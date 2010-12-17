<?php

    function Security_Login($username, $password)
    {
        $sql = mysql_query("SELECT * FROM user WHERE username = '" . mysql_real_escape_string($username) . "' AND password = '" . md5(mysql_real_escape_string($password)) . "'");
        
        if (mysql_num_rows($sql) > 0)
        {
            $row = mysql_fetch_array($sql);
            
            $_SESSION["CurrentUser_ID"] = $row[id];
            $_SESSION["CurrentUser_Username"] = $row[username];
            $_SESSION["CurrentUser_Email"] = $row[email];
        
            return true;
        }
        else
        {
            return false;
        }
    }
    
    function Security_Logout()
    {
        session_destroy();
        
        return true;
    }
    
    function Security_Authorize()
    {
        if ($_SESSION["CurrentUser_ID"] == null)
        {
            header("Location: login");
            exit;
        }
    }
    
?>