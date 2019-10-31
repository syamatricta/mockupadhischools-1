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

				$this->CI->db->select ("id AS USERID, firstname AS FIRST_NAME,username AS USERNAME, emailid AS EMAIL, user_type, sub_admin_permission");
				$this->CI->db->where ('username', $username);
				$this->CI->db->where ('password', md5($password));
				$select_query    = $this->CI->db->get ('adhi_admin');			
	
				if (0 < $select_query->num_rows ())
				{
					$row 			= $select_query->row();    
                                        
                                        /*
                                        if(ENVIRONMENT == 'production'){
                                            return $row;
                                        }else{
                                            $this->process_admin_otp($row);
                                        }
                                        */
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
                                        'ADMINTYPE'     => $row->user_type,                                       
                                        'SUB_PERMISSION'=> $row->sub_admin_permission                                       
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

			if (0 < $select_query->num_rows ()){
				
				$row 			= $select_query->row();   

				if($this->checkUserUniqueLogin($row->USERID,$row->EMAIL,$login['forced_login'])){
					
                                    if($this->checkUserExamMode($row->USERID,$login['forced_login'])){
                                        
                                        /* Removing Trial session data */
                                        $session_data 	= array (
                                            'TRIAL_USERID'  => '',
                                            'USERNAME'      => '',
                                            'USER_NAME'     => '',
                                            'LAST_NAME'     => '',
                                            'EMAIL'         => '',
                                            'PHONE'         => '',
                                            'STATUS'        => '',
                                            'USERTYPE'      => '',
                                            'ACTIVATED_AT'  => ''
                                        );
                                        $this->CI->session->unset_userdata($session_data);
                                        
                                        
                                        $session_data 	= array (
		                                           	'USERID'        => $row->USERID,
		                                           	'USERNAME'      => $row->EMAIL,
		                                           	'USER_NAME'   	=> $row->FIRST_NAME,
		                                           	'LAST_NAME'   	=> $row->LAST_NAME,
		                                           	'EMAIL'         => $row->EMAIL,
		                                           	'STATUS' 	=> $row->STATUS,
		                                           	'USERTYPE' 	=> 'N'
		                              	        );
                                        if($session_data['STATUS']=='A'){

                                                /* Whether the user Online account or Live. Purpose : "find a class" button should not show in online account */
                                                $query  = $this->CI->db->query("select auct.course_type from adhi_user_course_types auct JOIN adhi_user au ON auct.id=au.course_user_type  where au.id = {$row->USERID}");
                                                $result = $query->row();
                                                if($result && isset($result->course_type)){
                                                    $session_data['COURSE_TYPE']    = $result->course_type;
                                                }
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
                                                $response['status']="error";
                                                $response['error_status']= 'freezed';
                                                $response['msg']="Your Account is Freezed. Please contact Administrator";	
                                        }
                                    }else {
                                            $response['status']         = "error";
                                            $response['error_status']   = 'login_exam_mode';
                                            $response['msg']            = "You are already in Exam mode";					 
                                    }
					
				}else {						 
						$response['status']="error";
						$response['error_status']= 'login_unique_page';
						$response['msg']="Already logged in, please login forcefully";	
				}
                                $response['user_type'] = 'normal';
				
			}else if($user = $this->_exist_trial_account($username, $password)){
                            $response['user_type']          = 'trial';
                            if(0 == $user->status){
                                $response['status']         = 'error';
                                $response['error_status']   = 'trial_user_pending_status';
                                $response['msg']            = 'Your trial account not yet activated, please verify your email.';
                            }else if(1 == $user->status){
                                $this->CI->load->model('admin_trial_account_model');
                                $settings                   = $this->CI->admin_trial_account_model->getSettings();
                                $today  = strtotime(convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')));
                                $check  = strtotime($user->activated_at.' +'. $settings->validity_days .' days');
                                if($today > $check){
                                    $response['status']         = 'error';
                                    $response['error_status']   = 'trial_period_expired';
                                    $response['msg']            = 'Your Trial account is expired.';
                                }else{
                                    $session_data 	= array (
                                            'USERID'        => '',
                                            'USERNAME'      => '',
                                            'USER_NAME'   	=> '',
                                            'LAST_NAME'   	=> '',
                                            'EMAIL'         => '',
                                            'STATUS' 	=> '',
                                            'USERTYPE'      => '',
                                            'COURSE_TYPE'   => ''
                                    );
                                    $this->CI->session->unset_userdata($session_data);

                                    $session_data 	= array (
                                            'TRIAL_USERID'  => $user->id,
                                            'USERNAME'      => $user->username,
                                            'USER_NAME'   	=> $user->first_name,
                                            'LAST_NAME'   	=> $user->last_name,
                                            'EMAIL'         => $user->email,
                                            'PHONE'         => $user->phone,
                                            'STATUS' 	=> $user->status,
                                            'USERTYPE'      => 'T',
                                            'ACTIVATED_AT'  => $user->activated_at
                                    );
                                    $this->CI->session->set_userdata($session_data);

                                    $response['status']         = 'success';
                                    $response['error_status']   = 'trial_login_success';
                                    $response['msg']            = '';
                                }
                            }else if(2 == $user->status){
                                $response['status']         = 'error';
                                $response['error_status']   = 'adhi_user_not_in_db';
                                $response['msg']            = 'Sorry it looks like you are trying to login with the password from your guest account, 
                                                                     not the one you registered with.  Enter the right password or 
                                                             <a class="loginlinks" data-sec="login" href="#">click here </a> to reset it.';
                            }else if(3 == $user->status){
                                $response['status']         = 'error';
                                $response['userid']         =  $user->id;
                                $response['error_status']   = 'trial_period_expired';
                                $response['msg']            = 'Your Trial account is expired.';
                            }
			}else {
				$response['status']="error";
				$response['error_status']= 'invalid';
				$response['msg']="Invalid Login";
			}
			return $response;
		}
		
                function _exist_trial_account($username, $password){
                    $this->CI->db->select("id, first_name, last_name, email, phone, status, activated_at");
                    $this->CI->db->where('email', $username);
                    $this->CI->db->where('password', md5($password));
                    $result    = $this->CI->db->get ('adhi_trial_users');
                    return (0 < $result->num_rows ()) ? $result->row() : FALSE;
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
                        if($required_role=='trial'){
				if ($this->CI->session->userdata ('USERTYPE')!='T')
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
                                case 'trial':
                                        if(!$this->CI->session->userdata ('TRIAL_USERID')){
						return FALSE;
                                        }else if(!$this->UserHasAccess('trial')){
						return FALSE;
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
                
                
                function userAutoLogin($user_id){
                    $this->CI->db->select ("id AS USERID, firstname AS FIRST_NAME, lastname as LAST_NAME, emailid AS USERNAME, emailid AS EMAIL,status as STATUS");
                    $this->CI->db->where ('id', $user_id);
                    $select_query    = $this->CI->db->get ('adhi_user');	
                    if (0 < $select_query->num_rows ()){
                        $row 			= $select_query->row();

                        /* Removing Trial session data */
                        $session_data 	= array (
                            'TRIAL_USERID'  => '',
                            'USERNAME'      => '',
                            'USER_NAME'     => '',
                            'LAST_NAME'     => '',
                            'EMAIL'         => '',
                            'PHONE'         => '',
                            'STATUS'        => '',
                            'USERTYPE'      => '',
                            'ACTIVATED_AT'  => ''
                        );
                        $this->CI->session->unset_userdata($session_data);

                        $session_data 	= array (
                                                        'USERID'        => $row->USERID,
                                                        'USERNAME'      => $row->EMAIL,
                                                        'USER_NAME'   	=> $row->FIRST_NAME,
                                                        'LAST_NAME'   	=> $row->LAST_NAME,
                                                        'EMAIL'         => $row->EMAIL,
                                                        'STATUS' 	=> $row->STATUS,
                                                        'USERTYPE' 	=> 'N'
                                                );
                        if($session_data['STATUS'] == 'A'){

                            /* Whether the user Online account or Live. Purpose : "find a class" button should not show in online account */
                            $query  = $this->CI->db->query("select auct.course_type from adhi_user_course_types auct JOIN adhi_user au ON auct.id=au.course_user_type  where au.id = {$row->USERID}");
                            $result = $query->row();
                            if($result && isset($result->course_type)){
                                $session_data['COURSE_TYPE']    = $result->course_type;
                            }
                            //notneed
                            //$this->update_score($row->USERID);// function for updating the exam score when a user logged before exam end 

                            $array = array('quiz_status' =>1,'quiz_end'=>convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')));
                            $select_query    = $this->CI->db->set($array);
                            $select_query    = $this->CI->db->where ('user_id',$row->USERID);
                            $select_query    = $this->CI->db->update ('adhi_user_quiz');

                            $this->CI->session->set_userdata ($session_data);

                            $response['status']         = 'success';
                            $response['error_status']   = 'success';
                            $response['msg']            = '';                                
                        }else{
                            $response['status']         = 'error';
                            $response['error_status']   = 'freezed';
                            $response['msg']            = 'Your Account is Freezed';
                        }
                    }else{					 
                        $response['status']         = 'error';
                        $response['error_status']   = 'invalid';
                        $response['msg']            = 'Invalid request';
                    }
                    $response['user_type']          = 'normal';
                    return $response;
                
                }
            function check_permission_redirect($role_type, $redirect = TRUE){
                switch ($role_type) {
                    case 'sub_permission_1':
                        if(1 != $this->CI->session->userdata ('SUB_PERMISSION')){
                            if($redirect){
                                $this->CI->session->set_flashdata('error', "Unauthorized access");
                                redirect('/admin/home');
                            }else{
                                return FALSE;
                            }
                        }else{
                            return TRUE;
                        }                   
                        break;
                    case 'super_admin':
                        if(1 == $this->CI->session->userdata ('ADMINTYPE')){
                            return TRUE;
                        }
                        return FALSE;
                        break;
                    default:
                        return FALSE;
                        break;
                }
                
            }
	}
// End of library class
// Location: system/application/libraries/authentication.php
