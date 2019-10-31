<div class="main_wrapper">		
       	<section>
        	<div class="register_desc">
                <h1>Create Account</h1>	
                <p>
    				Note to student: Make sure that you input your name exactly as it appears on
					your drivers license and other legal documents.<br/> Don’t use any nicknames. For
					example, if your legal name is “Jonathan” don’t enter “John”.<br/>
					The names need to match up because your name will appear on your course
					completion certificates that you submit to the Department of Real Estate. Your
					license and exam application will be delayed if the name on your certificates
					doesn’t match the name on your legal documents.
    			</p>
         	</div>
           
            <div class="clearboth"></div>
			
			  
			
    		<h3 class="register_heading"><img src="<?php echo base_url() ;?>images/iframe_user/images/arrow_smbl.png" alt="a"/><span class="register_heading_H01">Create Account</span><span class="register_heading_step1">Step 2</span></h3>         
            <div class="contactUs_Step1_Form">
            	<form name="registerform" id="myform" method="post" action="">
					
                    <div class="community_input_desc step02_descp_p">
                     	<input type="text" name="forumalias" id="forumalias" class="usertextwidth"   value="<?php echo set_value('forumalias'); ?>" tabindex="1"/>
                    	<p>We have a really cool online community where you can ask questions to your instructor or other students. How do you want your name to display if you post messages in the Adhi Schools forum?*</p>
                    </div>
                    <div class="license_type">
                    		<ul class="form_step_01">
                                <li class="clearfix">
                                    <div class="float_l">
                                        <label>License Type*</label>
	                    				<input type="hidden" name="txtLicencetype" id="txtLicencetype" class="droplisDivtxtbx" value="<?php if(set_value('txtLicencetype')){ echo set_value('txtLicencetype');} else { echo set_value('block_txtLicencetype');} ?>" readonly/>
                                        
                                        <div id="dd" class="wrapper-dropdown-5 max_dropdown" tabindex="2">
                                           <?php if('S' == set_value('txtLicencetype')){
												$license_t = 'Sales';
											}else if('B' == set_value('txtLicencetype')){
												$license_t = 'Broker';
											}else{
												 $license_t =  "Select License Type";
											}
											?>
                                            <ul class="dropdown">
                                                <li><a href="#" class="cbolicense" data-license="S">Sales</a></li>
                                                <li><a href="#" class="cbolicense" data-license="B">Broker</a></li>
                                             </ul>
                                             <span><?php echo $license_t; ?></span>
                                        </div>
                                        <label class="suffix_width">
                                        	<a onmouseout="hide_tooltip()" onmouseover="open_tooltip(tooltip_body,'#FFFFFF', 400)">
                                        		Sales/Brokers What's the difference?
                                    		</a>
                                         	</label>

                                    </div>
                                    <div class="float_r">
                                        <label>So how did you hear about us?*</label>
                                         <div id="dd1" class="wrapper-dropdown-5 max_dropdown" tabindex="3">
                                          
                                            <span><?php if(set_value('txthowhear')) { echo set_value('txthowhear');} else { echo "Select";} ?></span>
                                            <ul class="dropdown">
                                                <li><a href="#" class="cbohowhear" data-howhear="Search engine">Search engine</a></li>
                                                <li><a href="#" class="cbohowhear" data-howhear="Referral from a real estate office">Referral from a real estate office</a></li>
                                                <li><a href="#" class="cbohowhear" data-howhear="Facebook/YouTube/Twitter">Facebook/YouTube/Twitter</a></li>
                                                <li><a href="#" class="cbohowhear" data-howhear="Friend">Friend</a></li>
                                                <li><a href="#" class="cbohowhear" data-howhear="Other">Other</a></li>
                                            </ul>
                                            <input type="hidden" name="txthowhear" id="txthowhear" value="<?php if(set_value('txthowhear')) { echo set_value('txthowhear');} else { echo "Select";} ?>" />
                                        </div>
                                    </div>                            	
                                </li> 
                                <li class="clearfix">
									 
                                    <div class="float_l">
                                        <label></label>
                                    </div>
                                    <div class="float_r">
                                    	
                                     	<div <?php if(set_value('txtSearchengine')){ ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?> id="hh1_txt"> 
										 	 <label>Enter Search Engine*</label>
										 	<input type="text" name="txtSearchengine" id="txtSearchengine" class="usertextwidth"   value="<?php echo set_value('txtSearchengine'); ?>" tabindex="18"/>
										</div>
										<div  <?php if(set_value('txtREO')){ ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?> id="hh2_txt"> 
											 <label>Which Real Estate Office*</label>
											<input type="text" name="txtREO" id="txtREO" class="usertextwidth"   value="<?php echo set_value('txtREO'); ?>" tabindex="18"/>
										</div>	
                                        
                                    </div>                            	
                                </li>
                                                                                                                                                
                            </ul>		  
                    </div>
 					<div class="billing_address">
 						<?php 
 						
 						?>
                        	<h4> Billing address</h4>
                        		 
                    		<div>
                    			<input type="checkbox" name="chksameasaddress" id="chksameasaddress" tabindex="4" />
                    			<label for="chksameasaddress"> Same as shipping address.</h5></label>
                    		</div>
                    		<div class="cb"></div>
                        	
                            <div class="billing_form_wrapper">
                                <ul class="form_step_01">
                                    <li class="clearfix">
                                        <div class="float_l">
                                            <label>Address*</label>
                                            <input type="text" name="b_address" id="b_address"   class="usertextwidth" maxlength="128" value="<?php echo set_value('b_address'); ?>" onblur="javascript:checkrate1(); " tabindex="5"/>
                                        </div>
                                        <div class="float_r">
                                            <label>City*</label>
                                            <input type="text" name="b_city" id="b_city"   class="usertextwidth" maxlength="40"  value="<?php echo set_value('b_city'); ?>" onblur="javascript:checkrate1(); " tabindex="6"/>
                                        </div>                            	
                                    </li>
                                    <li class="clearfix">
                                        <div class="float_l">
                                           <label>State*</label>
                                            <div id="dd2" class="wrapper-dropdown-5 max_dropdown" tabindex="7">
	                                           <ul class="dropdown">
 	                                        	<?php 
	                                        		$selected = ''; 
	                                        		foreach($state as $state1){
  	                                        		?>
	                                        		 <li><a href="#" class="stateCB" data-stateid="<?php echo $state1['state_code'];?>"><?php echo $state1['state'];?></a></li>
	                                        	<?php } ?>
	                                        	</ul>
	                                        	<span>Select State</span>
											</div>                                        
                                         
		 								
		 								<input type="hidden" readonly name="b_state" id="b_state" class="droplisRenewDivtxtbx" value="<?php if(set_value('b_state')){ echo set_value('b_state');}?>" onchange="javascript:checkrate1();"/>
                                        <input type="hidden" name="b_country" id="b_country" value="US" tabindex="26">
                                        
                                        </div>
                                        <div class="float_r">
                                            <label>Zipcode*</label>
                                   		 	<input type="text" name="b_zipcode" id="b_zipcode"   class="usertextwidth" maxlength="5" value="<?php echo set_value('b_zipcode'); ?>" onblur="javascript:checkrate1(); " tabindex="8"/>
											<label id="field_suffix">Zipcode must be 5 digits</label>
                                        </div>                            	
                                    </li>                                                                      
                                </ul>		                          
                           </div>     
                           
                    </div>                                          	
                		
                
                        <div class="cb">
                        	<div class="page_error" id="errordisplay" ></div>
							<div  class="page_error" id="errordiv" style="display:none;"><?php if(isset($msg)) echo $msg; ?></div>
							<?php if(isset($msg)) {?>
							<div  class="page_error errordiv"><?php if(isset($msg)) echo $msg; ?></div>
							<?php }  ?>
							<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("msg");   ?></div>
							<?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
                        </div>
                        <div class="nextbuttondiv" >
                         	
                        <input class="button_red registerForm_btn reg_btn_step01" type="submit" onclick="javascript:checkuserregister_2('<?php echo $site;?>');return false;" value="NEXT" tabindex="9">
                        
                        <input type="hidden" name="step2" id="step2"  value="0" />
                        <input type="hidden" name="country" id="country" value="US">
                         
                </form>	
            </div>
	    </section>
</div><!--end of main_wrapper--> 
  

<script language="JavaScript">
	
 	jQuery(document).ready(function() {
		
		jQuery(".cbohowhear").on('click', function(event){
			var howhear = jQuery(this).attr("data-howhear");
			if( howhear == 'Search engine'){
				jQuery("#hh1_txt").show();
			}else{
				jQuery("#hh1_txt").hide();
			}
			if( howhear == 'Referral from a real estate office'){
				jQuery("#hh2_txt").show();
			}else{
				jQuery("#hh2_txt").hide();
			}
			jQuery("#txthowhear").val( howhear );
 		});
		
		jQuery(".cbolicense").on('click', function(event){
			var license = jQuery(this).attr("data-license");
 			jQuery("#txtLicencetype").val( license );
 		});
 		
 		jQuery(".stateCB").on('click', function(event){
			var stateid = jQuery(this).attr("data-stateid")
			jQuery("#b_state").val( stateid );
			
		});
		
		
		//parent.iframeResize(125);
		
		
		jQuery("#chksameasaddress").on('click',function(){
			var statename = '';
			if(jQuery(this).is(":checked")){
				
				jQuery(".stateCB").each(function( ) {
					if( jQuery(this).attr("data-stateid") == jQuery("#ses_state").val() ){
						statename = jQuery(this).html();
						jQuery("#dd2").find("span").html( statename );
					}
				});
				
				jQuery("#b_address").val(  jQuery("#ses_address").val()  );
				jQuery("#b_city").val(  jQuery("#ses_city").val()  );
				jQuery("#b_state").val(  jQuery("#ses_state").val()  );
				jQuery("#b_zipcode").val(  jQuery("#ses_zipcode").val()  );
			}else{
				jQuery("#b_address").val("");
				jQuery("#b_city").val("" );
				jQuery("#dd2").find("span").html( "Select State" );
				jQuery("#b_state").val( "" );
				jQuery("#b_zipcode").val("");
 			}
 	    });
    
		 
	});
	
</script> 
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

<input type="hidden" id="ses_address" value="<?php echo $this->session->userdata('address');?>"  />
<input type="hidden" id="ses_city" value="<?php echo $this->session->userdata('city');?>" />
<input type="hidden" id="ses_state" value="<?php echo $this->session->userdata('state');?>" />
<input type="hidden" id="ses_zipcode" value="<?php echo $this->session->userdata('zipcode');?>" />
<input type="hidden" id="ses_country" value="<?php echo $this->session->userdata('country');?>" />

