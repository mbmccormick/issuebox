<?php

    function login()
    {
        return html("security/login.php");
    }
    
    function login_post()
    {
        if (Security_Login($_POST[username], $_POST[password]) == true)
        {
            header("Location: /");
            exit;
        }
        else
        {
            header("Location: /login?msg=Please check your login credentials and try again.");
            exit;
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