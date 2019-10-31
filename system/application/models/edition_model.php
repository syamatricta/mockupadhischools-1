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

class Edition_model extends Model{
	function Admin_course_model ()
	{
		parent::Model ();
	}  
	function select_p_courses(){
		$this->db->select('course_name,id');
		$this->db->where('parent_course_id',0);
		$this->db->from('adhi_courses');
		$query = $this->db->get();
		return($query->result());
	}
	function getSummary ($num,$offset = 0,$details) {
		
		if('' != $details['course_id'])
		{
			$this->db->where("s.course_id =".$details['course_id']);
		}
		if('' != $details['date_from'])
		{
			$this->db->where("date_from >='".$details['date_from']."' ");
		}
		if('' != $details['date_to'])
		{
			$this->db->where("date_to <='".$details['date_to']."' ");
		}
		$this->db->select ("s.id,c.course_name,s.edition_no,s.date_from,s.date_to,s.default_edition");
		$this->db->from('adhi_edition_summary s');
		$this->db->join('adhi_courses c' ,'s.course_id = c.id');
	    $this->db->limit($num,$offset);
	    $this->db->orderby('c.course_name','ASC');
	    $this->db->orderby('edition_no','DESC');	    
		$query	=	$this->db->get();
		return($query->result());
	}
	function qry_count_orderdetails ($details){
		if('' != $details['course_id'])
		{
			$this->db->where("s.course_id =".$details['course_id']);
		}
		if('' != $details['date_from'])
		{
			$this->db->where("date_from >='".$details['date_from']."' ");
		}
		if('' != $details['date_to'])
		{
			$this->db->where("date_to <='".$details['date_to']."' ");
		}
		$this->db->select ("count(s.id) as tot");
		$this->db->from('adhi_edition_summary s');
		$query	=	$this->db->get();
		$count	=	$query->row();
		return($count->tot);
	}
	
	function isValidAddDates($course_id,$date_from,$date_to=''){
		$whr = "WHERE course_id = $course_id AND ";
		$qryCondn1 = $qryCondn2 = '';
		if($date_to){
			$qryCondn1 = " OR '$date_to' BETWEEN date_from and date_to ";
			$qryCondn2 = " OR '$date_to' <= date_from ";
		}
		$count = $this->db->query("SELECT COUNT(*) as tot FROM adhi_edition_summary $whr ('$date_from' BETWEEN date_from AND date_to $qryCondn1) AND date_to IS NOT NULL");
		$total = $count->row();
		if($total->tot > 0){
			return 1;
		}else {
			$count2 = $this->db->query("SELECT COUNT(*) as tot FROM adhi_edition_summary $whr ('$date_from' <= date_from $qryCondn2) AND date_to IS NULL");
			$total2 = $count2->row();
			if($total2->tot > 0){
				if($date_to==''){					
					return 3;
				}else {
					$count3 = $this->db->query("SELECT COUNT(*) as tot FROM adhi_edition_summary $whr ('$date_to' <= date_from $qryCondn2) AND date_to IS NULL");
					$total3 = $count3->row();
					if($total3->tot > 0){
						return 'NO';
					}else 
						return 2;
				}
			}
			else 
				return 'SUCCESS';
		}
	}
	
	function isValidEditDates($id,$course_id,$date_from,$date_to=''){
		$whr = "WHERE course_id = $course_id AND ";
		$qryCondn1 = $qryCondn2 = '';
		if($date_to){
			$qryCondn1 = " OR '$date_to' BETWEEN date_from and date_to ";
			$qryCondn2 = " OR '$date_to' <= date_from ";
		}
		$count = $this->db->query("SELECT COUNT(*) as tot FROM adhi_edition_summary $whr ('$date_from' BETWEEN date_from AND date_to $qryCondn1) AND date_to IS NOT NULL AND id!=$id");
		$total = $count->row();
		if($total->tot > 0){
			return 1;
		}else {
			if($date_to==''){
				$count2 = $this->db->query("SELECT COUNT(*) as tot FROM adhi_edition_summary $whr ('$date_from' <= date_from $qryCondn2) AND date_to IS NULL AND id!=$id");
				$total2 = $count2->row();
				if($total2->tot > 0)
					return 2;
				else 
					return 0;
			}else {
				$count2 = $this->db->query("SELECT COUNT(*) as tot FROM adhi_edition_summary $whr ('$date_from' >= date_from OR '$date_to' >=date_from) AND date_to IS NULL AND id!=$id");
				$total2 = $count2->row();
				if($total2->tot > 0){
					if($date_to==''){					
						return 3;
					}else {
						$count3 = $this->db->query("SELECT COUNT(*) as tot FROM adhi_edition_summary $whr ('$date_to' <= date_from $qryCondn2) AND date_to IS NULL AND id!=$id");
						$total3 = $count3->row();
						if($total3->tot > 0){
							return 'NO';
						}else 
							return 2;
					}
				}
				else 
					return 0;
			}
		}
	}
	
	function getEditionDetails ($id) {
		$this->db->select ("*");
		$this->db->where ('id',$id);
		$this->db->from("adhi_edition_summary");
		$query	=	$this->db->get();
		return($query->row());
	}
	
	function getUserCourses ($courseid,$date_from,$date_to='') {
		$this->db->select ("id");
		$this->db->where ('admin_set_flag',0);
		if(!$date_to)
			$date_to = date('Y-m-d');
		$this->db->where ("enrolled_date BETWEEN '$date_from' AND '$date_to'");
		$this->db->where ('courseid',$courseid);
		$this->db->from("adhi_user_course");
		$query	=	$this->db->get();
		return($query->result_array());
	}
}