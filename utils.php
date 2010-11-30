<?php

    function SetPageTitle($title)
    {
        echo "<script type='text/javascript'>\n";
        echo "document.title = '$title';\n";
        echo "</script>\n";
    }

    function FriendlyDate($levels = 2, $date1)
    { 
        $blocks = array( 
            array('name'=>'year','amount'    =>    60*60*24*365    ), 
            array('name'=>'month','amount'    =>    60*60*24*31    ), 
            array('name'=>'week','amount'    =>    60*60*24*7    ), 
            array('name'=>'day','amount'    =>    60*60*24    ), 
            array('name'=>'hour','amount'    =>    60*60        ), 
            array('name'=>'minute','amount'    =>    60        ), 
            array('name'=>'second','amount'    =>    1        ) 
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
    
    function FriendlyString($string, $length = 160)
    {
        if (strlen($string) > $length)
            return substr($string, 0, ($length - 3)) . "...";
        else
            return substr($string);
    }
    
    function LogActivity($itemtype = 0, $itemid = 0, $actiontype = 0)
    {
        try
        {
            require_once "config.php";
            require_once "security.php";

            $con = mysql_connect($Server, $Username, $Password);
            if (!$con)
            {
                die("Could not connect to $Server: " . mysql_error());
            }

            mysql_select_db($Database, $con);
        }
        catch (Exception $e)
        {
        }

        $now = date("Y-m-d H:i:s");
        $sql = "INSERT INTO activity (itemtype, itemid, actiontype, createdby, createddate) VALUES
                    ('$itemtype', '$itemid', '$actiontype', '$CurrentUser_ID', '$now')";
        if (!mysql_query($sql,$con))
        {
            die('Error: ' . mysql_error());
        }
    }
    
?>