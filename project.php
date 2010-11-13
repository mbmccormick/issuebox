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
        Issue Tracker
    </div>
    <div class="content">
        <div class="list">
            <?php

                $con = mysql_connect($Server, $Username, $Password);
                if (!$con)
                {
                    die("Could not connect: " . mysql_error());
                }

                mysql_select_db($Database, $con);

                $result = mysql_query("SELECT * FROM issue WHERE projectid = '$_GET[id]' ORDER BY number ASC");
                while($row = mysql_fetch_array($result))
                {
                    echo "<div class='list-item issue'>\n";
                    echo "<h3>#$row[number]&nbsp;&nbsp;<a href='issue.php?id=$row[id]'>" . $row[title] . "</a></h3><br />\n";
                    echo "<p>" . $row[details] . "</p>\n";
                    echo "</div>\n";
                }

            ?>
            <div class="list-item">
                <form action="issue-add.php?projectid=<?php echo $_GET[id]; ?>" method="post">
                    <input type="text" name="title" style="width: 100%;" /><br />
                    <textarea name="details" style="width: 762px;" rows="8"></textarea>
                    <br />
                    <br />
                    <button type="submit" class="button">
                        <span>Create Issue</span>
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