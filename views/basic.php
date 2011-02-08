<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" dir=ltr lang=en-US> 
<head> 
    <title>Issuebox - <?=$title?></title> 
    <link rel="stylesheet" type="text/css" media="screen,projection" href="/public/css/basic.css" />
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
    <?=$content?>
    <div class="footer">
        Issuebox is built by <a href="http://www.mccormicktechnologies.com/" target="_blank">McCormick Technologies</a>. Version <?=Version?>.
    </div>
    <div id="arrow-top" style="display: none;">
        &#9650;
    </div>
</body> 
</html>