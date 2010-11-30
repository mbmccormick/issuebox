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
    <div class="content">
        <div class="navigation">
            <a href="index.php">Projects</a>
        </div>
        <div class="list">
            <?php

                $result = mysql_query("SELECT * FROM activity ORDER BY createddate DESC LIMIT 20");
                while($row = mysql_fetch_array($result))
                {
                    $sql = mysql_query("SELECT * FROM user WHERE id = '$row[createdby]'");
                    $user = mysql_fetch_array($sql);
                    
                    echo "<div class='list-item activity'>\n";
                    echo "<table cellpadding='0' cellspacing='0' style='width: 100%;'>\n";
                    
                    if ($row[itemtype] == "1")
                    {
                        $sql = mysql_query("SELECT * FROM project WHERE id = '$row[itemid]'");
                        $project = mysql_fetch_array($sql);
                        
                        echo "<tr>\n";
                        echo "<td rowspan='2' valign='top' style='width: 25px;'>\n";
                        echo "<img src='img/project" . $row[actiontype] . ".png' alt='$row[actiontype]' />\n";
                        echo "</td>\n";
                        echo "<td colspan='2' style='padding-bottom: 7px;'>\n";
                        echo "<b><a href='user-edit.php?id=" . $user[id] . "'>" . $user[username] . "</a> ";
                        
                        if ($row[actiontype] == "1")
                        {
                            echo "created ";
                        }
                        else if ($row[actiontype] == "2")
                        {
                            echo "updated ";
                        }
                        else if ($row[actiontype] == "3")
                        {
                            echo "deleted ";
                        }
                        
                        echo "project <a href='project-edit.php?id=$project[id]'>" . $project[name] . "</a> about " . FriendlyDate(1, strtotime($row[createddate]));
                        echo "</b>\n";
                        echo "</td>\n";
                        echo "</tr>\n";
                        echo "<tr>\n";
                        echo "<td valign='top' style='width: 45px;'>\n";
                        echo "<img src='http://www.gravatar.com/avatar/" . md5($user[email]) . "?s=30' style='padding: 2px; border: 1px solid #D0D0D0; background-color: #ffffff;' />\n";
                        echo "</td>\n";
                        echo "<td valign='top'>\n";
                        echo "<span class='description'>" . FriendlyString($project[description]) . "</span>\n";
                        echo "</td>\n";
                        echo "</tr>\n";
                    }
                    else if ($row[itemtype] == "2")
                    {
                        $sql = mysql_query("SELECT * FROM issue WHERE id = '$row[itemid]'");
                        $issue = mysql_fetch_array($sql);
                        
                        $sql = mysql_query("SELECT * FROM project WHERE id = '$issue[projectid]'");
                        $project = mysql_fetch_array($sql);
                        
                        echo "<tr>\n";
                        echo "<td rowspan='2' valign='top' style='width: 25px;'>\n";
                        echo "<img src='img/issue" . $row[actiontype] . ".png' alt='$row[actiontype]' />\n";
                        echo "</td>\n";
                        echo "<td colspan='2' style='padding-bottom: 7px;'>\n";
                        echo "<b><a href='user-edit.php?id=" . $user[id] . "'>" . $user[username] . "</a> ";
                        
                        if ($row[actiontype] == "1")
                        {
                            echo "created ";
                        }
                        else if ($row[actiontype] == "2")
                        {
                            echo "updated ";
                        }
                        else if ($row[actiontype] == "3")
                        {
                            echo "deleted ";
                        }
                                                
                        echo "<a href='issue-edit.php?id=$issue[id]'>issue " . $issue[number] . "</a> on <a href='project-edit.php?id=$project[id]'>" . $project[name] . "</a> about " . FriendlyDate(1, strtotime($row[createddate]));
                        echo "</b>\n";
                        echo "</td>\n";
                        echo "</tr>\n";
                        echo "<tr>\n";
                        echo "<td valign='top' style='width: 45px;'>\n";
                        echo "<img src='http://www.gravatar.com/avatar/" . md5($user[email]) . "?s=30' style='padding: 2px; border: 1px solid #D0D0D0; background-color: #ffffff;' />\n";
                        echo "</td>\n";
                        echo "<td valign='top'>\n";
                        echo "<span class='description'>" . FriendlyString($issue[body]) . "</span>\n";
                        echo "</td>\n";
                        echo "</tr>\n";
                    }
                    else if ($row[itemtype] == "3")
                    {
                        $sql = mysql_query("SELECT * FROM comment WHERE id = '$row[itemid]'");
                        $comment = mysql_fetch_array($sql);
                        
                        $sql = mysql_query("SELECT * FROM issue WHERE id = '$comment[issueid]'");
                        $issue = mysql_fetch_array($sql);
                        
                        echo "<tr>\n";
                        echo "<td rowspan='2' valign='top' style='width: 25px;'>\n";
                        echo "<img src='img/comment" . $row[actiontype] . ".png' alt='$row[actiontype]' />\n";
                        echo "</td>\n";
                        echo "<td colspan='2' style='padding-bottom: 7px;'>\n";
                        echo "<b><a href='user-edit.php?id=" . $user[id] . "'>" . $user[username] . "</a> ";
                        
                        if ($row[actiontype] == "1")
                        {
                            echo "commented on ";
                        }
                        else if ($row[actiontype] == "2")
                        {
                            echo "updated a comment on ";
                        }
                        else if ($row[actiontype] == "3")
                        {
                            echo "deleted a comment on ";
                        }
                        
                        echo "<a href='issue-edit.php?id=$issue[id]'>issue " . $issue[number] . "</a> about " . FriendlyDate(1, strtotime($row[createddate]));
                        echo "</b>\n";
                        echo "</td>\n";
                        echo "</tr>\n";
                        echo "<tr>\n";
                        echo "<td valign='top' style='width: 45px;'>\n";
                        echo "<img src='http://www.gravatar.com/avatar/" . md5($user[email]) . "?s=30' style='padding: 2px; border: 1px solid #D0D0D0; background-color: #ffffff;' />\n";
                        echo "</td>\n";
                        echo "<td valign='top'>\n";
                        echo "<span class='description'>" . FriendlyString($comment[body]) . "</span>\n";
                        echo "</td>\n";
                        echo "</tr>\n";
                    }
                    
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