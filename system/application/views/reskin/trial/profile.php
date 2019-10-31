<?php page_heading('Profile' , 'banner-inner');?>
<div class="container">
    <div class="divide40"></div>
    <div class="row margin40">
        <div class="col-sm-10 col-sm-offset-1">
            <?php if(count($user) > 0){ ?>
                
                <div class="row margin20">
                    <div class="col-sm-12">
                        <div class="heading_band">Personal Details</div>
                    </div>
                </div>

                <div class="row margin10">
                    <div class="col-xs-6 text-right">First Name :</div>
                    <div class="col-xs-6"><?php echo $user->first_name; ?></div>
                </div>
                <div class="row margin10">
                    <div class="col-xs-6 text-right">Last Name :</div>
                    <div class="col-xs-6"><?php echo $user->last_name; ?></div>
                </div>
                <div class="row margin10">
                    <div class="col-xs-6 text-right">Email Id :</div>
                    <div class="col-xs-6"><?php echo $user->email; ?></div>
                </div>
                <div class="row margin10">
                    <div class="col-xs-6 text-right">Phone :</div>
                    <div class="col-xs-6"><?php echo $user->phone; ?></div>
                </div>
                <div class="row margin10">
                    <div class="col-xs-6 text-right">User Type :</div>
                    <div class="col-xs-6">Trial</div>
                </div>
                
                <div class="row margin20">
                    <div class="divide40"></div>
                    <div class="col-sm-12 text-center">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Your Trial period will expire in <?php echo $expire_within;?></h3>
                            </div>
                            <div class="panel-body">
                                <a  class="btn-adhi" href="<?php echo base_url().'user/register'; ?>" rel="nofollow">Register</a> to avail full features
                            </div>
                          </div>
                    </div>
                </div>
            <?php }?>
        </div>
    </div>
</div>
