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
    
    
    $now = date("Y-m-d H:i:s");
    
    $sql = "INSERT INTO user (username, password, email, createddate) VALUES
            ('" . mysql_real_escape_string($_POST[username]) . "', '" . md5(mysql_real_escape_string($_POST[password])) . "', '" . mysql_real_escape_string($_POST[email]) . "', '" . $now . "')";
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }
    
    mysql_close($con);
    
    header("Location: user.php");
    exit;
    
?>