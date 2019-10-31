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

class Iframe_User extends Controller 
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
	function Iframe_User()
	{
		parent::Controller();

		$this->load->model('Common_model');
        $this->load->model('Iframeuser_model');
        
        //$this->config->item ('site_basepath').'system/application/libraries/vbintegration.php';
        //require_once $this->config->item('site_basepath').'/system/application/libraries/vbintegration.php';

        $this->gen_contents['css'] = array(  'iframe_user/adhi-keller.css');
		$this->gen_contents['js'] = array('jquery.min.1.8.2.js', 'popcalendar.js', 'validation.js', 'client_login.js', 'iframe_user.js', 'customScroll/main.js', 'jsCheckbox.js');
		$this->load->model('admin_sitepage_model');
		
		$isFrame =  $this->uri->segment(3); 
		if(!isset($isFrame) && empty($isFrame) || $isFrame == ''){
			//redirect( $this->config->item("go_to_keller_registration") );
		}
		
		$continue = 0;
  		if(isset($_SERVER['HTTP_REFERER'])) {
 		    //correct domain:
		    $ar=parse_url($_SERVER['HTTP_REFERER']);
		    if( strpos($ar['host'], $this->config->item("keller_domain") ) === false ){
		    } else {
		        $continue = 1;
		    }
 		}
		
		if($continue == 0){
		    //redirect( $this->config->item("go_to_keller_registration") );
 		}
	}
	
	/**
	 * incex function
	 * Enter description here ...
	 * @access public
	 * @param void
	 * @return void
	 */
	function index() 
	{
		if($this->authentication->logged_in("normal"))
			redirect("profile");			
		
		redirect("home");
	}
		
	/*******************************Registration*******************************/		
	/**
	 * validation rules for step1 
	 * Enter description here ...
	 * @access public
	 * @param void
	 * @returnvoid
	 */	
	function _init_registration_rules()
	{
		$this->form_validation->set_rules('firstname', 'FIRST NAME', 'required|max_length[128]');
		$this->form_validation->set_rules('lastname', 'LAST NAME', 'required|max_length[128]');
		//$this->form_validation->set_rules('name_on_certificate', 'CERTIFICATE NAME', 'required|max_length[255]');
		$this->form_validation->set_rules('email', 'EMAIL', 'required|max_length[128]');
		$this->form_validation->set_rules('confirmemail', 'CONFIRM EMAIL', 'required|max_length[128]');
		$this->form_validation->set_rules('psword', 'PASSWORD', 'required');
		$this->form_validation->set_rules('psword1', 'CONFIRM PASSWORD', 'required');
		$this->form_validation->set_rules('address', 'ADDRESS', 'required|max_length[128]');
		$this->form_validation->set_rules('state', 'STATE', 'required');
		$this->form_validation->set_rules('city', 'CITY', 'required');
		$this->form_validation->set_rules('country', 'COUNTRY', 'required');
		$this->form_validation->set_rules('zipcode', 'ZIPCODE', 'required');
		$this->form_validation->set_rules('phone', 'PHONE NO', 'required|max_length[10]|numeric');		
	}
	
	/**
	 * Validation rules for step2
	 * Enter description here ...
	 * @access public
	 * @param void
	 * @return vooid
	 */
	function _init_registration_rules_step2()
	{
		//$this->form_validation->set_rules('forumalias', 'Forum Alias', 'required|min_length[3]|max_length[100]');
		$this->form_validation->set_rules('txtLicencetype', 'License Type', 'required');
		$this->form_validation->set_rules('txthowhear', 'How did you hear about us?', 'required|max_length[250]');
		$this->form_validation->set_rules('b_address', 'Billing Address', 'required|max_length[128]');
		$this->form_validation->set_rules('b_state', 'Billing Address State', 'required|max_length[128]');
		$this->form_validation->set_rules('b_country', 'Billing Address Country', 'required|max_length[128]');
		$this->form_validation->set_rules('b_city', 'Billing Address City', 'required|max_length[128]');
		$this->form_validation->set_rules('b_zipcode', 'Billing Address Zipcode', 'required|max_length[128]');
                $this->form_validation->set_rules('driving_license', 'Drivers License Number', 'required|max_length[10]');
		$this->form_validation->set_rules('txtSearchengine');
		$this->form_validation->set_rules('txtREO');
		/*
		$this->form_validation->set_rules('s_address', 'Shipping Address', 'required|max_length[128]');
		$this->form_validation->set_rules('s_state', 'Shipping Address State', 'required');
		$this->form_validation->set_rules('s_country', 'Shipping Address Country', 'required');
		$this->form_validation->set_rules('s_city', 'Shipping Address City', 'required');
		$this->form_validation->set_rules('s_zipcode', 'Shipping Address Zip code', 'required');
		*/
		//$this->form_validation->set_rules('course[]', 'Course', 'required');
		/*	
		$this->form_validation->set_rules('shipid', 'Ship Method', 'required');
		$this->form_validation->set_rules('ccno', 'Credit Crad Number', 'required|max_length[128]');
		$this->form_validation->set_rules('cvv2no', 'Credit Card Verification Code', 'required|max_length[128]');
		$this->form_validation->set_rules('cardtype', 'Credit Card Type', 'required|max_length[128]');
		$this->form_validation->set_rules('expmonth', 'Expire Month', 'required|max_length[128]');
		$this->form_validation->set_rules('expyear', 'Expire Year', 'required|max_length[128]');*/
	}
	
	/**
	 * Validation rules for step3
	 * Enter description here ...
	 * @access public
	 * @param void
	 * @return void
	 */
	function _init_registration_rules_step3()
	{
		//$this->form_validation->set_rules('course[]', 'Course', 'required');
		$this->form_validation->set_rules('shipid', 'Ship Method', 'required');
		$this->form_validation->set_rules('ccno', 'Credit Crad Number', 'required|max_length[128]');
		$this->form_validation->set_rules('cvv2no', 'Credit Card Verification Code', 'required|max_length[128]');
		$this->form_validation->set_rules('cardtype', 'Credit Card Type', 'required|max_length[128]');
		$this->form_validation->set_rules('expmonth', 'Expire Month', 'required|max_length[128]');
		$this->form_validation->set_rules('expyear', 'Expire Year', 'required|max_length[128]');
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
	function _init_renewal_rules()
	{
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
	
	
		function _init_user_regdetails(){
	
                    $this->gen_contents['data'] =array(		
                                    "firstname"             => 	$this->Common_model->safe_html($this->input->post('firstname')),
                                    "lastname"              => 	$this->Common_model->safe_html($this->input->post('lastname')),
                                    "name_on_certificate"   =>  $this->Common_model->safe_html($this->input->post('firstname'))." ".$this->Common_model->safe_html($this->input->post('lastname')),
                                    "emailid" 		=> 	$this->Common_model->safe_html($this->input->post('email')),
                                    "password" 		=> 	md5($this->Common_model->safe_html($this->input->post('psword'))),
                                    "orgpassword"       => 	$this->Common_model->safe_html($this->input->post('psword')),
                                    "address"		=> 	$this->Common_model->safe_html($this->input->post('address')),
                                    "state" 		=> 	$this->input->post('state'),
                                    "city" 		=> 	$this->Common_model->safe_html($this->input->post('city')),
                                    "zipcode" 		=>	$this->Common_model->safe_html($this->input->post('zipcode')),
                                    "country" 		=> 	$this->input->post('country'),
                                    "phone" 		=> 	$this->Common_model->safe_html($this->input->post('phone')),
                                    "unit_number"       =>	$this->Common_model->safe_html($this->input->post('unitnumber')),
                                    "note"              =>      $this->Common_model->safe_html($this->input->post('note'))                                    
                    );
		}
		function _init_user_regdetails_step2(){
			$reason = '';
			if($this->Common_model->safe_html($this->input->post('txthowhear')) == 'Search engine'){
				$reason = $this->Common_model->safe_html($this->input->post('txtSearchengine'));
			}else if($this->Common_model->safe_html($this->input->post('txthowhear')) == 'Referral from a real estate office'){
				$reason = $this->Common_model->safe_html($this->input->post('txtREO'));
			}
                        
                        if($this->uri->segment(3) == 'alam'){
                            $reason .= " - ALAM";
                        }else{
                            $reason .= " - KWADHI";
                        }
                        
			$this->gen_contents['data']['step2data'] = array(		
					"forum_alias"	=> 	$this->Common_model->safe_html($this->input->post('forumalias')),						 
					"licensetype"	=> 	$this->input->post('txtLicencetype'),
//					"unit_number"	=>	$this->Common_model->safe_html($this->input->post('unitnumber')),
					"testimonial" 	=> 	$this->Common_model->safe_html($this->input->post('txthowhear')),
					"reason" 	=> 	$reason,
					"b_address"	=> 	$this->Common_model->safe_html($this->input->post('b_address')),
					"b_state" 	=> 	$this->input->post('b_state'),
					"b_city" 	=> 	$this->Common_model->safe_html($this->input->post('b_city')),
					"b_zipcode" 	=>	$this->Common_model->safe_html($this->input->post('b_zipcode')),
					"b_country" 	=> 	$this->input->post('b_country'),
					//"billing_sameas_shipping" 	=> 	$this->input->post('bsame'),
					"billing_sameas_shipping" 	=> 	'',
					
					/*
					"s_address"		=> 	$this->Common_model->safe_html($this->input->post('s_address')),
					"s_state" 		=> 	$this->input->post('s_state'),
					"s_city" 		=> 	$this->Common_model->safe_html($this->input->post('s_city')),
					"s_zipcode" 	=>	$this->Common_model->safe_html($this->input->post('s_zipcode')),
					"s_country" 	=> 	$this->input->post('s_country')
					*/
					
					"s_address"         => 	$this->session->userdata('address'),
					"s_state"           => 	$this->session->userdata('state'),
					"s_city"            => 	$this->session->userdata('city'),
					"s_zipcode"         =>	$this->session->userdata('zipcode'),
					"s_country"         => 	$this->session->userdata('country'),
                                        "driving_license"   =>  generate_hash($this->Common_model->safe_html($this->input->post('driving_license')))
			
					);
						
		}
		function _init_user_paymentdetails(){
				$this->payment_contents =array(		
						"firstname" 	=> 	$this->session->userdata('firstname'),
						"lastname"		=> 	$this->session->userdata('lastname'),
						"ccno" 			=> 	$this->Common_model->safe_html($this->input->post('ccno')),
						"cardtype" 		=> 	$this->input->post('cardtype'),
						"expmonth" 		=> 	$this->input->post('expmonth'),
						"expyear" 		=> 	$this->input->post('expyear'),
						"cvv2no" 		=> 	$this->Common_model->safe_html($this->input->post('cvv2no')),
						"address1" 		=>	$this->session->userdata('b_address'),
						"zipcode" 		=>  $this->session->userdata('b_zipcode'),
						"country" 		=> 	$this->session->userdata('b_country'),
						"state" 		=> 	$this->session->userdata('b_state'),//$state,
						"city" 			=> 	$this->session->userdata('b_city'),
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
		function _mail_content(){
			$this->gen_contents['maincontent'] =array(		
				"firstname" 	=> 	$this->Common_model->safe_html($this->input->post('firstname')),
				"lastname"		=> 	$this->Common_model->safe_html($this->input->post('lastname')),
				"emailid" 		=> 	$this->Common_model->safe_html($this->input->post('email')),
				"orgpassword" 	=> 	$this->Common_model->safe_html($this->input->post('psword')),
				"phone" 		=> 	$this->Common_model->safe_html($this->input->post('phone')),
                                "note" 		=> 	$this->Common_model->safe_html($this->input->post('note'))
				
				);
				return $this->gen_contents['maincontent'];
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
							"name_on_certificate" => $this->session->userdata('name_on_certificate'),
							"forum_alias" 	=> 	$this->session->userdata('forum_alias'),
							"emailid" 		=> 	$this->session->userdata('emailid'),
							"password" 		=> 	$this->session->userdata('password'),							
							"address" 		=> 	$this->session->userdata('address'),
							"state" 		=> 	$this->session->userdata('state'),
							"city" 			=> 	$this->session->userdata('city'),
							"zipcode" 		=> 	$this->session->userdata('zipcode'),
							"country" 		=> 	$this->session->userdata('country'),
							"phone" 		=> 	$this->session->userdata('phone'),
                                                        "note"                  =>      $this->session->userdata('note'),    
							"testimonial" 	=> 	$this->session->userdata('testimonial'),	
							"reason"		=>	$this->session->userdata('reason'),
							"licensetype" 	=> 	$this->session->userdata('licensetype'),
							"b_address" 	=> 	$this->session->userdata('b_address'),
							"b_country" 	=> 	$this->session->userdata('b_country'),
							"b_state" 		=> 	$this->session->userdata('b_state'),
							"b_city" 		=> 	$this->session->userdata('b_city'),
							"billing_sameas_shipping" 	=> 	$this->session->userdata('billing_sameas_shipping'),
							"b_zipcode" 	=> 	$this->session->userdata('b_zipcode'),
							"driving_license" 	=> 	$this->session->userdata('driving_license'),                            
							"s_address" 	=> 	$this->session->userdata('s_address'),
							"s_country" 	=>	$this->session->userdata('s_country'),
							"s_state" 		=> 	$this->session->userdata('s_state'),
							"s_city" 		=> 	$this->session->userdata('s_city'),
							"s_zipcode" 	=> 	$this->session->userdata('s_zipcode'),
							"course_user_type"=>$this->session->userdata('course_usertype'),
							"unit_number"	=>$this->session->userdata('unit_number'),
							);
			
			
			$this->order_contents =array(
							"b_address" 		=> 	$this->session->userdata('b_address'),
							"b_country" 		=> 	$this->session->userdata('b_country'),
							"b_state" 			=> 	$this->session->userdata('b_state'),
							"b_city" 			=> 	$this->session->userdata('b_city'),
							"b_zipcode" 		=> 	$this->session->userdata('b_zipcode'),
							"s_address" 		=> 	$this->session->userdata('s_address'),
							"s_country" 		=>	$this->session->userdata('s_country'),
							"s_state" 			=> 	$this->session->userdata('s_state'),
							"s_city"			=> 	$this->session->userdata('s_city'),
							"s_zipcode" 		=> 	$this->session->userdata('s_zipcode'),
							"total_amount"		=> 	$this->input->post('totalprice'),
							"ship_rate" 		=> 	$this->input->post('shipprice'),
							"course_price" 		=> 	$this->input->post('price'),
							"transactionid"		=> 	$transactionid,
							"payment_method"	=> 'Paypal Payment Method',
							"orderdate" 		=> 	convert_UTC_to_PST_date(date('Y-m-d H:i:s'))
							
							);
		
		}
       function _user_forum_data($transactionid){
			$this->user_forum_contents =array(
							"usergroupid"   	=> 	2,
							"displaygroupid"	=> 	0,
							"username" 		=> 	$this->session->userdata('emailid'),
							"password" 		=> 	$this->session->userdata('password'),
							"email" 		=> 	$this->session->userdata('emailid'),
							"showvbcode" 	=> 	'vb',
                             "firstname"    => 	$this->session->userdata('firstname'),
							"lastname" 		=> 	$this->session->userdata('lastname'),
							"forum_alias" 	=> 	$this->session->userdata('forum_alias'),
							"usertitle" 	=> 	'Junior Member'
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
		
		function _int_user_mail($course){
			$this->mail_contents =array(
				"name" 				=> 	$this->session->userdata('firstname')." ".$this->session->userdata('lastname'),
				"useremail" 		=> 	$this->session->userdata('emailid'),
				"password" 			=> 	$this->session->userdata('orgpassword'),
				"course" 			=> 	$course['course'],
				"subcourse" 		=> 	$course['subcourse'],
				"course_o" 			=> 	$course['course_o'],
                                "note"                  =>  $this->session->userdata('note')
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
                        $this->load->model('Iframeuser_model');
                        $this->load->library("form_validation");
                        //registration
                        $this->_init_registration_rules();
                        if($this->form_validation->run() == TRUE) {
                            $this->_init_user_regdetails();	
                            $this->gen_contents['data']['admindetails'] = $this->Iframeuser_model->get_admin();	
                            $check =$this->Iframeuser_model->checkuser($this->input->post('email'));
                            //$check_blog =$this->Iframeuser_model->checkuser_blog($this->input->post('email'));    

                            //if($check<=0 && $check_blog<=0){								
                            if($check <= 0 ){
                                $this->gen_contents['data']['step1'] =$this->input->post('step1');
                                $this->session->set_userdata ($this->gen_contents['data']);									
                                //$checkins = $this->Iframeuser_model->save_step1_reg_details($this->gen_contents['data']);
                                //  if($checkins > 0){
                                        $admin = $this->Iframeuser_model->get_admin();
                                        $mailcontent = $this->_mail_content();
                                        $admindetail = $this->session->userdata{'admindetails'};
                                        /* Registration in process save mail starts */
                                        $reg_datas = array(
                                            'reg_ip_address' => $this->input->ip_address() ,
                                            'reg_first_name' => $this->gen_contents['data']['firstname'],
                                            'reg_last_name'  => $this->gen_contents['data']['lastname'],
                                            'reg_email'      => $this->gen_contents['data']['emailid'],
                                            'reg_phone'      => $this->gen_contents['data']['phone'],
                                            'reg_date'       => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')),
                                            'created_by'     => ($this->uri->segment(3) == 'alam') ? 2 : 1,
                                            'status'         => 1
                                        );
                                        $this->Iframeuser_model->save_reg_in_process($reg_datas);
                                        /* Registration in process save mail ends */

                                        $sendmail = $this->Iframeuser_model->send_registration_mail_to_admin($this->config->item('guest_pass_enquiry'),$mailcontent,'Registration in process');

           // }
                                // step 2
                                $this-> _init_step2_registration();
                            } else {
                                if($check > 0 ){
                                        $msg = "Email Already Exist";
                                }
                                /*else if($check_blog > 0){
                                        $msg = "Email Already Exist in Forum";
                                }*/
                                $this->gen_contents['msg']= $msg;

                                $this->load->model('Iframeuser_model');
                                $this->load->helper("form");		
                                $this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();						
                                $this->load->view("client_home_header_new",$this->gen_contents);	
                                $this->gen_contents['state'] = $this->Iframeuser_model->get_state();		
                                $this->load->view('iframe_user/userregister/user_register',$this->gen_contents);			
                                $this->load->view("client_home_footer_new");	

                            }						
                        }else{
                            $this->load->model('Iframeuser_model');
                            $this->load->helper("form");		
                            $this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();						
                            $this->load->view("client_home_header_new",$this->gen_contents);	
                            $this->gen_contents['state'] = $this->Iframeuser_model->get_state();		
                            $this->load->view('iframe_user/userregister/user_register',$this->gen_contents);			
                            $this->load->view("client_home_footer_new");	
                        }

                    }
		
                }
		// function for first ohase registratio=> n	
		function register() {
            
			// regisration step 1
			if($this->input->post('step1') == 1){
				
				$this->_int_user_register_step1();
			}
                        
                        $this->gen_contents['site'] = ($this->uri->segment(4) == 'alam') ? 'alam' : '';
			if(!$_POST || !isset($_POST['step1'])){                        
				$this->load->model('Iframeuser_model');
				$this->load->helper("form");			
				$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();				
				//$this->load->view("client_common_header_main",$this->gen_contents);
						
				$this->load->view("client_home_header_new", $this->gen_contents);	
				
				//$captcha                     = $this->Iframeuser_model->generate_captcha ();			
				//$this->session->set_userdata ("captcha_word", $captcha['word']);
				
				//$this->gen_contents['captcha_details']     = $captcha;	
				$this->gen_contents['state'] = $this->Iframeuser_model->get_state();	
				//$this->load->view('user/register',$this->gen_contents);			
				$this->load->view('iframe_user/userregister/user_register',$this->gen_contents);	
				//$this->load->view("client_common_footer_main",$this->gen_contents);				
				$this->load->view("client_home_footer_new",$this->gen_contents);
			}	
		
		}
		/**
		 * function for displaying step2 registration
		 *
		 */
		function _init_step2_registration(){
			$this->load->model('Common_model');
			$this->load->model('Iframeuser_model');
			
			$data['coursearr']=$this->Common_model->listallcourses();
			
			$data['phone']=$this->session->userdata{'phone'};
			$data['state'] = $this->Iframeuser_model->get_state();		
  			
			$this->load->view("client_home_header_new",$this->gen_contents);	
			
                        $data['site'] = ($this->uri->segment(3) == 'alam') ? 'alam' : '';
			$this->load->view('iframe_user/userregister/user_register_step2',$data);					
			$this->load->view("client_home_footer_new",$this->gen_contents); 
			
		}
		function register_step2(){
			 
			if($this->input->post('step2') == 2 && $this->session->userdata('step1') == 1 ){
				
				
				$this->load->library("form_validation");			
				$this->load->model('Common_model');
				$this->load->model('Iframeuser_model');
			
				if(!empty($_POST)) {
					
					$this->_init_registration_rules_step2();	
						
					if($this->form_validation->run() == TRUE) {	
						
						$this->_init_user_regdetails_step2();
						
						$state = $this->Iframeuser_model->selectstate($this->input->post('b_state'));
						
                                                $this->gen_contents['data']['step2'] = array('step2'=>$this->input->post('step2'));
                                                $this->session->set_userdata ($this->gen_contents['data']['step2data']);
                                                $this->session->set_userdata ($this->gen_contents['data']['step2']);									

                                                // step 3
                                                $this-> _int_user_register_course();
                                                /*
 						$check_forumalias = $this->Iframeuser_model->checkuser_forumalias($this->input->post('forumalias'));
						if($check_forumalias<=0 ){
							$this->gen_contents['data']['step2'] =array('step2'=>$this->input->post('step2'));
							//get step2 user details to update in database
							//$step2_arr = $this->_set_step2_registration_details($this->gen_contents['data']['step2data']);
							//$save_secondstep = $this->Iframeuser_model->update_step2_reg_details($step2_arr, $this->session->userdata('temp_userid'));
							$this->session->set_userdata ($this->gen_contents['data']['step2data']);
							$this->session->set_userdata ($this->gen_contents['data']['step2']);									
							
							// step 3
							$this-> _int_user_register_course();
						}else{
							$this->gen_contents['msg']= "Forum Alias Already Exist";
							$this->gen_contents['state'] = $this->Iframeuser_model->get_state();	
							$this->_init_step2_registration();							
						}
                                                */
					}else{
						//echo validation_errors();
						$this->_init_step2_registration();		
					}
				}
			} else {
  				redirect("iframe_user/register/".$this->uri->segment(3));
			}
		}
		// function for second phase registration course listing,shipping methodslisting,payment selection
		function _int_user_register_course(){
			$this->load->model('Common_model');
			$this->load->model('Iframeuser_model');
			//echo $this->session->userdata('state');
			$usertype           = $this->session->userdata('course_usertype');
			//$data['coursearr']=$this->Common_model->listallcourses();
			
			$data['coursearr']  = $this->Common_model->getCoursesList($usertype);
			$data['phone']      = $this->session->userdata{'phone'};
			$data['license']    = $this->session->userdata{'licensetype'};
			//$data['courses_m']=$this->Common_model->licensecourselist_m($data['license']);
			//$data['courses_o']=$this->Common_model->licensecourselist_o($data['license']);
			$data['courses_m']  = $this->Common_model->licensecourselist_m($usertype);
			$data['courses_o']  = $this->Common_model->licensecourselist_o($usertype);
			$data['subcourses'] = $this->Common_model->subcourselist();
			

			$data['state']  = $this->Iframeuser_model->get_state();		
			$data['month']  = $this->Iframeuser_model->listmonth();
			$currentyear    = convert_UTC_to_PST_year(date('Y-m-d H:i:s'));	
			$data['year']   = $this->Iframeuser_model->listyear($currentyear);
			$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();	
			$this->load->view("client_home_header_new",$this->gen_contents);	
			
                        $data['site'] = ($this->uri->segment(3) == 'alam') ? 'alam' : '';
                        $this->session->set_userdata('site',$data['site']);
			$this->load->view('iframe_user/userregister/user_register_step3',$data);					
			$this->load->view("client_home_footer_new",$this->gen_contents);	
		}
		
		// function for registration, payment process, order placement and shipping
		function courseadd(){
			
				$this->load->helper("form");
                                $new_package = 0;       
			//Registration step2 
			if($this->input->post('step3') == 3 && $this->session->userdata('step2') == 2 ){ 
				$this->load->library("form_validation");			
				$this->load->model('Common_model');
				$this->load->model('Iframeuser_model');
			
				if(!empty($_POST)) { 
					$this->_init_registration_rules_step3();	
						
						if($this->form_validation->run() == TRUE) {	
						//$state		= 	$this->Iframeuser_model->selectstate($this->input->post('b_state'));
						$name 		=	$this->session->userdata('firstname')." ".$this->session->userdata('lastname');
						$emailid	= 	$this->session->userdata('emailid');
						$course_name ='';
						$course ='';
						$subcourseid ='';
						$course_o ='';
						
						// assign new zipcode to session
						$this->session->set_userdata('zipcode', $this->input->post('s_zipcode'));
						$this->session->set_userdata('s_zipcode', $this->input->post('s_zipcode'));
						
						/* added by shinu for broker /sales packages starts here */
						$usertype = $this->session->userdata('course_usertype');
						// broker
							if($usertype == 1 || $usertype == 3){
								$courseids= $this->Common_model->getCourseweight();
								$course =array();
								foreach($courseids as $courseid){
									$course[] = $courseid->id;
								}
							
								$courselist= $this->Iframeuser_model->coursename($course);	
								if($course  !=''){							
									for($i=0; $i< count($courselist); $i++){
										if($course_name !='')		
											$course_name=$course_name.",".$courselist[$i]['course_name'];
											else
											$course_name=$courselist[$i]['course_name'];
									}
								}
								//sales
							}else if($usertype == 5 || $usertype == 7){
								/* For New Package*/
                                                                if($this->input->post('new_package') == 1)
                                                                {
                                                                    $courseids= $this->Common_model->licensecourselist_m(11);
                                                                    $new_package = 1;
                                                                }
                                                                else
                                                                {
                                                                    $courseids= $this->Common_model->licensecourselist_m(6);
                                                                }
                                                                
                                                                
								$course =array();
								foreach($courseids as $courseid){
									$course[] = $courseid['course_id'];
								}
                                                                
                                                                if($this->input->post('new_package') != 1)
                                                                    $course[] = $this->input->post('hidcrsid');
                                                                
								$courselist= $this->Iframeuser_model->coursename($course);	
								if($course  !=''){							
									for($i=0; $i< count($courselist); $i++){
										if($course_name !='')		
											$course_name=$course_name.",".$courselist[$i]['course_name'];
											else
											$course_name=$courselist[$i]['course_name'];
									}
								}
							}else {
							/* added by shinu for broker packages ends here */
								if($this->input->post('course')){
								$course =$this->input->post('course');
									//$courselist= $this->Iframeuser_model->courselist($this->input->post('course'));
									$courselist= $this->Iframeuser_model->coursename($this->input->post('course'));	
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
										$subcourselist= $this->Iframeuser_model->subcourselist($this->input->post('subcourse'));									
										
											if($course_name !='')		
												$course_name=$course_name.",".$subcourselist['course_name'];
												else
												$course_name=$subcourselist['course_name'];
									
										}
										
									}
									if($this->input->post('course_b')){
										$course_o =$this->input->post('course_b');
										if($course_o  !=''){
										$opcourselist= $this->Iframeuser_model->opcourselist($course_o);	
										
											if($course_name !='')		
												$course_name=$course_name.",".$opcourselist['course_name'];
												else
												$course_name=$opcourselist['course_name'];
													
										}
									}
							}
						//init payment details
						$this->_init_user_paymentdetails();
						 
						$data['payment']=$this->Iframeuser_model->payment($this->payment_contents);
					
						if("SUCCESS" == strtoupper($data['payment']["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($data['payment']["ACK"])) {
						
							$redirect_action	=	"reg_result_success";
							/**
							*paymentlog
							**/							
							$status =$data['payment']["ACK"];							
							$this->_init_payment_log($name,$emailid,$status,$course_name);
							$this->Iframeuser_model->paymentlog($this->payment_log);
							/*****/
                                                       
							$this->_init_user_registration($data['payment']["TRANSACTIONID"]);
                                                        
                                                        //New package update
                                                        $this->user_contents["sales_new_package"] = $new_package;
                                                        
							$result=$this->Iframeuser_model->userregistration($this->user_contents);
						    $this->_user_forum_data($data['payment']["TRANSACTIONID"]);
                                                    ///$result_forum=$this->Iframeuser_model->adduser_forum($this->user_forum_contents);
                                                    //	if($result > 0){
                                                    if($result > 0) {
								$this->order_contents['userid'] =$result;
                                                                //Abhinand here the shipping method is trimmed to get rid of _ and assing white spaces in them
								//$this->order_contents['ship_method'] =$this->Iframeuser_model->servicemethod($this->input->post('shipid'));
								$this->order_contents['ship_method'] = str_replace("_"," ",$this->input->post('shipid'));
                                                                $result1=$this->Iframeuser_model->order($this->order_contents);
								
								if($usertype == 1 || $usertype == 3 || $usertype == 5 || $usertype == 7){
									$savecourse = $course;
								}else {
									$savecourse = $this->input->post('course');
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
								}
								$this->course_contents =array(						
															"course" => $savecourse,
															"subcourse"=> $subcourseid,
															"course_o"=> $course_o,
															"userid" => $result,
															"orderid" => $result1,
															"enrolled_date" =>$this->order_contents['orderdate']
															);
									
								$result2	=	$this->Iframeuser_model->usercourse($this->course_contents);
								$this->_init_user_ship();
								$course_weight	=	$this->Iframeuser_model->get_courseweight($this->course_contents);
								$this->ship_contents['courseweight'] = $course_weight;
								$ship =  $this->Iframeuser_model->shipmaterial($this->ship_contents,$this->session->userdata{'admindetails'});
								$this->_int_user_mail($this->course_contents);
								$this->order_updates =array();
								if($ship !='error'){		
							
									$this->order_updates =array(						
												"trackingno" => $ship[29],
												"label_path" => $ship['label'],
												"status" => 'S'
												);
												$orderid= $result1;
									$this->Iframeuser_model->updateorder($this->order_updates,$orderid);
									
									$redirect_action	=	"iframe_user/reg_result_success";
									$this->session->set_flashdata('msg',"Registration completed successfully");
																		
								} else{ 
									$redirect_action	=	"iframe_user/reg_result_success_reship";

									$this->order_updates ='';	
									$this->session->set_flashdata('msg',"Registration completed successfully. Administrator will reship it");
									$this->Iframeuser_model->send_mailto_admin($this->mail_contents,$this->order_contents,$this->session->userdata{'admindetails'},$this->order_updates,$usertype);														
									
								}
								$this->Iframeuser_model->send_mailto_user($this->mail_contents,$this->order_contents,$this->order_updates,'admin',$usertype);
								$this->Iframeuser_model->send_mailto_admin($this->mail_contents,$this->order_contents,$this->session->userdata{'admindetails'},$this->order_updates, $usertype);
								$this->session->sess_destroy();
								redirect($redirect_action);
							}else {
								$this->gen_contents["msg"]="Failed to register the user";
								$this->_int_user_register_course();							
							}							
						}else{
							$this->gen_contents["msg"]="Payment Transaction Failed ".urldecode($data['payment']['L_LONGMESSAGE0']);
							$this->_int_user_register_course();
							/**
							*paymentlog
							**/		
							$status =urldecode($data['payment']['L_LONGMESSAGE0']);
							$this->_init_payment_log($name,$emailid,$status,$course_name);
							$this->Iframeuser_model->paymentlog($this->payment_log);
							/**end **/
							//$this->_int_user_register_course();//die('ff');

						}
						
					} else{
						//$this->gen_contents["msg"]="Fill Required Fields";
						$this->_int_user_register_course();
					}
				}else{
				$this->gen_contents["msg"]="Failed to process please try again ";
				$this->_int_user_register_course();
				}
				

			} else {			
				redirect("user/register");
			}
			

		}
		function reg_result_success(){	
			$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();					
			//$this->load->view("client_common_header",$this->gen_contents);	
			$this->load->view("client_home_header_new",$this->gen_contents);		
			$this->load->view('iframe_user/userregister/reg_result_success');
			//$this->load->view("client_common_footer",$this->gen_contents);	
			$this->load->view("client_home_footer_new",$this->gen_contents);		
		}

		function reg_result_success_reship(){
			$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();					
			$this->load->view("client_home_header_new",$this->gen_contents);		
			$this->load->view('iframe_user/userregister/reg_result_success_reship');
			$this->load->view("client_home_footer_new",$this->gen_contents);
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
				$this->load->model('Iframeuser_model');
				
				if(!empty($_POST)) {
					$this->_init_neworder_rules();	
						
						if($this->form_validation->run() == TRUE) {	
					
						
						$state= $this->Iframeuser_model->selectstate($this->input->post('b_state'));
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
								$courselist= $this->Iframeuser_model->courselist($this->input->post('course'));	
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
									$subcourselist= $this->Iframeuser_model->subcourselist($this->input->post('subcourse'));									
									
										if($course_name !='')		
											$course_name=$course_name.",".$subcourselist['course_name'];
											else
											$course_name=$subcourselist['course_name'];
									
									}
									
								}
								if($this->input->post('course_b')){
									$course_o =$this->input->post('course_b');
									if($course_o  !=''){
									$opcourselist= $this->Iframeuser_model->opcourselist($course_o);	
								
										if($course_name !='')		
											$course_name=$course_name.",".$opcourselist['course_name'];
											else
											$course_name=$opcourselist['course_name'];
												
									}
								}

						
						//init payment details
						$this->_init_user_new_paymentdetails($state[0]['state']);
						 
						$data['payment']=$this->Iframeuser_model->payment($this->new_payment_contents);	
						
						if("SUCCESS" == strtoupper($data['payment']["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($data['payment']["ACK"])) {
                                                $data['payment']["TRANSACTIONID"]='123456789';
								$this->_init_user_order($data['payment']["TRANSACTIONID"]);
								$redirect_action	=	"addcourse_result_success";
								/**
								*paymentlog
								**/							
								$status =$data['payment']["ACK"];							
								$this->_init_payment_log($name,$emailid,$status,$course_name);
								$this->Iframeuser_model->paymentlog($this->payment_log);
								/*****/

								$this->new_order_contents['userid'] =$this->session->userdata('USERID');
								//$this->new_order_contents['ship_method'] =$this->Iframeuser_model->servicemethod($this->input->post('shipid'));
								$this->new_order_contents['ship_method'] = str_replace("_"," ",$this->input->post('shipid'));
                                                                
                                                                
                                                                
                                                                $result1=$this->Iframeuser_model->order($this->new_order_contents);
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
								$result2	=	$this->Iframeuser_model->usercourse($this->course_contents);
								$admindetails= $this->Iframeuser_model->get_admin();	
								$this->_init_user_new_ship();
								$course_weight	=	$this->Iframeuser_model->get_courseweight($this->course_contents);
								$this->new_ship_contents['courseweight'] = $course_weight;
								$ship =  $this->Iframeuser_model->shipmaterial($this->new_ship_contents,$admindetails);
								$this->_int_user_new_mail($this->course_contents);
								$this->order_updates ='';
								if($ship !='error'){		
							
									$this->order_updates =array(						
												"trackingno" => $ship[29],
												"label_path" => $ship['label'],
												"status" => 'S'
												);
												$orderid= $result1;
									$this->Iframeuser_model->updateorder($this->order_updates,$orderid);
									
									$redirect_action	=	"iframe_user/addcourse_result_success";
									$this->session->set_flashdata('msg',"New Courses Added Successfully");
																		
								} else{ 
									$redirect_action	=	"iframe_user/addcourse_result_success_reship";

									$this->order_updates ='';	
									$this->session->set_flashdata("msg","New Courses Added Successfully and administrator will reship it");														
									$this->Iframeuser_model->new_send_mailto_admin($this->new_mail_contents,$this->new_order_contents,$admindetails,$this->order_updates);
								}
								
								$this->Iframeuser_model->new_send_mailto_user($this->new_mail_contents,$this->new_order_contents,$this->order_updates);
							//	$this->Iframeuser_model->new_send_mailto_admin($this->new_mail_contents,$this->new_order_contents,$admindetails,$this->order_updates);
								
								
								redirect("exam/courselist");
						
					} else{
						$this->gen_contents["msg"]="Payment Transaction Failed ".urldecode($data['payment']['L_LONGMESSAGE0']);
						/**
						*paymentlog
						**/							
						$status =urldecode($data['payment']['L_LONGMESSAGE0']);
						$this->_init_payment_log($name,$emailid,$status,$course_name);
						$this->Iframeuser_model->paymentlog($this->payment_log);
						/*****/
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
				redirect("home");
			}		
			
			$this->load->helper("form");
			$this->load->model('Common_model');
			$this->load->model('Iframeuser_model');
				
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
				$data['license']= $this->Iframeuser_model->get_license($this->session->userdata('USERID'));
				$data['course_user_type']= $this->Iframeuser_model->get_course_user_type($this->session->userdata('USERID'));
                                
                                $data['coursearr']=$this->Common_model->listallcourses_type($data['course_user_type']);
                                
                                //$data['coursearr']=$this->Common_model->listallcourses();
				$billing= $this->Iframeuser_model->get_b_address($this->session->userdata('USERID'));
				$shipping= $this->Iframeuser_model->get_s_address($this->session->userdata('USERID'));
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
				
				$data['state'] = $this->Iframeuser_model->get_state();		
				$data['month']=$this->Iframeuser_model->listmonth();
				$currentyear=convert_UTC_to_PST_year(date('Y-m-d H:i:s'));	
				$data['year']=$this->Iframeuser_model->listyear($currentyear);	
			}
			$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();
			$this->load->view("client_common_header_course_new",$this->gen_contents);
			$this->load->view('iframe_user/userregister/remaincourse_new',$data);
			$this->load->view("client_common_footer_main_new",$this->gen_contents);

		
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
				$this->load->model('Iframeuser_model');
			
				if(!empty($_POST)) { 
					$this->_init_renewal_rules();	
						
						if($this->form_validation->run() == TRUE) {	
						$state= $this->Iframeuser_model->selectstate($this->input->post('b_state'));
						$name 		=	$this->input->post('firstname')." ".$this->input->post('lastname');
						$emailid	= 	$this->input->post('emailid');
						$course_name =	$this->input->post('coursename');

						//init payment details
						$this->_init_user_new_paymentdetails($state[0]['state']);
						 
						$data['payment']=$this->Iframeuser_model->payment($this->new_payment_contents);
						
						if("SUCCESS" == strtoupper($data['payment']["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($data['payment']["ACK"])) {
								/**
								*paymentlog
								**/							
								$status =$data['payment']["ACK"];							
								$this->_init_payment_log($name,$emailid,$status,$course_name);
								$this->Iframeuser_model->paymentlog($this->payment_log);
								/*****/
								$userid =$this->session->userdata('USERID');							
								$courseid = $this->input->post('courseid');	
								$course_user_type= $this->Iframeuser_model->get_course_user_type($this->session->userdata('USERID'));
								$emailid= $this->Iframeuser_model->get_mail($this->session->userdata('USERID'));
								$renew_date =date('Y-m-d H:i:s');
								$this->course_det= array(
														"reg_courseid" => $this->input->post('usercourse'),
														"b_address"=> $this->input->post('b_address'),
														"b_city"=> $this->input->post('b_city'),
														"b_state"=> $this->input->post('b_state'),
														"b_country"=> $this->input->post('b_country'),
														"b_zipcode"=> $this->input->post('b_zipcode'),
														"renew_date"=> convert_UTC_to_PST_date($renew_date)
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
								$result2	=	$this->Iframeuser_model->renewcourse($this->course_det);
								$this->session->set_flashdata('msg',$this->input->post('coursename')." Renewed Successfully");
								$this->Iframeuser_model->send_renewal_mailto_user($this->renew_mail_contents,$course_user_type);
								redirect("exam/courselist");
						
					} else{
						
						$this->gen_contents["msg"]="Payment Transaction Failed ".urldecode($data['payment']['L_LONGMESSAGE0']);
						/**
						*paymentlog
						**/							
						$status =urldecode($data['payment']['L_LONGMESSAGE0']);
						$this->_init_payment_log($name,$emailid,$status,$course_name);
						$this->Iframeuser_model->paymentlog($this->payment_log);
						/*****/

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
		 
		 function renewal(){
		  if(!$this->authentication->logged_in("normal")){		 
				redirect("home");
		 }
		 $usercourse = ($this->uri->segment(3)>0)?$this->uri->segment(3):$_POST['usercourse'];
		 $data['usercourse'] = $usercourse;
		
			$this->load->helper("form");
				$this->load->model('Common_model');
				$this->load->model('Iframeuser_model');
				
				$page_submit_error	=	FALSE;
				if(!empty($_POST) ) {
					if('' != $_POST['b_address'])
					if($this->_init_new_renew_order() == false) {
						$page_submit_error	=	FALSE;
					}
				} else {
						$page_submit_error	=	FALSE;
				}
				
				if($page_submit_error == FALSE) {
				
					$this->gen_contents['userid']=$this->session->userdata('USERID');	
					$data['license']= $this->Iframeuser_model->get_license($this->session->userdata('USERID'));
                     $data['course_user_type']= $this->Iframeuser_model->get_course_user_type($this->session->userdata('USERID'));
					
					$billing= $this->Iframeuser_model->get_b_address($this->session->userdata('USERID'));
					$data['billing'] =$billing[0];
					$data['phone'] = $data['billing']['phone'];
					$data['firstname'] = $data['billing']['firstname'];
					$data['lastname'] = $data['billing']['lastname'];
					$data['emailid'] = $data['billing']['emailid'];			
					
					$this->session->set_userdata ("usercourse", $usercourse); 
					$data['u_course']=$this->Common_model->u_course($usercourse);
					$data['renewcourse']=$this->Common_model->list_renewcourse_user($data['u_course'],$data['course_user_type']);
					$data['state'] = $this->Iframeuser_model->get_state();		
					$data['month']=$this->Iframeuser_model->listmonth();
					$currentyear=convert_UTC_to_PST_year(date('Y-m-d H:i:s'));	
					$data['year']=$this->Iframeuser_model->listyear($currentyear);	
				}
				$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();
				$this->load->view("client_common_header_main_new",$this->gen_contents);
				$this->load->view('user/renewcourse_new',$data);
				$this->load->view("client_common_footer_main_new",$this->gen_contents);
			
			
		 
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
						$login_details['username']		=	$this->username;
						$login_details['password']		=	$this->password;
						$login_details['forced_login']	=	$this->forced_login;
						$msg	=	$this->authentication->process_user_login($login_details);
                       // echo $msg;exit;
												
						if($msg=='freezed')
							$this->session->set_flashdata('msg', 'Your Account is Freezed');
							
						elseif ($msg=='success') {
							
                    		
//                                                  $this->vbulletin = new xvbIntegration();
//                                                  $this->vbulletin->xvbLogin($login_details['username'],true);
                                                    ///$this->Iframeuser_model->vb_login($login_details['username']);
							mob_log_message("start","","");						
							//redirect("profile");
                                                        redirect("exam/courselist");

						}		
						else

							$this->session->set_flashdata('msg', 'Invalid Login');
							

					}
				}
				redirect("user/user_login");
		}

        function user_login(){
            $this->load->helper(array('form', 'url', 'file'));
			$this->load->library("session");

			if($this->authentication->logged_in("normal"))
				redirect("profile");

			$this->gen_contents["msg"]	=	$this->session->userdata ('MSG_LOGIN');
			$this->session->set_userdata ('MSG_LOGIN','');

            $this->load->view("client_common_header_new",$this->gen_contents);
            $this->load->view('user/user_login_new');
            $this->load->view("client_common_footer_new",$this->gen_contents);
        }
        		/**
		 * showing login with msg
		 *
		 * @access	public
		 */	

         function log_in(){

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
			if($this->authentication->logged_in("normal"))
				redirect("profile");
				
			if(!empty($_POST))	{
				
				$this->load->library('form_validation');
				
				$this->form_validation->set_rules ('email', 'Email', 'trim|required|valid_email');
				
				if (!$this->form_validation->run() == FALSE) {// form validation
					
					$this->load->model('Iframeuser_model');
					$this->load->model('admin_Iframeuser_model');
				
					
					$this->_init_fogot_password_details();	
					
					if($data=$this->Iframeuser_model->get_password($this->email)){
						$password=random_string('alnum',$len=12);
						if($this->Iframeuser_model->change_password($this->email,$data->id,md5($password))){
							
							$admin=$this->Iframeuser_model->get_admin();
							$subject = '';
							$subject.= "Dear ".$data->firstname. " ".$data->lastname.",<br><br>";
							$subject.= "As per your request, new password has been generated as follows<br>";
							$subject .=" New Password : ".$password."<br><br>"; 
							$subject .= "Thanks,<br>";
							$subject .= "Administrator";
							//if($this->admin_Iframeuser_model->send_mail($this->email,$admin[0]['emailid'],'Forgot Password',$subject)){
							if($this->Common_model->send_mail($this->email,'','Forgot Password',$subject)){
								$this->session->set_flashdata('success', "Your request has been successfully sent to your Email Address");
								redirect('user/forgot_password/');
							}else {
								$this->session->set_flashdata('error', "Can't send New Password");
								redirect('user/forgot_password/');
							}
						}else{
							$this->session->set_flashdata('error', "Can't send New Password");
							redirect('user/forgot_password/');
						}
					}
					else{
						
						$this->session->set_flashdata('error', 'Please enter your correct Email Address');
						redirect('user/forgot_password/');
					}
		
				}
				
			}
				
			$this->load->view("client_common_header_new",$this->gen_contents);
			$this->load->view('user/forgot_password_new');
			$this->load->view("client_common_footer_new",$this->gen_contents);
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
					
					$this->load->model('Iframeuser_model');
							
					$this->_init_change_password_details();	
					$userid		=	$this->session->userdata ('USERID');
					$email_id	=	$this->session->userdata ('EMAIL');
					if($this->Iframeuser_model->confirm_password(md5($this->old_password),$userid)){
	
						if($this->Iframeuser_model->change_password($email_id,$userid,md5($this->new_password))){
							
							$this->session->set_flashdata('success', "Password changed successfully");
							redirect('user/change_password/');
							
						}else{
							$this->session->set_flashdata('error', "Request Failed");
							redirect('user/change_password/');
						}
					}
					else{
						
						$this->session->set_flashdata('error', 'Please enter your correct Current Password');
						redirect('user/change_password/');
					}
		
				}
				
			}
					
			$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();
			$this->load->view("client_common_header_new",$this->gen_contents);
			$this->load->view('user/change_password_new');
			$this->load->view("client_common_footer_new",$this->gen_contents);
		}

		
		
		
		
		/**
		 * logout for user
		 *
		 */	
		function logout ()
		{
			if(!$this->authentication->logged_in("normal"))
				redirect("home");
			//$this->authentication->update_score($this->session->userdata ('USERID'));// for updating the score/exam details when a user logged before the normal process of the exam
			//mob_log_message("end","","");			
				
			//$this->authentication->logout();
			//redirect('home');
			//mob_log_message("end","","");
                         
                        ///$this->vbulletin = new xvbIntegration();
                        ///global $vbulletin;
				//echo $this->session->userdata ('USERID');
                              //  echo $this->session->userdata ('EMAIL');
                            ///$f_id=$vbulletin->userinfo['userid'];
                            ///$f_uname =  $this->vbulletin->xvbUserMail($f_id);
                                //xvbUserMail
//                        if($vbulletin->userinfo['userid']=='')
//                        {
//			$this->authentication->logout();
//                        redirect('home');
//                        }  else {
                            
//                           echo "fb".$f_uname['username'];
//                           echo
                              /*if($this->session->userdata ('EMAIL') == $f_uname['email'])
                                  {
                                 // echo"sdfsd";
                                    $this->authentication->logout();
                                       ///$this->Iframeuser_model->vb_logout();
                                             redirect('home');
                                             mob_log_message("end","","");
                                    }
                                    else{
                                    */ 
                                        $this->authentication->logout();
                                        redirect('home');
                                        mob_log_message("end","","");
                                    //}

                       // }
                         
			//redirect('home');
/*			$this->load->view("client_common_header",$this->gen_contents);						
			$this->load->view('user/client_home_page');
			$this->load->view("client_common_footer");*/
		}
		
		
}