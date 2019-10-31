<div class="profile_personal_middle_edit" >
	<div class="testbox_label_edit_profile">Address<span class="madatory"> *</span></div>
	<div class="text_box_div">
		<input type="text" name="s_txtAddress" id="s_txtAddress" size="25" maxlength="250" value="<?php echo $userdetails->s_address; ?>" />
	</div>
	
	<div class="space_edit_profile"></div>
	<div class="testbox_label_edit_profile">City<span class="madatory"> *</span></div>
	<div class="text_box_div">
		<input type="text" name="s_txtCity" id="s_txtCity" size="25" maxlength="64" value="<?php echo $userdetails->s_city; ?>" />
	</div>
	
	<div class="testbox_label_edit_profile">State<span class="madatory"> *</span></div>
	<div class="select_box_div">
		<select name="cmbstate_s" id="cmbstate_s" class="styled">
			<option value="">Select State</option>
			<?php foreach($allstate as $state_s) : ?>
				<option 
					value="<?php echo $state_s->state_code;?>"  
					<?php echo ($state_s->state_code == $s_state->state_code) ? ' selected="selected"' : ""; ?>>
					<?php echo $state_s->state;?>
				</option>
			<?php endforeach; ?>
		</select>	
	</div>
	
	<div class="space_edit_profile"></div>
    <div class="testbox_label_edit_profile">Zip Code<span class="madatory"> *</span></div>
	<div class="text_box_div">
		<input type="text" name="s_txtZip" id="s_txtZip" size="25" maxlength="5" onkeyup="isNumber(this)" value="<?php echo $userdetails->s_zipcode; ?>" />
	</div>
	
	<!--<div class="testbox_label_edit_profile">Country </div>
	<div class="text_box_space" style="line-height:20px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if('US' == $userdetails->s_country) { echo "United States";} ?></div>-->
	
	<div class="space_edit_profile"></div>
	<div class="testbox_label_edit_profile">&nbsp;</div>
    <div class="text_box_space"><span class="instruction">&nbsp;</span></div>
                
    <div class="space_edit_profile"></div>
	<div class="testbox_label_edit_profile">&nbsp;</div>
    <div class="text_box_space" style="width:200px;"><span class="instruction">Zipcode must be 5 digits</span></div>
</div>