<div class="register_step2_billing_middle" >
	<div class="contents_addmain" >
		<div class="testbox_label_edit_profile">Address<span class="madatory">*</span></div>
		<div class="text_box_div"> <input type="text" name="s_address" id="s_address" class="textwidth" maxlength="128" value="<?php if(isset($shipping['s_address']))echo $shipping['s_address'];  else echo set_value('s_address');  ?>" onblur="javascript:checkrate1(); "/></div>
        <div class="space_edit_profile"></div>
		<div class="testbox_label_edit_profile">State<span class="madatory">*</span></div>
		<div class="renewcourse_select" onclick="javascript:__fncShowData('stateDiv');return false;"  onmouseout="javascript:hide_div('stateDiv');return false;">
			 <div style="float:left;margin-bottom:10px;height:30px;font-size:18px;">
			 	<input type="text" readonly name="block_s_state" id="block_s_state" class="droplisRenewDivtxtbx" value="<?php if(isset($shipping['s_state']))echo get_statename($shipping['s_state']); else echo set_value('block_s_state'); ?>"/>
				<input type="hidden" readonly name="s_state" id="s_state" class="droplisRenewDivtxtbx" value="<?php if(isset($shipping['s_state']))echo $shipping['s_state']; else echo set_value('s_state'); ?>"/>
			</div>
			<div id="stateDiv" style="display:none; position:relative;z-index:1000;width:302px;" onclick="javascript:__fncShowData('stateDiv');return false;" onmouseover="javascript:__fncShowData('stateDiv');return false;">
				<div class="addnw_dropdownoverflow">
				<?php 
					foreach($state as $state1){?>
					 <div id="stateDiv<?php echo $state1['state_code'];?>" class="addnw_droplisRenewDiv"  onmouseover="javascript:__fncShowdiv('stateDiv<?php echo $state1['state_code'];?>');" onmouseout="javascript:__fncChangeColor('stateDiv<?php echo $state1['state_code'];?>');" onclick="javascript:__fncSetSelectedValue('stateDiv<?php echo $state1['state_code'];?>', 'stateDiv', 's_state','<?php echo $state1['state_code'];?>','block_s_state');"><?php echo $state1['state'];?></div>
              	<?php }?>
              	</div>
             </div>
		</div>
		
		<!--<div class="select_box_div"> <select name="s_state"  id="s_state" class="selecttextwidth"  onchange="javascript:checkrate1();">
		  <option value="">Select</option>
		  		<?php 
				foreach($state as $state1){
				if($shipping['s_state'] == $state1['state_code'])  {?>
				<option value="<?php echo $shipping['s_state'];?>"  <?php if($shipping['s_state']== $state1['state_code']){?> selected="selected" <?php } ?>><?php echo $state1['state'];?></option>
				<?php }else{?>
				<option value="<?php echo $state1['state_code'];?>"   <?php if(set_value('s_state')==$state1['state_code']){?> selected="selected" <?php } ?>><?php echo $state1['state'];?></option>
				<?php }}?>
		  </select>
		</div>-->
		<div class="clearboth"></div>
		<div class="testbox_label_edit_profile">Country &nbsp;</div>
		<div class="text_box_space"> <div style="float:left; padding-top:3px; padding-left:10px;"><label id="lblcountry">United States</label></div><input type="hidden" name="s_country" id="s_country" value="US">
		</div>
           <div class="space_edit_profile"></div>
		<div class="testbox_label_edit_profile">City<span class="madatory">*</span></div>
		<div class="text_box_div"><input type="text" name="s_city" id="s_city"   class="textwidth" maxlength="40"  value="<?php if(isset($shipping['s_city']))echo $shipping['s_city'];  else echo set_value('s_city'); ?>" onblur="javascript:checkrate1(); "/></div>
		<div class="clearboth"></div>
		<div class="testbox_label_edit_profile">Zipcode<span class="madatory">*</span></div>
		<div class="text_box_div"> <input type="text" name="s_zipcode" id="s_zipcode"   class="textwidth" maxlength="5" value="<?php if(isset($shipping['s_zipcode']))echo $shipping['s_zipcode']; else echo set_value('s_zipcode');  ?>" onblur="javascript:checkrate1(); "/></div>
        <div class="space_edit_profile"></div>
		<div class="clearboth"></div>
        <div class="testbox_label_edit_profile">&nbsp;</div>
		<div class="floatleft"><span class="instruction">Zipcode must be 5 digits</span></div>
	</div>
</div>