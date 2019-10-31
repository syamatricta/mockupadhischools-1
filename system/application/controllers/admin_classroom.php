<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * Controlle class file
 *
 * Contains class for handling classroom videos
 *
 * @package 	Adhischools
 * @author		Rainconcert Technologies (P) LTD.
 * @copyright	Copyright (c) 2012, Rainconcert Technologies.
 * @license		http://adhischools.com/license.html
 * @link		http://adhischools.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * controller class for calssroom videos
 * admin_classroom class
 *
 * @package		CodeIgniter
 * @subpackage	Controllers
 * @category	admin
 * @author		Rainconcert
 * @link		http://adhischools.com
 * 
 */
class Admin_classroom extends Controller
{
	/**
	 * General contents
	 * @var array $gen_contents
	 */
	var $gen_contents = array();
	
	/**
	 * constructor
	 */
	function Admin_classroom()
	{
		// Call parrent constructor
		parent::Controller();
		
		$this->load->library('authentication');
		$this->load->helper(array('form', 'file', 'remote_file_exists', 'input'));

		if (!$this->authentication->logged_in ("admin")) {
			redirect("admin");
		}
		else if($this->authentication->logged_in ("admin") === "sub") 
                {
                    redirect("admin/noaccess");
                    exit;
                }
		$this->load->library(array('form_validation'));
		
		// Loading models
		$this->load->model('admin_quiz_model');
		$this->load->model('classroom_model');
		
		$this->gen_contents['css'] = array('admin_style.css','dhtmlgoodies_calendar.css');
		$this->gen_contents['js'] = array('admin_classroom.js');
		$this->gen_contents['title']	=	'Classroom';
		
		// Get all courses
		$this->gen_contents['courses'] = $this->admin_quiz_model->get_course_lst();
	}
	
	/**
	 * index action
	 * for now its redirecting to view
	 * @param void
	 * @return void
	 */
	function index()
	{
		$this->view();
	}
	
	/**
	 * function to load the template (header, body and footer)
	 *
	 * @access private
	 * @param string $page
	 * @param array $contents
	 * @return void
	 */
	private function _template($page, $contents)
	{
		// if no page defined throw an exception
		if(!isset($page) || '' == $page){
			show_error('Error no classroom: Template is missing');
		}
		
		$this->load->view("admin_header", $contents);							
		$this->load->view('admin/classroom/' . $page, $contents);
		$this->load->view("admin_footer");
	}
		
	/**
	 * View method
	 * List all the videos by course and chapter
	 * @param void
	 * @return void
	 */
	function view()
	{
		$this->gen_contents['page_title'] = 'Classroom - Videos';
		$this->gen_contents['course_id'] = 0;
		
		// Get course and chapter
		$course_id = ($this->input->post('course')) ? $this->input->post('course') : $this->uri->segment(3);
		$chapter_id = ($this->input->post('chapter')) ? $this->input->post('chapter') : $this->uri->segment(4);
		$edition = ($this->input->post('edition')) ? $this->input->post('edition') : $this->uri->segment(5);
		$this->gen_contents['editions'] = get_editions($course_id );
		//print_r($this->gen_contents['editions']);
		if(isset($chapter_id) && '' != $chapter_id) {
			$this->gen_contents['course_id'] = $course_id;
			$this->gen_contents['chapter_id'] = $chapter_id;
			$this->gen_contents['edition_id'] = $edition;
			
			// Get videos
			$this->gen_contents['videos'] = $this->classroom_model->get_by_chapter_id($chapter_id,'A',$edition);
			
			// Get chapters for course
			$this->gen_contents['chapters'] = $this->admin_quiz_model->get_chapters_by_course($course_id,$edition);
			
		}
				
		$this->_template('view', $this->gen_contents);
	}
	
