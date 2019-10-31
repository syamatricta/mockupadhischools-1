<div class="row margin20">
    <div class="col-sm-12">
        <div class="heading_band">Shipping Address</div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="address">ADDRESS*</label>
        <input type="text" name="address" id="address" required placeholder="ADDRESS*"  class="form-control" maxlength="128" value="<?php echo set_value('address', $userdetails->s_address); ?>" data-toggle="tooltip" data-placement="bottom" title="FedEx will not deliver to P.O. Boxes" />
    </div>
    <div class="col-md-6 form-group">
        <label for="state">STATE*</label>
        <select class="state form-control" id="state" name="state" required>
            <option value="">SELECT STATE*</option>
            
            <?php foreach($states as $single_state){?>
                <option value="<?php echo $single_state->state_code; ?>" <?php echo select_selected_ext('state', $single_state->state_code, $s_state->state_code);?>><?php echo $single_state->state;?></option>
            <?php }?>
        </select>
    </div>
</div>
<div class="row">    
   <div class="col-md-6 form-group">
        <label for="city">CITY*</label>
        <input type="text" placeholder="CITY*" name="city" required id="city" class="form-control" maxlength="40" value="<?php echo set_value('city', $userdetails->s_city); ?>" />
    </div> 
    <div class="col-md-6 form-group">
        <label for="zipcode">ZIP CODE*</label>
        <input type="text" placeholder="ZIP CODE*" required name="zipcode" id="zipcode"  class="form-control" maxlength="5"  value="<?php echo set_value('zipcode', $userdetails->s_zipcode); ?>" />
        <div class="text-right guide-cnt">Zip code must be 5 digits</div>
    </div>
</div>