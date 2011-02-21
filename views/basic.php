<!DOCTYPE html> 
<html lang="en">
<head> 
    <meta charset="utf-8" /> 
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