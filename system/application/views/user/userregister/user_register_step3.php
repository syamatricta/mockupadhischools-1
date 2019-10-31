<?php echo form_open("user/courseadd",array('name'=>'course','id'=>'course'));  ?>
<input type="hidden" name="s_state" id="s_state" value="<?php echo $this->session->userdata('s_state');?>"/>
<input type="hidden" name="unitnumber" id="unitnumber" value="<?php echo $this->session->userdata('unit_number');?>"/>
<input type="hidden" name="s_address" id="s_address" value="<?php echo $this->session->userdata('s_address');?>" />
<input type="hidden" name="s_city" id="s_city" value="<?php echo $this->session->userdata('s_city');?>" />
<input type="hidden" name="s_zipcode" id="s_zipcode" value="<?php echo $this->session->userdata('s_zipcode');?>" />
<input type="hidden" name="s_country" id="s_country" value="<?php echo $this->session->userdata('s_country');?>" />
<input type="hidden" name="bphone" id="bphone" value="<?php echo $this->session->userdata('phone');?>" />
<input type="hidden" name="new_package" id="new_package" value="" />
<input type="hidden" name="register_user" id="register_user" value="1" />
<div class="floatleft">
	<div class="left_cntnr positionr">
		<?php $this ->load->view('left_content_home.php');?>
	</div>
    <div class="right_cntnr">
        <div class="right_cntnr_bg_hd">
          <div class="floatleft width100p">
			 <div class="sitepagehead"><h1>Create Account Step 3</h1></div>
			 <div class="username"></div>
		 </div>
        </div>
        <div class="right_cntnr_bg">


			<div id="maindiv">
			  <div id="registerviewmain3" >
			    <div class="stmain3" align="center">
                                <?php
                                        if(isset($msg) || validation_errors ()) {
                                            $style = "block";
                                        } else {
                                            $style = "none";
                                        }
                                        ?>
				  <div class="registerinnerregister_step3contentdiv" align="center">
			        <div class="page_error" id="errordisplay"></div>
			        <div class="wrap-box-fixed" id="wrap_error_box">
                                    <div  class="page_error box-fixed" id="errordiv" style="display:<?php echo $style;?>">
                                      <?php if(isset($msg)) echo $msg; ?>
                                      <?php if (validation_errors ()) : echo validation_errors (); endif;?>
                                    </div>
                                    <button class="close" id="close_button" data-dismiss="alert" type="button" onclick="hide_errorbox();" style="display:<?php echo $style;?>">×</button>
                                </div>    
			        <div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("msg");   ?></div>
			        
			        <input  type="hidden" name="bphone" id="bphone" value="<?php if(isset($phone))echo $phone;?>" />
			        <div class="clearboth"></div>

					<div class="listregistermain">
			      	 	<div class="clearboth padding-bottom20"></div>
							<div class="contents_registermain margin-left29">
								<input type="hidden" name="hidlicensetype" id="hidlicensetype" value="<?php echo $license;?>" />
								<div class="leftside_register_step3">
									<!-- <img width="121"  height="28" src="<?php echo ssl_url_img().'course_type.png';?>" border="0"/> -->
									Do you want to take your classes with an optional live component or online?  Click below
								</div>
								<div class="clearboth">&nbsp;</div>
								<div class="rightsidedata_register">
                                                                    <a class="live_divsel" id="coursetypel" href="javascript:void(null);" onclick="javascript:show_courses(1,'Live')" title="Live" tabindex="31"></a>
                                                                    <a class="online_div" id="coursetypeo" href="javascript:void(null);" onclick="javascript:show_courses(1,'Online')" title="Online" tabindex="32"></a>&nbsp;
                                                                    <!--<img src="<?php echo ssl_url_img(); ?>live_normal.png" width="100" height="28" border="0" id="coursetypel" onclick="javascript:show_courses(1,'Live')"/>&nbsp;

                                                                    <img src="<?php   echo ssl_url_img(); ?>online_normal.png" width="100" height="28" border="0" id="coursetypeo" onclick="javascript:show_courses(1,'Online')"/>-->
								    <input type="hidden" name="hidcoursetype" id="hidcoursetype" value="<?php echo set_value('hidcoursetype');?>"/>
