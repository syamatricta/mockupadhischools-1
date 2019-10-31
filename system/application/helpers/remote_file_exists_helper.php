<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Adhischools
 *
 * Adhischools.com
 *
 * @package		CodeIgniter
 * @author		Rainconcert Technologies
 * @copyright	Copyright (c) 2012, Rainconcert Technologies.
 * @license		http://adhischools/license.html
 * @link		http://cadhischools.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Array Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Rainconcert Technologies Dev Team
 * @link		
 */

// ------------------------------------------------------------------------

/**
 * Remote file exists
 *
 * Lets you determine whether the file exxists in remote location
 * *
 * @access	public
 * @param	string
 * @return	Boolean 
 */	

function remote_file_exists($filename, $videoUrl = "")
{
	//TODO Validate the file name using regular expression
	 	
	$ci = & get_instance();
	$ci->load->library('form_validation');
	
	// Get video location from config and generate new url
	if($videoUrl == "") {
		$videoUrl = $ci->config->item('quiz_video_location');	
	}
	
	// if video location not found show error
	if(!isset($videoUrl) || '' == $videoUrl) {
		//show_error('Video location config is missing');
		return FALSE;
	}
	
	// Validate file name
	if(empty($filename) || '' == $filename){
		//show_error('remote_file_exists(): Filename is missing  argument.');
		return FALSE;
	}
	
	$url = $videoUrl . rawurlencode(trim($filename));
	
	
	// Initialise curl
	$curl = curl_init($url);

	//don't fetch the actual page, you only want to check the connection is ok
    curl_setopt($curl, CURLOPT_NOBODY, TRUE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    //do request
    $result = curl_exec($curl);
    $check = FALSE;

    //if request did not fail
    if ($result !== FALSE) {
    	//if request was ok, check response code
    	$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  
			
    	// check fot status code
    	if ($statusCode == 200) {
    		$check = TRUE;
    	}
    }
		
    // Close curl
    curl_close($curl);
    
    return $check;
}

/**
 * check for allowed extensions
 * 
 */
function check_allowed_extensions($filename)
{
	$ci = & get_instance();
	$extension = strtolower(file_extension($filename));
	
	if(in_array($extension, $ci->config->item('video_extensions'))){
		return TRUE;
	} else {
		return FALSE;
	}
	
}
