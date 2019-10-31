<div class="row margin20">
    <div class="col-sm-12">
        <div class="heading_band">Shipping Address</div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 form-group">
        <label for="address">ADDRESS*</label>
        <input type="text" name="s_address" id="s_address" required placeholder="ADDRESS*"  class="form-control" maxlength="128" value="<?php echo set_value('address', $shipping['s_address']); ?>" data-toggle="tooltip" data-placement="bottom" title="FedEx will not deliver to P.O. Boxes" />
    </div>
    <div class="col-md-6 form-group">
        <label for="country">COUNTRY*</label>
        <input type="text" name="s_country" id="country" required placeholder="COUNTRY*" disabled=""  class="form-control" maxlength="128" value="United States"  />
        <input type="hidden" name="s_country" id="s_country" value="US">
    </div>
</div>
<div class="row">
    <div class="col-md-6 form-group">
        <label for="state">STATE*</label>
        <select class="state form-control" id="s_state" name="s_state" required>
            <option value="">SELECT STATE*</option>
            
            <?php foreach($state as $single_state){?>
                <option value="<?php echo $single_state['state_code']; ?>" <?php echo select_selected_ext('state', $single_state['state_code'], $shipping['s_state']);?>><?php echo $single_state['state'];?></option>
            <?php }?>
        </select>
    </div>
    <div class="col-md-6 form-group">
        <label for="city">CITY*</label>
        <input type="text" placeholder="CITY*" name="s_city" required id="s_city" class="form-control" maxlength="40" value="<?php echo set_value('city', $shipping['s_city']); ?>" />
    </div>
    
</div>
<div class="row">
    <div class="col-md-6 form-group">
        <label for="s_zipcode">ZIP CODE*</label>
        <input type="text" placeholder="ZIP CODE*" required name="s_zipcode" id="s_zipcode"  class="form-control" maxlength="5"  value="<?php echo set_value('zipcode', $shipping['s_zipcode']); ?>" />
        <div class="text-right guide-cnt">Zip code must be 5 digits</div>
    </div>
</div>
<input type="hidden" id="apply_check_zipcode" value="<?php echo $shipping['s_zipcode'];?>" />