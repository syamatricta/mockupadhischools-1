<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User Controller
 *
 * @package		CodeIgniter
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Shinu
 * @link		http://ahischools.com/userregister/
 */

// ------------------------------------------------------------------------

class Userregister extends Controller {

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
		
	function Userregister(){
		parent::Controller();
						
		$this->load->model('Common_model');
        /*$this->load->model('user_model');
        //$this->config->item ('site_basepath').'system/application/libraries/vbintegration.php';
        require_once $this->config->item('site_basepath').'/system/application/libraries/vbintegration.php';*/
		$this->gen_contents['css'] = array('style.css','dhtmlgoodies_calendar.css','client_style.css');
		$this->gen_contents['js'] = array('userdetails.js','popcalendar.js','client_login.js','validation.js');
		$this->load->model('admin_sitepage_model');
		
	}
	
	function index() {
        $this->register();			
	}
    function _init_registration_rules(){

		$this->form_validation->set_rules('firstname', 'FIRST NAME', 'required|max_length[128]');
		$this->form_validation->set_rules('lastname', 'LAST NAME', 'required|max_length[128]');
		$this->form_validation->set_rules('email', 'EMAIL', 'required|max_length[128]');
        $this->form_validation->set_rules('phonenumber', 'PHONE NUMBER', 'required');
		$this->form_validation->set_rules('upassword', 'PASSWORD', 'required');
		$this->form_validation->set_rules('cupassword', 'CONFIRM PASSWORD', 'required');
		
	}
    function _init_user_regdetails(){
			$this->gen_contents['data']['userdetails'] =array(
					"firstname" 	=> 	$this->Common_model->safe_html($this->input->post('firstname')),
					"lastname"		=> 	$this->Common_model->safe_html($this->input->post('lastname')),
					"phone" 		=> 	$this->Common_model->safe_html($this->input->post('phonenumber')),
					"emailid" 		=> 	$this->Common_model->safe_html($this->input->post('email')),
					"password" 		=> 	md5($this->Common_model->safe_html($this->input->post('upassword')))
				);
	}
	function _int_user_register_step1() {
		if(!empty($_POST)) {
			$this->load->model('userreg_model');
			$this->load->library("form_validation");

			//registration
			$this->_init_registration_rules();
			if($this->form_validation->run() == TRUE) {
				//
				$this->_init_user_regdetails();
				$this->gen_contents['data']['admindetails'] = $this->userreg_model->get_admin();
				
				$check =$this->userreg_model->checkuser($this->input->post('email'));
				// checking the email address already exisitng in vbulletin, uncheck below code before uploading to live
              //  $check_blog =$this->userreg_model->checkuser_blog($this->input->post('email'));          
								
               // if($check <= 0 && $check_blog <= 0 ){
                if($check <= 0 ){
					$this->gen_contents['data']['userregstep1'] =$this->input->post('userregstep1');
					$checkins = $this->userreg_model->userregistration($this->gen_contents['data']['userdetails']);
                    if($checkins > 0){
						$admin = $this->userreg_model->get_admin();
                                                /* Registration in process save mail starts */
                                                $reg_datas = array(
                                                    'reg_ip_address' => $this->input->ip_address() ,
                                                    'reg_first_name' => $this->gen_contents['data']['firstname'],
                                                    'reg_last_name'  => $this->gen_contents['data']['lastname'],
                                                    'reg_email'      => $this->gen_contents['data']['emailid'],
                                                    'reg_phone'      => $this->gen_contents['data']['phone'],
                                                    'reg_date'       => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')),
                                                    'created_by'     => 0,
                                                    'status'         => 1
                                                );
                                                $this->load->model('user_model');
                                                $this->user_model->save_reg_in_process($reg_datas);
                                                /* Registration in process save mail ends */
						$sendmail = $this->userreg_model->send_registration_mail_to_admin($admin[0]['emailid'],$this->gen_contents['data']['userdetails'],'Registration in process');
						//if($sendmail){
							redirect('userregister/registerstep2/'.$checkins);
						/*}else {
							$this->session->set_flashdata('msg', "Can't send registration details to admin");
							redirect('userregister');
						} */                        
                    }
						// step 2
						
				} else {
					if($check > 0){
						$this->gen_contents['msg']= "Email Already Exist";
					} 
					//$this->load->model('user_model');
					$this->load->helper("form");
					$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();
					$this->load->view("client_home_header_new",$this->gen_contents);
					$this->load->view('user/userregister/user_register',$this->gen_contents);
					$this->load->view("client_home_footer_new");

				}
			}
		}
	}
		
