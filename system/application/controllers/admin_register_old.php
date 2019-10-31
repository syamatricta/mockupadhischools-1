<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User Controller
 *
 * @package		CodeIgniter
 * @subpackage	Controllers
 * @category	Controllers
 * @author		MNU
 * @link		http://ahischools.com/admin_register/
 */

// ------------------------------------------------------------------------

class Admin_Register extends Controller {
		
		var $gen_contents = array();
		var $order_contents = array();
		var $user_contents = array();
		var $payment_contents =array();
		var $ship_contents =array();
		var $course_contents =array();
		var $admin_contents =array();
		var $order_updates =array();
		var $mail_contents = array();
		var $new_payment_contents =array();
		var $new_ship_contents=array();
		var $new_order_contents =array();
		var $new_mail_contents = array();
		var $course_det =array();
		var $renew_mail_contents =array();
		
	function Admin_Register(){
		parent::Controller();
						
			$this->load->model('Common_model');
			$this->load->model('admin_user_model');
			$this->load->model('user_model');
			
			$this->gen_contents['css'] = array('style.css','dhtmlgoodies_calendar.css','admin_register.css' ,'admin_style.css');
			$this->gen_contents['js'] = array('admin_register.js','popcalendar.js');
			
			
		}
	
		function index() {
			
			
			if($this->authentication->logged_in('admin')){
				
				$this->register();
			}
			else{
				redirect("admin/login");
			}
			
		}
		
		/**
		 * function for registering user
		 */
		
		function register(){
			
			// regisration step 1
			if($this->input->post('step1') == 1){
				$this-> _int_user_register_step1();
			}
			//default case
			if(!$_POST){
			
				
				$this->load->helper("form");			
								
				$this->load->view("admin/admin_register_heading",$this->gen_contents);	
				
				$captcha                     = $this->user_model->generate_captcha ();		
					
				$this->session->set_userdata ("captcha_word", $captcha['word']);
				
				$this->gen_contents['captcha_details']     = $captcha;	
				$this->gen_contents['state'] = $this->user_model->get_state();		
				$this->load->view('admin/register/admin_user_reg_step1',$this->gen_contents);			
				$this->load->view("admin_footer",$this->gen_contents);	
			
			}
		}
		
		/**
		 * function for valiadting the step registration
		 */
		
