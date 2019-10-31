<?php echo form_open("admin/credential_check");?>
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
                                                ?>
					</div>	
					<br/><div class="logintext">Enter authentication code</div>
					<div class="clearboth"></div>
					<div class="floatleft" style="width:240px;">
						<div class="adminlogin"><input type="text" name="otp"  maxlength="15"  value="<?php echo set_value('otp')?>" id="otp" style="width:200px;" /></div>
					</div>
					<div class="clearboth"></div>
                                        
					<div class="floatleft" style="width:240px;">
						<div class="adminlogin"><input type="submit" value="Submit" onclick="javascript:return validateOtpValue();"/></div>
					</div>
                                        
                                        <div class="clearboth"></div>
                                        <br/> <br/>
                                        <div class="floatleft">
						<div class=""><a href="<?php echo base_url(); ?>admin/repeat_credential"> Click here to resend the authentication code </a></div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo form_close();?>