	/*******************************Registration*******************************/		
	function register() {

		// regisration step 1
		if($this->input->post('userregstep1') == 1){
			$this-> _int_user_register_step1();
		}
		if(!$_POST || !isset($_POST['userregstep1'])){
        	$this->load->model('user_model');
			$this->load->helper("form");
			$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();
			$this->load->view("client_home_header_new",$this->gen_contents);
			$this->load->view('user/userregister/user_register',$this->gen_contents);
			$this->load->view("client_home_footer_new",$this->gen_contents);
		}

	}
  	function _init_registration_rules2(){
		$this->form_validation->set_rules('forumalias', 'FORUM ALIAS', 'required|min_length[3]|max_length[100]');
		$this->form_validation->set_rules('txtLicencetype', 'LICENCE TYPE', 'required|max_length[128]');
		$this->form_validation->set_rules('txthowhear', 'HOW DID YOU HEAR ABOUT US', 'required');
		$this->form_validation->set_rules('s_address', 'Shipping Address', 'required|max_length[128]');
		$this->form_validation->set_rules('s_state', 'Shipping Address State', 'required');
		$this->form_validation->set_rules('s_country', 'Shipping Address Country', 'required');
		$this->form_validation->set_rules('s_city', 'Shipping Address City', 'required');
		$this->form_validation->set_rules('s_zipcode', 'Shipping Address Zip code', 'required');
		$this->form_validation->set_rules('b_address', 'Billing Address', 'required|max_length[128]');
		$this->form_validation->set_rules('b_state', 'Billing Address State', 'required|max_length[128]');
		$this->form_validation->set_rules('b_country', 'Billing Address Country', 'required|max_length[128]');
		$this->form_validation->set_rules('b_city', 'Billing Address City', 'required|max_length[128]');
		$this->form_validation->set_rules('b_zipcode', 'Billing Address Zipcode', 'required|max_length[128]');
		$this->form_validation->set_rules('txtSearchengine');
		$this->form_validation->set_rules('txtREO');
		
	}
    function _init_user_regdetails2(){
        $typ='';
        if($this->Common_model->safe_html($this->input->post('txtLicencetype'))=='Sales') $typ='S';
        if($this->Common_model->safe_html($this->input->post('txtLicencetype'))=='Broker') $typ='B';
		$this->gen_contents['data']['userdetails2'] =array(
				"forum_alias" 	=> 	$this->Common_model->safe_html($this->input->post('forumalias')),
				"licensetype"	=> 	$typ,
				"unit_number"	=> 	$this->Common_model->safe_html($this->input->post('unitnumber')),
				"howhear" 		=> 	$this->Common_model->safe_html($this->input->post('txthowhear')),
                "reason" 		=> 	($this->Common_model->safe_html($this->input->post('txthowhear'))=='Search engine')?$this->Common_model->safe_html($this->input->post('txtSearchengine')) :$this->Common_model->safe_html($this->input->post('txtREO')),
                "b_address" 	=> 	$this->Common_model->safe_html($this->input->post('b_address')),
				"b_country" 	=> 	$this->Common_model->safe_html($this->input->post('b_country')),
				"b_state" 		=> 	$this->Common_model->safe_html($this->input->post('b_state')),
				"b_city" 		=> 	$this->Common_model->safe_html($this->input->post('b_city')),
				"b_zipcode" 	=> 	$this->Common_model->safe_html($this->input->post('b_zipcode')),
				"s_address" 	=> 	$this->Common_model->safe_html($this->input->post('s_address')),
				"s_country" 	=>	$this->Common_model->safe_html($this->input->post('s_country')),
				"s_state" 		=> 	$this->Common_model->safe_html($this->input->post('s_state')),
				"s_city" 		=> 	$this->Common_model->safe_html($this->input->post('s_city')),
				"s_zipcode" 	=> 	$this->Common_model->safe_html($this->input->post('s_zipcode'))
				);
	}
    function _int_user_register_step2($usid=0) {
		if(!empty($_POST)) {
			$this->load->model('userreg_model');
			$this->load->library("form_validation");

			//registration
			$this->_init_registration_rules2();
			if($this->form_validation->run() == TRUE) {
				$this->_init_user_regdetails2();
				$this->gen_contents['data']['admindetails'] = $this->userreg_model->get_admin();
				$check_forumalias = $this->userreg_model->checkuser_forumalias($this->input->post('forumalias'));
			    //if($check_forumalias<=0){
					$this->gen_contents['data']['userregstep2'] =$this->input->post('userregstep1');
					$check =$this->userreg_model->updateuserreg($this->gen_contents['data']['userdetails2'],$usid);
					// step 3
					redirect('userregister/registerstep3/'.$usid);
				/*} else {
					if($check_forumalias > 0){
						$this->gen_contents['msg']= "Forum Alias Already Exist";
					}*/
						
					$this->load->helper("form");
					$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();
					$this->load->view("client_home_header_new",$this->gen_contents);
					$this->gen_contents['state'] = $this->userreg_model->get_state();
					$this->load->view('user/userregister/user_register_step2',$this->gen_contents);
	                $this->load->view("client_home_footer_new",$this->gen_contents); 
				}		
			}


		

	}

