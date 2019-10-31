<?php

class Course extends Controller 
{

		var $gen_contents = array();
		var $score;
		var $message;
		
		function Course()
		{
			parent::Controller();	
					
                        error_reporting(E_ALL);
                        ini_set("display_errors",1);
			$this->load->helper("form");
			$this->load->model('Common_model');
			$this->load->model('admin_sitepage_model');
			
			$this->gen_contents['css'] = array('style.css','dhtmlgoodies_calendar.css','client_style.css','modalbox.css');
			$this->gen_contents['js'] = array('userdetails.js','popcalendar.js','effects.js','exam_user.js','modalbox.js','quiz_user.js','custom_element.js');
			$this->gen_contents['exam_tracking_id']	= 0;
		}
		
		// function for course listing
		function courselist(){
                    $this->load->model('course_model');	
                    $this->load->model('user_exam_model');
                    $this->load->model('quiz_model');

                    $this->gen_contents['siteurl']	=   $this->admin_sitepage_model->select_sitepages_url();
                    $this->gen_contents['selected_nav']	=   'course';
                    if($this->authentication->logged_in("normal")){

                            $this->session->userdata('EXAMMODEID');
                            $exam_mode=$this->course_model->check_ajaxupdate($this->session->userdata('EXAMMODEID'));

                            if(isset($exam_mode) && $exam_mode){
                                $examtime=convert_UTC_to_PST_timeonly();
                                $exam_time=$examtime-$exam_mode->exam_time;
                                if($exam_time>10){
                                        $this->user_exam_model->update_endexam_status('','',$this->session->userdata('EXAMMODEID'));						

                                        /* Update exam tracking data with user closed the exam browser in-between starts here */
                                        $tracking_id	= $this->session->userdata('TRACKINGID');
                                        if($tracking_id > 0){
                                                $exam_track = $this->user_exam_model->get_exam_tracking($tracking_id);							

                                                $grade	=	$this->user_exam_model->get_grade($exam_track->score);
                                                if($grade)
                                                        $status='P';
                                                else 
                                                        $status='F';

                                                $tracking_data	= array(
                                                                'exam_ended'=> 2, // default value 0, 1 - user clicked end exam, 2 - user closed browser in between
                                                                'ended_at' 	=> convert_UTC_to_PST_datetime(date('m/d/Y H:i:s')),
                                                                'status' 	=> $status						
                                                                );
                                                $this->user_exam_model->update_exam_tracking($tracking_id, $tracking_data);

                                                $this->user_exam_model->modifyCourseReenrollStatus($this->session->userdata('USERID'), $exam_track->course_id);
                                        }
                                        /* Update exam tracking data with user closed the exam browser in-between ends here */


                                        $session_items			  =	array('EXAMMODEID'=>'','QUESTIONS'=>'','ANSWER'=>'','ANSWERID'=>'','TIMEEND'=>'','COURSENAME'=>'', 'TRACKINGID' => '');
                                        $this->session->unset_userdata($session_items);

                                }
                        }

                        if( $this->session->userdata('USERID')>0 && !$this->session->userdata('EXAMMODEID')){
                                $this->_update_score_in_maintable();
                        }
                        //echo $this->session->userdata('QUIZMODEID');
                        $quiz_mode=$this->quiz_model->check_ajaxupdate_quiz($this->session->userdata('QUIZMODEID'));


                        if(isset($quiz_mode) && $quiz_mode){
                        $examtime=convert_UTC_to_PST_timeonly();
                                $exam_time=$examtime-$quiz_mode->quiz_time;
                                if($exam_time>5){

                                        $this->quiz_model->update_endquiz_status('','',$this->session->userdata('QUIZMODEID'));

                                        $session_items						=	array('QUIZMODEID'=>'');
                                        $this->session->unset_userdata($session_items);
                                }
                        }

                        $this->gen_contents['userid']=$this->session->userdata('USERID');	
                        $this->load->helper("form");	
                        $this->gen_contents['courselist']=$this->course_model->get_examlist($this->session->userdata('USERID'));

                        $license= $this->course_model->get_license($this->session->userdata('USERID'));
                        $course_user_type= $this->course_model->get_user_course_types($this->session->userdata('USERID'));

                        /* Get new package for sales*/
                        $package_type= $this->course_model->get_user_package_type($this->session->userdata('USERID'));

                        if($course_user_type==1 || $course_user_type==3 || (($course_user_type==5 || $course_user_type==7) && $package_type!=1)) {
                            $this->gen_contents['add_status'] = false;
                        }else{
                            $this->gen_contents['add_status']= $this->course_model->check_addcourse($this->session->userdata('USERID'),$license,$course_user_type,$package_type);
                        }
                        $this->gen_contents['passedcourselist']=$this->course_model->get_passed_courselist($this->session->userdata('USERID'));


                       // $this->load->view("client_common_header_new",$this->gen_contents);
                        //$this->load->view('exam/courselist_new',$this->gen_contents);
                        //$this->load->view("client_common_footer_new");
                        
                        $this->_profile_progress();

					    $this->load->model('user_exam_model');

                        $this->gen_contents['course_reenroll_status']=$this->_make_reenroll_course_status();
                        
                        $this->template->set_template('user');
                        $this->template->write_view('content', 'reskin/course/list', $this->gen_contents);
                        $this->template->render();
                    }
                    else{
                        redirect("home");
                    }
	
		}
		function _make_reenroll_course_status(){
			$button_status	= array(
					5 => 0,
					6 => 0,
					7 => 0,
					8 => 0,
					9 => 0,
					10 => 0,
					11 => 0,
					12 => 0,
				);
			/*if(FALSE !== array_search($this->session->userdata ('USERID'), c('student_test_accounts'))){*/
				$user_id = $this->session->userdata ('USERID');
				foreach ($button_status as $course_id => $status) {
					/*$exam_count = $this->user_exam_model->getExamCount($user_id, $course_id);
					if($exam_count >= 2){
						$button_status[$course_id]	= 1;
					}*/

                    $need_reenroll = $this->user_exam_model->getCourseReenrollStatus($user_id, $course_id);
                    //echo $course_id.' --> '.$need_reenroll.'<br/>';
                    if(1 == $need_reenroll){
                        $button_status[$course_id]	= 1;
                    }
				}
				/*$button_status	= array(
					5 => 1,
					6 => 0,
					7 => 1,
					8 => 0,
					9 => 0,
					10 => 0,
					11 => 0,
					12 => 2,
				);*/
			/*}*/
			//exit;
			return $button_status;
		}

