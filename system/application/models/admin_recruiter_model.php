<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Handles admin functions.
 *
 * @package	CodeIgniter
 * @subpackage	Modelsf
 * @category	Models
 * @author
 */

// ------------------------------------------------------------------------

class Admin_recruiter_model extends Model{
	function Admin_recruiter_model ()
	{
		parent::Model ();
		//$this->output->enable_profiler();
	}  
	/**
	 * function to select the recruiter details
	 *
	 * @return recruiterdetails
	 */
	function select_recruiterdetails ($num,$offset = 0,$srchFname = '',$srchLname = '',$srchEmail = '', $srcBrokerage = '') {
            $this->db->select ("*");
            $this->db->from('adhi_recruiter as AR');
	    $this->db->limit($num,$offset);
	    if('' != $srchFname)
                $this->db->like('AR.recruiter_name',$srchFname,'both');
            if('' != $srchLname)
                $this->db->like('AR.recruiter_last_name',$srchLname,'both');
	    if('' != $srchEmail)
    		$this->db->like('AR.recruiter_mail',$srchEmail,'both');
            if('' != $srcBrokerage)
                $this->db->like('AR.recruiter_brokerage',$srcBrokerage,'both');
            
            if($this->authentication->logged_in ("admin") === "sub" && FALSE === $this->authentication->check_permission_redirect('sub_permission_1', FALSE)) {
                $sub_id = $this->session->userdata('USERID');
                $this->db->where('AR.created_by',$sub_id);
            }
            $this->db->join('adhi_admin as AD','AD.id = AR.created_by');
	    $this->db->orderby('AR.adhi_recruiter_id','DESC');
		$query	=	$this->db->get();
		return($query->result()); 
	}
	/**
	 * function to get the count of recruiter details
	 *
	 * @return count of recruiters
	 */
	function qry_count_recruiterdetails ($srchFname = '',$srchLname = '',$srchEmail = '', $srcBrokerage = ''){
            if('' != $srchFname)
                $this->db->like('recruiter_name',$srchFname,'both');
            if('' != $srchLname)
                $this->db->like('recruiter_last_name',$srchLname,'both');
	    if('' != $srchEmail)
    		$this->db->like('recruiter_mail',$srchEmail,'both');
            if('' != $srcBrokerage)
                $this->db->like('recruiter_brokerage',$srcBrokerage,'both');
            
            if($this->authentication->logged_in ("admin") === "sub" && FALSE === $this->authentication->check_permission_redirect('sub_permission_1', FALSE)) {
                $sub_id = $this->session->userdata('USERID');
                $this->db->where('created_by',$sub_id);
            }
            $this->db->from('adhi_recruiter');
            $TOTAL = $this->db->count_all_results();
            return $TOTAL;
		
	}
        
        /**
	 * function to add the recruiter
	 *
	 * @param unknown_type $details
	 * @return unknown
	 */
        
        function add_recruiter_details($details){
		return $this->db->insert('adhi_recruiter', $details); 
	}
        /**
	 * function to check whether email exists
	 *
	 * @param  $emailid
	 * @return unknown
	 */
        
