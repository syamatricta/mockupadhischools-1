<?php page_heading('Confirm login' , 'banner-inner'); ?>
<div class="divide40"></div>
<div class="container margin40">
	<div class="col-sm-11 col-sm-offset-1">
		<?php echo  form_open ('course/confirm_password', array('name'=>'examconfirm_password_form_adhi','id' => 'examconfirm_password_form_adhi', 'class' => '') ); ?>
		<div class="row">
			<div class="col-sm-12 margin10">
	            <div class="heading_band">Enter Your Login Password</div>
	        </div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="page_error" id="errordisplay"></div>
                <?php
                if($this->session->flashdata("error") || '' != validation_errors()) {
                    $style = "block";
                } else {
                    $style = "none";
                }
                ?>
                <div class="wrap-box-fixed" id="wrap_error_box">
                    <div  class="page_error box-fixed" id="errordiv" style="display:<?php echo $style;?>">
                      <?php 
                        if($this->session->flashdata("error")){
                            echo $this->session->flashdata("error");
                        }else if('' != validation_errors()){ 
                            echo validation_errors();                            
                        }
                        ?>
                    </div>
                    <button class="close" id="close_button" data-dismiss="alert" type="button" onclick="hide_errorbox();" style="display:<?php echo $style;?>">×</button>
                </div> 
                <div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3">
				<div class="form-group">
				    <label for="txt_password">Password</label>				    
				    <input type="password" class="form-control" name="txt_password" id="txt_password">
				  </div>
			</div>
                    
                        <?php if('' != s('DRIVING_LICENSE')){?>
                        <div class="col-sm-6 col-sm-offset-3">
                            <div class="form-group">
                                <label for="txt_driving_license">Drivers License Number</label>				    
                                <input type="password" class="form-control" name="txt_driving_license" id="txt_driving_license" required="" maxlength="20">
                            </div>
			</div>
                        <?php }?>
			<div class="col-sm-6 col-sm-offset-3 ">
                            <input type="submit" class=" btn-adhi" value="Submit" />
                            <button class="btn-adhi" id="cancelpdconfirm">Cancel</button>
                            <!--a href="<?php echo site_url()."/course/courselist"?>" class="btn-adhi"><i class="fa fa-remove"></i> </a-->
					 
			</div>
		</div>
		<?php echo form_close();?>
	</div>
</div>
<script>
function show() {
    document.getElementById("errordiv").style.display = "none";
    document.getElementById("close_button").style.display = "none";
}
function hidealert() {
    setTimeout("show()", 9000);  
}
setTimeout("show()", 9000);  
</script>