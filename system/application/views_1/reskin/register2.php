<?php page_heading('Create Account', '');?>
<section class="register">
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-sm12 col-md-offset-1 wtbg"> 
				<form name="registerform2" id="registerform2" method="post" action="" >					 
					 <div class="row">
					 	<div class="col-md-10 col-sm12 col-md-offset-1">
					 		<div class="row mtb50">
							 	<div class="col-xs-4 step">
							 		  STEP 1
							 	</div>
							 	<div class="col-xs-4 step active bl  text-center">
							 		  STEP 2
							 	</div>
							 	<div class="col-xs-4 step  text-right  bl">
							 		  STEP 3
							 	</div>
							 </div>
					 		 <div class="row">
							 	<div class="col-md-12">
							 		<?php
					                if(isset($msg)) {
					                    $style = "block";
					                } else {
					                    $style = "none";
					                }
					                ?>
							 		 
					                
					                <div  class="alert alert-danger" id="errordiv" style="display:<?php echo $style;?>">
					                    <?php if(isset($msg)) echo $msg; ?>
					                </div> 
					                               
									<!--div  class="alert alert-success" id="flashsuccess"><?php echo $this->session->flashdata("msg");   ?></div-->
									<?php if (validation_errors ()) : echo '<div class="alert alert-danger">'.validation_errors ().'</div>'; endif;?>
							 	</div>
							 </div>
                                                         <!--
							 <div class="row margin30">
                                                            <div class="forum-alias-cnt col-md-12">
                                                                <div class="col-md-12 text-center form-group">
                                                                        We have a really cool online community where you can ask questions to your instructor or other students. How do you want your name to display if you post a message in the ADHI Schools forum? <span class="vcol extrabig">*</span>
                                                                </div>
                                                                <div class="col-sm-6 col-sm-offset-3 form-group"><input type="text" required name="forumalias" id="forumalias" class="form-control"   value="<?php echo set_value('forumalias'); ?>"/></div>
                                                            </div>
							 </div>
                                                         -->
							 <div class="row">
							 	<div class="col-md-6 form-group">
							 		<select name="txtLicencetype" id="txtLicencetype" class="form-control" required>
                                                                            <option value="">SELECT LICENSE TYPE*</option>
							 			<option value="S" <?php echo select_selected_ext('txtLicencetype', 'S', s('licensetype'));?>>Sales</option>
							 			<option value="B" <?php echo select_selected_ext('txtLicencetype', 'B', s('licensetype'));?>>Broker</option>
							 		</select>
                                                                    <div class="guide-cnt text-right">
                                                                        <a  data-toggle="popover"		 			
							 			data-trigger="hover" 
							 			data-container="body"
							 			title="Sales / Broker"
                                                                                data-html="true"
							 			data-title="Sales / Broker"
							 			data-placement="top"
                                                                                data-content="A <b>brokers</b> license lets you operate your own company. 
							 		   				You don't have to work for another broker like you would if you were a sales person. 
							 		   				Also, as a broker you could have multiple licenses; one to sell real estate from and one to conduct property management activity from, for example. 
							 		   				In order to qualify for this license, you need a bachelors degree in real estate or two years of full-time real estate experience.
                                                                                                        <br/><br/>A <b>salesperson</b> must work under a broker in order to do anything that would require a real estate license<br/>"
							 		   	>Sales/Broker (what's the difference?)</a>
                                                                    </div>
							 		
							 		 
							 	</div>
							 	<div class="col-md-6 form-group"> 
							 		<select name="txthowhear" id="txthowhear" class="form-control" required>
                                                                            <option value="">HOW DID YOU HEAR ABOUT US*</option>
							 			<option value="Search engine" <?php echo select_selected_ext('txthowhear', 'Search engine', s('testimonial'));?>>Search engine</option>
							 			<option value="Referral from a real estate office" <?php echo select_selected_ext('txthowhear', 'Referral from a real estate office', s('testimonial'));?>>Referral from a real estate office</option>
							 			<option value="Facebook/YouTube/Twitter" <?php echo select_selected_ext('txthowhear', 'Facebook/YouTube/Twitter', s('testimonial'));?>>Facebook/YouTube/Twitter</option>
							 			<option value="Friend" <?php echo select_selected_ext('txthowhear', 'Friend', s('testimonial'));?>>Friend</option>
							 			<option value="Other" <?php echo select_selected_ext('txthowhear', 'Other', s('testimonial'));?>>Other</option>		 			 
							 		</select>
								</div>
								 
							 </div>
							 <div class="row">
							 	<div class="col-md-6 form-group" id="extrafield">
							 		<input type="text" name="txtSearchengine" id="txtSearchengine" placeholder="Search Engine " class="form-control hearoptions" value="<?php echo $this->input->post('txtSearchengine', s('txtSearchengine')); ?>"  style="display: none"required />
									<input type="text" name="txtREO" id="txtREO" class="form-control hearoptions" placeholder="Real estate office" style="display: none" value="<?php echo $this->input->post('txtREO', s('txtREO')); ?>" required />
							 	</div>
							 </div>
                                                        <div class="row">
                                                            <div class="col-md-6 form-group">		
                                                                <input type="text" name="address" id="address" required placeholder="SHIPPING ADDRESS *"  class="form-control" maxlength="128" value="<?php echo set_value('address', s('s_address')); ?>" data-toggle="tooltip" data-placement="bottom" title="FedEx will not deliver to P.O. Boxes" />
                                                            </div>
                                                            <div class="col-md-6 form-group">		
                                                                <input type="text" placeholder="UNIT NUMBER" name="unitnumber" id="unitnumber"  class="form-control"  value="<?php echo $this->input->post('unitnumber', s('unit_number')); ?>" />
                                                                <input type="hidden" name="country" id="country" value="US">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 form-group">
						 		<input type="text" placeholder="CITY*" name="city" required id="city" class="form-control" maxlength="128" value="<?php echo set_value('city', s('s_city')); ?>" />
                                                            </div>
                                                            <div class="col-md-6 form-group">		
						 		<select class="state form-control" id="state" name="state" required>
                                                                    <option value="">SELECT STATE*</option>
                                                                        <?php foreach($state as $single_state){?>
                                                                            <option value="<?php echo $single_state['state_code'] ?>" <?php echo select_selected_ext('state', $single_state['state_code'], s('s_state'));?>><?php echo $single_state['state']?></option>
                                                                        <?php }?>
                                                                    </select>
                                                                    <input type="hidden" readonly name="block_state" id="block_state" class="form-control" value="<?php if(set_value('state')) { echo get_statename(set_value('state'));} else {echo "Select State";}; ?>" onchange="javascript:checkrate1();" />
                                                                <input type="hidden" readonly name="statexx" id="sxxtate" class="droplisRenewDivtxtbx" value="<?php if(set_value('state')) { echo set_value('state'); } else { echo set_value('block_state');} ?>"/>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 form-group">
						 		<input type="text" placeholder="ZIP CODE*" required name="zipcode" id="zipcode"  class="form-control" maxlength="5"  value="<?php echo set_value('zipcode', s('s_zipcode')); ?>" />
                                                                <div class="text-right guide-cnt">Zip code must be 5 digits</div>
                                                            </div>
                                                        </div>
                                                         
							 <h3>BILLING ADDRESS </h3>
							 
					
							 <div class="row">
							 	<div class="col-md-12">
							 		<div class="checkbox  checkbox-danger" >
                                                                            <input type="checkbox" name="setaddr" id="setaddr" value="1" <?php echo set_checkbox_ext('setaddr', 1,  s('setaddr'));?>>
								        <label for="setaddr">
								           Billing address same as shipping address <span style="display:none;" id="indicator">loading</span>
								        </label>
								    </div>
							 	</div>
							 </div>		 
							 <div class="row">
							 	<div class="col-md-6 form-group">		
							 		 <input type="text" name="b_address" id="b_address" placeholder="ADDRESS" required  class="form-control" maxlength="128" value="<?php echo set_value('b_address', s('b_address')); ?>" onblur="javascript:checkrate1(); "/> 		
							 	</div>
							 	<div class="col-md-6  form-group">
							 		<input type="text" name="b_city" id="b_city" placeholder="CITY*" required  class="form-control" maxlength="40"  value="<?php echo set_value('b_city', s('b_city')); ?>" onblur="javascript:checkrate1(); "/>
							 	</div>
							 </div>		 
							 <div class="row">
							 	<div class="col-md-6  form-group">		
							 		<input type="hidden" name="b_country" id="b_country" value="US" >
							 		<select class="state form-control" id="b_state" name="b_state" required>
                                                                            <option value="">SELECT STATE</option>
							 			<?php foreach($state as $state){?>
							 				<option value="<?php echo $state['state_code'] ?>" <?php echo select_selected_ext('b_state', $state['state_code'], s('b_state'));?>><?php echo $state['state']?></option>
							 			<?php }?>
							 		</select>  		
							 	</div>
							 	<div class="col-md-6 form-group">
							 		<input type="text" name="b_zipcode" id="b_zipcode" placeholder="ZIP CODE" required  class="form-control" maxlength="5" value="<?php echo set_value('b_zipcode', s('b_zipcode')); ?>" onblur="javascript:checkrate1(); "/>
                                                                        <div class="text-right guide-cnt">Zip code must be 5 digits</div>
							 	</div>
							 </div>
							  
							
							 <div class="row">
							 	<div class="col-md-12 text-center mtb50">
							 		<input type="hidden" name="step2" id="step2"  value="0" />
                                                                        <input type="button" class=" btn-adhi gotourl" value="PREVIOUS" goto="user/register" />
							 		<input type="submit" class=" btn-adhi" value="NEXT" />
							 	</div>
							 </div>
					 	</div>
					 </div>	
					
					 
					 </form>
			</div>
		</div>
	</div>
</section>