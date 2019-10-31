<?php

class Exam extends Controller {

		var $gen_contents = array();
		
		function Exam(){
			parent::Controller();	
					
			$this->load->helper("form");
			$this->load->library("session");
			$this->load->helper('url');
			$this->load->model('Common_model');
			$this->load->model('admin_sitepage_model');
			
			$this->gen_contents['css'] = array('style.css','dhtmlgoodies_calendar.css','client_style.css','modalbox.css');
			$this->gen_contents['js'] = array('userdetails.js','popcalendar.js','effects.js','exam_user.js','modalbox.js','quiz_user.js');
			
		}
		// function for course listing
		function courselist(){
			$this->load->model('course_model');	
			$this->load->model('user_exam_model');	
			$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();
			if($this->authentication->logged_in("normal")){
				
				$exam_mode=$this->course_model->check_ajaxupdate($this->session->userdata('EXAMMODEID'));
				
				if(isset($exam_mode) && $exam_mode){
					$exam_time=time()-$exam_mode->exam_time;
					if($exam_time>10){
						
						$data=$this->course_model->get_exam_detail($this->session->userdata('USERID'));
						
						if($data){
							for($i=0;$i<count($data);$i++){
								
								$grade	=	$this->user_exam_model->get_grade($data[$i]->exam_score);
								if($grade)
									$status='P';
								else 
									$status='F';
								$data=$this->course_model->update_score($this->session->userdata('USERID'),$status,$data[$i]->user_course_id,$data[$i]->exam_score,$data[$i]->id);
							}
						}else{
							//echo $exam_mode->course_id;die();
							$this->course_model->update_score_fail($exam_mode->user_id,'F',$exam_mode->course_id,0);
						}
						//$this->user_exam_model->delete_exam_date($this->session->userdata('EXAMMODEID'));
						
						$this->user_exam_model->update_endexam_status('','',$this->session->userdata('EXAMMODEID'));
						//$this->session->set_userdata('EXAMMODEID','');
						$session_items						=	array('EXAMMODEID'=>'');
						$this->session->unset_userdata($session_items);
					}
				}
				
				//echo "courselist";
				$this->gen_contents['userid']=$this->session->userdata('USERID');	
				$this->load->helper("form");	
				$this->gen_contents['courselist']=$this->course_model->get_examlist($this->session->userdata('USERID'));	
				//print_r($this->gen_contents['courselist']);//die();

				 $license= $this->course_model->get_license($this->session->userdata('USERID'));
				$this->gen_contents['add_status']= $this->course_model->check_addcourse($this->session->userdata('USERID'),$license);

				$this->gen_contents['passedcourselist']=$this->course_model->get_passed_courselist($this->session->userdata('USERID'));	
				//print_r($this->gen_contents['passedcourselist']);
				$this->load->view("client_common_header",$this->gen_contents);	
				$this->load->view('exam/courselist',$this->gen_contents);
				$this->load->view("client_common_footer");		
				
			}
			else{
					redirect("home");
				}
	
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
			$userid			=	$this->session->userdata ('USERID');
			
			$exam_mode		=	$this->user_exam_model->already_exam_mode($userid);
			//print_r($exam_mode);die();
			
			if($usercourse && (!$exam_mode)){
				
				$this->session->set_userdata ('USERCOURSE',$usercourse);
				
				redirect('exam/confirm_password/');
			}else {
				$this->session->set_flashdata('msg', 'Already in Exam');
				redirect('exam/courselist');
			}
			
		}
		
		

