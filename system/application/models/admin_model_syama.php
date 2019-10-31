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

class Admin_model extends Model{
	
	function Admin_model (){
		
		parent::Model ();
		
	}  
	
 /**
 * function to get the password using the email
 */
	function confirm_password($password,$id){
		
		if(isset ($id) && '' != $id && isset ($password) && '' != $password){
			
			$this->db->where('password',$password);
			$this->db->where('id',$id);
			$this->db->select ("password,id");
			$query	=	$this->db->get('adhi_admin');
			
			if($query->row())
				return $query->row();
			else
				return FALSE;
			
		}else 	
			return FALSE;
	}
	
	 /**
	 * function to change the password using the email
	 */
	function change_password($email,$id,$password){
		
		if(isset ($email) && '' != $email && isset ($id) && '' != $id && isset ($password) && '' != $password ){
			
			$array = array('password' => $password);
			$this->db->set($array);
			
			$this->db->where('id',$id);
			$this->db->where('emailid',$email);
			
			
			if($this->db->update('adhi_admin'))
				return TRUE;
			else 
				return FALSE;
			
		}else 	
			return FALSE;
	}
	
        function get_access_token($user_id){
            $this->db->select('google_access_token');
            $this->db->where('id', $user_id);
            $query = $this->db->get('adhi_admin');
            if($query->row()){
                return ('' != trim($query->row()->google_access_token)) ? $query->row()->google_access_token : false;
            }
            return false;
        }

        function set_access_token($user_id, $access_token){
            $this->db->set('google_access_token', $access_token);
            $this->db->where('id', $user_id);
            return $this->db->update('adhi_admin');
        }

        
        function get_exam_report($status, $from_date, $to_date, $unexpected='') {
            $this->db->from('adhi_exam_tracking');
            if($unexpected != ''){
                if('P' == $status){
                    $this->db->where('score >= ', 60);
                }else if('F' == $status){
                    $this->db->where('score < ', 60);
                }
                $this->db->where('exam_ended ', $unexpected);
            }else if($status != ''){
                $this->db->where('status ', $status);
            }
            $this->db->where('updated_at >=', $from_date." 00:00:00");
            $this->db->where('updated_at <=', $to_date." 23:59:59");
            return $this->db->count_all_results();
        }
        
