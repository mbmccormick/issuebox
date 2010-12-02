<?php

    require "config.php";
    require_once "security.php";

?>
<?php include "header.php"; ?>
    <div class="content">
        <div class="navigation">
            <a href="login.php">Login</a>
        </div>
        <div class="standard-form">
            <h2>Login</h2>
            <br />
            <form action="login_post.php" method="post">
                <label for="Username">
                    Username<br />
                    <input class="text" name="username" style="width: 25em;" type="text" />
                </label>
                <label for="password">
                    Password<br />
                    <input class="text" name="password" style="width: 25em;" type="password" />
                </label>
                <label>
                    <input type="submit" value="Log in">
                </label>
            </form>  
        </div>
    </div>
<?php include "footer.php"; ?>