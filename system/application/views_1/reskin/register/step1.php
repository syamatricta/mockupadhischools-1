<form name="registerform_step1" id="registerform_step1" method="post">
    <div class="row mlr5">
        <div class="col-md-12 text-center">
            <p class=""><i>Note to student:<br/> Make sure that you input your name exactly as it appears on your drivers license and other legal documents.
                    Don’t use any nicknames. For example, if your legal name is “Jonathan” don’t enter “John”.</i>
            </p>
            <p>
                    <i>The names need to match up because your name will appear on your course completion certificates that you submit to the Bureau of Real Estate. Your license and exam application will be delayed if the name on your certificates doesn’t match the name on your legal documents.</i> 
            </p>
        </div>
     </div>
     <div class="row">
        <div class="col-md-10 col-sm12 col-md-offset-1">            
            <div class="row mt30">
                <div class="col-md-4 form-group">
                    <input type="text" name="firstname" id="firstname" placeholder="FIRST NAME*" class="form-control" maxlength="40" required onblur="javascript:populate_certificate_name();"  value="<?php echo set_value('firstname', (s('USER_NAME')) ? s('USER_NAME') : s('EXP_USER_NAME')); ?>" />
                </div>
                <div class="col-md-4 form-group"> 
                    <input type="text" name="lastname" id="lastname" placeholder="LAST NAME*" class="form-control" maxlength="40" required onblur="javascript:populate_certificate_name();" value="<?php echo set_value('lastname', (s('LAST_NAME')) ? s('LAST_NAME') : s('EXP_LAST_NAME')); ?>" />
                </div>
                <div class="col-md-4 form-group">
                    <div class="checkbox  checkbox-danger" >
                        <input type="checkbox" name="confirm_name" id="confirm_name_id" value="1" <?php echo set_checkbox_ext('confirm_name', s('confirm_name'), 1);?>>
                        <label for="confirm_name_id">This is my legal name.</label>
                    </div>
                </div>
            </div>
            <!--<div class="row">
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
                        <input type="email" name="email" id="email" required placeholder="EMAIL*" class="form-control" value="<?php echo set_value('email', s('')); ?>"/>
                </div>
            </div>-->
            <div class="row">
                  <div class="col-md-8  form-group">		
                      <input type="email" name="email" id="email" maxlength="70" required placeholder="EMAIL*" class="form-control" value="<?php echo set_value('email', (s('EMAIL')) ? s('EMAIL') : s('EXP_EMAIL')); ?>"/>
                  </div>

                  <div class="col-md-4 form-group">
                      <div class="checkbox  checkbox-danger">
                          <input type="checkbox" name="confirm_email" id="confirm_email_id" maxlength="70" value="1" <?php echo set_checkbox_ext('confirm_email', s('confirm_email'), 1);?>>
                          <label for="confirm_email_id">This is my email</label>
                      </div>
                  </div>
           </div>
           <div class="row">
                  <div class="col-md-6 form-group">
                      <input type="password" placeholder="PASSWORD*" name="psword" required id="psword"  maxlength="40" class="form-control" value=""/>
                  </div>
                  <div class="col-md-6 form-group">		
                      <input type="password" placeholder="CONFIRM PASSWORD*" required name="psword1" id="psword1"  maxlength="40" class="form-control" value="" />
                  </div>						 	
           </div>
           <div class="row">
                  <div class="col-md-6 form-group">
                        <input type="text"  placeholder="PHONE*" required name="phone" id="phone" maxlength="10"  class="form-control numbers_only"  value="<?php echo set_value('phone', (s('PHONE')) ? s('PHONE') : s('EXP_PHONE')); ?>" />
                  </div>
                  <div class="col-md-6 form-group">
                        <textarea placeholder="NOTE TO ADHISCHOOLS" style="overflow-y: scroll;resize: none; height:44px;" name="note" id="note" maxlength="200"  class="form-control expand" ><?php echo set_value('note', s('note'));?></textarea>                        
                  </div>
            </div>

           <div class="row">
                <div class="col-md-12 text-center mtb50">
                    <input type="hidden" name="step" id="step"  value="1" />
                    <input type="submit" class=" btn-adhi" value="NEXT" />
                </div>
           </div>
        </div>
    </div>
</form>