<!--<div class="profile_personal_left"><img  src="<?php  echo ssl_url_img();?>register/reg_shipping_left.jpg" /></div>-->
 <div class="register_step2_shipping_middle" >
	<div class="contents_renewmain" >
		<div class="floatleft">&nbsp;</div>
	
		<div class="clearboth"></div>
		<div class="testbox_label_edit_profile">Address<span class="madatory">*</span></div>
		<div class="text_box_div"><input type="text" name="b_address" id="b_address" class="textwidth" maxlength="128"  value="<?php if(isset($billing['b_address']))echo $billing['b_address']; else echo set_value('b_address'); ?>" /></div>
        <div class="space_edit_profile"></div>
		<div class="testbox_label_edit_profile">State<span class="madatory">*</span></div>
		<div class="renewcourse_select" onclick="javascript:__fncShowData('stateDiv');return false;">
			 <div style="float:left;margin-bottom:10px;height:30px;font-size:18px;">
			 	<input type="text" readonly name="block_b_state" id="block_b_state" class="droplisRenewDivtxtbx" value="<?php if(isset($billing['b_state']))echo get_statename($billing['b_state']); else echo set_value('block_b_state'); ?>"/>
			 	<input type="hidden" readonly name="b_state" id="b_state" class="droplisRenewDivtxtbx" value="<?php if(isset($billing['b_state']))echo $billing['b_state']; else echo set_value('b_state'); ?>"/>
			 </div>
			<div id="stateDiv" style="display:none; position:relative; z-index:1000;width:302px;" onclick="javascript:__fncShowData('stateDiv');return false;">
				<div class="addnw_dropdownoverflow">
					<?php 
						foreach($state as $state1){
						if($billing['b_state'] == $state1['state_code'])  {?>
	                <div id="stateDiv<?php echo $state1['state'];?>" class="droplisRenewDiv"  onmouseover="javascript:__fncShowdiv('stateDiv<?php echo $state1['state'];?>');" onmouseout="javascript:__fncChangeColor('stateDiv<?php echo $state1['state'];?>');" onclick="javascript:__fncSetSelectedValue('stateDiv<?php echo $state1['state'];?>', 'stateDiv', 'b_state','<?php echo $state1['state'];?>','block_b_state');"><?php echo $state1['state'];?></div>
	              <?php }else{?>
	              		 <div id="stateDiv<?php echo $state1['state'];?>" class="droplisRenewDiv"  onmouseover="javascript:__fncShowdiv('stateDiv<?php echo $state1['state'];?>');" onmouseout="javascript:__fncChangeColor('stateDiv<?php echo $state1['state'];?>');" onclick="javascript:__fncSetSelectedValue('stateDiv<?php echo $state1['state'];?>', 'stateDiv', 'b_state','<?php echo $state1['state'];?>','block_b_state');"><?php echo $state1['state'];?></div>
	              <?php }}?>
	            </div>
             </div>
		
			<!--<select name="b_state"  id="b_state" class="selecttextwidth" >
				<option value="">Select</option>
					<?php 
					foreach($state as $state1){
					if($billing['b_state'] == $state1['state_code'])  {?>
					<option value="<?php echo $billing['b_state'];?>"  <?php if($billing['b_state']== $state1['state_code']){?> selected="selected" <?php } ?>><?php echo $state1['state'];?></option>
					<?php }else{?>
					<option value="<?php echo $state1['state_code'];?>"   <?php if(set_value('b_state')==$state1['state_code']){?> selected="selected" <?php } ?>><?php echo $state1['state'];?></option>
					<?php }}?>
				</select>-->
		</div>
        <div class="clearboth"></div>
		<div class="testbox_label_edit_profile">Country</div>
		<div class="text_box_space"><div style="float:left; padding-top:3px; padding-left:10px;"> <label id="lblcountry">United States</label></div><input type="hidden" name="b_country" id="b_country" value="US">
		</div>
        <div class="space_edit_profile"></div>
		<div class="testbox_label_edit_profile">City<span class="madatory">*</span></div>
		<div class="text_box_div"> <input type="text" name="b_city" id="b_city" class="textwidth" maxlength="128"  value="<?php if(isset($billing['b_city']))echo $billing['b_city']; else echo set_value('b_city'); ?>"/></div>
		
		<div class="testbox_label_edit_profile">Zipcode<span class="madatory">*</span></div>
		<div class="text_box_div"> <input type="text" name="b_zipcode" id="b_zipcode"  class="textwidth" maxlength="5" value="<?php if(isset($billing['b_zipcode']))echo $billing['b_zipcode']; else echo set_value('b_zipcode'); ?>" /></div>
		<div class="clearboth"></div>
		<div class="leftsideheadings_register">&nbsp;</div>
		<div class="middlecolon_register"> &nbsp;</div>
		<div class="floatleft"><span class="instruction">Zipcode must be 5 digits</span></div>
	</div>
</div>
<!--<div class="profile_personal_right"><img  src="<?php  echo ssl_url_img();?>register/reg_shipping_right.jpg" /></div>	-->