		function _int_user_register_step1() {		
			if(!empty($_POST)) {
						$this->load->model('user_model');
						$this->load->library("form_validation");
						
						//registration
						$this->_init_registration_rules();							
						if($this->form_validation->run() == TRUE) {								
							//
							$this->_init_user_regdetails();	
							$this->gen_contents['data']['admindetails'] = $this->user_model->get_admin();	
							$captcha_code =	$this->input->post('captcha_code');						
							$captcha_word = $this->session->userdata("captcha_word");						
							
							if ( !( isset($captcha_code) && isset ($captcha_word) &&  0 == strcmp ($captcha_code, $captcha_word) ) )	{
			
								$this->gen_contents['msg']= "InCorrect Verification Code";
								$this->load->model('user_model');
								$this->load->helper("form");	
								
								$this->load->view("admin/admin_register_heading",$this->gen_contents);
								$captcha                     = $this->user_model->generate_captcha ();		
					
								$this->session->set_userdata ("captcha_word", $captcha['word']);
								
								$this->gen_contents['captcha_details']     = $captcha;	
								$this->gen_contents['state'] = $this->user_model->get_state();		
								$this->load->view('admin/register/admin_user_reg_step1',$this->gen_contents);			
								$this->load->view("admin_footer",$this->gen_contents);						
								
							} else {
									
								$check =$this->user_model->checkuser($this->input->post('email'));							
								if($check<=0){
									$this->gen_contents['data']['step1'] =$this->input->post('step1');
									$this->session->set_userdata ($this->gen_contents['data']);									
									
									// step 2
									$this-> _int_user_register_course();
								} else {
										
										$this->gen_contents['msg']= "Email Already Exist";
										$this->load->model('user_model');
										$this->load->helper("form");
												
										$this->load->view("admin/admin_register_heading",$this->gen_contents);
										$captcha                     = $this->user_model->generate_captcha ();		
							
										$this->session->set_userdata ("captcha_word", $captcha['word']);
										
										$this->gen_contents['captcha_details']     = $captcha;	
										$this->gen_contents['state'] = $this->user_model->get_state();		
										$this->load->view('admin/register/admin_user_reg_step1',$this->gen_contents);			
										$this->load->view("admin_footer",$this->gen_contents);						

								}								
							}
						}
	
	
				}
	
		}
		/**
		 * function for form validation in step 1 registration
		 *
		 */
		function _init_registration_rules(){
		
			$this->form_validation->set_rules('firstname', 'FIRST NAME', 'required|max_length[128]');
			$this->form_validation->set_rules('lastname', 'LAST NAME', 'required|max_length[128]');
			$this->form_validation->set_rules('email', 'EMAIL', 'required|max_length[128]');
			$this->form_validation->set_rules('confirmemail', 'CONFIRM EMAIL', 'required|max_length[128]');
			$this->form_validation->set_rules('psword', 'PASSWORD', 'required');
			$this->form_validation->set_rules('psword1', 'CONFIRM PASSWORD', 'required');
			$this->form_validation->set_rules('address', 'ADDRESS', 'required|max_length[128]');
			$this->form_validation->set_rules('state', 'STATE', 'required');
			$this->form_validation->set_rules('city', 'CITY', 'required');
			$this->form_validation->set_rules('country', 'COUNTRY', 'required');
			$this->form_validation->set_rules('zipcode', 'ZIPCODE', 'required');
			$this->form_validation->set_rules('phone', 'PHONE NO', 'required');
			$this->form_validation->set_rules('license', 'LICENSE TYPE', 'required');
			
		}
		/**
		 * function for assigning the post values of step1 registration
		 *
		 */
		function _init_user_regdetails(){
	
				$this->gen_contents['data'] =array(		
						"firstname" 	=> 	$this->Common_model->safe_html($this->input->post('firstname')),
						"lastname"		=> 	$this->Common_model->safe_html($this->input->post('lastname')),
						"emailid" 		=> 	$this->Common_model->safe_html($this->input->post('email')),
						"password" 	=> 	md5($this->Common_model->safe_html($this->input->post('psword'))),
						"orgpassword" 		=> 	$this->Common_model->safe_html($this->input->post('psword')),
						"address"		=> 	$this->Common_model->safe_html($this->input->post('address')),
						"state" 		=> 	$this->input->post('state'),
						"city" 			=> 	$this->Common_model->safe_html($this->input->post('city')),
						"zipcode" 		=>	$this->Common_model->safe_html($this->input->post('zipcode')),
						"country" 		=> 	$this->input->post('country'),
						"phone" 		=> 	$this->Common_model->safe_html($this->input->post('phone')),
						"testimonial" 	=> 	$this->Common_model->safe_html($this->input->post('testimonial')),						 
						"licensetype"	=> 	$this->input->post('license')
						);
		}
			
		/**
		 * function for displaying step2 registration
		 *
		 */
		function _int_user_register_course(){
			$this->load->model('Common_model');
			$this->load->model('user_model');
			//echo $this->session->userdata('state');

			$data['coursearr']=$this->Common_model->listallcourses();
			$data['phone']=$this->session->userdata{'phone'};
			$data['license']=$this->session->userdata{'licensetype'};
			$data['courses_m']=$this->Common_model->licensecourselist_m($data['license']);
			$data['courses_o']=$this->Common_model->licensecourselist_o($data['license']);
			$data['subcourses']=$this->Common_model->subcourselist();
			

			$data['state'] = $this->user_model->get_state();		
			$data['month']=$this->user_model->listmonth();
			$currentyear=date('Y');	
			$data['year']=$this->user_model->listyear($currentyear);
			
			$this->load->view("admin/admin_register_course_heading",$this->gen_contents);						
			$this->load->view('admin/register/admin_user_reg_step2',$data);			
			$this->load->view("admin_footer",$this->gen_contents);
				
		}
		
