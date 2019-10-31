<?php echo  form_open ('user/change_password', array('name'=>'change_password_form_adhi','id' => 'change_password_form_adhi', 'class' => '',  'onsubmit'=>'javascript: return change_password ();') ); ?>
<div id="maindiv">
	<div id="profileviewmain" >
  	<?php /*functional part */?>
	   <div  class="redheading"> Change <span class="ashheading">Password </span></div>
		<div class="clearboth">&nbsp;</div>
		<div class="examdata" >
			<div class="profile_personal_left"><img  src="<?php  echo $this->config->item('images');?>innerpages/profile_personal_left.jpg" /></div>
			<div class="exam_middle" >
				<div class="change_password_main"  >
					<div class="page_error" id="errordisplay"></div>
					<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error"); ?></div>
					<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
					<div class="exam_left_title">Current Password<span class="red_star">*</span></div>
					<div class="middlecolon">&nbsp;</div>
					<div class="change_password_right"><input type="password" maxlength="50" size="25" name="old_password" id="old_password"></div>
					<div class="clearboth"></div>
					<div class="exam_left_title">New Password<span class="red_star">*</span></div>
					<div class="middlecolon">&nbsp;</div>
					<div class="change_password_right"><input type="password" maxlength="50" size="25" name="new_password" id="new_password"></div>
					<div class="clearboth"></div>
					<div class="exam_left_title">Retype Password<span class="red_star">*</span></div>
					<div class="middlecolon">&nbsp;</div>
					<div class="change_password_right"><input type="password" maxlength="50" size="25" name="confirm_password" id="confirm_password"></div>
					<div class="clearboth"></div>
					<div class="exam_left_title">&nbsp;</div>
					<div class="middlecolon">&nbsp;</div>
				</div> <?php /* end of listdata */?>
			</div>
			<div class="profile_personal_right"><img  src="<?php  echo $this->config->item('images');?>innerpages/profile_personal_right.jpg" /></div>		
			<div class="clearboth"></div>
			<div class="middlebutton">
				<img src="<?php echo $this->config->item('images').'innerpages/changepassword.jpg'?>" alt="Change Password" style="cursor:pointer" onclick="javascript:return change_password();return false;" />
			</div>
		</div>
	</div>
	<div class="floatleft" >
		<?php echo $this->load->view('user/client_menu');?>
	</div>
</div>
	<?php echo form_close();?>