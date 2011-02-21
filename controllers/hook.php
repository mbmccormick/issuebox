<?php

    function hook_git_post()
    {
        $payload = $_POST[payload];
        $data = json_decode($payload);
        
        $count = 0;
        foreach($data->commits as $commit)
        {
            if(strpos($commit->message, "#issuebox") !== false)
            {
                $issuenum = substr($commit->message, strpos($commit->message, "#issuebox") + 9);
                
                $commentBody = trim(str_replace("#issuebox" . $issuenum, "", $commit->message));
                
                $result = mysql_query("SELECT * FROM user WHERE email='" . $commit->author->email . "'");
                $row = mysql_fetch_array($result);
                $userid = $row[id];
                
                $_SESSION["CurrentUser_ID"] = $userid;
                
                $result = mysql_query("SELECT * FROM issue WHERE projectid='" . params('projectid') . "' AND number='$issuenum'");
                $row = mysql_fetch_array($result);
                $issueid = $row[id];
                
                $sql = "UPDATE issue SET isclosed='1' WHERE id='$issueid'";
                mysql_query($sql);
                
                $now = date("Y-m-d H:i:s");
    
                $sql = "INSERT INTO comment (issueid, body, createdby, createddate) VALUES
                    ('$issueid', '" . mysql_real_escape_string($commentBody) . "', '$userid', '" . $now . "')";
                mysql_query($sql);
                
                LogActivity(3, mysql_insert_id(), 1);
                
                $count = $count + 1;
                echo "Processing commit " . $commit->id . ".\n";
            }
        }
        
        echo "\n";
        echo "Processed $count of " . count($data->commits) . " commits.\n";
    }
    
    function hook_svn_post()
    {
        $payload = $_POST[payload];
        $data = json_decode($payload);
        
        $count = 0;
        foreach($data->commits as $commit)
        {
            if(strpos($commit->message, "#issuebox") !== false)
            {
                $issuenum = substr($commit->message, strpos($commit->message, "#issuebox") + 9);
                
                $commentBody = trim(str_replace("#issuebox" . $issuenum, "", $commit->message));
                
                $result = mysql_query("SELECT * FROM user WHERE email='" . $commit->author->email . "'");
                $row = mysql_fetch_array($result);
                $userid = $row[id];
                
                $_SESSION["CurrentUser_ID"] = $userid;
                
                $result = mysql_query("SELECT * FROM issue WHERE projectid='" . params('projectid') . "' AND number='$issuenum'");
                $row = mysql_fetch_array($result);
                $issueid = $row[id];
                
                $sql = "UPDATE issue SET isclosed='1' WHERE id='$issueid'";
                mysql_query($sql);
                
                $now = date("Y-m-d H:i:s");
    
                $sql = "INSERT INTO comment (issueid, body, createdby, createddate) VALUES
                    ('$issueid', '" . mysql_real_escape_string($commentBody) . "', '$userid', '" . $now . "')";
                mysql_query($sql);
                
                LogActivity(3, mysql_insert_id(), 1);
                
                $count = $count + 1;
                echo "Processing commit " . $commit->id . ".\n";
            }
        }
        
        echo "\n";
        echo "Processed $count of " . count($data->commits) . " commits.\n";
    }

?>