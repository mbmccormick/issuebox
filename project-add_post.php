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
    $nowlcl = date("Y-m-d H:i:s", strtotime("+3 hour", strtotime($now)));

    $sql = "INSERT INTO project (name, description, createdby, createddate) VALUES
            ('" . mysql_real_escape_string($_POST[name]) . "', '" . mysql_real_escape_string($_POST[description]) . "', '$CurrentUser_ID', '" . $nowlcl . "')";
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }
    
    mysql_close($con);
    
    header("Location: index.php");
    exit;
    
?>