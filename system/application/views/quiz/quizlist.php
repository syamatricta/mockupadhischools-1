<div class="floatleft">
     <div class="left_cntnr" style="position: relative;">
            <?php $this ->load->view('left_content.php');?>
    </div>
    <div class="right_cntnr">
        <div class="right_cntnr_bg_hd">
            <div class="floatleft"  style="width:100%;">
            	<div class="sitepagehead"><h1>Quiz</h1></div>
            	<div class="username"><?php disp_loggedin_username(); ?></div>
            </div>
            <div class="user_name_display">
              <?php //if(count($userdetails) > 0){ echo $userdetails->firstname." ".$userdetails->lastname; } ?>
            </div>
        </div>
        <div class="right_cntnr_bg">
        	<?php $this->load->view('second_navigation');?>
            
			<?php echo form_open('quiz/courselist', array('name'=>'confirm_password_form_adhi','id' => 'confirm_password_form_adhi', 'class' => '') ); ?>
			<div id="maindiv">
				<div class="quizlist_main">
					<div class="quizsubject" style="width:90%">
						Subject : <span class="quizcourse"><?php  echo @$quizlist[0]->course_name?></span>
						<?php 
						/* This functionality is disabled to show the enabled quizzes in continuous numbers */
						/*if($listStatus != 0):?>
							<!--<div id="showhide" style="float:right;">
								<a href="javascript: void(0);" onClick="javascript: fncDisplayList();" class="showall"></a>
							</div>-->
						<?php endif;*/ ?>
					</div>
					<div class="quiztop"></div>
					<div class="quizrepreat">
						<div class="quiz_innermain"><input type="hidden" value="0" id="hdnListMode" />
						<?php if(!empty($quizlist)) :?>
							<div class="clearboth" style="padding-bottom:10px;"> &nbsp;</div>

							<?php 
								if(isset($quizlist) && $quizlist!=''):
									$arr_quiz = $quizlist;
									$i = 1;
									$active_no 	= 1;
									
							?>
									<div id="divShowAll" class="middlebutton invisible">
										<?php foreach($quizlist as $data): ?>
											<?php if($data->quiz_status =='E'): ?>
												<div  class="filedforrate">
													<span class="quiz_list"><?php echo $i;?>&nbsp;</span>
													<a style="color:#A5CE34" rel="nofollow" 
													   href="javascript:void(null);" 
													   onclick="javascript:show_quizList('<?php echo site_url()."quiz/quizrule/".$data->id."/".$course_id.'/'.$data->quiz_name;?>'); return false;">
													   Chapter <?php echo $viewChapter?>
													    <?php echo $data->quiz_name . (($data->topic) ? ' - ' . $data->topic : '');?>
													</a>&nbsp;
													<span class="instruction" style="color:#FFF !important">Last attempted on: <?php echo ($data->last_date!=0) ? $data->last_date : 'Not attempted'; ?></span>
												</div>
											<?php elseif($data->quiz_status =='D'):?>
												<div  class="filedforrate"> 
													<span class="head_txt" style="float: left; width:35px;"><?php echo $i;?>&nbsp;</span><?php echo $data->quiz_name;?>
													<span class="examtitle" style='font-size:12px !important'> - This quiz has been disabled by Administrator</span>
												</div>
											<?php else:?>
												<div  class="filedforrate"> 
													<span class="head_txt" style="float: left; width:35px;"><?php echo $i;?>&nbsp;&nbsp;</span><?php echo $data->quiz_name;?>
													<span class="examtitle" style='font-size:12px !important'> - This quiz has been removed by Administrator</span>
													<div class="instruction" style="padding:4px 0px 0px 20px;width:auto;">
														<?php echo ($data->last_date!=0) ? 'Last attempted on: '.$data->last_date : ''; ?>
													</div>
												</div>
											<?php endif; ?>
											<div class="clearboth">&nbsp;</div>
										<?php 
											$i++; 
											endforeach;
										?>
									</div>
									
									<?php $viewChapter = 0; ?>
									<div id="divShowActive" class="middlebutton">
										<?php foreach($arr_quiz as $data): ?>
											<?php if($data->quiz_status =='E'): ?>
												<div  class="filedforrate"> 
													<span class="quiz_list"><?php echo $active_no;?>&nbsp;</span>
													Chapter <?php echo ++$viewChapter; ?>&nbsp;
													<a rel="nofollow" style="color:#A5CE34" href="javascript:void(null);" 
													   onclick="javascript:show_quizList('<?php echo site_url()."quiz/quizrule/".$data->id."/".$course_id.'/'.$active_no;?>'); return false;">
													    ( <?php echo $data->quiz_name . (($data->topic) ? ' - ' . $data->topic : '');?> )
													</a>&nbsp;
													<span class="instruction" style="color:#FFF !important">
														Last attempted on: <?php echo ($data->last_date!=0) ? $data->last_date : 'Not attempted'; ?>
													</span>
												</div>
												<div class="clearboth">&nbsp;</div>
												<?php $active_no++; ?>
											<?php endif; ?>
										<?php endforeach; ?>
										<?php if($active_no==1):?>
											<div class="middlebutton"><span class="examtitle floatleft"> No Active Quiz(s) available</span></div>
										<?php endif; ?>
							   		</div>
									
							<?php else: ?>
								<div class="middlebutton">No Quiz Available</div>
							<?php endif; ?>
							
						<?php else: echo "No Quiz Available";?>
							
						<?php endif;?>
						</div>
					</div>					
					<div class="quizbottom"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo form_close();?>

<style type="text/css">
    body {
    font-family: Arial, Helvetica, sans-serif;
    text-align: left;
    padding: 0px;
    margin-top:0px;
    background:url(<?php echo base_url().'images/bg_01.jpg'?>) #000000 no-repeat center top;
    height:auto;
    }
</style>