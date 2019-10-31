<div class="floatleft margin-left58">
	<div class="" style="padding-left:40px;"><img  src="<?php  echo ssl_url_img();?>enter_payment_details.png" /></div>
	<div class="clearboth">&nbsp;</div>
	<div class="contents_renewmain" >
		<div class="testbox_label_renew">Credit Card Type<span class="green_star">*</span> </div>
		<div class="renewcourse_select" onclick="javascript:__fncShowData('cardTypeDiv');return false;">
			 <div style="float:left;width:293px;margin-bottom:10px;height:30px;font-size:18px;">
			 	<input type="text" readonly name="block_cardtype" id="block_cardtype" class="droplisRenewDivtxtbx" value="<?php echo set_value('block_cardtype'); ?>" onchange="javascript:isCreditCard();"/>
			 	<input type="hidden" readonly name="cardtype" id="cardtype" class="droplisRenewDivtxtbx" value="<?php echo set_value('cardtype'); ?>" onchange="javascript:isCreditCard();"/>
			 </div>
			 <div id="cardTypeDiv" style="display:none;width:293px; position:relative; z-index:1000" ><!---onclick="javascript:__fncShowData('cardTypeDiv');return false;"-->
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
		<div class="testbox_label_renew">Credit Card No<span class="green_star">*</span></div>
		<div class="text_box_div">
			<input  type="text" name="ccno"  id="ccno" value="<?php echo set_value('ccno'); ?>" class="textwidth" maxlength="30" />
		</div>
		<div class="clearboth"></div>
		<div class="testbox_label_renew">CVV2 No<span class="green_star">*</span></div>
		<div class="text_box_div"><input  type="text" name="cvv2no" class="textwidth" id="cvv2no" value="<?php echo set_value('cvv2no'); ?>" maxlength="10" size="25"/></div>
		<div class="clearboth"></div>
		<div class="testbox_label_renew">Expiration Date<span class="green_star">*</span> </div>
		<div class="select_box_div">
			<div class="renewcourse_date_select" style="margin-right:4px;" onclick="javascript:__fncShowData('DateDiv');return false;">
				 <div style="float:left;margin-bottom:10px;height:30px;font-size:18px;">
				 	<input type="text" readonly name="block_expmonth" id="block_expmonth" class="droplisRenewDivtxtbx" value="<?php echo set_value('block_expmonth'); ?>" />
				 	<input type="hidden" readonly name="expmonth" id="expmonth" class="droplisRenewDivtxtbx" value="<?php echo set_value('expmonth'); ?>" />
				 </div>
				 <div id="DateDiv" style="display:none; position:relative; z-index:1000" ><!---onclick="javascript:__fncShowData('DateDiv');return false;" -->
					 <?php $i=1; 
					 foreach($month as $month){ ?>
						<div id="DateDiv<?php echo $i; ?>" class="droplisRenewmonthDiv"  onmouseover="javascript:__fncShowdiv('DateDiv<?php echo $i; ?>');" onmouseout="javascript:__fncChangeColor('DateDiv<?php echo $i; ?>');" onclick="javascript:__fncSetSelectedValue('DateDiv<?php echo $i; ?>', 'DateDiv', 'expmonth','<?php echo $i; ?>','block_expmonth');"><?php echo $month?></div>
					<?php $i++; } ?>
				 </div>
			</div>
			<div class="renewcourse_date_select" onclick="javascript:__fncShowData('YearDiv');return false;">
				 <div style="float:left;margin-bottom:10px;height:30px;font-size:18px;">
				 	<input type="text" name="block_expyear" readonly id="block_expyear" class="droplisRenewDivtxtbx" value="<?php echo set_value('block_expyear'); ?>" />
				 	<input type="hidden" name="expyear" readonly id="expyear" class="droplisRenewDivtxtbx" value="<?php echo set_value('expyear'); ?>" />
				 </div>
				 <div id="YearDiv" style="display:none; position:relative; z-index:1000 " ><!--onclick="javascript:__fncShowData('YearDiv');return false;" -->
					 <?php 
					 foreach($year as $year){ ?> 
						<div id="YearDiv<?php echo $year; ?>" class="droplisRenewmonthDiv"  onmouseover="javascript:__fncShowdiv('YearDiv<?php echo $year; ?>');" onmouseout="javascript:__fncChangeColor('YearDiv<?php echo $year; ?>');" onclick="javascript:__fncSetSelectedValue('YearDiv<?php echo $year; ?>', 'YearDiv', 'expyear','<?php echo $year; ?>','block_expyear');"><?php echo $year?></div>
					<?php } ?>
				 </div>
			</div>			
		</div>
		<div class="clearboth"></div>
		<div class="leftside_register">&nbsp;</div>
		<div class="middlecolon_register">&nbsp;</div>
		<div class="rightsidedata_register" style="float:right; padding-right:250px; padding-top:30px;">
<!--			<img  src="<?php  echo ssl_url_img();?>innerpages/submit_butt.png"	onclick="javascript:addcourses();" class="stylebutton" />-->
                       <input type="image"  src="<?php  echo ssl_url_img();?>innerpages/submit_butt.png"	onclick="javascript:addcourses();hidealert();return false;" class="stylebutton"  id="sb_btn"/>
                        <span  id="newimg" style="display:none;"></span>
		</div>
	</div>
</div>
<div class="clearboth"></div>

