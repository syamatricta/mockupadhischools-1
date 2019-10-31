<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Project				-	Adhischools
* Language				-	PHP 5 & above
* Database				-	Mysql
* Author				-	Shinu Mary Simon	
* Created On 			-	November 02, 2009
* Modified On 			-	November 02, 2009
* Development Center	-	Rain Concert Technologies Pvt Ltd, Trivandrum, Kerala, India.(http://aarthikaindia.com)
*/
// ------------------------------------------------------------------------ 
class Edition extends Controller
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
	function Edition () {
		parent::Controller();
		$this->load->library('authentication');
		$this->load->helper(array('form', 'file'));
		if (!$this->authentication->logged_in ("admin"))
		{
			redirect("admin");
		}
		$this->load->library(array('form_validation'));
		$this->load->model('edition_model');
		$this->load->model('common_model');
		$this->gen_contents['css'] = array('admin_style.css','dhtmlgoodies_calendar.css');
		$this->gen_contents['js'] = array('edition.js','popcalendar.js');
		$this->gen_contents['title']	=	'Edition Management';
		
	}
	/**
	 * function to load the template (header, body and footer)
	 *
	 * @param string $page
	 * @param array $contents
	 */
	function _template ($page,$contents){
		$this->load->view("admin_header",$contents);							
		$this->load->view('admin/edition/'.$page, $contents);
		$this->load->view("admin_footer");
	}
	function summary(){
		$this->gen_contents['page_title']	= 'Edition Summary';
		$this->gen_contents ["courses"] = $this->edition_model->select_p_courses();
		
		if(isset($_POST['course_id']) && '' != $_POST['course_id']){
			$this->gen_contents['course_id'] = $this->input->post('course_id');	
		}
		else 
		{
			$this->gen_contents['course_id'] ='';	
		}
		
		if(isset($_POST['date_from']) && '' != $_POST['date_from']){
			$this->gen_contents['date_from'] = formatDate_search($this->input->post('date_from'));	
		}
		else 
		{
			$this->gen_contents['date_from'] ='';	
		}
		
		if(isset($_POST['date_to']) && '' != $_POST['date_to']){
			$this->gen_contents['date_to'] = formatDate_search($this->input->post('date_to'));	
		}
		else 
		{
			$this->gen_contents['date_to'] ='';	
		}

		$this->load->library('pagination');
		$config['base_url'] 				= 	base_url().'edition/summary';
		$config['per_page'] 				= 	10;
		$config['uri_segment']  			=  	3;
		$this->gen_contents["edition_list"]	=	$this->edition_model->getSummary($config['per_page'],$this->uri->segment(3),$this->gen_contents);

		$config['total_rows']   			= 	$this->edition_model->qry_count_orderdetails($this->gen_contents);
		$this->pagination->initialize($config);
		
		$this->gen_contents['paginate']     =   $this->pagination->create_links(true);
		
		$this->_template('summary',$this->gen_contents);
	}
	
	function add(){
		$this->gen_contents['page_title']	= 'Add Edition';
		$this->gen_contents ["courses"] = $this->edition_model->select_p_courses();
		if(@$_POST['edition']>0){
			
			$this->form_validation->set_rules ('course_id',"course", 'required');
			$this->form_validation->set_rules ('edition',"edition", 'trim|required|xss_clean|numeric');
			$this->form_validation->set_rules ('date_from',"from date",'trim|required|xss_clean');
			$this->form_validation->set_rules ('date_to',"to date",'trim|xss_clean');					
			
			if ((TRUE == $this->form_validation->run())) {	

					$save_data['course_id']	= trim($this->input->post ('course_id'));
					$save_data['edition_no']	= trim($this->input->post ('edition'));
					$save_data['default_edition']	= trim($this->input->post ('default_edition'));
			    	$save_data['date_from']		= formatDate_search($this->input->post('date_from'));
			    	$save_data['updated_on']	= date('Y-m-d H:i:s');
			    	$todate='';
			    	if($this->input->post('date_to'))
			    		$todate = $save_data['date_to']	=  formatDate_search($this->input->post('date_to'));
			    	if($this->common_model->valueExists('adhi_edition_summary','id',array("edition_no"=> $save_data['edition_no'],"course_id"=>$save_data['course_id']))) {
					   	$this->gen_contents['error'] =  "Edition - ".$save_data['edition_no']." has been already added";
			    	} else {
			    		$is_valid = $this->edition_model->isValidAddDates($save_data['course_id'],$save_data['date_from'],$todate);
			    		if($is_valid==1) {
			    			$this->gen_contents['error'] =  "There is a conflict with an already existing edition. Please select proper date range.";
			    		}else if($is_valid==2) {
			    			$this->gen_contents['error'] =  "An edition already exists in the same date or future date. Please select proper date range.";
			    		}else if($is_valid==3) {
			    			$this->gen_contents['error'] =  "Please select proper To-Date.";
			    		}else {
			    			
			    			if($is_valid!="NO"){
					    		$date_update_arr = $this->common_model->select('adhi_edition_summary','id',array("course_id"=> $save_data['course_id'],"date_to"=>null));
					    		if(count($date_update_arr)>0){
					    			$last_date = date('Y-m-d', strtotime('-1 day', strtotime($save_data['date_from'])));
									$this->common_model->update('adhi_edition_summary',array("date_to"=> $last_date,'updated_on'=>date('Y-m-d')),array("id"=> $date_update_arr[0]['id']));
								}
			    			}
							if($this->input->post ('default_edition')==1){
								$this->common_model->update('adhi_edition_summary',array("default_edition"=> 0),array("course_id"=> $save_data['course_id']));
							}
							$ret_id = $this->common_model->save('adhi_edition_summary',$save_data);
					    	if($ret_id) {
					    		if($this->input->post ('default_edition')==1)
									$default = $ret_id;
								else $default = 0;
								$this->common_model->update('adhi_courses',array("default_edition"=>$default),array("id"=> $save_data['course_id']));
								$user_courses =  $this->edition_model->getUserCourses($save_data['course_id'],$save_data['date_from'],$todate);
								if(count($user_courses)>0){
									foreach ($user_courses as $row) {
										$this->common_model->update('adhi_user_course',array("edition"=>$ret_id),array("id"=> $row['id']));
									}
								}
								
							   	$this->session->set_flashdata('success', "Edition has been added successfully");
			    		   		redirect ('edition/summary');
					    	} else {
					    		$this->session->set_flashdata('error', "Failed to insert the data");
			    		   		redirect ('edition/add');
					    	}
			    		}
			    	}
			}else {
				$this->merror=validation_errors();
			}
		}
		$this->_template('add',$this->gen_contents);
	}
	
	function edit(){
		$this->gen_contents['page_title']	= 'Edit Edition';
		$this->gen_contents ["courses"] = $this->edition_model->select_p_courses();
		$this->gen_contents ["edition_id"] = $edition_id = $this->uri->segment(3);
		if(is_numeric($edition_id)){
			$this->gen_contents ["edition_details"] = $this->edition_model->getEditionDetails($edition_id);
			if(count($this->gen_contents ["edition_details"])){
				if(@$_POST['edition']>0){
					$this->form_validation->set_rules ('course_id',"course", 'required');
					$this->form_validation->set_rules ('edition',"edition", 'trim|required|xss_clean|numeric');
					$this->form_validation->set_rules ('date_from',"from date",'trim|required|xss_clean');
					$this->form_validation->set_rules ('date_to',"to date",'trim|xss_clean');					
					
					if ((TRUE == $this->form_validation->run())) {	
		
						$save_data['course_id']		= trim($this->input->post ('course_id'));
						$save_data['edition_no']	= trim($this->input->post ('edition'));
						$save_data['default_edition']	= trim($this->input->post ('default_edition'));
				    	$save_data['date_from']		= formatDate_search($this->input->post('date_from'));
				    	$save_data['updated_on']	= date('Y-m-d H:i:s');
				    	$todate='';
				    	if($this->input->post('date_to'))
				    		$todate = $save_data['date_to']	=  formatDate_search($this->input->post('date_to'));
				    					    	
						if(!$save_data['default_edition'] && !$this->common_model->valueExists('adhi_edition_summary','id',array("default_edition"=> 1,"course_id"=>$save_data['course_id']),array('id'=>$edition_id))) {
						   	$this->gen_contents['error'] =  "Each course should have an edition set as default.";
				    	}else if($this->common_model->valueExists('adhi_edition_summary','id',array("edition_no"=> $save_data['edition_no'],"course_id"=>$save_data['course_id']),array('id'=>$edition_id))) {
						   	$this->gen_contents['error'] =  "Edition - ".$save_data['edition_no']." has been already added";
				    	} else {
				    		$is_valid = $this->edition_model->isValidEditDates($edition_id,$save_data['course_id'],$save_data['date_from'],$todate);
				    		if($is_valid==1) {
				    			$this->gen_contents['error'] =  "There is a conflict with an already existing edition. Please select proper date range.";
				    		}else if($is_valid==2) {
				    			$this->gen_contents['error'] =  "An edition already exists in the same date or future date. Please select proper date range.";
				    		}else if($is_valid==3) {
				    			$this->gen_contents['error'] =  "Please select proper To-Date.";
				    		}else {	
				    			if($this->input->post ('default_edition')==1){
									$this->common_model->update('adhi_edition_summary',array("default_edition"=> 0),array("course_id"=> $save_data['course_id']));
				    			}
						    	if($this->common_model->update('adhi_edition_summary',$save_data,array('id'=>$edition_id))) {	
						    		if($this->input->post ('default_edition')==1)
										$default = $edition_id;
									else $default = 0;
									$this->common_model->update('adhi_courses',array("default_edition"=>$default),array("id"=> $save_data['course_id']));
									
									$user_courses =  $this->edition_model->getUserCourses($save_data['course_id'],$save_data['date_from'],$todate);
									if(count($user_courses)>0){
										foreach ($user_courses as $row) {
											$this->common_model->update('adhi_user_course',array("edition"=>$edition_id),array("id"=> $row['id']));
										}
									}
								
								   	$this->session->set_flashdata('success', "Edition has been updated successfully");
				    		   		redirect ('edition/summary');
						    	} else {
						    		$this->session->set_flashdata('error', "Failed to insert the data");
				    		   		redirect ('edition/add');
						    	}
				    		}
				    	}
					}else {
						$this->merror=validation_errors();
					}
				}
				$this->_template('edit',$this->gen_contents);
			}else {
				$this->session->set_flashdata('error', "Invalid url");
				redirect ('edition/summary');
			}
		}else {
			$this->session->set_flashdata('error', "Invalid url");
			redirect ('edition/summary');
		}
	}
	function check_exam_status($course_id){
		$course_id = $this->uri->segment(3);
		$status = $this->common_model->select('adhi_courses','exam_status',array("id"=> $course_id));
		echo $status[0]['exam_status'];
	}
}