		/**
		 * function for registration step2 process
		 */
				// function for registration, payment process, order placement and shipping
		function courseadd(){
			//print_r($_POST);die();
			$this->load->helper("form");

			//Registration step2 
			if($this->input->post('step2') == 2 and $this->session->userdata('step1') == 1 ){
				
				
				$this->_init_no_ship_payment();
				
				$this->load->library("form_validation");			
				$this->load->model('Common_model');
				$this->load->model('user_model');
			
				if(!empty($_POST)) {
					$this->_init_registration_rules_step2();	
						
						if($this->form_validation->run() == TRUE) {	
					
						
						$state		= 	$this->user_model->selectstate($this->input->post('b_state'));
						$name 		=	$this->session->userdata('firstname')." ".$this->session->userdata('lastname');
						$emailid	= 	$this->session->userdata('emailid');
						$course_name ='';
						$course ='';
						$subcourseid ='';
						$course_o ='';
							if($this->input->post('course')){
							$course =$this->input->post('course');
								$courselist= $this->user_model->courselist($this->input->post('course'));	
								if($course  !=''){							
								for($i=0; $i< count($courselist); $i++){
									if($course_name !='')		
										$course_name=$course_name.",".$courselist[$i]['course_name'];
										else
										$course_name=$courselist[$i]['course_name'];
									}
								}
							}
						
							if($this->input->post('subcourse')){
									$subcourseid =$this->input->post('subcourse');
									if($subcourseid  !=''){
									$subcourselist= $this->user_model->subcourselist($this->input->post('subcourse'));									
								
										if($course_name !='')		
											$course_name=$course_name.",".$subcourselist['course_name'];
											else
											$course_name=$subcourselist['course_name'];
								
									}
									
								}
								if($this->input->post('course_b')){
									$course_o =$this->input->post('course_b');
									if($course_o  !=''){
									$opcourselist= $this->user_model->opcourselist($course_o);	
									
										if($course_name !='')		
											$course_name=$course_name.",".$opcourselist['course_name'];
											else
											$course_name=$opcourselist['course_name'];
												
									}
								}
						if($this->input->post('need_payment')=='yes' && $this->input->post('need_ship')=='yes'){
							$this->_init_user_paymentdetails($state[0]['state']);//init payment details
						 
							$data['payment']=$this->user_model->payment($this->payment_contents);
							
							if("SUCCESS" == strtoupper($data['payment']["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($data['payment']["ACK"])) {
							
								$redirect_action	=	"reg_result_success";
								/**
								*paymentlog
								**/							
								$status =$data['payment']["ACK"];							
								$this->_init_payment_log($name,$emailid,$status,$course_name);
								$this->user_model->paymentlog($this->payment_log);
								/*****/
								$this->_init_user_registration($data['payment']["TRANSACTIONID"]);
								$result=$this->user_model->userregistration($this->user_contents);
	
								if($result > 0) {
									$this->order_contents['userid'] =$result;
									$this->order_contents['ship_method'] =$this->user_model->servicemethod($this->input->post('shipid'));
									$result1=$this->user_model->order($this->order_contents);
									if($this->input->post('subcourse')){
										$subcourseid =$this->input->post('subcourse');
									}else{
										$subcourseid ='';
									}
									if($this->input->post('course_b')){
										$course_o =$this->input->post('course_b');
									}else{
										$course_o ='';
									}
									
									$this->course_contents =array(						
																"course" => $this->input->post('course'),
																"subcourse"=> $subcourseid,
																"course_o"=> $course_o,
																"userid" => $result,
																"orderid" => $result1,
																"enrolled_date" =>$this->order_contents['orderdate']
																);
									$result2	=	$this->user_model->usercourse($this->course_contents);
									$this->_init_user_ship();
									$course_weight	=	$this->user_model->get_courseweight($this->course_contents);
									$this->ship_contents['courseweight'] = $course_weight;
									$ship =  $this->user_model->shipmaterial($this->ship_contents,$this->session->userdata{'admindetails'});
									$this->_int_user_mail($this->course_contents);
									$this->order_updates =array();
									if($ship !='error'){		
								
										$this->order_updates =array(						
													"trackingno" => $ship[29],
													"status" => 'S'
													);
													$orderid= $result1;
										$this->user_model->updateorder($this->order_updates,$orderid);
										
										$redirect_action	=	"admin_register/reg_result_success";
										$this->session->set_flashdata('msg',"Registration Completed Successfully");
																			
									} else{ 
										$redirect_action	=	"admin_register/reg_result_success_reship";
	
										$this->order_updates ='';	
										$this->session->set_flashdata('msg',"Registration Completed Successfully administrator will reship it");
										$this->user_model->send_mailto_admin($this->mail_contents,$this->order_contents,$this->session->userdata{'admindetails'},$this->order_updates);														
										
									}
									
									$this->user_model->send_mailto_user($this->mail_contents,$this->order_contents,$this->order_updates);
								//	$this->user_model->send_mailto_admin($this->mail_contents,$this->order_contents,$this->session->userdata{'admindetails'},$this->order_updates);
									$this->session->sess_destroy();
									redirect($redirect_action);
								}
							}else{
								$this->gen_contents["msg"]="Payment Transaction Failed ".urldecode($data['payment']['L_LONGMESSAGE0']);
								
								/**
								*paymentlog
								**/		
								$status =urldecode($data['payment']['L_LONGMESSAGE0']);
								$this->_init_payment_log($name,$emailid,$status,$course_name);
								$this->user_model->paymentlog($this->payment_log);
								/**end **/
								$this->_int_user_register_course();//die('ff');
	
							}
								
								
							
						}elseif ($this->input->post('need_ship')=='yes' && $this->input->post('need_payment')=='no'){
							
							
							$this->_init_user_paymentdetails($state[0]['state']);//init payment details
						 
							//$data['payment']=$this->user_model->payment($this->payment_contents);
							
							
								$redirect_action	=	"reg_result_success";
								
							
								$this->_init_user_registration_nopayment('');
								$result=$this->user_model->userregistration($this->user_contents);
	
								if($result > 0) {
									$this->order_contents['userid'] =$result;
									$this->order_contents['ship_method'] =$this->user_model->servicemethod($this->input->post('shipid'));
									$result1=$this->user_model->order($this->order_contents);
									if($this->input->post('subcourse')){
										$subcourseid =$this->input->post('subcourse');
									}else{
										$subcourseid ='';
									}
									if($this->input->post('course_b')){
										$course_o =$this->input->post('course_b');
									}else{
										$course_o ='';
									}
									
									$this->course_contents =array(						
																"course" => $this->input->post('course'),
																"subcourse"=> $subcourseid,
																"course_o"=> $course_o,
																"userid" => $result,
																"orderid" => $result1,
																"enrolled_date" =>$this->order_contents['orderdate']
																);
									$result2	=	$this->user_model->usercourse($this->course_contents);
									$this->_init_user_ship();
									$course_weight	=	$this->user_model->get_courseweight($this->course_contents);
									$this->ship_contents['courseweight'] = $course_weight;
									$ship =  $this->user_model->shipmaterial($this->ship_contents,$this->session->userdata{'admindetails'});
									$this->_int_user_mail($this->course_contents);
									$this->order_updates =array();
									if($ship !='error'){		
								
										$this->order_updates =array(						
													"trackingno" => $ship[29],
													"status" => 'S'
													);
													$orderid= $result1;
										$this->user_model->updateorder($this->order_updates,$orderid);
										
										$redirect_action	=	"admin_register/reg_result_success";
										$this->session->set_flashdata('msg',"Registration Completed Successfully");
																			
									} else{ 
										$redirect_action	=	"admin_register/reg_result_success_reship";
	
										$this->order_updates ='';	
										$this->session->set_flashdata('msg',"Registration Completed Successfully administrator will reship it");
										$this->user_model->send_mailto_admin($this->mail_contents,$this->order_contents,$this->session->userdata{'admindetails'},$this->order_updates);														
										
									}
									
									$this->user_model->send_mailto_user($this->mail_contents,$this->order_contents,$this->order_updates);
								//	$this->user_model->send_mailto_admin($this->mail_contents,$this->order_contents,$this->session->userdata{'admindetails'},$this->order_updates);
									$this->session->sess_destroy();
									redirect($redirect_action);
								}

						

	
						}else if($this->input->post('need_ship')=='no' && $this->input->post('need_payment')=='yes'){
							
							//init payment details
							$this->_init_user_paymentdetails($state[0]['state']);
							 
							$data['payment']=$this->user_model->payment($this->payment_contents);
							if("SUCCESS" == strtoupper($data['payment']["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($data['payment']["ACK"])) {
								$redirect_action	=	"reg_result_success";
					
								/**
								*paymentlog
								**/							
								$status =$data['payment']["ACK"];							
								$this->_init_payment_log($name,$emailid,$status,$course_name);
								$this->user_model->paymentlog($this->payment_log);
								/*****/
								$this->_init_user_registration($data['payment']["TRANSACTIONID"]);
								$result=$this->user_model->userregistration($this->user_contents);
								
								if($result > 0) {
									$this->order_contents['userid'] =$result;
									$this->order_contents['ship_method'] ='Admin';
									$result1=$this->user_model->order($this->order_contents);
									if($this->input->post('subcourse')){
										$subcourseid =$this->input->post('subcourse');
									}else{
										$subcourseid ='';
									}
									if($this->input->post('course_b')){
										$course_o =$this->input->post('course_b');
									}else{
										$course_o ='';
									}
									
									$this->course_contents =array(						
																"course" => $this->input->post('course'),
																"subcourse"=> $subcourseid,
																"course_o"=> $course_o,
																"userid" => $result,
																"orderid" => $result1,
																"enrolled_date" =>$this->order_contents['orderdate'],
																"delivered_date"=>$this->order_contents['orderdate'],
																"effective_date"=>$this->order_contents['orderdate']
																);
									$result2	=	$this->user_model->usercourse($this->course_contents);
									/*$this->_init_user_ship();
									$course_weight	=	$this->user_model->get_courseweight($this->course_contents);
									$this->ship_contents['courseweight'] = $course_weight;
									$ship =  $this->user_model->shipmaterial($this->ship_contents,$this->session->userdata{'admindetails'});*/
									$this->_int_user_mail($this->course_contents);
									$this->order_updates =array();
											
								
										$this->order_updates =array(						
													"trackingno" => '',
													"status" => 'C'
													);
													$orderid= $result1;
										$this->user_model->updateorder($this->order_updates,$orderid);
										
										$redirect_action	=	"admin_register/reg_result_success";
										
																			
								
	
										$this->order_updates ='';	
										$this->session->set_flashdata('msg',"Registration Completed Successfully");
										$this->user_model->send_mailto_admin($this->mail_contents,$this->order_contents,$this->session->userdata{'admindetails'},$this->order_updates);														
										
									
									$this->user_model->send_mailto_user($this->mail_contents,$this->order_contents,$this->order_updates);
								//	$this->user_model->send_mailto_admin($this->mail_contents,$this->order_contents,$this->session->userdata{'admindetails'},$this->order_updates);
									$this->session->sess_destroy();
									redirect($redirect_action);
								}
							}else{
									
									$this->gen_contents["msg"]="Payment Transaction Failed ".urldecode($data['payment']['L_LONGMESSAGE0']);
								
									/**
									*paymentlog
									**/		
									$status =urldecode($data['payment']['L_LONGMESSAGE0']);
									$this->_init_payment_log($name,$emailid,$status,$course_name);
									$this->user_model->paymentlog($this->payment_log);
									/**end **/
									$this->_int_user_register_course();//die('ff');
								}
									
						}else{
							$this->_init_user_registration_nopayment('');
							$result=$this->user_model->userregistration($this->user_contents);
							if($result > 0) {
								$this->order_contents['userid'] =$result;
								$this->order_contents['ship_method'] ='Admin';
								$result1=$this->user_model->order($this->order_contents);
								if($this->input->post('subcourse')){
									$subcourseid =$this->input->post('subcourse');
								}else{
									$subcourseid ='';
								}
								if($this->input->post('course_b')){
									$course_o =$this->input->post('course_b');
								}else{
									$course_o ='';
								}
								
								$this->course_contents =array(						
															"course" => $this->input->post('course'),
															"subcourse"=> $subcourseid,
															"course_o"=> $course_o,
															"userid" => $result,
															"orderid" => $result1,
															"enrolled_date" =>$this->order_contents['orderdate'],
															"delivered_date"=>$this->order_contents['orderdate'],
															"effective_date"=>$this->order_contents['orderdate']
															);
								$result2	=	$this->user_model->usercourse($this->course_contents);
								$this->_int_user_mail($this->course_contents);
								$this->order_updates =array();
								//if($ship !='error'){		
							
									$this->order_updates =array(						
												"trackingno" => '',
												"status" => 'C'
												);
												$orderid= $result1;
									$this->user_model->updateorder($this->order_updates,$orderid);
									
									$redirect_action	=	"admin_register/reg_result_success";
									$this->session->set_flashdata('msg',"Registration Completed Successfully");
																		
							//	} 
								
								$this->user_model->send_mailto_user($this->mail_contents,$this->order_contents,$this->order_updates);
							//	$this->user_model->send_mailto_admin($this->mail_contents,$this->order_contents,$this->session->userdata{'admindetails'},$this->order_updates);
								$this->session->sess_destroy();
								redirect($redirect_action);
							}
							
							
						}

					} else{
						
						$this->gen_contents["msg"]="Fill Required Fields";
						$this->_int_user_register_course();
					}
				}else{
					$this->gen_contents["msg"]="Failed to process please try again ";
					$this->_int_user_register_course();
				}
				

		}else {			
				redirect("admin_register/register");
			}
			

		}
		
		/**
		 * function for form validation in step 1 registration
		 *
		 */
		function _init_registration_rules_step2(){
			
			if($this->input->post('need_payment')=='yes'){
				$this->form_validation->set_rules('b_address', 'Billing Address', 'required|max_length[128]');
				$this->form_validation->set_rules('b_state', 'Billing Address State', 'required|max_length[128]');
				$this->form_validation->set_rules('b_country', 'Billing Address Country', 'required|max_length[128]');
				$this->form_validation->set_rules('b_city', 'Billing Address City', 'required|max_length[128]');
				$this->form_validation->set_rules('b_zipcode', 'Billing Address Zipcode', 'required|max_length[128]');
				$this->form_validation->set_rules('ccno', 'Credit Crad Number', 'required|max_length[128]');

				$this->form_validation->set_rules('cvv2no', 'Credit Card Verification Code', 'required|max_length[128]');
				$this->form_validation->set_rules('cardtype', 'Credit Card Type', 'required|max_length[128]');
				$this->form_validation->set_rules('expmonth', 'Expire Month', 'required|max_length[128]');
				$this->form_validation->set_rules('expyear', 'Expire Year', 'required|max_length[128]');
			}
			
			if($this->input->post('need_ship')=='yes'){
				$this->form_validation->set_rules('s_address', 'Shipping Address', 'required|max_length[128]');
				$this->form_validation->set_rules('s_state', 'Shipping Address State', 'required');
				$this->form_validation->set_rules('s_country', 'Shipping Address Country', 'required');
				$this->form_validation->set_rules('s_city', 'Shipping Address City', 'required');
				$this->form_validation->set_rules('s_zipcode', 'Shipping Address Zip code', 'required');
				
				$this->form_validation->set_rules('shipid', 'Ship Method', 'required');
			}
			$this->form_validation->set_rules('s_address', 'Shipping Address', 'required|max_length[128]');
			
			//$this->form_validation->set_rules('course[]', 'Course', 'required');
			
		

		}
		function _init_user_paymentdetails($state){
				$this->payment_contents =array(		
						"firstname" 	=> 	$this->session->userdata('firstname'),
						"lastname"		=> 	$this->session->userdata('lastname'),
						"ccno" 			=> 	$this->Common_model->safe_html($this->input->post('ccno')),
						"cardtype" 		=> 	$this->input->post('cardtype'),
						"expmonth" 		=> 	$this->input->post('expmonth'),
						"expyear" 		=> 	$this->input->post('expyear'),
						"cvv2no" 		=> 	$this->Common_model->safe_html($this->input->post('cvv2no')),
						"address1" 		=>	$this->input->post('b_address'),
						"zipcode" 		=>  $this->input->post('b_zipcode'),
						"country" 		=> 	$this->input->post('b_country'),
						"state" 		=> 	$state,
						"city" 			=> 	$this->input->post('b_city"'),
						"amount" 		=> 	$this->input->post('totalprice')
						);
		}	
			
		function _init_user_paymentdetails_nopayment($state){
				$this->payment_contents =array(		
						"firstname" 	=> 	$this->session->userdata('firstname'),
						"lastname"		=> 	$this->session->userdata('lastname'),
						"ccno" 			=> 	'',
						"cardtype" 		=> 	'',
						"expmonth" 		=> 	'',
						"expyear" 		=> 	'',
						"cvv2no" 		=> 	'',
						
						"address1" 		=> 	$this->session->userdata('address'),
						"state" 		=> 	$this->session->userdata('state'),
						"city" 			=> 	$this->session->userdata('city'),
						"zipcode" 		=> 	$this->session->userdata('zipcode'),
						"country" 		=> 	$this->session->userdata('country'),
						
						"amount" 		=> 	$this->input->post('totalprice')
						);
		}
		
		
		
		
		
		
		function _init_payment_log($name,$emailid,$status,$course_name){
			$this->payment_log =array(						
					
					"name"				=> 	$name,						
					"emailid" 			=> $emailid,
					"paymentdate"		=> date("Y-m-d H:i:s"),
					"b_address" 		=> $this->input->post('b_address').",".$this->input->post('b_city').
												",".$this->input->post('b_state').",".$this->input->post('b_country').",".$this->input->post('b_zipcode'),
				
					"s_address" 		=> $this->input->post('s_address').",".$this->input->post('s_city').
												",".$this->input->post('s_state').",".$this->input->post('s_country').",".$this->input->post('s_zipcode'),
					"coursename" 		=> $course_name,
					"status" 			=> $status
					);
		}
		
		function _init_payment_log_nopayment($name,$emailid,$status,$course_name){
					$this->payment_log =array(						
							
							"name"				=> 	$name,						
							"emailid" 			=> $emailid,
							"paymentdate"		=> date("Y-m-d H:i:s"),
							

							"b_address" 		=> $this->session->userdata('address').",".$this->session->userdata('city').
														",".$this->session->userdata('state').",".$this->session->userdata('country').",".$this->session->userdata('zipcode'),
						
							"s_address" 		=> $this->input->post('s_address').",".$this->input->post('s_city').
														",".$this->input->post('s_state').",".$this->input->post('s_country').",".$this->input->post('s_zipcode'),
							"coursename" 		=> $course_name,
							"status" 			=> $status
							);
		}
		
		
		function _init_user_registration($transactionid){
			$this->user_contents =array(		
							"firstname" 	=> 	$this->session->userdata('firstname'),
							"lastname" 		=> 	$this->session->userdata('lastname'),
							"emailid" 		=> 	$this->session->userdata('emailid'),
							"password" 		=> 	$this->session->userdata('password'),							
							"address" 		=> 	$this->session->userdata('address'),
							"state" 		=> 	$this->session->userdata('state'),
							"city" 			=> 	$this->session->userdata('city'),
							"zipcode" 		=> 	$this->session->userdata('zipcode'),
							"country" 		=> 	$this->session->userdata('country'),
							"phone" 		=> 	$this->session->userdata('phone'),
							"testimonial" 	=> 	$this->session->userdata('testimonial'),						 
							"licensetype" 	=> 	$this->session->userdata('licensetype'),
							"b_address" 	=> 	$this->input->post('b_address'),
							"b_country" 	=> 	$this->input->post('b_country'),
							"b_state" 		=> 	$this->input->post('b_state'),
							"b_city" 		=> 	$this->input->post('b_city'),
							"b_zipcode" 	=> 	$this->input->post('b_zipcode'),
							"s_address" 	=> 	$this->input->post('s_address'),
							"s_country" 	=>	$this->input->post('s_country'),
							"s_state" 		=> 	$this->input->post('s_state'),
							"s_city" 		=> 	$this->input->post('s_city'),
							"s_zipcode" 	=> 	$this->input->post('s_zipcode')
	
							);
			
			
			$this->order_contents =array(
							"b_address" 		=> 	$this->input->post('b_address'),
							"b_country" 		=> 	$this->input->post('b_country'),
							"b_state" 			=> 	$this->input->post('b_state'),
							"b_city" 			=> 	$this->input->post('b_city'),
							"b_zipcode" 		=> 	$this->input->post('b_zipcode'),
							"s_address" 		=> 	$this->input->post('s_address'),
							"s_country" 		=>	$this->input->post('s_country'),
							"s_state" 			=> 	$this->input->post('s_state'),
							"s_city"			=> 	$this->input->post('s_city'),
							"s_zipcode" 		=> 	$this->input->post('s_zipcode'),
							"total_amount"		=> 	$this->input->post('totalprice'),
							"ship_rate" 		=> 	$this->input->post('shipprice'),
							"course_price" 		=> 	$this->input->post('price'),
							"transactionid"		=> 	$transactionid,
							"payment_method"	=> 'Paypal Payment Method',
							"orderdate" 		=> 	date('Y-m-d')
							
							);
		
		}
		
		
		function _init_user_registration_nopayment($transactionid){
			$this->user_contents =array(		
							"firstname" 	=> 	$this->session->userdata('firstname'),
							"lastname" 		=> 	$this->session->userdata('lastname'),
							"emailid" 		=> 	$this->session->userdata('emailid'),
							"password" 		=> 	$this->session->userdata('password'),							
							"address" 		=> 	$this->session->userdata('address'),
							"state" 		=> 	$this->session->userdata('state'),
							"city" 			=> 	$this->session->userdata('city'),
							"zipcode" 		=> 	$this->session->userdata('zipcode'),
							"country" 		=> 	$this->session->userdata('country'),
							"phone" 		=> 	$this->session->userdata('phone'),
							"testimonial" 	=> 	$this->session->userdata('testimonial'),						 
							"licensetype" 	=> 	$this->session->userdata('licensetype'),
							
							
							"b_address" 		=> 	$this->session->userdata('address'),
							"b_state" 			=> 	$this->session->userdata('state'),
							"b_city" 			=> 	$this->session->userdata('city'),
							"b_zipcode" 		=> 	$this->session->userdata('zipcode'),
							"b_country" 		=> 	$this->session->userdata('country'),
							
							
							"s_address" 	=> 	$this->input->post('s_address'),
							"s_country" 	=>	$this->input->post('s_country'),
							"s_state" 		=> 	$this->input->post('s_state'),
							"s_city" 		=> 	$this->input->post('s_city'),
							"s_zipcode" 	=> 	$this->input->post('s_zipcode')
	
							);
			
			
			$this->order_contents =array(
							"b_address" 		=> 	$this->session->userdata('address'),
							"b_state" 			=> 	$this->session->userdata('state'),
							"b_city" 			=> 	$this->session->userdata('city'),
							"b_zipcode" 		=> 	$this->session->userdata('zipcode'),
							"b_country" 		=> 	$this->session->userdata('country'),
							"s_address" 		=> 	$this->input->post('s_address'),
							"s_country" 		=>	$this->input->post('s_country'),
							"s_state" 			=> 	$this->input->post('s_state'),
							"s_city"			=> 	$this->input->post('s_city'),
							"s_zipcode" 		=> 	$this->input->post('s_zipcode'),
							"total_amount"		=> 	$this->input->post('totalprice'),
							"ship_rate" 		=> 	$this->input->post('shipprice'),
							"course_price" 		=> 	$this->input->post('price'),
							"transactionid"		=> 	$transactionid,
							"payment_method"	=> 'By Admin',
							"orderdate" 		=> 	date('Y-m-d')
							
							);
		
		}
		
		function _init_user_ship(){
			$this->ship_contents =array(		
						"r_phone" 		=>  $this->input->post('bphone'),
						"r_address" 	=>  $this->input->post('s_address'),
						"r_country" 	=>  $this->input->post('s_country'),
						"r_state"		=>  $this->input->post('s_state'),
						"r_city"		=>  $this->input->post('s_city'),
						"r_zipcode" 	=>  $this->input->post('s_zipcode'),
						"r_name" 		=>  $this->session->userdata('firstname')." ".$this->session->userdata('lastname'),
						"r_method" 		=>  $this->input->post('shipid')
						);
		}
		
		function _int_user_mail($course){
			$this->mail_contents =array(
				"name" 				=> 	$this->session->userdata('firstname')." ".$this->session->userdata('lastname'),
				"useremail" 		=> 	$this->session->userdata('emailid'),
				"password" 			=> 	$this->session->userdata('orgpassword'),
				"course" 			=> 	$course['course'],
				"subcourse" 		=> 	$course['subcourse'],
				"course_o" 			=> 	$course['course_o']
				);
		}
		
		function _init_payment_log_noship($name,$emailid,$status,$course_name){
			$this->payment_log =array(						
					"name"				=> 	$name,						
					"emailid" 			=> $emailid,
					"paymentdate"		=> date("Y-m-d H:i:s"),
					
					"b_address" 		=> $this->input->post('b_address').",".$this->input->post('b_city').
												",".$this->input->post('b_state').",".$this->input->post('b_country').",".$this->input->post('b_zipcode'),
				
					"s_address" 		=> $this->session->userdata('address').",".$this->session->userdata('city').
												",".$this->session->userdata('state').",".$this->session->userdata('country').",".$this->session->userdata('zipcode'),				
					"coursename" 		=> $course_name,
					"status" 			=> $status
					);
		}
		
		function _init_no_ship_payment(){
			
			if($this->input->post('need_ship')=='no'){

				$_POST['s_address']				=	 	$this->session->userdata('address');
				$_POST['s_country']    			=		$this->session->userdata('country');
				$_POST['s_state']				=		$this->session->userdata('state');
				$_POST['s_city'] 				=		$this->session->userdata('city');
			 	$_POST['s_zipcode'] 			=		$this->session->userdata('zipcode');
				$_POST['total'] 				=		$this->session->userdata('price');

			}
			if($this->input->post('need_payment')=='no'){
				
				 $_POST['b_address']			=	 	$this->session->userdata('address');
				 $_POST['b_country']			=		$this->session->userdata('country');
				 $_POST['b_state']				=		$this->session->userdata('state');
				 $_POST['b_city'] 				=		$this->session->userdata('city');
			 	 $_POST['b_zipcode']  			=		$this->session->userdata('zipcode');
				
			}
			
		}
		
		function reg_result_success(){	
								
			$this->load->view("admin/admin_register_heading",$this->gen_contents);			
			$this->load->view('admin/register/reg_result_success');
			$this->load->view("admin_footer",$this->gen_contents);			
		}

		function reg_result_success_reship(){
								
			$this->load->view("admin/admin_register_heading",$this->gen_contents);			
			$this->load->view('admin/register/reg_result_success_reship');
			$this->load->view("admin_footer",$this->gen_contents);			
			//unset($_POST);
			
		}
}

?>