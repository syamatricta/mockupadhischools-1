<?php echo  form_open ('forgot-password', array('name'=>'forgot_password_form_adhi','id' => 'forgot_password_form_adhi', 'class' => '',  'onsubmit'=>'javascript: return forgot_password ();') ); ?>
<div class="floatleft">
      <div class="left_cntnr" style="position: relative;">
            <?php $this ->load->view('left_content.php');?>
    </div>
    <div class="right_cntnr">
        <div class="right_cntnr_bg_hd">
            <div class="sitepagehead"><h1>Forgot Password?</h1><h2>Forgot Password?</h2></div>
        </div>
        <div class="right_cntnr_bg">
            <center>
            <div class="forgot_pwd_cntnr">
                <div class="forgot_pwd_txt">
                <span style="font-size:12px;">Forgot your password?</span><br>
                Enter your login email below. We will send you an email with password. 
                </div>
                    <div class="page_error" id="errordisplay">&nbsp;</div>
					<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error"); ?></div>
					<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
                    <div class="fields_cntnr">
                        <div class="testbox_label" style="width:99px;">Email Address<span class="madatory"> *</span></div>
                        <div class="text_box_div"><input type="text" maxlength="50" size="30" name="email" id="email"></div>
                        <div class="button_cntnr">
                        	<div class="fl">
                        		<div class="fgtPwd_submit" style="cursor:pointer" onclick="javascript:return forgot_password();" ></div>
                         	</div>
                         	<div class="fl">
                         		<a href="<?php echo base_url().'user/user_login'?>"><div class="fgtPwd_cancel" style="cursor:pointer" ></div></a>
                         	</div>
                           	<div class="cb"></div>
                           
                            
                        </div>
                    </div>
            </div>
            </center>
        </div>
    </div>
</div>
<?php echo form_close();?>

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