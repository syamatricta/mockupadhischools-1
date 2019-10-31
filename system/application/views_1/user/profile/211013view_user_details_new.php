<div class="floatleft">
	<div class="left_cntnr" style="position: relative;">
		<?php $this ->load->view('left_content.php');?>
	</div>
	
    <div class="right_cntnr">
    	<div class="right_cntnr_bg_hd">
    		<div class="floatleft" style="width:100%;">
    			<div class="profle_title"></div>
    			<div class="username">
	            	<?php disp_loggedin_username(); //if(count($userdetails) > 0){ echo $userdetails->firstname." ".$userdetails->lastname; } ?>
	            </div>
             </div>
        </div>
        
        <div class="right_cntnr_bg">
        	<?php $this->load->view('second_navigation');?>
            
            <center>
				<?php echo form_open_multipart('admin_user', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
					<div id="maindiv">
						<div id="profileviewmain">
							<?php if(count($userdetails) > 0): ?>
							<div class="clearboth"></div>
                            <div class="profileinnercontentdiv">
                            	<div class="listdata">
                            	
                                    <div class="commonaddressheads"><img  align="left" src="<?php  echo $this->config->item('images');?>personal_details.png" /></div>
                                    <?php echo $this->load->view('user/profile/view_profile_personal_details');?>
                                    <div class="clearboth">&nbsp;</div>
                                    
                                    <!--<div class="commonaddressheads"><img  align="left" src="<?php  echo $this->config->item('images');?>contact_address.png" /></div>
                                    <?php echo $this->load->view('user/profile/view_profile_contact_details');?>
                                    <div class="clearboth">&nbsp;</div>-->
                                    
                                    <div class="commonaddressheads"><img  align="left" src="<?php  echo $this->config->item('images');?>shipping_address.png" /></div>
                                    <?php echo $this->load->view('user/profile/view_profile_shipping_details');?>
                                    <div class="clearboth">&nbsp;</div>
                                    
                                    <div class="commonaddressheads"><img  align="left" src="<?php  echo $this->config->item('images');?>billing_address.png" /></div>
                                    <?php echo $this->load->view('user/profile/view_profile_billing_details')?>
                                    <div class="clearboth" style="padding-bottom:30px;"></div>
                                    
                                </div>
                            </div>
                             <div class="floatleft" >
                                <div class="editprofile" >
                                            <?php //echo anchor('profile/edit_profile','Edit My Profile');?>
                                    <a href="<?php echo base_url().'profile/edit_profile'; ?>"><img  align="right" src="<?php  echo $this->config->item('images');?>edit_profile.png" /></a>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="floatleft">
                            <?php //echo $this->load->view('user/client_menu');?>
                    	</div>
                	</div>
            	<?php echo form_close();?>
			</center>
		</div>
	</div>
</div>

<style type="text/css">
	body {
		font-family: Arial, Helvetica, sans-serif;
        text-align: left;
        padding: 0px;
        margin-top:0px;
        background:url(<?php echo base_url().'images/bg_01.jpg'?>) #000000 no-repeat center top;
        height:auto;
	}
</style>