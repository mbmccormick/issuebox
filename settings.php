<?php

    require "config.php";
    require_once "security.php";
    
    authorize(); 

?>
<?php include "header.php"; ?>
    <div class="content">
        <div class="navigation">
            <a href="settings.php">Settings</a>
        </div>
        <div class="list">
            <div class="list-item setting">
                <a href="user.php">Users</a>
            </div>
        </div>
        <br />
        <button type="button" class="button" onclick="location.href='index.php';">
            <span>Return to Projects</span>
        </button>
    </div>
<?php include "footer.php"; ?>