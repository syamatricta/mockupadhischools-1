<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * Model class file
 *
 * Model class for classroom video watch list
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
 * Model class for lassroom video watch list
 * class classroom_videos
 *
 * @package		CodeIgniter
 * @subpackage	Models
 * @category	Classroom_video_watch_model
 * @author		Rainconcert
 * @link		http://adhischools.com
 * 
 */
class Classroom_video_watch_model extends Model 
{
	/**
	 * get by user id and videoid
	 * @access public
	 * @param integer $user_id
	 * @param integer $video_id
	 * @return mixed $result
	 */
	public function get_by_user_and_video($user_id, $video_id)
	{
		// validate arguments, if fails throw an exception
		if(!isset($user_id) || '' == $user_id || !isset($video_id) || '' == $video_id ){
			show_error('get_by_user_and_video(): Argument missing');   	
		}
		
		$this->db->where('user_id', $user_id);
		$this->db->where('video_id', $video_id);
		$query = $this->db->get('adhi_classroom_videos_watch_list');
		
		$result = $query->result();
		
		// if results then return result
		if(!empty($result)){
			return $result;
		}
		
		return FALSE;
	}
	
	/**
	 * inset to watched list
	 * @access public
	 * @param int $chapterId
	 * @return mixed $result
	 */
	public function add_to_watched($user_id, $video_id)
	{
		// validate arguments, if fails throw an exception
		if(!isset($user_id) || '' == $user_id || !isset($video_id) || '' == $video_id ){
			show_error('add_to_watched(): Argument missing');   	
		}
		
		$data = array(
			'video_id' => $video_id,
			'user_id' => $user_id,
			'watched_on' => convert_UTC_to_PST_datetime(date("Y-m-d H:i:s"))
		);
		
		$this->db->set($data);
		$this->db->insert('adhi_classroom_videos_watch_list');
		
		//get last inserted id
		$last_id = $this->db->insert_id();
		
		if(empty($last_id)) {
			return FALSE;
		}
		
		return $last_id;
	}
	
	/**
	 * 
	 * Remove from watched list
	 * @access public
	 * @param int $video_id
	 * @param int $user_id
	 * @return boolean $status
	 */
	public function remove_from_watched($user_id, $video_id)
	{
	// validate arguments, if fails throw an exception
		if(!isset($user_id) || '' == $user_id || !isset($video_id) || '' == $video_id ){
			show_error('remove_from_watched(): Argument missing');   	
		}
		
		$this->db->where('user_id', $user_id);
		$this->db->where('video_id', $video_id);
		$result = $this->db->delete('adhi_classroom_videos_watch_list');
		
		if($result){
			return TRUE;
		}
		
		return FALSE;
		
	}
	
	/**
	 * update watched list
	 * @access public
	 * @param integer user_id
	 * @param integer video_id
	 * @return status
	 */
	public function update_watched($user_id, $video_id)
	{
		// validate arguments, if fails throw an exception
		if(!isset($user_id) || '' == $user_id || !isset($video_id) || '' == $video_id ){
			show_error('update_watched()--: Argument missing');   	
		}
		
		// check for existing entry, if have delete the entry, else create new entry
		if($this->get_by_user_and_video($user_id, $video_id) === FALSE) {
			$this->add_to_watched($user_id, $video_id);
			return TRUE;
		} else {
			$this->remove_from_watched($user_id, $video_id);
			return FALSE;
		}
		
		return FALSE;
	}
}