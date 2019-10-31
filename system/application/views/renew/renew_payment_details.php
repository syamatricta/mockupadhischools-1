<div class="floatleft">
	<div class="" style="padding-left:40px;"><img  src="<?php  echo ssl_url_img();?>enter_payment_details.png" /></div>
	<div class="clearboth">&nbsp;</div>
	<div class="contents_renewmain" >
		<div class="testbox_label_renew">Credit Card Type<span class="red_star">*</span> </div>
		<div class="renewcourse_select" onclick="javascript:__fncShowData('cardTypeDiv');return false;">
			 <div style="float:left;width:293px;margin-bottom:10px;height:30px;font-size:18px;">
			 	<input type="text" readonly name="block_cardtype" id="block_cardtype" class="droplisRenewDivtxtbx" value="" onchange="javascript:isCreditCard();"/>
			 	<input type="hidden" readonly name="cardtype" id="cardtype" class="droplisRenewDivtxtbx" value="" onchange="javascript:isCreditCard();"/>
			 </div>
			 <div id="cardTypeDiv" style="display:none;width:293px; position:relative; z-index:1000" ><!--onclick="javascript:__fncShowData('cardTypeDiv');return false;"-->
				<div id="cardTypeDiv1" class="droplisRenewDiv"  onmouseover="javascript:__fncShowdiv('cardTypeDiv1');" onmouseout="javascript:__fncChangeColor('cardTypeDiv1');" onclick="javascript:__fncSetSelectedValue('cardTypeDiv1', 'cardTypeDiv', 'cardtype','Visa','block_cardtype');">Visa</div>
				<div id="cardTypeDiv2" class="droplisRenewDiv"  onmouseover="javascript:__fncShowdiv('cardTypeDiv2');" onmouseout="javascript:__fncChangeColor('cardTypeDiv2');" onclick="javascript:__fncSetSelectedValue('cardTypeDiv2', 'cardTypeDiv', 'cardtype','MasterCard','block_cardtype');">MasterCard</div>
				<div id="cardTypeDiv3" class="droplisRenewDiv"  onmouseover="javascript:__fncShowdiv('cardTypeDiv3');" onmouseout="javascript:__fncChangeColor('cardTypeDiv3');" onclick="javascript:__fncSetSelectedValue('cardTypeDiv3', 'cardTypeDiv', 'cardtype','Amex','block_cardtype');">American Express</div>
				<div id="cardTypeDiv4" class="droplisRenewDiv"  onmouseover="javascript:__fncShowdiv('cardTypeDiv4');" onmouseout="javascript:__fncChangeColor('cardTypeDiv4');" onclick="javascript:__fncSetSelectedValue('cardTypeDiv4', 'cardTypeDiv', 'cardtype','Discover','block_cardtype');">Discover</div>
             </div>
		</div>
		<div class="floatleft" style="padding-left:20px; padding-top:10px;">
			<img  src="<?php  echo ssl_url_img();?>innerpages/visa.jpg" alt="Visa" title="Visa" />
			<img  src="<?php  echo ssl_url_img();?>innerpages/mastercard.jpg" alt="Mastercard" title="Mastercard" />
			<img  src="<?php  echo ssl_url_img();?>innerpages/amex.jpg" alt="American Express" title="American Express" />
			<img  src="<?php  echo ssl_url_img();?>innerpages/discover.jpg" alt="Discover" title="Discover" />
		</div>
		<div class="clearboth"></div>
		<div class="testbox_label_renew">Credit Card No<span class="red_star">*</span></div>
		<div class="text_box_div">
			<input  type="text" name="ccno"  id="ccno" value="" class="textwidth" maxlength="30" />
		</div>
		<div class="clearboth"></div>
		<div class="testbox_label_renew">CVV2 No<span class="red_star">*</span></div>
		<div class="text_box_div"><input  type="text" name="cvv2no" class="textwidth" id="cvv2no" value="" maxlength="10" size="25"/></div>
		<div class="clearboth"></div>
		<div class="testbox_label_renew">Expiration Date<span class="red_star">*</span> </div>
		<div class="select_box_div">
			<div class="renewcourse_date_select" style="margin-right:4px;" onclick="javascript:__fncShowData('DateDiv');return false;">
				 <div style="float:left;margin-bottom:10px;height:30px;font-size:18px;">
				 	<input type="text" readonly name="block_expmonth" id="block_expmonth" class="droplisRenewDivtxtbx" value="" />
				 	<input type="hidden" readonly name="expmonth" id="expmonth" class="droplisRenewDivtxtbx" value="" />
				 </div>
				 <div id="DateDiv" style="display:none; position:relative; z-index:1000" ><!--onclick="javascript:__fncShowData('DateDiv');return false;"-->
					 <?php $i=1; 
					 foreach($month as $month){ ?>
						<div id="DateDiv<?php echo $i; ?>" class="droplisRenewmonthDiv"  onmouseover="javascript:__fncShowdiv('DateDiv<?php echo $i; ?>');" onmouseout="javascript:__fncChangeColor('DateDiv<?php echo $i; ?>');" onclick="javascript:__fncSetSelectedValue('DateDiv<?php echo $i; ?>', 'DateDiv', 'expmonth','<?php echo $i; ?>','block_expmonth');"><?php echo $month?></div>
					<?php $i++; } ?>
				 </div>
			</div>
			<div class="renewcourse_date_select" onclick="javascript:__fncShowData('YearDiv');return false;">
				 <div style="float:left;margin-bottom:10px;height:30px;font-size:18px;">
				 	<input type="text" name="block_expyear" readonly id="block_expyear" class="droplisRenewDivtxtbx" value="" />
				 	<input type="hidden" name="expyear" readonly id="expyear" class="droplisRenewDivtxtbx" value="" />
				 </div>
				 <div id="YearDiv" style="display:none; position:relative; z-index:1000 " ><!--onclick="javascript:__fncShowData('YearDiv');return false;"-->
					 <?php 
					 foreach($year as $year){ ?> 
						<div id="YearDiv<?php echo $year; ?>" class="droplisRenewmonthDiv"  onmouseover="javascript:__fncShowdiv('YearDiv<?php echo $year; ?>');" onmouseout="javascript:__fncChangeColor('YearDiv<?php echo $year; ?>');" onclick="javascript:__fncSetSelectedValue('YearDiv<?php echo $year; ?>', 'YearDiv', 'expyear','<?php echo $year; ?>','block_expyear');"><?php echo $year?></div>
					<?php } ?>
				 </div>
			</div>
			
			<!--<select name="expmonth" id="expmonth" class="selectboxsmall">
			<?php echo  $i=1; foreach($month as $month){ ?>
			<option value="<?php echo $i; ?>" <?php if(set_value('expmonth')== $i){?> selected="selected" <?php }?>><?php echo $month; ?></option>
			<?php $i++; } ?>
			</select>
			<select name="expyear" id="expyear" class="selectboxsmall" >
			<?php foreach($year as $year){ ?>
			<option value="<?php echo $year; ?>" <?php if(set_value('expyear')== $year){?> selected="selected" <?php }?>><?php echo $year; ?></option>
			<?php  } ?>
			</select>-->
		</div>
		<div class="clearboth"></div>
		<div class="testbox_label_renew">&nbsp;</div>
		<div class="text_box_div_space">
			<div class="nextbuttondiv" style="width:290px;" >
				<img style="margin-left:110px;" src="<?php  echo base_url();?>images/submit_button.png" border="0" align="left" onclick="javascript:renew_course();hidealert();"/>
				<a href="<?php echo base_url().'exam/courselist'?>"><img src="<? echo $this->config->item('images').'cancel.png'?>" style="cursor:pointer"  /></a><span  id="newimg" style="display:block;"></span>
			</div>
			<!--<img  src="<?php  echo ssl_url_img();?>innerpages/sub_btn.jpg" onclick="javascript:renew_course();" class="stylebutton" /><span  id="newimg" style="display:block;"></span>-->
		</div>
	</div>
</div>
<div class="clearboth"></div>