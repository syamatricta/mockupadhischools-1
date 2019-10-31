<?php echo form_open_multipart('admin_user', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="adminmainlist">
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div> <?php /*end of  adminpagebanner */?>
	<div class="clearboth">&nbsp;</div>
	<div class="admininnercontentdiv">
		<div class="page_error" id="errordisplay"></div>
		<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error"); ?></div>
		<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
		<?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
		<div class="listdata">
		<?php if('' != $course->course_name){?>
			<div class="leftsideheadings_view">Course Name</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $course->course_name; ?></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">Course Code</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $course->course_code; ?></div>
			<div class="clearboth"></div>
		<?php } else {?>
			<div class="leftsideheadings_view">Course Name</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo "Package"; ?></div>
		<?php } ?>
			<div class="leftsideheadings_view">Amount<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtAmount" id="txtAmount" size="20" maxlength="6" onkeyup="isNumber(this)" value="<?php echo $course->amount; ?>" /></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">&nbsp;</div>
			<div class="middlecolon">&nbsp;</div>
			<div class="rightsidedata_view"><input type="button" name="butUpdate" value="Update" onclick="javascript:fncUpadtecourserate(<?php if(count($course)>0) { echo $course->id;} ?>,'<?php echo $this->uri->segment(4)?>');" /></div>
			</div> <?php /* end of listdata */?>
		</div> <?php /* end of admininnercontentdiv */?>
	
		
	<div class="backtolist"><a href="javascript:void(null);" onclick="javascript:gotolist('<?php echo $this->uri->segment(4);?>','<?php echo $this->uri->segment(5);?>'); return false;"><< Back to course list </a></div>
	<input type="hidden" id="hiduserid" name="hiduserid"  value="" />
</div> <?php /* end of adminmainlist */ ?>
<?php echo form_close();?>