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
	class Admin_schedule extends Controller
	{
		/**
		 * General contents
		 */
		var $gen_contents	= array();
		
		/**
		 * admin_schedule constructor
		 */
		
		function Admin_schedule () {
			parent::Controller();
			
			$this->load->helper(array('form'));
			
			$this->load->library(array('form_validation'));
			$this->load->helper ('tiny_mce');
			$this->load->model ('admin_schedule_model');
			
			$this->gen_contents['css'] 			= array('admin_style.css','calendar_style.css','dhtmlgoodies_calendar.css');
			$this->gen_contents['js'] 			= array('popup.js','schedule.js','effects.js','dragdrop.js','popcalendar.js');
			$this->gen_contents['title']		= 'Schedule Management';
			$this->gen_contents['page_title']	= 'Schedule Management';
                        
                        if($this->authentication->logged_in ("admin") === "sub") 
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
			$this->load->view('admin/schedule/'.$page);
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
			
			$_POST['sltSearchRegion'] = '';
			$_POST['sltSearchSubregion'] = '';
			//selected search options are saved to a variable
			if($_POST){
				$this->gen_contents['region_search'] 	= $_POST['sltSearchRegion'];
				$this->gen_contents['subregion_search'] = $_POST['sltSearchSubregion'];
			}
			
			//helps to change the mode of calendar by choosing the link from subregion list out 
			if($this->session->userdata('CLASS')){
				$this->gen_contents['class_mode'] 	= 1;
				$this->gen_contents['title']		= 'Class Management';
				$this->gen_contents['page_title']	= 'Class Management';
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
			
			$this->gen_contents['regions'] 		= $this->admin_schedule_model->dbSelectAllRegions();
			$arr_data 							= $this->admin_schedule_model->dbSelectAllSubRegions();
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
			$data['events']		= $this->admin_schedule_model->dbGetMonthlyEventDetails(date('Y/m/d',$first_day_of_month),date('Y/m/d',$last_day_of_month),$region_id,$subregion_id);
			
			return $data;
  
 		}
 		/**
		 * function to add a particular event
		 */
		function add_event(){
			
			if(!$this->authentication->logged_in("admin")){ 
				$this->gen_contents['msg'] = 'Session expired';
				$this->load->view('admin/schedule/display_error',$this->gen_contents);
				return;
			}	
			$this->gen_contents['instructor_list'] 	=$this->admin_schedule_model->dbSelectAllInstructors();
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
			$this->gen_contents['course_list'] 	= $this->admin_schedule_model->dbSelectAllCourses();
			$this->load->view('admin/schedule/display_add_event',$this->gen_contents);
		}
		/**
		 * function to display the list of events for a particular day
		 */
		function display_list(){
			if(!$this->authentication->logged_in("admin")){
				$this->gen_contents['msg'] = 'Session expired';
				$this->load->view('admin/schedule/display_error',$this->gen_contents);
				return;
			}		
			$this->gen_contents['current_date']	= $_POST['datecurrent'];
			$this->gen_contents['arr_list'] 	= $this->admin_schedule_model->dbGetEventListWithSearch($_POST);
			$this->load->view('admin/schedule/display_list_event',$this->gen_contents);
		}
		/**
		 * function to display single event
		 */
		function view_event(){
			$this->load->model("common_model");
			$this->gen_contents['arr_event'] 	= $this->admin_schedule_model->dbGetSingleEventDetails($_POST['main_id']);
			$this->gen_contents['capacity'] = $this->common_model->valueExists('adhi_events','totalcapacity',array('events_master_id'=>$_POST['main_id']));
                        $this->gen_contents['course_nam']='';
                        if($this->gen_contents['arr_event']->course_id !=0){
                            $this->gen_contents['course_selc'] 	= $this->admin_schedule_model->dbSelectSelcCoursesDetails($this->gen_contents['arr_event']->course_id);
                            $this->gen_contents['course_nam']=$this->gen_contents['course_selc']->course_name;
                        }

                        $this->load->view('admin/schedule/display_view_event',$this->gen_contents);
		}
		/**
		 * function to edit an event
		 */
		function edit_event(){
			$this->load->model("common_model");
			$this->gen_contents['arr_event'] 	= $this->admin_schedule_model->dbGetSingleEventDetails($_POST['main_id']);
			$this->gen_contents['capacity'] = $this->common_model->valueExists('adhi_events','totalcapacity',array('events_master_id'=>$_POST['main_id']));
			$this->gen_contents['instructor_list'] 	=$this->admin_schedule_model->dbSelectAllInstructors();
			$this->_get_regions_subregions();
			if($this->session->userdata('CLASS'))
				$this->gen_contents['class_mode'] 	= 1;
                        $this->gen_contents['course_list'] 	= $this->admin_schedule_model->dbSelectAllCourses();
			$this->load->view('admin/schedule/display_edit_event',$this->gen_contents);
		}
		/**
		 * function used to process insertion, updation and deletion
		 */
		function _dbEventProcessor(){
			$this->load->model ('common_model');
			$arr_events  				= array();
			$arr_sub_events['arr_date'] = array();
			
			$cc_arr_events  				= array();
	        $cc_arr_sub_events['arr_date'] = array();
        
			if(isset($_POST['txtWhat2Do'])){
				
				if($_POST['txtWhat2Do'] == 'add' || $_POST['txtWhat2Do'] == 'edit'){ //add events to calendar
				
					$arr_events['subregion_id'] 		= $_POST['sltSubregion'];
					$arr_events['course_id'] 		= $_POST['sltCourses'];
					if($arr_events['course_id']==15){
						$loc_name = $this->common_model->valueExists('adhi_subregion','subregion_name',array('id'=>$arr_events['subregion_id']));
						$cc_arr_events['location_name'] 		= $loc_name;						
					}
                    $arr_sub_events['tot_capacity'] = $cc_arr_sub_events['tot_capacity'] = @$_POST['capacity'];
					$arr_sub_events['instructor_id'] = $cc_arr_sub_events['instructor_id'] = @$_POST['instructor'];
					$cc_arr_events['date'] = $arr_events['date'] 				= date('Y/m/d',strtotime($_POST['txtDateStart']));
					
					if(isset($_POST['txtRepeat'])){
						$cc_arr_events['repeat_status'] = $arr_events['repeat_status'] 	= $_POST['sltRepeatType'];
						$cc_arr_events['repeat_till'] = $arr_events['repeat_till'] 	= date('Y/m/d',strtotime($_POST['txtDateEnd']));
						$cc_arr_sub_events['arr_date'] = $arr_sub_events['arr_date'] = $this->_getDays($arr_events['date'],$arr_events['repeat_till'],$_POST['sltRepeatType']);
					}else{
						$cc_arr_sub_events['arr_date'][] = $arr_sub_events['arr_date'][] = $arr_events['date'];
					}
					
					$cc_arr_events['time_start'] = $arr_events['time_start'] = $this->_getFormattedTime($_POST['sltFromHr'],$_POST['sltFromMts'],$_POST['sltFromAP']);
					$cc_arr_events['time_end'] = $arr_events['time_end'] = $this->_getFormattedTime( $_POST['sltToHr'],$_POST['sltToMts'],$_POST['sltToAP']);
					
					$arr_events['chapter_description'] 	= $_POST['txtContent'];
					
					$cc_arr_events['created_date'] = $arr_events['created_date'] = convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'));
					$cc_arr_events['updated_date'] = $arr_events['updated_date'] = convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'));
					
					if($_POST['txtWhat2Do'] == 'add'){
						$ret_arr = array();
						$ret_arr = $this->admin_schedule_model->dbInsertEventMaster($arr_events,$cc_arr_sub_events);
						if(empty($ret_arr)){							
							$this->gen_contents['error_message'] 	= 'Request failed';
						}else{
							if($arr_events['course_id']==15){ // check whether crashcourse
								$cc_arr_events['events_master_id'] 		= $ret_arr[0];
								$cc_arr_sub_events['events_id'] 		= $ret_arr[1];
								$this->admin_schedule_model->dbInsertEventMasterCCO($cc_arr_events,$cc_arr_sub_events);
							}
							$this->gen_contents['success_message'] 	= 'Successfully added the event(s)';
						}
					}
					if($_POST['txtWhat2Do'] == 'edit'){
						
						$course_id = $this->common_model->valueExists('adhi_events_master','course_id',array('id'=>$_POST['hdnMasterid']));
						if($course_id==15){
							$this->admin_schedule_model->dbDeleteEventDetailsCCO($_POST['hdnMasterid']);
						}
					
						if($this->admin_schedule_model->dbDeleteEventDetails($_POST['hdnMasterid'])){
							$ret_arr = array();
							$ret_arr = $this->admin_schedule_model->dbInsertEventMaster($arr_events,$cc_arr_sub_events);
							if(empty($ret_arr)){									
								$this->gen_contents['error_message'] 	= 'Request failed';
							}else{
								if($arr_events['course_id']==15){ // check whether crashcourse
									$cc_arr_events['events_master_id'] 		= $ret_arr[0];
									$cc_arr_sub_events['events_id'] 		= $ret_arr[1];
									$this->admin_schedule_model->dbInsertEventMasterCCO($cc_arr_events,$cc_arr_sub_events);
								}
								$this->gen_contents['success_message'] 	= 'Successfully updated the event(s)';
							}
						}else{
							$this->gen_contents['error_message'] 	= 'Request failed';
						}
					}					
				}
				else if($_POST['txtWhat2Do'] == 'delete'){ //deletes all the event related to the chosen event
					$course_id = $this->common_model->valueExists('adhi_events_master','course_id',array('id'=>$_POST['hdnMasterid']));
					if($course_id==15){
						$this->admin_schedule_model->dbDeleteEventDetailsCCO($_POST['hdnMasterid']);
					}
					 
					if(!$this->admin_schedule_model->dbDeleteEventDetails($_POST['hdnMasterid'])){
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
					
	}	
/* End of file admin_schedule.php */
/* Location: ./system/application/controllers/admin_schedule.php */