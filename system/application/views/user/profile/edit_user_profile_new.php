<div class="floatleft">
	<div class="left_cntnr" style="position: relative;">
		<?php $this ->load->view('left_content.php');?>
	</div>
	
    <div class="right_cntnr">
    	<div class="right_cntnr_bg_hd">
    		<div class="floatleft" style="width:100%;">
    			<div class="sitepagehead"><h1>Profile</h1></div>
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
            			<div id="profileviewmain_edit" >
            				<?php if(count($userdetails) > 0): ?>
            					<div class="clearboth"></div>
            					<div class="profileinnercontentdiv">
            						<div class="listdata">
	            						<!--<div class="leftsideheadings_profileedit">License Type</div>
	            						<div class="middlecolon_profile_edit">:</div>
	            						<div class="rightsidedata_profileedit">-->
	            							<?php $licensetype = ($userdetails->licensetype) ? "Sales" : "Broker"; ?>
	            						<!--</div>-->
	            						<center>
	            							<div class="edit_profile_cntnr">
                                                                            <?php
                                                                            if(validation_errors () || $this->session->flashdata("error")) {
                                                                                $style = "block";
                                                                            } else {
                                                                                $style = "none";
                                                                            }
                                                                            
                                                                            if($this->session->flashdata("success")) {
                                                                                $style_success = "block";
                                                                            } else {
                                                                                $style_success = "none";
                                                                            }
                                                                            ?>
	            								<div class="wrap-box-fixed" id="wrap_error_box">
                                                                                    <div class="page_error box-fixed-error-profile" id="errordisplay" style="display:<?php echo $style;?>"><?php if (validation_errors ()) : echo validation_errors (); endif;echo $this->session->flashdata("error");?></div>
                                                                                    <button class="close-profile" id="close_button" data-dismiss="alert" type="button" onclick="hide_errorbox();" style="display:<?php echo $style;?>">×</button>
                                                                                </div>
	            								<div  class="page_error" id="flasherror"><?php //echo $this->session->flashdata("error"); ?></div>
	            								
                                                                                <div class="wrap-box-fixed" id="wrap_error_box">
                                                                                    <div  class="page_success  box-fixed-success-profile" id="flashsuccess" style="display:<?php echo $style_success;?>"><?php echo $this->session->flashdata("success");   ?></div>
                                                                                    <button class="close-profile" id="close_button_success" data-dismiss="alert" type="button" onclick="hide_errorbox_success();" style="display:<?php echo $style_success;?>">×</button>
                                                                                </div>
                                                                                
                                                                                <?php //if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
	            								
	            								<div class="commonaddressheads_edit" style="padding-top:20px;">
	            									<div class="floatleft"><img  align="left" src="<?php  echo $this->config->item('images');?>personal_details.png" alt="Personal Details" /></div>
	            									<div class="license_type_txt">License Type: <?php echo $licensetype.', '.@$course_user_type->course_type.', '.@$course_user_type->payment_type;?></div>
	            								</div>
	            								<div class="clearboth"></div>
	            								
	            								<?php echo $this->load->view('user/profile/edit_profile_personal_details');?>
	            								<div class="clearboth">&nbsp;</div>
					
												<!--<div class="commonaddressheads_edit"><img  align="left" src="<?php  echo $this->config->item('images');?>contact_address.png" /></div>
												<?php echo $this->load->view('user/profile/edit_profile_contact_details');?>
												<div class="clearboth">&nbsp;</div>-->
												
												<div class="commonaddressheads_edit"><img  align="left" src="<?php  echo $this->config->item('images');?>shipping_address.png" alt="Shipping Address" /></div>
												<?php echo $this->load->view('user/profile/edit_profile_shipping_details');?>
												<div class="clearboth">&nbsp;</div>
												
												<div class="commonaddressheads_edit"><img  align="left" src="<?php  echo $this->config->item('images');?>billing_address.png" alt="Billing Address" /></div>
												<?php echo $this->load->view('user/profile/edit_profile_billing_details')?>
												<div class="clearboth" style="padding-bottom:30px;"></div>
												
												<div class="middlebutton">
													<img src="<? echo $this->config->item('images').'innerpages/update.png'?>" alt="Update"
														 style="cursor:pointer; 
														 padding-right:10px;" 
														 onclick="javascript:fncUpadteUserprofile();hidealert();return false;" />
													<a href="<?php echo base_url().'profile'?>" rel="nofollow"><img src="<? echo $this->config->item('images').'cancel.png'?>" alt="Cancel" style="cursor:pointer"  /></a>
												</div>
											</div>
										</center>
									</div>
								</div>
							<?php endif; ?>
						</div>
					
						<div class="floatleft" ><?php //echo $this->load->view('user/client_menu');?></div>
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
<script>
function show() {
    document.getElementById("errordisplay").style.display = "none";
    document.getElementById("close_button").style.display = "none";
    
    document.getElementById("flashsuccess").style.display = "none";
    document.getElementById("close_button_success").style.display = "none";
}
function hidealert() {
    setTimeout("show()", 9000);  
}
setTimeout("show()", 9000);  
</script>