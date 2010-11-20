<?php

    require "config.php";
    require_once "security.php";
    
    authorize();
    
?>
<?php include "header.php"; ?>
    <div class="content">
        <div class="navigation">
            <a href="settings.php">Settings</a> / <a href="user.php">Users</a> / <a href="user-add.php">New User</a>
        </div>
        <div class="list">
            <div class="list-item user">
                <h3>New User</h3>
                <br />
                <form action="user-add_post.php" method="post">
                    <b>Username</b><br />
                    <input type="text" name="username" style="width: 760px;" /><br />
                    <br />
                    <b>Password</b><br />                    
                    <input type="text" name="password" style="width: 760px;" /><br />
                    <br />
                    <b>Email</b><br />                    
                    <input type="text" name="email" style="width: 760px;" /><br />
                    <br />
                    <br />
                    <button type="submit" class="button">
                        <span>Create User</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
<?php include "footer.php"; ?>
