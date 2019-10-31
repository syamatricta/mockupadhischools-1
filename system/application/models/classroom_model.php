<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * Model class file
 *
 * Model class for classroom videos
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
 * class classroom_videos
 *
 * @package		CodeIgniter
 * @subpackage	Models
 * @category	Classroom_videos
 * @author		Rainconcert
 * @link		http://adhischools.com
 * 
 */
class Classroom_model extends Model 
{
	/**
	 * Get videos by chapter id
	 * @access public
	 * @param int $chapterId
	 * @return mixed $result
	 */
	function get_by_chapter_id($chapter_id,$type, $edition, $offset = 0, $limit = null)
	{
		$ci = &get_instance();
		// if chapter_id is not set then throw an exceprion
		if(!isset($chapter_id) || '' == $chapter_id) {
			show_error('Error on classroom model: Argument missing!');
		}
		$qryCondn = ' WHERE v.edition='.$edition.' AND ';
		if($type=='U')
		$qryCondn = ' JOIN adhi_user_course us ON v.edition = us.edition WHERE us.userid='.$ci->session->userdata ('USERID').' AND ';
		//$query = $this->db->get_where('adhi_classroom_videos', array('quiz_id' => $chapter_id));
		
		$sql = 'SELECT v.id, v.quiz_id, v.video, v.description, q.course_id, es.edition_no'
		     . ' FROM adhi_classroom_videos v '
		     . ' LEFT JOIN adhi_edition_summary es ON es.id = v.edition '
		     . ' JOIN adhi_quiz_list q ON v.quiz_id = q.id '
		     .$qryCondn
		     . ' v.quiz_id = ' . $chapter_id
		     . ' AND q.quiz_status = "E"';
		
		// if have limit add limiter
		if($limit != null) {
			$sql .= ' LIMIT ' . $offset . ', ' . $limit;
		}
		$query = $this->db->query($sql);
		$result = $query->result();
		
		if($result){
			// Return resultset
			return $result;
		}
		
		return FALSE;
	}
	
	/**
	 * Get videos by chapter id witn watched list
	 * @access public
	 * @param int $chapterId
	 * @return mixed $result
	 */
	function get_by_chapter_id_with_watched($chapter_id, $user_id, $offset = 0, $limit = null)
	{
		
		if(!isset($chapter_id) || !is_numeric($chapter_id)
		   || !isset($user_id) || !is_numeric($user_id)
		   || !isset($offset) || !is_numeric($offset)) {
			show_404();
		   	return false;
		   	
		}
		
		
		$ci = &get_instance();
		$ci->load->model('classroom_video_watch_model', 'watched_list');
				
		// if chapter_id is not set then throw an exceprion
		if(!isset($chapter_id) || '' == $chapter_id || !isset($user_id) || '' == $user_id) {
			//show_error('Error on classroom model: Argument missing!');
			return false;
		}
		
		$videos = $this->get_by_chapter_id($chapter_id,'U',0, $offset, $limit );
		
		if($videos !== FALSE) {
			foreach($videos as &$video) {
				$watched = $ci->watched_list->get_by_user_and_video($user_id, $video->id);
				
				if($watched !== FALSE) {
					$video->watched = TRUE;
				} else {
					$video->watched = FALSE;
				}
			}
		}
		
		return $videos;
	}
	
	/**
	 * Get video count by chapter id
	 * @access public
	 * @param int $chapterId
	 * @return mixed $result
	 */
	function get_count_by_chapter_id($chapter_id)
	{
		// if chapter_id is not set then throw an exceprion
		if(!isset($chapter_id) || '' == $chapter_id || !is_numeric($chapter_id)) {
			//show_error('Error on classroom model: Argument missing!');
			show_404();
			return FALSE;
		}
		$ci = &get_instance();
		$sql = 'SELECT count(*) as video_count'
		     . ' FROM adhi_classroom_videos v '
		     . ' JOIN adhi_quiz_list q ON v.quiz_id = q.id '
		     . ' JOIN adhi_user_course us ON v.edition = us.edition WHERE us.userid='.$ci->session->userdata ('USERID').' AND ' 
		     . ' v.quiz_id = ' . $chapter_id;
		
		
		$query = $this->db->query($sql);
		$result = $query->result();
		
		if($result){
			// Return resultset
			return $result[0]->video_count;
		} 
		
		return FALSE;
	}
	
