<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
	* Project				-	Adhischools
	* Language				-	PHP 5 & above
	* Database				-	Mysql
	* Author				-	Shinu Mary Simon
	* Created On                            -	October 23, 2009
	* Modified On                           -	October 23, 2009
	* Development Center                    -	Rain Concert Technologies Pvt Ltd, Trivandrum, Kerala, India.(http://aarthikaindia.com)
*/
// ------------------------------------------------------------------------
	class Brokerage extends Controller
	{

		/**
		 * General contents
		 *
		 * @var Array
		 */
		var     $gen_contents	=	array();
		var     $userid 		=	''; 		/*Id of the selected user*/
		var     $firstname		=	"";
		var     $lastname		=	'';
                var	$licensetype		=	'';
		var	$email			=	'';
		var	$current_controller     =	'brokerage';
		/**
		 * Admin constructor
		 *
		 */
		function Brokerage () {
			parent::Controller();
			$this->load->library('authentication');
			$this->load->helper(array('form', 'file'));
			if (!$this->authentication->logged_in ("admin"))
			{
				redirect("admin");
			}
                        else if($this->authentication->logged_in ("admin") === "sub") 
                        {
                            $this->session->set_flashdata('success', $this->session->flashdata("success"));
                            redirect("admin/noaccess");
                            exit;
                        }
			$this->load->library(array('form_validation'));
			$this->load->model('admin_user_model');
			$this->gen_contents['css'] = array('admin_style.css','dhtmlgoodies_calendar.css');
			$this->gen_contents['js'] = array('admin_user_js.js','popcalendar.js');
			$this->gen_contents['title']	=	'User-Brokerage Management';

		}
		/**
		 * function to load the template (header, body and footer)
		 *
		 * @param string $page
		 * @param array $contents
		 */
		function _template ($page,$contents, $admin_folder='admin/brokerage/'){
			$this->load->helper('form');
			$this->load->view("admin_header",$contents);
			$this->load->view($admin_folder.$page, $contents);
			$this->load->view("admin_footer");
		}
                
		function index()
		{
			$this->list_user_details();
		}
		/**
		 * function to list the user details
		 *
		 */
		function list_user_details ()
		{
			$this->gen_contents["success_message"]='';
			if(!is_numeric($this->uri->segment(3))){
				$s_msg = ($this->uri->segment(3));
				$this->gen_contents["success_message"] = base64_decode($s_msg);
			}
			$this->load->model('common_model');
                        $this->load->model('admin_subadmin_model');
			$this->gen_contents['page_title']	=	'Users';
			$this->load->library('pagination');
			$config['base_url'] 				= 	base_url().'index.php/brokerage/list_user_details/';
			$config['per_page'] 				= 	'10';
			$config['uri_segment']  			=  	3;

			/*****sree 080710**/
			$this->gen_contents["search_firstname"] = '';
			$this->gen_contents["search_lastname"] = '';
			$this->gen_contents["search_email"] = '';
			$this->gen_contents["course_completed"]='';
                        
                        $this->gen_contents["search_phone"] = '';
                        $this->gen_contents["search_zipcode"] = '';
                        $this->gen_contents["search_brokerage"] = '';
                        $this->gen_contents["course_type"]      = '';

			if(!empty($_POST)) {
				$this->gen_contents["search_firstname"] = $this->common_model->safe_html($this->input->post('txtSrchFirstname'));
				$this->gen_contents["search_lastname"] = $this->common_model->safe_html($this->input->post('txtSrchLastname'));
				$this->gen_contents["search_email"] = $this->common_model->safe_html($this->input->post('txtSrchEmail'));
				$this->gen_contents["course_completed"] = $this->common_model->safe_html($this->input->post('course_completed'));
				$this->gen_contents["license_type"] = $this->common_model->safe_html($this->input->post('license_type'));
				$this->gen_contents["course_type"]      = $this->common_model->safe_html($this->input->post('course_type'));
                                $this->gen_contents["search_brokerage"]      = $this->common_model->safe_html($this->input->post('txtBrokerage'));
                                
                                $this->gen_contents["search_phone"] = $this->common_model->safe_html($this->input->post('txtSrchPhone'));
                                $this->gen_contents["search_city"] = $this->common_model->safe_html($this->input->post('txtSrchCity'));
                                $this->gen_contents["search_zipcode"] = $this->common_model->safe_html($this->input->post('txtSrchZipcode'));
			}else {
				$this->gen_contents["search_firstname"] = ($this->session->flashdata('bsearch_firstname'))?$this->session->flashdata('bsearch_firstname'):$this->gen_contents["search_firstname"];
				$this->gen_contents["search_lastname"] = $this->session->flashdata('bsearch_lastname');
				$this->gen_contents["search_email"] = $this->session->flashdata('bsearch_email');
				$this->gen_contents["course_completed"] = $this->session->flashdata('bcourse_completed');
				$this->gen_contents["license_type"] = $this->session->flashdata('blicense_type');
				$this->gen_contents["course_type"]      = $this->session->flashdata('bcourse_type');
                                $this->gen_contents["search_brokerage"]      = $this->session->flashdata('bsearch_brokerage');
                                
                                $this->gen_contents["search_phone"] = $this->session->flashdata('search_phone');
                                $this->gen_contents["search_city"] = $this->session->flashdata('search_city');
                                $this->gen_contents["search_zipcode"] = $this->session->flashdata('search_zipcode');
			}
			$this->session->set_flashdata('bsearch_firstname',$this->gen_contents["search_firstname"]);
			$this->session->set_flashdata('bsearch_lastname',$this->gen_contents["search_lastname"]);
			$this->session->set_flashdata('bsearch_email',$this->gen_contents["search_email"]);
			$this->session->set_flashdata('bcourse_completed',$this->gen_contents["course_completed"]);
			$this->session->set_flashdata('blicense_type',$this->gen_contents["license_type"]);
                        
                        $this->session->set_flashdata('bsearch_brokerage',$this->gen_contents["search_brokerage"]);
                        $this->session->set_flashdata('bsearch_phone',$this->gen_contents["search_phone"]);
                        $this->session->set_flashdata('bsearch_city',$this->gen_contents["search_city"]);
                        $this->session->set_flashdata('bsearch_zipcode',$this->gen_contents["search_zipcode"]);
			
                        $is_completed = true;
                        $this->gen_contents["userdetails"]	= $this->admin_user_model->bb_select_userdetails_completed($config['per_page'],$this->uri->segment(3),$this->gen_contents["search_firstname"],$this->gen_contents["search_lastname"],$this->gen_contents["search_email"], $this->gen_contents["license_type"],$this->gen_contents["search_phone"],$this->gen_contents["search_zipcode"], $this->gen_contents["search_city"], $this->gen_contents["course_type"], $this->gen_contents["search_brokerage"],$is_completed, true);

                        $config['total_rows']   		= $this->admin_user_model->bb_qry_count_userdetails_completed($this->gen_contents["search_firstname"],$this->gen_contents["search_lastname"],$this->gen_contents["search_email"],$this->gen_contents["license_type"],$this->gen_contents["search_phone"],$this->gen_contents["search_zipcode"], $this->gen_contents["search_city"], $this->gen_contents["course_type"],$is_completed, $this->gen_contents["search_brokerage"]);

			$this->gen_contents["total"]            = $config['total_rows'];
			$this->pagination->initialize($config);
			$this->gen_contents['paginate']     =   $this->pagination->create_links(true);
			$this->_template('list_user_details',$this->gen_contents);
		}
            /**
            * function to list the report details excel
            *
            */
           function list_export_to_excel() {
               $this->load->model('common_model');
               $search_params   = array();
               if(!empty($_POST)) {
                    $search_params["first_name"]    = $this->common_model->safe_html($this->input->post('first_name'));
                    $search_params["last_name"]     = $this->common_model->safe_html($this->input->post('last_name'));
                    $search_params["email"]         = $this->common_model->safe_html($this->input->post('email'));
                    $search_params["brokerage"]  = $this->common_model->safe_html($this->input->post('brokerage'));
                    $search_params["license_type"]  = $this->common_model->safe_html($this->input->post('lic_type'));
                    $search_params["phone"]         = $this->common_model->safe_html($this->input->post('phone'));
                    $search_params["city"]          = $this->common_model->safe_html($this->input->post('city'));
                    $search_params["zipcode"]       = $this->common_model->safe_html($this->input->post('zipcode'));
                    $search_params["course_type"]       = $this->common_model->safe_html($this->input->post('c_type'));

                }else {
                    $this->session->set_flashdata ('error', 'Invalid request');
                    redirect('brokerage/list_user_details');
                }

                $users  = $this->admin_user_model->bb_select_userdetails_completed(0,0,$search_params["first_name"],$search_params["last_name"],
                        $search_params["email"],$search_params["license_type"],$search_params["phone"],$search_params["zipcode"],$search_params["city"],
                         $search_params["course_type"],$search_params['brokerage'],true,false);
                

               if(!empty($users)){
                   $row     = 5;
                   $no      = 1;

                   $this->load->library('Excel');
                   $this->excel->setActiveSheetIndex(0);
                   //name the worksheet
                   $this->excel->getActiveSheet()->setTitle('Adhischools Users');  
                   //set cell A1 content with some text
                   $this->excel->getActiveSheet()->setCellValue('A1', 'Adhischools Users');

                   $this->excel->getActiveSheet()->setCellValue('A4', 'Sl.no.');
                   $this->excel->getActiveSheet()->setCellValue('B4', 'Name');
                   $this->excel->getActiveSheet()->setCellValue('C4', 'Email');
                   $this->excel->getActiveSheet()->setCellValue('D4', 'License');
                   $this->excel->getActiveSheet()->setCellValue('E4', 'Broker');
                   $this->excel->getActiveSheet()->setCellValue('F4', 'Phone');
                   $this->excel->getActiveSheet()->setCellValue('G4', 'City');
                   $this->excel->getActiveSheet()->setCellValue('H4', 'Zipcode');

                   $this->excel->getActiveSheet()->mergeCells('A1:H3');
                   //set aligment to center for that merged cell
                   $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                   $this->excel->getActiveSheet()->getStyle('A4:H4')->getFont()->setBold(true);
                   //make the font become bold
                   $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
                   $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
                   $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');

                   for($col = ord('A'); $col <= ord('H'); $col++){
                      //set column dimension
                      $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
                       //change the font size
                      $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);

                      $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                   }

                   foreach ($users as $data){
                        $this->excel->getActiveSheet()->setCellValue('A'.$row,$no);
                        $this->excel->getActiveSheet()->setCellValue('B'.$row,ucfirst($data->firstname)." ".ucfirst($data->lastname));  
                        $this->excel->getActiveSheet()->setCellValue('C'.$row,$data->emailid);
                        $this->excel->getActiveSheet()->setCellValue('D'.$row,("B" == $data->licensetype ? 'Brokers' : 'Sales'));
                        $this->excel->getActiveSheet()->setCellValue('E'.$row,$data->broker_name);
                        $this->excel->getActiveSheet()->setCellValue('F'.$row,$data->phone);
                        $this->excel->getActiveSheet()->setCellValue('G'.$row,$data->city);
                        $this->excel->getActiveSheet()->setCellValue('H'.$row,$data->zipcode);

                        $row++;
                        $no++;
                   }

                   $filename = 'Adhischools_Users_List_'.date('m_d_Y').'_'.time().'.xls';       //save our workbook as this file name
                   header('Content-Type: application/vnd.ms-excel');                   //mime type
                   header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                   header('Cache-Control: max-age=0');                                 //no cache

                   $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
                   //ob_end_clean();
                   $objWriter->save('php://output');
               }else{
                   $this->session->set_flashdata ('error', 'Empty data');
                    redirect('brokerage/list_user_details');
               }
           }
           
           function view_users (){
                    $this->gen_contents["course"]		=	array();
                    $this->gen_contents['page_title']	=	'User Details';

                    $this->session->set_flashdata('search_firstname',$this->session->flashdata('search_firstname'));
                    $this->session->set_flashdata('search_lastname',$this->session->flashdata('search_lastname'));
                    $this->session->set_flashdata('search_email',$this->session->flashdata('search_email'));
                    $this->session->set_flashdata("course_completed",$this->session->flashdata('course_completed'));

                    $this->_user_details($this->uri->segment(3));
                    $this->_profile_progress($this->userid, $this->gen_contents["userdetails"]->emailid);

                    $this->_template('view_user_details',$this->gen_contents);
            }
            
            function _user_details ($userid)
            {
                    $this->userid 						= 	$userid;
                    $this->gen_contents["userdetails"]	=	$this->admin_user_model->select_single_userdetails($this->userid);
                    $this->gen_contents["state"]		=	$this->admin_user_model->select_state_name($this->gen_contents["userdetails"]->state);
                    $this->gen_contents["s_state"]		=	$this->admin_user_model->select_state_name($this->gen_contents["userdetails"]->s_state);
                    $this->gen_contents["b_state"]		=	$this->admin_user_model->select_state_name($this->gen_contents["userdetails"]->b_state);
                    $this->gen_contents["course_user_type"] =	$this->admin_user_model->select_user_course_types($this->gen_contents["userdetails"]->course_user_type);
            /* course details*/
                    $this->gen_contents["coursedetails"]=	$this->admin_user_model->select_single_user_course_details($this->userid);
            }
            
            function _profile_progress($user_id, $email_id){
            /* Profile stage progress starts  here */
            $this->load->model(array('course_model', 'user_model'));
            $user_stat  = array(
                'completed_all_exams'           => (($this->course_model->hasAttendedAllExams($user_id, 'P')) ? array('class'=>'visited') : FALSE),
                'registerd_in_crashcourse'      => FALSE,
                'state_exam_applied'            => FALSE,
                'obtained_license'              => FALSE,
                'obtained_license_from'         => FALSE
            );
            
            if($user_stat['completed_all_exams']) {
                
                if($this->course_model->isCrashCourseUser($email_id)){
                    $user_stat['registerd_in_crashcourse']  = array('class' => 'visited');
                }

                $profile_progress = $this->user_model->getProfileProgress($user_id);

                /* Whether the user applied for State Exam */
                if($profile_progress && $this->_item_key_exists($profile_progress, 'state_exam_applied')){

                    $user_stat['state_exam_applied']    = array('class' => 'visited');
                    
                    if($this->course_model->isCrashCourseUser($email_id)){
                        $user_stat['obtained_license']      = array('class' => 'active');
                    }

                    /* Whether the user obtained license and  applied for State Exam  */
                    if($profile_progress && $this->_item_key_exists($profile_progress, 'obtained_license')){
                        $user_stat['obtained_license']        = array('class' => 'visited');
                        
                        if(!empty($profile_progress)){
                            foreach($profile_progress as $key => $prog){
                                if("obtained_license" == $prog["item"]){
                                    $user_stat['obtained_license_from'] = $prog["broker_name"];
                                }
                            }
                        }
                    }
                }else{
                    $user_stat['state_exam_applied']    = array('class' => 'active');
                }
                
            }
            
            $this->gen_contents['user_stat']  = $user_stat;                    
            /* Profile stage progress ends  here */
        }
        
        function _item_key_exists($array, $key, $check_value_true = TRUE){
            if(is_array($array) && count($array) > 0){
                foreach ($array as $array){
                    //if($key == $array['item'] && TRUE == $array['checked']){
                    if($key == $array['item']){
                        if($check_value_true){
                            return $array['checked'];
                        }
                        return TRUE;
                    }
                }
            }
            return FALSE;
        }
        
        function user_course_details () {
			$this->gen_contents['page_title']	= 'User Course Details';
			$this->userid 						= $this->uri->segment(3);

			$this->session->set_flashdata('search_firstname',$this->session->flashdata('search_firstname'));
			$this->session->set_flashdata('search_lastname',$this->session->flashdata('search_lastname'));
			$this->session->set_flashdata('search_email',$this->session->flashdata('search_email'));
			$this->session->set_flashdata("course_completed",$this->session->flashdata('course_completed'));

			$this->gen_contents['userid']		= $this->userid;
			$this->gen_contents["coursedetails"]= $this->admin_user_model->select_single_user_course_details($this->userid);
			
			/*** sree 070410**/
			$this->load->model('course_model');
                        $this->load->model('user_model');
			$license= $this->course_model->get_license($this->userid);
                        $course_user_type= $this->user_model->get_course_user_type($this->userid);
                        /* Get new package for sales*/
                         $package_type= $this->course_model->get_user_package_type($this->userid);
                         //Added to enable course edit to types
                         if(1==$course_user_type){
                                $course_user_type =2;
                            }else if(3==$course_user_type){
                                $course_user_type =4;
                            }else if(5==$course_user_type){
                                $course_user_type =6;
                            }else if(7==$course_user_type){
                                $course_user_type =8;
                            }else {
                                $course_user_type =$course_user_type;
                            } 
                            
                         if($course_user_type==2 || $course_user_type==4 || $course_user_type==6 || $course_user_type==8 || $package_type==1){

                          $this->gen_contents['add_status']	= $this->course_model->check_addcourse($this->userid,$license,$course_user_type);
                         }else{
                         $this->gen_contents['add_status'] = false;
                         
                        }
			/*** sree 070410 ***/

			$arr_quiz		= array();
			$arr_user_quiz	= $this->admin_user_model->getQuizCountForUser($this->userid);
			foreach ($arr_user_quiz as $val){
				$arr_quiz[] = $val->course_id;
			}
			
			/* Exam attended details exist or not starts here */
			$this->load->model('user_exam_model');
			$exam_attended_exist				= false;
			foreach ($this->gen_contents["coursedetails"] as $key	=> $coursedetail){
				$this->gen_contents["coursedetails"][$key]->exam_attended_exist	= $this->user_exam_model->isUserAttendedCourse($this->userid, $coursedetail->courseid);
                                if($coursedetail->renewal_status == 'Y'){
                                    $this->gen_contents["coursedetails"][$key]->renew_expired    = $this->user_exam_model->isRenewExpired($coursedetail->id);
                                } else{
                                    $this->gen_contents["coursedetails"][$key]->renew_expired     = 'N';
                                }
			}
			/* Exam attended details exist or not ends here */
			
			$this->gen_contents["arr_quiz"]		= $arr_quiz;
			$this->gen_contents["username"]		= $this->admin_user_model->select_single_userdetails($this->userid);
			$this->_template('user_course_details',$this->gen_contents);
		}
    }
/* End of file admin.php */
/* Location: ./system/application/controllers/admin_user.php */
