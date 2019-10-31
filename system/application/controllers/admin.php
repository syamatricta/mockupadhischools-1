<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Admin Controller
 *
 * @package		CodeIgniter
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Manu
 * @link		http://ahischools.com/admin/
 */

// ------------------------------------------------------------------------

class Admin extends Controller {
	
	/**
	 * Admin username
	 *
	 * @var string
	 */
	var $username = "";
	
	/**
	 * Admin password
	 *
	 * @var string
	 */
	var $password = "";


	
	/**
	 * General contents
	 *
	 * @var Array
	 */
	var $gen_contents	=	array();
	
	/**
	 * Admin constructor
	 * 
	 */
	function Admin() {
		
		parent::Controller();
		
		$this->load->helper("form");
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('authentication');
		$this->load->model('Common_model');
		$this->load->model('admin_model');
		$this->gen_contents["css"]	=	array('admin_style.css');
		$this->gen_contents["js"]	=	array('admin.js','prototype.js');
                //error_reporting( E_ALL );
                //ini_set('display_errors',1);

	}
	
	/**
	 * default page
	 *
	 */
	function index() {
            if($this->authentication->logged_in('admin')){
                redirect("admin/home");
            }else if(c('admin_login_url') == $this->uri->segment(1)){
                redirect(c('admin_login_url'));	
            }else{
                redirect('/');
            }

	}
	
	/**
	 * show the login page for admin
	 *
	 */
	function login() {
                
		if($this->authentication->logged_in("admin"))
			redirect("admin/home");	
                
                if(c('admin_login_url') != $this->uri->segment(1)){
                    redirect("/");
                }
		 // var_dump($_POST);
                   // print_r($_POST);
		//if(!empty($_POST)) {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {  
                        
                        /* Update Reinstate Expired Users Starts */
                        $this->authentication->reinstate_expired_update(); 
                        /* Update Reinstate Expired Users Ends */
                        
			$this->load->library('form_validation');	
			$this->form_validation->set_rules('username', 'USERNAME', 'required|max_length[50]');
			$this->form_validation->set_rules('password', 'PASSWORD', 'required|max_length[20]');
                            $this->form_validation->set_rules('captcha_code', 'VERIFICATION CODE', 'required|max_length[20]');
		
			if ($this->form_validation->run() == FALSE) {// form validation
				$this->gen_contents['msg']='Failed';
			} else {						
			
				$this->_init_user_details();
				$login_details['username']	=	$this->username;
				$login_details['password']	=	$this->password;
				if($this->captcha_code == $this->session->userdata ("captcha_word")){ 
                                        if($login_result = $this->authentication->process_admin_login($login_details)){ 
                                                /*if(ENVIRONMENT == 'production'){
                                                    $this->session->set_userdata ("login_result", (array)$login_result);
                                                    redirect('admin/credential_list');
                                                }else{
                                                    redirect('admin/home');
                                                }*/
                                                
                                                //Excluded some usernames, to avoid otp process for testing
                                                $otp_excluded_usernames = $this->config->item('otp_excluded_usernames');
                                                if(count($otp_excluded_usernames) > 0 && in_array($login_result->USERNAME, $otp_excluded_usernames)){
                                                    $this->authentication->process_admin_otp($login_result);
                                                    redirect('admin/home');
                                                }else{
                                                    $this->session->set_userdata ("login_result", (array)$login_result);
                                                    redirect('admin/credential_list');
                                                }
                                                
                                        }
                                        else{  
                                                $status = 0;
                                                $this->admin_model->save_login($this->username,$status, array());
                                                $this->session->set_flashdata('msg', 'Invalid Username or Password');
                                                redirect(c('admin_login_url'));
                                                
                                        }
                                    }
                                    else {
                                            $this->session->set_flashdata('msg', 'Verification code mismatch');
                                                redirect(c('admin_login_url'));
                                    }
			}
		}
                
                    $this->load->model('user_model');
                    $captcha                     = $this->user_model->generate_captcha ();
		$this->session->set_userdata ("captcha_word", $captcha['word']);

