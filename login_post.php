<?php

    require "config.php";
    require "security.php";

    if (login($_POST[username], $_POST[password]) == true)
    {
        header("Location: index.php");
        exit;
    }
    else
    {
        header("Location: login.php?msg=Invalid login credentials.");
        exit;
    }
    
?>