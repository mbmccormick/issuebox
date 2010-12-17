<?php

    function issue_view()
    {
        Security_Authorize();
        
        $result = mysql_query("SELECT * FROM issue WHERE id = '" . params('id') . "' ORDER BY id ASC");
        $issue = mysql_fetch_array($result);

        $result = mysql_query("SELECT * FROM project WHERE id = '$issue[projectid]'");
        $project = mysql_fetch_array($result);
       
        $result = mysql_query("SELECT * FROM user WHERE id = '$issue[createdby]'");
        $user = mysql_fetch_array($result);
        
        $result = mysql_query("SELECT * FROM comment WHERE issueid = '$issue[id]' ORDER BY id ASC");
        while($row = mysql_fetch_array($result))
        {
            $sql = mysql_query("SELECT id, username FROM user WHERE id = '$row[createdby]'");
            $user = mysql_fetch_array($sql);
            
            $body .= "<div class='list-item comment'>\n";
            
            $body .= "<div id='comment$row[id]' class='wikiStyle'>" . $row[body] . "</div>\n";
            $body .= "<br />\n";
            $body .= "<div class='options'>\n";
            $body .= "<a class='minibutton minidanger' postback='/comment/$row[id]/delete&issueid=$row[issueid]'><span>Delete</span></a>\n";
            $body .= "&nbsp;&nbsp;" . date("F j, Y", strtotime($row[createddate]));
            $body .= " by <a href='/user/$user[id]'>$user[username]</a>";
            $body .= "</div>\n";
            
            $body .= "<script type='text/javascript'>\n";
            $body .= "document.getElementById('comment$row[id]').innerHTML = converter.makeHtml(document.getElementById('comment$row[id]').innerHTML);\n";
            $body .= "</script>\n";
            
            $body .= "</div>\n";
        }
        
        set("title", "Issue #" . $issue[number]);
        set("body", $body);
        set("issue", $issue);
        set("project", $project);
        set("user", $user);
        return html("issue/view.php");
    }

    function issue_add_post()
    {
        Security_Authorize();
        
        $result = mysql_query("SELECT MAX(number) AS maxnum FROM issue WHERE projectid = '$_GET[projectid]'");
        $row = mysql_fetch_array($result);
        $next_num = $row[maxnum] + 1;
            
        $now = date("Y-m-d H:i:s");
        
        $sql = "INSERT INTO issue (projectid, number, title, body, isclosed, isurgent, createdby, createddate) VALUES
                ('$_GET[projectid]', '$next_num', '" . mysql_real_escape_string($_POST[title]) . "', '" . mysql_real_escape_string($_POST[body]) . "', '0', '" . $_POST[isurgent] . "', '$_SESSION[CurrentUser_ID]', '" . $now . "')";
        mysql_query($sql);

        $sql = mysql_query("SELECT * FROM issue WHERE id = '" . mysql_insert_id() . "'");
        $result = mysql_fetch_array($sql);
        
        $sql = mysql_query("SELECT * FROM user WHERE id = '$result[createdby]'");
        $user = mysql_fetch_array($sql);
            
        LogActivity(2, $result[id], 1);
        
        if ($_POST[returnObject] == "true")
        {
            $sql = mysql_query("SELECT COUNT(*) AS rowcount FROM comment WHERE issueid = '$result[id]'");
            $return = mysql_fetch_array($sql);
            $count = $return[rowcount];
            
            echo "<div class='list-item issue open'>\n";
                        
            echo "<table cellpadding='0' cellspacing='0' style='width: 100%;'>\n";
            echo "<tr>\n";
            echo "<td valign='middle'>\n";
            echo "<h3>#$result[number]&nbsp;&nbsp;<a href='/issue/$result[id]'>" . $result[title] . "</a></h3>";
            echo "</td>\n";
            echo "<td valign='middle' align='right'>\n";
            if ($result[isurgent] == "1")
                echo "<em class='urgent-indicator'>Urgent</span>";
            if ($result[isclosed] == "1")
                echo "<em class='closed-indicator'>Closed</span>";
            echo "</td>\n";
            echo "</tr>\n";
            echo "</table>\n";
            echo "<div id='issue$result[number]' class='wikiStyle'>" . $result[body] . "</div>\n";
            echo "<br />\n";
            echo "<div class='options'>\n";
            if ($count == 1)
                echo "<a href='issue.php?id=$result[id]'>$count comment</a>\n";
            else
                echo "<a href='issue.php?id=$result[id]'>$count comments</a>\n";
            echo "&nbsp;Created just now by <a href='/user/$user[id]'>$user[username]</a>";
            echo "</div>\n";
            
            echo "<script type='text/javascript'>\n";
            echo "document.getElementById('issue$result[number]').innerHTML = converter.makeHtml(document.getElementById('issue$result[number]').innerHTML);\n";
            echo "</script>\n";
            
            echo "</div>\n";
        }
        else
        {
            header("Location: /project/$_GET[projectid]");
            exit;
        }
    }
    
    function issue_edit()
    {
        Security_Authorize();
    
        $result = mysql_query("SELECT * FROM issue WHERE id = '" . params('id') . "'");
        $issue = mysql_fetch_array($result);
        
        $result = mysql_query("SELECT * FROM project WHERE id = '$issue[projectid]'");
        $project = mysql_fetch_array($result);
        
        set("title", "Edit Issue");
        set("issue", $issue);
        set("project", $project);
        return html("issue/edit.php");
    }
    
    function issue_edit_post()
    {
        Security_Authorize();
        
        $now = date("Y-m-d H:i:s");
        
        $sql = "UPDATE issue SET title = '" . mysql_real_escape_string($_POST[title]) . "', body = '" . mysql_real_escape_string($_POST[body]) . "', isurgent = '" . $_POST[isurgent] . "' WHERE id = '" . params('id') . "'";
        mysql_query($sql);
        
        LogActivity(2, params('id'), 2);
        
        header("Location: /issue/" . params('id') . "&success=true");
        exit;
    }
    
    function issue_delete()
    {
        Security_Authorize();
    
        $sql = "DELETE FROM issue WHERE id = '" . params('id') . "'";    
        mysql_query($sql);
        
        $sql = "DELETE FROM comment WHERE issueid = '" . params('id') . "'";    
        mysql_query($sql);

        PurgeActivity(1, params('id'));
        
        header("Location: /project/$_GET[projectid]&delete=true");
        exit;
    }

?>