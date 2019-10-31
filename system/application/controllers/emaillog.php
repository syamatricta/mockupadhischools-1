<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
	* Project				-	Adhischools
	* Language				-	PHP 5 & above
	* Database				-	Mysql
	* Author				-	Anusha Anand	
	* Created On 			-	April 26, 2010
	* Modified On 			-	April 26, 2010
	* Development Center	-	Rain Concert Technologies Pvt Ltd, Trivandrum, Kerala, India.(http://aarthikaindia.com)
*/
// ------------------------------------------------------------------------ 
	class Emaillog extends Controller
	{
			
		/**
		 * General contents
		 */
		var $gen_contents	= array();
		var $subregion 		= array();
		var $region;
		var $regionid;
		
		/**
		 * Admin constructor
		 * 
		 */
		function Emaillog () {
			parent::Controller();
			
			$this->load->helper(array('form'));
			if (!$this->authentication->logged_in ("admin"))
			{
				redirect("admin");
			}
			$this->load->library(array('form_validation'));
			$this->load->model('admin_region_model');
			
			$this->gen_contents['css'] 		= array('admin_style.css','emaillog_style.css');
			$this->gen_contents['js'] 		= array('admin_region.js');
			$this->gen_contents['title']	= 'Region Management';
			
		}
		/**
		 * function to load the template (header, body and footer)
		 *
		 * @param string $page
		 * @param array $contents
		 */
		function _template ($page,$contents){
			$this->load->view("admin_header",$contents);							
			$this->load->view('admin/maillog/'.$page);
			$this->load->view("admin_footer");
		}
		/**
		 * Index
		 */	
		function index()
		{
			$this->email_box();
		}
		/**
		 * function to list the region details
		 */
		function email_box ()
		{	
			/*$this->load->library('pagination');
			$this->gen_contents['page_title']	=	'Regions';
			$config['base_url'] 				= 	base_url().'index.php/admin_region/list_region';
			$config['per_page'] 				= 	'10';
			$config['uri_segment']  			=  	3;
			$this->gen_contents["page_no"]		=   $this->uri->segment(3);
			$this->gen_contents["regions"]		=	$this->admin_region_model->dbSelectAllRegion($config['per_page'],$this->gen_contents["page_no"]);
			$config['total_rows']   			= 	$this->admin_region_model->dbGetTotalRegion();
			//$config				 				= array_merge($config,$this->config->item('pagination_standard'));
			$this->pagination->initialize($config);
			$this->gen_contents['paginate']     =   $this->pagination->create_links(true);*/
			$this->_template('mail_box',$this->gen_contents);
		}
		/**
		 * function to add a region
		 *
		 */
		/*function add_region(){
			
			$this->gen_contents['page_title']	= 'Add Region';
			$page_no = $this->uri->segment(3);
			$this->gen_contents['page_no'] = $page_no;
			
			if($_POST){
				$this->_init_region_validation_rules(); //server side validation of input values
				//server side validation
				if($this->form_validation->run() == TRUE){
					
					$this->_init_region_details(); // assigns the input value to an class member
					if(!$this->admin_region_model->dbUniqueRegion($this->region,'name')){  //checks for uniqueness of name
						
						if($this->admin_region_model->dbInsertRegion($this->region)){
							
							$this->session->set_flashdata('success','Region added successfully');
							redirect('admin_region/list_region');
						}
					}else{
						$this->gen_contents['error_region'] = 'The region by this name already exist.';
					}
				}
			}
			$this->_template('add_region',$this->gen_contents);
		}*/
		/**
		 * validating the form elemnets
		 */
		/*function _init_region_validation_rules () {
			$this->form_validation->set_rules('txtName', 'Name', 'required');
		}*/
		/**
		 * Initialising the data
		 *
		 */
		/*function _init_region_details (){
			$this->region = $this->input->post('txtName');
		}*/
		/**
		 * function to edit a region
		 *
		 */
		/*function edit_region(){
			$this->gen_contents['page_title']	= 'Edit Region';
			if(!validate_segments($this->uri->segment(4))){
				$this->session->set_flashdata('error','Invalid action');
				redirect('admin_region/list_region');
			}
			
			$page_no = $this->uri->segment(4);
			$this->gen_contents['page_no'] = $page_no;
			if(validate_segments($this->uri->segment(3))){
				$id = $this->uri->segment(3);
				
				if($_POST){
					$this->_init_region_validation_rules(); //server side validation of input values
					// server side validation
					if($this->form_validation->run() == TRUE){
						$this->_init_region_details();// assigns the input value to an class member
						
						if(!$this->admin_region_model->dbUniqueRegion($this->region,'name/id',$id)){ //checks for uniqueness of name
							
							if($this->admin_region_model->dbUpdateRegion($this->region,$id)){
								
								$this->session->set_flashdata('success','Region updated successfully');
								redirect('admin_region/list_region/'.$page_no);
							}
						}else{
							$this->gen_contents['error_region'] = 'The region by this name already exist.';
						}
					}
				}
				
				if($this->admin_region_model->dbUniqueRegion($id,'id')){
					$region_details					= $this->admin_region_model->dbSelectSingleRegion($id);
					$this->gen_contents['region'] 	= $region_details[0];
				}else{
					$this->gen_contents['error_region'] = 'Invalid action';
				}
			}else{
				$this->gen_contents['error_region'] = 'Invalid action';
			}
			$this->_template('edit_region',$this->gen_contents);
		}*/
		/**
		 * function to delete a particular region
		 */
		/*function delete_region(){
			$id 	= $this->uri->segment(3);
			$pageno = $this->uri->segment(4);
			if($this->admin_region_model->dbDeleteRegion($id)){
				$this->session->set_flashdata('success','Region deleted successfully');
			}else{
				$this->session->set_flashdata('error','Region deleted successfully');
			}
			redirect('admin_region/list_region/'.$pageno);
		}*/
		
		/*function add_subregion(){
			$this->gen_contents['page_title']	= 'Add Sub-Region';
			if(validate_segments($this->uri->segment(3))===FALSE){
				$this->session->set_flashdata('error','Invalid action');
				redirect('admin_region/list_region');
			}
			
			if(validate_segments($this->uri->segment(4))===FALSE){
				$this->session->set_flashdata('error','Invalid action');
				redirect('admin_region/list_region');
			}
			
			$page_no 							= $this->uri->segment(4);
			$this->gen_contents['page_no'] 		= $page_no;
			$this->gen_contents['region_id'] 	= $this->uri->segment(3);
			$region_id							= $this->uri->segment(3);
			$arr_region							= $this->admin_region_model->dbSelectSingleRegion($region_id);
			$this->gen_contents['region_name']	= $arr_region[0]->region_name;
			
			if($_POST){
				$this->_init_subregion_validation_rules(); //server side validation of input values
				//server side validation
				if($this->form_validation->run() == TRUE){
					
					$arr_subregion = $this->_init_subregion_values(); // assigns the input value to an class member
					if(!$this->admin_region_model->dbUniqueSubRegion('name',$arr_subregion['subregion'],$region_id)){  //checks for uniqueness of name
						
						if(!empty($_FILES)) {
							if (($_FILES['txtImage']['error']) ==  0) {
								if($this->do_upload()){	
									$arr_subregion = array_merge($arr_subregion,array('file_name'=>$this->gen_contents["file_name"]));
								}
							}
						}
						if($this->admin_region_model->dbInsertSubRegion($arr_subregion,$region_id)){
										
							$this->session->set_flashdata('success','Sub-Region added successfully');
							redirect('admin_region/add_subregion/'.$region_id.'/'.$page_no);
						}
					}else{
						$this->gen_contents['error_region'] = 'The Sub-Region by this name already exist in this region.';
					}
				}
			}
			$this->_template('add_subregion',$this->gen_contents);
		}*/
		/**
		 * validating the form elements
		 */
		/*function _init_subregion_validation_rules () {
			$this->form_validation->set_rules('txtName', 'Name', 'required');
			$this->form_validation->set_rules('txtAddress', 'Address', 'required');
			$this->form_validation->set_rules('txtaDescrption', 'Description', 'required');
		}
		
		function _init_subregion_values(){
			
			$subregion = array(
						 	'subregion' 		=> $this->input->post('txtName'),
						 	'subregion_address' => $this->input->post('txtAddress'),
						 	'subregion_des' 	=> $this->input->post('txtaDescrption')
			             );
			return $subregion;
		}*/
		
		/**
		 * function for file upload
		 */
		/*function do_upload(){
			$config['upload_path'] 				= $this->config->item ('image_upload_path');
			$config['allowed_types'] 			= implode('|',$this->config->item ('image_extensions'));
			$config['max_size']					= $this->config->item ('image_max_size');
			$config['max_width']  				= $this->config->item ('image_max_width');
			$config['max_height']  				= $this->config->item ('image_max_height');	
			$config['encrypt_name']				= TRUE;
			$img_ext 							= get_extension ('txtImage'); 			
			$imgname							= $_FILES['txtImage']['name'];
			$config['file_name']  				= $imgname;
			
			//checks if its of the same file extension
			$name_array = explode(".",$_FILES['txtImage']['name']);
			$ext        = $name_array[count($name_array)-1];
			if(!in_array($ext,$this->config->item ('image_extensions'))){
				$this->gen_contents['error_region'] = 'Incorrect file type';
				return FALSE;
			}
			
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('txtImage')){ 
				
				$this->gen_contents['error_region'] = $this->upload->display_errors();
				return FALSE;
			}	
			else{
				$arr_file = $this->upload->data();
				$this->gen_contents["file_name"] 	=  $arr_file['file_name'];
				image_resize($this->gen_contents['file_name'],$config['upload_path'],175,100);
				return TRUE;
			}
		}	
		
		function show_subregion(){
			$this->gen_contents['page_title']	= 'View Sub-Regions';
			if(validate_segments($this->uri->segment(3))===FALSE){
				$this->session->set_flashdata('error','Invalid action');
				redirect('admin_region/list_region');
			}
			
			if(validate_segments($this->uri->segment(4))===FALSE){
				$this->session->set_flashdata('error','Invalid action');
				redirect('admin_region/list_region');
			}
			
			$page_no 							= $this->uri->segment(4);
			$this->gen_contents['page_no'] 		= $page_no;
			$this->gen_contents['region_id'] 	= $this->uri->segment(3);
			$region_id							= $this->uri->segment(3);
			$arr_region							= $this->admin_region_model->dbSelectSingleRegion($region_id);
			if($arr_region)
				$this->gen_contents['region_name']	= $arr_region[0]->region_name;
			else{
				$this->session->set_flashdata('error','Invalid action');
				redirect('admin_region/list_region');
			}
			$this->gen_contents['subregion']	= $this->admin_region_model->dbSelectAllSubRegionByRegion($region_id);
			
			$this->_template('list_subregion',$this->gen_contents);
		}*/
					
	}	
/* End of file admin_region.php */
/* Location: ./system/application/controllers/admin_region.php */