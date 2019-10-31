<div class="floatleft">
	<div class="subhead_txt">Please enter payment details here</div>
	<div class="clearboth">&nbsp;</div>
	<div class="contents_registermain" >
		<div class="leftside_register">Credit Card Type<span class="red_star">*</span> </div>
		<div class="middlecolon_register">&nbsp;</div>
		<div class="rightsidedata_register">
			<select name="cardtype" id="cardtype" class="selecttextwidth"  onchange="javascript:isCreditCard();">
			<option value="">Select</option>
			<option value="Visa" <?php if(set_value('cardtype')=='Visa'){?> selected="selected" <?php }?>>Visa</option>
			<option value="MasterCard" <?php if(set_value('cardtype')=='MasterCard'){?> selected="selected" <?php }?>>MasterCard</option>
			<option value="Amex" <?php if(set_value('cardtype')=='Amex'){?> selected="selected" <?php }?>>American Express</option>
			<option value="Discover" <?php if(set_value('cardtype')=='Discover'){?> selected="selected" <?php }?>>Discover</option>
			</select>
		</div>
		<div class="floatleft">
			<img  src="<?php  echo ssl_url_img(); ?>innerpages/visa.jpg" />
			<img  src="<?php  echo ssl_url_img(); ?>innerpages/mastercard.jpg" />
			<img  src="<?php  echo ssl_url_img(); ?>innerpages/amex.jpg" />
			<img  src="<?php  echo ssl_url_img(); ?>innerpages/discover.jpg" />
		</div>
		<div class="clearboth"></div>
		<div class="leftside_register">Credit Card No<span class="red_star">*</span></div>
		<div class="middlecolon_register">&nbsp;</div>
		<div class="rightsidedata_register">
			<input  type="text" name="ccno"  id="ccno" value="<?php echo set_value('ccno'); ?>" class="textwidth font-size_regpage_input" maxlength="30" />
		</div>
		<div class="clearboth"></div>
		<div class="leftside_register">CVV2 No<span class="red_star">*</span></div>
		<div class="middlecolon_register">&nbsp;</div>
		<div class="rightsidedata_register"><input  type="text" name="cvv2no" class="textwidth font-size_regpage_input" id="cvv2no" value="<?php echo set_value('cvv2no'); ?>" maxlength="10" size="25"/></div>
		<div class="clearboth"></div>
		<div class="leftside_register">Expiration Date<span class="red_star">*</span> </div>
		<div class="middlecolon_register">&nbsp;</div>
		<div class="rightsidedata_register">
			<select name="expmonth" id="expmonth" class="selectboxsmall">
			<?php echo  $i=1; foreach($month as $month){ ?>
			<option value="<?php echo $i; ?>" <?php if(set_value('expmonth')== $i){?> selected="selected" <?php }?>><?php echo $month; ?></option>
			<?php $i++; } ?>
			</select>
			<select name="expyear" id="expyear" class="selectboxsmall" >
			<?php foreach($year as $year){ ?>
			<option value="<?php echo $year; ?>" <?php if(set_value('expyear')== $year){?> selected="selected" <?php }?>><?php echo $year; ?></option>
			<?php  } ?>
			</select>
		</div>
		<div class="clearboth"></div>
		<div class="leftside_register">&nbsp;</div>
		<div class="middlecolon_register">&nbsp;</div>
		<div class="rightsidedata_register">
			<img  src="<?php  echo ssl_url_img();?>innerpages/sub_btn.jpg" onclick="javascript:addcourses();" class="stylebutton" /><span  id="newimg" style="display:none;"></span>
		</div>
	</div>
</div>
<div class="clearboth"></div>