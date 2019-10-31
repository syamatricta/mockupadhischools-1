<?php

class Quiz extends Controller {
	
	var $gen_contents = array ();
	
	function Quiz() {
		parent::Controller ();
		
		$this->load->helper ( "form" );
		$this->load->library ( "session" );
		$this->load->helper ( 'url' );
		$this->load->model ( 'Common_model' );
		$this->load->model ( 'admin_sitepage_model' );
		$this->gen_contents ['css'] = array ('style.css', 'dhtmlgoodies_calendar.css', 'client_style.css', 'modalbox.css', 'quiz_style.css' );
		$this->gen_contents ['js'] = array ('tooltips.js', 'userdetails.js', 'popcalendar.js', 'quiz_user.js', 'effects.js', 'scriptaculous.js', 'modalbox.js' );
	
	}
	// function for course listing
	function courselist() {
		$this->load->model ( 'course_model' );
		$this->gen_contents ['siteurl'] = $this->admin_sitepage_model->select_sitepages_url ();
		if ($this->authentication->logged_in ( "normal" )) {
			//echo "courselist";
			$this->gen_contents ['userid'] = $this->session->userdata ( 'USERID' );
			$this->load->helper ( "form" );
			$this->gen_contents ['courselist'] = $this->course_model->get_courselistQuiz ( $this->session->userdata ( 'USERID' ) );
			//print_r($this->gen_contents['courselist']);die();
			

			//$this->load->view ( "client_common_header", $this->gen_contents );
			//$this->load->view ( 'quiz/courselist', $this->gen_contents );
			//$this->load->view ( "client_common_footer" );
			
			$this->template->set_template('user');
            $this->template->write_view('content', 'reskin/quiz/courselist', $this->gen_contents);
            $this->template->render();
			
		
		} else
			redirect ( "home" );
	
	}
	//function for quiz listing
	

	function quizlist() {
		
		$this->gen_contents ['siteurl'] = $this->admin_sitepage_model->select_sitepages_url ();
		
		if ($this->authentication->logged_in ( "normal" )) {
			
			$this->load->model ( 'quiz_model' );
			$this->load->helper ( "form" );
			
			$this->gen_contents ["course_id"] = $this->uri->segment ( 3 );
			$edition = get_user_edition($this->gen_contents ["course_id"], $this->session->userdata ( 'USERID' ) );

			$this->gen_contents ['listStatus'] = ( int ) $this->quiz_model->checkQuizStatus ( $this->gen_contents ["course_id"],$edition );
			$this->gen_contents ['quizlist'] = $this->quiz_model->get_quizlist ( $this->gen_contents ["course_id"], $this->session->userdata ( 'USERID' ),$edition);
			
			//$this->load->view ( "client_common_header_new", $this->gen_contents );
			//$this->load->view ( 'quiz/quizlist', $this->gen_contents );
			//$this->load->view ( "client_common_footer_new" );
			$this->template->set_template('user');
            $this->template->write_view('content', 'reskin/quiz/quizlist', $this->gen_contents);
            $this->template->render();
		
		} else
			redirect ( "home" );
	
	}
	//function for quiz listing
	

