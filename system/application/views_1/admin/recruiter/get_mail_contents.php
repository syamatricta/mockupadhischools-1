<div class="clearboth"></div>
<form name="getmailcontents" id="getmailcontents" method="post" action="">
	<div id="maindiv" >
		<div id="registerviewmain">
			<div class="stmain">
				<div class="floatleft"><span class="registerredheading" style="color:black;">Recruiter Email</span></div>
				<div class="clearboth"></div>
				<div class="registerinnerregistercontentdiv" >
					<div class="page_error" id="errordisplay"></div>
					<div  class="page_error" id="errordiv" ><?php if(isset($msg)) echo $msg; ?></div>
					<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("msg");   ?></div>
					<?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
					<div class="clearboth"></div>
						<div class="listdata" style="margin-left:5%;width:1100px;">
									<div class="clearboth">&nbsp;</div>
                                                                        <div class="leftside_recruiter ">Recruiter name :<span class="red_star">*</span></div>
                                                                        <div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_recruiter"> 
										<select name="recruiter"  id="recruiter"  class="selecttextwidthr" onChange ="javascript : select_brokerage(this.value)">
											<option value="">Select</option>
											<?php
                                                                                            if(!empty($recruiter_detail)):
												foreach($recruiter_detail as $recruiter):
											?>
												<option value="<?php echo $recruiter['adhi_recruiter_id'];?>"  <?php echo ((set_value('recruiter') == $recruiter['adhi_recruiter_id']) || (isset($data) && $data['recruiter_referred'] == $recruiter['adhi_recruiter_id'])) ? 'SELECTED' : '';?>><?php echo $recruiter['recruiter_name'].' '.$recruiter['recruiter_last_name'].' ('.$recruiter['recruiter_mail'].' )';?></option>
											<?php endforeach; ?>
                                                                                     <?php endif; ?>
										</select>
									</div>
                                                                        
                                                                        <div class="leftsideheadings_recruiter">Brokerage referred to:</div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_recruiter" id ="brokerage_referred" name ="brokerage_referred"> <?php echo (set_value('brokerage_referred_to')); ?> </div>
                                                                        <input type="hidden" name="brokerage_referred_to" id="brokerage_referred_to" value=""/>
									<div class="clearboth"></div>
                                                                        
                                                                        <div class="leftside_recruiter">Copy email :</div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_recruiter" id ="copy_email" name ="copy_email"> <?php echo (set_value('copy_email_to')) ? (set_value('copy_email_to')) : '-'; ?> </div>
                                                                        <input type="hidden" name="copy_email_to" id="copy_email_to" value=""/>
									<div class="clearboth"></div>
                                                                        
									<div class="leftside_recruiter ht">Student First Name :<span class="red_star">*</span></div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_recruiter"><input type="text" name="firstname" id="firstname" class="textwidthr"  maxlength="128"  value="<?php echo isset($data) ? $data['student_first_name'] : set_value('firstname'); ?>"/></div>
									
                                                                        <div class="leftsideheadings_recruiter">Student Last Name :<span class="red_star">*</span></div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_recruiter"><input type="text" name="lastname" id="lastname" class="textwidthr"  maxlength="128"  value="<?php echo isset($data) ? $data['student_last_name'] : set_value('lastname'); ?>"/></div>
									<div class="clearboth"></div> 
                                                                        
                                                                        <div class="leftside_recruiter ">Gender of student :<span class="red_star">*</span></div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_recruiter" style="display:inline-block;float:left;">
                                                                            <input type="radio" name="gender" id="gender_m" value="1" <?php echo (isset($data) && $data['gender']) ? 'checked' : ''; ?>/> Male
                                                                            <input type="radio" name="gender" id="gender_f" value="0" <?php echo (isset($data) && (!$data['gender'])) ? 'checked' : ''; ?>/> Female
                                                                        </div>
									<div class="clearboth"></div> 
                                                                        
                                                                        <div class="leftside_recruiter ">Student area of interest/residence:<span class="red_star">*</span></div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_recruiter"><input type="text" name="area_of_interest" id="area_of_interest" class="textwidthr"  maxlength="128"  value="<?php echo isset($data) ? $data['area_of_interest'] : set_value('area_of_interest'); ?>"/></div>
									
                                                                        <div class="leftsideheadings_recruiter">Stage of licensure:<span class="red_star">*</span></div>
                                                                        <div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_recruiter"> 
										<select name="licensure"  id="licensure"  class="selecttextwidthr ">
											<option value="">Select</option>
											<?php
                                                                                            if(!empty($licensure_detail)):
												foreach($licensure_detail as $licensure):
											?>
												<option value="<?php echo $licensure['adhi_recruiter_licensure_stage_id'];?>"  <?php echo (set_value('licensure') == $licensure['adhi_recruiter_licensure_stage_id'] || (isset($data) && $data['stage_of_licensure'] == $licensure['adhi_recruiter_licensure_stage_id'])) ? 'SELECTED' : '';?>><?php echo $licensure['adhi_recruiter_licensure_stage_name'];?></option>
											<?php endforeach; ?>
                                                                                     <?php endif; ?>
										</select>
									</div>
									<div class="clearboth"></div>
                                                                        
									<div class="leftside_recruiter ">Student E-mail Address:<span class="red_star">*</span></div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_recruiter"><input type="text" name="email" id="email"  class="textwidthr" maxlength="50" value="<?php echo isset($data) ? $data['student_mail_id'] : set_value('email'); ?>"/></div>
									
                                                                        <?php /*
									<div class="leftsideheadings_recruiter ">Confirm E-mail :<span class="red_star">*</span></div>
									<div class="middlecolon_register">&nbsp;</div>
                                                                        <div class="rightsidedata_recruiter"><input type="text" name="confirmemail" id="confirmemail" class="textwidthr " maxlength="50" value="<?php echo isset($data) ? $data['student_mail_id'] : set_value('confirmemail'); ?>"/></div>
									<div class="clearboth"></div>
                                                                         * 
                                                                         */
                                                                        ?>
                                                                        
                                                                        <div class="leftsideheadings_recruiter ">Student Phone number :<span class="red_star">*</span></div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_recruiter"><input type="text" name="phone" id="phone"  class="textwidthr" maxlength="25" value="<?php echo isset($data) ? $data['student_phone_number'] : set_value('phone'); ?>"/></div>
									<div class="clearboth"></div>
                                                                        
                                                                        <div class="leftside_recruiter">Something interesting about the student :</div>
									<div class="middlecolon_register">&nbsp;</div>
									<div class="rightsidedata_recruiter"><textarea name="about" id="about"  class="textwidthr" rows="6" cols="50" value=""><?php echo isset($data) ? rtrim($data['about_student'], ".") : set_value('about'); ?></textarea> </div>
									
			
									
								</div>
							<?php /*content add recruiter main end*/?>
                                                                <div class="row" style="text-align:center;">
                                                                      <input class="btn red" type="button" value="Preview" onclick ="javascript : fncAddRecruiterMaildetails();" >
                                                                      <input class="btn red" type="button" value="Clear" onclick ="javascript : fncClearRecruiterMaildetails();">
                                                                </div>
                                                            <div class="register_instructionmark" style="padding-right:10px; margin-right: 42px; margin-top:5%;"><span class="instruction">Marked with </span><span class="red_star">*</span> <span class="instruction">are mandatory fields</span></div>
                                                            <div class="clearboth">&nbsp;</div>
                                                            <input type="hidden" name="hidprevrecruiterid" id="hidprevrecruiterid" value="<?php echo isset($prevrecid) ? $prevrecid : '' ; ?>"/>
                                                            <input type="hidden" name="hidprevmailid" id="hidprevmailid" value="<?php echo  isset($prevmailid) ? $prevmailid : ''; ?>"/>
							</div>
                                                        
						

				</div>
			<?php /*send recruiter mail get data end*/?>
		</div>
	</div>
</form>
