<div style="height:300px;padding-left: 20px;">
        <?php if($this->session->userdata ('ADMINTYPE') == 1) { ?>
	Welcome to Admins profile	
        <?php } else { ?>
        <!--<div>Welcome to Sub-Admins profile</div>-->
        <div style="margin: 10px 0 10px 0px;">Welcome <?php echo $this->session->userdata("USERNAME"); ?></div>
        <div class="adminmainlist">
		<div class="adminpagebanner">
                    <div  class="page_success" id="flashsuccess" style="margin-left:38%;padding-top:10px;"><?php echo $this->session->flashdata("success"); ?></div>
                    <div class="adminpagetitle" style="margin-left: 40%;padding-top: 10px;">User management</div>
                    <div class="clearboth"></div>
                    
                    <div class="sub-admin-register"><a href="<?php echo site_url()."admin_register/register"?>">Add new user</a></div>
                </div>
	</div>
        <?php } ?>

</div>
<script type="text/javascript" src="<?php echo base_url();?>jscripts/tiny_mce/tiny_mce.js"></script> 
