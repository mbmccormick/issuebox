<?php

    function comment_add_post()
    {
        Security_Authorize();
        
        if (isset($_POST[commentandclose]) == true)
        {
            $sql = "UPDATE issue SET isclosed='1' WHERE id='$_GET[issueid]'";
            mysql_query($sql);
        }
        
        $now = date("Y-m-d H:i:s");
        
        $sql = "INSERT INTO comment (issueid, body, createdby, createddate) VALUES
                ('$_GET[issueid]', '" . mysql_real_escape_string($_POST[body]) . "', '$_SESSION[CurrentUser_ID]', '" . $now . "')";
        mysql_query($sql);
        
        $sql = mysql_query("SELECT * FROM comment WHERE id='" . mysql_insert_id() . "'");
        $result = mysql_fetch_array($sql);
        
        $sql = mysql_query("SELECT * FROM user WHERE id='$result[createdby]'");
        $user = mysql_fetch_array($sql);
        
        mysql_close($con);
        
        LogActivity(3, $result[id], 1);
        
        if ($_POST[returnObject] == "true")
        {
            if (isset($_POST[commentandclose]) == true)
            {
                echo "<div id='issue-closed'></div>\n";
            }
            echo "<div class='list-item comment'>\n";
                            
            echo "<div id='comment$result[id]' class='wikiStyle'>" . $result[body] . "</div>\n";
            echo "<br />\n";
            echo "<div class='options'>\n";
            echo "<a class='minibutton minidanger' postback='/comment/$result[id]/delete&issueid=$result[issueid]'><span>Delete</span></a>\n";
            echo "&nbsp;&nbsp;" . date("F j, Y", strtotime($result[createddate]));
            echo " by <a href='/user/$user[id]'>$user[username]</a>";
            echo "</div>\n";
            
            echo "</div>\n";
        }
        else
        {
            header("Location: /issue/$_GET[issueid]");
            exit;
        }
    }
    
    function comment_delete()
    {
        Security_Authorize();
    
        $sql = "DELETE FROM comment WHERE id='" . params('id') . "'";    
        mysql_query($sql);
        
        PurgeActivity(3, params('id'));
        
        header("Location: /issue/$_GET[issueid]&success=Your comment was deleted successfully!");
        exit;
    }

?>