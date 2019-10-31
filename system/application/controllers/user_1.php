<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User Controller
 *
 * @package		CodeIgniter
 * @subpackage	Controllers
 * @category	Controllers
 * @author		soumya
 * @link		http://ahischools.com/user/
 */

// ------------------------------------------------------------------------

class User extends Controller {

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
		function User(){
		parent::Controller();
						
			$this->load->model('Common_model');
			$this->gen_contents['css'] = array('style.css','dhtmlgoodies_calendar.css','client_style.css');
			$this->gen_contents['js'] = array('userdetails.js','popcalendar.js');
			$this->load->model('admin_sitepage_model');
			
		}
	
		function index() {

			if($this->authentication->logged_in("normal"))
				redirect("profile");			
			redirect("home");
			
		}
		
	/*******************************Registration*******************************/		
	
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
			$this->form_validation->set_rules('testimonial', 'TESTIMONIAL', 'required|max_length[250]');
		}
		
		function _init_registration_rules_step2(){
		
			$this->form_validation->set_rules('b_address', 'Billing Address', 'required|max_length[128]');
			$this->form_validation->set_rules('b_state', 'Billing Address State', 'required|max_length[128]');
			$this->form_validation->set_rules('b_country', 'Billing Address Country', 'required|max_length[128]');
			$this->form_validation->set_rules('b_city', 'Billing Address City', 'required|max_length[128]');
			$this->form_validation->set_rules('b_zipcode', 'Billing Address Zipcode', 'required|max_length[128]');
			$this->form_validation->set_rules('s_address', 'Shipping Address', 'required|max_length[128]');
			$this->form_validation->set_rules('s_state', 'Shipping Address State', 'required');
			$this->form_validation->set_rules('s_country', 'Shipping Address Country', 'required');
			$this->form_validation->set_rules('s_city', 'Shipping Address City', 'required');
			$this->form_validation->set_rules('s_zipcode', 'Shipping Address Zip code', 'required');
			//$this->form_validation->set_rules('course[]', 'Course', 'required');
			$this->form_validation->set_rules('shipid', 'Ship Method', 'required');
			$this->form_validation->set_rules('ccno', 'Credit Crad Number', 'required|max_length[128]');
			$this->form_validation->set_rules('cvv2no', 'Credit Card Verification Code', 'required|max_length[128]');
			$this->form_validation->set_rules('cardtype', 'Credit Card Type', 'required|max_length[128]');
			$this->form_validation->set_rules('expmonth', 'Expire Month', 'required|max_length[128]');
			$this->form_validation->set_rules('expyear', 'Expire Year', 'required|max_length[128]');

		}
		function _init_renewal_rules(){
			$this->form_validation->set_rules('b_address', 'Billing Address', 'required|max_length[128]');
			$this->form_validation->set_rules('b_state', 'Billing Address State', 'required|max_length[128]');
			$this->form_validation->set_rules('b_country', 'Billing Address Country', 'required|max_length[128]');
			$this->form_validation->set_rules('b_city', 'Billing Address City', 'required|max_length[128]');
			$this->form_validation->set_rules('b_zipcode', 'Billing Address Zipcode', 'required|max_length[128]');
			$this->form_validation->set_rules('courseid', 'Course', 'required');
			$this->form_validation->set_rules('ccno', 'Credit Crad Number', 'required|max_length[128]');
			$this->form_validation->set_rules('cvv2no', 'Credit Card Verification Code', 'required|max_length[128]');
			$this->form_validation->set_rules('cardtype', 'Credit Card Type', 'required|max_length[128]');
			$this->form_validation->set_rules('expmonth', 'Expire Month', 'required|max_length[128]');
			$this->form_validation->set_rules('expyear', 'Expire Year', 'required|max_length[128]');
		
		}
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
		function _init_user_new_paymentdetails($state){
				$this->new_payment_contents =array(		
						"firstname" 	=> 	$this->input->post('firstname'),
						"lastname"		=> 	$this->input->post('lastname'),
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
		function _init_user_new_ship(){
			$this->new_ship_contents =array(		
						"r_phone" 		=>  $this->input->post('bphone'),
						"r_address" 	=>  $this->input->post('s_address'),
						"r_country" 	=>  $this->input->post('s_country'),
						"r_state"		=>  $this->input->post('s_state'),
						"r_city"		=>  $this->input->post('s_city'),
						"r_zipcode" 	=>  $this->input->post('s_zipcode'),
						"r_name" 		=>  $this->input->post('firstname')." ".$this->input->post('lastname'),
						"r_method" 		=>  $this->input->post('shipid')
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
		
		function _init_user_order($transactionid){
			$this->new_order_contents =array(
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
		
		function _int_user_new_mail($course){
			$this->new_mail_contents =array(
				"name" 				=> 	$this->input->post('firstname')." ".$this->input->post('lastname'),
				"useremail" 		=> 	$this->input->post('emailid'),
				"course" 			=> 	$course['course'],
				"subcourse" 		=> 	$course['subcourse'],
				"course_o" 			=> 	$course['course_o']
				);

		}
		
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
			
								$this->gen_contents['msg']= "InCorrect Access code";
								$this->load->model('user_model');
								$this->load->helper("form");							
								$this->load->view("client_common_header",$this->gen_contents);	
								$captcha                     = $this->user_model->generate_captcha ();			
								$this->session->set_userdata ("captcha_word", $captcha['word']);
								
								$this->gen_contents['captcha_details']     = $captcha;	
								$this->gen_contents['state'] = $this->user_model->get_state();		
								$this->load->view('user/register',$this->gen_contents);			
								$this->load->view("client_common_footer");					
								
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
										$this->load->view("client_common_header",$this->gen_contents);	
										$captcha                     = $this->user_model->generate_captcha ();			
										$this->session->set_userdata ("captcha_word", $captcha['word']);
										
										$this->gen_contents['captcha_details']     = $captcha;	
										$this->gen_contents['state'] = $this->user_model->get_state();		
										$this->load->view('user/register',$this->gen_contents);			
										$this->load->view("client_common_footer");	

								}								
							}
						}
	
	
				}
	
		}
		// function for first ohase registration	
		function register() {	
		
			// regisration step 1
			if($this->input->post('step1') == 1){
				$this-> _int_user_register_step1();
			}

			if(!$_POST){
			$this->load->model('user_model');
			$this->load->helper("form");			
			$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();				
			$this->load->view("client_common_header",$this->gen_contents);	
			$captcha                     = $this->user_model->generate_captcha ();			
			$this->session->set_userdata ("captcha_word", $captcha['word']);
			
			$this->gen_contents['captcha_details']     = $captcha;	
			$this->gen_contents['state'] = $this->user_model->get_state();		
			$this->load->view('user/register',$this->gen_contents);			
			$this->load->view("client_common_footer",$this->gen_contents);	
			}	
		
		}
		
		// function for second phase registration course listing,shipping methodslisting,payment selection
		function _int_user_register_course(){
			$this->load->model('Common_model');
			$this->load->model('user_model');
			
			/*$this->gen_contents['css'] = array('style.css','dhtmlgoodies_calendar.css','client_style.css');
			$this->gen_contents['js'] = array('userdetails.js','popcalendar.js');*/
			$data['phone']=$this->session->userdata{'phone'};
			$data['license']=$this->session->userdata{'licensetype'};
			$data['courses_m']=$this->Common_model->licensecourselist_m($data['license']);
			$data['courses_o']=$this->Common_model->licensecourselist_o($data['license']);
			$data['subcourses']=$this->Common_model->subcourselist();
			
			/*$data['fedex'] = $this->session->userdata;
			$data['fedexrate']=$this->user_model->servicesrate($data['fedex'],$this->session->userdata{'admindetails'});	
			*/
			$data['state'] = $this->user_model->get_state();		
			$data['month']=$this->user_model->listmonth();
			$currentyear=date('Y');	
			$data['year']=$this->user_model->listyear($currentyear);
			$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();	
			$this->load->view("client_common_header_course",$this->gen_contents);				
			$this->load->view('user/course',$data);
			$this->load->view("client_common_footer",$this->gen_contents);		
				
		}
		
		// function for registration, payment process, order placement and shipping
		function courseadd(){
				$this->load->helper("form");
						

			/*var_dump( $this->session->userdata('step1'));
				print( $this->input->post('step2'));
				exit;*/
			//Registration step2 
			if($this->input->post('step2') == 2 and $this->session->userdata('step1') == 1 ){
				$this->load->library("form_validation");			
				$this->load->model('Common_model');
				$this->load->model('user_model');
			
				if(!empty($_POST)) {
					$this->_init_registration_rules_step2();	
						
						if($this->form_validation->run() == TRUE) {	
					
						
						$state= $this->user_model->selectstate($this->input->post('b_state'));
						
						//init payment details
						$this->_init_user_paymentdetails($state[0]['state']);
						 
						$data['payment']=$this->user_model->payment($this->payment_contents);
						
						if("SUCCESS" == strtoupper($data['payment']["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($data['payment']["ACK"])) {
							
							$redirect_action	=	"reg_result_success";
							
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
									
									$redirect_action	=	"user/reg_result_success";
									$this->session->set_flashdata('msg',"Registration Completed Successfully");
																		
								} else{ 
									$redirect_action	=	"user/reg_result_success_reship";

									$this->order_updates ='';	
									$this->session->set_flashdata('msg',"Registration Completed Successfully admin will reship it");														
									$this->user_model->send_mailto_admin($this->mail_contents,$this->order_contents,$this->session->userdata{'admindetails'});
								}
								$this->order_updates ='';
								$this->user_model->send_mailto_user($this->mail_contents,$this->order_contents,$this->order_updates);
								$this->session->sess_destroy();
								//print_r($this->session->userdata);
								redirect($redirect_action);
								//$this->session->unset_userdata ($arr);
								//print_r($this->session->userdata);
								 
							}
						}else{
							$this->session->set_userdata('msg',"Payment Transaction Failed ".urldecode($data['payment']['L_LONGMESSAGE0']));
							
							$this->_int_user_register_course();//die('ff');

						}
						
					} else{
					
						$this->_int_user_register_course();
						exit();
					
					}
				}else{
				
				$this->_int_user_register_course();
				exit();			

				}
				

			} else {			
				redirect("user/register");
			}
			

		}
		function reg_result_success(){	
			$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();					
			$this->load->view("client_common_header",$this->gen_contents);			
			$this->load->view('user/reg_result_success');
			$this->load->view("client_common_footer",$this->gen_contents);			
		}

		function reg_result_success_reship(){
			$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();					
			$this->load->view("client_common_header",$this->gen_contents);			
			$this->load->view('user/reg_result_success_reship');
			$this->load->view("client_common_footer",$this->gen_contents);			
			//unset($_POST);
			
		}

		
		
		
		/*******************************Registration*******************************/
		/**
		 * function for add new course
		 *
		 */
		function _init_new_order(){
		
		$this->load->helper("form");
						
			//Registration step2 
			
				$this->load->library("form_validation");			
				$this->load->model('Common_model');
				$this->load->model('user_model');
			
				if(!empty($_POST)) {
					$this->_init_registration_rules_step2();	
						
						if($this->form_validation->run() == TRUE) {	
					
						
						$state= $this->user_model->selectstate($this->input->post('b_state'));
						
						//init payment details
						$this->_init_user_new_paymentdetails($state[0]['state']);
						 
						$data['payment']=$this->user_model->payment($this->new_payment_contents);					
						
						if("SUCCESS" == strtoupper($data['payment']["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($data['payment']["ACK"])) {
								$this->_init_user_order($data['payment']["TRANSACTIONID"]);
								$redirect_action	=	"addcourse_result_success";
							
								$this->new_order_contents['userid'] =$this->session->userdata('USERID');
								$this->new_order_contents['ship_method'] =$this->user_model->servicemethod($this->input->post('shipid'));
								$result1=$this->user_model->order($this->new_order_contents);
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
															"userid" => $this->new_order_contents['userid'],
															"orderid" => $result1,
															"enrolled_date" =>$this->new_order_contents['orderdate']
															);
								$result2	=	$this->user_model->usercourse($this->course_contents);
								$admindetails= $this->user_model->get_admin();	
								$this->_init_user_new_ship();
								$course_weight	=	$this->user_model->get_courseweight($this->course_contents);
								$this->new_ship_contents['courseweight'] = $course_weight;
								$ship =  $this->user_model->shipmaterial($this->new_ship_contents,$admindetails);
								$this->_int_user_new_mail($this->course_contents);
								$this->order_updates =array();
								if($ship !='error'){		
							
									$this->order_updates =array(						
												"trackingno" => $ship[29],
												"status" => 'S'
												);
												$orderid= $result1;
									$this->user_model->updateorder($this->order_updates,$orderid);
									
									$redirect_action	=	"user/addcourse_result_success";
									$this->session->set_flashdata('msg',"Order Completed Successfully");
																		
								} else{ 
									$redirect_action	=	"user/addcourse_result_success_reship";

									$this->order_updates ='';	
									$this->session->set_flashdata("msg","Order Completed Successfully admin will reship it");														
									$this->user_model->new_send_mailto_admin($this->new_mail_contents,$this->new_order_contents,$admindetails);
								}
								$this->order_updates ='';
								$this->user_model->new_send_mailto_user($this->new_mail_contents,$this->new_order_contents,$this->order_updates);
								
								
								redirect("exam/courselist");
						
					} else{
						$this->session->set_userdata("msg","Payment Transaction Failed ".urldecode($data['payment']['L_LONGMESSAGE0']));
						redirect("exam/courselist");
					
					
					}
				}
				
			}
		}

		/*end *
		
		/**
		 * function for list remaining course
		 *
		 */		
		function listremainingcourse(){
			if($this->authentication->logged_in("normal")){
			$this->load->helper("form");
				$this->load->model('Common_model');
				$this->load->model('user_model');
				if(!empty($_POST) ) {
				
					$this->_init_new_order();
				}else{
					$this->gen_contents['userid']=$this->session->userdata('USERID');	
					$data['license']= $this->user_model->get_license($this->session->userdata('USERID'));
					
					$billing= $this->user_model->get_b_address($this->session->userdata('USERID'));
					$shipping= $this->user_model->get_s_address($this->session->userdata('USERID'));
					$data['billing'] =$billing[0];
					$data['shipping'] =$shipping[0];
					$data['phone'] = $data['billing']['phone'];
					$data['firstname'] = $data['billing']['firstname'];
					$data['lastname'] = $data['billing']['lastname'];
					$data['emailid'] = $data['billing']['emailid'];		
					
					/*$data['phone'] = $data['billing'][0]['phone'];
					$data['firstname'] = $data['billing'][0]['firstname'];
					$data['lastname'] = $data['billing'][0]['lastname'];
					$data['emailid'] = $data['billing'][0]['emailid'];*/
					$data['subcourses']=$this->Common_model->sub_remain_courselist($this->session->userdata('USERID'));
					if($data['license'] == 'S'){
						if($data['subcourses'] != false){
						$data['courses_m']=$this->Common_model->license_remain_courselist_m($data['license'],$this->session->userdata('USERID'));
						
						}
						else{
						$data['courses_m']=$this->Common_model->license_remain_courselist_nm($data['license'],$this->session->userdata('USERID'));

						//$data['courses_mt']=$this->Common_model->license_remain_courselist_nmt($data['license'],$this->session->userdata('USERID'));
						}
				
						$data['courses_o']=$this->Common_model->license_remain_courselist_o($data['license'],$this->session->userdata('USERID'));
					}
					if($data['license'] == 'B'){
						if($data['subcourses'] != false){
						$data['courses_mb']=$this->Common_model->license_remain_courselist_mb($data['license'],$this->session->userdata('USERID'));
						$data['courses_mt']=$this->Common_model->license_remain_courselist_mt($data['license'],$this->session->userdata('USERID'));
						$data['countmt'] = count($data['courses_mb']);
						if($data['countmt']>3)
						$data['countmt'] =3;
						$data['countnum'] = $this->Common_model->convertNum($data['countmt']);
						}
						else{
						$data['courses_mb']=$this->Common_model->license_remain_courselist_nmb($data['license'],$this->session->userdata('USERID'));
						$data['courses_mt']=$this->Common_model->license_remain_courselist_nmt($data['license'],$this->session->userdata('USERID'));
						$data['countmt'] = count($data['courses_mb']);
						if($data['countmt']>3)
						$data['countmt'] =3;
						$data['countnum'] = $this->Common_model->convertNum($data['countmt']);
						}
						
					}
					
					
					$data['state'] = $this->user_model->get_state();		
					$data['month']=$this->user_model->listmonth();
					$currentyear=date('Y');	
					$data['year']=$this->user_model->listyear($currentyear);	
				}
				$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();
				$this->load->view("client_common_header_course",$this->gen_contents);				
				$this->load->view('user/remaincourse',$data);
				$this->load->view("client_common_footer",$this->gen_contents);		
			}
			else{
				redirect("home");
			}
		
		}	
		
		/*end */
	
		/**
		 * function for list renew course
		 *
		 */	
		 
		 function _init_new_renew_order(){
		 
		 		$this->load->helper("form");
				//Registration step2 
				$this->load->library("form_validation");			
				$this->load->model('Common_model');
				$this->load->model('user_model');
			
				if(!empty($_POST)) {
					$this->_init_renewal_rules();	
						
						if($this->form_validation->run() == TRUE) {	
						$state= $this->user_model->selectstate($this->input->post('b_state'));
						//init payment details
						$this->_init_user_new_paymentdetails($state[0]['state']);
						 
						$data['payment']=$this->user_model->payment($this->new_payment_contents);
						
						if("SUCCESS" == strtoupper($data['payment']["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($data['payment']["ACK"])) {
								//$this->_init_user_order($data['payment']["TRANSACTIONID"]);
								//$redirect_action	=	"renew_result_success";
							
								$userid =$this->session->userdata('USERID');							
								$courseid = $this->input->post('courseid');	
								
								$emailid= $this->user_model->get_mail($this->session->userdata('USERID'));
								$renew_date =date('Y-m-d');
								$this->course_det= array(
														"reg_courseid" => $this->input->post('usercourse'),
														"b_address"=> $this->input->post('b_address'),
														"b_city"=> $this->input->post('b_city'),
														"b_state"=> $this->input->post('b_state'),
														"b_country"=> $this->input->post('b_country'),
														"b_zipcode"=> $this->input->post('b_zipcode'),
														"renew_date"=> $renew_date
								                      )	;
								$this->renew_mail_contents = array(
															"b_address"=> $this->input->post('b_address'),
															"b_city"=> $this->input->post('b_city'),
															"b_zipcode"=> $this->input->post('b_zipcode'),
															"b_country"=>'United States',
															"b_state"=> $state[0]['state'],
															"useremail"=> $this->input->post('emailid'),	
															"coursename"=> $this->input->post('coursename'),																													
															"name"=> $this->input->post('firstname')." ".$this->input->post('lastname'),															
															"coursename"=> $this->input->post('coursename'),
															"renew_date"=> $renew_date,
															"courseprice"=> $this->input->post('totalprice')
															);					
								$result2	=	$this->user_model->renewcourse($this->course_det);
								$this->session->set_flashdata('msg',"Renewed Succesfully");	
								$this->user_model->send_renewal_mailto_user($this->renew_mail_contents);
								redirect("exam/courselist");
						
					} else{
						$this->session->set_userdata('msg',"Payment Transaction Failed ".urldecode($data['payment']['L_LONGMESSAGE0']));
						redirect("exam/courselist");
					}
				}
				
			}
		 }
		 
		 function renewal(){
		 $usercourse = $this->uri->segment(3);
		 $data['usercourse'] = $usercourse;
		 if($this->authentication->logged_in("normal")){
			$this->load->helper("form");
				$this->load->model('Common_model');
				$this->load->model('user_model');
					if(!empty($_POST) ) {
				
					$this->_init_new_renew_order();
				}else{
					$this->gen_contents['userid']=$this->session->userdata('USERID');	
					$data['license']= $this->user_model->get_license($this->session->userdata('USERID'));
					
					$billing= $this->user_model->get_b_address($this->session->userdata('USERID'));
					$data['billing'] =$billing[0];
					$data['phone'] = $data['billing']['phone'];
					$data['firstname'] = $data['billing']['firstname'];
					$data['lastname'] = $data['billing']['lastname'];
					$data['emailid'] = $data['billing']['emailid'];			
					
					$this->session->set_userdata ("usercourse", $usercourse); 
					
					$data['renewcourse']=$this->Common_model->list_renewcourse($usercourse);				
					$data['state'] = $this->user_model->get_state();		
					$data['month']=$this->user_model->listmonth();
					$currentyear=date('Y');	
					$data['year']=$this->user_model->listyear($currentyear);	
				}
				$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();
				$this->load->view("client_common_header",$this->gen_contents);				
				$this->load->view('user/renewcourse',$data);
				$this->load->view("client_common_footer",$this->gen_contents);		
			}
			else{
				redirect("home");
			}
		 
		 }
		 

		 /* end */	
		/**
		 * function for user login
		 *
		 */
		function login() {	
			if($this->authentication->logged_in("normal"))
				redirect("profile");
			else
				$this->gen_contents['msg']=$this->session->userdata('CHECKUSERSTATUS');	
				
				if(!empty($_POST)){	
				
					$this->load->library('form_validation');	
					$this->form_validation->set_rules('username', 'USERNAME', 'required|max_length[100]');
					$this->form_validation->set_rules('password', 'PASSWORD', 'required');
					
					if ($this->form_validation->run() == FALSE) {// form validation
						$this->gen_contents['msg']='Failed';
					}else {						
					
						$this->_init_user_details();
						$login_details['username']	=	$this->username;
						$login_details['password']	=	$this->password;
						$msg	=	$this->authentication->process_user_login($login_details);
												
						if($msg=='freezed')
							$this->session->set_flashdata('msg', 'Your Account is Freezed');
							
						elseif ($msg=='success')
							redirect("profile");						
						else 

							$this->session->set_flashdata('msg', 'Invalid Login');
							

					}
				}
				redirect("home");
		}
		

		
		/**
		 * get the values from the POST and Input it into safe_html
		 *
		 */
		function _init_user_details() {
			
			$this->username = $this->Common_model->safe_html($this->input->post("username"));
			$this->password = $this->Common_model->safe_html($this->input->post("password"));
		}	
		
		/**
		 * get the values from the POST and Input it into safe_html
		 *
		 */
		function _init_fogot_password_details() {
			
			$this->email = $this->Common_model->safe_html($this->input->post("email"));
			
		}	
		
		/**
		 * get the values from the POST and Input it into safe_html
		 *
		 */
		function _init_change_password_details() {
			
			$this->old_password = $this->Common_model->safe_html($this->input->post("old_password"));
			$this->new_password = $this->Common_model->safe_html($this->input->post("new_password"));
			
		}	
		
		
		/**
		 * after sucessfull login for user
		 *
		 */
		function profile(){
			
			if(!$this->authentication->logged_in("normal"))
				redirect("home");
			$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();
			$this->load->view("client_common_header",$this->gen_contents);						
			$this->load->view('profile');
			$this->load->view("client_common_footer",$this->gen_contents);
		}
		
		
		/**
		 * forget password
		 *
		 */
		function forgot_password(){
			$this->load->helper("form");
			if($this->authentication->logged_in("normal"))
				redirect("profile");
				
			if(!empty($_POST))	{
				
				$this->load->library('form_validation');
				
				$this->form_validation->set_rules ('email', 'Email', 'trim|required|valid_email');
				
				if (!$this->form_validation->run() == FALSE) {// form validation
					
					$this->load->model('user_model');
					$this->load->model('admin_user_model');
				
					
					$this->_init_fogot_password_details();	
					
					if($data=$this->user_model->get_password($this->email)){
	
						$password=random_string('alnum',$len=12);
						if($this->user_model->change_password($this->email,$data->id,md5($password))){
							
							$admin=$this->user_model->get_admin();
							
							$subject="Your New password is :".$password;
							
							if($this->admin_user_model->send_mail($this->email,$admin[0]['emailid'],'Forget Password',$subject))
								$this->session->set_flashdata('msg', "Password sent to the mail you entered");
							else 
								$this->session->set_flashdata('msg', "Can't send New Password");
							
						}else{
							$this->session->set_flashdata('msg', "Can't send New Password");
						}
						
					}
					else{
						
						$this->session->set_flashdata('msg', 'Please enter your correct Email Address');
					}
		
				}
				
			}
				
			redirect('home/forgot_password');

		}
		
		/**
		 * Change password
		 *
		 */
		function change_password(){
			$this->load->helper("form");
			if(!$this->authentication->logged_in("normal"))
				redirect("user/login");
				
			$this->gen_contents['page_title']='Change Password ';
			
			if(!empty($_POST))	{
				
				$this->load->library('form_validation');
				
				$this->form_validation->set_rules ('old_password', 'Password', 'required');
				$this->form_validation->set_rules('new_password', 'Password', 'required|matches[confirm_password]');
				$this->form_validation->set_rules('confirm_password', 'Confirmpassword', 'required');
				
				if (!$this->form_validation->run() == FALSE) {// form validation
					
					$this->load->model('user_model');
					
				
					
					$this->_init_change_password_details();	
					$userid		=	$this->session->userdata ('USERID');
					$email_id	=	$this->session->userdata ('EMAIL');
					if($this->user_model->confirm_password(md5($this->old_password),$userid)){
	
						if($this->user_model->change_password($email_id,$userid,md5($this->new_password))){
							
							$this->session->set_flashdata('success', "Password changed successfully");
							
						}else{
							$this->session->set_flashdata('error', "Request Failed");
						}
						
					}
					else{
						
						$this->session->set_flashdata('error', 'Please enter your correct Old Password');
					}
		
				}
				
			}
				
			//redirect('home/change_password');
			$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();
			$this->load->view("client_common_header",$this->gen_contents);						
			$this->load->view('user/change_password');
			$this->load->view("client_common_footer",$this->gen_contents);
		}

		
		
		
		
		/**
		 * logout for user
		 *
		 */	
		function logout ()
		{
			if(!$this->authentication->logged_in("normal"))
				redirect("home");
			$this->authentication->logout();
			redirect('home');
/*			$this->load->view("client_common_header",$this->gen_contents);						
			$this->load->view('user/client_home_page');
			$this->load->view("client_common_footer");*/
		}
		
		
}
?>
