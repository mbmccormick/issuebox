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
    
    $sql = "INSERT INTO comment (issueid, body, createdby, createddate) VALUES
            ('$_GET[issueid]', '" . mysql_real_escape_string($_POST[body]) . "', '$CurrentUser_ID', '" . $now . "')";
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }
    
    if ($_GET[close] == "1")
    {
        $sql = "UPDATE issue SET isclosed = '1' WHERE id='$_GET[issueid]'";
        if (!mysql_query($sql,$con))
        {
            die('Error: ' . mysql_error());
        }
    }
    
    $sql = mysql_query("SELECT * FROM comment ORDER BY createddate DESC LIMIT 1");
    $result = mysql_fetch_array($sql);
    
    mysql_close($con);
    
    LogActivity(3, $result[id], 1);
    
    header("Location: issue.php?id=$_GET[issueid]");
    exit;
    
?>