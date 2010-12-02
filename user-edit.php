<?php

    require "config.php";
    require_once "security.php";
    
    authorize();
    
    $con = mysql_connect($Server, $Username, $Password);
    if (!$con)
    {
        die("Could not connect: " . mysql_error());
    }

    mysql_select_db($Database, $con);   
    
    $result = mysql_query("SELECT * FROM user WHERE id = '$_GET[id]'");
    $user = mysql_fetch_array($result);
    
?>
<?php include "header.php"; ?>
    <div class="content">
        <div class="navigation">
            <a href="index.php">Home</a> / <a href="settings.php">Settings</a> / <a href="user.php">Users</a> / <a href="user-edit.php?id=<?php echo $user[id]; ?>"><?php echo $user[username]; ?></a>
        </div>
        <div class="list">
            <form action="user-edit_post.php?id=<?php echo $user[id]; ?>" method="post">
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
                <button type="button" class="button" onclick="confirm('Are you sure you want to delete this user?') ? location.href='user-delete_post.php?id=<?php echo $_GET[id]; ?>' : false;">
                    <span>Delete</span>
                </button>
            </form>
        </div>
    </div>
<?php include "footer.php"; ?>
