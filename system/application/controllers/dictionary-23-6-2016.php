<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
	* Project				-	Crash course online
	* Language				-	PHP 5 & above
	* Database				-	Mysql
	* Author				-	Sreeraj s	
	* Created On 			-	March 16, 2010
	* Modified On 			-	March 29, 2010
	* Development Center	-	Rain Concert Technologies Pvt Ltd, Trivandrum, Kerala, India.(http://aarthikaindia.com)
*/

// ------------------------------------------------------------------------

	class Dictionary extends Controller {
		
		
		/**
		 * keyword
		 *
		 * @var string
		 */
		var $keyword	=	'';
		/**
		 * keyword
		 *
		 * @var string
		 */
		var $definition	=	'';
		
		/**
		 * General contents
		 *
		 * @var Array
		 */
		var $gen_contents	=	array();
		
		/**
		 * Dictionary constructor
		 * 
		 */
		function Dictionary() {
			
			parent::Controller();
			
			$this->load->helper("form");
			$this->load->model('common_model');
			$this->load->model('dictionary_model');
			$this->load->library('form_validation');
			$this->gen_contents["css"]	=	array('admin_style.css','style.css');
			$this->gen_contents["js"]	=	array('dictionary.js');	
			$this->gen_contents["title"]= 'Dictionary Management';
                        
                        if($this->authentication->logged_in ("admin") === "sub") 
                        {
                            redirect("admin/noaccess");
                            exit;
                        }
		}
		
		/**
		 * default page
		 *
		 */
		function index() {
 			if($this->authentication->logged_in('admin'))
				redirect("dictionary/dictionary_list");
			else
				redirect("admin/login");	

		}
		
		/**
		 * function to load the admin template (header, body and footer)
		 *
		 * @param string $page
		 * @param array $contents
		 */
		function _admin_template ($page,$contents){			
			$this->load->view("admin_header",$contents);
			$this->load->view('dictionary/'.$page, $contents);
			$this->load->view("admin_footer",$contents);
		}
		
		/**
		 * Dictinary list
		 * @param  no parameters
		 * 
		 */
		function dictionary_list () {
			if(!$this->authentication->logged_in("admin"))
					redirect("admin/login");
			else{
				
				$this->gen_contents["title"]= 'Dictionary Listing';
				$this->gen_contents["page_title"]= 'Dictionary List';
				$search_keyword = '';
				if(isset($_POST['search_keyword']) && '' != $_POST['search_keyword']){
					$this->form_validation->set_rules ('search_keyword', '', 'trim|xss_clean');
					$search_keyword = $this->common_model->safe_html($_POST['search_keyword']);
				}
				
				$this->load->library('pagination');
				$config['base_url'] 				= 	base_url().'dictionary/dictionary_list/';
				$config['per_page'] 				= 	10;
				if ('' == $this->uri->segment(3))
					$offset	=	0;
				else
			    	$offset	=	$this->uri->segment(3);
                                $this->gen_contents["slno"] = $offset;
                                $this->gen_contents["offset_val"] = $offset;
                                $this->gen_contents['upload_status']		= $this->common_model->getUploadStatus ();
                                //$this->gen_contents['ex_count']				= $this->common_model->getCountOfPersonsInExams ();
                                $this->gen_contents['quiz_count']	= $this->common_model->get_person_taking_quiz ();                				
                                $config['total_rows']   			= 	$this->dictionary_model->qry_s_get_count_dictionary_details($search_keyword);
                                if($config['total_rows'] <= $offset){
                                    $offset = 0;
                                }
			    
				$this->gen_contents["dictionary_details"] = $this->dictionary_model->qry_s_dictionary_details ($search_keyword,$config['per_page'],$offset);
				
				//$config				  = array_merge($config,$this->config->item('pagination_standard'));
                                
				$this->pagination->initialize($config);
				$this->gen_contents['paginate']     =   $this->pagination->create_links(true);
				
				
				
				$this->_admin_template('dictionary_list',$this->gen_contents);
			}	
		}
		
		/**
		 * function for dictionary uploading
		 * @param no parameters
		 */
		function upload() {
			if(!$this->authentication->logged_in("admin"))
					redirect("admin/login");
			else{
				$this->gen_contents["title"]= 'Dictionary Upload';
				$this->gen_contents["page_title"]= 'Upload Dictionary';
				if(!empty($_FILES)) {
					if (($_FILES['userfile']['error']) ==  0) {				 	
						if($this->do_upload()){						
							$xls_path			=	$this->gen_contents["file_path"];						
	
							if($this->dictionary_model->act_save_dictionary_details ($xls_path)){
							
								//loading the plugin for reading the xls file 
								$this->load->plugin('exel_reader');
								if($msg=read_dictionary_excel_validate($xls_path)){//validation for xls file
									$this->session->set_flashdata('msg', $msg);
								}
								else{
									//function for read the content from xls and save in db
									read_excel_dictionary($xls_path);
									//@unlink($old_xls_path);
									$this->session->set_flashdata('success', 'Uploaded successfully');
									redirect('dictionary/upload/');
								}
							}else 
								$this->session->set_flashdata('msg', 'Upload failed');
						}else
							$this->session->set_flashdata('msg', $this->gen_contents["error_xls"]['error']);
	
					 } else {
					 	$this->session->set_flashdata('msg', 'Must upload ');
					 }
				} 			
				$this->_admin_template('upload',$this->gen_contents);
			}
		}
		
		/**
		 * function for file upload
		 *
		 */
		function do_upload(){
			
			$config['upload_path'] = $this->config->item('dictionary_upload_file');
			$config['allowed_types'] = 'xls';
			$config['max_size']	= '2048';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';
			
			
			$img_ext 				= $this->get_extension ('userfile'); 
			
			$imgname				= time().'.'.$img_ext;
			
			
			$this->gen_contents["file_path"] = $this->config->item('dictionary_upload_file').'/'.$imgname;
			$config['file_name']  = $imgname;
			
			$this->load->library('upload', $config);
			/*var_dump($_FILES['userfile']);
		var_dump(move_uploaded_file($_FILES['userfile']['tmp_name'],$this->gen_contents["file_path"]));die();*/
			if ( ! $this->upload->do_upload()){ 
				
				$this->gen_contents["error_xls"] = array('error' => $this->upload->display_errors());
				return FALSE;
			}	
			else{
				
				//$this->gen_contents["err"] = array('upload_data' => $this->upload->data());
				//print_r($this->gen_contents["err"]);die();
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
		
		/**
		 * Function for deleting a dictionary detail
		 * @param no param
		 * @return no return value
		 */
		
		function delete () {
			if(!$this->authentication->logged_in("admin"))
					redirect("admin/login");
			else{
				if(!empty ($_POST)) {
					if(isset ($_POST['hdn_dict_id']) && '' != $_POST['hdn_dict_id']) {
						$offset = $_POST['hdn_offset_value'];
						$delete = $this->dictionary_model->qry_d_delete_dictionary_details ($_POST['hdn_dict_id']);
						if($delete) {
							$this->session->set_flashdata('success','Successfully deleted');
						} else {
							$this->session->set_flashdata('msg','Error occcured while deleting dictionary detail. Try again');
						}
						redirect ('dictionary/dictionary_list/'.$offset);
					} else {
						redirect ('dictionary');
					}
					
				} else {
					redirect ('dictionary');
				}
			}
		}
		
		/**
		 * Function for truncate a dictionary detail
		 * @param no param
		 * @return no return value
		 */
		
		function empty_dictionary () {
			if(!$this->authentication->logged_in("admin"))
					redirect("admin/login");
			else{
				if(!empty ($_POST)) {
					if(isset ($_POST['hdn_dict_id']) && 0 == $_POST['hdn_dict_id'] ) {
						$delete = $this->dictionary_model->qry_e_empty_dictionary_details ();
						if($delete) {
							$this->session->set_flashdata('success','Successfully emptied the dictionary');
						} else {
							$this->session->set_flashdata('msg','Error occcured while emptying the dictionary detail. Try again');
						}
						redirect ('dictionary/dictionary_list');
					} else {
						redirect ('dictionary');
					}
					
				} else {
					redirect ('dictionary');
				}
			}
		}
		
		/**
		 * Function for truncate a dictionary detail
		 * @param no param
		 * @return no return value
		 */
		
		function edit () {
			unset($_POST['ajax']);
			if(!$this->authentication->logged_in("admin"))
					redirect("admin/login");
			else{
				if($this->uri->segment(3)) {
					$this->gen_contents['dict_id'] = $this->uri->segment(3);
				} else {
					redirect ('dictionary');
				}
				$this->gen_contents["title"] = 'Dictionary Edit';
				$this->gen_contents["page_title"] = 'Edit Dictionary';
				if($this->uri->segment(4) && ctype_digit($this->uri->segment(4))) {
					$this->gen_contents['offset_val'] = $this->uri->segment(4);
				} else {
					$this->gen_contents['offset_val'] = 0;
				}
				$this->gen_contents["dictionary_detail"] = $this->dictionary_model->qry_s_get_single_dictionary_detail($this->gen_contents['dict_id']);
				if(!empty ($_POST)) {
					if(isset ($_POST['hdn_offset_val']) && '' != ($_POST['hdn_offset_val'])) {
						$this->gen_contents['offset_val'] = $_POST['hdn_offset_val'];
					}
					$this->load->library('form_validation');	
					$this->form_validation->set_rules('dctKeyword', 'DICTIONARY KEYWORD', 'required|max_length[150]');
					$this->form_validation->set_rules('dctDefinition', 'KEYWORD DEFINITION', 'required');
					if ($this->form_validation->run() == FALSE) {// form validation
						$this->gen_contents['msg']=validation_errors();
					} else {
						$this->_init_dictionary_details();
						//checks for duplicate entry of words
						if($this->dictionary_model->qry_s_check_keyword_exist ($this->dctKeyword,$this->gen_contents['dict_id'])) {
							$update_details['dct_keyword']		=	$this->dctKeyword;
							$update_details['dct_definition']	=	$this->definition;
							$update_details['dct_updated_date']	= convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'));
							if($this->dictionary_model->qry_u_dictionary_detail ($update_details,$this->gen_contents['dict_id'])) {
								$this->session->set_flashdata ('success','Updated successfully');							
							} else {
								$this->session->set_flashdata ('msg','Updation failed');				
							}
							redirect('dictionary/edit/'.$this->gen_contents['dict_id'].'/'.$this->gen_contents['offset_val']);
						} else {
							$this->gen_contents['msg'] = 'Keyword already exist';
						}						
					}
					
				}
				$this->_admin_template('edit',$this->gen_contents);
			}
		}
		
		/**
		 * Function for truncate a dictionary detail
		 * @param no param
		 * @return no return value
		 */
		
		function add () {
			unset($_POST['ajax']);
			if(!$this->authentication->logged_in("admin"))
					redirect("admin/login");
			else{
				
				$this->gen_contents["title"] = 'Add Dictionary Keyword';
				$this->gen_contents["page_title"] = 'Add Dictionary Keyword';
				if(!empty ($_POST)) {
					$this->load->library('form_validation');	
					$this->form_validation->set_rules('dctKeyword', 'DICTIONARY KEYWORD', 'required|max_length[150]');
					$this->form_validation->set_rules('dctDefinition', 'KEYWORD DEFINITION', 'required');
					if ($this->form_validation->run() == FALSE) {// form validation
						$this->gen_contents['msg']=validation_errors();
					} else {
						$this->_init_dictionary_details();
						//checks for duplicate entry of words
						if($this->dictionary_model->qry_s_check_keyword_exist ($this->dctKeyword)) {
							$add_details['dct_keyword']		=	$this->dctKeyword;
							$add_details['dct_definition']	=	$this->definition;
							$add_details['dct_created_date']	= convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'));
							$add_details['dct_updated_date']	= convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'));
							if($this->dictionary_model->qry_i_dictionary_detail ($add_details)) {
								$this->session->set_flashdata ('success','Added successfully');							
							} else {
								$this->session->set_flashdata ('msg','Keyword addition failed');				
							}
							redirect('dictionary/add');
						} else {
							$this->gen_contents['msg'] = 'Keyword already exist';
						}						
					}					
				}
				$this->_admin_template('add',$this->gen_contents);
			}
		}
		
		/**
		 * function for initialize dictionary details
		 *
		 */
		function _init_dictionary_details () {
			$this->dctKeyword 		= $this->common_model->safe_html($this->input->post("dctKeyword"));
			$this->definition 	= $this->common_model->safe_html($this->input->post("dctDefinition"));					
		}
		/**
		 * function for changing the status of exam mode
		 *
		 */
		function change_status () {
			if(!$this->authentication->logged_in("admin"))
				redirect("admin/login");
			else{
				if((($this->uri->segment(3) == 1) || ($this->uri->segment(3) == 0))) {
					$status = $this->uri->segment(3);
					$this->load->model('quiz_model');
					if($status == 0) {
						$updated_array['s_status'] = 1;
						$success_msg = 'Successfully enabled quiz status';
						$error_msg = 'Falied to enabling the quiz status';
					} else if ($status == 1) {
						$updated_array['s_status'] = 0;
						$success_msg = 'Successfully disabled quiz status';
						$error_msg = 'Falied to disabling the quiz status';
					}
					if($this->quiz_model->changeStatus($updated_array,'upload_status')) {
						$this->session->set_flashdata('success',$success_msg);
						redirect('dictionary/dictionary_list');
					} else {
						$this->session->set_flashdata('msg',$error_msg);
						redirect('dictionary/dictionary_list');
					}
				} else {
					redirect("dictionary/dictionary_list");
				}
			}
		}
		
		/**
       * function to validate if the status could be enabled.
       */
	    function validate_enable(){
	      	
	    	$this->load->model('questions_model');
			$arr_total	= $this->questions_model->weightageChecking();
			$counter 	= 0;
			
			foreach($arr_total as $key){
				
				if($key->sales > $key->total_sales or $key->broker > $key->total_broker){
					$counter++;
				}
			}
			
			if($counter){
			
				$this->gen_contents['return_value'] = 'The total no of questions doesn\'t match the weightage';
			}else{
				
				$video_counter = 0;
				
				//checks if all the video file exist in the respective folders
				$arr_video	= $this->questions_model->getAllVideoNames();
				foreach($arr_video as $video){
					$file_name = $this->config->item('upload_file').'/videos/'.$video->license_type.'/'.$video->folder_name.'/'.$video->video_name;
					if ( !file_exists($file_name)){
						$video_counter++;
					}
				}
				if($video_counter){
					$this->gen_contents['return_value'] = 'Please upload all the video files.';
				}
				else{
					$this->gen_contents['return_value'] = '';
				}
			}
			
			$this->load->view('dsp_show_ajax',$this->gen_contents);
		}
		
	}
?>