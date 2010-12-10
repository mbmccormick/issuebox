<?php

    require "config.php";
    require "security.php";
    
    if (logout() == true)
    {
        header("Location: login.php");
        exit;
    }

?>
