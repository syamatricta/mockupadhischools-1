<?php echo form_open(c('admin_login_url'));?>
	<div class="adminmainlist">
		<div class="admininnercontentdiv">
			<div class="adminmaindiv">
				<div class="floatleft"><img  src="<?php  echo $this->config->item('images');?>loginkey.jpg" /></div>
				<div class="floatleft" >
					<div class="floatleft"><img  src="<?php  echo $this->config->item('images');?>logintext.jpg" /></div>
					<div class="clearboth"></div>
					<div  id="error"  class="page_error" style="width:240px;" id="display_error">	</div>
					<div class="page_error" style="width:350px;" id="display_error">
						<?php if(validation_errors()){echo validation_errors();	}
						if($this->session->flashdata('msg'))
								echo $this->session->flashdata('msg');
                                                if($this->uri->segment("2") == "sub")
                                                    echo "Your account has been deleted. Please contact administrator.";
                                                ?>
					</div>	
					<div class="logintext">Please enter username and password</div>
					<div class="clearboth"></div>
					<div class="floatleft" style="width:240px;">
						<div class="adminlogin">User Name</div>
						<div class="adminlogin"><input type="text" name="username"  maxlength="50"  value="<?php echo set_value('username')?>" id="username" style="width:200px;" /></div>
					</div>
					<div class="clearboth"></div>
					<div class="floatleft" style="width:240px;">
						<div class="adminlogin">Password</div>
						<div class="adminlogin"><input type="password"  maxlength="20"  name="password" value="" id="password" style="width:200px;"/></div>
					</div>
                                        <div class="clearboth"></div>
					<div class="floatleft" style="width:480px;">
                                                <div class="adminlogin">&nbsp;</div>
						<div class="rightsidedata_register" id="captcha_display" ><?php echo $captcha_details['image']; ?></div>
                                                <div class="cantview"><span class="bluelabelcaptcha"><a  class="bluelabelcaptcha" href="javascript: void(null);" id="catcha_link" onclick="javascript: regenerate_captcha ('captcha_display'); return false;">Can't view this word?</a></span></div>
						
					</div>
                                        <div class="clearboth">&nbsp;</div>
                                        <div class="clearboth"></div>
					<div class="floatleft" style="width:240px;">
						<div class="adminlogin">Verification Code<span class="red_star">*</span></div>
						<div class="adminlogin"><input type="text"  name="captcha_code" value="" id="captcha_code" style="width:200px;"/></div>
					</div>
					<div class="clearboth"></div>
					<div class="floatleft" style="width:240px;">
						<div class="adminlogin">&nbsp;</div>
						<div class="adminlogin"><input type="submit" value="Login" onclick="javascript:return validateLogin();"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo form_close();?>