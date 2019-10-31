<?php echo form_open('admin_user', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<?php
	$ended_exam	= $exam_details->exam_ended;
	$cur_time	= convert_UTC_to_PST_datetime(date('m/d/Y H:i:s'));
	$user_agent	= getBrowser($exam_details->user_agent);
	
	//extra 30min; user will get exta 30 for updating while offline
	$actual_time_exceeded	= (strtotime($cur_time) > strtotime($exam_details->will_end_at.'+30 minutes')) ? true : false;
?>
<div class="exam_track_page">
	<div class="exam_track_back_button"><a href="javascript:void(null);" onclick="javascript:gotocourselist(<?php echo $this->uri->segment(3);?>,<?php echo ($this->uri->segment(4))?$this->uri->segment(4):0;?>); return false;">Back to course list </a></div>
	<div class="exam_track_head">
		<span class="et_username"><?php echo strtoupper('Exam details of '.$user_details->firstname.' '.$user_details->lastname);?></span>
		<span class="et_course">
			<span class="et_course_label">COURSE:</span>
			<span class="et_course_name"> <?php echo strtoupper($course_details->course_name);?></span>
		</span>
	</div>
	<!-- Data at once starts here -->
	<div class="exam_track_onceat">
		<div class="eto_time_tracks">
			<div class="eto_heading">TIME TRACKING</div>
			<div class="eto_info">
				<div class="eto_info_row">
					<span class="etoi_l">Start time</span>
					<span class="etoi_m">:</span>
					<span class="etoi_r"><?php echo $exam_details->started_at;?></span>
				</div>
				
				<div class="eto_info_row">
					<span class="etoi_l">Expected end time</span>
					<span class="etoi_m">:</span>
					<span class="etoi_r"><?php echo $exam_details->will_end_at;?></span>
				</div>
				<?php if(1 == $ended_exam){?>
				<div class="eto_info_row">
					<span class="etoi_l">Actual end time</span>
					<span class="etoi_m">:</span>
					<span class="etoi_r"><?php echo $exam_details->ended_at;?></span>
				</div>
				
				<div class="eto_info_row">
					<span class="etoi_l">Exam duration</span>
					<span class="etoi_m">:</span>
					<span class="etoi_r"><?php echo format_duration(strtotime($exam_details->ended_at)-strtotime($exam_details->started_at));?></span>
				</div>
				<?php }else{?>
				
				<div class="eto_info_row">
					<span class="etoi_l">Actual end time</span>
					<span class="etoi_m">:</span>
					<span class="etoi_r">
						<?php
							/* User closed the browser(closed the browser and refresh the course list after a 10 sec), actual time exceeded and user not closed(Clicked End Exam btn) the exam yet */
							if(2 == $ended_exam || $actual_time_exceeded){
								echo 'Exam ended unexpectedly after ('.$exam_details->updated_at.')';
							}else{
								echo 'Ongoing ('.format_duration(strtotime($exam_details->will_end_at) - strtotime($cur_time)).' left)';
							}
						?>
					</span>
				</div>
				
				<?php }?>
				
				<div class="eto_info_row offline_times">
					<span class="etoi_l">Was offline</span>
					<span class="etoi_m">:</span>
					<span class="etoi_r">
						<?php
							if('null' == $exam_details->offline_times){
                                                            echo '-';
							}else if('' == $exam_details->offline_times){
                                                            echo '-';
                                                        }else{
                                                            foreach(json_decode($exam_details->offline_times) as $offline){
                                                                    $time	= strtotime($offline[1]) - strtotime($offline[0]);									
                                                                    echo date('G:i:s', strtotime($offline[0])).' to '.date('G:i:s', strtotime($offline[1]));
                                                                    echo ' - '.format_duration($time).'</br>';
                                                            }
							}
						?>
					</span>
				</div>
			</div>
		</div>
		<div class="eto_exam_tracks">
			<div class="eto_heading">EXAM TRACKING</div>
			<div class="eto_info">
				<div class="eto_info_row">
					<span class="etoi_l">Total questions</span>
					<span class="etoi_m">:</span>
					<span class="etoi_r"><?php echo $exam_details->total_question;?></span>
				</div>
				
				<div class="eto_info_row">
					<span class="etoi_l">No. of question reached</span>
					<span class="etoi_m">:</span>
					<span class="etoi_r"><?php echo count($attended_details);?></span>
				</div>
				
				<div class="eto_info_row">
					<span class="etoi_l">No. of right answers</span>
					<span class="etoi_m">:</span>
					<span class="etoi_r"><?php echo $right_answer_count;?></span>
				</div>
				
				<div class="eto_info_row">
					<span class="etoi_l">No. of wrong answers</span>
					<span class="etoi_m">:</span>
					<span class="etoi_r"><?php echo $wrong_answer_count;?></span>
				</div>
				
				<div class="eto_info_row">
					<span class="etoi_l">Not attended</span>
					<span class="etoi_m">:</span>
					<span class="etoi_r"><?php echo $not_answered_count;?></span>
				</div>
				
				<div class="eto_info_row">
					<span class="etoi_l">User clicked End Exam?</span>
					<span class="etoi_m">:</span>
					<span class="etoi_r"><?php echo (1 == $ended_exam) ? 'Yes' : 'No';?></span>
				</div>
				
				<div class="eto_info_row">
					<span class="etoi_l">Score</span>
					<span class="etoi_m">:</span>
					<span class="etoi_r"><?php echo $exam_details->score;?></span>
				</div>
				
				<div class="eto_info_row">
					<span class="etoi_l">Result</span>
					<span class="etoi_m">:</span>
					<span class="etoi_r exam_result">
						<?php
                             switch ($exam_details->status){                                                
                                    case 'P':
                                            $r_text = 'Passed'; $r_class = 'exam_passed'; break;
                                    case 'F':
                                            $r_text = 'Failed'; $r_class = 'exam_failed'; break;
                                    default:                                                                        
                                            $grade        = $this->user_exam_model->get_grade($exam_details->score);                                                                        
                                            if(2 == $ended_exam || $actual_time_exceeded){
                                                    if($grade){
                                                            $r_text = 'Passed'; $r_class = 'exam_passed'; break;
                                                    }else{
                                                            $r_text = 'Failed'; $r_class = 'exam_failed'; break;
                                                    }
                                            }else {
                                                    $r_text = 'Ongoing'; $r_class = 'exam_ongoing';break;
                                            }
                                            
                            }
                            echo '<span class="'.$r_class.'"></span><span>'.$r_text.'</span>';
                    ?>
					</span>
				</div>
			</div>
		</div>
		<div class="eto_sys_tracks">
			<div class="eto_heading">SYSTEM DETAILS</div>
			<div class="eto_info">
				<div class="eto_info_row">
					<span class="etoi_l">IP address</span>
					<span class="etoi_m">:</span>
					<span class="etoi_r"><?php echo $exam_details->ip;?></span>
				</div>
				
				<div class="eto_info_row">
					<span class="etoi_l">Browser</span>
					<span class="etoi_m">:</span>
					<span class="etoi_r"><?php echo $user_agent->browser.' '.$user_agent->version; ?></span>
				</div>
				
				<div class="eto_info_row">
					<span class="etoi_l">Platform</span>
					<span class="etoi_m">:</span>
					<span class="etoi_r"><?php echo $user_agent->platform.' ';
					echo ($user_agent->platform_version!='unknown') ? '('.$user_agent->platform_version.')' : "";?>
					</span>
				</div>
			</div>
			
			<div class="other_exams">
				<div class="eto_heading">OTHER EXAMS</div>
				<div class="eto_info">
					<?php
					if('' != $other_exam_details && count($other_exam_details) > 0){
						foreach ($other_exam_details as $other_exam){
					
					?>
						<div class="eto_info_row">
							<span class="etoi_l"><a class="other_exam_link" href="<?php echo site_url('admin_user/view_user_exam_details/'.$this->userid.'/'.$other_exam->course_id);?>"><?php echo $other_exam->course_name ;?></a></span>
							<span class="etoi_m">:</span>
							<span class="etoi_r"><?php echo $other_exam->score;?></span>
						</div>
					<?php
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<!-- Data at once ends here -->
	
	<!-- Recorded details starts here -->
	<div class="exam_recorded_cnt">
		<div class="erc_heading">Questions</div>
		<div class="erc_all">
			<?php
				$odd_questions	= array();
				$even_questions	= array();
				foreach(json_decode($exam_details->ordered_question_ids) as $key => $question_id){
					if(0 == $key%2){
						$even_questions[$key]	= $question_id;
					}else{
						$odd_questions[$key]	= $question_id;
					}
				}
				if(count($odd_questions) > 0){
					echo '<div class="erc_left">';
					foreach($odd_questions as $key => $question_id){
							$this->gen_contents['key']			= $key;
							$this->gen_contents['question_id']	= $question_id;
							$this->load->view('admin/user management/_exam_single_question_detail', $this->gen_contents);
					}
					echo '</div>';
				}
				if(count($even_questions) > 0){
					echo '<div class="erc_right">';
					foreach($even_questions as $key => $question_id){
							$this->gen_contents['key']	= $key;
							$this->gen_contents['question_id']	= $question_id;
							$this->load->view('admin/user management/_exam_single_question_detail', $this->gen_contents);
					}
					echo '</div>';
				}
			?>
		</div>
	</div>
	<!-- Recorded details ends here -->
	
</div>
<?php echo form_close();?>