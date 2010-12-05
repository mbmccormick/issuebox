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

?>
<?php include "header.php"; ?>
    <?php SetPageTitle("Activity"); ?>
    <div class="content">
         <table cellpadding="0" cellspacing="0" style="width: 100%; padding-bottom: 20px;">
            <tr>
                <td valign="middle">
                    <div class="navigation" style="padding: 0px;">
                        <a href="index.php">Home</a>
                    </div>
                </td>
                <td valign="middle" align="right">
                    <a class="minibutton btn-projects" title="Click here to go to projects." href="list.php" style="padding: 2px 0px 1px 3px;">
                        <span>Projects<span class="icon"></span></span>
                    </a>
                </td>
            </tr>
        </table>
        <div class="list">
            <?php

                $result = mysql_query("SELECT * FROM activity WHERE actiontype != '3' ORDER BY createddate DESC LIMIT 20");
                while($row = mysql_fetch_array($result))
                {
                    $sql = mysql_query("SELECT * FROM user WHERE id = '$row[createdby]'");
                    $user = mysql_fetch_array($sql);
                    
                    echo "<div class='list-item activity'>\n";
                    echo "<table cellpadding='0' cellspacing='0' style='width: 100%;'>\n";
                    
                    echo "<tr>\n";
                    echo "<td rowspan='2' valign='top' style='width: 25px;'>\n";
                    if ($row[itemtype] == "1")
                        echo "<img src='img/project" . $row[actiontype] . ".png' alt='$row[actiontype]' />\n";
                    else if ($row[itemtype] == "2")
                        echo "<img src='img/issue" . $row[actiontype] . ".png' alt='$row[actiontype]' />\n";
                    else if ($row[itemtype] == "3")
                        echo "<img src='img/comment" . $row[actiontype] . ".png' alt='$row[actiontype]' />\n";
                    echo "</td>\n";
                    echo "<td colspan='2' style='padding-bottom: 7px;'>\n";
                    echo "<b><a href='user-edit.php?id=" . $user[id] . "'>" . $user[username] . "</a> " . $row[headline] . " about " . FriendlyDate(1, strtotime($row[createddate])) . "</b>\n";
                    echo "</td>\n";
                    echo "</tr>\n";
                    echo "<tr>\n";
                    echo "<td valign='top' style='width: 45px;'>\n";
                    echo "<img src='http://www.gravatar.com/avatar/" . md5($user[email]) . "?s=30' style='padding: 2px; border: 1px solid #D0D0D0; background-color: #ffffff;' />\n";
                    echo "</td>\n";
                    echo "<td valign='top'>\n";
                    echo "<span class='description'>" . FriendlyString($row[description]) . "</span>\n";
                    echo "</td>\n";
                    echo "</tr>\n";                    
                    
                    echo "</table>\n";
                    echo "</div>\n";
                }
                
                if (mysql_num_rows($result) == 0)
                {
                    echo "<div class='list-item activity'>\n";
                    echo "<p>There is currently no activity to display.</p>\n";
                    echo "</div>\n";
                }

            ?>
        </div>
    </div>
<?php include "footer.php"; ?>