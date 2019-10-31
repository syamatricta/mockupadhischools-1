<form name="trial_registration_form" id="trial_registration_form" method="post">
    <div class="row">
        <div class="col-md-10 col-sm12 col-md-offset-1">            
            <div class="row mt30">
                <div class="col-sm-6 form-group">
                    <input type="text" name="firstname" id="firstname" placeholder="FIRST NAME*" class="form-control" maxlength="40" required onblur="javascript:populate_certificate_name();"  value="" />
                </div>
                <div class="col-sm-6 form-group"> 
                    <input type="text" name="lastname" id="lastname" placeholder="LAST NAME*" class="form-control" maxlength="40" required onblur="javascript:populate_certificate_name();" value="" />
                </div>
            </div>
            <div class="row">
                  <div class="col-sm-6  form-group">		
                      <input type="email" name="email" id="email"  maxlength="70" required placeholder="EMAIL*" class="form-control" value=""/>
                  </div>

                  <div class="col-sm-6 form-group">
                      <div class="checkbox  checkbox-danger">
                          <input type="checkbox" name="confirm_email" id="confirm_email_id" maxlength="70" value="1" />
                          <label for="confirm_email_id">This is my email</label>
                      </div>
                  </div>
           </div>
            <div class="row">
                  <div class="col-sm-6 form-group">
                      <input type="password" placeholder="PASSWORD*" name="psword" required id="psword"  maxlength="40" class="form-control" value=""/>
                  </div>
                  <div class="col-sm-6 form-group">		
                      <input type="password" placeholder="CONFIRM PASSWORD*" required name="psword1" id="psword1"  maxlength="40" class="form-control" value="" />
                  </div>						 	
           </div>						  
           <div class="row">
                <div class="col-sm-6 form-group">
                    <input type="text"  placeholder="PHONE*" required name="phone" id="phone" maxlength="10"  class="form-control numbers_only"  value="" />
                </div>
                <div class="col-sm-6 form-group">                      
                    <div class="checkbox  checkbox-danger">
                        <input type="checkbox" name="terms" id="terms_id" maxlength="70" value="1" />
                        <label for="terms_id">I agree Terms and Conditions</label>
                    </div>
                </div>
           </div>
            

           <div class="row">
                <div class="col-md-12 text-center mtb50">
                    <input type="submit" class="btn-adhi" value="REGISTER" />
                </div>
           </div>
        </div>
    </div>
</form>