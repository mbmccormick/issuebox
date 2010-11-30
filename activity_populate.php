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
    
    $count = 0;
    
    $result = mysql_query("SELECT * FROM project ORDER BY createddate ASC");
    while($row = mysql_fetch_array($result))
    {
        LogActivity(1, $row[id], 1, $row[createdby], $row[createddate]);
    }
    $count = $count + mysql_num_rows($result);
    
    $result = mysql_query("SELECT * FROM issue ORDER BY createddate ASC");
    while($row = mysql_fetch_array($result))
    {
        LogActivity(2, $row[id], 1, $row[createdby], $row[createddate]);
    }
    $count = $count + mysql_num_rows($result);
    
    $result = mysql_query("SELECT * FROM comment ORDER BY createddate ASC");
    while($row = mysql_fetch_array($result))
    {
        LogActivity(3, $row[id], 1, $row[createdby], $row[createddate]);
    }
    $count = $count + mysql_num_rows($result);
    
    
    mysql_close($con);    
    
    echo "Populated activity with $count records.";
    
    
    function LogActivity($itemtype = 0, $itemid = 0, $actiontype = 0, $createdby, $createddate)
    {
        $sql = "INSERT INTO activity (itemtype, itemid, actiontype, createdby, createddate) VALUES
                    ('$itemtype', '$itemid', '$actiontype', '$createdby', '$createddate')";
        if (!mysql_query($sql))
        {
            die('Error: ' . mysql_error());
        }
    }
    
?>