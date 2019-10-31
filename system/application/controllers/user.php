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

class User extends Controller 
{
	var $gen_contents = array();
	var $order_contents = array();
	var $user_contents = array();
        var $user_forum_contents=array();
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
	
        
	/**
	 * init function
	 * Enter description here ...
	 */
	function User(){
            error_reporting(E_ALL);
            ini_set('dispaly_errors',1);
            parent::Controller();

            $this->load->model('Common_model');       
            $this->load->model('user_model'); 
            $this->load->model('course_model');
            $this->load->helper("fedex");

            //$this->config->item ('site_basepath').'system/application/libraries/vbintegration.php';
            //require_once $this->config->item('site_basepath').'/system/application/libraries/vbintegration.php';

            $this->gen_contents['css'] = array('style.css','dhtmlgoodies_calendar.css','client_style.css');
            $this->gen_contents['js'] = array('userdetails.js','popcalendar.js','client_login.js');
            $this->load->model('admin_sitepage_model'); 
			
	}
	
	/**
	 * incex function
	 * Enter description here ...
	 * @access public
	 * @param void
	 * @return void
	 */
	function index() {
		if($this->authentication->logged_in("normal"))
			redirect("profile");			
		
		redirect("home");
	}
        
        
        /**
         * Function User registration
         * @param type $step_back
         */        
        function register() {
            if($this->authentication->logged_in("normal")){
                redirect("profile");
            }
            $this->session->unset_userdata('reg_data');
            $this->load->library("form_validation");
            $this->gen_contents['css']      = array_merge($this->gen_contents['css'], array("register.css"));
            $this->gen_contents['js']       = array_merge($this->gen_contents['js'], array("register.js"));
            
            $this->gen_contents['state']            = $this->user_model->get_state();
            $this->gen_contents['state_selected']   = 'CA';
            $this->template->set_template('user');
            $this->template->write_view('content', 'reskin/register', $this->gen_contents);
            $this->template->render();
        }

	/**
	 * Validation rules for new orders
	 * @access public
	 * @param void
	 * @return void
	 */
	function _init_neworder_rules()
	{
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
		$this->form_validation->set_rules('bphone', 'Phone Number', 'required|max_length[128]');
		$this->form_validation->set_rules('firstname', 'First Name', 'required|max_length[128]');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required|max_length[128]');
		$this->form_validation->set_rules('emailid', 'Email', 'required|max_length[128]');
	}
	
	/**
	 * validation rules for renewal
	 * @access public
	 * @param void
	 * @return void
	 */
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
            $this->form_validation->set_rules('bphone', 'Phone Number', 'required|max_length[128]');
            $this->form_validation->set_rules('firstname', 'First Name', 'required|max_length[128]');
            $this->form_validation->set_rules('lastname', 'Last Name', 'required|max_length[128]');
            $this->form_validation->set_rules('emailid', 'Email', 'required|max_length[128]');
            $this->form_validation->set_rules('usercourse', 'User Course', 'required|max_length[128]');
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
                
