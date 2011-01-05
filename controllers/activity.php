<?php

    function activity_list()
    {
        Security_Authorize();
    
        $result = mysql_query("SELECT * FROM activity ORDER BY createddate DESC LIMIT 20");
        while($row = mysql_fetch_array($result))
        {
            $sql = mysql_query("SELECT * FROM user WHERE id = '$row[createdby]'");
            $user = mysql_fetch_array($sql);
            
            $body .= "<div class='list-item activity'>\n";
            $body .= "<table cellpadding='0' cellspacing='0' style='width: 100%;'>\n";
            
            $body .= "<tr>\n";
            $body .= "<td rowspan='2' valign='top' style='width: 25px;'>\n";
            if ($row[itemtype] == "1")
                $body .= "<img src='/public/img/project" . $row[actiontype] . ".png' alt='$row[actiontype]' />\n";
            else if ($row[itemtype] == "2")
                $body .= "<img src='/public/img/issue" . $row[actiontype] . ".png' alt='$row[actiontype]' />\n";
            else if ($row[itemtype] == "3")
                if (StartsWith($row[headline], "closed"))
                    $body .= "<img src='/public/img/comment" . $row[actiontype] . "c.png' alt='$row[actiontype]' />\n";
                else
                    $body .= "<img src='/public/img/comment" . $row[actiontype] . ".png' alt='$row[actiontype]' />\n";
            $body .= "</td>\n";
            $body .= "<td colspan='2' style='padding-bottom: 7px;'>\n";
            $body .= "<b><a href='/user/" . $user[id] . "'>" . $user[username] . "</a> " . $row[headline] . " about " . FriendlyDate(1, strtotime($row[createddate])) . "</b>\n";
            $body .= "</td>\n";
            $body .= "</tr>\n";
            $body .= "<tr>\n";
            $body .= "<td valign='top' style='width: 45px;'>\n";
            $body .= "<img src='http://www.gravatar.com/avatar/" . md5($user[email]) . "?s=30' style='padding: 2px; border: 1px solid #D0D0D0; background-color: #ffffff;' />\n";
            $body .= "</td>\n";
            $body .= "<td valign='top'>\n";
            $body .= "<span class='description truncate'>" . $row[description] . "</span>\n";
            $body .= "</td>\n";
            $body .= "</tr>\n";                    
            
            $body .= "</table>\n";
            $body .= "</div>\n";
        }
        
        if (mysql_num_rows($result) == 0)
        {
            $body .= "<div class='list-item activity'>\n";
            $body .= "<p>There is currently no activity to display.</p>\n";
            $body .= "</div>\n";
        }
        
        set("title", "Activity");
        set("body", $body);
        return html("activity/list.php");
    }
    
    function activity_populate()
    {
        Security_Authorize();
    
        $count = 0;
    
        $result = mysql_query("SELECT * FROM project ORDER BY createddate ASC");
        while($row = mysql_fetch_array($result))
        {
            LogActivity(1, $row[id], 1, $row[createdby], $row[createddate]);
        }
        $count = $count + mysql_num_rows($result);
        
        $result = mysql_query("SELECT * FROM issue ORDER BY createddate ASC");
        while($row = mysql_fetch_array($result))
        {
            LogActivity(2, $row[id], 1, $row[createdby], $row[createddate]);
        }
        $count = $count + mysql_num_rows($result);
        
        $result = mysql_query("SELECT * FROM comment ORDER BY createddate ASC");
        while($row = mysql_fetch_array($result))
        {
            LogActivity(3, $row[id], 1, $row[createdby], $row[createddate]);
        }
        $count = $count + mysql_num_rows($result);
        
        set("title", "Populate Activity");
        set("count", $count);
        return html("activity/populate.php");
    }

?>