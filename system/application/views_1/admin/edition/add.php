<?php echo form_open('edition/add/', array('name'=>'frmAddEdition','id' => 'frmAddEdition')); ?>
<div class="adminmainlist">	
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
		<div class="clearboth paddingtop"></div>
	</div>	
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">	
		<div id="errordisplay" class="page_error"><?php if (isset($error) && ''!= $error) : echo ''.$error.''; endif;?></div>
		<div class="page_error"><?php echo $this->session->flashdata("error"); ?></div>
		<div class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success"); ?></div>
		<div class="clearboth paddingtop">&nbsp;</div>
		<div class="listdata">
				<div class="floatleft region_leftlabel">Course<span class="red_star">*</span></div>
				<div class="floatleft region_midcolon">:</div>
				<div class="floatleft">
					<select name="course_id" id="course_id" >
						<option value="">Select</option>
						<?php 
							foreach($courses as $course){ ?>
							<option value="<?php echo $course->id?>"<?php echo ($this->input->post('course_id')==$course->id)?"Selected":''?> ><?php echo $course->course_name?></option>			
						<?php }?>
					</select>
				</div>
				<div class="clearboth paddingtop"></div>
				<div class="floatleft region_leftlabel">Edition<span class="red_star">*</span></div>
				<div class="floatleft region_midcolon">:</div>
				<div class="floatleft">
					<input  type="text" id="edition" name="edition" title="edition" value="<?php if(set_value('edition')){ echo set_value('edition');}?>" autocomplete="off" onkeypress="return numbersonly(event)" maxlength="10"/>
					
				</div>
				<div class="floatleft" style="padding-left:10px;">
					<input type="checkbox" name="default_edition" id="default_edition" value="1">
				</div>
				<div class="floatleft" style="padding-top:4px;">Make Default Edition</div>
				<div class="clearboth paddingtop"></div>
				<div class="floatleft region_leftlabel">Date From<span class="red_star">*</span></div>
				<div class="floatleft region_midcolon">:</div>
				<div class="floatleft">
					<input type="text" maxlength="50"  name="date_from" id="date_from" readonly value="<?php 
					if('' != $this->input->post('date_from') ){ 
					echo formatDate($this->input->post('date_from'));
					} ?>"/>
					<img  src="<?php  echo $this->config->item('images');?>calendar.gif" alt="calendar" title="calendar" onclick="displayCalendar(document.frmAddEdition.date_from,'mm/dd/yyyy',this)"/>
					&nbsp;&nbsp;To&nbsp;&nbsp;
					
					<input type="text" maxlength="50"  name="date_to" id="date_to" readonly  value="<?php 
					if('' != $this->input->post('date_to')){ echo formatDate($this->input->post('date_to'));}   ?>"/>
					<img  src="<?php  echo $this->config->item('images');?>calendar.gif" alt="calendar" title="calendar"  onclick="displayCalendar(document.frmAddEdition.date_to,'mm/dd/yyyy',this)"/>
				</div>
				<div class="clearboth paddingtop"></div>
				<div class="subregion_addbutton">
					<input id="edition_add" type="button" onclick="return addEdition();" name="edition_add" value="Add">
					&nbsp;&nbsp;<input type="button" value="Clear" onclick="javascript:clearaddedit()" />
				</div>
				<div class="clearboth"></div>
		</div>
	</div>
	
	<div class="backtolist"><?php echo anchor('edition/summary/','<< Back to Edition Summary')?></div>
 </div>
<?php echo form_close();?>




