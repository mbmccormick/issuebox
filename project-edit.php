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

?>
<?php include "header.php"; ?>
    <div class="content">
        <div class="navigation">
            <a href="index.php">Projects</a> / <a href="project-edit.php?id=<?php echo $_GET[id]; ?>">Edit Project</a>
        </div>
        <div class="list">
            <div class="list-item project">
                <h3>Edit Project</h3>
                <br />
                <form action="project-edit-post.php?id=<?php echo $_GET[id]; ?>" method="post">
                    <b>Name</b><br />
                    <input type="text" name="name" style="width: 100%;" value="<?php echo $project[name]; ?>" /><br />
                    <br />
                    <b>Description</b><br />                    
                    <textarea name="description" style="width: 762px;" rows="5"><?php echo $project[description]; ?></textarea>
                    <br />
                    <br />
                    <button type="submit" class="button">
                        <span>Save</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
<?php include "footer.php"; ?>