<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Handles admin functions.
 *
 * @package		CodeIgniter
 * @subpackage	Models
 * @category	Models
 * @author
 */

// ------------------------------------------------------------------------

class Admin_course_model extends Model{
	function Admin_course_model ()
	{
		parent::Model ();
	}  
	/**
	 * function to select the user details
	 *
	 * @return userdetails
	 */
	/*function select_courses ($num,$offset = 0,$usertype) {
		if($offset == '')
		{
			$offset =0;
		}
		if('all' == $usertype || '' == $usertype){
			$query = $this->db->query ("SELECT c.course_name,c.id,c.parent_course_id,c.amount,c.parent_course_name,c.exam_status,c.wieght,c.course_code,
										 (SELECT count(cc.course_code) 
										 FROM adhi_courses as cc where cc.parent_course_id=c.id) as count_sub 
										 FROM `adhi_courses` as c   LIMIT ".$offset.",".$num);
		}
		else 
		{ 
			$query = $this->db->query ("SELECT DISTINCT AC.course_name,AC.id,AC.amount,AC.parent_course_id,ALC.course_type,AC.parent_course_name,AC.exam_status,AC.wieght,AC.course_code
									 	FROM adhi_courses AS AC
										LEFT JOIN adhi_license_course AS ALC
										ON AC.id = ALC.course_id 
										WHERE ALC.licensetype = '".$usertype."'  LIMIT ".$offset.",".$num);
		}
		return($query->result());
	}*/
	
	
	function select_courses ($num,$offset = 0,$usertype) {
		
		if($offset == '')
		{
			$offset =0;
		}
		if('all' == $usertype || '' == $usertype){
			$query = $this->db->query ("SELECT c.course_name,c.id,c.amount,c.parent_course_name,c.exam_status,c.wieght,c.course_code
										FROM `adhi_courses` as c WHERE exam_status='E' and parent_course_id = 0   LIMIT ".$offset.",".$num);
		}
		else 
		{ 
			$query = $this->db->query ("SELECT ACP.id, ACP.course_id,ACP.amount,AC.wieght,AC.course_name,AC.course_code
									 	FROM adhi_course_price AS ACP
										LEFT JOIN adhi_courses AS AC
										ON ACP.course_id = AC.id 
										WHERE ACP.course_type_id = '".$usertype."'  LIMIT ".$offset.",".$num);
		}
		return($query->result());
	}
	function select_all_courses(){
		$this->db->select('course_name', 'id');
		$this->db->where('exam_status','E');
		$this->db->where('parent_course_id',0);
		$this->db->from('adhi_courses');
		$query = $this->db->get();
		return($query->result());
	}
	/**
	 * function to get the count of user details
	 *
	 * @return count of users
	 */
	function qry_count_coursedetails ($usertype){
		if('all' == $usertype || '' == $usertype){
			$count = $this->db->query ("SELECT count(DISTINCT AC.course_name) as tot
									 	FROM adhi_courses AS AC
										LEFT JOIN adhi_license_course AS ALC
										ON AC.id = ALC.course_id ");
		}
		else 
		{
			$count = $this->db->query ("SELECT count(DISTINCT AC.course_name) as tot
									 	FROM adhi_courses AS AC
										LEFT JOIN adhi_license_course AS ALC
										ON AC.id = ALC.course_id 
										WHERE ALC.licensetype = '".$usertype."'");
		}
		
		$TOTAL	=	$count->row();
		return($TOTAL->tot);
	}
	function admin_course_tot_weight(){
		$query = $this->db->query ("SELECT SUM(wieght) AS weight
										 FROM adhi_courses ");
		$sum	=	$query->row();
		return($sum->weight);
	}
	function select_subcourses($id)	{
		$this->db->where('parent_course_id',$id);
		$this->db->select ("id,course_name,course_code,amount,wieght");
		$query	=	$this->db->get('adhi_courses');
		return($query->result());
	}
	/**
	 * function to get the details of a single user
	 *
	 * @param int $userid
	 * @return user details
	 */
	function select_single_courses_det($courseid){
		$this->db->where('id',$courseid);
		$this->db->select ("id,course_name,course_code,amount,wieght");
		$query	=	$this->db->get('adhi_courses');
		return($query->row());
	}
	/**
	 * function to update the user details
	 *
	 * @param unknown_type $details
	 * @return unknown
	 */
	function update_course_details($details){
		$weight = 	round(($details['weight']* (2.2)),1);
		$this->db->where('id', $details['id']);
		$details	=	  array('wieght' =>	$weight,
								'amount' =>	$details['amount']
								);
		$updates	=	$this->db->update('adhi_courses', $details);
		if($updates > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
			
		}
	}
	/**
	 * function to update the course rate
	 *
	 * @param unknown_type $details
	 * @return unknown
	 */
	function update_course_rate($details){
		$this->db->where('id', $details['id']);
		$details	=	  array('amount' =>	$details['amount']
								);
		$updates	=	$this->db->update('adhi_course_price', $details);
		if($updates > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
			
		}
	}
	/**
	 * function to select a single course rate
	 *
	 * @param unknown_type $courseid
	 * @return array
	 */
	function select_single_course_rate($courseid){
		$this->db->where('acp.id',$courseid);
		$this->db->select ("acp.id,ac.course_name,ac.course_code,acp.amount");
		$this->db->join('adhi_courses ac','acp.course_id=ac.id','left');
		$query	=	$this->db->get('adhi_course_price acp');
		return($query->row());
	}
	
}