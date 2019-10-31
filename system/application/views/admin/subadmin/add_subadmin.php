<div class="clearboth"></div>
<form name="registerform" id="myform" method="post" action="">
<div id="maindiv" style="width:1023px;">
    <div id="registerviewmain">
        <div class="stmain">
            <div class="floatleft">
                <span class="registerredheading"><?php echo $page_title;?></span>
               
            </div>
            <!--<div>
                <span style="float: right;margin-top: 5px;">
                    <a href="javascript:void(null);" onclick="javascript:gotolistnew(<?php echo $this->uri->segment(4);?>); return false;"><< Back to Sub-Admins list </a>
                </span>
            </div>-->
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
                        <div class="contents_registermain" style="padding-top:2px;">
                            <div class="clearboth" style="height: 4px;">&nbsp;</div>
                                <div class="leftside_register">First Name<span class="red_star">*</span></div>
                                <div class="middlecolon_register">&nbsp;</div>
                                <div class="rightsidedata_register"><input type="text" name="firstname" id="firstname" class="textwidth" maxlength="128"  value="<?php echo set_value('firstname'); ?>"/></div>

                                <div class="leftsideheadings_register">Last Name<span class="red_star">*</span></div>
                                <div class="middlecolon_register">&nbsp;</div>
                                <div class="rightsidedata_register"><input type="text" name="lastname" id="lastname" class="textwidth"  maxlength="128"  value="<?php echo set_value('lastname'); ?>"/></div>
                                <div class="clearboth"></div>
                                                                
                                <div class="leftside_register">User Name<span class="red_star">*</span></div>
                                <div class="middlecolon_register">&nbsp;</div>
                                <div class="rightsidedata_register"><input type="text" name="username" id="username" class="textwidth" maxlength="128"  value="<?php echo set_value('username'); ?>"/></div>

                                <div class="leftsideheadings_register"></div>
                                <div class="middlecolon_register">&nbsp;</div>
                                <div class="rightsidedata_register"></div>
                                <div class="clearboth"></div>
                                
                                <div class="leftside_register">E-mail<span class="red_star">*</span></div>
                                <div class="middlecolon_register">&nbsp;</div>
                                <div class="rightsidedata_register"><input type="text" name="email" id="email"  class="textwidth" maxlength="128" value="<?php echo set_value('email'); ?>"/></div>

                                <div class="leftsideheadings_register">Confirm E-mail<span class="red_star">*</span></div>
                                <div class="middlecolon_register">&nbsp;</div>
                                <div class="rightsidedata_register"><input type="text" name="confirmemail" id="confirmemail" class="textwidth" maxlength="128" value="<?php echo set_value('confirmemail'); ?>"/></div>
                                <div class="clearboth"></div>

                                <div class="leftside_register">Password<span class="red_star">*</span></div>
                                <div class="middlecolon_register">&nbsp;</div>
                                <div class="rightsidedata_register"><input type="password" name="psword" id="psword"  class="textwidth" maxlength="128"  value=""/></div>

                                <div class="leftsideheadings_register">Confirm Password<span class="red_star">*</span></div>
                                <div class="middlecolon_register">&nbsp;</div>
                                <div class="rightsidedata_register"><input type="password" name="psword1" id="psword1"  class="textwidth" maxlength="128"  value=""/></div>
                               
                                
                                 <div style="padding-left:44px;"><span class="instruction">&nbsp;Password and Confirm Password should be minimum 6 characters and alphanumeric</span></div>
                                
                                    
                                
                                <div class="clearboth"></div>
                                
                                <div class="leftside_register"> Address<span class="red_star">*</span></div>
                                <div class="middlecolon_register">&nbsp;</div>
                                <div class="rightsidedata_register"><textarea name="address" id="address"  class="textwidth"><?php echo set_value('address'); ?></textarea></div>

                                <div class="leftsideheadings_register">City<span class="red_star">*</span></div>
                                <div class="middlecolon_register">&nbsp;</div>
                                <div class="rightsidedata_register"><input type="text" name="city" id="city" class="textwidth" maxlength="128" value="<?php echo set_value('city'); ?>"/></div>

                                <div class="leftsideheadings_register">State<span class="red_star">*</span></div>
                                <div class="middlecolon_register">&nbsp;</div>
                                <div class="rightsidedata_register"> 
                                        <select name="state"  id="state"  class="selecttextwidth">
                                                <option value="">Select</option>
                                                <?php
                                                        $state1 = $state;
                                                        $state2 = $state;
                                                        foreach($state as $state):
                                                ?>
                                                        <option value="<?php echo $state['state_code'];?>"  <?php echo (set_value('state') == $state['state_code']) ? 'SELECTED' : '';?>><?php echo $state['state'];?></option>
                                                <?php endforeach; ?>
                                        </select>
                                </div>
                                <div class="clearboth"></div>
                                                                                                                           
                                <div class="leftside_register">Phone Number<span class="red_star">*</span></div>
                                <div class="middlecolon_register">&nbsp;</div>
                                <div class="rightsidedata_register"><input type="text" name="phone" id="phone"   onkeyup="isvalidPhoneNumber(this)" class="textwidth" maxlength="25" value="<?php echo set_value('phone'); ?>"/></div>
                                
                                
                                <div class="leftsideheadings_register">Zipcode<span class="red_star">*</span></div>
                                <div class="middlecolon_register">&nbsp;</div>
                                <div class="rightsidedata_register"><input type="text" name="zipcode" id="zipcode"  class="textwidth" maxlength="5"  value="<?php echo set_value('zipcode'); ?>"/></div>
                                
                                <div class="clearboth"></div>
                                
                                <div class="leftside_register"></div>
                                <div class="middlecolon_register">&nbsp;</div>
                                <div class="rightsidedata_register">&nbsp;</div>
                                                                
                                <div class="leftsideheadings_register">&nbsp;</div>
                                <div class="middlecolon_register">&nbsp;</div>
                                <div class="rightsidedata_phone_instru"><span class="instruction">&nbsp;Zipcode must be 5 digits</span></div>
                                <div class="leftsideheadings_register">&nbsp;</div>
                                    
                                                             
                                <div class="clearboth"></div>
                                
                                <div class="view_permission_box">
                                    <div class="leftside_register">Extra Permission<span class="red_star"></span></div>
                                    <div class="middlecolon_register">&nbsp;</div>
                                    <div class="rightsidedata_register" style="width:100px;" ><input type="checkbox" name="extra_permission" id="extra_permission"  class="" value="1"/></div>
                                    <div  style="float:left" class="instruction_div">
                                        <span class="instruction">
                                            
                                             Search users, view user details, user course details and order details.<br/>

                                             Full permission to Class and Recruiter functionality.<br/>

                                             <span class="extraspace"><span class="red_star">*</span> This admin is not be able to edit dates.</span>
                                        </span>
                                    </div>
                                </div>
                                <div  style="float:left;width:45%;">
                                    <div class="leftsideheadings_register" style="width:87px;">&nbsp;</div>
                                    <input type="hidden" name="register_sub" id="register_sub"  value="0" />
                                    <div class="middlecolon_register">&nbsp;</div>
                                    <div class="rightsidedata_register">
                                        <img  src="<?php  echo $this->config->item('images');?>/innerpages/sub_btn.jpg" onclick="javascript:checkuser();" class="stylebutton" />
                                    </div>
                                </div>
                                
                                
                            </div>
                        <?php /*content register main end*/?>
                        </div>
                        <div class="profile_personal_right"><img  src="<?php  echo $this->config->item('images');?>register/registration_step1_right.jpg" /></div>	

                        <div class="register_instructionmark" style="margin-top:-5px;padding-right:10px; margin-right: 142px;">
                            <span class="instruction">Marked with </span><span class="red_star">*</span> <span class="instruction">are mandatory fields</span>
                            
                        </div>
                    <div class="clearboth">&nbsp;</div>
                </div>
        <?php /*list register data end*/?>
            </div>
        </div>
    </div>
     <div class="backtolist">
         <a href="javascript:void(null);" onclick="javascript:gotolistnew(<?php echo $this->uri->segment(4);?>); return false;"><< Back to Sub-Admins list </a>
     </div>
</div>
</form>
<script>
function submit() 
{
    document.getElementById("register_sub").value = 1;
    document.registerform.submit();
}
</script>


