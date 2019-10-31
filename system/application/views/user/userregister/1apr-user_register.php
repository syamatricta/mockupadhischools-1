<div class="floatleft">
      <div class="left_cntnr" style="position: relative;">
            <?php $this ->load->view('left_content_home.php');?>
    </div>
    <div class="right_cntnr">
        <div class="right_cntnr_bg_hd">
           <div class="floatleft" style="width:100%;">
			 <div class="sitepagehead"><h1>Create Account Step 1</h1></div>
			 <div class="username"></div>
		 </div>
        </div>
        <div class="right_cntnr_bg">
             <form name="registerform" id="myform" method="post" action="<?php echo base_url().'user/register';?>" >

				<div id="userregisterviewmain">
					<div style="color:#A5CE34; font-style:italic; font-size:13px; padding-bottom:10px; float:left;">
        				<b>Note to student:</b> Make sure that you input your name exactly as it appears on
						your drivers license and other legal documents.<br/> Don’t use any nicknames. For
						example, if your legal name is “Jonathan” don’t enter “John”.<br/><br/>
						The names need to match up because your name will appear on your course
						completion certificates that you submit to the Department of Real Estate. Your
						license and exam application will be delayed if the name on your certificates
						doesn’t match the name on your legal documents.
        			</div>
                                <?php
                                if(isset($msg)) {
                                    $style = "block";
                                } else {
                                    $style = "none";
                                }
                                ?>
        			<div class="clearboth">&nbsp;</div>
					<div class="page_error" id="errordisplay"></div>
                                        <div class="wrap-box-fixed" id="wrap_error_box">
                                            <div  class="page_error box-fixed" id="errordiv" style="display:<?php echo $style;?>">

                                                <?php if(isset($msg)) echo $msg; ?>
                                            </div> 
                                            <button class="close" id="close_button" data-dismiss="alert" type="button" onclick="hide_errorbox();" style="display:<?php echo $style;?>">×</button>
                                        </div>
					<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("msg");   ?></div>
					<?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
					<div class="clearboth">&nbsp;</div>
        		<?php /* new design */?>

					<div class="login_email_pwd"><div class="splice_first_name"></div></div>
	                <div class="login_email_pwd"><div class="splice_last_name"></div></div>
	                <div class="login_email_pwd"><div class="splice_certificate_name"></div></div>

	                <div class="text_box_div_register">
	                    <input type="text" name="firstname" id="firstname" class="usertextwidth" onblur="javascript:populate_certificate_name();"  value="<?php echo set_value('firstname'); ?>" tabindex="1"/>
	                    <div class="register_form_arrow"></div>
	                </div>
	                <div class="text_box_div_register">
	                    <input type="text" name="lastname" id="lastname" class="usertextwidth"  onblur="javascript:populate_certificate_name();" value="<?php echo set_value('lastname'); ?>" tabindex="2"/>
	                    <div class="register_form_arrow"></div>
	                </div>
	                <div class="text_box_div_register">
	                   <input type="text" readonly name="name_on_certificate" id="name_on_certificate" class="usertextwidth" value="<?php echo $this->input->post('name_on_certificate'); ?>" tabindex="3"/>
	                   <a rel="nofollow" onMouseover="open_tooltip(tooltip_body,'#FFFFFF', 400)" onMouseout="hide_tooltip()"><div class="register_form_text splice_certi_tooltip" style="right:8px;"></div></a>
	                </div>

	                <div class="ht60"></div>

	                <div class="login_email_pwd"><div class="splice_email"></div></div>
	                <div class="login_email_pwd"><div class="splice_email_confirm"></div></div>
	                <div class="login_email_pwd"><div class="splice_password"></div></div>


	                <div class="text_box_div_register">
	                   <input type="text" name="email" id="email" class="usertextwidth" value="<?php echo set_value('email'); ?>" tabindex="4"/>
	                   <div class="register_form_arrow"></div>
	                </div>

	                <div class="text_box_div_register">
	                   <input type="text" name="confirmemail" id="confirmemail" class="usertextwidth" maxlength="128" value="<?php echo set_value('confirmemail'); ?>" tabindex="5"/>
	                    <div class="register_form_arrow"></div>
	                </div>
	                <div class="text_box_div_register">
	                    <input type="password" name="psword" id="psword" class="usertextwidth" value="" tabindex="6"/>
	                </div>

	                <div class="ht60"></div>

	                <!-- <div class="login_email_pwd"><img  src="<?php echo $this->config->item('images');?>contact_regaddress.png"/></div> -->

	                <div class="login_email_pwd"><div class="splice_password_confirm"></div></div>
	                <div class="login_email_pwd"><div class="splice_shipping"></div></div>
					<div class="login_email_pwd"><div class="splice_unit" ></div></div>



					<!-- <div class="login_email_pwd"><img  src="<?php echo $this->config->item('images');?>country.png"/></div> -->
					<div class="cb"></div>

					<div class="text_box_div_register">
	                   <input type="password" name="psword1" id="psword1" class="usertextwidth" value="" tabindex="7"/>
	                   <div class="register_form_arrow"></div>
	                </div>

					<div class="text_box_div_register">
						<input type="text" name="address" id="address"  class="usertextwidth" maxlength="128" value="<?php echo set_value('address'); ?>" tabindex="8"/>
						<div class="register_form_arrow"></div>
					</div>

					<!-- Unit number -->
					<div class="text_box_div_register">
	                   <input type="text" name="unitnumber" id="unitnumber" class="usertextwidth"   value="<?php echo $this->input->post('unitnumber'); ?>" tabindex="9"/>
	                </div>

					 <!-- <div class="text_box_div_register_right"> -->
					 	<input type="hidden" name="country" id="country" value="US">
					 <!-- <input type="text" name="country_show" id="country_show"  class="usertextwidth" value="United States" readonly tabindex="9"/>

					</div> -->
					<div class="ht50"></div>

					<div class="login_email_pwd"><div class="splice_city"></div></div>
					<div class="login_email_pwd"><div class="splice_state"></div></div>
					<div class="login_email_pwd"><div class="splice_zipcode"></div></div>

					<div class="cb"></div>

					 <div class="text_box_div_register">
						<input type="text" name="city" id="city" class="usertextwidth" maxlength="128" value="<?php echo set_value('city'); ?>" tabindex="10"/>
						<div class="register_form_arrow"></div>
					</div>

					 <div class="text_box_div_register text_box_div_register_select2" onclick="javascript:__fncShowData('stateBillDiv');return false;"  > <!-- onmouseout="javascript:hide_div('stateBillDiv');"  -->
					 	<div style="clear:both; float:left;margin-bottom:10px;height:30px;font-size:18px;">
					 		<input type="text" readonly name="block_state" id="block_state" class="droplisRenewDivtxtbx" value="<?php if(set_value('state')) { echo get_statename(set_value('state'));} else {echo "Select State";}; ?>" onchange="javascript:checkrate1();" tabindex="11"/>
                           	<div class="register_form_arrow"></div>
					 		<input type="hidden" readonly name="state" id="state" class="droplisRenewDivtxtbx" value="<?php if(set_value('state')) { echo set_value('state'); } else { echo set_value('block_state');} ?>"/>
					  	</div>
                       <div class="cb"></div>

						<div id="stateBillDiv" style="display:none; position:relative;top:14px;z-index:1000;width:230px;margin-left:2px;"  ><!-- onclick="javascript:__fncShowData('stateBillDiv');return false;" onmouseover="javascript:__fncShowData('stateBillDiv');return false;"   -->

                        	<div class="dropdownoverflow">
							<?php
								$state1= $state;
								$state2= $state;
							foreach($state as $state){?>
							 <div   id="stateBillDiv<?php echo $state['state_code'];?>" class="droplisRegStateDiv"  onmouseover="javascript:__fncShowdiv('stateBillDiv<?php echo $state['state_code'];?>');" onmouseout="javascript:__fncChangeColor('stateBillDiv<?php echo $state['state_code'];?>');" onclick="javascript:__fncSetSelectedValue('stateBillDiv<?php echo $state['state_code'];?>', 'stateBillDiv', 'state','<?php echo $state['state_code'];?>','block_state');"><?php echo $state['state'];?></div>
					 	 <?php }?>
					 	 </div>
					 	</div>

					</div>

					 <div class="text_box_div_register">

					 	<input type="text" name="zipcode" id="zipcode"  class="usertextwidth" maxlength="5"  value="<?php echo set_value('zipcode'); ?>" tabindex="12"/>
                        <br>
                        <div class="register_form_text splice_zipcode_tooltip" ></div>

					</div>

	                <div class="ht60"></div>

					<div class="login_email_pwd"><div class="splice_phoneno"></div></div>
					<div class="cb"></div>
					<div class="text_box_div_register">
	                   <input type="text" name="phone" id="phone" maxlength="10"  class="usertextwidth" onkeyup="isvalidPhoneNumber(this)" value="<?php echo set_value('phone'); ?>" tabindex="13"/>

	                </div>

	                <div class="nextbuttondiv" ><input type="hidden" name="step1" id="step1"  value="0" />
                         <input type="image" align="right" onkeypress="javascript:checkuser();hidealert();return false;" onclick="javascript:checkuser();hidealert();return false;" tabindex="14" onmouseout="this.src='<?php echo $this->config->item('images'); ?>calendar_next_year_normal.png'" onmouseover="this.src='<?php echo $this->config->item('images'); ?>calendar_next_year_hover.png'" src="<?php echo $this->config->item('images'); ?>calendar_next_year_normal.png">
	                </div>
				<?php /* new design ends*/?>
        		</div>
        	</form>
        </div>
    </div>
</div>

<script type="text/javascript">
	var tooltip_body ='<div style="padding:10px 20px 20px 20px;background-color:#000; color:#FFF;">';
  	 tooltip_body   +=   '<span style="color:#A5CE34"><h3><u>What is Certificate Name?</u></h3></span>';
     tooltip_body   +=  '<p>Please enter your legal name here as it appears on your passport or birth certificate.  Completing this improperly will delay your license.';
     tooltip_body   +=  '</p>';
     tooltip_body   += '</div>';
</script>

  <!-- <Tool tip> -->
<div id="dhtmltooltip"></div>
 <script>
        var offsetxpoint=-60 //Customize x offset of tooltip
        var offsetypoint=20 //Customize y offset of tooltip
        var ie=document.all
        var ns6=document.getElementById && !document.all
        var enabletip=false
        if (ie||ns6)
        var tipobj=document.all? document.all["dhtmltooltip"] : document.getElementById? document.getElementById("dhtmltooltip") : ""
        document.onmousemove=positiontip;
</script>
        <!-- </Tool tip> -->
        
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