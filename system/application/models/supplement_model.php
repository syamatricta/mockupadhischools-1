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

class Supplement_model extends Model{
	function Supplement_model (){
		parent::Model ();
	} 
	function allCourses(){
		$this->db->select('course_name,id');
		$this->db->where('parent_course_id',0);
		$this->db->from('adhi_courses');
		$query = $this->db->get();
		return($query->result());
	}
	function allEditions($course_id){
		$this->db->select('edition_no, id, default_edition');
		$this->db->where('course_id', $course_id);
		$this->db->from('adhi_edition_summary');
		$query = $this->db->get();
		return($query->result());
	}
	function all($return_type = 'list', $where = array(), $num = 10, $offset = 0) {		
		if(isset($where['course_id']) && '' != $where['course_id']){
			$this->db->where("s.course_id =".$where['course_id']);
		}
		$this->db->from('adhi_supplements s');		
		$this->db->group_by('s.course_id, s.edition_id');
		if('count' == $return_type){
			$this->db->select ("count(s.id) as count");
			$query	=	$this->db->get();
			return ($query) ? $query->num_rows() : 0;
		}else{
			$this->db->join('adhi_edition_summary e' ,'e.id = s.edition_id');
			$this->db->join('adhi_courses c' ,'s.course_id = c.id');
			$this->db->select ("s.id, s.course_id, s.edition_id, c.course_name, e.edition_no, e.default_edition");
		    $this->db->limit($num,$offset);
		    $this->db->orderby('c.course_name','ASC');
		    $this->db->orderby('e.edition_no','DESC');		    
			$query	=	$this->db->get();
			return($query->result());
		}
	}
	function hasSupplements($course_id, $edition_id){
		$this->db->select('count(id) as count');
		$this->db->where(array('course_id' => $course_id, 'edition_id' => $edition_id));
		$this->db->group_by('course_id, edition_id');
		$query 	= $this->db->get('adhi_supplements');
		$result	= $query->row();
		return ($result) ? $result->count : 0;
	}
	function getSupplements($course_id, $edition_id) {
		$this->db->select("s.id, s.course_id, s.edition_id, c.course_name, e.edition_no, e.default_edition, s.title, s.file, s.created_date, s.updated_date");
		$this->db->where('s.course_id', $course_id);
		$this->db->where('s.edition_id', $edition_id);
		$this->db->join('adhi_edition_summary e' ,'e.id = s.edition_id');
		$this->db->join('adhi_courses c' ,'s.course_id = c.id');
		$this->db->from("adhi_supplements s");
		$query	=	$this->db->get();
		return $query->result();
	}
	function getSupplementById($id) {
		$this->db->select("s.id, s.course_id, s.edition_id, c.course_name, e.edition_no, e.default_edition, s.title, s.file, s.created_date, s.updated_date");
		$this->db->where('s.id', $id);
		$this->db->join('adhi_edition_summary e' ,'e.id = s.edition_id');
		$this->db->join('adhi_courses c' ,'s.course_id = c.id');
		$this->db->from("adhi_supplements s");
		$query	=	$this->db->get();
		return $query->row();
	}	
	function deleteById($id) {
		$this->db->where('id', $id);
		return $this->db->delete('adhi_supplements');
	}
	function deleteAll($course_id, $edition_id) {
		$this->db->where('course_id', $course_id);
		$this->db->where('edition_id', $edition_id);
		return $this->db->delete('adhi_supplements');
	}
	
	
}