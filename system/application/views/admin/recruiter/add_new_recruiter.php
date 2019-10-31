


<form name="addrecruiterform" id="addrecruiterform" method="post" action="">
<div class="adminmainlist">
	<div class="adminpagebanner">
		<div class="adminpagetitle">Add Recruiter</div>
	</div> 
        <?php /*end of  adminpagebanner */?>
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		<div class="page_error" id="errordisplay"></div>
                <div  class="page_error" id="errordiv" ><?php if(isset($msg)) echo $msg; ?></div>
                <div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("msg");   ?></div>
                <?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
                <div class="clearboth"></div>
                                <div class="listdata">
                                                <div class="clearboth">&nbsp;</div>
                                                <div class="leftsideheadings_view padding_r">First Name :<span class="red_star">*</span></div>
                                                <div class="middlecolon">&nbsp;</div>
                                                <div class="rightsidedata_view"><input type="text" name="firstname" id="firstname" class="textwidth"  maxlength="128"  value="<?php echo set_value('firstname'); ?>"/></div>
                                                <div class="clearboth"></div>
                                                
                                                <div class="leftsideheadings_view padding_r">Last Name :</div>
                                                <div class="middlecolon">&nbsp;</div>
                                                <div class="rightsidedata_view"><input type="text" name="lastname" id="lastname" class="textwidth"  maxlength="128"  value="<?php echo set_value('lastname'); ?>"/></div>
                                                <div class="clearboth"></div>

                                                <div class="leftsideheadings_view padding_r">E-mail :<span class="red_star">*</span></div>
                                                <div class="middlecolon">&nbsp;</div>
                                                <div class="rightsidedata_view"><input type="text" name="email" id="email"  class="textwidth" maxlength="128" value="<?php echo set_value('email'); ?>"/></div>
                                                <div class="clearboth"></div>

                                                <div class="leftsideheadings_view padding_r">Confirm E-mail :<span class="red_star">*</span></div>
                                                <div class="middlecolon">&nbsp;</div>
                                                <div class="rightsidedata_view"><input type="text" name="confirmemail" id="confirmemail" class="textwidth" maxlength="128" value="<?php echo set_value('confirmemail'); ?>"/></div>
                                                <div class="clearboth"></div>
                                                
                                                <div class="leftsideheadings_view padding_r">Copy Email :</div>
                                                <div class="middlecolon">&nbsp;</div>
                                                <div class="rightsidedata_view"><input type="text" name="copy_email" id="copy_email"  class="textwidth" maxlength="128" value="<?php echo set_value('copy_email'); ?>"/></div>
                                                <div class="clearboth"></div>


                                                <div class="leftsideheadings_view padding_r">Brokerage :<span class="red_star">*</span></div>
                                                <div class="middlecolon">&nbsp;</div>
                                                <div class="rightsidedata_view"><input type="text" name="brokerage" id="brokerage" class="textwidth" maxlength="128" value="<?php echo set_value('brokerage'); ?>"/></div>
                                                <div class="clearboth"></div>
                                <?php /*content add recruiter main end*/?>
                                        <div class="row padding_l">
                                              <div class="clearboth">&nbsp;</div>
                                              <input class="btn red" class=""type="button" value="Add" onclick ="javascript : fncAddRecruiterdetails();" >
                                              <div class="backtolist"><?php echo anchor('admin_recruiter/list_recruiter/'.$page_no,'<< Back to recruiters list')?></div>
                                        </div>
                                </div>
                <div class="register_instructionmark" style="padding-right:10px; margin-right: 142px;"><span class="instruction">Marked with </span><span class="red_star">*</span> <span class="instruction">are mandatory fields</span></div>
        <div class="clearboth">&nbsp;</div>
			
    </div> <?php /* end of adminmainlist */ ?>
</div>
</form>



