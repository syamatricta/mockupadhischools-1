	<div class="profile_personal_middle_edit" >
            <div class="testbox_label_edit_profile">First Name<span class="madatory"> *</span></div>
            <div class="text_box_div"><input type="text" name="txtFirstName" id="txtFirstName" size="25" maxlength="128" value="<?php echo $userdetails->firstname; ?>"/></div>
            <div class="space_edit_profile"></div>
            <div class="testbox_label_edit_profile">Email Id</div>
            <div class="text_box_space" style="line-height:17px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $userdetails->emailid; ?></div>
            <div class="testbox_label_edit_profile">Last Name<span class="madatory"> *</span></div>
            <div class="text_box_div"><input type="text" name="txtLastName" id="txtLastName" size="25" maxlength="128" value="<?php echo $userdetails->lastname; ?>" /></div>
            
            
            <div class="space_edit_profile"></div>
            <div class="testbox_label_edit_profile">Phone<span class="madatory"> *</span></div>
            <div class="text_box_div"><input type="text" name="txtPhone" id="txtPhone" onkeyup="isvalidPhoneNumber(this)" size="25" maxlength="15" value="<?php echo $userdetails->phone; ?>" /></div>
            
            
            <div class="testbox_label_edit_profile">Forum Alias<span class="madatory"> *</span></div>
            <div class="text_box_div"><div style="float:left"><input type="text" name="forumalias" id="forumalias" style="width:180px !important;" size="25" maxlength="25" value="<?php echo $userdetails->forum_alias; ?>" /></div></div>
            <div class="tooltip" style="width:22px;float:left; padding-top:10px; padding-left:4px;">
                <span>Please enter Forum Alias which would be reflected as User Name in Forum</span>
				<a href="javascript:void(0);"><img style="margin-top:3px;padding-right:3px;" src="<?php echo base_url().'images/q_mark.png"' ?>" alt="Help" width="16" height="16" border="0" /></a>
            </div>
            
            
            
            <!--<div class="space_edit_profile"></div>-->
            <!--<div class="testbox_label_edit_profile">&nbsp;</div>
            <div class="text_box_space"><span class="instruction">Phone Number should be any one of the following format.1. (xxx) xxx xxxx  2. (xxx) xxx-xxxx  3. xxx-xxx-xxxx</span></div>-->
            <div class="testbox_label_edit_profile">Unit Number</div>
            <div class="text_box_div"><input type="text" name="txtUnitNumber" id="txtUnitNumber" size="25" maxlength="10" value="<?php echo $userdetails->unit_number; ?>" /></div>
	</div>
				