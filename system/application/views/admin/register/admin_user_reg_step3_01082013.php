<?php echo form_open("admin_register/courseadd",array('name'=>'course','id'=>'course'));  ?>
<input type="hidden" name="s_state" id="s_state" value="<?php echo $this->session->userdata('s_state');?>"/>
<input type="hidden" name="s_address" id="s_address" value="<?php echo $this->session->userdata('s_address');?>" />
<input type="hidden" name="s_city" id="s_city" value="<?php echo $this->session->userdata('s_city');?>" />
<input type="hidden" name="s_zipcode" id="s_zipcode" value="<?php echo $this->session->userdata('s_zipcode');?>" />
<input type="hidden" name="s_country" id="s_country" value="<?php echo $this->session->userdata('s_country');?>" />
<input type="hidden" name="bphone" id="bphone" value="<?php echo $this->session->userdata('phone');?>" />
<input type="hidden" name="need_ship" id="need_ship" value="<?php echo $this->session->userdata('need_ship');?>" />
<input type="hidden" name="need_payment" id="need_payment" value="<?php echo $this->session->userdata('need_payment');?>" />
<!--	<input type="hidden" name="price"  id="price"  value="0" />-->
<!--	<input type="hidden" name="shipprice"  id="shipprice"  value="0" />-->
<!--	<input type="hidden" name="totalprice"  id="totalprice"  value="0" />-->
	<input type="hidden" name="curyear"  id="curyear"  value="<?php echo convert_UTC_to_PST_year(date('Y-m-d H:i:s'));?>" />
	<input type="hidden" name="curmonth"  id="curmonth"  value="<?php echo convert_UTC_to_PST_month(date('Y-m-d H:i:s'));?>" />
	<input type="hidden" name="sel_course_b" id="sel_course_b" value=""  />
	<input type="hidden" name="sel_course_m" id="sel_course_m" value="0"  />
<div class="clearboth"></div>

<div id="maindiv">
  <div id="registerviewmain" >
    <div class="stmain">
      <div class="floatleft"><span class="redheading">Registration</span>&nbsp;&nbsp;<span class="register_step">Step 3 </span></div>
      <div class="clearboth"></div>
	  <div class="registerinnerregistercontentdiv">
        <div class="page_error" id="errordisplay"></div>
        <div  class="page_error" id="errordiv" >
          <?php if(isset($msg)) echo $msg; ?>
        </div>
        <div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("msg");   ?></div>
        <?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
        <input  type="hidden" name="bphone" id="bphone" value="<?php if(isset($phone))echo $phone;?>" />
        <div class="clearboth"></div>
        
<div class="listregistermain">
      	 	<div class="clearboth" style="padding-bottom:20px;"></div>
      	 	<div class="profile_personal_left"><img  src="<?php   echo ssl_url_img(); ?>register/reg_step2_biling_left.jpg" /></div>
			 <div class="admin_register_step2_billing_middle" >
			
				<div class="contents_registermain">
					<input type="hidden" name="hidlicensetype" id="hidlicensetype" value="<?php echo $license;?>" />
					<div class="leftside_register">Course Type: </div>
					<div class="middlecolon_register">&nbsp;</div>
					<div class="rightsidedata_register">
						<input type="radio" <?php if(set_value('coursetype')== 'Live'){?> checked="checked" <?php }?> name="coursetype" id="coursetype" value="Live"  onclick="javascript:show_courses(this.value )">Live
			        	<input type="radio" name="coursetype" <?php if(set_value('coursetype')== 'Online'){?> checked="checked" <?php }?>  id="coursetype" value="Online" onclick="javascript:show_courses(this)" >Online
					</div>
					  <div class="clearboth">&nbsp;</div>
					
					<div class="">
						<input type="radio" name="paymenttype" id="paymenttype" value="Package" <?php if(set_value('paymenttype')== 'Package'){?> checked="checked" <?php }?> onclick="javascript:show_courses(this)">Select one of our package deals – recommended. It’ll save you some cash in the long run
						<br/>
			        	<input type="radio" name="paymenttype" id="paymenttype" value="Cart"  <?php if(set_value('paymenttype')== 'Cart'){?> checked="checked" <?php }?> onclick="javascript:show_courses(this)" >Buy each course on an a la carte basis				
					</div>
				</div>
				<div class="clearboth"></div>		   		
			
			</div>
			<div class="profile_personal_right"><img  src="<?php   echo ssl_url_img(); ?>register/reg_step2_billing_right.jpg" /></div>	
			<input  type="hidden" name="step3"  id="step3" value="3" />
			 <input  type="hidden" name="hidusertype"  id="hidusertype" value="" />
			<div class="clearboth">&nbsp;</div>
                        <div id="show_courses" style="display:none">
                                <div class="floatleft"><span class="redsubheading">COURSE LIST</span></div>
                                <div class="clearboth">&nbsp;</div>
                                <div id="update_course_div"></div>
                        </div>
      </div>
    </div>
  </div>
</div>
</form>
