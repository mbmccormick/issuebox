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
    
    
    $result = mysql_query("SELECT * FROM user WHERE id = '$_GET[id]'");
    $user = mysql_fetch_array($result);
    
    $now = date("Y-m-d H:i:s");
    $nowlcl = date("Y-m-d H:i:s", strtotime("+3 hour", strtotime($now)));

    if (md5($_POST[currentpassword]) == $user[password])
    {
        if ($user[newpassword] == $user[newpasswordconfirm])
        {
            $sql = "UPDATE user SET username = '" . mysql_real_escape_string($_POST[username]) . "', password = '" . md5(mysql_real_escape_string($_POST[newpassword])) . "', email = '" . mysql_real_escape_string($_POST[email]) . "' WHERE id = '$_GET[id]'";
            if (!mysql_query($sql,$con))
            {
                die('Error: ' . mysql_error());
            }
        }
    }
    else
    {
        $sql = "UPDATE user SET username = '" . mysql_real_escape_string($_POST[username]) . "', email = '" . mysql_real_escape_string($_POST[email]) . "' WHERE id = '$_GET[id]'";
        if (!mysql_query($sql,$con))
        {
            die('Error: ' . mysql_error());
        }
    }
    
    mysql_close($con);
    
    header("Location: user-edit.php?id=$_GET[id]");
    exit;
    
?>