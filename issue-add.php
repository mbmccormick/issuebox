<?php

    require "config.php";

    $con = mysql_connect($Server, $Username, $Password);
    if (!$con)
    {
        die("Could not connect: " . mysql_error());
    }

    mysql_select_db($Database, $con);
    
    
    $result = mysql_query("SELECT MAX(number) FROM issue WHERE projectid = '$_GET[projectid]'");
    $row = mysql_fetch_array($result);
    $next_num = $row[number] > 0 ? $row[number] : 1;
    
    
    $now = date("Y-m-d H:i:s");
    $nowlcl = date("Y-m-d H:i:s", strtotime("+3 hour", strtotime($now)));

    $sql = "INSERT INTO issue (projectid, number, title, details, isopen, createddate) VALUES
            ('$_GET[projectid]', '$next_num', '$_POST[title]', '" . mysql_real_escape_string($_POST[details]) . "', '1', '" . $nowlcl . "')";
    
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }

    mysql_close($con);
    
    header("Location: project.php?id=$_GET[projectid]");
    exit;
    
?>