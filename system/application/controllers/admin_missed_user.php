<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
	* Project				-	Adhischools
	* Language				-	PHP 5 & above
	* Database				-	Mysql
	* Author				-	Syama S
*/
// ------------------------------------------------------------------------
	class Admin_missed_user extends Controller
	{

		/**
		 * General contents
		 *
		 * @var Array
		 */
		var     $gen_contents           =	array();
		var     $userid 		=	''; 		/*Id of the selected user*/
		var     $firstname		=	"";
		var     $lastname		=	'';
		var     $name_on_certificate    =       "";
		var     $forumalias		=	'';
                var	$licensetype		=	'';
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
		var	$current_controller     =	'admin_missed_user';
		/**
		 * Admin constructor
		 *
		 */
		function Admin_missed_user () {
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
			$this->gen_contents['title']	=	'Missed User Management';

		}
		/**
		 * function to load the template (header, body and footer)
		 *
		 * @param string $page
		 * @param array $contents
		 */
		function _template ($page,$contents, $admin_folder='admin/missed user management/'){
                    $this->load->helper('form');
                    $this->load->view("admin_header",$contents);
                    $this->load->view($admin_folder.$page, $contents);
                    $this->load->view("admin_footer");
		}
		/**
		 * Index
		 *
		 * @access	public
		 */
		function index()
		{
                    if(0 == $this->input->post('type')){
                        $this->list_user_details();
                    }else {
                        $this->list_renew_reenroll_details($this->input->post('type'));
                    }
		}
		/**
		 * function to list the user details
		 *
		 */
		function list_user_details ()
		{
			$this->load->model('common_model');
                        $this->load->model('admin_subadmin_model');
			$this->gen_contents['page_title']	=	'Missed Users';
			$this->load->library('pagination');
			$config['base_url'] 				= 	base_url().'index.php/admin_missed_user/list_user_details/';
			$config['per_page'] 				= 	'10';
			$config['uri_segment']  			=  	3;

			/*****sree 080710**/
			$this->gen_contents["search_firstname"] = '';
			$this->gen_contents["search_lastname"] = '';
			$this->gen_contents["search_email"] = '';
                        $this->gen_contents["license_type"] = '';
                        $this->gen_contents["search_phone"] = '';
                        $this->gen_contents["search_type"] = '';
                        
			if(!empty($_POST)) {
				$this->gen_contents["search_firstname"] = $this->common_model->safe_html($this->input->post('txtTempSrchFirstname'));
				$this->gen_contents["search_lastname"] = $this->common_model->safe_html($this->input->post('txtTempSrchLastname'));
				$this->gen_contents["search_email"] = $this->common_model->safe_html($this->input->post('txtTempSrchEmail'));
				$this->gen_contents["license_type"] = $this->common_model->safe_html($this->input->post('license_type'));
				$this->gen_contents["search_phone"] = $this->common_model->safe_html($this->input->post('txtTempSrchPhone'));
                                $this->gen_contents["search_type"] = $this->common_model->safe_html($this->input->post('type'));
                         }else {
				$this->gen_contents["search_firstname"] = ($this->session->flashdata('search_firstname'))?$this->session->flashdata('search_firstname'):$this->gen_contents["search_firstname"];
				$this->gen_contents["search_lastname"] = $this->session->flashdata('search_lastname');
				$this->gen_contents["search_email"] = $this->session->flashdata('search_email');
				$this->gen_contents["license_type"] = $this->session->flashdata('license_type');
                                $this->gen_contents["search_phone"] = $this->session->flashdata('search_phone');
                                $this->gen_contents["search_type"] =  $this->session->flashdata('search_type');
			}
			$this->session->set_flashdata('search_firstname',$this->gen_contents["search_firstname"]);
			$this->session->set_flashdata('search_lastname',$this->gen_contents["search_lastname"]);
			$this->session->set_flashdata('search_email',$this->gen_contents["search_email"]);
			$this->session->set_flashdata('license_type',$this->gen_contents["license_type"]);
                        $this->session->set_flashdata('search_phone',$this->gen_contents["search_phone"]);
                        $this->session->set_flashdata('search_type',$this->gen_contents["search_type"]);
			
                        $this->load->model('admin_user_model');
			$this->gen_contents["userdetails"]	=	$this->admin_user_model->select_temp_userdetails($config['per_page'],$this->uri->segment(3),$this->gen_contents["search_firstname"],$this->gen_contents["search_lastname"],$this->gen_contents["search_email"], $this->gen_contents["license_type"],$this->gen_contents["search_phone"]);
                        $config['total_rows']   		= 	$this->admin_user_model->qry_count_temp_userdetails($this->gen_contents["search_firstname"],$this->gen_contents["search_lastname"],$this->gen_contents["search_email"],$this->gen_contents["license_type"],$this->gen_contents["search_phone"]);
			
			$this->gen_contents["total"]            = $config['total_rows'];
			$this->pagination->initialize($config);
			$this->gen_contents['paginate']     =   $this->pagination->create_links(true);
			$this->_template('list_user_details',$this->gen_contents);
		}
                
                /**
		 * function to list the user details
		 *
		 */
		function list_renew_reenroll_details ()
		{
			$this->load->model('common_model');
                        $this->load->model('admin_subadmin_model');
			$this->gen_contents['page_title']	=	'Missed Users';
			$this->load->library('pagination');
			$config['base_url'] 				= 	base_url().'index.php/admin_missed_user/list_renew_reenroll_details/';
			$config['per_page'] 				= 	'10';
			$config['uri_segment']  			=  	3;

			/*****sree 080710**/
			$this->gen_contents["search_firstname"] = '';
			$this->gen_contents["search_lastname"] = '';
			$this->gen_contents["search_email"] = '';
                        $this->gen_contents["license_type"] = '';
                        $this->gen_contents["search_phone"] = '';
                        $this->gen_contents["search_type"] = '';
                        
			if(!empty($_POST)) {
				$this->gen_contents["search_firstname"] = $this->common_model->safe_html($this->input->post('txtTempSrchFirstname'));
				$this->gen_contents["search_lastname"] = $this->common_model->safe_html($this->input->post('txtTempSrchLastname'));
				$this->gen_contents["search_email"] = $this->common_model->safe_html($this->input->post('txtTempSrchEmail'));
				$this->gen_contents["license_type"] = $this->common_model->safe_html($this->input->post('license_type'));
				$this->gen_contents["search_phone"] = $this->common_model->safe_html($this->input->post('txtTempSrchPhone'));
                                $this->gen_contents["search_type"] = $this->common_model->safe_html($this->input->post('type'));
                         }else {
				$this->gen_contents["search_firstname"] = ($this->session->flashdata('search_firstname'))?$this->session->flashdata('search_firstname'):$this->gen_contents["search_firstname"];
				$this->gen_contents["search_lastname"] = $this->session->flashdata('search_lastname');
				$this->gen_contents["search_email"] = $this->session->flashdata('search_email');
				$this->gen_contents["license_type"] = $this->session->flashdata('license_type');
                                $this->gen_contents["search_phone"] = $this->session->flashdata('search_phone');
                                $this->gen_contents["search_type"] =  $this->session->flashdata('search_type');
			}
			$this->session->set_flashdata('search_firstname',$this->gen_contents["search_firstname"]);
			$this->session->set_flashdata('search_lastname',$this->gen_contents["search_lastname"]);
			$this->session->set_flashdata('search_email',$this->gen_contents["search_email"]);
			$this->session->set_flashdata('license_type',$this->gen_contents["license_type"]);
                        $this->session->set_flashdata('search_phone',$this->gen_contents["search_phone"]);
                        $this->session->set_flashdata('search_type',$this->gen_contents["search_type"]);
			
                        $this->load->model('admin_user_model');
			$this->gen_contents["userdetails"]	=	$this->admin_user_model->select_renew_reenroll_details($config['per_page'],$this->uri->segment(3),$this->gen_contents["search_firstname"],$this->gen_contents["search_lastname"],$this->gen_contents["search_email"], $this->gen_contents["license_type"],$this->gen_contents["search_phone"],$this->gen_contents["search_type"]);
                        $config['total_rows']   		= 	$this->admin_user_model->qry_count_renew_reenroll_details($this->gen_contents["search_firstname"],$this->gen_contents["search_lastname"],$this->gen_contents["search_email"],$this->gen_contents["license_type"],$this->gen_contents["search_phone"],$this->gen_contents["search_type"]);
			
			$this->gen_contents["total"]            = $config['total_rows'];
			$this->pagination->initialize($config);
			$this->gen_contents['paginate']     =   $this->pagination->create_links(true);
			$this->_template('list_user_details',$this->gen_contents, "admin/missed payment management/");
		}
                
                /**
		 * function to get the user details temp
		 *
		 */
		function _user_details ($userid)
		{
			$this->userid 				= 	$userid;
			$this->gen_contents["userdetails"]	=	$this->admin_user_model->select_single_temp_userdetails($this->userid);
			$this->gen_contents["state"]		=	$this->admin_user_model->select_state_name($this->gen_contents["userdetails"]->state);
			$this->gen_contents["s_state"]		=	$this->admin_user_model->select_state_name($this->gen_contents["userdetails"]->s_state);
			$this->gen_contents["b_state"]		=	$this->admin_user_model->select_state_name($this->gen_contents["userdetails"]->b_state);
                        $this->gen_contents["course_user_type"] =	$this->admin_user_model->select_user_course_types($this->gen_contents["userdetails"]->course_user_type);
                        /* course details*/
			$this->gen_contents["coursedetails"]    =	$this->admin_user_model->select_single_temp_user_course_details($this->userid);
		}
		/**
		 * function to get the user details
		 *
		 */
		function _renew_user_details ($userid,$order_id)
		{
			$this->userid 				= 	$userid;
			$this->gen_contents["userdetails"]	=	$this->admin_user_model->select_single_userdetails($this->userid);
			$this->gen_contents["state"]		=	$this->admin_user_model->select_state_name($this->gen_contents["userdetails"]->state);
			$this->gen_contents["s_state"]		=	$this->admin_user_model->select_state_name($this->gen_contents["userdetails"]->s_state);
			$this->gen_contents["b_state"]		=	$this->admin_user_model->select_state_name($this->gen_contents["userdetails"]->b_state);
                        $this->gen_contents["course_user_type"] =	$this->admin_user_model->select_user_course_types($this->gen_contents["userdetails"]->course_user_type);
                        /* course details*/
			$this->gen_contents["coursedetails"]    =	$this->admin_user_model->select_single_renew_course_details($this->userid,$order_id);
		}
		/**
		 * function to view the user details
		 *
		 */
		function view_users (){
			$this->gen_contents["course"]		=	array();
			$this->gen_contents['page_title']	=	'Missed User Details';

			$this->session->set_flashdata('search_firstname',$this->session->flashdata('search_firstname'));
			$this->session->set_flashdata('search_lastname',$this->session->flashdata('search_lastname'));
			$this->session->set_flashdata('search_email',$this->session->flashdata('search_email'));

			$this->_user_details($this->uri->segment(3));
			$this->_template('view_user_details',$this->gen_contents);
		}
                
                /**
		 * function to view the user details
		 *
		 */
		function view_renew_users (){
			$this->gen_contents["course"]		=	array();
			$this->gen_contents['page_title']	=	'Missed User Details';

			$this->session->set_flashdata('search_firstname',$this->session->flashdata('search_firstname'));
			$this->session->set_flashdata('search_lastname',$this->session->flashdata('search_lastname'));
			$this->session->set_flashdata('search_email',$this->session->flashdata('search_email'));

			$this->_renew_user_details($this->uri->segment(3),$this->uri->segment(4));
			$this->_template('view_user_details',$this->gen_contents, "admin/missed payment management/");
		}
		/**
		 * function to get the course selected by a user
		 *
		 */
		function user_course_details () {
			$this->gen_contents['page_title']	= 'User Course Details';
			$this->userid 				= $this->uri->segment(3);

			$this->session->set_flashdata('search_firstname',$this->session->flashdata('search_firstname'));
			$this->session->set_flashdata('search_lastname',$this->session->flashdata('search_lastname'));
			$this->session->set_flashdata('search_email',$this->session->flashdata('search_email'));

			$this->gen_contents['userid']		= $this->userid;
			$this->gen_contents["coursedetails"]= $this->admin_user_model->select_single_temp_user_course_details($this->userid);
			
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
                        $this->gen_contents['add_status'] = false;
			$this->gen_contents["username"]		= $this->admin_user_model->select_single_temp_userdetails($this->userid);
			$this->_template('user_course_details',$this->gen_contents);
		}
                /**
		 * function to get the course selected by a user
		 *
		 */
		function user_renew_course_details () {
			$this->gen_contents['page_title']	= 'User Course Details';
			$this->userid 				= $this->uri->segment(3);
                        $order_id                               = $this->uri->segment(4);
                        
			$this->session->set_flashdata('search_firstname',$this->session->flashdata('search_firstname'));
			$this->session->set_flashdata('search_lastname',$this->session->flashdata('search_lastname'));
			$this->session->set_flashdata('search_email',$this->session->flashdata('search_email'));

			$this->gen_contents['userid']		= $this->userid;
                        $this->gen_contents['order_id']		= $order_id;
			$this->gen_contents["coursedetails"]= $this->admin_user_model->select_single_renew_course_details($this->userid,$order_id);
			
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
                        $this->gen_contents['add_status'] = false;
			$this->gen_contents["username"]		= $this->admin_user_model->select_single_userdetails($this->userid);
			$this->_template('user_course_details',$this->gen_contents, "admin/missed payment management/");
		}
		/**
		 * function to get the course selected by a user
		 *
		 */
		function user_courses () {
			$this->gen_contents['page_title']	= 'User Course Details';
			$this->userid 				= $this->uri->segment(3);
			$this->orderid 				= $this->uri->segment(4);

			$this->session->set_flashdata('search_firstname',$this->session->flashdata('search_firstname'));
			$this->session->set_flashdata('search_lastname',$this->session->flashdata('search_lastname'));
			$this->session->set_flashdata('search_email',$this->session->flashdata('search_email'));

			$this->gen_contents['userid']		= $this->userid;
			$this->gen_contents["coursedetails"]    = $this->admin_user_model->select_single_temp_user_course_details($this->userid,$this->orderid);
			$this->gen_contents["username"]		= $this->admin_user_model->select_single_temp_userdetails($this->userid);
			$this->_template('user_courses',$this->gen_contents);
		}
                /**
		 * function to get the course selected by a user
		 *
		 */
		function user_renew_courses () {
			$this->gen_contents['page_title']	= 'User Course Details';
			$this->userid 				= $this->uri->segment(3);
			$this->orderid 				= $this->uri->segment(4);

			$this->session->set_flashdata('search_firstname',$this->session->flashdata('search_firstname'));
			$this->session->set_flashdata('search_lastname',$this->session->flashdata('search_lastname'));
			$this->session->set_flashdata('search_email',$this->session->flashdata('search_email'));

			$this->gen_contents['userid']		= $this->userid;
			$this->gen_contents["coursedetails"]    = $this->admin_user_model->select_single_renew_course_details($this->userid,$this->orderid);
			$this->gen_contents["username"]		= $this->admin_user_model->select_single_userdetails($this->userid);
			$this->_template('user_courses',$this->gen_contents, "admin/missed payment management/");
		}
		/**
		 * function to view the order details of a user
		 *
		 */
		function view_order_details() {
			$this->userid 				= 	$this->uri->segment(3);
			$this->gen_contents['page_title']	=	'View Order Details';

			$this->session->set_flashdata('search_firstname',$this->session->flashdata('search_firstname'));
			$this->session->set_flashdata('search_lastname',$this->session->flashdata('search_lastname'));
			$this->session->set_flashdata('search_email',$this->session->flashdata('search_email'));

			$this->_user_details($this->userid);
			$this->gen_contents['orderdet']		=	$this->admin_user_model->select_single_temp_user_order_details($this->userid);
			$this->_template('view_order_details',$this->gen_contents);
		}
                
                /**
		 * function to view the order details of a user
		 *
		 */
		function view_renew_order_details() {
			$this->userid 				= 	$this->uri->segment(3);
                        $order_id 				= 	$this->uri->segment(4);
			$this->gen_contents['page_title']	=	'View Order Details';

			$this->session->set_flashdata('search_firstname',$this->session->flashdata('search_firstname'));
			$this->session->set_flashdata('search_lastname',$this->session->flashdata('search_lastname'));
			$this->session->set_flashdata('search_email',$this->session->flashdata('search_email'));

			$this->_renew_user_details($this->userid,$order_id);
			$this->gen_contents['orderdet']		=	$this->admin_user_model->select_single_renew_user_order_details($this->userid,$order_id);
			$this->_template('view_order_details',$this->gen_contents, "admin/missed payment management/");
		}
    }
/* End of file admin_missed_user.php */
/* Location: ./system/application/controllers/admin_missed_user.php */
