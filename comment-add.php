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
        
    if (isset($_POST[commentandclose]) == true)
    {
        $sql = "UPDATE issue SET isclosed = '1' WHERE id='$_GET[issueid]'";
        if (!mysql_query($sql,$con))
        {
            die('Error: ' . mysql_error());
        }
    }
    
    $now = date("Y-m-d H:i:s");
    
    $sql = "INSERT INTO comment (issueid, body, createdby, createddate) VALUES
            ('$_GET[issueid]', '" . mysql_real_escape_string($_POST[body]) . "', '$CurrentUser_ID', '" . $now . "')";
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }
    
    $sql = mysql_query("SELECT * FROM comment WHERE id = '" . mysql_insert_id() . "'");
    $result = mysql_fetch_array($sql);
    
    $sql = mysql_query("SELECT * FROM user WHERE id = '$result[createdby]'");
    $user = mysql_fetch_array($sql);
    
    mysql_close($con);
    
    LogActivity(3, $result[id], 1);
    
    if ($_POST[returnObject] == "true")
    {
        echo "<div id='issue-closed'></div>\n";
        echo "<div class='list-item comment'>\n";
                        
        echo "<div id='comment$result[id]' class='wikiStyle'>" . $result[body] . "</div>\n";
        echo "<br />\n";
        echo "<div class='options'>\n";
        echo "<a class='minibutton' onclick=\"return confirm('Are you sure you want to delete this comment?');\" href='comment-delete.php?id=$result[id]&issueid=$result[issueid]'><span>Delete</span></a>\n";
        echo "&nbsp;&nbsp;" . date("F j, Y", strtotime($result[createddate]));
        echo " by <a href='user-edit.php?id=$user[id]'>$user[username]</a>";
        echo "</div>\n";
        
        echo "<script type='text/javascript'>\n";
        echo "document.getElementById('comment$result[id]').innerHTML = converter.makeHtml(document.getElementById('comment$result[id]').innerHTML);\n";
        echo "</script>\n";
        
        echo "</div>\n";
    }
    else
    {
        header("Location: issue.php?id=$_GET[issueid]");
        exit;
    }
    
?>