<div class="clearboth"></div>
<?php echo form_open("user/courseadd",array('name'=>'myform','id'=>'myform'));  ?>
	<div id="maindiv">
		<div id="registerviewmain" >
			<div class="stmain">
				<div class="floatleft"><span class="redheading">Registration</span>&nbsp;&nbsp;<span class="register_step">Step 2 </span></div>
				<div class="clearboth"></div>
				
				<div class="registerinnerregistercontentdiv">
					<div class="page_error" id="errordisplay"></div>
					<div  class="page_error" id="errordiv" ><?php if(isset($msg)) echo $msg; ?></div>
					<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("msg"); ?></div>
					<?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
					<input  type="hidden" name="bphone" id="bphone" value="<?php if(isset($phone))echo $phone;?>" />
        			<div class="clearboth"></div>
					
					<div class="listregistermain">
						<!--<div class="leftsideheadings_register">Forum Alias<span class="red_star">*</span></div>
						<div class="middlecolon_register">&nbsp;</div>
						<div class="rightsidedata_register">
							<input type="text" name="forumalias" id="forumalias" class="textwidth" maxlength="25"  value="<?php echo set_value('forumalias'); ?>"/>
						</div>
                                                -->
						<div class="leftside_register">License Type<span class="red_star">*</span></div>
						<div class="middlecolon_register">&nbsp;</div>
						<div class="rightsidedata_register">
							<select name="license" id="license" class="selecttextwidth">
								<option value="">Select License</option>
								<option value="S" <?php if(set_value('license')=='S'){?> selected="selected" <?php } ?>>Sales</option>
								<option value="B" <?php if(set_value('license')=='B'){?> selected="selected" <?php } ?>>Broker</option>
							</select>
						</div>
						<div class="clearboth"></div>
						
						<!--<div class="leftsideheadings_register">Unit Number</div>
						<div class="middlecolon_register">&nbsp;</div>
						<div class="rightsidedata_register"><input type="text" name="unitnumber" id="unitnumber" class="textwidth" maxlength="7"  value="<?php echo $this->input->post('unitnumber'); ?>"/></div>
						<div class="clearboth"></div>-->
						
						<?php /* shipping and biling needed or not*/?>
						<div class="profile_personal_left"><img  src="<?php   echo ssl_url_img(); ?>register/reg_step2_biling_left.jpg" /></div>
						<div class="admin_register_step2_billing_middle" >
							<div class="contents_registermain">
								<div class="leftside_register">Need Shipping</div>
								<div class="middlecolon_register">&nbsp;</div>
								<div class="rightsidedata_register">
									<!--<input type="radio" checked="checked" name="need_ship" id="need_ship" value="yes" onclick="javascript:show_ship(); checkcourse();">Yes
									<input type="radio" name="need_ship" <?php #if(set_value('need_ship')== 'no'){?> checked="checked" <?php #}?>  id="need_ship" value="no"  onclick="javascript:show_ship(); checkcourse();">No-->
									<input type="radio" checked="checked"  name="need_ship" id="need_ship_yes" value="yes" onclick="javascript:show_ship(); ">Yes
									<input type="radio" name="need_ship" <?php if(set_value('need_ship')== 'no'){?> checked="checked" <?php }?>  id="need_ship_no" value="no"  onclick="javascript:show_ship(); ">No
								</div>
								<div class="clearboth">&nbsp;</div>
								
								<div class="leftside_register">Need Payment</div>
								<div class="middlecolon_register">&nbsp;</div>
								<div class="rightsidedata_register">
									<!--<input type="radio" name="need_payment" id="need_payment" value="yes" onclick="javascript:show_payment(); checkcourse();" checked="checked">Yes
									<input type="radio" name="need_payment" id="need_payment" value="no"  <?php # if(set_value('need_payment')== 'no'){?> checked="checked" <?php #}?>  onclick="javascript:show_payment(); checkcourse();">No				-->
									<input type="radio" name="need_payment" id="need_payment_yes" value="yes" onclick="javascript:show_payment();" checked="checked"><label for="need_payment_yes">Yes</label>
									<input type="radio" name="need_payment" id="need_payment_no" value="no"  <?php if(set_value('need_payment')== 'no'){?> checked="checked" <?php }?>  onclick="javascript:show_payment(); "><label for="need_payment_no">No</label>
								</div>
							</div>
						</div>
						
						<div class="profile_personal_right"><img  src="<?php   echo ssl_url_img(); ?>register/reg_step2_billing_right.jpg" /></div>
						
						<?php /* shipping and biling needed or not*/?>
						<div class="clearboth">&nbsp;</div>
						
						<!--<div id="show_ship_div_addr">
							<div class="commonaddressheads">Shipping Address</div>
							<div class="clearboth"></div>
							<?php #$this->load->view("admin/register/register_step2_shipping"); ?>
						</div>-->
						
						<div id="show_payment_div_addr">
							<div class="clearboth">&nbsp;</div>
							<div class="commonaddressheads">Billing Address</div>
							<div class="clearboth"></div>
							<?php $this->load->view("admin/register/register_step2_billing");?>
						</div>
						
						<input type="hidden" name="step2" id="step2"  value="0" />
						
						<div class="clearboth">&nbsp;</div>
						<div align="center" class="rightsidedata_register" style="text-align:center; width:50%;">
							<img  src="<?php  echo ssl_url_img();?>innerpages/nextstep.jpg" onclick="javascript:check_step2();" class="stylebutton" />
							<span  id="newimg" style="display:none;"></span>
						</div>
					</div>
				<!-- list registerdata-->
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" >
	show_payment();
	//show_ship();
	var carr = new Array();
	<?php /*foreach($coursearr as $coursearr){ ?>
		carr[<?php echo $coursearr['id']?>] 	= new Array();
		carr[<?php echo $coursearr['id']?>][0]	= "<?php echo $coursearr['course_name']?>";
		carr[<?php echo $coursearr['id']?>][1]	= "<?php echo $coursearr['amount']?>";
	<?php }*/?>
	</script>
<?php echo form_close(); ?>