	/**
	 * get by video id
	 * @access public
	 * @param int video_id
	 * @return $result
	 */
	function get_by_id($video_id)
	{
		// if video_id is not set then throw an exceprion
		if(!isset($video_id) || '' == $video_id) {
			show_error('Error on classroom model: Argument missing!');
		}
		
		$sql = 'SELECT v.id, v.quiz_id, v.video, v.description, q.course_id,v.edition'
		     . ' FROM adhi_classroom_videos v '
		     . ' JOIN adhi_quiz_list q ON v.quiz_id = q.id '
		     . ' WHERE v.id = ' . $video_id . ' AND v.status ="E" ';
		
		
		$query = $this->db->query($sql);
		$result = $query->result();
		
		if($result){
			// Return resultset
			return $result[0];
		} 
		
		return FALSE;
	}
	
	/**
	 * update record
	 * @access public
	 */
	function update_video($course_id,$edition, $chapter_id, $video, $description, $video_id)
	{
		// Throw an exception if argument is missing
		if(empty($chapter_id) || empty($video) || empty($video_id)) {
			show_error("Missing argument!");
		}
		
		// Insert to table
		$data = array(
			'quiz_id' => $chapter_id,
			'edition' => $edition,
			'video' => $video,
			'description' => $description,
			'status' => 'E'
		);
		
		$this->db->set($data);
		$this->db->where('id', $video_id);
		$result = $this->db->update('adhi_classroom_videos');
		
		if($result) {
			return TRUE;
		}
				
		return FALSE;
	}
	
	/**
	 * insert record
	 * 
	 * @access public
	 * @param int $course_id
	 * @param int $chapter_id
	 * @param string $video
	 * @return int last_inserted_id
	 * 
	 */
	function insert_video($course_id,$edition, $chapter_id, $video, $description)
	{
		// Throw an exception if argument is missing
		if(empty($chapter_id) || empty($video)) {
			show_error("insert_video(): Missing argument!");
		}
		
		// Insert to table
		$data = array(
			'quiz_id' => $chapter_id,
			'edition' => $edition,
			'video' => $video,
			'description' => $description,
			'status' => 'E'
		);
		
		$this->db->set($data);
		$this->db->insert('adhi_classroom_videos');
		
		//get last inserted id
		$last_id = $this->db->insert_id();
		
		if(empty($last_id)) {
			return FALSE;
		}
		
		return $last_id;
	}
	
	/**
	 * delete a video
	 * @access public
	 * @param int video_id
	 * @param int chapter_id
	 * @return boolen #result
	 */
	function delete_video($video_id, $chapter_id)
	{
		// throw an exception if video id is missing
		if(empty($video_id) || '' == $video_id){
			show_error("Missing argument!");
		}
		
		// Delete record from table
		$this->db->where('id', $video_id);
		$this->db->where('quiz_id', $chapter_id);
		$result = $this->db->delete('adhi_classroom_videos');
		if($result){
			return TRUE;
		}
		
		return FALSE;
		
	}
	
	/**
	 * get first video by chapter
	 * Get the first video information from the chapter specified.
	 * @param int $chapter_id
	 * @return stdClass $return
	 */
	function get_first_video_from_chapter($chapter_id)
	{
		// if chapter_id is not set then throw an exceprion
		if(!isset($chapter_id) || '' == $chapter_id) {
			show_error('Error on classroom model: Argument missing!');
		}
		
		$sql = 'SELECT v.id, v.quiz_id, v.video, v.description, q.course_id'
		     . ' FROM adhi_classroom_videos v '
		     . ' JOIN adhi_quiz_list q ON v.quiz_id = q.id '
		     . ' WHERE v.quiz_id = ' . $chapter_id 
		     . ' LIMIT 1';
		
		$query = $this->db->query($sql);
		$result = $query->result();
		
		if($result){
			// Return resultset
			return $result[0];
		} 
		
		return FALSE;
	}
}