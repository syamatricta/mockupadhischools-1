<div class="floatleft">
      <div class="left_cntnr pos_rel">
            <?php $this ->load->view('left_content.php');?>
    </div>
    <div class="right_cntnr">
        <div class="right_cntnr_bg_hd">
        	<div class="sitepagehead"><h1>Login</h1><h2>Login</h2></div>
        </div>
        <div class="right_cntnr_bg_login">
            <center>

                     <div class="clientlogin_cntnr">
			<?php echo form_open("user/login", array('name'=>'loginform','id' => 'loginform'));?>
				<div class="logindet">
					<div class="loginhead"><div class="loginpage_title cp"></div></div>
                    <div class="clearboth h18"></div>
					<div  id="error"  class="page_error login_error" id="display_error w320">
					<?php if(validation_errors()){echo validation_errors();	}
					if($this->session->flashdata('error'))
					echo $this->session->flashdata('error');
						?>
					</div>
					<div  class="page_success fl" id="flashsuccess"><?php if($this->session->flashdata('msg'))
					echo $this->session->flashdata('msg');   ?></div>
					<div class="page_error login_error" id="server_error"></div>
					<div class="clearboth"></div>
                    <div class="login_email_pwd"><div class="login_field_username"></div></div>
                    <div class="login_email_pwd"><div class="login_field_password"></div></div>
					<div class="text_box_div_login">
                        <input type="text" class="textbox" maxlength="50" name="username" id="username" value="Email Address" title="Email Address" onblur="fillField(this)" onfocus="clearField(this)" autocomplete="off"/>
                        <div  class="login_form_arrow"></div>
                    </div>
                    <div class="text_box_login_space">&nbsp;</div>
					<div class="text_box_div_login" >                       
                        <input type="password" onblur="signPassAddComon(this,'sign_temp_password_errlog');" name="password" id="password" autocomplete="off" value=""  class="textbox pswd" style="display:none;"/>
                    <input type="text" onfocus="passwordFieldFocus(this,'password',false);" name="sign_temp_password_errlog" id="sign_temp_password_errlog" autocomplete="off" value="Password" class="textbox loginpass ldb" autocomplete="off"/> 
                    
                        <div  class="login_form_arrow"></div>
                    </div>
					<div class="homeloginbuttons" ><input type="submit" value="" class="login_img" onclick="javascript:return validate_user_Login();"></div>
					<div class="clearboth"></div>
					<?php if($msg==1){?>
						<div class="forcedlogin"><input type="checkbox" name="forced_login" id="forced_login"> Force Login</div>
					<?php }else{?>
						<div class="forcedlogin">&nbsp;</div>
					<?php }?>

					<div class="forgotpassword"><?php echo anchor('forgot-password','Forgot Password?',array("rel"=>"nofollow"));?></div>

				</div>
			<?php echo form_close();?>
			</div>
            </center>
        </div>
    </div>
</div>