<?php

    require "config.php";
    require "utils.php";
    require_once "security.php";
    
    authorize();

    $con = mysql_connect($Server, $Username, $Password);
    if (!$con)
    {
        die("Could not connect: " . mysql_error());
    }

    mysql_select_db($Database, $con);
        
    $result = mysql_query("SELECT MAX(number) AS maxnum FROM issue WHERE projectid = '$_GET[projectid]'");
    $row = mysql_fetch_array($result);
    $next_num = $row[maxnum] + 1;
        
    $now = date("Y-m-d H:i:s");
    
    $sql = "INSERT INTO issue (projectid, number, title, body, isclosed, isurgent, createdby, createddate) VALUES
            ('$_GET[projectid]', '$next_num', '" . mysql_real_escape_string($_POST[title]) . "', '" . mysql_real_escape_string($_POST[body]) . "', '0', '" . $_POST[isurgent] . "', '$CurrentUser_ID', '" . $now . "')";
    
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }

    $sql = mysql_query("SELECT * FROM issue WHERE id = '" . mysql_insert_id() . "'");
    $result = mysql_fetch_array($sql);
    
    $sql = mysql_query("SELECT * FROM user WHERE id = '$result[createdby]'");
    $user = mysql_fetch_array($sql);
        
    mysql_close($con);
    
    LogActivity(2, $result[id], 1);
    
    if ($_POST[returnObject] == "true")
    {
        $sql = mysql_query("SELECT COUNT(*) AS rowcount FROM comment WHERE issueid = '$result[id]'");
        $return = mysql_fetch_array($sql);
        $count = $return[rowcount];
        
        echo "<div class='list-item issue'>\n";
                    
        echo "<table cellpadding='0' cellspacing='0' style='width: 100%;'>\n";
        echo "<tr>\n";
        echo "<td valign='middle'>\n";
        echo "<h3>#$result[number]&nbsp;&nbsp;<a href='issue.php?id=$result[id]'>" . $result[title] . "</a></h3>";
        echo "</td>\n";
        echo "<td valign='middle' align='right'>\n";
        if ($result[isclosed] == "1")
            echo "<em class='closed'>Closed</span>";
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
        echo "&nbsp;Created just now by <a href='user-edit.php?id=$user[id]'>$user[username]</a>";
        echo "</div>\n";
        
        echo "<script type='text/javascript'>\n";
        echo "document.getElementById('issue$result[number]').innerHTML = converter.makeHtml(document.getElementById('issue$result[number]').innerHTML);\n";
        echo "</script>\n";
        
        echo "</div>\n";
    }
    else
    {
        header("Location: project.php?id=$_GET[projectid]");
        exit;
    }    
    
?>