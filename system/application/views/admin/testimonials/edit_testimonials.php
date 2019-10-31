<?php 
$id = '';
$title = '';
$testimonials = '';
$shortdesc = '';
if($testimonial){
	$id = $testimonial->id;
	$title = $testimonial->testimonial_name;
	$shortdesc = $testimonial->testimonial_short;
	$testimonials = $testimonial->testimonial;
}
 echo form_open('admin_testimonials/edit_testimonial/'.$id, array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="adminmainlist">	
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div> <?php /*end of  adminpagebanner */?>
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		<div class="page_error" id="errordisplay"></div>
		<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");?></div>
		<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
		<?php if (isset($error) && ''!= $error) : echo '<div class="page_error">'.$error.'</div>'; endif;?>
		
		<div class="listdata">
			<div class="leftsideheadings_view">Title</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtTitle" id="txtTitle" maxlength="250" value="<?php echo set_post_value('txtTitle',$title);?>" /></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">Short Testimonial<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtshortTitle" id="txtshortTitle" maxlength="250" value="<?php echo set_post_value('txtshortTitle',$shortdesc);?>" /></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">Testimonial<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><textarea name="txtContent" id="txtContent" rows="4" cols="30"><?php echo set_post_value('txtContent',$testimonials);?></textarea></div>
			<div class="clearboth"></div>
			<div class="middlebutton"><input type="button" name="butUpdate" value="Update" onclick="javascript:fncSavetestimonials('<?php echo $id; ?>','<?php echo $pageid; ?>');" /></div>
			</div> <?php /* end of listdata */?>
		</div> <?php /* end of admininnercontentdiv */?>
	<div class="backtolist"><a href="javascript:void(null);" onclick="javascript:gotolist(<?php echo $pageid;?>); return false;"><< Back to testimonial list </a></div>
	<input type="hidden" id="hidtestm_id" name="hidtestm_id"  value="" />
<?php  enable_tiny_mce("txtContent","advanced"); ?>
</div> <?php /* end of adminmainlist */ ?>
<?php echo form_close();?>
