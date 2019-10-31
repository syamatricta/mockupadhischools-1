<div class="floatleft margin-left58">
	<!--div class="" style="padding-left:40px;"><img  src="<?php  echo ssl_url_img();?>enter_payment_details.png" /></div-->
	<div class="clearboth">&nbsp;</div>
	
        <div class="cb">
        	<div class="page_error" id="errordisplay" ></div>
			<div  class="page_error" id="errordiv" style="display:none;"><?php if(isset($msg)) echo $msg; ?></div>
			<?php if(isset($msg)) {?>
			<div  class="page_error errordiv"  ><?php if(isset($msg)) echo $msg; ?></div>
			<?php }  ?>
			<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("msg");   ?></div>
			<?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
        </div>
        <div class="clearboth">&nbsp;</div>
	<div>
		
		<ul class="form_step_01 payment_form">
            <li class="clearfix">
                <div class="float_l">
			 		<input type="hidden" name="cardtype" id="cardtype" value="<?php echo (set_value('cardtype')) ? set_value('cardtype') : 'Mastercard'; ?>" onchange="javascript:isCreditCard();"/>
			 	
                    <label>Credit Card Types*</label>
                     <div tabindex="1" class="wrapper-dropdown-5 creditcard_dropdown active" id="dd">
                        <span><?php echo (set_value('cardtype')) ? set_value('cardtype') : 'Mastercard'; ?></span>  
                        <ul class="dropdown">
                            <li><a rel="nofollow" href="#" class="cbocardtype" data-name="Mastercard">Mastercard</a></li>
                            <li><a rel="nofollow" href="#" class="cbocardtype" data-name="Amex">American Express</a></li>
                            <li><a rel="nofollow" href="#" class="cbocardtype" data-name="Visa">VISA</a></li>
                            <li><a rel="nofollow" href="#" class="cbocardtype" data-name="Discover">Discover</a></li>
                        </ul>
                    </div>
                </div>
                <div class="float_r">
                   	<img alt="creditcards_logo" class="credit_cards" src="<?php echo base_url();?>images/iframe_user/images/debit_credit_cards.png">
                </div>                            	
            </li>
            <li class="clearfix">
                <div class="float_l margin_r_10">
                   <label>Credit Card No*</label>
                    <input type="text" name="ccno" id="ccno" value="<?php echo set_value('ccno'); ?>" class="txt_area" maxlength="30" />
                </div>
                <div class="float_l margin_r_10">
                    <label>CVV No*</label>
                    <input type="text" name="cvv2no" class="txt_area" id="cvv2no" value="<?php echo set_value('cvv2no'); ?>" maxlength="10" size="25"/>
                </div> 
                 <div class="float_l smaller_inputs margin_r_10">
				 	<input type="hidden" name="expmonth" id="expmonth" value="<?php echo (set_value('expmonth')) ? set_value('expmonth') : 1; ?>" />
				 	
                    <label>Expiration Date*</label>
                     <div tabindex="1" class="wrapper-dropdown-5 min_dropdown" id="dd1">
                         <ul class="dropdown">
                         	
                        	<?php $i=1; 
 						 	foreach($month as $month){ ?>
                            <li><a href="#" class="select_month" data-month="<?php echo $i; ?>"><?php echo $month?></a></li>
                            <?php $i++; } ?> 
                         </ul>
                         <span>Jan</span>
                        
                    </div>
                </div>
                <div class="float_l smaller_inputs margin_r_10">
				 	
				 	
                    <label>Year*</label>
                    <div tabindex="1" class="wrapper-dropdown-5 min_dropdown" id="dd2">
                         <ul class="dropdown">
                        	<?php $fy=$year[0];
							 foreach($year as $year){ ?> 
							 	<li><a rel="nofollow" href="#" class="select_year" data-year="<?php echo $year?>"><?php echo $year?></a></li>
 							<?php } ?> 
                         </ul>
                         <span><?php echo $fy; ?></span>
                    </div>
                </div>
                <input type="hidden" name="expyear" id="expyear" value="<?php echo (set_value('expyear')) ? set_value('expyear') : $fy; ?>" />
            </li>                                                                                                
        </ul>
        
        
        
        <input type="button" value="SUBMIT" class="button_red paymentForm_btn" id="sb_btn"onclick="javascript:return addcourses();" >
        <span  id="newimg" style="display:none;"></span>
         
        
	</div>
	
	
	 
</div>
<div class="clearboth"></div> 