		/**
		 * function to show the confirm password box
		 */
		function confirm_password(){
			$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();
			if(!$this->authentication->logged_in("normal")){
				redirect('home');
			}
			$this->load->model('user_exam_model');
			
			$userid			=	$this->session->userdata ('USERID');
			$exam_mode		=	$this->user_exam_model->already_exam_mode($userid);
			
			if($this->session->userdata ('USERCOURSE') && (!$exam_mode)){
				if(!empty($_POST))	{
					
					$this->load->library('form_validation');
					
					$this->form_validation->set_rules ('txt_password', 'Password', 'required');
					
					if (!$this->form_validation->run() == FALSE) {// form validation
						
						$this->load->model('user_model');
						
						$this->_init_confirm_password_details();	
						$userid		=	$this->session->userdata ('USERID');
						
						if($this->user_model->confirm_password(md5($this->txt_password),$userid)){
							//$this->session->set_userdata ('EXAMID',1);
							redirect('exam/exam_rule');
							
						}
						else{
							
							$this->session->set_flashdata('msg', 'Please enter your correct  Password');
						}
			
					}
					redirect('exam/confirm_password');
				}
				$this->load->view("client_common_header",$this->gen_contents);	
				$this->load->view('exam/exam_confirm',$this->gen_contents);
				$this->load->view("client_common_footer");	
			}else
				redirect('exam/courselist');
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
			
			if(!$exam_mode && $this->session->userdata ('USERCOURSE')){
				
				$this->load->view("client_common_header",$this->gen_contents);	
				$this->load->view('exam/exam_rule',$this->gen_contents);
				$this->load->view("client_common_footer");	
			}else
				redirect('exam/courselist');
			
		}
		
		
		/**
		 * Exam start
		 *
		 */
		function exam_start() {
			$this->load->model('user_exam_model');
			$usercourseid	=	$this->session->userdata ('USERCOURSE');
			$userid			=	$this->session->userdata ('USERID');
			if(isset($_POST['start']) && isset($_POST['start'])){
				$data			=	$this->user_exam_model->get_course ($usercourseid);
				
				if($data[0]['exam_status']!='D'){
				
					$this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();
					if(!$this->authentication->logged_in("normal")){
						redirect('home');
					}
					
							$session_items						=	array('QUESTIONS'=>'','ANSWER'=>'','ANSWERID'=>'','TIMEEND'=>'','COURSENAME'=>'');
							
							$this->session->unset_userdata($session_items);
							
							
							$exam_mode		=	$this->user_exam_model->already_exam_mode($userid);
							
							$this->session->set_userdata ('EXAMUNIQUE',1);
							if($usercourseid){
							 
								//$userid			=	$this->session->userdata ('USERID');
								
								
								
								$this->session->set_userdata ('COURSEID',$data[0]['id']);
								$this->session->set_userdata ('COURSENAME',$data[0]['course_name']);
								
								$question		=	$this->user_exam_model->getquestionid ($data[0]['id']);
								
								 $i				= 	count($question);
								
				
				
								$question[$i] = $question[0];
				
								$question[$i] 	=	$question[0];
				
								unset($question[0]);
								
								
								//$timeend					=	time()+9000;
								$timeend					=	time()+1850;
								
								$this->session->set_userdata ('TIMEEND',$timeend);
								
								
								//$mode_id=$this->user_exam_model->save_user_exam($data[0]['id'],$userid);
								
								//$this->session->set_userdata('EXAMMODEID', $mode_id);
								
								$this->user_exam_model->change_effective_date($userid , $usercourseid ,'othercourse');
								
								$this->user_exam_model->change_effective_date($userid,$usercourseid,'samecourse');
								
								$this->session->set_userdata ('QUESTIONS',$question);
								
								$this->user_exam_model->updateuserstatus($userid,'Y');
								
								redirect('exam/examination');
							}else
								redirect('exam/courselist');
					}else
						redirect('exam/courselist');

				}
					$user_status=$this->user_exam_model->get_user_status($userid);
					
				if( $_POST && $user_status){
					
					$this->examination();
				}else 
					redirect('exam/courselist');

		}
		
