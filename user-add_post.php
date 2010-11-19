<?php

    require "config.php";

    $con = mysql_connect($Server, $Username, $Password);
    if (!$con)
    {
        die("Could not connect: " . mysql_error());
    }

    mysql_select_db($Database, $con);
    
    
    $now = date("Y-m-d H:i:s");
    $nowlcl = date("Y-m-d H:i:s", strtotime("+3 hour", strtotime($now)));

    $sql = "INSERT INTO user (username, password, email, createddate) VALUES
            ('" . mysql_real_escape_string($_POST[username]) . "', '" . mysql_real_escape_string($_POST[password]) . "', '" . mysql_real_escape_string($_POST[email]) . "', '" . $nowlcl . "')";
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }
    
    mysql_close($con);
    
    header("Location: user.php");
    exit;
    
?>