<!--                                                                    <input type="radio" <?php if(set_value('coursetype')== 'Live'){?> checked="checked" <?php }?> name="coursetype" id="coursetype" value="Live"  onclick="javascript:show_courses(1,this.value )">Live
						        	<input type="radio" name="coursetype" <?php if(set_value('coursetype')== 'Online'){?> checked="checked" <?php }?>  id="coursetype" value="Online" onclick="javascript:show_courses(1,this)" >Online-->
								</div>
								  <div class="clearboth">&nbsp;</div>

								<div class="paytype_cntr" id="paytype">
									<div style="padding: 5px 0px">
										<img width="13"  height="13" src="<?php if(set_value('hidpaymenttype')=='Package'){ echo ssl_url_img().'radio_select.png';}else{ echo ssl_url_img().'radio_nonselection.png';}?>" onclick="javascript:show_courses(2,'Package');" align="top" border="0" id="paymenttypep"/>
										<span class="" onclick="javascript:show_courses(2,'Package');" tabindex="33">&nbsp;&nbsp;Select one of our package deals – recommended. It’ll save you some cash in the long run</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									</div>

<!--								<input type="radio" name="paymenttype" id="paymenttype" value="Package" <?php if(set_value('paymenttype')== 'Package'){?> checked="checked" <?php }?> onclick="javascript:show_courses(this)">-->
<!--						        <input type="radio" name="paymenttype" id="paymenttype" value="Cart"  <?php if(set_value('paymenttype')== 'Cart'){?> checked="checked" <?php }?> onclick="javascript:show_courses(this)" >-->
                                    <div style="padding: 5px 0px">
                                    	<img width="13"  height="13" src="<?php if(set_value('hidpaymenttype')=='Cart'){ echo ssl_url_img().'radio_select.png';}else{ echo ssl_url_img().'radio_nonselection.png';}?>" onclick="javascript:show_courses(2,'Cart');" align="top" border="0" id="paymenttypec"/>
                                    	<span class="" onclick="javascript:show_courses(2,'Cart');" tabindex="34">&nbsp;&nbsp;Buy each course on an a la carte basis</span>
                                    </div>
									<input type="hidden" name="hidpaymenttype" id="hidpaymenttype" value="<?php echo set_value('hidpaymenttype');?>" />
                                </div>

							</div>
							<div class="clearboth"></div>

						<!--</div>
						<div class="profile_personal_right"><img  src="<?php   echo ssl_url_img(); ?>register/reg_step2_billing_right.jpg" /></div>	-->
						<input  type="hidden" name="step3"  id="step3" value="3" />
                                                <input  type="hidden" name="hidusertype"  id="hidusertype" value="" />
						<div class="clearboth">&nbsp;</div>
			      	 	<div id="show_courses" class="display-none">
			      	 		<div class="courselist_head727 margin-left29 display-none" id="crs_list_heading">COURSE LIST</div>

							<div class="clearboth46">&nbsp;</div>
							<div id="update_course_div"></div><?php /* loading the courses here */?>

						<?php	/* SALES MANDATORY COURSES*/
						#	$this->load->view("admin/register/register_course_sales_mandatory");
							/* SALES OPTIONAL COURSES */
						#	$this->load->view("admin/register/register_course_sales_optional");
							/* BROKERS COURSES */
						#	$this->load->view("admin/register/register_course_broker_mandatory");?>


					<!-- list registerdata-->
					</div>
			      </div>
			    </div>
			  </div>
			</div>


			</div>
		</div>
	</div>
</div>
</form>
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
show_courses(1,'Live');
</script>
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