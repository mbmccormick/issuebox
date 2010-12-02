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
        
    $sql = "DELETE FROM comment WHERE issueid = '$_GET[id]'";    
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }
    
    $sql = "DELETE FROM issue WHERE id = '$_GET[id]'";    
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }

    mysql_close($con);
    
    LogActivity(2, $_GET[id], 3);
    
    header("Location: project.php?id=$_GET[projectid]");
    exit;
    
?>