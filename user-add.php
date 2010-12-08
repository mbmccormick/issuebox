<?php

    require "config.php";
    require "utils.php";
    require_once "security.php";
    
    authorize();
    
    if ($_SERVER[REQUEST_METHOD] === "POST")
    {
        $con = mysql_connect($Server, $Username, $Password);
        if (!$con)
        {
            die("Could not connect: " . mysql_error());
        }

        mysql_select_db($Database, $con);
        
        
        $now = date("Y-m-d H:i:s");
        
        if ($user[password] == $user[passwordconfirm])
        {
            $sql = "INSERT INTO user (username, password, email, createddate) VALUES
                    ('" . mysql_real_escape_string($_POST[username]) . "', '" . md5(mysql_real_escape_string($_POST[password])) . "', '" . mysql_real_escape_string($_POST[email]) . "', '" . $now . "')";
            if (!mysql_query($sql,$con))
            {
                die('Error: ' . mysql_error());
            }
        }
        else
        {
            header("Location: user-add.php?msg=Your passwords do not match!");
            exit;
        }
        
        mysql_close($con);
        
        header("Location: user.php");
        exit;
    }
    
?>
<?php include "header.php"; ?>
    <?php SetPageTitle("New User"); ?>
    <div class="content">
        <div class="navigation">
            <a href="settings.php">Settings</a> / <a href="user.php">Users</a> / <a href="user-add.php">New User</a>
        </div>
        <div class="list">
            <form id="user-new" action="<?php echo $_SERVER[PHP_SELF]; ?>" method="post">
                <div class="list-item user">
                    <h3>New User</h3>
                    <br />
                    <b>Username</b><br />
                    <input type="text" name="username" style="width: 710px;" /><br />
                    <br />
                    <b>Email</b><br />                    
                    <input type="text" name="email" style="width: 710px;" /><br />
                    <br />
                    <br />
                    <b>Password</b><br />                    
                    <input type="password" name="password" style="width: 710px;" /><br />
                    <br />
                    <b>Confirm Password</b><br />                    
                    <input type="password" name="passwordconfirm" style="width: 710px;" /><br />
                </div>
                <br />
                <button type="submit" class="button">
                    <span>Create User</span>
                </button>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        
        $("#user-new").submit(function validate() {
            var formData = $("#user-new").serializeArray();
            for (var i=0; i < formData.length; i++) { 
                if (!formData[i].value) { 
                    $(document).showMessage({
                        thisMessage: ["Please complete all fields, check your input, and try again."],
                        className: "error",
                        opacity: 95,
                        displayNavigation: false,
                        autoClose: true,
                        delayTime: 5000
                    });
                    
                    return false;
                }
            }
        });
        
    </script>
<?php include "footer.php"; ?>
