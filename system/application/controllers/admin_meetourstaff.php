<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
	* Project				-	Adhischools
	* Language				-	PHP 5 & above
	* Database				-	Mysql
	* Author				-	Shinu Mary Simon	
	* Created On 			-	November 17, 2011
	* Modified On 			-	November 17, 2011
	* Development Center	-	Rain Concert Technologies Pvt Ltd, Trivandrum, Kerala, India.(http://aarthikaindia.com)
*/
// ------------------------------------------------------------------------ 
	class Admin_meetourstaff extends Controller
	{
			
		/**
		 * General contents
		 *
		 * @var Array
		 */
		var $gen_contents	=	array();
		var $staff_id 	=	''; 	
		var $staff_name	=	'';			
		var $description=	'';		
		
		/**
		 * Admin constructor
		 * 
		 */
		function Admin_meetourstaff () {
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
			$this->load->model('admin_meet_staff_model');
			
			$this->load->helper ('tiny_mce');
			$this->gen_contents['css'] = array('admin_style.css');
			$this->gen_contents['js'] = array('admin_mettstaff.js');
			$this->gen_contents['css'] = array('admin_style.css','reskin/croppie.css');
			$this->gen_contents['js'] = array('reskin/jquery.min.js','admin_mettstaff.js','reskin/croppie.js',);
			
			$this->gen_contents['title']	=	'Meet our staff';
			
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
			$this->load->view('admin/meetstaff/'.$page, $contents);
			$this->load->view("admin_footer");
		}
		/**
		 * validating the staff in server side
		 *
		 */
		function _init_staff_validation_rules () {
			$this->form_validation->set_rules ('txtName','Name', 'trim|required');
			$this->form_validation->set_rules ('cboyear','Year', 'trim|required');
			$this->form_validation->set_rules ('txtHours','Base Hours', 'trim|required');
			$this->form_validation->set_rules ('txtContent','Description', 'trim|required');
			$this->form_validation->set_rules ('txtimg','Photo', 'trim|required');
		}
		/**
		 * Initialising the data
		 *
		 */
		function _init_staff (){
			$this->load->model('common_model');
			$this->staff_name			= $this->common_model->safe_html($this->input->post('txtName'));
			$this->year			= $this->common_model->safe_html($this->input->post('cboyear'));
			$this->basehour			= $this->common_model->safe_html($this->input->post('txtHours'));
			$this->description			= $this->input->post('txtContent');
			
		}
		/**
		 * Index
		 *
		 * @access	public
		 */	
		function index()
		{
			$this->list_staff();
		}
		/**
		 * function to list the user details
		 *
		 */
		function list_staff ()
		{	
			$this->load->model('common_model');
			$this->gen_contents['page_title']	=	'Meet our staff';
			$this->load->library('pagination');
			$config['base_url'] 				= 	base_url().'admin_meetourstaff/list_staff/';
			$config['per_page'] 				= 	'10';
			$config['uri_segment']  			=  	3;
			
		
			$this->gen_contents["search_testimonial"] = '';
			
			
			if(!empty($_POST)) { 
				$this->gen_contents["search_staff"] = $this->common_model->safe_html($this->input->post('txtStaff'));
			}else {
				$this->gen_contents["search_staff"] = $this->session->flashdata('search_staff');
			}
			$this->session->set_flashdata('search_staff',$this->gen_contents["search_staff"]);
									
			$this->gen_contents["staff"]	=	$this->admin_meet_staff_model->select_staff($config['per_page'],$this->uri->segment(3),$this->gen_contents["search_staff"]);
			$config['total_rows']   			= 	$this->admin_meet_staff_model->qry_count_staff($this->gen_contents["search_staff"]);
			
			$this->pagination->initialize($config);
			$this->gen_contents['paginate']     =   $this->pagination->create_links(true);
			$this->_template('list_staff',$this->gen_contents);
		}
		/**
		 * function to show the template and showing the details
		 *
		 */
		function add_staff (){ 
			if($_POST && !empty($_POST)){
				$this->_saveStaff();
			}
			$this->gen_contents['page_title']	=	'Add Staff';
			$this->gen_contents['title']		=	'Staff Management';
			$this->_template('add_staff',$this->gen_contents);
		}

		function _saveStaff(){
			if($this->input->post('txtName')){
				$this->_init_staff_validation_rules();
	
				if (FALSE == $this->form_validation->run()){
					$this->gen_contents['error'] =  validation_errors();
					return false;
				} else {
					$this->_init_staff();
					
					$staff_data					=	array();
					$staff_data['name']			=	$this->staff_name;
					$staff_data['since']			=	$this->year;
					$staff_data['basehour']		=	$this->basehour;
					$staff_data['description']	=	$this->description;
					$staff_data['upload_date']	=	date('Y-m-d');
					$staff_data['modified_date']=	date('Y-m-d');
					
					$flag = 0;
					if($flag == 0) {
						if($this->input->post('txtPhoto')) {
							$img  = $this->input->post('txtPhoto');
				 
							list($type, $img) = explode(';', $img);
							list(, $img)      = explode(',', $img);
							$data = base64_decode($img);
							$imgnew = "croppedImg_".rand().'.png';
							$output_filename =  $this->config->item('staff_image_upload_path').$imgnew;				 
							file_put_contents($output_filename, $data);
							if( file_exists($output_filename)){								 
								$staff_data['photo'] = $imgnew;
							}else{
								$this->session->set_flashdata('error',"Error while saving image");
	                            redirect('admin_meetourstaff/add_staff');
							}
							/*list($bUploadStatus, $aData) = $this->common_model->file_upload ( 'txtPhoto', $this->config->item('staff_image_upload_path'), $this->config->item('images_allowed_file_type'), $this->config->item('images_upload_limit'));
							if ($bUploadStatus) {
								$staff_data['photo'] 	= $aData['upload_data']['file_name']; 
										
								//Create thumbnails
								$this->load->model ('image_model');
								$this->image_model->image_resize (
											$aData['upload_data']['file_name'], 
											$aData['upload_data']['file_name'], 
											$this->config->item('staff_image_upload_path'), $this->config->item('staff_image_thumb_dimension')); 
													
							} else {
								$this->session->set_flashdata('error',$aData['error_msg']);
	                            redirect('admin_meetourstaff/add_staff');
							}
							 */
						}
						
						$staff_id			=	$this->admin_meet_staff_model->save_staff($staff_data);
						if($staff_id) {
							$this->session->set_flashdata('success','Successfully added staff.');
							redirect('admin_meetourstaff/list_staff');
						} else {
							$this->session->set_flashdata('error','Error was encountered while adding staff. Please try again.');
							redirect('admin_meetourstaff/add_staff');
						}
					}
				}
			}
		}
		
		/**
		 * function to get the staff details
		 *
		 */
		function _staff ($staff_id)
		{
			$this->staff_id 				= 	$staff_id;
			$this->gen_contents["staff"]	=	$this->admin_meet_staff_model->select_single_staff($this->staff_id);			
		}
		/**
		 * function to view the staff details
		 *
		 */
		function view_staff (){
			$this->gen_contents['page_title']	=	'Meet our staff';
			$this->_staff($this->uri->segment(3));
			
			$this->_template('view_staff',$this->gen_contents);
		}
		/**
		 * function to edit the staff
		 *
		 */
		function edit_staff (){
			$this->gen_contents['page_title']	=	'Edit Staff';
			$this->gen_contents["staff_id"]		=	$this->uri->segment(3);
			$this->gen_contents["pageid"]		=	$this->uri->segment(4);
			$this->_staff($this->gen_contents["staff_id"]);
			$this->_template('edit_staff',$this->gen_contents);
		}
		
		
		/**
		 * inner function to edit the staff
		 *
		 * @param int $staff_id
		 */
		function _edit_staff ($staff_id){
			$this->load->model('image_model');
			$staff_array	=	array(
								'id'			=>	$staff_id,
								'name' 			=>	$this->staff_name,
								'since' 			=>	$this->year,
								'basehour'		=>	$this->basehour,
								'description'	=>	$this->description,
								'modified_date'	=>	date('Y-m-d')						
								);
			if($this->input->post('txtPhoto')){
				
				$img  = $this->input->post('txtPhoto');
				 
				list($type, $img) = explode(';', $img);
				list(, $img)      = explode(',', $img);
				$data = base64_decode($img);
				$imgnew = "croppedImg_".rand().'.png';
				$output_filename =  $this->config->item('staff_image_upload_path').$imgnew;				 
				file_put_contents($output_filename, $data);
				if( file_exists($output_filename)){
					$staff	=	$this->admin_meet_staff_model->select_single_staff($staff_id);
					if('' != $staff->photo){
						$this->image_model->deleteImage('staff',$staff->photo);
					}
					$staff_array['photo'] = $imgnew;
				}
					
				
				
				/*if( '' != $_FILES['txtPhoto']['name'] ) {
					$staff	=	$this->admin_meet_staff_model->select_single_staff($staff_id);
					if('' != $staff->photo){
						$this->image_model->deleteImage('staff',$staff->photo);
					}
					list($bUploadStatus, $aData) = $this->common_model->file_upload ( 'txtPhoto', $this->config->item('staff_image_upload_path'), $this->config->item('images_allowed_file_type'), $this->config->item('images_upload_limit'));
					if ($bUploadStatus) {
						$staff_array['photo'] 	= $aData['upload_data']['file_name']; 
								
						//Create thumbnails
						$this->load->model ('image_model');
						$this->image_model->image_resize (
									$aData['upload_data']['file_name'], 
									$aData['upload_data']['file_name'], 
									$this->config->item('staff_image_upload_path'), $this->config->item('staff_image_thumb_dimension')); 
											
					} else {
						$this->session->set_flashdata('error',$aData['error_msg']);
	                    redirect('admin_meetourstaff/add_staff');
					}
				}
				 */	
			}					
			return $this->admin_meet_staff_model->update_staff($staff_array);
		}
		/**
		 * function to update the staff
		 *
		 */
		function update_staff () {
		
			$this->staff_id 	= 	$this->uri->segment(3);
			
			/* validating the fields*/
			$this->_init_staff_validation_rules();
			
			if($this->form_validation->run() == TRUE) {
				
				/* initialising the data*/
				$this->_init_staff();
				
				$update = $this->_edit_staff($this->staff_id );
				
				if($update > 0)
				{
					$this->session->set_flashdata ('success', 'Staff details updated successfully');
					redirect('admin_meetourstaff/list_staff/'.$this->uri->segment(4));
				}
				else
				{
					$this->session->set_flashdata ('error', 'Request Failed');
					redirect('admin_meetourstaff/edit_staff/'.$this->staff_id.'/'.$this->uri->segment(4));
				}
			}
			else {
				$this->edit_staff();
			}
		}
		/**
		 * function t0 delete a staff
		 *
		 */
		function delete_staff(){
			$this->staff_id 	= 	$this->input->post('hidstaffid');
			
			$staff	=	$this->admin_meet_staff_model->select_single_staff($this->staff_id);
			
			if('' != $staff->photo){
				$this->load->model('image_model');
				$this->image_model->deleteImage('staff',$staff->photo);
			}
			
			$delete = $this->admin_meet_staff_model->delete_staff($this->staff_id);
			if($delete){
				$this->session->set_flashdata ('success', 'Staff deleted successfully');
					redirect('admin_meetourstaff/list_staff/'.$this->uri->segment(4));
			}else {
				$this->session->set_flashdata ('error', 'Request Failed');
					redirect('admin_meetourstaff/list_staff/'.$this->uri->segment(4));
			}
		}
		
		function add_weeklyhours(){
			$this->load->model('common_model');
			$data['staff_id'] = $this->input->post('id');
			$data['hour'] = $this->input->post('hour');
			$id =$this->common_model->save('adhi_meet_staff_weekly_hour',$data);			 
			if($id){
				$msg['success']=true;
				$msg['msg']='Successfully added weekly hour';
			}else{
				$msg['success']=false;
				$msg['msg']='Error while saving data';
			
			}
			echo json_encode($msg);
		}
	}	
/* End of file admin.php */
/* Location: ./system/application/controllers/admin_meetourstaff.php */