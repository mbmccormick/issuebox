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

    $sql = "UPDATE project SET name = '" . mysql_real_escape_string($_POST[name]) . "', description = '" . mysql_real_escape_string($_POST[description]) . "' WHERE id = '$_GET[id]'";
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }
    
    mysql_close($con);
    
    header("Location: project.php?id=$_GET[id]");
    exit;
    
?>