<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Handles admin functions.
 *
 * @package		CodeIgniter
 * @subpackage	Models
 * @category	Models
 * @author
 */
// ------------------------------------------------------------------------

class Income_report_model extends Model {

    function Income_report_model() {
        parent::Model();
    }

    /**
     * function to select the report details
     *
     * @return reportdetails
     */
    function select_reports($num, $offset = 0, $details = array()) {
	
        $where = "";
        if ('' != $details['datefrom'] && '' == $details['dateto']) {
            $where .= "AC.enrolled_date >='" . $details['datefrom'] . "' ";
        }
        if ('' != $details['dateto'] && '' == $details['datefrom']) {
            $where .= "AC.enrolled_date <='" . $details['dateto'] . "' ";
        }
        if ('' != $details['datefrom'] && '' != $details['dateto']) {
            $where .= "AC.enrolled_date BETWEEN '" . $details['datefrom'] . "' AND '" . $details['dateto'] . "' ";
        }
        if ($where != '') {
            $this->db->where($where);
        }
        
        if (3 != $details['reg_type'] && "" != $details['reg_type']) {
           $this->db->where('AU.created_by',$details['reg_type']);
        }
       
        switch($details['course_type']){
            case 1:
                $this->db->where('ACT.course_type',"Live");
                break;
            case 2:
                $this->db->where('ACT.course_type',"Online");
                break;
            default:
                break;
        }
        
        $this->db->where('AU.reason !=',"Living Social");
        $this->db->where('AU.reason !=',"Groupon");
        $this->db->where('AU.reason !=',"Amazon Local");
        
        $this->db->select("ACT.course_type,AD.firstname as admin_fname, AD.lastname as admin_lname, AU.firstname, AU.lastname, AU.emailid, AU.phone, AU.licensetype, AU.reason, AU.testimonial, AU.created_by, AU.created_type, AC.enrolled_date, AC.renewal_status");
        $this->db->join('adhi_user_course AC','AU.id = AC.userid');
        $this->db->join('adhi_user_course_types ACT','AU.course_user_type = ACT.id');
        $this->db->join('adhi_admin AD','AD.id = AU.created_type','LEFT');
        $this->db->from('adhi_user as AU');
        
        if($num != ""){
            $this->db->limit($num, $offset);
        }
        $this->db->orderby('AC.userid', 'DESC');
        $this->db->group_by("AC.userid"); 
        $query = $this->db->get();
        
        return($query->result());
    }

    /**
     * function to get the count of user details
     *
     * @return count of users
     */
    function qry_count_reportdetails($details) {
        $this->db->select('COUNT(DISTINCT AC.userid) as count');
        $where = "";
        if ('' != $details['datefrom'] && '' == $details['dateto']) {
            $where .= "AC.enrolled_date >='" . $details['datefrom'] . "' ";
        }
        if ('' != $details['dateto'] && '' == $details['datefrom']) {
            $where .= "AC.enrolled_date <='" . $details['dateto'] . "' ";
        }
        if ('' != $details['datefrom'] && '' != $details['dateto']) {
            $where .= "AC.enrolled_date BETWEEN '" . $details['datefrom'] . "' AND '" . $details['dateto'] . "' ";
        }
       
        if ($where != '') {
            $this->db->where($where);
        }
        
        if (3 != $details['reg_type'] && "" != $details['reg_type']) {
           $this->db->where('AU.created_by',$details['reg_type']);
        }
        
        switch($details['course_type']){
            case 1:
                $this->db->where('ACT.course_type',"Live");
                break;
            case 2:
                $this->db->where('ACT.course_type',"Online");
                break;
            default:
                break;
        }
        $this->db->where('AU.reason !=',"Living Social");
        $this->db->where('AU.reason !=',"Groupon");
        $this->db->where('AU.reason !=',"Amazon Local");
        
        $this->db->join('adhi_user_course AC','AU.id = AC.userid');
        $this->db->join('adhi_user_course_types ACT','AU.course_user_type = ACT.id');
        $this->db->from('adhi_user as AU');
        $s = $this->db->get();
        $query = $s->row_array(); 
        return $query['count'];
    }
}