	function registerstep2() {
		$this->gen_contents['usid']=$this->uri->segment(3);
		// regisration step 1
		if($this->input->post('userregstep1') == 2){
			$this-> _int_user_register_step2($this->gen_contents['usid']);
		}
		if(!$_POST || !isset($_POST['userregstep2'])){
			$this->load->model('userreg_model');
			$this->load->helper("form");
			$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();
			$this->load->view("client_home_header_new",$this->gen_contents);
			$this->gen_contents['state'] = $this->userreg_model->get_state();
			$this->load->view('user/userregister/user_register_step2',$this->gen_contents);
			$this->load->view("client_home_footer_new",$this->gen_contents);
		}
	}
	function _init_registration_rules3(){

			$this->form_validation->set_rules('txtREP', 'Pick your package: Real Estate Principles classes most often', 'required');
			$this->form_validation->set_rules('txtREPmf', 'Live crash course: Real Estate Principles classes most often', 'required');
			

		}
                 function _init_user_regdetails3(){
                                
				$this->gen_contents['data']['userdetails3'] =array(
						"REP" 	        => 	$this->Common_model->safe_html($this->input->post('txtREP')),
                                                "agree1" 	=> 	$this->Common_model->safe_html($this->input->post('rdbagree1')),
						"REPmf"		=> 	$this->Common_model->safe_html($this->input->post('txtREPmf')),
                                                "agree2" 	=> 	$this->Common_model->safe_html($this->input->post('rdbagree2')),
                                                "agree3" 	=> 	$this->Common_model->safe_html($this->input->post('rdbagree3')),
						);
		}
                 function _int_user_register_step3($usid=0) {

			if(!empty($_POST)) {
						$this->load->model('userreg_model');
						$this->load->library("form_validation");

						//registration
						$this->_init_registration_rules3();
						if($this->form_validation->run() == TRUE) {
							//
							$this->_init_user_regdetails3();
							$this->gen_contents['data']['admindetails'] = $this->userreg_model->get_admin();
							

							/*if ( !( isset($captcha_code) && isset ($captcha_word) &&  0 == strcmp ($captcha_code, $captcha_word) ) )	{


							} else {*/

								//$check =$this->userreg_model->checkuser($this->input->post('email'));
                                                                //$check_blog =$this->user_model->checkuser_blog($this->input->post('email'));
                                                                //$check_forumalias = $this->userreg_model->checkuser_forumalias($this->input->post('forumalias'));
								//if($check<=0 && $check_blog<=0 && $check_forumalias<=0 ){
                                                               // if($check_forumalias<=0){
									$this->gen_contents['data']['userregstep2'] =$this->input->post('userregstep1');
									//$this->session->set_userdata ($this->gen_contents['data']);
                                                                       // print_r($this->gen_contents['data']['userdetails3']);
                                                                        $check =$this->userreg_model->updateuserreg($this->gen_contents['data']['userdetails3'],$usid);
									// step 3
									redirect('userregister/registersuccess/'.$usid);
								//} else {
										/*if($check > 0){
											$this->gen_contents['msg']= "Email Already Exist";
										} else if($check_forumalias > 0){
											$this->gen_contents['msg']= "Forum Alias Already Exist";
										}*/

										//$this->load->model('user_model');
										//$this->load->helper("form");
										////$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();
										//$this->load->view("client_common_header_main",$this->gen_contents);
										//$captcha                     = $this->user_model->generate_captcha ();
										//$this->session->set_userdata ("captcha_word", $captcha['word']);

										//$this->gen_contents['captcha_details']     = $captcha;
										//$this->gen_contents['state'] = $this->user_model->get_state();
										//$this->load->view('user/userregister/user_register_step3',$this->gen_contents);
			                                                      //  $this->load->view("client_common_footer_main",$this->gen_contents);

								//}
							//}
						}


				}

		}

                function registerstep3() {
                        $this->gen_contents['usid']=$this->uri->segment(3);
			// regisration step 1
			if($this->input->post('userregstep1') == 3){
				$this-> _int_user_register_step3($this->gen_contents['usid']);
			}
//var_dump($_POST);
			if(!$_POST || !isset($_POST['userregstep1'])){

                        //echo "helo";
			$this->load->model('user_model');
			$this->load->helper("form");
			$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();
			$this->load->view("client_home_header_new",$this->gen_contents);
			///$captcha                     = $this->user_model->generate_captcha ();
			//$this->session->set_userdata ("captcha_word", $captcha['word']);

			//$this->gen_contents['captcha_details']     = $captcha;
			//$this->gen_contents['state'] = $this->user_model->get_state();
			$this->load->view('user/userregister/user_register_step3',$this->gen_contents);
			$this->load->view("client_home_footer_new",$this->gen_contents);
			}

		}
                function registersuccess() {
                        $this->gen_contents['usid']=$this->uri->segment(3);
			// regisration step 1
			// $this-> _int_user_register_step3($this->gen_contents['usid']);
			
			//$this->load->model('user_model');
			//$this->load->helper("form");
			$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();
			$this->load->view("client_home_header_new",$this->gen_contents);
			///$captcha                     = $this->user_model->generate_captcha ();
			//$this->session->set_userdata ("captcha_word", $captcha['word']);

			//$this->gen_contents['captcha_details']     = $captcha;
			//$this->gen_contents['state'] = $this->user_model->get_state();
			$this->load->view('user/userregister/user_register_rsuccess',$this->gen_contents);
			$this->load->view("client_home_footer_new",$this->gen_contents);
			

		}
		
		
}
?>
