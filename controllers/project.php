<?php

    function project_view()
    {
        Security_Authorize();
        
        $result = mysql_query("SELECT * FROM project WHERE id = '" . params('id') . "'");
        $project = mysql_fetch_array($result);
        
        $result = mysql_query("SELECT * FROM issue WHERE projectid = '$project[id]' ORDER BY isurgent DESC, number ASC");
        while($row = mysql_fetch_array($result))
        {
            $sql = mysql_query("SELECT COUNT(*) AS rowcount FROM comment WHERE issueid = '$row[id]'");
            $return = mysql_fetch_array($sql);
            $count = $return[rowcount];
            
            $sql = mysql_query("SELECT id, username FROM user WHERE id = '$row[createdby]'");
            $user = mysql_fetch_array($sql);
            
            if ($row[isclosed] == "0")
                $body .= "<div class='list-item issue open'>\n";
            else
                $body .= "<div class='list-item issue closed' style='display: none;'>\n";
            
            $body .= "<table cellpadding='0' cellspacing='0' style='width: 100%;'>\n";
            $body .= "<tr>\n";
            $body .= "<td valign='middle'>\n";
            $body .= "<h3>#$row[number]&nbsp;&nbsp;<a href='/issue/$row[id]'>" . FriendlyString($row[title], 65) . "</a></h3>";
            $body .= "</td>\n";
            $body .= "<td valign='middle' align='right'>\n";
            if ($row[isurgent] == "1")
                $body .= "<em class='urgent-indicator'>Urgent</em>";
            if ($row[isclosed] == "1")
                $body .= "<em class='closed-indicator'>Closed</em>";
            $body .= "</td>\n";
            $body .= "</tr>\n";
            $body .= "</table>\n";
            $body .= "<div id='issue$row[number]' class='wikiStyle'>" . FriendlyString($row[body], 220) . "</div>\n";
            $body .= "<br />\n";
            $body .= "<div class='options'>\n";
            if ($count == 1)
                $body .= "<a href='/issue/$row[id]'>$count comment</a>\n";
            else
                $body .= "<a href='/issue/$row[id]'>$count comments</a>\n";
            $body .= "&nbsp;Created about " . FriendlyDate(1, strtotime($row[createddate])) . " by <a href='/user/$user[id]'>$user[username]</a>";
            $body .= "</div>\n";
            
            $body .= "<script type='text/javascript'>\n";
            $body .= "document.getElementById('issue$row[number]').innerHTML = converter.makeHtml(document.getElementById('issue$row[number]').innerHTML);\n";
            $body .= "</script>\n";
            
            $body .= "</div>\n";
        }
        
        
        set("title", $project[name]);
        set("body", $body);
        set("project", $project);
        return html("project/view.php");
    }
    
    function project_list()
    {
        Security_Authorize();
    
        $result = mysql_query("SELECT * FROM project ORDER BY name ASC");
        while($row = mysql_fetch_array($result))
        {
            $sql = mysql_query("SELECT COUNT(*) AS rowcount FROM issue WHERE projectid = '$row[id]' AND isclosed = '0'");
            $return = mysql_fetch_array($sql);
            $open = $return['rowcount'];
            
            $sql = mysql_query("SELECT COUNT(*) AS rowcount FROM issue WHERE projectid = '$row[id]' AND isclosed = '1'");
            $return = mysql_fetch_array($sql);
            $closed = $return['rowcount'];
            
            $sql = mysql_query("SELECT COUNT(*) AS rowcount FROM issue WHERE projectid = '$row[id]' AND isclosed = '0' AND isurgent = '1'");
            $return = mysql_fetch_array($sql);
            $urgent = $return['rowcount'];
                                
            $body .= "<div class='list-item project'>\n";
            $body .= "<table cellpadding='0' cellspacing='0' style='width: 100%;'><tr>\n";
            
            $body .= "<td width='100%'>\n";
            $body .= "<h3><a href='/project/$row[id]'>" . FriendlyString($row['name'], 58) . "</a></h3><br />\n";
            $body .= "<p>" . FriendlyString($row['description'], 81) . "</p>\n";
            $body .= "</td>\n";
            
            $body .= "<td>\n";
            $body .= "<div class='counter'>\n";
            if ($urgent > 0)
                $body .= "<big class='urgent'>$open</big>\n";
            else
                $body .= "<big>$open</big>\n";
            $body .= "Open Issues\n";
            $body .= "</div>\n";
            $body .= "</td>\n";
            
            $body .= "<td>\n";
            $body .= "<div class='counter'>\n";
            $body .= "<big>$closed</big>\n";
            $body .= "Closed Issues\n";
            $body .= "</div>\n";
            $body .= "</td>\n";    
            
            $body .= "</tr></table>\n";
            $body .= "</div>\n";
        }
        
        if (mysql_num_rows($result) == 0)
        {
            $body .= "<div class='list-item project'>\n";
            $body .= "<p>There are currently no projects setup.</p>\n";
            $body .= "</div>\n";
        }
        
        set("title", "Projects");
        set("body", $body);
        return html("project/list.php");
    }
    
    function project_add()
    {
        Security_Authorize();
    
        set("title", "New Project");
        return html("project/add.php");
    }
    
    function project_add_post()
    {
        Security_Authorize();
        
        $now = date("Y-m-d H:i:s");
        $sql = "INSERT INTO project (name, description, createdby, createddate) VALUES
                ('" . mysql_real_escape_string($_POST[name]) . "', '" . mysql_real_escape_string($_POST[description]) . "', '$_SESSION[CurrentUser_ID]', '" . $now . "')";
        if (!mysql_query($sql))
        {
            die('Error: ' . mysql_error());
        }
        
        $sql = mysql_query("SELECT * FROM project WHERE id = '" . mysql_insert_id() . "'");
        $result = mysql_fetch_array($sql);
        
        LogActivity(1, $result[id], 1);
        
        header("Location: /&success=Your project was created successfully!");
        exit;
    }
    
    function project_edit()
    {
        Security_Authorize();
    
        $result = mysql_query("SELECT * FROM project WHERE id = '" . params('id') . "'");
        $project = mysql_fetch_array($result);
        
        set("title", "Edit Project");
        set("project", $project);
        return html("project/edit.php");
    }
    
    function project_edit_post()
    {
        Security_Authorize();
        
        $now = date("Y-m-d H:i:s");
        
        $sql = "UPDATE project SET name = '" . mysql_real_escape_string($_POST[name]) . "', description = '" . mysql_real_escape_string($_POST[description]) . "' WHERE id = '" . params('id') . "'";
        mysql_query($sql);
        
        LogActivity(1, params('id'), 2);
        
        header("Location: /project/" . params('id') . "&success=Your project was updated successfully!");
        exit;
    }
    
    function project_delete()
    {
        Security_Authorize();
    
        $sql = "DELETE FROM project WHERE id = '" . params('id') . "'";    
        mysql_query($sql);
        
        $sql = "SELECT * FROM issue WHERE projectid = '" . params('id') . "'";    
        $result = mysql_query($sql);
        while($row = mysql_fetch_array($result))
        {
            $sql = "DELETE FROM comment WHERE issueid = '" . params('id') . "'";    
            mysql_query($sql);
        }
        
        $sql = "DELETE FROM issue WHERE projectid = '" . params('id') . "'";    
        mysql_query($sql);

        PurgeActivity(1, params('id'));
        
        header("Location: /&success=Your project was deleted successfully!");
        exit;
    }

?>