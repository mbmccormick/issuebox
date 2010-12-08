<?php

    require "config.php";
    require "utils.php";
    require_once "security.php";

    if ($_SERVER[REQUEST_METHOD] === "POST")
    {
        if (login($_POST[username], $_POST[password]) == true)
        {
            header("Location: index.php");
            exit;
        }
        else
        {
            header("Location: login.php?msg=Please check your login credentials and try again.");
            exit;
        }
    }
    
?>
<?php include "header.php"; ?>
    <?php SetPageTitle("Login"); ?>
    <div class="content">
        <div class="navigation">
            <a href="login.php">Login</a>
        </div>
        <div class="standard-form">
            <h2>Login</h2>
            <br />
            <form action="<?php echo $_SERVER[PHP_SELF]; ?>" method="post">
                <label for="Username">
                    Username<br />
                    <input class="text" name="username" style="width: 25em;" type="text" />
                </label>
                <label for="password">
                    Password<br />
                    <input class="text" name="password" style="width: 25em;" type="password" />
                </label>
                <label>
                    <button type="submit" class="button">
                        <span>Log In</span>
                    </button>
                </label>
            </form>  
        </div>
        <div class="standard-form help">
            <b>Forget your password?</b><br />
            <br />
            <a href="password-reset.php">Click here to reset your password.</a>
        </div>
    </div>
    <?php if (isset($_GET[msg]) == true) { ?>
    <script type="text/javascript">
    
        $(document).ready(function() { 
            $(document).showMessage({
            thisMessage: ["<?php echo $_GET[msg]; ?>"],
            className: "error",
            opacity: 100,
            displayNavigation: false,
            autoClose: true,
            delayTime: 5000
            });
        });
    
    </script>
    <?php } ?>
<?php include "footer.php"; ?>