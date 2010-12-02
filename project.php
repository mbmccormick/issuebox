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
                        <a href="index.php">Home</a> / <a href="list.php">Projects</a> / <a href="project.php?id=<?php echo $project[id]; ?>"><?php echo $project[name]; ?></a>
                    </div>
                </td>
                <td valign="middle" align="right">
                    <?php include "filter.php"; ?>
                </td>
            </tr>
        </table>
        <div class="list">
            <script type="text/javascript">            
                var converter = new Showdown.converter();            
            </script>
            <?php
                
                if ($_GET[open] == "1")
                    $result = mysql_query("SELECT * FROM issue WHERE projectid = '$project[id]' AND isclosed='0' ORDER BY number ASC");
                if ($_GET[open] == "0")
                    $result = mysql_query("SELECT * FROM issue WHERE projectid = '$project[id]' AND isclosed='1' ORDER BY number ASC");
                if ($_GET[open] == "1" && $_GET[closed] == "1")
                    $result = mysql_query("SELECT * FROM issue WHERE projectid = '$project[id]' AND (isclosed='1' OR isclosed='0') ORDER BY number ASC");  
                if ($_GET[open] == "0" && $_GET[closed] == "0")
                    $result = mysql_query("SELECT * FROM issue WHERE projectid = '$project[id]' AND (isclosed='1' AND isclosed='0') ORDER BY number ASC");  
                   
                while($row = mysql_fetch_array($result))
                {
                    $sql = mysql_query("SELECT COUNT(*) AS rowcount FROM comment WHERE issueid = '$row[id]'");
                    $return = mysql_fetch_array($sql);
                    $count = $return[rowcount];
                    
                    $sql = mysql_query("SELECT id, username FROM user WHERE id = '$row[createdby]'");
                    $user = mysql_fetch_array($sql);
                                    
                    echo "<div class='list-item issue'>\n";
                    
                    echo "<table cellpadding='0' cellspacing='0' style='width: 100%;'>\n";
                    echo "<tr>\n";
                    echo "<td valign='middle'>\n";
                    echo "<h3>#$row[number]&nbsp;&nbsp;<a href='issue.php?id=$row[id]'>" . $row[title] . "</a></h3>";
                    echo "</td>\n";
                    echo "<td valign='middle' align='right'>\n";
                    if ($row[isclosed] == "1")
                        echo "<em class='closed'>Closed</span>";
                    echo "</td>\n";
                    echo "</tr>\n";
                    echo "</table>\n";
                    echo "<div id='issue$row[number]' class='wikiStyle'>" . $row[body] . "</div>\n";
                    echo "<br />\n";
                    echo "<div class='options'>\n";
                    if ($count == 1)
                        echo "<a href='issue.php?id=$row[id]'>$count comment</a>\n";
                    else
                        echo "<a href='issue.php?id=$row[id]'>$count comments</a>\n";
                    echo "&nbsp;Created about " . FriendlyDate(1, strtotime($row[createddate])) . " by <a href='user-edit.php?id=$user[id]'>$user[username]</a>";
                    echo "</div>\n";
                    
                    echo "<script type='text/javascript'>\n";
                    echo "document.getElementById('issue$row[number]').innerHTML = converter.makeHtml(document.getElementById('issue$row[number]').innerHTML);\n";
                    echo "</script>\n";
                    
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
                <table cellpadding="0" cellspacing="0" style="width: 100%;">
                    <tr>
                        <td valign="middle">
                            <h3>New Issue</h3>
                        </td>
                        <td valign="middle" align="right">
                            <small>Issues are parsed with <a target="_blank" href="https://github.com/github/github-flavored-markdown">GitHub Flavored Markdown</a></small>
                        </td>
                    </tr>
                </table>
                <br />
                <form action="issue-add_post.php?projectid=<?php echo $project[id]; ?>" method="post">
                    <b>Title</b><br />
                    <input type="text" name="title" style="width: 710px;" /><br />
                    <br />
                    <b>Body</b><br />                    
                    <textarea name="body" style="width: 710px;" rows="8"></textarea>
                    <br />
                    <br />
                    <button type="submit" class="button">
                        <span>Create Issue</span>
                    </button>
                </form>
            </div>
            <br />
            <button type="button" class="button" onclick="location.href='project-edit.php?id=<?php echo $project[id]; ?>';">
                <span>Edit Project</span>
            </button>
            <button type="button" class="button" onclick="confirm('Are you sure you want to delete this project and all of its issues?') ? location.href='project-delete_post.php?id=<?php echo $project[id]; ?>' : false;">
                <span>Delete</span>
            </button>
        </div>        
    </div>
<?php include "footer.php"; ?>
