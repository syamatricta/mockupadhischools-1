<?php echo form_open('admin_user', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="adminmainlist">	
		<div class="page_error" id="errordisplay"></div>
		<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");?></div>
		<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
		<?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
		<div class="adminpagebanner">
			<div class="adminpagetitle"><?php echo $page_title?></div>
		</div>
		<div class="clearboth"> </div>
		<div class="admininnercontentdiv">
			<div class="list_regionadd"><a href="<?php echo base_url().'admin_sitepages/add_faq';?>">Add FAQ</a></div>
			<div class="listdata">
				<div class="admintopheads">
					<div class="adminlistheadings" style="width:10%; text-align:center;">Sl. No</div>
					<div class="adminlistheadings" style="width:80%;">Question</div>
<!--					<div class="adminlistheadings" style="width:50%;">Short Description</div>-->
					<div class="adminlistheadings" style="width:5%;text-align:center;">Edit</div>
					<div class="adminlistheadings" style="width:5%;text-align:center;">Delete</div>
				</div>
			</div>
			<div class="clearboth"> </div>
		<?php 
		if(count($faq) > 0){
	/* list headings ends here*/
			$count=1; 
		   	if ($this->uri->segment(3)){
				$count = $count+$this->uri->segment(3);
			} 
			foreach($faq as $data){
				$bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';
	/* data list starts here */ 
		?>
						<div class="<?php print($bg_color);?>">
						 	<div class="floatleft" style="width:10%;  text-align:center;"><?php print $count; ?></div> 
						 	<div class="floatleft" style="width:80%;"><?php echo $data->fq_question; ?></div>
<!--						 	<div class="floatleft" style="width:50%;"><?php //echo $data->banner_short_dec; ?></div> -->
						 	<div class="floatleft" style="width:5%;text-align:center;"><?php echo anchor('admin_sitepages/edit_faq/'.$data->fq_id,'Edit');?></div>
						 	<div class="floatleft" style="width:5%;text-align:center;"><a href="javascript:void(0);" onclick="javascript:deletefaq(<?php echo $data->fq_id;?>);">Delete</a></div>
						</div>
						<div class="clearboth"> </div>
		<?php 
				$count++; 
			}
	/* data list ends here */ 			
		?>
		</div>
		<div class="pagination"><?php  echo $paginate;?></div>
		<div style="clear:both">&nbsp;</div>
	<?php } else { ?>
		<div class="nodata">No FAQ</div>
	<?php }?> 
</div>
<input type="hidden" id="hidfaqId" name="hidfaqId"  value="" />
<?php echo form_close();?>