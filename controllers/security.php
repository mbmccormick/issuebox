<?php

    function login()
    {
        set("identity", $_SESSION[CurrentUser_Identity]);
        set("title", "Login");
        return html("security/login.php", "basic.php");
    }
    
    function login_post()
    {
        if (Security_Login($_POST[username], $_POST[password]) == true)
        {
            if (isset($_SESSION[CurrentUser_Identity]))
            {
                $sql = "UPDATE user SET identity = '". $_SESSION[CurrentUser_Identity] . "' WHERE id = '$_SESSION[CurrentUser_ID]'";
                mysql_query($sql);
                
                header("Location: /&success=Your Google Account was linked to Issuebox successfully!");
                exit;
            }
            else
            {
                header("Location: /");
                exit;
            }
        }
        else
        {
            header("Location: /login&error=Please check your login credentials and try again.");
            exit;
        }
    }
    
    function login_reset()
    {
        set("title", "Reset Password");
        return html("security/reset.php", "basic.php");
    }
    
    function login_reset_post()
    {
        $result = mysql_query("SELECT * FROM user WHERE email = '" . $_POST[email] . "'");
        $user = mysql_fetch_array($result);
        
        $password = "";
        for ($i = 0; $i < 8; $i++)
        { 
            $d .= rand(1, 30) % 2; 
            $password .= $d ? chr(rand(65, 90)) : chr(rand(48, 57)); 
        }
        
        if (mail($user[email], "Your New Issuebox Password", "You recently requested a new password for Issuebox. Your new password is " . $password . ".\n\n--\nIssuebox", "From: Issuebox <" . RetrieveSetting("ContactEmailAddress") . ">") == true)
        {        
            $sql = "UPDATE user SET password = '". md5($password) . "' WHERE id = '$user[id]'";
            mysql_query($sql);
            
            header("Location: /login&success=Your password has been reset and a new one was just emailed to you!");
            exit;
        }
        else
        {
            header("Location: /login&error=Something went wrong, please contact our support team!");
            exit;
        }
    }
    
    function login_openid_google()
    {
        $openid = new LightOpenID;
        
        if($openid->mode == 'cancel')
        {
            header("Location: /login&error=Please check your login credentials and try again.");
            exit;
        }
        else
        {
            if ($openid->validate() &&
                Security_Login_OpenID($openid->identity) == true)
            {
                header("Location: /");
                exit;
            }
            else
            {
                $_SESSION[CurrentUser_Identity] = $openid->identity;
                header("Location: /login&warning=Please login to Issuebox to finish linking your Google Account.");
                exit;
            }
        }
    }
    
    function login_openid_google_post()
    {
        $openid = new LightOpenID;
        $openid->returnUrl = "http://" . $_SERVER['HTTP_HOST'] . "/?/login/openid/google";
            
        if(!$openid->mode)
        {
            $openid->identity = "https://www.google.com/accounts/o8/id";
            header("Location: " . $openid->authUrl());
        }
    }
    
    function logout()
    {
        if (Security_Logout() == true)
        {
            header("Location: /login");
            exit;
        }
    }

?>