        /**
         * Added function init recepient
         * Created on 14th May 2013
         * Developer : sam@rainconcert.in
         */
        function _init_recipient(){

            if ($this->session->userdata('firstname') || $this->session->userdata('lastname')){
                $user_name = $this->session->userdata('firstname')." ".$this->session->userdata('lastname');
            }else{
                $user_name = get_loggedin_username();
            }


            $this->aryRecipient = array(
                                    'Contact' => array(
                                            'PersonName' => $user_name,
                                            //'CompanyName' => 'Company Name',
                                            'PhoneNumber' => $this->input->post('bphone')
                                    ),
                                    'Address' => array(
                                            'StreetLines' => $this->input->post('s_address').', '.$this->session->userdata('unit_number'),
                                            'City' => $this->input->post('s_city'),
                                            'StateOrProvinceCode' => $this->input->post('s_state'),
                                            'PostalCode' => $this->input->post('s_zipcode'),
                                            'CountryCode' => $this->input->post('s_country'),
                                            'Residential' => false)
                                );
        }
                
                
    /**
     * Added function init package
     * Created on 14th May 2013
     * Developer : sam@rainconcert.in
     */                                                
    function _init_package($courseDetails){
        $package_weight = $courseDetails['course_weight'];
        $est_amount = $courseDetails['course_amount'];
        $arrCourseDetails = $courseDetails['arrCourseDetails'];
        $packagingType = $courseDetails['packagingType'];

        $order_id = $this->course_contents['orderid'];

        $packetDescription = "FEDEX Package for order ".$order_id;
        $packageDetails = array(
                            0 => array(
                                'weight'            => $package_weight,
                                'ItemDescription' => $packetDescription
                            )
                        );
        $packageDetails[0]     = array_merge($packageDetails[0], get_fedex_packaging_dimension($packagingType));

        $cnt = 0;
        foreach($arrCourseDetails as $courseDetails){
            $aryPackageItems[$cnt]['item_qty'] = 1;
            $aryPackageItems[$cnt]['item_price'] = $courseDetails['amount'];
            $aryPackageItems[$cnt]['item_name'] = $courseDetails['course_name'];
            $aryPackageItems[$cnt]['item_weight'] = $courseDetails['wieght'];

            $cnt++;
        }

        $this->realPackages = array(
                        0 => array(
                            'packageDetails' => $packageDetails,
                            'aryPackageItems' => $aryPackageItems,  
                            'package_amount' => $est_amount
                        )
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
                        "course_price" 	    => (float) $this->input->post('totalprice') - (float) $this->input->post('shipprice'),//$this->input->post('price'),
                        "transactionid"		=> 	$transactionid,
                        "payment_method"	=> 'Paypal Payment Method',
                        "orderdate" 		=> 	convert_UTC_to_PST_date(date('Y-m-d H:i:s'))

                        );

        }
        function _init_payment_log($name,$emailid,$status,$course_name){
                                $this->payment_log =array(						

                                                "name"				=> 	$name,						
                                                "emailid" 			=> $emailid,
                                                "paymentdate"		=> convert_UTC_to_PST_datetime(date("Y-m-d H:i:s")),
                                                "b_address" 		=> $this->session->userdata('b_address').",".$this->session->userdata('b_city').
                                                                                                        ",".$this->session->userdata('b_state').",".$this->session->userdata('b_country').",".$this->session->userdata('b_zipcode'),

                                                "s_address" 		=> $this->session->userdata('s_address').",".$this->session->userdata('s_city').
                                                                                                        ",".$this->session->userdata('s_state').",".$this->session->userdata('s_country').",".$this->session->userdata('s_zipcode'),
                                                "coursename" 		=> $course_name,
                                                "status" 			=> $status
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
		
		
		/*******************************Registration*******************************/
		/**
		 * function for add new course
		 *
		 */
		function _init_new_order(){
		
                        $this->load->helper("form");
                        $this->load->helper("fedex");
                                				
			//Registration step2 
			
				$this->load->library("form_validation");			
				$this->load->model('Common_model');
				$this->load->model('user_model');
				
				if(!empty($_POST)) {
					$this->_init_neworder_rules();	
						
						if($this->form_validation->run() == TRUE) {	
					
						
						$state= $this->user_model->selectstate($this->input->post('b_state'));
						$name 		=	$this->input->post('firstname')." ".$this->input->post('lastname');
						$emailid	= 	$this->input->post('emailid');
						$course_name ='';
						$course ='';
						$subcourseid ='';
						$course_o ='';
						
						// set new zipcode
						$this->session->set_userdata('zipcode', $this->input->post('s_zipcode'));
						$this->session->set_userdata('s_zipcode', $this->input->post('s_zipcode'));
						
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

						
						//init payment details
						$this->_init_user_new_paymentdetails($state[0]['state']);	
                                                $temp_res = $this->saveRenewReenrollDataInTemp($course,0);
						$data['payment']=$this->user_model->payment($this->new_payment_contents);	
                                                if("SUCCESS" == strtoupper($data['payment']["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($data['payment']["ACK"])) {  
								//echo "Testing";exit;
                                                                $this->_init_user_order($data['payment']["TRANSACTIONID"]);
								$redirect_action	=	"addcourse_result_success";
								/**
								*paymentlog
								**/							
								$status =$data['payment']["ACK"];							
								$this->_init_payment_log($name,$emailid,$status,$course_name);
								$this->user_model->paymentlog($this->payment_log);
								/*****/
                                                                 
                                                                $course_us_type = $this->user_model->get_course_user_type($this->session->userdata('USERID'));
								$this->new_order_contents['userid'] =$this->session->userdata('USERID');
								//$this->new_order_contents['ship_method'] =$this->user_model->servicemethod($this->input->post('shipid'));
								$this->new_order_contents['ship_method'] = str_replace("_"," ",$this->input->post('shipid'));
                                $this->new_order_contents['packaging_type'] = get_fedex_packaging_type(count($course));
                                                                
                                                                
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
								//$this->_init_user_new_ship();
                                                                $this->_init_recipient();
                                                                
                                                                $courseDetails = $this->user_model->get_course_details($this->course_contents);
                                                                $course_weight = $courseDetails['course_weight'];
                                                                $course_amount = $courseDetails['course_amount'];
                                                                $arrCourseDetails = $courseDetails['arrCourseDetails'];
                                                                $courseDetails['packagingType'] = $this->new_order_contents['packaging_type'];
                                                                $this->_init_package($courseDetails);
                                                                
								//$course_weight	=	$this->user_model->get_courseweight($this->course_contents);
								//$this->new_ship_contents['courseweight'] = $course_weight;
								//$ship =  $this->user_model->shipmaterial($this->new_ship_contents,$admindetails);
								
                                /*$aryOrder = array(
                                    'TotalPackages' => 1,
                                    'PackageType' => 'YOUR_PACKAGING',        //FEDEX_10KG_BOX, FEDEX_25KG_BOX, FEDEX_BOX, FEDEX_ENVELOPE, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING
                                    'ServiceType' => $this->input->post('shipid'),
                                    'TermsOfSaleType' => "DDU",         #    DDU/DDP
                                    'DropoffType' => 'REGULAR_PICKUP'         // BUSINESS_SERVICE_CENTER, DROP_BOX, REGULAR_PICKUP, REQUEST_COURIER, STATION
                                );*/

                                $aryOrder   = get_fedex_order_array(count($course));

                                //$ship =  setShipment($aryOrder,$this->aryRecipient,$this->realPackages,$course_amount,$course_weight);
                                $ship = 'error';
                                $this->_int_user_new_mail($this->course_contents);
                                                               
								$this->order_updates ='';
								if($ship !='error'){		
							
									/*$this->order_updates =array(						
												"trackingno" => $ship[29],
												"label_path" => $ship['label'],
												"status" => 'S'
												);*/
                                                                        $this->order_updates =array(						
												"trackingno" => $ship['trackingno'],
												"label_path" => $ship['label'],
												"status" => 'S'
												);
												$orderid= $result1;
									$this->user_model->updateorder($this->order_updates,$orderid);
									
									$redirect_action	=	"user/addcourse_result_success";
									$this->session->set_flashdata('success',"New Course(s) Added Successfully");
									
                                                                        if($temp_res){
                                                                            $this->user_model->temp_renew_reenroll_update($temp_res,$data['payment']["TRANSACTIONID"]);
                                                                        }
								} else{ 
									$redirect_action	=	"user/addcourse_result_success_reship";

									$this->order_updates ='';	
									$this->session->set_flashdata("success","New Course(s) Added Successfully and administrator will reship it");														
									$this->user_model->new_send_mailto_admin($this->new_mail_contents,$this->new_order_contents,$admindetails,$this->order_updates,$course_us_type);
                                                                        if($temp_res){
                                                                            $this->user_model->temp_renew_reenroll_update($temp_res,$data['payment']["TRANSACTIONID"]);
                                                                        }
								}
								
								$this->user_model->new_send_mailto_user($this->new_mail_contents,$this->new_order_contents,$this->order_updates,$course_us_type);
								$this->user_model->new_send_mailto_admin($this->new_mail_contents,$this->new_order_contents,$admindetails,$this->order_updates,$course_us_type);
								
								
								redirect("course/courselist");
						
					} else{
						//$this->gen_contents["msg"]="Payment transaction failed. ".urldecode($data['payment']['L_LONGMESSAGE0']);
						$this->message["error"]="Payment transaction failed. ".urldecode($data['payment']['L_LONGMESSAGE0']);
						/**
						*paymentlog
						**/							
						$status =urldecode($data['payment']['L_LONGMESSAGE0']);
						$this->_init_payment_log($name,$emailid,$status,$course_name);
						$this->user_model->paymentlog($this->payment_log);
						/*****/
                                                if($temp_res){
                                                    $this->user_model->temp_renew_reenroll_update($temp_res,"PAYMENT FAILED");
                                                }
						return false;
						
					}
				}
				 else{
				 		
						return false;
					}
			}
			else{
					$this->gen_contents["msg"]="Failed to process please try again ";
					return false;
				}
			
		}

		/*end *
		
		/**
		 * function for list remaining course
		 *
		 */		
		function listremainingcourse(){
			if(!$this->authentication->logged_in("normal")){
				loginto_continue_msg();
			}		
			
			$this->load->helper("form");
			$this->load->model('Common_model');
			$this->load->model('user_model');
                        
                        $license= $this->course_model->get_license($this->session->userdata('USERID'));
                        $course_user_type_check = $this->course_model->get_user_course_types($this->session->userdata('USERID'));
                        $package_type= $this->course_model->get_user_package_type($this->session->userdata('USERID'));
                        $this->gen_contents['add_status']= $this->course_model->check_addcourse($this->session->userdata('USERID'),$license,$course_user_type_check,$package_type);
			if(!$this->gen_contents['add_status']) 
                        {
                            $this->session->set_flashdata("error","Courses already added.");
                            redirect("course/courselist/".base64_encode("Courses already added"));
                        }
                        $page_submit_error	=	FALSE;
			if(!empty($_POST) ) {
				if('' != $_POST['s_address']){
					if($this->_init_new_order() == false) {
						$page_submit_error	=	FALSE;
					}
				}
			} else {
						$page_submit_error	=	FALSE;
			}
				
			if($page_submit_error == FALSE) {
				
				$this->gen_contents['userid']=$this->session->userdata('USERID');	
				$data['license']= $this->user_model->get_license($this->session->userdata('USERID'));
				$data['course_user_type']= $this->user_model->get_course_user_type($this->session->userdata('USERID'));
                                
                                /* Get new package for sales*/
                                //$package_type= $this->course_model->get_user_package_type($this->session->userdata('USERID'));
                                if($package_type == 1)
                                {
                                    $data['course_user_type'] = 13;
                                }
                                
                                $data['coursearr']=$this->Common_model->listallcourses_type($data['course_user_type']);
                                
                                //$data['coursearr']=$this->Common_model->listallcourses();
				$billing= $this->user_model->get_b_address($this->session->userdata('USERID'));
				$shipping= $this->user_model->get_s_address($this->session->userdata('USERID'));
				$data['billing'] =$billing[0];
				$data['shipping'] =$shipping[0];
				$data['phone'] = $data['billing']['phone'];
				$data['firstname'] = $data['billing']['firstname'];
				$data['lastname'] = $data['billing']['lastname'];
				$data['emailid'] = $data['billing']['emailid'];		
				
				$data['subcourses']=$this->Common_model->sub_remain_courselist($this->session->userdata('USERID'));
				if($data['license'] == 'S'){
					if($data['subcourses'] != false){
					$data['courses_m']=$this->Common_model->license_remain_courselist_m($data['license'],$this->session->userdata('USERID'),$data['course_user_type']);
					}
					else{
					$data['courses_m']=$this->Common_model->license_remain_courselist_nm($data['license'],$this->session->userdata('USERID'),$data['course_user_type']);
					//$data['courses_mt']=$this->Common_model->license_remain_courselist_nmt($data['license'],$this->session->userdata('USERID'));
					}
					$data['courses_o']=$this->Common_model->license_remain_courselist_o($data['license'],$this->session->userdata('USERID'),$data['course_user_type']);
				}
				if($data['license'] == 'B'){
					if($data['subcourses'] != false){
					//echo "hi2";
					$data['courses_mb']=$this->Common_model->license_remain_courselist_mb($data['license'],$this->session->userdata('USERID'),$data['course_user_type']);
					//print_r($data['courses_mb']);
					$data['courses_mt']=$this->Common_model->license_remain_courselist_mt($data['license'],$this->session->userdata('USERID'),$data['course_user_type']);
					$data['countmt'] = count($data['courses_mb']);
					if($data['countmt']>3)
					$data['countmt'] =3;
					$data['countnum'] = $this->Common_model->convertNum($data['countmt']);
					}
					else{
					
					$data['courses_mb']=$this->Common_model->license_remain_courselist_nmb($data['license'],$this->session->userdata('USERID'),$data['course_user_type']);
					$data['courses_mt']=$this->Common_model->license_remain_courselist_nmt($data['license'],$this->session->userdata('USERID'),$data['course_user_type']);
					$data['countmt'] = count($data['courses_mb']);
					if($data['countmt']>3)
					$data['countmt'] =3;
					$data['countnum'] = $this->Common_model->convertNum($data['countmt']);
					}
					
				}
				$data['courses'] = $this->Common_model->getCourses($data['course_user_type']);
				
				$data['state'] = $this->user_model->get_state();		
				$data['month']=$this->user_model->listmonth();
				$currentyear=convert_UTC_to_PST_year(date('Y-m-d H:i:s'));	
				$data['year']=$this->user_model->listyear($currentyear);	
			}
			/**
                        $this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();
			$this->load->view("client_common_header_course_new",$this->gen_contents);
			$this->load->view('user/remaincourse_new',$data);
			$this->load->view("client_common_footer_main_new",$this->gen_contents);
                        
                         */
                        $this->template->set_template('user');
                        $this->template->write_view('content', 'reskin/course/apply_new', $data);
                        $this->template->render();
                       
		
		}	
		
		/*end */
	
		/**
		 * function for list renew course
		 *
		 */	
		 
		 
		 function renewal(){
                    if(!$this->authentication->logged_in("normal")){		 
                        loginto_continue_msg();
                    }
                    $usercourse         = ($this->uri->segment(3)>0)?$this->uri->segment(3):$_POST['usercourse'];
                    $reneroll           = ($this->uri->segment(4)>0)?$this->uri->segment(4):0;
                    
                    $data['usercourse'] = $usercourse;
                    $this->load->helper("form");
                    $this->load->model('Common_model');
                    $this->load->model('user_model');

                    $page_submit_error	=	FALSE;
                    
                    if(!empty($_POST) ) {
                        if(isset($_POST['b_address']) && '' != $_POST['b_address']){
                            if($this->_init_new_renew_order() == false) {
                                $page_submit_error	=	FALSE;
				$validation_error = $this->session->userdata('validation_error');
				if($validation_error){
					$this->message['error'] = $validation_error;
				}
                            }
                        }
                    }else{
                         $page_submit_error	=	FALSE;
                    }
                    if($page_submit_error == FALSE) {
                        $this->gen_contents['userid']   = $this->session->userdata('USERID');	
                        $data['license']                = $this->user_model->get_license($this->session->userdata('USERID'));
                        $data['course_user_type']       = $this->user_model->get_course_user_type($this->session->userdata('USERID'));

                        $billing= $this->user_model->get_b_address($this->session->userdata('USERID'));
                        $data['billing']    = $billing[0];
                        $data['phone']      = $data['billing']['phone'];
                        $data['firstname']  = $data['billing']['firstname'];
                        $data['lastname']   = $data['billing']['lastname'];
                        $data['emailid']    = $data['billing']['emailid'];			

                        $this->session->set_userdata ("usercourse", $usercourse); 
                        $data['u_course']   = $this->Common_model->u_course($usercourse);
                        $data['renewcourse']= $this->Common_model->list_renewcourse_user($data['u_course'],$data['course_user_type']);
                        $data['state']      = $this->user_model->get_state();		
                        $data['month']      = $this->user_model->listmonth();
                        $currentyear        = convert_UTC_to_PST_year(date('Y-m-d H:i:s'));	
                        $data['year']       = $this->user_model->listyear($currentyear);	
                    }
                    $this->gen_contents['siteurl']  = $this->admin_sitepage_model->select_sitepages_url();
                    
                    $this->template->set_template('user');
                    $this->template->write_view('content', 'reskin/course/renewal', $data);
                    $this->template->render();
		 }
                 
                 
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
                                $name 		= $this->input->post('firstname')." ".$this->input->post('lastname');
                                $emailid	= $this->input->post('emailid');
                                $course_name    = $this->input->post('coursename');

                                //init payment details
                                $this->_init_user_new_paymentdetails($state[0]['state']);
                                $re_type   = ($this->uri->segment(4)>0)?$this->uri->segment(4):0;
                                
                                if(1 == $re_type){
                                    $temp_res = $this->saveRenewReenrollDataInTemp('',2);      // Re enroll
                                }else{
                                    $temp_res = $this->saveRenewReenrollDataInTemp('',1);      // Renew
                                }
                                
                                $data['payment']=$this->user_model->payment($this->new_payment_contents);

                                if("SUCCESS" == strtoupper($data['payment']["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($data['payment']["ACK"])) {
                                    /**
                                    *paymentlog
                                    **/		
                                    //echo "Testing";exit;
                                    $status     = $data['payment']["ACK"];							
                                    $this->_init_payment_log($name,$emailid,$status,$course_name);
                                    $this->user_model->paymentlog($this->payment_log);
                                    /*****/
                                    $userid             = $this->session->userdata('USERID');							
                                    $courseid           = $this->input->post('courseid');	
                                    $course_user_type   = $this->user_model->get_course_user_type($this->session->userdata('USERID'));
                                    $emailid            = $this->user_model->get_mail($this->session->userdata('USERID'));
                                    $renew_date         = date('Y-m-d H:i:s');
                                    $this->course_det           = array(
                                                                    "reg_courseid" => $this->input->post('usercourse'),
                                                                    "b_address"=> $this->input->post('b_address'),
                                                                    "b_city"=> $this->input->post('b_city'),
                                                                    "b_state"=> $this->input->post('b_state'),
                                                                    "b_country"=> $this->input->post('b_country'),
                                                                    "b_zipcode"=> $this->input->post('b_zipcode'),
                                                                    "renew_date"=> convert_UTC_to_PST_date($renew_date)
                                                                  )	;
                                    $this->renew_mail_contents  = array(
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
                                    $result2                = $this->user_model->renewcourse($this->course_det);
                                    //$this->session->set_flashdata('msg_type', 'success');
                                    //$this->session->set_flashdata('msg',$this->input->post('coursename')." Renewed Successfully");
                                    
                                    $reneroll           = ($this->uri->segment(4)>0)?$this->uri->segment(4):0;
                                    $this->user_model->clear_reenrolls($userid,$courseid,$reneroll);
                                    
                                    if($reneroll){
                                        $this->session->set_flashdata('success', $this->input->post('course_name') . " Re-enrolled Successfully");
                                    }else{
                                        $this->session->set_flashdata('success', $this->input->post('course_name') . " Renewed Successfully");
                                    }
                                    
                                    /*echo $this->session->flashdata('msg');
                                    echo $this->session->flashdata('msg_type');exit;*/
                                    $this->user_model->send_renewal_mailto_user($this->renew_mail_contents,$course_user_type);
                                     
                                    if($temp_res){
                                        $this->user_model->temp_renew_reenroll_update($temp_res,$data['payment']["TRANSACTIONID"]);
                                    }
                                    redirect("course/courselist");

                                } else{

                                    $this->gen_contents["msg"]="Payment transaction failed. ".urldecode($data['payment']['L_LONGMESSAGE0']);
                                    /**
                                    *paymentlog
                                    **/							
                                    $status = urldecode($data['payment']['L_LONGMESSAGE0']);
                                    $this->_init_payment_log($name,$emailid,$status,$course_name);
                                    $this->user_model->paymentlog($this->payment_log);
                                    /*****/
                                    $this->session->set_userdata('validation_error', $this->gen_contents["msg"]);
                                    if($temp_res){
                                        $this->user_model->temp_renew_reenroll_update($temp_res,"PAYMENT FAILED");
                                    }
                                    return false;
                                }

                            } else{

                                            $this->gen_contents["msg"]="Fill Required Fields";
                                            return false;
                            }

                    }
                    else{
                                            $this->gen_contents["msg"]="Failed to process please try again ";
                                            return false;
                    }
		 }
		 
                 
                 
		 /* end */	
                 
		/**
		 * function for user login
		 *
		 */
		function login() {
                    /* Check whether the call is ajax , if not redirect to home page and popup the login box */
                    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                        $this->_user_login();
                    }else if($this->authentication->logged_in("normal")){
                        redirect('/profile');
                    }else{                        
                        //$this->session->set_flashdata('SHOW_LOGIN_POPUP', TRUE);
                        redirect('/home/index/login');
                    }
		}
                
                /* ajax call for user login */
                function _user_login(){
                    $response =array();
			 
                    if($this->authentication->user_logged_in()){
                        $response['status']="success";
                        $response['error_status']= 'profilepage';
                        $response['msg']="";
                        echo json_encode($response);exit;
                    }else{
                        //$response['msg']=$this->session->userdata('CHECKUSERSTATUS');                                 
                        $this->authentication->reinstate_expired_update();                                
                    }
                    if(!empty($_POST)){                    				
                            $this->load->library('form_validation');	
                            $this->form_validation->set_rules('username', 'Email Address', 'required|max_length[100]');
                            $this->form_validation->set_rules('password', 'Password', 'required');					
                            if ($this->form_validation->run() == FALSE) {
                                    $response['status']="error";
                                    $response['error_status']= 'validation';                         
                                    $response['msg']= validation_errors();
                            }else {						

                                    $this->_init_user_details();
                                    $login_details['username']		= $this->username;
                                    $login_details['password']		= $this->password;
                                    $login_details['forced_login']	= $this->forced_login;
                                    $msg                                = $this->authentication->process_user_ajax_login($login_details);
                                    
                                    if ('normal' == $msg['user_type'] && $msg['status']=='success') {
                                        $this->load->model('common_model');
                                        $this->load->model('user_exam_model');
                                        $track_data_arr = $this->common_model->select('adhi_exam_tracking',array('id','score'),array("user_id"=> $this->session->userdata ('USERID'),"status"=>"O"));
                                        if(!empty($track_data_arr)){
                                                foreach ($track_data_arr as $track_data) {
                                                    $grade	= $this->user_exam_model->get_grade($track_data['score']);
                                                    if($grade){
                                                        $status='P';
                                                    }else{
                                                        $status='F';
                                                    }
                                                    $tracking_data	= array(
                                                                    'exam_ended'=> 2, // default value 0, 1 - user clicked end exam, 2 - user closed browser in between
                                                                    'ended_at' 	=> convert_UTC_to_PST_datetime(date('m/d/Y H:i:s')),
                                                                    'status' 	=> $status						
                                                                    );
                                                    $this->user_exam_model->update_exam_tracking($track_data['id'], $tracking_data);
                                                }								
                                        }
                                        //$this->vbulletin = new xvbIntegration();
                                        //$this->vbulletin->xvbLogin($login_details['username'],true);
                                        //$this->user_model->vb_login($login_details['username']);
                                        mob_log_message("start","","");
                                    }else if('trial_period_expired' == $msg['error_status']){
                                        $this->session->set_userdata(array('EXPIRED_TRIAL_ID' => $msg['userid'], 'TRIAL_EXPIRED' => TRUE));
                                    }
                                    $response= $msg;
                            }
                    }

                    $data['return_value']   = json_encode($response);
                    $this->load->view ('dsp_show_ajax',  $data);
                }

        function user_login(){
            
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                $this->_user_login();
            }else if($this->authentication->logged_in("normal")){
                redirect('/profile');
            }else{                        
                //$this->session->set_flashdata('SHOW_LOGIN_POPUP', TRUE);
                redirect('/home/index/login');
            }
            /*
            $this->load->helper(array('form', 'url', 'file'));
			$this->load->library("session");
			$this->gen_contents['css'] = array_merge($this->gen_contents['css'], array("login.css"));
			if($this->authentication->logged_in("normal"))
				redirect("profile");

			$this->gen_contents["msg"]	=	$this->session->userdata ('MSG_LOGIN');
			$this->session->set_userdata ('MSG_LOGIN','');

            $this->load->view("client_common_header_new",$this->gen_contents);
            $this->load->view('user/user_login_new');
            $this->load->view("client_common_footer_new",$this->gen_contents);
             * 
             */
        }
        		/**
		 * showing login with msg
		 *
		 * @access	public
		 */	

         function log_in(){
             $this->gen_contents['css'] = array_merge($this->gen_contents['css'], array("login.css"));
             $this->load->helper(array('form', 'url', 'file'));
			 $this->load->library("session");

			if($this->authentication->logged_in("normal"))
				redirect("profile");
			$msg 		= 	$this->uri->segment(3);
			$this->gen_contents['msg']=$msg;


            $this->load->view("client_common_header_new",$this->gen_contents);
            $this->load->view('user/user_login_new');
            $this->load->view("client_common_footer_new",$this->gen_contents);
		}
		/**
		 * get the values from the POST and Input it into safe_html
		 *
		 */
		function _init_user_details() {
			
			$this->username		 = $this->Common_model->safe_html($this->input->post("username"));
			$this->password 	 = $this->Common_model->safe_html($this->input->post("password"));
			$this->forced_login  = $this->Common_model->safe_html($this->input->post("forced_login"));
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
			$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();
			$this->gen_contents['thinkingabout']=	$this->admin_sitepage_model->select_single_sitepage_det(3);
			$this->gen_contents['gotquestion']	=	$this->admin_sitepage_model->select_single_sitepage_det(4);
			if($this->authentication->logged_in("normal")){
				$response['status']="success";
				$response['error_status']= 'profilepage';
				$response['msg']="";
				echo json_encode($response);exit;
			}
				 
				
			if(!empty($_POST))	{
				
				$this->load->library('form_validation');
				
				$this->form_validation->set_rules ('email', 'Email', 'trim|required|valid_email');
				
				if (!$this->form_validation->run() == FALSE) {// form validation
					
					$this->load->model('user_model');
					$this->load->model('admin_user_model');
				
					//$user = $this->user_model->getTrialUserByEmail($this->email);
					
                                        $this->_init_fogot_password_details();
                                        $error  = 'error';
                                        if($user = $this->user_model->get_password($this->email)){
                                            $first_name = $user->firstname;
                                            $last_name  = $user->lastname;
                                            $userid     = $user->id;
                                            $user_type  = 'normal';
                                            $error      = 'success';
                                        }else if($user = $this->user_model->getTrialUserByEmail($this->email)){
                                            $first_name = $user->first_name;
                                            $last_name  = $user->last_name;
                                            $userid     = $user->id;
                                            $user_type  = 'trial';
                                            if(0 == $user->status){
                                                $msg    = 'Your Trial account is pending status, please verify email.';
                                            }else if(3 == $user->status){
                                                $msg    = 'Your Trial account is expired.';
                                            }else if(1 == $user->status){
                                                $error  = 'success';
                                            }
                                        }else{
                                            $msg    = 'Please enter your correct Email Address';
                                        }
                                        
                                        
					if('success' == $error){
						$password   = random_string('alnum', $len=12);
                                                if('normal' == $user_type){
                                                    $result = $this->user_model->change_password($this->email, $userid, md5($password));
                                                }else if('trial' == $user_type){
                                                    $result = $this->user_model->trial_user_change_password($userid, md5($password));
                                                }
						if($result){
                                                    $subject    = '';
                                                    $subject    .= "Dear ".$first_name. " ".$last_name.",<br><br>";
                                                    $subject    .= "As per your request, new password has been generated as follows<br>";
                                                    $subject    .=" New Password : ".$password."<br><br>"; 
                                                    $subject    .= "Thanks,<br>";
                                                    $subject    .= "Administrator";

                                                    if($this->Common_model->send_mail($this->email, '', 'Forgot Password', $subject)){
                                                            $response['status']         = 'success';
                                                            $response['error_status']   = 'success';
                                                            $response['msg']            = 'Your new Password has been successfully sent to your Email Address';	
                                                    }else {
                                                            $response['status']         = 'error';
                                                            $response['error_status']   = 'error';
                                                            $response['msg']            = "Can't send New Password";
                                                    }
						}else{
							$response['status']         = 'error';
							$response['error_status']   = 'error';
							$response['msg']            ="Can't send New Password";
						}
					}else{
						$response['status']         = 'error';
						$response['error_status']   = 'error';
						$response['msg']            = $msg;
					}
		
				}else{
					$response['status']         ="error";
					$response['error_status']   = 'validation';                         
					$response['msg']            = validation_errors();
				}
				
			}
			echo json_encode($response);exit; 
		}
		
		function change_password(){
                    
                    $this->load->helper("form");
                    if(!$this->authentication->logged_in("normal")){
                        loginto_continue_msg();
                    }
                    $this->gen_contents['page_title']   = 'Change Password ';
                    $this->gen_contents['selected_nav'] = 'change_password';
                    if(!empty($_POST))	{
                        $this->load->library('form_validation');
                        $this->form_validation->set_rules   ('old_password',    'Password',         'required');
                        $this->form_validation->set_rules   ('new_password',    'Password',         'required|matches[confirm_password]');
                        $this->form_validation->set_rules   ('confirm_password','Confirm Password', 'required');
                        if (!$this->form_validation->run() == FALSE) {// form validation
                            $this->load->model('user_model');
                            $this->_init_change_password_details();	
                            $userid	= $this->session->userdata ('USERID');
                            $email_id	= $this->session->userdata ('EMAIL');
                            if($this->user_model->confirm_password(md5($this->old_password),$userid)){
                                if($this->user_model->change_password($email_id,$userid,md5($this->new_password))){
                                    $this->session->set_flashdata('success', "Password changed successfully");
                                    redirect('user/change_password/');
                                }else{
                                    $this->session->set_flashdata('error', "Request Failed");
                                    redirect('user/change_password/');
                                }
                            }else{
                                $this->session->set_flashdata('error', 'Please enter your correct Current Password');
                                redirect('user/change_password/');
                            }
                        }
                    }
                    $this->template->set_template('user');
                    $this->template->write_view('content', 'reskin/user/change_password', $this->gen_contents);
                    $this->template->render();
                    //$this->load->view("client_common_header_new",$this->gen_contents);
					//$this->load->view('user/change_password_new');
					//$this->load->view("client_common_footer_new",$this->gen_contents);
		}
		
		
		
		/**
		 * logout for user
		 *
		 */	
		function logout ()
		{
			if(!$this->authentication->logged_in("normal") && !$this->authentication->logged_in("trial"))
				redirect("home");
			//$this->authentication->update_score($this->session->userdata ('USERID'));// for updating the score/exam details when a user logged before the normal process of the exam
			//mob_log_message("end","","");			
				
			//$this->authentication->logout();
			//redirect('home');
			//mob_log_message("end","","");
                         
                       //$this->vbulletin = new xvbIntegration();
                        //global $vbulletin;
				//echo $this->session->userdata ('USERID');
                              //  echo $this->session->userdata ('EMAIL');
                          //       $f_id=$vbulletin->userinfo['userid'];
                           //   $f_uname =  $this->vbulletin->xvbUserMail($f_id);
                                //xvbUserMail
//                        if($vbulletin->userinfo['userid']=='')
//                        {
//			$this->authentication->logout();
//                        redirect('home');
//                        }  else {
                            
//                           echo "fb".$f_uname['username'];
//                           echo
                              /*if($this->session->userdata ('EMAIL') == $f_uname['email'])
                                  { */
                                 // echo"sdfsd";
                                    $this->authentication->logout();
                                   //    $this->user_model->vb_logout();
                                             redirect('home');
                                             mob_log_message("end","","");
                                   /* }
                                    else{
                                        $this->authentication->logout();
                                        redirect('home');
                                        mob_log_message("end","","");
                                    }*/

                       // }
                         
			//redirect('home');
/*			$this->load->view("client_common_header",$this->gen_contents);						
			$this->load->view('user/client_home_page');
			$this->load->view("client_common_footer");*/
		}
		
	function setShippingAddrToBillingAddr ()
        {
            $state = get_statename($this->session->userdata('state'));
            $data = array('status' => 200, 'data' => array("address" => $this->session->userdata('address'),
                    "state" => $state,
                    "state_code" => $this->session->userdata('state'),
                    "city" => $this->session->userdata('city'),
                    "zipcode" => $this->session->userdata('zipcode'),
                    "country" => $this->session->userdata('country')));
            $this->output->set_header("Content-Type:application/json");
            echo $this->output->set_output(json_encode($data));
        }	

	function renew_courses() {
            $this->load->helper("form");
            $this->load->model("admin_user_model");
            if (!$this->authentication->logged_in("normal")) {
                loginto_continue_msg();
            }
            $userid = $this->session->userdata('USERID');
            $courses_ids = $_POST['courses_ids'];
            if (!$courses_ids || '' == $courses_ids) {
                $this->session->set_flashdata('error', "Invalid request");
                redirect('course/courselist');
            } else {
                $courses_ids = explode(',', $courses_ids);
            }
            $driving_license    = $this->user_model->getDrivingLicense($userid);
            if('' != $driving_license){
                $this->gen_contents["ask_driving_license"]   = true;
            }
            if(isset($_POST['b_address'])){            
                $this->init_renew_courses();
                $validation_error = $this->session->userdata('validation_error');
                if($validation_error){
                    $this->message['error'] = $validation_error;                
                }
            }

        
            $user_details                         = $this->admin_user_model->select_single_userdetails($userid);
            $user_details->phone                   = str_replace(array(' ', '-'),'', $user_details->phone);
            $this->gen_contents["userdetails"]   = $user_details;

            $this->gen_contents['course_user_type']   = $this->user_model->get_course_user_type($userid);
            $this->gen_contents['courses']            = $this->Common_model->getUserRenewCourses($courses_ids, $this->gen_contents['course_user_type'], $userid);
            $book_weight    = 0;
            array_walk($this->gen_contents['courses'], function ($course) use(&$book_weight){
                $book_weight += $course['wieght'];
            });
            $this->gen_contents['shipping_rate']   = $this->_get_shipping_rate(array(
                'address'       => $user_details->s_address,
                'unit_number'   => $user_details->unit_number,
                'zipcode'       => ($this->input->post('zipcode') != '') ? $this->input->post('zipcode') : $user_details->s_zipcode,
                'city'          => $user_details->s_city,
                'state'         => $user_details->s_state,          
                'country'       => $user_details->s_country,
                'phone'         => $user_details->phone,
                'weight'        => $book_weight,
                'books_count'    => count($courses_ids)
            ));

            $this->gen_contents['userid']   = $this->session->userdata('USERID');
            $this->gen_contents['license']                = $this->user_model->get_license($this->session->userdata('USERID'));
            $this->gen_contents['course_user_type']       = $this->user_model->get_course_user_type($this->session->userdata('USERID'));

            //$this->session->set_userdata("usercourse", $usercourse);
            $states                         = $this->user_model->get_state();
            $this->gen_contents['states']   = json_decode(json_encode((object)$states), FALSE);

            $this->gen_contents["s_state"]          = $this->admin_user_model->select_state_name($this->gen_contents["userdetails"]->s_state);
            $this->gen_contents["b_state"]          = $this->admin_user_model->select_state_name($this->gen_contents["userdetails"]->b_state);


            $this->gen_contents['month']  = $this->user_model->listmonth();
            $currentyear    = convert_UTC_to_PST_year(date('Y-m-d H:i:s'));
            $this->gen_contents['year']   = $this->user_model->listyear($currentyear);

            $this->template->set_template('user');
            $this->template->write_view('content', 'reskin/course/renew_courses', $this->gen_contents);
            $this->template->render();
        }
    
    
    function init_renew_courses(){
        $this->load->library("form_validation");
        if (!empty($_POST)) {
            $this->form_validation->set_rules('address', 'Shipping Address', 'required|max_length[128]');
            $this->form_validation->set_rules('state', 'Shipping Address State', 'required|max_length[128]');
            $this->form_validation->set_rules('country', 'Shipping Address Country', 'required|max_length[128]');
            $this->form_validation->set_rules('city', 'Shipping Address City', 'required|max_length[128]');
            $this->form_validation->set_rules('zipcode', 'Shipping Address Zipcode', 'required|max_length[128]');
            
            $this->form_validation->set_rules('b_address', 'Billing Address', 'required|max_length[128]');
            $this->form_validation->set_rules('b_state', 'Billing Address State', 'required|max_length[128]');
            //$this->form_validation->set_rules('b_country', 'Billing Address Country', 'required|max_length[128]');
            $this->form_validation->set_rules('b_city', 'Billing Address City', 'required|max_length[128]');
            $this->form_validation->set_rules('b_zipcode', 'Billing Address Zipcode', 'required|max_length[128]');
            
            $this->form_validation->set_rules('courses_ids', 'Course(s)', 'required');
            $this->form_validation->set_rules('ccno', 'Credit Crad Number', 'required|max_length[128]');
            $this->form_validation->set_rules('cvv2no', 'Credit Card Verification Code', 'required|max_length[128]');
            $this->form_validation->set_rules('cardtype', 'Credit Card Type', 'required|max_length[128]');
            $this->form_validation->set_rules('expmonth', 'Expire Month', 'required|max_length[128]');
            $this->form_validation->set_rules('expyear', 'Expire Year', 'required|max_length[128]');
            $this->form_validation->set_rules('phone', 'Phone Number', 'required|max_length[128]');
            $this->form_validation->set_rules('firstname', 'First Name', 'required|max_length[128]');
            $this->form_validation->set_rules('lastname', 'Last Name', 'required|max_length[128]');
            $this->form_validation->set_rules('email', 'Email', 'required|max_length[128]');
            $this->form_validation->set_rules('unit_number', 'Unit Number', 'max_length[128]');
            if(isset($this->gen_contents["ask_driving_license"]) && TRUE === $this->gen_contents["ask_driving_license"]){
                $this->form_validation->set_rules ('driving_license', 'Drivers License Number', 'required|max_length[20]');
            }
            
            $this->form_validation->set_rules('price_wo_ship', 'Price with out shiprate', 'trim');
            $this->form_validation->set_rules('ship_rate', 'Shiprate', 'trim');
            $this->form_validation->set_rules('totalprice', 'Total Price', 'trim|required|min_value[1]');
            $userid         = $this->session->userdata('USERID');
            $courseid       = $this->input->post('courses_ids');
            if ($this->form_validation->run() == TRUE) {
                $state          = $this->user_model->selectstate($this->input->post('b_state'));                
                $name           = $this->input->post('firstname') . " " . $this->input->post('lastname');
                $emailid        = $this->input->post('email');
                $course_name    = $this->input->post('course_name');
                if($this->user_model->emailidExists($emailid, $userid)){
                   $this->gen_contents["msg"] = 'Email id already exist';
                   return false;
                }
                
                $payment_contents = array(
                    "firstname"     => $this->input->post('firstname'),
                    "lastname"      => $this->input->post('lastname'),
                    "ccno"          => $this->Common_model->safe_html($this->input->post('ccno')),
                    "cardtype"      => $this->input->post('cardtype'),
                    "expmonth"      => $this->input->post('expmonth'),
                    "expyear"       => $this->input->post('expyear'),
                    "cvv2no"        => $this->Common_model->safe_html($this->input->post('cvv2no')),
                    "address1"      => $this->input->post('b_address'),
                    "zipcode"       => $this->input->post('b_zipcode'),
                    "country"       => 'US',
                    "state"         => $state[0]['state'],
                    "city"          => $this->input->post('b_city'),
                    "amount"        => $this->input->post('totalprice')
                );
                

                $data['payment'] = $this->user_model->payment($payment_contents);
                $courses = explode(',', $courseid);
                $temp_res = $this->saveRenewReenrollDataInTemp($courses,1); // Renew Courses
                //echo '<pre>';print_r($_POST);exit;
                //var_dump($this->input->post('usercourse'));exit;
                if ("SUCCESS" == strtoupper($data['payment']["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($data['payment']["ACK"])) {                    
                    //SAVE TRANSACTION
                    $this->_insert_payment_log($name, $emailid, $course_name, $data['payment']["ACK"]);
                    
                    $user_detail    = array(
                            'firstname'         => $this->input->post('firstname'), 
                            'lastname'          => $this->input->post('lastname'),
                            'phone'             => $this->input->post('phone'),
                            'unit_number'       => $this->input->post('unit_number'),
                            "b_address"         => $this->input->post('b_address'),
                            "b_country" 	=> 'US',
                            "b_state"           => $this->input->post('b_state'),
                            "b_city"            => $this->input->post('b_city'),
                            "b_zipcode" 	=> $this->input->post('b_zipcode'),
                            "s_address" 	=> $this->input->post('address'),
                            "s_country" 	=> 'US',
                            "s_state"           => $this->input->post('state'),
                            "s_city"            => $this->input->post('city'),
                            "s_zipcode" 	=> $this->input->post('zipcode'),
                        );
                    if(isset($this->gen_contents["ask_driving_license"]) && TRUE === $this->gen_contents["ask_driving_license"]){
                        $user_detail['driving_license'] = generate_hash($this->Common_model->safe_html($this->input->post('driving_license')));
                    }
                    //UPDATE USER DETAILS
                    $this->user_model->updateUserDetails($userid, $user_detail);
                    
                    //SAVE ORDER DETAILS
                    $order_id = $this->_save_order_details($userid, $data['payment']["TRANSACTIONID"]);                    
                    
                    
                    //RENEW LOG
                    $course_user_type   = $this->user_model->get_course_user_type($userid);
                    $renew_date         = convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
                    $usercoureids       = $this->input->post('usercourse');
                    $usercoureids       = explode(',', $usercoureids);
                    
                    foreach ($usercoureids as $usercourse){
                        $course_details   = array(
                            "reg_courseid"  => $usercourse,
                            "b_address"     => $this->input->post('b_address'),
                            "b_city"        => $this->input->post('b_city'),
                            "b_state"       => $this->input->post('b_state'),
                            "b_country"     => $this->input->post('b_country'),
                            "b_zipcode"     => $this->input->post('b_zipcode'),
                            "renew_date"    => $renew_date
                        );
                        $this->user_model->renewcourse($course_details);
                    }
                    

                    //SHIP BOOKS
                    $courses            = explode(',', $courseid);
                    $ship               = $this->_ship_course_books($order_id, $courses);
                    $order_updates      = '';
                    if($ship != 'error'){
                        $order_updates    = array(
                                                    "trackingno" => $ship['trackingno'],
                                                    "label_path" => $ship['label'],
                                                    "status"    => 'S'
                                                );
                        $this->user_model->updateorder($order_updates, $order_id);

                    } else{ 
                        $this->session->set_flashdata('msg',"Course(s) renewed successfully. Administrator will reship it");
                        //$this->user_model->send_mailto_admin($this->mail_contents, $this->order_contents, $this->session->userdata{'admindetails'}, $order_updates, $usertype);														
                        
                    }
                    
                    $renew_mail_contents = array(
                        "b_address"     => $this->input->post('b_address'),
                        "b_city"        => $this->input->post('b_city'),
                        "b_zipcode"     => $this->input->post('b_zipcode'),
                        "b_country"     => 'United States',
                        "b_state"       => $state[0]['state'],
                        "useremail"     => $this->input->post('email'),
                        "coursename"    => $this->input->post('course_name'),
                        "name"          => $this->input->post('firstname') . " " . $this->input->post('lastname'),                        
                        "renew_date"    => $renew_date,
                        "courseprice"   => $this->input->post('totalprice')
                    );
                    
                    
                    //$this->session->set_flashdata('succcess', 'success');
                    $this->session->set_flashdata('success', $this->input->post('course_name') . " Renewed Successfully");
                    /* echo $this->session->flashdata('msg');
                      echo $this->session->flashdata('msg_type');exit; */
                    $this->user_model->send_renewal_mailto_user($renew_mail_contents, $course_user_type, $order_updates);
                    $this->user_model->send_renewal_mailto_admin($renew_mail_contents, $course_user_type, $order_updates);
                    if($temp_res){
                        $this->user_model->temp_renew_reenroll_update($temp_res,$data['payment']["TRANSACTIONID"]);
                    }
                    redirect("course/courselist");
                } else {

                    $this->gen_contents["msg"] = "Payment transaction failed. " . urldecode($data['payment']['L_LONGMESSAGE0']);
                    
                    $status = urldecode($data['payment']['L_LONGMESSAGE0']);
                    //$this->_init_payment_log($name, $emailid, $status, $course_name);
                    
                    $payment_log = array(
                        "name"          => $name,
                        "emailid"       => $emailid,
                        "paymentdate"   => convert_UTC_to_PST_datetime(date("Y-m-d H:i:s")),
                        "b_address"     => $this->input->post('b_address') . "," . $this->input->post('b_city') .
                                            "," . $this->input->post('b_state') . "," . $this->input->post('b_country') . "," . $this->input->post('b_zipcode'),
                        "s_address"     => $this->input->post('address') . "," . $this->input->post('city') .
                                            "," . $this->input->post('s_state') . "," . $this->input->post('country') . "," . $this->input->post('zipcode'),
                        "coursename"    => $course_name,
                        "status"        => $status
                    );
                    
                    $this->user_model->paymentlog($payment_log);
                    
                    if($temp_res){
                        $this->user_model->temp_renew_reenroll_update($temp_res,"PAYMENT FAILED");
                    }

                    //$this->session->set_flashdata('error', 'failed');
                    $this->session->set_userdata('validation_error', $this->gen_contents["msg"]);
                    //redirect("course/courselist" );

                    /*****/

                    return false;
                }
            } else {
                $this->gen_contents["msg"] = "Fill Required Fields";
                return false;
            }
        } else {
            $this->gen_contents["msg"] = "Failed to process please try again ";
            return false;
        }
    }

    
    
    function _set_order_vaiables(){
        $this->order_contents = array(
                    "b_address"     => $this->regdata['b_address'],
                    "b_country" 	=> $this->regdata['b_country'],
                    "b_state" 	=> $this->regdata['b_state'],
                    "b_city" 	=> $this->regdata['b_city'],
                    "b_zipcode" 	=> $this->regdata['b_zipcode'],
                    "s_address" 	=> $this->regdata['s_address'],
                    "s_country" 	=> $this->regdata['s_country'],
                    "s_state" 	=> $this->regdata['s_state'],
                    "s_city"	=> $this->regdata['s_city'],
                    "s_zipcode" 	=> $this->regdata['s_zipcode'],
                    "total_amount"	=> $this->input->post('totalprice'),
                    "ship_rate" 	=> $this->input->post('shipprice'),
                    "course_price" 	=> $this->input->post('price'),
                    "transactionid"	=> $transactionid,
                    "payment_method"=> 'Paypal Payment Method',
                    "orderdate" 	=> convert_UTC_to_PST_date(date('Y-m-d H:i:s')),                                                        
                    );
        if($this->input->post('is_promocode_applied') == 1){
            $this->order_contents['is_promocode_applied']   = 1;
            $promocode      = $this->input->post('hid_promocode');
            $detail         = $this->user_model->getPromocodeDetails($promocode);
            $this->order_contents['promocode_details']      = json_encode(array(
            'promocode'                     => $promocode,
            'promocode_id'                  => $detail->id,
            'redeem_type'                   => $detail->redeem_type,
            'redeem_value'                  => $detail->redeem_value,
            'grand_total_before_promocode'  => $this->input->post('grand_total_before_promocode'),
            'grand_total_after_promocode'   => $this->input->post('grand_total_after_promocode')
            ));
        }
    }
    
    private function _get_shipping_rate($params){
        //echo '<pre>';print_r($params);exit;
        $result = array('status' => 'success');        
        $this->load->helper('fedex');
        $aryRecipient = array(
                'Contact' => array(
                    'PersonName'    => 'Recipient Name',
                    'CompanyName'   => 'Company Name',
                    'PhoneNumber'   => $params['phone']
                ),
                'Address' => array(
                    'StreetLines'           => $params['address'].", ".$params['unit_number'],
                    'City'                  => $params['city'],
                    'StateOrProvinceCode'   => $params['state'],
                    'PostalCode'            => $params['zipcode'],
                    'CountryCode'           => $params['country'],
                    'Residential'           => false
                )
        );

        $packageDetails = array(
                            0 => array(
                                'weight'    => (float) $params['weight'],
                                'length'    => "",
                                'width'     => "",
                                'height'    => ""
                            )
                        );

        $aryPackage     = getPackage($packageDetails);
        $aryOrder       = get_fedex_order_array(count($params['books_count']));
        /*if(IS_FEDEX_ONE_RATE_ENABLED) {
            $aryOrder = array(
                'TotalPackages'     => count($packageDetails),
                'PackageType'       => c('fedex_one_rate_packaging_type'),
                'ServiceType'       => c('fedex_one_rate_service_type'),
                'TermsOfSaleType'   => "DDU",               # DDU/DDP
                'DropoffType'       => 'REGULAR_PICKUP'     # BUSINESS_SERVICE_CENTER, DROP_BOX, REGULAR_PICKUP, REQUEST_COURIER, STATION
            );
        }else{
            $aryOrder = array(
                'TotalPackages' => count($packageDetails),
                'PackageType'       => c('fedex_packaging_type'), # FEDEX_10KG_BOX, FEDEX_25KG_BOX, FEDEX_BOX, FEDEX_ENVELOPE, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING
                'ServiceType'       => c('fedex_service_type'),
                'TermsOfSaleType'   => "DDU",                   # DDU/DDP
                'DropoffType'       => 'REGULAR_PICKUP'         # BUSINESS_SERVICE_CENTER, DROP_BOX, REGULAR_PICKUP, REQUEST_COURIER, STATION
            );
        }*/

        $ratedetails = getRate($aryRecipient, $aryOrder, $aryPackage);

        //echo '<pre>';print_r($ratedetails);exit;
        $shipping_rate = 0;
        if(IS_FEDEX_ONE_RATE_ENABLED){
            if(c('fedex_one_rate_service_type') == $ratedetails['rateReply']->ServiceType){
                $shipping_rate      = $ratedetails['rateReply']->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount;
                $result['amount']   = $shipping_rate;
            }
        }else if (isset($ratedetails['rateReply']) && !empty($ratedetails['rateReply'])){
            foreach ($ratedetails['rateReply'] as $rateReply){
                if('FEDEX_GROUND' == $rateReply->ServiceType){
                    $shipping_rate  = $rateReply->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount;
                    break;
                }
            }
            $result['amount']    = $shipping_rate;
        }else if (isset($ratedetails['rateReply']) && empty($ratedetails['rateReply'])){
            $result['status']   = 'error';
            $result['error']    = 'Shpping not allowd for this zipcode';
        }else if(isset ($ratedetails['error'])){
            $result['status']   = 'error';
            $result['error']    = $ratedetails['error'];
        }else{
            $result['status']   = 'error';
            $result['error']    = 'Something went wrong, failed to fetch shipping rate';
        }
        return $result;
    }
    
    function get_shipping_rate(){
        $courses_ids    = $this->input->post('courses_ids');
        $address        = $this->input->post('address');
        $unit_number    = $this->input->post('unit_number');
        $zipcode        = $this->input->post('zipcode');
        $city           = $this->input->post('city');
        $state          = $this->input->post('state');
        $phone          = $this->input->post('phone');
        
        $courses        = $this->Common_model->getCoursesByIds($courses_ids);

        $book_weight    = 0;
        array_walk($courses, function ($course) use(&$book_weight){
            $book_weight += $course->wieght;
        });
        /*echo '<pre>';print_r([
            'address'       => $address,
            'unit_number'   => $unit_number,
            'zipcode'       => $zipcode,
            'city'          => $city,
            'state'         => $state,          
            'country'       => 'US',
            'phone'         => $phone,
            'weight'        => $book_weight
        ]);exit;*/
        $shipping_rate   = $this->_get_shipping_rate(array(
            'address'       => $address,
            'unit_number'   => $unit_number,
            'zipcode'       => $zipcode,
            'city'          => $city,
            'state'         => $state,          
            'country'       => 'US',
            'phone'         => $phone,
            'weight'        => $book_weight,
            'books_count'    => count($courses)
        ));
        
        $data['return_value'] = json_encode($shipping_rate);
        $this->load->view('dsp_show_ajax', $data);
    }
            
    function send_registration_mail_forcefully($user_id){
        $this->load->model('admin_user_model');
        $user_details   = $this->admin_user_model->select_single_userdetails($user_id);
        
        $courses        = $this->admin_user_model->select_single_user_course_details($user_id);
        
        $course_ids     = array();
        foreach ($courses as $course){
            array_push($course_ids, $course->courseid);
        }
        $order_info        = $this->admin_user_model->select_single_user_order_details($user_id);
        $order_info        = (array) $order_info[0];
        $order_info['payment_method']        = 'Paypal Payment Method';
        
        //echo '<pre>';print_r($order_info);exit;
        
        $usre_info   = array(
            'name'          => $user_details->firstname.' '.$user_details->lastname,
            'useremail'     => $user_details->emailid,
            'password'      => '******',
            'course'        => $course_ids,
            'subcourse'     => '',
            'course_o'      => ''
        );
                
        $this->user_model->send_mailto_user($usre_info, $order_info, array('trackingno' => $order_info['trackingno']), 
                $from_admin='admin', $user_details->course_user_type, $ship='yes');
        
    }
    private function _insert_payment_log($name, $emailid, $course_name, $status){
        $payment_log = array(
            "name"          => $name,
            "emailid"       => $emailid,
            "paymentdate"   => convert_UTC_to_PST_datetime(date("Y-m-d H:i:s")),
            "b_address"     => $this->input->post('b_address') . "," . $this->input->post('b_city') .
                                "," . $this->input->post('b_state') . "," . $this->input->post('b_country') . "," . $this->input->post('b_zipcode'),
            "s_address"     => $this->input->post('address') . "," . $this->input->post('city') .
                                "," . $this->input->post('s_state') . "," . $this->input->post('country') . "," . $this->input->post('zipcode'),
            "coursename"    => $course_name,
            "status"        => $status
        );

        $this->user_model->paymentlog($payment_log);
    }
    
    private function _save_order_details($userid, $transaction_id){
        $order_contents = array(
                            "userid"        => $userid,
                            "b_address"     => $this->input->post('b_address'),
                            "b_country"     => $this->input->post('b_country'),
                            "b_state"       => $this->input->post('b_state'),
                            "b_city"        => $this->input->post('b_city'),
                            "b_zipcode"     => $this->input->post('b_zipcode'),
                            "s_address"     => $this->input->post('address'),
                            "s_country"     => $this->input->post('country'),
                            "s_state"       => $this->input->post('state'),
                            "s_city"        => $this->input->post('city'),
                            "s_zipcode"     => $this->input->post('zipcode'),
                            "total_amount"  => $this->input->post('totalprice'),
                            "ship_rate"     => $this->input->post('ship_rate'),
                            "course_price"  => $this->input->post('price_wo_ship'),
                            "transactionid" => $transaction_id,
                            "payment_method"=> 'Paypal Payment Method',
                            "orderdate"     => convert_UTC_to_PST_date(date('Y-m-d H:i:s')),
        );
        
        if($this->input->post('is_promocode_applied') == 1){
            $order_contents['is_promocode_applied']   = 1;
            $promocode      = $this->input->post('hid_promocode');
            $detail         = $this->user_model->getPromocodeDetails($promocode);
            $order_contents['promocode_details']      = json_encode(array(
            'promocode'                     => $promocode,
            'promocode_id'                  => $detail->id,
            'redeem_type'                   => $detail->redeem_type,
            'redeem_value'                  => $detail->redeem_value,
            'grand_total_before_promocode'  => $this->input->post('grand_total_before_promocode'),
            'grand_total_after_promocode'   => $this->input->post('grand_total_after_promocode')
            ));
        }
                    
        return $this->user_model->order($order_contents);
                    
    }
    
    private function _ship_course_books($order_id, $courses){
        $this->load->helper('fedex');
        $aryRecipient = array(
                            'Contact' => array(
                                    'PersonName'    => $this->input->post('firstname').' '.$this->input->post('lastname'),
                                    'PhoneNumber'   => $this->input->post('phone')
                            ),
                            'Address' => array(
                                    'StreetLines'           => $this->input->post('address').', '.$this->input->post('unit_number'),
                                    'City'                  => $this->input->post('city'),
                                    'StateOrProvinceCode'   => $this->input->post('state'),
                                    'PostalCode'            => $this->input->post('zipcode'),
                                    'CountryCode'           => $this->input->post('country'),
                                    'Residential'           => false
                            )
        );
        
        $courseDetails      = $this->user_model->get_course_details(array('course' => $courses, 'subcourse' => '', 'course_o' => ''));
        $course_weight      = $courseDetails['course_weight'];
        $course_amount      = $courseDetails['course_amount'];
        $arrCourseDetails   = $courseDetails['arrCourseDetails'];
        $packetDescription  = "FEDEX Package for order ".$order_id;
        $packageDetails     = array(
                                    0 => array(
                                        'weight'            => $course_weight,
                                        'length'            => "20",
                                        'width'             => "20",
                                        'height'            => "10",
                                        'ItemDescription'   => $packetDescription
                                    )
                                );


        $cnt = 0;
        
        foreach($arrCourseDetails as $courseDetails){
            $aryPackageItems[$cnt]['item_qty']      = 1;
            $aryPackageItems[$cnt]['item_price']    = $courseDetails['amount'];
            $aryPackageItems[$cnt]['item_name']     = $courseDetails['course_name'];
            $aryPackageItems[$cnt]['item_weight']   = $courseDetails['wieght'];

            $cnt++;
        }

        $realPackages = array(
                                    0 => array(
                                        'packageDetails'    => $packageDetails,
                                        'aryPackageItems'   => $aryPackageItems,  
                                        'package_amount'    => $course_weight
                                    )
                                );

        $aryOrder   = array(
                            'TotalPackages'     => 1,
                            'PackageType'       => 'YOUR_PACKAGING',        //FEDEX_10KG_BOX, FEDEX_25KG_BOX, FEDEX_BOX, FEDEX_ENVELOPE, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING
                            'ServiceType'       => 'FEDEX_GROUND',
                            'TermsOfSaleType'   => "DDU",         #    DDU/DDP
                            'DropoffType'       => 'REGULAR_PICKUP'         // BUSINESS_SERVICE_CENTER, DROP_BOX, REGULAR_PICKUP, REQUEST_COURIER, STATION
                            //'TotalWeight' => array('Value' => 50.0, 'Units' => 'LB'), // valid values LB and KG
                        );
        return setShipment($aryOrder, $aryRecipient, $realPackages, $course_amount, $course_weight);
    }

    function course_contact(){
        if($this->authentication->logged_in("normal")){
            redirect("profile");
        }
        $this->load->library("form_validation");
        if(!empty($_POST))	{

            $this->form_validation->set_rules ('first_name',    'FIRST NAME',   'trim|required|min_length[2]');
            $this->form_validation->set_rules ('last_name',     'LAST NAME',    'trim|required');
            $this->form_validation->set_rules ('email',         'EMAIL',        'trim|required|valid_email');
            $this->form_validation->set_rules ('phone_number',  'PHONE NUMBER', 'trim|required');
            $this->form_validation->set_rules ('city',          'CITY OF RESIDENCE', 'trim|required');
            $this->form_validation->set_rules ('class_preference[]','COURSE PREFERENCE',        'trim|required');

            if (!$this->form_validation->run() == FALSE) {// form validation

                $this->load->model('user_model');
                if($this->user_model->courseContactExists('email', $this->input->post('email'))){
                    $this->message['error'] = 'EMAIL already exists';
                }else if($this->user_model->courseContactExists('phone_number', $this->input->post('phone_number'))){
                    $this->message['error'] = 'PHONE NUMBER already exists';
                }else{
                    $prefer = $this->input->post('class_preference');
                    $prefer_arr = array();
                    if(is_array($prefer) && count($prefer) > 0){

                        if(in_array(1, $prefer)){
                            array_push($prefer_arr,'Online');
                        }
                        if(in_array(2, $prefer)){
                            array_push($prefer_arr, 'Classroom');
                        }
                        $prefer = json_encode($prefer);
                    }else{
                        $prefer = '';
                    }
                    $data   = array(
                        'first_name'    => $this->input->post('first_name'),
                        'last_name'     => $this->input->post('last_name'),
                        'email'         => $this->input->post('email'),
                        'phone_number'  => $this->input->post('phone_number'),
                        'city'          => $this->input->post('city'),
                        'prefer'        => $prefer,
                        'ip_address'    => $this->input->ip_address(),
                        'created_at'    => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'))
                    );

                    $this->user_model->saveCourseContact($data);

                    $prefer_string = implode(', ', $prefer_arr);

                    $body       = "Dear Administrator,<br><br>";
                    $body    .= $data['first_name']. " ".$data['last_name']. " has contacted for future classes. Please find below details<br><br><br>";
                    $body    .=" First Name: ".$data['first_name']."<br><br>";
                    $body    .=" Last Name: ".$data['last_name']."<br><br>";
                    $body    .=" Email: ".$data['email']."<br><br>";
                    $body    .=" Phone Number: ".$data['phone_number']."<br><br>";
                    $body    .=" City of Residence: ".$data['city']."<br><br>";
                    $body    .=" Class Preference: ".$prefer_string."<br><br>";
                    $body    .=" <small>Request from ip address ".$this->input->ip_address()."</small><br><br>";
                    $body    .= "<br>Regards,<br>";
                    $body    .= "Adhischools Team";

                    if($this->Common_model->send_mail(c('course_contact_to'), '', 'Contact for future classes', $body)){
                        $this->session->set_flashdata('success',"Thank you for contacting Adhischools, we will get back to you shortly.");
                    }else {
                        $this->session->set_flashdata('success',"Failed to sent your informations");
                    }
                    redirect('user/register');
                }
            }

        }
        $this->template->set_template('user');
        $this->template->write_view('content', 'reskin/course_contact', $this->gen_contents);
        $this->template->render();
    }
    
    /* Third party user */
    function registration(){
        $this->user_model->third_party_user();
        redirect('user/register');
    }
    
    function saveRenewReenrollDataInTemp($course,$type = 0){
        
        $this->_temp_init_user_order($course,$type);     // Type - Apply New Course - 0   , 1 - Renew, 2 - Reenroll 
        $re_result = $this->user_model->renew_reneroll_order($this->temp_new_order_contents);
        $renew_date         = date('Y-m-d H:i:s');
                    
        if(0 == $type){
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

            $this->re_course_contents =array(						
                "course" => $this->input->post('course'),
                "subcourse"=> $subcourseid,
                "course_o"=> $course_o,
                "userid" => $this->temp_new_order_contents['userid'],
                "orderid" => $re_result,
                "enrolled_date" =>$this->temp_new_order_contents['orderdate']
            );
            $this->user_model->renew_reneroll_usercourse($this->re_course_contents,$type);
        }else{
            if(is_array($course)){
                if(!empty($course)){
                    foreach($course as $cor){
                        $this->re_course_contents =array(						
                            "course" => $cor,
                            "userid" => $this->temp_new_order_contents['userid'],
                            "orderid" => $re_result,
                            "renew_reenroll_date" =>convert_UTC_to_PST_date($renew_date)
                        );
                        $this->user_model->renew_reneroll_usercourse($this->re_course_contents,$type);
                    }
                }
            }else{
                $this->re_course_contents =array(						
                    "course" => $this->input->post('courseid'),
                    "userid" => $this->temp_new_order_contents['userid'],
                    "orderid" => $re_result,
                    "renew_reenroll_date" =>convert_UTC_to_PST_date($renew_date)
                );
                $this->user_model->renew_reneroll_usercourse($this->re_course_contents,$type);
            }
            
        }
        return $re_result;
    }
                                                               
    
    function _temp_init_user_order($course, $type){
                $this->load->model("user_model");
                
                if(0 == $type){
                    $this->temp_new_order_contents =array(
                            "userid"            =>      $this->session->userdata('USERID'),
                            "b_address" 	=> 	$this->input->post('b_address'),
                            "b_country" 	=> 	$this->input->post('b_country'),
                            "b_state" 		=> 	$this->input->post('b_state'),
                            "b_city" 		=> 	$this->input->post('b_city'),
                            "b_zipcode" 	=> 	$this->input->post('b_zipcode'),
                            "s_address" 	=> 	$this->input->post('s_address'),
                            "s_country" 	=>	$this->input->post('s_country'),
                            "s_state" 		=> 	$this->input->post('s_state'),
                            "s_city"		=> 	$this->input->post('s_city'),
                            "s_zipcode" 	=> 	$this->input->post('s_zipcode'),
                            "total_amount"	=> 	$this->input->post('totalprice'),
                            "ship_rate" 	=> 	$this->input->post('shipprice'),
                            "ship_method" 	=> 	str_replace("_"," ",$this->input->post('shipid')),
                            "packaging_type" 	=> 	get_fedex_packaging_type(count($course)),
                            "course_price"      => (    float) $this->input->post('totalprice') - (float) $this->input->post('shipprice'),//$this->input->post('price'),
                            "transactionid"	=> 	"000000",
                            "status"		=> 	"Q",
                            "orderdate" 	=> 	convert_UTC_to_PST_date(date('Y-m-d H:i:s')),
                            "success"		=> 	0,
                            "type"              =>      $type

                    );
                }else if(1 == $type){
                    $this->temp_new_order_contents =array(
                            "userid"            =>      $this->session->userdata('USERID'),
                            "b_address" 	=> 	$this->input->post('b_address'),
                            "b_country" 	=> 	$this->input->post('country'),
                            "b_state" 		=> 	$this->input->post('b_state'),
                            "b_city" 		=> 	$this->input->post('b_city'),
                            "b_zipcode" 	=> 	$this->input->post('b_zipcode'),
                            "s_address" 	=> 	$this->input->post('address'),
                            "s_country" 	=>	$this->input->post('country'),
                            "s_state" 		=> 	$this->input->post('state'),
                            "s_city"		=> 	$this->input->post('city'),
                            "s_zipcode" 	=> 	$this->input->post('zipcode'),
                            "total_amount"	=> 	$this->input->post('totalprice'),
                            "ship_rate" 	=> 	$this->input->post('ship_rate'),
                            "ship_method" 	=> 	"FEDEX",
                            "packaging_type" 	=> 	get_fedex_packaging_type(count($course)),
                            "course_price"      =>      $this->input->post('price_wo_ship'),//$this->input->post('price'),
                            "transactionid"	=> 	"000000",
                            "status"		=> 	"Q",
                            "orderdate" 	=> 	convert_UTC_to_PST_date(date('Y-m-d H:i:s')),
                            "success"		=> 	0,
                            "type"              =>      $type

                    );
                }else{
                    $this->temp_new_order_contents =array(
                            "userid"            =>      $this->session->userdata('USERID'),
                            "b_address" 	=> 	$this->input->post('b_address'),
                            "b_country" 	=> 	$this->input->post('b_country'),
                            "b_state" 		=> 	$this->input->post('b_state'),
                            "b_city" 		=> 	$this->input->post('b_city'),
                            "b_zipcode" 	=> 	$this->input->post('b_zipcode'),
                            "total_amount"	=> 	$this->input->post('totalprice'),
                            "course_price"      => (    float) $this->input->post('totalprice'),//$this->input->post('price'),
                            "transactionid"	=> 	"000000",
                            "status"		=> 	"Q",
                            "orderdate" 	=> 	convert_UTC_to_PST_date(date('Y-m-d H:i:s')),
                            "success"		=> 	0,
                            "type"              =>      $type

                    );
                }
                
                if(isset($_POST['is_promocode_applied']) && $this->input->post('is_promocode_applied') == 1){
                    $this->temp_new_order_contents['is_promocode_applied']   = 1;
                    $promocode      = $this->input->post('hid_promocode');
                    $detail         = $this->user_model->getPromocodeDetails($promocode);
                    $this->temp_new_order_contents['promocode_details']      = json_encode(array(
                        'promocode'                     => $promocode,
                        'promocode_id'                  => $detail->id,
                        'redeem_type'                   => $detail->redeem_type,
                        'redeem_value'                  => $detail->redeem_value,
                        'grand_total_before_promocode'  => $this->input->post('grand_total_before_promocode'),
                        'grand_total_after_promocode'   => $this->input->post('grand_total_after_promocode')
                    ));
                }

    }
}
