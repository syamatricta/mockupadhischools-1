<?php echo form_open_multipart('admin_user', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<?php //$totweight = round(($totweight/2.2),2);
	//$currentweight = round(($course->wieght/2.2),2);
?>
<input type="hidden" name="remain" id="remain" value="<?php echo ($totweight-$currentweight)?>">
<div class="adminmainlist">
	<?php 
	if(count($course) > 0){
	?>
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div> <?php /*end of  adminpagebanner */?>
	<div class="clearboth">&nbsp;</div>
	<div class="floatright instruction">Total course weight allowed for shipping is 68 Kg</div>
	<div class="clearboth">&nbsp;</div>
	<div class="admininnercontentdiv">
		<div class="page_error" id="errordisplay"></div>
		<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error"); ?></div>
		<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
		<?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
		<div class="listdata">
			<div class="leftsideheadings_view">Course Name</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $course->course_name; ?></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">Course Code</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $course->course_code; ?></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">Weight(Kg)<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtWeight" id="txtWeight" size="20" maxlength="5" onkeyup="isNumber(this)" value="<?php echo $currentweight; ?>" /></div>
			<div class="clearboth"></div>
			<!--<div class="leftsideheadings_view">Amount<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtAmount" id="txtAmount" size="20" maxlength="6" onkeyup="isNumber(this)" value="<?php #echo $course->amount; ?>" /></div>
			<div class="clearboth"></div>-->
			<div class="leftsideheadings_view">&nbsp;</div>
			<div class="middlecolon">&nbsp;</div>
			<div class="rightsidedata_view"><input type="button" name="butUpdate" value="Update" onclick="javascript:fncUpadtecourse(<?php if(count($course)>0) { echo $course->id;} ?>,'<?php echo $this->uri->segment(4)?>','<?php echo $this->uri->segment(5)?>');" /></div>
			</div> <?php /* end of listdata */?>
		</div> <?php /* end of admininnercontentdiv */?>
	<?php }?>
	<div class="backtolist"><a href="javascript:void(null);" onclick="javascript:gotolist('<?php echo $this->uri->segment(4);?>','<?php echo $this->uri->segment(5);?>'); return false;"><< Back to course list </a></div>
	<input type="hidden" id="hiduserid" name="hiduserid"  value="" />
</div> <?php /* end of adminmainlist */ ?>
<?php echo form_close();?>