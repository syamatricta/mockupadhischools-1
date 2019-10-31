<div class="profile_personal_left"><img  src="<?php  echo $this->config->item('images');?>register/reg_shipping_left.jpg" /></div>
 <div class="register_step2_shipping_middle" >
	<div class="contents_registermain" >
		<div class="floatleft">&nbsp;</div>
	
		<div class="clearboth"></div>
		<div class="leftside_register">Address<span class="red_star">*</span></div>
		<div class="middlecolon_register">&nbsp;</div>
		<div class="rightsidedata_register"><input type="text" name="b_address" id="b_address" class="textwidth" maxlength="128"  value="<?php if(isset($billing['b_address']))echo $billing['b_address']; else echo set_value('b_address'); ?>" /></div>
		
		<div class="leftsideheadings_register">State<span class="red_star">*</span></div>
		<div class="middlecolon_register">&nbsp;</div>
		<div class="rightsidedata_register"> <select name="b_state"  id="b_state" class="selecttextwidth" >
											<option value="">Select</option>
												<?php 
												foreach($state as $state1){
												if($billing['b_state'] == $state1['state_code'])  {?>
												<option value="<?php echo $billing['b_state'];?>"  <?php if($billing['b_state']== $state1['state_code']){?> selected="selected" <?php } ?>><?php echo $state1['state'];?></option>
												<?php }else{?>
												<option value="<?php echo $state1['state_code'];?>"   <?php if(set_value('b_state')==$state1['state_code']){?> selected="selected" <?php } ?>><?php echo $state1['state'];?></option>
												<?php }}?>
												</select>
		</div>
		<div class="clearboth"></div>
		<div class="leftside_register">Country</div>
		<div class="middlecolon_register">&nbsp;</div>
		<div class="rightsidedata_register"><div style="float:left; padding-top:3px; padding-left:10px;"> <label id="lblcountry">United States</label></div><input type="hidden" name="b_country" id="b_country" value="US">
		</div>
		<div class="leftsideheadings_register">City<span class="red_star">*</span></div>
		<div class="middlecolon_register">&nbsp;</div>
		<div class="rightsidedata_register"> <input type="text" name="b_city" id="b_city" class="textwidth" maxlength="128"  value="<?php if(isset($billing['b_city']))echo $billing['b_city']; else echo set_value('b_city'); ?>"/></div>
		
		<div class="leftside_register">Zipcode<span class="red_star">*</span></div>
		<div class="middlecolon_register">&nbsp;</div>
		<div class="rightsidedata_register"> <input type="text" name="b_zipcode" id="b_zipcode"  class="textwidth" maxlength="5" value="<?php if(isset($billing['b_zipcode']))echo $billing['b_zipcode']; else echo set_value('b_zipcode'); ?>" /></div>
		<div class="clearboth"></div>
		<div class="leftsideheadings_register">&nbsp;</div>
		<div class="middlecolon_register"> &nbsp;</div>
		<div class="floatleft"><span class="instruction">Zipcode must be 5 digits</span></div>
	</div>
</div>
<div class="profile_personal_right"><img  src="<?php  echo $this->config->item('images');?>register/reg_shipping_right.jpg" /></div>	