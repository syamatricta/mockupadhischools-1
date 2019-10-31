<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
	* Project				-	Adhischools
	* Language				-	PHP 5 & above
	* Database				-	Mysql
	* Author				-	Anusha Anand	
	* Created On 			-	April 28, 2010
	* Modified On 			-	April 28, 2010
	* Development Center	-	Rain Concert Technologies Pvt Ltd, Trivandrum, Kerala, India.(http://aarthikaindia.com)
*/
// ------------------------------------------------------------------------ 
	class Schedule extends Controller
	{
		/**
		 * General contents
		 */
		var $gen_contents	= array();
		
		/**
		 * Schedule constructor
		 */
		
		function Schedule () {
			parent::Controller();
			
			$this->load->helper(array('form'));
			
			$this->load->model ('admin_schedule_model');
			
			$this->gen_contents['css'] 			= array('style.css','client_style.css','user_calendar_style.css','modalbox.css','schedule.css');
			$this->gen_contents['js'] 			= array('client_login.js','effects.js','popcalendar.js','modalbox.js','custom_element.js','inlineschedule.js');
			$this->gen_contents['title']		= 'Schedules & Locations';
			$this->gen_contents['page_title']	= 'Schedules & Locations';
			
		}
		/**
		 * function to load the home template (header, body and footer)
		 *
		 * @param string $page
		 * @param array $contents
		 */
		function _home_template ($page,$contents){
			$this->load->view("client_home_header_new",$contents);
			$this->load->view('user/schedule/'.$page, $contents);
			$this->load->view("client_home_footer_new",$contents);
		}
		/**
		 * function to load the template (header, body and footer)
		 *
		 * @param string $page
		 * @param array $contents
		 */
		function _template ($page,$contents){
			$this->load->view("client_common_header",$contents);							
			$this->load->view('user/schedule/'.$page, $contents);
			$this->load->view("client_common_footer",$contents);
		}
		/**
		 * Index
		 */	
		function indexold()
		{ 
			/*$this->gen_contents['css'] = array_merge($this->gen_contents['css'], array("meet.css"));
        	$this->gen_contents['js'] = array_merge($this->gen_contents['js'], array("meet.js"));*/
			$this->load->model('admin_sitepage_model');
			$this->_set_default_values();
			$this->commonListRelatedRegion();
			$this->_get_regions_subregions();
			$this->gen_contents["course_list_all"] = $this->admin_schedule_model->dbSelectAllCourses();
                        $this->gen_contents["chp_list"] = $this->config->item('chapter_list');
                        $this->gen_contents["crse_color"] = $this->config->item('course_color');
                        
			// we call _date function to get all the details of calendar n its event
			$this->gen_contents = array_merge($this->gen_contents,$this->_date(strtotime('-8 hour')));
			
			$this->_home_template('display_schedule_new',$this->gen_contents);
			
		}
		
		
		
		function index(){
			$this->load->model('admin_sitepage_model');
			$this->_set_default_values();
			$this->commonListRelatedRegion();
			$this->_get_regions_subregions();
			$this->gen_contents["course_list_all"] = $this->admin_schedule_model->dbSelectAllCourses();
                        $this->gen_contents["chp_list"] = $this->config->item('chapter_list');
                        $this->gen_contents["selected_nav"] = 'schedule';
                        $this->gen_contents["crse_color"] = $this->config->item('course_color');
                        
		
			
			 
            $this->template->write_view('content', 'reskin/schedule/schedule', $this->gen_contents);
            $this->template->render();
		}
		
		function getClassforDay(){
			$this->gen_contents['region_search'] 	= $_POST['region'];
 			$this->gen_contents['subregion_search'] = $_POST['subregion'];
            $this->gen_contents['course_search'] = $_POST['course'];
            if($this->gen_contents['course_search']=='5'){
                $this->gen_contents['chp_search'] = $_POST['chp'];
            }
            $this->gen_contents["chp_list"] = $this->config->item('chapter_list');
            $this->gen_contents["crse_color"] = $this->config->item('course_color');
 			// we call _date function to get all the details of calendar n its event
			//$this->gen_contents = array_merge($this->gen_contents,$this->_date($_POST['timeid'],$_POST['course'],$_POST['region'],$_POST['subregion']));
			
			if(isset($this->gen_contents['region_search']))
				$region_id  = $this->gen_contents['region_search'];
			else 
				$region_id	= 0;
			if(isset($this->gen_contents['subregion_search']))
				$subregion_id  = $this->gen_contents['subregion_search'];
			else 
				$subregion_id	= 0;
                        if(isset($this->gen_contents['course_search']))
				$course_id  = $this->gen_contents['course_search'];
			else
				$course_id	= 0;
                        if(isset($this->gen_contents['chp_search']))
				$chp_id  = $this->gen_contents['chp_search'];
			else
				$chp_id	= 0;
			$date =  $_POST['date'];
		    $this->gen_contents['date'] = $date;			 
            $chp_list = $this->config->item('chapter_list');
			//$dated			=	convert_UTC_to_PST_date_slash(date('m/d/Y H:i:s',strtotime($date)));			
            $this->gen_contents['arr_class'] = $this->admin_schedule_model->dbClasslistandlocation($date,$course_id, $region_id, $subregion_id,$chp_id,$chp_list);
			if($this->gen_contents['arr_class'])
				$this->load->view ('reskin/schedule/eachday', $this->gen_contents);
			else {
				echo '';
			}
	
		}
		
		function get_classes(){ 
 			$this->gen_contents['region_search'] 	= $_POST['region'];
 			$this->gen_contents['subregion_search'] = $_POST['subregion'];
            $this->gen_contents['course_search'] = $_POST['course'];
            if($this->gen_contents['course_search']=='5'){
                $this->gen_contents['chp_search'] = $_POST['chp'];
            }
            $this->gen_contents["chp_list"] = $this->config->item('chapter_list');
            $this->gen_contents["crse_color"] = $this->config->item('course_color');
 			// we call _date function to get all the details of calendar n its event
			//$this->gen_contents = array_merge($this->gen_contents,$this->_date($_POST['timeid'],$_POST['course'],$_POST['region'],$_POST['subregion']));
			$device = $_POST['device'] ?$_POST['device']:'large';
			if(isset($this->gen_contents['region_search']))
				$region_id  = $this->gen_contents['region_search'];
			else 
				$region_id	= 0;
			if(isset($this->gen_contents['subregion_search']))
				$subregion_id  = $this->gen_contents['subregion_search'];
			else 
				$subregion_id	= 0;
                        if(isset($this->gen_contents['course_search']))
				$course_id  = $this->gen_contents['course_search'];
			else
				$course_id	= 0;
                        if(isset($this->gen_contents['chp_search']))
				$chp_id  = $this->gen_contents['chp_search'];
			else
				$chp_id	= 0;
			$first_day_of_month =  $_POST['s_date'];
			$last_day_of_month  =  $_POST['e_date'];
			 
            $chp_list = $this->config->item('chapter_list');
                        //$data["course_list"] = $this->admin_schedule_model->dbSelectAllCourses();
            if($device=='large')
              $data["course_list"] = $this->admin_schedule_model->dbGetCoursesByDate($first_day_of_month,$last_day_of_month,$course_id, $region_id, $subregion_id,$chp_id,$chp_list);
			else  
			  $data["course_list"] = $this->admin_schedule_model->dbGetCoursesByDateMobile($first_day_of_month,$last_day_of_month,$course_id, $region_id, $subregion_id,$chp_id,$chp_list);
             echo json_encode($data["course_list"])  ;exit;

 		}
		
		function _set_default_values(){
			$this->gen_contents['siteurl']			= $this->admin_sitepage_model->select_sitepages_url();
			$this->gen_contents['thinkingabout']	= $this->admin_sitepage_model->select_single_sitepage_det(3);
			$this->gen_contents['gotquestion']		= $this->admin_sitepage_model->select_single_sitepage_det(4);
			$this->gen_contents['dated'] 			= convert_UTC_to_PST_date_slash(date('m/d/Y H:i:s'));
			//$this->gen_contents['dated'] 			= date('m/d/Y');
			$this->gen_contents['image_path'] 		= $this->config->item('image_upload_url').'thumbs/';
			$this->gen_contents['modal_path'] 		= 'home/class_details';
			$this->gen_contents['modal_form'] 		= 'tonightclassform';
			$this->gen_contents["offset_hidden"] 	= 0;
			$this->gen_contents["num_hidden"] 		= 5;
		}
		/**
		 * function used to collect the iamges for displaying at the user side
		 */
		function commonListRelatedRegion() {
			
			$this->load->model('admin_schedule_model');
			
			$this->gen_contents["tot_num_related_region"] = $this->admin_schedule_model->dbGetCountTonitesClasslist($this->gen_contents['dated']);
			
			$this->gen_contents["next_active"] 	= 0; //1 for enable and 0 for disable			
			$this->gen_contents["prev_active"] 	= 0; //1 for enable and 0 for disable
			$num_pages 							= ceil($this->gen_contents["tot_num_related_region"] / $this->gen_contents["num_hidden"])-1;
			$cur_page 							= ceil(($this->gen_contents["offset_hidden"]/$this->gen_contents["num_hidden"]));
			if($cur_page < $num_pages) {
				$this->gen_contents["next_active"] = 1;
			} 
			if($cur_page > 0) {
				$this->gen_contents["prev_active"] = 1;
			}			
			$this->gen_contents['image_path'] 	= $this->config->item('image_upload_url').'thumbs/';
			$this->gen_contents["arr_result"] 	= $this->admin_schedule_model->dbGetTonitesClasslist($this->gen_contents['dated'],$this->gen_contents["num_hidden"],$this->gen_contents["offset_hidden"]);
		}
		/**
		 * gets the next set of images for diaplying at the user schedule and locations
		 */
		function related_region () {
			$this->gen_contents['modal_path'] 		= 'home/class_details';
			$this->gen_contents['modal_form'] 		= 'tonightclassform';
			if(!empty($_POST)) {
				$this->gen_contents['dated']	 	= $_POST['dated'];	
				$this->gen_contents['subregion'] 	= $_POST['subregion'];	
				$this->gen_contents["offset_hidden"]= $_POST['offset'];
				$this->gen_contents["num_hidden"] 	= 5;
				
				$this->commonListRelatedRegion ();				
					
			} else {
				$this->gen_contents["arr_result"] 	= array ();
			}
			$related_regions = $this->load->view ('user/display_related_class', $this->gen_contents); 
			echo $related_regions;
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
		function _date($time, $course='', $region='', $sub_region=''){
 			//$today 					= date("Y/n/j", time());
			$today 					= date("Y/n/j", strtotime('-8 hour'));
			$data['today']			= $today;
			
			$actual_day				= date("Y/n/j", $time);
			$data['actual_day']	    = $actual_day;
			
			//$actual_month 			= date("n", time());
			$actual_month 			= date("n", strtotime('-8 hour'));
			$data['actual_month'] 	= $actual_month;
			
			$actual_year 			= date("Y", strtotime('-8 hour'));
			$data['actual_year'] 	= $actual_year;
			
			$data['today_timeline']	= mktime(0,0,0,$actual_month,1,$actual_year);
			
			$current_day 			= date("j", $time);
			$data['current_day'] 	= $current_day;
			
			$current_month 			= date("n", $time);
			$data['current_month'] 	= $current_month;
			
			$current_year 			= date("Y", $time);
			$data['current_year'] 	= $current_year;
			
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
                        if(isset($this->gen_contents['course_search']))
				$course_id  = $this->gen_contents['course_search'];
			else
				$course_id	= 0;
                        if(isset($this->gen_contents['chp_search']))
				$chp_id  = $this->gen_contents['chp_search'];
			else
				$chp_id	= 0;
                        $chp_list = $this->config->item('chapter_list');
                        //$data["course_list"] = $this->admin_schedule_model->dbSelectAllCourses();
                        $data["course_list"] = $this->admin_schedule_model->dbGetMonthlyCourses(date('Y/m/d',$first_day_of_month),date('Y/m/d',$last_day_of_month),$course, $region, $sub_region,$chp_id,$chp_list);
                        $data["crse_color"] = $this->config->item('course_color');
                        $data["div_width_crse"] = $this->config->item('course_color_div_width');
			//gets all the list of events for that month	
			$data['events']		= $this->admin_schedule_model->dbGetMonthlyEventDetailsUser(date('Y/m/d',$first_day_of_month),date('Y/m/d',$last_day_of_month),$region_id,$subregion_id,$course_id,$chp_id,$chp_list);
                        $data['events_clr']		= $this->admin_schedule_model->dbGetMonthlyEventDetailsUserclr(date('Y/m/d',$first_day_of_month),date('Y/m/d',$last_day_of_month),$region_id,$subregion_id,$course_id,$chp_id,$chp_list);
                        $data['events_crs']		= $this->admin_schedule_model->dbSelectAllCoursesarr();
                        
                        return $data;
  
 		}
 		/**
 		 * function for getting the next calendar
 		 */
 		function show_next_calendar(){ 
 			$this->gen_contents['region_search'] 	= $_POST['region'];
 			$this->gen_contents['subregion_search'] = $_POST['subregion'];
                        $this->gen_contents['course_search'] = $_POST['course'];
                        if($this->gen_contents['course_search']=='5'){
                            $this->gen_contents['chp_search'] = $_POST['chp'];
                        }
                         $this->gen_contents["chp_list"] = $this->config->item('chapter_list');
                         $this->gen_contents["crse_color"] = $this->config->item('course_color');
 			// we call _date function to get all the details of calendar n its event
			$this->gen_contents = array_merge($this->gen_contents,$this->_date($_POST['timeid'],$_POST['course'],$_POST['region'],$_POST['subregion']));
			
			$this->load->view('user/schedule/schedule_calendar',$this->gen_contents);
 		}
 		/**
 		 * function for getting the next calendar
 		 */
 		
 		/**
		 * function to display the list of events for a particular day
		 */
		function display_list(){
			$this->load->model('admin_schedule_model');
			$this->gen_contents['modal_path'] 	= '/schedule/class_details';
			$this->gen_contents['current_date']	= $_POST['datecurrent'];
                        
                        $chp_list = $this->config->item('chapter_list');
			$this->gen_contents['arr_list'] 	= $this->admin_schedule_model->dbGetEventListWithSearchUser($_POST,$chp_list);
			$this->load->view('user/schedule/display_list_event',$this->gen_contents);
		}
		/**
		 * function used for displaying individual subregions details
		 */
		function class_details() {
			
			$this->load->model('admin_schedule_model');
			$this->gen_contents['image_path'] 		= $this->config->item('image_upload_url').'thumbs/';
			$image_path = $this->config->item('image_upload_path').'thumbs/';
				
			$this->gen_contents['arr_class'] 		= $this->admin_schedule_model->dbGetSingleEventDetails($_POST['masterid']);
			
			$this->gen_contents['dated'] 			= $_POST['currentdate'];
			
			$image = $image_path.$this->gen_contents['arr_class']->image_name;
			
			if($this->gen_contents['arr_class']->image_name && file_exists($image)){
				$this->gen_contents['image_url'] = $this->gen_contents['image_path'].$this->gen_contents['arr_class']->image_name;
			}else{
				$this->gen_contents['image_url'] = $this->config->item('images').'default_image.jpg';
			}
			$this->gen_contents['adhi_course'] = $this->admin_schedule_model->dbSelectSelcCrashCourse();
			$this->load->view('user/schedule/display_schedule_details', $this->gen_contents);
		}

                /**
		 * function used for displaying individual subregions details
		 */
		function cr_sq_details() {
                        $crse_color = $this->config->item('course_color');
                        $svpath=$this->config->item('sq_image_folder').'small_77/';
                        echo $svpath;
                       
                            //create_image_sq("#339900",$svpath);
                            //create_image_sq("#663300",$svpath);
                           //create_image_sq("#CC0000",$svpath);
                           //create_image_sq("#000000",$svpath);
                          //create_image_sq("#9900CC",$svpath);
                         // create_image_sq("#CC0099",$svpath);
                          //  create_image_sq("#FF9900",$svpath);
                       // create_image_sq("#66FF66",$svpath);
                          //  create_image_sq("#FFFF00",$svpath);
                       // create_image_sq("#0000FF",$svpath);

                       // create_image_sq("#EBC1BF",$svpath);
                      //   create_image_sq("#DBDEA4",$svpath);
                         //create_image_sq("#A8D8E8",$svpath);
                        // create_image_sq("#B5F49A",$svpath);
                        // create_image_sq("#E2D289",$svpath);
                        //create_image_sq("#F0FE57",$svpath);
                             //create_image_sq("#E8E2DF",$svpath);
                            // create_image_sq("#F8AB93",$svpath);
                            // create_image_sq("#B68FFF",$svpath);
                             create_image_sq("#FDB6FF",$svpath);



                          
                            print '<img src="'.$this->config->item('sq_image_url').'image.png">';
                            
                        
			
		}
							
	}	
/* End of file schedule.php */
/* Location: ./system/application/controllers/schedule.php */