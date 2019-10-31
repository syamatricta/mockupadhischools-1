<?php $i=1;
if($passedcourselist){  ?>
    <div  class="completedcourses_label" > &nbsp;&nbsp;&nbsp;&nbsp;Completed Courses</div>
<?php foreach ($passedcourselist as $pcourse){?>
<?php /* Completed course list */ ?>

<div class="clearboth">&nbsp;</div>
	<div class="exam_middle" >
		<div class="examdetmainview">
             <div  class="examtitle"> <?php if( $pcourse->parent_course_name) echo $pcourse->parent_course_name ."(".$pcourse->course_name.")"; else echo $pcourse->course_name; ?></div>
    	     <div class="clearboth"></div>
			<div class="examdetmain">
			<div class="clearboth"></div>
				<div class="examdetails" >
					<div class="exam_left_title">Course Code</div>
					<div class="exam_middle_colon">:</div>
					<div class="exam_right_det"><span class="datacolor"><?php echo $pcourse->course_code;  ?></span></div>
					<div class="clearboth"></div>
					<div class="exam_left_title">Course Registration</div>
					<div class="exam_middle_colon">:</div>
					<div class="exam_right_det"><span class="datacolor"><?php echo formatDate($pcourse->enrolled_date);  ?></span></div>
					<div class="clearboth"></div>
					<div class="exam_left_title">Passed Date</div>
					<div class="exam_middle_colon">:</div>
					<div class="exam_right_det"><span class="datacolor"><?php echo formatDate($pcourse->passeddate);  ?></span></div>
				</div>
			</div>
			<div class="floatleft">
				<div  class="writeexam"> <a href="javascript:void(null);" onclick="javascript:show_quizList('<?php echo site_url(). 'quiz/quizlist/'.$pcourse->courseid;?>'); return false;"> <div class="take_quiz_img">&nbsp;</div></a></div>
				<div class="clearboth">&nbsp;</div>
				<!--<div  class="writeexam"> <a href="javascript:void(null);" onclick="javascript:Modalbox.show('<?php echo base_url();?>index.php/home/examscore/<?php echo $pcourse->final_score;?>', { width: 980, height: 400, title:'SCORE'}); return false;"><div class="view_score_img">&nbsp;</div></a></div>-->
				<div  class="writeexam"><a href="javascript:void(0)" onclick="javascript:view_score(<?php echo $pcourse->courseid; ?>); return false;"><div class="view_score_img"></div></a></div>
				<div class="clearboth"></div>
				<?php 
				$edition = get_user_edition($pcourse->courseid, $this->session->userdata ( 'USERID' ) );
				$supplements = getSupplement($pcourse->courseid, $edition );
				if(count($supplements)>0){
					$this->gen_contents['supplements'] = $supplements;
					$this->gen_contents['id'] = $pcourse->courseid;
					echo $this->load->view('exam/view_supplement',$this->gen_contents);
				}
				?>
				<div class="clearboth"></div>
				<?php /* popup starts */ ?>
    			<div style="display: none;" id="viewscore_<?php echo $pcourse->courseid; ?>">
					<?php  echo popup_box_top($pcourse->courseid);?>
						<div class="popup_content_main">
							<div class="popup_content_name"><b>Exam Score</b></div>
							<div class="cb"></div>
							<div class="exam_score">Your Score is <?php echo $pcourse->final_score; ?></div>
						</div>
					<?php echo popup_box_bottom();?>
					
					<style type="text/css">
    					#viewscore_<?php echo $pcourse->courseid; ?> {
							position:fixed;
							left:600px;
							z-index:1001;
							top:280px; 
						}
        			</style>
				</div>
				<?php /* popup ends */ ?>
				<div class="clearboth">&nbsp;</div>
				<?php if($pcourse->expired>0){?>
				
				<div  class="writeexam"><a href="<?php echo 'pdf_create/'.$pcourse->courseid?>"><div class="view_certificate_img">&nbsp;</div></a></div>
				<div class="clearboth">&nbsp;</div>
				<?php } ?>
				<div class="clearboth"></div>
			</div>
		</div>
	</div>
	<?php $i++; } 
			}?>