		function examination(){
			$this->load->model('user_exam_model');
			
			
			
				//$this->session->set_userdata('start', '');
				
				$sess_ques								=	$this->session->userdata ('QUESTIONS');
				$sess_ans								=	$this->session->userdata ('ANSWER'); 
				
				$this->gen_contents['count_ques']		=	count($sess_ques);
				
				$que_no		=	$this->uri->segment(4);
				$action		=	$this->uri->segment(3);
				$timeout	=	$this->uri->segment(3);
				$this->_init_examination_details();
				if(empty($que_no))$que_no=1;
				
				if($action=='p'){
					
					
					if($this->right_ans){
						
						$this->exam_action($que_no);
					}
	
					$que_no	=	$que_no-1;
					
					
					
				}elseif($action=='n'){

					if($this->right_ans){
						
						$this->exam_action($que_no);
					}
					
					$que_no	=	$que_no+1;
				}
				$sess_ans=	$this->session->userdata ('ANSWER');
				if(isset($sess_ans[$que_no]) && (!empty($sess_ans[$que_no])))
						$this->gen_contents['right_ans']=$sess_ans[$que_no];
					
				
				if($que_no<=count($sess_ques) && $timeout!='E'){
				
					$this->gen_contents['que_no']		=	$que_no;
					$this->gen_contents['ques_ans']		=	$this->user_exam_model->getquestion_ans ($sess_ques[$que_no]['id']);
					
					$timeend							=	$this->session->userdata ('TIMEEND');
					$now								=	time();
				//$this->gen_contents['time_rem']		= 	$timeend - $now;
	
					$cur								= 	$timeend - $now;
					if($cur==9000)
						$cur=8999;
					$second								=	$cur%60;
					if($second==0)
						$second=60;
					$this->gen_contents['sec']			=   $second;
					
					$this->gen_contents['minute']		=	floor($cur/60);
							
					
					//print_r($this->gen_contents['ques_ans']);die();
					//$this->user_exam_model->update_status_detail($this->session->userdata('EXAMMODEID'));
					$this->load->view("exam/exam_header",$this->gen_contents);	
					$this->load->view('exam/exam_page',$this->gen_contents);
					$this->load->view("exam/exam_footer");
					
				
				}
				else 
					redirect('exam/exam_end');
				
				
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
		
		
		function exam_action($que_no){
				
			$answer[$que_no]	=$this->right_ans;
			
			$sess_ans			=	$this->session->userdata ('ANSWER');
			$sess_ques			=	$this->session->userdata ('QUESTIONS'); 
			
			//echo $this->right_ans."=".$sess_ques[$que_no]['ansid'];
			//print_r($sess_ans);
			//echo count($sess_ans);
			if(isset($sess_ans) && $sess_ans){//die('eee');
				
				$ans_id		=	$this->session->userdata ('ANSWERID');
				
				if(isset($sess_ans[$que_no]) && (!empty($sess_ans[$que_no]))){
					
					if($sess_ans[$que_no]!=$this->right_ans){
						
						if($sess_ques[$que_no]['ansid']==$this->right_ans){
							if(isset($ans_id) && (!empty($ans_id)))
								$this->update_scoreplus();
							else 
								$this->insert_score();
						
						}
						else if($sess_ans[$que_no]==$sess_ques[$que_no]['ansid']) 
							$this->update_scoreminus();

					}
				}else{
					
						if($sess_ques[$que_no]['ansid']==$this->right_ans){
							if(isset($ans_id) && (!empty($ans_id)))
									$this->update_scoreplus();
								else 
									$this->insert_score();
						}
					}
			}else{
				
				//echo $this->right_ans;
				if($sess_ques[$que_no]['ansid']==$this->right_ans)
					$this->insert_score();
				//die('ff');
				}	
			$sess_ans[$que_no]	=	$answer[$que_no];
			$this->session->set_userdata ('ANSWER',$sess_ans);
			
		}

		
		
		
		function insert_score(){
			
			$course_id		=	$this->session->userdata ('COURSEID');
			$usercourse_id	=	$this->session->userdata ('USERCOURSE');
			$userid			=	$this->session->userdata ('USERID');
			$ans_id			=	$this->user_exam_model->insert_score($course_id,$usercourse_id,$userid);
			//die();
			$this->session->set_userdata ('ANSWERID',$ans_id);
			$this->session->userdata ('ANSWERID',$ans_id);
		}
		
		function update_scoreplus(){
				
			$ans_id=	$this->session->userdata ('ANSWERID');
			$this->user_exam_model->update_scoreplus($ans_id);
		}
		
		function update_scoreminus(){
			
			$ans_id=	$this->session->userdata ('ANSWERID');
			$this->user_exam_model->update_scoreminus($ans_id);
		}
		
		function exam_end(){
			
			$this->gen_contents['siteurl']				=	$this->admin_sitepage_model->select_sitepages_url();
			$this->load->model('user_exam_model');
			$this->gen_contents['course_id']			=	$this->session->userdata ('COURSEID');
			$user_id									=	$this->session->userdata ('USERID');
			$this->user_exam_model->updateuserstatus($user_id,'N');
			$this->user_exam_model->update_endexam_status($user_id,$this->gen_contents['course_id']);
			
			if($this->session->userdata ('QUESTIONS'))
				$this->gen_contents['total']			=	count($this->session->userdata ('QUESTIONS'));
			else 	
				$this->gen_contents['total']			=	0;
			if($this->session->userdata ('ANSWER'))
				$this->gen_contents['attended_que']		=	count($this->session->userdata ('ANSWER'));
			else 
				$this->gen_contents['attended_que']		=	0;
				
				//print_r($this->session->userdata ('ANSWER'));die();
			
			$score_id									=	$this->session->userdata ('ANSWERID');
			$user_course_id								=	$this->session->userdata ('USERCOURSE');
			$score										=	$this->user_exam_model->get_score($score_id);
			
			
			
			$this->gen_contents['not_attend_count'] =	$this->gen_contents['total']-$this->gen_contents['attended_que'];
			
			if(isset($score) && $score!='')
				$this->gen_contents['right_count']	=	$score[0]->exam_score;
			else 
				$this->gen_contents['right_count']	=	0;
				
			$this->gen_contents['wrong_count']		=	$this->gen_contents['attended_que']	- $this->gen_contents['right_count'];
			$this->gen_contents['grade']			=	$this->user_exam_model->get_grade($this->gen_contents['right_count']);
			
			if($this->gen_contents['grade']) $status='P';else $status='F';
			
			$this->user_exam_model->update_user_score($user_course_id,$this->gen_contents['right_count'],$status);
			$session_items						=	array('EXAMMODEID'=>'');
			$this->session->unset_userdata($session_items);
			
			$this->load->view("client_common_header",$this->gen_contents);	
			$this->load->view('exam/exam_end',$this->gen_contents);
			$this->load->view("client_common_footer");

		}
		
		function pdf_create(){
			$arr['userid']= $this->session->userdata('USERID');
			$arr['courseid']= $this->uri->segment(3);
			$this->load->model('user_exam_model');		
			$this->user_exam_model->create_pdf($arr);	
		}
	
		function ajax_update(){
			$this->load->library("session");
			$this->load->model('user_exam_model');
			$id	=	$this->session->userdata('EXAMMODEID');
			//echo $id;
			$this->user_exam_model->ajax_update($id);
			
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
		
}
?>