<?php

    function setting_list()
    {
        Security_Authorize();
        
        set("title", "Settings");
        return html("setting/list.php");
    }
    
    function setting_email()
    {
        Security_Authorize();
        
        set("title", "Email Configuration");
        return html("setting/email.php");
    }
    
    function setting_email_post()
    {
        Security_Authorize();
        
        $sql = "UPDATE setting SET value = '" . mysql_real_escape_string($_POST[outgoingEmailAddress]) . "' WHERE name = 'ContactEmailAddress'";
        mysql_query($sql);
        
        header("Location: /settings&success=Your settings were saved successfully!");
        exit;
    }

?>