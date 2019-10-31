<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
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


class Admin_trial_account extends Controller {
	
	/**
	 * General contents
	 *
	 * @var Array
	 */
	var $gen_contents = array ();
	
	/**
	 * Admin constructor
	 * 
	 */
	function Admin_trial_account() {
		
		parent::Controller ();
		$this->load->helper ( array ('form', 'url', 'file' ) );
		$this->load->library ( 'session' );
		$this->load->library ( 'authentication' );
		$this->load->library('form_validation');
		
		$this->load->model (array('common_model', 'admin_trial_account_model' ));
                
		
		$this->gen_contents ["js"] = array ( 'admin_trial_account.js', 'prototype.js' );
		$this->gen_contents ['css'] = array ('admin_style.css' );
		$this->gen_contents ['title'] = 'Guest Account';
		if(!$this->authentication->logged_in("admin")) {
			redirect(c('admin_login_url'));
		}else if($this->authentication->logged_in ("admin") === "sub") {
                    redirect("admin/noaccess");
                    exit;
                }
	
	}
	
	/**
	 * default page
	 *
	 */
	function index() {
            if ($this->authentication->logged_in ( "admin" )){
                redirect ( "Admin_trial_account/settings" );
            }
            redirect(c('admin_login_url'));
	}
	
	/**
	 * Trial acount settings
	 */
	function settings() {
            $this->gen_contents ['title'] = 'Guest Account Settings';
            if(!$this->authentication->logged_in("admin")) {
                redirect(c('admin_login_url'));
            } else {
                if($this->input->post('validity')){
                    $this->load->library( 'form_validation' );
                    $this->form_validation->set_rules ( 'validity', 'Guest Account Validity', 'trim|required' );
                    $this->form_validation->set_rules ( 'course',   'Course',   'trim|required' );
                    $this->form_validation->set_rules ( 'edition',  'Edition',  'trim|required' );
                    $this->form_validation->set_rules ( 'chapter',  'Chapter',  'trim|required' );
                    if($this->form_validation->run() == TRUE){
                        $data   =  array(
                                        'validity_days' => $this->input->post('validity'), 
                                        'quiz_list_id'  => $this->input->post('chapter'),
                                        'updated_at'    => convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'))
                                    );
                        if($this->admin_trial_account_model->updateSettings($data)){
                            $this->session->set_flashdata ( 'success', 'Settings updated successfully' );
                        }else{
                            $this->session->set_flashdata ( 'error', 'Failed to update Settings' );
                        }
                        redirect('admin_trial_account/settings');
                    }
                    
                }
                $this->load->model ('admin_quiz_model');
                $settings                           = $this->admin_trial_account_model->getSettings();
                $this->gen_contents['settings']     = $settings;
                $this->gen_contents['quiz_details'] = $this->admin_trial_account_model->getQuizDetails($settings->quiz_list_id);
                $this->gen_contents['course_id']    = $this->gen_contents['quiz_details']->course_id;
                $this->gen_contents['edition_id']   = $this->gen_contents['quiz_details']->edition;
                $this->gen_contents['chapter_id']   = $this->gen_contents['quiz_details']->chapter_id;
                $this->gen_contents['video']        = $this->gen_contents['quiz_details']->video;

                $this->gen_contents["courses"]      = $this->admin_quiz_model->get_course_lst();
                $this->gen_contents['editions']     = get_editions($this->gen_contents["course_id"]);
                $this->gen_contents['chapters']     = $this->admin_quiz_model->get_chapters_by_course($this->gen_contents["course_id"], $this->gen_contents['edition_id']);



                $this->load->view ( "admin_header", $this->gen_contents );
                $this->load->view ( 'admin/trial_account/settings', $this->gen_contents );
                $this->load->view ( "admin_footer" );
                
            }
            
            
	}
	
