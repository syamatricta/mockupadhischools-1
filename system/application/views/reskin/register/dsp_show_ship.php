<?php 
 if(array_key_exists('error', $return_value) || count($return_value)==0) :?>
 	<p class='red_star'><?php echo $return_value['error'];?>
        <?php /*Please provide correct zipcode based on the selected state */?>
    </p>
    <?php if(FALSE !== strpos( $return_value['error'], 'postal code')){?>
        <div class="form-inline">
            <div id='zipcode-correct-div' class='form-group'>
                <input type="text" id='zipcode_correct' class="form-control" name = "zipcode_correct" value="" autocomplete="off" maxlength="5"/>
            </div>
            <input class=" btn-adhi" type="button" name="update_s_zipcode_btn" id="update_s_zipcode_btn" value="Update">
        </div>
        <p id='zipcode_correct_error' class='red_star'></p>
    <?php } ?>
 <?php else:?> 	
    <div class="row">
   <?php
        foreach($return_value as $return_value):
            if('FEDEX_GROUND' != $return_value['methodno']
                &&
                (
                    'FEDEX_EXPRESS_SAVER' != $return_value['methodno'] ||
                    (!IS_FEDEX_ONE_RATE_ENABLED && 'FEDEX_EXPRESS_SAVER' == $return_value['methodno'])
                )
            ){continue;}

   ?>
        <div  class="filedforrate col-sm-6" >
            <div  class="filedforrate" >
                <div class="radio radio-danger"  style="margin:0;">
                        <input  id="ship<?php echo $return_value['methodno']; ?>" data-method="<?php echo $return_value['methodno']; ?>"  type="radio"  name="shiprate_radios" data-shiptate="<?php echo $return_value['rate']; ?>">
                        <label for="ship<?php echo $return_value['methodno']; ?>"><?php  echo $return_value['service'] ." - "."$".$return_value['rate'] ; ?></label>
                </div>                  
                <input type="hidden" name="shiprate<?php echo $return_value['methodno']; ?>" id="shiprate<?php echo $return_value['methodno']; ?>" value="<?php echo $return_value['rate']; ?>"   />
             </div>
        </div>
		 
	<?php  endforeach; ?>	
	<div class="col-sm-6 text-right color-note"><i>Note : FedEx will not deliver to P.O. Boxes</i></div>
    </div>
<?php endif;?>
 <input  type="hidden"  name="shipid" id="shipid" value="" />   
<?php
if($show_promocode_div){
?>
 <input type="hidden" name="is_promocode_applied" id="is_promocode_applied" value="" />
 <input type="hidden" name="hid_promocode" id="hid_promocode" value="" />
 <input type="hidden" name="grand_total_before_promocode"   id="grand_total_before_promocode" value="" />
 <input type="hidden" name="grand_total_after_promocode"    id="grand_total_after_promocode" value="" />
 <div id="promo_code_div">
    <div class="row" style="margin-top:25px;" id="promo_code_form_cnt">
       <div class="col-md-6 form-group">
           <input name="promocode" id="promocode"  placeholder="PROMO CODE" class="form-control valid" 
                  maxlength="128" value="" type="text">
           <div id="promocode_error" style="display:none;margin-top:5px;" class="text-danger"></div>
       </div>
       <div class="col-md-6 form-group">
           <buttton class="btn-adhi" id="promo_code_apply" style="font-size: 12px;margin-top:5px;">
               APPLY <img style="display:none;" src="<?php echo c('images');?>small_loader.gif" />
           </buttton>           
       </div>
    </div>
    <div class="row" style="margin-top:25px;display:none" id="promo_code_applied_cnt">
       <div class="col-md-12 form-group" id="promo_code_applied_code"></div>
    </div>
         
</div>
<?php
}
?>