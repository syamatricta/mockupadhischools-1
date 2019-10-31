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

class Admin_legacy_student_model extends Model{
	function Admin_legacy_student_model(){
            parent::Model ();
            //$this->output->enable_profiler();
	} 
	function getAll($search, $result_type = 'list', $per_page = 10, $offset = 0) {            
            $this->db->select ("*");
            $this->db->from('adhi_legacy_students');
            
	    if(1 == $search['first_name_null']){
                $this->db->where('first_name', '');
            }else if('' != $search['first_name']){                
	    	$this->db->like('first_name', $search['first_name'],'both');
            }
            
	    if(1 == $search['last_name_null']){
                $this->db->where("last_name = '' OR last_name IS NULL ", NULL, FALSE);
            }else if('' != $search['last_name']){
	    	$this->db->like('last_name', $search['last_name'],'both');
            }
            
	    if(1 == $search['email_id_null']){
                $this->db->where("email_id = '' OR email_id IS NULL ", NULL, FALSE);
            }else if('' != $search['email_id']){	    
	    	$this->db->like('email_id', $search['email_id'],'both');
            }
            
            if(1 == $search['phone_null']){
                $this->db->where("phone = '' OR phone IS NULL ", NULL, FALSE);
            }else if('' != $search['phone']){
                $this->db->where('phone', $search['phone']);
            }
            
            if(1 == $search['address_null']){
                $this->db->where("address = '' OR address IS NULL ", NULL, FALSE);
            }else if('' != $search['address']){
                $this->db->like('address', $search['address'],'both');
            }
            
            if(1 == $search['day_rule_failed']){
                $this->db->where("rule_18day_breaks_count > 0", NULL, FALSE);
            }
            if(1 == $search['course_not_found']){
                $this->db->where("course_not_found_count > 0", NULL, FALSE);
            }
            if(1 == $search['validation']){
                $this->db->where("validation_success", 1);
            }else if(2 == $search['validation']){
                $this->db->where("validation_success", 0);
            }
            
            if('list' == $result_type){
                $this->db->limit($per_page, $offset);
                $this->db->orderby('first_name', 'ASC');
                $this->db->orderby('last_name', 'ASC');
                $query  = $this->db->get();
                return $query->result();
            }else{
                return $this->db->count_all_results();
            }
            
	}
        
        
        function getCourses(){
            $this->db->select('course_name, id');
            $this->db->where('exam_status','E');
            $this->db->where('parent_course_id',0);
            $this->db->from('adhi_courses');
            $query = $this->db->get();
            return($query->result());
	}
        
        function insertStudent($data){
            $result = $this->db->insert('adhi_legacy_students', $data);
            return $this->db->insert_id();
        }
        
        function insertStudentCourse($data){
            $result = $this->db->insert('adhi_legacy_student_courses', $data);
            return $this->db->insert_id();
        }
        
        function updateStudentValidation($student_id, $validation_errors, $rule_18day_rule_breaks_count, $course_not_found_count){
            if(count($validation_errors['warning']) == 0 && count($validation_errors['fatal']) == 0){return true;}
            $this->db->select('validation_success, validation_errors');
            $this->db->where('id', $student_id);
            $query = $this->db->get('adhi_legacy_students');
            $prev_validation_errors   = array('warning' => array(), 'fatal' => array());
            if($student = $query->row()){                
               if( '' != $student->validation_errors){
                   $prev_validation_errors   = json_decode($student->validation_errors, TRUE);                   
               } 
            }
            if(count($validation_errors['warning']) > 0){
                foreach ($validation_errors['warning'] as $key => $error){
                    array_push($prev_validation_errors['warning'], $error);
                }
            }
            if(count($validation_errors['fatal']) > 0){
                foreach ($validation_errors['fatal'] as $key => $error){
                    array_push($prev_validation_errors['fatal'], $error);
                }
            }
            
            $data   = array(
                            'validation_success'        => FALSE,
                            'validation_errors'         => json_encode($prev_validation_errors),
                            'rule_18day_breaks_count'   => $rule_18day_rule_breaks_count,
                            'course_not_found_count'    => $course_not_found_count
                        );
            
            $this->db->where('id', $student_id);
            $result = $this->db->update('adhi_legacy_students', $data);            
            
        }
        
        function getStudentCourses($student_id){
            $this->db->select('lsc.student_id, lsc.course_id, lsc.course_name_from_excel, lsc.enrolled_date, lsc.exam_date, lsc.score, lsc.validation_errors, c.course_name');
            $this->db->where('lsc.student_id', $student_id);
            $this->db->from('adhi_legacy_student_courses lsc');
            $this->db->join('adhi_courses c', 'c.id=lsc.course_id', 'left');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        function getPassedCourseDetails($student_id, $course_id){
            $this->db->select("CONCAT_WS(' ', s.first_name, s.last_name) full_name, s.address, s.status, "
                    . "lsc.course_id, lsc.course_name_from_excel, lsc.enrolled_date, lsc.exam_date, lsc.score, "
                    . "lsc.validation_errors, c.course_name, c.course_code", FALSE);
            $this->db->where('lsc.student_id', $student_id);
            $this->db->where('lsc.course_id', $course_id);
            $this->db->where('lsc.score >= 60', NULL, FALSE);
            $this->db->from('adhi_legacy_student_courses lsc');
            $this->db->join('adhi_courses c', 'c.id=lsc.course_id', 'left');
            $this->db->join('adhi_legacy_students s', 's.id=lsc.student_id');
            $query = $this->db->get();
            return $query->row();
        }
	
	
        
}