        function load_video(){
            
            $chapter_id     = $this->uri->rsegment(3 );
            $quiz_details   = $this->admin_trial_account_model->getQuizDetails($chapter_id);
            $video          = $quiz_details->video;
            //$result = $this->load->view('admin/trial_account/_video', $this->gen_contents, TRUE);
            $result = array('video' =>trim($video));
            $this->load->view('dsp_show_ajax', array('return_value' => json_encode($result)));
        }
	/**
	 * display page to add examination questions
	 * 
	 */
	function upload() 
	{
		if (! $this->authentication->logged_in("admin")){
			redirect(c('admin_login_url'));
		} else {
			$this->gen_contents['page_title'] = 'Upload ';
			$this->load->model('admin_quiz_model');
			
			$this->gen_contents["course_id"] = $this->uri->segment(3 );
			$this->gen_contents['editions'] = get_editions($this->gen_contents["course_id"] );
			//$this->gen_contents["course"]			= $this->common_model->licensecourselist_b('B');	
			$this->gen_contents ["course"] = $this->admin_quiz_model->get_course_lst ();
			
			$this->gen_contents ['msg'] = $this->uri->segment ( 4 );
			
			$this->load->view ( "admin_header", $this->gen_contents );
			$this->load->view ( 'admin/upload_quiz', $this->gen_contents );
			$this->load->view ( "admin_footer" );
		}
	}
	
