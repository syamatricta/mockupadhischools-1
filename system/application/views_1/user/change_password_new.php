<div class="floatleft">
      <div class="left_cntnr" style="position: relative;">
            <?php $this ->load->view('left_content.php');?>
    </div>
    <div class="right_cntnr">
        <div class="right_cntnr_bg_hd">
             <div class="floatleft" style="width:100%;">
				 <div class="sitepagehead"><h1>Change Password</h1><h2>Change Password</h2></div>
				 <div class="username"><?php disp_loggedin_username(); ?></div>
			 </div>
            
            
        </div>
        <?php 
        if($this->session->flashdata("success")) {
            $style_success = "block";
        } else {
            $style_success = "none";
        }
        if($this->session->flashdata("error")) {
            $style_error = "block";
        } else {
            $style_error = "none";
        }
        ?>
        <div class="right_cntnr_bg">
        	<?php $this->load->view('second_navigation');?>
                         <?php echo  form_open ('user/change_password', array('name'=>'change_password_form_adhi','id' => 'change_password_form_adhi', 'class' => '',  'onsubmit'=>'javascript: return change_password ();') ); ?>
                        <div id="maindiv">
                            <?php /*functional part */?>
                                <div class="clearboth">&nbsp;</div>
                                <div class="profileinnercontentdiv" >
                                               <center>
                                    <div class="change_pwd_cntnr" >
                                        <div class="change_password_main"  >
                                            <div class="wrap-box-fixed" id="wrap_error_box">
                                                <div class="page_error box-fixed-error-password" id="errordisplay" style="display:<?php echo $style_error;?>"><?php echo $this->session->flashdata("error"); ?></div>
                                                <button class="close-profile-password" id="close_button" data-dismiss="alert" type="button" onclick="hide_errorbox_profile();" style="display:<?php echo $style_error;?>;">×</button>
                                             </div>
                                            <div  class="page_error" id="flasherror"></div>
                                              <div class="wrap-box-fixed" id="wrap_error_box">
                                                <div  class="page_success box-fixed-success-password" id="flashsuccess" style="display:<?php echo $style_success;?>"><?php echo $this->session->flashdata("success");   ?></div>
                                                <button class="close-profile-password" id="close_button_success" data-dismiss="alert" type="button" onclick="hide_errorbox_success();" style="display:<?php echo $style_success;?>">×</button>
                                            </div>
                                        <div class="fields_cntnr">
                                            <div class="testbox_label">Current Password<span class="madatory"> *</span></div>
                                            <div class="text_box_div"><input type="password" maxlength="50" size="25" name="old_password" id="old_password"></div>
                                            <div class="testbox_label">New Password<span class="madatory"> *</span></div>
                                            <div class="text_box_div"><input type="password" maxlength="50" size="25" name="new_password" id="new_password"></div>
                                            <div class="testbox_label">Retype Password<span class="madatory"> *</span></div>
                                            <div class="text_box_div"><input type="password" maxlength="50" size="25" name="confirm_password" id="confirm_password"></div>
                                            <div class="button_cntnr">
                                                <img src="<?php echo $this->config->item('images').'innerpages/chng_passwd.png'?>" alt="Change Password" style="cursor:pointer" onclick="javascript:change_password();hidealert();return false;" />
                                            </div>
                                        </div>
                                        </div> 
                                    </div>
                                               </center>
                                </div>
                            <div class="floatleft" >
                                <?php //echo $this->load->view('user/client_menu');?>
                            </div>
                        </div>
                            <?php echo form_close();?>


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