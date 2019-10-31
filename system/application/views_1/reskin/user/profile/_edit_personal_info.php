<div class="row margin20">
    <div class="col-sm-12">
        <div class="heading_band">Personal Details</div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 form-group">
        <label for="firstname">FIRST NAME*</label>
        <input type="text" name="firstname" id="firstname" placeholder="FIRST NAME*" class="form-control" maxlength="40" required value="<?php echo set_value('firstname', $userdetails->firstname); ?>" />
    </div>
    <div class="col-sm-6 form-group"> 
        <label for="lastname">LAST NAME*</label>
        <input type="text" name="lastname" id="lastname" placeholder="LAST NAME*" class="form-control" maxlength="40" required value="<?php echo set_value('lastname', $userdetails->lastname); ?>" />
    </div>
</div>
<div class="row">
    <div class="col-sm-6  form-group">
        <label for="email">EMAIL*</label>
        <input type="email" name="email" id="email"  maxlength="70" required disabled="" placeholder="EMAIL*" class="form-control" value="<?php echo set_value('email', $userdetails->emailid); ?>"/>
    </div>
    <div class="col-sm-6 form-group">
        <label for="phone">PHONE*</label>
        <input type="text"  placeholder="PHONE*" required name="phone" id="phone" maxlength="10"  class="form-control numbers_only"  value="<?php echo set_value('phone', $userdetails->phone); ?>" />
    </div>
</div>
<div class="row">
    <div class="col-md-6 form-group">
        <label for="unit_number">UNIT NUMBER</label>
        <input type="text" placeholder="UNIT NUMBER" name="unit_number" id="unit_number"  maxlength="15" class="form-control"  value="<?php echo set_value('unitnumber', $userdetails->unit_number); ?>" />
        <input type="hidden" name="country" id="country" value="US">
    </div>
    <?php if(isset($ask_driving_license) && TRUE === $ask_driving_license){?>
    <div class="col-sm-6 form-group">
        <label for="driving_license">DRIVERS LICENSE NUMBER*</label>
        <input type="text" placeholder="DRIVERS LICENSE NUMBER*" required="" name="driving_license" id="driving_license" maxlength="20" class="form-control" value="" aria-required="true" value="<?php echo set_value('driving_license', $userdetails->driving_license); ?>">
    </div>
    <?php }?>
</div>