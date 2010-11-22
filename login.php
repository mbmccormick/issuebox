<?php

    require "config.php";
    require_once "security.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" dir=ltr lang=en-US> 
<head> 
  <title>Issue Tracker</title> 
  <link rel="stylesheet" type="text/css" media="screen,projection" href="css/stylesheet.css" />
  <script type="text/javascript" src="js/css_browser_selector/css_browser_selector.js"></script>
  <script type="text/javascript" src="js/github-flavored-markdown/scripts/showdown.js"></script>
</head> 
<body> 
    <div class="header" id="login-header">
    </div>
    <div class="content">
        <div id="login" class="standard_form">
            <h2><a href="index.php">Issue Tracker</a></h2>
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
    <div class="footer" id="login-footer">
        Copyright &copy; 2010 McCormick Technologies LLC. All rights reserved.
    </div>
</body> 
</html>