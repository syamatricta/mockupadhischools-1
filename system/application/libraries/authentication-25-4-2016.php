<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 *
 * @package		CodeIgniter
 * @author		
 * @link		http://adhischools.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

	class Authentication
	{
		var $CI = null;

		function Authentication ()
		{
			$this->CI =& get_instance ();
		}
		
		/**
		 * function for admin login process
		 * 
		 * @package		CodeIgniter
		 * @author		
		 * @link		http://adhischools.com
		 * @return unknown
		 */
		function process_admin_login ($login = NULL, $request = '')
		{
			$status			 = $this->CI->config->item('user_status');
		    
    			if (!is_array ($login) || 0 >= count ($login))
    			{
    				return FALSE;
    			}
    			$username        = $login['username'];
    			$password        = $login['password'];		       

				$this->CI->db->select ("id AS USERID, firstname AS FIRST_NAME,username AS USERNAME, emailid AS EMAIL, user_type");
				$this->CI->db->where ('username', $username);
				$this->CI->db->where ('password', md5($password));
				$select_query    = $this->CI->db->get ('adhi_admin');			
	
				if (0 < $select_query->num_rows ())
				{
					$row 			= $select_query->row();    
					return $row;
				}
				else 	
					return false;
		}
                
                /**
		 * function for otp rocess
		 * 
		 * @package		CodeIgniter
		 * @author		
		 * @link		http://adhischools.com
		 * @return unknown
		 */
		function process_admin_otp ($row = array())
		{
                    if(!empty($row)){
			$session_data 	= array (
                                        'USERID'        => $row->USERID,
                                        'USERNAME'      => $row->USERNAME,
                                        'USER_NAME'   	=> $row->FIRST_NAME,
                                        'EMAIL'         => $row->EMAIL,	  
                                        'USERTYPE' 	=> 'A',
                                        'ADMINTYPE'     => $row->user_type                                       
                        );
                        $this->CI->session->set_userdata ($session_data);
                        return true;
                    }
                    return false;
		}
                
		
		/**
		 * function for users login process
		 * 
		 * @package		CodeIgniter
		 * @author		
		 * @link		http://adhischools.com
		 * @return unknown
		 */
		
		function process_user_ajax_login ($login = NULL, $request = '')
		{
			$status			 = $this->CI->config->item('user_status');
		    
		    /*if($this->CI->input->cookie('MA8_OUCID', TRUE))
		    {
		        $user_details =   $this->CI->input->cookie('MA8_OUCID', TRUE);
			    $this->CI->load->library('encrypt');
			    $decrypted_string = $this->CI->encrypt->decode($user_details, "asdfdsa");	
			    $user_data        = explode("#$",$decrypted_string);
    	        $username         = $user_data[1];
			    $password         = $user_data[0];
		    }
		    else
		    {
		    */
    			if (!is_array ($login) || 0 >= count ($login))
    			{
    				return FALSE;
    			}
    			$username        = $login['username'];
    			$password        = $login['password'];		        
		    //}

			

			$this->CI->db->select ("id AS USERID, firstname AS FIRST_NAME, lastname as LAST_NAME, emailid AS USERNAME, emailid AS EMAIL,status as STATUS");
			$this->CI->db->where ('emailid', $username);
			$this->CI->db->where ('password', md5($password));
			
			$select_query    = $this->CI->db->get ('adhi_user');	

			if (0 < $select_query->num_rows ())
			{
				
				$row 			= $select_query->row();   

				if($this->checkUserUniqueLogin($row->USERID,$row->EMAIL,$login['forced_login'])){
					
					if($this->checkUserExamMode($row->USERID,$login['forced_login'])){
				
		                $session_data 	= array (
		                                           	'USERID'        => $row->USERID,
		                                           	'USERNAME'      => $row->EMAIL,
		                                           	'USER_NAME'   	=> $row->FIRST_NAME,
		                                           	'LAST_NAME'   	=> $row->LAST_NAME,
		                                           	'EMAIL'         => $row->EMAIL,	
		                                           	'STATUS' 		=>$row->STATUS, 
		                                           	'USERTYPE' 		=>	'N'                                       
		                              	        );
		      	        if($session_data['STATUS']=='A'){
		      	      
		      	        	//notneed
		      	        	//$this->update_score($row->USERID);// function for updating the exam score when a user logged before exam end 
		      	        	
		      	        	$array = array('quiz_status' =>1,'quiz_end'=>convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')));
							$select_query    = $this->CI->db->set($array);
		      	        	$select_query    = $this->CI->db->where ('user_id',$row->USERID);
							$select_query    = $this->CI->db->update ('adhi_user_quiz');
							
							$this->CI->session->set_userdata ($session_data);
							
							 
							$response['status']="success";
							$response['error_status']= 'success';
							$response['msg']="";	
		      	        }else{
		      	        	return 'freezed';
							$response['status']="error";
							$response['error_status']= 'freezed';
							$response['msg']="Your Account is Freezed";	
		      	        }
					}else {
						$response['status']="error";
						$response['error_status']= 'login_exam_mode';
						$response['msg']="You are already in Exam mode";					 
					}
					
				}else {						 
						$response['status']="error";
						$response['error_status']= 'login_unique_page';
						$response['msg']="Already logged in, please login forcefully";	
				}
				
			}
			else {
				$response['status']="error";
				$response['error_status']= 'invalid';
				$response['msg']="Invalid Login";
			}	
			return $response;
		}
		
		
		/**
		 * function for users login process
		 * 
		 * @package		CodeIgniter
		 * @author		
		 * @link		http://adhischools.com
		 * @return unknown
		 */
		
		function process_user_login ($login = NULL, $request = '')
		{
			$status			 = $this->CI->config->item('user_status');
		    
		    /*if($this->CI->input->cookie('MA8_OUCID', TRUE))
		    {
		        $user_details =   $this->CI->input->cookie('MA8_OUCID', TRUE);
			    $this->CI->load->library('encrypt');
			    $decrypted_string = $this->CI->encrypt->decode($user_details, "asdfdsa");	
			    $user_data        = explode("#$",$decrypted_string);
    	        $username         = $user_data[1];
			    $password         = $user_data[0];
		    }
		    else
		    {
		    */
    			if (!is_array ($login) || 0 >= count ($login))
    			{
    				return FALSE;
    			}
    			$username        = $login['username'];
    			$password        = $login['password'];		        
		    //}

			

			$this->CI->db->select ("id AS USERID, firstname AS FIRST_NAME, lastname as LAST_NAME, emailid AS USERNAME, emailid AS EMAIL,status as STATUS");
			$this->CI->db->where ('emailid', $username);
			$this->CI->db->where ('password', md5($password));
			
			$select_query    = $this->CI->db->get ('adhi_user');	

			if (0 < $select_query->num_rows ())
			{
				
				$row 			= $select_query->row();   

				if($this->checkUserUniqueLogin($row->USERID,$row->EMAIL,$login['forced_login'])){
					
					if($this->checkUserExamMode($row->USERID,$login['forced_login'])){
				
		                $session_data 	= array (
		                                           	'USERID'        => $row->USERID,
		                                           	'USERNAME'      => $row->EMAIL,
		                                           	'USER_NAME'   	=> $row->FIRST_NAME,
		                                           	'LAST_NAME'   	=> $row->LAST_NAME,
		                                           	'EMAIL'         => $row->EMAIL,	
		                                           	'STATUS' 		=>$row->STATUS, 
		                                           	'USERTYPE' 		=>	'N'                                       
		                              	        );
		      	        if($session_data['STATUS']=='A'){
		      	      
		      	        	//notneed
		      	        	//$this->update_score($row->USERID);// function for updating the exam score when a user logged before exam end 
		      	        	
		      	        	$array = array('quiz_status' =>1,'quiz_end'=>convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')));
							$select_query    = $this->CI->db->set($array);
		      	        	$select_query    = $this->CI->db->where ('user_id',$row->USERID);
							$select_query    = $this->CI->db->update ('adhi_user_quiz');
							
							$this->CI->session->set_userdata ($session_data);
							
							return 'success';
		      	        }else{
		      	        	return 'freezed';
		      	        }
					}else {
						
						$this->CI->session->set_flashdata('error', 'You are already in Exam mode');
						redirect ($this->CI->config->item ('login_exam_mode'));
					}
					
				}else {
						$this->CI->session->set_flashdata('error', 'Already logged in, please login forcefully');
						redirect ($this->CI->config->item ('login_unique_page'));
				}
				
			}
			else 	
				return false;
		}
		
		
		/**
		 * function for updating score
		 */
		
		//notneed
		/*
		function update_score($id){
			$this->CI->load->model('course_model');
			$this->CI->load->model('user_exam_model');
			$this->CI->db->select ("*");
			$this->CI->db->where ('user_id ',$id);
			$this->CI->db->where ('exam_status != ','1');
			
			$query    = $this->CI->db->get ('adhi_user_exam');
			$result	  =  $query->result();
			
			
			if($result){
				
				for($i=0;$i<count($result);$i++){
					
					$this->CI->db->select ("*");
					$this->CI->db->where ('course_id',$result[$i]->course_id);
					$this->CI->db->where ('user_id',$result[$i]->user_id);
					$query_res    = $this->CI->db->get ('adhi_user_exam_details');
					$result_det	  =  $query_res->result();
					
					if($result_det){
								
							$grade	=	$this->CI->user_exam_model->get_grade($result_det[$i]->exam_score);
							
							if($grade)
								$status='P';
							else 
								$status='F';
								//notneed
								//$data=$this->CI->course_model->update_score($result[$i]->user_id,$status,$result_det[$i]->user_course_id,$result_det[$i]->exam_score,$result_det[$i]->id);
							
						}else{
							//echo $exam_mode->course_id;die();
							$this->CI->course_model->update_score_fail($result[$i]->user_id,'F',$result[$i]->course_id,0);
						}
						
						
					//}else{
					//	
					//	$score=0;
					//	$status='F';
					//	$array = array('final_score' => $score, 'status' => $status);
					//	$this->db->set($array);
					//	$this->db->where('userid',$result[$i]->user_id);
					//	$this->db->where('courseid',$result[$i]->course_id);
					//	$this->db->update('adhi_user_course');
					//	
					//}
					$id_exam	 	 =	$result[$i]->id	;
					$array = array('exam_status' =>1,'exam_end'=>convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')));
					
					
					$select_query    = $this->CI->db->set($array);
					
					$select_query    = $this->CI->db->where ('id',$id_exam);
					
					$select_query    = $this->CI->db->update ('adhi_user_exam');
				}
				
				return true;
			}
			
			
		}
		*/
		
		
		
		/**
		 *function to check user in Exam mode
		 * 
		 * @package		CodeIgniter
		 * @author		
		 * @link		http://adhischools.com
		 */
		
		function checkUserExamMode($userid,$forced_login){
                   
			$past_date=	convert_UTC_to_PST_datetime(date("Y-m-d H:i:s", time()-(9000)));
			$this->CI->db->select ("*");
			
			$where = "exam_start between '".$past_date."'  and  '".convert_UTC_to_PST_datetime(date("Y-m-d H:i:s"))."'";
			
			$select_query    = $this->CI->db->where ('user_id',$userid);
			//$select_query    = $this->CI->db->where ('exam_start >',$past_date);
			$select_query    = $this->CI->db->where ($where);
			
			$select_query    = $this->CI->db->get ('adhi_user_exam');
			
			if (0 < $select_query->num_rows ()){
				if($forced_login){
			/*	$select_query    = $this->CI->db->where ('user_id',$userid);
				$select_query    = $this->CI->db->delete ('adhi_user_exam');	*/
					return TRUE;
				}else
					return TRUE;
			}else 
				return TRUE;
			
		}

		
		/**
		 *function to check unique login
		 * 
		 * @package		CodeIgniter
		 * @author		
		 * @link		http://adhischools.com
		 */
		
		function checkUserUniqueLogin($userid,$email,$forced_login){
			 $this->CI->load->model('user_model');
			$this->CI->db->select ("user_data,session_id");
			$select_query    = $this->CI->db->get ('ci_sessions');	

			if (0 < $select_query->num_rows ())
			{
				
					// Is there custom data?  If so, add it to the main session array
				$row = $select_query->result();
				
				foreach($row as $row){
					
					if (isset($row->user_data) AND $row->user_data != ''){
						$custom_data = $this->CI->session->_unserialize($row->user_data);
                                                //echo '<pre>';
						//print_r($custom_data);
						
						if (is_array($custom_data))
						{
							/*foreach ($custom_data as $val)
							{*/	//print_r($custom_data);die();
								//$session[$key] = $val;
								
								if(isset($custom_data['EMAIL'])){// echo $custom_data['EMAIL']; die();
									if($custom_data['EMAIL']==$email && $custom_data['USERID']==$userid){
										if($forced_login){
                                                                                   // $this->CI->user_model->vb_forcelogout($email);
											$del_query    		= $this->CI->db->where ('session_id',$row->session_id);
											$select_query    	= $this->CI->db->delete('ci_sessions');
                                                                                        
											return TRUE;
										}else
											return FALSE;
									}
										

									//echo $custom_data['EMAIL'].'=='.$email .'&&'. $custom_data['USERID'].'=='.$userid;die();//return FALSE;
							}
						}
					}
				}return TRUE;
			}else 
				return TRUE;
			
		}
		
		
		/**
		 * function for logout
		 * 
		 * @package		CodeIgniter
		 * @author		
		 * @link		http://adhischools.com
		 * @return unknown
		 */
		function logout ()
		{
           
			$this->CI->session->sess_destroy();
			return TRUE;
		}
		
		/**
		 * To avoid the unauthorized access
		 * 
		 * @package		CodeIgniter
		 * @author		
		 * @link		http://adhischools.com
		 * @return unknown
		 */
		function UserHasAccess( $required_role){
			if($required_role=='admin'){
				if ($this->CI->session->userdata ('USERTYPE')!='A')
					return FALSE;
			}			
			if($required_role=='normal'){
				if ($this->CI->session->userdata ('USERTYPE')!='N')
					return FALSE;
			}
			return TRUE;
			
		}

 
		/**
		 * To checked whether the user is logged in or not
		 * 
		 * @package		CodeIgniter
		 * @author		
		 * @link		http://adhischools.com
		 * @return unknown
		 */
		function logged_in ($user_type = "normal")
		{
			switch ($user_type) {
				case "normal"://echo $this->CI->session->userdata ('USERID');
					if (!$this->CI->session->userdata ('USERID')) 
						return FALSE;
					
					// suppose admin has blocked the user after user logged in then
					// we have to logout the user and redirect to login page with proper staus
					
					if(!$this->Checkuserstatus($this->CI->session->userdata ('USERID'))){
						$this->logout();
						redirect ($this->CI->config->item ('login_page'));
						//$session_data['CHECKUSERSTATUS']='User Account is Freezed';
						//$this->CI->session->set_userdata ($session_data);
						return FALSE;
					}
					if(!$this->UserHasAccess('normal')){
						return FALSE;
					}
					return TRUE;
					
					break;					
				case "admin":
                                    	if (!$this->CI->session->userdata ('USERID'))
						return FALSE;
					else if(!$this->UserHasAccess('admin')){
						return FALSE;
					}
					elseif($this->CI->session->userdata ('ADMINTYPE') == 2) {
                                            return "sub";
                                        }
					return TRUE;
					break;					
				default:
					return FALSE;
			}
		}
		
		function user_logged_in ()
		{
			 
			if (!$this->CI->session->userdata ('USERID')) 
				return FALSE;
					
			 
			if(!$this->Checkuserstatus($this->CI->session->userdata ('USERID'))){
				$this->logout();				 
				return FALSE;
			}
			if(!$this->UserHasAccess('normal')){
				return FALSE;
			}
			return TRUE;
			 
		}
		/**
		 * To checked whether the user is an active user
		 * 
		 * @package		CodeIgniter
		 * @author		
		 * @link		http://adhischools.com
		 * @return unknown
		 */
		function Checkuserstatus($user_id)
		{
			//$status			 =$this->CI->config->item('user_status');
			//$status			 = 'A';
			$this->CI->db->select ("id");
			$this->CI->db->where ('id', $user_id);
			//$this->CI->db->where ('status', $status['active']);
			$this->CI->db->where ('status', 'A');

			$select_query    = $this->CI->db->get ('adhi_user');
			if (0 < $select_query->num_rows ())
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
                /**
		 * TUpdate all reinstae expired cases
		 * 
		 * @package		CodeIgniter
		 * @author		
		 * @link		http://adhischools.com
		 * @return unknown
		 */
                function reinstate_expired_update(){
                        $this->CI->db->select ("reinstate_id,user_course_id");
			$this->CI->db->where (array('status' =>  1));
                        $this->CI->db->where("DATEDIFF( reinstate_to, date_format(  DATE_SUB( NOW( ) , INTERVAL 8 HOUR ) , '%Y-%m-%d') ) < 0");
			$select_query    = $this->CI->db->get ('adhi_reinstate_details');
                        
			if (0 < $select_query->num_rows ())
			{
                               $res = $select_query->result_array();
                               
                               if(!empty($res)){
                                   foreach($res as $r){
                                        $this->CI->db->where(array('reinstate_id' => $r['reinstate_id']));
                                        $this->CI->db->set(array('status' => 0));
                                        $this->CI->db->update('adhi_reinstate_details');
                                       
                                        $this->CI->db->where(array('id' => $r['user_course_id']));
                                        $this->CI->db->set(array('reinstate_status' => 0));
                                        $this->CI->db->update('adhi_user_course');
                                     }
                               }
			}
                    return TRUE;
                }

	}
// End of library class
// Location: system/application/libraries/authentication.php
