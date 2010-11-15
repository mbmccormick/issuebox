<?php

    require "config.php";
    
    $con = mysql_connect($Server, $Username, $Password);
    if (!$con)
    {
        die("Could not connect: " . mysql_error());
    }

    mysql_select_db($Database, $con);   
    
    $result = mysql_query("SELECT * FROM issue WHERE id = '$_GET[id]' ORDER BY id ASC");
    $issue = mysql_fetch_array($result);

    $result = mysql_query("SELECT * FROM project WHERE id = '$issue[projectid]'");
    $project = mysql_fetch_array($result);
    
?>
<?php include "header.php"; ?>
    <div class="content">
        <div class="navigation">
            <a href="index.php">Projects</a> / <a href="project.php?id=<?php echo $project[id]; ?>"><?php echo $project[name]; ?></a> / <a href="issue.php?id=<?php echo $issue[id]; ?>">Issue #<?php echo $issue[number]; ?></a>
        </div>
        <div class="list">            
            <div class="list-item issue">
                <table cellpadding="0" cellspacing="0" style="width: 100%;">
                    <tr>
                        <td valign="middle">
                            <h3>#<?php echo $issue[number]; ?>&nbsp;&nbsp;<a href="issue.php?id=<?php echo $issue[id]; ?>"><?php echo $issue[title]; ?></a></h3>
                        </td>
                        <td valign="middle" align="right">
                            <?php
                            
                                if ($issue[isclosed] == "0")
                                    echo "<span class='filter-on'>Open</span>";
                                else
                                    echo "<span class='filter-on'>Closed</span>";
                                    
                            ?>
                        </td>
                    </tr>
                </table>
                <br />
                <p><?php echo $issue[body]; ?></p>
                <br />
                <div class="options">
                    <a class="minibutton" href='issue-edit.php?id=<?php echo $issue[id]; ?>'><span>Edit</span></a>
                    <a class="minibutton" onclick="return confirm('Are you sure you want to delete this issue and all of its comments?');" href='issue-delete.php?id=<?php echo $issue[id]; ?>&projectid=<?php echo $issue[projectid]; ?>'><span>Delete</span></a>
                    &nbsp;&nbsp;<span class="date"><?php echo date("m/d/Y g:ia", strtotime($issue[createddate])); ?></span>
                </div>
            </div>
            <?php

                $result = mysql_query("SELECT * FROM comment WHERE issueid = '$_GET[id]' ORDER BY id ASC");
                while($row = mysql_fetch_array($result))
                {
                    echo "<div class='list-item comment'>\n";
                    echo "<p>" . $row[body] . "</p>\n";
                    echo "<br />\n";
                    echo "<div class='options'>\n";
                    echo "<a class='minibutton' onclick=\"return confirm('Are you sure you want to delete this comment?');\" href='comment-delete.php?id=$row[id]&issueid=$row[issueid]'><span>Delete</span></a>\n";
                    echo "&nbsp;&nbsp;" . date("m/d/Y g:ia", strtotime($row[createddate]));
                    echo "</div>\n";
                    echo "</div>\n";
                }

            ?>
            <?php if ($issue[isclosed] == "0") { ?>
            <div class="list-item comment">
                <h3>New Comment</h3>
                <br />
                <form action="comment-add.php?issueid=<?php echo $_GET[id]; ?>" method="post">
                    <textarea name="body" style="width: 762px;" rows="8"></textarea>
                    <br />
                    <br />
                    <button onclick="this.form.action = this.form.action + '&close=1';" type="submit" name="commentandclose" class="button">
                        <span>Comment &amp; Close</span>
                    </button>
                    <button type="submit" name="comment" class="button">
                        <span>Comment</span>
                    </button>
                </form>
            </div>
            <?php } else { ?>
            <div class="list-item comment">
                <p>This issue is closed, and no more comments can be added.</p>
            </div>
            <?php } ?>
        </div>        
    </div>
<?php include "footer.php"; ?>