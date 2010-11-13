<?php

    require "config.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" dir=ltr lang=en-US> 
<head> 
  <title>Issue Tracker</title> 
  <link rel="stylesheet" type="text/css" media="screen,projection" href="stylesheet.css" />
</head> 
<body> 
    <div class="header">
        <a href="index.php">Issue Tracker</a>
    </div>
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
                    <input type="text" name="name" style="width: 100%;" /><br />
                    <br />
                    <b>Description</b><br />                    
                    <textarea name="description" style="width: 762px;" rows="5"></textarea>
                    <br />
                    <br />
                    <button type="submit" class="button">
                        <span>Create Project</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="footer">
        Copyright &copy; 2010 McCormick Technologies LLC. All rights reserved.
    </div>
</body> 
</html>