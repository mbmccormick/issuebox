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
    
    $result = mysql_query("SELECT * FROM issue WHERE id = '$_GET[id]'");
    $issue = mysql_fetch_array($result);

    $result = mysql_query("SELECT * FROM project WHERE id = '$issue[projectid]'");
    $project = mysql_fetch_array($result);
    
?>
<?php include "header.php"; ?>
    <div class="content">
        <div class="navigation">
            <a href="index.php">Home</a> / <a href="list.php">Projects</a> / <a href="project.php?id=<?php echo $project[id]; ?>"><?php echo $project[name]; ?></a> / <a href="issue.php?id=<?php echo $issue[id]; ?>">Issue #<?php echo $issue[number]; ?></a>
        </div>
        <div class="list">
            <form action="issue-edit_post.php?id=<?php echo $_GET[id]; ?>" method="post">
                <div class="list-item issue">
                    <table cellpadding="0" cellspacing="0" style="width: 100%;">
                        <tr>
                            <td valign="middle">
                                <h3>Edit Issue</h3>
                            </td>
                            <td valign="middle" align="right">
                                <small>Issues are parsed with <a target="_blank" href="https://github.com/github/github-flavored-markdown">GitHub Flavored Markdown</a></small>
                            </td>
                        </tr>
                    </table>
                    <br />
                    <b>Title</b><br />
                    <input type="text" name="title" style="width: 750px;" value="<?php echo $issue[title]; ?>" /><br />
                    <br />
                    <b>Body</b><br />                    
                    <textarea name="body" style="width: 750px;" rows="8"><?php echo $issue[body]; ?></textarea>
                </div>
                <br />
                <button type="submit" class="button">
                    <span>Save Issue</span>
                </button>
                <button type="button" class="button" onclick="confirm('Are you sure you want to delete this issue and all of its comments?') ? location.href='issue-delete_post.php?id=<?php echo $_GET[id]; ?>' : false;">
                    <span>Delete</span>
                </button>
            </form>
        </div>
    </div>
<?php include "footer.php"; ?>
