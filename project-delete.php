<?php

    require "config.php";
    require "utils.php";
    require_once "security.php";
    
    authorize();

    $con = mysql_connect($Server, $Username, $Password);
    if (!$con)
    {
        die("Could not connect: " . mysql_error());
    }

    mysql_select_db($Database, $con);
        
    $sql = "DELETE FROM project WHERE id = '$_GET[id]'";    
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }
    
    $sql = "SELECT * FROM issue WHERE projectid = '$_GET[id]'";    
    $result = mysql_query($sql);
    while($row = mysql_fetch_array($result))
    {
        $sql = "DELETE FROM comment WHERE issueid = '$row[id]'";    
        if (!mysql_query($sql,$con))
        {
            die('Error: ' . mysql_error());
        }
    }
    
    $sql = "DELETE FROM issue WHERE projectid = '$_GET[id]'";    
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }

    mysql_close($con);
    
    PurgeActivity(1, $_GET[id]);
    
    header("Location: list.php?delete=true");
    exit;
    
?>