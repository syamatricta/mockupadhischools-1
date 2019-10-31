<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User clas in Codeigniter
 *
 * File contains class for Remote_file_exists
 *
 * @package		CodeIgniter
 * @author		Rainconcert Technologies (P) LTD.
 * @copyright	Copyright (c) 2012, Rainconcert Technologies.
 * @license		http://adhischools.com/license.html
 * @link		http://adhischools.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Remote file exists check class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Validation
 * @author		Rainconcert
 * @link		http://adhischools.com
 * 
 */
class Remote_file_exists 
{
	
	/**
	 * check for file exists
	 * 
	 * Function will check for the file existance
	 * @access public
	 * @param string $url
	 * @return Boolen $check
	 */
	public function check($url)
	{
		// Initialise curl
		$curl = curl_init($url);
		
		//don't fetch the actual page, you only want to check the connection is ok
    	curl_setopt($curl, CURLOPT_NOBODY, true);

    	//do request
    	$result = curl_exec($curl);

    	$check = false;

    	//if request did not fail
    	if ($result !== false) {
    		//if request was ok, check response code
    		$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  
			
    		// check fot status code
    		if ($statusCode == 200) {
    			$check = true;
    		}
    	}
		
    	// Close curl
    	curl_close($curl);
		
    	// return status
    	return $check;
	}
	
}

// END Remote file exists check class

/* End of file Remote_file_exists.php */
/* Location: ./application/libraries/Remote_file_exists.php */