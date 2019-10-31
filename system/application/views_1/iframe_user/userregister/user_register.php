<?php echo $this->load->view('iframe_user/userregister/package_menu'); ?>
<div class="main_wrapper">		
       	<section>
        	<div class="register_desc">
                <h1>Create Account</h1>
                <p>
    				Note to student: Make sure that you input your name exactly as it appears on
					your drivers license and other legal documents.<br/> Don’t use any nicknames. For
					example, if your legal name is “Jonathan” don’t enter “John”.<br/>
					The names need to match up because your name will appear on your course
					completion certificates that you submit to the Bureau of Real Estate. Your
					license and exam application will be delayed if the name on your certificates
					doesn’t match the name on your legal documents.
    			</p>
         	</div>
           
            <div class="clearboth"></div>
			
			<?php 
 			
 			if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
			<div class="clearboth">&nbsp;</div>
			
    		<h3 class="register_heading"><img src="<?php echo base_url() ;?>images/iframe_user/images/arrow_smbl.png" alt="a"/><span class="register_heading_H01">Create Account</span><span class="register_heading_step1">Step 1</span></h3>         
            <div class="contactUs_Step1_Form">
            	<form name="registerform" id="myform" method="post" class="form_step_01" action="<?php echo base_url().'iframe_user/register/'.$site;?>" >

                        <ul class="form_step_01">
                        	<li class="clearfix">
                            	<div class="float_l">
                                    <label>First Name*</label>
                                    <input type="text" name="firstname" id="firstname" class="txt_area" onblur="javascript:populate_certificate_name();"  value="<?php echo set_value('firstname'); ?>" tabindex="1"/>
                                </div>
								<div class="float_r">
                                   	<label>Last Name*</label>
	                                <input type="text" name="lastname" id="lastname" class="usertextwidth"  onblur="javascript:populate_certificate_name();" value="<?php echo set_value('lastname'); ?>" tabindex="2"/>
                                </div>                            	
                            </li>
                        	<li class="clearfix">
                            	<div class="float_l">
                                   <label>Certificate Name*</label>
                                	<input type="text" readonly name="name_on_certificate" id="name_on_certificate" class="usertextwidth" value="<?php echo $this->input->post('name_on_certificate'); ?>" />
	                   				<a onMouseover="open_tooltip(tooltip_body,'#FFFFFF', 400)" onMouseout="hide_tooltip()">
	                   					<label id="field_suffix">What is Certificate Name?</label>
                   					</a>

                                 </div>
								<div class="float_r">
                                   	<label>Email*</label>
                               		<input type="text" name="email" id="email" class="usertextwidth" value="<?php echo set_value('email'); ?>" tabindex="3"/>
                                </div>                            	
                            </li>  
                            <li class="clearfix">
                            	<div class="float_l">
                                    <label>Confirm Email*</label>
                                	<input type="text" name="confirmemail" id="confirmemail" class="usertextwidth" maxlength="128" value="<?php echo set_value('confirmemail'); ?>" tabindex="4"/>
                                </div>
								<div class="float_r">
                                   	<label>Password*</label>
                                	<input type="password" name="psword" id="psword" class="usertextwidth" value="" tabindex="5"/>
                                </div>                            	
                            </li>   
                            <li class="clearfix">
                            	<div class="float_l">
                                    <label>Confirm Password*</label>
                               		<input type="password" name="psword1" id="psword1" class="usertextwidth" value="" tabindex="6"/>
                                </div>
								<div class="float_r">
                                  	<label>Shipping Address*</label>
                               	 	<input type="text" name="address" id="address"  class="usertextwidth" maxlength="128" value="<?php echo set_value('address'); ?>" tabindex="7" onfocus="showFedexMsg()" onblur="hideFedexMsg()"/>                               	 	
                                    
                                <div id="fedexMsg" style="width:240px;margin-left: 1px;display:none;position:absolute;background-color: lightyellow;border: 3px solid #999999;padding: 2px;z-index: 100;"><div style="padding:10px 10px;background-color:#000; color:#FFF;font-size:13px;">FedEx will not deliver to P.O. Boxes</div></div> 
                                </div>                      	
                            </li>    
                            <li class="clearfix">
                            	<div class="float_l">
                                    <label>Unit Number</label>
                               		<input type="text" name="unitnumber" id="unitnumber" class="usertextwidth"   value="<?php echo $this->input->post('unitnumber'); ?>" tabindex="8"/>
                                </div>
								<div class="float_r">
                                   	<label>City*</label>
                               		<input type="text" name="city" id="city" class="usertextwidth" maxlength="128" value="<?php echo set_value('city'); ?>" tabindex="9"/>
                                </div>                            	
                            </li>  
                            
                            <li class="clearfix"> 
								<div class="float_r">
									 <label>Zipcode*</label>
                                	 <input type="text" name="zipcode" id="zipcode"  class="usertextwidth" maxlength="5"  value="<?php echo set_value('zipcode'); ?>" tabindex="11"/>
                                 </div>
                                 <div class="float_l">
                                     <label>State*</label>
                                	 <div id="dd" class="wrapper-dropdown-5 max_dropdown" tabindex="10">
                                         <ul class="dropdown">
                                         	<li><a href="#" class="stateCB" data-stateid="0">Select State</a></li>
                                        	<?php
                                        		$selected = ''; 
                                        		foreach($state as $state){ 
                                        			if($state['state_code'] == 0){
                                        				//$selected = $state['state'];
                                        				$selected = 'Select State';
                                        			}
                                        		?>
                                        		 <li><a href="#" class="stateCB" data-stateid="<?php echo $state['state_code'];?>"><?php echo $state['state'];?></a></li>
                                        	<?php } ?>
                                        </ul>
                                        <span><?php echo $selected; ?></span>
                                        <input type="hidden" name="state" id="state" value="" />
                                    </div>
                                </div>
                                                            	
                            </li>
                            <li class="clearfix">
                            	<div class="float_l">
                                  <label>Phone*</label>
                                  <input type="text" name="phone" id="phone" maxlength="10" class="usertextwidth" onkeyup="isvalidPhoneNumber(this)" value="<?php echo set_value('phone'); ?>" tabindex="12"/>
                                </div>  
                                <div class="float_r">
                                  <label>Note </label>
                                  <textarea style="overflow-y: scroll;resize: none;" name="note" id="note" maxlength="150"  
                                            class="usertextwidth"  tabindex="13"><?php echo trim(set_value('note') ? set_value('note') : (isset($data['note'])) ? $data['note'] : '');  ?></textarea>
                                                                  
                                </div>
								                          	
                            </li>                                                                                  
                               
                        </ul>	
                        <div class="nextbuttondiv" ><input type="hidden" name="step1" id="step1"  value="0" />	 
                        	
                    	<div class="cb">
                        	<div class="page_error" id="errordisplay" ></div>
							<div  class="page_error" id="errordiv" style="display:none;"><?php if(isset($msg)) echo $msg; ?></div>
							<?php if(isset($msg)) {?>
							<div  class="page_error errordiv" ><?php if(isset($msg)) echo $msg; ?></div>
							<?php }  ?>
							<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("msg");   ?></div>
							<?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
                        </div>
                        
                        <input class="button_red registerForm_btn reg_btn_step01" type="submit" onclick="javascript:checkuser();return false;" value="NEXT" tabindex="14">
                        
                        
                       <input type="hidden" name="country" id="country" value="US">
                         
                </form>	
            </div>
	    </section>
</div><!--end of main_wrapper-->   

<script language="JavaScript">	
	
	jQuery(document).ready(function() {
		 		
		jQuery(".stateCB").on('click', function(event){
			var stateid = jQuery(this).attr("data-stateid")
			jQuery("#state").val( stateid );
			
		});
	
	});
	
	function showFedexMsg(){
		document.getElementById("fedexMsg").style.display = "block";
	}
	function hideFedexMsg(){
		document.getElementById("fedexMsg").style.display = "none";
	}
	
</script>
<script type="text/javascript">
	var tooltip_body ='<div style="padding:10px 20px 20px 20px;background-color:#000; color:#FFF;">';
  	 tooltip_body   +=   '<span style="color:#E49907"><h3><u>What is Certificate Name?</u></h3></span>';
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
<style>
    textarea {
    border: medium none;
    box-shadow: 0 0 4px 0 #7c7c7c inset;
    height: 42px;
    padding-left: 10px;
    width: 310px;
}
</style>
        