<?php
    
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
    <div class="header">
        <a href="index.php">Issue Tracker</a>
    </div>
    <?php 
    
        if ($CurrentUser_ID != null)
        {
        
    ?>
    <div class="toolbar">
        <img src="http://www.gravatar.com/avatar/<?php echo md5($CurrentUser_Email); ?>?s=15" />&nbsp;<?php echo $CurrentUser_Username; ?>&nbsp;<a href="logout.php">Logout</a>
    </div>
    <?php
    
        }
        
    ?>