        function checkrecruiter($emailid){
            $query= $this->db->query("select * from adhi_recruiter where recruiter_mail = '$emailid'");
            $result= $query->num_rows();
            return $result;
	}
        /**
	 * function to get the details of a single user
	 *
	 * @param int $userid
	 * @return user details
	 */
	function select_single_recruiterdetails($recruiterid){
		$this->db->where('adhi_recruiter_id',$recruiterid);
		$this->db->select ("*");
		$query	=	$this->db->get('adhi_recruiter');
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
	 * function to freeze the recruite
	 *
	 * @param unknown_type $details
	 * @return unknown
	 */
	function freeze_recruiter($details){
		
		$this->db->where('adhi_recruiter_id', $details['recruiterid']);
		$details	=	array('recruiter_status'     =>	0,
                                              'reason'	             =>	$details['reason'],
                                              'updated_by'           =>	$this->session->userdata('USERID'),
                                              'updated_date'         =>	convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'))
                                             );
		$updates	=	$this->db->update('adhi_recruiter', $details);
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
	 * function to activate the recruite
	 *
	 * @param unknown_type $details
	 * @return unknown
	 */
	function activate_recruiter($details){
		
		$this->db->where('adhi_recruiter_id', $details['recruiterid']);
		$details	=	array('recruiter_status'     =>	1,
                                              'reason'	             =>	$details['reason'],
                                              'updated_by'           =>	$this->session->userdata('USERID'),
                                              'updated_date'         =>	convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'))
                                             );
		$updates	=	$this->db->update('adhi_recruiter', $details);
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
	 * function to update the user details
	 *
	 * @param unknown_type $details
	 * @return unknown
	 */
	function update_recruiter_details($recruiter_id,$details){
		
                $this->db->where('adhi_recruiter_id', $recruiter_id);
		$updates	=	$this->db->update('adhi_recruiter', $details);
                 
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
	 * function to check whether the email is already exists or not
	 *
	 * @param int $userid
	 * @param varchar $email
	 * @return email address
	 */
	function check_recruiter_email($recruiterid,$email)
	{
		$this->db->where('adhi_recruiter_id !=',$recruiterid);
		$this->db->where('recruiter_mail',$email);
		$this->db->select ("recruiter_mail");
		$this->db->from('adhi_recruiter');
	  	$query	=	$this->db->get();
                
		return($query->result());
	}
	
        /**
	 * function to select all recruiter details
	 *
	 * @return recruiterdetails
	 */
	function get_all_recruiters ($recruiter_id = FALSE, $order_on = "adhi_recruiter_id") {
            if($recruiter_id){
                $this->db->where('adhi_recruiter_id',$recruiter_id);
            }
            
            $this->db->orderby($order_on,'ASC');
            $this->db->where(array('status' => 1, 'recruiter_status' => 1));
            if($this->authentication->logged_in ("admin") === "sub" && FALSE === $this->authentication->check_permission_redirect('sub_permission_1', FALSE)) {
                $sub_id = $this->session->userdata('USERID');
                $this->db->where('created_by',$sub_id);
            }
	    $query	=	$this->db->get('adhi_recruiter');
	    return($query->result_array()); 
	}

        /**
	 * function to select the licensure stage details
	 *
	 * @return recruiterdetails
	 */
	function get_all_licensure_stage ($licensure_id = FALSE) {
            
            if($licensure_id){
                $this->db->where('adhi_recruiter_licensure_stage_id',$licensure_id);
            }
            
            $this->db->orderby('adhi_recruiter_licensure_stage_id','ASC');
            $this->db->where(array('status' => 1));
	    $query	=	 $this->db->get('adhi_recruiter_licensure_stage');
	    return($query->result_array()); 
	}
        /**
	 * function to add the recruiter mail details
	 *
	 * @param unknown_type $details
	 * @return unknown
	 */
        
        function add_recruiter_mail_details($details){
            if(!empty($details)){
		if($this->db->insert('adhi_recruiter_send_mail', $details)){
                    return $this->db->insert_id();
                }
            }
            return FALSE;
	}
        
        /**
	 * function to update the recruiter mail details
	 *
	 * @param unknown_type $details
	 * @return unknown
	 */
        
        function update_recruiter_mail_details($id,$details){
            if(!empty($details)){
                $this->db->where(array('adhi_recruiter_send_mail_id' => $id,'mail_status' => 2, 'status' => 1));
                $this->db->set($details);
		$this->db->update('adhi_recruiter_send_mail');
                return TRUE; 
            }
            return FALSE;
	}
        
        /**
	 * function to get recruiter mail details
	 *
	 * @param unknown_type $details
	 * @return unknown
	 */
        
        function get_recruiter_mail_details($recruiter_mail_id = FALSE ,$mail_status = ''){
            if($recruiter_mail_id){
                $this->db->where('RSM.adhi_recruiter_send_mail_id',$recruiter_mail_id);
            }
            
            $this->db->orderby('RSM.adhi_recruiter_send_mail_id','DESC');
            
            if($mail_status != ''){
                 $this->db->where(array('RSM.mail_status' => $mail_status));
            }
            
            $this->db->join('adhi_recruiter_licensure_stage AS RLS','RLS.adhi_recruiter_licensure_stage_id = RSM.stage_of_licensure','LEFT');
            $this->db->join('adhi_recruiter AS R','R.adhi_recruiter_id = RSM.recruiter_referred','LEFT');
            $this->db->where(array('RSM.status' => 1));
	    $query	=	 $this->db->get('adhi_recruiter_send_mail AS RSM');
            
//            print '<pre>';
//            echo $this->db->last_query();
//            print_r($query->row_array());
//            exit;
	    return($query->row_array()); 
	}
        /**
	 * function to get mail template
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
	    return($query->result_array()); 
	}
        
        /**
	 * function to get last inserted row (if session gets cleared)
	 *
	 * @return unknown
	 */
        
        function get_last_row_recruiter_data(){
            $this->db->select('*');
            $this->db->from('adhi_recruiter_send_mail');
            $this->db->orderby('adhi_recruiter_send_mail_id','DESC');
            $this->db->limit(1);
            $this->db->where(array('status' => 1));
	    $query	=	 $this->db->get();
	    return($query->row_array()); 
	}
        
        /**
	 * function to check whether the email is already exists or not
	 *
	 * @param int $userid
	 * @param varchar $email
	 * @return email address
	 */
	
	function get_admin_details(){
		$query= $this->db->query("select firstname,lastname,emailid,company_name,company_address,state,city,zpcode,country,phone   from adhi_admin");
		return $query->result_array();
	}
	/**
	 * function to get the count of recruiter details
	 *
	 * @return count of recruiters
	 */
	function qry_recruitermail_details ($num,$offset = 0,$srchFname = '',$srchLname = '',$srchEmail = '', $srcBrokerage = '',$start_date = '',$end_date = '',$type=''){
            if($type == 'count'){
                $factor = 'recruiter_brokerage';
                $order_by = "AR.recruiter_brokerage";
            } else{
                $factor = 'recruiter_referred';
                $order_by = "AM.recruiter_referred";
            }
           
            $this->db->select('*');
            if('' != $srchFname)
                $this->db->like('AR.recruiter_name',$srchFname,'both');
            if('' != $srchLname)
                $this->db->like('AR.recruiter_last_name',$srchLname,'both');
	    if('' != $srchEmail)
    		$this->db->like('AR.recruiter_mail',$srchEmail,'both');
            if('' != $srcBrokerage)
                $this->db->where('AR.recruiter_brokerage',$srcBrokerage);
            if('' != $start_date)
    		$this->db->where('DATE(AM.created_date) >=',$start_date);
            if('' != $end_date)
                $this->db->where('DATE(AM.created_date) <=',$end_date);
            
            if('' != $num && '' != $offset){
                 $this->db->limit($num,$offset);
            }
            $this->db->where('AM.mail_status',1);
            $this->db->join('adhi_recruiter as AR', 'AR.adhi_recruiter_id = AM.recruiter_referred');
            $this->db->from('adhi_recruiter_send_mail as AM');
            $this->db->orderby($order_by,'ASC');
            $query	=	$this->db->get();
            $result = $query->result();
            
            if(!empty($result)){
                $rec_id = array();
                $i = -1;
                $initial_id          =        '';
                
                foreach($result as $r){
                    if($initial_id != $r->$factor){
                        $i++;
                        $rec_id[$i]['id']          =        $initial_id     =       $r->$factor;
                        $rec_id[$i]['name']        =        $r->recruiter_name;
                        $rec_id[$i]['full_name']   =        $r->recruiter_name.' '.$r->recruiter_last_name;
                        $rec_id[$i]['mail_id']     =        $r->recruiter_mail;
                        $rec_id[$i]['brokerage']   =        $r->recruiter_brokerage;
                        $rec_id[$i]['status']      =        $r->recruiter_status;
                        $rec_id[$i]['count']       =        1;
                    } else{
                        $rec_id[$i]['count'] += 1;
                    }
                }
                
                return($rec_id); 
            } else{
                return FALSE;
            }
            
	}
        
        function getRecruiterMailCount(){
            $this->db->select('adhi_recruiter_send_mail_id');
            $this->db->where('mail_status',1);
            $this->db->from('adhi_recruiter_send_mail');
            $TOTAL = $this->db->count_all_results();
            return $TOTAL;
        }
        
        
        function get_brokerage_report($from,$to,$brokerage,$first_name,$last_name,$email_id,$num,$offset,$type){
            $this->db->select ("COUNT(*) AS count,RSM.student_first_name,RSM.student_last_name,RSM.student_mail_id,RSM.student_phone_number,RSM.area_of_interest,RSM.created_date,R.recruiter_brokerage,RSM.recruiter_referred,RSM.adhi_recruiter_send_mail_id as id");
            $this->db->from('adhi_recruiter_send_mail as RSM');
            
            if("data" == $type){
                $this->db->limit($num,$offset);
            }
            if("" != $from){
                $this->db->where ("DATE_FORMAT(RSM.created_date, '%Y/%m/%d') >=", date("Y/m/d",strtotime($from)));
            }
            
            if("" != $to){
                $this->db->where ("DATE_FORMAT(RSM.created_date, '%Y/%m/%d') <=", date("Y/m/d",strtotime($to)));
            }
            
            if(is_array($brokerage)){
                $this->db->where_in("RSM.recruiter_referred",$brokerage);
            }else{
                $this->db->where ("RSM.recruiter_referred",$brokerage);
            }
            
            if("" != $first_name){
                $this->db->like ("RSM.student_first_name",$first_name, 'both');
            }
            
            if("" != $last_name){
                $this->db->like ("RSM.student_last_name",$last_name, 'both');
            }
            
            if("" != $email_id){
                $this->db->where ("RSM.student_mail_id",$email_id);
            }
            
            $this->db->order_by('RSM.created_date','ASC');
            $this->db->where(array('RSM.status' => 1, 'RSM.mail_status' => 1));
            $this->db->join('adhi_recruiter AS R','R.adhi_recruiter_id = RSM.recruiter_referred','LEFT');
            $this->db->group_by(array("RSM.student_mail_id","RSM.recruiter_referred"));
	    $query	=	$this->db->get();
            
	    return($query->result_array()); 
        }
        
        function get_brokerage_detail($id){
            if($id){
                $this->db->select('student_mail_id,recruiter_referred');
                $this->db->from('adhi_recruiter_send_mail');
                $this->db->where('adhi_recruiter_send_mail_id',$id);
                $query = $this->db->get();
                
                if($query->num_rows() > 0){
                    $result = $query->row_array();
                    
                    $this->db->select('RSM.*,R.recruiter_brokerage,R.recruiter_name,R.recruiter_last_name,R.recruiter_mail');
                    $this->db->from('adhi_recruiter_send_mail as RSM');
                    $this->db->join('adhi_recruiter AS R','R.adhi_recruiter_id = RSM.recruiter_referred','LEFT');
                    $this->db->where(array('RSM.student_mail_id' => $result['student_mail_id'],'RSM.recruiter_referred' => $result['recruiter_referred'],'RSM.mail_status' => 1,'RSM.status' => 1));
                    $query = $this->db->get();
                    
                    return $query->result_array();
                }
            }
        }
        
        function get_all_licensure_stages(){
            $this->db->select('adhi_recruiter_licensure_stage_id as id,adhi_recruiter_licensure_stage_name as name');
            $this->db->from('adhi_recruiter_licensure_stage');
            $query = $this->db->get();

            if($query->num_rows() > 0){
                return $query->result_array();
            }

            return array();
        }
        
        function checkPriorExists($email,$recruiter_id){
            if("" != $email && "" != $recruiter_id){
                $this->db->select('created_date,recruiter_referred');
                $this->db->from('adhi_recruiter_send_mail');
                $this->db->where(array('student_mail_id' => $email,'recruiter_referred' => $recruiter_id,
                    'mail_status' => 1,'status' => 1));
                $query = $this->db->get();
                
                if($query -> num_rows() > 0){
                   return $query->result_array();
                }
            }
            
            return array();
        }
}