	/**
	 * Add method
	 * Adding videos
	 * @access public
	 * @param viod
	 * @return void
	 */
	function add()
	{
		$this->gen_contents['page_title'] = 'Add Classroom Video';
				
		// Form validation rules
		$this->form_validation->set_rules('course', 'Course', 'required');
		$this->form_validation->set_rules('chapter', 'Chapter', 'required');
		$this->form_validation->set_rules('edition', 'Edition', 'required');
		$this->form_validation->set_rules('video', 'Video', 'required|callback_format_check|callback_remote_file_check');

		// Get chapter id and course id
		$this->gen_contents['course_id'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : '';
		$this->gen_contents['chapter_id'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : '';
		$this->gen_contents['edition_id'] = ($this->uri->segment(5)) ? $this->uri->segment(5) : '';
		
		// Course selected then load chapters corresponding to the course
		if($this->input->post('course')) {
			// Get chapters for course
			$this->gen_contents['chapters'] = $this->admin_quiz_model->get_chapters_by_course($this->input->post('course'));
			$this->gen_contents['editions'] = get_editions($this->input->post('course'));
		} else {
			$this->gen_contents['chapters'] = $this->admin_quiz_model->get_chapters_by_course($this->gen_contents['course_id'],$this->input->post('edition'));
			$this->gen_contents['editions'] = get_editions($this->gen_contents['course_id']);
		}

		// Post data
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			if($this->form_validation->run() == TRUE) {
				//TODO save details to table
				$this->classroom_model->insert_video(
					$this->input->post('course'), 
					$this->input->post('edition'), 
					$this->input->post('chapter'), 
					$this->input->post('video'),
					$this->input->post('description')
				);
				
				$this->session->set_flashdata( 'success', 'Updated successfully' );
				// if success, then redirect too view
				redirect('admin_classroom/view/' . $this->input->post('course') . '/' . $this->input->post('chapter').'/'.$this->input->post('edition') );
			}
		}
		// Render view
		$this->_template('add', $this->gen_contents);
		
	}
	
	/**
	 * Edit methos
	 * Edit videos
	 * @access public
	 * @param void
	 * @return void
	 */
	function edit()
	{
		$this->gen_contents['page_title'] = 'Edit Classroom Video';
		
		// Form validation rules
		$this->form_validation->set_rules('course', 'Course', 'required');
		$this->form_validation->set_rules('chapter', 'Chapter', 'required');
		$this->form_validation->set_rules('edition', 'Edition', 'required');
		$this->form_validation->set_rules('video', 'Video', 'required|callback_format_check|callback_remote_file_check');
		
		// Post data
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			if($this->form_validation->run() == TRUE) {
				//TODO save details to table
				$this->classroom_model->update_video(
					$this->input->post('course'), 
					$this->input->post('edition'), 
					$this->input->post('chapter'), 
					$this->input->post('video'),
					$this->input->post('description'),
					$this->input->post('video-id')
				);
				
				$this->session->set_flashdata( 'success', 'Updated successfully' );
				// if success, then redirect too view
				redirect('admin_classroom/view/' . $this->input->post('course') . '/' . $this->input->post('chapter') .'/'.$this->input->post('edition'));
			}
		}
		
		// Get video id
		$video_id = ($this->input->post('video-id')) ? $this->input->post('video-id') : $this->uri->segment(3);
		
		// Throw exception if video id not present
		if(!isset($video_id) && '' == $video_id){
			//show_error('unauthorised access!');
			redirect('admin_classroom/view');
		}
		
		// Get video details
		$this->gen_contents['video'] = $this->classroom_model->get_by_id($video_id);
		
		if(empty($this->gen_contents['video'])) {
			//show_error('unauthorised access!');
			redirect('admin_classroom/view');
		}
		
		// Course selected then load chapters corresponding to the course
		$this->gen_contents['course_id'] = ($this->input->post('course')) ? $this->input->post('course') : $this->gen_contents['video']->course_id;
		
		// Get chapters for course
		$this->gen_contents['chapters'] = $this->admin_quiz_model->get_chapters_by_course($this->gen_contents['course_id'],$this->input->post('edition'));
		$this->gen_contents['editions'] = get_editions($this->gen_contents['course_id']);		
		// passing chapter id to view
		$this->gen_contents['chapter_id'] = ($this->input->post('chapter')) ? $this->input->post('chapter') : $this->gen_contents['video']->quiz_id;
		$this->gen_contents['edition_id'] = ($this->input->post('edition')) ? $this->input->post('edition') : $this->gen_contents['video']->edition;
		
		// Render view
		$this->_template('edit', $this->gen_contents);
	}
	
