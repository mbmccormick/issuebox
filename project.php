<?php

    require "config.php";
    
    $con = mysql_connect($Server, $Username, $Password);
    if (!$con)
    {
        die("Could not connect: " . mysql_error());
    }

    mysql_select_db($Database, $con);

    $result = mysql_query("SELECT * FROM project WHERE id = '$_GET[id]'");
    $project = mysql_fetch_array($result);
    
    if (!isset($_GET[open]) || $_GET[open] == null)
        $_GET[open] = "1";
        
    if (!isset($_GET[closed]) || $_GET[closed] == null)
        $_GET[closed] = "0";
    
?>
<?php include "header.php"; ?>
    <div class="content">
        <table cellpadding="0" cellspacing="0" style="width: 100%; padding-bottom: 20px;">
            <tr>
                <td valign="middle">
                    <div class="navigation" style="padding: 0px;">
                        <a href="index.php">Projects</a> / <a href="project.php?id=<?php echo $project[id]; ?>"><?php echo $project[name]; ?></a>
                    </div>
                </td>
                <td valign="middle" align="right">
                    <div class="filter">
                        <?php if ($_GET[open] == "1") { ?>
                            <a class="filter-on" title="Click here to hide open issues." href="project.php?id=<?php echo $project[id]; ?>&open=0&closed=<?php echo $_GET[closed]; ?>">Open</a>
                        <?php } else { ?>
                            <a class="filter-off" title="Click here to show open issues." href="project.php?id=<?php echo $project[id]; ?>&open=1&closed=<?php echo $_GET[closed]; ?>">Open</a>
                        <?php } ?>
                        <?php if ($_GET[closed] == "1") { ?>
                            <a class="filter-on" title="Click here to hide closed issues." href="project.php?id=<?php echo $project[id]; ?>&closed=0&open=<?php echo $_GET[open]; ?>">Closed</a>
                        <?php } else { ?>
                            <a class="filter-off" title="Click here to show closed issues." href="project.php?id=<?php echo $project[id]; ?>&closed=1&open=<?php echo $_GET[open]; ?>">Closed</a>
                        <?php } ?>
                    </div>
                </td>
            </tr>
        </table>
        <div class="list">
            <?php
                
                if ($_GET[open] == "1")
                    $result = mysql_query("SELECT * FROM issue WHERE projectid = '$_GET[id]' AND isclosed='0' ORDER BY number ASC");
                if ($_GET[open] == "0")
                    $result = mysql_query("SELECT * FROM issue WHERE projectid = '$_GET[id]' AND isclosed='1' ORDER BY number ASC");
                if ($_GET[open] == "1" && $_GET[closed] == "1")
                    $result = mysql_query("SELECT * FROM issue WHERE projectid = '$_GET[id]' AND (isclosed='1' OR isclosed='0') ORDER BY number ASC");  
                    
                if ($_GET[open] == "0" && $_GET[closed] == "0")
                    $result = mysql_query("SELECT * FROM issue WHERE projectid = '$_GET[id]' AND (isclosed='1' AND isclosed='0') ORDER BY number ASC");  
                   
                while($row = mysql_fetch_array($result))
                {
                    $sql = mysql_query("SELECT * FROM comment WHERE issueid = '$row[id]'");
                    $count = mysql_num_rows($sql);
                                    
                    echo "<div class='list-item issue'>\n";
                    echo "<table cellpadding='0' cellspacing='0' style='width: 100%;'>\n";
                    echo "<tr>\n";
                    echo "<td valign='middle'>\n";
                    echo "<h3>#$row[number]&nbsp;&nbsp;<a href='issue.php?id=$row[id]'>" . $row[title] . "</a></h3>";
                    echo "</td>\n";
                    echo "<td valign='middle' align='right'>\n";
                    if ($row[isclosed] == "0")
                        echo "<span class='filter-on'>Open</span>";
                    else
                        echo "<span class='filter-on'>Closed</span>";
                    echo "</td>\n";
                    echo "</tr>\n";
                    echo "</table>\n";
                    echo "<br />\n";
                    echo "<p>" . $row[body] . "</p>\n";
                    echo "<br />\n";
                    echo "<div class='options'>\n";
                    echo date("m/d/Y g:ia", strtotime($row[createddate])) . "&nbsp;&nbsp;";
                    if ($count == 1)
                        echo "<a href='issue.php?id=$row[id]'>$count comment</a>\n";
                    else
                        echo "<a href='issue.php?id=$row[id]'>$count comments</a>\n";
                    echo "</div>\n";
                    echo "</div>\n";
                }
                
                if (mysql_num_rows($result) == 0)
                {
                    echo "<div class='list-item issue'>\n";
                    echo "<p>There are no open issues for this project.</p>\n";
                    echo "</div>\n";
                }

            ?>
            <div class="list-item issue">
                <h3>New Issue</h3>
                <br />
                <form action="issue-add.php?projectid=<?php echo $_GET[id]; ?>" method="post">
                    <b>Title</b><br />
                    <input type="text" name="title" style="width: 100%;" /><br />
                    <br />
                    <b>Body</b><br />                    
                    <textarea name="body" style="width: 762px;" rows="8"></textarea>
                    <br />
                    <br />
                    <button type="submit" class="button">
                        <span>Create Issue</span>
                    </button>
                </form>
            </div>
            <br />
            <button type="submit" class="button" onclick="confirm('Are you sure you want to delete this project and all of its issues?') ? location.href='project-delete.php?id=<?php echo $_GET[id]; ?>' : false;">
                <span>Delete Project</span>
            </button>
        </div>        
    </div>
<?php include "footer.php"; ?>