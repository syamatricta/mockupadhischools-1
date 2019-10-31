<?php page_heading('Profile' , 'banner-inner');?>
<div class="text-right" style="margin-right:8%;">		
    <span><a href="<?php echo base_url(); ?>">Home</a></span>		
    <span class="content">|Profile</span> 		
</div>
<div class="container">
    <div class="divide40"></div>
    <div class="row margin40">
        <div class="col-sm-10 col-sm-offset-1">
            <?php if(count($userdetails) > 0){ ?>
                
                <?php $this->load->view('reskin/user/profile/_view_personal_info');?>
                <?php if(!is_BRE_test_user()){?>
                    <?php $this->load->view('reskin/user/profile/_view_shipping_info');?>
                    <?php
                        if( trim($userdetails->b_address)!=''){
                            $this->load->view('reskin/user/profile/_view_billing_info');
                        }
                    ?>
                    <div class="row margin20">
                        <div class="divide40"></div>
                        <div class="col-sm-12 text-center">
                            <a  class="btn-adhi" href="<?php echo base_url().'profile/edit'; ?>" rel="nofollow">Edit My Profile</a>
                        </div>
                    </div>
                <?php }?>
            <?php }?>
        </div>
    </div>
</div>
