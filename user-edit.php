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
            <a href="settings.php">Settings</a> / <a href="user.php">Users</a> / <a href="user-edit.php?id=<?php echo $user[id]; ?>"><?php echo $user[username]; ?></a>
        </div>
        <div class="list">
            <div class="list-item user">
                <h3>Edit User</h3>
                <br />
                <form action="user-edit_post.php?id=<?php echo $user[id]; ?>" method="post">
                    <b>Username</b><br />
                    <input type="text" name="username" style="width: 760px;" value="<?php echo $user[username]; ?>" /><br />
                    <br />
                    <b>Password</b><br />                    
                    <input type="text" name="password" style="width: 760px;" value="<?php echo $user[password]; ?>" /><br />
                    <br />
                    <b>Email</b><br />                    
                    <input type="text" name="email" style="width: 760px;" value="<?php echo $user[email]; ?>" /><br />
                    <br />
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
    </div>
<?php include "footer.php"; ?>
