<div class="profile_personal_left"><img  src="<?php   echo ssl_url_img(); ?>register/reg_step2_biling_left.jpg" /></div>
 <div class="register_step2_billing_middle" >
	<div class="contents_registermain">
		<div class="leftside_register">Address<span class="red_star">*</span></div>
		<div class="middlecolon_register">&nbsp;</div>
		<div class="rightsidedata_register"> <input type="text" name="s_address" id="s_address"   class="textwidth" maxlength="128" value="<?php if($this->session->userdata('address'))echo 	$this->session->userdata('address'); else echo set_value('s_address'); ?>" onblur="javascript:checkrate1(); "/></div>
		<div class="leftsideheadings_register">State<span class="red_star">*</span></div>
		<div class="middlecolon_register">&nbsp;</div>
		<div class="rightsidedata_register"> <select name="s_state"  id="s_state" class="selecttextwidth" onchange="javascript:checkrate1();" >
											<option value="">Select</option>
											<?php 
											foreach($state as $state2){?>
											<option value="<?php echo $state2['state_code'];?>"  <?php if($this->session->userdata('state')==$state2['state_code']) {?> selected="selected" <?php } else if(set_value('s_state')==$state2['state_code']){?> selected="selected" <?php } ?> ><?php echo $state2['state'];?></option>
											<?php }?>
											</select>
		</div>
		<div class="clearboth"></div>
		<div class="leftside_register">Country&nbsp;</div>
		<div class="middlecolon_register">&nbsp;</div>
		<div class="rightsidedata_register"><div style="float:left; padding-top:3px; padding-left:10px;"> <label id="lblcountry">United States</label></div><input type="hidden" name="s_country" id="s_country" value="US">
		</div>
		<div class="leftsideheadings_register">City<span class="red_star">*</span></div>
		<div class="middlecolon_register">&nbsp;</div>
		<div class="rightsidedata_register"><input type="text" name="s_city" id="s_city"   class="textwidth" maxlength="40"  value="<?php if($this->session->userdata('city'))echo 	$this->session->userdata('city'); else echo set_value('s_city'); ?>" onblur="javascript:checkrate1(); "/></div>
		
		<div class="leftside_register">Zipcode<span class="red_star">*</span></div>
		<div class="middlecolon_register">&nbsp;</div>
		<div class="rightsidedata_register"> <input type="text" name="s_zipcode" id="s_zipcode"   class="textwidth" maxlength="5" value="<?php if($this->session->userdata('zipcode'))echo 	$this->session->userdata('zipcode'); else echo set_value('s_zipcode'); ?>" onblur="javascript:checkrate1(); "/></div>
		<div class="clearboth"></div>
		<div class="leftsideheadings_register">&nbsp;</div>
		<div class="middlecolon_register"> &nbsp;</div>
		<div class="floatleft"><span class="instruction">Zipcode must be 5 digits</span></div>
	</div>
</div>
<div class="profile_personal_right"><img  src="<?php   echo ssl_url_img(); ?>register/reg_step2_billing_right.jpg" /></div>	