	/**
	 * Delete a video
	 * @access public
	 * @param void
	 * @return void
	 */
	function delete_video()
	{
		// Get video_id & course_id
		$video_id = $this->uri->segment(3);
		$chapter_id = $this->uri->segment(4);
		$course_id = $this->uri->segment(5);
		
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
			// if have video_id & course_id then delete the record and redirect to view page
			if(!empty($video_id) && !empty($chapter_id) && !empty($course_id)) {
				
				if($this->classroom_model->delete_video($video_id, $chapter_id)){
					$this->session->set_flashdata( 'success', 'Video removed successfully!' );
				} else {
					$this->session->set_flashdata( 'error', 'Something went wrong while deleting video.' );
				}
				
				redirect('admin_classroom/view/' . $course_id . '/' . $chapter_id);
			} else {
				$this->session->set_flashdata('error', 'Something went wrong while deleting video.');
				redirect('admin_classroom/view/');
			}
		} else {
			redirect('admin_classroom/view/');
			//show_error('Unauthorised access.');
		}
	}
	
	/**
	 * Upload excel form
	 * @access public
	 * @param void
	 * @return void
	 */
	public function upload()
	{
		// Load excel upload helper
		$this->load->helper('excel_upload');
		
		// Page title
		$this->gen_contents['page_title'] = 'Upload Classroom Video';
		
		// Get chapter id and course id
		$this->gen_contents['course_id'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : '';
		$this->gen_contents['chapter_id'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : '';
		
		// Course selected then load chapters corresponding to the course
		if($this->input->post('course')) {
			// Get chapters for course
			$this->gen_contents['chapters'] = $this->admin_quiz_model->get_chapters_by_course($this->input->post('course'),$this->input->post('edition'));
			$this->gen_contents['editions'] = get_editions($this->input->post('course'));
		} else {
			$this->gen_contents['chapters'] = $this->admin_quiz_model->get_chapters_by_course($this->gen_contents['course_id'],$this->input->post('edition'));
			$this->gen_contents['editions'] = get_editions($this->gen_contents['course_id']);
		}
		
		// if request is post 
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			// add validation rules
			$this->form_validation->set_rules('course', 'Course', 'required');
			$this->form_validation->set_rules('chapter', 'Chapter', 'required');
			$this->form_validation->set_rules('edition', 'Edition', 'required');
			$this->form_validation->set_rules('userfile', 'Userfile', 'callback_excel_required');
			$validation_error = "";
			
			// Validate form
			if($this->form_validation->run() != FALSE){
				// Uploading excel
				if(do_excel_upload($_FILES['userfile']) == TRUE) {
					
					// validate uploaded excel
					//$validation_error = validate_classroom_video_excel($this->gen_contents['file_path']);
					$validation_error = process_classroom_video_excel(
											$this->gen_contents['file_path'], 
											$this->input->post('course'),
											$this->input->post('chapter'),
											$this->input->post('edition')
										);
					
					// if error then pass to view, else redirect to view
					if($validation_error !== TRUE){
						$this->gen_contents['validation_error'] = $validation_error;
					} else {
						$this->session->set_flashdata( 'success', 'Videos added successfully!' );
						redirect('admin_classroom/view/' . $this->input->post('course') . '/' . $this->input->post('chapter').'/'.$this->input->post('edition'));
					}
					
				} else {
					$this->gen_contents['validation_error'] = $this->gen_contents['error_xls']['error'];
				}
			}
		}
		
		// Render view
		$this->_template('upload', $this->gen_contents);
	}
		
	/**
	 * Ajax handle to load chapters
	 * Load chapters
	 * @access public
	 * @param void
	 * @return void
	 */
	function load_chapters()
	{
		$course_id = $this->uri->segment(3);
		$edition = $this->uri->segment(4);
		 
		// Get chapters for course
		$chapters = $this->admin_quiz_model->get_chapters_by_course($course_id,$edition);
		$json_array = array();
		
		if($chapters !== FALSE){
			foreach($chapters as $chapter){
				$json_array[] = array('id' => $chapter->id, 'name' => $chapter->quiz_name);
			}
		}
		
		echo json_encode($json_array);
		
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
	
	/**
	 * Custom form validation
	 * Validate excel file selected by user
	 * @param string $str
	 * @return Boolean.
	 */
	function excel_required($str)
	{
		if($_FILES['userfile']['error'] != 0) {
			$this->form_validation->set_message('excel_required', 'Missing excel file');
			return FALSE;
		}		
		
	 	// Extension check
		$extension = strtolower(substr(strrchr($_FILES['userfile']['name'], '.'), 1));
		if($extension != 'xls'){
			$this->form_validation->set_message('excel_required', 'Please upload a Xls file...');
			return FALSE;
		}
		
		return TRUE;
		
	}
	function load_editions()
	{
		$course_id = $this->uri->segment(3);
		 
		// Get chapters for course
		$editions = get_editions($course_id);
		
		$json_array = array();
		
		if(count($editions)){
			foreach ($editions as $ed_no){
				$json_array[] = array('id' => $ed_no['id'], 'edition_no' => $ed_no['edition_no']);
			}
		}
		
		echo json_encode($json_array);
		
	}
}