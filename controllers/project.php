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
            $body .= "<h3>#$row[number]&nbsp;&nbsp;<a href='issue.php?id=$row[id]'>" . $row[title] . "</a></h3>";
            $body .= "</td>\n";
            $body .= "<td valign='middle' align='right'>\n";
            if ($row[isurgent] == "1")
                $body .= "<em class='urgent-indicator'>Urgent</span>";
            if ($row[isclosed] == "1")
                $body .= "<em class='closed-indicator'>Closed</span>";
            $body .= "</td>\n";
            $body .= "</tr>\n";
            $body .= "</table>\n";
            $body .= "<div id='issue$row[number]' class='wikiStyle'>" . $row[body] . "</div>\n";
            $body .= "<br />\n";
            $body .= "<div class='options'>\n";
            if ($count == 1)
                $body .= "<a href='issue.php?id=$row[id]'>$count comment</a>\n";
            else
                $body .= "<a href='issue.php?id=$row[id]'>$count comments</a>\n";
            $body .= "&nbsp;Created about " . FriendlyDate(1, strtotime($row[createddate])) . " by <a href='user-edit.php?id=$user[id]'>$user[username]</a>";
            $body .= "</div>\n";
            
            $body .= "<script type='text/javascript'>\n";
            $body .= "document.getElementById('issue$row[number]').innerHTML = converter.makeHtml(document.getElementById('issue$row[number]').innerHTML);\n";
            $body .= "</script>\n";
            
            $body .= "</div>\n";
        }
        
        if (mysql_num_rows($result) == 0)
        {
            $body .= "<div class='list-item issue none'>\n";
            $body .= "<p>There are no issues to display for this project.</p>\n";
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
                                
            $body .= "<div class='list-item project'>\n";
            $body .= "<table cellpadding='0' cellspacing='0' style='width: 100%;'><tr>\n";
            
            $body .= "<td width='100%'>\n";
            $body .= "<h3><a href='project.php?id=$row[id]'>" . $row['name'] . "</a></h3><br />\n";
            $body .= "<p>" . $row['description'] . "</p>\n";
            $body .= "</td>\n";
            
            $body .= "<td>\n";
            $body .= "<div class='counter'>\n";
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
    
    // function project_add()
    // {
        // // authorize();
    
        // $this->title = "Projects";
        // $this->render('views/project/add.php');
    // }
    
    // function project_add_post()
    // {
        // // authorize();
        
        // $now = date("Y-m-d H:i:s");
        // $sql = "INSERT INTO project (name, description, createdby, createddate) VALUES
                // ('" . mysql_real_escape_string($_POST[name]) . "', '" . mysql_real_escape_string($_POST[description]) . "', '$CurrentUser_ID', '" . $now . "')";
        // if (!mysql_query($sql,$con))
        // {
            // die('Error: ' . mysql_error());
        // }
        
        // $sql = mysql_query("SELECT * FROM project WHERE id = '" . mysql_insert_id() . "'");
        // $result = mysql_fetch_array($sql);
        
        // LogActivity(1, $result[id], 1);
        
        // header("Location: index.php?success=true");
        // exit;
    // }
    
    // function project_edit()
    // {
        // // authorize();
    
        // $result = mysql_query("SELECT * FROM project WHERE id = '$_GET[id]'");
        // $project = mysql_fetch_array($result);
        
        // $this->title = "Projects";
        // $this->render('views/project/edit.php');
    // }
    
    // function project_edit_post()
    // {
        // // authorize();
        
        // $now = date("Y-m-d H:i:s");
        // $nowlcl = date("Y-m-d H:i:s", strtotime("+3 hour", strtotime($now)));

        // $sql = "UPDATE project SET name = '" . mysql_real_escape_string($_POST[name]) . "', description = '" . mysql_real_escape_string($_POST[description]) . "' WHERE id = '$_GET[id]'";
        // if (!mysql_query($sql,$con))
        // {
            // die('Error: ' . mysql_error());
        // }
        
        // LogActivity(1, $_GET[id], 2);
        
        // header("Location: project.php?id=$_GET[id]&success=true");
        // exit;
    // }
    
    // function project_delete()
    // {
        // // authorize();
    
        // $sql = "DELETE FROM project WHERE id = '$_GET[id]'";    
        // if (!mysql_query($sql,$con))
        // {
            // die('Error: ' . mysql_error());
        // }
        
        // $sql = "SELECT * FROM issue WHERE projectid = '$_GET[id]'";    
        // $result = mysql_query($sql);
        // while($row = mysql_fetch_array($result))
        // {
            // $sql = "DELETE FROM comment WHERE issueid = '$row[id]'";    
            // if (!mysql_query($sql,$con))
            // {
                // die('Error: ' . mysql_error());
            // }
        // }
        
        // $sql = "DELETE FROM issue WHERE projectid = '$_GET[id]'";    
        // if (!mysql_query($sql,$con))
        // {
            // die('Error: ' . mysql_error());
        // }

        // PurgeActivity(1, $_GET[id]);
        
        // header("Location: index.php?delete=true");
        // exit;
    // }

?>