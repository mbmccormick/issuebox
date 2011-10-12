<!DOCTYPE html> 
<html lang="en">
<head> 
    <meta charset="utf-8" /> 
    <title>Issuebox - <?=$title?></title> 
    <link rel="stylesheet" type="text/css" media="screen,projection" href="<?=option('base_uri')?>public/css/layout.css" />
    <link rel="shortcut icon" type="image/x-icon" href="<?=option('base_uri')?>public/img/logo.ico">
    <script type="text/javascript" src="<?=option('base_uri')?>public/js/jquery/jquery-1.4.4.js"></script>
    <script type="text/javascript" src="<?=option('base_uri')?>public/js/form/jquery.form.js"></script>
    <script type="text/javascript" src="<?=option('base_uri')?>public/js/showMessage/jquery.showMessage-2.1.js"></script>
    <script type="text/javascript" src="<?=option('base_uri')?>public/js/scrollTo/jquery.scrollTo.js"></script>
    <script type="text/javascript" src="<?=option('base_uri')?>public/js/truncator/jquery.truncator.js"></script>
    <script type="text/javascript" src="<?=option('base_uri')?>public/js/css_browser_selector/css_browser_selector.js"></script>
    <script type="text/javascript" src="<?=option('base_uri')?>public/js/github-flavored-markdown/scripts/showdown.js"></script>
    <script type="text/javascript" src="<?=option('base_uri')?>public/js/common.js"></script>
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
    <script type="text/javascript">
      var uservoiceOptions = {
        key: 'issuebox',
        host: 'issuebox.uservoice.com', 
        forum: '103387',
        alignment: 'left',
        background_color:'#000000', 
        text_color: 'white',
        hover_color: '#0066CC',
        lang: 'en',
        showTab: true
      };
      function _loadUserVoice() {
        var s = document.createElement('script');
        s.src = ("https:" == document.location.protocol ? "https://" : "http://") + "cdn.uservoice.com/javascripts/widgets/tab.js";
        document.getElementsByTagName('head')[0].appendChild(s);
      }
      _loadSuper = window.onload;
      window.onload = (typeof window.onload != 'function') ? _loadUserVoice : function() { _loadSuper(); _loadUserVoice(); };
    </script>
</body> 
</html>