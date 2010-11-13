<?php

    require "config.php";
    
    $con = mysql_connect($Server, $Username, $Password);
    if (!$con)
    {
        die("Could not connect: " . mysql_error());
    }

    mysql_select_db($Database, $con);   
    
    $result = mysql_query("SELECT * FROM issue WHERE id = '$_GET[id]' ORDER BY id ASC");
    $issue = mysql_fetch_array($result);

    $result = mysql_query("SELECT * FROM project WHERE id = '$issue[projectid]'");
    $project = mysql_fetch_array($result);
    
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
            <a href="index.php">Projects</a> / <a href="project.php?id=<?php echo $project[id]; ?>"><?php echo $project[name]; ?></a> / <a href="issue.php?id=<?php echo $issue[id]; ?>">Issue #<?php echo $issue[number]; ?></a>
        </div>
        <div class="list">
            <div class="list-item issue">
                <h3>Edit Issue</h3>
                <br />
                <form action="issue-edit-post.php?id=<?php echo $_GET[id]; ?>" method="post">
                    <b>Title</b><br />
                    <input type="text" name="title" style="width: 100%;" value="<?php echo $issue[title]; ?>" /><br />
                    <br />
                    <b>Body</b><br />                    
                    <textarea name="body" style="width: 762px;" rows="8"><?php echo $issue[body]; ?></textarea>
                    <br />
                    <br />
                    <button type="submit" class="button">
                        <span>Update Issue</span>
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