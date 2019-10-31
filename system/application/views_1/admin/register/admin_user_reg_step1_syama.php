<div class="clearboth"></div>
<form name="registerform" id="myform" method="post" action="">
	<div id="maindiv" style="width:1023px;">
		<div id="registerviewmain">
			<div class="stmain">
				<div class="floatleft"><span class="registerredheading">Registration</span>&nbsp;&nbsp;<span class="register_step">Step 1 </span></div>
				<div class="clearboth"></div>
				<div class="registerinnerregistercontentdiv" >
					<div class="page_error" id="errordisplay"></div>
					<div  class="page_error" id="errordiv" ><?php if(isset($msg)) echo $msg; ?></div>
					<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("msg");   ?></div>
					<?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
					<div class="clearboth"></div>
						<div class="listregistermain">
							<div class="profile_personal_left"><img  src="<?php  echo $this->config->item('images');?>register/registration_step1_left.jpg" /></div>
							<div class="register_step1_middle"  >
								<div class="contents_registermain" >
									<div class="clearboth">&nbsp;</div>
									<div class="leftside_register">First Name<span class="red_star">*</span></div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_register"><input type="text" name="firstname" id="firstname" class="textwidth" onblur="javascript:populate_certificate_name();" maxlength="128"  value="<?php echo set_value('firstname'); ?>"/></div>
									
									<div class="leftsideheadings_register">Last Name<span class="red_star">*</span></div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_register"><input type="text" name="lastname" id="lastname" class="textwidth" onblur="javascript:populate_certificate_name();" maxlength="128"  value="<?php echo set_value('lastname'); ?>"/></div>
									<div class="clearboth"></div>
									
									<div class="leftside_register">Certificate Name<span class="red_star">*</span></div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_register"><input type="text" readonly name="name_on_certificate" id="name_on_certificate" class="textwidth" maxlength="255"  value="<?php echo $this->input->post('name_on_certificate'); ?>"/></div>
									<div class="clearboth"></div>
									
									<div class="leftside_register">E-mail<span class="red_star">*</span></div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_register"><input type="text" name="email" id="email"  class="textwidth" maxlength="128" value="<?php echo set_value('email'); ?>"/></div>
									
									<div class="leftsideheadings_register">Confirm E-mail<span class="red_star">*</span></div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_register"><input type="text" name="confirmemail" id="confirmemail" class="textwidth" maxlength="128" value="<?php echo set_value('confirmemail'); ?>"/></div>
									<div class="clearboth"></div>
			
									<div class="leftside_register">Password<span class="red_star">*</span></div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_register"><input type="password" name="psword" id="psword"  class="textwidth" maxlength="128"  value=""/></div>
									
									<div class="leftsideheadings_register">Confirm Password<span class="red_star">*</span></div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_register"><input type="password" name="psword1" id="psword1"  class="textwidth" maxlength="128"  value=""/></div>
									<div class="clearboth">&nbsp;</div>
									
									<div class="leftside_register"> Shipping Address<span class="red_star">*</span></div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_register"><input type="text" name="address" id="address"  class="textwidth" maxlength="128" value="<?php echo set_value('address'); ?>"/></div>
									
									<div class="leftsideheadings_register">Unit Number</div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_register"><input type="text" name="unitnumber" id="unitnumber" class="textwidth" maxlength="7"  value="<?php echo $this->input->post('unitnumber'); ?>"/></div>
									<div class="clearboth"></div>
									
									<div class="leftside_register">City<span class="red_star">*</span></div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_register"><input type="text" name="city" id="city" class="textwidth" maxlength="128" value="<?php echo set_value('city'); ?>"/></div>
									
									<div class="leftsideheadings_register">State<span class="red_star">*</span></div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_register"> 
										<select name="state"  id="state"  class="selecttextwidth">
											<option value="">Select</option>
											<?php
												$state1 = $state;
												$state2 = $state;
												foreach($state as $state):
											?>
												<option value="<?php echo $state['state_code'];?>"  <?php echo (set_value('state') == $state['state_code']) ? 'SELECTED' : '';?>><?php echo $state['state'];?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="clearboth"></div>
									
									<!--<div class="clearboth"></div>
									<div class="leftside_register">Country&nbsp; </div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_register"><div style="float:left; padding-top:3px; padding-left:10px;"><label id="lblcountry">United States</label></div><input type="hidden" name="country" id="country" value="US"></div>-->
									<input type="hidden" name="country" id="country" value="US">
									
									<div class="leftside_register">Zipcode<span class="red_star">*</span></div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_register"><input type="text" name="zipcode" id="zipcode"  class="textwidth" maxlength="5"  value="<?php echo set_value('zipcode'); ?>"/></div>
									
									<div class="leftsideheadings_register">Phone Number<span class="red_star">*</span></div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_register"><input type="text" name="phone" id="phone"   onkeyup="isvalidPhoneNumber(this)" class="textwidth" maxlength="25" value="<?php echo set_value('phone'); ?>"/></div>
									<div class="clearboth"></div>
									
									<!--<div class="leftsideheadings_register">Zipcode<span class="red_star">*</span></div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_register"><input type="text" name="zipcode" id="zipcode"  class="textwidth" maxlength="5"  value="<?php echo set_value('zipcode'); ?>"/></div>
									<div class="clearboth"></div>-->
									
									<div class="leftside_register">&nbsp;</div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_phone_instru"><span class="instruction">&nbsp;Zipcode must be 5 digits</span></div>
									<div class="leftsideheadings_register">&nbsp;</div>
									
									<div class="leftside_register">&nbsp;</div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_phone_instru"><!-- Phone Number format should be<br /> 1.(xxx) xxx xxxx  2.(xxx) xxx-xxxx  3.xxx-xxx-xxxx--></div>
									<div class="leftsideheadings_register">&nbsp;</div>
									
									<!--<div class="middlecolon_register"> &nbsp;</div>
									<div class="rightsidedata_register"><span class="instruction">&nbsp;Zipcode must be 5 digits</span></div>
									<div class="clearboth"></div>-->
									
									<div class="registefloatleft">&nbsp;<input type="hidden" name="step1" id="step1"  value="0" /></div>
									<div class="leftside_register">&nbsp;</div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="leftside_register">
										<img  src="<?php  echo $this->config->item('images');?>/innerpages/nextstep.jpg" onclick="javascript:checkuser();" class="stylebutton" />
									</div>
								</div>
							<?php /*content register main end*/?>
							</div>
						<div class="profile_personal_right"><img  src="<?php  echo $this->config->item('images');?>register/registration_step1_right.jpg" /></div>	
