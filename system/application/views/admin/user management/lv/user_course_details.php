<?php echo form_open_multipart('admin_user', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="adminmainlist">
		<div class="adminpagebanner">
			<div class="adminpagetitle"><?php echo $page_title?></div>
		</div>
		<div class="clearboth"> </div>
		<div class="admininnercontentdiv">
		<div class="page_error" id="errordisplay"></div>
		<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");  ?></div>
		<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
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
				<div class="floatright"><?php if ($add_status == true){echo anchor('admin_user/listremainingcourse/'.$userid,'Add New Course'); }?></div>
				<div class="clearboth"></div>
				<?php /* course details */?>
			<?php if(count($coursedetails)>0){ ?>
				<div class="addressdivisionleft"><strong>Course details of <?php echo $username->firstname. " ".$username->lastname ?> </strong></div>
				<!--<div class="floatright"><?php //if ($add_status == true){echo anchor('admin_user/listremainingcourse/'.$userid,'Add New Course'); }?></div>
				<div class="clearboth"></div>-->
				<div class="admintopheads">
					<div class="adminlistheadings" style="width:5%; text-align:center">Sl.No</div>
					<div class="adminlistheadings" style="width:15%">Course</div>
					<div class="adminlistheadings" style="width:4%"></div>
					<div class="adminlistheadings" style="width:13%">Enrolled Date</div>
					<div class="adminlistheadings" style="width:10%">Delivered Date</div>
					<div class="adminlistheadings" style="width:13%">Effective Date</div>
					<div class="adminlistheadings" style="width:10%">Attended Date</div>
					<div class="adminlistheadings" style="width:6%">Status</div>
					<div class="adminlistheadings" style="width:5%">Score</div>
					<div class="adminlistheadings" style="width:8%">Quiz</div>
					<div class="adminlistheadings" style="width:5%">Action</div>
                                        <div class="adminlistheadings" style="width:5%"></div>
				</div>
				<div class="clearboth"></div>
				<?php $count=1; 
					$cnt_quiz = count($arr_quiz);
				 foreach($coursedetails as $data){
				 	$quiz_status = 'D'; //enable the link
				 	if($cnt_quiz!=0 && in_array($data->courseid,$arr_quiz)){
				 	 	$quiz_status = 'E'; //enable the link
				 	 }
				 	 $bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';	
				 ?>
				  <div class="<?php print($bg_color);?>">
					<div class="adminlistheadings" style="width:5%; text-align:center"><?php echo $count;?></div>
					<div class="adminlistheadings" style="width:15%"><?php echo $data->course_name; ?></div>
					<div class="adminlistheadings" style="width:5%"><?php if( $data->ship_status=='S'){ ?>
					<img  src="<?php  echo $this->config->item('images');?>fedex_log.jpg"  />
					<?php } ?>
					</div>
					<div class="adminlistheadings" style="width:13%">
					<input type="text" class="success_border" name="txtenrolled<?php echo $count;?>" size="10" id="txtenrolled<?php echo $count;?>" readonly value="<?php if('0000-00-00' == $data->enrolled_date) { echo ""; } else { echo formatDate($data->enrolled_date); }  ?>" />
					<img  src="<?php  echo $this->config->item('images');?>calendar.gif"  onclick="displayCalendar(document.frmadhischool.txtenrolled<?php echo $count;?>,'mm/dd/yyyy',this)"/>

					<?php //echo formatDate($data->enrolled_date); ?></div>
					<div class="adminlistheadings" style="width:10%">
					
					<?php if('0000-00-00' == $data->delivered_date) { echo "Not Delivered"; } else { echo formatDate($data->delivered_date);} ?></div>
					<div class="adminlistheadings" style="width:13%">
						<input type="text" class="success_border" name="txtEffective<?php echo $count;?>" size="10" id="txtEffective<?php echo $count;?>" readonly value="<?php if('0000-00-00' == $data->effective_date) { echo ""; } else { echo formatDate($data->effective_date); }  ?>" />
						<img  src="<?php  echo $this->config->item('images');?>calendar.gif"  onclick="displayCalendar(document.frmadhischool.txtEffective<?php echo $count;?>,'mm/dd/yyyy',this)"/>
					</div>
					<div class="adminlistheadings" style="width:10%"><?php if('0000-00-00' == $data->last_attemptdate) { echo "Not Attended"; } else { echo formatDate($data->last_attemptdate);} ?></div>
					<div class="adminlistheadings" style="width:6%"><?php 
							if('P'== $data->status){
								echo "Passed";
							}
							else if('F'== $data->status){ 
								echo "Failed";
							}
					#echo $data->status; ?></div>
					<div class="adminlistheadings" style="width:5%"><?php echo $data->final_score; ?></div>
					<?php if($quiz_status=='E') {?>
						<div class="adminlistheadings" style="width:8%"><a href="javascript:void(null);" onclick="javascript:getQuizDetails('<?php echo $data->courseid;?>','<?php echo $userid;?>','<?php echo $this->uri->segment(4);?>');">Quiz details</a></div>
					<?php } else{ ?>
						<div class="adminlistheadings" style="width:8%"><font color="#8C8E8D">Quiz details</font></div>
					<?php }?>
					<div class="adminlistheadings" style="width:5%"><?php $curdate = convert_UTC_to_PST_date_slash(date('m/d/Y H:i:s')); ?>
						<a href="javascript:void(null);" onclick="javascript:edit_effective_date('<?php echo $data->courseid;?>','<?php echo $userid;?>','<?php echo $count;?>','<?php echo $this->uri->segment(4);?>',document.frmadhischool.txtenrolled<?php echo $count;?>.value,document.frmadhischool.txtEffective<?php echo $count;?>.value,'<?php echo $curdate;?>'); return false;">Update</a>
					<?php # echo anchor('admin_users/edit_course','Edit')?></div>
					<div class="adminlistheadings" style="width:5%"><?php if('P'== $data->status && 'C'== $data->effective_date_status){ echo anchor('exam/pdf_createadmin/'.$data->courseid.'/'.$userid,'<img  src="'.$this->config->item('images').'/innerpages/viewcertificate.jpg" alt="View Certificate" title="View Certificate"/>'); } ?></div>
                                        <div class="clearboth"></div>
				</div>
				 <? $count++; 
				 }		
				}?>
		</div>
		<div class="backtolist">
			<a href="javascript:void(null);" onclick="javascript:gotolist(<?php echo $this->uri->segment(4);?>); return false;"><< Back to users list </a>
		</div>
	</div>
</div>
<input type="hidden" id="hidcount" name="hidcount"  value="<?php if(isset($_POST['hidcount'])){echo $_POST['hidcount'];}?>" />
<?php echo form_close();?>