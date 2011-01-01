<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" dir=ltr lang=en-US> 
<head> 
  <title>Issuebox - <?=$title?></title> 
  <link rel="stylesheet" type="text/css" media="screen,projection" href="/public/css/stylesheet.css" />
  <script type="text/javascript" src="/public/js/jquery/jquery-1.4.4.js"></script>
  <script type="text/javascript" src="/public/js/form/jquery.form.js"></script>
  <script type="text/javascript" src="/public/js/showMessage/jquery.showMessage-2.1.js"></script>
  <script type="text/javascript" src="/public/js/css_browser_selector/css_browser_selector.js"></script>
  <script type="text/javascript" src="/public/js/github-flavored-markdown/scripts/showdown.js"></script>
  <script type="text/javascript" src="/public/js/common.js"></script>
</head> 
<body> 
    <?php
    
        if ($_SESSION[CurrentUser_ID] != null)
        {
        
    ?>
    <div class="toolbar">
        <table class="toolbar-menu" cellpadding="0" cellspacing="0">
            <tr>
                <td valign="middle">
                    <img src="http://www.gravatar.com/avatar/<?php echo md5($_SESSION[CurrentUser_Email]); ?>?s=20" style="border: 1px solid white; margin-right: 3px; margin-top: 3px;" />&nbsp;
                </td>
                <td valign="middle">
                    <a href="/user/<?php echo $_SESSION[CurrentUser_ID]; ?>" style="color: #000000;"><?php echo $_SESSION[CurrentUser_Username]; ?></a>&nbsp;&nbsp;/&nbsp;&nbsp;<a href="/logout">Logout</a>
                </td>
            </tr>
        </table>
    </div>
    <?php
    
        }
        
    ?>
    <div class="header">
        <table cellpadding="0" cellspacing="0"> 
            <tr valign="middle">
                <td>
                    <img src="/public/img/logo.png" />
                </td>
                <td>
                    &nbsp;<a href="/">Issuebox</a>
                </td>
            </tr>
        </table>
    </div>
    <?=$content?>
    <div class="footer">
        Issuebox is built by <a href="http://www.mccormicktechnologies.com/" target="_blank">McCormick Technologies</a>. Version <?=$Version?>.
    </div>
</body> 
</html>