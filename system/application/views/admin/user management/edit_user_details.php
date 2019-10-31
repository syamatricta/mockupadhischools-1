<?php echo form_open_multipart('admin_user', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="adminmainlist">
	<?php 
	if(count($userdetails) > 0){
	?>
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
                <div class="floatright" style="margin-right:1%;"><a href="<?php echo base_url().'to_cco/user_register/'.$userdetails->id;?>">Add to CCO</a></div>
	</div> <?php /*end of  adminpagebanner */?>
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		<div class="page_error" id="errordisplay"></div>
		<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error"); ?></div>
		<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
		<?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
		<div class="listdata">
			<div class="leftsideheadings_view">First Name<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" class="success_border" name="txtFirstName" id="txtFirstName" size="40" maxlength="128" value="<?php echo $userdetails->firstname; ?>"/></div>
			<div class="clearboth"></div>
			
			<div class="leftsideheadings_view">Last Name<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" class="success_border" name="txtLastName" id="txtLastName" size="40" maxlength="128" value="<?php echo $userdetails->lastname; ?>" /></div>
			<div class="clearboth"></div>
			
			<div class="leftsideheadings_view">Certificate Name<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" class="success_border" name="name_on_certificate" id="name_on_certificate" size="40" maxlength="255" value="<?php echo $userdetails->name_on_certificate; ?>" /></div>
			<div class="clearboth"></div>
                        
                        <?php if('' != $userdetails->driving_license){?>
                            <div class="leftsideheadings_view">Drivers License Number<span class="red_star">*</span></div>
                            <div class="middlecolon">:</div>
                            <div class="rightsidedata_view">
                                <span id="dl_text">xxxxxxxxx</span>
                                <input type="text" style="display:none;" class="success_border" name="driving_license" id="driving_license" size="40" maxlength="20" value="" />
                                <a id="dl_link_edit" class="dl_link" onclick="editDL()">Edit</a>
                                <a id="dl_link_cancel" class="dl_link" onclick="cancelDL()" style="display:none;">Cancel</a>
                            </div>
                            <div class="clearboth"></div>
                        <?php }?>
			<!--
			<div class="leftsideheadings_view">Forum Alias<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" class="success_border" name="forumalias" id="forumalias" size="40" maxlength="25" value="<?php echo $userdetails->forum_alias; ?>" /></div>
			<div class="clearboth"></div>
                        -->
                        
			<div class="leftsideheadings_view">License Type<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view">
				<!--<?php if('B' == $userdetails->licensetype){
							echo "Broker";?>
							<input type="hidden" name="license" id="license" value="<?php echo $userdetails->licensetype; ?>" />
						<?php } else {?>
			           	 	<select name="license" id="license" class="success_border">
                                <option value=" ">Select License</option>
								<option value="S" <?php if($userdetails->licensetype=='S'){?> selected="selected" <?php } ?>>Sales</option>
								<option value="B" <?php if($userdetails->licensetype=='B'){?> selected="selected" <?php } ?>>Broker</option>
							</select>
			    	<?php } ?>-->
                                <?php if($userdetails->licensetype=='S'){ echo "Sales"; } ?>
				<?php if($userdetails->licensetype=='B'){ echo "Broker"; } ?>
                                
                        </div>
                        <div class="clearboth"></div>
			<div class="leftsideheadings_view">Unit Number</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" class="success_border" name="txtUnitNumber" id="txtUnitNumber" size="40" maxlength="10" value="<?php echo $userdetails->unit_number; ?>" /></div>
                        <div class="clearboth"></div>
			<div class="leftsideheadings_view">Email Id<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtEmail" class="success_border" id="txtEmail" size="40" maxlength="128" value="<?php echo $userdetails->emailid; ?>" /></div>
			<div class="clearboth"></div>
                        <div class="leftsideheadings_view">Note</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><textarea name="txtNote" class="success_border" id="txtNote" rows="4" cols="50" maxlength="200"><?php echo $userdetails->note; ?></textarea></div>
			<div class="clearboth"></div>
			
			<!--<div class="leftsideheadings_view">Address<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtAddress" class="success_border" id="txtAddress" size="40" maxlength="250" value="<?php echo $userdetails->address; ?>" /></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">City<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtCity" class="success_border" id="txtCity" size="40" maxlength="250" value="<?php echo $userdetails->city; ?>" /></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">State<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view">
				<select name="cmbstate" id="cmbstate" class="success_border">
					<option value="">Select State</option>
					<?php foreach($allstate as $state_p){?>
					<option value="<?php echo $state_p->state_code;?>"  <?php if($state_p->state_code == $state->state_code){?> selected="selected" <?php } ?>><?php echo $state_p->state;?></option>
					<?php } ?>
			        
			     </select>
			</div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">Country</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><label id="lblcountry">United States</label><input type="hidden" name="cmbcountry" id="cmbcountry" value="US"></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">Zip Code<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" class="success_border" name="txtZip" id="txtZip" onkeyup="isNumber(this)" size="40" maxlength="5" value="<?php echo $userdetails->zipcode; ?>" /></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">&nbsp;</div>
			<div class="middlecolon">&nbsp;</div>
			<div class="rightsidedata_view"><span class="instruction">Zipcode must be 5 digits</span></div>
			<div class="clearboth"></div>-->
			
			
			<!--<div class="leftsideheadings_view">Phone<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtPhone" class="success_border" id="txtPhone" onkeyup="isvalidPhoneNumber(this)" size="40" maxlength="15" value="<?php echo $userdetails->phone; ?>" /></div>
			<div class="clearboth"></div>-->
			<div class="leftsideheadings_view">&nbsp;</div>
			<div class="middlecolon">&nbsp;</div>
			<div class="rightsidedata_view"><!--<span class="instruction">Phone Number should be any one of the following format.1. (xxx) xxx xxxx  2. (xxx) xxx-xxxx  3. xxx-xxx-xxxx</span>--></div>
			<div class="clearboth"></div>
			
<?php /* shipping address */?>
			<div class="addressdivisionleft" >
				<fieldset style="width:97%; min-height: 175px;" >
   				<legend class="subhead_txt"><strong>Shipping Address</strong></legend>
					<div class="leftsideaddressheadings_view">Address<span class="red_star">*</span></div>
					<div class="addressmiddlecolon">:</div>
					<div class="rightsideaddress_view"><input type="text" class="success_border" name="s_txtAddress" id="s_txtAddress" size="40" maxlength="250" value="<?php echo $userdetails->s_address; ?>" /></div>
					<div class="clearboth"></div>
					<div class="leftsideaddressheadings_view">City<span class="red_star">*</span></div>
					<div class="addressmiddlecolon">:</div>
					<div class="rightsideaddress_view"><input type="text" class="success_border" name="s_txtCity" id="s_txtCity" size="40" maxlength="64" value="<?php echo $userdetails->s_city; ?>" /></div>
					<div class="clearboth"></div>
					<div class="leftsideaddressheadings_view">State<span class="red_star">*</span></div>
					<div class="addressmiddlecolon">:</div>
					<div class="rightsideaddress_view">
						<select name="cmbstate_s" id="cmbstate_s" class="success_border">
							<option value="">Select State</option>
							<?php foreach($allstate as $state_s){?>
							<option value="<?php echo $state_s->state_code;?>"  <?php if($state_s->state_code == $s_state->state_code){?> selected="selected" <?php } ?>><?php echo $state_s->state;?></option>
							<?php } ?>
				        </select>
					</div>
					<div class="clearboth"></div>
					
					<!--<div class="leftsideaddressheadings_view">Country </div>
					<div class="addressmiddlecolon">:</div>
					<div class="rightsideaddress_view"><label id="s_lblcountry">United States</label><input type="hidden" name="cmbcountry_s" id="cmbcountry_s" value="US"></div>
					<div class="clearboth"></div>-->
					<input type="hidden" name="cmbcountry_s" id="cmbcountry_s" value="US">
					
					
					<div class="leftsideaddressheadings_view">Zip Code<span class="red_star">*</span></div>
					<div class="addressmiddlecolon">:</div>
					<div class="rightsideaddress_view"><input type="text" class="success_border" name="s_txtZip" id="s_txtZip" onkeyup="isNumber(this)" size="40" maxlength="5" value="<?php echo trim($userdetails->s_zipcode);?>" /></div>
					<div class="clearboth"></div>
					<div class="leftsideaddressheadings_view">&nbsp;</div>
					<div class="addressmiddlecolon">&nbsp;</div>
					<div class="rightsideaddress_view"><span class="instruction">Zipcode must be 5 digits</span></div>
					<div class="clearboth"></div>
					
					<div class="leftsideaddressheadings_view">Phone<span class="red_star">*</span></div>
					<div class="addressmiddlecolon">:</div>
					<div class="rightsideaddress_view"><input type="text" name="txtPhone" class="success_border" id="txtPhone" onkeyup="isvalidPhoneNumber(this)" size="40" maxlength="15" value="<?php echo $userdetails->phone; ?>" /></div>
					<div class="clearboth"></div>
					
					
				</fieldset>
			</div> <?php /* end of addressdivisionleft */ ?>
<?php /* Billinging address */?>
			<div class="addressdivisionright" >
				<fieldset style="width:97%; min-height:175px;">
   				<legend class="subhead_txt"><strong>Billing Address</strong></legend>
					<div class="clearboth"></div>
					<div class="leftsideaddressheadings_view">Address<span class="red_star">*</span></div>
					<div class="addressmiddlecolon">:</div>
					<div class="rightsideaddress_view"><input type="text" class="success_border" name="b_txtAddress" id="b_txtAddress" size="40" maxlength="250" value="<?php echo $userdetails->b_address; ?>" /></div>
					<div class="clearboth"></div>
					<div class="leftsideaddressheadings_view">City<span class="red_star">*</span></div>
					<div class="addressmiddlecolon">:</div>
					<div class="rightsideaddress_view"><input type="text" class="success_border" name="b_txtCity" id="b_txtCity" size="40" maxlength="64" value="<?php echo $userdetails->b_city; ?>" /></div>
					<div class="clearboth"></div>
					<div class="leftsideaddressheadings_view">State<span class="red_star">*</span></div>
					<div class="addressmiddlecolon">:</div>
					<div class="rightsideaddress_view">
						<select name="cmbstate_b" id="cmbstate_b" class="success_border">
							<option value="">Select State</option>
							<?php foreach($allstate as $state_b){?>
							<option value="<?php echo $state_b->state_code;?>"  <?php if($state_b->state_code == @$b_state->state_code){?> selected="selected" <?php } ?>><?php echo $state_b->state;?></option>
							<?php } ?>
				        </select>
					</div>
					<div class="clearboth"></div>
					<!--<div class="leftsideaddressheadings_view">Country </div>
					<div class="addressmiddlecolon">:</div>
					<div class="rightsideaddress_view"><label id="b_lblcountry">United States</label><input type="hidden" name="cmbcountry_b" id="cmbcountry_b" value="US">	</div>
					<div class="clearboth"></div>-->
					<input type="hidden" name="cmbcountry_b" id="cmbcountry_b" value="US">
					
					
					<div class="leftsideaddressheadings_view">Zip Code<span class="red_star">*</span></div>
					<div class="addressmiddlecolon">:</div>
					<div class="rightsideaddress_view"><input type="text" class="success_border" name="b_txtZip" id="b_txtZip" size="40" onkeyup="isNumber(this)" maxlength="5" value="<?php echo $userdetails->b_zipcode; ?>" /></div>
					<div class="clearboth"></div>		
					<div class="leftsideaddressheadings_view">&nbsp;</div>
					<div class="addressmiddlecolon">&nbsp;</div>
					<div class="rightsideaddress_view"><span class="instruction">Zipcode must be 5 digits</span></div>
					<div class="clearboth"></div>	
				</fieldset>	
			</div> <?php /* end of addressdivisionright */?>
<?php /*course details */?>
			<?php if(count($coursedetails)>0){?>
				<div class="addressdivisionleft"><strong>Course Details</strong></div>
				<div class="admintopheads">
					<div class="clearboth"></div>
					<div class="adminlistheadings" style="width:10%; text-align:center;">Sl. No</div>
					<div class="adminlistheadings" style="width:30%">Course</div>
					<div class="adminlistheadings" style="width:20%">Enrolled Date</div>
					<div class="adminlistheadings" style="width:20%">Delivered Date</div>
					<div class="adminlistheadings" style="width:20%">Effective Date</div>
				</div>
				<?php $count=1; 
				 foreach($coursedetails as $data){
				  $bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';	?>
				   <div class="<?php print($bg_color);?>">
						<div class="adminlistheadings" style="width:10%; text-align:center;"><?php echo $count;?></div>
						<div class="adminlistheadings" style="width:30%"><?php echo $data->course_name; ?></div>
						<div class="adminlistheadings" style="width:20%"><label id="txtEnrolled<?php echo $count;?>"><?php echo formatDate($data->enrolled_date); ?></label></div>
						<div class="adminlistheadings" style="width:20%"><label id="txtDelivered<?php echo $count;?>"><?php if('0000-00-00' == $data->delivered_date) { echo "Not Delivered";} else { echo formatDate($data->delivered_date); } ?></label></div>
						<div class="adminlistheadings" style="width:20%"><label id="txtEffective<?php echo $count;?>"><?php if('0000-00-00' == $data->effective_date) { echo ""; } else { echo formatDate($data->effective_date);}  ?></label></div>
					</div>
				 <?php $count++; 
				 }		
				?>
			<?php }?>
			<div class="clearboth"></div>
			<?php 
			if('' != $this->uri->segment(4)) { $pageid =  $this->uri->segment(4);} else {
				$pageid ='';
			}
			?>
			<div class="middlebutton"><input type="button" name="butUpdate" value="Update" onclick="javascript:fncUpadteUserdetails('<?php if(count($coursedetails)>0) { echo $coursedetails[0]->userid;}  ?>','<?php echo $pageid; ?>');" /></div>
			</div> <?php /* end of listdata */?>
		</div> <?php /* end of admininnercontentdiv */?>
	<?php }?>
	<div class="backtolist"><a href="javascript:void(null);" onclick="javascript:gotolist(<?php echo $this->uri->segment(4);?>); return false;"><< Back to users list </a></div>
	<input type="hidden" id="hiduserid" name="hiduserid"  value="<?php echo $userid;?>" />
</div> <?php /* end of adminmainlist */ ?>
<?php echo form_close();?>