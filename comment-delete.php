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

    $sql = "DELETE FROM comment WHERE id = '$_GET[id]'";    
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }

    mysql_close($con);
    
    header("Location: issue.php?id=$_GET[issueid]");
    exit;
    
?>