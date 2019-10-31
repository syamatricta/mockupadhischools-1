<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Admin Examination Controller
 *
 * @package		CodeIgniter
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Manu
 * @link		http://ahischools.com/admin/
 */

// ------------------------------------------------------------------------

	class Admin_exam extends Controller {
		
		/**
		 * General contents
		 *
		 * @var Array
		 */
		var $gen_contents	=	array();
		
		/**
		 * Admin constructor
		 * 
		 */
		function Admin_exam() {
			
			parent::Controller();
			$this->load->helper(array('form', 'url', 'file'));
			$this->load->library('session');
			$this->load->library('authentication');
			$this->load->model('common_model');

			$this->gen_contents["js"]		 =	array('admin_exam.js','prototype.js');	
			$this->gen_contents['css']		 = 	array('admin_style.css');
			$this->gen_contents['title']	 =	'Exam Management';
 			//$this->output->enable_profiler(TRUE);
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
			if($this->authentication->logged_in("admin"))
				redirect("admin_exam/list_exam");			
			redirect("admin/login");
		}
		
		/**
		 * function to add examination questions and answers from xls
		 */
		function upload_file(){
			
			if(!$this->authentication->logged_in("admin"))
					redirect("admin/login");
			else{
				$this->gen_contents['page_title']	 =	'Upload ';
				
				$this->load->model('admin_exam_model');
				$course_id 			= 	$this->input->post('course');
				$edition_id			= 	$this->input->post('edition');
				
			 	if (($_FILES['userfile']['error']) ==  0) {
				 	
					if($this->do_upload()){
						
						$exam_replace_id	=	$this->input->post('exams_replace');
						$xls_path			=	$this->gen_contents["file_path"];
							//loading the plugin for readin gthe xxls file 
						$this->load->plugin('exel_reader');
						
						if($msg=read_excel_validate($xls_path,'','',$course_id)){//validation for xls file
							
							//echo $msg;die();
							$this->session->set_flashdata('msg', $msg);
							redirect('admin_exam/list_exam/');
						}
						else{
							if($exam_replace_id){//echo $exam_replace_id;die();
								$result				=	$this->admin_exam_model->getExamList($exam_replace_id,$edition_id,$xls_path);
								$old_xls_path			=	$result[0]->xls_path;

								if($this->admin_exam_model->delete_course_question($exam_replace_id,$edition_id,$old_xls_path))
									@unlink($old_xls_path);
							}
							if($this->admin_exam_model->saveExamDetails ($xls_path,$course_id,$edition_id)){
								//function for read the content from xls and save in db
								read_excel($xls_path,$course_id,$edition_id);
								//@unlink($old_xls_path);
								$this->session->set_flashdata('success', 'Uploaded successfully');
								redirect('admin_exam/list_exam');
							}else {
								$this->session->set_flashdata('msg', 'error occurred while saving data');
								redirect('admin_exam/list_exam');
							}
						}							
					}else
						$this->session->set_flashdata('msg', $this->gen_contents["error_xls"]);
						

				 }else
				 	$this->session->set_flashdata('msg', 'Error in upload');
			 	//redirect("admin_exam/upload");
				 	
			}
			$this->gen_contents["course"]		= $this->admin_exam_model->get_course();
			$this->gen_contents["course_id"]	= $course_id;
			
			
				
			$this->load->view("admin_header",$this->gen_contents);					
			$this->load->view('admin/upload_exam',$this->gen_contents);			
			$this->load->view("admin_footer");
		}
		
		/**
		 * display page to add examination questions
		 * 
		 */
		function upload(){
			if(!$this->authentication->logged_in("admin"))
					redirect("admin/login");
			else{
					$this->gen_contents['page_title']	 =	'Upload ';
					$this->load->model('admin_exam_model');
					
					$this->gen_contents["course_id"] 		= 	$this->uri->segment(3);
					$this->gen_contents['editions'] = get_editions($this->gen_contents["course_id"] );
					//$this->gen_contents["licensetype"] 	= 	$this->uri->segment(4);
					
					//$this->gen_contents["course"]			= $this->common_model->licensecourselist_b('B');	
					$this->gen_contents["course"]			= $this->admin_exam_model->get_course('E');
					
					$this->gen_contents['msg']=$this->uri->segment(4);
					
					$this->load->view("admin_header",$this->gen_contents);					
					$this->load->view('admin/upload_exam',$this->gen_contents);			
					$this->load->view("admin_footer");
				}
			}
				
		/**
		 * get the values from the POST 
		 *
		 */
		function _init_exam_details() {
			
			$this->license = $this->input->post("license");
			if($this->license=='broker')
				$this->course =$this->input->post("broker_type");
			elseif($this->license=='sales')
				$this->course =$this->input->post("sales_type");			
		}	
		/**
		 * function for listing exam details
		 *
		 */
		function list_exam(){ 
			if(!$this->authentication->logged_in("admin"))
				redirect("admin/login");
			else{
			
				$this->load->model('admin_exam_model');
				
				$this->gen_contents['page_title']	=	'List Exam';
				$this->gen_contents["msg"] 		= 	$this->uri->segment(3);
				$this->gen_contents["course"]		= $this->admin_exam_model->get_course();
	
				$this->load->view("admin_header",$this->gen_contents);					
				$this->load->view('admin/list_exam_details',$this->gen_contents);			
				$this->load->view("admin_footer");
			}
			
		}
		/**
		 * function for file upload
		 *
		 */
		function do_upload(){
			
			$config['upload_path'] = $this->config->item('upload_file');
			$config['allowed_types'] = 'xls';
			$config['max_size']	= '2048';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';
			
			
			$img_ext 				= $this->get_extension ('userfile'); 
			
			$imgname				= time().'.'.$img_ext;
			
			$this->gen_contents["file_path"] = $this->config->item('upload_file').'/'.$imgname;
			
			$config['file_name']  = $imgname;
			
			$this->load->library('upload', $config);
		
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
		 * function for editing the exam course 
		 */
		function edit()
		{
			if(!$this->authentication->logged_in("admin")) {
				redirect("admin/login");
			}
				
			else{
				$edition_id = 0;
				$course_id								= 	$this->uri->segment(3);
				$edition_id								= 	$this->uri->segment(4);
				$ques_id								= 	$this->uri->segment(5);
				$this->gen_contents['msg']				= 	$this->uri->segment(6);
				
				$this->gen_contents['editions'] = get_editions($course_id);	
				$this->gen_contents['course_id']		=	$course_id;
				$this->gen_contents['edition_id']		=	$edition_id;
				
				$course_name=$this->common_model->courseList($course_id);
				
				$this->gen_contents['page_title']		=	'Edit Question - '.ucfirst($course_name[0]->course_name);
				
			
				$this->load->model('admin_exam_model');
				$this->load->helper('text');
				$this->gen_contents['data_cnt'] = '';
				if(!$this->gen_contents["questions"]=$this->admin_exam_model->get_questions($course_id,$edition_id)){
					//redirect('admin_exam/list_exam/6');
				}
				else{

					if(count($this->gen_contents["questions"])>0){
						
						if(empty($ques_id)){
							
							if(!$this->input->post("hidquestid"))
								$ques_id=$this->gen_contents["questions"][0]->id;	
							else 
								$ques_id=$this->input->post("hidquestid");
						}
						//echo $ques_id;
						//if($_POST){
						if($_SERVER['REQUEST_METHOD'] == 'POST'){
							//var_dump(	mb_detect_encoding($this->input->post("questions")));
							//die();
							$this->load->library('form_validation');	
							$this->form_validation->set_rules('questions', 'Question', 'required');
							for($i=1;$i<=4;$i++){
								$this->form_validation->set_rules('answers'.$i, 'Option '.$i, 'required|max_length[250]');
							}
						
							if ($this->form_validation->run() == FALSE) {// form validation
								$this->gen_contents['display']='display';
							}else{
							
						
								$ques_id=$this->input->post("hidquestid");
								//echo $ques_id;
								$this->_init_question_details();
								
								if($this->admin_exam_model->update_questions($ques_id,$this->questions)){
								
									for($i=1;$i<=4;$i++){
									//var_dump(	mb_detect_encoding($this->answers[$i]));
									//echo $this->answers[$i];
								//	die();
										$this->admin_exam_model->update_answers($ques_id,$this->ansid[$i],$this->answers[$i],$this->answer_option[$i]);
									}
									//die();
									$this->session->set_flashdata('success', 'Updated successfully');
									
								}else 	
									$this->session->set_flashdata('msg', 'Updation failed');
								redirect('admin_exam/edit/'.$course_id.'/'.$edition_id.'/'.$ques_id);		
							}
							
						}
							
						$this->gen_contents['ques_id']			=	$ques_id;
						
						$this->gen_contents["ques_ans"]			= $this->admin_exam_model->get_one_quest_ans($ques_id,$course_id);
					}
					
				}
				$this->load->view("admin_header",$this->gen_contents);					
				$this->load->view('admin/edit_exam_details',$this->gen_contents);			
				$this->load->view("admin_footer");
			}
		}
		/**
		 * get the values from the POST and Input it into safe_html
		 *
		 */
		function _init_question_details() {
			
			$this->questions = $this->common_model->safe_html($this->input->post("questions"));
			for($i=1;$i<=4;$i++){
				$this->answers[$i]			=	$this->input->post("answers".$i);
	
				$this->ansid[$i] 			=	$this->input->post("ansid".$i);
				
				if($this->input->post("answer_option")==$this->ansid[$i])
					$this->answer_option[$i]='Y';
				else 
					$this->answer_option[$i]='N';
			}
			
		}
		/**
		 * get the values from the POST and Input it into safe_html
		 *
		 */
		function delete() {
			
			$course_id								= 	$this->uri->segment(3);
			$edition_id								= 	$this->uri->segment(4);
			$ques_id								= 	$this->uri->segment(5);
			
			$this->load->model('admin_exam_model');
			
			if($this->admin_exam_model->delete_question($ques_id))
				$this->session->set_flashdata('success', 'Deletion Successful');

			else 
				$this->session->set_flashdata('msg', 'Deletion failed');
				
			redirect('admin_exam/edit/'.$course_id.'/'.$edition_id);
			
		}
		/**
		 * get the values from the POST and Input it into safe_html
		 *
		 */
		function delete_question() {
			
			$course_id								= 	$this->uri->segment(3);
			
			$this->load->model('admin_exam_model');
			
			$result	=$this->admin_exam_model->getExamList($course_id);
			@$result[0]->xls_path;
	
			if($this->admin_exam_model->delete_course_question($course_id)){
				
				@unlink($result[0]->xls_path);
				$this->session->set_flashdata('success', 'Deletion Successful');
				
			}else
				$this->session->set_flashdata('msg', 'Deletion failed');
				
			redirect('admin_exam/list_exam');
		
			
		}
		/**
		 * get the values from the POST and Input it into safe_html
		 *
		 */
		function add_question() {
			unset($_POST['ajax']);
			$this->gen_contents['course_id']				= 	$this->uri->segment(3);
			$this->gen_contents['edition_id']				= 	$this->uri->segment(4);
			$this->gen_contents['editions'] = get_editions($this->gen_contents["course_id"] );
			$this->load->model('admin_exam_model');
			if($_POST){
				$this->gen_contents['edition_id'] = $this->input->post('edition');
				$this->load->library('form_validation');	
				$this->form_validation->set_rules('edition', 'Edition', 'required');
				$this->form_validation->set_rules('questions', 'Question', 'required');
				for($i=1;$i<=4;$i++){
					$this->form_validation->set_rules('answers'.$i, 'Option '.$i, 'required|max_length[250]');
				}
			
				if ($this->form_validation->run() == FALSE) {// form validation
					$this->gen_contents['msg']='';
				}else {
					$this->_init_add_question_details();
					$date_update_arr = $this->common_model->select('adhi_exam_list','id',array("course_id"=> $this->gen_contents['course_id'],"edition"=>$this->gen_contents['edition_id']));
					if(empty($date_update_arr)){
						$this->common_model->save('adhi_exam_list',array("course_id"=> $this->gen_contents['course_id'],"edition"=>$this->gen_contents['edition_id']));
					}
					$ques_id=$this->admin_exam_model->add_questions($this->gen_contents['course_id'],$this->questions,$this->gen_contents['edition_id']);
					//die();
					for($i=1;$i<=4;$i++){
						$this->admin_exam_model->add_answers($ques_id,$this->answers[$i],$this->answer_option[$i]);
					}
					$this->session->set_flashdata('success', 'Question and Answers added successfully');
					redirect('admin_exam/edit/'.$this->gen_contents['course_id']."/".$this->gen_contents['edition_id']."/".$ques_id);
				}
			}
			
			$course_name=$this->common_model->courseList($this->gen_contents['course_id']);
			//$this->gen_contents['page_title']		=	'Add Question - '.$course_name[0]->course_name;
			
			$this->gen_contents['page_title']				=	'Add Question- '.ucfirst($course_name[0]->course_name);
			$this->load->view("admin_header",$this->gen_contents);					
			$this->load->view('admin/add_exam_question',$this->gen_contents);			
			$this->load->view("admin_footer");	
					
		}
		/**
		 * get the values from the POST and Input it into safe_html
		 *
		 */
		function _init_add_question_details() {
			
			$this->questions = $this->input->post("questions");
			for($i=1;$i<=4;$i++){
				$this->answers[$i]			=	$this->input->post("answers".$i);
				

				if($this->input->post("answer_option")==$i)
					$this->answer_option[$i]='Y';
				else 
					$this->answer_option[$i]='N';
				
			}
			
		}
		/**
		 * To change the exam status of the course
		 *
		 */
		function change_status(){
			
			$this->gen_contents['course_id']				= 	$this->uri->segment(3);
			$status											= 	$this->uri->segment(4);
			
			if($status=='E')
				$status	='D';
			else 
				$status	='E';
			
			$this->load->model('admin_exam_model');
			
			if($this->admin_exam_model->changeExamStatus($this->gen_contents['course_id'],$status))
				$this->session->set_flashdata('success', 'Status changed successfully');
			else
				 $this->session->set_flashdata('msg', 'Operation failed');
				 
			redirect('admin_exam/list_exam/');
			
		}
}