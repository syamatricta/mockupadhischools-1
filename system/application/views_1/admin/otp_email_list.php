<?php echo form_open("admin/credential_list");?>
	<div class="adminmainlist">
		<div class="admininnercontentdiv">
			<div class="adminmaindiv">
				<div class="floatleft"><img  src="<?php  echo $this->config->item('images');?>loginkey.jpg" /></div>
				<div class="floatleft" >
					<div  id="error"  class="page_error" style="width:240px;" id="display_error">	</div>
					<div class="page_error" style="width:350px;" id="display_error">
						<?php if(validation_errors()){echo validation_errors();	}
						if($this->session->flashdata('msg'))
                                                    echo $this->session->flashdata('msg');
                                                if(isset($msg) && $msg != ""){
                                                    echo $msg;
                                                }
                                                if($this->uri->segment("3") == "sub")
                                                    echo "Your account has been deleted. Please contact administrator.";
                                                ?>
					</div>	
					<div class="logintext" style="font-size: 15px;">Login Credential</div>
					<div class="clearboth"></div>
					<div class="floatleft" style="width:240px;">
						<div class="adminlogin"><input type="text" name="otp_credential"  maxlength="50"  value="<?php echo set_value('otp_credential')?>" id="otp_credential" style="width:200px;" /></div>
					</div>
					<div class="clearboth"></div>
					
					<div class="clearboth"></div>
					<div class="floatleft" style="width:200px;">
						<div class="adminlogin"><input type="submit" value="Submit" onclick="javascript:return validateOtp();"/></div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo form_close();?>