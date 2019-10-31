<?php
#require('/home/adhischools/public_html/system/application/config/siteconfig.php');
//$url	= $config['site_baseurl'].'exam/update_exam_ongoing';
$url = 'http://www.adhischools.com/exam/update_exam_ongoing';
$ch 	= curl_init($url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION ,1); 
curl_setopt($ch, CURLOPT_HEADER      	,0);  // DO NOT RETURN HTTP HEADERS 
curl_setopt($ch, CURLOPT_RETURNTRANSFER ,1);  // RETURN THE CONTENTS OF THE CALL
$result = curl_exec($ch);
curl_close($ch);
?>
