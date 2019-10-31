<?php echo form_open('admin_meetourstaff', array('name'=>'frmadhischool','id' => 'frmadhischool'));
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
				<div class="floatleft smallpaddingright">Staff : <input type="text" value="<?php echo $search_staff;?>" name="txtStaff" id="txtStaff" />&nbsp;&nbsp;&nbsp;</div>
				<div class="floatleft"> &nbsp;&nbsp;&nbsp;<input type="submit" value="Search" /></div>
			</div>
			<div class="floatright"><a href="<?php echo site_url()."admin_meetourstaff/add_staff"?>">Add new staff</a></div>
			<?php 
			if(count($staff) > 0){
				/* list headings starts here*/		
			?>
			<div class="listdata">
				
				<div class="clearboth">&nbsp;</div>
				<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");   ?></div>
				<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
				<div class="clearboth"> </div>
				<div class="admintopheads">
					<div class="adminlistheadings" style="width:5%; text-align:center;">Sl. No</div>
					<div class="adminlistheadings" style="width:80%;">Staff</div>
					<div class="adminlistheadings" style="width:15%;text-align:center;">Actions</div>
				</div>
			</div>
			<div class="clearboth"> </div>
		<?php  
	/* list headings ends here*/
				$count=1; 
			   if ($this->uri->segment(3)){
					$count = $count+$this->uri->segment(3);
				} 
				   foreach($staff as $data){
				  $bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';
	/* data list starts here */ 
				 ?>
				  <div class="<?php print($bg_color);?>">
				 	<div class="floatleft" style="width:5%;  text-align:center;"><?php print $count;?></div> 
				 	<div class="floatleft" style="width:10%;">
				 		<img src="<?php echo $this->config->item('staff_image_upload_url').$data->photo; ?>" style="margin-left:10px;width:50px;display: block" />
				 	</div>
				 	<div class="floatleft" style="width:70%;"><?php echo "<b>".$data->name."</b><br /><br />". $data->description;?></div>
				 	<div class="floatleft" style="width:15%;text-align:center;">
						<?php echo anchor('admin_meetourstaff/view_staff/'.$data->id.'/'.$segment,'View')?>&nbsp;|&nbsp;
						<?php echo anchor('admin_meetourstaff/edit_staff/'.$data->id.'/'.$segment,'Edit');?>&nbsp;|&nbsp; 
						<a href="javascript:void(0);" onclick="javascript:deleteStaff('<?php echo $data->id; ?>','<?php echo $segment; ?>'); return false;" />Delete</a>
					</div> 
				</div>
				<div class="clearboth"> </div>
				<?php $count++; 
	/* data list ends here */ 			
			}?>
			<div class="pagination"><?php  echo $paginate;?></div>
			<div style="clear:both">&nbsp;</div>
			<?php }else { ?>
				<div class="nodata">No Staffs</div>
			<?php }?>
		</div>
		
</div>
<input type="hidden" id="hidstaffid" name="hidstaffid"  value="<?php if(isset($_POST['hidstaffid'])){echo $_POST['hidstaffid'];}?>" />
<?php echo form_close();?>