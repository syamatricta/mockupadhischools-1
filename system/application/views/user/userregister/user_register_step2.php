<div class="floatleft">
	<div class="left_cntnr" style="position: relative;">
		<?php $this ->load->view('left_content_home.php');?>
	</div>
    <div class="right_cntnr">
        <div class="right_cntnr_bg_hd">
          <div class="floatleft" style="width:100%;">
			 <div class="sitepagehead"><h1>Create Account Step 2</h1></div>
			 <div class="username"></div> 
		 </div>
        </div>
        <div class="right_cntnr_bg">
			<div class="reg_step2_main">
			<form name="registerform" id="myform" method="post" action="">
				<div style="float:left; padding-left:30px;">
					<div class="page_error" id="errordisplay"></div>
					<?php
                                        if(isset($msg)) {
                                            $style = "block";
                                        } else {
                                            $style = "none";
                                        }
                                        ?>
                                        <div class="wrap-box-fixed" id="wrap_error_box">
                                            <div  class="page_error box-fixed" id="errordiv" style="display:<?php echo $style;?>"><?php if(isset($msg)) echo $msg; ?></div>
                                            <button class="close" id="close_button" data-dismiss="alert" type="button" onclick="hide_errorbox();" style="display:<?php echo $style;?>">×</button>
                                        </div>
                                        <div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("msg");   ?></div>
					<?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
					<div class="clearboth"></div>
					<div class="floatleft">
						<div class="floatleft" >
							<div class="reg_step2_text_left"></div>
							<div class="reg_step2_text_repeat">
								<div class="reg_step2_instruction">We have a really cool online community where you can ask questions to your instructor or other students. How do you want your name to display if you post a message in the ADHI Schools forum? <span class="green_star">*</span></div>
	                            <div class="reg_step2_istruction_textbox"> <div class="text_box_div_register" style="margin-right:16px !important" ><input type="text" name="forumalias" id="forumalias" class="usertextwidth"   value="<?php echo set_value('forumalias'); ?>" tabindex="14"/></div></div>
							</div>
							<div class="reg_step2_text_right"></div>
						</div>
					</div>
					
					<div class="ht60"></div>
					
					<div class="login_email_pwd"><div  class="splice_license_type"></div></div>
	                
					<!-- <div class="login_email_pwd"><img src="<?php echo $this->config->item('images');?>unit_number.png"/></div>
					<div class="text_box_register_space">&nbsp;</div> -->
					
					 <div class="login_email_pwd hearus_div"><div class="splice_hearus"></div></div>

					 
					 <div class="login_email_pwd_01" <?php if(set_value('txtSearchengine')){ ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?> id="hh1"><img src="<?php echo $this->config->item('images');?>enter-search-engine.png" alt="Enter search engine" /></div>
					 <div class="login_email_pwd_01" <?php if(set_value('txtREO')){ ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?> id="hh2"><img  src="<?php echo $this->config->item('images');?>Enter-which-real-estate-office.png" alt="Enter real estate office" /></div>
						
						
					<div class="cb"></div>                
					<div class="text_box_div_register_select" onclick="javascript:__fncShowData('LicencetypeDiv');return false;" onmouseout="javascript:hide_div('LicencetypeDiv');return false;">
						<?php if('S' == set_value('txtLicencetype')){
							$license_t = 'Sales';
						}else {
							$license_t = 'Broker';
						}?>
	                    <div style="float:left;width:226px;margin-bottom:10px;height:30px;font-size:18px;">
	                    	<input type="text" name="block_txtLicencetype" id="block_txtLicencetype" class="droplisDivtxtbx" value="<?php if(set_value('txtLicencetype')){ echo $license_t;} else { echo "Select License Type";} ?>" readonly tabindex="15"/>
	                    	<input type="hidden" name="txtLicencetype" id="txtLicencetype" class="droplisDivtxtbx" value="<?php if(set_value('txtLicencetype')){ echo set_value('txtLicencetype');} else { echo set_value('block_txtLicencetype');} ?>" readonly/>
	                   	</div>
	                    <!-- <div style="float:right;width:16px;height:10px;"><img src="<?php  echo base_url();?>images/reg_select.png" align="right"  onclick="javascript:__fncShowData('LicencetypeDiv');return false;"/></div>-->
	                     <a rel="nofollow" onMouseover="open_tooltip(tooltip_body,'#FFFFFF', 400)" onMouseout="hide_tooltip()"><div class="register_form_text tooltip_img"></div></a>
	                    <div class="register_form_arrow_02 margin_top_66"></div>
	                    <div class="cb"></div>
	                    <div id="LicencetypeDiv" style="display:none;width:226px; position:absolute;top:59px;z-index:100" onclick="javascript:__fncShowData('LicencetypeDiv');return false;" onmouseover="javascript:__fncShowData('LicencetypeDiv');return false;">
	                        <div id="LicencetypeDiv1" class="droplisDiv226"  onmouseover="javascript:__fncShowdiv('LicencetypeDiv1');" onmouseout="javascript:__fncChangeColor('LicencetypeDiv1');" onclick="javascript:__fncSetSelectedValue('LicencetypeDiv1', 'LicencetypeDiv', 'txtLicencetype','S','block_txtLicencetype');">Sales</div>
	                        <div id="LicencetypeDiv2" class="droplisDiv226"  onmouseover="javascript:__fncShowdiv('LicencetypeDiv2');" onmouseout="javascript:__fncChangeColor('LicencetypeDiv2');" onclick="javascript:__fncSetSelectedValue('LicencetypeDiv2', 'LicencetypeDiv', 'txtLicencetype','B','block_txtLicencetype');">Broker</div>
	                     </div>
	                </div>
	              
	                <!-- <div class="text_box_div_register">
	                   <input type="text" name="unitnumber" id="unitnumber" class="usertextwidth"   value="<?php echo $this->input->post('unitnumber'); ?>" tabindex="16"/>
	                    <img class="register_form_arrow"  src="<?php  echo base_url();?>images/register_form_arrow.png"/>
	                </div> -->
	                
					
					<div class="text_box_div_register_select" onclick="javascript:__fncShowDatahh('howhearDiv');return false;" onmouseout="javascript:hide_div('howhearDiv');return false;"><!--<div style="float:right;width:36px;height:59px; cursor:pointer"><img src="<?php  echo base_url();?>images/reg_select.png" align="right" onclick="javascript:__fncShowDatahh('howhearDiv');return false;"/></div>-->
					<div style="float:left;width:233px;margin-bottom:10px;height:59px;font-size:18px;">
						<input type="text" name="txthowhear" id="txthowhear" class="droplisDivtxtbx318 howhearwidth" value="<?php if(set_value('txthowhear')) { echo set_value('txthowhear');} else { echo "Select";} ?>" readonly tabindex="17"/></div>
						<div id="howhearDiv" style="display:none;width:228px; position:relative;top:-12px" onclick="javascript:__fncShowDatahh('howhearDiv');return false;" onmouseover="javascript:__fncShowDatahh('howhearDiv');return false;">
						    <div id="howhearDiv1" class="droplisDiv318"  onmouseover="javascript:__fncShowdivhh('howhearDiv1');" onmouseout="javascript:__fncChangeColorhh('howhearDiv1');" onclick="javascript:__fncSetSelectedValuehh('howhearDiv1', 'howhearDiv', 'txthowhear','Search engine');">Search engine</div>
						    <div id="howhearDiv2" class="droplisDiv318"  onmouseover="javascript:__fncShowdivhh('howhearDiv2');" onmouseout="javascript:__fncChangeColorhh('howhearDiv2');" onclick="javascript:__fncSetSelectedValuehh('howhearDiv2', 'howhearDiv', 'txthowhear','Referral from a real estate office');">Referral from a real estate office</div>
						    <div id="howhearDiv3" class="droplisDiv318"  onmouseover="javascript:__fncShowdivhh('howhearDiv3');" onmouseout="javascript:__fncChangeColorhh('howhearDiv3');" onclick="javascript:__fncSetSelectedValuehh('howhearDiv3', 'howhearDiv', 'txthowhear','Facebook/YouTube/Twitter');">Facebook/YouTube/Twitter</div>
						    <div id="howhearDiv4" class="droplisDiv318"  onmouseover="javascript:__fncShowdivhh('howhearDiv4');" onmouseout="javascript:__fncChangeColorhh('howhearDiv4');" onclick="javascript:__fncSetSelectedValuehh('howhearDiv4', 'howhearDiv', 'txthowhear','Friend');">Friend</div>
						    <div id="howhearDiv5" class="droplisDiv318"  onmouseover="javascript:__fncShowdivhh('howhearDiv5');" onmouseout="javascript:__fncChangeColorhh('howhearDiv5');" onclick="javascript:__fncSetSelectedValuehh('howhearDiv5', 'howhearDiv', 'txthowhear','Other');">Other</div>
						</div>
						<?php $display = (set_value('txtSearchengine') || set_value('txtREO')) ? 'block' : 'none'; ?>
						<div class="register_form_arrow_02" style="display:<?php echo $display; ?>" id='hear-about-us-box'></div>
					</div>
					
					<div class="floatleft">	                  
						<div class="clearboth"></div>
						<div class="text_box_div_register" <?php if(set_value('txtSearchengine')){ ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?> id="hh1_txt"> <input type="text" name="txtSearchengine" id="txtSearchengine" class="usertextwidth"   value="<?php echo set_value('txtSearchengine'); ?>" tabindex="18"/></div>
						<div class="text_box_div_register" <?php if(set_value('txtREO')){ ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?> id="hh2_txt"> <input type="text" name="txtREO" id="txtREO" class="usertextwidth"   value="<?php echo set_value('txtREO'); ?>" tabindex="18"/></div>
	                </div>
					
					<div class="cb"></div>                                  	
					<div class="ht60"></div>				
				</div>
				
				<div style="float:left; ">					
					<div class="login_email_pwd"><div class="splice_billingadd_title"></div></div>
					<div class="clearboth"></div>
					
					 
					<!--  Billing Address is same as Shipping Address </div> -->
					  
					<div class="clearboth"></div>
					 	<?php $this->load->view("user/userregister/register_step2_billing");?>
				</div>
				 <div class="nextbuttondiv" style="padding-right:60px; float:right;" ><input type="hidden" name="step2" id="step2"  value="0" />
					<input type="image" src="<?php  echo base_url();?>images/calendar_next_year_normal.png" 
                    onMouseOver="this.src='<?php  echo base_url();?>images/calendar_next_year_hover.png'" 
                    onMouseOut="this.src='<?php  echo base_url();?>images/calendar_next_year_normal.png'" align="right" 
                    onclick="javascript:checkuserregister_2('<?php echo $usid;?>');hidealert();return false;" 
                    onkeypress="javascript:checkuserregister_2('<?php echo $usid;?>');hidealert();return false;" tabindex="30"/>
				</div>
				</form>
			</div>       
		</div>
	</div>
</div>
<script type="text/javascript">
	var tooltip_body ='<div style="padding:10px 20px 20px 20px;background-color:#000; color:#FFF;">';
  	 tooltip_body   +=   '<span style="color:#A5CE34"><h3><u>Sales/Broker (What\'s the difference?)</u></h3></span>';
     tooltip_body   +=  '<p> A brokers license lets you operate your own company. You don\'t have to work for';
     tooltip_body   +=  ' another broker like you would if you were a sales person. Also, as a broker you';
     tooltip_body   +=  ' could have multiple licenses; one to sell real estate from and one to conduct';
     tooltip_body   +=  ' property management activity from, for example. In order to qualify for this';
     tooltip_body   +=  ' license, you need a bachelors degree in real estate or two years of full-time real estate';
     tooltip_body   +=  ' experience.</p>';
     tooltip_body   +=  '<br/><p>  A sales person must work under a broker in order to do anything that would';
     tooltip_body   +=  ' require a real estate license.</p>';
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