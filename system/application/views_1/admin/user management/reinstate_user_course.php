<?php echo form_open_multipart('admin_user/reinstate/'.$user_course_id, array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="adminmainlist">
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div>
	<div class="clearboth"></div>
	
	<div class="admininnercontentdiv">
		<div class="page_error home_error" id="errordisplay"></div>
		<div  class="page_error home_error" id="errordiv"><?php if(isset($err_msg)) echo $err_msg; ?></div>
		<div  class="page_success" id="flashsuccess"><?php if(isset($msg)) echo $msg; ?>&nbsp;</div>
		
		<?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
		
		<div class="listdata">
			<div class="leftsideheadings_view admin_user_left">Re-instate until</div>
			<div class="middlecolon">&nbsp;</div>
			<div class="rightsidedata_view  admin_user_right">
				<input type="text" name="expiry_date" id="expiry_date" class="textwidth"  value="<?php echo set_value('expiry_date'); ?>" readonly/>
				<img  src="<?php  echo ssl_url_img();?>calendar.gif" alt="calendar" title="calendar" onclick="javascript: displayCalendar(document.getElementById('expiry_date'),'mm-dd-yyyy',this)"/>
			</div>
                        
                        <div class="leftsideheadings_view admin_user_left">Reason</div>
			<div class="middlecolon">&nbsp;</div>
			<div class="rightsidedata_view  admin_user_right">
				<textarea type="text" name="reason" id="reason" size="25" maxlength="200" ></textarea>
                        </div>
		</div>
	</div>
	<div class="backtolist">
	  <input type="button" value="Save" onclick="javascript: fnReinstate();" />&nbsp;&nbsp;
          <?php echo anchor('admin_user/user_course_details/'.$userid,"<< Back to user's course list");?>
        </div>
 </div>
<input type="hidden" name="edit_user_course_id" id="edit_user_course_id" value="<?php echo $user_course_id;?>">
<?php echo form_close();?>