		$this->gen_contents['captcha_details']     = $captcha;
		$this->load->view("admin_header",$this->gen_contents);						
		$this->load->view('admin/login');
		$this->load->view("admin_footer");				
	}
	
	function _init_user_details() {
		$this->username = $this->Common_model->safe_html($this->input->post("username"));
		$this->password = $this->Common_model->safe_html($this->input->post("password"));
                    $this->captcha_code = $this->Common_model->safe_html($this->input->post("captcha_code"));
	}
	/**
	 * for admin login process
	 *
	 */
	function loginSubmit(){

		if($this->authentication->logged_in("admin"))
			redirect("admin/home");
		
		
	}
        
        /**
	 * After successful login admin enter in to the otp email list
	 *
	 */
	function repeat_credential(){
                
            if($this->session->userdata('login_result')){
                
                $datas = $this->session->userdata('login_final');
                $otp_email = $datas['otp_email'];
                
                $login_result = $this->session->userdata('login_result');
                        
                $object = new stdClass();
                        
                foreach ($login_result as $key => $value)
                {
                    $object->$key = $value;
                }
                $login_result = $object;

                if($otp_email_details = $this->admin_model->get_otp_emails($otp_email,$login_result->USERID,TRUE)){
                     $otp_email_id  = $otp_email_details[0]['otp_email_id'];
                     $otp_name  = $otp_email_details[0]['name'];

                     if($otp_history_id = $this->admin_model->admin_otp_email($login_result,$otp_email_id, $otp_email,1)){

                         $data = array(
                            'login_result'   => $login_result,
                            'otp_email_id'   => $otp_email_id,
                            'otp_email'      => $otp_email,
                            'otp_history_id' => $otp_history_id,
                            'otp_name'       => $otp_name
                         );

                         $this->session->unset_userdata('login_final');
                         $this->session->set_userdata('login_final',$data);

                         redirect('admin/credential_check');
                     }
                }
                
            } else {
                if($this->authentication->logged_in())
			redirect("admin/home");
		else
			redirect(c('admin_login_url'));	
            }  
	}
        
        /**
	 * After successful login admin enter in to the otp email list
	 *
	 */
	function credential_list(){
                
            if($this->session->userdata('login_result')){
		if($_SERVER['REQUEST_METHOD'] == 'POST' && array_key_exists('otp_credential', $_POST)) {
                    
                    $this->load->library('form_validation');	
                    $this->gen_contents['msg'] = "";
                    $this->form_validation->set_rules('otp_credential', 'Credential', 'required');
			
                    if ($this->form_validation->run() == FALSE) {               // form validation
                            $this->gen_contents['msg']   = 'Failed';
                    } else {
                        $otp_email = trim($_POST["otp_credential"]);
                        $login_result = $this->session->userdata('login_result');
                        
                        $object = new stdClass();
                        
                        foreach ($login_result as $key => $value)
                        {
                            $object->$key = $value;
                        }
                        $login_result = $object;

                        if($otp_email_details = $this->admin_model->get_otp_emails($otp_email,$login_result->USERID,TRUE)){
                             $otp_email_id  = $otp_email_details[0]['otp_email_id'];
                             $otp_name  = $otp_email_details[0]['name'];
                             
                             if($otp_history_id = $this->admin_model->admin_otp_email($login_result,$otp_email_id, $otp_email)){
                                 
                                 $data = array(
                                    'login_result'   => $login_result,
                                    'otp_email_id'   => $otp_email_id,
                                    'otp_email'      => $otp_email,
                                    'otp_history_id' => $otp_history_id,
                                    'otp_name'       => $otp_name
                                 );
                                 
                                 $this->session->set_userdata('login_final',$data);
                                 
                                 redirect('admin/credential_check');
                             }
                        } else {
                            //$this->session->set_flashdata('msg','Invalid Credential');
                            $this->gen_contents['msg']   = 'Invalid Credential';
                        }
                    }
                }
                
                $this->load->view("admin_header",$this->gen_contents);						
                $this->load->view('admin/otp_email_list');
                $this->load->view("admin_footer");
                
            } else {
                if($this->authentication->logged_in()){
                    redirect("admin/home");
                }else{
                    redirect('/');	
                }
            }  
	}
        
        /**
	 * After successful login admin enter in to the otp check
	 *
	 */
	function credential_check(){
            
            if($this->session->userdata('login_final')){
		if($_SERVER['REQUEST_METHOD'] == 'POST' && array_key_exists('otp', $_POST)) {
                    
                    $this->load->library('form_validation');	
                    $this->gen_contents['msg']   = '';
                    $this->form_validation->set_rules('otp', 'Otp', 'required');
                    
                    if ($this->form_validation->run() == FALSE) {               // form validation
                            $this->gen_contents['msg']   = 'Failed';
                    } else {
                        $otp  = $_POST["otp"];
                        $data = $this->session->userdata('login_final');
                        
                        if($this->admin_model->admin_otp($data,$otp)){
                            if($this->admin_model->admin_otp_expiry($data,$otp)){
                                $this->authentication->process_admin_otp($data['login_result']);
                                $this->admin_model->save_login($data['login_result']->USERNAME,1,$data);
                                $this->session->unset_userdata('login_final');
                                $this->session->unset_userdata('login_result');
                                redirect('admin/home');
                            } else {
                                //$this->session->set_flashdata('msg','Code Expired');
                                $this->gen_contents['msg']   = 'Code Expired';
                            }
                        }else {
                                //$this->session->set_flashdata('msg','Incorrect Code');
                                $this->gen_contents['msg']   = 'Incorrect Code';
                        }
                    }
                    
                }
                
                $this->load->view("admin_header",$this->gen_contents);						
                $this->load->view('admin/otp_check');
                $this->load->view("admin_footer");
            } else {
                if($this->authentication->logged_in()){
                    redirect("admin/home");
                }else{
                    redirect('/');	
                }
            }
		
	}
	
	/**
	 * After successfull login admin enter in to the homepage
	 *
	 */
	function home(){
		if(!$this->authentication->logged_in("admin")){
                    redirect(c('admin_login_url'));
                }else if(1 == $this->session->userdata ('ADMINTYPE')) {
                    redirect("admin/dashboard");
                }else if(3 == $this->session->userdata ('ADMINTYPE')) {
                    $this->sub_manager();
                }else{
                    if(2 == $this->session->userdata ('ADMINTYPE') && $this->authentication->check_permission_redirect('sub_permission_1', FALSE)){
                        redirect("admin_register/list_user_details");
                    }else{
                        $this->load->view("admin_header",$this->gen_contents);						
                        $this->load->view('admin/home');
                        $this->load->view("admin_footer");
                    }
                    
                }
		
	}
			
	/**
	 * logout for admin
	 *
	 */
	function logout (){
		
		$this->authentication->logout ();
		redirect(c('admin_login_url'));
		
	}
	/**
	 * change password for admin
	 */
		function change_password(){
		$this->load->helper("form");
		if(!$this->authentication->logged_in("admin"))
			redirect(c('admin_login_url'));
		if($this->authentication->logged_in ("admin") === "sub") 
                    {
                        redirect("admin/noaccess");
                        exit;
                    }	
		$this->gen_contents['page_title']='Change Password ';
		if(!empty($_POST))	{
			$this->load->library('form_validation');
			$this->form_validation->set_rules ('old_password', 'Password', 'required');
			$this->form_validation->set_rules('new_password', 'Password', 'required|matches[confirm_password]');
			$this->form_validation->set_rules('confirm_password', 'Confirmpassword', 'required');
			
			if (!$this->form_validation->run() == FALSE) {// form validation
						
				$this->_init_change_password_details();	
				$userid		=	$this->session->userdata ('USERID');
				$email_id	=	$this->session->userdata ('EMAIL');
				if($this->admin_model->confirm_password(md5($this->old_password),$userid)){

					if($this->admin_model->change_password($email_id,$userid,md5($this->new_password))){
						
						$this->session->set_flashdata('success', "Password changed successfully");
						redirect('admin/change_password/');
						
					}else{
						$this->session->set_flashdata('error', "Request Failed");
						redirect('admin/change_password/');
					}
				}
				else{
					
					$this->session->set_flashdata('error', 'Please enter your correct Current Password');
					redirect('admin/change_password/');
				}
	
			}
			
		}
				
		$this->load->view("admin_header",$this->gen_contents);						
		$this->load->view('admin/admin_change_password');
		$this->load->view("admin_footer");
	}
	
	/**
	 * get the values from the POST and Input it into safe_html
	 *
	 */
	function _init_change_password_details() {
		
		$this->old_password = $this->Common_model->safe_html($this->input->post("old_password"));
		$this->new_password = $this->Common_model->safe_html($this->input->post("new_password"));
		
	}
            
	function noaccess() {
		if($this->authentication->logged_in("admin"))
		{
			$this->session->set_flashdata('success', $this->session->flashdata("success"));
			redirect("admin/home");
		}
		else
		{
			redirect(c('admin_login_url'));
		}
		$this->load->view("admin_header",$this->gen_contents);						
		$this->load->view('admin/noaccess');
		$this->load->view("admin_footer");
	}
	
	//Dashboard
	function dashboard(){
            if($this->authentication->logged_in("admin") && 1 == $this->session->userdata ('ADMINTYPE')) {
                $this->gen_contents['js'] 				= array_merge($this->gen_contents['js'], array('dashboard.js', 'popcalendar.js', 'event.simulate.js'));
                $this->gen_contents['css'] 				= array_merge($this->gen_contents['css'], array('dashboard.css' ,'dhtmlgoodies_calendar.css'));
                $start_date             = convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
                $end_date               = convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
                $ga_profile_id          = 'ga:85101887';//$this->config->item('ga_profile_id');
                $this->gen_contents['selected_dashboard_item']  = c('default_dashboard_tab');
                if('' != $this->input->post('selected_section')){
                    $start_date             = ('' != $this->input->post('date_from')) ? formatDate_search($this->input->post('date_from')) : $start_date;
                    $end_date               = ('' != $this->input->post('date_to')) ? formatDate_search($this->input->post('date_to')) : $end_date;
                    $this->gen_contents['selected_dashboard_item']  = $this->input->post('selected_section');
                }
                $this->gen_contents['start_date']   = $start_date;
                $this->gen_contents['end_date']     = $end_date;
                $this->user_id		= $this->session->userdata ('USERID');
                $this->load->model('admin_recruiter_model');
                $this->gen_contents['recruiter_mail_count'] = $this->admin_recruiter_model->getRecruiterMailCount();
                
                //reset values
                $this->gen_contents['active_users'] = 0;
                $this->gen_contents['unique_users'] = 0;
                $this->gen_contents['active_user_seperate'] = array('guest' => 0, 'registered' => 0);
                $this->gen_contents['total_passed'] = 0;
                $this->gen_contents['total_failed'] = 0;
                $this->gen_contents['total_unexpected'] = 0;
                $this->gen_contents['total_unexpected_passed'] = 0;
                $this->gen_contents['total_unexpected_failed'] = 0;
                $this->gen_contents['total_ongoing'] = 0;
                
                
                //$this->_google_api_auth();
                //$this->_google_client();
                //$this->_get_dashboard_left_side();
                
                $this->load->view("admin_header", $this->gen_contents);						
                $this->load->view('admin/dashboard/dashboard');
                $this->load->view("admin_footer");
            }else{
                redirect(c('admin_login_url'));
            }
	}
        
        function _google_client_old(){
            set_include_path(c('base_path')."system/application/libraries/src/" . PATH_SEPARATOR . get_include_path());
            require_once 'Google/Client.php';
            require_once 'Google/Service/Analytics.php';

            $client_id      = c('ga_client_id');
            $client_secret  = c('ga_client_secret');
            $redirect_uri   = c('ga_redirect_uri');            
            $this->client = new Google_Client();            
            $this->client->setClientId($client_id);
            $this->client->setClientSecret($client_secret);
            $this->client->setRedirectUri($redirect_uri);
            $this->client->setAccessType('offline');
            $this->client->addScope("https://www.googleapis.com/auth/analytics.readonly", "https://www.googleapis.com/auth/analytics.manage.users.readonly");
            $this->analytics      = new Google_Service_Analytics($this->client);
            $this->ga_profile_id    = 'ga:'.$this->config->item('ga_profile_id');
            $this->ga_hostname_filter = 'ga:hostname=='.c('ga_hostname_filter').';ga:pagePathLevel1!=/uat/';//only from www.adhischools.com domain except uat
        }
        function _google_client(){
            $this->ga_profile_id            = 'ga:'.$this->config->item('ga_profile_id');
            //$this->ga_hostname_filter       = 'ga:hostname=='.c('ga_hostname_filter').';';///ga:pagePathLevel1!=/uat/
            //set_include_path(c('base_path')."third_party/" . PATH_SEPARATOR . get_include_path());
            //require_once c('base_path'). "third_party/" . 'Google/autoload.php';
            set_include_path(c('base_path')."third_party/Google/" . PATH_SEPARATOR . get_include_path());
            //require_once '/home/sreeraj/public_html/adhischools/third_party/Google/src/Google/autoload.php';
            require_once 'src/Google/autoload.php';
            
            
            
            $service_account_email  = c('ga_service_account_email');
            $key_file_location      = c('base_path').'third_party/Google/'.c('ga_key_file');

            // Create and configure a new client object.
            $client = new Google_Client();
            $client->setApplicationName(c('ga_application_name'));
            $this->analytics = new Google_Service_Analytics($client);

            // Read the generated client_secrets.p12 key.
            $key = file_get_contents($key_file_location);
            $cred = new Google_Auth_AssertionCredentials(
                $service_account_email,
                array(Google_Service_Analytics::ANALYTICS_READONLY),
                $key
            );
            $client->setAssertionCredentials($cred);
            if($client->getAuth()->isAccessTokenExpired()) {
              $client->getAuth()->refreshTokenWithAssertion($cred);
            }
        }
        
        function _google_api_auth(){
            $user_id		= $this->session->userdata ('USERID');
            $google_token_str   = $this->admin_model->get_access_token($user_id);
            $refresh_token      = $this->_get_user_refresh_token($google_token_str);
            
            $this->_google_client();

            $query_data = parse_url($_SERVER['REQUEST_URI']);
            $code   = '';
            if(isset($query_data['query'])){
                $code   = str_replace('code=', '', $query_data['query']);
            }
            
            if ('' != $code) {
                $this->client->authenticate($code);
                $google_token_str   = $this->client->getAccessToken();
                $this->admin_model->set_access_token($user_id, $google_token_str);
                $refresh_token      = $this->_get_user_refresh_token($google_token_str);
                $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
                header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
            }
            
        }
        
        function _get_dashboard_left_side_old(){
            //$google_token_str   = $this->admin_model->get_access_token($this->user_id);
            //$refresh_token      = $this->_get_user_refresh_token($google_token_str);
            //$authUrl            = false;
            $this->gen_contents['bro_plat_max'] = 4;
            if ($google_token_str) {
                $this->client->setAccessToken($google_token_str);
                if($this->client->isAccessTokenExpired()){
                    try {
                        $google_token_str   = $this->client->refreshToken($refresh_token);
                    } catch(error $a){
                        print_r($a);
                    }
                    if('' != $google_token_str){
                       $this->admin_model->set_access_token($this->user_id, $google_token_str); 
                       //$this->admin_model->set_access_token($user_id, $google_token_str);
                       $this->client->setAccessToken($google_token_str);
                    }
                    
                }
                try {
                    
                    //Left menu - Unique user count
                    /*$optParams = array('dimensions' => 'rt:medium');
                    $results = $this->analytics->data_realtime->get($this->ga_profile_id, 'rt:activeUsers', $optParams);
                    $active_users   =  $results->getTotalsForAllResults();
                    $this->gen_contents['active_users']  =  (isset($active_users['ga:users'])) ? $active_users['ga:users'] : 0;
                    */
                    
                    $time_span  = c('active_time_span');
                    $active_users   = $this->admin_model->getActiveUserCount(convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')), $time_span);
                    $this->gen_contents['active_users']  =  $active_users;
                    $this->gen_contents['active_user_seperate'] = array('registered' => 0, 'guest' => 0);
                    if($active_users > 0){
                        $this->gen_contents['active_user_seperate']['registered']   = $this->admin_model->getActiveUserCount(convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')), $time_span, 'registered');
                        $this->gen_contents['active_user_seperate']['guest']        = abs($active_users - $this->gen_contents['active_user_seperate']['registered']);
                    }
                    
                    //Left menu - Active user count (real time)
                    $results = $this->analytics->data_ga->get($this->ga_profile_id, $this->gen_contents['start_date'], $this->gen_contents['end_date'], 'ga:users', array('filters' => $this->ga_hostname_filter));
                    $unique_users  =  $results->getTotalsForAllResults();
                    $this->gen_contents['unique_users']  =  (isset($unique_users['ga:users'])) ? $unique_users['ga:users'] : 0;
                    
                    
                    
                    //Unique user(Member and Guest)
                    $this->gen_contents['unique_user_seperate']  =  $this->_splitted_unique_user($this->gen_contents['unique_users']);
                    
                    //Left menu - Browser+browser version count
                    $results = $this->analytics->data_ga->get($this->ga_profile_id, $this->gen_contents['start_date'], $this->gen_contents['end_date'], 'ga:users', array('dimensions' => 'ga:browser,ga:browserVersion', 'start-index' => 1, 'max-results' => $this->gen_contents['bro_plat_max'], 'sort' => '-ga:users'));
                    $this->gen_contents['browser_data']  =  $results->rows;
                    
                    //Left menu - Operating system version count
                    $results = $this->analytics->data_ga->get($this->ga_profile_id, $this->gen_contents['start_date'], $this->gen_contents['end_date'], 'ga:users', array('dimensions' => 'ga:operatingSystem,ga:operatingSystemVersion', 'start-index' => 1, 'max-results' => $this->gen_contents['bro_plat_max'], 'sort' => '-ga:users'));
                    $this->gen_contents['os_data']  =  $results->rows;
                    
                    //LeftMenu - ExamReports
                    $this->gen_contents['total_passed']     = $this->admin_model->get_exam_report('P', $this->gen_contents['start_date'], $this->gen_contents['end_date']);
                    $this->gen_contents['total_failed']     = $this->admin_model->get_exam_report('F', $this->gen_contents['start_date'], $this->gen_contents['end_date']);
                    $this->gen_contents['total_ongoing']    = $this->admin_model->get_exam_report('O', $this->gen_contents['start_date'], $this->gen_contents['end_date']);
                    $this->gen_contents['total_unexpected_passed'] = $this->admin_model->get_exam_report('P',  $this->gen_contents['start_date'], $this->gen_contents['end_date'], 2);
                    $this->gen_contents['total_unexpected_failed'] = $this->admin_model->get_exam_report('F',  $this->gen_contents['start_date'], $this->gen_contents['end_date'], 2);
                   
                    
                    
                } catch (apiServiceException $e) {
                    // Handle API service exceptions.
                    $error = $e->getMessage();                    
                }
            } else {
                $authUrl = $this->client->createAuthUrl();
            }
            $this->gen_contents['google_auth_url']   = $authUrl;
        }
        
        function _get_dashboard_left_side(){
            //$google_token_str   = $this->admin_model->get_access_token($this->user_id);
            //$refresh_token      = $this->_get_user_refresh_token($google_token_str);
            //$authUrl            = false;
            $this->gen_contents['bro_plat_max'] = 4;
                try {
                    
                    //Left menu - Unique user count
                    /*$optParams = array('dimensions' => 'rt:medium');
                    $results = $this->analytics->data_realtime->get($this->ga_profile_id, 'rt:activeUsers', $optParams);
                    $active_users   =  $results->getTotalsForAllResults();
                    $this->gen_contents['active_users']  =  (isset($active_users['ga:users'])) ? $active_users['ga:users'] : 0;
                    */
                    
                    $time_span  = c('active_time_span');
                    $active_users   = $this->admin_model->getActiveUserCount(convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')), $time_span);
                    $this->gen_contents['active_users']  =  $active_users;
                    $this->gen_contents['active_user_seperate'] = array('registered' => 0, 'guest' => 0);
                    if($active_users > 0){
                        $this->gen_contents['active_user_seperate']['registered']   = $this->admin_model->getActiveUserCount(convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')), $time_span, 'registered');
                        $this->gen_contents['active_user_seperate']['guest']        = abs($active_users - $this->gen_contents['active_user_seperate']['registered']);
                    }
                    
                    //Left menu - Active user count (real time)
                    $results = $this->analytics->data_ga->get($this->ga_profile_id, $this->gen_contents['start_date'], $this->gen_contents['end_date'], 'ga:users');
                    $unique_users  =  $results->getTotalsForAllResults();
                    $this->gen_contents['unique_users']  =  (isset($unique_users['ga:users'])) ? $unique_users['ga:users'] : 0;
                    
                    
                    
                    //Unique user(Member and Guest)
                    $this->gen_contents['unique_user_seperate']  =  $this->_splitted_unique_user($this->gen_contents['unique_users']);
                    
                    //Left menu - Browser+browser version count
                    $results = $this->analytics->data_ga->get($this->ga_profile_id, $this->gen_contents['start_date'], $this->gen_contents['end_date'], 'ga:users', array('dimensions' => 'ga:browser,ga:browserVersion', 'start-index' => 1, 'max-results' => $this->gen_contents['bro_plat_max'], 'sort' => '-ga:users'));
                    $this->gen_contents['browser_data']  =  $results->rows;
                    
                    //Left menu - Operating system version count
                    $results = $this->analytics->data_ga->get($this->ga_profile_id, $this->gen_contents['start_date'], $this->gen_contents['end_date'], 'ga:users', array('dimensions' => 'ga:operatingSystem,ga:operatingSystemVersion', 'start-index' => 1, 'max-results' => $this->gen_contents['bro_plat_max'], 'sort' => '-ga:users'));
                    $this->gen_contents['os_data']  =  $results->rows;
                    
                    //LeftMenu - ExamReports
                    $this->gen_contents['total_passed']     = $this->admin_model->get_exam_report('P', $this->gen_contents['start_date'], $this->gen_contents['end_date']);
                    $this->gen_contents['total_failed']     = $this->admin_model->get_exam_report('F', $this->gen_contents['start_date'], $this->gen_contents['end_date']);
                    $this->gen_contents['total_ongoing']    = $this->admin_model->get_exam_report('O', $this->gen_contents['start_date'], $this->gen_contents['end_date']);
                    $this->gen_contents['total_unexpected_passed'] = $this->admin_model->get_exam_report('P',  $this->gen_contents['start_date'], $this->gen_contents['end_date'], 2);
                    $this->gen_contents['total_unexpected_failed'] = $this->admin_model->get_exam_report('F',  $this->gen_contents['start_date'], $this->gen_contents['end_date'], 2);
                   
                    
                    
                } catch (apiServiceException $e) {
                    // Handle API service exceptions.
                    $error = $e->getMessage();                    
                }
        }
        
        function dashboard_item(){
            $start_date             = convert_UTC_to_PST_date(date('Y-m-d'));
            $end_date               = convert_UTC_to_PST_date(date('Y-m-d'));
            
            $selected_item          = $this->input->post('selected_item');
            $this->gen_contents['start_date']     = ('' != $this->input->post('start_date')) ? $this->input->post('start_date') : $start_date;
            $this->gen_contents['end_date']       = ('' != $this->input->post('end_date')) ? $this->input->post('end_date') : $end_date;
            $output = array('success' => 0, 'html' => '', 'message' => 'Unable to process');
            if('browser_platform' == $selected_item){
                $browser_platform_data  = $this->_browser_platform();
                $output['success']      = 1;
                $output['js_variables'] = $browser_platform_data['js_variables'];
                $output['html']         = $browser_platform_data['html'];
            }else if('visitors_analysis' == $selected_item){                
                $browser_platform_data  = $this->_visitors_analysis();
                $output['success']      = 1;
                $output['js_variables'] = $browser_platform_data['js_variables'];
                $output['html']         = $browser_platform_data['html'];
            }elseif('exam_report' == $selected_item){ 
                $exam_report = $this->_exam_report($this->input->post('start_date'), $this->input->post('end_date'));
                $output['success']      = 1;
                $output['html']         =  $exam_report['html'];

            }elseif('user_report' == $selected_item){ 
                $user_report                = $this->_user_report();
                $output['success']          = 1;
                $output['user_pie_object']  = $user_report['user_pie_object'];
                $output['js_variables']     = $user_report['js_variables'];
                $output['html']             = $user_report['html'];
            }elseif('course' == $selected_item){
                $course_report = $this->_course_report($this->input->post('start_date'), $this->input->post('end_date'));
                $output['success']      = 1;
                $output['html']         =  $course_report['html'];
            }elseif('recruiter' == $selected_item){
                $recruiter_report = $this->_recruiter_report($this->input->post('start_date'), $this->input->post('end_date'),'');
                $output['js_variables'] = $recruiter_report['js_variables'];
                $output['success']      = 1;
                $output['html']         = $recruiter_report['html'];
            }
            
            $data['return_value'] = json_encode($output);
            $this->load->view('dsp_show_ajax', $data);
        }
        
        function _recruiter_report($start_date = '', $end_date = '' ,$rec_brokerage = ''){
          
            /* Pie chart - Recruiter data */
            $this->load->model('admin_recruiter_model');
            $rec_first_name = $rec_last_name = $rec_email           =       '';
            $this->gen_contents['recruiter_count']                  =       $this->admin_recruiter_model->qry_recruitermail_details('','',$rec_first_name,$rec_last_name,$rec_email,'', $start_date, $end_date,'count');
            
            /* Pie chart data without brokerage type */
            if(!empty($this->gen_contents['recruiter_count'])){
                
                $recruiter_pie_object                               =       "[['Recruiter', 'Number'],";
                foreach($this->gen_contents['recruiter_count'] as $key => $recruiter_count){
                 //   $recruiter_pie_object                        .=       "['".$recruiter_count['full_name'].'  '.$recruiter_count['brokerage']." ( ".$recruiter_count['count']." )', ".$recruiter_count['count']."],";
                      $recruiter_pie_object                        .=       "['".$recruiter_count['brokerage']." ( ".$recruiter_count['count']." )', ".$recruiter_count['count']."],";
                }
                $recruiter_pie_object = rtrim($recruiter_pie_object, ',').']';
                $data['js_variables']                               =       array('recruiter_pie_object' => $recruiter_pie_object);
                
                /* Get table data with brokerage type*/
                $this->gen_contents['recruiter_data']               =       $this->admin_recruiter_model->qry_recruitermail_details('','',$rec_first_name,$rec_last_name,$rec_email,$rec_brokerage, $start_date, $end_date,'data');
                $this->gen_contents["recruiter_detail"]             =       $this->admin_recruiter_model->get_all_recruiters(); 
                    
                if(!empty($this->gen_contents["recruiter_detail"])){
                    $recruiter_detail = array();
                        foreach($this->gen_contents["recruiter_detail"] as $rec){
                            $recruiter_detail[] = $rec['recruiter_brokerage'];
                        }
                    $this->gen_contents["recruiter_detail"] = array_unique($recruiter_detail);
                }
            } else{
                $this->gen_contents['recruiter_data'] = array();
                $data['js_variables']   = array('recruiter_pie_object' => '');
            }
            
            $this->gen_contents['brokerage'] = $rec_brokerage;
            $data['html'] = $this->load->view('admin/dashboard/_recruiter_report', $this->gen_contents, TRUE);
            
            return $data;
            
        }
        
        function select_recruiter_report_data(){
            $recruiter_report = $this->_recruiter_report($_POST['start_date'], $_POST['end_date'],$_POST['recruiter']);
            $data = json_encode($recruiter_report);
            print $data;
            exit;
        }
        
        function _course_report($start_date, $end_date){
            $gen_contents["page_title"] = "Course";
            $gen_contents['courses'] = $this->admin_model->getCourses();
            $gen_contents['course_count'] = $this->admin_model->get_course_report(5, $start_date, $end_date);
            $gen_contents['course_data'] = $this->admin_model->get_course_report_details(5, $start_date, $end_date);
            $data['html'] = $this->load->view('admin/dashboard/course_report', $gen_contents, TRUE);
            return $data;
        }
        
        function course_detail(){
            $this->load->model('admin_model');
            $course_selected = $this->input->post('course_selected');
            $course_id = $this->input->post('course_id');
            $start_date     = $this->input->post('start_date');
            $end_date       = $this->input->post('end_date');
            //$output['total_result'] = $this->admin_model->get_course_report($course_id, $start_date, $end_date);
            $output['result_details'] = $this->admin_model->get_course_report_details($course_id, $start_date, $end_date);
            $output['total_result'] = count($output['result_details']);
            $output['html'] = $this->load->view('admin/dashboard/course_report_detail', $output, TRUE);
            
            $data['return_value'] = json_encode($output);
            $this->load->view('dsp_show_ajax', $data);
        }
        
        function _exam_report($start_date, $end_date){
            $gen_contents["page_title"] = "Exam Report";
            $gen_contents['passed_count'] = $this->admin_model->get_exam_report('', $start_date, $end_date);
            $gen_contents['passed_data'] = $this->admin_model->get_exam_report_details('', $start_date, $end_date);
            $data['html'] = $this->load->view('admin/dashboard/exam_report', $gen_contents, TRUE);
            return $data;
        }
        
        function exam_report_detail() {
            $this->load->model('admin_model');
            $report_type = $this->input->post('report_type');
            $code = $this->input->post('code');
            $start_date     = $this->input->post('start_date');
            $end_date       = $this->input->post('end_date');
            //$output['total_result'] = $this->admin_model->get_exam_report($code, $start_date, $end_date);
            $output['result_details'] = $this->admin_model->get_exam_report_details($code, $start_date, $end_date);
            $output['total_result'] = count($output['result_details']);
            $output['html'] = $this->load->view('admin/dashboard/exam_report_detail', $output, TRUE);
            
            //Graph imputs
            //Total Report Graph
            $output['report_type'] = $report_type;
            $output['total_passed'] = $this->admin_model->get_exam_report('P', $start_date, $end_date);
            $output['total_failed'] = $this->admin_model->get_exam_report('F', $start_date, $end_date);
            if($report_type === "report_total") {
                $output['total_ongoing'] = $this->admin_model->get_exam_report('o', $start_date, $end_date);
                $output['total_unexpected'] = $this->admin_model->get_exam_report('', $start_date, $end_date, 2);
            } else if($report_type === "report_passed") {
                //Passed Graph
                $output['total_passed_unexpected'] = $this->admin_model->get_exam_report('P', $start_date, $end_date, 2);
                $output['total_passed_normal'] = $output['total_passed']-$output['total_passed_unexpected'];
            } else if($report_type === "report_failed") {
                //Failed graph
                $output['total_failed_unexpected'] = $this->admin_model->get_exam_report('F', $start_date, $end_date, 2);
                $output['total_failed_normal'] = $output['total_failed']-$output['total_failed_unexpected'];
            }
            ///////////////////////////    
                    
            $data['return_value'] = json_encode($output);
            $this->load->view('dsp_show_ajax', $data);
        }
        function _browser_platform(){
            $this->_google_client();
            $user_id		= $this->session->userdata ('USERID');
            //$google_token_str   = $this->admin_model->get_access_token($user_id);
            //$refresh_token      = $this->_get_user_refresh_token($google_token_str);
            //$this->client->setAccessToken($google_token_str);
            
            /* Pie chart - Browser data */
            $results = $this->analytics->data_ga->get($this->ga_profile_id, $this->gen_contents['start_date'], $this->gen_contents['end_date'], 'ga:users', array('dimensions' => 'ga:browser', 'sort' => '-ga:users'));
            $gen_contents['browser_data']  =  $results->rows;
            $browser_pie_object             = "[['Browser', 'Number'],";
            if($gen_contents['browser_data']){
                foreach($gen_contents['browser_data'] as $key => $browser_data){
                    if(5 == $key){break;}
                    $browser_pie_object  .= "['".$browser_data[0]." ( ".$browser_data[1]." )', ".$browser_data[1]."],";
                }
                $browser_pie_object = rtrim($browser_pie_object, ',').']';
            }
            
            /* for browser version dropdown */
            $browser_data_option    = array(array('All', 'All'));
            $browser_data_only  = $gen_contents['browser_data'];
            if($browser_data_only){
                $results = $this->analytics->data_ga->get($this->ga_profile_id, $this->gen_contents['start_date'], $this->gen_contents['end_date'], 'ga:users', array('dimensions' => 'ga:browser,ga:browserVersion', 'sort' => '-ga:browserVersion', 'max-results' => 400));
                $browser_data_version  =  $results->rows;                
                foreach($browser_data_only as $data_only){
                    array_push($browser_data_option, array($data_only[0], $data_only[0], true));
                    foreach($browser_data_version as $data_version){
                        if($data_only[0] == $data_version[0]){
                            array_push($browser_data_option, array($data_version[0].'__'.$data_version[1], $data_version[0].' '.$data_version[1], false));
                        }
                    }
                }

            }
            $gen_contents['browser_data'] = $browser_data_option;
            
            /* Pie chart - Platform data */
            $results = $this->analytics->data_ga->get($this->ga_profile_id, $this->gen_contents['start_date'], $this->gen_contents['end_date'], 'ga:users', array('dimensions' => 'ga:operatingSystem', 'sort' => '-ga:users'));
            $gen_contents['os_data']  =  $results->rows;
            $os_pie_object              = "[['Platform', 'Number'],";
            if($gen_contents['os_data']){
                foreach($gen_contents['os_data'] as $key => $os_data){
                    if(5 == $key){break;}
                    $os_pie_object  .= "['".$os_data[0]." ( ".$os_data[1]." )', ".$os_data[1]."],";
                }
                $os_pie_object      = rtrim($os_pie_object, ',').']';
            }
            
            
            /* for platform version dropdown */
            $platform_data_option   = array(array('All', 'All'));
            $platform_data_only     = $gen_contents['os_data'];
            if($platform_data_only){
                $results = $this->analytics->data_ga->get($this->ga_profile_id, $this->gen_contents['start_date'], $this->gen_contents['end_date'], 'ga:users', array('dimensions' => 'ga:operatingSystem,ga:operatingSystemVersion', 'sort' => '-ga:operatingSystemVersion', 'max-results' => 100));
                $platform_data_version  =  $results->rows;                
                foreach($platform_data_only as $data_only){
                    array_push($platform_data_option, array($data_only[0], $data_only[0], true));
                    foreach($platform_data_version as $data_version){
                        if($data_only[0] == $data_version[0]){
                            array_push($platform_data_option, array($data_version[0].'__'.$data_version[1], $data_version[0].' '.$data_version[1], false));
                        }
                    }
                }

            }
            $gen_contents['os_data'] = $platform_data_option;
            
            /* Combination of browser and platform */
            $results = $this->analytics->data_ga->get($this->ga_profile_id, $this->gen_contents['start_date'], $this->gen_contents['end_date'], 'ga:users', array('dimensions' => 'ga:operatingSystem,ga:operatingSystemVersion,ga:browser,ga:browserVersion', 'start-index' => 1, 'max-results' => 5, 'sort' => '-ga:users'));
            $gen_contents['os_browser_data']  =  $results->rows;            
            
            
            $data['html'] = $this->load->view('admin/dashboard/_browser_platform', $gen_contents, TRUE);
            $data['js_variables']   = array('browser_pie_object' => $browser_pie_object, 'os_pie_object' => $os_pie_object);
            return $data;
            
        }
        function _visitors_analysis(){
            $this->_google_client();
            $user_id		= $this->session->userdata ('USERID');
            ///$google_token_str   = $this->admin_model->get_access_token($user_id);
            ///$refresh_token      = $this->_get_user_refresh_token($google_token_str);
            ///$this->client->setAccessToken($google_token_str);
            
            /* Total number of Unique User */
            $results = $this->analytics->data_ga->get($this->ga_profile_id, $this->gen_contents['start_date'], $this->gen_contents['end_date'], 'ga:users');
            //$results = $this->analytics->data_ga->get($this->ga_profile_id, $this->gen_contents['start_date'], $this->gen_contents['end_date'], 'ga:users', array('filters' => $this->ga_hostname_filter));
            $unique_users  =  $results->getTotalsForAllResults();
            $gen_contents['unique_users']  =  (isset($unique_users['ga:users'])) ? $unique_users['ga:users'] : 0;
            
            
            /* Splitted count of Guest and Member */
            $gen_contents['unique_user_seperate']  =  $this->_splitted_unique_user($gen_contents['unique_users']);
            
            
            /* Line chart - Unique users (Member, Guest) */
            $unique_line_chart_group_type   = $this->_get_chart_group_type();
            $ga_group   = 'ga:date, ga:day';
            if('hour' == $unique_line_chart_group_type){
                $ga_group   = 'ga:date, ga:hour';
            }else if('month' == $unique_line_chart_group_type){
                $ga_group   = 'ga:year, ga:month';                
            }
            //echo $unique_line_chart_group_type;exit;
            $results = $this->analytics->data_ga->get($this->ga_profile_id, $this->gen_contents['start_date'], $this->gen_contents['end_date'], 'ga:users', array('dimensions' => "ga:customVarName1,ga:customVarValue1,$ga_group", 'sort' => "$ga_group"));
            //print_r($results);exit;
            //$results = $this->analytics->data_ga->get($this->ga_profile_id, $this->gen_contents['start_date'], $this->gen_contents['end_date'], 'ga:users', array('dimensions' => "ga:customVarName1,ga:customVarValue1,$ga_group", 'sort' => "$ga_group", 'filters' => $this->ga_hostname_filter));
            $unique_line_arr   =  $results->rows;
            //print_r($unique_line_arr);exit;
            $unique_line_object             = "[['".ucfirst($unique_line_chart_group_type)."', 'Guest', 'Member'],";
            if($unique_line_arr){
                $combine_arr    = array();
                foreach($unique_line_arr as $unique_user){
                    $hour   = '00';
                    $value   = $unique_user[4];
                    if('hour' == $unique_line_chart_group_type){
                        $year   = substr($unique_user[2], 0, 4);
                        $month  = substr($unique_user[2], 4, 2);
                        $day    = substr($unique_user[2], 6, 2);
                        $hour    = $unique_user[3];
                    }else if('month' == $unique_line_chart_group_type){
                        $year   = $unique_user[2];
                        $month  = $unique_user[3];
                        $day    = 1;
                    }else{
                        $year   = substr($unique_user[2], 0, 4);
                        $month  = substr($unique_user[2], 4, 2);
                        $day    = substr($unique_user[2], 6, 2);
                    }
                    
                    $month = $month-1;//in javascript the month start form 0
                    $akey   = strtotime("$year-$month-$day $hour:00:00");                    
                    if(!array_key_exists($akey, $combine_arr)){
                        if((strtolower($unique_user[1]) == 'guest')){
                           $combine_arr[$akey]['guest'] = $value;
                        }else{
                           $combine_arr[$akey]['member'] = $value;
                        }
                    }else{
                        if((strtolower($unique_user[1]) == 'guest')){
                           $combine_arr[$akey]['guest'] = $value;
                        }else{
                           $combine_arr[$akey]['member'] = $value;
                        }
                    }
                }
                if('hour' == $unique_line_chart_group_type){
                    //$group_key  = 'new Date('.date('Y').','.date('m').','.date('d').', #KEY#, 0, 0, 0)';
                }
                foreach ($combine_arr as $key => $arr){
                    $guest_count    = (isset($arr['guest'])) ? $arr['guest'] : 0;
                    $member_count   = (isset($arr['member'])) ? $arr['member'] : 0;
                    
                    //$key = 'new Date('.date('Y').','.date('m').','.date('d').','.$key. ', 0, 0, 0)';
                    $year   = date('Y', $key);
                    $month  = date('m', $key);
                    $day    = date('d', $key);
                    $hour   = date('H', $key);
                    $key = " new Date($year, $month, $day, $hour, 0, 0, 0) ";
                    
                    $unique_line_object .= "[".$key.", ".$guest_count.", ".$member_count."],";
                }                
            }
            $unique_line_object = rtrim($unique_line_object, ',').']';
            
            /* Total Number of Active User (real time) */
            /*$optParams = array('dimensions' => 'rt:medium');
            $results = $this->analytics->data_realtime->get($this->ga_profile_id, 'rt:activeUsers', $optParams);
            $gen_contents['active_users']  =  $results->getTotalsForAllResults();*/
            
            $time_span      = c('active_time_span');
            $active_users   = $this->admin_model->getActiveUserCount(convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')), $time_span);
            
            $gen_contents['active_users'] =  $active_users;
            $gen_contents['active_registered']  = 0;
            $gen_contents['active_guest']       = 0;
            if($active_users > 0){
                $gen_contents['active_registered']   = $this->admin_model->getActiveUserCount(convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')), $time_span, 'registered');
                $gen_contents['active_guest']        = abs($active_users - $gen_contents['active_registered']);
            }
            
            $active_users_group_by_time   = $this->admin_model->getActiveUserCountByTime(convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')), $time_span);
            
            $active_line_object             = "[['Time', 'Guest', 'Registered'],";
            if($active_users_group_by_time){
                foreach ($active_users_group_by_time as $active_users_group){
                    $time = strtotime($active_users_group->last_accessed);
                    $year   = date('Y', $time);
                    $month  = date('m', $time);
                    $day    = date('d', $time);
                    $hour   = date('H', $time);
                    $minute = date('i', $time);
                    $month  = $month-1;//in javascript the month start form 0
                    $key = " new Date($year, $month, $day, $hour, $minute, 0, 0) ";
                    $active_line_object .= "[".$key.", ".$active_users_group->guest.", ".$active_users_group->registered."],";
                }
            }else{
                $now    = convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'));
                $time   = strtotime($now);
                $time1   = strtotime($now) - 5*60;
                $year   = date('Y', $time);
                $month  = date('m', $time);
                $day    = date('d', $time);
                $hour   = date('H', $time);
                $minute = date('i', $time);
                $key                = "[new Date($year, $month, $day, $hour, $minute, 0, 0)]";

                $year1   = date('Y', $time1);
                $month1  = date('m', $time1);
                $day1    = date('d', $time1);
                $hour1   = date('H', $time1);
                $minute1 = date('i', $time1);
                $key1                = "[new Date($year, $month, $day, $hour, $minute, 0, 0)]";
                $active_line_object .= "[".$key1.", 0, 0],[".$key.", 0, 0],";
            }
            $active_line_object = rtrim($active_line_object, ',').']';
            
            /* Average time spend by user */
            $this->load->library('pagination');
            $results = $this->analytics->data_ga->get($this->ga_profile_id, $this->gen_contents['start_date'], $this->gen_contents['end_date'], 'ga:avgTimeOnPage', array('dimensions' => 'ga:pagePathLevel1,ga:pagePathLevel2', 'start-index' => 1,  'max-results' => c('average_time_spent_perpage'), 'sort' => '-ga:avgTimeOnPage'));
            //$results = $this->analytics->data_ga->get($this->ga_profile_id, $this->gen_contents['start_date'], $this->gen_contents['end_date'], 'ga:avgTimeOnPage', array('dimensions' => 'ga:pagePathLevel1,ga:pagePathLevel2', 'filters' => $this->ga_hostname_filter, 'start-index' => 1,  'max-results' => c('average_time_spent_perpage'), 'sort' => '-ga:avgTimeOnPage'));
            
            $average_time_spent = $results->rows;
            $pagination_config  = array(
                                        'base_url'      => base_url().'admin/average_time_spent',
                                        'per_page'      => c('average_time_spent_perpage'),
                                        'uri_segment'  	=> 3,
                                        'total_rows'    => $results->totalResults
                                    );
            $this->pagination->initialize($pagination_config);
            $gen_contents['paginate']     = $this->pagination->create_links_ajax('averageTimeSpentAjax');
            $gen_contents['average_time_spent'] = $average_time_spent;
            
            
            $data['html'] = $this->load->view('admin/dashboard/_visitors_analysis', $gen_contents, TRUE);
            $data['js_variables']   = array('unique_users'          => $gen_contents['unique_users'], 
                                            'active_users'          => $gen_contents['active_users'], 
                                            'unique_user_seperate'  => $gen_contents['unique_user_seperate'], 
                                            'unique_line_object'    => $unique_line_object, 
                                            'active_line_object'    => $active_line_object);
            return $data;
        }
        
        function _get_user_refresh_token($google_token_str = ''){
            $refresh_token  = '';
            if('' != $google_token_str){
                $google_token   = json_decode($google_token_str);
                $refresh_token  = $google_token->refresh_token;
            }
            return $refresh_token;
        }
        
        /* Unique user(Member and Guest)*/
        function _splitted_unique_user($unique_users){            
            $results = $this->analytics->data_ga->get($this->ga_profile_id, $this->gen_contents['start_date'], $this->gen_contents['end_date'], 'ga:users', array('dimensions' => 'ga:customVarName1,ga:customVarValue1'));            
            //$results = $this->analytics->data_ga->get($this->ga_profile_id, $this->gen_contents['start_date'], $this->gen_contents['end_date'], 'ga:users', array('dimensions' => 'ga:customVarName1,ga:customVarValue1', 'filters' => $this->ga_hostname_filter));            
            $unique_user_seperate_arr   =  $results->rows;

            $unique_user_seperate    = array('guest' => 0, 'member' => 0);
            if($unique_user_seperate_arr){
                foreach($unique_user_seperate_arr as $arr){
                    if('Guest' == $arr[1] || 'Member' == $arr[1]){
                        $unique_user_seperate[strtolower($arr[1])] = $arr[2];
                    }
                }
            }
            if($unique_users > 0 && $unique_users < ($unique_user_seperate['guest'] + $unique_user_seperate['member'])){
                $unique_user_seperate['guest']  = $unique_users - $unique_user_seperate['member'];
            }
            return $unique_user_seperate;
        }
        
        function _get_chart_group_type(){
            $time_diff  = strtotime($this->gen_contents['end_date']) - strtotime($this->gen_contents['start_date']);
            $group_type = 'day';
            if(0 == $time_diff){
                $group_type = 'hour';
            }else{
                $time_diff  = round(abs($time_diff) / (60 * 60), 2); //minutes
                if($time_diff <= 31*24){//below 1month
                    $group_type = 'day';
                }else if($time_diff <= 365*24){//below 1 year
                    $group_type = 'month';
                }else if($time_diff > 365*24){
                    $group_type = 'year';
                }
            }
            return $group_type;
        }
        
        function browser_platform_comb_count(){
            $start_date     = $this->input->post('start_date');
            $end_date       = $this->input->post('end_date');
            $browser        = $this->input->post('browser');
            $platform       = $this->input->post('platform');
            
            $this->gen_contents['start_date']   = $start_date;
            $this->gen_contents['end_date']     = $end_date;
            
            $this->_google_client();
            $user_id		= $this->session->userdata ('USERID');
            //$google_token_str   = $this->admin_model->get_access_token($user_id);
            //$refresh_token      = $this->_get_user_refresh_token($google_token_str);
            //$this->client->setAccessToken($google_token_str);
            $metrics_dimension  = array();
            
            $browser_det = explode('__', $browser);
            if(count($browser_det) > 1){
                $brower_name    = $browser_det[0];
                $brower_version = $browser_det[1];
            }else{
                $brower_name    = $browser;
                $brower_version = '';
            }
            
            $platform_det = explode('__', $platform);
            if(count($platform_det) > 1){
                $platform_name    = $platform_det[0];
                $platform_version = $platform_det[1];
            }else{
                $platform_name    = $platform;
                $platform_version = '';
            }
            
            if('all' != strtolower($brower_name)){
                $ga_browser_filter = ('' != $brower_version) ? "ga:browser=={$brower_name};ga:browserVersion=={$brower_version}" : "ga:browser=={$brower_name}";
            }
            if('all' != strtolower($platform_name)){
                $ga_platform_filter = ('' != $platform_version) ? "ga:operatingSystem=={$platform_name};ga:operatingSystemVersion=={$platform_version}" : "ga:operatingSystem=={$platform_name}";
            }
            if(!('all' == strtolower($brower_name) && 'all' == strtolower($platform_name))){
                if('all' == strtolower($brower_name)){
                    $metrics_dimension['dimensions'] = "ga:operatingSystem,ga:operatingSystemVersion";
                    $metrics_dimension['filters']    = $ga_platform_filter;
                            //.';'.$this->ga_hostname_filter;
                }else if('all' == strtolower($platform_name)){
                    $ga_filters = $ga_browser_filter;
                    $metrics_dimension['dimensions'] = "ga:browser";
                    $metrics_dimension['filters']    = $ga_browser_filter;
                            //.$this->ga_hostname_filter;
                }else{                  
                    $metrics_dimension['dimensions'] = "ga:browser,ga:browserVersion,ga:operatingSystem,ga:operatingSystemVersion";
                    $metrics_dimension['filters']    = $ga_browser_filter.';'.$ga_platform_filter;
                            //.$this->ga_hostname_filter;
                }
            }
            $results    = $this->analytics->data_ga->get($this->ga_profile_id, $this->gen_contents['start_date'], $this->gen_contents['end_date'], 'ga:users', $metrics_dimension);
            $count      = $results->getTotalsForAllResults();
            $count      = (isset($count['ga:users'])) ? $count['ga:users'] : 0;
            $data['return_value'] = $count;
            $this->load->view('dsp_show_ajax', $data);
        }
        
        function active_user_count(){
            $time_span      = c('active_time_span');
            $active_users   = $this->admin_model->getActiveUserCount(convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')), $time_span);
            $count          = array('success' => 1, 'registered' => 0, 'guest' => 0);
            $count['total'] =  $active_users;
            if($active_users > 0){
                $count['registered']   = $this->admin_model->getActiveUserCount(convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')), $time_span, 'registered');
                $count['guest']        = abs($active_users - $count['registered']);
            }
            if('visitors_analysis' == $this->input->post('selected_item')){
                $active_users_group_by_time   = $this->admin_model->getActiveUserCountByTime(convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')), $time_span);
                $active_line_object             = "[['Time', 'Guest', 'Registered'],";
                if($active_users_group_by_time){
                    foreach ($active_users_group_by_time as $active_users_group){
                        $time = strtotime($active_users_group->last_accessed);
                        $year   = date('Y', $time);
                        $month  = date('m', $time);
                        $day    = date('d', $time);
                        $hour   = date('H', $time);
                        $minute = date('i', $time);
                        $key = " new Date($year, $month, $day, $hour, $minute, 0, 0) ";
                        $active_line_object .= "[".$key.", ".$active_users_group->guest.", ".$active_users_group->registered."],";
                    }
                }else{
                    $now    = convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'));
                    $time   = strtotime($now);
                    $time1   = strtotime($now) - 5*60;
                    $year   = date('Y', $time);
                    $month  = date('m', $time);
                    $day    = date('d', $time);
                    $hour   = date('H', $time);
                    $minute = date('i', $time);
                    $key                = "[new Date($year, $month, $day, $hour, $minute, 0, 0)]";

                    $year1   = date('Y', $time1);
                    $month1  = date('m', $time1);
                    $day1    = date('d', $time1);
                    $hour1   = date('H', $time1);
                    $minute1 = date('i', $time1);
                    $key1                = "[new Date($year, $month, $day, $hour, $minute, 0, 0)]";
                    $active_line_object .= "[".$key1.", 0, 0],[".$key.", 0, 0],";
                }
                $active_line_object = rtrim($active_line_object, ',').']';
                $count['active_line_object'] = $active_line_object;
            }
            $data['return_value'] = json_encode($count);
            $this->load->view('dsp_show_ajax', $data);
        }
        
        function _user_report(){
            $count  = $this->admin_model->breakdownUserCount($this->gen_contents['start_date'], $this->gen_contents['end_date']);
            $result = array();
            $show_chart             = ($count['normal'] == 0 && $count['amazon'] == 0 && $count['living'] == 0 && $count['groupon'] == 0) ? false : true;
            $result['js_variables'] = array('show_chart' => $show_chart);
            $result['user_pie_object']  = "[['Site', 'Number'],['Adhischools ({$count['normal']})', {$count['normal']}],['Amazon ({$count['amazon']})', {$count['amazon']}], ['Living Social({$count['living']})', {$count['living']}], ['Groupon ({$count['groupon']})', {$count['groupon']}]]";
            $result['html']             = $this->load->view('admin/dashboard/_user_report', array('count' => $count, 'show_chart' => $show_chart), TRUE);
            return $result;
        }
        
        function average_time_spent(){
            $gen_contents['start_date']     = $this->input->post('start_date');
            $gen_contents['end_date']       = $this->input->post('end_date');
            
            $this->_google_client();
            $user_id		= $this->session->userdata ('USERID');
            //$google_token_str   = $this->admin_model->get_access_token($user_id);
            //$refresh_token      = $this->_get_user_refresh_token($google_token_str);
            //$this->client->setAccessToken($google_token_str);
            
            $start_index        = (0 == $this->uri->segment(3)) ? 1: $this->uri->segment(3)+1;
            $this->load->library('pagination');
            $results = $this->analytics->data_ga->get($this->ga_profile_id, $gen_contents['start_date'], $gen_contents['end_date'], 'ga:avgTimeOnPage', array('dimensions' => 'ga:pagePathLevel1,ga:pagePathLevel2', 'start-index' => $start_index,  'max-results' => c('average_time_spent_perpage'), 'sort' => '-ga:avgTimeOnPage'));
            
            $average_time_spent = $results->rows;
            $pagination_config  = array(
                                        'base_url'      => base_url().'admin/average_time_spent',
                                        'per_page'      => c('average_time_spent_perpage'),
                                        'uri_segment'  	=> 3,
                                        'total_rows'    => $results->totalResults
                                    );
            $this->pagination->initialize($pagination_config);
            $gen_contents['paginate']     = $this->pagination->create_links_ajax('averageTimeSpentAjax');
            $gen_contents['average_time_spent'] = $average_time_spent;
            
            $data['return_value'] = $this->load->view('admin/dashboard/_average_time_spent', $gen_contents, TRUE);
            $this->load->view('dsp_show_ajax', $data);
        }
        
        function sub_manager(){
            $this->gen_contents["success_message"]='';
            if(!is_numeric($this->uri->segment(3))){
                    $s_msg = ($this->uri->segment(3));
                    $this->gen_contents["success_message"] = base64_decode($s_msg);
            }
            
            $this->load->model('common_model');
            $this->load->model('admin_subadmin_model');
            $this->gen_contents['page_title']	=	'Users';
            $this->load->library('pagination');
            $config['base_url'] 		= 	base_url().'index.php/admin/sub_manager/';
            $config['per_page'] 		= 	'10';
            $config['uri_segment']  		=  	3;

            $this->gen_contents["ssearch_firstname"] = '';
            $this->gen_contents["ssearch_lastname"] = '';
            $this->gen_contents["ssearch_email"] = '';
            $this->gen_contents["ssearch_phone"] = '';

            if(!empty($_POST)) {
                $this->gen_contents["ssearch_firstname"] = $this->common_model->safe_html($this->input->post('txtSrchFirstname'));
                $this->gen_contents["ssearch_lastname"] = $this->common_model->safe_html($this->input->post('txtSrchLastname'));
                $this->gen_contents["ssearch_email"] = $this->common_model->safe_html($this->input->post('txtSrchEmail'));
                $this->gen_contents["ssearch_phone"] = $this->common_model->safe_html($this->input->post('txtSrchPhone'));
            }else {
                $this->gen_contents["ssearch_firstname"] = ($this->session->flashdata('ssearch_firstname'))?$this->session->flashdata('ssearch_firstname'):$this->gen_contents["ssearch_firstname"];
                $this->gen_contents["ssearch_lastname"] = $this->session->flashdata('ssearch_lastname');
                $this->gen_contents["ssearch_email"] = $this->session->flashdata('ssearch_email');
                $this->gen_contents["ssearch_phone"] = $this->session->flashdata('ssearch_phone');
            }
            
            $this->session->set_flashdata('ssearch_firstname',$this->gen_contents["ssearch_firstname"]);
            $this->session->set_flashdata('ssearch_lastname',$this->gen_contents["ssearch_lastname"]);
            $this->session->set_flashdata('ssearch_email',$this->gen_contents["ssearch_email"]);
            $this->session->set_flashdata('ssearch_phone',$this->gen_contents["ssearch_phone"]);
            
            //if("" != $this->gen_contents["ssearch_firstname"] || "" != $this->gen_contents["ssearch_lastname"] || "" != $this->gen_contents["ssearch_email"]
            //        || "" != $this->gen_contents["ssearch_phone"]){
                $this->gen_contents["userdetails"]	=	$this->admin_subadmin_model->select_userdetails($config['per_page'],$this->uri->segment(3),$this->gen_contents["ssearch_firstname"],$this->gen_contents["ssearch_lastname"],$this->gen_contents["ssearch_email"],$this->gen_contents["ssearch_phone"],true);
                $config['total_rows']   		= 	$this->admin_subadmin_model->qry_count_userdetails($this->gen_contents["ssearch_firstname"],$this->gen_contents["ssearch_lastname"],$this->gen_contents["ssearch_email"],$this->gen_contents["ssearch_phone"]);

                $this->gen_contents["total"]            = $config['total_rows'];
            //}else{
            //    $this->gen_contents["userdetails"] = array();
            //    $this->gen_contents["total"]            = $config['total_rows'] = 0;
            //}
            
            $this->pagination->initialize($config);
            $this->gen_contents['paginate']     =   $this->pagination->create_links(true);
            
            $this->load->view("admin_header",$this->gen_contents);						
            $this->load->view('admin/sub_manager',$this->gen_contents);
            $this->load->view("admin_footer");
        }
        
        /**
        * function to view the user details
        *
        */
       function view_users (){
            $this->gen_contents["course"]		=	array();
            $this->gen_contents['page_title']	=	'Course Details';

            $this->session->set_flashdata('ssearch_firstname',$this->session->flashdata('ssearch_firstname'));
            $this->session->set_flashdata('ssearch_lastname',$this->session->flashdata('ssearch_lastname'));
            $this->session->set_flashdata('ssearch_email',$this->session->flashdata('ssearch_email'));
            $this->session->set_flashdata("ssearch_phone",$this->session->flashdata('ssearch_phone'));

            $this->_user_details($this->uri->segment(3));
            $this->load->view("admin_header",$this->gen_contents);						
            $this->load->view('admin/sub_manager_course',$this->gen_contents);
            $this->load->view("admin_footer");
       }
       /**
        * function to get the user details
        *
        */
       function _user_details ($userid){
               $this->userid                            = 	$userid;
               $this->load->model('admin_subadmin_model');
               $this->gen_contents["userdetails"]	=	$this->admin_subadmin_model->select_single_userdetails($this->userid);
               $this->gen_contents["coursedetails"]     =	$this->admin_subadmin_model->select_single_user_course_details($this->userid);
               $this->gen_contents["crash"]             =	$this->admin_subadmin_model->checkCCO($this->gen_contents["userdetails"]->emailid,$this->gen_contents["userdetails"]->firstname,$this->gen_contents["userdetails"]->lastname);
       }
       
       
        function runOptionA(){
            $this->load->model("admin_user_model");
            //$this->admin_user_model->setEdition3ForUsersOptionA();
        }
        
        function runOptionB1(){
            $this->load->model("admin_user_model");
            //$this->admin_user_model->setEdition3ForUsersOptionB1();
        }
        
        function runOptionB2(){
            $this->load->model("admin_user_model");
            //$this->admin_user_model->setEdition3ForUsersOptionB2();
        }
        
        function runOptionC(){
            $this->load->model("admin_user_model");
            //$this->admin_user_model->setEdition3ForUsersOptionC();
        }
        
        function runOptionD(){
            $this->load->model("admin_user_model");
            //$this->admin_user_model->setEdition3ForUsersOptionD();
        }
}
?>
