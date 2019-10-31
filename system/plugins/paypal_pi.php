<?php



/**
 * paypal Plugin
 *
 * @package		CodeIgniter
 * @subpackage	Plugin
 * @category	Plugin
 * @author		soumya
 * @link		http://ahischools.com/user/course
 */

// ------------------------------------------------------------------------

/** DoDirectPayment NVP example; last modified 08MAY23.
 *
 *  Process a credit card payment. 
*/

// or 'beta-sandbox' or 'live'

/**
 * Send HTTP POST Request
 *
 * @param	string	The API method name
 * @param	string	The POST Message fields in &name=value pair format
 * @return	array	Parsed HTTP Response body
 */
function PPHttpPost($methodName_, $nvpStr_) {
	$CI =& get_instance();		
     if($CI->config->item('paypal_type') == "test"){
		$environment = 'sandbox';	
		// Set up your API credentials, PayPal end point, and API version.
		$API_UserName = urlencode('soniya_1255589104_biz_api1.gmail.com');
		$API_Password = urlencode('1255589110');
		$API_Signature = urlencode('AFcWxV21C7fd0v3bYYYRCpSSRl31AAx69kqDcs2pTwG1I2JSajY3gFY1');
		//$API_Endpoint = "https://api-3t.paypal.com/nvp";
		if("sandbox" === $environment || "beta-sandbox" === $environment) {
			$API_Endpoint = "https://api-3t.$environment.paypal.com/nvp";
		}
		
	}
 	if($CI->config->item('paypal_type') == "live"){
		// Set up your API credentials, PayPal end point, and API version.
		$API_UserName = urlencode('kartik_api1.adhischools.com');
		$API_Password = urlencode('2QWMFM5V7LB83E3W');
		$API_Signature = urlencode('AEQ0B-bj-C4cFjmk6QQC2c9UNNzHAabm9ckE5SJ08Bv9qfuoGeG6cMon');
		$API_Endpoint = "https://api-3t.paypal.com/nvp";
	}

	$version = urlencode('51.0');

	// Set the curl parameters.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);

	// Turn off the server and peer verification (TrustManager Concept).
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);

	// Set the API operation, version, and API signature in the request.
	$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";

	// Set the request as a POST FIELD for curl.
	curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

	// Get response from the server.
	$httpResponse = curl_exec($ch);

	if(!$httpResponse) {
		exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
	}

	// Extract the response details.
	$httpResponseAr = explode("&", $httpResponse);

	$httpParsedResponseAr = array();
	foreach ($httpResponseAr as $i => $value) {
		$tmpAr = explode("=", $value);
		if(sizeof($tmpAr) > 1) {
			$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
		}
	}

	if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
		exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
	}

	return $httpParsedResponseAr;
}
?>