<?php echo form_open('admin_testimonials', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="adminmainlist">
	<?php 
	if(count($testimonial) > 0){
	?>
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div>
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		
		<div class="listdata">
		<?php if('' != $testimonial->testimonial_name){?>
			<div class="leftsideheadings_view">Title</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $testimonial->testimonial_name; ?></div>
			<div class="clearboth"></div>
		<?php } ?>
			<div class="leftsideheadings_view">Short Testimonial</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $testimonial->testimonial_short; ?></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">Testimonial</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $testimonial->testimonial; ?></div>
		</div>
	</div>
	<?php }?>
	<div class="backtolist"><a href="javascript:void(null);" onclick="javascript:gotolist(<?php echo $this->uri->segment(4);?>); return false;"><< Back to testimonial list </a></div>
 </div>
<?php echo form_close();?>