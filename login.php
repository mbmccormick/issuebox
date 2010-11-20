<?php

    require "config.php";

?>
<?php include "header.php"; ?>
    <div class="content">
        <div id="login" class="standard_form">
            <form action="login_post.php" method="post">
                <h3>Log in</h3>
                <label for="Username">
                    Username<br />
                    <input class="text" name="username" style="width: 25em;" type="text">
                </label>
                <label for="password">
                    Password<br />
                    <input class="text" name="password" style="width: 25em;" type="password">
                </label>
                <label>
                    <input type="submit" value="Log in">
                </label>
            </form>  
        </div>
    </div>
<?php include "footer.php"; ?>
