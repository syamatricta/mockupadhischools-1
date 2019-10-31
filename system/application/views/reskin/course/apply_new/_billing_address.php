<div class="row margin20">
    <div class="col-sm-12">
        <div class="heading_band">Billing Address</div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="checkbox  checkbox-danger" >
            <input type="checkbox" name="setaddr" id="setaddr" value="Y" <?php echo set_checkbox_ext('setaddr', 'Y',  $billing['billing_sameas_shipping']);?>>
            <label for="setaddr">
               Billing address same as shipping address <span style="display:none;" id="indicator">loading</span>
            </label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 form-group">
        <label for="address">ADDRESS*</label>
        <input type="text" name="b_address" id="b_address" placeholder="ADDRESS" required  class="form-control" maxlength="128" value="<?php echo set_value('b_address', $billing['b_address']); ?>"/> 		
    </div>
    <div class="col-md-6 form-group">
        <label for="country">COUNTRY*</label>
        <input type="text" name="country" id="country" required placeholder="COUNTRY*" disabled="" class="form-control" maxlength="128" value="United States"  />
        <input type="hidden" name="b_country" id="b_country" value="US">
    </div>
    
</div>		 
<div class="row">
    <div class="col-md-6  form-group">
        <label for="b_state">STATE*</label>
        <select class="state form-control" id="b_state" name="b_state" required>
            <option value="">SELECT STATE*</option>
            <?php foreach($state as $single_state){?>
                <option value="<?php echo $single_state['state_code']; ?>" <?php echo select_selected_ext('state', $single_state['state_code'], $billing['b_state']);?>><?php echo $single_state['state'];?></option>
            <?php }?>
        </select>  		
    </div>
    <div class="col-md-6  form-group">
        <label for="b_city">CITY*</label>
        <input type="text" name="b_city" id="b_city" placeholder="CITY*" required  class="form-control" maxlength="40"  value="<?php echo set_value('b_city', $billing['b_city']); ?>"/>
    </div>    
</div>
<div class="row">
    <div class="col-md-6 form-group">
        <label for="b_zipcode">ZIP CODE*</label>
        <input type="text" name="b_zipcode" id="b_zipcode" placeholder="ZIP CODE" required  class="form-control" maxlength="5" value="<?php echo set_value('b_zipcode', $billing['b_zipcode']); ?>"/>
        <div class="text-right guide-cnt">Zip code must be 5 digits</div>
    </div>
</div>
