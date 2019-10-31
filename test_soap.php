<?php
echo 'Ready,';
$url = '/home/adhischools/public_html/wsdl/RateService_v10.wsdl';
$client     = new SoapClient($url, array("trace" => 1, "exception" => 0)); 

echo "<pre>".print_r($client)."</pre>"; 
?>