	/**
	 * get the values from the POST 
	 *
	 */
	function _init_exam_details() {
		
		$this->license = $this->input->post ( "license" );
		if ($this->license == 'broker')
			$this->course = $this->input->post ( "broker_type" );
		elseif ($this->license == 'sales')
			$this->course = $this->input->post ( "sales_type" );
	}
	/**
	 * function for listing exam details
	 *
	 */
	function list_quiz() {
		if (! $this->authentication->logged_in ( "admin" ))
			redirect(c('admin_login_url'));
		else {
			$this->gen_contents ["course_id"] = $this->uri->segment ( 3 );
			$this->load->model ( 'admin_quiz_model' );
			
			$this->gen_contents ['page_title'] = 'List Quiz';
			//$this->gen_contents["msg"] 			= 	$this->uri->segment(3);
			

			$this->gen_contents ["course"] = $this->admin_quiz_model->get_course_lst();
			
			if ($this->gen_contents ["course_id"])
				$course_id = $this->gen_contents ["course_id"];
			else {
				$course_id = $this->gen_contents ["course"] [0]->id;
				$this->gen_contents ["course_id"] = $course_id;
			}
			$this->gen_contents ["quiz"] = $this->admin_quiz_model->get_course( $course_id );
			
			$this->load->view ( "admin_header", $this->gen_contents );
			$this->load->view ( 'admin/list_quiz_details', $this->gen_contents );
			$this->load->view ( "admin_footer" );
		}
	
	}
	/**
	 * function for file upload
	 *
	 */
	function do_upload() {
		
		$config ['upload_path'] = $this->config->item ( 'upload_file' );
		$config ['allowed_types'] = 'xls';
		$config ['max_size'] = '2048';
		$config ['max_width'] = '1024';
		$config ['max_height'] = '768';
		
		$img_ext = $this->get_extension ( 'userfile' );
		
		$imgname = time () . '.' . $img_ext;
		
		$this->gen_contents ["file_path"] = $this->config->item ( 'upload_file' ) . '/' . $imgname;
		
		$config ['file_name'] = $imgname;
		
		$this->load->library ( 'upload', $config );
		
		if (! $this->upload->do_upload ()) {
			
			$this->gen_contents ["error_xls"] = array ('error' => $this->upload->display_errors () );
			return FALSE;
		} else {
			
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
		
		$name_array = explode ( ".", $_FILES [$upload_text_name] ['name'] );
		$ext = $name_array [count ( $name_array ) - 1];
		return strtolower ( $ext );
	}
	
	/**
	 * function for editing the exam course 
	 */
	function edit() 
	{ 
		if (! $this->authentication->logged_in ( "admin" )){
			redirect(c('admin_login_url'));
		} else {
			
			$this->load->helper('remote_file_exists');
			$edition_id = 0;
			$course_id = $this->uri->segment(3);
			$list_id = $this->uri->segment(4);
			$edition_id	= 	$this->uri->segment(5);
			$ques_id = $this->uri->segment(6);
			//$this->gen_contents['msg']			= 	$this->uri->segment(5);

			$this->gen_contents['course_id'] = $course_id;
			$this->gen_contents['edition_id'] =	$edition_id;
			$this->gen_contents['list_id'] = $list_id;
			$this->gen_contents['editions'] = get_editions($course_id);
			
			$course_name = $this->common_model->courseList($course_id);
			
			$this->gen_contents['page_title'] = 'Edit Chapters - ' . ucfirst ( $course_name [0]->course_name );
			//$this->gen_contents['page_title']		=	'Edit Quiz';

			$this->load->model('admin_quiz_model');
			
			if(! $this->gen_contents["questions"] = $this->admin_quiz_model->get_questions( $list_id,$edition_id )){
				//redirect( 'admin_quiz/list_quiz' );
			} else {
				if(count($this->gen_contents ["questions"]) > 0){
					
					if (empty($ques_id)){
						if (! $this->input->post( "hidquestid" ))
							$ques_id = $this->gen_contents["questions"][0]->id;
						else
							$ques_id = $this->input->post ( "hidquestid" );
					}
					
					//if($_POST){
					if($_SERVER['REQUEST_METHOD'] === 'POST') {
						$this->load->library( 'form_validation' );
						$this->form_validation->set_rules ( 'questions', 'Question', 'required' );
						
						// If video present add validation
						if($this->input->post('video') != '') {
							$this->form_validation->set_rules('video', 'Video', 'callback_format_check|callback_remote_file_check');
						}
						
						for($i = 1; $i <= 4; $i ++){
							$this->form_validation->set_rules ( 'answers' . $i, 'Option ' . $i, 'required|max_length[250]' );
						}
						
						if ($this->form_validation->run () == FALSE){ // form validation
							$this->gen_contents ['display'] = 'display';
						} else {
							$ques_id = $this->input->post( "hidquestid" );
							
							$this->_init_question_details ();
							
							if($this->admin_quiz_model->update_questions ( $ques_id, $this->questions, $this->video )){
								for($i = 1; $i <= 4; $i ++) {
									$this->admin_quiz_model->update_answers ( $ques_id, $this->ansid [$i], $this->answers [$i], $this->answer_option [$i] );
								}
								$this->session->set_flashdata ( 'success', 'Updated successfully' );
								redirect ( 'admin_quiz/edit/' . $course_id . '/' . $list_id . '/' . $edition_id. '/' . $ques_id );
							} else {
								$this->session->set_flashdata ( 'msg', 'Updation failed' );
							}
							
							redirect ( 'admin_quiz/edit/' . $course_id . '/' . $list_id . '/' . $edition_id. '/' . $ques_id );
						}
					}
					
					$this->gen_contents['ques_id'] = $ques_id;
					
					$this->gen_contents["ques_ans"] = $this->admin_quiz_model->get_one_quest_ans( $ques_id, $list_id );
				}
				
				// get cuttent chapter details
				$quizList = $this->admin_quiz_model->getQuizList($list_id);
		
				// redirect to error page if no question list.
				if(empty($quizList)){
					show_error("Something went wrong!");
				}
				
				// Passing question list view
				$this->gen_contents['quizList'] = $quizList[0];
				
				// Passing video location to view
				$this->gen_contents['quiz_video_location'] = $this->config->item('quiz_video_location');
			}
			$this->load->view ( "admin_header", $this->gen_contents );
			$this->load->view ( 'admin/edit_quiz_details', $this->gen_contents );
			$this->load->view ( "admin_footer" );
		}
	}
	
	
	/**
	 * get the values from the POST and Input it into safe_html
	 *
	 */
	function _init_question_details() {
		
		$this->questions = $this->input->post ( "questions" );
		$this->video = $this->input->post('video');
		for($i = 1; $i <= 4; $i ++) {
			$this->answers [$i] = $this->input->post ( "answers" . $i );
			
			$this->ansid [$i] = $this->input->post ( "ansid" . $i );
			
			if ($this->input->post ( "answer_option" ) == $this->ansid [$i])
				$this->answer_option [$i] = 'Y';
			else
				$this->answer_option [$i] = 'N';
		}
	
	}
	/**
	 * get the values from the POST and Input it into safe_html
	 *
	 */
	function delete() {
		
		$course_id = $this->uri->segment ( 3 );
		$list_id = $this->uri->segment ( 4 );
		$ques_id = $this->uri->segment ( 5 );
		$ques_no = $this->uri->segment ( 6 );
		$edition_id = $this->uri->segment ( 7 );
		$this->load->model ( 'admin_quiz_model' );
		
		if ($this->admin_quiz_model->delete_question ( $ques_id )) {
			$this->session->set_flashdata ( 'success', 'Deleted successfully' );
			if ($ques_no == 1) {
				
				$result = $this->admin_quiz_model->getQuizList ( $list_id );
				
				@unlink ( $result [0]->xls_path );
				$this->admin_quiz_model->delete_quizlist ( $list_id );
				redirect ( 'admin_quiz/list_quiz/' . $course_id );
			
			}
		
		} 

		else
			$this->session->set_flashdata ( 'msg', 'Deletion failed' );
		
		redirect ( 'admin_quiz/edit/' . $course_id . '/' . $list_id .'/' . $edition_id );
	
	}
	/**
	 * get the values from the POST and Input it into safe_html
	 *
	 */
	function delete_question() {
		
		$list_id = $this->uri->segment ( 3 );
		$course_id = $this->uri->segment ( 4 );
		$this->load->model ( 'admin_quiz_model' );
		
		$result = $this->admin_quiz_model->getQuizList ( $list_id );
		
		$result [0]->xls_path;
		
		if ($this->admin_quiz_model->delete_course_question ( $list_id )) {
			
			@unlink ( $result [0]->xls_path );
			$this->session->set_flashdata ( 'success', 'Deletion Successful' );
		
		//redirect('admin_quiz/list_quiz/1');
		} else {
			$this->session->set_flashdata ( 'msg', 'Deletion failed' );
		
		//redirect('admin_quiz/list_quiz/2');
		}
		redirect ( 'admin_quiz/list_quiz/' . $course_id );
	
	}
	
	/**
	 * get the values from the POST and Input it into safe_html
	 *
	 */
	function add_question() {
		
		$this->gen_contents ['course_id'] = $this->uri->segment ( 3 );
		$this->gen_contents ['list_id'] = $this->uri->segment ( 4 );
		$this->gen_contents ['edition_id'] = $this->uri->segment ( 5 );
		$this->load->model ( 'admin_quiz_model' );
		$this->load->helper('remote_file_exists');
		
		//if ($_POST) {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
			$this->load->library ( 'form_validation' );
			
			$this->form_validation->set_rules ( 'questions', 'Question', 'required' );

			// If video present add validation
			if($this->input->post('video') != '') {
				$this->form_validation->set_rules('video', 'Video', 'callback_format_check|callback_remote_file_check');
			}
			
			for($i = 1; $i <= 4; $i ++) {
				$this->form_validation->set_rules ( 'answers' . $i, 'Option ' . $i, 'required|max_length[250]' );
			}
			
			if ($this->form_validation->run () == FALSE) { // form validation
				$this->gen_contents ['msg'] = '';
			} else {
				$this->_init_add_question_details ();
				
				$ques_id = $this->admin_quiz_model->add_questions ( $this->gen_contents ['list_id'], $this->questions, $this->video  );
				//die();
				for($i = 1; $i <= 4; $i ++) {
					$this->admin_quiz_model->add_answers ( $ques_id, $this->answers [$i], $this->answer_option [$i] );
				}
				$this->session->set_flashdata ( 'success', 'Question and Answers added successfully' );
				redirect ( 'admin_quiz/edit/' . $this->gen_contents ['course_id'] . "/" . $this->gen_contents ['list_id'] . "/" . $this->gen_contents ['edition_id']."/".$ques_id );
			}
		
		}
	
		$course_name = $this->common_model->courseList ( $this->gen_contents ['course_id'] );
		$this->gen_contents ['page_title'] = 'Add Question - ' . ucfirst ( $course_name [0]->course_name );
		
		$this->load->view ( "admin_header", $this->gen_contents );
		$this->load->view ( 'admin/add_quiz_question', $this->gen_contents );
		$this->load->view ( "admin_footer" );
	
	}
	/**
	 * get the values from the POST and Input it into safe_html
	 *
	 */
	function _init_add_question_details() {
		
		$this->questions = $this->input->post ( "questions" );
		$this->video = $this->input->post('video');
		for($i = 1; $i <= 4; $i ++) {
			$this->answers [$i] = $this->input->post ( "answers" . $i );
			
			if ($this->input->post ( "answer_option" ) == $i)
				$this->answer_option [$i] = 'Y';
			else
				$this->answer_option [$i] = 'N';
		
		}
	
	}
	/**
	 * To change the exam status of the course
	 *
	 */
	function change_status() {
		
		$this->gen_contents ['list_id'] = $this->uri->segment ( 3 );
		$status = $this->uri->segment ( 4 );
		$course_id = $this->uri->segment ( 5 );
		
		if ($status == 'E')
			$status = 'D';
		else
			$status = 'E';
		
		$this->load->model ( 'admin_quiz_model' );
		if (! $this->admin_quiz_model->checkUserTakingQuiz ( $this->gen_contents ['list_id'] )) {
			if ($this->admin_quiz_model->changeExamStatus ( $this->gen_contents ['list_id'], $status ))
				$this->session->set_flashdata ( 'success', 'Status changed successfully' );
			else
				$this->session->set_flashdata ( 'msg', 'Operation failed' );
		} else {
			$this->session->set_flashdata ( 'msg', 'Cannot perform your request since user(s) is attending quiz' );
		}
		redirect ( 'admin_quiz/list_quiz/' . $course_id );
	
	}
	
