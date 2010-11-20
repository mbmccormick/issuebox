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
    <?php 
    
        if ($CurrentUser_ID != null)
        {
        
    ?>
    <div class="toolbar">
        <table class="toolbar-menu" cellpadding="0" cellspacing="0">
            <tr>
                <td valign="middle">
                    <img src="http://www.gravatar.com/avatar/<?php echo md5($CurrentUser_Email); ?>?s=20" />&nbsp;
                </td>
                <td valign="middle">
                    <?php echo $CurrentUser_Username; ?>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="logout.php">Logout</a>
                </td>
            </tr>
        </table>
    </div>
    <?php
    
        }
        
    ?>
    <div class="header">
        <a href="index.php">Issue Tracker</a>
    </div>