<?php

    function setting_list()
    {
        Security_Authorize();
        
        set("title", "Settings");
        return html("setting/list.php");
    }

?>