<?php /* registration captcha starts here */?>
						<!--<div class="clearboth" style="padding-top:5px;"></div>							
						<div class="profile_personal_left"><img  src="<?php  echo $this->config->item('images');?>register/reg_captcha_left.jpg" /></div>
							<div class="register_captcha_middle"  >
								<div class="contents_registermain" >
											<div class="clearboth">&nbsp;</div>			
				
											<div class="clearboth"></div>
											<div class="leftside_register">&nbsp;</div>
											<div class="middlecolon_register">&nbsp;</div>
											<div class="rightsidedata_register" id="captcha_display" ><?php echo $captcha_details['image']; ?></div>
											<div class="cantview"><span class="bluelabelcaptcha"><a  class="bluelabelcaptcha" href="javascript: void(null);" id="catcha_link" onclick="javascript: regenerate_captcha ('captcha_display'); return false;">Can't view this word?</a></span></div>
											<div class="clearboth"></div>
											<div class="leftside_register">Verification Code<span class="red_star">*</span></div>
											<div class="middlecolon_register">&nbsp;</div>
											<div class="rightsidedata_register"><input type="text" name="captcha_code" id="captcha_code" class="textwidth"  value="" /></div>
											<div class="registefloatleft">&nbsp;<input type="hidden" name="step1" id="step1"  value="0" /></div>
											<div class="clearboth"></div>
											<div class="leftside_register">&nbsp;</div>
											<div class="middlecolon_register">&nbsp;</div>
											<div class="leftside_register">
											<img  src="<?php  echo $this->config->item('images');?>/innerpages/nextstep.jpg" onclick="javascript:checkuser();" class="stylebutton" />
											</div>
										</div>
							<?php /*content register main end*/?>
							</div>
						<div class="profile_personal_right"><img  src="<?php  echo $this->config->item('images');?>register/reg_captcha_right.jpg" /></div>	-->
<?php /* registration captcha ends here */?>	
										
					<div class="register_instructionmark" style="padding-right:10px; margin-right: 142px;"><span class="instruction">Marked with </span><span class="red_star">*</span> <span class="instruction">are mandatory fields</span></div>
				<div class="clearboth">&nbsp;</div>
				</div>
			<?php /*list register data end*/?>
			</div>
			</div>
		</div>
	</div>
</form>



