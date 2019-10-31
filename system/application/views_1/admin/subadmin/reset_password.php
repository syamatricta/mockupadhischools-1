<?php echo form_open('admin_sub', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="clearboth"></div>
<form name="registerform" id="myform" method="post" action="">
<div id="maindiv" style="width:1023px;">
    <div id="registerviewmain">
        <div class="stmain">
            <div class="floatleft"><span class="registerredheading"><?php echo $page_title;?></span></div>
            <div class="clearboth"></div>
            <div class="registerinnerregistercontentdiv" >
            <div class="page_error" id="errordisplay"></div>
            <div  class="page_error" id="errordiv" ><?php if(isset($msg)) echo $msg; ?></div>
            <div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("msg");   ?></div>
            <?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
            <div class="clearboth"></div>
                <div class="listregistermain">
                   <div class="profile_personal_left"><img  src="<?php  echo $this->config->item('images');?>register/registration_step1_left.jpg" /></div>
                   <div class="register_step1_middle">
                      <div class="contents_registermain" >
                            <div class="clearboth">&nbsp;</div>
                            <div class="leftside_register">Reset Password<span class="red_star">*</span></div>
                            <div class="middlecolon_register">&nbsp;</div>
                            <div class="rightsidedata_register"><input type="password" name="r_password" id="r_password" class="textwidth" maxlength="128"  value="" autocomplete="off" /></div>
                            
                            <input type="hidden" name="resetted" id="resetted"  value="0" />
                            <input type="hidden" name="subadmin_id" id="subadmin_id"  value="<?php echo $subadmin_id; ?>" />
                            <input type="hidden" name="page_no" id="page_no"  value="<?php echo $page_no; ?>" />
                            <div class="middlecolon_register">&nbsp;</div>
                            <div class="rightsidedata_register">
                                    <img  src="<?php  echo $this->config->item('images');?>/innerpages/update.jpg" onclick="javascript:reset_password(<?php echo $subadmin_id; ?>);" class="stylebutton" />
                            </div>
                            <div class="clearboth"> </div>
                            <div style="padding-left:12px;"><span class="instruction">&nbsp;Password and Confirm Password should be minimum 6 characters and alphanumeric</span></div>
                            <div class="backtolist"><a href="javascript:void(null);" onclick="javascript:gotolist(<?php echo $this->uri->segment(4);?>); return false;"><< Back to Sub-Admins list </a></div>
                      </div>
                   </div>
                </div>
            </div>
        </div>
        
    </div>  
<?php echo form_close();?>