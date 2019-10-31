<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Crashcourse
 *
 * crashcourseonline.com
 *
 * @package		CodeIgniter
 * @author		Rainconcert Technologies
 * @copyright	Copyright (c) 2012, Rainconcert Technologies.
 * @license		http://crashcourseonline.com/license.html
 * @link		http://crashcourseonline.com
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
 * Input helpers
 *
 * Helper functions for form elements without validation
 * *
 * @access	public
 * @param	string
 * @return	Boolean 
 */	

function set_value_without_validation($field, $default = '')
{
	if(!isset($_POST[$field])) {
		return $default;
	} else {
		return $_POST[$field];
	}
}