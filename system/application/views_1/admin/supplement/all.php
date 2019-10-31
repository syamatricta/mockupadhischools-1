<?php 
echo form_open('supplement/all/', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="adminmainlist">
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div>
	<div class="clearboth"> </div>
	<div class="admininnercontentdiv">		
		<div class="listdata">
			<div id="errordisplay" class="page_error"><?php if (isset($error) && ''!= $error) : echo ''.$error.''; endif;?></div>
			<div class="page_error"><?php echo $this->session->flashdata("error"); ?></div>
			<div class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success"); ?></div>
			<div align="right" class="floatleft" style="width: 99%; text-align: right; border: 1px solid rgb(153, 153, 153); padding: 5px; background: none repeat scroll 0% 0% rgb(232, 227, 220);">
				<div class="floatleft smallpaddingright">
					Course : 
					<select name="course_id" id="course_id" >
					<option value="">All</option>
					<?php 
					foreach($courses as $course){ ?>
						<option value="<?php echo $course->id?>"<?php echo ($this->input->post('course_id')==$course->id)?"Selected":''?> ><?php echo $course->course_name?></option>			
					<?php }?>
					</select>&nbsp;&nbsp;&nbsp;
				</div>				
				<div class="floatleft"> &nbsp;&nbsp;&nbsp;<input type="button" value="Search" onclick="javascript:fncSearch()" /></div>
			</div>
			<div class="clearboth"> &nbsp;</div>
			<div class="floatright"><a href="<?php echo site_url()."supplement/add"?>">Add New Supplement</a></div>
			<div class="clearboth"> &nbsp;</div>
			<div class="admintopheads">
				<div class="adminlistheadings" style="width:5%; text-align:center;">Sl. No</div>
				<div class="adminlistheadings" style="width:40%;">Course</div>
				<div class="adminlistheadings" style="width:35%;">Edition</div>				
				<div class="adminlistheadings" style="width:20%;">Actions</div>
			</div>
		</div>
		<div class="clearboth"> </div>
		<?php
		if(count($supplement_details) > 0){
			$count=1; 
			$weight = 0;
			if ($this->uri->segment(3)){
				$count = $count+$this->uri->segment(3);
			}
			foreach($supplement_details as $data){
				$bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';
				?>
				<div class="<?php print($bg_color);?>">
					<div class="floatleft" style="width:5%;  text-align:center;"><?php print $count; ?></div> 
					<div class="floatleft" style="width:40%;"><?php echo $data->course_name	; ?></div> 
					<div class="floatleft" style="width:35%;">Edition <?php echo $data->edition_no	; ?><?php echo ($data->default_edition==1)?"<b> (Default)</b>":""	; ?></div> 
					<div class="floatleft" style="width:20%;"><?php echo anchor('supplement/edit/'.$data->course_id.'/'.$data->edition_id, 'Edit');?> <a class="delete_all" onclick="deleteAllSupplements(<?php echo $data->course_id;?>, <?php echo $data->edition_id;?>,'<?php echo $data->course_name	; ?>','<?php echo $data->edition_no	; ?>');" >Delete</a></div>
				</div>
				<div class="clearboth"> </div>
			<?php $count++; } ?>
		</div>
		<div class="pagination"><?  echo $paginate;?></div>
		<div style="clear:both">&nbsp;</div>
	<?php } else { ?>
	<div class="nodata">No supplements available</div>
	<?php }?>
</div>
<?php echo form_close();?>