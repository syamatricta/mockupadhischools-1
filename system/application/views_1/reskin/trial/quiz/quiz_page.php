<script src="<?php echo base_url();?>js/jwplayer/jwplayer.js"></script>
<?php echo  form_open ('trial_quiz/quizpage/', array('name'=>'quiz_form_adhi','id' => 'quiz_form_adhi', 'class' => '') ); ?>
<input type="hidden" name="choice" id="choice" value="0"/>
<input type="hidden" name="hdnMode" id="hdnMode" value="1"/>
<div class="quizinnerbackground_middle">
	<div id="maindiv">
		<?php		
  			/* gets the question and options dictionary words*/
  			//print_r($ques_ans);
  			$arr_qa = @identifyDictionaryWords(
  				stripslashes($ques_ans[0]['questions']),
  				stripslashes($ques_ans[0]['answers']),
  				stripslashes($ques_ans[1]['answers']),
  				stripslashes($ques_ans[2]['answers']),
  				stripslashes($ques_ans[3]['answers'])
  			);
  			//print_r($arr_qa);
		?>
		
		<div id="examviewmain">
	  	<?php /*functional part */?>
		   	<div  class="redheading">
		   		<div class="redheading"> Course :  </div>
		   		<div class="completedcourses floatleft">
		   			<?php 
		   				$subjec_str = ' ' . $this->session->userdata('COURSENAME_QUIZ')
		   							. ' > ' . $this->session->userdata ('QUIZ_NUMBER');
		   							
		   				$subjec_str .= ($this->session->userdata('QUIZ_TOPIC') != '')
		   				               ? ' > ' . $this->session->userdata('QUIZ_TOPIC')
		   				               : ""; 
		   				echo $subjec_str;
		   			?>
		   		</div>
		   	</div>
		   	<div class="floatright"><div id="divCounterTotal" class="floatleft examquestionno"><?php echo $que_no;?></div><span class="examquestioncolor"><?php echo '/' . $totalQuestions; ?></span></div>
		   	<div class="clearboth">&nbsp;</div>
		   	<?php if($que_no!=$count_ques){ ?>
		   	<div class="floatright" id="quizExit"><a href="javascript:void(null);" onclick="javascript: quiz_exit('<?php echo $que_no?>');return false;"><img  src="<?php echo $this->config->item('images')?>/innerpages/endquiz.jpg" alt="End quiz" /></a></div>
		   	<div class="clearboth">&nbsp;</div>
		   	<?php }?>
			<input type="hidden" value="<?php echo $que_no?>" name="hid_que">
			<input type="hidden" name="unique_page" id="unique_page"  value="<?php echo $que_no; ?>">
			<div class="clearboth">&nbsp;</div>
			<div class="quizquestdata" id="confirm">
				<!--<div class="profile_personal_left">
					<img  src="<?php  echo $this->config->item('images');?>innerpages/exam_quest_header.jpg" />
				</div>-->
				<div class="clearboth"></div>
				<!--<div class="profile_personal_left"><img  src="<?php  echo $this->config->item('images');?>innerpages/exam_quest_left.jpg" /></div>-->
				
				<div class="exam_quest_middle">
					
						<div class="examdetmainview">
							
							<div id="divCounter" class="exam_quest_no_background questno_red">1</div>
							<div class="floatleft" style="width:660px;">
								<div id="divQuestion" class="examquestioncolors"><?php  echo $arr_qa['questions'];?></div>
								<div class="clearboth">&nbsp;</div>
								<div class="floatleft">
									<?php $i=1;
									foreach($ques_ans as $data){ ?>
									<div style="width:375px" class="examanswercolors">
										<div class="floatleft" style="padding-left:18px;" id="divRadio_<?php echo $i;?>"><input type="radio" value="<?php echo $data['ansid'];?>" id="option_<?php echo $data['ansid'];?>" name="right_ans" onclick="javascript: JSfncSetValue(<?php echo $data['ansid'];?>);"></div>
										<div id="divOption_<?php echo $i;?>" class="floatleft q_opt_txt" style="padding-left:11px;  width:320px;">
											<div id="answer-option-alphabet" class="floatleft answer-option-alphabet" >
												<?php 
													$answerOptionAlphabet = '';
													switch($i){
														case 1: 
															$answerOptionAlphabet = 'A ';
															break;
														case 2:
															$answerOptionAlphabet = 'B ';
															break;
														case 3:
															$answerOptionAlphabet = 'C ';
															break;
														case 4:
															$answerOptionAlphabet = 'D ';
															break;
														default:
															break;
													}
													echo $answerOptionAlphabet;
												?>
											</div>
											<div id="answer-option-text" class="floatleft answer-option-text" ><?php echo  $arr_qa['option'.$i]; ?></div>
										</div>
									</div>
									<div class="clearboth">&nbsp;</div>
								<?php $i++;}?>
								</div>
								<div style="float:right;" id="videoDiv">
								<div id='quiz-video'></div>
									<?php if(!empty($ques_ans[0]['video'])):?>
			 							<script type="text/javascript">
			 								jwplayer("quiz-video").setup({
				 								flashplayer: "<?php echo base_url()?>/js/jwplayer/player.swf?file=<?php echo $ques_ans[0]['video_url']; ?>",
				 								file: "<?php echo $ques_ans[0]['video_url']; ?>",
				 								width: '275',
				 								height: '200'
					 						});
					 					</script>										
									<?php endif;?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--<div class="profile_personal_right"><img  src="<?php  echo $this->config->item('images');?>innerpages/exam_quest_right.jpgg" /></div>-->
				<div class="clearboth"></div>
				<div class="profile_personal_right"><img  src="<?php  echo $this->config->item('images');?>innerpages/exam_quest_footer.jpg" /></div>	
				<div class="exambuttons">
					<div id="divPrevious" class="copyright" <?php if($que_no==1){?>style="visibility:hidden;"<?php }?>><a href="javascript:void(null);" onclick="javascript: JSfncPreviousQuizQuestion();"><img  src="<?php echo $this->config->item('images')?>innerpages/previous.jpg" /></a></div>
			  	
			  	<div id="divNext" class="copyright" <?php if($que_no==$count_ques){?>style="display:none;"<?php }?>><a href="javascript:void(null);" onclick="javascript: JSfncNextQuizQuestion();"><img id="imgNext" src="<?php echo $this->config->item('images')?>innerpages/next.jpg" /></a></div>
			  	
			  	<div id="divEnd" class="copyright" <?php if($que_no!=$count_ques){?>style="display:none;"<?php }?>><a href="javascript:void(null);" onclick="javascript: quiz_action(<?php echo $totalQuestions;?>); return false;"><img id="imgNext" src="<?php echo $this->config->item('images')?>innerpages/endquiz.jpg" /></a></div>
			  	
				</div>
			</div>
			
		</div>
	</div>

<?php //display quiz starts ?>
	
	
<?php echo form_close();

$content  = "var content = ".$json_array.";";
$content .= "ajax_update();";
$content .= "disable_ctrl(this);";
$content .= "disable_rightClick(this);";

$script_encoded  = fncEncodeJavascript($content);

?>
<script type="text/javascript" language="javascript">
	<?php echo $script_encoded;?>	
</script>