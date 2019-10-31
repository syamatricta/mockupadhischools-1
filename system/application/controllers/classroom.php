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
class Classroom extends Controller
{
	/**
	 * General contents
	 * @var array $gen_contents
	 */
	var $gen_contents = array();
	
	/**
	 * constructor
	 */
	function Classroom()
	{
		// Call parrent constructor
		parent::Controller();
		
		$this->load->library('authentication');
		$this->load->helper(array('form', 'file'));

		if(!$this->authentication->logged_in("normal")){
                    redirect("home");
                }
		
		$this->load->library(array('form_validation'));
		
		// Loading models
		$this->load->model('admin_user_model');
		$this->load->model('admin_sitepage_model');
		$this->load->model('admin_quiz_model');
		$this->load->model('classroom_model');
		$this->load->model('classroom_video_watch_model', 'watched_list');
		
		
		$this->gen_contents['css'] = array('client_style.css');
		$this->gen_contents['js'] = array( 'custom_element.js', 'classroom.js');
		$this->gen_contents['title'] = 'Classroom';
                $this->gen_contents['selected_nav'] = 'classroom';
		$this->gen_contents['forum'] = '';
		$this->gen_contents['siteurl'] = $this->admin_sitepage_model->select_sitepages_url();
		
                if($this->authentication->logged_in("normal")){
                    // Get all courses
                    $this->gen_contents['courses'] = $this->admin_quiz_model->get_course_lst_by_user($this->session->userdata ('USERID'));
                }
		
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
		
		$this->load->view("client_common_header_new", $contents);							
		$this->load->view('classroom/' . $page, $contents);
		$this->load->view("client_common_footer_new");
	}
		
	/**
	 * View method
	 * List all the videos by course and chapter
	 * @param void
	 * @return void
	 */
	function view()
	{
        if(is_BRE_test_user()){
            $this->session->set_flashdata ('error', 'You are restricted to view Classroom videos');
            redirect('course/courselist');
        }
        
        if(find_date_diff($this->config->item("cut_off_date"),$this->session->userdata ( 'USER_CREATED_AT' )) <= 0){
            $this->session->set_flashdata ('error', 'You are restricted to view Classroom videos');
            redirect('course/courselist');
        }
                // Load pagination library
		$this->load->library('pagination');
		
		$this->gen_contents['page_title'] = 'Classroom - videos';
		$this->gen_contents['course_id'] = 0;
		
		// Get course and chapter
		$course_id = ($this->input->post('course')) ? $this->input->post('course') : $this->uri->segment(3);
		$chapter_id = ($this->input->post('chapter')) ? $this->input->post('chapter') : $this->uri->segment(4);
		$offset = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		//$video_id = ($this->input->post('video')) ? $this->input->post('video') : $this->uri->segment(5);
		
		if(isset($chapter_id) && '' != $chapter_id) {
			//TODO check in user course id
			if($this->admin_quiz_model->check_user_course_list($course_id, $this->session->userdata ('USERID'))) {
				
				$this->gen_contents['course_id'] = $course_id;
				$this->gen_contents['chapter_id'] = $chapter_id;
				
				// Paginate configs
				$paginate_config ['per_page'] = '3';
				$paginate_config ['uri_segment'] = 5;
				$paginate_config ['base_url'] = base_url () . 'classroom/view/' . $course_id . '/' . $chapter_id;
				$paginate_config ['total_rows'] = $this->classroom_model->get_count_by_chapter_id($chapter_id);
				$paginate_config = array_merge ( $paginate_config, $this->config->item ( 'pagination_standard' ) );
				$this->pagination->initialize ( $paginate_config );
				
				$this->gen_contents['paginate'] = $this->pagination->create_links(true);
				
				// Get videos
				$this->gen_contents['videos'] = $this->classroom_model->get_by_chapter_id_with_watched($chapter_id, $this->session->userdata ('USERID'), $offset, $paginate_config ['per_page']);
			
				// Get chapters for course
				$edition = get_user_edition($course_id, $this->session->userdata ( 'USERID' ) );
				$this->gen_contents['chapters'] = $this->admin_quiz_model->get_chapters_by_course($course_id,$edition);
			}
		}
				
		//$this->_template('view', $this->gen_contents);
			$this->template->set_template('user');
        	$this->template->write_view('content', 'reskin/classroom/view', $this->gen_contents);
        	$this->template->render();
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
		 
		// Get chapters for course
		$edition = get_user_edition($course_id, $this->session->userdata ( 'USERID' ) );
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
	 * function to update video watched list
	 * @access public
	 * @param void
	 * @return ajax response
	 */
	public function update_watched_list()
	{
		$video_id = $this->input->post('video_id'); 	
		$user_id = $this->session->userdata ('USERID');

		if($this->watched_list->update_watched($user_id, $video_id) == TRUE) {
			echo "TRUE"; 
		} else {
			echo "FALSE";
		}
		exit;
	}
}