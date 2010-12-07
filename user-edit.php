<?php

    require "config.php";
    require "utils.php";
    require_once "security.php";
    
    authorize();
    
    $con = mysql_connect($Server, $Username, $Password);
    if (!$con)
    {
        die("Could not connect: " . mysql_error());
    }

    mysql_select_db($Database, $con);   
    
    if ($_SERVER[REQUEST_METHOD] === "POST")
    {
        $result = mysql_query("SELECT * FROM user WHERE id = '$_GET[id]'");
        $user = mysql_fetch_array($result);
        
        $now = date("Y-m-d H:i:s");
        $nowlcl = date("Y-m-d H:i:s", strtotime("+3 hour", strtotime($now)));

        if (md5($_POST[currentpassword]) == $user[password])
        {
            if ($user[newpassword] == $user[newpasswordconfirm])
            {
                $sql = "UPDATE user SET username = '" . mysql_real_escape_string($_POST[username]) . "', password = '" . md5(mysql_real_escape_string($_POST[newpassword])) . "', email = '" . mysql_real_escape_string($_POST[email]) . "' WHERE id = '$_GET[id]'";
                if (!mysql_query($sql,$con))
                {
                    die('Error: ' . mysql_error());
                }
            }
        }
        else
        {
            $sql = "UPDATE user SET username = '" . mysql_real_escape_string($_POST[username]) . "', email = '" . mysql_real_escape_string($_POST[email]) . "' WHERE id = '$_GET[id]'";
            if (!mysql_query($sql,$con))
            {
                die('Error: ' . mysql_error());
            }
        }
        
        mysql_close($con);
        
        header("Location: user-edit.php?id=$_GET[id]&success=true");
        exit;
    }
    
    $result = mysql_query("SELECT * FROM user WHERE id = '$_GET[id]'");
    $user = mysql_fetch_array($result);
    
?>
<?php include "header.php"; ?>
    <?php SetPageTitle($user[username]); ?>
    <div class="content">
        <div class="navigation">
            <a href="index.php">Home</a> / <a href="settings.php">Settings</a> / <a href="user.php">Users</a> / <a href="user-edit.php?id=<?php echo $user[id]; ?>"><?php echo $user[username]; ?></a>
        </div>
        <div class="list">
            <form id="user-edit" action="<?php echo $_SERVER[PHP_SELF]; ?>?id=<?php echo $user[id]; ?>" method="post">
                <div class="list-item user">
                    <h3>Edit User</h3>
                    <br />
                    <b>Username</b><br />
                    <input type="text" name="username" style="width: 710px;" value="<?php echo $user[username]; ?>" /><br />
                    <br />
                    <b>Email</b><br />                    
                    <input type="text" name="email" style="width: 710px;" value="<?php echo $user[email]; ?>" /><br />
                    <br />
                    <br />
                    <b>Current Password</b><br />                    
                    <input type="password" name="currentpassword" style="width: 710px;" /><br />
                    <br />
                    <br />
                    <b>New Password</b><br />                    
                    <input type="password" name="newpassword" style="width: 710px;" /><br />
                    <br />
                    <b>Confirm New Password</b><br />                    
                    <input type="password" name="newpasswordconfirm" style="width: 710px;" /><br />
                </div>
                <br />
                <button type="submit" class="button">
                    <span>Save User</span>
                </button>
                <button type="button" class="button" onclick="confirm('Are you sure you want to delete this user?') ? location.href='user-delete.php?id=<?php echo $_GET[id]; ?>' : false;">
                    <span>Delete</span>
                </button>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        
        $("#user-edit").submit(function validate() {
            var formData = $("#user-edit").serializeArray();
            for (var i=0; i < formData.length; i++) { 
                if (!formData[i].value) { 
                    $(document).showMessage({
                        thisMessage: ["Please complete all fields, check your input, and try again."],
                        className: "error",
                        opacity: 80,
                        displayNavigation: false,
                        autoClose: true,
                        delayTime: 5000
                    });
                    
                    return false;
                }
            }
        });
        
        <?php
    
            if (isset($_GET[success]) == true)
            {
        
        ?>    
        $(document).ready(function() { 
            $(document).showMessage({
            thisMessage: ["This user has been updated successfully!"],
            className: "success",
            opacity: 80,
            displayNavigation: false,
            autoClose: true,
            delayTime: 5000
            });
        });    
        <?php
    
            }
            
        ?>
    </script>
<?php include "footer.php"; ?>
