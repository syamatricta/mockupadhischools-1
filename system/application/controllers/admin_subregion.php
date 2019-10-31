<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
	* Project				-	Adhischools
	* Language				-	PHP 5 & above
	* Database				-	Mysql
	* Author				-	Anusha Anand	
	* Created On 			-	April 27, 2010
	* Modified On 			-	April 27, 2010
	* Development Center	-	Rain Concert Technologies Pvt Ltd, Trivandrum, Kerala, India.(http://aarthikaindia.com)
*/
// ------------------------------------------------------------------------ 
	class Admin_subregion extends Controller
	{
			
		/**
		 * General contents
		 */
		var $gen_contents	= array();
		var $subregion 		= array();
	
		/**
		 * Admin constructor
		 * 
		 */
		function Admin_subregion () {
			parent::Controller();
			
			$this->load->helper(array('form'));
			if (!$this->authentication->logged_in ("admin"))
			{
				redirect("admin");
			}
                        else if($this->authentication->logged_in ("admin") === "sub" && !$this->authentication->check_permission_redirect('sub_permission_1', FALSE)) 
                        {
                            redirect("admin/noaccess");
                            exit;
                        }
			$this->load->library(array('form_validation'));
			$this->load->model('admin_subregion_model');
			$this->load->model('admin_region_model');
			$this->load->model('common_model');
			
			$this->gen_contents['css'] 		= array('admin_style.css');
			$this->gen_contents['js'] 		= array('admin_subregion.js');
			$this->gen_contents['title']	= 'Sub-Region Management';
			
		}
		/**
		 * function to load the template (header, body and footer)
		 *
		 * @param string $page
		 * @param array $contents
		 */
		function _template ($page,$contents){
			$this->load->view("admin_header",$contents);							
			$this->load->view('admin/subregion/'.$page);
			$this->load->view("admin_footer");
		}
		/**
		 * Index
		 */	
		function index()
		{
			$this->list_subregion();
		}
		/**
		 * function to list the region details
		 */
		function list_subregion ()
		{	
			$this->load->library('pagination');			
			$this->gen_contents['page_title']	= 'Sub-Regions';
			$config['base_url'] 				= base_url().'index.php/admin_subregion/list_subregion';
			$config['per_page'] 				= '10';
			$config['uri_segment']  			= 3;
			$this->gen_contents["page_no"]		= $this->uri->segment(3);
			$region_search						= 0;
			
			if($_POST){
				$region_search = $this->input->post('sltRegionList');
			}
			
			$this->gen_contents["region_id"]	= $region_search;
			
			$this->gen_contents["regions"]		= $this->admin_subregion_model->dbSelectAllSubRegion($config['per_page'],$this->gen_contents["page_no"],$region_search);
			$config['total_rows']   			= $this->admin_subregion_model->dbGetTotalSubRegion($region_search);
			$this->gen_contents['region_list']	= $this->admin_region_model->dbSelectAllRegionDetails();
			
			$this->pagination->initialize($config);
			$this->gen_contents['paginate']     =   $this->pagination->create_links(true);
			$this->_template('list_subregion',$this->gen_contents);
		}
			
		/**
		 * validating the form elements
		 */
		function _init_subregion_validation_rules () {
			$this->form_validation->set_rules('txtName', 'Name', 'required');
			$this->form_validation->set_rules('txtAddress', 'Address', 'required');
			$this->form_validation->set_rules('txtaDescription', 'Description', 'required');
			$this->form_validation->set_rules('sltRegion', 'Region', 'required');
		}
		
		function _init_subregion_values(){
			
			$subregion = array(
						 	'subregion' 		=> $this->input->post('txtName'),
						 	'subregion_address'     => $this->common_model->safe_html($this->input->post('txtAddress')),
						 	'subregion_des' 	=> $this->common_model->safe_html($this->input->post('txtaDescription')),
						 	'region_id'		=> $this->input->post('sltRegion')
			             );
			return $subregion;
		}
		/**
		 * function to add sub region
		 */
		function add_subregion(){
			$this->gen_contents['page_title']	= 'Add Sub-Region';
			if(validate_segments($this->uri->segment(3))===FALSE){
				$this->session->set_flashdata('error','Invalid action');
				redirect('admin_subregion/list_subregion');
			}
			$flag 								= 0;
			$page_no 							= $this->uri->segment(3);
			$this->gen_contents['page_no'] 		= $page_no;
			$this->gen_contents['region']		= $this->admin_region_model->dbSelectAllRegionDetails();
			
			if(isset($_POST['btnAdd_x'])){
				$this->_init_subregion_validation_rules(); //server side validation of input values
				//server side validation
				if($this->form_validation->run() == TRUE){
					
					$arr_subregion = $this->_init_subregion_values(); // assigns the input value to an class member
					if(!$this->admin_region_model->dbUniqueSubRegion('name',$arr_subregion['subregion'])){  //checks for uniqueness of name
						
						if(!empty($_FILES)) {
							if (($_FILES['txtImage']['error']) ==  0) {
								if($this->do_upload()){	
									
									$arr_subregion = array_merge($arr_subregion,array('file_name'=>$this->gen_contents["file_name"]));
								}else{
									$flag = 1;
								}
							}
						}
						if($flag==0){
							if($this->admin_region_model->dbInsertSubRegion($arr_subregion,$arr_subregion['region_id'])){
							
								$this->session->set_flashdata('success','Sub-Region added successfully');
								redirect('admin_subregion/add_subregion/'.$page_no);
							}
						}
					}else{
						$this->gen_contents['error_region'] = 'The Sub-Region by this name already exist in this region.';
					}
				}
			}
			$this->_template('add_subregion',$this->gen_contents);
		}
	
		/**
		 * function for file upload
		 */
		function do_upload(){
			
			$config['upload_path'] 				= $this->config->item ('image_upload_path');
			$config['allowed_types'] 			= implode('|',$this->config->item ('image_extensions'));
			$config['max_size']					= $this->config->item ('image_max_size');
			$config['max_width']  				= $this->config->item ('image_max_width');
			$config['max_height']  				= $this->config->item ('image_max_height');	
			$config['encrypt_name']				= TRUE;
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
				
				image_resize($this->gen_contents['file_name'],$config['upload_path'],480,270);
				
				return TRUE;
			}
		}
		
		/**
		 * function to delete a particular region
		 */
		function delete_subregion(){
			$id 	= $this->uri->segment(3);
			$pageno = $this->uri->segment(4);
			$arr_subregion	= $this->admin_subregion_model->dbSelectSingleSubRegion($id);
			@unlink($this->config->item ('image_upload_path').$arr_subregion[0]->image_name);
			@unlink($this->config->item ('image_upload_path').'thumbs/'.$arr_subregion[0]->image_name);
			if($this->admin_subregion_model->dbDeleteSubRegion($id)){
				$this->session->set_flashdata('success','Sub-Region deleted successfully');
			}else{
				$this->session->set_flashdata('error','Sub-Region deleted successfully');
			}
			redirect('admin_subregion/list_subregion/');
		}	
		
		/**
		 * function to edit a sub-region
		 *
		 */
		function edit_subregion(){
			$this->gen_contents['page_title']	= 'Edit Sub-Region';
			if(!validate_segments($this->uri->segment(4))){
				$this->session->set_flashdata('error','Invalid action');
				redirect('admin_subregion/list_subregion');
			}
			
			$page_no 						= $this->uri->segment(4);
			$this->gen_contents['page_no'] 	= $page_no;
			if(validate_segments($this->uri->segment(3))){
				$id 	= $this->uri->segment(3);
				$flag 	= 0;
				
				$arr_subregion					 		= $this->admin_subregion_model->dbSelectSingleSubRegion($id);
                                
				if($arr_subregion){
					$this->gen_contents['subregion'] 	= $arr_subregion[0];
				}else{
					$this->session->set_flashdata('error','Invalid action');
					redirect('admin_subregion/list_subregion');
				}
				
				
				if(isset($_POST['btnUpdate_x'])){ 
					$this->_init_subregion_validation_rules(); //server side validation of input values
					// server side validation
					if($this->form_validation->run() == TRUE){
						$arr_subregion_post = $this->_init_subregion_values();// assigns the input value to an class member
						
						if(!$this->admin_region_model->dbUniqueSubRegion('name/id',$arr_subregion_post['subregion'],$id)){ //checks for uniqueness of name
							
							if(!empty($_FILES)) {
								if (($_FILES['txtImage']['error']) ==  0) {
									
									if($this->do_upload()){	
										@unlink($this->config->item ('image_upload_path').$arr_subregion[0]->image_name);
										@unlink($this->config->item ('image_upload_path').'thumbs/'.$arr_subregion[0]->image_name);
										$arr_subregion_post = array_merge($arr_subregion_post,array('file_name'=>$this->gen_contents["file_name"]));
									}else{
										$flag = 1;
									}
								}
							}
							if($flag==0){
								if($this->admin_subregion_model->dbUpdateSubRegion($arr_subregion_post,$id)){
									
									$this->session->set_flashdata('success','Sub-Region updated successfully');
									redirect('admin_subregion/list_subregion/'.$page_no);
								}
							}
						}else{
							$this->gen_contents['error_region'] = 'The sub-region by this name already exist.';
						}
					}
				}
								
				$arr_region 						= $this->admin_region_model->dbSelectSingleRegion($arr_subregion[0]->region_id);
				if($arr_region){
					$this->gen_contents['region'] 		= $arr_region[0]->region_name;
				}else{
					$this->session->set_flashdata('error','Invalid action');
					redirect('admin_subregion/list_subregion');
				}
				
			}else{
				$this->session->set_flashdata('error','Invalid action');
				redirect('admin_subregion/list_subregion');
			}
			$this->_template('edit_subregion',$this->gen_contents);
		}
		
		function view_subregion(){
			$this->gen_contents['page_title']	= 'View Sub-Region';
			if(!validate_segments($this->uri->segment(4))){
				$this->session->set_flashdata('error','Invalid action');
				redirect('admin_subregion/list_subregion');
			}
			
			$page_no 						= $this->uri->segment(4);
			$this->gen_contents['page_no'] 	= $page_no;
			if(validate_segments($this->uri->segment(3))){
				$id 	= $this->uri->segment(3);
				
				$arr_subregion					 		= $this->admin_subregion_model->dbSelectSingleSubRegion($id);
				if($arr_subregion){
					$this->gen_contents['subregion'] 		= $arr_subregion[0];
				}else{
					$this->session->set_flashdata('error','Invalid action');
					redirect('admin_subregion/list_subregion');
				}
				
				$arr_region 							= $this->admin_region_model->dbSelectSingleRegion($arr_subregion[0]->region_id);
				if($arr_region){
					$this->gen_contents['region'] 			= $arr_region[0]->region_name;
				}else{
					$this->session->set_flashdata('error','Invalid action');
					redirect('admin_subregion/list_subregion');
				}
			}else{
				$this->session->set_flashdata('error','Invalid action');
				redirect('admin_subregion/list_subregion');
			}
			$this->_template('view_subregion',$this->gen_contents);
		}
		
	}	
/* End of file admin_subregion.php */
/* Location: ./system/application/controllers/admin_subregion.php */