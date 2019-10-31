<?php 
	function convert_UTC_to_PST_datetime($datetime){
		$convertdatetime = date('Y-m-d H:i:s',strtotime($datetime.'-8 hour'));
		return $convertdatetime;
	}
        
        function convert_UTC_to_PST_date($datetime){
		$convertdate = date('Y-m-d',strtotime($datetime.'-8 hour'));
		return $convertdate;
	}

    function time_diff_conv($start, $s) {
        $string = '';
        $t = array( //suffixes
            'd' => 86400,
            'h' => 3600,
            'm' => 60,
        );
        $s = abs($s - $start);
        foreach($t as $key => &$val) {
            $$key = floor($s/$val);
            $s -= ($$key*$val);
            $string .= ($$key==0) ? '' : $$key . "$key ";
        }
        return $string . $s. 's';
    }
    
    function find_date_diff ($date1, $date2) {
        $date1 = date('Y-m-d', strtotime($date1));
        $date2 = date('Y-m-d', strtotime($date2));
        $checkdate1 = strtotime($date1);
        $checkdate2 = strtotime($date2);
        $dateDiff = $checkdate1 - $checkdate2;
        $fullDays = floor($dateDiff / (60 * 60 * 24));
        return $fullDays;
    }
?>