	/**
	 * function to set or update Chapter/Quiz topic
	 * @access public
	 * @param void
	 * @return void
	 */
	function topic()
	{
		// Set page tile
		$this->gen_contents['page_title'] = "Change Topic Name";
		
		//Get list-id
		$listId = $this->uri->segment(4);
		$this->gen_contents['edition_id'] = $this->uri->segment(5);
		
		// Get current topic, chapter name
		$this->load->model('admin_quiz_model');
		$quizList = $this->admin_quiz_model->getQuizList($listId);
		
		// redirect to error page if no question list.
		if(empty($quizList)){
			show_error("Something went wrong!");
		}
		
		// Passing question list view
		$this->gen_contents['quizList'] = $quizList[0];
		
		//capture form submit and update ito table
		if($_SERVER['REQUEST_METHOD'] === 'POST') {
			//Set form validations
			$this->form_validation->set_rules('topic', 'Topic', 'trim|required|xss_clean');
			
			// Validate form
			if($this->form_validation->run() !== FALSE){
				
				// Update chapter topic	
				$this->admin_quiz_model->updateTopic($this->input->post('list_id'), $this->input->post('topic'));
				
				// set success message
				$this->session->set_userdata('successMsg', 'Topic Name updated successfully');
				
				// Get new topic
				$quizList = $this->admin_quiz_model->getQuizList($listId);
				
				// Assign new topic to view
				$this->gen_contents['quizList'] = $quizList[0];
			}
		}
		
		// Render change topic form
		$this->load->view ( "admin_header", $this->gen_contents );
		$this->load->view ( 'admin/quiz/change_topic', $this->gen_contents );
		$this->load->view ( "admin_footer" );
	}
	
	/**
	 * Custom form validation
	 * validation function for video field
	 * 
	 */
	function remote_file_check($url)
	{
		
		$check = remote_file_exists($url);
		
		if($check === FALSE){
			$this->form_validation->set_message('remote_file_check', 'This video does not exist in FTP folder. Please check the File Name and try again.');
			return FALSE;
		} 
		
		return TRUE;
	}
	
	/**
	 * validate file format
	 * 
	 */
	function format_check($filename)
	{
		if(check_allowed_extensions($filename) == FALSE) {
			$this->form_validation->set_message('format_check', 'Please enter a Valid Video file name with extension.');
			return FALSE;
		}
		
		return TRUE;
	}
}