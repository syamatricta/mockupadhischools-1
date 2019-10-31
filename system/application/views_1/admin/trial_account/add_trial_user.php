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
                                                <div class="leftsideheadings_view padding_r">First Name :<span class="red_star">*</span></div>
                                                <div class="middlecolon">&nbsp;</div>
                                                <div class="rightsidedata_view"><input type="text" name="first_name" id="first_name" class="textwidth"  maxlength="128"  value="<?php echo array_key_exists("first_name", $userdetails)  ?  $userdetails['first_name'] : set_value('first_name'); ?>"/></div>
                                                <div class="clearboth"></div>
                                                
                                                <div class="leftsideheadings_view padding_r">Last Name :<span class="red_star">*</span></div>
                                                <div class="middlecolon">&nbsp;</div>
                                                <div class="rightsidedata_view"><input type="text" name="last_name" id="last_name" class="textwidth"  maxlength="128"  value="<?php echo array_key_exists("last_name", $userdetails)  ?  $userdetails['last_name'] : set_value('last_name'); ?>"/></div>
                                                <div class="clearboth"></div>
                                                
                                                <div class="leftsideheadings_view padding_r">E-mail :<span class="red_star">*</span></div>
                                                <div class="middlecolon">&nbsp;</div>
                                                <div class="rightsidedata_view"><input type="text" name="email" id="email"  class="textwidth" maxlength="128" value="<?php echo array_key_exists("email", $userdetails)  ?  $userdetails['email'] : set_value('email'); ?>"/></div>
                                                <div class="clearboth"></div>
                                                
                                                <div class="leftsideheadings_view padding_r">Confirm E-mail :<span class="red_star">*</span></div>
                                                <div class="middlecolon">&nbsp;</div>
                                                <div class="rightsidedata_view"><input type="text" name="confirmemail" id="confirmemail" class="textwidth" maxlength="128" value="<?php echo array_key_exists("email", $userdetails)  ?  $userdetails['email'] : set_value('confirmemail'); ?>"/></div>
                                                <div class="clearboth"></div>
                                                
                                                <div class="leftsideheadings_view padding_r">Password :<?php if(0 == $is_edit){?><span class="red_star">*</span><?php }?></div>
                                                <div class="middlecolon">&nbsp;</div>
                                                <div class="rightsidedata_view"><input type="password" name="psword" id="psword" class="textwidth" maxlength="128" value="<?php echo array_key_exists("psword", $userdetails)  ?  '' : set_value('psword'); ?>"/></div>
                                                <div class="clearboth"></div>
                                                
                                                <div class="leftsideheadings_view padding_r">Confirm Password :<?php if(0 == $is_edit){?><span class="red_star">*</span><?php }?></div>
                                                <div class="middlecolon">&nbsp;</div>
                                                <div class="rightsidedata_view"><input type="password" name="psword1" id="psword1" class="textwidth" maxlength="128" value="<?php echo array_key_exists("psword1", $userdetails)  ?  '' : set_value('psword1'); ?>"/></div>
                                                <div class="clearboth"></div>
                                                
                                                <div class="leftsideheadings_view padding_r">Phone :<span class="red_star">*</span></div>
                                                <div class="middlecolon">&nbsp;</div>
                                                <div class="rightsidedata_view"><input type="text" name="phone" id="phone" class="textwidth"  maxlength="128"  value="<?php echo array_key_exists("phone", $userdetails)  ?  $userdetails['phone'] : set_value('phone'); ?>"/></div>
                                                <div class="clearboth"></div>
                                                
                                                
                                <?php /*content add recruiter main end*/?>
                                    <div class="row padding_l">
                                        <div class="clearboth">&nbsp;</div>
                                        <input type="hidden" id="userid" value="<?php echo $userid;?>" />
                                        <input class="btn red" class=""type="button" value="<?php echo $btn; ?>" onclick ="javascript : fncSaveTrialUser();" >
                                        <div class="backtolist"><?php echo anchor('admin_user/list_trial_users','<< Back to Guest Users list')?></div>
                                    </div>
                                </div>
                <div class="register_instructionmark" style="padding-right:10px; margin-right: 142px;"><span class="instruction">Marked with </span><span class="red_star">*</span> <span class="instruction">are mandatory fields</span></div>
        <div class="clearboth">&nbsp;</div>
			
    </div> <?php /* end of adminmainlist */ ?>
</div>
</form>



<style>
    .leftsideheadings_view{width:15%;}
    .rightsidedata_view{width:70%;}
</style>