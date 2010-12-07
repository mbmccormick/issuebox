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
        $nowlcl = date("Y-m-d H:i:s", strtotime("+3 hour", strtotime($now)));

        $sql = "UPDATE project SET name = '" . mysql_real_escape_string($_POST[name]) . "', description = '" . mysql_real_escape_string($_POST[description]) . "' WHERE id = '$_GET[id]'";
        if (!mysql_query($sql,$con))
        {
            die('Error: ' . mysql_error());
        }
        
        mysql_close($con);
        
        LogActivity(1, $_GET[id], 2);
        
        header("Location: project.php?id=$_GET[id]&success=true");
        exit;
    }
    
    $result = mysql_query("SELECT * FROM project WHERE id = '$_GET[id]'");
    $project = mysql_fetch_array($result);

?>
<?php include "header.php"; ?>
    <?php SetPageTitle($project[name]); ?>
    <div class="content">
        <div class="navigation">
            <a href="index.php">Projects</a> / <a href="project-edit.php?id=<?php echo $_GET[id]; ?>">Edit Project</a>
        </div>
        <div class="list">
            <form id="project-edit" action="<?php echo $_SERVER[PHP_SELF]; ?>?id=<?php echo $_GET[id]; ?>" method="post">
                <div class="list-item project">
                    <h3>Edit Project</h3>
                    <br />                    
                    <b>Name</b><br />
                    <input type="text" name="name" style="width: 710px;" value="<?php echo $project[name]; ?>" /><br />
                    <br />
                    <b>Description</b><br />                    
                    <textarea name="description" style="width: 710px;" rows="5"><?php echo $project[description]; ?></textarea>                        
                </div>
                <br />
                <button type="submit" class="button">
                    <span>Save Project</span>
                </button>
                <button type="button" class="button" onclick="confirm('Are you sure you want to delete this project and all of its issues?') ? location.href='issue-delete.php?id=<?php echo $_GET[id]; ?>' : false;">
                    <span>Delete</span>
                </button>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        
        $("#project-edit").submit(function validate() {
            var formData = $("#project-edit").serializeArray();
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