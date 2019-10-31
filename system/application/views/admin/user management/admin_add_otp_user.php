

<form name="addotpuserform" id="addotpuserform" method="post" action="">
<div class="adminmainlist">
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $head; ?></div>
	</div> 
        <?php /*end of  adminpagebanner */?>
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		<div class="page_error" id="errordisplay"></div>
                <div  class="page_error" id="errordiv" ><?php if(isset($msg)) echo $msg; ?></div>
                <div  class="page_success" id="flashsuccess"><?php if(isset($msgs)) echo $msgs;   ?></div>
                <?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
                <div class="clearboth"></div>
                                <div class="listdata">
                                                <div class="clearboth">&nbsp;</div>
                                                <div class="leftsideheadings_view padding_r">Name :<span class="red_star">*</span></div>
                                                <div class="middlecolon">&nbsp;</div>
                                                <div class="rightsidedata_view"><input type="text" name="firstname" id="firstname" class="textwidth"  maxlength="128"  value="<?php echo array_key_exists("name", $userdetails)  ?  $userdetails['name'] : set_value('firstname'); ?>"/></div>
                                                <div class="clearboth"></div>
                                                
                                                <div class="leftsideheadings_view padding_r">Phone :</div>
                                                <div class="middlecolon">&nbsp;</div>
                                                <div class="rightsidedata_view"><input type="text" name="phone" id="phone" class="textwidth"  maxlength="128"  value="<?php echo array_key_exists("phone", $userdetails)  ?  $userdetails['phone'] : set_value('phone'); ?>"/></div>
                                                <div class="clearboth"></div>

                                                <div class="leftsideheadings_view padding_r">E-mail :<span class="red_star">*</span></div>
                                                <div class="middlecolon">&nbsp;</div>
                                                <div class="rightsidedata_view"><input type="text" name="email" id="email"  class="textwidth" maxlength="128" value="<?php echo array_key_exists("email_id", $userdetails)  ?  $userdetails['email_id'] : set_value('email'); ?>"/></div>
                                                <div class="clearboth"></div>

                                                <div class="leftsideheadings_view padding_r">Confirm E-mail :<span class="red_star">*</span></div>
                                                <div class="middlecolon">&nbsp;</div>
                                                <div class="rightsidedata_view"><input type="text" name="confirmemail" id="confirmemail" class="textwidth" maxlength="128" value="<?php echo array_key_exists("email_id", $userdetails)  ?  $userdetails['email_id'] : set_value('confirmemail'); ?>"/></div>
                                                <div class="clearboth"></div>
                                                
                                <?php /*content add recruiter main end*/?>
                                        <div class="row padding_l">
                                              <div class="clearboth">&nbsp;</div>
                                              <?php if(!$action) { // Add ?>
                                                        <input class="btn red" class=""type="button" value="<?php echo $btn; ?>" onclick ="javascript : fncAddOtpUserdetails();" >
                                                    <?php } else { // Edit ?>
                                                        <input class="btn red" class=""type="button" value="<?php echo $btn; ?>" onclick ="javascript : fncUpdateOtpUserdetails(<?php echo $userdetails['id']; ?>);" >
                                                    <?php } ?>
                                              <div class="backtolist"><?php echo anchor('admin_user/list_otp_users','<< Back to OTP users list')?></div>
                                        </div>
                                </div>
                <div class="register_instructionmark" style="padding-right:10px; margin-right: 142px;"><span class="instruction">Marked with </span><span class="red_star">*</span> <span class="instruction">are mandatory fields</span></div>
        <div class="clearboth">&nbsp;</div>
			
    </div> <?php /* end of adminmainlist */ ?>
</div>
</form>



