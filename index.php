<?php

    require "config.php";

?>
<?php include "header.php"; ?>
    <div class="content">
        <div class="navigation">
            <a href="index.php">Projects</a>
        </div>
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
                    $sql = mysql_query("SELECT * FROM issue WHERE projectid = '$row[id]' AND isclosed = '0'");
                    $open = mysql_num_rows($sql);
                    
                    $sql = mysql_query("SELECT * FROM issue WHERE projectid = '$row[id]' AND isclosed = '1'");
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
        <button type="submit" class="button" onclick="location.href='project-add.php';">
            <span>New Project</span>
        </button>
        <button type="submit" class="button">
            <span>Settings</span>
        </button>
    </div>
<?php include "footer.php"; ?>