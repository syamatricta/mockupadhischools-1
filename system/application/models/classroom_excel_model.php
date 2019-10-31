<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * Model class file
 *
 * Model class for classroom excel videos
 *
 * @package 	Adhischools
 * @author		Rainconcert Technologies (P) LTD.
 * @copyright	Copyright (c) 2012, Rainconcert Technologies.
 * @license		http://adhischools.com/license.html
 * @link		http://adhischools.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Model class for classrom videos
 * class classroom_excel
 *
 * @package		CodeIgniter
 * @subpackage	Models
 * @category	Classroom_videos
 * @author		Rainconcert
 * @link		http://adhischools.com
 * 
 */
class Classroom_excel_model extends Model 
{
	/**
	 * insert to table
	 * @access public
	 * @param int $chapterId
	 * @param int $course_id
	 * @param string $excel_path
	 * @return mixed $result
	 */
	function insert_excel_info($course_id, $chapter_id, $excel_path)
	{
		// if chapter_id is not set then throw an exceprion
		if(!isset($course_id) || '' == $course_id
			|| !isset($chapter_id) || '' == $chapter_id
			|| !isset($excel_path) || '' == $excel_path) {
			show_error('Error on classroom excel model: Argument missing!');
		}
		
		// Insert to table
		$data = array(
			'quiz_id' => $chapter_id,
			'course_id' => $course_id,
			'excel_path' => $excel_path,
			'created_on' => convert_UTC_to_PST_datetime(date("Y-m-d H:i:s"))
		);
		
		$this->db->set($data);
		$this->db->insert('adhi_classroom_videos_xls');
		
		//get last inserted id
		$last_id = $this->db->insert_id();
		
		if(empty($last_id)) {
			return FALSE;
		}
		
		return $last_id;
	}
	
	
}