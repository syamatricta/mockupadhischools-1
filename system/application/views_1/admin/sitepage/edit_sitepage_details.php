<?php echo form_open_multipart('admin_sitepages', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="adminmainlist">
	<?php 
	if(count($sitepagedet) > 0){
	?>
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div> <?php /*end of  adminpagebanner */?>
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		<div class="page_error" id="errordisplay"></div>
		<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");?></div>
		<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
		<?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
		
		<div class="listdata">
			<div class="leftsideheadings_view">Title<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtTitle" id="txtTitle" size="40" maxlength="128" value="<?php echo $sitepagedet->title; ?>" /></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">Content<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><textarea name="txtContent" id="txtContent" rows="4" cols="30"><?php echo $sitepagedet->content; ?></textarea>	</div>
			<div class="clearboth"></div>
			<div class="middlebutton"><input type="button" name="butUpdate" value="Update" onclick="javascript:fncUpadtesitepagedetails(<?php if(count($sitepagedet)>0) { echo $sitepagedet->id;} ?>,'<?php echo $this->uri->segment(4)?>');" /></div>
			</div> <?php /* end of listdata */?>
		</div> <?php /* end of admininnercontentdiv */?>
	<?php }?>
	<div class="backtolist"><a href="javascript:void(null);" onclick="javascript:gotolist('<?php echo $this->uri->segment(4);?>'); return false;"><< Back to sitepage list </a></div>
	<?php  enable_tiny_mce("txtContent","advanced"); ?>
	<input type="hidden" id="hiduserid" name="hiduserid"  value="" />
</div> <?php /* end of adminmainlist */ ?>
<?php echo form_close();?>