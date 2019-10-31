<?php
$base_path = dirname(dirname(__FILE__));
// Calling db configurations
include($base_path."/crone/db.php");

/**
 * Cron job to end quiz, to maintain the correct count
 * 
 */

// Get current time - one hour
$oneHourBack = convert_UTC_to_PST_timeonly() - 3600;
	
// Update adhi_user_quiz where quiz_time less than current time minus one hour and quiz_status =0
$sql = 'UPDATE adhi_user_quiz SET quiz_status = 1 '
     . ' WHERE quiz_time < ' . $oneHourBack . ' AND quiz_status = 0 ';
        
$result = mysqli_query($mysql_con, $sql);
$count = mysqli_affected_rows($mysql_con);
mysqli_close($mysql_con);
	     //print_r($result);
	     
if($result){
	echo $count.' rows Updated';
} else {
	echo "Failed";
}

/**
 * get current time in PST
 * 
 * @access public
 * @param void
 * @return string $covertime
 */
function convert_UTC_to_PST_timeonly()
{
	$covertime = time() - (8 * 60 * 60);
	return $covertime;
}

?>