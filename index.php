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

                $result = mysql_query("SELECT * FROM project ORDER BY name ASC");
                while($row = mysql_fetch_array($result))
                {
                    $sql = mysql_query("SELECT * FROM issue WHERE projectid = '$row[id]' AND isopen = '1'");
                    $open = mysql_num_rows($sql);
                    
                    $sql = mysql_query("SELECT * FROM issue WHERE projectid = '$row[id]' AND isopen = '0'");
                    $closed = mysql_num_rows($sql);
                                        
                    echo "<div class='list-item project'>\n";
                    echo "<table cellpadding='0' cellspacing='0' style='width: 100%;'><tr>\n";
                    
                    echo "<td width='100%'>\n";
                    echo "<h3><a href='project.php?id=$row[id]'>" . $row[name] . "</a></h3><br />\n";
                    echo "<p>" . $row[description] . "</p>\n";
                    echo "</td>\n";
                    
                    echo "<td>\n";
                    echo "<div class='counter'>\n";
                    echo "<big>$open</big>\n";
                    echo "Open Issues\n";
                    echo "</div>\n";
                    echo "</td>\n";
                    
                    echo "<td>\n";
                    echo "<div class='counter'>\n";
                    echo "<big>$closed</big>\n";
                    echo "Closed Issues\n";
                    echo "</div>\n";
                    echo "</td>\n";    
                    
                    echo "</tr></table>\n";
                    echo "</div>\n";
                }

            ?>
        </div>
        <br />
        <button type="submit" class="button">
            <span>New Project</span>
        </button>
    </div>
    <div class="footer">
        Copyright &copy; 2010 McCormick Technologies LLC. All rights reserved.
    </div>
</body> 
</html>