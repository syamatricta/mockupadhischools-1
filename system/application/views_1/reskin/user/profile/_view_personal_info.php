<?php if(is_BRE_test_user()){?>
    <div class="row margin20">
        <div class="col-sm-12">
            <div class="heading_band">Details</div>
        </div>
    </div>
    <div class="row margin10">
        <div class="col-xs-6 text-right">Password :</div>
        <div class="col-xs-6"><?php //echo c('BRE_user_password')[s('USERID')]; ?></div>
    </div>
    <div class="row margin10">
        <div class="col-xs-6 text-right">Drivers License Number :</div>
        <div class="col-xs-6"><?php //echo c('BRE_user_license_number')[s('USERID')]; ?></div>
    </div>
<?php }else{?>
<div class="row margin20">
    <div class="col-sm-12">
        <div class="heading_band">Personal Details</div>
    </div>
</div>

<div class="row margin10">
    <div class="col-xs-6 text-right">First Name :</div>
    <div class="col-xs-6"><?php echo $userdetails->firstname; ?></div>
</div>
<div class="row margin10">
    <div class="col-xs-6 text-right">Last Name :</div>
    <div class="col-xs-6"><?php echo $userdetails->lastname; ?></div>
</div>
<div class="row margin10">
    <div class="col-xs-6 text-right">Name on Certificate :</div>
    <div class="col-xs-6"><?php echo $userdetails->name_on_certificate; ?></div>
</div>
<div class="row margin10">
    <div class="col-xs-6 text-right">Email Id :</div>
    <div class="col-xs-6"><?php echo $userdetails->emailid; ?></div>
</div>
<div class="row margin10">
    <div class="col-xs-6 text-right">Phone :</div>
    <div class="col-xs-6"><?php echo $userdetails->phone; ?></div>
</div>
<?php if($userdetails->note != ''){?>
<div class="row margin10">
    <div class="col-xs-6 text-right">Note :</div>
    <div class="col-xs-6"><?php echo $userdetails->note; ?></div>
</div>
<?php }?>
<div class="row margin10">
    <div class="col-xs-6 text-right">License Type :</div>
    <div class="col-xs-6">
        <?php 
        $licensetype    = ('S' == $userdetails->licensetype ) ? "Sales" : "Broker" ;
        echo $licensetype.', '.@$course_user_type->course_type.', '.@$course_user_type->payment_type;
        ?>
    </div>
</div>
<div class="row margin10">
    <div class="col-xs-6 text-right">Unit Number :</div>
    <div class="col-xs-6"><?php echo $userdetails->unit_number; ?></div>
</div>
<?php }?>