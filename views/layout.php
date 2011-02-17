<!DOCTYPE html> 
<html lang="en">
<head> 
    <meta charset="utf-8" /> 
    <title>Issuebox - <?=$title?></title> 
    <link rel="stylesheet" type="text/css" media="screen,projection" href="/public/css/layout.css" />
    <link rel="shortcut icon" type="image/x-icon" href="/public/img/logo.ico">
    <script type="text/javascript" src="/public/js/jquery/jquery-1.4.4.js"></script>
    <script type="text/javascript" src="/public/js/form/jquery.form.js"></script>
    <script type="text/javascript" src="/public/js/showMessage/jquery.showMessage-2.1.js"></script>
    <script type="text/javascript" src="/public/js/scrollTo/jquery.scrollTo.js"></script>
    <script type="text/javascript" src="/public/js/truncator/jquery.truncator.js"></script>
    <script type="text/javascript" src="/public/js/css_browser_selector/css_browser_selector.js"></script>
    <script type="text/javascript" src="/public/js/github-flavored-markdown/scripts/showdown.js"></script>
    <script type="text/javascript" src="/public/js/common.js"></script>
</head> 
<body> 
    <div class="toolbar">
        <table class="toolbar-menu" cellpadding="0" cellspacing="0">
            <tr>
                <td valign="middle" align="left">
                    <?php
                        
                        if ($_SERVER[REQUEST_URI] == "/" ||
                            strpos($_SERVER[REQUEST_URI], "/project") === 0 ||
                            strpos($_SERVER[REQUEST_URI], "/issue") === 0) {
                            echo "<a href='/' class='selected'>Projects</a>\n";
                        } else {
                            echo "<a href='/'>Projects</a>\n";
                        }
                        
                        if (strpos($_SERVER[REQUEST_URI], "/activity") === 0) {
                            echo "<a href='/activity' class='selected'>Activity</a>\n";
                        } else {
                            echo "<a href='/activity'>Activity</a>\n";
                        }
                        
                        if (strpos($_SERVER[REQUEST_URI], "/user") === 0) {
                            echo "<a href='/user' class='selected'>Users</a>\n";
                        } else {
                            echo "<a href='/user'>Users</a>\n";
                        }
                        
                    ?>
                </td>
                <td valign="middle" align="right">
                    <a href="/user/<?php echo $_SESSION[CurrentUser_ID]; ?>"><?php echo $_SESSION[CurrentUser_Username]; ?></a>
                    <a href="/logout">Logout</a>
                </td>
            </tr>
        </table>
    </div>
    <div class="header">
        <table cellpadding="0" cellspacing="0"> 
            <tr valign="middle">
                <td>
                    &nbsp;<a href="/">Issuebox</a>
                </td>
            </tr>
        </table>
    </div>
    <?=$content?>
    <div class="footer">
        <a href="/">Issuebox</a> is built by <a href="http://www.mccormicktechnologies.com/" target="_blank">McCormick Technologies</a>. Version <?=Version?>.
    </div>
    <div id="arrow-top" style="display: none;">
        &#9650;
    </div>
</body> 
</html>