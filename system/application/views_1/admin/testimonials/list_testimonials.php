<?php echo form_open('admin_testimonials', array('name'=>'frmadhischool','id' => 'frmadhischool'));
if('' != $this->uri->segment(3)){
	$segment = $this->uri->segment(3); 
}
else{
	$segment ='';
}?>

<div class="adminmainlist">
	<div class="clearboth"> </div>
	

		<div class="adminpagebanner">
			<div class="adminpagetitle"><?php echo $page_title?></div>
		</div>
		<div class="clearboth"> </div>
		<div class="admininnercontentdiv">
			<div align="right" class="floatleft" style="width: 99%; text-align: right; border: 1px solid rgb(153, 153, 153); padding: 5px; background: none repeat scroll 0% 0% rgb(232, 227, 220);">
				<div class="floatleft smallpaddingright">Testimonial : <input type="text" value="<?php echo $search_testimonial;?>" name="txttestimonial" id="txttestimonial" />&nbsp;&nbsp;&nbsp;</div>
				<div class="floatleft"> &nbsp;&nbsp;&nbsp;<input type="submit" value="Search" /></div>
			</div>
			<div class="floatright"><a href="<?php echo site_url()."admin_testimonials/add_testimonial"?>">Add new testimonial</a></div>
			<?php 
			if(count($testimonials) > 0){
				/* list headings starts here*/		
			?>
			<div class="listdata">
				
				<div class="clearboth">&nbsp;</div>
				<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");   ?></div>
				<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
				<div class="clearboth"> </div>
				<div class="admintopheads">
					<div class="adminlistheadings" style="width:5%; text-align:center;">Sl. No</div>
					<div class="adminlistheadings" style="width:70%;">Testimonial</div>
					<div class="adminlistheadings" style="width:25%;text-align:center;">Actions</div>
				</div>
			</div>
			<div class="clearboth"> </div>
		<?php  
	/* list headings ends here*/
				$count=1; 
			   if ($this->uri->segment(3)){
					$count = $count+$this->uri->segment(3);
				} 
				   foreach($testimonials as $data){
				  $bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';
	/* data list starts here */ 
				 ?>
				  <div class="<?php print($bg_color);?>">
				 	<div class="floatleft" style="width:5%;  text-align:center;"><?php print $count;?></div> 
				 	<div class="floatleft" style="width:70%;"><?php $strlen = strlen($data->testimonial_short);
				 					if($strlen > 50){
				 						echo substr($data->testimonial_short,0,50)."...";
				 					}else {
				 						echo $data->testimonial_short;
				 					}			 	
				 	?></div>
				 	<div class="floatleft" style="width:25%;text-align:center;">
						<?php echo anchor('admin_testimonials/view_testimonial/'.$data->id.'/'.$segment,'View')?>&nbsp;|&nbsp;
						<?php echo anchor('admin_testimonials/edit_testimonial/'.$data->id.'/'.$segment,'Edit');?>&nbsp;|&nbsp; 
						<?php #echo anchor('admin_user/edit_users/'.$data->id.'/'.$segment,'Delete');?>
						<a href="javascript:void(0);" onclick="javascript:deleteTestimonial('<?php echo $data->id; ?>','<?php echo $segment; ?>'); return false;" />Delete</a>
					</div> 
				</div>
				<div class="clearboth"> </div>
				<?php $count++; 
	/* data list ends here */ 			
			}?>
			<div class="pagination"><?  echo $paginate;?></div>
			<div style="clear:both">&nbsp;</div>
			<?php }else { ?>
				<div class="nodata">No Testimonials</div>
			<?php }?>
		</div>
		
</div>
<input type="hidden" id="hidtestimonialid" name="hidtestimonialid"  value="<?php if(isset($_POST['hidtestimonialid'])){echo $_POST['hidtestimonialid'];}?>" />
<?php echo form_close();?>