<form name="registerform_step3" id="registerform_step3" method="post">
    <div class="row">
        <div class="col-md-10 col-sm12 col-md-offset-1">            
            <div class="row">
                <div class="col-md-12">
                    <div id="wrap_error_box" class="wrap-box-fixed">
                        <div id="fixederror" class="page_error box-fixed" style="display: none;"></div>					
                    </div>
                </div>
            </div>
            <div class="row">
                   <div class="col-md-12 form-group">
                        Do you want to take your classes with a classroom component or online?  <span class="vcol">Click below</span>
                   </div>		 	
            </div>
            <div class="row margin30">
                <div class="col-md-12">
                    <ul class="nav nav-tabs">
                        <li role="presentation" class="active"><a href="#live" aria-controls="live" role="tab" data-toggle="tab">Live</a></li>
                        <li role="presentation"><a href="#online" aria-controls="online" role="tab" data-toggle="tab">Online</a></li>
                    </ul>
                </div>		 	 
            </div>
            <div class="row">
                <div class="col-md-12">
                     <div class="radio radio-info">
                        <input id="radio3" type="radio" value="Package" name="package_type" >
                        <label for="radio3"> Select one of our package deals – recommended. It’ll save you some cash in the long run </label>
                     </div>
                </div>
                <div class="col-md-12 form-info">
                    <div class="radio radio-info">
                        <input id="radio4" type="radio" value="Cart" name="package_type">
                        <label for="radio4"> Buy each course on an a la carte basis </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" name="hidcoursetype" id="hidcoursetype" />
                    <input type="hidden" name="hidlicensetype" id="hidlicensetype" />
                    <input type="hidden" name="s_state" id="s_state""/>
                    <input type="hidden" name="unitnumber" id="unitnumber"/>
                    <input type="hidden" name="s_address" id="s_address" />
                    <input type="hidden" name="s_city" id="s_city" />
                    <input type="hidden" name="s_zipcode" id="s_zipcode" />
                    <input type="hidden" name="s_country" id="s_country" />
                    <input type="hidden" name="bphone" id="bphone" />
                    <input type="hidden" name="new_package" id="new_package" value="" />
                    <input type="hidden" name="register_user" id="register_user" value="1" />
                    <input type="hidden" name="hidpaymenttype" id="hidpaymenttype" />
                    <input  type="hidden" name="hidusertype"  id="hidusertype" value="" />
                    <!--div class="tab-content">
                       <div role="tabpanel" class="tab-pane active" id="live">


                           </div>
                       <div role="tabpanel" class="tab-pane" id="online">2...</div>				     
                     </div-->
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">		 		
                    <div id="update_course_div" class="course"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center mtb50">
                    <input type="hidden" name="step" id="step"  value="3" />
                    <input type="button" class=" btn-adhi previous_step" value="PREVIOUS" />
                    <input type="submit" class=" btn-adhi" value="SUBMIT" />
                </div>
            </div>
        </div>
    </div>
</form>	
