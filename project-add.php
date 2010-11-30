<?php

    require "config.php";
    require_once "security.php";
    
    authorize();

?>
<?php include "header.php"; ?>
    <div class="content">
        <div class="navigation">
            <a href="index.php">Home</a> / <a href="list.php">Projects</a> / <a href="project-add.php">New Project</a>
        </div>
        <div class="list">
            <form action="project-add_post.php" method="post">
                <div class="list-item issue">
                    <h3>New Project</h3>
                    <br />
                    <b>Name</b><br />
                    <input type="text" name="name" style="width: 750px;" /><br />
                    <br />
                    <b>Description</b><br />                    
                    <textarea name="description" style="width: 750px;" rows="5"></textarea>
                </div>        
                <br />
                <button type="submit" class="button">
                    <span>Create Project</span>
                </button>
            </form>
        </div>
    </div>
<?php include "footer.php"; ?>