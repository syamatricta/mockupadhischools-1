<?php echo form_open_multipart($this->current_controller, array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="adminmainlist">
		<div class="adminpagebanner">
			<div class="adminpagetitle"><?php echo $page_title?></div>
		</div>
		<div class="clearboth"> </div>
		<div class="admininnercontentdiv">
		<div class="page_error" id="errordisplay"></div>
		<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?>
                <div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");  ?></div>
                
                </div>
			<?php /*Reason for changing the effective date starts here */?>
				<div class="listdata" id="reason" style="display:none">
					<fieldset>
	   					 <legend><strong>Reason for changing effective date</strong></legend>
	   					<div class="leftsideheadings_view">Submit your reason for changing the effective date</div>
						<div class="middlecolon">:</div>
						<div class="rightsidedata_view"><textarea name="txtReason" class="success_border" id="txtReason" rows="4" cols="70" ></textarea></div>
						<div class="clearboth"></div>
						<div class="middlebutton">
						<input type="button" name="butUpdate" value="Submit" onclick="javascript:fncsubmiteffectivedatereason(<?php echo $this->uri->segment(3);?>);" />
						<input type="button" name="butCancel" value="Cancel" onclick="javascript:fncCancelFreezing();" />
						</div>
					</fieldset>
				</div>
				<div class="clearboth"> &nbsp;</div>
<?php  /*Reason for changing the effective date ends here */?>
			<div class="listdata">
                                <?php if($this->authentication->check_permission_redirect('super_admin', FALSE)){?>
                                    <div class="floatright"><?php if ($add_status == true){echo anchor($this->current_controller.'/listremainingcourse/'.$userid,'Add New Course'); }?></div>
                                    <div class="clearboth"></div>
                                <?php }?>
				<?php /* course details */?>
			<?php if(count($coursedetails)>0){ 
                            $column2    = '10%';
                            if($this->authentication->check_permission_redirect('sub_permission_1', FALSE)){ 
                                $column2    = '20%';
                            }
                            
                            ?>
				<div class="addressdivisionleft"><strong>Course details of <?php echo $username->firstname. " ".$username->lastname ?> </strong></div>
				<!--<div class="floatright"><?php //if ($add_status == true){echo anchor('admin_user/listremainingcourse/'.$userid,'Add New Course'); }?></div>
				<div class="clearboth"></div>-->
				<div class="admintopheads">
					<div class="adminlistheadings" style="width:5%; text-align:center">Sl.No</div>
					<div class="adminlistheadings" style="width:<?php echo $column2;?>">Course</div>
					<div class="adminlistheadings" style="width:8%;text-align:center">Edition</div>
					<div class="adminlistheadings" style="width:6%">&nbsp;</div>
					<div class="adminlistheadings" style="width:12%">Enrolled Date</div>
					<div class="adminlistheadings" style="width:12%">Delivered Date</div>
					<div class="adminlistheadings" style="width:15%">Effective Date</div>
					<div class="adminlistheadings" style="width:10%">Attended Date</div>
					<div class="adminlistheadings" style="width:8%;text-align:center;">Status</div>
					<div class="adminlistheadings" style="width:4%;">Score</div>
                                        <?php if($this->authentication->check_permission_redirect('super_admin', FALSE)){ ?>
					<div class="adminlistheadings" style="width:10%;text-align:center;">Action</div>
                                        <?php }?>
				</div>
				<div class="clearboth"></div>
				<?php $count=1; 
					$cnt_quiz = count($arr_quiz);
					$actual_time_exceeded	= false;
				 foreach($coursedetails as $data){
				 	$user_attended_exam	= true;
				 	$tracking_id	= $data->tracking_id;
					$r_text 	= '';
					$r_class	= '';
					$ended_exam	= 0;					
					$status		= '';
					if($tracking_id > 0){
						$ended_exam	= $data->exam_ended;
						$cur_time	= convert_UTC_to_PST_datetime(date('m/d/Y H:i:s'));
						
						//extra 30min; user will get exta 30 for updating while offline
						$actual_time_exceeded	= (strtotime($cur_time) > strtotime($data->will_end_at.'+30 minutes')) ? true : false;
						$status	= $data->tracking_status;
					}else{
						$grade	= $this->user_exam_model->get_grade($data->final_score);
						$status	= ($grade) ? 'P' : 'F';	
					}
				 	
				 	switch ($status){
						case 'P':
							$r_text = 'Passed'; $r_class = 'exam_passed'; break;
						case 'F':
							$r_text = 'Failed'; $r_class = 'exam_failed'; break;
						default:
							$r_text = 'Ongoing'; $r_class = 'exam_ongoing';break;
					}
                                        
                                        
				 	
				 	$quiz_status = 'D'; //enable the link
				 	if($cnt_quiz!=0 && in_array($data->courseid,$arr_quiz)){
				 	 	$quiz_status = 'E'; //enable the link
				 	 }
				 	 $editions = get_editions($data->courseid);
				 	 $bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';	
				 ?>
				  <div class="<?php print($bg_color);?>">
					<div class="adminlistheadings" style="width:5%; text-align:center"><?php echo $count;?></div>					
					<div class="adminlistheadings" style="width:<?php echo $column2;?>"><?php echo $data->course_name; ?></div>
					<div class="adminlistheadings" style="width:8%; text-align:center;">
                                        <?php 
                                            if($this->authentication->check_permission_redirect('super_admin', FALSE)){ 
                                        ?>
                                            <select name="edition<?php echo $count;?>" id="edition<?php echo $count;?>" style="width:65px;">
                                            <option value="0">Select</option>
                                            <?php foreach ($editions as $ed_no){ ?>
                                            <option value="<?php echo $ed_no['id']; ?>" <?php echo ($ed_no['id']==$data->edition)?"selected":"";?>><?php echo $ed_no['edition_no']; ?></option>
                                            <?php } ?>
                                            </select>
                                        <?php                                        
                                            }else{
                                                 foreach ($editions as $ed_no){
                                                     if($ed_no['id']==$data->edition){echo $ed_no['edition_no'];}
                                                 }
                                            }
                                        ?>
					</div>
					<div class="adminlistheadings" style="width:6%"><?php if( $data->ship_status=='S'){ ?><img  src="<?php  echo $this->config->item('images');?>fedex_log.jpg"  /><?php } ?></div>
					<div class="adminlistheadings" style="width:12%">
						<?php 
                                                if($this->authentication->check_permission_redirect('super_admin', FALSE)){
                                                ?>
                                                <input type="text" class="success_border" name="txtenrolled<?php echo $count;?>" size="10" id="txtenrolled<?php echo $count;?>" readonly value="<?php if('0000-00-00' == $data->enrolled_date) { echo ""; } else { echo formatDate($data->enrolled_date); }  ?>" />
                                                <img  src="<?php  echo $this->config->item('images');?>calendar.gif"  onclick="displayCalendar(document.frmadhischool.txtenrolled<?php echo $count;?>,'mm/dd/yyyy',this)"/>
                                                <?php }else{
                                                    echo formatDate($data->enrolled_date);
                                                }
                                                ?>
						<?php //echo formatDate($data->enrolled_date); ?>
					</div>
					<div class="adminlistheadings" style="width:12%">
						<?php $is_delivered = TRUE; if('0000-00-00' == $data->delivered_date) { $is_delivered = FALSE; echo "Not Delivered"; } else { echo formatDate($data->delivered_date);} 
                                                $is_delivered   = TRUE;//Will remove after implimenting new 18 day rule
                                                ?>
					</div>
					<div class="adminlistheadings" style="width:15%">                                            
                                            <?php if($is_delivered){ ?>                                                
                                                <?php 
                                                if($this->authentication->check_permission_redirect('super_admin', FALSE)){
                                                ?>
                                                    <input type="text" class="success_border" name="txtEffective<?php echo $count;?>" size="10" id="txtEffective<?php echo $count;?>" readonly value="<?php if('0000-00-00' == $data->effective_date) { echo ""; } else { echo formatDate($data->effective_date); }  ?>" />
                                                    <img  src="<?php  echo $this->config->item('images');?>calendar.gif"  onclick="displayCalendar(document.frmadhischool.txtEffective<?php echo $count;?>,'mm/dd/yyyy',this)"/>
                                                <?php }else{
                                                    echo formatDate($data->effective_date);
                                                }
                                                ?>
                                            <?php }else{?>
                                                <input type="text" class="success_border" name="txtEffective<?php echo $count;?>" size="10" id="txtEffective<?php echo $count;?>" readonly disabled="disabled" />
                                            <?php }?>
					</div>
					<div class="adminlistheadings" style="width:10%"><?php if('0000-00-00' == $data->last_attemptdate) { echo "Not Attended"; $user_attended_exam = false;} else { echo formatDate($data->last_attemptdate);} ?></div>
					<div class="adminlistheadings exam_result" style="width:8%">
						<?php 
							/*
							if('P'== $data->status){
								echo "Passed";
							}
							else if('F'== $data->status){ 
								echo "Failed";
							}
							*/
                                                
							if(2 == $ended_exam || (1 != $ended_exam && $actual_time_exceeded)){
								$grade	= $this->user_exam_model->get_grade($data->final_score);
								$status	= ($grade) ? 'P' : 'F';
								switch ($status){
									case 'P':
										$r_text = 'Passed'; $r_class = 'exam_passed'; break;
									case 'F':
										$r_text = 'Failed'; $r_class = 'exam_failed'; break;
								}
							}
							if($user_attended_exam){
								echo '<span class="'.$r_class.'"></span><span>'.$r_text.'</span>';
							}
							#echo $data->status;
						?>
					</div>
					<div class="adminlistheadings" style="width:4%;text-align:center;"><?php if($user_attended_exam){echo $data->final_score;} ?></div>
					<?php if($this->authentication->check_permission_redirect('super_admin', FALSE)){ ?>
                                            <div class="adminlistheadings" style="width:10%">
                                            <?php $curdate = convert_UTC_to_PST_date_slash(date('m/d/Y H:i:s')); ?>				
                                                    <input class="updat_btn action_icon" type="button" value="update" href="javascript:void(null);" onclick="javascript:edit_effective_date('<?php echo $data->courseid;?>','<?php echo $userid;?>','<?php echo $count;?>','<?php echo $this->uri->segment(4);?>',document.frmadhischool.txtenrolled<?php echo $count;?>.value,document.frmadhischool.txtEffective<?php echo $count;?>.value,'<?php echo $curdate;?>'); return false;" />
                                                    <!--<img  src="'.$this->config->item('images').'/innerpages/viewcertificate.png" alt="View Certificate" class="action_icon" title="View Certificate"/>-->
                                                    <?php if(((0 != $ended_exam || $actual_time_exceeded) || ('' == $tracking_id)) && 'P'== $status){ echo anchor('exam/pdf_createadmin/'.$data->courseid.'/'.$userid, 'Download Certificate', 'class="action_icon"'); } ?>
                                                    <?php if($quiz_status=='E') {?>
                                                                    <a class="action_icon" style="clear:left;" href="javascript:void(null);" onclick="javascript:getQuizDetails('<?php echo $data->courseid;?>', '<?php echo $userid;?>','<?php echo $this->uri->segment(4);?>');">
                                                                            <!--<img src="<?php //echo $this->config->item('images').'quiz-details.png';?>" alt="Exam details" title="View Quiz details" />-->
                                                                            View Quiz details
                                                                    </a>
                                                    <?php } ?>	
                                                    <?php if($data->exam_attended_exist){?>
                                                                    <a class="action_icon" style="clear:left;" href="<?php echo base_url().$this->current_controller.'/view_user_exam_details/'.$userid.'/'.$data->courseid;?>">
                                                                            View Exam details
                                                                            <!--<img src="<?php echo $this->config->item('images').'exam-details.png';?>" alt="Exam details" title="View exam details" />-->
                                                                    </a>
                                                            <?php }?>
                                                            <?php
                                                            if(find_date_diff($this->config->item("cut_off_date"),$data->enrolled_date) > 0){
                                                                $span = "+2 years";
                                                            }else{
                                                                $span = "+1 years";
                                                            }
                                                            
                                                            $date_diff = find_date_diff(date('Y-m-d', strtotime($data->enrolled_date.$span)),date('Y-m-d'));

                                                            if($tracking_id > 0){
                                                                $status	= $data->tracking_status;
                                                            } else {
                                                                $grade	= $this->user_exam_model->get_grade($data->final_score);
                                                                $status	= ($grade) ? 'P' : 'F';	
                                                            }

                                                            $passd =  ($status == 'P') ? TRUE : FALSE;

                                                            if($date_diff < 0 ){
                                                                if($data->reinstate_status == 0 && !$passd) {
                                                                    if($data->renewal_status != 'Y' || ($data->renewal_status == 'Y' && $data->renew_expired == 'Y')){
                                                                ?>
                                                                <a class="action_icon" style="clear:left;" href="<?php echo base_url().$this->current_controller.'/reinstate/'.$data->id; ?>">Reinstate</a>
                                                            <?php } }
                                                                if($data->reinstate_status == 1 && !$passd){
                                                                  if($data->renewal_status != 'Y' || ($data->renewal_status == 'Y' && $data->renew_expired == 'Y')){ ?>
                                                                        <span class="action_icon" style="clear:left;color:green;" > Reinstated </span>
                                                                <?php
                                                                }
                                                              }
                                                            }
                                                            ?>
                                                            <?php # echo anchor('admin_users/edit_course','Edit')?>	

                                                                <a href="#" id="delete_course" class="action_icon" style="clear:left;" onclick="delete_course('<?php echo $data->courseid;?>','<?php echo $userid;?>');">Delete</a>
                                                            
                                            </div>
                                        <?php }?>
					<div class="clearboth"></div>
				</div>
				 <?php $count++; 
				 }		
				}?>
		</div>
		<div class="backtolist">
			<?php echo anchor($this->current_controller.'/list_user_details', '<< Back to users list');?>
		</div>
	</div>
</div>
<input type="hidden" id="hidcount" name="hidcount"  value="<?php if(isset($_POST['hidcount'])){echo $_POST['hidcount'];}?>" />


<?php echo form_close();?>

<script>
function delete_course(course_id, user_id)
{
    if(confirm("Are you sure to delete this course?"))
    {
        var url  =   base_url + '<?php echo $this->current_controller;?>' +"/delete_course";
        var params      =   'course_id='+course_id+'&user_id='+user_id;
        new Ajax.Request(url,{
               method      : "post",
               onSuccess   : delete_course_success,
                             parameters  : params,
               onFailure   : disp_delete_course_error
             }
        );
    }    
        
}    
function delete_course_success(resp_obj)
{
    if(resp_obj.responseText == "exists") 
    {
        $("errordisplay").innerHTML = "Already attended exam.Not able to delete this course!";
    }
    else
    {
        window.location = base_url+ '<?php echo $this->current_controller;?>' + "/user_course_details/"+resp_obj.responseText;
    }
}

function disp_delete_course_error()
{
    
}
</script>

<style>
.updat_btn{width:53px;margin:0px 0 0 0;border:1px solid #ccc; 
				background-color:#6E6E6E;color:#FFF;
				text-align:center;
-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	cursor:pointer;
	padding:2px;
}
.action_icon{margin-bottom:6px;float:left;}
a.action_icon{color:#000;}
</style>
