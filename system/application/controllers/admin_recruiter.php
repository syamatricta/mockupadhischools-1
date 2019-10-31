<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
	* Project				-	Adhischools
	* Language				-	PHP 5 & above
	* Database				-	Mysql
	* Author				-	Syama S (syama.s@rainconcert.in)
	* Created On                            -	April 13, 2015
	* Modified On                           -	April 13, 2015
	* Development Center                    -	Rain Concert Technologies Pvt Ltd, Trivandrum, Kerala, India.(http://aarthikaindia.com)
*/
// ------------------------------------------------------------------------
	class Admin_recruiter extends Controller
	{

		/**
		 * General contents
		 *
		 * @var Array
		 */
		var $gen_contents	=	array();
		var $recruiterid 	=	''; 		
		var $firstname		=	'';
                var $lastname		=	'';
		var $email		=	'';
		var $brokerage		=	'';
        
		/**
		 * Admin constructor
		 *
		 */
		function Admin_recruiter () {
			parent::Controller();
			$this->load->library('authentication');
			$this->load->helper(array('form', 'file'));
                        if (!$this->authentication->logged_in ("admin"))
			{
				redirect("admin");
			}
//                        else if($this->authentication->logged_in ("admin") === "sub") 
//                        {
//                            $this->session->set_flashdata('success', $this->session->flashdata("success"));
//                            redirect("admin/noaccess");
//                            exit;
//                        }
                        unset($_POST['ajax']);
			$this->load->library(array('form_validation'));
			$this->load->model('admin_recruiter_model');
			$this->gen_contents['css']      = array('admin_style.css','dhtmlgoodies_calendar.css','style.css','admin_register.css','admin_style_main.css');
			$this->gen_contents['js']       = array('admin_recruiter.js','popcalendar.js');
			$this->gen_contents['title']	= 'Recruiter Management';
                        ini_set('display_errors',1);
                        error_reporting( E_ALL );

		}
		/**
		 * Index
		 *
		 * @access	public
		 */
		function index()
		{
                    $this->recruiter_mail();
		}
                /**
		 * function to load the template (header, body and footer)
		 *
		 * @param string $page
		 * @param array $contents
		 */
		function _template ($page,$contents){
			$this->load->helper('form');
			$this->load->view("admin_header",$contents);
			$this->load->view('admin/recruiter/'.$page, $contents);
			$this->load->view("admin_footer");
		}
		/**
		 * function to list the recruiter details
		 *
		 */
		function list_recruiter ()
		{
                    
			$this->gen_contents["success_message"]='';
			if(!is_numeric($this->uri->segment(3))){
				$s_msg = ($this->uri->segment(3));
				$this->gen_contents["success_message"] = base64_decode($s_msg);
			}
			$this->load->model('common_model');
			$this->gen_contents['page_title']               =	'Recruiters';
			$this->load->library('pagination');
			$config['base_url'] 				= 	base_url().'index.php/admin_recruiter/list_recruiter/';
			$config['per_page'] 				= 	'10';
			$config['uri_segment']  			=  	3;
                        $page_no 					= $this->uri->segment(3);
			$this->gen_contents['page_no']                  = $page_no;

		
			$this->gen_contents["search_firstname"] = '';
                        $this->gen_contents["search_lastname"] = '';
			$this->gen_contents["search_email"] = '';
                        $this->gen_contents["search_brokerage"] = '';
			

			if(!empty($_POST)) {
				$this->gen_contents["search_firstname"] = trim($this->common_model->safe_html($this->input->post('txtSearch_Rfirstname')));
                                $this->gen_contents["search_lastname"] = trim($this->common_model->safe_html($this->input->post('txtSearch_Rlastname')));
				$this->gen_contents["search_email"]     = trim($this->common_model->safe_html($this->input->post('txtSearch_Remail')));
				$this->gen_contents["search_brokerage"] = trim($this->common_model->safe_html($this->input->post('txtSearch_Rbrokerage')));
			} else {
				$this->gen_contents["search_firstname"] = ($this->session->flashdata('Search_Rfirstname')) ? trim($this->session->flashdata('Search_Rfirstname')) : trim($this->gen_contents["search_firstname"]);
                                $this->gen_contents["search_lastname"] = ($this->session->flashdata('Search_Rlastname')) ? trim($this->session->flashdata('Search_Rlastname')): trim($this->gen_contents["search_lastname"]);
				$this->gen_contents["search_email"]     =  trim($this->session->flashdata('Search_Remail'));
                                $this->gen_contents["search_brokerage"] =  trim($this->session->flashdata('Search_Rbrokerage'));
			}
			$this->session->set_flashdata('Search_Rfirstname',$this->gen_contents["search_firstname"]);
                        $this->session->set_flashdata('Search_Rlastname',$this->gen_contents["search_lastname"]);
			$this->session->set_flashdata('Search_Remail',$this->gen_contents["search_email"]);
			$this->session->set_flashdata('Search_Rbrokerage',$this->gen_contents["search_brokerage"]);
	
                        $this->gen_contents["recruiterdetails"]              =	$this->admin_recruiter_model->select_recruiterdetails($config['per_page'],$this->uri->segment(3),$this->gen_contents["search_firstname"],$this->gen_contents["search_lastname"],$this->gen_contents["search_email"],$this->gen_contents["search_brokerage"]);
                        $config['total_rows']   			= 	$this->admin_recruiter_model->qry_count_recruiterdetails($this->gen_contents["search_firstname"],$this->gen_contents["search_lastname"],$this->gen_contents["search_email"],$this->gen_contents["search_brokerage"]);
			
			$this->pagination->initialize($config);
			$this->gen_contents['paginate']     =   $this->pagination->create_links(true);
			$this->_template('list_recruiter_details',$this->gen_contents);
		}
                
                /**
                * function for registering recruiter
                */

                function add_recruiter()
                {
                        
                      if(!empty($_POST)) {
                          $this-> _int_user_recruiter_step();
                      }
                      $page_no 					= $this->uri->segment(3);
                      $this->gen_contents['page_no']            = $page_no;
                
                      $this->load->helper("form");
                      $this->load->view("admin/admin_recruiter_heading",$this->gen_contents);
                      $this->load->view('admin/recruiter/add_new_recruiter',$this->gen_contents);
                      $this->load->view("admin_footer",$this->gen_contents);
                }
                
                function _int_user_recruiter_step()
                {
                        if(!empty($_POST)) {
                                $this->load->library("form_validation");
                                $this->_init_recruiter_rules();

                                if($this->form_validation->run() == TRUE) {
                                        $check =$this->admin_recruiter_model->checkrecruiter($this->input->post('email'));
                                        
                                        if($check <= 0){
                                            $this->_init_user_recruiterdetails();
                                        
                                            //recruiter details to save in database
                                            if($this->admin_recruiter_model->add_recruiter_details($this->gen_contents['data'])){
                                                $this->session->set_flashdata ('msg', 'Recruiter added successfully');
                                                redirect('admin_recruiter/add_recruiter/'.$this->uri->segment(4));
                                            } else{
                                                $this->gen_contents['msg'] = 'Recruiter not added';
                                            }
                                        } else{
                                            $this->gen_contents['msg']= "Email Already Exist";
                                        }
                                }
                        }

                }
                
                /**
                 * function for form validation in step 1 registration
                 *
                 */
                function _init_recruiter_rules()
                {
                        $this->form_validation->set_rules('firstname', 'FIRST NAME', 'required|max_length[128]');
                        $this->form_validation->set_rules('email', 'EMAIL', 'required|max_length[128]|matches[confirmemail]');
                        $this->form_validation->set_rules('confirmemail', 'CONFIRM EMAIL', 'required|max_length[128]');
                        $this->form_validation->set_rules('brokerage', 'BROKERAGE', 'required');
                }

                /**
                 * function for assigning the post values of step1 registration
                 *
                 */
                function _init_user_recruiterdetails()
                {
                        $this->load->model('common_model');
                        $this->gen_contents['data'] = array(
                                "recruiter_name" 	=> $this->common_model->safe_html(ucfirst($this->input->post('firstname'))),
                                "recruiter_last_name" 	=> $this->common_model->safe_html(ucfirst($this->input->post('lastname'))),
                                "recruiter_mail" 	=> $this->common_model->safe_html($this->input->post('email')),
                                "recruiter_copy_mail" 	=> $this->common_model->safe_html($this->input->post('copy_email')),
                                "recruiter_brokerage" 	=> $this->common_model->safe_html($this->input->post('brokerage')),
                                "recruiter_status" 	=> 1,
                                "created_by"            => $this->session->userdata('USERID'),
                                "created_date"          => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')),
                                "status"                => 1
                        );
                }
                /**
		 * function to view the recruiter details
		 *
		 */
		function view_recruiters (){
			$this->gen_contents["course"]		=	array();
			$this->gen_contents['page_title']	=	'Recruiter Details';

			$this->session->set_flashdata('search_firstname',$this->session->flashdata('Search_Rfirstname'));
			$this->session->set_flashdata('search_email',$this->session->flashdata('Search_Remail'));
			$this->session->set_flashdata("search_brokerage",$this->session->flashdata('Search_Rbrokerage'));

			$this->_recruiter_details($this->uri->segment(3));
			$this->_template('view_recruiter_details',$this->gen_contents);
		}
		/**
		 * function to edit the recruiter details
		 *
		 */
		function edit_recruiters (){
			$this->gen_contents['page_title']	=	'Edit Recruiter Details';
			$this->gen_contents["recruiterid"]	=	$this->uri->segment(3);

			$this->session->set_flashdata('search_firstname',$this->session->flashdata('Search_Rfirstname'));
			$this->session->set_flashdata('search_email',$this->session->flashdata('Search_Remail'));
			$this->session->set_flashdata("search_brokerage",$this->session->flashdata('Search_Rbrokerage'));

			
			$this->_recruiter_details($this->gen_contents["recruiterid"]);
			$this->_template('edit_recruiter_details',$this->gen_contents);
		}
		/**
		 * inner function to edit the recruiter details
		 *
		 * @param int $recruiterid
		 */
		function _edit_recruiter_details ($recruiterid){
                    
			$recrarray	=	array(
                                                    'recruiter_name'            =>	ucfirst($this->firstname),
                                                    'recruiter_last_name'       =>	ucfirst($this->lastname),
                                                    'recruiter_mail'		=>	$this->email,
                                                    'recruiter_copy_mail'	=>	$this->copy_email,
                                                    'recruiter_brokerage'	=>	$this->brokerage,
                                                    'updated_by'                =>      $this->session->userdata('USERID'),
                                                    'updated_date'              => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')),
							
						);
			return $this->admin_recruiter_model->update_recruiter_details($recruiterid,$recrarray);
		}
		/**
		 * function to update the recruiter details
		 *
		 */
		function update_recruiters () {
			$this->recruiterid     = 	$this->input->post('hidrecruiterid');
		
			$this->firstname       =	ucfirst($this->input->post('firstname'));
                        $this->lastname        =	ucfirst($this->input->post('lastname'));
                        $this->email           =	$this->input->post('email');
                        $this->copy_email      =	$this->input->post('copy_email');
                        $confrim_email         =	$this->input->post('confrimemail');
                        $this->brokerage       =	$this->input->post('brokerage');
			/* validating the fields*/
			$this->_init_recruiter_rules();

			if($this->form_validation->run() == TRUE) {
                            
				$emailexist = $this->admin_recruiter_model->check_recruiter_email($this->recruiterid,$this->email);
				

				/* updating the recruiter details*/
                                $update = 0;
				if(0 == count($emailexist)){
					$update = $this->_edit_recruiter_details($this->recruiterid );
				} else {
					$this->session->set_flashdata ('error', 'Email id already exist. Please choose another one');
					redirect('admin_recruiter/edit_recruiters/'.$this->recruiterid.'/'.$this->uri->segment(4));
				}

				if($update > 0)
				{
					$this->session->set_flashdata ('success', 'Recruiter details updated successfully');
					redirect('admin_recruiter/edit_recruiters/'.$this->recruiterid.'/'.$this->uri->segment(4));
				}
				else
				{
					$this->session->set_flashdata ('error', 'Request Failed');
					redirect('admin_recruiter/edit_recruiters/'.$this->recruiterid.'/'.$this->uri->segment(4));
				}
			}
			else {
				$this->edit_recruiters();
			}
		}
                
                /**
		 * function to freeze recruiter
		 *
		 */
		function freeze_recruiter() {
			$this->recruiterid                       =    $this->uri->segment(3);
			$this->gen_contents['recruiterid']       =    $this->recruiterid;
			$this->gen_contents['reason']            =    $this->input->post('txtReasonFreeze');
			$freeze_recruiter                        =    $this->admin_recruiter_model->freeze_recruiter($this->gen_contents);
                        $page_no                                 =    ($this->uri->segment(4) != 'undefined') ? $this->uri->segment(4) : '';
			if($freeze_recruiter >0)
			{
				$this->session->set_flashdata ('success', 'Recruiter freezed successfully');
				redirect('admin_recruiter/list_recruiter/'.$page_no);
			}
			else
			{
				$this->session->set_flashdata ('error', 'Request Failed');
				redirect('admin_recruiter/list_recruiter/'.$page_no);
			}
		}
                /**
		 * function to activate recruiter
		 *
		 */
		function activate_recruiter() {
			$this->recruiterid                       =    $this->uri->segment(3);
			$this->gen_contents['recruiterid']       =    $this->recruiterid;
			$this->gen_contents['reason']            =    $this->input->post('txtReasonAct');
			$freeze_recruiter                        =    $this->admin_recruiter_model->activate_recruiter($this->gen_contents);
                        $page_no                                 =    ($this->uri->segment(4) != 'undefined') ? $this->uri->segment(4) : '';
			if($freeze_recruiter >0)
			{
				$this->session->set_flashdata ('success', 'Recruiter activated successfully');
				redirect('admin_recruiter/list_recruiter/'.$page_no);
			}
			else
			{
				$this->session->set_flashdata ('error', 'Request Failed');
				redirect('admin_recruiter/list_recruiter/'.$page_no);
			}
		}
		/**
		 * function to get the recruiter details
		 *
		 */
		function _recruiter_details ($recruiterid)
		{
			$this->recruiterid 			= 	$recruiterid;
			if(!($this->gen_contents["recruiterdetails"]	=	$this->admin_recruiter_model->select_single_recruiterdetails($this->recruiterid))){
                            redirect("admin/noaccess");
                            exit;
                        }
		}
                /**
		 * function to get contents for sending mail to recruiter
		 *
		 */
                function recruiter_mail ()
		{
                    
//                    if($this->authentication->logged_in ("admin") === "sub") 
//                    {
//                            $this->session->set_flashdata('success', $this->session->flashdata("success"));
//                            redirect("admin/noaccess");
//                            exit;
//                    }
                    if(!empty($_POST)) {
                          $this->gen_contents["prevmailid"]   = array_key_exists('hidmailid',$_POST) ? $_POST['hidmailid'] : '';
                          $this->gen_contents["prevrecid"]    = array_key_exists('hidrecruiterid',$_POST) ? $_POST['hidrecruiterid'] : '';
                         
                          if($this->gen_contents["prevmailid"] == '' && $this->gen_contents["prevrecid"] == ''){
                              $this-> _int_mail_recruiter_step(); 
                          } else{
                              if($this->gen_contents["prevmailid"] != 'back'){
                                    $this->gen_contents["data"]      =	$this->admin_recruiter_model->get_recruiter_mail_details($this->gen_contents["prevmailid"],NULL);
                         
                               }
                          }
                      }
                     
                      $this->load->helper("form");
                      $this->gen_contents["recruiter_detail"]	=	$this->admin_recruiter_model->get_all_recruiters();  
                      $this->gen_contents["licensure_detail"]	=	$this->admin_recruiter_model->get_all_licensure_stage(); 
                      $this->load->view("admin/admin_recruiter_heading",$this->gen_contents);
                      $this->load->view('admin/recruiter/get_mail_contents',$this->gen_contents);
                      $this->load->view("admin_footer",$this->gen_contents);
                }
                /**
		 * function for getting contents for sending mail to recruiter
		 *
		*/
		
                function _int_mail_recruiter_step()
                {
//                        if($this->authentication->logged_in ("admin") === "sub") 
//                        {
//                                $this->session->set_flashdata('success', $this->session->flashdata("success"));
//                                redirect("admin/noaccess");
//                                exit;
//                        }
                        if(!empty($_POST)) {
                                $this->load->library("form_validation");
                                $this->_init_mail_recruiter_rules();

                                if($this->form_validation->run() == TRUE) {
                                    
                                            $this->_init_mail_recruiterdetails();
                                        
                                            //mail details to save in database
                                          
                                            if($this->input->post('hidprevmailid') == '' || $this->input->post('hidprevmailid') == 'back'){
                                                if($id = $this->admin_recruiter_model->add_recruiter_mail_details($this->gen_contents['data'])){
                                                    redirect('admin_recruiter/preview_recruiter_mail/'.$id.'/'.$this->gen_contents['data']['recruiter_referred']);
                                                } else{
                                                    $this->gen_contents['msg'] = 'Error occured. Please try again';
                                                }
                                            } else{
                                               if($this->admin_recruiter_model->update_recruiter_mail_details($this->input->post('hidprevmailid'),$this->gen_contents['data'])){
                                                   redirect('admin_recruiter/preview_recruiter_mail/'.$this->input->post('hidprevmailid').'/'.$this->gen_contents['data']['recruiter_referred']);
                                                } else{
                                                    $this->gen_contents['msg'] = 'Error occured. Please try again';
                                                } 
                                            }
                                        
                                }
                        }

                }
                
                /**
                 * function for form validation in step 1 recruiter mail
                 *
                 */
                function _init_mail_recruiter_rules()
                {
//                        if($this->authentication->logged_in ("admin") === "sub") 
//                        {
//                                $this->session->set_flashdata('success', $this->session->flashdata("success"));
//                                redirect("admin/noaccess");
//                                exit;
//                        }
                        
                        $this->form_validation->set_rules('firstname', 'FIRST NAME', 'required|max_length[128]');
                        $this->form_validation->set_rules('lastname', 'LAST NAME', 'required|max_length[128]');
                        $this->form_validation->set_rules('gender', 'GENDER', 'required');
                        $this->form_validation->set_rules('recruiter', 'RECRUITER NAME', 'required');
                        $this->form_validation->set_rules('area_of_interest', 'AREA OF INTEREST', 'required|max_length[128]');
                        $this->form_validation->set_rules('licensure', 'LICENSURE STAGE', 'required');
                        $this->form_validation->set_rules('email', 'EMAIL', 'required|max_length[50]');
                        //$this->form_validation->set_rules('email', 'EMAIL', 'required|max_length[50]|matches[confirmemail]');
                        //$this->form_validation->set_rules('confirmemail', 'CONFIRM EMAIL', 'required|max_length[50]');
                        $this->form_validation->set_rules('phone', 'PHONE NUMBER', 'required');
                }

                /**
                 * function for assigning the post values of step1 recruiter mail
                 *
                 */
                function _init_mail_recruiterdetails()
                {
//                        if($this->authentication->logged_in ("admin") === "sub") 
//                        {
//                                $this->session->set_flashdata('success', $this->session->flashdata("success"));
//                                redirect("admin/noaccess");
//                                exit;
//                        }
                    
                        $this->load->model('common_model');
                        $this->gen_contents['data'] = array();
                        $this->gen_contents['data'] = array(
                                "student_first_name" 	=> $this->common_model->safe_html(ucfirst($this->input->post('firstname'))),
                                "student_last_name" 	=> $this->common_model->safe_html(ucfirst($this->input->post('lastname'))),
                                "gender"                => $this->common_model->safe_html($this->input->post('gender')),
                                "recruiter_referred" 	=> $this->common_model->safe_html($this->input->post('recruiter')),
                                "area_of_interest" 	=> $this->common_model->safe_html($this->input->post('area_of_interest')),
                                "stage_of_licensure" 	=> $this->common_model->safe_html($this->input->post('licensure')),
                                "student_mail_id" 	=> $this->common_model->safe_html($this->input->post('email')),
                                "student_phone_number" 	=> $this->common_model->safe_html($this->input->post('phone')),
                                "about_student" 	=> ($this->input->post('about') != '') ? ($this->common_model->safe_html($this->input->post('about'))).'.' : '',
                                "mail_status"           => 2,               
                                "created_date"          => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')),
                                "status"                => 1
                                
                        );
                }
          
                /**
                 * function for assigning the post values of step1 registration
                 *
                 */
                function get_brokerage_onrecruiter()
                {
                   if(isset($_POST)){
                          $this->gen_contents['recruiter_id'] = $_POST['recruiter_id'];
                          $data = $this->admin_recruiter_model->get_all_recruiters($this->gen_contents['recruiter_id']);
                          
                          if(!empty($data)){
                              print(json_encode(array('recruiter_brokerage' => $data[0]['recruiter_brokerage'], 
                                  'recruiter_copy_mail' => $data[0]['recruiter_copy_mail'])));
                          }
                          exit;
                   }
                }
                
                function preview_recruiter_mail(){
//                      if($this->authentication->logged_in ("admin") === "sub") 
//                        {
//                                $this->session->set_flashdata('success', $this->session->flashdata("success"));
//                                redirect("admin/noaccess");
//                                exit;
//                        }
                    
                      $recruiter_mail_id                        =       $this->uri->segment(3);
                      $recruiter_referred                       =       $this->uri->segment(4);
                      
                      
                      if(!$recruiter_mail_id || $recruiter_mail_id == '' || !(is_numeric($recruiter_mail_id))){
                          $recruiter_details    =   $this->admin_recruiter_model->get_last_row_recruiter_data();
                          $recruiter_mail_id    =   $recruiter_details['adhi_recruiter_send_mail_id'];
                          $recruiter_referred   =   $recruiter_details['recruiter_referred'];
                      }
                      
                      if(is_numeric($recruiter_mail_id)){
                          $this->load->helper("form");
                          $data                                     =	$this->admin_recruiter_model->get_recruiter_mail_details($recruiter_mail_id,NULL);
                          $this->gen_contents["mail_template"]      =	$this->admin_recruiter_model->get_mail_template($this->config->item('RECRUITER_MAIL_TEMPLATE'));
                          
                          if($data['gender']){
                              $mention = 'He is';
                              $mention_as = 'his';
                          } else{
                              $mention = 'She is';
                              $mention_as = 'her';
                          }

                          
                          if($data['adhi_recruiter_licensure_stage_id'] == 2){
                              $data['adhi_recruiter_licensure_stage_name'] = str_replace('the',$mention_as,$data['adhi_recruiter_licensure_stage_name']);
                          }
                          
                          $data['adhi_recruiter_licensure_stage_name'] = $mention.' '.$data['adhi_recruiter_licensure_stage_name'];
                          
//                          $sub_name = array();
//                          $sub_name = explode(' ',$data['recruiter_name'],2);
//                          $recruiter_fname = $sub_name [0];

                          $mail_body = sprintf($this->gen_contents["mail_template"][0]["mail_body"], $data['recruiter_name'], $data['student_first_name'],$data['student_last_name'],
                                               $data['area_of_interest'],$data['adhi_recruiter_licensure_stage_name'],$data['recruiter_brokerage'],
                                               $data['about_student'],$data['student_first_name'],$data['recruiter_brokerage'],$data['student_first_name'],
                                               $data['student_phone_number'],$mention_as,$data['student_mail_id']);
                          
                          $subject = sprintf($this->gen_contents["mail_template"][0]["mail_subject"], $data['recruiter_brokerage']);

                          $this->gen_contents["mail_template"][0]['mail_body']      =         $mail_body;
                          $this->gen_contents["mail_template"][0]['mail_subject']   =         $subject;
                          $this->gen_contents['data']                               =         $data;

                          $this->load->view("admin/admin_recruiter_heading",$this->gen_contents);
                          $this->load->view('admin/recruiter/preview_recruiter_mail_details',$this->gen_contents);
                          $this->load->view("admin_footer",$this->gen_contents);
                      }
                }
                
                /**
		 * function for sending mail to recruiter
		 *
		 */
                function recruiter_send_mail ()
		{
//                    if($this->authentication->logged_in ("admin") === "sub") 
//                    {
//                            $this->session->set_flashdata('success', $this->session->flashdata("success"));
//                            redirect("admin/noaccess");
//                            exit;
//                    }
                    
                    if(!empty($_POST)) {
                        $this->load->model('common_model');
                        $to  = $_POST['to']      ? $_POST['to']  : '';
                        $to .= $_POST['cc']  ? ','.$_POST['cc']  : '';
                        $to .= $_POST['bcc'] ? ','.$_POST['bcc'] : '';
                        
                        if($_POST['copy_mail'] != ''){
                            $to.= ','.$_POST['copy_mail'];
                        }
                        
                        if($to != ''){
                            $mail = $this->common_model->guest_pass_mail($to,$_POST['from'], $_POST['from_name'], $_POST['subject'], $_POST['body'],'',array());
                            $details = array('mail_status' => $mail, 'created_date' => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')), 'mail_body' =>$_POST['body']);
                            $id = $_POST['hidmailid'];
                            $this-> admin_recruiter_model-> update_recruiter_mail_details($id,$details);
                            
                            if($mail){
                                $this->session->set_flashdata ('success_mail', 'Recruiter Email sent successfully to '.ucfirst($_POST['to_name']));
                            } else{
                                $this->session->set_flashdata ('fail_mail', 'Mail sent failed');
                            }
                            redirect('admin_recruiter/preview_recruiter_mail/'.$_POST['hidmailid'].'/'.$_POST['hidrecruiterid']);
                        }
                    }
                }
                
		function recruiter_reports ()
		{
                    $this->session->unset_userdata('date_from');
                    $this->session->unset_userdata('date_to');
                    $this->session->unset_userdata('brokerage');
                    $this->session->unset_userdata('student_first_name');
                    $this->session->unset_userdata('student_last_name');
                    $this->session->unset_userdata('student_mail_id');
                    $this->recruiter_report();
                }
                /**
		 * function to list the recruiter details
		 *
		 */
		function recruiter_report ()
		{
                    
			$this->gen_contents["success_message"]='';
			if(!is_numeric($this->uri->segment(3))){
				$s_msg = ($this->uri->segment(3));
				$this->gen_contents["success_message"] = base64_decode($s_msg);
			}
			$this->load->model('common_model');
			$this->gen_contents['page_title']               =	'Recruiters Report';
			$this->load->library('pagination');
			$config['base_url'] 				= 	base_url().'index.php/admin_recruiter/recruiter_report/';
			$config['per_page'] 				= 	'10';
			$config['uri_segment']  			=  	3;
                        $page_no 					= $this->uri->segment(3);
			$this->gen_contents['page_no']                  = $page_no;

		
			$this->gen_contents["date_from"] = '';
                        $this->gen_contents["date_to"] = '';
			$this->gen_contents["brokerage"] = '';
                        
                        $this->gen_contents["student_first_name"] = '';
                        $this->gen_contents["student_last_name"] = '';
			$this->gen_contents["student_mail_id"] = '';
			
			if(!empty($_POST)) {
				$this->gen_contents["date_from"] = trim($this->common_model->safe_html($this->input->post('date_from')));
                                $this->gen_contents["date_to"] = trim($this->common_model->safe_html($this->input->post('date_to')));
				$this->gen_contents["brokerage"]     = $this->input->post('brokerage');
                                $this->gen_contents["student_first_name"] = trim($this->common_model->safe_html($this->input->post('student_first_name')));
                                $this->gen_contents["student_last_name"] = trim($this->common_model->safe_html($this->input->post('student_last_name')));
				$this->gen_contents["student_mail_id"] = trim($this->common_model->safe_html($this->input->post('student_mail_id')));
                        } else {
				$this->gen_contents["date_from"] = ($this->session->userdata('date_from')) ? trim($this->session->userdata('date_from')) : trim($this->gen_contents["date_from"]);
                                $this->gen_contents["date_to"] = ($this->session->userdata('date_to')) ? trim($this->session->userdata('date_to')): trim($this->gen_contents["date_to"]);
				$this->gen_contents["brokerage"]     =  $this->session->userdata('brokerage');
                                $this->gen_contents["student_first_name"] = ($this->session->userdata('student_first_name')) ? trim($this->session->userdata('student_first_name')) : trim($this->gen_contents["student_first_name"]);
                                $this->gen_contents["student_last_name"] = ($this->session->userdata('student_last_name')) ? trim($this->session->userdata('student_last_name')): trim($this->gen_contents["student_last_name"]);
				$this->gen_contents["student_mail_id"] = ($this->session->userdata('student_mail_id')) ? trim($this->session->userdata('student_mail_id')) : trim($this->gen_contents["student_mail_id"]);
                        }
                        
			$this->session->set_userdata('date_from',$this->gen_contents["date_from"]);
                        $this->session->set_userdata('date_to',$this->gen_contents["date_to"]);
			$this->session->set_userdata('brokerage',$this->gen_contents["brokerage"]);
                        $this->session->set_userdata('student_first_name',$this->gen_contents["student_first_name"]);
                        $this->session->set_userdata('student_last_name',$this->gen_contents["student_last_name"]);
			$this->session->set_userdata('student_mail_id',$this->gen_contents["student_mail_id"]);
	
                        $this->gen_contents["recruiters"]  =  $this->admin_recruiter_model->get_all_recruiters(FALSE,"recruiter_brokerage");
                        $this->gen_contents["reports"]  =  $this->admin_recruiter_model->get_brokerage_report($this->gen_contents["date_from"],$this->gen_contents["date_to"],$this->gen_contents["brokerage"],
                                $this->gen_contents["student_first_name"],$this->gen_contents["student_last_name"],$this->gen_contents["student_mail_id"],$config['per_page'],$this->uri->segment(3),"data");
                        $config["total_rows"] = count($this->admin_recruiter_model->get_brokerage_report($this->gen_contents["date_from"],$this->gen_contents["date_to"],$this->gen_contents["brokerage"],
                                $this->gen_contents["student_first_name"],$this->gen_contents["student_last_name"],$this->gen_contents["student_mail_id"],0,0,"count"));
                        
			$this->pagination->initialize($config);
			$this->gen_contents['paginate']     =   $this->pagination->create_links(true);
			$this->_template('list_report_details',$this->gen_contents);
		}
                
                function get_referral_details(){
                    $id = $this->uri->segment(4);
                    $this->load->model('common_model');
                    $this->gen_contents['page_title']               =	'Referral Details';
                    $this->gen_contents["stages"]   =  $this->admin_recruiter_model->get_all_licensure_stages();
                    $this->gen_contents["report"]  =  $this->admin_recruiter_model->get_brokerage_detail($id);
                    $this->_template('view_refer_details',$this->gen_contents);
                        
                }
		
                
                function recruiter_report_excel(){
                    
                    $this->load->model("common_model");
                    
                    if(!empty($_POST)) {
                            $this->gen_contents["date_from"] = trim($this->common_model->safe_html($this->input->post('date_from')));
                            $this->gen_contents["date_to"] = trim($this->common_model->safe_html($this->input->post('date_to')));
                            $this->gen_contents["brokerage"]     = $this->input->post('brokerage');
                            $this->gen_contents["student_first_name"] = trim($this->common_model->safe_html($this->input->post('student_first_name')));
                            $this->gen_contents["student_last_name"] = trim($this->common_model->safe_html($this->input->post('student_last_name')));
                            $this->gen_contents["student_mail_id"] = trim($this->common_model->safe_html($this->input->post('student_mail_id')));
                    } else {
                            $this->gen_contents["date_from"] = ($this->session->flashdata('date_from')) ? trim($this->session->flashdata('date_from')) : trim($this->gen_contents["date_from"]);
                            $this->gen_contents["date_to"] = ($this->session->flashdata('date_to')) ? trim($this->session->flashdata('date_to')): trim($this->gen_contents["date_to"]);
                            $this->gen_contents["brokerage"]     =  $this->session->flashdata('brokerage');
                            $this->gen_contents["student_first_name"] = ($this->session->flashdata('student_first_name')) ? trim($this->session->flashdata('student_first_name')) : trim($this->gen_contents["student_first_name"]);
                            $this->gen_contents["student_last_name"] = ($this->session->flashdata('student_last_name')) ? trim($this->session->flashdata('student_last_name')): trim($this->gen_contents["student_last_name"]);
                            $this->gen_contents["student_mail_id"] = ($this->session->flashdata('student_mail_id')) ? trim($this->session->flashdata('student_mail_id')) : trim($this->gen_contents["student_mail_id"]);
                    }
                    
                    if (isset($_POST['date_from']) && '' != $_POST['date_from']) {
                        $this->gen_contents['datefrom'] = formatDate_search($this->input->post('date_from'));
                        $dt_from = date('m/d/Y',strtotime($this->gen_contents['datefrom']));
                    } else if ('' != $this->uri->segment(4)) {
                        $this->gen_contents['datefrom'] = $this->uri->segment(4);
                        $dt_from = 'Beginning';
                    } else if ('' != $this->uri->segment(4) && 0 == $this->uri->segment(4)) {
                        $this->gen_contents['datefrom'] = '';
                        $dt_from = 'Beginning';
                    } else {
                        $this->gen_contents['datefrom'] = convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
                        $dt_from = date('m/d/Y',strtotime($this->gen_contents['datefrom']));
                    }

                    if (isset($_POST['date_to']) && '' != $_POST['date_to']) {
                        $this->gen_contents['dateto'] = formatDate_search($this->input->post('date_to'));
                    } else if ('' != $this->uri->segment(5)) {
                        $this->gen_contents['dateto'] = $this->uri->segment(5);
                    } else {
                        $this->gen_contents['dateto'] = convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
                        $this->gen_contents['dateto'] = date('m/d/Y',strtotime($this->gen_contents['dateto']));
                    }
                    
                    $reports =  $this->admin_recruiter_model->get_brokerage_report($this->gen_contents["date_from"],$this->gen_contents["date_to"],$this->gen_contents["brokerage"],
                                $this->gen_contents["student_first_name"],$this->gen_contents["student_last_name"],$this->gen_contents["student_mail_id"],0,0,"excel");
                        
                    $row     = 5;
                    $no      = 1;
                    $this->load->library('Excel');
                    $this->excel->setActiveSheetIndex(0);
                    //name the worksheet
                    $this->excel->getActiveSheet()->setTitle('Referral Report');  
                    //set cell A1 content with some text
                    $this->excel->getActiveSheet()->setCellValue('A1', 'Referral Report ('.$dt_from.' - '. date('m/d/Y',strtotime($this->gen_contents['dateto'])).')');
               
                    $this->excel->getActiveSheet()->setCellValue('A4', 'Sl.no.');
                    $this->excel->getActiveSheet()->setCellValue('B4', 'Name');
                    $this->excel->getActiveSheet()->setCellValue('C4', 'Email');
                    $this->excel->getActiveSheet()->setCellValue('D4', 'Phone');
                    $this->excel->getActiveSheet()->setCellValue('E4', 'Residence Area');
                    $this->excel->getActiveSheet()->setCellValue('F4', 'Brokerage');
                    $this->excel->getActiveSheet()->setCellValue('G4', 'Created Date');
                    $this->excel->getActiveSheet()->setCellValue('H4', 'Referral');

                    $this->excel->getActiveSheet()->mergeCells('A1:H3');
                    //set aligment to center for that merged cell
                    $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('A4:H4')->getFont()->setBold(true);
                    //make the font become bold
                    $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
                    $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
                    $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');

                    for($col = ord('A'); $col <= ord('H'); $col++){
                       //set column dimension
                       $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
                        //change the font size
                       $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);

                       $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    }

                    foreach ($reports as $data){
                         $this->excel->getActiveSheet()->setCellValue('A'.$row,$no);
                         $this->excel->getActiveSheet()->setCellValue('B'.$row,ucfirst($data['student_first_name'])." ".ucfirst($data['student_last_name']));  
                         $this->excel->getActiveSheet()->setCellValue('C'.$row,$data['student_mail_id']);
                         $this->excel->getActiveSheet()->setCellValue('D'.$row,$data['student_phone_number']);
                         $this->excel->getActiveSheet()->setCellValue('E'.$row,$data['area_of_interest']);
                         $this->excel->getActiveSheet()->setCellValue('F'.$row,$data['recruiter_brokerage']);
                         $this->excel->getActiveSheet()->setCellValue('G'.$row,date("m-d-Y",strtotime($data['created_date'])));
                         $this->excel->getActiveSheet()->setCellValue('H'.$row,$data['count']);

                         $row++;
                         $no++;
                    }

               $filename = 'Referral_Report_'.date('m_d_Y').'_'.time().'.xls';       //save our workbook as this file name
               header('Content-Type: application/vnd.ms-excel');                   //mime type
               header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
               header('Cache-Control: max-age=0');                                 //no cache

               $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
               //ob_end_clean();
               $objWriter->save('php://output');
            }
                
           function check_recruiter_mail(){
                if(isset($_POST)){
                    $data = $this->admin_recruiter_model->checkPriorExists($_POST['email'],$_POST['recruiter']);
                    $date = '';
                    $recruiter = array();
                    
                    if(!empty($data)){
                        $proceed = 0;
                        $date = '';
                        $recruiter =  $this->admin_recruiter_model->select_single_recruiterdetails($data[0]['recruiter_referred'])->recruiter_brokerage;
                        foreach($data as $d){
                            $date .= convert_UTC_to_PST_date_slash($d['created_date']).",";
                        }
                        $date = substr($date, 0, -1);
                    }else{
                        $proceed = 1;
                    }
                    print(json_encode(array('proceed' => $proceed,'date' => $date, 'recruiter' => $recruiter)));
                    exit;
                }
           }
	}
/* End of file admin.php */
/* Location: ./system/application/controllers/admin_recruiter.php */