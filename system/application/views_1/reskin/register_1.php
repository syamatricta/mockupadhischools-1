<?php page_heading('Create Account', '');?>
<section class="register">
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-sm12 col-md-offset-1 wtbg">
				<form name="registerform" id="registerform" method="post" action="<?php echo c('site_ssl_baseurl').'user/register';?>" >
					<div class="row">
				 		<div class="col-md-10 col-sm12 col-md-offset-1">	 
						 <div class="row  mtb50">
						 	<div class="col-xs-4 step active">
						 		  STEP 1
						 	</div>
						 	<div class="col-xs-4 step text-center bl">
						 		  STEP 2
						 	</div>
						 	<div class="col-xs-4 step text-right bl">
						 		  STEP 3
						 	</div>
						 </div>
						</div>
					</div>
				 <div class="row mlr5">
				 	<div class="col-md-12 text-center">
				 		<p class=""><i>Note to student:<br/> Make sure that you input your name exactly as it appears on your drivers license and other legal documents.
							Don’t use any nicknames. For example, if your legal name is <strong>“Jonathan”</strong> don’t enter <strong>“John”</strong>.</i></p>
				 		<p>
				 			<i>The names need to match up because your name will appear on your course completion certificates that you submit to the Bureau of Real Estate. Your license and exam application will be delayed if the name on your certificates doesn’t match the name on your legal documents.</i>
				 		</p>
				 	</div>
				 </div>
				 <div class="row">
				 	<div class="col-md-10 col-sm12 col-md-offset-1">
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
						 <div class="row mt30">
						 	<div class="col-md-6 form-group">
						 		  <input type="text" name="firstname" id="firstname" placeholder="FIRST NAME*" class="form-control" required onblur="javascript:populate_certificate_name();"  value="<?php echo set_value('firstname'); ?>" />
						 	</div>
						 	<div class="col-md-6 form-group"> 
						 		<input type="text" name="lastname" id="lastname" placeholder="LAST NAME*" class="form-control" required onblur="javascript:populate_certificate_name();" value="<?php echo set_value('lastname'); ?>" />
							</div>
						 </div>
						 <div class="row">
						 	<div class="col-md-6 form-group">		
						 		 <input type="text" readonly placeholder="CERTIFICATE NAME*" name="name_on_certificate" id="name_on_certificate" required class="form-control" value="<?php echo $this->input->post('name_on_certificate'); ?>" />
                                                                 <div class="text-right guide-cnt">
                                                                     <a 	 			 
							 			data-toggle="popover"		 			
							 			data-trigger="hover" 
							 			data-container="body"
							 			title="What is certificate name?"
							 			data-title="What is certificate name?"
							 			data-placement="top"
							 		    data-content="Please enter your legal name here as it appears on your passport or birth certificate.  Completing this improperly will delay your license."
							 		   	>What is certificate name?</a>
                                                                 </div>
						 	</div>
						 	<div class="col-md-6  form-group">
						 		<input type="email" name="email" id="email" required placeholder="EMAIL*" class="form-control" value="<?php echo set_value('email'); ?>"/>
						 	</div>
						 </div>
						  <div class="row">
						 	<div class="col-md-6  form-group">		
						 		  		 <input type="text" placeholder="CONFIRM EMAIL*" required name="confirmemail" id="confirmemail" class="form-control" maxlength="128" value="<?php echo set_value('confirmemail'); ?>"/>
						 	</div>
						 	<div class="col-md-6 form-group">
						 		<input type="password" placeholder="PASSWORD*" name="psword" required id="psword" class="form-control" value=""/>
						 	</div>
						 </div>
						  <div class="row">
						 	<div class="col-md-6 form-group">		
						 		  <input type="password" placeholder="CONFIRM PASSWORD*" required name="psword1" id="psword1" class="form-control" value="" />
						 	</div>
						 	<div class="col-md-6 form-group">
						 		<input type="text" name="address" id="address" required placeholder="SHIPPING ADDRESS *"  class="form-control" maxlength="128" value="<?php echo set_value('address'); ?>" data-toggle="tooltip" data-placement="bottom" title="FedEx will not deliver to P.O. Boxes" />
							</div>
						 </div>
						  <div class="row">
						 	<div class="col-md-6 form-group">		
						 		  		<input type="text" placeholder="UNIT NUMBER" name="unitnumber" id="unitnumber"  class="form-control"  value="<?php echo $this->input->post('unitnumber'); ?>" />
						 		  		<input type="hidden" name="country" id="country" value="US">
						 	</div>
						 	<div class="col-md-6 form-group">
						 		<input type="text" placeholder="CITY*" name="city" required id="city" class="form-control" maxlength="128" value="<?php echo set_value('city'); ?>" />
						 	</div>
						 </div>
						  <div class="row">
						 	<div class="col-md-6 form-group">		
						 		<select class="state form-control" id="state" name="state" required>
                                                                    <option value="">SELECT STATE*</option>
						 			<?php foreach($state as $state){?>
						 				<option value="<?php echo $state['state_code'] ?>"><?php echo $state['state']?></option>
						 			<?php }?>
						 		</select>
						 		 <input type="hidden" readonly name="block_state" id="block_state" class="form-control" value="<?php if(set_value('state')) { echo get_statename(set_value('state'));} else {echo "Select State";}; ?>" onchange="javascript:checkrate1();" />
                                                            <input type="hidden" readonly name="statexx" id="sxxtate" class="droplisRenewDivtxtbx" value="<?php if(set_value('state')) { echo set_value('state'); } else { echo set_value('block_state');} ?>"/>
						 	</div>
						 	<div class="col-md-6 form-group">
						 		<input type="text" placeholder="ZIP CODE*" required name="zipcode" id="zipcode"  class="form-control" maxlength="5"  value="<?php echo set_value('zipcode'); ?>" />
                                                                <div class="text-right guide-cnt">Zip code must be 5 digits</div>
						 	</div>
						 </div>
						 <div class="row">
						 	<div class="col-md-6 form-group">
						 		<input type="text"  placeholder="PHONE*" required name="phone" id="phone" maxlength="10"  class="form-control"  value="<?php echo set_value('phone'); ?>" />
						 	</div>
						 	<div class="col-md-6 form-group">
						 		<textarea placeholder="NOTE TO ADHISCHOOLS" style="overflow-y: scroll;resize: none; height:42px;" name="note" id="note" maxlength="200"  class="form-control" ><?php echo set_value('note') ? set_value('note') : $data['note'];  ?></textarea>
						 	</div>
						 </div>
						
						 <div class="row">
						 	<div class="col-md-12 text-center mtb50">
						 		<input type="hidden" name="step1" id="step1"  value="0" />
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