<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
	* Project				-	Adhischools
	* Language				-	PHP 5 & above
	* Database				-	Mysql
	* Author				-	Shinu Mary Simon	
	* Created On 			-	November 04, 2011
	* Modified On 			-	November 04, 2011
	* Development Center	-	Rain Concert Technologies Pvt Ltd, Trivandrum, Kerala, India.(http://aarthikaindia.com)
*/
// ------------------------------------------------------------------------ 
	class Admin_testimonials extends Controller
	{
			
		/**
		 * General contents
		 *
		 * @var Array
		 */
		var $gen_contents	=	array();
		var $testimonial_id 	=	''; 	
		var $testimonial_name	=	'';			
		var $testimonial		=	'';	
		var $test_desc 			= 	'';	
		
		/**
		 * Admin constructor
		 * 
		 */
		function Admin_testimonials () {
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
			$this->load->model('admin_testimonial_model');
			
			$this->load->helper ('tiny_mce');
			$this->gen_contents['css'] = array('admin_style.css');
			$this->gen_contents['js'] = array('admin_testimonials.js');
			$this->gen_contents['title']	=	'Testimonials';
			
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
			$this->load->view('admin/testimonials/'.$page, $contents);
			$this->load->view("admin_footer");
		}
		/**
		 * validating the testimonial in server side
		 *
		 */
		function _init_testm_validation_rules () {
			$this->form_validation->set_rules ('txtshortTitle','Short Testimonial', 'trim|required');
			$this->form_validation->set_rules ('txtContent','Testimonial', 'trim|required');
		}
		/**
		 * Initialising the data
		 *
		 */
		function _init_testimonial (){
			$this->load->model('common_model');
			$this->testimonial_name		= $this->common_model->safe_html($this->input->post('txtTitle'));
			$this->test_desc			= $this->common_model->safe_html($this->input->post('txtshortTitle'));
			$this->testimonial			= $this->input->post('txtContent');
			
		}
		/**
		 * Index
		 *
		 * @access	public
		 */	
		function index()
		{
			$this->list_testimonials();
		}
		/**
		 * function to list the user details
		 *
		 */
		function list_testimonials ()
		{	
			$this->load->model('common_model');
			$this->gen_contents['page_title']	=	'Testimonials';
			$this->load->library('pagination');
			$config['base_url'] 				= 	base_url().'admin_testimonials/list_testimonials/';
			$config['per_page'] 				= 	'10';
			$config['uri_segment']  			=  	3;
			
		
			$this->gen_contents["search_testimonial"] = '';
			
			
			if(!empty($_POST)) { 
				$this->gen_contents["search_testimonial"] = $this->common_model->safe_html($this->input->post('txttestimonial'));
			}else {
				$this->gen_contents["search_testimonial"] = $this->session->flashdata('search_testimonial');
			}
			$this->session->set_flashdata('search_testimonial',$this->gen_contents["search_testimonial"]);
									
			$this->gen_contents["testimonials"]	=	$this->admin_testimonial_model->select_testimonials($config['per_page'],$this->uri->segment(3),$this->gen_contents["search_testimonial"]);
			$config['total_rows']   			= 	$this->admin_testimonial_model->qry_count_testimonials($this->gen_contents["search_testimonial"]);
			
			$this->pagination->initialize($config);
			$this->gen_contents['paginate']     =   $this->pagination->create_links(true);
			$this->_template('list_testimonials',$this->gen_contents);
		}
		/**
		 * function to show the template and showing the details
		 *
		 */
		function add_testimonial (){ 
			if($_POST && !empty($_POST)){
				$this->_savetestimonial();
			}
			$this->gen_contents['page_title']	=	'Add Testimonial';
			$this->gen_contents['title']		=	'testimonial Management';
			$this->_template('add_testimonials',$this->gen_contents);
		}

		function _savetestimonial(){
			if($this->input->post('txtshortTitle')){
				$this->_init_testm_validation_rules();
	
				if (FALSE == $this->form_validation->run()){
					$this->gen_contents['error'] =  validation_errors();
					return false;
				} else {
					$this->_init_testimonial();
					
					$testimonial_data				=	array();
					
					$testimonial_data['testimonial_name']=	$this->testimonial_name;
					$testimonial_data['testimonial']	=	$this->testimonial;
					$testimonial_data['testimonial_short']	=	$this->test_desc;
					$testimonial_data['created_date']	=	date('Y-m-d');
					$testimonial_data['updated_date']	=	date('Y-m-d');
					
					$flag = 0;
					if($flag == 0) {
						$testm_id			=	$this->admin_testimonial_model->save_testimonial($testimonial_data);
	
						if($testm_id) {
							$this->session->set_flashdata('success','Successfully added testimonial.');
							redirect('admin_testimonials/list_testimonials');
						} else {
							$this->session->set_flashdata('error','Error was encountered while adding testimonials. Please try again.');
							redirect('admin_testimonials/add_testimonials');
						}
					}
	
				}
			}
		}
		
		/**
		 * function to get the testimonial
		 *
		 */
		function _testimonial ($testm_id)
		{
			$this->testimonial_id 				= 	$testm_id;
			$this->gen_contents["testimonial"]	=	$this->admin_testimonial_model->select_single_testimonial($this->testimonial_id);			
		}
		/**
		 * function to view the testimonial
		 *
		 */
		function view_testimonial (){
			$this->gen_contents['page_title']	=	'Testimonial';
			$this->_testimonial($this->uri->segment(3));
			
			$this->_template('view_testimonial',$this->gen_contents);
		}
		/**
		 * function to edit the testimonial
		 *
		 */
		function edit_testimonial (){
			$this->gen_contents['page_title']	=	'Edit Testimonial';
			$this->gen_contents["testm_id"]		=	$this->uri->segment(3);
			$this->gen_contents["pageid"]		=	$this->uri->segment(4);
			$this->_testimonial($this->gen_contents["testm_id"]);
			//print_r($this->gen_contents['testimonial']);exit();
			$this->_template('edit_testimonials',$this->gen_contents);
		}
		
		
		/**
		 * inner function to edit the testimonial
		 *
		 * @param int $testm_id
		 */
		function _edit_testimonials ($testm_id){
			
			$testm_array	=	array(
								'id'				=>	$testm_id,
								'testimonial_name' 	=>	$this->testimonial_name,
								'testimonial_short' =>	$this->test_desc,
								'testimonial'		=>	$this->testimonial,
								'updated_date'		=>	date('Y-m-d')						
								);	
			return $this->admin_testimonial_model->update_testimonial($testm_array);
		}
		/**
		 * function to update the testimonial
		 *
		 */
		function update_testimonial () {
		//	$this->testm_id 	= 	$this->input->post('hidtestm_id');
			$this->testm_id 	= 	$this->uri->segment(3);
			
			/* validating the fields*/
			$this->_init_testm_validation_rules();
			
			if($this->form_validation->run() == TRUE) {
				
				/* initialising the data*/
				$this->_init_testimonial();
				
				$testimonial_data				=	array();
				
				$testimonial_data['testimonial_name']=	$this->testimonial_name;
				$testimonial_data['testimonial_short']=	$this->test_desc;
				$testimonial_data['testimonial']	=	$this->testimonial;
				$testimonial_data['updated_date']	=	date('Y-m-d');
                 			
				$update = $this->_edit_testimonials($this->testm_id );
				
				if($update > 0)
				{
					$this->session->set_flashdata ('success', 'Testimonial updated successfully');
					redirect('admin_testimonials/list_testimonials/'.$this->uri->segment(4));
				}
				else
				{
					$this->session->set_flashdata ('error', 'Request Failed');
					redirect('admin_testimonials/edit_testimonial/'.$this->testm_id.'/'.$this->uri->segment(4));
				}
			}
			else {
				$this->edit_testimonial();
			}
		}
		/**
		 * function t delete a testimonial
		 *
		 */
		function delete_testimonial(){
			$this->testm_id 	= 	$this->input->post('hidtestimonialid');
			$delete = $this->admin_testimonial_model->delete_testimonial($this->testm_id);
			if($delete){
				$this->session->set_flashdata ('success', 'Testimonial deleted successfully');
					redirect('admin_testimonials/list_testimonials/'.$this->uri->segment(4));
			}else {
				$this->session->set_flashdata ('error', 'Request Failed');
					redirect('admin_testimonials/list_testimonials/'.$this->uri->segment(4));
			}
		}
	}	
/* End of file admin.php */
/* Location: ./system/application/controllers/admin_testimonial.php */