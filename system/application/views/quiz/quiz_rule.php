<div class="floatleft">
     <div class="left_cntnr" style="position: relative;">
            <?php $this ->load->view('left_content.php');?>
    </div>
    <div class="right_cntnr">
        <div class="right_cntnr_bg_hd">
             <div class="floatleft" style="width:100%">
             	<div class="sitepagehead"><h1>Quiz</h1></div>
             	<div class="username"><?php disp_loggedin_username(); ?></div>
             </div>
            <div class="user_name_display">
              <?php //if(count($userdetails) > 0){ echo $userdetails->firstname." ".$userdetails->lastname; } ?>
            </div>
        </div>
        <div class="right_cntnr_bg">
        	<?php $this->load->view('second_navigation');?>
            <?php echo  form_open ('quiz/courselist', array('name'=>'confirm_password_form_adhi','id' => 'confirm_password_form_adhi', 'class' => '') ); ?>
			<div id="maindiv" style="padding-top:100px">
				<div class="quizlist_main" >
				<?php $subject_title = ($topic !== '') ? $subject.' > ' .$quizno . ' > ' . $topic : $subject.' > ' .$quizno ;?>
					<div class="quizsubject">Subject : <span class="quizcourse"><?php echo $subject_title;?></span> </div>
					<div style="float:right; padding-bottom:5px; padding-right:50px;">
						<!--<a  style="color:#FFF; text-decoration:none; font-weight:bold; "href="javascript:void(null);" onclick="javascript:Modalbox.show('<?php echo base_url();?>index.php/home/examrules', { width: 980, height: 400, title:'Rules'}); return false;">View Rule</a>-->
						<a  style="color:#FFF; text-decoration:none; font-weight:bold; "href="javascript:void(null);" onclick="javascript:viewrule(); return false;" class="viewrule"></a>
					</div>
					<?php /* popup starts */ ?>
	    			<div style="display: none;" id="viewrule">
						<?php  echo popup_box_top('');?>
							<div class="popup_content_main">
								<div class="popup_content_name"><b><?php echo $page_title?></b></div>
								<div class="cb"></div>
								<div class="quiz_rule"><?php echo $pagedetails->content;?></div>
							</div>
						<?php echo popup_box_bottom();?>
						
						<style type="text/css">
	    					#viewrule {
								position:absolute;
								left:540px;
								z-index:1001;
								top:240px; 
							}
	        			</style>
					</div>
					<?php /* popup ends */ ?>
					
					<div class="quiztop"></div>
					<div class="quizrepreat">
						<div class="time">&nbsp;</div>
						<?php /* functional part */?>
							<input type="hidden" value="1" name="popup_blocked_status" id="popup_blocked_status">
                			<input type="hidden" value="<?php echo (isset($poptry) && $poptry=='1')? 1 : 0;?>" name="poptry" id="poptry">
                			<input type="hidden" name="hdnQuizNo" id="hdnQuizNo" value="<?php echo $quizno;?>"/>
							<div class="examstartbuttons" id="confirm">
								<div class="leftsideheadings_view"></div>
								<div class="middlebutton">
									<div class="headernavmain" >
			                            <div style="float:left;width:213px;height:54px; padding-left:83px;" id="hide_strt_btn">
			                            <?php if(@$poptry==0){?>
										<img src="<?php echo $this->config->item('images').'innerpages/start-quiz.png'?>" alt="Start Quiz" id="strtexm" style="cursor:pointer" onclick="javascript:return quiz_rule_check('<?php echo site_url().'/quiz/quiz_start/'.$quiz_id?>', '<?php echo $quiz_id;?>','<?php echo $this->uri->segment(4);?>');return false;"  />
										<?php } ?>
										</div>
			                            <div style="float:left;width:213px;height:54px; padding-left:20px; padding-bottom:20px;" align="left">
			                               	<img src="<?php echo $this->config->item('images').'innerpages/cancel.png'?>" alt="Cancel" style="cursor:pointer" onclick="javascript:cancel_confirm('<?php echo site_url()."/quiz/quizlist" . "/" . $course_id?>');" />                        
			                              <!-- <a href="javascript:void(null);" onclick="javascript:Modalbox.show('<?php echo base_url();?>index.php/home/examrules', { width: 980, height: 400, title:'Rules'}); return false;"><img align="top" src="<?php echo $this->config->item('images').'innerpages/viewrules.jpg'?>" align="right" /></a>-->
			                          	 </div>
			                        </div>
									<div style="float:left; text-align:center; width:100%">
																</div>
								</div>
					
						</div>
					</div>
					<div class="quizbottom"></div>
				</div>
			<?php echo form_close();?>
	     </div>
	</div>
</div>

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
<script>

	function viewrule(){
		$('viewrule').show();
	}
	function popup_close(){
		$('viewrule').hide();
	}
</script>


<?php echo form_close();?>
<?php if(isset($poptry) && $poptry=='1'){?>
 <script type="text/javascript" src="<?php echo base_url().'js/quiz_new.js';?>">    </script>
<?php }?>
  <?php if(isset($poptry) && $poptry=='1'){?>
    <script language="javascript" type="text/javascript">
       
         //quiz_rule();
        //alert("It is fine you can start the exam now.");    	                
    </script>

<?php }?>