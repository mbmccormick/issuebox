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
    
    
    $now = date("Y-m-d H:i:s");
    $nowlcl = date("Y-m-d H:i:s", strtotime("+3 hour", strtotime($now)));

    $sql = "UPDATE issue SET title = '" . mysql_real_escape_string($_POST[title]) . "', body = '" . mysql_real_escape_string($_POST[body]) . "' WHERE id = '$_GET[id]'";
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }
    
    mysql_close($con);
    
    LogActivity(2, $_GET[id], 2);
    
    header("Location: issue.php?id=$_GET[id]");
    exit;
    
?>