<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Project				-	Adhischools
* Language				-	PHP 5 & above
* Database				-	Mysql
* Author				-	Rahul PK
* Created On 			-	April 03, 2014
* Modified On 			-	April 03, 2014
* Development Center	-	Rain Concert Technologies Pvt Ltd, Trivandrum, Kerala, India.(http://www.rainconcert.in)
*/
// ------------------------------------------------------------------------ 
class Supplement extends Controller
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
	function Supplement () {
		parent::Controller();
		$this->load->library('authentication');
		$this->load->helper(array('form', 'file'));
		if (!$this->authentication->logged_in ("admin")){
			redirect("admin");
		}
		$this->load->library(array('form_validation'));
		$this->load->model('supplement_model');
		$this->load->model('common_model');
		$this->gen_contents['css']		= array('admin_style.css');
		$this->gen_contents['js']		= array('supplement.js');
		$this->gen_contents['title']	= 'Supplement Management';
		
	}
	/**
	 * function to load the template (header, body and footer)
	 *
	 * @param string $page
	 * @param array $contents
	 */
	function _template ($page,$contents){
		$this->load->view("admin_header",$contents);							
		$this->load->view('admin/supplement/'.$page, $contents);
		$this->load->view("admin_footer");
	}
	
	/**
	 * List all Supplements
	 *
	 */
	function all(){
		$this->gen_contents['page_title']	= 'Supplement Summary';
		$this->gen_contents ["courses"]		= $this->supplement_model->allCourses();
		
		if(isset($_POST['course_id']) && '' != $_POST['course_id']){
			$this->gen_contents['course_id'] = $this->input->post('course_id');	
		}else{
			$this->gen_contents['course_id'] ='';	
		}
		
		$this->load->library('pagination');
		$config['base_url'] 				= base_url().'supplement/all';
		$config['per_page'] 				= 10;
		$config['uri_segment']  			= 3;
		$this->gen_contents["supplement_details"]	= $this->supplement_model->all('list', $this->gen_contents, $config['per_page'], $this->uri->segment(3));
		$config['total_rows']   					= $this->supplement_model->all('count', $this->gen_contents);		
		$this->pagination->initialize($config);
		
		$this->gen_contents['paginate']     =   $this->pagination->create_links(true);
		
		$this->_template('all',$this->gen_contents);
	}
	
	/**
	 * Add Supplements against a Course - Edition(Multiple file upload)
	 *
	 */
	function add(){
		$this->gen_contents["course_id"]	= ($this->uri->segment(3) > 0 ) ? $this->uri->segment(3) : 0;
		$this->gen_contents["course_id"]	= (isset($_POST['course_id'])) ? $_POST['course_id']: $this->gen_contents["course_id"];
		$course_id							= $this->gen_contents["course_id"];
		
		$this->gen_contents['page_title']	= 'Add Supplement';
		$this->gen_contents ["courses"]		= $this->supplement_model->allCourses();
		$this->gen_contents ["editions"]	= $this->supplement_model->allEditions($course_id);		
		if(isset($_POST['course_id'])){
			$edition_id	= $this->input->post('edition_id');
			$this->gen_contents['title_err_fld']	= array();
			$this->gen_contents['file_err_fld']		= array();
			if($this->supplement_model->hasSupplements($course_id, $edition_id)){
				$this->gen_contents['error'] = 'The selected Course with Edition have already Supplements, You can add new supplements in <a href="'.c('site_baseurl').'supplement/edit/'.$course_id.'/'.$edition_id.'">Edit</a> section ';
			}else{				
				$this->load->library('upload');
				$this->form_validation->set_rules ('course_id',"Course", 'required');
				$this->form_validation->set_rules ('edition_id',"Edition", 'trim|required');			
				if ((TRUE == $this->form_validation->run())) {
					$error_msg			= '';
					$title_err_count	= 0;
					$file_err_count		= 0;
					$file_invalid_count	= 0;
					$title_err_fld	= array();
					$file_err_fld	= array();
					
					foreach ($_POST['title'] as $key => $title){
						if('' == trim($title)){
							$title_err_count++;
							array_push($title_err_fld, $key);
						}						
						if('' == trim($_FILES['file_'.$key]['name'])){
							$title_err_count++;
							array_push($file_err_fld, $key);
						}else if(!in_array(trim($_FILES['file_'.$key]['type'], '"'), $this->upload->mimes_types('pdf'))){
							$file_invalid_count++;
							array_push($file_err_fld, $key);
						}
					}
					
					if($title_err_count > 0 && $fil_err_count > 0){
						$error_msg	= 'Empty Title / File';
					}else if($title_err_count > 0){
						$error_msg	= 'Title field is empty';
					}else if($file_err_count > 0){
						$error_msg	= 'File field is empty';
					}
					if($file_invalid_count > 0){
						$error_msg	= 'Invalid File format, only accept .pdf';
					}
					$this->gen_contents['title_err_fld']	= $title_err_fld;
					$this->gen_contents['file_err_fld']		= $file_err_fld;
					$this->gen_contents['error'] 			= $error_msg;
					if('' == $this->gen_contents['error']){
						$course_id		= trim($this->input->post ('course_id'));
						$edition_id		= trim($this->input->post ('edition_id'));
				    	
				    	$file_arr		= array();
				    	$upload_path	= c('supplement_file_path');
				    	foreach ($_POST['title'] as $key => $title){
				    		$file_return = file_upload('pdf', 'file_'.$key, $upload_path);
				    		if(isset($file_return['error'])){
				    			$this->gen_contents['error'] =  $file_return['error'];
				    			break;
				    		}else{
				    			$file_arr[$key]	= $file_return['file_name'];
				    		}
				    	}
				    	if('' == $this->gen_contents['error']){
				    		$this->db->trans_begin();
				    		foreach ($_POST['title'] as $key => $title){
				    			$data	= array(
				    							'course_id'		=> $course_id,
				    							'edition_id'	=> $edition_id,
				    							'title'			=> $title,
				    							'file'			=> $file_arr[$key],
				    							'created_date'	=> date('Y-m-d H:i:s')
				    						);
								if(!$this->common_model->save('adhi_supplements', $data)){
									$this->db->trans_rollback();
									break;
								}
				    		}
				    		if ($this->db->trans_status() === TRUE){
				    			$this->db->trans_commit();
				    			$this->session->set_flashdata('success', 'Supplement(s) added successfully');
			    		   		
				    		}else{
				    			$this->session->set_flashdata('error', 'Failed to save Supplement(s)');
				    		}
				    		redirect ('supplement/all');
				    	}
				    	
					}
						
				}else {
					$this->merror=validation_errors();
				}
			}
		}
		$this->_template('add',$this->gen_contents);
	}
	
	/**
	 * Ajax call for edition dropdown by posting course id
	 *
	 */
	function get_editions(){		
		$course_id			= ($this->input->post('course_id') > 0 ) ? $this->input->post('course_id') : 0;
		$editions			= $this->supplement_model->allEditions($course_id);
		$edition_array		= array('' => 'Select Edition');
		if($editions){
			foreach ($editions as $edition){
				$edition_array[$edition->id] = 'Edition '.$edition->edition_no;
				if($edition->default_edition == 1) $edition_array[$edition->id] .= ' (Default)';				
			}
		}
		$output['return_value']= form_dropdown('edition_id', $edition_array, '0', 'id="edition_id"');
		$this->load->view('dsp_show_ajax', $output);
	}
	
	/**
	 * Edit Course - Edition's supplements
	 *
	 */
	function edit(){
		$this->gen_contents['page_title']	= 'Edit Supplement';
		
		$this->gen_contents["course_id"]			= $course_id	= $this->uri->segment(3);
		$this->gen_contents ["edition_id"]			= $edition_id	= $this->uri->segment(4);
		if($course_id > 0 && $edition_id > 0){
			$this->gen_contents ["supplement_details"] 	= $this->supplement_model->getSupplements($course_id, $edition_id);
			if(count($this->gen_contents ["supplement_details"]) || (isset($_POST['edit_title']) || isset($_POST['title']))){
				if(isset($_POST['edit_title']) || isset($_POST['title'])){
					$this->load->library('upload');
					$error_msg			= '';
					$title_err_count		= 0;
					$edit_title_err_count	= 0;
					$file_err_count			= 0;
					$file_invalid_count		= 0;
					$title_err_fld			= array();
					$edit_title_err_fld		= array();
					$file_err_fld			= array();
					if(isset($_POST['edit_title'])){
						foreach ($_POST['edit_title'] as $key => $title){
							if('' == trim($title)){
								$title_err_count++;
								array_push($edit_title_err_count, $key);
							}
						}
					}				
					if(isset($_POST['title']) && count($_POST['title']) > 0){
						foreach ($_POST['title'] as $key => $title){
							if('' == trim($title)){
								$title_err_count++;
								array_push($title_err_fld, $key);
							}
							if('' == trim($_FILES['file_'.$key]['name'])){
								$title_err_count++;
								array_push($file_err_fld, $key);
							}else if(!in_array(trim($_FILES['file_'.$key]['type'], '"'), $this->upload->mimes_types('pdf'))){
								$file_invalid_count++;
								array_push($file_err_fld, $key);
							}
						}
					}
					
					if($title_err_count > 0 && $fil_err_count > 0){
						$error_msg	= 'Empty Title / File';
					}else if($edit_title_err_count > 0 || $title_err_count > 0){
						$error_msg	= 'Title field is empty';
					}else if($file_err_count > 0){
						$error_msg	= 'File field is empty';
					}
					if($file_invalid_count > 0){
						$error_msg	= 'Invalid File format, only accept .pdf';
					}
					$this->gen_contents['edit_title_err_fld']	= $edit_title_err_fld;
					$this->gen_contents['title_err_fld']	= $title_err_fld;
					$this->gen_contents['file_err_fld']		= $file_err_fld;
					$this->gen_contents['error'] 			= $error_msg;
					if('' == $this->gen_contents['error']){
						if(isset($_POST['title']) && count($_POST['title']) > 0){
					    	$file_arr		= array();
					    	$upload_path	= c('supplement_file_path');
					    	foreach ($_POST['title'] as $key => $title){
					    		$file_return = file_upload('pdf', 'file_'.$key, $upload_path);
					    		if(isset($file_return['error'])){
					    			$this->gen_contents['error'] =  $file_return['error'];
					    			break;
					    		}else{
					    			$file_arr[$key]	= $file_return['file_name'];
					    		}
					    	}
						}
				    	if('' == $this->gen_contents['error']){
				    		$this->db->trans_begin();
				    		$where	= array();
				    		$data	= array();
				    		$db_error	= 0;
				    		if(isset($_POST['edit_title'])){
					    		foreach ($_POST['edit_title'] as $key => $title){
					    			$where['id']			= $key;
					    			$data['title']			= $title;
					    			$data['updated_date']	= date('Y-m-d H:i:s');
					    			if(!$this->common_model->update('adhi_supplements', $data, $where)){
					    				$this->db->trans_rollback();
					    				$db_error	= 1;
										break;
					    			}
					    		}
				    		}
				    		if(0 == $db_error && isset($_POST['title']) && count($_POST['title']) > 0){
					    		foreach ($_POST['title'] as $key => $title){
					    			$data	= array(
					    							'course_id'		=> $course_id,
					    							'edition_id'	=> $edition_id,
					    							'title'			=> $title,
					    							'file'			=> $file_arr[$key],
					    							'created_date'	=> date('Y-m-d H:i:s')
					    						);
									if(!$this->common_model->save('adhi_supplements', $data)){
										$this->db->trans_rollback();
										$db_error = 1;
										break;
									}
					    		}
				    		}
				    		if ($this->db->trans_status() === TRUE){
				    			$this->db->trans_commit();
				    			$this->session->set_flashdata('success', 'Supplement(s) modified successfully');
			    		   		
				    		}else{
				    			$this->session->set_flashdata('error', 'Failed to modify Supplement(s)');
				    		}
				    		redirect ('supplement/all');
				    	}
				    	
					}
				}
				$this->_template('edit', $this->gen_contents);
			}else {
				$this->session->set_flashdata('error', 'Invalid url');
				redirect ('supplement/all');
			}
		}else {
			$this->session->set_flashdata('error', 'Invalid url');
			redirect ('supplement/all');
		}
	}
	
	/**
	 * Download a supplement
	 *
	 */
	function download(){
		$id		= $this->uri->segment(3);
		if($id > 0 && $supplement = $this->supplement_model->getSupplementById($id)){
			$file_path	= c('supplement_file_path').$supplement->file;
			if(file_exists($file_path)){
				$this->load->helper('download');
				$data 			= file_get_contents($file_path); // Read the file's contents
				$new_file_name	= supplementFileName($supplement->course_name, $supplement->edition_no, $supplement->title);
				force_download($new_file_name, $data);
			}else{
				$this->session->set_flashdata('error', 'Invalid request');
				redirect ('supplement/all');
			}
		}else{
			$this->session->set_flashdata('error', 'Invalid request');
			redirect ('supplement/all');
		}
	}
	
	/**
	 * Delete a supplement
	 *
	 */
	function delete(){
		$id		= $this->input->post('id');
		$result	= array('success' => 0, 'message' => 'Invalid request', 'no_supplements' => 0);
		if($id > 0 && $supplement = $this->supplement_model->getSupplementById($id)){
			$course_id	= $supplement->course_id;
			$edition_id	= $supplement->course_id;
			if($this->supplement_model->deleteById($id)){
				$file_path	= c('supplement_file_path').$supplement->file;
				if(file_exists($file_path)){
					@unlink($file_path);
				}
				$result['success'] = 1;
				$result['message'] = 'Successfully deleted the Supplement';
				if(!$this->supplement_model->hasSupplements($course_id, $edition_id)){
					$result['no_supplements'] = 1;
				}
				//$result['message'] = 'Successfully deleted the Supplement. No Supplements exist for this Edition, you can <a href="'.c('site_baseurl').'supplement/add/'.$course_id.'/'.$edition_id.'">Add new Supplements</a> or <a href="'.c('site_baseurl').'supplement/all">Back to list</a>';
				
			}
		}
		$output['return_value']= json_encode($result);
		$this->load->view('dsp_show_ajax', $output);
	}
	
	/**
	 * Delete all supplements in course - edition
	 *
	 */
	function delete_all(){
		$course_id		= $this->uri->segment(3);
		$edition_id		= $this->uri->segment(4);
		$supplements	= $this->supplement_model->getSupplements($course_id, $edition_id);		
		if($course_id > 0 && $edition_id > 0 && count($supplements) > 0){
			if($this->supplement_model->deleteAll($course_id, $edition_id)){
				foreach ($supplements as $supplement){
					$file_path	= c('supplement_file_path').$supplement->file;
					if(file_exists($file_path)){
						@unlink($file_path);
					}
				}
				$this->session->set_flashdata('success', 'Successfully deleted the Supplement');
			}else{
				$this->session->set_flashdata('error', 'Failed to delete Supplement');
			}
		}else{
			$this->session->set_flashdata('error', 'Invalid request');
		}
		redirect ('supplement/all');
	}
}