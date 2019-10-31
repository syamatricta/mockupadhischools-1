<?php echo form_open('admin_meta/meta_data/', array('name'=>'frmadhischool','id' => 'frmadhischool'));?>	
<div class="adminmainlist">
		<div class="adminpagebanner">
			<div class="adminpagetitle"><?php echo $page_title?></div>
		</div>
		<div class="clearboth"></div>
		<div class="page_error paddingleft" id="errordisplay"><?php if($this->session->flashdata('error')){ echo $this->session->flashdata('error');}?></div>
		<div class="page_success paddingleft"><?php if($this->session->flashdata('success')){ echo $this->session->flashdata('success');}?></div>
		
		<div class="clearboth"></div>
		<div class="floatleft" style="width:97%;text-align:right"><a href="<?php echo site_url()."/admin_meta/add"?>">Add New Meta Tag</a></div>
		<div class="clearboth"> </div>
		<div class="admininnercontentdiv">
			<div class="listdata">
				<div class="admintopheads">
					<div class="adminlistheadings" style="width:5%; text-align:center;">Sl. No</div>
					<div class="adminlistheadings" style="width:15%;">Page Name</div>
					<div class="adminlistheadings" style="width:20%;">Page Title</div>
					<div class="adminlistheadings" style="width:15%;">Keywords</div>
					<div class="adminlistheadings" style="width:20%;">Description</div>
					<div class="adminlistheadings" style="width:20%;">Actions</div>
				</div>
			</div>
			<div class="clearboth"> </div>
		<?php  
	/* list headings ends here*/
		 if(count($meta_data) > 0) {	?>
		<?php  
		   $count = $offset + 1; 
		   foreach($meta_data as $meta) {
		
				  $bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';
	/* data list starts here */ 
					?>
						<div class="<?php print($bg_color);?>">
						 	<div class="floatleft" style="width:5%;  text-align:center;"><?php print $count;?></div> 
						 	<div class="floatleft" style="width:15%;"><?php echo substr($meta->meta_page_name,0,30); ?></div> 
						 	<div class="floatleft" style="width:20%;"><?php echo substr($meta->meta_page_title,0,30).(strlen($meta->meta_page_title)>30?'....':''); ?></div> 
						 	<div class="floatleft" style="width:15%;"><?php echo substr($meta->meta_keyword,0,30).(strlen($meta->meta_keyword)>30?'....':'');  ?></div> 
						 	<div class="floatleft" style="width:20%;"><?php echo substr($meta->meta_description,0,30).(strlen($meta->meta_description)>30?'....':''); ?></div> 
						 	<div class="floatleft" style="width:20%;">
								<a href="<?php echo base_url().'admin_meta/view/'.$meta->meta_id;?>" title="View">View</a>&nbsp;
								<a  href="<?php echo base_url().'admin_meta/edit/'.$meta->meta_id;?>". title="Edit Meta" >Edit</a>&nbsp;
								<a href="javascript:void(0)" onclick="javascript:deleteMeta(<?php echo $meta->meta_id;?>);" title="Delete">Delete</a>
						 	</div> 
						</div>
						<div class="clearboth"> </div>
				<?php 
				$count++; 
				}
	/* data list ends here */ 			
			?>
		</div>
		<div class="pagination"><?  echo $paginate;?></div>
		<div style="clear:both">&nbsp;</div>
	<?php } else { ?>
			<div class="nodata">No Meta Tag</div>
		<?php }?> 
</div>

<?php echo form_close();?>