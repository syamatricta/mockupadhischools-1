<div class="row margin20">
    <div class="col-sm-12">
        <div class="heading_band">Billing Address</div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 form-group">
        <label for="address">ADDRESS*</label>
        <input type="text" name="b_address" id="b_address" placeholder="ADDRESS" required  class="form-control" maxlength="128" value="<?php echo set_value('b_address', $userdetails->b_address); ?>"/> 		
    </div>
    <div class="col-md-6  form-group">
        <label for="b_city">CITY*</label>
        <input type="text" name="b_city" id="b_city" placeholder="CITY*" required  class="form-control" maxlength="40"  value="<?php echo set_value('b_city', $userdetails->b_city); ?>"/>
    </div>
</div>		 
<div class="row">
    <div class="col-md-6  form-group">
        <?php
            $state = '';
            if($this->input->post('b_state')){
                $state = $this->input->post('b_state');
            }else if(isset($b_state->state_code)){
                $state = $b_state->state_code;
            }
        ?>
        <label for="b_state">STATE*</label>
        <select class="state form-control" id="b_state" name="b_state" required>
            <option value="">SELECT STATE*</option>
            <?php foreach($states as $single_state){
                $selected = ($single_state->state_code == $state) ? 'selected="selected" ' : '';
            ?>
                <option value="<?php echo $single_state->state_code; ?>" <?php echo $selected;?>><?php echo $single_state->state;?></option>
            <?php }?>
        </select>  		
    </div>
    <div class="col-md-6 form-group">
        <label for="b_zipcode">ZIP CODE*</label>
        <input type="text" name="b_zipcode" id="b_zipcode" placeholder="ZIP CODE" required  class="form-control" maxlength="5" value="<?php echo set_value('b_zipcode', $userdetails->b_zipcode); ?>"/>
        <div class="text-right guide-cnt">Zip code must be 5 digits</div>
    </div>
</div>