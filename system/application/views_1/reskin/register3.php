<?php page_heading('Create Account', '');?>
<section class="register">
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-sm12 col-md-offset-1 wtbg"> 
				<?php echo form_open("user/courseadd",array('name'=>'courseform','id'=>'courseform'));  ?>
				 
				 <div class="row">
					 <div class="col-md-10 col-sm12 col-md-offset-1">
					 	<div class="row  mtb50">
						 	<div class="col-xs-4 step">
						 		  STEP 1
						 	</div>
						 	<div class="col-xs-4 step text-center bl">
						 		  STEP 2
						 	</div>
						 	<div class="col-xs-4 step text-right bl active">
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
								<div id="wrap_error_box" class="wrap-box-fixed">
									<div id="fixederror" class="page_error box-fixed" style="display: none;"></div>					
								</div>
						 	</div>
						 </div>
						 <div class="row">
						 	<div class="col-md-12 form-group">
						 		Do you want to take your classes with an optional live component or online?  <span class="vcol">Click below</span>
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
						 	<div class="col-md-12">
						 		<div class="radio radio-info">
									<input id="radio4" type="radio" value="Cart" name="package_type">
									<label for="radio4"> Buy each course on an a la carte basis </label>
								</div>
						 	</div>
						 </div>
						 <div class="row">
						 	<div class="col-md-12">
						 		 <input type="hidden" name="hidcoursetype" id="hidcoursetype" value="<?php echo set_value('hidcoursetype');?>"/>
						 		 <input type="hidden" name="hidlicensetype" id="hidlicensetype" value="<?php echo $license;?>" />
						 		 <input type="hidden" name="s_state" id="s_state" value="<?php echo $this->session->userdata('s_state');?>"/>
								<input type="hidden" name="unitnumber" id="unitnumber" value="<?php echo $this->session->userdata('unit_number');?>"/>
								<input type="hidden" name="s_address" id="s_address" value="<?php echo $this->session->userdata('s_address');?>" />
								<input type="hidden" name="s_city" id="s_city" value="<?php echo $this->session->userdata('s_city');?>" />
								<input type="hidden" name="s_zipcode" id="s_zipcode" value="<?php echo $this->session->userdata('s_zipcode');?>" />
								<input type="hidden" name="s_country" id="s_country" value="<?php echo $this->session->userdata('s_country');?>" />
								<input type="hidden" name="bphone" id="bphone" value="<?php echo $this->session->userdata('phone');?>" />
								<input type="hidden" name="new_package" id="new_package" value="" />
								<input type="hidden" name="register_user" id="register_user" value="1" />
								<input  type="hidden" name="bphone" id="bphone" value="<?php if(isset($phone))echo $phone;?>" />
								<input type="hidden" name="hidpaymenttype" id="hidpaymenttype" value="<?php echo set_value('hidpaymenttype');?>" />
								<input  type="hidden" name="step3"  id="step3" value="3" />
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
						 		<input type="hidden" name="step2" id="step2"  value="0" />
                                                                <input type="button" class=" btn-adhi gotourl" value="PREVIOUS" goto="user/register/2" />
						 		<input type="submit" class=" btn-adhi" value="SUBMIT" />
						 	</div>
						 </div>
						 
						  </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>