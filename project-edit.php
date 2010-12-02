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
    
    $result = mysql_query("SELECT * FROM project WHERE id = '$_GET[id]'");
    $project = mysql_fetch_array($result);

?>
<?php include "header.php"; ?>
    <div class="content">
        <div class="navigation">
            <a href="index.php">Home</a> / <a href="list.php">Projects</a> / <a href="project-edit.php?id=<?php echo $_GET[id]; ?>">Edit Project</a>
        </div>
        <div class="list">
            <form action="project-edit_post.php?id=<?php echo $_GET[id]; ?>" method="post">
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
                <button type="button" class="button" onclick="confirm('Are you sure you want to delete this project and all of its issues?') ? location.href='issue-delete_post.php?id=<?php echo $_GET[id]; ?>' : false;">
                    <span>Delete</span>
                </button>
            </form>
        </div>
    </div>
<?php include "footer.php"; ?>