<?php echo  form_open ('exam/exam_start/', array('name'=>'examination_form_adhi','id' => 'examination_form_adhi', 'class' => '') ); ?>
<div id="maindiv">
	<input type="hidden" name="hdnMode" id="hdnMode" value="1"/>
	<input type="hidden" name="hdnOfflineTimer" id="hdnOfflineTimer" value="0"/>
	<div id="examviewmain">
  	<?php /*functional part */ ?>
  		<input type="hidden" name="choice" id="choice" value="0"/>
	   	<div  class="redheading"><div class="redheading"> Course :  </div><div class="completedcourses"><?php echo $this->session->userdata ('COURSENAME'); ?></div></div>
	   	<div class="floatright"><div id="divCounterTotal" class="floatleft examquestionno"><?php echo $que_no;?></div><span class="examquestioncolor"><?php echo '/' . $totalQuestions; ?></span></div>
		<div class="floatright examquestioncolor" style="padding-right:15px;" id="divMode">Online</div>
	   	<div class="clearboth">&nbsp;</div>
		<div class="floatleft" style="height:32px;">
			<div class="remainingtime">Remaining Time :  </div>
			<div class="floatleft">
				<div align="right" class="page_error" id="time_show"></div>
					<input type="hidden" id="timer_hid" value="<?php echo $minute?>">
					
					<input type="hidden" id="minute_hid" value="<?php echo $minute?>">
					<input type="hidden" id="second_hid" value="<?php echo $sec?>">
					
					
					<div align="right" class="page_error" id="time_alert"></div>
					<div align="right" class="time_alert" id="latest"></div>
					<div align="right" id="divAlert" style="display:none;float:left;"><img src="<?php echo $this->config->item('images')?>innerpages/alert.jpg" alt="Alert" /></div>
					<div align="right" class="page_time_error" id="alert"></div>
					<input type="hidden" name="unique_page" id="unique_page"  value="<?php echo $que_no; ?>">
			</div>
		</div>
		<div class="clearboth">&nbsp;</div>
                <div id="ad_board" style="display:none;"><img src="<?php  echo $this->config->item('image_url');?>ad-board.gif" width="728" height="120" /></div>
		<div class="examquestdata" id="confirm">
			<div class="profile_personal_left"><img  src="<?php  echo $this->config->item('images');?>innerpages/exam_quest_header.jpg" /></div>
			<div class="clearboth"></div>
			<div class="exam_quest_middle">
				<div class="examdetmainview" id="examdetmainview">
					<div id="divCounter" class="exam_quest_no_background questno_red">1</div>
					<div class="floatleft"  style="width:540px;">
                                                <div id="divQuestion" class="examquestioncolors"><?php  echo $ques_ans['question'];?></div>
						<div class="clearboth">&nbsp;</div>
						<?php $i=1;
						foreach($ques_ans['options'] as $option_title){
						?>
						<div style="width:520px" class="examanswercolors">
							<div class="floatleft" style="padding-left:26px;width:23px;"><input type="radio" value="<?php echo $i;?>" id="option_<?php echo $i;?>" name="right_ans" onclick="javascript: JSfncSetValue(<?php echo $i;?>);"></div>
							<div id="divOption_<?php echo $i;?>" class="floatleft" style="padding-left:21px;  width:450px;">
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
								<div id="answer-option-text" class="floatleft answer-option-text" ><?php echo stripslashes($option_title); ?></div>
							</div>
						</div>
						<div class="clearboth">&nbsp;</div>
					<?php $i++;}?>
					</div>
				</div>
				<div class="offline_alert" id="offline_alert"></div>
			</div>
			<div class="clearboth"></div>
			<div class="profile_personal_right"><img  src="<?php  echo $this->config->item('images');?>innerpages/exam_quest_footer.jpg" /></div>	
			<div class="exambuttons" id="spinID">
			  	<div id="divPrevious" class="copyright" <?php if($que_no==1){?>style="visibility:hidden;"<?php }?>><a href="javascript:void(null);" onclick="javascript: JSfncPreviousQuestion();"><img  src="<?php echo $this->config->item('images')?>innerpages/previous.jpg" alt="Previous" /></a></div>
			  	
			  	<div id="divNext" class="copyright" <?php if($que_no==$count_ques){?>style="display:none;"<?php }?>><a href="javascript:void(null);" onclick="javascript: JSfncNextQuestion();"><img id="imgNext" src="<?php echo $this->config->item('images')?>innerpages/next.jpg" alt="Next" /></a></div>
			  	
			  	<div id="divEnd" class="copyright" <?php if($que_no!=$count_ques){?>style="display:none;"<?php }?>><a href="javascript:void(null);" onclick="javascript: JSfncEndExam(1);"><img id="imgNext" src="<?php echo $this->config->item('images')?>innerpages/endexam.jpg" alt="End Examination" /></a></div>
			  
			  	<!-- Goto question -->
			  	<div id="divGotoQuestion">
			  		<div class="floatleft">Jump to question : </div>
			  		<div class="floatleft">
			  			<select name="jumpToQuestion" id="jumpToQuestion" onmouseover="javascript:this.focus();" onchange="javascript: gotoQuestion();" class="jumpto_select" >
			  				<option>--</option>		  				
			  			</select>
			  			
			  		</div>
			  	</div>
			  	
			  	
			</div>
			<div class="clearboth"> &nbsp;</div>
		</div>
	</div>
</div>
<?php echo form_close();

$content  = "var content = ".$json_array.";";
$content .= "ajax_update1();";
$content .= "disable_ctrl(this);";
$content .= "disable_rightClick(this);";
$content .= "timer('".$minute."');";
$content .= "exam_tracking_id=".$exam_tracking_id.";";
$content .= "var offline_interval_time=".$this->config->item('offline_interval_time').";";

$script_encoded  = fncEncodeJavascript($content);

?>
<script type="text/javascript" language="javascript">
	<?php echo $script_encoded;?>
</script>

<style type="text/css">
body,html{     
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;  
}
</style>