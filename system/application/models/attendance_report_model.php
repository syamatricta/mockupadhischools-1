<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Handles attendance report functions.
 *
 * @package		CodeIgniter
 * @subpackage	Models
 * @category	Models
 * @author
 */
// ------------------------------------------------------------------------

class Attendance_report_model extends Model {

    function Attendance_report_model() {
        parent::Model();
    }
    
    /**
    * function to get the details of a single attendance
    *
    */
   function select_single_attendancedetails($attendance_id){
        $this->db->select ("AAR.report,AAR.notes,AAR.adhi_attendance_report_id,AAR.region,AAR.sub_region,AAR.course,AAR.instructor,AR.region_name,ASR.subregion_name,AMS.name as instructor_name,AC.course_name,AAR.date,AAR.time_from,AAR.time_to,AAR.attendance,AAR.titled_guests,AAR.created_date");
        $this->db->where('adhi_attendance_report_id',$attendance_id);
        $this->db->join('adhi_region AR','AR.id = AAR.region');
        $this->db->join('adhi_subregion ASR','ASR.id = AAR.sub_region');
        $this->db->join('adhi_courses AC','AC.id = AAR.course');
        $this->db->join('adhi_meet_staff AMS','AMS.id = AAR.instructor');
        $query	=	$this->db->get('adhi_attendance_report as AAR');
        $result = $query->row();

        if($this->authentication->logged_in ("admin") === "sub" && FALSE === $this->authentication->check_permission_redirect('sub_permission_1', FALSE)) {
            $sub_id = $this->session->userdata('USERID');
            if($result -> created_by == $sub_id ){
                return $result;
            } else{
                return FALSE;
            }
        } else{
            return $result;
        }
   }

    /**
     * function to select the report details
     *
     * @return reportdetails
     */
    function select_reports($num, $offset = 0, $details = array(), $type="data") {
	
        $where = "";
        if ('' != $details['search_date_from'] && '' == $details['search_date_to']) {
            $where .= "AAR.date >='" . $details['search_date_from'] . "' ";
        }
        if ('' != $details['search_date_to'] && '' == $details['search_date_from']) {
            $where .= "AAR.date <='" . $details['search_date_to'] . "' ";
        }
        if ('' != $details['search_date_from'] && '' != $details['search_date_to']) {
            $where .= "AAR.date BETWEEN '" . $details['search_date_from'] . "' AND '" . $details['search_date_to'] . "' ";
        }
        if ($where != '') {
            $this->db->where($where);
        }
        
        if ('' != $details['search_region']){
           $this->db->where('AAR.region',$details['search_region']);
        }
        
        if ('' != $details['search_sub_region']){
           $this->db->where('AAR.sub_region',$details['search_sub_region']);
        }
        
        if ('' != $details['search_course']){
           $this->db->where('AAR.course',$details['search_course']);
        }
        
        if ('' != $details['search_instructor']){
           $this->db->where('AAR.instructor',$details['search_instructor']);
        }
        
        $this->db->where("AAR.status",1);
        if("count" != $type){
             $this->db->select ("AAR.report,AAR.notes,AAR.adhi_attendance_report_id,AR.region_name,ASR.subregion_name,AMS.name as instructor_name,AC.course_name,AAR.date,AAR.time_from,AAR.time_to,AAR.attendance,AAR.titled_guests,AAR.created_date,AAR.updated_date,AA.firstname as admin_first_name,AA.lastname as admin_last_name");
        }else{
            $this->db->select('COUNT(DISTINCT AAR.adhi_attendance_report_id) as count');
        }
        $this->db->join('adhi_region AR','AR.id = AAR.region');
        $this->db->join('adhi_subregion ASR','ASR.id = AAR.sub_region');
        $this->db->join('adhi_courses AC','AC.id = AAR.course');
        $this->db->join('adhi_meet_staff AMS','AMS.id = AAR.instructor');
        $this->db->join('adhi_admin AA','AA.id = AAR.created_by');
        
        if("data" == $type){
            if($num != ""){
                $this->db->limit($num, $offset);
            }
        }
        
        $this->db->orderby('AAR.adhi_attendance_report_id', 'DESC');
        $query	=	$this->db->get('adhi_attendance_report as AAR');
        
        if("count" != $type){
            return($query->result());
        }else{
            $querys = $query->row_array(); 
            return $querys['count'];
        }
    }

    /**
     * function to get the count of attendance details
     *
     * @return count of attendance
     */
    function qry_count_reportdetails($details) {
        $this->db->select('COUNT(DISTINCT AAR.adhi_attendance_report_id) as count');
        $where = "";
        
        if ('' != $details['search_date_from'] && '' == $details['search_date_to']) {
            $where .= "AAR.date >='" . $details['search_date_from'] . "' ";
        }
        if ('' != $details['search_date_to'] && '' == $details['search_date_from']) {
            $where .= "AAR.date <='" . $details['search_date_to'] . "' ";
        }
        if ('' != $details['search_date_from'] && '' != $details['search_date_to']) {
            $where .= "AAR.date BETWEEN '" . $details['search_date_from'] . "' AND '" . $details['search_date_to'] . "' ";
        }
        if ($where != '') {
            $this->db->where($where);
        }
        
        if ('' != $details['search_region']){
           $this->db->where('AAR.region',$details['search_region']);
        }
        
        if ('' != $details['search_sub_region']){
           $this->db->where('AAR.sub_region',$details['search_sub_region']);
        }
        
        if ('' != $details['search_course']){
           $this->db->where('AAR.course',$details['search_course']);
        }
        
        if ('' != $details['search_instructor']){
           $this->db->where('AAR.instructor',$details['search_instructor']);
        }
        
        $this->db->where("AAR.status",1);
        $this->db->join('adhi_region AR','AR.id = AAR.region');
        $this->db->join('adhi_subregion ASR','ASR.id = AAR.sub_region');
        $this->db->join('adhi_courses AC','AC.id = AAR.course');
        $this->db->join('adhi_meet_staff AMS','AMS.id = AAR.instructor');
        $this->db->join('adhi_admin AA','AA.id = AAR.created_by');
        
        $this->db->orderby('AAR.adhi_attendance_report_id', 'DESC');
        $querys	=	$this->db->get('adhi_attendance_report as AAR');
        
        $query = $querys->row_array(); 
        return $query['count'];
    }
    
    
    /**
     * function to add the attendance
     *
     * @param unknown_type $details
     * @return unknown
     */

    function add_attendance_details($details){
        $this->db->insert('adhi_attendance_report', $details); 
        return $this->db->insert_id();
    }
    
    
    /**
     * function to update the attendance details
     *
     * @param unknown_type $details
     * @return unknown
     */
    
    function update_attendance_details($attendance_id,$details){
        $this->db->where('adhi_attendance_report_id', $attendance_id);
        return $this->db->update('adhi_attendance_report', $details);
    }
}