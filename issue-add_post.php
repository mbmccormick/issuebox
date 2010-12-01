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
    
    
    $result = mysql_query("SELECT MAX(number) AS maxnum FROM issue WHERE projectid = '$_GET[projectid]'");
    $row = mysql_fetch_array($result);
    $next_num = $row[maxnum] + 1;
    
    
    $now = date("Y-m-d H:i:s");
    
    $sql = "INSERT INTO issue (projectid, number, title, body, isclosed, createdby, createddate) VALUES
            ('$_GET[projectid]', '$next_num', '" . mysql_real_escape_string($_POST[title]) . "', '" . mysql_real_escape_string($_POST[body]) . "', '0', '$CurrentUser_ID', '" . $now . "')";
    
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }

    $sql = mysql_query("SELECT * FROM issue ORDER BY createddate DESC LIMIT 1");
    $result = mysql_fetch_array($sql);
    
    mysql_close($con);
    
    LogActivity(2, $result[id], 1);
    
    header("Location: project.php?id=$_GET[projectid]");
    exit;
    
?>