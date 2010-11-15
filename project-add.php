<?php

    require "config.php";

?>
<?php include "header.php"; ?>
    <div class="content">
        <div class="navigation">
            <a href="index.php">Projects</a> / <a href="project-add.php">New Project</a>
        </div>
        <div class="list">
            <div class="list-item issue">
                <h3>New Project</h3>
                <br />
                <form action="project-add-post.php" method="post">
                    <b>Name</b><br />
                    <input type="text" name="name" style="width: 760px;" /><br />
                    <br />
                    <b>Description</b><br />                    
                    <textarea name="description" style="width: 760px;" rows="5"></textarea>
                    <br />
                    <br />
                    <button type="submit" class="button">
                        <span>Create Project</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
<?php include "footer.php"; ?>