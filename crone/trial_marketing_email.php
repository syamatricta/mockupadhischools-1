<?php
$url = 'http://www.adhischools.com/trial_account/maketing_email';
$ch 	= curl_init($url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION ,1); 
curl_setopt($ch, CURLOPT_HEADER      	,0);  // DO NOT RETURN HTTP HEADERS 
curl_setopt($ch, CURLOPT_RETURNTRANSFER ,1);  // RETURN THE CONTENTS OF THE CALL
$result = curl_exec($ch);
curl_close($ch);
?>
