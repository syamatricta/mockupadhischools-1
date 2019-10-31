<?php echo  form_open ('admin/change_password', array('name'=>'change_password_form_adhi','id' => 'change_password_form_adhi', 'class' => '',  'onsubmit'=>'javascript: return change_password ();') ); ?>
<div class="adminmainlist">
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo ucfirst($page_title)?></div>
	</div> 
  	<?php /*functional part */?>
	   
		<div class="admininnercontentdiv">
			<div class="page_error" id="errordisplay"></div>
			<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error"); ?></div>
			<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
			<div class="floatleft" style="width:27%;">&nbsp;</div>
			<div class="floatleft"  style="width:13%;">Current Password<span class="red_star">*</span></div>
			<div class="floatleft">&nbsp;</div>
			<div class="floatleft" ><input type="password" maxlength="50" size="25" name="old_password" id="old_password"></div>
			<div class="clearboth">&nbsp;</div>
			
			<div class="floatleft" style="width:27%;">&nbsp;</div>
			<div class="floatleft" style="width:13%;">New Password<span class="red_star">*</span></div>
			<div class="floatleft">&nbsp;</div>
			<div class="floatleft"><input type="password" maxlength="50" size="25" name="new_password" id="new_password"></div>
			<div class="clearboth">&nbsp;</div>
			
			<div class="floatleft" style="width:27%;">&nbsp;</div>
			<div class="floatleft" style="width:13%;">Retype Password<span class="red_star">*</span></div>
			<div class="floatleft">&nbsp;</div>
			<div class="floatleft"><input type="password" maxlength="50" size="25" name="confirm_password" id="confirm_password"></div>
			<div class="clearboth"></div>
			<div class="floatleft">&nbsp;</div>
			<div class="floatleft">&nbsp;</div>
		</div> 
			<div class="clearboth"></div>
		<div class="middlebutton">
			<img src="<?php echo $this->config->item('images').'innerpages/changepassword.jpg'?>" style="cursor:pointer" onclick="javascript:return change_password();return false;" />
		</div>

</div>
	<?php echo form_close();?>
	