		/**
		 * function to show the confirm password box
		 */
		function confirm_go(){
			$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();
			if(!$this->authentication->logged_in("normal")){
				redirect('home');
			}
			$this->load->model('user_exam_model');
			
			$usercourse		=	$this->uri->segment(3);
			$course_id		=	$this->uri->segment(4);			
			$userid			=	$this->session->userdata ('USERID');
			$edition = get_user_edition($course_id, $this->session->userdata ( 'USERID' ) );
			$examlist = $this->user_exam_model->getquestionid ( $course_id,$edition);
			if (count($examlist)==0){
				$this->session->set_flashdata ('msg',"Admin has not uploaded questions into this course");
                                $msg = 'Edition update required. Please contact administrator.';
				$this->session->set_userdata ('msg',$msg);
				redirect('course/courselist');
			}
			$exam_mode		=	$this->user_exam_model->already_exam_mode($userid);

			if($usercourse && (!$exam_mode)){
				
				$this->session->set_userdata ('USERCOURSE',$usercourse);
				
				redirect('course/confirm_password/');
			}else {
				//$this->session->set_flashdata('msg', 'Already in Exam');
				$msg = 'Already in Exam';
				$this->session->set_userdata ('msg',$msg);
				redirect('course/courselist');
			}
			
		}
	/**
	 * function to show the confirm password box
	 */
	function confirm_password()
	{
		$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();
		
		if(!$this->authentication->logged_in("normal")){
			redirect('home');
		}
		
		$this->load->model('user_exam_model');
		
		$userid = $this->session->userdata ('USERID');
		$exam_mode = $this->user_exam_model->already_exam_mode($userid);
		
		if($this->session->userdata ('USERCOURSE') && (!$exam_mode)) {
			//if(!empty($_POST)) {
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				$this->load->library('form_validation');
				$this->form_validation->set_rules ('txt_password', 'Password', 'required');
                                $this->load->model('user_model');
                                $userid             = $this->session->userdata ('USERID');
                                $driving_license    = $this->user_model->getDrivingLicense($userid);
                                if('' != $driving_license){
                                    $this->form_validation->set_rules ('txt_driving_license', 'Drivers License Number', 'required|max_length[20]');
                                }
				
				if(!$this->form_validation->run() == FALSE) {// form validation
					if('' != $_POST['txt_password']){
						$this->_init_confirm_password_details();
						
						if($this->user_model->confirm_password(md5($this->txt_password),$userid)){
                                                        //3-jan-2017 Added new checking
                                                        $driving_license_checking   = true;                                                        
                                                        if('' != $driving_license && !validate_crypt(trim($this->input->post('txt_driving_license')), $driving_license)){
                                                                $driving_license_checking   = false;                                                                
                                                                $this->session->set_flashdata('error', 'Please enter your correct Drivers License Number');
                                                        }
                                                        if($driving_license_checking){
                                                            $this->session->set_userdata ('TIMEEND','');
                                                            redirect('course/exam_rule');
                                                        }
						} else {
							$this->session->set_flashdata('error', 'Please enter your correct  Password');
						}
					}
					redirect('course/confirm_password');
				}
			}
			//$this->load->view("client_common_header_new",$this->gen_contents);	
			//$this->load->view('exam/exam_confirm',$this->gen_contents);
			//$this->load->view("client_common_footer_new");	
				
			$this->template->set_template('user');
            $this->template->write_view('content', 'reskin/course/exam_confirm', $this->gen_contents);
            $this->template->render();
		} else {
			redirect('course/courselist');
		}
	}
			
		/**
		 * get the values from the POST and Input it into safe_html
		 *
		 */
		function _init_confirm_password_details() {
			
			$this->txt_password = $this->Common_model->safe_html($this->input->post("txt_password"));
		}	
		
		/**
		 * get the values from the POST and Input it into safe_html
		 *
		 */
		function exam_rule() { 
			$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();
			if(!$this->authentication->logged_in("normal")){
				redirect('home');
			}
			$this->load->model('user_exam_model');
			$usercourseid					=	$this->session->userdata ('USERCOURSE');
			$data							=	$this->user_exam_model->get_course ($usercourseid);
			$this->gen_contents['subject']	=	$data[0]['course_name'];
			$userid							=	$this->session->userdata ('USERID');
			$exam_mode						=	$this->user_exam_model->already_exam_mode($userid);
			
			$this->gen_contents['page_title']	=	"Exam Rules";
			$this->gen_contents['pageid']		=	'7';
			$this->gen_contents['pagedetails']	=	$this->admin_sitepage_model->select_single_sitepage_det($this->gen_contents['pageid']);
			
			
			if(isset($_POST['poptry']) && $_POST['poptry']==1)
			     $this->gen_contents['poptry']='1';

			if(!$exam_mode && $this->session->userdata ('USERCOURSE')){
			 //$this->gen_contents['js'][]   =   "exam_new.js";
				//$this->load->view("client_common_header_new",$this->gen_contents);	
				//$this->load->view('exam/exam_rule',$this->gen_contents);
				//$this->load->view("client_common_footer_new");
				
				$this->template->set_template('user');
            	$this->template->write_view('content', 'reskin/course/exam_rule', $this->gen_contents);
            	$this->template->render();	
			}else
				redirect('course/courselist');
			
		}
		
		function check(){
		$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();
			$this->load->view("client_common_header",$this->gen_contents);	
				$this->load->view('exam/exam_check',$this->gen_contents);
				$this->load->view("client_common_footer");	
		
		}
		/**
		 * Exam start
		 *
		 */
		function exam_start() 
		{
			$this->load->model('user_exam_model');
			$usercourseid =	$this->session->userdata ('USERCOURSE');
			$this->gen_contents['css'] = array('style.css','client_style.css');
			//$this->gen_contents['js'] = array('exam_user.js','quiz_user.js');
			$this->gen_contents['js'] = array('exam_user.js');
			
			$data =	$this->user_exam_model->get_course($usercourseid);
			
			//checks if the exam is disalbed
			if($data[0]['exam_status']!='D'){
			    $attempt_count_reenroll = $data[0]['attempt_count_reenroll'];
				$this->gen_contents['siteurl'] = $this->admin_sitepage_model->select_sitepages_url();
				
				if(!$this->authentication->logged_in("normal")){
					redirect('course/exam_error/2');
				}
				
				if(isset($_POST) && $this->session->userdata ('ANSWERID')){
					redirect('course/exam_error/1');
				}
				
				$time_end_status = $this->session->userdata ('TIMEEND');
				///if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']){
				if(!$time_end_status){
					//$logmsg	="User ID".$this->session->userdata ('USERID').' start  to write exam of course '.$usercourseid;
					//common_log_message('start',$logmsg,'exam');
					$this->gen_contents['js'] = array_merge($this->gen_contents['js'],array('json.js'));
					
					$session_items = array('QUESTIONS'=>'','ANSWER'=>'','ANSWERID'=>'','TIMEEND'=>'','COURSENAME'=>'');
					$this->session->unset_userdata($session_items);
					$this->session->set_userdata ('EXAMUNIQUE',1);
					
					$userid = $this->session->userdata ('USERID');
					$exam_mode = $this->user_exam_model->already_exam_mode($userid);
					
					if($usercourseid){
					 
						$this->session->set_userdata('COURSEID',$data[0]['id']);
						$this->session->set_userdata('COURSENAME',$data[0]['course_name']);
						
						$userid			=	$this->session->userdata ('USERID');
						$edition = get_user_edition($data[0]['id'], $this->session->userdata ( 'USERID' ) );


                        $this->user_exam_model->archiveOldExamTracking($userid, $data[0]['id']);

                        $distinct_question_ids = array();
						$distinct_question_enabled_courses = c('distinct_question_enabled_courses');

						if(FALSE !== array_search($data[0]['id'], $distinct_question_enabled_courses)){
                            //Implementing the question set  - student fails a final examination, second set of questions distinct from the first that will display in the event that student fails exam.
                            $distinct_question_ids = $this->user_exam_model->distinctQuestionIds($userid, $data[0]['id'], $edition);
                        }

                        $question_all =	$this->user_exam_model->getquestionid($data[0]['id'],$edition, $distinct_question_ids, FALSE);

						//If admin updates new question set, the system will removed the old question data, so the distinct question scenario
                        //will not work, so we need to choose 100 question newly. Also need to remove previous course exam tracking

                        if(count($distinct_question_ids) > 0 && count($question_all) < 100 ){
                            $question_all =	$this->user_exam_model->getquestionid($data[0]['id'],$edition, array(), FALSE);
                            /*$this->user_exam_model->archiveOldExamTracking($userid, $data[0]['id']);
                            $this->user_exam_model->deleteUserAttendedDetails($userid, $data[0]['id']);*/
                        }

						/*if(count($distinct_question_ids) > 0 && count($question_all) < 100 ){
                            $question_all =	$this->user_exam_model->getquestionid($data[0]['id'],$edition, array(), FALSE);
                            $this->user_exam_model->archiveOldExamTracking($userid, $data[0]['id']);
                            $this->user_exam_model->deleteUserAttendedDetails($userid, $data[0]['id']);
                        }*/
                        //echo '<pre>';print_r(array_column($question_all, 'id'));exit;
                        /*if(10137 == s('USERID')){echo ' count = '.count($question_all).'<pre>';print_r(array_column($question_all, 'id'));echo '</pre><br/>';}*/
                        #code used to create JSON array
						/***********************/
						
						$arr_exam 		= array();
						$question		= array();
						$r 				= 0;
						/* since a json will consider an php array as an object only if the starting key value is 1*/
						//gets the questions and its id
						
						//For exam tracking score update storing questionid - answerid
						$question_answer	= array();
						
						foreach ($question_all as $key){
							$question_answer[$key['id']]	= $key['ansid'];
							if(0==$r){
								$arr_exam['questionid'][1] 	= $key['id'];
								$arr_exam['question'][1] 	= strip_tags(stripslashes($key['question']));
								$question[1]				= array('id'=>$key['id'],'ansid'=>$key['ansid']);
								$r++;
							}else{
								$arr_exam['questionid'][] 	= $key['id'];
								$arr_exam['question'][] 	= strip_tags(stripslashes($key['question']));
								$question[]					= array('id'=>$key['id'],'ansid'=>$key['ansid']);
							}
						}
						/* collection of questions is ppased to get the answer options from the table*/
						$arr_answers			= $this->user_exam_model->fncGetQuestionsOptions ($arr_exam['questionid']);
						$arr_exam['optionid']	= array();
						/* gets the options and its id*/
						foreach ($arr_answers as $answer){
							
							$main_key = array_search($answer->question_id,$arr_exam['questionid']);
							if(@is_array($arr_exam['optionid'][$main_key])){
								$arr_exam['optionid'][$main_key][] 	= $answer->answer_id;
								$arr_exam['option'][$main_key][] 	= strip_tags(stripslashes($answer->answers));
							}else{
								$arr_exam['optionid'][$main_key][1] = $answer->answer_id;
								$arr_exam['option'][$main_key][1] 	= strip_tags(stripslashes($answer->answers));
							}
						}
							
						ksort($arr_exam['optionid']);
						ksort($arr_exam['option']);
						
						$arr_exam['counter'] = 1; //counter set to one which is used to point to the question
						//$arr_exam['total'] 		=  100;//total no of questions
						$arr_exam['total'] = count($question_all); //total no of questions
						$arr_exam['navigation'] = 1; // navigation used for store visited question count, default 1
						
						// Passing total question count to view
						$this->gen_contents['totalQuestions'] = $arr_exam['total'];
						
						$arr_exam['answer'] = array(1=>'');
                                                                                                                                                
                                                $this->gen_contents['arr_exam'] = $arr_exam;
                                                
						/* exam array is encode to jason with questionid,question,options,optionid */
						$this->gen_contents['json_array'] = json_encode($arr_exam);
						
						/**********************/
												
						$thistime					=	convert_UTC_to_PST_timeonly();
						$timeend					=	$thistime+9000;
						//$timeend					=	$thistime+(30*60);
						
						$this->session->set_userdata ('TIMEEND',$timeend);
						
						if(FALSE === array_search($this->session->userdata ('USERID'), c('regulator_test_accounts'))){
							$this->user_exam_model->change_effective_date($userid , $usercourseid ,'othercourse');
							$this->user_exam_model->change_effective_date($userid,$usercourseid,'samecourse');
						}
						
						$this->session->set_userdata ('QUESTIONS',$question);
						$this->session->set_userdata('start', '1');
						$this->session->set_userdata('end', '1');
						
						
						/* Delete exam tracking details starts here */
						//$this->user_exam_model->deleteUserAttendedDetails($userid, $data[0]['id']);
						/* Delete exam tracking details ends s here */

						/**
                         * Making all exam tracking as past (is_latest = false)
                         * For implementing distinct question feature.
                         * */
                        $this->user_exam_model->makeUserAttendedExamsPast($userid, $data[0]['id']);
						
						//Exam tracking - insertion - starts here
						$current_datetime	= convert_UTC_to_PST_datetime(date('m/d/Y H:i:s'));
						$will_end_datetime	= convert_UTC_to_PST_datetime(date('m/d/Y H:i:s', strtotime('+9000 seconds')));						
						$tracking_data	= array(
												'course_id'			=> $data[0]['id'],
												'user_id'			=> $userid,
												'started_at'		=> $current_datetime,
												'will_end_at'		=> $will_end_datetime,
												'exam_ended'		=> 0, // default value 0, 1 - user clicked end exam, 2 - user closed browser in between
												'total_question'	=> count($question_all),
												'ordered_question_ids'	=> json_encode($arr_exam['questionid']),
												'attended_details'	=> json_encode( array($question[1]['id'] => array('created_at'=> $current_datetime, 'online' => 1)) ),
												'score'				=> 0,
												'updated_at'		=> $current_datetime,
												'status'			=> 'O', // ongoing
												'ip'				=> $this->input->ip_address(),
												'user_agent'		=> $this->input->user_agent()
										);
						$exam_tracking_id	= $this->user_exam_model->start_exam_tracking($tracking_data);

						$logData    = array(
						    'user_id'           => $userid,
                            'course_id'         => $data[0]['id'],
                            'edition_id'        => $edition,
                            'exam_start_time'   => $current_datetime
                        );
                        $this->user_exam_model->logExamAndChangeAttemptCount($logData, $attempt_count_reenroll);

						$this->gen_contents['exam_tracking_id']	= $exam_tracking_id;
						$this->session->set_userdata ('TRACKINGID', $exam_tracking_id);
						
						$this->session->set_userdata ('QUESTIONANSWER', $question_answer);
						//Exam tracking - insertion - ends here
						
						//Score update to 0 and status to F in main table
						$this->_update_main_score($userid, $data[0]['id'], 0);
						
						$this->examination();
						
						//redirect('exam/examination');
					}else {
						//$logmsg	="User ID".$this->session->userdata ('USERID').' lost courseid from session ';
						//$this->_log_error_keep($logmsg);
						redirect('course/exam_error/3');
					}
				}else{
					//$logmsg	="User ID".$this->session->userdata ('USERID').' tried to refresh  course '.$usercourseid;
					//$this->_log_error_keep($logmsg);
					
					redirect('course/exam_error/1');
				}
			}else{
				//$logmsg	="User ID".$this->session->userdata ('USERID').'admin disabled  course '.$usercourseid;
				//$this->_log_error_keep($logmsg);
				redirect('course/exam_error/4');
			}
			
		}
		
		function examination(){
			//if($_POST['unique_page']==$this->uri->segment(4)){
			if(!$this->authentication->logged_in("normal")){
				redirect('course/exam_error/2');
			}
			if(($this->session->userdata('start') || $_POST) && $this->session->userdata('end')){
				$this->load->model('user_exam_model');
				$sess_ques							=	$this->session->userdata ('QUESTIONS');
				$sess_ans							=	$this->session->userdata ('ANSWER'); 
				
				$this->gen_contents['count_ques']		=	count($sess_ques);
				
				$que_no	=	$this->uri->segment(4);
				$action	=	$this->uri->segment(3);
				//$this->_init_examination_details();
				if(empty($que_no))$que_no=1;
				if($que_no<=count($sess_ques)){
				
					$this->gen_contents['que_no']		= $que_no;
					//$this->gen_contents['ques_ans']		= $this->user_exam_model->getquestion_ans ($sess_ques[$que_no]['id']);
                                        /* Fix for 1st question options jumbling */
                                        $arr_exam   = $this->gen_contents['arr_exam'];
                                        $this->gen_contents['ques_ans'] = array('question' => $arr_exam['question'][$que_no], 'options' => $arr_exam['option'][$que_no]);
                                        
                                        
					$timeend							=	$this->session->userdata ('TIMEEND');
					//$thistime							=	convert_UTC_to_PST_timeonly();
					$now								=	convert_UTC_to_PST_timeonly();
					//$this->gen_contents['time_rem']	= 	$timeend - $now;
	
					$cur								= 	$timeend - $now;
					if($cur==9000)
						$cur=8999;
					$second								=	$cur%60;
					if($second==0)
						$second=60;
						
					$this->gen_contents['sec']			=   $second;
					$this->gen_contents['minute']		=	floor($cur/60);
					
					$this->load->view("exam/exam_header",$this->gen_contents);	
					$this->load->view('exam/exam_page');
					$this->load->view("exam/exam_footer");
				
				}
				else 
					redirect('course/exam_end');
				
				}else 
					redirect('course/exam_error/1');
			/*}else 
				redirect('profile');*/
	
		}
		/**
		 * get the values from the POST and Input it into safe_html
		 *
		 */
		function _init_examination_details() {
			
			$this->right_ans = $this->input->post("right_ans");
		}
		/**
		 * function which is invoked by ajax call, that is used to calculate and update the score
		 *
		 */
		function update_score(){
			
			$this->load->model('user_exam_model');
			
			/** notneed **********************************************
			$decoded 		= json_decode($_POST['jsonarray'], true);
			$arr_questions	= $this->session->userdata ('QUESTIONS'); 
			$cnt 			= 1;
			$score			= 0;
			$answerid		= $this->session->userdata ('ANSWERID');			
			foreach($arr_questions as $questions){
				// gets each questions from session and checks if the question is answered.
				if(isset($decoded['answer'][$cnt]) && !empty($decoded['answer'][$cnt])){
					$key 			= $decoded['answer'][$cnt];
					$user_answer 	= $decoded['optionid'][$cnt][$key];
					if($user_answer == $arr_questions[$cnt]['ansid']){
						$score++;
					}
				}
				$cnt++;
			}
			$this->score = $score;
			if(0!=$score && ''==$answerid){ //if the score is calculated for the first time an entry is made in the table
				//notneed
				$this->insert_score();
			}else{
				//notneed
				//$this->user_exam_model->update_score_status($answerid,$this->score);// updates teh score
			}
			//if first question is not answered the null insertion is removed
			if($decoded['answer'][1]=='' && (count($decoded['answer'])==1))
				return;
			$this->session->set_userdata ('ANSWER',$decoded['answer']);
			********************************/			
			
			
			/* Exam tracking at the end of the exam( after clicking last question) */
			if(isset($_POST['exam_tracking_id']) && $_POST['exam_tracking_id'] > 0){
				$this->_update_tracking_details($_POST);
                                echo 'true';
			}
			
			$decoded 		= json_decode($_POST['jsonarray'], true);
			//if first question is not answered the null insertion is removed
			if($decoded['answer'][1]=='' && (count($decoded['answer'])==1))
				return;
			$this->session->set_userdata ('ANSWER',$decoded['answer']);
			
		}
		/**
		 * function used to insert score in the exam sub table
		 *
		 */
		
		
		/* not need */
		/*		
		function insert_score(){
			
			$course_id		=	$this->session->userdata ('COURSEID');
			$usercourse_id	=	$this->session->userdata ('USERCOURSE');
			$userid			=	$this->session->userdata ('USERID');
			$ans_id			=	$this->user_exam_model->insert_score($course_id,$usercourse_id,$userid,$this->score);
			$this->session->set_userdata ('ANSWERID',$ans_id);
			
		}
		*/
		
		
		/**
		 * function used to display the exam results
		 *
		 */
		function exam_end(){
			if(!$this->authentication->logged_in("normal")){
				redirect('home');
			}
			
			//$logmsg	="User ID".$this->session->userdata ('USERID').' ends exam of course '.$usercourseid;
			//common_log_message('start',$logmsg,'exam');
			
			$score_id									=	$this->session->userdata ('ANSWERID');
			$this->gen_contents['siteurl']				=	$this->admin_sitepage_model->select_sitepages_url();
			$this->load->model('user_exam_model');
			$this->gen_contents['course_id']			=	$this->session->userdata ('COURSEID');
			$user_id									=	$this->session->userdata ('USERID');
			
            /* Added by Syama to avoid direct url access to exam end - Starts */
            if($this->gen_contents['course_id'] == ''){
                redirect('course/exam_error/1');
            }
            /* Ends */
                                                
			if($this->session->userdata('end')){//first time the score getting from the user_exam_details table 
				
				$this->load->model('course_model');	
				
				//notneed
				//$score									=	$this->user_exam_model->get_score($score_id);
				
				
				$this->user_exam_model->updateuserstatus($user_id,'N');
				$this->user_exam_model->update_endexam_status($user_id,$this->gen_contents['course_id']);
				
				//notneed
				//$this->course_model->delete_record ($score_id);
				
			}else{
				
				//notneed
				//$score									=	$this->user_exam_model->get_score_user($this->session->userdata ('USERCOURSE'));
			}
                        
                        $user_course_id								=	$this->session->userdata ('USERCOURSE');
                        
                        
			$user_course_id								=	$this->session->userdata ('USERCOURSE');
			
			/*
			// OLD CODE COMMENTING ; NOW THE RESULT PAGE DATA FROM EXAM TRACKING
			
			if($this->session->userdata ('QUESTIONS'))
				$this->gen_contents['total']			=	count($this->session->userdata ('QUESTIONS'));
			else 	
				$this->gen_contents['total']			=	0;
			
			if($this->session->userdata ('ANSWER'))
				$this->gen_contents['attended_que']		=	count($this->session->userdata ('ANSWER'));
			else 
				$this->gen_contents['attended_que']		=	0;
				
			
			$user_course_id								=	$this->session->userdata ('USERCOURSE');
			//$score										=	$this->user_exam_model->get_score($score_id);
			
			$this->gen_contents['not_attend_count'] 	=	(int)$this->gen_contents['total']-(int)$this->gen_contents['attended_que'];
			
			if(isset($score) && $score!='')
				$this->gen_contents['right_count']		=	$score[0]->exam_score;
			else 
				$this->gen_contents['right_count']		=	0;
				
			$this->gen_contents['wrong_count']			=	$this->gen_contents['attended_que']	- $this->gen_contents['right_count'];
			$this->gen_contents['grade']				=	$this->user_exam_model->get_grade($this->gen_contents['right_count']);
			
			if($this->gen_contents['grade']) $status='P';else $status='F';
			*/
			
			
			/* Showing all consoldated exam result from Exam tracking data starts here */
			$courseid 			= $this->gen_contents['course_id'];
			$user_exam_details	= $this->user_exam_model->getUserAttendedDetails($user_id, $courseid);
			$this->gen_contents['data_exam_completed'] = date("m/d/Y",$this->session->userdata('TIMEEND'));
                        
            $data_exam =	$this->user_exam_model->get_course($this->session->userdata ('COURSEID'));

            //Get Course name
            $this->load->model('common_model');
            $course_name = $this->common_model->select('adhi_courses','course_name',array("id"=> $this->session->userdata ('COURSEID')));


            $this->gen_contents['data_exam'] = $course_name;
            $data_exam_completed = $this->gen_contents['data_exam_completed'] ;
                        
                        
                        
			$right_answer_count	= 0;
			$wrong_answer_count	= 0;
			$not_answered_count	= 0;
			if($user_exam_details){				
				$attended_details	= json_decode($user_exam_details->attended_details, true);
                $ordered_question_ids	= json_decode($user_exam_details->ordered_question_ids, true);
				$edition = get_user_edition($courseid, $user_id );
				$question_all		= $this->user_exam_model->getquestionid($courseid,$edition, $ordered_question_ids, FALSE);
				foreach ($question_all as $question){
					if(isset($attended_details[$question['id']]['option_id']) && $attended_details[$question['id']]['option_id'] > 0){
						if($question['ansid'] == $attended_details[$question['id']]['option_id']){
							$right_answer_count++;
						}else{
							$wrong_answer_count++;
						}
					}else{
						$not_answered_count++;
					}
				}
			}
			
			$this->gen_contents['total']			= count($question_all);
			$this->gen_contents['attended_que']		= 0;
			$this->gen_contents['not_attend_count']	= $not_answered_count;
			$this->gen_contents['right_count']		= $right_answer_count;
			$this->gen_contents['wrong_count']		= $wrong_answer_count;
			$this->gen_contents['grade']			= $this->user_exam_model->get_grade($right_answer_count);
			
			if($this->gen_contents['grade']) $status='P';else $status='F';
			
			/* Showing all consoldated exam result from Exam tracking data ends here */
			
			
			
			
			
			if($this->session->userdata('end')){
				$this->user_exam_model->update_user_score($user_course_id,$this->gen_contents['right_count'], $status);
                $this->user_exam_model->modifyCourseReenrollStatus($user_id, $courseid);
			}
			
			
			
			/* Update exam tracking data starts here */
			$tracking_id	= $this->session->userdata('TRACKINGID');
			$tracking_data	= array(
					'exam_ended' => 1, // default value 0, 1 - user clicked end exam, 2 - user closed browser in between
					'ended_at' => convert_UTC_to_PST_datetime(date('m/d/Y H:i:s')), 
					'status' => $status
					);
			$this->user_exam_model->update_exam_tracking($tracking_id, $tracking_data);			
			/* Update exam tracking data ends here */
            $need_reenroll                          = $this->user_exam_model->getCourseReenrollStatus($user_id, $courseid);
            $this->gen_contents['need_reenroll']    = $need_reenroll;

            $reenroll_message = '';
            if(1 == $need_reenroll){
                //$reenroll_message = '<div style="padding: 5px 15px; color: #0fd98f;border:1px solid #0fd98f;">Please call office at 888 7685285 to reregister for course</div>';
                $reenroll_message = '<div style="padding: 5px 15px; color: #0fd98f;border:1px solid #0fd98f;">You should re-enroll the course since you failed to pass the exam 2 times.</div>';
            }
            $this->gen_contents['reenroll_message']    = $reenroll_message;
			
			$session_items						=	array('EXAMMODEID'=>'','ANSWERID'=>'','COURSENAME'=>'', 'TRACKINGID' => '');
			$this->session->set_userdata('end', '');
			
			$this->session->unset_userdata($session_items);
			
			$this->load->view("exam/exam_header_result",$this->gen_contents);	
			$this->load->view('exam/exam_end',$this->gen_contents);
			$this->load->view("exam/exam_footer_result");


                        
                         //Sent Email
                        $this->load->model('Common_model');
                        $total = $this->gen_contents['total']?$this->gen_contents['total']:0;
                        $right_count = $this->gen_contents['right_count']?$this->gen_contents['right_count']:0;
                        $wrong_count = $this->gen_contents['wrong_count']?$this->gen_contents['wrong_count']:0;
                        $not_attend_count = $this->gen_contents['not_attend_count']?$this->gen_contents['not_attend_count']:0;
                        $grade = $this->gen_contents['grade']?$this->gen_contents['grade']:"Failed";
                        $data_exam_completed = $this->gen_contents['data_exam_completed'] ;
                        
                        $toemail= $this->session->userdata('EMAIL');
                        //$toemail = "perumal.m@rainconcert.in";
                        $subject=$course_name[0]['course_name']. ' examination result';
                        $from = "";
                        $contents		= '';
                        $contents		= 'Dear '.$this->session->userdata('USER_NAME')." ".$this->session->userdata('LAST_NAME').",<br><br>";
                        $contents		.= '<table  cellspacing="0" cellpadding="0" border="0" class="exam-success-table" width="673">
                                    <tr>
                                        <td>';
                         if($this->gen_contents['grade']) { 
                         $contents	 .= '<img src="'.$this->config->item('images').'result/pass/success_banner.png" width="673" height="55" />';
                                            } else {
                           $contents	 .= '<table cellpadding="0" cellspacing="0" >
                                                <tr>
                                                    <td height="53">
                                                        <img style="float:left" border="0" height="53" src="'.$this->config->item('images').'result/fail/failleft.png"  />
                                                    </td>
                                                    <td width="90%" align="top" height="53">
                                                        <table cellpadding="0" cellspacing="0" width="100%">
                                                            <tr>
                                                                <td valign="middle"  width="100%" style="background-color: #CC3336;line-height:41px;margin:0px;padding:0px;color:#FFFFFF;text-align: left;font-weight:bold;vertical-align: middle;">
                                                                    Sorry. You only answered '." ".$right_count.' questions correctly
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td valign="top"  height="53">
                                                        <img  style="float:left" border="0" height="53" src="'. $this->config->item('images').'result/fail/fail_right.png"  />
                                                    </td>
                                                </tr>
                                            </table>';
                             } 
                             $contents	 .= '</td>
                                    </tr>
                                    
                                    <tr>
                                        <td style="border-right:1px solid #ECECEC;border-left:1px solid #ECECEC">
                                            <table width="100%" cellspacing="0" cellpadding="6" border="0" >
                                                <tr>
                                                    <td width="18%" style="color:#6E6E6E;">Name </td>
                                                    <td width="1%"> : </td>
                                                    <td width="35%">'.$this->session->userdata('USER_NAME')." ".$this->session->userdata('LAST_NAME').'</td>
                                                    <td width="10%" style="color:#6E6E6E;">Score </td>
                                                    <td width="1%"> : </td>
                                                    <td >'.$right_count.'</td>
                                                </tr>
                                                <tr>
                                                    <td width="18%" style="color:#6E6E6E;">Course :</td>
                                                    <td width="1%"> : </td>
                                                    <td width="35%">'.$course_name[0]['course_name'].'</td>
                                                    <td width="10%" style="color:#6E6E6E;">Status </td>
                                                    <td width="1%"> : </td>
                                                    <td>';
                             if($this->gen_contents['grade']){
                                 $contents	 .= "<span style='color:#ABB95E'><b>Passed</b></span>";
                             } else {
                                 $contents	 .= "<span style='color:#FF0000'><b>Failed</b></span>";
                             }
                              $contents	 .= '</td>
                                                </tr>
                                                <tr>
                                                    <td width="18%" style="color:#6E6E6E;">Date attended</td>
                                                     <td width="1%"> : </td>
                                                    <td width="35%">'.$data_exam_completed.'</td>
                                                        <td colspan="3">'.$reenroll_message.'</td>
                                                </tr>
                                                <tr><td colspan="6">&nbsp;</td></tr>
                                            </table>
                                            
                                            <table  width="100%" cellspacing="0" cellpadding="6" border="0">
                                                <tr>
                                                    <td width="45%" style="color:#6E6E6E;">Number of Questions & Answers </td>
                                                    <td width="1%"> : </td>
                                                    <td style="color:#6E6E6E;">'.$total.'</td>
                                                    <td rowspan="4" align="right" width="69%">';
                                              if($this->gen_contents['grade']){ 
                                              $contents	 .= '<img style="float:right;" src="'.$this->config->item('images').'result/pass/results_08.png" width="155" height="135" />';
                                                       } 
                                              else { 
                                              $contents	 .= '&nbsp;';
                                              
                                              } 
                                              $contents	 .=  '</td>
                                                </tr>
                                                <tr>
                                                    <td width="45%" style="color:#6E6E6E;">Number of Right Answers </td>
                                                    <td width="1%"> : </td>
                                                    <td style="color:#6E6E6E;">'.$right_count.'</td>
                                                </tr>
                                                <tr>
                                                    <td width="45%" style="color:#6E6E6E;">Number of Wrong Answers</td>
                                                    <td width="1%"> : </td>
                                                    <td style="color:#6E6E6E;">'.$wrong_count.'</td>
                                                </tr>
                                                <tr>
                                                    <td width="45% " style="color:#6E6E6E;">Number of Unanswered Questions</td>
                                                    <td width="1%"> : </td>
                                                    <td style="color:#6E6E6E;">'.$not_attend_count.'</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>';
                                              
                                    if($this->gen_contents['grade']){ 
                                        $contents	 .=  '<tr>
                                            <td class="success-table-data" style="color:red;font-size:12px; padding:20px 5px;border-right:1px solid #ECECEC;border-left:1px solid #ECECEC">
                                                <div style="float:left;width:5%"> <b><u>Note</u></b> :</div>
                                                <div>
                                                    This is not your official certificate. Please download this from your profile.  Do not submit this image to the state.
                                                </div>
                                            </td>
                                        </tr>';
                                    }
                                    
                                    
                                    $contents	 .=  '<tr>
                                        <td>
                                            <img src="'.$this->config->item('images').'result/pass/results_10.png" width="673" height="45" />
                                        </td>
                                    </tr>
                                </table>';
                        $sent_result = $this->common_model->select('adhi_user','sent_result',array("id"=>  $this->session->userdata ('USERID')));
                        //if($sent_result[0]['sent_result'] == 0)
                        //{    
                            //echo "Yes";
                            $mail = $this->Common_model->send_mail($toemail,$from,$subject,$contents);
                            
                            if($mail)
                            {
                                $this->Common_model->update('adhi_user', array('sent_result'=> '1'),array("id"=> $this->session->userdata ('USERID')));
                                //echo "Mail sent successfully";
                            }
                            else
                            {
                                //echo "Not sent";
                            }
                        //}
                        //else
                        //{
                            //echo "no";
                       // }

		}
		
		function pdf_create(){
			$arr['userid']= $this->session->userdata('USERID');
			$arr['courseid']= $this->uri->segment(3);
			$this->load->model('user_exam_model');		
			$this->user_exam_model->create_pdf($arr);	
		}
		
                function pdf_createadmin(){
			$arr['userid']= $this->uri->segment(4);
                        $this->load->model('user_exam_model');
                        $nam =	$this->user_exam_model->get_user_cert($this->uri->segment(4));
                        $unam= $nam->firstname.''.$nam->lastname;
			$arr['courseid']= $this->uri->segment(3);
			
			$this->user_exam_model->create_pdf($arr,$unam);
		}
	
		function ajax_update(){
			$this->load->model('user_exam_model');
			//update tracking detail
			$this->_update_tracking_details($_POST);
			
			
			if(!$this->authentication->logged_in("normal")){
				echo 'session';
			}
			$id	=	$this->session->userdata('EXAMMODEID');
			//echo $id;
			if($this->user_exam_model->ajax_update($id))
			{
				echo 'true';
			}
			
		}	
		
		
		function change_exammode(){

			$this->load->library("session");
			$this->load->library("authentication");
			if(!$this->authentication->logged_in("normal")){
				echo 'false';
			}
			
			$this->load->model('user_exam_model');
			$this->load->model('course_model');
			
			$user_course_id		=	$this->session->userdata ('USERCOURSE');
			$data				=	$this->user_exam_model->get_course ($user_course_id);
		
			$mode_id='';
			if($data[0]['exam_status']!='D'){ 
		
				$reset	=	$this->session->userdata('EXAMMODEID');
				if(isset($reset) && (! $reset)){
					$effective= $this->course_model->get_effective_date($user_course_id);
					if($effective){
					   	$user_id			=	$this->session->userdata('USERID');
						$mode_id			=	$this->user_exam_model->save_user_exam($data[0]['id'],$user_id);
						//echo $mode_id;		
						$this->session->set_userdata('EXAMMODEID', $mode_id);
						echo 'true';
					}else
						echo 'false';
				}else
					echo 'false';
					
			}else
				echo 'false';
	
		}
		function exam_error(){
			$error	=$this->uri->segment(3);
			$this->gen_contents['msg']	=	$error;
			
			//$this->load->view("exam/exam_header",$this->gen_contents);
			//$this->load->view('exam/exam_error',$this->gen_contents);
			//$this->load->view("exam/exam_footer");
			$this->template->set_template('user');
            $this->template->write_view('content', 'reskin/course/exam_error', $this->gen_contents);
            $this->template->render();
		}
		
		//for testing
		function _log_error_keep ($logmsg){
			
			//common_log_message('end',$logmsg,'other');
		}
		

		/**
		 * Update exam tracking details - it will call every second
		 * If user is always online $data only contain exam_tracking_id, and it will only update the updated_at (datetime)
		 * If user comeback(online) after offline, $data will contain the exam details with key exam_data
		 *
		 * @param json $data
		 */
		function _update_tracking_details($data){
                    
			$post_exam_data	= array();
			
			// Converting post exam_data array to following format 
			// array(
			//		[4150] =>	array (
			//						[option_id] => 16873,
			//						[online] => 1 
			//					), 
			//		[4374] => 
			//					array(
			//						[option_id] => 21839
			//						[online] => 0
			//					)
			// )
			
			if('' != $data['exam_data']){
				$e_data = ltrim($data['exam_data'], '"');
				$e_data = rtrim($e_data, '"');
				$exam_data	= json_decode(stripslashes($e_data), true);
				$post_exam_data	= $exam_data;				
			}
                        
                        if('' != $data['exam_ended']){
                            $exam_ended	= json_decode(stripslashes($data['exam_ended']), true);                            
                        }
			$is_online			= $data['is_online'];
			$data['exam_data']              = $post_exam_data;
			$is_online			= $data['is_online'];
			//$exam_ended			= $data['exam_ended'];//user clicked end exam btn
                        
                        
                        // For delaying the redirection after the user click on exam end  button
                        /*if(isset($exam_ended['ended']) && 1 == $exam_ended['ended']){
                            if('' == $this->session->userdata('delay_exam_ended_at')){
                                $this->session->set_userdata('delay_exam_ended_at', time());
                                echo 'delay';exit;
                            }else if($this->session->userdata('delay_exam_ended_at')+12 > time()){
                                echo 'delay';exit;
                            }else{
                                $this->session->unset_userdata('delay_exam_ended_at');
                            }
                        }
                         * 
                         */
                        
                        
			if(isset($data['exam_tracking_id'])){
				$tracking_id = $data['exam_tracking_id'];
				if($tracking_id > 0 && $exam_track = $this->user_exam_model->get_exam_tracking($tracking_id)){
					$user_id 	= $exam_track->user_id;
					$course_id	= $exam_track->course_id;
					$tracking_data	= array('updated_at' => convert_UTC_to_PST_datetime(date('m/d/Y H:i:s')));
					$offline_times		= ('' != $exam_track->offline_times) ? json_decode($exam_track->offline_times, true) : array();
					$current_time		= convert_UTC_to_PST_datetime(date('m/d/Y H:i:s'));
					if(isset($data['exam_data']) && count($data['exam_data']) > 0){
						$current_exam_data		= $exam_track->attended_details;
						$exam_started_time		= $exam_track->started_at;
						if('' != $current_exam_data){
							$current_exam_data	= json_decode($current_exam_data, true);
						}else{
							$current_exam_data	= array();
						}
						$update_exam_data	= array();
						foreach($data['exam_data'] as $qestion_id => $exam_data){//Looping through input(post) exam data
							$exist_status			= 0;// 0 - new one, 1 - already viewed but no option selected, 2 - selected different option, 3 - no change in option selected
							if('' != $current_exam_data && count($current_exam_data) > 0 ){
								if( array_key_exists($qestion_id, $current_exam_data) ){ // check whether the question details already exist in db									
									$current_single_question = $current_exam_data[$qestion_id];// user selected option details against a question from db
									if( $option_id_exist = array_key_exists('option_id', $current_single_question)){ // check whether the option_id exist in single question details
										if($current_single_question['option_id'] != $exam_data['option_id']){ // check whether user selected different option
											$exist_status	= 2;
										}else{
											$exist_status	= 3;
										}
									}else if(!isset($exam_data['option_id'])){
										$exist_status	= 1;
									}
								}
							}
							
							if(1 == $exist_status || 3 == $exist_status){//dont need to update
								continue;
							}else{
								$viewed_at	= date('Y-m-d H:i:s', strtotime($exam_started_time.'+'.$exam_data['view_at'].' seconds'));								
								$current_exam_data[$qestion_id]['online']			= $is_online;
								if(0 == $exist_status){
									$current_exam_data[$qestion_id]['created_at']	= $viewed_at;
								}								
								if(isset($exam_data['option_id'])){
									$current_exam_data[$qestion_id]['option_id']	= $exam_data['option_id'];
									if(isset($exam_data['answer_at'])){
										$answer_at	= date('Y-m-d H:i:s', strtotime($exam_started_time.'+'.$exam_data['answer_at'].' seconds'));
										$current_exam_data[$qestion_id]['updated_at']	= $answer_at;
									}
								}
							}
						}
						if($score = $this->_get_current_score($current_exam_data)){
							$tracking_data['score']	= $score;
							//update score in main table
							$this->_update_main_score($user_id, $course_id, $score);		
						}
						
						$tracking_data['attended_details']	= json_encode($current_exam_data); // update attended details of all question and answer
					}
					if(0 == $is_online){
						if(strtotime($exam_track->updated_at) != strtotime($current_time)){
							array_push($offline_times, array($exam_track->updated_at, $current_time));
							$offline_time_json	= json_encode($offline_times);
							if('' != $offline_time_json){
								$tracking_data['offline_times']	= $offline_time_json;
							}
						}
					}
                                        $this->user_exam_model->update_exam_tracking($tracking_id, $tracking_data);
					if(isset($exam_ended['ended']) && 1 == $exam_ended['ended']){
						$score	= $this->_get_current_score($current_exam_data);
						$status	= 'F';
						if($score){
							$grade	= $this->user_exam_model->get_grade($score);
							$status	= ($grade) ? 'P' : 'F';
							$this->_update_main_score($user_id, $course_id, $score);
						}						
						$tracking_data	= array(
							'exam_ended'=> 1, // default value 0, 1 - user clicked end exam, 2 - user closed browser in between
							'ended_at' 	=> date('Y-m-d H:i:s', strtotime($exam_started_time.'+'.$exam_ended['time'].' seconds')), 
							'status' 	=> $status
						);
						$this->user_exam_model->update_exam_tracking($tracking_id, $tracking_data);	
					}
					
				}
			}
		}
		
		/* Get current exam score during exam */
		function _get_current_score($exsting_exam_data){
			if($exsting_exam_data){
				$score	= 0;
				$question_answers	=	$this->session->userdata ('QUESTIONANSWER');				
				foreach($exsting_exam_data as $question_id => $exam_data){
					if(isset($exam_data['option_id']) && $exam_data['option_id'] == $question_answers[$question_id]){
						$score++;
					}
				}
				return $score;
			}
		}
		
		/* Update score in main table */
		function _update_main_score($user_id, $course_id, $score){
			$grade	=	$this->user_exam_model->get_grade($score);
			$status	= ($grade) ? 'P' : 'F';
			$main_update_data	= array(
										'final_score'	=> $score,
										'status'		=> $status,
									);
			//Score update in main table
			$this->user_exam_model->updateUserCourseDetails(array('userid' => $user_id, 'courseid' => $course_id), $main_update_data);
		}
		
		/* For cron job - Clear passed exam tracking data periodically - 2month past data */
		function delete_exam_tracking(){			
			$this->load->model('user_exam_model');
			$exam_tracking_delete_duration	= $this->config->item('exam_tracking_delete_duration');
			$past_date		= convert_UTC_to_PST_datetime(date('m/d/Y H:i:s', strtotime($exam_tracking_delete_duration)));
			$where			= array('t.status' => 'P');
			$result	= $this->user_exam_model->deleteExamDataPastDate($past_date, $where, true);
			$return_string	= 'No data';
			if($result){
				$return_string ='';
				foreach ($result as $result){
					$return_string	.= $result->course_name." exam by ".$result->name_on_certificate." on ".$result->started_at." is deleted \n";
				}
			}
			echo $return_string;
		}
		
		function _update_score_in_maintable(){
			$user_id = $this->session->userdata('USERID');
			$user_courses = $this->course_model->get_user_courses($this->session->userdata('USERID'));
			if(count($user_courses)){
				foreach ($user_courses as $course_id) {		
					$data=$this->course_model->get_tracking_score($course_id['courseid'],$user_id);					
					if($data){
						$data=$this->course_model->update_score_from_tracking($course_id['courseid'],$user_id,$data);							
					}	
				
				}	
			}		
		}
		
		/* For testing to get default timezone*/
		function timezone(){
			echo date_default_timezone_get();
		}
		//Supplement download
		function download(){
			$this->load->model('supplement_model');
			$id		= $this->uri->segment(3);
                        
			if($id > 0 && $supplement = $this->supplement_model->getSupplementById($id)){
                            	$file_path	= c('supplement_file_path').$supplement->file;
				if(file_exists($file_path)){
					$this->load->helper('download');
					$data 			= file_get_contents($file_path); // Read the file's contents
					$new_file_name	= supplementFileName($supplement->course_name, $supplement->edition_no, $supplement->title);
					force_download($new_file_name, $data);
				}else{
                                    $this->session->set_flashdata('msg_type', 'error');
                                    $this->session->set_flashdata('msg', "Sorry, File does not exists.");
                                    redirect ('course/courselist');
				}
			}else{
                            $this->session->set_flashdata('msg_type', 'error');
                            $this->session->set_flashdata('msg', "Invalid request");
                            redirect ('course/courselist');
			}
		}
                
                function update_exam_ongoing(){
                    $this->load->model('user_exam_model');
                    $exam_ongoing_duration	= $this->config->item('exam_ongoing_duration');
                    $current_date		= convert_UTC_to_PST_datetime(date('Y-m-d H:i:s'));
                    
                    $this->user_exam_model->updateExamOngoing($current_date, $exam_ongoing_duration);
                    
                    echo "Updated successfully";
                    
                }
                
                
        function _profile_progress(){
            $user_id    = $this->session->userdata('USERID');
            $email_id   = $this->session->userdata('EMAIL');

            /* Profile stage progress starts  here */
            $this->load->model(array('course_model', 'user_model'));
            $user_stat  = array(
                'completed_all_exams'           => (($this->course_model->hasAttendedAllExams($user_id, 'P')) ? array('class'=>'visited') : FALSE),
                'registerd_in_crashcourse'      => FALSE,
                'state_exam_applied'            => FALSE,
                'obtained_license'              => FALSE
            );
            
            /* Whether the user registered in crashcourseonline and user attended all exams */
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

        function update_progress(){
            $this->load->model(array('user_model'));
            $item           = $this->input->post('item');
            $broker_name    = $this->input->post('broker_name');
            $result         = array('type'  => 'error', 'message' => '');
            $user_id        = $this->session->userdata('USERID');
            if('state_exam_applied' == $item || 'obtained_license' == $item){
                $profile_progress = $this->user_model->getProfileProgress($user_id);
                $data   = array();
                if(!$profile_progress || !$this->_item_key_exists($profile_progress, $item, FALSE)){
                    $data['user_id']    = $user_id;
                    $data['item']       = $item;
                    if('obtained_license' == $item){
                        $data['broker_name']   = $broker_name;
                    }
                    $data['checked']    = TRUE;
                    $data['created_at'] = convert_UTC_to_PST_datetime(date("Y-m-d H:i:s"));
                    $save   = $this->user_model->insertProfileProgress($data);
                }else{
                    if('obtained_license' == $item){
                        $data['broker_name']   = $broker_name;
                    }
                    $data['checked']    = TRUE;
                    $data['updated_at'] = convert_UTC_to_PST_datetime(date("Y-m-d H:i:s"));
                    $save   = $this->user_model->updateProfileProgress($data, $user_id, $item);
                }
                if($save){
                    $result['type']        = 'success';
                    $result['message']     = 'Updated Profile progress';
                }else{
                    $result['message']     = 'Invalid request';
                }
            }else{
                $result['message']   = 'Invalid request';
            }
            $data['return_value']   = json_encode($result);
            $this->load->view ('dsp_show_ajax',  $data);
        }

    function reenroll() {
        $this->load->helper("form");
        $this->load->model("admin_user_model");
        $this->load->model("user_exam_model");
        $this->load->model("user_model");
        
        if (!$this->authentication->logged_in("normal")) {
            loginto_continue_msg();
        }
        $course = array();
        $userid     = $this->session->userdata('USERID');
        $course_id  = $_POST['reenroll_course_id'];
        
        $billing= $this->user_model->get_b_address($userid);
        $data['billing']    = $billing[0];
        $this->gen_contents['phone']      = $data['billing']['phone'];
        $this->gen_contents['firstname']  = $data['billing']['firstname'];
        $this->gen_contents['lastname']   = $data['billing']['lastname'];
        $this->gen_contents['emailid']    = $data['billing']['emailid'];
                        
        if (!$course_id || '' == $course_id) {
            $this->session->set_flashdata('error', "Invalid request");
            redirect('course/courselist');
        }else{
            $course = $this->user_exam_model->getUserCourseDetails($userid, $course_id);
            $this->gen_contents['usercourse']           = $course->id;
            if(!$course || ($course && !$course->need_to_reenroll)){
                $this->session->set_flashdata('error', "Course already reenrolled");
                redirect('course/courselist');
            }
        }
        if(isset($_POST['b_address'])){
            $this->init_renew_courses();
            $validation_error = $this->session->userdata('validation_error');
            if($validation_error){
                $this->message['error'] = $validation_error;
            }
        }


        $user_details                        = $this->admin_user_model->select_single_userdetails($userid);
        $user_details->phone                 = str_replace(array(' ', '-'),'', $user_details->phone);
        $this->gen_contents["userdetails"]   = $user_details;

        $this->gen_contents['course_user_type']   = $this->user_model->get_course_user_type($userid);


        $this->gen_contents['userid']           = $this->session->userdata('USERID');
        $this->gen_contents['license']          = $this->user_model->get_license($this->session->userdata('USERID'));
        $this->gen_contents['course_user_type'] = $this->user_model->get_course_user_type($this->session->userdata('USERID'));
        
        $renewcourse1                       = $this->Common_model->getUserRenewCourses($course_id, $this->gen_contents['course_user_type'], $userid);
        $this->gen_contents['renewcourse1'] = array();
        
        if(!empty($renewcourse1)){
            $this->gen_contents['renewcourse1']         = $renewcourse1[0];
        }
        
        //$this->session->set_userdata("usercourse", $usercourse);
        $states                         = $this->user_model->get_state();
        $this->gen_contents['states']   = json_decode(json_encode((object)$states), FALSE);

        $this->gen_contents["s_state"]          = $this->admin_user_model->select_state_name($this->gen_contents["userdetails"]->s_state);
        $this->gen_contents["b_state"]          = $this->admin_user_model->select_state_name($this->gen_contents["userdetails"]->b_state);


        $this->gen_contents['month']  = $this->user_model->listmonth();
        $currentyear    = convert_UTC_to_PST_year(date('Y-m-d H:i:s'));
        $this->gen_contents['year']   = $this->user_model->listyear($currentyear);

        $this->template->set_template('user');
        $this->template->write_view('content', 'reskin/course/reenroll', $this->gen_contents);
        $this->template->render();
    }
    
    function init_renew_courses(){
        $this->load->library("form_validation");
        if (!empty($_POST)) {
            $this->form_validation->set_rules('address', 'Shipping Address', 'required|max_length[128]');
            $this->form_validation->set_rules('state', 'Shipping Address State', 'required|max_length[128]');
            $this->form_validation->set_rules('country', 'Shipping Address Country', 'required|max_length[128]');
            $this->form_validation->set_rules('city', 'Shipping Address City', 'required|max_length[128]');
            $this->form_validation->set_rules('zipcode', 'Shipping Address Zipcode', 'required|max_length[128]');
            
            $this->form_validation->set_rules('b_address', 'Billing Address', 'required|max_length[128]');
            $this->form_validation->set_rules('b_state', 'Billing Address State', 'required|max_length[128]');
            //$this->form_validation->set_rules('b_country', 'Billing Address Country', 'required|max_length[128]');
            $this->form_validation->set_rules('b_city', 'Billing Address City', 'required|max_length[128]');
            $this->form_validation->set_rules('b_zipcode', 'Billing Address Zipcode', 'required|max_length[128]');
            
            $this->form_validation->set_rules('courses_ids', 'Course(s)', 'required');
            $this->form_validation->set_rules('ccno', 'Credit Crad Number', 'required|max_length[128]');
            $this->form_validation->set_rules('cvv2no', 'Credit Card Verification Code', 'required|max_length[128]');
            $this->form_validation->set_rules('cardtype', 'Credit Card Type', 'required|max_length[128]');
            $this->form_validation->set_rules('expmonth', 'Expire Month', 'required|max_length[128]');
            $this->form_validation->set_rules('expyear', 'Expire Year', 'required|max_length[128]');
            $this->form_validation->set_rules('phone', 'Phone Number', 'required|max_length[128]');
            $this->form_validation->set_rules('firstname', 'First Name', 'required|max_length[128]');
            $this->form_validation->set_rules('lastname', 'Last Name', 'required|max_length[128]');
            $this->form_validation->set_rules('email', 'Email', 'required|max_length[128]');
            $this->form_validation->set_rules('unit_number', 'Unit Number', 'max_length[128]');
            if(isset($this->gen_contents["ask_driving_license"]) && TRUE === $this->gen_contents["ask_driving_license"]){
                $this->form_validation->set_rules ('driving_license', 'Drivers License Number', 'required|max_length[20]');
            }
            
            $this->form_validation->set_rules('price_wo_ship', 'Price with out shiprate', 'trim');
            $this->form_validation->set_rules('ship_rate', 'Shiprate', 'trim');
            $this->form_validation->set_rules('totalprice', 'Total Price', 'trim|required|min_value[1]');
            $userid         = $this->session->userdata('USERID');
            $courseid       = $this->input->post('courses_ids');
            if ($this->form_validation->run() == TRUE) {
                $state          = $this->user_model->selectstate($this->input->post('b_state'));                
                $name           = $this->input->post('firstname') . " " . $this->input->post('lastname');
                $emailid        = $this->input->post('email');
                $course_name    = $this->input->post('course_name');
                if($this->user_model->emailidExists($emailid, $userid)){
                   $this->gen_contents["msg"] = 'Email id already exist';
                   return false;
                }
                
                $payment_contents = array(
                    "firstname"     => $this->input->post('firstname'),
                    "lastname"      => $this->input->post('lastname'),
                    "ccno"          => $this->Common_model->safe_html($this->input->post('ccno')),
                    "cardtype"      => $this->input->post('cardtype'),
                    "expmonth"      => $this->input->post('expmonth'),
                    "expyear"       => $this->input->post('expyear'),
                    "cvv2no"        => $this->Common_model->safe_html($this->input->post('cvv2no')),
                    "address1"      => $this->input->post('b_address'),
                    "zipcode"       => $this->input->post('b_zipcode'),
                    "country"       => 'US',
                    "state"         => $state[0]['state'],
                    "city"          => $this->input->post('b_city'),
                    "amount"        => $this->input->post('totalprice')
                );
                

                $data['payment'] = $this->user_model->payment($payment_contents);
                $courses = explode(',', $courseid);
                //echo '<pre>';print_r($_POST);exit;
                //var_dump($this->input->post('usercourse'));exit;
                if ("SUCCESS" == strtoupper($data['payment']["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($data['payment']["ACK"])) {                    
                    //SAVE TRANSACTION
                    $this->_insert_payment_log($name, $emailid, $course_name, $data['payment']["ACK"]);
                    
                    $user_detail    = array(
                            'firstname'         => $this->input->post('firstname'), 
                            'lastname'          => $this->input->post('lastname'),
                            'phone'             => $this->input->post('phone'),
                            'unit_number'       => $this->input->post('unit_number'),
                            "b_address"         => $this->input->post('b_address'),
                            "b_country" 	=> 'US',
                            "b_state"           => $this->input->post('b_state'),
                            "b_city"            => $this->input->post('b_city'),
                            "b_zipcode" 	=> $this->input->post('b_zipcode'),
                            "s_address" 	=> $this->input->post('address'),
                            "s_country" 	=> 'US',
                            "s_state"           => $this->input->post('state'),
                            "s_city"            => $this->input->post('city'),
                            "s_zipcode" 	=> $this->input->post('zipcode'),
                        );
                    if(isset($this->gen_contents["ask_driving_license"]) && TRUE === $this->gen_contents["ask_driving_license"]){
                        $user_detail['driving_license'] = generate_hash($this->Common_model->safe_html($this->input->post('driving_license')));
                    }
                    //UPDATE USER DETAILS
                    $this->user_model->updateUserDetails($userid, $user_detail);
                    
                    //SAVE ORDER DETAILS
                    $order_id = $this->_save_order_details($userid, $data['payment']["TRANSACTIONID"]);                    
                    
                    
                    //RENEW LOG
                    $course_user_type   = $this->user_model->get_course_user_type($userid);
                    $renew_date         = convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
                    $usercoureids       = $this->input->post('usercourse');
                    $usercoureids       = explode(',', $usercoureids);
                    
                    foreach ($usercoureids as $usercourse){
                        $course_details   = array(
                            "reg_courseid"  => $usercourse,
                            "b_address"     => $this->input->post('b_address'),
                            "b_city"        => $this->input->post('b_city'),
                            "b_state"       => $this->input->post('b_state'),
                            "b_country"     => $this->input->post('b_country'),
                            "b_zipcode"     => $this->input->post('b_zipcode'),
                            "renew_date"    => $renew_date
                        );
                        $this->user_model->renewcourse($course_details);
                    }
                    

                    //SHIP BOOKS
                    $courses            = explode(',', $courseid);
                    $ship               = $this->_ship_course_books($order_id, $courses);
                    $order_updates      = '';
                    if($ship != 'error'){
                        $order_updates    = array(
                                                    "trackingno" => $ship['trackingno'],
                                                    "label_path" => $ship['label'],
                                                    "status"    => 'S'
                                                );
                        $this->user_model->updateorder($order_updates, $order_id);

                    } else{ 
                        $this->session->set_flashdata('msg',"Course(s) renewed successfully. Administrator will reship it");
                        //$this->user_model->send_mailto_admin($this->mail_contents, $this->order_contents, $this->session->userdata{'admindetails'}, $order_updates, $usertype);														
                        
                    }
                    
                    $renew_mail_contents = array(
                        "b_address"     => $this->input->post('b_address'),
                        "b_city"        => $this->input->post('b_city'),
                        "b_zipcode"     => $this->input->post('b_zipcode'),
                        "b_country"     => 'United States',
                        "b_state"       => $state[0]['state'],
                        "useremail"     => $this->input->post('emailid'),
                        "coursename"    => $this->input->post('course_name'),
                        "name"          => $this->input->post('firstname') . " " . $this->input->post('lastname'),                        
                        "renew_date"    => $renew_date,
                        "courseprice"   => $this->input->post('totalprice')
                    );
                    
                    
                    //$this->session->set_flashdata('succcess', 'success');
                    $this->session->set_flashdata('success', $this->input->post('course_name') . " Renewed Successfully");
                    /* echo $this->session->flashdata('msg');
                      echo $this->session->flashdata('msg_type');exit; */
                    $this->user_model->send_renewal_mailto_user($renew_mail_contents, $course_user_type, $order_updates);
                    $this->user_model->send_renewal_mailto_admin($renew_mail_contents, $course_user_type, $order_updates);
                    redirect("course/courselist");
                } else {

                    $this->gen_contents["msg"] = "Payment transaction failed. " . urldecode($data['payment']['L_LONGMESSAGE0']);
                    
                    $status = urldecode($data['payment']['L_LONGMESSAGE0']);
                    //$this->_init_payment_log($name, $emailid, $status, $course_name);
                    
                    $payment_log = array(
                        "name"          => $name,
                        "emailid"       => $emailid,
                        "paymentdate"   => convert_UTC_to_PST_datetime(date("Y-m-d H:i:s")),
                        "b_address"     => $this->input->post('b_address') . "," . $this->input->post('b_city') .
                                            "," . $this->input->post('b_state') . "," . $this->input->post('b_country') . "," . $this->input->post('b_zipcode'),
                        "s_address"     => $this->input->post('address') . "," . $this->input->post('city') .
                                            "," . $this->input->post('s_state') . "," . $this->input->post('country') . "," . $this->input->post('zipcode'),
                        "coursename"    => $course_name,
                        "status"        => $status
                    );
                    
                    $this->user_model->paymentlog($payment_log);

                    //$this->session->set_flashdata('error', 'failed');
                    $this->session->set_userdata('validation_error', $this->gen_contents["msg"]);
                    //redirect("course/courselist" );

                    /*****/

                    return false;
                }
            } else {
                $this->gen_contents["msg"] = "Fill Required Fields";
                return false;
            }
        } else {
            $this->gen_contents["msg"] = "Failed to process please try again ";
            return false;
        }
    }

}
?>