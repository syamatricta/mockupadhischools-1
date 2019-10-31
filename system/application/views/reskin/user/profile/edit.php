<?php page_heading('Profile' , 'banner-inner');?>
<div class="text-right" style="margin-right:8%;">		
    <span><a href="<?php echo base_url(); ?>">Home</a></span>		
    <span class="content">|Edit profile</span> 		
</div>
<div class="container">
    <div class="divide40"></div>    
    <div class="row margin40">
        <div class="col-sm-10 col-sm-offset-1">
            <?php
                echo form_open_multipart('profile/edit', array('name'=>'form_edit_profile','id' => 'form_edit_profile'));
                if(count($userdetails) > 0){ ?>
                    <div class="row"><?php showMessage();?></div>
                    <?php $licensetype = ('S' == $userdetails->licensetype) ? "Sales" : "Broker"; ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="well text-center"><b>License Type:</b> <?php echo $licensetype.', '.@$course_user_type->course_type.', '.@$course_user_type->payment_type;?></h4>
                        </div>
                    </div>
            <?php
                    $this->load->view('reskin/user/profile/_edit_personal_info');

                    $this->load->view('reskin/user/profile/_edit_shipping_info');

                    $this->load->view('reskin/user/profile/_edit_billing_info');
                    ?>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <input type="submit" class=" btn-adhi" value="Update" />
                            <input type="button" class=" btn-adhi go_to_url" value="Cancel" data-url="<?php echo base_url().'profile'; ?>" />
                        </div>
                    </div>
                    <?php
                }
                echo form_close();
            ?>
            
        </div>
    </div>
</div>