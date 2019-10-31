<?php echo  form_open ('forgot-password', array('name'=>'forgot_password_form_adhi','id' => 'forgot_password_form_adhi', 'class' => '',  'onsubmit'=>'javascript: return forgot_password ();') ); ?>
<div id="maindiv">
	<div id="forgotmain" >
  	<?php /*functional part */?>
	   <div  class="redheading"> Forgot <span class="ashheading">Password? </span></div>
		<div class="clearboth">&nbsp;</div>
		<div class="forgotdata" >
			<div class="profile_personal_left"><img  src="<?php  echo $this->config->item('images');?>innerpages/profile_personal_left.jpg" /></div>
			<div class="forgot_middle" >
				<div class="change_password_main"  >
					<div class="forgotpasswordtext">
						Forgot your password? Enter your login email below. We will send you an email with  password.
					</div>
					<div class="page_error" id="errordisplay"></div>
					<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error"); ?></div>
					<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
					<div class="exam_left_title">Email Address<span class="red_star">*</span></div>
					<div class="middlecolon">&nbsp;</div>
					<div class="change_password_right"><input type="text" maxlength="50" size="30" name="email" id="email"></div>
					<div class="clearboth"></div>
				</div> 
			</div>
			<div class="profile_personal_right"><img  src="<?php  echo $this->config->item('images');?>innerpages/profile_personal_right.jpg" /></div>		
			<div class="clearboth"></div>
			<div class="middlebutton">
				<img src="<?php echo $this->config->item('images').'innerpages/submit.jpg'?>" alt="Submit" style="cursor:pointer" onclick="javascript:return forgot_password();" />
			</div>
		</div>
	</div>
</div>
<?php echo form_close();?>