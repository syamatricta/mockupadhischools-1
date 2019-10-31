<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
	* Project				-	Adhischools
	* Language				-	PHP 5 & above
	* Database				-	Mysql
	* Author				-	Shinu Mary Simon
	* Created On 			-	October 23, 2009
	* Modified On 			-	October 23, 2009
	* Development Center	-	Rain Concert Technologies Pvt Ltd, Trivandrum, Kerala, India.(http://aarthikaindia.com)
*/
// ------------------------------------------------------------------------
	class Admin_user extends Controller
	{

		/**
		 * General contents
		 *
		 * @var Array
		 */
		var $gen_contents	=	array();
		var $userid 		=	''; 		/*Id of the selected user*/
		var $firstname		=	"";
		var $lastname		=	'';
		var $name_on_certificate = "";
		var $forumalias		=	'';
        var	$licensetype			=	'';
		var	$email			=	'';
		var	$address		=	'';
		var	$city			=	'';
		var	$state			=	'';
		var	$country		=	'';
		var	$zipcode		=	'';
		var	$phone			=	'';
                var     $note                   =       '';
		var	$s_address		=	'';			/* shipping address*/
		var	$s_city			=	'';
		var	$s_state		=	'';
		var	$s_country		=	'';
		var	$s_zipcode		=	'';
		var	$b_address		=	'';			/* billing address*/
		var	$b_city			=	'';
		var	$b_state		=	'';
		var	$b_country		=	'';
		var	$b_zipcode		=	'';
		/**
		 * Admin constructor
		 *
		 */
		function Admin_user () {
			parent::Controller();
			$this->load->library('authentication');
			$this->load->helper(array('form', 'file'));
			if (!$this->authentication->logged_in ("admin"))
			{
				redirect("admin");
			}
                        else if($this->authentication->logged_in ("admin") === "sub") 
                        {
                            $this->session->set_flashdata('success', $this->session->flashdata("success"));
                            redirect("admin/noaccess");
                            exit;
                        }
			$this->load->library(array('form_validation'));
			$this->load->model('admin_user_model');
			$this->gen_contents['css'] = array('admin_style.css','dhtmlgoodies_calendar.css');
			$this->gen_contents['js'] = array('admin_user_js.js','popcalendar.js');
			$this->gen_contents['title']	=	'User Management';

		}
		/**
		 * function to load the template (header, body and footer)
		 *
		 * @param string $page
		 * @param array $contents
		 */
		function _template ($page,$contents, $admin_folder='admin/user management/'){
			$this->load->helper('form');
			$this->load->view("admin_header",$contents);
			$this->load->view($admin_folder.$page, $contents);
			$this->load->view("admin_footer");
		}
		/**
		 * validating the user details in server side
		 *
		 */
		function _init_user_validation_rules () {
			$this->form_validation->set_rules('txtFirstName', 'First Name', 'required|max_length[128]');
			$this->form_validation->set_rules('txtLastName', 'Last Name', 'required|max_length[128]');
			$this->form_validation->set_rules('name_on_certificate', 'Certificate Name', 'required|max_length[255]');
			$this->form_validation->set_rules('forumalias', 'Forum Alias', 'required|min_length[3]|max_length[100]');
            //$this->form_validation->set_rules('license', 'Licence', 'required');
            $this->form_validation->set_rules('txtEmail', 'Email', 'required|max_length[128]');

			/*$this->form_validation->set_rules('txtAddress', 'Address', 'required|max_length[250]');
			$this->form_validation->set_rules('txtCity', 'City', 'required');
			$this->form_validation->set_rules('cmbstate', 'State', 'required');
			$this->form_validation->set_rules('cmbcountry', 'Country', 'required');
			$this->form_validation->set_rules('txtZip', 'Zip Code', 'required');*/

			$this->form_validation->set_rules('txtPhone', 'Phone Number', 'required');

			$this->form_validation->set_rules('s_txtAddress', 'Shipping Address', 'required|max_length[250]');
			$this->form_validation->set_rules('s_txtCity', 'City', 'required');
			$this->form_validation->set_rules('cmbstate_s', 'State', 'required');
			$this->form_validation->set_rules('cmbcountry_s', 'Country', 'required');
			$this->form_validation->set_rules('s_txtZip', 'Zip Code', 'required');
			$this->form_validation->set_rules('b_txtAddress', 'Billing Address', 'required|max_length[250]');
			$this->form_validation->set_rules('b_txtCity', 'City', 'required');
			$this->form_validation->set_rules('cmbstate_b', 'State', 'required');
			$this->form_validation->set_rules('cmbcountry_b', 'Country', 'required');
			$this->form_validation->set_rules('b_txtZip', 'Zip Code', 'required');
		}
		/**
		 * Initialising the data
		 *
		 */
		function _init_user_details (){
			$this->load->model('common_model');
			$this->firstname			=	$this->input->post('txtFirstName');
			$this->lastname				=	$this->input->post('txtLastName');
			$this->name_on_certificate = $this->common_model->safe_html($this->input->post('name_on_certificate'));
			$this->forumalias			=	$this->common_model->safe_html($this->input->post('forumalias'));
            $this->licensetype			=	$this->input->post('license');
            $this->unit_number			=	$this->input->post('txtUnitNumber');
			$this->email				=	$this->input->post('txtEmail');

			/*$this->address				=	$this->input->post('txtAddress');
			$this->city				=	$this->input->post('txtCity');
			$this->state				=	$this->input->post('cmbstate');
			$this->country				=	$this->input->post('cmbcountry');
			$this->zipcode				=	$this->input->post('txtZip');*/

			$this->address				=	$this->input->post('s_txtAddress');
			$this->city				=	$this->input->post('s_txtCity');
			$this->state				=	$this->input->post('cmbstate_s');
			$this->country				=	$this->input->post('cmbcountry_s');
			$this->zipcode				=	$this->input->post('s_txtZip');

			$this->phone				=	$this->input->post('txtPhone');
                        $this->note				=	$this->common_model->safe_html($this->input->post('txtNote'));
			$this->s_address			=	$this->input->post('s_txtAddress');
			$this->s_city				=	$this->input->post('s_txtCity');
			$this->s_state				=	$this->input->post('cmbstate_s');
			$this->s_country			=	$this->input->post('cmbcountry_s');
			$this->s_zipcode			=	$this->input->post('s_txtZip');
			$this->b_address			=	$this->input->post('b_txtAddress');
			$this->b_city				=	$this->input->post('b_txtCity');
			$this->b_state				=	$this->input->post('cmbstate_b');
			$this->b_country			=	$this->input->post('cmbcountry_b');
			$this->b_zipcode			=	$this->input->post('b_txtZip');

		}
		/**
		 * Index
		 *
		 * @access	public
		 */
		function index()
		{
			$this->list_user_details();
		}
		/**
		 * function to list the user details
		 *
		 */
		function list_user_details ()
		{
			$this->gen_contents["success_message"]='';
			if(!is_numeric($this->uri->segment(3))){
				$s_msg = ($this->uri->segment(3));
				$this->gen_contents["success_message"] = base64_decode($s_msg);
			}
			$this->load->model('common_model');
                        $this->load->model('admin_subadmin_model');
			$this->gen_contents['page_title']	=	'Users';
			$this->load->library('pagination');
			$config['base_url'] 				= 	base_url().'index.php/admin_user/list_user_details/';
			$config['per_page'] 				= 	'10';
			$config['uri_segment']  			=  	3;

			/*****sree 080710**/
			$this->gen_contents["search_firstname"] = '';
			$this->gen_contents["search_lastname"] = '';
			$this->gen_contents["search_email"] = '';
			$this->gen_contents["course_completed"]='';
                        
                        $this->gen_contents["search_phone"] = '';
                        $this->gen_contents["search_zipcode"] = '';

			if(!empty($_POST)) {
				$this->gen_contents["search_firstname"] = $this->common_model->safe_html($this->input->post('txtSrchFirstname'));
				//echo $this->gen_contents["search_firstname"];die();
				$this->gen_contents["search_lastname"] = $this->common_model->safe_html($this->input->post('txtSrchLastname'));
				$this->gen_contents["search_email"] = $this->common_model->safe_html($this->input->post('txtSrchEmail'));
				$this->gen_contents["course_completed"] = $this->common_model->safe_html($this->input->post('course_completed'));
				$this->gen_contents["license_type"] = $this->common_model->safe_html($this->input->post('license_type'));
                                
                                $this->gen_contents["search_phone"] = $this->common_model->safe_html($this->input->post('txtSrchPhone'));
                                $this->gen_contents["search_zipcode"] = $this->common_model->safe_html($this->input->post('txtSrchZipcode'));
			}else {
				$this->gen_contents["search_firstname"] = ($this->session->flashdata('search_firstname'))?$this->session->flashdata('search_firstname'):$this->gen_contents["search_firstname"];
				$this->gen_contents["search_lastname"] = $this->session->flashdata('search_lastname');
				$this->gen_contents["search_email"] = $this->session->flashdata('search_email');
				$this->gen_contents["course_completed"] = $this->session->flashdata('course_completed');
				$this->gen_contents["license_type"] = $this->session->flashdata('license_type');
                                
                                $this->gen_contents["search_phone"] = $this->session->flashdata('search_phone');
                                $this->gen_contents["search_zipcode"] = $this->session->flashdata('search_zipcode');
			}
			$this->session->set_flashdata('search_firstname',$this->gen_contents["search_firstname"]);
			$this->session->set_flashdata('search_lastname',$this->gen_contents["search_lastname"]);
			$this->session->set_flashdata('search_email',$this->gen_contents["search_email"]);
			$this->session->set_flashdata('course_completed',$this->gen_contents["course_completed"]);
			$this->session->set_flashdata('license_type',$this->gen_contents["license_type"]);
                        
                        $this->session->set_flashdata('search_phone',$this->gen_contents["search_phone"]);
                        $this->session->set_flashdata('search_zipcode',$this->gen_contents["search_zipcode"]);
			/*****sree 080710**/
			if($this->gen_contents["course_completed"]){

				$this->gen_contents["userdetails"]	=	$this->admin_user_model->select_userdetails_completed($config['per_page'],$this->uri->segment(3),$this->gen_contents["search_firstname"],$this->gen_contents["search_lastname"],$this->gen_contents["search_email"], $this->gen_contents["license_type"],$this->gen_contents["search_phone"],$this->gen_contents["search_zipcode"]);
				$config['total_rows']   			= 	$this->admin_user_model->qry_count_userdetails_completed($this->gen_contents["search_firstname"],$this->gen_contents["search_lastname"],$this->gen_contents["search_email"],$this->gen_contents["license_type"],$this->gen_contents["search_phone"],$this->gen_contents["search_zipcode"]);

			}else{

				$this->gen_contents["userdetails"]	=	$this->admin_user_model->select_userdetails($config['per_page'],$this->uri->segment(3),$this->gen_contents["search_firstname"],$this->gen_contents["search_lastname"],$this->gen_contents["search_email"], $this->gen_contents["license_type"],$this->gen_contents["search_phone"],$this->gen_contents["search_zipcode"]);
				$config['total_rows']   			= 	$this->admin_user_model->qry_count_userdetails($this->gen_contents["search_firstname"],$this->gen_contents["search_lastname"],$this->gen_contents["search_email"],$this->gen_contents["license_type"],$this->gen_contents["search_phone"],$this->gen_contents["search_zipcode"]);
			}
			$this->pagination->initialize($config);
			$this->gen_contents['paginate']     =   $this->pagination->create_links(true);
			$this->_template('list_user_details',$this->gen_contents);
		}
		/**
		 * function to get the user details
		 *
		 */
		function _user_details ($userid)
		{
			$this->userid 						= 	$userid;
			$this->gen_contents["userdetails"]	=	$this->admin_user_model->select_single_userdetails($this->userid);
			$this->gen_contents["state"]		=	$this->admin_user_model->select_state_name($this->gen_contents["userdetails"]->state);
			$this->gen_contents["s_state"]		=	$this->admin_user_model->select_state_name($this->gen_contents["userdetails"]->s_state);
			$this->gen_contents["b_state"]		=	$this->admin_user_model->select_state_name($this->gen_contents["userdetails"]->b_state);
                        $this->gen_contents["course_user_type"] =	$this->admin_user_model->select_user_course_types($this->gen_contents["userdetails"]->course_user_type);
		/* course details*/
			$this->gen_contents["coursedetails"]=	$this->admin_user_model->select_single_user_course_details($this->userid);
		}
		/**
		 * function to view the user details
		 *
		 */
		function view_users (){
			$this->gen_contents["course"]		=	array();
			$this->gen_contents['page_title']	=	'User Details';

			$this->session->set_flashdata('search_firstname',$this->session->flashdata('search_firstname'));
			$this->session->set_flashdata('search_lastname',$this->session->flashdata('search_lastname'));
			$this->session->set_flashdata('search_email',$this->session->flashdata('search_email'));
			$this->session->set_flashdata("course_completed",$this->session->flashdata('course_completed'));

			$this->_user_details($this->uri->segment(3));

			$this->_template('view_user_details',$this->gen_contents);
		}
		/**
		 * function to edit the user details
		 *
		 */
		function edit_users (){
			$this->gen_contents['page_title']	=	'Edit User Details';
			$this->gen_contents["userid"]		=	$this->uri->segment(3);

			$this->session->set_flashdata('search_firstname',$this->session->flashdata('search_firstname'));
			$this->session->set_flashdata('search_lastname',$this->session->flashdata('search_lastname'));
			$this->session->set_flashdata('search_email',$this->session->flashdata('search_email'));
			$this->session->set_flashdata("course_completed",$this->session->flashdata('course_completed'));

			$this->gen_contents["allstate"]		=	$this->admin_user_model->select_states();
			$this->_user_details($this->gen_contents["userid"]);
			$this->_template('edit_user_details',$this->gen_contents);
		}
		/**
		 * inner function to edit the user details
		 *
		 * @param int $userid
		 */
		function _edit_user_details ($userid){
			$current_courseusertype = $this->admin_user_model->select_course_user_type($userid);
			$course_user_type = $current_courseusertype->course_user_type;
			$licensetype = $current_courseusertype->licensetype;

			if($licensetype !=$this->licensetype ){
				if('B' == $this->licensetype){
					$licensetype = $this->licensetype;
					if($course_user_type == 5 || $course_user_type == 6){
						$course_user_type = 2;
					} else if($course_user_type == 7 || $course_user_type == 8){
						$course_user_type = 4;
					} else {
						$course_user_type = $course_user_type;
					}
				}else {
					$course_user_type = $course_user_type;
					$licensetype = $licensetype;
				}
			}else {
				$course_user_type = $course_user_type;
				$licensetype = $licensetype;
			}

			$userarray	=	array(
								'userid'		=>	$userid,
								'firstname' 	=>	$this->firstname,
								'lastname'		=>	$this->lastname,
								'name_on_certificate' => $this->name_on_certificate,
								'forum_alias'	=>	$this->forumalias,
                                'unit_number'	=>	$this->unit_number,
                                'licensetype'	=>	$licensetype,
                                'course_user_type'=> $course_user_type,
								'email'			=>	$this->email,
								'address'		=>	$this->address,
								'city'			=>	$this->city,
								'state'			=>	$this->state,
								'country'		=>	$this->country,
								'zipcode'		=>	$this->zipcode,
								'phone'			=>	$this->phone,
                                                                'note'                  =>      $this->note,
								's_address'		=>	$this->s_address,
								's_city'		=>	$this->s_city,
								's_state'		=>	$this->s_state,
								's_country'		=>	$this->s_country,
								's_zipcode'		=>	$this->s_zipcode,
								'b_address'		=>	$this->b_address,
								'b_city'		=>	$this->b_city,
								'b_state'		=>	$this->b_state,
								'b_country'		=>	$this->b_country,
								'b_zipcode'		=>	$this->b_zipcode
								);
                       
			return $this->admin_user_model->update_user_details($userarray);
		}
		/**
		 * function to update the user details
		 *
		 */
		function update_users () {
			$this->userid 	= 	$this->input->post('hiduserid');
			$this->email	=	$this->input->post('txtEmail');
			$this->forumalias=	$this->input->post('forumalias');
			/* validating the fields*/
			$this->_init_user_validation_rules();

			if($this->form_validation->run() == TRUE) {

				/* initialising the data*/
				$this->_init_user_details();


				$emailexist = $this->admin_user_model->check_user_email($this->userid,$this->email);
				$forumalaisexist = $this->admin_user_model->check_user_forumalias($this->userid,$this->forumalias);

				/* updating the user details*/
				if(0 == count($emailexist) && $forumalaisexist<=0){

					//$vbInsert['username'] = $email;
					//$vbInsert['username'] = $this->firstname.$this->lastname;
					$vbInsert['username'] = $this->forumalias;
					$vbInsert['email'] = $this->email;

					$site_basepath = $this->config->item ('site_basepath');
					require_once $site_basepath.'system/application/libraries/vbintegration.php';

					$this->vbulletin = new xvbIntegration();

					$this->vbulletin->xvbUpdate($vbInsert);
					$update = $this->_edit_user_details($this->userid );
				} else {
					if(count($emailexist) > 0){
						$this->session->set_flashdata ('error', 'Email id already exist. Please choose another one');
					} else if($forumalaisexist > 0){
						$this->session->set_flashdata ('error', 'Forum Alias already exist. Please choose another one');
					}

					redirect('admin_user/edit_users/'.$this->userid.'/'.$this->uri->segment(4));
				}

				if($update > 0)
				{
					$this->session->set_flashdata ('success', 'User details updated successfully');
					redirect('admin_user/edit_users/'.$this->userid.'/'.$this->uri->segment(4));
				}
				else
				{
					$this->session->set_flashdata ('error', 'Request Failed');
					redirect('admin_user/edit_users/'.$this->userid.'/'.$this->uri->segment(4));
				}
			}
			else {
				$this->edit_users();
			}
		}
		/**
		 * function to freeze user
		 *
		 */
		function freeze_user() {
			$this->userid 	= 	$this->uri->segment(3);
			$this->gen_contents['userid'] = $this->userid;
			$this->gen_contents['reason'] = $this->input->post('txtReason');
			$freeze_user	=	$this->admin_user_model->freeze_user($this->gen_contents);
			if($freeze_user >0)
			{
				$this->session->set_flashdata ('success', 'User freezed successfully');
				redirect('admin_user/list_user_details/'.$this->uri->segment(4));
			}
			else
			{
				$this->session->set_flashdata ('error', 'Request Failed');
				redirect('admin_user/list_user_details/'.$this->uri->segment(4));
			}
		}
		/**
		 * function to get the course selected by a user
		 *
		 */
		function user_course_details () {
			$this->gen_contents['page_title']	= 'User Course Details';
			$this->userid 						= $this->uri->segment(3);

			$this->session->set_flashdata('search_firstname',$this->session->flashdata('search_firstname'));
			$this->session->set_flashdata('search_lastname',$this->session->flashdata('search_lastname'));
			$this->session->set_flashdata('search_email',$this->session->flashdata('search_email'));
			$this->session->set_flashdata("course_completed",$this->session->flashdata('course_completed'));

			$this->gen_contents['userid']		= $this->userid;
			$this->gen_contents["coursedetails"]= $this->admin_user_model->select_single_user_course_details($this->userid);
			
			/*** sree 070410**/
			$this->load->model('course_model');
                        $this->load->model('user_model');
			$license= $this->course_model->get_license($this->userid);
                        $course_user_type= $this->user_model->get_course_user_type($this->userid);
                        /* Get new package for sales*/
                         $package_type= $this->course_model->get_user_package_type($this->userid);
                         //Added to enable course edit to types
                         if(1==$course_user_type){
                                $course_user_type =2;
                            }else if(3==$course_user_type){
                                $course_user_type =4;
                            }else if(5==$course_user_type){
                                $course_user_type =6;
                            }else if(7==$course_user_type){
                                $course_user_type =8;
                            }else {
                                $course_user_type =$course_user_type;
                            } 
                            
                         if($course_user_type==2 || $course_user_type==4 || $course_user_type==6 || $course_user_type==8 || $package_type==1){

                          $this->gen_contents['add_status']	= $this->course_model->check_addcourse($this->userid,$license,$course_user_type);
                         }else{
                         $this->gen_contents['add_status'] = false;
                         
                        }
			/*** sree 070410 ***/

			$arr_quiz		= array();
			$arr_user_quiz	= $this->admin_user_model->getQuizCountForUser($this->userid);
			foreach ($arr_user_quiz as $val){
				$arr_quiz[] = $val->course_id;
			}
			
			/* Exam attended details exist or not starts here */
			$this->load->model('user_exam_model');
			$exam_attended_exist				= false;
			foreach ($this->gen_contents["coursedetails"] as $key	=> $coursedetail){
				$this->gen_contents["coursedetails"][$key]->exam_attended_exist	= $this->user_exam_model->isUserAttendedCourse($this->userid, $coursedetail->courseid);
                                if($coursedetail->renewal_status == 'Y'){
                                    $this->gen_contents["coursedetails"][$key]->renew_expired    = $this->user_exam_model->isRenewExpired($coursedetail->id);
                                } else{
                                    $this->gen_contents["coursedetails"][$key]->renew_expired     = 'N';
                                }
			}
			/* Exam attended details exist or not ends here */
			
			$this->gen_contents["arr_quiz"]		= $arr_quiz;
			$this->gen_contents["username"]		= $this->admin_user_model->select_single_userdetails($this->userid);
			$this->_template('user_course_details',$this->gen_contents);
		}
		/**
		 * function to get the course selected by a user
		 *
		 */
		function user_courses () {
			$this->gen_contents['page_title']	= 'User Course Details';
			$this->userid 						= $this->uri->segment(3);
			$this->orderid 						= $this->uri->segment(4);

			$this->session->set_flashdata('search_firstname',$this->session->flashdata('search_firstname'));
			$this->session->set_flashdata('search_lastname',$this->session->flashdata('search_lastname'));
			$this->session->set_flashdata('search_email',$this->session->flashdata('search_email'));
			$this->session->set_flashdata("course_completed",$this->session->flashdata('course_completed'));

			$this->gen_contents['userid']		= $this->userid;
			$this->gen_contents["coursedetails"]= $this->admin_user_model->select_single_user_course_order_details($this->userid,$this->orderid);
			$this->gen_contents["username"]		= $this->admin_user_model->select_single_userdetails($this->userid);
			$this->_template('user_courses',$this->gen_contents);
		}
		/**
		 * function to edit the effective date
		 *
		 */
		function edit_effective_date () {
			$count					=	$this->input->post('hidcount');
			$this->gen_contents['userid'] 		= 	$this->uri->segment(3);
			$this->gen_contents['courseid'] 	= 	$this->uri->segment(4);
			$this->gen_contents['effectivedate']    = 	$this->input->post('txtEffective'.$count);
			$this->gen_contents['enrolleddate']     = 	$this->input->post('txtenrolled'.$count);
			$this->gen_contents['edition']          = 	$this->input->post('edition'.$count);
			$this->gen_contents['ship_status']      = 	$this->admin_user_model->get_ship_status($this->gen_contents['courseid'], $this->gen_contents['userid']);
                        if($this->_validate_effective_date($this->gen_contents)){
                            $update = $this->admin_user_model->update_course_effective_date($this->gen_contents);

                            if($update > 0){
                                $this->session->set_flashdata ('success', "updated successfully");
                                redirect("admin_user/user_course_details/".$this->gen_contents['userid'].'/'.$this->uri->segment(5) );
                            }else{
                                $this->session->set_flashdata ('error', 'Request Failed');
                                redirect("admin_user/user_course_details/".$this->gen_contents['userid'].'/'.$this->uri->segment(5) );
                            }
                        }else{
                            $this->session->set_flashdata ('error', 'Your operation is against the 18 day rule');
                            redirect("admin_user/user_course_details/".$this->gen_contents['userid'].'/'.$this->uri->segment(5) );
                        }
			
		}
                
                /**
                 * Validate the effective date pass the 18day rule (effective date be less than 18 days from delivered date)
                 * First count of user attended exams that have same delivered date, and increase the count if the current course exam is not attempted yet
                 * Create a compared date of next effective date, satisfying 18 day rule
                 * Return false, if the modifying date  is less than compared date
                 */
                function _validate_effective_date($params){
                    return TRUE;//Will remove after implimenting new 18 day rule
                    $user_course    =  $this->admin_user_model->get_user_course($params['userid'], $params['courseid']);
                    if($user_course && ('' != $user_course->delivered_date && '0000-00-00' != $user_course->delivered_date) && '' != $params['effectivedate']){
                        
                        //Count of user attended exams that have same delivered date
                        $delivered_course_count = $this->admin_user_model->delivered_course_count($params['userid'], $user_course->delivered_date);
                        
                        //Increasing count if the course exam(the course that admin is going to change effective date) is not attempted yet
                        if('0000-00-00' == $user_course->last_attemptdate){
                            $delivered_course_count++;
                        }
                        
                        $day_inc    = $delivered_course_count * 18 - 1;
                        $comp_date = strtotime(date("Y-m-d", strtotime($user_course->delivered_date)) . " +{$day_inc} day");
                        
                        //Return False if the modifying date is less than the comparing date 
                        if($comp_date > strtotime(date('Y-m-d', strtotime($params['effectivedate'])))){
                            return FALSE;
                        }
                    }else if('' == $user_course->delivered_date || '0000-00-00' == $user_course->delivered_date){
                        //If the course delivered date is null, need to remove the effective date data from update array
                        if(isset($this->gen_contents['effectivedate'])){unset($this->gen_contents['effectivedate']);};
                    }
                    return TRUE;
                }
                
		function edit_effective_date_det () {
			$count								=	$this->input->post('hidcount');
			$this->gen_contents['userid'] 		= 	$this->uri->segment(3);
			$this->gen_contents['courseid'] 	= 	$this->uri->segment(4);
			$this->gen_contents['effectivedate']= 	$this->input->post('txtEffective'.$count);
			$this->gen_contents['enrolleddate']= 	$this->input->post('txtenrolled'.$count);
			$this->gen_contents['ship_status']= 	$this->admin_user_model->get_ship_status($this->gen_contents['courseid'],$this->gen_contents['userid']);
			$this->gen_contents['edition']= 	$this->input->post('edition'.$count);
			$update = $this->admin_user_model->update_course_effective_date($this->gen_contents);

			if($update > 0)
			{
				$this->session->set_flashdata ('success', "updated successfully");
				redirect("admin_user/user_courses/".$this->gen_contents['userid'].'/'.$this->uri->segment(5) );
			}
			else
			{
				$this->session->set_flashdata ('error', 'Request Failed');
				redirect("admin_user/user_courses/".$this->gen_contents['userid'].'/'.$this->uri->segment(5) );
			}
		}
		/**
		 * function to view the order details of a user
		 *
		 */
		function view_order_details() {
			$this->userid 						= 	$this->uri->segment(3);
			$this->gen_contents['page_title']	=	'View Order Details';

			$this->session->set_flashdata('search_firstname',$this->session->flashdata('search_firstname'));
			$this->session->set_flashdata('search_lastname',$this->session->flashdata('search_lastname'));
			$this->session->set_flashdata('search_email',$this->session->flashdata('search_email'));
			$this->session->set_flashdata("course_completed",$this->session->flashdata('course_completed'));

			$this->_user_details($this->userid);
			//$this->gen_contents["username"]		= 	$this->admin_user_model->select_single_userdetails($this->userid);
			$this->gen_contents['orderdet']		=	$this->admin_user_model->select_single_user_order_details($this->userid);
			$this->gen_contents['freezedorder']	=	$this->admin_user_model->select_single_user_freezed_order_details($this->userid);

			//$this->gen_contents['shiporder']	=	$this->admin_user_model->ship_order_details($this->userid);
			//$this->_user_details();

			$this->_template('view_order_details',$this->gen_contents);
		}
		function _insert_freezed_order($userid,$orderid,$reason){
			$order 	= $this->admin_user_model->select_single_user_single_order($userid,$orderid);
			$orderarray	=	array(
								'order_id'			=>	$order->id,
								'userid' 			=>	$order->userid,
								'b_address'			=>	$order->b_address,
								'b_city'			=>	$order->b_city,
								'b_state' 			=>	$order->b_state,
								'b_zipcode'			=>	$order->b_zipcode,
								'b_country'			=>	$order->b_country,
								's_address'			=>	$order->s_address,
								's_city'			=>	$order->s_city,
								's_state'			=>	$order->s_state,
								's_zipcode'			=>	$order->s_zipcode,
								's_country'			=>	$order->s_country,
								'transactionid'		=>	$order->transactionid,
								'orderdate'			=>	$order->orderdate,
								'ship_method'		=>	$order->ship_method,
								'payment_method'	=>	$order->payment_method,
								'ship_rate'			=>	$order->ship_rate,
								'course_price'		=>	$order->course_price,
								'total_amount'		=>	$order->total_amount,
								'delivered_date'	=>	$order->delivered_date,
								'trackingno'		=>	$order->trackingno,
								'last_trackdate'	=>	$order->last_trackdate,
								'current_location'	=>	$order->current_location,
								'status'			=>	$order->status,
								'reason'			=>	$reason
							);
			if($this->admin_user_model->insert_freezed_order_details($orderarray)){

				$this->_insert_freezed_order_course($userid,$orderid);

			   $result=  $this->admin_user_model->delete_freezed_order($orderid);
			   if($result>0){
			   	return TRUE;
			   }
			}
		}

		function _insert_freezed_order_course($userid,$orderid){
			$course_order = $this->admin_user_model->select_single_user_single_order_course($userid,$orderid);
			foreach($course_order as $courseorder){
				$ordercoursearray	=	array(
												'userid'						=>	$courseorder->userid,
												'courseid' 						=>	$courseorder->courseid,
												'orderid'						=>	$courseorder->orderid,
												'enrolled_date'					=>	$courseorder->enrolled_date,
												'delivered_date' 				=>	$courseorder->delivered_date,
												'effective_date'				=>	$courseorder->effective_date,
												'reason_changing_effective_date'=>	$courseorder->reason_changing_effective_date,
												'final_score'					=>	$courseorder->final_score,
												'last_attemptdate'				=>	$courseorder->last_attemptdate,
												'renewal_status'				=>	$courseorder->renewal_status,
												'status'						=>	$courseorder->status,
												'effective_date_status'			=>	$courseorder->effective_date_status,
												);
				if($this->admin_user_model->insert_freezed_order_course_details($ordercoursearray)){
					 $this->admin_user_model->delete_freezed_order_course($courseorder->id);
				}

			}


		}
		/**
		 * function to freeze the order details
		 *
		 */
		function freeze_order(){
			$this->userid 	= 	$this->uri->segment(3);
			$this->orderid 	= 	$this->uri->segment(4);
			$this->gen_contents['userid'] = $this->userid;
			$this->gen_contents['orderid'] = $this->orderid;
			$this->gen_contents['reason'] = $this->input->post('txtReason');

			$freese_order = $this->_insert_freezed_order($this->userid,$this->orderid,$this->gen_contents['reason']);


			if($freese_order)
			{
				$this->session->set_flashdata ('success', 'Order freezed successfully');
				redirect('admin_user/view_order_details/'.$this->userid);
			}
			else
			{
				$this->session->set_flashdata ('error', 'Request Failed');
				redirect('admin_user/view_order_details/'.$this->userid);
			}

		}
		/**
		*function to ship order
		*
		*/

		/*function ship_order(){

			$this->orderid = $this->uri->segment(3);
			$this->userid = $this->uri->segment(4);
			$this->gen_contents['shipdetails'] = $this->admin_user_model->select_single_order_details($this->orderid );
			$this->gen_contents['admindetails'] = $this->admin_user_model->get_admin_details();
			$course_weight=$this->admin_user_model->get_courseweight($this->orderid);
			$ship = $this->admin_user_model->shiporder($this->gen_contents['shipdetails'],$course_weight,$this->gen_contents['admindetails']);
			if($ship !='error'){
				$this->admin_user_model->update_orderdetails($this->orderid,$ship[29],$ship['label']);
				$this->gen_contents["userdetails"]	=	$this->admin_user_model->select_single_userdetails($this->userid);
				$this->gen_contents['orderdetails'] = $this->admin_user_model->select_single_order_details($this->orderid );
				$this->admin_user_model->mail_touser($this->gen_contents["userdetails"],$this->gen_contents['orderdetails']);
				$this->session->set_flashdata ('success', 'Order shipped successfully');
				redirect('admin_user/view_order_details/'.$this->gen_contents['shipdetails']['id']);

			}else{

				$this->session->set_flashdata ('error', 'Request Failed');
				redirect('admin_user/view_order_details/'.$this->gen_contents['shipdetails']['id']);

			}
		}*/

		/**** sree 070410 */
		/**
		 * function for list remaining course
		 *
		 */
		function listremainingcourse(){

			$this->load->helper("form");
			$this->load->model('Common_model');
			$this->load->model('user_model');
                        $this->load->model('course_model');
			$this->userid = $this->uri->segment(3);
			$page_submit_error	=	FALSE;
/*print "<pre>";
print_r($_POST);
print "</pre>";
exit();*/
			
                        if(!empty($_POST) && isset($_POST['price'])) {
					if($this->_init_new_order() == false) {
						$page_submit_error	=	FALSE;
					}
			} else {
						$page_submit_error	=	FALSE;
			}

			$this->session->set_flashdata('search_firstname',$this->session->flashdata('search_firstname'));
			$this->session->set_flashdata('search_lastname',$this->session->flashdata('search_lastname'));
			$this->session->set_flashdata('search_email',$this->session->flashdata('search_email'));
			$this->session->set_flashdata("course_completed",$this->session->flashdata('course_completed'));

			if($page_submit_error == FALSE) {

                                
				$this->gen_contents['userid']=$this->userid;
				$this->gen_contents['license']= $this->user_model->get_license($this->userid);
                                $course_user_type= $this->user_model->get_course_user_type($this->userid);
                                
                                /* Get new package for sales*/
                                $package_type= $this->course_model->get_user_package_type($this->userid);
                                $course_user_typeM = 0; 
                                if($package_type ==1)
                                {
                                    $course_user_type = 13;
                                    $course_user_typeM = 11;
                                }
                                
                                //Added to enable course edit to types
                                 if(1==$course_user_type){
                                        $course_user_type =2;
                                    }else if(3==$course_user_type){
                                        $course_user_type =4;
                                    }else if(5==$course_user_type){
                                        $course_user_type =6;
                                    }else if(7==$course_user_type){
                                        $course_user_type =8;
                                    }else {
                                        $course_user_type =$course_user_type;
                                    }
                                    
				$this->gen_contents['coursearr']=$this->Common_model->listallcourses_type($course_user_type);
                                if($package_type ==1)
                                {
                                    $course_user_typeM_arr = $this->Common_model->listallcourses_type($course_user_typeM);
                                    $this->gen_contents['coursearr'] = array_merge($this->gen_contents['coursearr'],$course_user_typeM_arr);
                                }
                                //echo "<pre>";print_r($this->gen_contents['coursearr']);
				$billing= $this->user_model->get_b_address($this->userid);
				$shipping= $this->user_model->get_s_address($this->userid);
				$this->gen_contents['billing'] =$billing[0];
				$this->gen_contents['shipping'] =$shipping[0];
				$this->gen_contents['phone'] = $this->gen_contents['billing']['phone'];
				$this->gen_contents['firstname'] = $this->gen_contents['billing']['firstname'];
				$this->gen_contents['lastname'] = $this->gen_contents['billing']['lastname'];
				$this->gen_contents['emailid'] = $this->gen_contents['billing']['emailid'];

				$this->gen_contents['subcourses']=$this->Common_model->sub_remain_courselist($this->userid);
                                
                                 
                                    
				if($this->gen_contents['license'] == 'S'){
					
                                        if($this->gen_contents['subcourses'] != false){  
                                            if($package_type ==1) {
                                                
                                                $this->gen_contents['courses_m']=$this->Common_model->license_remain_courselist_m($this->gen_contents['license'],$this->userid,$course_user_typeM);
                                               
                                            }
                                            else { 
                                                $this->gen_contents['courses_m']=$this->Common_model->license_remain_courselist_m($this->gen_contents['license'],$this->userid,$course_user_type);
                                                
                                                
                                            }
					
					}
					else{ 
					$this->gen_contents['courses_m']=$this->Common_model->license_remain_courselist_nm($this->gen_contents['license'],$this->userid,$course_user_type);
					//$this->gen_contents['courses_mt']=$this->Common_model->license_remain_courselist_nmt($this->gen_contents['license'],$this->userid);
					}
					$this->gen_contents['courses_o']=$this->Common_model->license_remain_courselist_o($this->gen_contents['license'],$this->userid,$course_user_type);
                                        
                                        
                                }
				if($this->gen_contents['license'] == 'B'){ 
					if($this->gen_contents['subcourses'] != false){
					//echo "hi2";
					$this->gen_contents['courses_mb']=$this->Common_model->license_remain_courselist_mb($this->gen_contents['license'],$this->userid,$course_user_type);
					//print_r($this->gen_contents['courses_mb']);
					$this->gen_contents['courses_mt']=$this->Common_model->license_remain_courselist_mt($this->gen_contents['license'],$this->userid,$course_user_type);
					$this->gen_contents['countmt'] = count($this->gen_contents['courses_mb']);
					if($this->gen_contents['countmt']>3)
					$this->gen_contents['countmt'] =3;
					$this->gen_contents['countnum'] = $this->Common_model->convertNum($this->gen_contents['countmt']);
					}
					else{

					$this->gen_contents['courses_mb']=$this->Common_model->license_remain_courselist_nmb($this->gen_contents['license'],$this->userid,$course_user_type);
					$this->gen_contents['courses_mt']=$this->Common_model->license_remain_courselist_nmt($this->gen_contents['license'],$this->userid,$course_user_type);
					$this->gen_contents['countmt'] = count($this->gen_contents['courses_mb']);
					if($this->gen_contents['countmt']>3)
					$this->gen_contents['countmt'] =3;
					$this->gen_contents['countnum'] = $this->Common_model->convertNum($this->gen_contents['countmt']);
					}

				}


				$this->gen_contents['state'] = $this->user_model->get_state();
				$this->gen_contents['month']=$this->user_model->listmonth();
				$currentyear=convert_UTC_to_PST_year(date('Y-m-d H:i:s'));
				$this->gen_contents['year']=$this->user_model->listyear($currentyear);
			}

			$this->gen_contents['css'] 	= array_merge($this->gen_contents['css'],array('admin_register.css','style.css'));
			$this->gen_contents['js'] 	= array_merge($this->gen_contents['js'],array('admin_newcourse.js'));
			//$this->_template('remaincourse',$this->gen_contents);
			$this->load->view("admin_addcourse_header",$this->gen_contents);
			$this->load->view('admin/user management/remaincourse', $this->gen_contents);
			$this->load->view("admin_footer");


		}

		/**
		 * function for add new course
		 *
		 */
		function _init_new_order(){
		        $_POST['price']=0;
			$this->load->helper("form");

			//Registration step2

				$this->load->library("form_validation");
				$this->load->model('Common_model');
				$this->load->model('user_model');

				if(!empty($_POST)) {

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

								$this->new_order_contents['userid'] =$this->userid;
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
								$this->_init_user_order_details($this->userid);
								$this->order_contents['userid'] = $this->userid;
								$this->order_contents['ship_method'] ='Admin';
								$result1=$this->user_model->order($this->order_contents);

								$effective_time = strtotime(date("Y-m-d", strtotime($this->order_contents['orderdate'])) . " +17 day");
								$effective_date	= date('Y-m-d', $effective_time) ;

								$this->course_contents =array(
															"course" => $this->input->post('course'),
															"subcourse"=> $subcourseid,
															"course_o"=> $course_o,
															"userid" => $this->new_order_contents['userid'],
															"orderid" => $result1,
															"enrolled_date" =>$this->order_contents['orderdate'],
															"delivered_date"=>$this->order_contents['orderdate'],
															"effective_date"=>$effective_date
															);
								$result2	=	$this->admin_user_model->usercourse_admin($this->course_contents);
								$admindetails= $this->user_model->get_admin();


								//$this->user_model->new_send_mailto_user($this->new_mail_contents,$this->new_order_contents,$this->order_updates);
							//	$this->user_model->new_send_mailto_admin($this->new_mail_contents,$this->new_order_contents,$admindetails,$this->order_updates);

								$this->session->set_flashdata('success','New Courses Added Successfully');
								redirect("admin_user/user_course_details/".$this->userid);
			}
			else{
					$this->gen_contents["msg"]="Failed to process please try again ";
					return false;
				}

		}



		function _init_user_order_details($user_id) {

			$delivered_date	=	convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
			$billing_address  	= $this->user_model->get_b_address($user_id);
			$ship_details 		= $this->user_model->get_s_address($user_id);

			$this->order_contents =array(
							"b_address" 		=> 	$billing_address[0]['b_address'],
							"b_state" 			=> 	$billing_address[0]['b_state'],
							"b_city" 			=> 	$billing_address[0]['b_city'],
							"b_zipcode" 		=> 	$billing_address[0]['b_zipcode'],
							"b_country" 		=> 	$billing_address[0]['b_country'],
							"s_address" 		=> 	$ship_details[0]['s_address'],
							"s_country" 		=>	$ship_details[0]['s_country'],
							"s_state" 			=> 	$ship_details[0]['s_state'],
							"s_city"			=> 	$ship_details[0]['s_city'],
							"s_zipcode" 		=> 	$ship_details[0]['s_zipcode'],
							"total_amount"		=> 	$this->input->post('totalprice'),
							"ship_rate" 		=> 	$this->input->post('shipprice'),
							"course_price" 		=> 	$this->input->post('price'),
							"transactionid"		=> 	'',
							"payment_method"	=> 'By Admin',
							"orderdate" 		=> 	convert_UTC_to_PST_date(date('Y-m-d H:i:s')),
							"delivered_date"	=>	$delivered_date,
							"ship_status"		=>	'N',
							"status"			=>	'C'
							);

		}


		/**** sree 070410 */
		/**
		 * function used to display the quiz detials of a particular user's course
		 *
		 */
		function view_quiz_details(){

			$course_id		= $this->uri->segment(3);
			$this->userid 	= $this->uri->segment(4);

			$this->session->set_flashdata('search_firstname',$this->session->flashdata('search_firstname'));
			$this->session->set_flashdata('search_lastname',$this->session->flashdata('search_lastname'));
			$this->session->set_flashdata('search_email',$this->session->flashdata('search_email'));
			$this->session->set_flashdata("course_completed",$this->session->flashdata('course_completed'));

			$this->gen_contents['page_title']	= 'User Quiz Details';
			$this->gen_contents["userdetails"]	= $this->admin_user_model->select_single_userdetails($this->userid);

			$this->gen_contents['quiz_details']	= $this->admin_user_model->getQuizListForCourse($course_id,$this->userid);
			$this->_template('view_quiz_details',$this->gen_contents);
		}

		function conversations() {
			$this->load->helper('text');
			$user_id = $this->uri->segment(3);
			$this->load->model('admin_user_model');

			$this->gen_contents['user_id']		= 	$user_id;

			$this->load->library('pagination');
			$config['base_url'] 				= 	base_url().'admin_user/conversations/'.$user_id.'/';
			$config['per_page'] 				= 	'5';
			$config['uri_segment']  			=  	4;
			if($this->uri->segment(4)) {
				if(!ctype_digit($this->uri->segment(4))) {
					redirect('admin_user/conversations/'.$user_id);
				}
			}
			$this->gen_contents["conversations"]	= $this->admin_user_model->select_conversations($user_id,$config['per_page'],$this->uri->segment(4));
			$config['total_rows']   				= $this->admin_user_model->qry_count_conversations($user_id);
			//$config				 		 			= array_merge($config,$this->config->item('pagination_standard'));

			$this->pagination->initialize($config);
			$this->gen_contents['paginate']     	=   $this->pagination->create_links(true);
			$this->gen_contents['js']       	= array_merge($this->gen_contents['js'],array('admin_conversation.js'));
			$this->gen_contents['user_det']		= $this->admin_user_model->select_single_userdetails($user_id);
			$this->gen_contents['page_title']	= 'Record Conversations with '.$this->gen_contents['user_det']->firstname.' '.$this->gen_contents['user_det']->lastname ."(".$this->gen_contents['user_det']->emailid.")";

			$this->_add_conversation ();
			//$this->_template('list_conversations',$this->gen_contents);

		}

		function _add_conversation() {
			$user_id = $this->uri->segment(3);
			$this->load->model('admin_user_model');
			$this->gen_contents["msg"] = '';
			$this->load->model('common_model');
			if(isset($_POST['action_add']) && $_POST){
				$this->load->library("form_validation");

				//conversations details
				$this->_validate_conversation_details();
				if($this->form_validation->run() == TRUE) {

					$this->_init_conversation_details();
					$upload = 0;
					if(!empty($_FILES)) {
						if (($_FILES['userfile']['error']) ==  0) {
							if($this->do_upload()){
								$this->conversation_contents['cd_filename'] = $this->gen_contents["file_path"];
							} else {
								$upload = 1;
							}
						}
					}
					if($upload == 0) {
						$this->conversation_contents['user_id'] = $user_id;
						$conv_id	= $this->admin_user_model->qry_i_conversation($this->conversation_contents);

						if($conv_id) {
							//$mail = $this->user_model->send_mailto_user($this->user_contents,'admin_user',$extra);
							$this->session->set_flashdata('success', 'Conversation saved successfully');
							redirect('admin_user/conversations/'.$user_id);
						} else {
							$this->session->set_flashdata('msg', 'Error has occured while saving Conversation details');
							redirect('admin_user/conversations/'.$user_id);
						}
					} else {
						//print_r($this->gen_contents["error_xls"]);
						$this->gen_contents["msg"]	= $this->gen_contents["error_xls"]['error'];
					}
				}else{
					$this->gen_contents["msg"]	= "Fill required fields";
				}
			}
			$this->gen_contents['user_id']		= $user_id;
			$this->load->helper ('tiny_mce');
			$this->gen_contents['js']       	= array_merge($this->gen_contents['js'],array('admin_conversation.js'));
			$this->gen_contents['user_det']		= $this->admin_user_model->select_single_userdetails($user_id);
			if(empty($this->gen_contents['page_title']))
				$this->gen_contents['page_title']	= 'Add Conversation';
			//$this->_template('add_conversation',$this->gen_contents);
			$this->_template('conversation',$this->gen_contents);
		}

		function _validate_conversation_details(){
			$this->form_validation->set_rules('txtTitle', 'Title', 'required|max_length[150]');
			$this->form_validation->set_rules('conver_date', 'Date', 'required');
			$this->form_validation->set_rules('txtContent', 'Content', 'required|xss_clean');
		}

		function _init_conversation_details(){
			$this->conversation_contents =array(
							"cd_title" 			=> 	$this->common_model->safe_html($this->input->post('txtTitle')),
							"cd_content" 		=> 	$this->input->post('txtContent'),
							"cd_created_date"	=>  date("Y-m-d H:i:s",strtotime($this->input->post('conver_date')))//convert_UTC_to_PST_datetime(date("Y-m-d H:i:s",strtotime($this->input->post('conver_date'))))
							);
		}

		function view_conversation () {
			$conv_id = $this->uri->segment(3);
			$this->load->model('admin_user_model');
			$this->gen_contents['conv_id']		= 	$conv_id;
			$this->gen_contents['page_title']	=	'View Conversation';
			$this->gen_contents["conversations"]	= $this->admin_user_model->select_single_conversations($conv_id);
			if(!empty($this->gen_contents["conversations"])){
				$this->gen_contents['js']       	= array_merge($this->gen_contents['js'],array('admin_conversation.js'));
				$this->_template('view_conversation',$this->gen_contents);
			} else {
				redirect('admin_user/list_user_details');
			}
		}

		function delete_conversation () {
			$conv_id = $this->uri->segment(3);
			$this->load->model('admin_user_model');
			$conversations	= $this->admin_user_model->select_single_conversations($conv_id);
			if($this->admin_user_model->delete_conversations($conv_id)){
				if($conversations->cd_filename != '')
					@unlink($this->config->item('conversations_upload_file').$conversations->cd_filename);

				$this->session->set_flashdata('success', 'Conversation deleted successfully');
				redirect('admin_user/conversations/'.$conversations->user_id);
			} else {
				$this->session->set_flashdata('msg', 'Error has occured while deleting Conversation');
				redirect('admin_user/conversations/'.$conversations->user_id);
			}
		}

		function edit_conversation () {
			$conv_id = $this->uri->segment(3);
			$this->load->model('admin_user_model');
			$this->load->model('common_model');
			$this->gen_contents['conv_id']		= 	$conv_id;
			$this->gen_contents['page_title']	=	'Edit Conversation';
			$this->gen_contents["msg"] = '';
			$this->gen_contents["conversations"]	= $this->admin_user_model->select_single_conversations($conv_id);
			//print_r($this->gen_contents["conversations"]);
			if($_POST){
				//$this->load->library("form_validation");

				//conversations details
				$this->_validate_conversation_details();
				if($this->form_validation->run() == TRUE) {

					$this->_init_conversation_details();
					$upload = 0;
					if(!empty($_FILES)) {
						if (($_FILES['userfile']['error']) ==  0) {
							if($this->do_upload()){
								$this->conversation_contents['cd_filename'] = $this->gen_contents["file_path"];
								if($this->gen_contents["conversations"]->cd_filename != '')
									@unlink($this->config->item('conversations_upload_file').$this->gen_contents["conversations"]->cd_filename);
							} else {
								$upload = 1;
							}
						}
					}
					if($upload == 0) {
						$conv_id	= $this->admin_user_model->qry_u_conversation($this->conversation_contents,$conv_id);

						if($conv_id) {
							//$mail = $this->user_model->send_mailto_user($this->user_contents,'admin_user',$extra);
							$this->session->set_flashdata('success', 'Conversation updated successfully');
							redirect('admin_user/conversations/'.$this->gen_contents["conversations"]->user_id);
						} else {
							$this->session->set_flashdata('msg', 'Error has occured while updating Conversation details');
							redirect('admin_user/conversations/'.$this->gen_contents["conversations"]->user_id);
						}
					} else {
						$this->gen_contents["msg"]	= $this->gen_contents["error_xls"]['error'];
					}
				}else{
					$this->gen_contents["msg"]	= "Fill required fields";
				}
			}

			if(!empty($this->gen_contents["conversations"])){
				$this->load->helper ('tiny_mce');
			$this->gen_contents['js']       	= array_merge($this->gen_contents['js'],array('admin_conversation.js'));
			$this->_template('edit_conversation',$this->gen_contents);
			} else {
				redirect('admin_user/list_user_details');
			}

		}

		/**
		 * function for file upload
		 *
		 */
		function do_upload(){
			$config['upload_path'] 		= $this->config->item('conversations_upload_file');
			$config['allowed_types'] 	= $this->config->item('conversation_extensions');
			$config['max_size']			= '2048';
			$config['max_width']  		= '1024';
			$config['max_height']  		= '768';
			$img_ext 					= $this->get_extension ('userfile');
			$imgname					= time().'.'.$img_ext;

			$this->gen_contents["file_path"] = $imgname;
			$config['file_name']  = $imgname;
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload()){

				$this->gen_contents["error_xls"] = array('error' => $this->upload->display_errors());
				return FALSE;
			}
			else{
				return TRUE;
			}
		}
		/**
		 * function for getting the image extensions
		 *
		 */
		function get_extension($upload_text_name) {

			$name_array = explode(".",$_FILES[$upload_text_name]['name']);
			$ext        = $name_array[count($name_array)-1];
			return strtolower($ext);
		}

		function delete_conversation_attachment () {
			$conv_id = $this->uri->segment(3);
			$this->load->model('admin_user_model');
			$conversations	= $this->admin_user_model->select_single_conversations($conv_id);
			$this->conversation_contents['cd_filename'] = '';
			$conv_id	= $this->admin_user_model->qry_u_conversation($this->conversation_contents,$conv_id);
			if($conv_id) {
				if($conversations->cd_filename != '')
					@unlink($this->config->item('conversations_upload_file').$conversations->cd_filename);

				$this->session->set_flashdata('success', 'Attachment deleted successfully');
				redirect('admin_user/conversations/'.$conversations->user_id.'/'.$this->uri->segment(4));
			} else {
				$this->session->set_flashdata('msg', 'Error occured while deleting attachment');
				redirect('admin_user/conversations/'.$conversations->user_id.'/'.$this->uri->segment(4));
			}

		}

        /**
         * function to ship order
         *
         */
        function ship_order ()
        {
            $this->load->helper('fedex');
            $this->orderid = $this->uri->segment(3);
            $this->userid = $this->uri->segment(4);
            $this->gen_contents['shipdetails'] = $this->admin_user_model->select_single_order_details($this->orderid);

            $shipdetails = $this->admin_user_model->select_single_order_details($this->orderid);

            $aryOrder = array(
                'TotalPackages' => 1,
                'PackageType' => 'YOUR_PACKAGING', //FEDEX_10KG_BOX, FEDEX_25KG_BOX, FEDEX_BOX, FEDEX_ENVELOPE, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING
                'ServiceType' => 'FEDEX_GROUND',
                'TermsOfSaleType' => "DDU", #    DDU/DDP
                'DropoffType' => 'REGULAR_PICKUP'         // BUSINESS_SERVICE_CENTER, DROP_BOX, REGULAR_PICKUP, REQUEST_COURIER, STATION
                //'TotalWeight' => array('Value' => 50.0, 'Units' => 'LB'), // valid values LB and KG
            );

            $aryRecipient = array(
                'Contact' => array(
                    'PersonName' => $shipdetails['firstname'] . " " . $shipdetails['lastname'],
                    //'CompanyName' => 'Company Name',
                    'PhoneNumber' => $shipdetails['phone']
                ),
                'Address' => array(
                    'StreetLines' => $shipdetails['b_address'].", ".$shipdetails['unit_number'],
                    'City' => $shipdetails['b_city'],
                    'StateOrProvinceCode' => $shipdetails['b_state'],
                    'PostalCode' => $shipdetails['b_zipcode'],
                    'CountryCode' => $shipdetails['b_country'],
                    'Residential' => false)
            );

            $courseDetails = $this->admin_user_model->get_course_details($this->orderid);
            $course_weight = $courseDetails['course_weight'];
            $course_amount = $courseDetails['course_amount'];
            $arrCourseDetails = $courseDetails['arrCourseDetails'];

            $package_weight = $courseDetails['course_weight'];
            $est_amount = $courseDetails['course_amount'];
            $arrCourseDetails = $courseDetails['arrCourseDetails'];

            $order_id = $this->orderid;

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

            $realPackages = array(
                0 => array(
                    'packageDetails' => $packageDetails,
                    'aryPackageItems' => $aryPackageItems,
                    'package_amount' => $est_amount
                )
            );


            $ship = setShipment($aryOrder, $aryRecipient, $realPackages, $course_amount, $course_weight);

            //$this->gen_contents['admindetails'] = $this->admin_user_model->get_admin_details();
            //$course_weight=$this->admin_user_model->get_courseweight($this->orderid);
            //$ship = $this->admin_user_model->shiporder($this->gen_contents['shipdetails'],$course_weight,$this->gen_contents['admindetails']);

            if ($ship != 'error')
            {
                $this->admin_user_model->update_orderdetails($this->orderid, $ship['trackingno'], $ship['label']);
                $this->gen_contents["userdetails"] = $this->admin_user_model->select_single_userdetails($this->userid);
                $this->gen_contents['orderdetails'] = $this->admin_user_model->select_single_order_details($this->orderid);
                $this->admin_user_model->mail_touser($this->gen_contents["userdetails"], $this->gen_contents['orderdetails']);
                $this->session->set_flashdata('success', 'Order shipped successfully');
                redirect('admin_user/view_order_details/' . $this->gen_contents['shipdetails']['id']);
            }
            else
            {

                $this->session->set_flashdata('error', 'Request Failed');
                redirect('admin_user/view_order_details/' . $this->gen_contents['shipdetails']['id']);
            }
        }
        
        
        /**
         * View exam tracking details
         *
         */
        function view_user_exam_details(){
        	$this->load->model('user_exam_model');
        	$this->userid 		= $this->uri->segment(3);
        	$courseid 			= $this->uri->segment(4);			
			if('' == $this->userid || '' == $courseid){
				redirect('admin_user/list_user_details');
			}
			$user_exam_details	= $this->user_exam_model->getUserAttendedDetails($this->userid, $courseid);
			$question_details	= array();
			$option_details		= array();
			$right_answer_count	= 0;
			$wrong_answer_count	= 0;
			$not_answered_count	= 0;
			if($user_exam_details){
				
				$attended_details	= json_decode($user_exam_details->attended_details, true);
				$course_details		= $this->user_exam_model->getMainCourseDetails($courseid);
				
				/* Question and options */				
				$edition = get_user_edition($courseid, $this->userid );
				$question_all	= $this->user_exam_model->getquestionid($courseid,$edition);

				foreach ($question_all as $question){
					$question_details[$question['id']]	= array('question' => $question['question'], 'answer_id' => $question['ansid']);
					if(isset($attended_details[$question['id']]['option_id']) && $attended_details[$question['id']]['option_id'] > 0){
						if($question['ansid'] == $attended_details[$question['id']]['option_id']){
							$right_answer_count++;
						}else{
							$wrong_answer_count++;
						}
					}else{
						$not_answered_count++;
					}
				}
				
				$option_all		= $this->user_exam_model->fncGetQuestionsOptions (array_keys($question_details));
				foreach ($option_all as $option){
					$option_details[$option->question_id][$option->answer_id]	= $option->answers;
				}
				
				/* Question and options */
				
				
				$this->gen_contents['course_details']			= $course_details;
				$this->gen_contents['exam_details']				= $user_exam_details;
				$this->gen_contents['question_details']			= $question_details;
				$this->gen_contents['option_details']			= $option_details;
				$this->gen_contents['attended_details']			= $attended_details;				
				$this->gen_contents["user_details"]				= $this->admin_user_model->select_single_userdetails($this->userid);
				$this->gen_contents["right_answer_count"]		= $right_answer_count;
				$this->gen_contents["wrong_answer_count"]		= $wrong_answer_count;
				$this->gen_contents["not_answered_count"]		= $not_answered_count;
				
				$this->gen_contents["other_exam_details"]		= $this->user_exam_model->getUserOtherAttendedDetails($this->userid, $courseid);

				$this->gen_contents['page_title']	= 'User Exam Details';
				$this->_template('view_exam_details', $this->gen_contents);
			}else{
				redirect('admin_user/user_course_details/'.$this->userid);
			}
        }

        
        function delete_course()
        {
            $user_id = $this->input->post("user_id");
            $course_id = $this->input->post("course_id");
            
            $exam_attended = $this->admin_user_model->select_user_exam($user_id, $course_id);
            if($exam_attended > 0 ) 
            {
                echo "exists";
            }
            else
            {
                $this->admin_user_model->delete_course_user($user_id, $course_id);
                $this->session->set_flashdata('success', 'User course deleted successfully!');
                echo $user_id;
            }
        }
        
        /* 
         * Reinstate Functionality 
         * Parameter - User course id
         */
        function reinstate(){
            $this->gen_contents['user_course_id'] = $this->gen_contents['expiry_date'] = $this->gen_contents['reason'] = '';
            $this->gen_contents["msg"] = $this->gen_contents["err_msg"] = '';
            
            if(array_key_exists('edit_user_course_id',$_POST)){
                $this->gen_contents['user_course_id'] = $_POST['edit_user_course_id'];
                $this->gen_contents['expiry_date'] = $_POST['expiry_date'];
                $this->gen_contents['reason'] = $_POST['reason'];
                
                if($this->admin_user_model->reinstate_user_course($this->gen_contents['user_course_id'],$this->gen_contents['expiry_date'],$this->gen_contents['reason'])){
                   $this->gen_contents["msg"] = 'Reinstated successfully!';
                } else {
                   $this->gen_contents["err_msg"] = 'Reinstated failed';
                }
            }
            
            $this->gen_contents['page_title']           = 'Course Reinstate Details';
            if($this->gen_contents['user_course_id'] == ''){
                $this->gen_contents['user_course_id'] 			= $this->uri->segment(3);
            }
            
            $this->gen_contents["coursedetails"]        = $this->admin_user_model->select_single_user_course_id_details($this->gen_contents['user_course_id']);
            $this->gen_contents["userid"]               = $this->gen_contents["coursedetails"][0]->userid;
            $this->_template('reinstate_user_course',$this->gen_contents);
        }
        
        /**
         * function to list the user details
         *
         */
        function list_otp_users ()
        {
            
                $this->gen_contents["success_message"]='';
                if(!is_numeric($this->uri->segment(3))){
                        $s_msg = ($this->uri->segment(3));
                        $this->gen_contents["success_message"] = base64_decode($s_msg);
                }
                $this->load->model('common_model');
                $this->load->model('admin_subadmin_model');
                $this->gen_contents['page_title']               =	'OTP Users';
                $this->load->library('pagination');
                $config['base_url'] 				= 	base_url().'index.php/admin_user/list_otp_users/';
                $config['per_page'] 				= 	'10';
                $config['uri_segment']  			=  	3;

                $this->gen_contents["search_firstname"] = '';
                $this->gen_contents["search_email"] = '';
                $this->gen_contents["search_phone"]='';


                if(!empty($_POST)) {
                        $this->gen_contents["search_firstname"] = $this->common_model->safe_html($this->input->post('txtSrchFirstname'));
                        $this->gen_contents["search_email"]     = $this->common_model->safe_html($this->input->post('txtSrchEmail'));
                        $this->gen_contents["search_phone"]     = $this->common_model->safe_html($this->input->post('txtSrchPhone'));
                }else {
                        $this->gen_contents["search_firstname"] = ($this->session->flashdata('search_firstname'))?$this->session->flashdata('search_firstname'):$this->gen_contents["search_firstname"];
                        $this->gen_contents["search_email"] = $this->session->flashdata('search_email');
                        $this->gen_contents["search_phone"] = $this->session->flashdata('search_phone');
                }
                
                $this->session->set_flashdata('search_firstname',$this->gen_contents["search_firstname"]);
                $this->session->set_flashdata('search_email',$this->gen_contents["search_email"]);
                $this->session->set_flashdata('search_phone',$this->gen_contents["search_phone"]);
                
                $this->gen_contents["userdetails"]	=	$this->admin_user_model->select_otpusers($config['per_page'],$this->uri->segment(3),$this->gen_contents["search_firstname"],$this->gen_contents["search_email"], $this->gen_contents["search_phone"]);
                $config['total_rows']   		= 	$this->admin_user_model->qry_count_otpusers($this->gen_contents["search_firstname"],$this->gen_contents["search_email"],$this->gen_contents["search_phone"]);

                $this->pagination->initialize($config);
                $this->gen_contents['paginate']     =   $this->pagination->create_links(true);
                $this->_template('list_otp_users',$this->gen_contents);
        }
        
        /* Add new otp user */
        
        function add_otp_user()
	{
		//default case
		if($_SERVER['REQUEST_METHOD'] == 'POST') {  
                    $this->load->library(array('form_validation'));
                    $this->form_validation->set_rules('firstname', 'First Name', 'required|max_length[128]');
                    //$this->form_validation->set_rules('phone', 'Phone', 'required|min_length[10]|max_length[10]');
                    $this->form_validation->set_rules('email', 'Email','required|min_length[5]|max_length[100]|is_unique[adhi_otp_emails.email_id]|matches[confirmemail]');
                    $this->form_validation->set_rules('confirmemail', 'Confirm Email', 'required|min_length[5]|max_length[100]');
                   
                    if($this->form_validation->run() == TRUE) {
                        $data = array(
                            "name"         =>   $this->input->post("firstname"),
                            "email_id"     =>   $this->input->post("email"),
                            "phone"        =>   $this->input->post("phone"),
                            "created_date" =>   convert_UTC_to_PST_date(date('Y-m-d H:i:s')),
                            "active_status"=>   1,
                            "status"       =>   1
                        );
                        
                        if($this->admin_user_model->otp_mail_check("",$data["email_id"])){
                            if($this->admin_user_model->add_otp_user("",$data)){
                                $this->gen_contents["msgs"] = "Created successfully";
                                //$this->session->set_flashdata("msg", $this->gen_contents["msgs"]);
                            } else {
                                $this->gen_contents["msgs"] = "Creation Failed";
                                //$this->session->set_flashdata("msg", $this->gen_contents["msgs"]);
                            }
                        } else {
                            $this->gen_contents["msg"] = "Email already exists";
                        }
                        
                    }
                }
			
                $this->load->helper("form");
                
                $this->gen_contents['head']   = "Add OTP User";
                $this->gen_contents['btn']    = "Add";
                $this->gen_contents['action'] =  0;
                
                $this->gen_contents['userdetails'] = array();
                $this->load->view("admin/admin_register_heading",$this->gen_contents);
                $this->load->view('admin/user management/admin_add_otp_user',$this->gen_contents);
                $this->load->view("admin_footer",$this->gen_contents);
	}
        
        /* Edit new otp user */
        
        function edit_otp_user()
	{
		//default case
		if($_SERVER['REQUEST_METHOD'] == 'POST') {  
                    $this->load->library(array('form_validation'));
                    $this->form_validation->set_rules('firstname', 'First Name', 'required|max_length[128]');
                    //$this->form_validation->set_rules('phone', 'Phone', 'required|min_length[10]|max_length[10]');
                    $this->form_validation->set_rules('email', 'Email','required|min_length[5]|max_length[100]|is_unique[adhi_otp_emails.email_id]|matches[confirmemail]');
                    $this->form_validation->set_rules('confirmemail', 'Confirm Email', 'required|min_length[5]|max_length[100]');
                   
                    if($this->form_validation->run() == TRUE) {
                        $data = array(
                            "name"         =>   $this->input->post("firstname"),
                            "email_id"     =>   $this->input->post("email"),
                            "phone"        =>   $this->input->post("phone"),
                            "updated_date" =>   convert_UTC_to_PST_date(date('Y-m-d H:i:s')),
                            "status"       =>   1
                        );
                        
                        $id = $this->uri->segment(3);
                        
                        if($this->admin_user_model->otp_mail_check($id,$data["email_id"])){
                            if($this->admin_user_model->add_otp_user($id,$data)){
                                $this->gen_contents["msgs"] = "Updated successfully";
                                //$this->session->set_flashdata("msg", $this->gen_contents["msgs"]);
                            } else {
                                $this->gen_contents["msg"] = "Update failed";
                                //$this->session->set_flashdata("msg", $this->gen_contents["msgs"]);
                            }
                        }  else {
                            $this->gen_contents["msg"] = "Email already exists";
                        }
                        
                    }
                }
			
                $this->load->helper("form");
                $id = $this->uri->segment(3);
                $this->load->model('admin_model');
                $this->gen_contents['head']   = "Edit OTP User";
                $this->gen_contents['btn']    = "Update";
                $this->gen_contents['action'] =  1;
                
                $userdetails = $this->admin_model->get_otp_emails("","",FALSE,$id);
                $this->gen_contents['userdetails'] = $userdetails[0];
                $this->load->view("admin/admin_register_heading",$this->gen_contents);
                $this->load->view('admin/user management/admin_add_otp_user',$this->gen_contents);
                $this->load->view("admin_footer",$this->gen_contents);
	}
        
        /**
         * function to freeze otp user
         *
         */
        function freeze_otp_user() {
                $this->userid 	= 	$this->uri->segment(3);
                $status         = 	$this->uri->segment(4);
                
                $this->gen_contents['userid'] = $this->userid;
                $this->gen_contents['reason'] = $this->input->post('txtReason');
                
                $freeze_user	=	$this->admin_user_model->freeze_otp_user($this->gen_contents,$status);
                $sct = $status ? "Enabled" : "Disabled";
                
                $page =$this->uri->segment(5) ? $this->uri->segment(5) : 0;
                
                if($freeze_user >0)
                {
                        $this->session->set_flashdata ('success', 'User '.$sct.' successfully');
                        redirect('admin_user/list_otp_users/'.$page);
                }
                else
                {
                        $this->session->set_flashdata ('error', 'Request Failed');
                        redirect('admin_user/list_otp_users/'.$page);
                }
        }
        
        
        
        /**
         * function to list the user details
         *
         */
        function list_trial_users (){
            
                /*$this->gen_contents["success_message"]='';
                if(!is_numeric($this->uri->segment(3))){
                        $s_msg = ($this->uri->segment(3));
                        $this->gen_contents["success_message"] = base64_decode($s_msg);
                }*/
                $this->load->model(array('common_model', 'admin_subadmin_model', 'admin_trial_account_model'));
                
                $this->gen_contents['page_title']               =	'Guest Users';
                $this->load->library('pagination');
                $config['base_url'] 				= 	base_url().'index.php/admin_user/list_trial_users/';
                $config['per_page'] 				= 	'10';
                $config['uri_segment']  			=  	3;

                $this->gen_contents["search_firstname"] = '';
                $this->gen_contents["search_lastname"] = '';
                $this->gen_contents["search_email"] = '';
                $this->gen_contents["search_phone"]='';


                if(!empty($_POST)) {
                        $this->gen_contents["search_firstname"] = $this->common_model->safe_html($this->input->post('txtSrchFirstname'));
                        $this->gen_contents["search_lastname"]  = $this->common_model->safe_html($this->input->post('txtSrchLastname'));
                        $this->gen_contents["search_email"]     = $this->common_model->safe_html($this->input->post('txtSrchEmail'));
                        $this->gen_contents["search_phone"]     = $this->common_model->safe_html($this->input->post('txtSrchPhone'));
                        $this->gen_contents["adhi_user_only"]   = $this->common_model->safe_html($this->input->post('txtSrchAdhiUser'));
                        $this->gen_contents["date_from"]        = $this->common_model->safe_html($this->input->post('txtSrchDateFrom'));
                        $this->gen_contents["date_to"]          = $this->common_model->safe_html($this->input->post('txtSrchDateTo'));
                }else {
                        $this->gen_contents["search_firstname"] = ($this->session->flashdata('search_firstname'))?$this->session->flashdata('search_firstname'):$this->gen_contents["search_firstname"];
                        $this->gen_contents["search_lastname"]  = ($this->session->flashdata('search_lastname'))?$this->session->flashdata('search_lastname'):$this->gen_contents["search_lastname"];
                        $this->gen_contents["search_email"]     = $this->session->flashdata('search_email');
                        $this->gen_contents["search_phone"]     = $this->session->flashdata('search_phone');
                        $this->gen_contents["adhi_user_only"]   = $this->session->flashdata('adhi_user_only');
                        $this->gen_contents["date_from"]        = $this->session->flashdata('date_from');
                        $this->gen_contents["date_to"]        = $this->session->flashdata('date_to');
                }
                
                $this->session->set_flashdata('search_firstname',$this->gen_contents["search_firstname"]);
                $this->session->set_flashdata('search_lastname',$this->gen_contents["search_lastname"]);
                $this->session->set_flashdata('search_email',$this->gen_contents["search_email"]);
                $this->session->set_flashdata('search_phone',$this->gen_contents["search_phone"]);
                $this->session->set_flashdata('adhi_user_only',$this->gen_contents["adhi_user_only"]);
                $this->session->set_flashdata('date_from',$this->gen_contents["date_from"]);
                $this->session->set_flashdata('date_to',$this->gen_contents["date_to"]);
                
                
                /*$this->gen_contents["total_trial_user"]	= $this->admin_trial_account_model->totalTrialUserCount('all');
                $this->gen_contents["total_adhi_user"]	= $this->admin_trial_account_model->totalTrialUserCount('adhi_user');
                */
                $this->gen_contents["userdetails"]	= $this->admin_user_model->select_trial_users($config['per_page'],$this->uri->segment(3),$this->gen_contents["search_firstname"],$this->gen_contents["search_lastname"],$this->gen_contents["search_email"], $this->gen_contents["search_phone"], $this->gen_contents["adhi_user_only"], $this->gen_contents["date_from"], $this->gen_contents["date_to"]);
                $config['total_rows']   		= $this->admin_user_model->qry_count_trial_users($this->gen_contents["search_firstname"],$this->gen_contents["search_lastname"],$this->gen_contents["search_email"],$this->gen_contents["search_phone"], $this->gen_contents["adhi_user_only"], $this->gen_contents["date_from"], $this->gen_contents["date_to"]);
                $this->gen_contents["total_user"]	= $config['total_rows'];

                $this->pagination->initialize($config);
                $this->gen_contents['paginate']     =   $this->pagination->create_links(true);
                $this->_template('list_trial_users', $this->gen_contents, 'admin/trial_account/');
        }
        
        /* Add new otp user */
        
        function add_trial_user(){
            $this->load->model(array('trial_account_model', 'user_model', 'admin_trial_account_model', 'Common_model'));
            $this->gen_contents['userid'] = '';
            
            if($_SERVER['REQUEST_METHOD'] == 'POST') {  
                $settings                   = $this->admin_trial_account_model->getSettings();
                
                $this->load->library(array('form_validation'));
                $this->form_validation->set_rules('first_name', 'First Name', 'required|max_length[128]');
                $this->form_validation->set_rules('last_name', 'Last Name', 'required|max_length[128]');
                $this->form_validation->set_rules('email', 'Email','required|min_length[5]|max_length[100]|is_unique[adhi_trial_users.email]|matches[confirmemail]');
                $this->form_validation->set_rules('confirmemail', 'Confirm Email', 'required|min_length[5]|max_length[100]');
                $this->form_validation->set_rules('psword', 'Password', 'required|matches[psword1]');
                $this->form_validation->set_rules('psword1', 'Confirm Password', 'required');
                $this->form_validation->set_rules('phone', 'Phone', 'required|min_length[10]|max_length[10]');
                
                if($this->form_validation->run() == TRUE) {
                    $this->gen_contents['msg']  = '';
                    $check_in_trial = $this->trial_account_model->userExists($this->input->post('email'));
                    $check_in_user  = $this->user_model->checkuser($this->input->post('email'));
                    if($check_in_trial){
                        if(0 == $check_in_trial->status){
                            $this->gen_contents['msg']   = 'User already registered as Guest User.';
                        }else if(1 == $check_in_trial->status){
                            $this->gen_contents['msg']   = 'User already have a Guest account.';
                        }else if(2 == $check_in_trial->status){
                            $this->gen_contents['msg']   = 'User already have an account in Adhischools.';
                        }
                    }
                    if($check_in_user){
                        $this->gen_contents['msg']   = 'User already have an account in Adhischools.';
                    }
                    if('' == $this->gen_contents['msg']){

                        /* Registration in process save mail starts */
                        $save_data = array(
                            'first_name'        => $this->Common_model->safe_html($this->input->post('first_name')),
                            'last_name'         => $this->Common_model->safe_html($this->input->post('last_name')),
                            'email'             => $this->Common_model->safe_html($this->input->post('email')),
                            'phone'             => $this->Common_model->safe_html($this->input->post('phone')),
                            'ip_address'        => $this->input->ip_address(),
                            'password'          => md5($this->Common_model->safe_html($this->input->post('psword'))),
                            'created_at'        => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')),
                            'activated_at'      => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s')),
                            'will_expire_at'    => convert_UTC_to_PST_datetime(strtotime(time()).' +'. $settings->validity_days .' days'),
                            'status'            => 1,
                            'created_by'        => $this->session->userdata('USERID')
                        );
                        if($settings->validity_days > 1){
                            $maketing_day   = floor($settings->validity_days/2);
                            $save_data['marketing_email_at'] = convert_UTC_to_PST_datetime(strtotime(time()).' +'. $maketing_day .' days');
                        }
                        
                        if($this->trial_account_model->save($save_data)){
                            $mail_data  = array(
                                            'firstname'             => $save_data['first_name'], 
                                            'username'              => $save_data['email'], 
                                            'password'              => $this->Common_model->safe_html($this->input->post('psword')),
                                            'trial_validity_days'   => $settings->validity_days
                                        );
                            $sendmail   = $this->trial_account_model->email_trial_user($this->input->post('email'), $mail_data, 'Welcome to your guest account with ADHI Schools', 'created_by_admin');
                            $this->session->set_flashdata ('success', 'Guest account created successfully');
                            
                        }else{
                            $this->session->set_flashdata ('error', 'Guest account created successfully');
                        }
                        redirect('admin_user/list_trial_users');
                    }
                }else{
                    $this->gen_contents['errors']   = validation_errors();
                }
            }
            $this->load->helper("form");

            $this->gen_contents['head']   = "Add Guest User";
            $this->gen_contents['btn']    = "Add";
            $this->gen_contents['is_edit'] =  0;

            $this->gen_contents['userdetails'] = array();
            $this->_template('add_trial_user', $this->gen_contents, 'admin/trial_account/');                
	}
        
        /* Edit new otp user */
        
        function edit_trial_user(){
            $this->load->model(array('trial_account_model', 'user_model', 'admin_trial_account_model', 'Common_model'));
            $userid = $this->uri->segment(3);
            $user = $this->trial_account_model->getUser($userid);
            
            $this->gen_contents['userid'] = $userid;
            if($user){
                if($_SERVER['REQUEST_METHOD'] == 'POST') {  
                    $this->load->library(array('form_validation'));
                    $this->form_validation->set_rules('first_name', 'First Name', 'required|max_length[128]');
                    $this->form_validation->set_rules('last_name', 'Last Name', 'required|max_length[128]');
                    $this->form_validation->set_rules('email', 'Email','required|min_length[5]|max_length[100]|is_unique[adhi_trial_users.email]|matches[confirmemail]');
                    $this->form_validation->set_rules('confirmemail', 'Confirm Email', 'required|min_length[5]|max_length[100]');
                    $this->form_validation->set_rules('psword', 'Password', 'matches[psword1]');
                    $this->form_validation->set_rules('psword1', 'Confirm Password', 'trim');
                    $this->form_validation->set_rules('phone', 'Phone', 'required|min_length[10]|max_length[10]');
                   
                    if($this->form_validation->run() == TRUE) {
                        $this->gen_contents['msg']  = '';
                        $check_in_trial = $this->trial_account_model->userExists($this->input->post('email'), $userid);
                        $check_in_user  = $this->user_model->checkuser($this->input->post('email'));
                        if($check_in_trial){
                            if(0 == $check_in_trial->status){
                                $this->gen_contents['msg']   = 'Email id already exist with statis activation pending';
                            }else if(1 == $check_in_trial->status){
                                $this->gen_contents['msg']   = 'Email id is already exist.';
                            }else if(2 == $check_in_trial->status){
                                $this->gen_contents['msg']   = 'User with this Email id already have an account in Adhischools.';
                            }
                        }
                        if($check_in_user){
                            $this->gen_contents['msg']   = 'User with this Email id already have an account in Adhischools.';
                        }
                        if('' == $this->gen_contents['msg']){
                            $save_data = array(
                                'first_name'        => $this->Common_model->safe_html($this->input->post('first_name')),
                                'last_name'         => $this->Common_model->safe_html($this->input->post('last_name')),
                                'email'             => $this->Common_model->safe_html($this->input->post('email')),
                                'phone'             => $this->Common_model->safe_html($this->input->post('phone')),                                
                                'updated_at'        => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'))
                            );
                            if('' != $this->input->post('psword')){
                                $save_data['password'] = md5($this->Common_model->safe_html($this->input->post('psword')));
                            }
                            if($this->trial_account_model->update($user->id, $save_data)){
                               $this->session->set_flashdata('success', 'Updated successfully');
                            }else{
                               $this->session->set_flashdata('error', 'Failed to update');;
                            }
                            redirect('admin_user/list_trial_users');
                        }
                    }
                }
            }else{
                $this->session->set_flashdata ('error', 'Invalid request');
                redirect('admin_user/list_trial_users');
            }

			
            $this->load->helper("form");
            $this->load->model('admin_model');
            $this->gen_contents['head']   = "Edit Trial User";
            $this->gen_contents['btn']    = "Update";
            $this->gen_contents['is_edit'] =  1;

            $this->gen_contents['userdetails'] = (array) $user;
            $this->_template('add_trial_user', $this->gen_contents, 'admin/trial_account/');
	}
        
        function adhi_memorial_unsubscribe_list(){
            $this->load->model('admin_user_model');
            $this->admin_user_model->getUnsubscribeRemvData();
        }
    }
/* End of file admin.php */
/* Location: ./system/application/controllers/admin_user.php */