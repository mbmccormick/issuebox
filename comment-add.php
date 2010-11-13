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

    $sql = "INSERT INTO comment (issueid, body, createddate) VALUES
            ('$_GET[issueid]', '" . mysql_real_escape_string($_POST[body]) . "', '" . $nowlcl . "')";
    if (!mysql_query($sql,$con))
    {
        die('Error: ' . mysql_error());
    }
    
    if ($_GET[close] == "1")
    {
        $sql = "UPDATE issue SET isopen = '0' WHERE id='$_GET[issueid]'";
        if (!mysql_query($sql,$con))
        {
            die('Error: ' . mysql_error());
        }
    }
    
    mysql_close($con);
    
    header("Location: issue.php?id=$_GET[issueid]");
    exit;
    
?>