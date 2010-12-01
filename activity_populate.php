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
    
    $count = 0;
    
    $result = mysql_query("SELECT * FROM project ORDER BY createddate ASC");
    while($row = mysql_fetch_array($result))
    {
        LogActivity(1, $row[id], 1, $row[createdby], $row[createddate]);
    }
    $count = $count + mysql_num_rows($result);
    
    $result = mysql_query("SELECT * FROM issue ORDER BY createddate ASC");
    while($row = mysql_fetch_array($result))
    {
        LogActivity(2, $row[id], 1, $row[createdby], $row[createddate]);
    }
    $count = $count + mysql_num_rows($result);
    
    $result = mysql_query("SELECT * FROM comment ORDER BY createddate ASC");
    while($row = mysql_fetch_array($result))
    {
        LogActivity(3, $row[id], 1, $row[createdby], $row[createddate]);
    }
    $count = $count + mysql_num_rows($result);
    
    
    mysql_close($con);    
    
    echo "Populated activity with $count records.";
    
    
    function LogActivity($itemtype = 0, $itemid = 0, $actiontype = 0)
    {
        $headline = "";
        $description = "";
        
        if ($itemtype == "1")
        {
            $sql = mysql_query("SELECT * FROM project WHERE id = '$itemid'");
            $project = mysql_fetch_array($sql);
            
            if ($actiontype == "1")
            {
                $headline = "created project <a href='project.php?id=$project[id]'>" . $project[name] . "</a>";
            }
            else if ($actiontype == "2")
            {
                $headline = "updated project <a href='project.php?id=$project[id]'>" . $project[name] . "</a>";
            }
            else if ($actiontype == "3")
            {
                $headline = "deleted project <a href='project.php?id=$project[id]'>" . $project[name] . "</a>";
            }
            
            $description = $project[description];
        }
        else if ($itemtype == "2")
        {
            $sql = mysql_query("SELECT * FROM issue WHERE id = '$itemid'");
            $issue = mysql_fetch_array($sql);
            
            $sql = mysql_query("SELECT * FROM project WHERE id = '$issue[projectid]'");
            $project = mysql_fetch_array($sql);
            
            if ($actiontype == "1")
            {
                $headline = "created <a href='issue.php?id=$issue[id]'>issue " . $issue[number] . "</a> on <a href='project-edit.php?id=$project[id]'>" . $project[name] . "</a>";
            }
            else if ($actiontype == "2")
            {
                $headline = "updated <a href='issue.php?id=$issue[id]'>issue " . $issue[number] . "</a> on <a href='project-edit.php?id=$project[id]'>" . $project[name] . "</a>";
            }
            else if ($actiontype == "3")
            {
                $headline = "deleted <a href='issue.php?id=$issue[id]'>issue " . $issue[number] . "</a> on <a href='project-edit.php?id=$project[id]'>" . $project[name] . "</a>";
            }
            
            $description = $issue[body];
        }
        else if ($itemtype == "3")
        {
            $sql = mysql_query("SELECT * FROM comment WHERE id = '$itemid'");
            $comment = mysql_fetch_array($sql);
            
            $sql = mysql_query("SELECT * FROM issue WHERE id = '$comment[issueid]'");
            $issue = mysql_fetch_array($sql);
            
            if ($actiontype == "1")
            {
                $headline = "commented on <a href='issue.php?id=$issue[id]'>issue " . $issue[number] . "</a>";
            }
            else if ($actiontype == "2")
            {
                $headline = "updated a comment on <a href='issue.php?id=$issue[id]'>issue " . $issue[number] . "</a>";
            }
            else if ($actiontype == "3")
            {
                $headline = "deleted a comment on <a href='issue.php?id=$issue[id]'>issue " . $issue[number] . "</a>";
            }
            
            $description = $comment[body];
        }

        $now = date("Y-m-d H:i:s");
        $sql = "INSERT INTO activity (headline, description, actiontype, createdby, createddate) VALUES
                    ('" . mysql_real_escape_string($headline) . "', '" . mysql_real_escape_string($description) . "', '$actiontype', '" . $_SESSION["CurrentUser_ID"] . "', '$now')";
        if (!mysql_query($sql))
        {
            die('Error: ' . mysql_error());
        }
    }
    
?>