<?php

    require "config.php";
    require "utils.php";
    require_once "security.php";
    
    authorize();
    
    if ($_SERVER[REQUEST_METHOD] === "POST")
    {
        $con = mysql_connect($Server, $Username, $Password);
        if (!$con)
        {
            die("Could not connect: " . mysql_error());
        }

        mysql_select_db($Database, $con);
        
        
        $now = date("Y-m-d H:i:s");
        
        $sql = "INSERT INTO project (name, description, createdby, createddate) VALUES
                ('" . mysql_real_escape_string($_POST[name]) . "', '" . mysql_real_escape_string($_POST[description]) . "', '$CurrentUser_ID', '" . $now . "')";
        if (!mysql_query($sql,$con))
        {
            die('Error: ' . mysql_error());
        }
        
        $sql = mysql_query("SELECT * FROM project WHERE id = '" . mysql_insert_id() . "'");
        $result = mysql_fetch_array($sql);
        
        mysql_close($con);
        
        LogActivity(1, $result[id], 1);
        
        header("Location: index.php");
        exit;
    }

?>
<?php include "header.php"; ?>
    <?php SetPageTitle("New Project"); ?>
    <div class="content">
        <div class="navigation">
            <a href="index.php">Home</a> / <a href="list.php">Projects</a> / <a href="project-add.php">New Project</a>
        </div>
        <div class="list">
            <form action="<?php echo $_SERVER[PHP_SELF]; ?>" method="post">
                <div class="list-item issue">
                    <h3>New Project</h3>
                    <br />
                    <b>Name</b><br />
                    <input type="text" name="name" style="width: 710px;" /><br />
                    <br />
                    <b>Description</b><br />                    
                    <textarea name="description" style="width: 710px;" rows="5"></textarea>
                </div>        
                <br />
                <button type="submit" class="button">
                    <span>Create Project</span>
                </button>
            </form>
        </div>
    </div>
<?php include "footer.php"; ?>