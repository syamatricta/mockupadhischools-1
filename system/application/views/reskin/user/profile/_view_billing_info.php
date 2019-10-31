<div class="row margin20">
    <div class="col-sm-12">
        <div class="heading_band">Billing Address</div>
    </div>
</div>

<div class="row margin10">
    <div class="col-xs-6 text-right">Address :</div>
    <div class="col-xs-6"><?php echo $userdetails->b_address; ?></div>
</div>
<div class="row margin10">
    <div class="col-xs-6 text-right">State :</div>
    <div class="col-xs-6"><?php echo @$b_state->state;; ?></div>
</div>
<div class="row margin10">
    <div class="col-xs-6 text-right">City :</div>
    <div class="col-xs-6"><?php echo $userdetails->b_city; ?></div>
</div>
<div class="row margin10">
    <div class="col-xs-6 text-right">Zip Code :</div>
    <div class="col-xs-6"><?php echo $userdetails->b_zipcode; ?></div>
</div>