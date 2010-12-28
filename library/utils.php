<?php

    function FriendlyDate($levels = 2, $date1)
    { 
        $blocks = array( 
            array('name'=>'year','amount' => 60*60*24*365), 
            array('name'=>'month','amount' => 60*60*24*31), 
            array('name'=>'week','amount' => 60*60*24*7), 
            array('name'=>'day','amount' => 60*60*24), 
            array('name'=>'hour','amount' => 60*60), 
            array('name'=>'minute','amount' => 60), 
            array('name'=>'second','amount' => 1) 
        ); 
        
        $date2 = time();
        $diff = abs($date1-$date2); 
        
        $current_level = 1; 
        $result = array(); 
        foreach($blocks as $block) 
            { 
            if ($current_level > $levels) {break;} 
            if ($diff/$block['amount'] >= 1) 
                { 
                $amount = floor($diff/$block['amount']); 
                if ($amount>1) {$plural='s';} else {$plural='';} 
                $result[] = $amount.' '.$block['name'].$plural; 
                $diff -= $amount*$block['amount']; 
                $current_level++; 
                } 
            } 
        return implode(' ',$result).' ago'; 
    }
    
    function FriendlyString($string, $length = 180)
    {
        if (strlen($string) > $length)
            return substr($string, 0, ($length - 3)) . "...";
        else
            return $string;
    }
    
    function LogActivity($itemtype = 0, $itemid = 0, $actiontype = 0)
    {
        $headline = "";
        $description = "";
        
        if ($itemtype == "1")
        {
            $sql = mysql_query("SELECT * FROM project WHERE id = '$itemid'");
            $project = mysql_fetch_array($sql);
            
            if ($actiontype == "1")
            {
                $headline = "created project <a href='/project/$project[id]'>" . $project[name] . "</a>";
            }
            else if ($actiontype == "2")
            {
                $headline = "updated project <a href='/project/$project[id]'>" . $project[name] . "</a>";
            }
            
            $description = $project[description];
        }
        else if ($itemtype == "2")
        {
            $sql = mysql_query("SELECT * FROM issue WHERE id = '$itemid'");
            $issue = mysql_fetch_array($sql);
            
            $sql = mysql_query("SELECT * FROM project WHERE id = '$issue[projectid]'");
            $project = mysql_fetch_array($sql);
            
            if ($actiontype == "1")
            {
                $headline = "created <a href='/issue/$issue[id]'>issue " . $issue[number] . "</a> on <a href='/project/$project[id]'>" . $project[name] . "</a>";
            }
            else if ($actiontype == "2")
            {
                $headline = "updated <a href='/issue/$issue[id]'>issue " . $issue[number] . "</a> on <a href='/project/$project[id]'>" . $project[name] . "</a>";
            }
            
            $description = $issue[body];
        }
        else if ($itemtype == "3")
        {
            $sql = mysql_query("SELECT * FROM comment WHERE id = '$itemid'");
            $comment = mysql_fetch_array($sql);
            
            $sql = mysql_query("SELECT * FROM issue WHERE id = '$comment[issueid]'");
            $issue = mysql_fetch_array($sql);
            
            if ($actiontype == "1")
            {
                if ($issue[isclosed] == "1")
                    $headline = "closed <a href='/issue/$issue[id]'>issue " . $issue[number] . "</a>";
                else
                    $headline = "commented on <a href='/issue/$issue[id]'>issue " . $issue[number] . "</a>";
            }
            else if ($actiontype == "2")
            {
                if ($issue[isclosed] == "1")
                    $headline = "closed <a href='/issue/$issue[id]'>issue " . $issue[number] . "</a>";
                else
                    $headline = "updated a comment on <a href='/issue/$issue[id]'>issue " . $issue[number] . "</a>";
            }
            
            $description = $comment[body];
        }

        $now = date("Y-m-d H:i:s");
        $sql = "INSERT INTO activity (headline, description, itemid, itemtype, actiontype, createdby, createddate) VALUES
                    ('" . mysql_real_escape_string($headline) . "', '" . mysql_real_escape_string($description) . "', '$itemid', '$itemtype', '$actiontype', '" . $_SESSION["CurrentUser_ID"] . "', '$now')";
        if (!mysql_query($sql))
        {
            die('Error: ' . mysql_error());
        }
    }
    
    function PurgeActivity($itemtype, $itemid)
    {
        $sql = "DELETE FROM activity WHERE itemtype = '$itemtype' AND itemid = '$itemid'";    
        if (!mysql_query($sql))
        {
            die('Error: ' . mysql_error());
        }
    }
    
    function StartsWith($haystack, $needle, $case=true)
    {
        if ($case) 
        {
            return (strcmp(substr($haystack, 0, strlen($needle)), $needle)===0);
        }
        return (strcasecmp(substr($haystack, 0, strlen($needle)), $needle)===0);
    }
    
    function RetrieveSetting($key)
    {
        $sql = mysql_query("SELECT * FROM setting WHERE name = '$key'");
        $setting = mysql_fetch_array($sql);
        return $setting[value];
    }
    
?>