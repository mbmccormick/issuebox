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

?>
<?php include "header.php"; ?>
    <div class="content">
        <div class="navigation">
            <a href="index.php">Projects</a>
        </div>
        <div class="list">
            <?php

                $result = mysql_query("SELECT * FROM project ORDER BY name ASC");
                while($row = mysql_fetch_array($result))
                {
                    $sql = mysql_query("SELECT COUNT(*) AS rowcount FROM issue WHERE projectid = '$row[id]' AND isclosed = '0'");
                    $return = mysql_fetch_array($sql);
                    $open = $return[rowcount];
                    
                    $sql = mysql_query("SELECT COUNT(*) AS rowcount FROM issue WHERE projectid = '$row[id]' AND isclosed = '1'");
                    $return = mysql_fetch_array($sql);
                    $closed = $return[rowcount];
                                        
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
                
                if (mysql_num_rows($result) == 0)
                {
                    echo "<div class='list-item project'>\n";
                    echo "<p>There are currently no projects setup.</p>\n";
                    echo "</div>\n";
                }

            ?>
        </div>
        <br />
        <button type="button" class="button" onclick="location.href='project-add.php';">
            <span>New Project</span>
        </button>
        <button type="button" class="button" onclick="location.href='settings.php';">
            <span>Settings</span>
        </button>
    </div>
<?php include "footer.php"; ?>