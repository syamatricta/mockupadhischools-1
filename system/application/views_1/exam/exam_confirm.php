<div class="floatleft">
     <div class="left_cntnr" style="position: relative;">
            <?php $this ->load->view('left_content.php');?>
    </div>
    <div class="right_cntnr">
        <div class="right_cntnr_bg_hd">
        	 <div class="floatleft" style="width:100%">
            	<div class="sitepagehead"><h1>Login</h1></div>
            	<div class="username"><?php disp_loggedin_username(); ?></div>
            </div>            
            <div class="user_name_display">
              <?php //if(count($userdetails) > 0){ echo $userdetails->firstname." ".$userdetails->lastname; } ?>
            </div>
        </div>
        <div class="right_cntnr_bg">
        	<?php $this->load->view('second_navigation');?>
          	<?php echo  form_open ('exam/confirm_password', array('name'=>'confirm_password_form_adhi','id' => 'confirm_password_form_adhi', 'class' => '',  'onsubmit'=>'javascript: return check_password ();') ); ?>
			<div id="maindiv">
				 <div class="profileinnercontentdiv" >
			     	<center>
				        <div class="change_pwd_cntnr" >
				        	
				            <div class="change_password_main"  >
				                <div class="page_error" id="errordisplay"></div>
				                <?php
                                if($this->session->flashdata("error")) {
                                    $style = "block";
                                } else {
                                    $style = "none";
                                }
                                ?>
				                <div class="wrap-box-fixed" id="wrap_error_box">
                                    <div  class="page_error box-fixed" id="errordiv" style="display:<?php echo $style;?>">
                                      <?php if($this->session->flashdata("error")) echo $this->session->flashdata("error"); ?>
                                    </div>
                                    <button class="close" id="close_button" data-dismiss="alert" type="button" onclick="hide_errorbox();" style="display:<?php echo $style;?>">×</button>
                                </div> 
				                <div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
				                
				                <div class="quizsubject" style="padding-left:70px;">Enter Your Login Password</div>
				            <div class="fields_cntnr" >
				                <div class="testbox_label"><b>Password</b></div>
				                <div class="text_box_div">
				                	<input type="password" name="txt_password" id="txt_password">
				                	<div style="clear:both">&nbsp;</div>
					                <div class="middlebutton" style="padding-left:70px;">
										<input  class="submitbutton" type="submit" name="butcheck" value="" /> 
										<input type="button" name="butCancel" class="cancelbutton" value="" onclick="javascript:cancel_confirm('<?php echo site_url()."/exam/courselist"?>');" />
									</div>
								</div>
							</div>
				            </div>
				            </div> 
				        </div>
			        </center>
			    </div>
			</div>
			<?php echo form_close();?>
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
    document.getElementById("errordiv").style.display = "none";
    document.getElementById("close_button").style.display = "none";
}
function hidealert() {
    setTimeout("show()", 9000);  
}
setTimeout("show()", 9000);  
</script>