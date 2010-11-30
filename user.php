<?php

    require "config.php";
    require_once "security.php";
    
    authorize();
    
    $con = mysql_connect($Server, $Username, $Password);
    if (!$con)
    {
        die("Could not connect: " . mysql_error());
    }

    mysql_select_db($Database, $con);   

?>
<?php include "header.php"; ?>
    <div class="content">
        <div class="navigation">
            <a href="index.php">Home</a> / <a href="settings.php">Settings</a> / <a href="user.php">Users</a>
        </div>
        <div class="list">
            <?php

                $result = mysql_query("SELECT * FROM user ORDER BY username ASC");
                while($row = mysql_fetch_array($result))
                {
                    echo "<div class='list-item user'>\n";
                    
                    echo "<table cellpadding='0' cellspacing='0' style='width: 100%;'>\n";
                    echo "<tr>\n";
                    echo "<td valign='middle'>\n";
                    echo "<img src='http://www.gravatar.com/avatar/" . md5($row[email]) . "?s=45' style='background-color: #ffffff; padding: 2px; border: solid 1px #dddddd;' />";
                    echo "</td>";
                    echo "<td>\n";
                    echo "&nbsp;&nbsp;\n";
                    echo "</td>\n";
                    echo "<td valign='middle' style='width: 100%;'>\n";
                    echo "<h3><a href='user-edit.php?id=$row[id]'>" . $row[username] . "</a></h3>\n";
                    echo "<p>Created on " . date("F j, Y", strtotime($row[createddate])) . "</p>\n";                    
                    echo "</tr>\n";
                    echo "</table>\n";
                    
                    echo "</div>\n";
                }
                
                if (mysql_num_rows($result) == 0)
                {
                    echo "<div class='list-item user'>\n";
                    echo "<p>There are currently no users setup.</p>\n";
                    echo "</div>\n";
                }

            ?>
        </div>
        <br />
        <button type="button" class="button" onclick="location.href='user-add.php';">
            <span>New User</span>
        </button>
    </div>
<?php include "footer.php"; ?>