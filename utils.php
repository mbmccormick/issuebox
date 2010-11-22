<?php

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
    
?>