<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Project				-	Adhischools
 * Language				-	PHP 5 & above
 * Database				-	Mysql
 * Author				-	Syama S
 * Created On                            -	March 29, 2016
 * Modified On                           -	March 29, 2016
 * Development Center                    -	Rain Concert Technologies Pvt Ltd, Trivandrum, Kerala, India.(http://aarthikaindia.com)
 */
// ------------------------------------------------------------------------
class Attendance_report extends Controller {

    /**
     * General contents
     *
     * @var Array
     */
    var $gen_contents = array();
    var $datefrom = '';
    var $dateto = '';

    /**
     * Attendance_report constructor
     *
     */
    function Attendance_report() {
        parent::Controller();
        
        $this->load->library('authentication');
        $this->load->helper(array('form', 'url', 'file'));
        
        $this->load->library(array('form_validation'));
        $this->load->model('attendance_report_model');
        $this->load->model('admin_user_model');
        $this->load->model('admin_schedule_model');
        $this->load->model('common_model');
        $this->gen_contents['css'] 			= array('admin_style.css','calendar_style.css','dhtmlgoodies_calendar.css');
        $this->gen_contents['js'] 			= array('popup.js','admin_attendance.js','effects.js','dragdrop.js','popcalendar.js','admin_report_js.js');
        $this->gen_contents['title'] =   'Attendance Report';
        
        if($this->authentication->logged_in ("admin") === "sub" && !$this->authentication->check_permission_redirect('sub_permission_1', FALSE)) 
        {
            redirect("admin/noaccess");
            exit;
        }
    }

    /**
     * function to load the template (header, body and footer)
     *
     * @param string $page
     * @param array $contents
     */
    function _template($page, $contents) {
        $this->load->view("admin_header", $contents);
        $this->load->view('admin/attendance/' . $page, $contents);
        $this->load->view("admin_footer");
    }

    /**
     * Index
     *
     * @access	public
     */
    function index() {
        $this->list_report_detail();
    }

    function list_report_detail (){
        $this->session->unset_userdata('search_date_from');
        $this->session->unset_userdata('search_date_to');
        $this->session->unset_userdata('search_region');
        $this->session->unset_userdata('search_sub_region');
        $this->session->unset_userdata('search_course');
        $this->session->unset_userdata('search_instructor');
        redirect('index.php/attendance_report/list_report_details');
    }

    /**
     * function to list the report details
     *
     */
    function list_report_details() {
        
        $this->_get_regions_subregions();
        $this->gen_contents['instructor_list']    = $this->admin_schedule_model->dbSelectAllInstructors();
        $this->gen_contents['course_list'] 	= $this->admin_schedule_model->dbSelectAllCourses();
      
        if(!empty($_POST)) {
            if (isset($_POST['search_date_from']) && '' != $_POST['search_date_from']&& 0 != $_POST['search_date_from']) {
                $this->gen_contents['search_date_from'] = formatDate_search($this->input->post('search_date_from'));
            } else {
                $this->gen_contents['search_date_from'] = '';
            }
            
            if (isset($_POST['search_date_to']) && '' != $_POST['search_date_to'] && 0 != $_POST['search_date_to']) {
                $this->gen_contents['search_date_to'] = formatDate_search($this->input->post('search_date_to'));
            }else {
                if(array_key_exists('ajax',$_POST)){
                    $this->gen_contents['search_date_to'] = '';
                } else {
                    $this->gen_contents['search_date_to'] = convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
                }
            }
            
            $this->gen_contents['search_region']       = (isset($_POST['search_region']) && 0 != $_POST['search_region'])? $_POST['search_region'] : "";
            $this->gen_contents['search_sub_region']   = (isset($_POST['search_sub_region']) && 0 != $_POST['search_sub_region'])? $_POST['search_sub_region'] : "";
            $this->gen_contents['search_course']       = (isset($_POST['search_course']) && 0 != $_POST['search_course'])? $_POST['search_course'] : "";
            $this->gen_contents['search_instructor']   = (isset($_POST['search_instructor']) && 0 != $_POST['search_instructor'])? $_POST['search_instructor'] : "";
        } else {
            $this->gen_contents["search_date_from"] = ($this->session->userdata('search_date_from')) ? trim($this->session->userdata('search_date_from')) : trim(@$this->gen_contents["search_date_from"]);
            $this->gen_contents["search_date_to"] = ($this->session->userdata('search_date_to')) ? trim($this->session->userdata('search_date_to')): trim(@$this->gen_contents["search_date_to"]);
            $this->gen_contents["search_region"]     =  ($this->session->userdata('search_region')) ? trim($this->session->userdata('search_region')): trim(@$this->gen_contents["search_region"]);
            $this->gen_contents["search_sub_region"] = ($this->session->userdata('search_sub_region')) ? trim($this->session->userdata('search_sub_region')) : trim(@$this->gen_contents["search_sub_region"]);
            $this->gen_contents["search_course"] = ($this->session->userdata('search_course')) ? trim($this->session->userdata('search_course')): trim(@$this->gen_contents["search_course"]);
            $this->gen_contents["search_instructor"] = ($this->session->userdata('search_instructor')) ? trim($this->session->userdata('search_instructor')) : trim(@$this->gen_contents["search_instructor"]);
        }
        
        $this->session->set_userdata('search_date_from',$this->gen_contents["search_date_from"]);
        $this->session->set_userdata('search_date_to',$this->gen_contents["search_date_to"]);
        $this->session->set_userdata('search_region',$this->gen_contents["search_region"]);
        $this->session->set_userdata('search_sub_region',$this->gen_contents["search_sub_region"]);
        $this->session->set_userdata('search_course',$this->gen_contents["search_course"]);
        $this->session->set_userdata('search_instructor',$this->gen_contents["search_instructor"]);

        $this->gen_contents['page_title'] = 'Attendance Report';
        $this->gen_contents['current_month_year'] =  $this->gen_contents['actual_month_year'] = date("Y/n", strtotime('-8 hour'));
        
        $this->load->library('pagination');
        $config['base_url']               = base_url() . 'index.php/attendance_report/list_report_details/';
        $config['per_page']               = '10';
        $config['uri_segment']            = 3;
        $this->gen_contents["reports"]    = $this->attendance_report_model->select_reports($config['per_page'], $this->uri->segment(3), $this->gen_contents,"data");
        $config['total_rows']             = $this->attendance_report_model->select_reports($config['per_page'], $this->uri->segment(3), $this->gen_contents,"count");
        $page_no 			  = $this->uri->segment(3);
        $this->gen_contents['page_no']    = $page_no;
                        
        $this->pagination->initialize($config);
        $this->gen_contents['paginate']   = $this->pagination->create_links(true);
        $this->_template('list_report_details', $this->gen_contents);
    }
    
    /**
     * function to list the report details excel
     *
     */
    function list_report_details_excel() {
        
        if(!empty($_POST)) {
            if (isset($_POST['search_date_from']) && '' != $_POST['search_date_from'] && 0 != $_POST['search_date_from']) {
                $this->gen_contents['search_date_from'] = formatDate_search($this->input->post('search_date_from'));
                $dt_from = date('m/d/Y',strtotime($this->gen_contents['search_date_from']));
            } else if ('' != $this->uri->segment(3) && 0 == $this->uri->segment(3)) {
                $this->gen_contents['search_date_from'] = '';
                $dt_from = 'Beginning';
            } else {
                $this->gen_contents['search_date_from'] = convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
                $dt_from = date('m/d/Y',strtotime($this->gen_contents['search_date_from']));
            }

            if (isset($_POST['search_date_to']) && '' != $_POST['search_date_to']) {
                $this->gen_contents['search_date_to'] = formatDate_search($this->input->post('search_date_to'));
            } else if ('' != $this->uri->segment(4)) {
                $this->gen_contents['search_date_to'] = $this->uri->segment(4);
            } else {
                $this->gen_contents['search_date_to'] = convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
            }
            
            $this->gen_contents['search_region']       = (isset($_POST['search_region']) && 0 != $_POST['search_region'])? $_POST['search_region'] : "";
            $this->gen_contents['search_sub_region']   = (isset($_POST['search_sub_region']) && 0 != $_POST['search_sub_region'])? $_POST['search_sub_region'] : "";
            $this->gen_contents['search_course']       = (isset($_POST['search_course']) && 0 != $_POST['search_course'])? $_POST['search_course'] : "";
            $this->gen_contents['search_instructor']   = (isset($_POST['search_instructor']) && 0 != $_POST['search_instructor'])? $_POST['search_instructor'] : "";
        } else {
            $this->gen_contents["search_date_from"] = ($this->session->userdata('search_date_from')) ? trim($this->session->userdata('search_date_from')) : trim($this->gen_contents["search_date_from"]);
            $this->gen_contents["search_date_to"] = ($this->session->userdata('search_date_to')) ? trim($this->session->userdata('search_date_to')): trim($this->gen_contents["search_date_to"]);
            $this->gen_contents["search_region"]     =  ($this->session->userdata('search_region')) ? trim($this->session->userdata('search_region')): trim($this->gen_contents["search_region"]);
            $this->gen_contents["search_sub_region"] = ($this->session->userdata('search_sub_region')) ? trim($this->session->userdata('search_sub_region')) : trim($this->gen_contents["search_sub_region"]);
            $this->gen_contents["search_course"] = ($this->session->userdata('search_course')) ? trim($this->session->userdata('search_course')): trim($this->gen_contents["search_course"]);
            $this->gen_contents["search_instructor"] = ($this->session->userdata('search_instructor')) ? trim($this->session->userdata('search_instructor')) : trim($this->gen_contents["search_instructor"]);
        }
        
        $this->session->set_userdata('search_date_from',$this->gen_contents["search_date_from"]);
        $this->session->set_userdata('search_date_to',$this->gen_contents["search_date_to"]);
        $this->session->set_userdata('search_region',$this->gen_contents["search_region"]);
        $this->session->set_userdata('search_sub_region',$this->gen_contents["search_sub_region"]);
        $this->session->set_userdata('search_course',$this->gen_contents["search_course"]);
        $this->session->set_userdata('search_instructor',$this->gen_contents["search_instructor"]);
        
        $reports                          = $this->attendance_report_model->select_reports("", "", $this->gen_contents,"full");
        
        //Show table values
        
        if(!empty($reports)){
            $row = 5;
            $no = 1;
            
            $this->load->library('Excel');
            $this->excel->setActiveSheetIndex(0);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('Attendance Report');  
            //set cell A1 content with some text
            $this->excel->getActiveSheet()->setCellValue('A1', 'Attendance Report ('.$dt_from.' - '. date('m/d/Y',strtotime($this->gen_contents['search_date_to'])).')');
            $this->excel->getActiveSheet()->setCellValue('A4', 'Date');
            $this->excel->getActiveSheet()->setCellValue('B4', 'Day');
            $this->excel->getActiveSheet()->setCellValue('C4', 'Start');
            $this->excel->getActiveSheet()->setCellValue('D4', 'End');
            $this->excel->getActiveSheet()->setCellValue('E4', 'Region');
            $this->excel->getActiveSheet()->setCellValue('F4', 'Sub-Region');
            $this->excel->getActiveSheet()->setCellValue('G4', 'Course');
            $this->excel->getActiveSheet()->setCellValue('H4', 'Instructor');
            $this->excel->getActiveSheet()->setCellValue('I4', 'Attendance');
            $this->excel->getActiveSheet()->setCellValue('J4', 'Created Date');
            $this->excel->getActiveSheet()->setCellValue('K4', 'Created By'); 
            $this->excel->getActiveSheet()->setCellValue('L4', 'Titled Guests');
            $this->excel->getActiveSheet()->setCellValue('M4', 'Notes');
            $this->excel->getActiveSheet()->setCellValue('N4', 'Updated Date');

            $this->excel->getActiveSheet()->mergeCells('A1:N1');
            //set aligment to center for that merged cell
            $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A4:N4')->getFont()->setBold(true);
            //make the font become bold
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
            $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');

            for($col = ord('A'); $col <= ord('N'); $col++){
               //set column dimension
               $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
                //change the font size
               $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);

               $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            }
            
            foreach ($reports as $data){
                            if(($data->admin_fname != "" && $data->created_by != 1)){ 
                                $by.= "(".ucfirst($data->admin_fname)." ".ucfirst($data->admin_lname).")"; 
                            }
                            
                            $this->excel->getActiveSheet()->setCellValue('A'.$row,formatDate($data->date));
                            $this->excel->getActiveSheet()->setCellValue('B'.$row,date("l",strtotime($data->date)));  
                            $this->excel->getActiveSheet()->setCellValue('C'.$row,$data->time_from);//
                            $this->excel->getActiveSheet()->setCellValue('D'.$row,$data->time_to); 
                            $this->excel->getActiveSheet()->setCellValue('E'.$row,$data->region_name );
                            $this->excel->getActiveSheet()->setCellValue('F'.$row,$data->subregion_name);
                            $this->excel->getActiveSheet()->setCellValue('G'.$row,$data->course_name);
                            $this->excel->getActiveSheet()->setCellValue('H'.$row,$data->instructor_name); 
                            $this->excel->getActiveSheet()->setCellValue('I'.$row,$data->attendance); 
                            
                            $this->excel->getActiveSheet()->setCellValue('J'.$row,formatDate($data->created_date));
                            $this->excel->getActiveSheet()->setCellValue('K'.$row,ucfirst($data->admin_first_name)." ".ucfirst($data->admin_last_name));
                            $this->excel->getActiveSheet()->setCellValue('L'.$row,$data->titled_guests);
                            $this->excel->getActiveSheet()->setCellValue('M'.$row,$data->notes);
                            $this->excel->getActiveSheet()->setCellValue('N'.$row,("" != $data->updated_date)? formatDate($data->updated_date) : '');
             
                            $row++;
                            $no++;
            }
            
            $filename = 'Attendance_Report_'.date('m_d_Y').'_'.time().'.xls';       //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel');                   //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0');                                 //no cache

            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            //ob_end_clean();
            $objWriter->save('php://output');
        }
    }
    
     /**
    * function for adding attendance
    */

    function add_attendance()
    {
          if(!empty($_POST)) {
              $this-> _int_user_attendance_step();
          }
          
          $this->gen_contents['selected_date']      = convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
          $page_no 				    = $this->uri->segment(3);
          $this->gen_contents['page_no']            = $page_no;
          
          $this->_get_regions_subregions();
          
          if(isset($_POST['subregion_id'])){
                $this->gen_contents['search_region'] 	= $_POST['sltRegion'];
                $this->gen_contents['search_sub_region'] = $_POST['sltSubregion'];
          }
          
          $this->gen_contents['current_month_year'] =  $this->gen_contents['actual_month_year'] = date("Y/n", strtotime('-8 hour'));

          $this->load->helper("form");
          $this->gen_contents['instructor_list']    = $this->admin_schedule_model->dbSelectAllInstructors();
          $this->gen_contents['course_list'] 	= $this->admin_schedule_model->dbSelectAllCourses();
          $this->load->view("admin/admin_recruiter_heading",$this->gen_contents);
          $this->load->view('admin/attendance/add_attendance',$this->gen_contents);
          $this->load->view("admin_footer",$this->gen_contents);
    }
    
    /**
    * function used to get the regions and all subregions
    */
   function _get_regions_subregions(){

           $this->gen_contents['regions'] 		= $this->admin_schedule_model->dbSelectAllRegions();
           $arr_data 					= $this->admin_schedule_model->dbSelectAllSubRegions();
           $this->gen_contents['raw_subregion']         = $arr_data;
           $id 						= 0;
           $arr_subregion				= array();

           foreach ($arr_data as $value){
                   if($id != $value->regionid){
                           $id 						= $value->regionid;
                           $arr_subregion['R'][$id] 	= array();
                   }
                   $arr_subregion['R'][$id][] 		= array('id' =>$value->id,'name'=>$value->sub_name);
           }
           //gets all the region and subregion for the purpose of displaying filter
           //used to display subregion using jason array 			
           $this->gen_contents['json_array'] 	= json_encode($arr_subregion);

   }


    function _int_user_attendance_step()
    {
        if(!empty($_POST)) {
            $this->gen_contents['msg'] 	= '';
            $this->load->library("form_validation");
            $this->_init_attendance_rules();

            if($this->form_validation->run() == TRUE) {
                if(isset($_POST['txtWhat2Do'])){
                    if($_POST['txtWhat2Do'] == 'add' || $_POST['txtWhat2Do'] == 'edit'){

                            $arr_events['region']        = $_POST['sltRegion'];
                            $arr_events['sub_region']     = $_POST['sltSubregion'];
                            $arr_events['course']        = $_POST['sltCourses'];
                            $arr_events['instructor']    = @$_POST['instructor'];
                            $arr_events['date']          = date('Y/m/d',strtotime($_POST['txtDateStart']));
                            $arr_events['time_from']     = $this->_getFormattedTime($_POST['sltFromHr'],$_POST['sltFromMts'],$_POST['sltFromAP']);
                            $arr_events['time_to']       = $this->_getFormattedTime( $_POST['sltToHr'],$_POST['sltToMts'],$_POST['sltToAP']);
                            $arr_events['status'] =  1;

                            $check_data = $arr_events;
                            $arr_events['attendance']    =  $this->common_model->safe_html($_POST['txtAttendance']);
                            $arr_events['titled_guests'] =  $this->common_model->safe_html($_POST['titled_guests']);
                            $arr_events['notes'] =  $this->common_model->safe_html($_POST['txtContent']);
                            
                            if(!empty($_FILES)) {
                                if (($_FILES['report']['error']) ==  0) {
                                            if($this->do_upload()){
                                                $arr_events['report'] = $this->gen_contents["file_name"];
                                            }
                                }
                            }
                            
                            if(1 == $_POST['fileRemoved']){
                                $arr_events['report'] = '';
                            }

                            if($_POST['txtWhat2Do'] == 'add'){
                                $arr_events['created_date']  = convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'));
                                $arr_events['created_by']  = $this->session->userdata('USERID');

                                $attendance_id = $this->common_model->valueExists('adhi_attendance_report','adhi_attendance_report_id',$check_data);
                                if($attendance_id){
                                    $this->gen_contents['msg'] 	= 'Data already exists';
                                }else{
                                    $attendance_id = $this->attendance_report_model->add_attendance_details($arr_events);
                                    $this->session->set_flashdata ('msg', 'Added successfully');
                                    redirect('attendance_report/list_report_details/'.$this->uri->segment(3));
                                }
                            }

                            if($_POST['txtWhat2Do'] == 'edit'){
                                    $arr_events['updated_date'] = convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'));
                                    $arr_events['updated_by']  = $this->session->userdata('USERID');
                                    $not_check_data = array("adhi_attendance_report_id" => $_POST['hidid']);

                                    $attendance_id = $this->common_model->valueExists('adhi_attendance_report','adhi_attendance_report_id',$check_data, $not_check_data);

                                    if($attendance_id){
                                        $this->gen_contents['msg'] 	= 'Data already exists';
                                    }else{
                                        $attendance_id = $this->attendance_report_model->update_attendance_details($_POST['hidid'],$arr_events);
                                        $this->gen_contents['msg'] 	= 'Updated successfully';
                                        //$this->session->set_flashdata ('msg', 'Updated successfully');
                                    }
                            }					
                    }
                }
            }
        }
    }

    /**
     * function for form validation in step 1 registration
     *
     */
    function _init_attendance_rules()
    {
            $this->form_validation->set_rules('sltRegion', 'Region', 'required|max_length[128]');
            $this->form_validation->set_rules('sltSubregion', 'Sub-Region', 'required|max_length[128]');
            $this->form_validation->set_rules('sltCourses', 'Course', 'required|max_length[128]');
            $this->form_validation->set_rules('instructor', 'Instructor', 'required');
            $this->form_validation->set_rules('txtDateStart', 'Date', 'required');
            $this->form_validation->set_rules('txtAttendance', 'Attendance', 'requiredd|max_length[20]|numeric');
            $this->form_validation->set_rules('titled_guests', 'Guests', 'requiredd|max_length[20]|numeric');
    }

    /**
     * function to view the attendance details
     *
     */
    function view_attendance (){
            $this->gen_contents["course"]	=	array();
            $this->gen_contents['page_title']	=	'Attendance Details';

            $this->session->set_flashdata('search_region',$this->session->flashdata('search_region'));
            $this->session->set_flashdata('search_sub_region',$this->session->flashdata('search_sub_region'));
            $this->session->set_flashdata("search_course",$this->session->flashdata('search_course'));
            $this->session->set_flashdata("search_instructor",$this->session->flashdata('search_instructor'));
            $this->session->set_flashdata("search_date_from",$this->session->flashdata('search_date_from'));
            $this->session->set_flashdata("search_date_to",$this->session->flashdata('search_date_to'));

            $this->_attendance_details($this->uri->segment(4));
            $this->_template('view_attendance',$this->gen_contents);
    }
     
    /**
     * function to edit the attendance details
     *
     */
    function edit_attendance (){
            $this->gen_contents['page_title']	=	'Edit Attendance Details';
            $this->gen_contents["attendanceid"]	=	$this->uri->segment(4);
            
            if(!empty($_POST)) {
              $this-> _int_user_attendance_step();
            }

            $this->session->set_flashdata('search_region',$this->session->flashdata('search_region'));
            $this->session->set_flashdata('search_sub_region',$this->session->flashdata('search_sub_region'));
            $this->session->set_flashdata("search_course",$this->session->flashdata('search_course'));
            $this->session->set_flashdata("search_instructor",$this->session->flashdata('search_instructor'));
            $this->session->set_flashdata("search_date_from",$this->session->flashdata('search_date_from'));
            $this->session->set_flashdata("search_date_to",$this->session->flashdata('search_date_to'));
            
            $page_no 				    = $this->uri->segment(3);
            $this->gen_contents['page_no']          = $page_no;
            $this->gen_contents['selected_date']    = convert_UTC_to_PST_date(date('m/d/Y'));
            
            $this->_get_regions_subregions();
            $this->gen_contents['current_month_year'] =  $this->gen_contents['actual_month_year'] = date("Y/n", strtotime('-8 hour'));

            $this->gen_contents['instructor_list']    = $this->admin_schedule_model->dbSelectAllInstructors();
            $this->gen_contents['course_list'] 	= $this->admin_schedule_model->dbSelectAllCourses();
          
            $this->_attendance_details($this->gen_contents["attendanceid"]);
            $this->_template('edit_attendance',$this->gen_contents);
    }
    
    /**
     * function to get the attendacne details
     *
     */
    function _attendance_details ($attendance_id)
    {
        $this->attendance_id                       = 	$attendance_id;
        $this->gen_contents["attendance_details"]  =	$this->attendance_report_model->select_single_attendancedetails($this->attendance_id);
        
        $h1 = explode(":",$this->gen_contents["attendance_details"]->time_from);
        $m1 = explode(" ",$h1[1]);
        $s1 = explode(" ",$this->gen_contents["attendance_details"]->time_from);
        
        $this->gen_contents["sltHr1"]              = $h1[0];
        $this->gen_contents["sltMin1"]             = $m1[0];
        $this->gen_contents["sltMer1"]             = $s1[1];
        
        $h2 = explode(":",$this->gen_contents["attendance_details"]->time_to);
        $m2 = explode(" ",$h2[1]);
        $s2 = explode(" ",$this->gen_contents["attendance_details"]->time_to);
        
        $this->gen_contents["sltHr2"]              = $h2[0];
        $this->gen_contents["sltMin2"]             = $m2[0];
        $this->gen_contents["sltMer2"]             = $s2[1];
    }
    
    /** 
    * function to get the formatted string for 24 hrs
    * **/
   function _getFormattedTime($hour,$minute,$type){

           if($type=='PM'){
                   $meridiem = 'PM';
           }else{
                   $meridiem = 'AM';
           }

           $set_time = sprintf('%02d',$hour).':'.sprintf('%02d',$minute).' '.$meridiem;

           //$formattedTime = date("H:i", strtotime($set_time))." ".$meridiem;
           return $set_time;
   }
   
   function delete_attendance(){
       $master_data   = array("adhi_attendance_report_id" => $_POST['masterid']);
       $arr_events    = array("status" => 0);
       $attendance_id = $this->common_model->update('adhi_attendance_report',$arr_events,$master_data);

       if($attendance_id){							
            $this->gen_contents['msg'] 	= 'Request failed';
       }else{
            //$this->gen_contents['msg'] 	= 'Deleted successfully';
            $this->session->set_flashdata ('msg', 'Deleted successfully');
       }
   }
   
   /**
    * function for file upload
    */
   function do_upload(){		
           $config['upload_path'] 				= $this->config->item ('image_upload_path').'attendance/';
           $config['allowed_types']                             = implode('|',$this->config->item ('image_extensions'));
           $config['max_size']					= $this->config->item ('image_max_size');
           $config['max_width']  				= $this->config->item ('image_max_width');
           $config['max_height']  				= $this->config->item ('image_max_height');	
           $config['encrypt_name']				= TRUE;
           $img_ext 						= get_extension ('report'); 			
           $imgname						= $_FILES['report']['name'];
           $config['file_name']  				= $imgname;

           //checks if its of the same file extension
           $name_array = explode(".",$_FILES['report']['name']);
           $ext        = $name_array[count($name_array)-1];
           if(!in_array($ext,$this->config->item ('image_extensions'))){
                   $this->gen_contents['error_region'] = 'Incorrect file type';
                   return FALSE;
           }

           $this->load->library('upload', $config);
           if ( ! $this->upload->do_upload('report')){ 

                   $this->gen_contents['msg'] = $this->upload->display_errors();
                   return FALSE;
           }	
           else{
                   $arr_file = $this->upload->data();
                   $this->gen_contents["file_name"] 	=  $arr_file['file_name'];
                   image_resize($this->gen_contents['file_name'],$config['upload_path'],175,100);
                   return TRUE;
           }
   }	
		
       
    
}

/* End of file income_report.php */
/* Location: ./system/application/controllers/income_report.php */