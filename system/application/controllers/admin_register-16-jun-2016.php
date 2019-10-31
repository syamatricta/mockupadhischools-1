<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User Controller
 *
 * @package		CodeIgniter
 * @subpackage	Controllers
 * @category	Controllers
 * @author		MANU
 * @link		http://ahischools.com/admin_register/
 */

// ------------------------------------------------------------------------

class Admin_Register extends Controller
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

	function Admin_Register(){
		parent::Controller();
                        $this->load->library('authentication');
                        $this->load->library('session');
			$this->load->model('Common_model');
			$this->load->model('admin_user_model');
			$this->load->model('user_model');

			$this->gen_contents['css'] = array('style.css','dhtmlgoodies_calendar.css','admin_register.css','admin_style_main.css' );
			$this->gen_contents['js'] = array('admin_register.js','popcalendar.js');
                        
                        if(!$this->authentication->logged_in('admin')){

				redirect("admin/login");
			}
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

	function register()
	{
		// regisration step 1
		if($this->input->post('step1') == 1) {
			$this-> _int_user_register_step1();
		}

		//default case
		if(!$_POST || !isset($_POST['step1'])) {
			$this->load->helper("form");
			$this->load->view("admin/admin_register_heading",$this->gen_contents);

			//$captcha                     = $this->user_model->generate_captcha ();
			//$this->session->set_userdata ("captcha_word", $captcha['word']);

			//$this->gen_contents['captcha_details']     = $captcha;
			$this->gen_contents['state'] = $this->user_model->get_state();
			$this->load->view('admin/register/admin_user_reg_step1',$this->gen_contents);
			$this->load->view("admin_footer",$this->gen_contents);

		}
	}

	/**
	 * function for valiadting the step registration
	 */
	function _int_user_register_step1()
	{
		if(!empty($_POST)) {
			$this->load->model('user_model');
			$this->load->library("form_validation");

			//registration
			$this->_init_registration_rules();

			if($this->form_validation->run() == TRUE) {
				$this->_init_user_regdetails();
				$this->gen_contents['data']['admindetails'] = $this->user_model->get_admin();

				//$captcha_code =	$this->input->post('captcha_code');
				//	$captcha_word = $this->session->userdata("captcha_word");

				/*if ( !( isset($captcha_code) && isset ($captcha_word) &&  0 == strcmp ($captcha_code, $captcha_word) ) )	{

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

				} else {*/

				$check =$this->user_model->checkuser($this->input->post('email'));
                $check_blog =$this->user_model->checkuser_blog($this->input->post('email'));

                                if($check<=0 && $check_blog<=0 ){
                                    $this->gen_contents['data']['step1'] =$this->input->post('step1');

                                    //get step1 user details to save in database
                                    $step1_arr = $this->_set_step1_registration_details($this->gen_contents['data']);

                                    //$this->gen_contents['data']['temp_userid'] = $this->user_model->save_step1_reg_details($step1_arr);
                                    $this->session->set_userdata ($this->gen_contents['data']);

                                    // step 2
                                    $this-> _init_step2_registration();
				} else {
					if($check > 0) {
						$this->gen_contents['msg']= "Email Already Exist";
					} else if($check_blog > 0) {
						$this->gen_contents['msg']= "Email Already Exist in Forum";
					}  /*else if($check_forumalias > 0){
						$this->gen_contents['msg']= "Forum Alias Already Exist";
					}*/
					//$this->gen_contents['msg']= "Email Already Exist";
					$this->load->model('user_model');
					$this->load->helper("form");

					$this->load->view("admin/admin_register_heading",$this->gen_contents);
					//	$captcha                     = $this->user_model->generate_captcha ();

					//	$this->session->set_userdata ("captcha_word", $captcha['word']);

					//	$this->gen_contents['captcha_details']     = $captcha;
					$this->gen_contents['state'] = $this->user_model->get_state();
					$this->load->view('admin/register/admin_user_reg_step1',$this->gen_contents);
					$this->load->view("admin_footer",$this->gen_contents);
				}
							//}
			}
		}

	}


	/**
	 * function for form validation in step 1 registration
	 *
	 */
	function _init_registration_rules()
	{
		$this->form_validation->set_rules('firstname', 'FIRST NAME', 'required|max_length[128]');
		$this->form_validation->set_rules('lastname', 'LAST NAME', 'required|max_length[128]');
		//$this->form_validation->set_rules('name_on_certificate', 'CERTIFICATE NAME', 'required|max_length[255]');
                $this->form_validation->set_rules('testimonial', 'HOW DID YOU HEAR ABOUT US', 'required|max_length[255]');
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
	}

	/**
	 * function for assigning the post values of step1 registration
	 *
	 */
	function _init_user_regdetails()
	{
            $reason = '';
            if($this->Common_model->safe_html($this->input->post('testimonial')) == 'Search engine'){
                    $reason = $this->Common_model->safe_html($this->input->post('txtSearchengine'));
            }else if($this->Common_model->safe_html($this->input->post('testimonial')) == 'Referral from a real estate office'){
                    $reason = $this->Common_model->safe_html($this->input->post('txtREO'));
            }
            
		$this->gen_contents['data'] = array(
			"firstname" 	=> $this->Common_model->safe_html($this->input->post('firstname')),
			"lastname" 		=> $this->Common_model->safe_html($this->input->post('lastname')),
                        "testimonial" 		=> $this->Common_model->safe_html($this->input->post('testimonial')),
                        "reason"	=>	$reason,
			"name_on_certificate" => $this->Common_model->safe_html($this->input->post('firstname')).' '.$this->Common_model->safe_html($this->input->post('lastname')),
			"emailid" 		=> $this->Common_model->safe_html($this->input->post('email')),
			"password" 		=> 	md5($this->Common_model->safe_html($this->input->post('psword'))),
			"orgpassword" 	=> 	$this->Common_model->safe_html($this->input->post('psword')),
			"address"		=> 	$this->Common_model->safe_html($this->input->post('address')),
			"state" 		=> 	$this->input->post('state'),
			"city" 			=> 	$this->Common_model->safe_html($this->input->post('city')),
			"zipcode" 		=>	$this->Common_model->safe_html($this->input->post('zipcode')),
			"country" 		=> 	$this->input->post('country'),
			"phone" 		=> 	$this->Common_model->safe_html($this->input->post('phone')),
			"unit_number"	=>	$this->Common_model->safe_html($this->input->post('unitnumber')),

			//"testimonial" 	=> 	$this->Common_model->safe_html($this->input->post('testimonial')),

			"s_address"		=> 	$this->Common_model->safe_html($this->input->post('address')),
			"s_state" 		=> 	$this->input->post('state'),
			"s_city" 		=> 	$this->Common_model->safe_html($this->input->post('city')),
			"s_zipcode" 	=>	$this->Common_model->safe_html($this->input->post('zipcode')),
			"s_country" 	=> 	$this->input->post('country')
		);
	}


		function _set_step1_registration_details($step1_arr){
			$this->gen_contents['step1_data'] = array(
				"firstname"             => 	$step1_arr['firstname'],
				"lastname"              => 	$step1_arr['lastname'],
				"name_on_certificate"   =>      $step1_arr['name_on_certificate'],
                                "testimonial"           =>      $step1_arr['testimonial'],
                                "reason"                =>      $step1_arr['reason'],
				"emailid" 		=> 	$step1_arr['emailid'],
				"password" 		=> 	$step1_arr['password'],
				"address"		=>      $step1_arr['address'],
				"state" 		=> 	$step1_arr['state'],
				"city" 			=> 	$step1_arr['city'],
				"zipcode" 		=>	$step1_arr['zipcode'],
				"country" 		=> 	$step1_arr['country'],
				"phone" 		=> 	$step1_arr['phone'],
				"s_address"		=> 	$step1_arr['address'],
				"s_state" 		=> 	$step1_arr['state'],
				"s_city" 		=> 	$step1_arr['city'],
				"s_zipcode"             =>	$step1_arr['zipcode'],
				"s_country"             => 	$step1_arr['country'],
                                "unitnumber"            =>      $step1_arr['unit_number']

			);
			return $this->gen_contents['step1_data'];
		}
		/**
		 * function for assigning the post values of step1 registration
		 *
		 */
		function _init_user_regdetails_step2(){

			$this->gen_contents['data']['step2data'] =array(
					//"forum_alias"	=> 	$this->Common_model->safe_html($this->input->post('forumalias')),
					"licensetype"	=> 	$this->input->post('license'),
					/*"unit_number"	=>	$this->Common_model->safe_html($this->input->post('unitnumber')),*/
					"b_address"		=> 	$this->Common_model->safe_html($this->input->post('b_address')),
					"b_state" 		=> 	$this->input->post('b_state'),
					"b_city" 		=> 	$this->Common_model->safe_html($this->input->post('b_city')),
					"b_zipcode" 	=>	$this->Common_model->safe_html($this->input->post('b_zipcode')),
					"b_country" 	=> 	$this->input->post('b_country'),
					/*"billing_sameas_shipping" 	=> 	$this->input->post('bsame'),*/
					"billing_sameas_shipping" 	=> 	'Y',

					/*"s_address"		=> 	$this->Common_model->safe_html($this->input->post('s_address')),
					"s_state" 		=> 	$this->input->post('s_state'),
					"s_city" 		=> 	$this->Common_model->safe_html($this->input->post('s_city')),
					"s_zipcode" 	=>	$this->Common_model->safe_html($this->input->post('s_zipcode')),
					"s_country" 	=> 	$this->input->post('s_country')*/
					);

		}
		function _set_step2_registration_details($step2_arr){
			$this->gen_contents['step2_data'] = array(
				//"forum_alias" 	=> 	$step2_arr['forum_alias'],
				"licensetype"	=> 	$step2_arr['licensetype'],
				/*"unit_number" 	=> 	$step2_arr['unit_number'],*/
				"b_address"		=>  $step2_arr['b_address'],
				"b_state" 		=> 	$step2_arr['b_state'],
				"b_city" 		=> 	$step2_arr['b_city'],
				"b_zipcode" 	=>	$step2_arr['b_zipcode'],
				"b_country" 	=> 	$step2_arr['b_country'],
				"billing_sameas_shipping" =>$step2_arr['billing_sameas_shipping']
				/*"s_address"		=>  $step2_arr['s_address'],
				"s_state" 		=> 	$step2_arr['s_state'],
				"s_city" 		=> 	$step2_arr['s_city'],
				"s_zipcode" 	=>	$step2_arr['s_zipcode'],
				"s_country" 	=> 	$step2_arr['s_country'],*/
			);
			return $this->gen_contents['step2_data'];
		}

	/**
	 * function for displaying step2 registration
	 *
	 */
	function _init_step2_registration()
	{
		$this->load->model('Common_model');
		$this->load->model('user_model');

		$data['coursearr']=$this->Common_model->listallcourses();

		$data['phone']=$this->session->userdata{'phone'};
		$data['state'] = $this->user_model->get_state();

		$this->load->view("admin/admin_register_course_heading",$this->gen_contents);
		$this->load->view('admin/register/admin_user_reg_step2',$data);
		$this->load->view("admin_footer",$this->gen_contents);
	}

		function register_step2(){ 


			if($this->input->post('step2') == 2 and $this->session->userdata('step1') == 1 ){


				$this->_init_no_ship_payment();

				$this->load->library("form_validation");
				$this->load->model('Common_model');
				$this->load->model('user_model');

				if(!empty($_POST)) {

					$this->_init_registration_rules_step2();

					if($this->form_validation->run() == TRUE) {

						$this->_init_user_regdetails_step2();

						$state		= 	$this->user_model->selectstate($this->input->post('b_state'));

						/*$check_forumalias = $this->user_model->checkuser_forumalias($this->input->post('forumalias'));
                                                
						if($check_forumalias<=0 ){*/
							$this->gen_contents['data']['step2'] =array('step2'=>$this->input->post('step2'));
							//get step2 user details to update in database
							$step2_arr = $this->_set_step2_registration_details($this->gen_contents['data']['step2data']);
							//$save_secondstep = $this->user_model->update_step2_reg_details($step2_arr, $this->session->userdata('temp_userid'));
							$this->session->set_userdata ($this->gen_contents['data']['step2data']);
							$this->session->set_userdata ($this->gen_contents['data']['step2']);
							$ship_pay_det = array('need_ship' => $this->input->post('need_ship'),
													'need_payment' =>$this->input->post('need_payment'));
							$this->session->set_userdata($ship_pay_det);
							// step 3
							//$this-> _int_user_register_coursecoursedd();
                                                        $this-> _int_user_register_course();
						/*}else{
							$this->gen_contents['msg']= "Forum Alias Already Exist";
							$this->gen_contents['state'] = $this->user_model->get_state();
							$this->load->view("admin/admin_register_heading",$this->gen_contents);
							$this->load->view('admin/register/admin_user_reg_step2',$this->gen_contents);
							$this->load->view("admin_footer",$this->gen_contents);
						}*/
					}else{
						echo validation_errors();
					}
				}
			}
		}

		/**
		 * function for displaying step3 registration
		 *
		 */
		function _int_user_register_course(){ 
			$this->load->model('Common_model');
			$this->load->model('user_model');
			//$data['coursearr']=$this->Common_model->listallcourses();

			$usertype = $this->session->userdata('course_usertype');
			//$data['coursearr']=$this->Common_model->licensecourselist_m($this->session->userdata('course_usertype'));
            $data['courses'] = $this->Common_model->getCourses($usertype);
                     //  print_r($data['coursearr']);
			$data['phone']=$this->session->userdata{'phone'};
			$data['license']=$this->session->userdata{'licensetype'};


		//  $data['courses_m']=$this->Common_model->licensecourselist_m($data['license']);
		//	$data['courses_o']=$this->Common_model->licensecourselist_o($data['license']);
		//	$data['subcourses']=$this->Common_model->subcourselist();


			$data['state'] = $this->user_model->get_state();

			$data['month']=$this->user_model->listmonth();
			$currentyear=convert_UTC_to_PST_year(date('Y-m-d H:i:s'));
			$data['year']=$this->user_model->listyear($currentyear);

			$this->load->view("admin/admin_register_course_heading",$this->gen_contents);
			$this->load->view('admin/register/admin_user_reg_step3',$data);
			$this->load->view("admin_footer",$this->gen_contents);

		}
		function _init_registration_rules_step3(){
			if($this->input->post('need_payment')=='yes'){
				$this->form_validation->set_rules('ccno', 'Credit Crad Number', 'required|max_length[128]');
				$this->form_validation->set_rules('cvv2no', 'Credit Card Verification Code', 'required|max_length[128]');
				$this->form_validation->set_rules('cardtype', 'Credit Card Type', 'required|max_length[128]');
				$this->form_validation->set_rules('expmonth', 'Expire Month', 'required|max_length[128]');
				$this->form_validation->set_rules('expyear', 'Expire Year', 'required|max_length[128]');
			}

			if($this->input->post('need_ship')=='yes'){
				$this->form_validation->set_rules('shipid', 'Ship Method', 'required');
			}
			$this->form_validation->set_rules('price', 'Price', 'required');
		}
		
		/**
		 * function for form validation in step 2 registration
		 *
		 */
		function _init_registration_rules_step2(){

			//$this->form_validation->set_rules('forumalias', 'FORUM ALIAS', 'required|min_length[3]|max_length[100]');
			$this->form_validation->set_rules('license', 'LICENSE TYPE', 'required');

			if($this->input->post('need_payment')=='yes'){
				$this->form_validation->set_rules('b_address', 'Billing Address', 'required|max_length[128]');
				$this->form_validation->set_rules('b_state', 'Billing Address State', 'required|max_length[128]');
				$this->form_validation->set_rules('b_country', 'Billing Address Country', 'required|max_length[128]');
				$this->form_validation->set_rules('b_city', 'Billing Address City', 'required|max_length[128]');
				$this->form_validation->set_rules('b_zipcode', 'Billing Address Zipcode', 'required|max_length[128]');
			}

			/*if($this->input->post('need_ship')=='yes'){
				$this->form_validation->set_rules('s_address', 'Shipping Address', 'required|max_length[128]');
				$this->form_validation->set_rules('s_state', 'Shipping Address State', 'required');
				$this->form_validation->set_rules('s_country', 'Shipping Address Country', 'required');
				$this->form_validation->set_rules('s_city', 'Shipping Address City', 'required');
				$this->form_validation->set_rules('s_zipcode', 'Shipping Address Zip code', 'required');
			}*/

			//$this->form_validation->set_rules('s_address', 'Shipping Address', 'required|max_length[128]');
			$this->form_validation->set_rules('need_ship', '', '');
			$this->form_validation->set_rules('need_payment', '', '');

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
						"address1" 		=>	$this->session->userdata('address'),
						"zipcode" 		=>  $this->session->userdata('state'),
						"country" 		=> 	$this->session->userdata('country'),
						"state" 		=> 	$state,
						"city" 			=> 	$this->session->userdata('city"'),
						"amount" 		=> 	$this->input->post('totalprice')
						);
				return $this->payment_contents;
				//print_r($this->payment_contents);die();
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
					"paymentdate"		=> convert_UTC_to_PST_datetime(date("Y-m-d H:i:s")),
					"b_address" 		=> $this->session->userdata('b_address').",".$this->session->userdata('b_city').
												",".$this->session->userdata('b_state').",".$this->session->userdata('b_country').",".$this->session->userdata('b_zipcode'),

					"s_address" 		=> $this->session->userdata('s_address').",".$this->session->userdata('s_city').
												",".$this->session->userdata('s_state').",".$this->session->userdata('s_country').",".$this->session->userdata('s_zipcode'),
					"coursename" 		=> $course_name,
					"status" 			=> $status
					);
		}

		function _init_payment_log_nopayment($name,$emailid,$status,$course_name){
					$this->payment_log =array(

							"name"				=> 	$name,
							"emailid" 			=> $emailid,
							"paymentdate"		=> convert_UTC_to_PST_datetime(date("Y-m-d H:i:s")),


							"b_address" 		=> $this->session->userdata('address').",".$this->session->userdata('city').
														",".$this->session->userdata('state').",".$this->session->userdata('country').",".$this->session->userdata('zipcode'),

							"s_address" 		=> $this->input->post('s_address').",".$this->input->post('s_city').
														",".$this->input->post('s_state').",".$this->input->post('s_country').",".$this->input->post('s_zipcode'),
							"coursename" 		=> $course_name,
							"status" 			=> $status
							);
		}


		function _init_user_registration_change($transactionid){
			$this->user_contents =array(
							"firstname" 	=> 	$this->session->userdata('firstname'),
							"lastname" 		=> 	$this->session->userdata('lastname'),
							"name_on_certificate" => $this->session->userdata('name_on_certificate'),
							//"forum_alias" 	=> 	$this->session->userdata('forum_alias'),
							"unit_number"	=>	$this->session->userdata('unit_number'),
							"emailid" 		=> 	$this->session->userdata('emailid'),
							"password" 		=> 	$this->session->userdata('password'),
							"address" 		=> 	$this->session->userdata('address'),
							"state" 		=> 	$this->session->userdata('state'),
							"city" 			=> 	$this->session->userdata('city'),
							"zipcode" 		=> 	$this->session->userdata('zipcode'),
							"country" 		=> 	$this->session->userdata('country'),
							"phone" 		=> 	$this->session->userdata('phone'),
							"testimonial" 	=> 	$this->session->userdata('testimonial'),
                                                        "reason" 	=> 	$this->session->userdata('reason'),
							"licensetype" 	=> 	$this->session->userdata('licensetype'),
							"b_address" 	=> 	$this->session->userdata('b_address'),
							"b_country" 	=> 	$this->session->userdata('b_country'),
							"b_state" 		=> 	$this->session->userdata('b_state'),
							"b_city" 		=> 	$this->session->userdata('b_city'),
							"b_zipcode" 	=> 	$this->session->userdata('b_zipcode'),
							"billing_sameas_shipping" 	=> 	$this->session->userdata('billing_sameas_shipping'),

							"s_address" 	=> 	$this->session->userdata('s_address'),
							"s_country" 	=>	$this->session->userdata('s_country'),
							"s_state" 		=> 	$this->session->userdata('s_state'),
							"s_city" 		=> 	$this->session->userdata('s_city'),
							"s_zipcode" 	=> 	$this->session->userdata('s_zipcode'),
                            "course_user_type"=>$this->session->userdata('course_usertype'),
							"unit_number"	=>$this->session->userdata('unit_number')

							);

			if($this->session->userdata('need_ship')=='no')
				$delivered_date	=	convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
			else
				$delivered_date	=	'0000-00-00';

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
							"orderdate" 		=> 	convert_UTC_to_PST_date(date('Y-m-d H:i:s')),
							"delivered_date"	=>	$delivered_date,
							"ship_status"		=>	'N'

							);
							/*print "<pre>";
	              print_r($this->order_contents);
              	print "</pre>";
                        die();*/


		}

			function _init_user_registration($transactionid){
			$this->user_contents =array(
							"firstname" 	=> 	$this->session->userdata('firstname'),
							"lastname" 		=> 	$this->session->userdata('lastname'),
							"name_on_certificate" => $this->session->userdata('name_on_certificate'),
							//"forum_alias" 	=> 	$this->session->userdata('forum_alias'),
							"emailid" 		=> 	$this->session->userdata('emailid'),
							"password" 		=> 	$this->session->userdata('password'),
							"address" 		=> 	$this->session->userdata('address'),
							"state" 		=> 	$this->session->userdata('state'),
							"city" 			=> 	$this->session->userdata('city'),
							"zipcode" 		=> 	$this->session->userdata('zipcode'),
							"country" 		=> 	$this->session->userdata('country'),
							"phone" 		=> 	$this->session->userdata('phone'),
							"testimonial" 	=> 	$this->session->userdata('testimonial'),
                                                        "reason" 	=> 	$this->session->userdata('reason'),
							"licensetype" 	=> 	$this->session->userdata('licensetype'),
							"b_address" 	=> 	$this->session->userdata('b_address'),
							"b_country" 	=> 	$this->session->userdata('b_country'),
							"b_state" 		=> 	$this->session->userdata('b_state'),
							"b_city" 		=> 	$this->session->userdata('b_city'),
							"b_zipcode" 	=> 	$this->session->userdata('b_zipcode'),
							"billing_sameas_shipping" 	=> 	$this->session->userdata('billing_sameas_shipping'),
							"s_address" 	=> 	$this->session->userdata('s_address'),
							"s_country" 	=>	$this->session->userdata('s_country'),
							"s_state" 		=> 	$this->session->userdata('s_state'),
							"s_city" 		=> 	$this->session->userdata('s_city'),
							"s_zipcode" 	=> 	$this->session->userdata('s_zipcode'),
							"course_user_type"=>$this->session->userdata('course_usertype'),
							"unit_number"=>$this->session->userdata('unit_number')
							);
			if($this->session->userdata('need_ship')=='no')
				$delivered_date	=	convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
			else
				$delivered_date	=	'0000-00-00';

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
							"orderdate" 		=> 	convert_UTC_to_PST_date(date('Y-m-d H:i:s')),
							"delivered_date"	=>	$delivered_date

							);

		}

                function _user_forum_data(){
			$this->user_forum_contents =array(
							"usergroupid"   	=> 	2,
							"displaygroupid"	=> 	0,
							"username" 		=> 	$this->session->userdata('emailid'),
							"password" 		=> 	$this->session->userdata('password'),
							"email" 		=> 	$this->session->userdata('emailid'),
							"showvbcode" 		=> 	'vb',
							 "firstname"    => 	$this->session->userdata('firstname'),
							"lastname" 		=> 	$this->session->userdata('lastname'),
							//"forum_alias" 	=> 	$this->session->userdata('forum_alias'),
							"usertitle" 	=> 	'Junior Member'
							);

		}
		function _init_user_registration_nopayment($transactionid){
			$this->user_contents =array(
							"firstname" 	=> 	$this->session->userdata('firstname'),
							"lastname" 		=> 	$this->session->userdata('lastname'),
							"name_on_certificate" => $this->session->userdata('name_on_certificate'),
							"emailid" 		=> 	$this->session->userdata('emailid'),
							"password" 		=> 	$this->session->userdata('password'),
							"address" 		=> 	$this->session->userdata('address'),
							"state" 		=> 	$this->session->userdata('state'),
							"city" 			=> 	$this->session->userdata('city'),
							"zipcode" 		=> 	$this->session->userdata('zipcode'),
							"country" 		=> 	$this->session->userdata('country'),
							"phone" 		=> 	$this->session->userdata('phone'),
							"testimonial" 	=> 	$this->session->userdata('testimonial'),
                                                        "reason" 	=> 	$this->session->userdata('reason'),
							"licensetype" 	=> 	$this->session->userdata('licensetype'),


							"b_address" 		=> 	$this->session->userdata('address'),
							"b_state" 			=> 	$this->session->userdata('state'),
							"b_city" 			=> 	$this->session->userdata('city'),
							"b_zipcode" 		=> 	$this->session->userdata('zipcode'),
							"b_country" 		=> 	$this->session->userdata('country'),


							"s_address" 	=> 	$this->session->userdata('s_address'),
							"s_country" 	=>	$this->session->userdata('s_country'),
							"s_state" 		=> 	$this->session->userdata('s_state'),
							"s_city" 		=> 	$this->session->userdata('s_city'),
							"s_zipcode" 	=> 	$this->session->userdata('s_zipcode'),
                                                        "course_user_type"=>$this->session->userdata('course_usertype'),
							"unit_number"=>$this->session->userdata('unit_number')

							);

			if($this->session->userdata('need_ship')=='no')
				$delivered_date	=	convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
			else
				$delivered_date	=	'0000-00-00';
			$this->order_contents =array(
							"b_address" 		=> 	$this->session->userdata('address'),
							"b_state" 			=> 	$this->session->userdata('state'),
							"b_city" 			=> 	$this->session->userdata('city'),
							"b_zipcode" 		=> 	$this->session->userdata('zipcode'),
							"b_country" 		=> 	$this->session->userdata('country'),
							"s_address" 		=> 	$this->session->userdata('s_address'),
							"s_country" 		=>	$this->session->userdata('s_country'),
							"s_state" 			=> 	$this->session->userdata('s_state'),
							"s_city"			=> 	$this->session->userdata('s_city'),
							"s_zipcode" 		=> 	$this->session->userdata('s_zipcode'),
							"total_amount"		=> 	$this->input->post('totalprice'),
							"ship_rate" 		=> 	$this->input->post('shipprice'),
							"course_price" 		=> 	$this->input->post('price'),
							"transactionid"		=> 	$transactionid,
							"payment_method"	=> 'By Admin',
							"orderdate" 		=> 	convert_UTC_to_PST_date(date('Y-m-d H:i:s')),
							"delivered_date"	=>	$delivered_date

							);




		}

			function _init_user_registration_nopayment_change($transactionid){
			$this->user_contents =array(
							"firstname" 	=> 	$this->session->userdata('firstname'),
							"lastname" 		=> 	$this->session->userdata('lastname'),
							"name_on_certificate" => $this->session->userdata('name_on_certificate'),
							//"forum_alias" 	=> 	$this->session->userdata('forum_alias'),
							"emailid" 		=> 	$this->session->userdata('emailid'),
							"password" 		=> 	$this->session->userdata('password'),
							"address" 		=> 	$this->session->userdata('address'),
							"state" 		=> 	$this->session->userdata('state'),
							"city" 			=> 	$this->session->userdata('city'),
							"zipcode" 		=> 	$this->session->userdata('zipcode'),
							"country" 		=> 	$this->session->userdata('country'),
							"phone" 		=> 	$this->session->userdata('phone'),
							"testimonial" 	=> 	$this->session->userdata('testimonial'),
                                                        "reason" 	=> 	$this->session->userdata('reason'),
							"licensetype" 	=> 	$this->session->userdata('licensetype'),


							"b_address" 		=> 	$this->session->userdata('address'),
							"b_state" 			=> 	$this->session->userdata('state'),
							"b_city" 			=> 	$this->session->userdata('city'),
							"b_zipcode" 		=> 	$this->session->userdata('zipcode'),
							"b_country" 		=> 	$this->session->userdata('country'),
							"billing_sameas_shipping" 	=> 	$this->session->userdata('billing_sameas_shipping'),

							"s_address" 	=> 	$this->session->userdata('s_address'),
							"s_country" 	=>	$this->session->userdata('s_country'),
							"s_state" 		=> 	$this->session->userdata('s_state'),
							"s_city" 		=> 	$this->session->userdata('s_city'),
							"s_zipcode" 	=> 	$this->session->userdata('s_zipcode'),
	                                                "course_user_type"=>$this->session->userdata('course_usertype'),
							"unit_number"=>$this->session->userdata('unit_number')
							);

			if($this->session->userdata('need_ship')=='no')
				$delivered_date	=	convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
			else
				$delivered_date	=	'0000-00-00';
			$this->order_contents =array(
							"b_address" 		=> 	$this->session->userdata('address'),
							"b_state" 			=> 	$this->session->userdata('state'),
							"b_city" 			=> 	$this->session->userdata('city'),
							"b_zipcode" 		=> 	$this->session->userdata('zipcode'),
							"b_country" 		=> 	$this->session->userdata('country'),
							"s_address" 		=> 	$this->session->userdata('s_address'),
							"s_country" 		=>	$this->session->userdata('s_country'),
							"s_state" 			=> 	$this->session->userdata('s_state'),
							"s_city"			=> 	$this->session->userdata('s_city'),
							"s_zipcode" 		=> 	$this->session->userdata('s_zipcode'),
							"total_amount"		=> 	$this->input->post('totalprice'),
							"ship_rate" 		=> 	$this->input->post('shipprice'),
							"course_price" 		=> 	$this->input->post('price'),
							"transactionid"		=> 	$transactionid,
							"payment_method"	=> 'By Admin',
							"orderdate" 		=> 	convert_UTC_to_PST_date(date('Y-m-d H:i:s')),
							"delivered_date"	=>	$delivered_date,
							"ship_status"		=>	'N'
							);

                }
		function _init_user_ship(){
			$this->ship_contents =array(
						"r_phone" 		=>  $this->input->post('bphone'),
						"r_address" 	=>  $this->session->userdata('s_address'),
						"r_country" 	=>  $this->session->userdata('s_country'),
						"r_state"		=>  $this->session->userdata('s_state'),
						"r_city"		=>  $this->session->userdata('s_city'),
						"r_zipcode" 	=>  $this->session->userdata('s_zipcode'),
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
					"paymentdate"		=> convert_UTC_to_PST_datetime(date("Y-m-d H:i:s")),

					"b_address" 		=> $this->session->userdata('b_address').",".$this->session->userdata('b_city').
												",".$this->session->userdata('b_state').",".$this->session->userdata('b_country').",".$this->session->userdata('b_zipcode'),

					"s_address" 		=> $this->session->userdata('address').",".$this->session->userdata('city').
												",".$this->session->userdata('state').",".$this->session->userdata('country').",".$this->session->userdata('zipcode'),
					"coursename" 		=> $course_name,
					"status" 			=> $status
					);
		}

		function _init_no_ship_payment(){

			if($this->session->userdata('need_ship')=='no'){

				$_POST['s_address']				=	 	$this->session->userdata('address');
				$_POST['s_country']    			=		$this->session->userdata('country');
				$_POST['s_state']				=		$this->session->userdata('state');
				$_POST['s_city'] 				=		$this->session->userdata('city');
			 	$_POST['s_zipcode'] 			=		$this->session->userdata('zipcode');
				//$_POST['total'] 				=		$this->input->post('price');
				//$_POST['totalprice'] 			=		$this->input->post('price');
			}
			if($this->session->userdata('need_payment')=='no'){

				 $_POST['b_address']			=	 	$this->session->userdata('address');
				 $_POST['b_country']			=		$this->session->userdata('country');
				 $_POST['b_state']				=		$this->session->userdata('state');
				 $_POST['b_city'] 				=		$this->session->userdata('city');
			 	 $_POST['b_zipcode']  			=		$this->session->userdata('zipcode');

			}

		}

		function reg_result_success(){

			if(!$this->authentication->logged_in('admin')){

				redirect("admin/login");
			}
			$this->load->view("admin/admin_register_heading",$this->gen_contents);
			$this->load->view('admin/register/reg_result_success');
			$this->load->view("admin_footer",$this->gen_contents);
		}

		function reg_result_success_reship(){
			if(!$this->authentication->logged_in('admin')){

				redirect("admin/login");
			}
			$this->load->view("admin/admin_register_heading",$this->gen_contents);
			$this->load->view('admin/register/reg_result_success_reship');
			$this->load->view("admin_footer",$this->gen_contents);
			//unset($_POST);

		}
		function _init_empty_user_session_details(){
			$data	=	array("firstname"=>'',
						"lastname"=>'',
						"name_on_certificate" => '',
						//"forum_alias"=>'',
						"emailid"=>'',
						"password"=>'',
						"orgpassword"=>'',
						"unit_number"=>'',
						"address"=>'',
						"state"=>'',
						"city"=>'',
						"zipcode"=>'',
						"country"=>'',
						"phone"=>'',
						"testimonial"=>'',
                                                "reason"=>'',
						"licensetype"=>'',
						"step1" =>'',
						"temp_userid" =>'',
						"b_address"=>'',
						"b_state"=>'',
						"b_city"=>'',
						"b_zipcode"=>'',
						"b_country"=>'',
						"billing_sameas_shipping"=>'',
						"s_address"=>'',
						"s_state"=>'',
						"s_city"=>'',
						"s_zipcode"=>'',
						"s_country"=>'',
						"need_ship"=>'',
						"need_payment"=>'',
						"course_usertype"=>'',
						"step2"=>''
						);
			$this->session->set_userdata($data);
		}

        // function for registration, payment process, order placement and shipping
        function courseadd ()
        {

            $this->load->helper("form");
            $this->load->helper("fedex");

            $this->load->model('common_model');
            $new_package = 0;
            //Registration step3
//                        print('<pre>');
//                        print_r($this->session->userdata);
//                        print_r($_POST);
            //if($this->input->post('step3') == 3 and $this->session->userdata('step2') == 2 ){
            if ($this->input->post('step3') == 3 and $this->session->userdata('step2') == 2)
            {

                $this->_init_no_ship_payment();

                $this->load->library("form_validation");
                $this->load->model('Common_model');
                $this->load->model('user_model');

                if (!empty($_POST))
                {

                    $this->_init_registration_rules_step3();

                    if ($this->form_validation->run() == TRUE)
                    {

                        $state = $this->user_model->selectstate($this->session->userdata('state'));
                        $name = $this->session->userdata('firstname') . " " . $this->session->userdata('lastname');
                        $emailid = $this->session->userdata('emailid');
                        $course_name = '';
                        $course = '';
                        $subcourseid = '';
                        $course_o = '';

                        // assign new zipcode to session
                        $this->session->set_userdata('zipcode', $this->input->post('s_zipcode'));
                        $this->session->set_userdata('s_zipcode', $this->input->post('s_zipcode'));

                        /* added by vidhya for sales packages starts here */
                        $usertype = $this->session->userdata('course_usertype');
                        if ($usertype == 1 || $usertype == 3)
                        {
                            $courseids = $this->Common_model->getCourseweight();
                            $course = array();
                            foreach ($courseids as $courseid)
                            {
                                $course[] = $courseid->id;
                            }

                            $courselist = $this->user_model->coursename($course);

                            if ($course != '')
                            {
                                for ($i = 0; $i < count($courselist); $i++)
                                {
                                    if ($course_name != '')
                                        $course_name = $course_name . "," . $courselist[$i]['course_name'];
                                    else
                                        $course_name = $courselist[$i]['course_name'];
                                }
                            }
                        }else if ($usertype == 5 || $usertype == 7)
                        {
                            if($this->input->post('new_package') == 1)
                            {
                                $courseids= $this->Common_model->licensecourselist_m(11);
                                $new_package = 1;
                            }
                            else
                            {
                                $courseids= $this->Common_model->licensecourselist_m(6);
                            }
                            
                            //print_r($courseids);
                            $course = array();
                            foreach ($courseids as $courseid)
                            {
                                $course[] = $courseid['course_id'];
                            }
                            if($this->input->post('new_package') != 1)
                            $course[] = $_POST['hidcrsid'];
                            $courselist = $this->user_model->coursename($course);
                            if ($course != '')
                            {
                                for ($i = 0; $i < count($courselist); $i++)
                                {
                                    if ($course_name != '')
                                        $course_name = $course_name . "," . $courselist[$i]['course_name'];
                                    else
                                        $course_name = $courselist[$i]['course_name'];
                                }
                            }
                        }else
                        {
                            /* added by vidhya for sales packages ends here */
                            if ($this->input->post('course'))
                            {
                                $course = $this->input->post('course');
                                $courselist = $this->user_model->courselist($this->input->post('course'));
                                if ($course != '')
                                {
                                    for ($i = 0; $i < count($courselist); $i++)
                                    {
                                        if ($course_name != '')
                                            $course_name = $course_name . "," . $courselist[$i]['course_name'];
                                        else
                                            $course_name = $courselist[$i]['course_name'];
                                    }
                                }
                            }

                            if ($this->input->post('subcourse'))
                            {
                                $subcourseid = $this->input->post('subcourse');
                                if ($subcourseid != '')
                                {
                                    $subcourselist = $this->user_model->subcourselist($this->input->post('subcourse'));

                                    if ($course_name != '')
                                        $course_name = $course_name . "," . $subcourselist['course_name'];
                                    else
                                        $course_name = $subcourselist['course_name'];
                                }
                            }
                            if ($this->input->post('course_b'))
                            {
                                $course_o = $this->input->post('course_b');
                                if ($course_o != '')
                                {
                                    $opcourselist = $this->user_model->opcourselist($course_o);

                                    if ($course_name != '')
                                        $course_name = $course_name . "," . $opcourselist['course_name'];
                                    else
                                        $course_name = $opcourselist['course_name'];
                                }
                            }
                        }
                        // exit();
                        //Logout for deleted subadmin
                         $this->load->model('admin_subadmin_model');
                         $subadmin_data = $this->admin_subadmin_model->select_subadmin($this->session->userdata('USERID'));
                         if(count($subadmin_data) == 0) 
                         {
                             $this->authentication->logout ();
                             $this->session->set_flashdata('msg', "Your account has been deleted. Please contact administrator. ");
                             redirect ('admin/login/sub');
                             exit;
			
                         }
                        //Logout for deleted subadmin
                        if ($this->input->post('need_payment') == 'yes' && $this->input->post('need_ship') == 'yes')
                        {
                            $this->_init_user_paymentdetails($state[0]['state']);//init payment details

                            $data['payment'] = $this->user_model->payment($this->payment_contents);

                            if ("SUCCESS" == strtoupper($data['payment']["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($data['payment']["ACK"]))
                            {

                                $redirect_action = "reg_result_success";
                                /**
                                 * paymentlog
                                 * */
                                $status = $data['payment']["ACK"];
                                $this->_init_payment_log($name, $emailid, $status, $course_name);
                                $this->user_model->paymentlog($this->payment_log);
                                /*                                 * ** */
                                $this->_init_user_registration($data['payment']["TRANSACTIONID"]);
                                //New package update
                                $this->user_contents["sales_new_package"] = $new_package;
                              
                                $result = $this->user_model->userregistration($this->user_contents);
                                //$this->_user_forum_data();
                                //$result_forum = $this->user_model->adduser_forum($this->user_forum_contents);
                                if ($result > 0)
                                {
                                    $this->_update_trial_account($this->session->userdata('emailid'), $result);//if user have trial account
                                    
                                    $this->order_contents['userid'] = $result;
                                    //to remove the underscore and give white space to the shipping method name and save it to the db
                                    //$this->order_contents['ship_method'] =$this->user_model->servicemethod($this->input->post('shipid'));
                                    $this->order_contents['ship_method'] = str_replace("_", " ", $this->input->post('shipid'));
                                    $result1 = $this->user_model->order($this->order_contents);
                                    if ($usertype == 1 || $usertype == 3 || $usertype == 5 || $usertype == 7)
                                    {
                                        $savecourse = $course;
                                    }
                                    else
                                    {
                                        $savecourse = $this->input->post('course');
                                        if ($this->input->post('subcourse'))
                                        {
                                            $subcourseid = $this->input->post('subcourse');
                                        }
                                        else
                                        {
                                            $subcourseid = '';
                                        }
                                        if ($this->input->post('course_b'))
                                        {
                                            $course_o = $this->input->post('course_b');
                                        }
                                        else
                                        {

                                            $course_o = '';
                                        }
                                    }
                                    //echo 'dd';
                                    //print_r($this->input->post('course'));exit();
                                    $this->course_contents = array(
                                        "course" => $savecourse,
                                        "subcourse" => $subcourseid,
                                        "course_o" => $course_o,
                                        "userid" => $result,
                                        "orderid" => $result1,
                                        "enrolled_date" => $this->order_contents['orderdate']
                                    );
                                    $result2 = $this->user_model->usercourse($this->course_contents);
                                    //$this->_init_user_ship();
                                    $this->_init_recipient();

                                    $courseDetails = $this->user_model->get_course_details($this->course_contents);
                                    $course_weight = $courseDetails['course_weight'];
                                    $course_amount = $courseDetails['course_amount'];
                                    $arrCourseDetails = $courseDetails['arrCourseDetails'];
                                    $this->_init_package($courseDetails);


                                    //$course_weight	=	$this->user_model->get_courseweight($this->course_contents);
                                    //$this->ship_contents['courseweight'] = $course_weight;
                                    //$ship =  $this->user_model->shipmaterial($this->ship_contents,$this->session->userdata{'admindetails'});

                                    $aryOrder = array(
                                        'TotalPackages' => 1,
                                        'PackageType' => 'YOUR_PACKAGING', //FEDEX_10KG_BOX, FEDEX_25KG_BOX, FEDEX_BOX, FEDEX_ENVELOPE, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING
                                        'ServiceType' => $this->input->post('shipid'),
                                        'TermsOfSaleType' => "DDU", #    DDU/DDP
                                        'DropoffType' => 'REGULAR_PICKUP'         // BUSINESS_SERVICE_CENTER, DROP_BOX, REGULAR_PICKUP, REQUEST_COURIER, STATION
                                        //'TotalWeight' => array('Value' => 50.0, 'Units' => 'LB'), // valid values LB and KG
                                    );

                                    $ship = setShipment($aryOrder, $this->aryRecipient, $this->realPackages, $course_amount, $course_weight);

                                    $this->_int_user_mail($this->course_contents);
                                    $this->order_updates = array();
                                    if ($ship != 'error')
                                    {

                                        /* $this->order_updates =array(
                                          "trackingno" => $ship[29],
                                          "label_path" => $ship['label'],
                                          "status" => 'S'
                                          ); */
                                        $this->order_updates = array(
                                            "trackingno" => $ship['trackingno'],
                                            "label_path" => $ship['label'],
                                            "status" => 'S'
                                        );
                                        $orderid = $result1;
                                        $this->user_model->updateorder($this->order_updates, $orderid);

                                        //$redirect_action = "admin_user/list_user_details/".base64_encode('Registration Completed Successfully');
                                        $redirect_action = 'admin_user/list_user_details';
                                        $this->session->set_flashdata('success', "Registration Completed Successfully");
                                    }
                                    else
                                    {
                                        //$redirect_action = "admin_user/list_user_details/".base64_encode('Registration Completed Successfully. Administrator will reship it');
                                        $redirect_action = 'admin_user/list_user_details';

                                        $this->order_updates = '';
                                        $this->session->set_flashdata('success', "Registration Completed Successfully. Administrator will reship it");
                                        $this->user_model->send_mailto_admin($this->mail_contents, $this->order_contents, $this->session->userdata{'admindetails'}, $this->order_updates, $usertype);
                                    }

                                    $this->user_model->send_mailto_user($this->mail_contents, $this->order_contents, $this->order_updates, 'admin', $usertype);
                                    //	$this->user_model->send_mailto_admin($this->mail_contents,$this->order_contents,$this->session->userdata{'admindetails'},$this->order_updates);
                                    $this->_init_empty_user_session_details();
                                    redirect($redirect_action);
                                }
                            }
                            else
                            {
                                $this->gen_contents["msg"] = "Payment Transaction Failed " . urldecode($data['payment']['L_LONGMESSAGE0']);
                                $this->_int_user_register_course();
                                /**
                                 * paymentlog
                                 * */
                                $status = urldecode($data['payment']['L_LONGMESSAGE0']);
                                $this->_init_payment_log($name, $emailid, $status, $course_name);
                                $this->user_model->paymentlog($this->payment_log);
                                /*                                 * end * */
                                /* $this->_int_user_register_course();//die('ff'); */
                            }
                        }
                        elseif ($this->input->post('need_ship') == 'yes' && $this->input->post('need_payment') == 'no')
                        {


                            $this->_init_user_paymentdetails($state[0]['state']);//init payment details
                            //$data['payment']=$this->user_model->payment($this->payment_contents);
                            //$redirect_action	=	"reg_result_success";


                            $this->_init_user_registration_nopayment('');
                            //New package update
                            $this->user_contents["sales_new_package"] = $new_package;
                            $result = $this->user_model->userregistration($this->user_contents);
                            //$this->_user_forum_data();
                            //$result_forum = $this->user_model->adduser_forum($this->user_forum_contents);
                            if ($result > 0)
                            {
                                $this->_update_trial_account($this->session->userdata('emailid'), $result);//if user have trial account
                                
                                $this->order_contents['userid'] = $result;
                                //$this->order_contents['ship_method'] =$this->user_model->servicemethod($this->input->post('shipid'));
                                $this->order_contents['ship_method'] = str_replace("_", " ", $this->input->post('shipid'));
                                $result1 = $this->user_model->order($this->order_contents);
                                if ($usertype == 1 || $usertype == 3 || $usertype == 5 || $usertype == 7)
                                {
                                    $savecourse = $course;
                                }
                                else
                                {
                                    $savecourse = $this->input->post('course');
                                    if ($this->input->post('subcourse'))
                                    {
                                        $subcourseid = $this->input->post('subcourse');
                                    }
                                    else
                                    {
                                        $subcourseid = '';
                                    }
                                    if ($this->input->post('course_b'))
                                    {
                                        $course_o = $this->input->post('course_b');
                                    }
                                    else
                                    {
                                        $course_o = '';
                                    }
                                }

                                $this->course_contents = array(
                                    "course" => $savecourse,
                                    "subcourse" => $subcourseid,
                                    "course_o" => $course_o,
                                    "userid" => $result,
                                    "orderid" => $result1,
                                    "enrolled_date" => $this->order_contents['orderdate']
                                );
                                $result2 = $this->user_model->usercourse($this->course_contents);
                                //$this->_init_user_ship();

                                $this->_init_recipient();

                                $courseDetails = $this->user_model->get_course_details($this->course_contents);
                                $course_weight = $courseDetails['course_weight'];
                                $course_amount = $courseDetails['course_amount'];
                                $arrCourseDetails = $courseDetails['arrCourseDetails'];
                                $this->_init_package($courseDetails);

                                //$course_weight	=	$this->user_model->get_courseweight($this->course_contents);
                                //$this->ship_contents['courseweight'] = $course_weight;
                                //$ship =  $this->user_model->shipmaterial($this->ship_contents,$this->session->userdata{'admindetails'});

                                $aryOrder = array(
                                    'TotalPackages' => 1,
                                    'PackageType' => 'YOUR_PACKAGING', //FEDEX_10KG_BOX, FEDEX_25KG_BOX, FEDEX_BOX, FEDEX_ENVELOPE, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING
                                    'ServiceType' => $this->input->post('shipid'),
                                    'TermsOfSaleType' => "DDU", #    DDU/DDP
                                    'DropoffType' => 'REGULAR_PICKUP'         // BUSINESS_SERVICE_CENTER, DROP_BOX, REGULAR_PICKUP, REQUEST_COURIER, STATION
                                    //'TotalWeight' => array('Value' => 50.0, 'Units' => 'LB'), // valid values LB and KG
                                );
//                                                                        p($aryOrder);
//                                                                        p($this->aryRecipient);
//                                                                        p($this->realPackages);
//                                                                        echo $course_amount;
//                                                                        echo $course_weight;exit;

                                $ship = setShipment($aryOrder, $this->aryRecipient, $this->realPackages, $course_amount, $course_weight);


                                $this->_int_user_mail($this->course_contents);
                                $this->order_updates = array();
                                if ($ship != 'error')
                                {

                                    /* $this->order_updates =array(
                                      "trackingno" => $ship[29],
                                      "label_path" => $ship['label'],
                                      "status" => 'S'
                                      ); */
                                    $this->order_updates = array(
                                        "trackingno" => $ship['trackingno'],
                                        "label_path" => $ship['label'],
                                        "status" => 'S'
                                    );
                                    $orderid = $result1;
                                    $this->user_model->updateorder($this->order_updates, $orderid);

                                    //$redirect_action = "admin_user/list_user_details/".base64_encode('Registration Completed Successfully');
                                    $redirect_action = 'admin_user/list_user_details';
                                    $this->session->set_flashdata('success', "Registration Completed Successfully");
                                }
                                else
                                {
                                    //$redirect_action = "admin_user/list_user_details/".base64_encode('Registration Completed Successfully administrator will reship it');
                                    $redirect_action = 'admin_user/list_user_details';

                                    $this->order_updates = '';
                                    $this->session->set_flashdata('success', "Registration Completed Successfully administrator will reship it");
                                    $this->user_model->send_mailto_admin($this->mail_contents, $this->order_contents, $this->session->userdata{'admindetails'}, $this->order_updates, $usertype);
                                }

                                $this->user_model->send_mailto_user($this->mail_contents, $this->order_contents, $this->order_updates, 'admin', $usertype);
                                //	$this->user_model->send_mailto_admin($this->mail_contents,$this->order_contents,$this->session->userdata{'admindetails'},$this->order_updates);
                                $this->_init_empty_user_session_details();
                                redirect($redirect_action);
                            }
                        }
                        else if ($this->input->post('need_ship') == 'no' && $this->input->post('need_payment') == 'yes')
                        {

                            //init payment details
                            $this->_init_user_paymentdetails($state[0]['state']);

                            $data['payment'] = $this->user_model->payment($this->payment_contents);
                            if ("SUCCESS" == strtoupper($data['payment']["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($data['payment']["ACK"]))
                            {
                                $redirect_action = "reg_result_success";

                                /**
                                 * paymentlog
                                 * */
                                $status = $data['payment']["ACK"];
                                $this->_init_payment_log($name, $emailid, $status, $course_name);
                                $this->user_model->paymentlog($this->payment_log);
                                /*                                 * ** */
                                $this->_init_user_registration_change($data['payment']["TRANSACTIONID"]);
                                //New package update
                                $this->user_contents["sales_new_package"] = $new_package;
                                $result = $this->user_model->userregistration($this->user_contents);
                                //$this->_user_forum_data();
                                //$result_forum = $this->user_model->adduser_forum($this->user_forum_contents);
                                if ($result > 0)
                                {
                                    
                                    $this->_update_trial_account($this->session->userdata('emailid'), $result);//if user have trial account
                                    
                                    $this->order_contents['userid'] = $result;
                                    $this->order_contents['ship_method'] = 'Admin';
                                    $result1 = $this->user_model->order($this->order_contents);
                                    if ($usertype == 1 || $usertype == 3 || $usertype == 5 || $usertype == 7)
                                    {
                                        $savecourse = $course;
                                    }
                                    else
                                    {
                                        $savecourse = $this->input->post('course');
                                        if ($this->input->post('subcourse'))
                                        {
                                            $subcourseid = $this->input->post('subcourse');
                                        }
                                        else
                                        {
                                            $subcourseid = '';
                                        }
                                        if ($this->input->post('course_b'))
                                        {
                                            $course_o = $this->input->post('course_b');
                                        }
                                        else
                                        {
                                            $course_o = '';
                                        }
                                    }
                                    $order_date = $this->order_contents['orderdate'];// current date
                                    $effective_time = strtotime(date("Y-m-d", strtotime($order_date)) . " +17 day");
                                    $effective_date = date('Y-m-d', $effective_time);

                                    if ($this->session->userdata('course_usertype') == 1 || $this->session->userdata('course_usertype') == 3)
                                    {
                                        $data['all_course'] = $this->common_model->getCourseweight();
                                        foreach ($data['all_course'] as $packagecourse)
                                        {
                                            $broker_package[] = $packagecourse->id;
                                        }
                                        $this->course_contents = array(
                                            "course" => $broker_package,
                                            "subcourse" => $subcourseid,
                                            "course_o" => $course_o,
                                            "userid" => $result,
                                            "orderid" => $result1,
                                            "enrolled_date" => $this->order_contents['orderdate'],
                                            "delivered_date" => $this->order_contents['orderdate'],
                                            "effective_date" => $effective_date
                                        );
                                    }
                                    else
                                    {
                                        $this->course_contents = array(
                                            "course" => $savecourse,
                                            "subcourse" => $subcourseid,
                                            "course_o" => $course_o,
                                            "userid" => $result,
                                            "orderid" => $result1,
                                            "enrolled_date" => $this->order_contents['orderdate'],
                                            "delivered_date" => $this->order_contents['orderdate'],
                                            "effective_date" => $effective_date
                                        );
                                    }
                                    $result2 = $this->admin_user_model->usercourse_admin($this->course_contents);
                                    /* $this->_init_user_ship();
                                      $course_weight	=	$this->user_model->get_courseweight($this->course_contents);
                                      $this->ship_contents['courseweight'] = $course_weight;
                                      $ship =  $this->user_model->shipmaterial($this->ship_contents,$this->session->userdata{'admindetails'}); */
                                    $this->_int_user_mail($this->course_contents);
                                    $this->order_updates = array();


                                    $this->order_updates = array(
                                        "trackingno" => '',
                                        "status" => 'C'
                                    );
                                    $orderid = $result1;
                                    $this->user_model->updateorder($this->order_updates, $orderid);

                                    //$redirect_action = "admin_user/list_user_details/".base64_encode('Registration Completed Successfully');
                                    $redirect_action = 'admin_user/list_user_details';




                                    $this->order_updates = '';
                                    $this->session->set_flashdata('success', "Registration Completed Successfully");
                                    //$this->user_model->send_mailto_admin($this->mail_contents,$this->order_contents,$this->session->userdata{'admindetails'},$this->order_updates);


                                    $this->user_model->send_mailto_user($this->mail_contents, $this->order_contents, $this->order_updates, 'admin', $usertype, 'no');
                                    //	$this->user_model->send_mailto_admin($this->mail_contents,$this->order_contents,$this->session->userdata{'admindetails'},$this->order_updates);
                                    $this->_init_empty_user_session_details();
                                    redirect($redirect_action);
                                }
                            }
                            else
                            {

                                $this->gen_contents["msg"] = "Payment Transaction Failed " . urldecode($data['payment']['L_LONGMESSAGE0']);
                                $this->_int_user_register_course();
                                /**
                                 * paymentlog
                                 * */
                                $status = urldecode($data['payment']['L_LONGMESSAGE0']);
                                $this->_init_payment_log($name, $emailid, $status, $course_name);
                                $this->user_model->paymentlog($this->payment_log);
                                /*                                 * end * */
                                //$this->_int_user_register_course();//die('ff');
                            }
                        }
                        else
                        {
                            $this->_init_user_registration_nopayment_change('');
                            //New package update
                            $this->user_contents["sales_new_package"] = $new_package;
                            $result = $this->user_model->userregistration($this->user_contents);
                            //$this->_user_forum_data();
                            //$result_forum = $this->user_model->adduser_forum($this->user_forum_contents);
                            if ($result > 0)
                            {
                                $this->_update_trial_account($this->session->userdata('emailid'), $result);//if user have trial account
                                
                                $this->order_contents['userid'] = $result;
                                $this->order_contents['ship_method'] = 'Admin';
                                $result1 = $this->user_model->order($this->order_contents);

                                if ($usertype == 1 || $usertype == 3 || $usertype == 5 || $usertype == 7)
                                {
                                    $savecourse = $course;
                                }
                                else
                                {
                                    $savecourse = $this->input->post('course');
                                    if ($this->input->post('subcourse'))
                                    {
                                        $subcourseid = $this->input->post('subcourse');
                                    }
                                    else
                                    {
                                        $subcourseid = '';
                                    }
                                    if ($this->input->post('course_b'))
                                    {
                                        $course_o = $this->input->post('course_b');
                                    }
                                    else
                                    {
                                        $course_o = '';
                                    }
                                }
                                $order_date = $this->order_contents['orderdate'];// current date
                                $effective_time = strtotime(date("Y-m-d", strtotime($order_date)) . " +17 day");
                                $effective_date = date('Y-m-d', $effective_time);
                                $this->course_contents = array(
                                    "course" => $savecourse,
                                    "subcourse" => $subcourseid,
                                    "course_o" => $course_o,
                                    "userid" => $result,
                                    "orderid" => $result1,
                                    "enrolled_date" => $this->order_contents['orderdate'],
                                    "delivered_date" => $this->order_contents['orderdate'],
                                    "effective_date" => $effective_date
                                );
                                $result2 = $this->admin_user_model->usercourse_admin($this->course_contents);
                                $this->_int_user_mail($this->course_contents);
                                $this->order_updates = array();
                                //if($ship !='error'){

                                $this->order_updates = array(
                                    "trackingno" => '',
                                    "status" => 'C'
                                );
                                $orderid = $result1;
                                $this->user_model->updateorder($this->order_updates, $orderid);

                                //$redirect_action = "admin_user/list_user_details/".base64_encode('Registration Completed Successfully');
                                $redirect_action = 'admin_user/list_user_details';
                                $this->session->set_flashdata('success', "Registration Completed Successfully");

                                //	}

                                $this->user_model->send_mailto_user($this->mail_contents, $this->order_contents, $this->order_updates, 'admin', $usertype, 'no');
                                //	$this->user_model->send_mailto_admin($this->mail_contents,$this->order_contents,$this->session->userdata{'admindetails'},$this->order_updates);

                                $this->_init_empty_user_session_details();
                                redirect($redirect_action);
                            }
                        }
                    }
                    else
                    {
                        exit;
                        $this->gen_contents["msg"] = "Fill Required Fields";
                        $this->_int_user_register_course();
                    }
                }
                else
                {
                    $this->gen_contents["msg"] = "Failed to process please try again ";
                    $this->_int_user_register_course();
                }
            }
            else
            {
                redirect("admin_register/register");
            }
        }

/**
         * Added function init recepient
         * Created on 14th May 2013
         * Developer : sam@rainconcert.in
         */
        function _init_recipient ()
        {
            $this->aryRecipient = array(
                'Contact' => array(
                    'PersonName' => $this->session->userdata('firstname') . " " . $this->session->userdata('lastname'),
                    //'CompanyName' => 'Company Name',
                    'PhoneNumber' => $this->input->post('bphone')
                ),
                'Address' => array(
                    'StreetLines' => $this->input->post('s_address').", ".$this->session->userdata('unit_number'),
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
        function _init_package ($courseDetails)
        {
            $package_weight = $courseDetails['course_weight'];
            $est_amount = $courseDetails['course_amount'];
            $arrCourseDetails = $courseDetails['arrCourseDetails'];

            $order_id = $this->course_contents['orderid'];

            $packetDescription = "FEDEX Package for order " . $order_id;
            $packageDetails = array(
                0 => array(
                    'weight' => $package_weight,
                    'length' => "20",
                    'width' => "20",
                    'height' => "10",
                    'ItemDescription' => $packetDescription
                )
            );
            $cnt = 0;
            foreach ($arrCourseDetails as $courseDetails)
            {
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
        
        function _update_trial_account($email_id, $user_id){
            $this->load->model('trial_account_model');
            $check_in_trial = $this->trial_account_model->userExists($email_id);
            if($user_id > 0 && $check_in_trial){
                $trial_data = array(
                                    'status'        => 2,
                                    'reg_user_id'   => $user_id,
                                    'updated_at'    => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'))
                                );
                $this->trial_account_model->update($check_in_trial->id, $trial_data);
            }
        }
}

?>