	function quizrule() {
		$this->gen_contents ['siteurl'] = $this->admin_sitepage_model->select_sitepages_url ();
		
		if ($this->authentication->logged_in ( "normal" )) {
			
			$this->load->helper ( "form" );
			$this->load->model ( 'common_model' );
			
			$this->gen_contents ["quiz_id"] = $this->uri->segment ( 3 );
			$this->gen_contents ["course_id"] = $this->uri->segment ( 4 );
			/****Sree 080410 ****/
			///
			

			$this->session->set_userdata ( 'COURSE_ID', $this->gen_contents ["course_id"] );
			$this->session->set_userdata ( 'quiz_list_id', $this->gen_contents ["quiz_id"] );
			
			$course_name = $this->common_model->courseList ( $this->gen_contents ["course_id"] );
			
			$this->gen_contents ['subject'] = @$course_name [0]->course_name;
			
			$this->gen_contents ['page_title'] = "Quiz Rules";
			$this->gen_contents ['pageid'] = '11';
			$this->gen_contents ['pagedetails'] = $this->admin_sitepage_model->select_single_sitepage_det ( $this->gen_contents ['pageid'] );
			
			$this->load->model('quiz_model');
			$userid	= $this->session->userdata ('USERID');
			$quiz_mode = $this->quiz_model->already_quiz_mode($userid);
			if($quiz_mode){
				//$this->session->set_flashdata ( 'msg', 'Please wait some seconds if you closed the quiz window or the quiz is ongoing' );
				//redirect('quiz/courselist');
				redirect('course/courselist');
				
			}
			
			if (isset ( $_POST ['poptry'] ) && $_POST ['poptry'] == 1)
				$this->gen_contents ['poptry'] = '1';
			$quiz_course = $this->common_model->get_quiz_status ( $this->gen_contents ["quiz_id"], $this->gen_contents ["course_id"] );
			if (@$quiz_course [0]->quiz_status == 'E') {
				$this->gen_contents ["quizno"] = $quiz_course [0]->quiz_name;
				$this->gen_contents['topic'] = $quiz_course [0]->topic ;
				$this->session->set_userdata ( 'QUIZ_NUMBER', $quiz_course [0]->quiz_name );
				$this->session->set_userdata('QUIZ_TOPIC', $quiz_course[0]->topic);
				//$this->load->view ( "client_common_header_new", $this->gen_contents );
				//$this->load->view ( 'quiz/quiz_rule', $this->gen_contents );
				//$this->load->view ( "client_common_footer_new" );
				$this->template->set_template('user');
            	$this->template->write_view('content', 'reskin/quiz/quiz_rule', $this->gen_contents);
            	$this->template->render();
			} else {
				$this->gen_contents ["message"] = "This Quiz has been disabled by Administrator";
				 
				$this->template->set_template('user');
            	$this->template->write_view('content', 'reskin/quiz/error_quiz', $this->gen_contents);
            	$this->template->render();
			}
		
		} else
			redirect ( "home" );
	
	}
	/**
	 * quiz start
	 *
	 */
	function quiz_start() 
	{ 
		$this->gen_contents ['siteurl'] = $this->admin_sitepage_model->select_sitepages_url ();
		
		if (! $this->authentication->logged_in ( "normal" )) 
		{
			redirect ( 'quiz/quiz_error/2' );
		}
		
		if (isset ( $_SERVER ['HTTP_REFERER'] ) && $_SERVER ['HTTP_REFERER']) 
		{
			$this->load->model ( 'quiz_model' );
			
			$this->gen_contents ["quiz_id"] = $this->uri->segment( 3 );
			$this->gen_contents ["quiz_id"] = $usercourseid = $this->session->userdata ( 'quiz_list_id' );
			$course_name = $this->quiz_model->getcourse_name ( $this->gen_contents ["quiz_id"] );
			$topic = $this->quiz_model->get_topic_name($this->gen_contents["quiz_id"]);
			
			$userid = $this->session->userdata ( 'USERID' );
			
			$session_items = array ('QUIZQUESTIONS' => '', 'QUIZANSWER' => '', 'QUIZSCORE' => '', 'COURSENAME_QUIZ' => '', 'QUIZ_TOPIC' => '' );
			
			$this->session->unset_userdata ( $session_items );
			//$this->session->set_userdata ('quiz_list_id',$this->gen_contents["quiz_id"]);
			$usercourseid = $this->session->set_userdata('COURSENAME_QUIZ', $course_name [0]->course_name );

			$this->session->set_userdata('QUIZ_TOPIC', $topic);
			//$usercourseid	=	$this->session->userdata ('USERCOURSE');
			
			$course_id = $this->session->userdata ( 'COURSE_ID' );	
			$edition = get_user_edition($course_name [0]->course_id, $userid );	
			$this->gen_contents ['quiz_list'] = $this->quiz_model->get_quizlist ( $course_id, $this->session->userdata ( 'USERID' ),$edition );
			$this->gen_contents ['quiz_design'] = 1; //to adjust the design to display the quiz list at the right corner
		
			if($this->gen_contents["quiz_id"]) 
			{
				$question_all = $this->quiz_model->getquestionid ( $this->gen_contents ["quiz_id"] );

				#############################################
				#code used to create JSON array
				/***********************/
				
				$arr_exam 		= array();
				$question		= array();
				$r 				= 0;
				/* since a json will consider an php array as an object only if the starting key value is 1*/
				//gets the questions and its id
				
				foreach ($question_all as $key){
					if($key['video']!='')
						$video_url = $this->config->item('quiz_video_location').$key['video'];
					else $video_url = '';
					$qn_dic_arr = @identifyDictionaryWords(strip_tags(stripslashes($key['question'])));
					if(0==$r){						
						$arr_exam['questionid'][1] 	= $key['id'];
						$arr_exam['question'][1] 	= $qn_dic_arr['questions'];
						$arr_exam['video_url'][1] 	= strip_tags(stripslashes($video_url));
						$question[1]				= array('id'=>$key['id'],'ansid'=>$key['ansid']);
						$r++;
					}else{
						$arr_exam['questionid'][] 	= $key['id'];
						$arr_exam['question'][] 	= $qn_dic_arr['questions'];
						$arr_exam['video_url'][] 	= strip_tags(stripslashes($video_url));
						$question[]					= array('id'=>$key['id'],'ansid'=>$key['ansid']);
					}
				}
				/*echo "<pre>";
				print_r($arr_exam);*/
				/* collection of questions is ppased to get the answer options from the table*/
				$arr_answers			= $this->quiz_model->fncGetQuestionsOptions ($arr_exam['questionid']);
				$arr_exam['optionid']	= array();
				/* gets the options and its id*/
				foreach ($arr_answers as $answer){
					$opt_arr = @identifyDictionaryWords(strip_tags(stripslashes($answer->answers)));
					$main_key = array_search($answer->question_id,$arr_exam['questionid']);
					if(@is_array($arr_exam['optionid'][$main_key])){
						$arr_exam['optionid'][$main_key][] 	= $answer->answer_id;
						$arr_exam['option'][$main_key][] 	= $opt_arr['questions'];
					}else{
						$arr_exam['optionid'][$main_key][1] = $answer->answer_id;
						$arr_exam['option'][$main_key][1] 	= $opt_arr['questions'];
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
				/* exam array is encode to jason with questionid,question,options,optionid */
				$this->gen_contents['json_array'] = json_encode($arr_exam);
				
				/**********************/
														
				$this->session->set_userdata ('QUIZQUESTIONS',$question);
				$this->session->set_userdata('start', '1');
				$this->session->set_userdata('end', '1');
				
				$this->quiz_examination();
				#############################################
				
			} else {
				redirect ( 'quiz/quiz_error/3' );
			}
		} else {
			redirect ( 'quiz/quiz_error/1' );
		}
	
	}
	function quiz_examination(){
		//if($_POST['unique_page']==$this->uri->segment(4)){
		if(!$this->authentication->logged_in("normal")){
			redirect('quiz/exam_error/2');
		}
		if(($this->session->userdata('start') || $_POST) && $this->session->userdata('end')){
			$this->load->model('quiz_model');
			$sess_ques							=	$this->session->userdata ('QUIZQUESTIONS');
			$sess_ans							=	$this->session->userdata ('QUIZANSWER'); 
			
			$this->gen_contents['count_ques']		=	count($sess_ques);
			
			$que_no	=	$this->uri->segment(4);
			$action	=	$this->uri->segment(3);
			//$this->_init_examination_details();
			if(empty($que_no))$que_no=1;
			//echo $que_no.'==='.count($sess_ques);exit;
			if($que_no<=count($sess_ques)){
			
				$this->gen_contents['que_no']		= $que_no;
				$this->gen_contents['ques_ans']		= $this->quiz_model->get_quiz_question_ans ($sess_ques[$que_no]['id']);
				
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
				
				$this->load->view ( "quiz/quiz_header", $this->gen_contents );
				$this->load->view ( 'quiz/quiz_page' );
				$this->load->view ( "quiz/quiz_footer" );
			
			}
			else 
				redirect('quiz/quiz_end');
			
			}else 
				redirect('quiz/quiz_error/1');
			
		/*}else 
			redirect('profile');*/

	}
	function quizpage() 
	{
		if (! $this->authentication->logged_in ( "normal" )) {
			redirect ( 'quiz/quiz_error/2' );
		}
		$this->load->model ( 'quiz_model' );
		$quiz_status = $this->quiz_model->check_quiz_status ( $this->session->userdata ( 'quiz_list_id' ) );
		
		$course_id = $this->session->userdata ( 'COURSE_ID' );
		$edition = get_user_edition($course_id, $this->session->userdata ( 'USERID' ) );	
		$this->gen_contents ['quiz_list'] = $this->quiz_model->get_quizlist ( $course_id, $this->session->userdata ( 'USERID' ),$edition );
		$this->gen_contents ['quiz_design'] = 1; //to adjust the design to display the quiz list at the right corner

		if ($quiz_status->quiz_status == 'E') {
			if ($_POST || $this->session->userdata ( 'start' )) {
				
				$sess_ques = $this->session->userdata ( 'QUIZQUESTIONS' );
				$sess_ans = $this->session->userdata ( 'QUIZANSWER' );
				//print_r($sess_ans);
				$this->gen_contents ['count_ques'] = count ( $sess_ques );
				
				$que_no = $this->uri->segment ( 4 );
				$action = $this->uri->segment ( 3 );
				$this->_init_quiz_details ();
				if (empty ( $que_no ))
					$que_no = 1;
					
				if ($action == 'n') {
					$this->session->set_userdata ( 'start', '' );
					if ($this->right_ans) {
						
						$sess_ans [$que_no] = $this->right_ans;
					}
					
					$que_no = $que_no + 1;
				}
				//print_r($sess_ans);
				$this->session->set_userdata ( 'QUIZANSWER', $sess_ans );
				//exit;
				if (isset ( $sess_ans [$que_no] ) && (! empty ( $sess_ans [$que_no] )))
					$this->gen_contents ['right_ans'] = $sess_ans [$que_no];
					$score = $this->session->set_userdata ( 'QUIZSCORE', '' );
					redirect ( 'quiz/quiz_end' );
				
				
			} else
				redirect ( 'quiz/quiz_error/1' );
		} else if ($quiz_status->quiz_status == 'D') {
			$score = $this->session->set_userdata ( 'QUIZSCORE', '' );
			$this->session->set_flashdata ( 'msg', 'This Quiz is disabled by the admin' );
			redirect ( 'quiz/quiz_end' );
		
		} else {
			$score = $this->session->set_userdata ( 'QUIZSCORE', '' );
			$this->session->set_flashdata ( 'msg', 'This Quiz is removed by the admin' );
			$this->session->set_flashdata ( 'display', 1 );
			redirect ( 'quiz/quiz_end' );
		}
	
	}
	
	/**
	 * get the values from the POST and Input it into safe_html
	 *
	 */
	function _init_quiz_details() {
		
		$this->right_ans = $this->input->post ( "right_ans" );
	
	}
	function quiz_end() {
		if (! $this->authentication->logged_in ( "normal" )) {
			redirect ( 'home' );
		}
		$this->gen_contents ['siteurl'] = $this->admin_sitepage_model->select_sitepages_url ();
		$this->load->model ( 'quiz_model' );
		$this->load->library ( 'pagination' );
		
		$config ['per_page'] = '3';
		$config ['uri_segment'] = 3;
                $config['num_links'] = 1;
		$config ['base_url'] = base_url () . 'index.php/quiz/quiz_end/';
		                
		$sess_ques = $this->gen_contents ['question'] = $this->session->userdata ( 'QUIZQUESTIONS' );
		$sess_ans = $this->gen_contents ['ans'] = $this->session->userdata ( 'QUIZANSWER' );
		$this->gen_contents ['total'] = count ( $this->session->userdata ( 'QUIZQUESTIONS' ) );
		
		$this->quiz_model->update_endquiz_status ( '', '', $this->session->userdata ( 'QUIZMODEID' ) );
		
		$session_items = array ('QUIZMODEID' => '' );
		$this->session->unset_userdata ( $session_items );
		
		$score = '';
		
		$offset = $this->uri->segment ( 3 );
		$score = $this->session->userdata ( 'QUIZSCORE' );
		//$this->session->set_userdata ('QUIZSCORE','');die();
		if (empty ( $score )) {
			
			for($i = 1; $i <= count ( $sess_ques ); $i ++) {
				if (isset ( $sess_ques [$i] ['id'] ) && $sess_ques [$i] ['id'] && isset ( $sess_ans [$i] ) && $sess_ans [$i])
					$count [$i] = $this->quiz_model->getquestionDetail ( $sess_ques [$i] ['id'], $sess_ans [$i] );
				
				if (isset ( $count [$i] ['correct'] ) && $count [$i] ['correct']) {
					$score = $score + 1;
				}
			
			} //$attmp_que[$i]	=	$data	;
		

		}
		
		$this->session->set_userdata ( 'QUIZSCORE', $score );
		
		if (empty ( $offset )) {
			
			$offset = '3';
			$num = '1';
		
		} else {
			$num = $offset + 1;
			//$offset						=	$offset*2;//echo count($this->gen_contents['question']);
			$offset = $num + 2;
			
			if ($offset >= count ( $this->gen_contents ['question'] )) {
				
				$page_value = $offset - count ( $this->gen_contents ['question'] );
				$offset = $num + 2;
			
		//echo $page_value;
			//$offset						=	$offset-$page_value;
			}
		}
		//	echo $offset;die();
		//$num	=$offset -	$config['per_page']+1;
		

		$config ['total_rows'] = count ( $this->gen_contents ['question'] );
		
		//echo $sess_ques[3]['id'].",".$sess_ans[3];die();
		for($i = $num; $i <= $offset; $i ++) {
			if (isset ( $sess_ques [$i] ['id'] ) || isset ( $sess_ans [$i] ) && $sess_ans [$i]) {
				if (isset ( $sess_ques [$i] ['id'] ) && $sess_ques [$i] ['id'] != '' && isset ( $sess_ans [$i] ) && $sess_ans [$i] != '')
					$data = $this->quiz_model->getquestionDetail ( $sess_ques [$i] ['id'], $sess_ans [$i] );
				else {
					$data = $this->quiz_model->getquestion ( $sess_ques [$i] ['id'] );
					$data ['answers'] = '';
				}
				
				//Get correct answer
				$data ['correct_answer'] = $this->quiz_model->get_correct_ans ( $sess_ques [$i] ['id'] );
				
				$attmp_que [$i] = $data;
			}
		
		}
		
		//echo "<pre>"; print_r($attmp_que); exit;
		

		$config = array_merge ( $config, $this->config->item ( 'pagination_standard' ) );
		$this->pagination->initialize ( $config );
		
		$this->gen_contents ['paginate'] = $this->pagination->create_links ( true );
		if ($attmp_que)
			$this->gen_contents ['attmp_que'] = $attmp_que;
		else
			$this->gen_contents ['attmp_que'] = '';
		if ($sess_ans)
			$this->gen_contents ['attended_count'] = count ( $sess_ans );
		else
			$this->gen_contents ['attended_count'] = 0;
		
		$this->gen_contents ['right_count'] = $score;
		$this->gen_contents ['wrong_count'] = $this->gen_contents ['attended_count'] - $score;
		$this->gen_contents ['not_attend_count'] = $this->gen_contents ['total'] - $this->gen_contents ['attended_count'];
		$this->gen_contents ['num'] = $num;
		
		//gets the  list of quiz for display
		$course_id = $this->session->userdata ( 'COURSE_ID' );
		$edition = get_user_edition($course_id, $this->session->userdata ( 'USERID' ) );	
		$this->gen_contents ['quiz_list'] = $this->quiz_model->get_quizlist ( $course_id, $this->session->userdata ( 'USERID' ),$edition );
		$this->gen_contents ['quiz_design'] = 1; //to adjust the design to display the quiz list at the right corner
		

		$this->load->view ( "quiz/quiz_header", $this->gen_contents );
		$this->load->view ( 'quiz/quiz_end', $this->gen_contents );
		$this->load->view ( "quiz/quiz_footer" );
	
	}
	
	function quiz_disable() {
		
		$this->load->view ( "quiz/quiz_header", $this->gen_contents );
		$this->load->view ( 'quiz/quiz_disable', $this->gen_contents );
		$this->load->view ( "quiz/quiz_footer" );
	}
	
	function quiz_update() {
		$this->load->library ( "session" );
		$this->load->model ( 'quiz_model' );
		$id = $this->session->userdata ( 'QUIZMODEID' );
		echo $id;
		$this->quiz_model->ajax_quiz_update ( $id );
	
	}
	
	function change_quizmode() {
		$this->load->library ( "session" );
		$this->load->library ( "authentication" );
		if (! $this->authentication->logged_in ( "normal" )) {
			echo 'false';
		}
		
		$this->load->model ( 'quiz_model' );
		$this->load->model ( 'course_model' );
		
		$user_course_id = $this->session->userdata ( 'quiz_list_id' );
		$data = $this->quiz_model->check_quiz_status ( $this->session->userdata ( 'quiz_list_id' ) );
		$mode_id = '';
		
		/*$quiz_mode = $this->quiz_model->check_ajaxupdate_quiz($this->session->userdata('QUIZMODEID'));
		
		if(isset($quiz_mode) && $quiz_mode){
			$examtime = convert_UTC_to_PST_timeonly();
			$exam_time = $examtime-$quiz_mode->quiz_time;
			
			if($exam_time>5){
				$this->quiz_model->update_endquiz_status('','',$this->session->userdata('QUIZMODEID'));
				$session_items = array('QUIZMODEID'=>'');
				$this->session->unset_userdata($session_items);
			}
		}*/
		
		//if($this->session->userdata('QUIZMODEID')){
		//echo $data->quiz_status;
		if ($data->quiz_status != 'D') {
			$reset = $this->session->userdata ( 'QUIZMODEID' );
			
			// Double checking, Check the quiz status, may the quiz end by cron
			$quiz_mode = $this->quiz_model->check_ajaxupdate_quiz($this->session->userdata('QUIZMODEID'));
			if($quiz_mode == false){
				$reset = '';	
			}
			
			//	echo "dd".$reset;
			if (isset ( $reset ) && (empty ( $reset ))) {
				
				$user_id = $this->session->userdata ( 'USERID' );
				$mode_id = $this->quiz_model->save_user_quiz ( $user_course_id, $user_id );
				//echo $mode_id;		
				$this->session->set_userdata ( 'QUIZMODEID', $mode_id );
				echo $user_course_id;
			} else
				echo 'false';
		
		} else
			echo 'false';
	
	}
	
	function quiz_error() {
		$error = $this->uri->segment ( 3 );
		$this->gen_contents ['msg'] = $error;
		
		$this->load->view ( "quiz/quiz_header", $this->gen_contents );
		$this->load->view ( 'quiz/quiz_reuse', $this->gen_contents );
		$this->load->view ( "quiz/quiz_footer" );
	}
	
	function change_quiz() {
		
		//updates the quiz end status if it exist
		$this->load->model ( 'quiz_model' );
		if ($this->session->userdata ( 'QUIZMODEID' )) {
			
			$this->quiz_model->update_endquiz_status ( '', '', $this->session->userdata ( 'QUIZMODEID' ) );
			$session_items = array ('QUIZMODEID' => '' );
			$this->session->unset_userdata ( $session_items );
		}
		
		$this->gen_contents ["quiz_id"] = $this->uri->segment ( 3 );
		$arr_quiz = $this->quiz_model->getSingleQuizDetails($this->gen_contents ["quiz_id"] );
		
		$this->gen_contents ["quizno"] = $arr_quiz->quiz_name;
		
		$this->session->set_userdata ( 'quiz_list_id', $this->gen_contents ["quiz_id"] );
		$this->session->set_userdata ( 'QUIZ_NUMBER', $this->gen_contents ["quizno"] );
		//sets the quiz mode
		$user_id = $this->session->userdata ( 'USERID' );
		$mode_id = $this->quiz_model->save_user_quiz ( $this->gen_contents ["quiz_id"], $user_id );
		$this->session->set_userdata ( 'QUIZMODEID', $mode_id );
		
		//page is redirected to the new quiz page
		redirect ( 'quiz/quiz_start' );
	
	}
	/**
	 * function to validate if the status could be enabled.
	 * $user_type  for understand sales or broker 0/1. $fun_type for understanding this function call from where.
       		false - its from this function otherwise from javascript
	 */
	function validate_enable($user_type = 0, $fun_type = true) {
		$this->load->model ( 'quiz_model' );
		//$user_type	= $this->uri->segment(3);
		$arr_total = $this->quiz_model->weightageCheckingByUsertype ( $user_type );
		$counter = 0;
		if (0 == $user_type) {
			$license = 'sales';
			$video_folder_user_type = 'sales';
		} else {
			$license = 'broker';
			$video_folder_user_type = 'brokers';
		}
		
		//foreach($arr_total as $key){
		

		//if($key->$license > $key->total_questions){
		//	$counter++;
		//}
		//}
		

		/*if($counter){*/
		if ($user_type == 1) {
			$this->gen_contents ['return_value'] = 'The total no of questions for broker users doesn\'t match the weightage';
		} else {
			$this->gen_contents ['return_value'] = 'The total no of questions for sales users doesn\'t match the weightage';
		}
		/*}else{

			$video_counter = 0;*/
		
		//checks if all the video file exist in the respective folders
		//$arr_video	= $this->questions_model->getAllVideoNamesByUsertype($user_type);
		//foreach($arr_video as $video){
		

		//$file_name = $this->config->item('upload_file').'/videos/'.$video_folder_user_type.'/'.$video->folder_name.'/'.$video->video_name;
		//if ( !file_exists($file_name)){
		//	$video_counter++;
		//}
		//}
		//if($video_counter){
		//	$this->gen_contents['return_value'] = 'Please upload all the video files.';
		//}
		//else{
		if (0 == $user_type && $fun_type == true) {
			$this->validate_enable ( 1, false );
		
		//break;
		} else if (1 == $user_type && $fun_type == true) {
			$this->validate_enable ( 0, false );
		
		//break;
		}
		$this->gen_contents ['return_value'] = '';
		//}
		//}
		

		$this->load->view ( 'dsp_show_ajax', $this->gen_contents );
	}
	function update_score() {
		//$decoded = json_decode(strip_tags(stripslashes($_POST['jsonarray'])),true);
		
		$decoded = json_decode($_POST['jsonarray'],true);
		if($decoded['answer'][1]=='' && (count($decoded['answer'])==1)){
			return;
		}
		$filtr_arr = array_filter($decoded['answer']);
		$this->session->set_userdata ('QUIZANSWER',$filtr_arr);
	}
}