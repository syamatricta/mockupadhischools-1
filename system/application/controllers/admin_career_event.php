<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
	* Project				-	Adhischools
	* Language				-	PHP 5 & above
	* Database				-	Mysql
	* Author				-	Anusha Anand	
	* Created On 			-	April 28, 2010
	* Modified On 			-	May 12, 2010
	* Development Center	-	Rain Concert Technologies Pvt Ltd, Trivandrum, Kerala, India.(http://aarthikaindia.com)
*/
// ------------------------------------------------------------------------ 
	class Admin_career_event extends Controller
	{
		/**
		 * General contents
		 */
		var $gen_contents	= array();
		
		/**
		 * admin_schedule constructor
		 */
		
		function Admin_career_event () {
			parent::Controller();
			
			$this->load->helper(array('form'));
			
			$this->load->library(array('form_validation'));
			$this->load->helper ('tiny_mce');
			$this->load->model ('admin_career_event_model');
			
			$this->gen_contents['css'] 			= array('admin_style.css','calendar_style.css','dhtmlgoodies_calendar.css');
			$this->gen_contents['js'] 			= array('popup.js','admin_career_event.js','effects.js','dragdrop.js','popcalendar.js');
			$this->gen_contents['title']		= 'Career Event Management';
			$this->gen_contents['page_title']	= 'Career Event Management';
                        
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
		function _template ($page,$contents){
			$this->load->view("admin_header",$contents);							
			$this->load->view('admin/career_event/'.$page);
			$this->load->view("admin_footer");
		}
		/**
		 * Index
		 */	
		function index()
		{
			$this->session->unset_userdata(array('CLASS'=>''));
			$this->display_calendar();
		}
		
		/**
		 * function to display the calendar along with the event list if any
		 */
		function display_calendar ()
		{
                    
                    if (!$this->authentication->logged_in ("admin"))
                            redirect("admin");

                    //calls DML for processing data
                    if($_POST)
                            $this->_dbEventProcessor();

                    //gets the region and subregion for filter purpose
                    $this->_get_regions_subregions();

                    // gets the calendar (month || year)
                    if(isset($_POST['hdnTimeid']) && $_POST['hdnTimeid']!=0)
                            $time = $_POST['hdnTimeid'];
                    else 
                            $time = strtotime('-8 hour');

                    $this->gen_contents['sec_timing'] = $time;

                    //$_POST['sltSearchRegion']     = '';
                    //$_POST['sltSearchSubregion']  = '';
                    
                    //selected search options are saved to a variable
                    if($_POST && isset($_POST['sltSearchRegion'])){
                        $this->gen_contents['region_search']    = $_POST['sltSearchRegion'];
                        $this->gen_contents['subregion_search'] = $_POST['sltSearchSubregion'];
                    }else{
                        $_POST['sltSearchRegion']     = '';
                        $_POST['sltSearchSubregion']  = '';
                    }

                    //helps to change the mode of calendar by choosing the link from subregion list out 
                    if($this->session->userdata('CLASS')){
                        $this->gen_contents['class_mode']   = 1;
                        $this->gen_contents['title']        = 'Class Management';
                        $this->gen_contents['page_title']   = 'Class Management';
                    }

                    // we call _date function to get all the details of calendar n its event
                    $this->gen_contents = array_merge($this->gen_contents,$this->_date($time));

                    //default listing events for the current date
                    //'hdnCurrentDate' field stores the date fo today onload
                    //once a date is choosen to list the events or for adding the hidden filed will contain that date
                    //after traversing the calendar and when returned back to the current month default listing should be provided
                    if(isset($_POST['hdnCurrentDate'])){
                        $this->gen_contents['hdnCurrentDate']   	= date('Y/m/d',strtotime($_POST['hdnCurrentDate'])); 

                        if(($this->gen_contents['actual_month_year'] == $this->gen_contents['current_month_year']) && $_POST['hdnCurrentDate'] == ''){
                            $this->gen_contents['hdnCurrentDate'] 	= $this->gen_contents['today'];
                        }
                    }

                    $this->_template('display_calendar',$this->gen_contents);
		}
		/**
		 * function used to get the regions and all subregions
		 */
		function _get_regions_subregions(){
			
			$this->gen_contents['regions'] 		= $this->admin_career_event_model->dbSelectAllRegions();
			$arr_data 							= $this->admin_career_event_model->dbSelectAllSubRegions();
			$this->gen_contents['raw_subregion']= $arr_data;
			$id 								= 0;
			$arr_subregion						= array();
			
			foreach ($arr_data as $value){
				if($id != $value->regionid){
					$id 						= $value->regionid;
					$arr_subregion['R'][$id] 	= array();
				}
				$arr_subregion['R'][$id][] 		= array('id' =>$value->id,'name'=>$value->sub_name);
			}
			//gets all the region and subregion for the purpose of displaying filter
			//used to diaply subregion using jason array 			
			$this->gen_contents['json_array'] 	= json_encode($arr_subregion);
			
		}
		/**
		 * function that generates the calendar properties and its events
		 */
		function _date($time){
 			
			$data['calendar_path'] 	= base_url().'index.php/admin_schedule/display_calendar/';
		
			//$today 					= date("Y/n/j",  time());
			$today 					= date("Y/n/j", strtotime('-8 hour'));
			$data['today']			= $today;
			
			//$actual_month_year			= date("Y/n", time());
			$actual_month_year			= date("Y/n", strtotime('-8 hour'));
			$data['actual_month_year']	= $actual_month_year;
			
			$current_day 			= date("j", $time);
			$data['current_day'] 	= $current_day;
			
			$current_month 			= date("n", $time);
			$data['current_month'] 	= $current_month;
			
			$current_year 			= date("Y", $time);
			$data['current_year'] 	= $current_year;
			
			$current_month_year				= date("Y/n", $time);
			$data['current_month_year']	    = $current_month_year;
			
			$current_month_text 		= date("F Y", $time);
			$data['current_month_text'] = $current_month_text;
			
			$total_days_of_current_month 		= date("t", $time);
			$data['total_days_of_current_month']= $total_days_of_current_month;
			
			$first_day_of_month 		= mktime(0,0,0,$current_month,1,$current_year);
			$data['first_day_of_month'] = $first_day_of_month;
			
			$last_day_of_month 			= mktime(0,0,0,$current_month,$total_days_of_current_month,$current_year);
			$data['last_day_of_month']  = $last_day_of_month;
			
			//geting Numeric representation of the day of the week for first day of the month. 0 (for Sunday) through 6 (for Saturday).
			$first_w_of_month 			= date("w", $first_day_of_month);
			$data['first_w_of_month'] 	= $first_w_of_month;
			
			//how many rows will be in the calendar to show the dates
			$total_rows 		= ceil(($total_days_of_current_month + $first_w_of_month)/7);
			$data['total_rows']	= $total_rows;
			
			//trick to show empty cell in the first row if the month doesn't start from Sunday
			$day 		= -$first_w_of_month;
			$data['day']= $day;
			
			$next_month 		= mktime(0,0,0,$current_month+1,1,$current_year);
			$data['next_month']	= $next_month;
			
			$next_month_text 		= date("F \'y", $next_month);
			$data['next_month_text']= $next_month_text;
			
			$previous_month	 		= mktime(0,0,0,$current_month-1,1,$current_year);
			$data['previous_month']	= $previous_month;
			
			$previous_month_text 		= date("F \'y", $previous_month);
			$data['previous_month_text']= $previous_month_text;
			
			$next_year 			= mktime(0,0,0,$current_month,1,$current_year+1);
			$data['next_year']	= $next_year;
			
			$next_year_text 		= date("F \'y", $next_year);
			$data['next_year_text']	= $next_year_text;
			
			$previous_year 			= mktime(0,0,0,$current_month,1,$current_year-1);
			$data['previous_year']	= $previous_year;
			
			$previous_year_text 		= date("F \'y", $previous_year);
			$data['previous_year_text']	= $previous_year_text;
			
			//data from table
			if(isset($this->gen_contents['region_search']))
				$region_id  = $this->gen_contents['region_search'];
			else 
				$region_id	= 0;
			if(isset($this->gen_contents['subregion_search']))
				$subregion_id  = $this->gen_contents['subregion_search'];
			else 
				$subregion_id	= 0;
			//gets all the list of events for that month
			$data['events']		= $this->admin_career_event_model->dbGetMonthlyEventDetails(date('Y/m/d',$first_day_of_month),date('Y/m/d',$last_day_of_month),$region_id,$subregion_id);
			
			return $data;
  
 		}
 		/**
		 * function to add a particular event
		 */
		function add_event(){
			
			if(!$this->authentication->logged_in("admin")){ 
				$this->gen_contents['msg'] = 'Session expired';
				$this->load->view('admin/career_event/display_error',$this->gen_contents);
				return;
			}	
			$this->gen_contents['instructor_list'] 	=$this->admin_career_event_model->dbSelectAllInstructors();
			if(isset($_POST))
				$this->gen_contents['selected_date'] = $_POST['datecurrent'];
			else
				$this->gen_contents['selected_date'] = date('m/d/Y');
			//gets the regions and all the subregions	
			$this->_get_regions_subregions();
				
			if(isset($_POST['subregion_id'])){	
				
				$this->gen_contents['region_search'] 		= $_POST['region_id'];
				$this->gen_contents['subregion_search'] 	= $_POST['subregion_id'];
			}
			
			if($this->session->userdata('CLASS'))
				$this->gen_contents['class_mode'] 	= 1;
			$this->gen_contents['course_list'] 	= $this->admin_career_event_model->dbSelectAllCourses();
			$this->load->view('admin/career_event/display_add_event',$this->gen_contents);
		}
		/**
		 * function to display the list of events for a particular day
		 */
		function display_list(){
			if(!$this->authentication->logged_in("admin")){
				$this->gen_contents['msg'] = 'Session expired';
				$this->load->view('admin/career_event/display_error',$this->gen_contents);
				return;
			}		
			$this->gen_contents['current_date']	= $_POST['datecurrent'];
			$this->gen_contents['arr_list'] 	= $this->admin_career_event_model->dbGetEventListWithSearch($_POST);
			$this->load->view('admin/career_event/display_list_event',$this->gen_contents);
		}
		/**
		 * function to display single event
		 */
		function view_event(){
			$this->load->model("common_model");
			$this->gen_contents['arr_event'] 	= $this->admin_career_event_model->dbGetSingleEventDetails($_POST['main_id']);
			$this->gen_contents['capacity'] = $this->common_model->valueExists('adhi_career_events','totalcapacity',array('events_master_id'=>$_POST['main_id']));
                        $this->load->view('admin/career_event/display_view_event',$this->gen_contents);
		}
		/**
		 * function to edit an event
		 */
		function edit_event(){
			$this->load->model("common_model");
			$this->gen_contents['arr_event'] 	= $this->admin_career_event_model->dbGetSingleEventDetails($_POST['main_id']);
			$this->gen_contents['capacity'] = $this->common_model->valueExists('adhi_career_events','totalcapacity',array('events_master_id'=>$_POST['main_id']));
			$this->gen_contents['instructor_list'] 	=$this->admin_career_event_model->dbSelectAllInstructors();
			$this->_get_regions_subregions();
			if($this->session->userdata('CLASS'))
				$this->gen_contents['class_mode'] 	= 1;
                        $this->gen_contents['course_list'] 	= $this->admin_career_event_model->dbSelectAllCourses();
			$this->load->view('admin/career_event/display_edit_event',$this->gen_contents);
		}
		/**
		 * function used to process insertion, updation and deletion
		 */
		function _dbEventProcessor(){
			$this->load->model ('common_model');
			$arr_events  				= array();
			$arr_sub_events['arr_date'] = array();
			
			$cc_arr_events  				= array();
        
			if(isset($_POST['txtWhat2Do'])){
				
				if($_POST['txtWhat2Do'] == 'add' || $_POST['txtWhat2Do'] == 'edit'){ //add events to calendar
                                    
                                    $arr_events['title']            = $_POST['txtTitle'];
                                    $arr_events['parking_info']     = $_POST['txtParkingInfo'];
                                    $arr_events['description']      = $_POST['txtContent'];
                                    $arr_events['subregion_id']     = $_POST['sltSubregion'];
                                    $arr_events['subregion_id']     = $_POST['sltSubregion'];

                                    $arr_sub_events['tot_capacity'] = @$_POST['capacity'];

                                    $arr_events['date']   = date('Y/m/d',strtotime($_POST['txtDateStart']));					
                                    if(isset($_POST['txtRepeat'])){
                                        $arr_events['repeat_status']    = $_POST['sltRepeatType'];
                                        $arr_events['repeat_till']      = date('Y/m/d',strtotime($_POST['txtDateEnd']));
                                        $arr_sub_events['arr_date']     = $this->_getDays($arr_events['date'],$arr_events['repeat_till'],$_POST['sltRepeatType']);
                                    }else{
                                        $arr_sub_events['arr_date'][] = $arr_events['date'];
                                    }

                                    $arr_events['time_start']   = $this->_getFormattedTime($_POST['sltFromHr'],$_POST['sltFromMts'],$_POST['sltFromAP']);
                                    $arr_events['time_end']     = $this->_getFormattedTime( $_POST['sltToHr'],$_POST['sltToMts'],$_POST['sltToAP']);


                                    $arr_events['created_date'] = convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'));
                                    $arr_events['updated_date'] = convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'));

                                    if($_POST['txtWhat2Do'] == 'add'){
                                        $ret_arr = array();
                                        $ret_arr = $this->admin_career_event_model->dbInsertEventMaster($arr_events,$arr_sub_events);
                                        if(empty($ret_arr)){							
                                                $this->gen_contents['error_message'] 	= 'Request failed';
                                        }else{
                                            $this->gen_contents['success_message'] 	= 'Successfully added the event(s)';
                                        }
                                    }
                                    if($_POST['txtWhat2Do'] == 'edit'){
                                        if($this->admin_career_event_model->dbDeleteEventDetails($_POST['hdnMasterid'])){
                                            $ret_arr = array();
                                            $ret_arr = $this->admin_career_event_model->dbInsertEventMaster($arr_events,$arr_sub_events);
                                            if(empty($ret_arr)){									
                                                $this->gen_contents['error_message'] 	= 'Request failed';
                                            }else{
                                                $this->gen_contents['success_message'] 	= 'Successfully updated the event(s)';
                                            }
                                        }else{
                                            $this->gen_contents['error_message'] 	= 'Request failed';
                                        }
                                    }					
				}else if($_POST['txtWhat2Do'] == 'delete'){ //deletes all the event related to the chosen event
					$course_id = $this->common_model->valueExists('adhi_events_master','course_id',array('id'=>$_POST['hdnMasterid']));
					if(!$this->admin_career_event_model->dbDeleteEventDetails($_POST['hdnMasterid'])){
						$this->gen_contents['error_message'] 	= 'Event deletion failed';
					}else{
						$this->gen_contents['success_message'] 	= 'Successfully deleted the event(s)';
					}						
				}
				
			}
		}
		/** 
		 * function to get the formatted string for 24 hrs
		 * **/
		function _getFormattedTime($hour,$minute,$type){
			
			if($type=='P'){
				$meridiem = 'pm';
			}else{
				$meridiem = 'am';
			}
			
			$set_time = sprintf('%02d',$hour).':'.sprintf('%02d',$minute).' '.$meridiem;
			
			$formattedTime = date("H:i:s", strtotime($set_time));
			return $formattedTime;
		}
		/**
		 * function to get all the days between two dates
		 */
		function _getDays($sStartDate, $sEndDate,$mode){
			// Firstly, format the provided dates.This function works best with YYYY-MM-DD
			// but other date formats will work thanks to strtotime().
		
			$sStartDate = date("Y/m/d", strtotime($sStartDate));
			$sEndDate 	= date("Y/m/d", strtotime($sEndDate));
			
			// Start the variable off with the start date
			$aDays[] = $sStartDate;
			
			// Set a 'temp' variable, sCurrentDate, with the start date - before beginning the loop
			$sCurrentDate = $sStartDate;
			if($mode==1){
				$add_string = "+1 day";
			}else{
				$add_string = "+7 day";
			}
			// While the current date is less than the end date
			while($sCurrentDate <= $sEndDate){
				// Add a day to the current date
				$sCurrentDate = date("Y/m/d", strtotime($add_string, strtotime($sCurrentDate)));
				// Add this new day to the aDays array
				if($sCurrentDate <= $sEndDate)
					$aDays[] = $sCurrentDate;
			}
			
			// Once the loop has finished, return the array of days.
			return $aDays;
		}
		/**
		 * function used to redirect the schedule page to subregion schedule mode
		 *
		 */
		function class_display(){
			
			$this->session->set_userdata('CLASS',1);
			$this->display_calendar();
		}
                
                
                function list_bookings(){
                    $this->gen_contents["success_message"]='';
                    $this->load->model('common_model');
                    $this->load->model('admin_subadmin_model');
                    $this->gen_contents['page_title']	= 'Career Event Bookings';
                    $this->load->library('pagination');
                    $config['base_url'] 		= base_url().'admin_career_event/list_bookings/';
                    $config['per_page'] 		= '10';
                    $config['uri_segment']  		= 3;

                    $this->gen_contents["first_name"]       = '';
                    $this->gen_contents["last_name"]        = '';
                    $this->gen_contents["email"]            = '';
                    $this->gen_contents["phone"]            = '';
                    $this->gen_contents["event_id"]         = 0;

                    if(!empty($_POST)) {
                            $this->gen_contents["first_name"]   = $this->common_model->safe_html($this->input->post('txtSrchFirstname'));
                            $this->gen_contents["last_name"]    = $this->common_model->safe_html($this->input->post('txtSrchLastname'));
                            $this->gen_contents["email"]        = $this->common_model->safe_html($this->input->post('txtSrchEmail'));
                            $this->gen_contents["phone"]        = $this->common_model->safe_html($this->input->post('txtSrchPhone'));
                            $this->gen_contents["event_id"]     = $this->common_model->safe_html($this->input->post('txtSrchEvent'));
                    }else {
                            $this->gen_contents["first_name"]   = ($this->session->flashdata('first_name'))?$this->session->flashdata('first_name'):$this->gen_contents["first_name"];
                            $this->gen_contents["last_name"]    = $this->session->flashdata('last_name');
                            $this->gen_contents["email"]        = $this->session->flashdata('email');
                            $this->gen_contents["phone"]        = $this->session->flashdata('phone');
                            $this->gen_contents["event_id"]     = $this->session->flashdata('event_id');
                    }
                    $this->session->set_flashdata('first_name', $this->gen_contents["first_name"]);
                    $this->session->set_flashdata('last_name',  $this->gen_contents["last_name"]);
                    $this->session->set_flashdata('email',      $this->gen_contents["email"]);
                    $this->session->set_flashdata('phone',      $this->gen_contents["phone"]);
                    $this->session->set_flashdata('event_id',    $this->gen_contents["event_id"]);
                    
                    $this->gen_contents['events'] = $this->admin_career_event_model->getAllEvents();
                    
                    $this->gen_contents['bookings'] = $this->admin_career_event_model->getAllBookings($this->gen_contents, 'list', $config['per_page'], $this->uri->segment(3));
                    $config['total_rows']           = $this->admin_career_event_model->getAllBookings($this->gen_contents, 'count');
                    
                    $this->pagination->initialize($config);
                    $this->gen_contents['paginate']     =   $this->pagination->create_links(true);
                    $this->_template('list_bookings', $this->gen_contents);
		}
                
                
                function list_export_to_excel() {
                    $this->load->model('common_model');
                    $search_params   = array();
                    if(!empty($_POST)) {
                         $search_params["first_name"]    = $this->common_model->safe_html($this->input->post('first_name'));
                         $search_params["last_name"]     = $this->common_model->safe_html($this->input->post('last_name'));
                         $search_params["email"]         = $this->common_model->safe_html($this->input->post('email'));
                         $search_params["phone"]         = $this->common_model->safe_html($this->input->post('phone'));
                         $search_params["event_id"]      = $this->common_model->safe_html($this->input->post('event_id'));
                     }else {
                         $this->session->set_flashdata ('error', 'Invalid request');
                         redirect('admin_career_event/list_bookings');
                     }
                     
                     $event = (object) array();
                     if($search_params["event_id"] > 0){
                         $event = $this->admin_career_event_model->isEventExist($search_params["event_id"]);
                     }
                     $users  = $this->admin_career_event_model->getAllBookings($search_params, 'all');

                    //Show table values

                    if(!empty($users)){
                        $row     = 7;
                        $no      = 1;

                        $this->load->library('Excel');
                        $this->excel->setActiveSheetIndex(0);
                        //name the worksheet
                        if(isset($event->title)){
                            $this->excel->getActiveSheet()->setTitle($event->title);  
                            //set cell A1 content with some text
                            $e_date = formatDate($event->date);
                            if($event->repeat_status!=0 && $event->repeat_till != '0000-00-00'){
                                $e_date = $e_date.' - '.formatDate($event->repeat_till);
                            }
                            $this->excel->getActiveSheet()->setCellValue('A1', $event->title."\n". $e_date . " ".
                                    date("h:i a", strtotime($event->time_start)). " to ".date("h:i a", strtotime($event->time_end))."\n".
                                    trim($event->region_name).', '.$event->subregion_name."\n".$event->subregion_address
                                    );
                            
                        }else{
                            $this->excel->getActiveSheet()->setTitle('Event Booking');  
                            //set cell A1 content with some text
                            $this->excel->getActiveSheet()->setCellValue('A1', 'Event Booking');
                        }
                        
                        $this->excel->getActiveSheet()->setCellValue('A6', 'Sl.no.');
                        $this->excel->getActiveSheet()->setCellValue('B6', 'Name');
                        $this->excel->getActiveSheet()->setCellValue('C6', 'Email');
                        $this->excel->getActiveSheet()->setCellValue('D6', 'Phone');
                        $this->excel->getActiveSheet()->setCellValue('E6', 'Event Date');
                        //$this->excel->getActiveSheet()->setCellValue('G4', 'Created By');
                        //$this->excel->getActiveSheet()->setCellValue('H4', 'Reference');

                        $this->excel->getActiveSheet()->mergeCells('A1:E5');
                        //set aligment to center for that merged cell
                        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        $this->excel->getActiveSheet()->getStyle('A6:E6')->getFont()->setBold(true);
                        //make the font become bold
                        //$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
                        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
                        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');

                        for($col = ord('A'); $col <= ord('E'); $col++){
                           //set column dimension
                           $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
                            //change the font size
                           $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);

                           $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        }

                        foreach ($users as $data){
                             $this->excel->getActiveSheet()->setCellValue('A'.$row,$no);
                             $this->excel->getActiveSheet()->setCellValue('B'.$row,ucfirst($data->first_name)." ".ucfirst($data->last_name));  
                             $this->excel->getActiveSheet()->setCellValue('C'.$row,$data->email);
                             $this->excel->getActiveSheet()->setCellValue('D'.$row,$data->phone);
                             $this->excel->getActiveSheet()->setCellValue('E'.$row, formatDate($data->event_date));

                             $row++;
                             $no++;
                        }
                        $eventname  = (isset($event->title) && '' != $event->title)? '_'.$this->_event_filename($event->title) : '';
                        if(strlen($eventname) > 15){
                            
                        }
                        $filename = 'Adhischools_event'.$eventname.'_'.date('m_d_Y').'_'.time().'.xls';       //save our workbook as this file name
                        header('Content-Type: application/vnd.ms-excel');                   //mime type
                        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                        header('Cache-Control: max-age=0');                                 //no cache

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
                        //ob_end_clean();
                        $objWriter->save('php://output');
                    }else{
                        $this->session->set_flashdata ('error', 'Empty data');
                         redirect('admin_user/list_user_details');
                    }
                }
                function _event_filename($title){
                    $title = strtolower(htmlentities($title)); 
                    $title = str_replace(get_html_translation_table(), "-", $title);
                    $title = str_replace(" ", "-", $title);
                    $title = preg_replace("/[-]+/i", "-", $title);
                    return $title;
                }
	}	
/* End of file admin_schedule.php */
/* Location: ./system/application/controllers/admin_schedule.php */