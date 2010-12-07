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
        
    $sql = "DELETE FROM user WHERE id = '$_GET[id]'";    
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }

    mysql_close($con);
    
    header("Location: user.php?delete=true");
    exit;
    
?>