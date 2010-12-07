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
    
    if ($_SERVER[REQUEST_METHOD] === "POST")
    {
        $now = date("Y-m-d H:i:s");
    
        $sql = "UPDATE issue SET title = '" . mysql_real_escape_string($_POST[title]) . "', body = '" . mysql_real_escape_string($_POST[body]) . "' WHERE id = '$_GET[id]'";
        if (!mysql_query($sql,$con))
        {
            die('Error: ' . mysql_error());
        }
        
        mysql_close($con);
        
        LogActivity(2, $_GET[id], 2);
        
        header("Location: issue.php?id=$_GET[id]&success=true");
        exit;
    }
    
    $result = mysql_query("SELECT * FROM issue WHERE id = '$_GET[id]'");
    $issue = mysql_fetch_array($result);

    $result = mysql_query("SELECT * FROM project WHERE id = '$issue[projectid]'");
    $project = mysql_fetch_array($result);
    
?>
<?php include "header.php"; ?>
    <?php SetPageTitle("Issue #" . $issue[number]); ?>
    <div class="content">
        <div class="navigation">
            <a href="index.php">Home</a> / <a href="list.php">Projects</a> / <a href="project.php?id=<?php echo $project[id]; ?>"><?php echo $project[name]; ?></a> / <a href="issue.php?id=<?php echo $issue[id]; ?>">Issue #<?php echo $issue[number]; ?></a>
        </div>
        <div class="list">
            <form id="issue-edit" action="<?php echo $_SERVER[PHP_SELF]; ?>?id=<?php echo $_GET[id]; ?>" method="post">
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
                    <input type="text" name="title" style="width: 710px;" value="<?php echo $issue[title]; ?>" /><br />
                    <br />
                    <b>Body</b><br />                    
                    <textarea name="body" style="width: 710px;" rows="8"><?php echo $issue[body]; ?></textarea>
                </div>
                <br />
                <button type="submit" class="button">
                    <span>Save Issue</span>
                </button>
                <button type="button" class="button" onclick="confirm('Are you sure you want to delete this issue and all of its comments?') ? location.href='issue-delete.php?id=<?php echo $_GET[id]; ?>' : false;">
                    <span>Delete</span>
                </button>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        
        $("#issue-edit").submit(function validate() {
            var formData = $("#issue-edit").serializeArray();
            for (var i=0; i < formData.length; i++) { 
                if (!formData[i].value) { 
                    $(document).showMessage({
                        thisMessage: ["Please complete all fields, check your input, and try again."],
                        className: "error",
                        opacity: 80,
                        displayNavigation: false,
                        autoClose: true,
                        delayTime: 5000
                    });
                    
                    return false;
                }
            }
        });
        
    </script>
<?php include "footer.php"; ?>
