<?php $i=1; 
if($courselist){
foreach ($courselist as $course){ 	
	
	$ended_exam					= 0;					
	$actual_time_exceeded		= false;
	
	if($course['tracking_id'] > 0){
		$ended_exam	= $course['exam_ended'];
		$cur_time	= convert_UTC_to_PST_datetime(date('m/d/Y H:i:s'));		
		//extra 30min; user will get exta 30 for updating while offline
		$actual_time_exceeded	= (strtotime($cur_time) > strtotime($course['will_end_at'].'+30 minutes')) ? true : false;
	}else{
		$actual_time_exceeded = true;
	}
	$view_score	= false;
	if(0 != $ended_exam || $actual_time_exceeded){
		$view_score	= true;
	}
	
?>
	<div class="exam_middle">
		<div class="examdetmainview">
            <div  class="examtitle"> <?php if( $course['parent_course_name']) echo $course['parent_course_name'] ."(".$course['course_name'].")"; else echo $course['course_name'];  ?></div>
			<div class="examdetmain">
				
				<div class="clearboth"></div>
				<div class="examdetails" >
					<div class="exam_left_title">Course Code</div>
					<div class="exam_middle_colon">:</div>
					<div class="exam_right_det"><span class="datacolor"><?php echo $course['course_code'];  ?></span></div>
					<div class="clearboth"></div>
					<div class="exam_left_title">Course Registration</div>
					<div class="exam_middle_colon">:</div>
					<div class="exam_right_det"><span class="datacolor"><?php echo formatDate($course['enrolled_date']);  ?></span></div>
					<div class="clearboth"></div>
					<div  class="exam_left_title">Last attempted on</div>
					<div class="exam_middle_colon">:</div>
					<div class="exam_right_data"><span class="datacolor">
						<?php if('0000-00-00' == $course['last_attemptdate']) { echo "Not Attended"; } else { echo formatDate($course['last_attemptdate']);} ?></span>
					</div>	
<!--					<div class="clearboth"></div>-->
					<?php if($course['effective_date'] !='0000-00-00') { ?>
							<div  class="exam_left_title">Date Final Exam Available &nbsp;</div>
							<div class="exam_middle_colon">:</div>
							<div class="exam_right_det"><span class="datacolor"><?php echo formatDate($course['effective_date']);  ?></span></div>
							<div class="clearboth"></div>
					<?php }else if($course['delivered_date'] =='0000-00-00'){ ?>
							<div  class="filedforrate head_txt">Track Information</div>
							<div class="clearboth"></div>
							<div  class="exam_left_title"> Track Location</div>
							<div class="exam_middle_colon">:</div>
							<div class="exam_right_data"><span class="datacolor"><?php if(isset($course['tracklocation'])){echo $course['tracklocation']; }else{ echo '';} ?></span></div>
							<div class="clearboth"></div>
							<div  class="exam_left_title"> Track Date  </div>
							<div class="exam_middle_colon">:</div>
							<div class="exam_right_data"><span class="datacolor"><?php if(isset($course['lasttrackdate']) && '0000-00-00 00:00:00' != $course['lasttrackdate']) { echo formatDate($course['lasttrackdate']); }else{ echo '';} ?></span></div>
							<div class="clearboth"></div>
					<?php } ?>
					
				</div>
			</div>
	<?php /* write exam link*/?>
			<div class="floatleft" style="width:120px; padding-bootm:10px;" >
	<?php 		if(!$course['disable_status']){ 
					if($course['effective_date']!='0000-00-00'){ 
						if($course['exam_status'] =='E' and  $course['exam_count'] >=9){?>
							<div  class="writeexam" style="padding-bottom:5px;"><a rel="nofollow" href="javascript:void(null);"onclick="confirm_go('<?php echo site_url(). 'exam/confirm_go/'.$course['regid'].'/'.$course['id']?>'); return false;"><div class="take_exam_img">&nbsp;</div></a></div>
		<?php	 		}
					}
					?>
		<?php } else {?>
                                <?php 	if($course['disable_status'] == 'reniew'){ ?>
                                     <?php 	if($course['reinstate_status'] == 1){ ?>  
                                                       <div  class="writeexam" style="padding-bottom:5px;"><a rel="nofollow" href="javascript:void(null);"onclick="confirm_go('<?php echo site_url(). 'exam/confirm_go/'.$course['regid'].'/'.$course['id']?>'); return false;"><div class="take_exam_img">&nbsp;</div></a></div>
                                     <?php      } else { ?>		
							<div  class="writeexam"> <a rel="nofollow" href="<?php echo base_url().'user/renewal/'.$course['regid']; ?>"><div class="renew_img"></div></a></div>
                                    <?php 	}
				}
					}
					if($course['disable_status'] != 'reniew' || ($course['reinstate_status'] == 1)) {?>
						<div  class="writeexam"><a rel="nofollow" href="javascript:void(null);" onclick="javascript:show_quizList('<?php echo site_url(). 'quiz/quizlist/'.$course['id']?>'); return false;"><div class="take_quiz_img">&nbsp;</div></a></div>
			<?php 	} ?>
			</div>
	<?php 	if($course['last_attemptdate']!='0000-00-00'){?>	
			<div class="floatleft" style="padding-top:10px;width:290px;" >				
				<?php if($view_score){?>
				<div  class="writeexam"><a rel="nofollow" href="javascript:void(0)" onclick="javascript:view_score(<?php echo $course['id']; ?>); return false;"><div class="view_score_img"></div></a></div>
				<?php }?>
				<div class="clearboth"></div>
				<?php /* popup starts */ ?>
    			<div style="display:none;" id="viewscore_<?php echo $course['id']; ?>" class="center-screen">
					<?php  echo popup_box_top($course['id']);?>
						<div class="popup_content_main">
							<div class="popup_content_name"><b>Exam Score</b></div>
							<div class="cb"></div>
							<div class="exam_score">Your Score is <?php echo $course['final_score']?></div>
						</div>
					<?php echo popup_box_bottom();?>
				</div>
				<?php /* popup ends */ ?>
				
			</div>	
		<?php }
		
		
		$edition = get_user_edition($course['id'], $this->session->userdata ( 'USERID' ) );
		$supplements = getSupplement($course['id'], $edition );
		if(count($supplements)>0){
			$this->gen_contents['supplements'] = $supplements;
			$this->gen_contents['id'] = $course['id'];
			echo $this->load->view('exam/view_supplement',$this->gen_contents);
		}
		?>
        <div class="clearboth"></div>
		<div class="floatleft">
		<?php 	if($course['disable_status'] == 'disable'){
					if($course['exam_status'] !='E'){?>
						<div  class="disabletext" >Admin has disabled this exam for maintenance purpose</div>
			<?php 	}
				}elseif($course['exam_count'] <9 ){?>
					<div  class="disabletext" >Admin has not uploaded questions into this course</div>
		<?php 	}?>
		</div>
        <div class="clearboth"></div>


		</div>	
	</div>
<div class="clearboth">&nbsp;</div>
<?php	$i++; }
}?>	
<script>

	function view_score(id){
		$('viewscore_'+id).show();
	}
	function popup_close(id){
		$('viewscore_'+id).hide();
	}	
</script>