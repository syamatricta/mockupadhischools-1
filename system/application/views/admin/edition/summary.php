<?php 
echo form_open('edition/summary/', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
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
				<div class="floatleft" id="showTypes">
					<div class="floatleft smallpaddingright">
						From : 
						<input type="text" maxlength="50"  name="date_from" id="date_from" readonly value="<?php 
						if('' != $this->input->post('date_from') ){ 
						echo formatDate($this->input->post('date_from'));
						} ?>"/>
						<img  src="<?php  echo $this->config->item('images');?>calendar.gif" alt="calendar" title="calendar" onclick="displayCalendar(document.frmadhischool.date_from,'mm/dd/yyyy',this)"/>
						&nbsp;&nbsp;&nbsp;
						</div>
						<div class="floatleft smallpaddingright">
						To : 
						<input type="text" maxlength="50"  name="date_to" id="date_to" readonly  value="<?php 
						if('' != $this->input->post('date_to')){ echo formatDate($this->input->post('date_to'));}   ?>"/>
						<img  src="<?php  echo $this->config->item('images');?>calendar.gif" alt="calendar" title="calendar"  onclick="displayCalendar(document.frmadhischool.date_to,'mm/dd/yyyy',this)"/>
					</div>
				</div>	
				<div class="floatleft"> &nbsp;&nbsp;&nbsp;<input type="button" value="Search" onclick="javascript:fncSearch()" /></div>
				<div class="floatleft"> &nbsp;&nbsp;&nbsp;<input type="button" value="Clear" onclick="javascript:clearSearch()" /></div>
			</div>
			<div class="clearboth"> &nbsp;</div>
			<div class="floatright"><a href="<?php echo site_url()."edition/add"?>">Add New Edition</a></div>
			<div class="clearboth"> &nbsp;</div>
			<div class="admintopheads">
				<div class="adminlistheadings" style="width:5%; text-align:center;">Sl. No</div>
				<div class="adminlistheadings" style="width:30%;">Course</div>
				<div class="adminlistheadings" style="width:25%;">Edition</div>
				<div class="adminlistheadings" style="width:15%;">From</div>						
				<div class="adminlistheadings" style="width:15%;">To</div>						
				<div class="adminlistheadings" style="width:10%;">Actions</div>
			</div>
		</div>
		<div class="clearboth"> </div>
		<?php		
		if(count($edition_list) > 0){
		$count=1; 
		$weight = 0;
		if ($this->uri->segment(3)){
		$count = $count+$this->uri->segment(3);
		}
		foreach($edition_list as $data){
		$bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';
		?>
		<div class="<?php print($bg_color);?>">
			<div class="floatleft" style="width:5%;  text-align:center;"><?php print $count; ?></div> 
			<div class="floatleft" style="width:30%;"><?php echo $data->course_name	; ?></div> 
			<div class="floatleft" style="width:25%;">Edition <?php echo $data->edition_no	; ?><?php echo ($data->default_edition==1)?"<b> (Default)</b>":""	; ?></div> 
			<div class="floatleft" style="width:15%;"><?php echo formatDate($data->date_from) ; ?></div>
			<div class="floatleft" style="width:15%;"><?php echo ($data->date_to!='')?formatDate($data->date_to):"&nbsp;"; ?> </div>
			<div class="floatleft" style="width:10%;"><?php echo anchor('edition/edit/'.$data->id,'Edit');?></div> 
		</div>
		<div class="clearboth"> </div>
		<?php $count++; } ?>
	</div>
	<div class="pagination"><?  echo $paginate;?></div>
	<div style="clear:both">&nbsp;</div>
	<?php } else { ?>
	<div class="nodata">No courses available</div>
	<?php }?>
</div>
<?php echo form_close();?>