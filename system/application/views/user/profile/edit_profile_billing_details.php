<div class="profile_personal_middle_edit" >
	<div class="testbox_label_edit_profile">Address<span class="madatory"> *</span></div>
	<div class="text_box_div">
		<input type="text" name="b_txtAddress" id="b_txtAddress" size="25" maxlength="250" value="<?php echo $userdetails->b_address; ?>" />
	</div>
    
    <div class="space_edit_profile"></div>
    <div class="testbox_label_edit_profile">City<span class="madatory"> *</span></div>
    <div class="text_box_div"><input type="text" name="b_txtCity" id="b_txtCity" size="25" maxlength="64" value="<?php echo $userdetails->b_city; ?>" /></div>
	<div class="testbox_label_edit_profile">State<span class="madatory"> *</span></div>
	<div class="select_box_div">
		<select name="cmbstate_b" id="cmbstate_b" class="styled">
			<option value="">Select State</option>
			<?php foreach($allstate as $state_b) :?>
				<option 
					value="<?php echo $state_b->state_code;?>"  
					<?php echo ($state_b->state_code == @$b_state->state_code) ?  'selected="selected"' : ''; ?>>
					<?php echo $state_b->state;?>
				</option>
			<?php endforeach; ?>
		</select>
	</div>
	
	<div class="space_edit_profile"></div>
	<div class="testbox_label_edit_profile">Zip Code<span class="madatory"> *</span></div>
	<div class="text_box_div">
		<input type="text" name="b_txtZip" id="b_txtZip" size="25" onkeyup="isNumber(this)" maxlength="5" value="<?php echo $userdetails->b_zipcode; ?>" />
	</div>
	
	<!--<div class="testbox_label_edit_profile">Country </div>
	<div class="text_box_space" style="line-height:20px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if('US' == $userdetails->b_country) { echo "United States";}?></div>-->
	
	<div class="space_edit_profile"></div>
	<div class="testbox_label_edit_profile">&nbsp; </div>
	<div class="text_box_space" style="line-height:20px;">&nbsp;</div>
	
	<div class="space_edit_profile"></div>
	<div class="testbox_label_edit_profile">&nbsp;</div>
	<div class="text_box_space" style="width:200px;"><span class="instruction">Zipcode must be 5 digits</span></div>
</div>