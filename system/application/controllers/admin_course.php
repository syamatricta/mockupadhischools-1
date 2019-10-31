<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
	* Project				-	Adhischools
	* Language				-	PHP 5 & above
	* Database				-	Mysql
	* Author				-	Shinu Mary Simon	
	* Created On 			-	November 02, 2009
	* Modified On 			-	November 02, 2009
	* Development Center	-	Rain Concert Technologies Pvt Ltd, Trivandrum, Kerala, India.(http://aarthikaindia.com)
*/
// ------------------------------------------------------------------------ 
	class Admin_course extends Controller
	{
			
		/**
		 * General contents
		 *
		 * @var Array
		 */
		var $gen_contents	=	array();
		var $courseid 		=	''; 		/*Id of the selected course*/
		var $usertype		=	"";		
		var $amount			=	'';	
		var $weight			=	'';
		
		/**
		 * Admin constructor
		 * 
		 */
		function Admin_course () {
			parent::Controller();
			$this->load->library('authentication');
			$this->load->helper(array('form', 'file'));
			if (!$this->authentication->logged_in ("admin"))
			{
				redirect("admin");
			}
                        else if($this->authentication->logged_in ("admin") === "sub") 
                        {
                            redirect("admin/noaccess");
                            exit;
                        }
			$this->load->library(array('form_validation'));
			$this->load->model('admin_course_model');
			$this->gen_contents['css'] = array('admin_style.css','dhtmlgoodies_calendar.css');
			$this->gen_contents['js'] = array('admin_course_js.js');
			$this->gen_contents['title']	=	'Course Management';
			
		}
		/**
		 * function to load the template (header, body and footer)
		 *
		 * @param string $page
		 * @param array $contents
		 */
		function _template ($page,$contents){
			$this->load->view("admin_header",$contents);							
			$this->load->view('admin/course/'.$page, $contents);
			$this->load->view("admin_footer");
		}
		/**
		 * validating the course amount in server side
		 *
		 */
		function _init_course_validation_rules () {
			$this->form_validation->set_rules('txtWeight', 'Weight', 'required');
			/*$this->form_validation->set_rules('txtAmount', 'Amount', 'required');*/
		}
		function _init_course_rate_validation_rules () {
			$this->form_validation->set_rules('txtAmount', 'Amount', 'required');
		}
		/**
		 * Initialising the data
		 *
		 */
		function _init_course_details (){
			$this->weight			=	$this->input->post('txtWeight');
			
		}
		function _init_course_rate(){
			$this->amount			=	$this->input->post('txtAmount');
		}
		/**
		 * Index
		 *
		 * @access	public
		 */	
		function index()
		{
			$this->list_course_details();
		}
		/**
		 * function to list the course details
		 *
		 */
		function list_course_details ()
		{	
			
			/*$this->usertype						=	$this->uri->segment(3);
			if('' == $this->usertype)
			{
				$this->usertype	 = 'all';
			}else {
				$this->usertype	= $this->usertype;
			}*/
			$this->gen_contents["search_usertype"] = '';
			$this->gen_contents["search_coursetype"] = '';
			$this->gen_contents["search_paymenttype"] = '';
			
			if(!empty($_POST)) { 
				$this->gen_contents["search_usertype"] 		= $this->input->post('cmbType');
				$this->gen_contents["search_coursetype"] 	= $this->input->post('cmbCourseType');
				$this->gen_contents["search_paymenttype"] 	= $this->input->post('cmbPaymentType');			
			}else {
				$this->gen_contents["search_usertype"] = ($this->session->flashdata('search_firstname'))?$this->session->flashdata('search_firstname'):$this->gen_contents["search_firstname"];
				$this->gen_contents["search_coursetype"] = $this->session->flashdata('search_lastname');
				$this->gen_contents["search_paymenttype"] = $this->session->flashdata('search_email');				
			}
			$this->session->set_flashdata('search_usertype',$this->gen_contents["search_usertype"]);
			$this->session->set_flashdata('search_coursetype',$this->gen_contents["search_coursetype"]);
			$this->session->set_flashdata('search_paymenttype',$this->gen_contents["search_paymenttype"]);			
			
			
			if($this->gen_contents["search_usertype"] == 'all'){
				$this->usertype = 'all';
			} else if(($this->gen_contents["search_usertype"] == 'B') && ($this->gen_contents["search_coursetype"] == 'Live') && ($this->gen_contents["search_paymenttype"] == 'Package')){
				$this->usertype = '1';
			}else if(($this->gen_contents["search_usertype"] == 'B') && ($this->gen_contents["search_coursetype"] == 'Live') && ($this->gen_contents["search_paymenttype"] == 'Cart')){
				$this->usertype = '2';
			}else if(($this->gen_contents["search_usertype"] == 'B') && ($this->gen_contents["search_coursetype"] == 'Online') && ($this->gen_contents["search_paymenttype"] == 'Package')){
				$this->usertype = '3';
			}else if(($this->gen_contents["search_usertype"] == 'B') && ($this->gen_contents["search_coursetype"] == 'Online') && ($this->gen_contents["search_paymenttype"] == 'Cart')){
				$this->usertype = '4';
			}else if(($this->gen_contents["search_usertype"] == 'S') && ($this->gen_contents["search_coursetype"] == 'Live') && ($this->gen_contents["search_paymenttype"] == 'Package')){
				$this->usertype = '5';
			}else if(($this->gen_contents["search_usertype"] == 'S') && ($this->gen_contents["search_coursetype"] == 'Live') && ($this->gen_contents["search_paymenttype"] == 'Cart')){
				$this->usertype = '6';
			}else if(($this->gen_contents["search_usertype"] == 'S') && ($this->gen_contents["search_coursetype"] == 'Online') && ($this->gen_contents["search_paymenttype"] == 'Package')){
				$this->usertype = '7';
			}else if(($this->gen_contents["search_usertype"] == 'S') && ($this->gen_contents["search_coursetype"] == 'Online') && ($this->gen_contents["search_paymenttype"] == 'Cart')){
				$this->usertype = '8';
			}else {
				$this->usertype = '';
			}	
			$this->gen_contents['user_coursetype']		= $this->usertype;
			$this->gen_contents['page_title']	=	'Courses';
			$this->load->library('pagination');
			//$config['base_url'] 				= 	base_url().'admin_course/list_course_details/'.$this->gen_contents["search_usertype"].'/'.$this->gen_contents["search_coursetype"].'/'.$this->gen_contents["search_paymenttype"].'/';
			$config['base_url'] 				= 	base_url().'admin_course/list_course_details/';
			$config['per_page'] 				= 	'10';
			$config['uri_segment']  			=  	3;
			$this->gen_contents["courses"]		=	$this->admin_course_model->select_courses($config['per_page'],$this->uri->segment(3),$this->usertype);
			
			if($this->gen_contents["search_usertype"]!= '' || $this->gen_contents["search_usertype"] !='all'){
				$this->gen_contents["courses_list"] = $this->admin_course_model->select_all_courses();
						
			}	
			
			/*$i=0;
			foreach($this->gen_contents["courses"] as $courses){
				$sub[$i]	=	$this->admin_course_model->select_subcourses($courses->id);
				$i++;
			}
			$this->gen_contents["subcourses"]	=	$sub;*/
			$config['total_rows']   			= 	$this->admin_course_model->qry_count_coursedetails($this->usertype);
			$this->pagination->initialize($config);
			$this->gen_contents['paginate']     =   $this->pagination->create_links(true);
			$this->_template('list_course_details',$this->gen_contents);
		}
		
		/**
		 * function to edit the course details
		 *
		 */
		function edit_courseweight (){
			$this->gen_contents['page_title']	= 'Edit Course Weight';
			
			$total_weight					 	= $this->admin_course_model->admin_course_tot_weight();
			//weight calculation is done differently since the round function is not working in PHP 5.2.9
			$this->gen_contents['totweight']	= fncCalculateFloat(($total_weight/2.2),2);
			
			$this->gen_contents["course"]		= $this->admin_course_model->select_single_courses_det($this->uri->segment(3));
			$this->gen_contents['currentweight']= fncCalculateFloat(($this->gen_contents["course"]->wieght/2.2),2);
			
			$this->_template('edit_course_details',$this->gen_contents);
		}
		/**
		 * internal function to update the course details
		 *
		 * @param int $courseid
		 * @return unknown
		 */
		function _update_course_details($courseid){
			$userarray	=	array(
								'id'		=>	$courseid,
								'weight'	=>	$this->weight,
								'amount' 	=>	$this->amount,
								);	
			return $this->admin_course_model->update_course_details($userarray);
		}
		/**
		 * function to update the course details
		 *
		 */
		function update_course () {
			$this->courseid 	= 	$this->uri->segment(3);
			
			/* validating the fields*/
			$this->_init_course_validation_rules();
			
			if($this->form_validation->run() == TRUE) {
				
				/* initialising the data*/
				$this->_init_course_details();
				
				/* updating the course details*/
				$update = $this->_update_course_details($this->courseid);
				
				if($update > 0)
				{
					$this->session->set_flashdata ('success', 'Course details updated successfully');
					redirect('admin_course/edit_courseweight/'.$this->courseid.'/'.$this->uri->segment(4).'/'.$this->uri->segment(5));
				}
				else
				{
					$this->session->set_flashdata ('error', 'Request Failed');
					redirect('admin_course/edit_courseweight/'.$this->courseid);
				}
			}
			else {
				$this->edit_courseweight();
			}
		}
		/**
		 * function to edit the course rate
		 *
		 */
		function edit_courserate (){
			$this->gen_contents['page_title']	= 'Edit Course Rate';
			$this->courseid 	= 	$this->uri->segment(3);
			$this->gen_contents["course"]=$this->admin_course_model->select_single_course_rate($this->courseid);				
			$this->_template('edit_course_rate_details',$this->gen_contents);
		}
		/**
		 * internal function to update the course details
		 *
		 * @param int $courseid
		 * @return unknown
		 */
		function _update_course_rate($courseid){
			$userarray	=	array(
								'id'		=>	$courseid,
								'amount' 	=>	$this->amount,
								);	
			return $this->admin_course_model->update_course_rate($userarray);
		}
		/**
		 * function to update the course details
		 *
		 */
		function update_course_rate () {
			$this->courseid 	= 	$this->uri->segment(3);
			
			/* validating the fields*/
			$this->_init_course_rate_validation_rules();
			
			if($this->form_validation->run() == TRUE) {
				
				/* initialising the data*/
				$this->_init_course_rate();
				
				/* updating the course details*/
				$update = $this->_update_course_rate($this->courseid);
				
				if($update > 0)
				{
					$this->session->set_flashdata ('success', 'Course rate updated successfully');
					redirect('admin_course/edit_courserate/'.$this->courseid.'/'.$this->uri->segment(4));
				}
				else
				{
					$this->session->set_flashdata ('error', 'Request Failed');
					redirect('admin_course/edit_courserate/'.$this->courseid);
				}
			}
			else {
				$this->edit_courserate();
			}
		}
	}	
	
/* End of file admin.php */
/* Location: ./system/application/controllers/admin_user.php */