        function get_exam_report_details($status, $from_date, $to_date, $unexpected='') {
            $this->db->select("DISTINCT(user_id) AS user_id, firstname, lastname, at.course_id");
            $this->db->from('adhi_exam_tracking at');
            $this->db->join('adhi_user au','at.user_id=au.id');
            if($unexpected != '') 
            {
                $this->db->where('exam_ended ', $unexpected);
            }
            if($status != '') 
            {
                $this->db->where('at.status ', $status);
            }
            $this->db->where('updated_at >=', $from_date." 00:00:00");
            $this->db->where('updated_at <=', $to_date." 23:59:59");
            $this->db->order_by('firstname');
            $reportquery = $this->db->get();
            return $reportquery->result_array();
        }

        
        function getActiveUserCount($current_time, $time_span = '-5 minutes', $type = 'all'){
            $start  = date('Y-m-d H:i:s', strtotime($time_span, strtotime($current_time)));
            $end    = $current_time;
            $this->db->select('count(session_id) as count');
            $where  = "last_accessed >='".$start."' AND last_accessed <= '".$end."' AND is_admin=0";
            if($type == 'registered'){
                $where  .= " AND user_id > 0 ";
            }
            $this->db->where($where, NULL, FALSE);
            $query = $this->db->get('ci_sessions');
            if($query->row()){
               return $query->row()->count;
            }
            return 0;
        }
        function getActiveUserCountByTime($current_time, $time_span = '-5 minutes'){
            $start  = date('Y-m-d H:i:s', strtotime($time_span, strtotime($current_time)));
            $end    = $current_time;
            $this->db->select(' last_accessed, 
                                SUM( if( user_id =0, 1, 0 ) ) AS guest, 
                                SUM( if( user_id >0, 1, 0 ) ) AS registered', FALSE);
            $where  = "last_accessed >='".$start."' AND last_accessed <= '".$end."' AND is_admin=0";            
            $this->db->where($where, NULL, FALSE);
            $this->db->group_by('user_id, MINUTE(last_accessed)');
            $this->db->order_by('last_accessed', 'ASC');
            $query = $this->db->get('ci_sessions');
            return $query->result();
        }
        
        function breakdownUserCount($start_date, $end_date){
            $result = array('normal' => 0, 'amazon' => 0, 'living' => 0, 'groupon' => 0 );            
            $total              = $this->userFromSite(false, $start_date, $end_date);            
            $result['amazon']   = $this->userFromSite('Amazon', $start_date, $end_date);            
            $result['living']   = $this->userFromSite('Living', $start_date, $end_date);
            $result['groupon']  = $this->userFromSite('Groupon', $start_date, $end_date);
            //$result['total']    = $total;
            $result['normal']   = $total - ($result['amazon']+$result['groupon']+$result['living']);
            return $result;
        }
        function userFromSite($site = false, $start_date, $end_date){
            $this->db->select('count(distinct(u.id)) as count');
            $this->db->join('adhi_user_course uc', 'uc.userid=u.id');
            if(false !== $site){
                $this->db->where("u.reason LIKE '%$site%'", NULL, FALSE);
            }
            $this->db->where('u.status', 'A');
            $this->db->where("uc.enrolled_date >= '$start_date' AND uc.enrolled_date <= '$end_date'", NULL, FALSE);
            $query = $this->db->get('adhi_user u');
            return ($query->row()) ? $query->row()->count: 0;
        }

        function getCourses(){
            $this->db->from('adhi_courses');
            $this->db->where("exam_status='E' and parent_course_id = 0", NULL, FALSE);//default_edition !=
            
            $reportquery = $this->db->get();
            return $reportquery->result_array();
        }
        function get_course_report($course, $from_date, $to_date) {
            $this->db->from('adhi_user_course');
            
            $this->db->where('courseid ', $course);
            
            $this->db->where('enrolled_date >=', $from_date);
            $this->db->where('enrolled_date <=', $to_date);
            return $this->db->count_all_results();
        }
        function get_course_report_details($course, $from_date, $to_date) {
            $this->db->select("DISTINCT(ac.userid) AS userid, firstname, lastname");
            $this->db->from('adhi_user_course ac');
            $this->db->join('adhi_user au','ac.userid=au.id');
            $this->db->where('courseid ', $course);
            $this->db->where('enrolled_date >=', $from_date);
            $this->db->where('enrolled_date <=', $to_date);
            $this->db->order_by('firstname');
            $reportquery = $this->db->get();
            return $reportquery->result_array();
        }
         /**
         * function to save login details
         */
	function save_login($username = '',$status = TRUE){
            $login_id = $status ? $this->session->userdata('USERID'): '';
            $data_save = array(
                'login_ip'       =>     $this->input->ip_address(),
                'login_user'     =>     $username,
                'login_id'       =>     $login_id,
                'login_status'   =>     $status,
                'created_date'   =>     convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')),
                'status'         =>     1
                );
            
            if($this->db->insert('adhi_login_history',$data_save)){
                if($status){
                    $template_id = $this->config->item('LOGIN_ALERT_MAIL_TEMPLATE');
                    if($template_array = $this->get_mail_template($template_id)){
                        $to_mail     =      $this->config->item('main_cc_to');
                        $from        =      $template_array['mail_from'];
                        $from_name   =      $template_array['mail_from_name'];
                        $date_time   =      date("F j, Y, g:i a",strtotime($data_save['created_date']));
                        
                        if($this->config->item('DST')){
                            $hour        =      $this->config->item('DST_HOUR');
                            $time_hr     =      $hour * 3600;
                            $date_time   =      date("F j, Y, g:i a",strtotime($date_time)+$time_hr);
                        }
                        $subject     =      sprintf($template_array['mail_subject'], $data_save['login_ip']);
                        $body        =      sprintf($template_array['mail_body'],$date_time , $data_save['login_user'], $data_save['login_ip']);
                        
                        $this->load->model('Common_model');
                        $this->Common_model->guest_pass_mail($to_mail,$from,$from_name,$subject,$body);
                    }
                }
            }
            
            
        }
        
        /**
	 * function to add the recruiter
	 *
	 * @param unknown_type $details
	 * @return unknown
	 */
        
        function get_mail_template($mail_template_id = FALSE){
            if($mail_template_id){
                $this->db->where('adhi_mail_template_id',$mail_template_id);
            }
            
            $this->db->orderby('adhi_mail_template_id','DESC');
            $this->db->where(array('status' => 1));
	    $query	=	 $this->db->get('adhi_mail_template');
	    return($query->row_array()); 
	}
}