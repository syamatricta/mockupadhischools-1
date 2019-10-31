<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
	* Project				-	Adhischools
	* Language				-	PHP 5 & above
	* Database				-	Mysql
	* Author				-	Shinu Mary Simon	
	* Created On 			-	November 05, 2009
	* Modified On 			-	November 05, 2009
	* Development Center	-	Rain Concert Technologies Pvt Ltd, Trivandrum, Kerala, India.(http://aarthikaindia.com)
*/
// ------------------------------------------------------------------------ 
	class Profile extends Controller
	{
			
		/**
		 * General contents
		 *
		 * @var Array
		 */
		var $gen_contents	= array();
		var $userid 		= ''; 		/*Id of the selected user*/
		var $firstname		= "";			
		var $lastname		= '';		
		var $forumalias		= '';		
		var $address		= '';
		var $city		= '';			
		var $state		= '';
		var $zipcode		= '';
		var $phone		= '';
		var $s_address		= '';		/* shipping address*/
		var $s_city		= '';
		var $s_state		= '';
		var $s_zipcode		= '';
		var $b_address		= '';		/* billing address*/
		var $b_city		= '';
		var $b_state		= '';
		var $b_zipcode		= '';
		var $message		= '';
		/**
		 * Admin constructor
		 * 
		 */
        
		function Profile () {
                    parent::Controller();
                    $this->load->library('authentication');

                    $this->load->helper(array('form', 'file'));

                    if(!$this->authentication->logged_in("normal")){
                        loginto_continue_msg();
                    }
                    $this->load->library(array('form_validation'));
                    $this->load->model('admin_user_model');
                    $this->load->model('admin_sitepage_model');
                    $this->gen_contents['css']      = array('client_style.css'); //'client_style.css'
                    $this->gen_contents['js']       = array('client_profile_js.js','custom_element.js');
                    $this->gen_contents['title']    = 'Profile';
                    $this->gen_contents['forum']    = '';
                    $this->message['error']         = '';
                    $this->message['info']          = '';
			
		}
                
                /**
		 * Index - View profile
		 *
		 * @access public
		 */	
		function index(){
			$this->gen_contents["course"]       = array();
			$this->gen_contents['selected_nav'] = 'profile';
			$this->gen_contents['siteurl']      = $this->admin_sitepage_model->select_sitepages_url();
			$this->_user_details();
			$this->_template('view',$this->gen_contents);
		}
                
                /**
		 * function to show the interface for editing the user profile and show the user details
		 *
		 */
		function edit(){
			$this->gen_contents['page_title']   = 'Profile';
			$this->gen_contents["userid"]       = $this->session->userdata('USERID');
			$this->gen_contents['siteurl']      = $this->admin_sitepage_model->select_sitepages_url();
			$this->gen_contents["states"]       = $this->admin_user_model->select_states();
                        if($this->input->post('firstname')){
                            $this->userid   = $this->session->userdata('USERID');
                            $email          = $this->admin_user_model->select_single_userdetails($this->userid);
			
                            /* validating the fields*/
                            $this->_init_user_validation_rules();

                            if($this->form_validation->run() == TRUE) {
                                /* initialising the data*/
                                $this->_init_user_details();
                                $update = $this->_edit_user_details($this->userid );
                                if($update > 0){
                                    $this->session->set_userdata(array('USER_NAME' => $this->firstname, 'LAST_NAME' => $this->lastname));
                                    $this->session->set_flashdata ('success', 'Profile updated successfully');
                                }else{
                                    $this->session->set_flashdata ('error', 'Failed to update Profile');
                                }
                                redirect('profile/edit');
                            }
                        }
			$this->_user_details();
			$this->_template('edit',$this->gen_contents);
		}
			
		function _template ($page){
                    /*$this->load->view("client_common_header_new",$contents);
                    $this->load->view('user/profile/'.$page, $contents);
                    $this->load->view("client_common_footer_new");
                    */
                    $this->template->set_template('user');
                    $this->template->write_view('content', 'reskin/user/profile/'.$page, $this->gen_contents);
                    $this->template->render();
		}
		/**
		 * validating the user profile details in server side
		 *
		 */
		function _init_user_validation_rules () {
                    $this->form_validation->set_rules('firstname', 'First Name', 'trim|required|max_length[128]');
                    $this->form_validation->set_rules('lastname',  'Last Name', 'trim|required|max_length[128]');
                    //$this->form_validation->set_rules('forumalias', 'Forum Alias', 'required|min_length[3]|max_length[100]');

                    /*$this->form_validation->set_rules('txtAddress', 'Address', 'required|max_length[250]');
                    $this->form_validation->set_rules('txtCity', 'City', 'required');
                    $this->form_validation->set_rules('cmbstate', 'State', 'required');
                    $this->form_validation->set_rules('txtZip', 'Zip Code', 'required');*/

                    $this->form_validation->set_rules('phone',      'Phone Number', 'trim|required');
                    $this->form_validation->set_rules('address',    'Shipping Address', 'trim|required|max_length[250]');
                    $this->form_validation->set_rules('city',       'City', 'trim|required');
                    $this->form_validation->set_rules('state',      'State', 'trim|required');
                    $this->form_validation->set_rules('zipcode',    'Zip Code', 'trim|required');
                    $this->form_validation->set_rules('b_address',  'Billing Address', 'trim|required|max_length[250]');
                    $this->form_validation->set_rules('b_city',     'City', 'trim|required');
                    $this->form_validation->set_rules('b_state',    'State', 'trim|required');
                    $this->form_validation->set_rules('b_zipcode',  'Zip Code', 'trim|required');
		}
		/**
		 * Initialising the data
		 *
		 */
		function _init_user_details (){
			$this->load->model('common_model');
			$this->firstname			=	$this->input->post('firstname');
			$this->lastname				=	$this->input->post('lastname');
                        //Disabling forum for reskin version
			//$this->forumalias			=	$this->common_model->safe_html($this->input->post('forumalias'));
                        $this->unit_number			=	$this->input->post('unit_number');
            
			/*$this->address				=	$this->input->post('txtAddress');
			$this->city				=	$this->input->post('txtCity');			
			$this->state				=	$this->input->post('cmbstate');
			$this->zipcode				=	$this->input->post('txtZip');*/
            
                        $this->address				=	$this->input->post('address');
			$this->city				=	$this->input->post('city');			
			$this->state				=	$this->input->post('state');
			$this->zipcode				=	$this->input->post('zipcode');
			
			$this->phone				=	$this->input->post('phone');
			$this->s_address			=	$this->input->post('address');
			$this->s_city				=	$this->input->post('city');
			$this->s_state				=	$this->input->post('state');
			$this->s_zipcode			=	$this->input->post('zipcode');
			$this->b_address			=	$this->input->post('b_address');
			$this->b_city				=	$this->input->post('b_city');
			$this->b_state				=	$this->input->post('b_state');
			$this->b_zipcode			=	$this->input->post('b_zipcode');
		}
		/**
		 * function to get the user details
		 *
		 */
		function _user_details (){
                    $this->userid                           = $this->session->userdata('USERID');
                    $this->gen_contents["userdetails"]      = $this->admin_user_model->select_single_userdetails($this->userid);
                    $this->gen_contents["state"]            = $this->admin_user_model->select_state_name($this->gen_contents["userdetails"]->state);
                    $this->gen_contents["s_state"]          = $this->admin_user_model->select_state_name($this->gen_contents["userdetails"]->s_state);
                    $this->gen_contents["b_state"]          = $this->admin_user_model->select_state_name($this->gen_contents["userdetails"]->b_state);
                    $this->gen_contents["course_user_type"] = $this->admin_user_model->select_user_course_types($this->gen_contents["userdetails"]->course_user_type);
		}
				
		
		
		/**
		 * inner function to edit the user profile
		 *
		 * @param int $userid
		 */
		function _edit_user_details ($userid){ 
			
			$userarray	=	array(
                                                    'userid'		=>	$userid,
                                                    'firstname'         =>	$this->firstname,
                                                    'lastname'		=>	$this->lastname,	
                                                    //'forum_alias'     =>	$this->forumalias,
                                                    'unit_number'       =>	$this->unit_number,
                                                    'address'		=>	$this->address,				
                                                    'city'		=>	$this->city,					
                                                    'state'		=>	$this->state,
                                                    'zipcode'		=>	$this->zipcode,
                                                    'phone'		=>	$this->phone,
                                                    's_address'		=>	$this->s_address,
                                                    's_city'		=>	$this->s_city,
                                                    's_state'		=>	$this->s_state,
                                                    's_zipcode'		=>	$this->s_zipcode,
                                                    'b_address'		=>	$this->b_address,
                                                    'b_city'		=>	$this->b_city,
                                                    'b_state'		=>	$this->b_state,
                                                    'b_zipcode'		=>	$this->b_zipcode			
                                                );	
			return $this->admin_user_model->update_user_profile($userarray);
		}
                
		/**
		 * function to update the user profile (NOT USING)
		 *
		 */
		function update_profile () {
			$this->userid 	= 	$this->session->userdata('USERID');
			$email          =	$this->admin_user_model->select_single_userdetails($this->userid);
			
			
			/* validating the fields*/
			$this->_init_user_validation_rules();
			
			if($this->form_validation->run() == TRUE) {
				
				/* initialising the data*/
				$this->_init_user_details();
				$this->load->model('user_model');
				 $check_forumalias = $this->user_model->checkuser_forumalias($this->input->post('forumalias'),$this->userid);
				if($check_forumalias<= 0){
				
					require_once $this->config->item ('site_basepath').'system/application/libraries/vbintegration.php';
		
		                                $this->vbulletin = new xvbIntegration();
						//$vbInsert['username'] = $this->firstname.$this->lastname;
						$vbInsert['username'] = $this->forumalias;
					$vbInsert['email'] = $email->emailid;
						$this->vbulletin->xvbUpdate($vbInsert);
						$update = $this->_edit_user_details($this->userid );
						if($update > 0)
						{
							$this->session->set_flashdata ('success', 'Profile updated successfully');
							redirect('profile/edit_profile/');
						}
						else
						{
							$this->session->set_flashdata ('error', 'Request Failed');
							redirect('profile/edit_profile/');
						}
				} else {
					//$this->gen_contents['msg']= "Email/Forum Alias Already Exist";
					//$this->edit_profile();
					$this->session->set_flashdata ('error', "Forum Alias Already Exist");
					redirect('profile/edit_profile/');
				}
			}
			else {
				$this->edit_profile();
			}
		}
		
	}	
/* End of file profile.php */
/* Location: ./system/application/controllers/profile.php */