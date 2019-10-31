	<div class="profile_personal_middle_edit" >
		    	<div class="testbox_label_edit_profile">Address<span class="madatory"> *</span></div>
				<div class="text_box_div"><input type="text" name="txtAddress" id="txtAddress" size="25" maxlength="250" value="<?php echo $userdetails->address; ?>" /></div>
                <div class="space_edit_profile"></div>
                <div class="testbox_label_edit_profile">City<span class="madatory"> *</span></div>
				<div class="text_box_div"><input type="text" name="txtCity" id="txtCity" size="25" maxlength="250" value="<?php echo $userdetails->city; ?>" /></div>

				<div class="testbox_label_edit_profile">State<span class="madatory"> *</span></div>
				<div class="select_box_div">
					<select name="cmbstate" id="cmbstate" class="styled">
						<option value="">Select State</option>
						<?php foreach($allstate as $state_p){?>
						<option value="<?php echo $state_p->state_code;?>"  <?php if($state_p->state_code == $state->state_code){?> selected="selected" <?php } ?>><?php echo $state_p->state;?></option>
						<?php } ?>
				        
				     </select>
				</div>
                <div class="space_edit_profile"></div>
                <div class="testbox_label_edit_profile">Zip Code<span class="madatory"> *</span></div>
				<div class="text_box_div"><input type="text" name="txtZip" id="txtZip" size="25" maxlength="5" onkeyup="isNumber(this)" value="<?php echo $userdetails->zipcode; ?>" /></div>
				<div class="testbox_label_edit_profile">Country </div>
				<div class="text_box_space" style="line-height:20px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if('US' == $userdetails->country) { echo "United States";} ?></div>
                <div class="space_edit_profile"></div>
				<div class="testbox_label_edit_profile">&nbsp;</div>
                <div class="text_box_space"><span class="instruction">Zipcode must be 5 digits</span></div>
	</div>
				
				