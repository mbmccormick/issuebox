<?php

    function hook_git_post()
    {
        $payload = $_POST[payload];
        $data = json_decode(stripslashes($payload));
        
        if(is_object($data) && is_array($data->commits))
        {
            foreach($data->commits as $commit)
            {
                if(strpos("#issuebox", $commit->message) !== false)
                {
                    $issueid = substr($commit->message, strpos("#issuebox", $commit->message));
                    
                    $commentBody = trim(str_replace("#issuebox" . $issueid, "", $commit->message));
                    
                    $result = mysql_query("SELECT * FROM user WHERE email='" . $commit->author->email . "'");
                    $row = mysql_fetch_array($result);
                    $userid = $row[id];
                    
                    $sql = "UPDATE issue SET isclosed = '1' WHERE id='$issueid'";
                    mysql_query($sql);
                    
                    $now = date("Y-m-d H:i:s");
        
                    $sql = "INSERT INTO comment (issueid, body, createdby, createddate) VALUES
                            ('$issueid', '" . mysql_real_escape_string($commentBody) . "', '$userid', '" . $now . "')";
                    mysql_query($sql);
                    
                    LogActivity(3, mysql_insert_id(), 1);
                }
            }
        }
    }
    
    function hook_svn_post()
    {
    
    }

?>