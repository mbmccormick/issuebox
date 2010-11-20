<?php

    session_start();
    
    $CurrentUser_ID = $_SESSION["CurrentUser_ID"];
    $CurrentUser_Username = $_SESSION["CurrentUser_Username"];
    $CurrentUser_Email = $_SESSION["CurrentUser_Email"];
    
    function login($username, $password)
    {
        require "config.php";
    
        $con = mysql_connect($Server, $Username, $Password);
        if (!$con)
        {
            die("Could not connect: " . mysql_error());
        }

        mysql_select_db($Database, $con);
        
        $sql = mysql_query("SELECT * FROM user WHERE username = '" . mysql_real_escape_string($username) . "' AND password = '" . md5(mysql_real_escape_string($password)) . "'");
        
        if (mysql_num_rows($sql) > 0)
        {
            $row = mysql_fetch_array($sql);
            
            $_SESSION["CurrentUser_ID"] = $row[id];
            $_SESSION["CurrentUser_Username"] = $row[username];
            $_SESSION["CurrentUser_Email"] = $row[email];
        
            mysql_close($con);
        
            return true;
        }
        else
        {
            mysql_close($con);
            
            return false;
        }
    }
    
    function logout()
    {
        session_start();
        session_destroy();
        
        return true;
    }
    
    function authorize()
    {
        if ($_SESSION["CurrentUser_ID"] == null)
        {
            header("Location: login.php");
            exit;
        }
    }
    
?>