<?php echo  form_open ('exam/examination/', array('name'=>'frmadhischool','id' => 'frmadhischool', 'class' => '') ); ?>
<div class="quizinnerbackground_middle" >
	<div id="maindiv">
		<div id="examresultviewmain" >
			<div class="floatleft"><span class="page_error">
				<?php 
					if($this->session->flashdata('msg')):
						echo $this->session->flashdata('msg');
					endif;
				?>
			</div>
			<div class="clearboth"></div>
			<div class="quizsuccessinnercontentdiv" >
				<div class="floatleft" ><div><span class="greenheading">See results of your quiz below </span></div></div>
				<div class="clearboth">&nbsp;</div>
				<div class="profile_personal_left" ><img  src="<?php  echo $this->config->item('images');?>innerpages/exam_result_left.jpg" /></div>
				
				<div class="exam_success_middle" >
					<div  class="coursetitle"><?php echo $this->session->userdata ('COURSENAME'); ?></div>
					<div class="successcontentsmain">	
						<div class="successinnercontent">
						
							<div class="exam_left_title">Number of Questions & Answers</div>
							<div class="exam_middle_colon">:</div>
							<div class="result_right_det"><span class="datacolor"><?php echo ($total)?$total:0;  ?></span></div>
							<div class="clearboth"></div>
							
							<div class="exam_left_title">Number of Right Answers</div>
							<div class="exam_middle_colon">:</div>
							<div class="result_right_det"><span class="datacolor"><?php echo ($right_count)?$right_count:0;  ?></span></div>
							<div class="clearboth"></div>
							
							<div class="exam_left_title">Number of Wrong Answers</div>
							<div class="exam_middle_colon">:</div>
							<div class="result_right_det"><span class="datacolor"><?php echo ($wrong_count)?$wrong_count:0;  ?></span></div>
							<div class="clearboth"></div>
							
							<div class="exam_left_title">Number of Not Attended Questions</div>
							<div class="exam_middle_colon">:</div>
							<div class="result_right_det"><span class="datacolor"><?php echo ($not_attend_count)?$not_attend_count:0;  ?></span></div>
							<div class="clearboth"></div>
							
						</div>							
					</div>
				</div>
				
				<div class="profile_personal_right"><img  src="<?php  echo $this->config->item('images');?>innerpages/exam_result_right.jpg" /></div>		
				<div class="clearboth"> &nbsp;</div>
				
				<?php if(!$this->session->flashdata('display')) : ?>
					<div class="quiz_result"><div class="quiz_resulthead">Quiz Result</div></div>
					<div class="clearboth"> </div>
					
					<div class="quiz_resultinner">
						<?php foreach($attmp_que as $data):?>
							<div class="quiz_border_result">
								<div class="floatleft quiz_result_que" style="padding-left:2px;">
									<?php echo '<b class="floatleft quiz_num">'.$num.'</b> &nbsp;'.stripslashes($data['questions']);?>
								</div>
								<div class="clearboth" style=" width:100%;">&nbsp; </div>
								<div class="floatleft quiz_result_ans"> <?php echo "You answered : " ;?></div>
								<div class="floatleft quiz_result_ans_is">
								 	<?php if(isset($data['answers']) && $data['answers']!='') echo stripslashes($data['answers'])."&nbsp;";?>
								</div>
								<div class="clearboth"> &nbsp;</div>
								
								<?php if(isset($data['correct']) && $data['correct'] != 1 ):?>
									<div class="floatleft quiz_result_ans"> <?php echo "Correct answer: " ;?></div>
									<div class="floatleft quiz_result_ans_is">
									 <?php echo stripslashes($data['correct_answer'])."&nbsp;";?></div>
									<div class="clearboth"> &nbsp;</div>
								<?php endif; ?>
								
								
								<div class="headernavmain">
									<div class="floatleft quiz_result_display" >
										<?php if(isset($data['correct']) && $data['correct']) : ?>
											<img  src="<?php  echo $this->config->item('images');?>innerpages/quiz_right_result.jpg" alt="Right Answer" />
										<?php elseif(isset($data['answers']) && (!$data['answers'])):?>
											<img  src="<?php  echo $this->config->item('images');?>innerpages/quiz_not_attended.jpg" alt="Not Attended" />
										<?php else: ?>
											<img  src="<?php  echo $this->config->item('images');?>innerpages/quiz_wrong_result.jpg" alt="Wrong Answer" />
										<?php endif;?>
									</div>
								</div>
								<div class="clearboth"> &nbsp;</div>
							</div>
						<?php 
							$num++;
							endforeach;
						?>
						<div class="headernavmain">
							<div  class="quiz_result_paginate"><?php  echo $paginate;?></div>
						</div>
					</div>
					<div class="clearboth"> &nbsp;</div>
					<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php echo form_close();?>


<script type="text/javascript" language="javascript">
	disable_ctrl(this);
	disable_rightClick(this);
</script>