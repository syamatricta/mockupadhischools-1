<div class="profile_personal_left"><img  src="<?php  echo ssl_url_img(); ?>register/reg_shipping_left.jpg" /></div>
 <div class="register_step2_shipping_middle" >
	<div class="contents_registermain" >
		<div class="floatleft">&nbsp;</div>
		<div class="floatleft"><input type="checkbox" name="bsame" id="bsame"    onclick="javascript:checkbilling(),checkrate1();" />
		  Billing Address is same as Shipping Address </div>
		<div class="clearboth"></div>
		<div class="leftside_register">Address<span class="red_star">*</span></div>
		<div class="middlecolon_register">&nbsp;</div>
		<div class="rightsidedata_register"><input type="text" name="b_address" id="b_address" class="textwidth font-size_regpage_input" maxlength="128"  value="<?php echo set_value('b_address'); ?>" onblur="javascript:checkrate1(); "/></div>
		
		<div class="leftsideheadings_register">State<span class="red_star">*</span></div>
		<div class="middlecolon_register">&nbsp;</div>
		<div class="rightsidedata_register"> <select name="b_state"  id="b_state" class="selecttextwidth" onchange="javascript:checkrate1();">
											<option value="">Select</option>
											<?php 
											foreach($state as $state1){?>
											<option value="<?php echo $state1['state_code'];?>"  <?php if(set_value('b_state')==$state1['state_code']){?> selected="selected" <?php } ?>><?php echo $state1['state'];?></option>
											<?php }?>
											</select>
		</div>
		<div class="clearboth"></div>
		<div class="leftside_register">Country&nbsp;</div>
		<div class="middlecolon_register">&nbsp;</div>
		<div class="rightsidedata_register"><div style="float:left; padding-top:3px; padding-left:10px;"> <label id="lblcountry">United States</label></div><input type="hidden" name="b_country" id="b_country" value="US">
		</div>
		<div class="leftsideheadings_register">City<span class="red_star">*</span></div>
		<div class="middlecolon_register">&nbsp;</div>
		<div class="rightsidedata_register"> <input type="text" name="b_city" id="b_city" class="textwidth font-size_regpage_input" maxlength="128"  value="<?php echo set_value('b_city'); ?>" onblur="javascript:checkrate1(); "/></div>
		
		<div class="leftside_register">Zipcode<span class="red_star">*</span></div>
		<div class="middlecolon_register">&nbsp;</div>
		<div class="rightsidedata_register"> <input type="text" name="b_zipcode" id="b_zipcode"  class="textwidth font-size_regpage_input" maxlength="5" value="<?php echo set_value('b_zipcode'); ?>" onblur="javascript:checkrate1(); "/></div>
		<div class="clearboth"></div>
		<div class="leftsideheadings_register">&nbsp;</div>
		<div class="middlecolon_register"> &nbsp;</div>
		<div class="floatleft"><span class="instruction">Zipcode must be 5 digits</span></div>
	</div>
</div>
<div class="profile_personal_right"><img  src="<?php   echo ssl_url_img(); ?>register/reg_shipping_right.jpg" /></div>	