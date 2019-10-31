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
	function save_login($username = '',$status = TRUE, $data = array()){
            $login_id = $status ? $data['login_result']-> USERID : '';
            $data_save = array(
                'login_ip'       =>     $this->input->ip_address(),
                'login_user'     =>     $username,
                'login_id'       =>     $login_id,
                'login_status'   =>     $status,
                'created_date'   =>     convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')),
                'status'         =>     1
                );
            
            if($status){
                $data_save['otp_mail_id']    = $data['otp_email_id'];
                $data_save['otp_history_id'] = $data['otp_history_id'];
            }
            
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
                        $body        =      sprintf($template_array['mail_body'],$date_time , ucfirst($data['otp_name']), $data['otp_email'],$data_save['login_user'], $data_save['login_ip']);
                        
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
        
        /**
         * function for admin otp email list process and send otp
         * 
         * @package		CodeIgniter
         * @author		
         * @link		http://adhischools.com
         * @return unknown
         */
        function admin_otp_email ($login_details, $otp_email_id = "", $otp_email = "", $resend = 0)
        {
            
            if($login_details->USERID != "" && $otp_email_id != "" && $otp_email != ""){

                    $template_id = $this->config->item('OTP_MAIL_TEMPLATE');
                    $otp         = generate_unique_key();
                    
                    $data_save 	= array (
                                'adhi_otp_mail_id' => $otp_email_id,
                                'login_id'         => $login_details->USERID,
                                'email_id'         => $otp_email,
                                'created_date'     => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')),
                                'otp'              => $otp,
                                'resend'           => $resend
                    );
                    
                    if($template_array = $this->get_mail_template($template_id)){
                        $to_mail     =      $otp_email;
                        $from        =      $template_array['mail_from'];
                        $from_name   =      $template_array['mail_from_name'];
                        $date_time   =      date("F j, Y, g:i a",strtotime($data_save['created_date']));

                        if($this->config->item('DST')){
                            $hour        =      $this->config->item('DST_HOUR');
                            $time_hr     =      $hour * 3600;
                            $date_time   =      date("F j, Y, g:i a",strtotime($date_time)+$time_hr);
                        }
                        
                        $subject     =      $template_array['mail_subject'];
                        $body        =      sprintf($template_array['mail_body'], $date_time, $otp);

                        $this->load->model('Common_model');
                        
                        if($email_status = $this->Common_model->guest_pass_mail($to_mail,$from,$from_name,$subject,$body)){
                                $data_save['email_status' ] 	= $email_status;
                                $this->db->insert('adhi_otp_mail_history',$data_save);
                                return $this->db->insert_id();
                        }
                    }
                }
            
            return false;
        }
        
        /**
         * Added function get otp email list
         * Created on 20 Jan 2016
         * Developer : syama.s@rainconcert.in
         *
         * @param nil
         * @return array
         */
        
        function get_otp_emails($otp_email = "", $login_id ="", $tracking = TRUE, $otp_id = ""){
            
                if($otp_id != ""){
                    $data_where = array('adhi_otp_emails_id' => $otp_id,'status' => 1);
                } else {
                    $data_where = array('active_status' => 1,'status' => 1);
                }
                
                if($otp_email != ""){
                    $this->db->select('adhi_otp_emails_id as otp_email_id, name');
                    $data_where = array_merge(array('email_id' => $otp_email),$data_where);
                } else {
                    $this->db->select('*,adhi_otp_emails_id as id');
                }
                
                
                $this->db->where($data_where);
                $this->db->from('adhi_otp_emails');
		$data = $this->db->get(); 
                
                $data_save = array(
                    'login_id'      => $login_id,
                    'otp_mail'      => $otp_email,
                    'created_date'  => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')),
                    'status'        => 0
                );
                
                if($data -> num_rows() > 0){
                    $data_save['status']  =  1;
                }
                
                if($tracking){
                    $this->db->insert('adhi_otp_tracking', $data_save);
                }
                
                if($data_save['status']  ==  1){
                    return $data->result_array();
                }
                return FALSE;
	}
        
        /**
         * Added function check otp
         * Created on 20 Jan 2016
         * Developer : syama.s@rainconcert.in
         *
         * @param $data,$otp
         * @return array
         */
        
        function admin_otp($data = array(),$otp = ""){
                $flag = 0;
                $query = $this->db->get_where('adhi_otp_mail_history',array('adhi_otp_mail_history_id' => $data['otp_history_id']));
                
                if($query -> num_rows() > 0){
                    $result = $query->row_array();
                    
                    $data_update = array(
                            'otp_status'    => 1,
                            'otp_attempts'  => $result['otp_attempts'] + 1,
                            'is_logged'     => 2,
                            'updated_date'  => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'))
                    );
                    
                    
                    if(trim($result['otp']) == trim($otp)){
                        $data_update['is_logged']     = 1;
                        $flag = 1;
                    }
                    
                    $this->db->set($data_update);
                    $this->db->where(array('adhi_otp_mail_history_id' => $data['otp_history_id']));
                    $this->db->update('adhi_otp_mail_history');
                }
                
                return $flag ? TRUE : FALSE;
	}
        
        /**
         * Added to check if admin otp expired or not
         * Created on 03 Feb 2016
         * Developer : syama.s@rainconcert.in
         *
         * @param $data,$otp
         * @return array
         */
        
        function admin_otp_expiry($data = array(),$otp = ""){
                $flag = 0;
                $query = $this->db->get_where('adhi_otp_mail_history',array('adhi_otp_mail_history_id' => $data['otp_history_id']));
                
                if($query -> num_rows() > 0){
                    $result = $query->row_array();
                    
                    $current_time = strtotime(convert_UTC_to_PST_datetime(date('Y-m-d H:i:s',strtotime('-1 hour')))); 
                    //$current_time = strtotime(convert_UTC_to_PST_datetime(date('Y-m-d H:i:s',strtotime('-5 Minute'))));  
                    $created_date = strtotime($result['created_date']); 
                    
                    $time_diff = $current_time - $created_date;
                    
                    if($time_diff > 0){
                        $data_update = array(
                                'otp_status'    => 2,                               //Expired
                                'is_logged'     => 3,                               //Expired
                                'expiry_check'  => $result['expiry_check'] + 1,
                                'expiry_try_date'  => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'))
                        );

                        $this->db->set($data_update);
                        $this->db->where(array('adhi_otp_mail_history_id' => $data['otp_history_id']));
                        $this->db->update('adhi_otp_mail_history');
                        
                        return FALSE;
                    }
                }
                
                return TRUE;
	}
        
        
        function adminrenewcourse($arr){
            $query= $this->db->query("select * from adhi_user_renewdetails where reg_courseid ='".$arr['reg_courseid']."'");
            $result= $query->num_rows();
            if($result){
                $query1= $this->db->query("update  adhi_user_renewdetails set renew_date ='".$arr['renew_date']."' where reg_courseid ='".$arr['reg_courseid']."'  ");
            }else{
                $query1= $this->db->insert('adhi_user_renewdetails', $arr);
            }

            $query= $this->db->query("update  adhi_user_course set renewal_status ='Y',attempt_count_reenroll = 0,need_to_reenroll = 0 where id ='".$arr['reg_courseid']."'  ");
            
        }
        
        function getUserDetails($user_id){
            $this->db->select('*');
            $this->db->where('id', $user_id);
            $query1	= $this->db->get('adhi_user');

            if($query1->num_rows() > 0){
               return $query1->row();
            }
            return array();
        }
        
        function getCourse($course_id){
            $this->db->select('*');
            $this->db->where('id',$course_id);
            $query1	= $this->db->get('adhi_courses');
                
            if($query1->num_rows() > 0){
               return $query1->row();
            }
            return array();
        }
        function getUserCourse($user_id,$course_id){
            $this->db->select('id');
            $this->db->where(array('userid' => $user_id, 'courseid' => $course_id));
            $query1	= $this->db->get('adhi_user_course');
                
            if($query1->num_rows() > 0){
               return $query1->row();
            }
            return array();
        }
        
        function send_renewal_mailto_user($toemail, $name, $coursename, $usertype, $courseprice){
                $from ='';
		$subject='Renewal Details';
		$contents		= '';
		$contents		.= 'Dear '.$name.",<br><br>";

		$contents		.= "You have successfully renewed ".$coursename." <br><br>";
		
                if(2 == $usertype || 4 == $usertype || 6 ==$usertype || 8 ==$usertype){
                    $contents		.='<tr>
                            <td align="left"  width="150" >Course Amount </td>
                            <td align="left"  width="150" > $'.$courseprice.' </td>
                    </tr>';
                }


				$contents		.='</table>';

						$contents		.= "<br><br>With regards,<br><br>";
						$contents		.= "Adhi Schools";
                                                
            $this->send_mail($toemail,$from,$subject,$contents);

	}
        
        function send_mail($to_email,$from='', $subject, $body_content,$admin='',$attachment = array(),$bcc = ''){
		$this->load->library ('email');
		$this->email->_smtp_auth	= $this->config->item('smtp_auth');     
		$this->email->protocol		= $this->config->item('protocol');
		$this->email->smtp_host		= $this->config->item('smtp_host');
		$this->email->smtp_user		= $this->config->item('smtp_user');
		$this->email->smtp_port		= $this->config->item('smtp_port') ? $this->config->item('smtp_port') : '25';
		$this->email->smtp_pass		= $this->config->item('smtp_password');
		$this->email->mailtype		= $this->config->item('mailtype');
		$from_name					= ($from=='')?$this->config->item('smtp_from_name'):$from;
		//$reply_mail					= ($from_mail=='')?$this->config->item('smtp_from'):$from_mail;
		$this->email->set_newline("\r\n");
                $this->email->set_crlf( "\r\n" );
		$this->email->from($this->config->item('smtp_from'), $from_name);
		$this->email->to($to_email);
		
		$this->email->reply_to($this->config->item('smtp_from'),$from_name);        
		//$this->email->set_mailtype('html');
		$this->email->subject($subject);
		$this->email->message($body_content);
		
                $bcc_emails = ('' != $bcc) ? $bcc.',' : '';
                if($admin!=''){
                    $bcc_emails .= $this->config->item ('main_cc_to').',';
                }
                $bcc_emails .= $this->config->item ('main_bcc_to');
                $this->email->bcc($bcc_emails);
                
		foreach($attachment as $attach ){
                    $this->email->attach($attach);
		}
		
		if ($this->email->send ()){
			
			//echo $this->email->print_debugger(); exit;
			return TRUE;
		}
		else{
			
			//echo $this->email->print_debugger();exit;
			return FALSE;
		}
	}
}