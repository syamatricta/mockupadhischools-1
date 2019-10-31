<div class="clearboth"></div>
<?php echo form_open("user/listremainingcourse",array('name'=>'course','id'=>'course'));?>
<div id="maindiv">
  <div id="profileviewmain" >
    <div class="floatleft" >
      <div class="floatleft"><span class="redheading">Add</span>&nbsp;&nbsp;<span class="register_step">New Courses </span></div>
      <div class="clearboth"></div>
      <div class="profileinnerregistercontentdiv">
        <div class="page_error" id="errordisplay"></div>
        <div  class="page_error" id="errordiv" >
          <?php if(isset($msg)) echo $msg; ?>
        </div>
        <div  class="page_error" >
          <?php  echo $this->session->flashdata("msg");   ?>
        </div>
        <?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
        <div class="clearboth"></div>
        <input  type="hidden" name="bphone" id="bphone" size="30" value="<?php if(isset($phone))echo $phone;?>" />
        <input  type="hidden" name="firstname" id="firstname" size="30" value="<?php if(isset($firstname))echo $firstname;?>" />
        <input  type="hidden" name="lastname" id="lastname" size="30" value="<?php if(isset($lastname))echo $lastname;?>" />
        <input  type="hidden" name="emailid" id="emailid" size="30" value="<?php if(isset($emailid))echo $emailid;?>"  />
        <div class="clearboth"></div>
        <div class="listregisterdata"> 
			<div class="commonaddressheads">Billing Address</div>
			<div class="clearboth"></div>
			<div class="register_personal_middle" >
					<div class="contents_registermain" >
						<div class="clearboth">&nbsp;</div>
						<div class="clearboth">&nbsp;</div>
						<div class="leftside_register">Address<span class="red_star">*</span></div>
						<div class="middlecolon_register">:</div>
						<div class="rightsidedata_register"><input type="text" name="b_address" id="b_address"   size="25" maxlength="128"  value="<?php if(isset($billing['b_address']))echo $billing['b_address']; ?>" onblur="javascript:checkrate1(); "/></div>
						
						<div class="leftsideheadings_register">State<span class="red_star">*</span></div>
						<div class="middlecolon_register">:</div>
						<div class="rightsidedata_register"> <select name="b_state"  id="b_state" onchange="javascript:checkrate1();">
															  <option value="">Select</option>
															  <?php 
																	foreach($state as $state1){
																	 if($billing['b_state'] == $state1['state_code'])  {?>
															  <option value="<?php echo $billing['b_state'];?>"  <?php if($billing['b_state']== $state1['state_code']){?> selected="selected" <?php } ?>><?php echo $state1['state'];?></option>
															  <?php }else{?>
																<option value="<?php echo $state1['state_code'];?>" ><?php echo $state1['state'];?></option>
										
															  <?php }}?>
															  </select>
						</div>
						<div class="clearboth"></div>
						<div class="leftside_register">Country<span class="red_star">*</span></div>
						<div class="middlecolon_register">:</div>
						<div class="rightsidedata_register"> <label id="lblcountry">United States</label><input type="hidden" name="b_country" id="b_country" value="US">
						</div>
					
						
						<div class="leftsideheadings_register">City<span class="red_star">*</span></div>
						<div class="middlecolon_register">:</div>
						<div class="rightsidedata_register"> <input type="text" name="b_city" id="b_city"  size="25" maxlength="128"  value="<?php if(isset($billing['b_city']))echo $billing['b_city']; ?>" onblur="javascript:checkrate1(); "/></div>
						<div class="clearboth"></div>
						<div class="leftside_register">Zipcode<span class="red_star">*</span></div>
						<div class="middlecolon_register">:</div>
						<div class="rightsidedata_register"> <input type="text" name="b_zipcode" id="b_zipcode"   size="25" maxlength="5" value="<?php if(isset($billing['b_zipcode']))echo $billing['b_zipcode'];?>" onblur="javascript:checkrate1(); "/></div>
						<div class="clearboth"></div>

					
					</div>
					<!--content register main end-->
				
			</div>
			<!--register_personal_middle end-->
			<div class="clearboth">&nbsp;</div>
		<div class="commonaddressheads">Shipping Address</div>
		<div class="clearboth"></div>
		<div class="register_personal_middle" >
					<div class="contents_registermain" >
						<div class="clearboth">&nbsp;</div>
						<div class="register_checkbox">&nbsp;</div>
						<div class="floatleft"><input type="checkbox" name="ssame" id="ssame"    onclick="javascript:checkshipping(),checkrate1();" />
						  Shipping Address is same as Billing Address </div>
						  <div class="clearboth">&nbsp;</div>
						<div class="leftside_register">Address<span class="red_star">*</span></div>
						<div class="middlecolon_register">:</div>
						<div class="rightsidedata_register"> <input type="text" name="s_address" id="s_address"    size="25" maxlength="128" value="<?php if(isset($shipping['s_address']))echo $shipping['s_address']; ?>" onblur="javascript:checkrate1(); "/></div>
						
						<div class="leftsideheadings_register">State<span class="red_star">*</span></div>
						<div class="middlecolon_register">:</div>
						<div class="rightsidedata_register"> <select name="s_state"  id="s_state" onchange="javascript:checkrate1();">
															  <option value="">Select</option>
															  <?php 
																	foreach($state as $state1){
																	 if($shipping['s_state'] == $state1['state_code'])  {?>
															  <option value="<?php echo $shipping['s_state'];?>"  <?php if($shipping['s_state']== $state1['state_code']){?> selected="selected" <?php } ?>><?php echo $state1['state'];?></option>
															  <?php }else{?>
																<option value="<?php echo $state1['state_code'];?>" ><?php echo $state1['state'];?></option>
										
															  <?php }}?>
															  </select>

						</div>
						<div class="clearboth"></div>
						<div class="leftside_register">Country<span class="red_star">*</span></div>
						<div class="middlecolon_register">:</div>
						<div class="rightsidedata_register"> <label id="lblcountry">United States</label><input type="hidden" name="s_country" id="s_country" value="US">
						</div>
					
						
						<div class="leftsideheadings_register">City<span class="red_star">*</span></div>
						<div class="middlecolon_register">:</div>
						<div class="rightsidedata_register"><input type="text" name="s_city" id="s_city"   size="25" maxlength="40"  value="<?php if(isset($shipping['s_city']))echo $shipping['s_city'];?>" onblur="javascript:checkrate1(); "/></div>
						<div class="clearboth"></div>
						<div class="leftside_register">Zipcode<span class="red_star">*</span></div>
						<div class="middlecolon_register">:</div>
						<div class="rightsidedata_register"> <input type="text" name="s_zipcode" id="s_zipcode"   size="25" maxlength="5" value="<?php if(isset($shipping['s_zipcode']))echo $shipping['s_zipcode']; ?>" onblur="javascript:checkrate1(); "/></div>
						<div class="clearboth"></div>

					
					</div>
					<!--content register main end-->
				
			</div>
			<!--content register personal end-->
		<div class="clearboth" style="padding-bottom:20px;"></div>
		<div class="floatleft"><span class="redsubheading">COURSE LIST</span></div>
		<div class="clearboth">&nbsp;</div>

	  <!--Courses For Sales-->
     <?php if($license == 'S' and $courses_m !=false){?>
  	  
			<div class="subhead_txt">The following courses are required </div>
			<div class="clearboth">&nbsp;</div>
		<!--Mandatory Courses-->	 
	   <?php foreach($courses_m as $courses_m){ ?>
	  <div  class="filedforrate"  >
		<div  class="filedforrate" >
		  <input type="hidden" name="courseprice<?php echo $courses_m['id']; ?>" id="courseprice<?php echo $courses_m['id']; ?>" value="<?php echo $courses_m['amount']; ?>"  />
		 
		     <input type="checkbox" <?php if($courses_m['child_cnt'] ==0){?> class="scheck" <?php } ?>  name="course[]"   id="course<?php if($courses_m['child_cnt'] ==0) echo $courses_m['id']; else echo 0; ?>" value="<?php if($courses_m['child_cnt'] ==0)  echo $courses_m['id']; else echo 0; ?>" onClick="javascript:showterms(this.value), checkrate();"  />
		  <?php if($courses_m['child_cnt'] ==0){
		echo $courses_m['course_name'] ." -  $".$courses_m['amount']; 
		  }
		  else
		  echo $courses_m['course_name'] ; 
		  ?>
		 <?php if($courses_m['child_cnt'] ==0) ?>
		  <input type="hidden" name="courseweight<?php echo $courses_m['id']; ?>" id="courseweight<?php echo $courses_m['id']; ?>" value="<?php echo $courses_m['wieght']; ?>"  />
		 </div>
	  </div>
	  
	    <!--Terms and condition-->
		<?php  if($courses_m['child_cnt'] ==0){?>
		 <div class="clearboth">&nbsp;</div> 
				   <div class="filedforrate" id="showdiv<?php echo $courses_m['id']; ?>" style="display:none;" >
						<div  class="filedforrate" >
						<textarea class="textarea_txt"  rows="7" cols="60">					ADHI Schools, LLC
			Voice: 888 768 5285 Fax: 800 598 3258
			Headquarters, 1063 West 6th Street - Second Floor, Ontario, CA 91762
			
			Enrollment Agreement/General Information Page
												Date ____________________		
			Name _________________________________________________
			Telephone number ________________
			Mailing address __________________________________________________________
			City ___________________________	State ______	Zip code ________________
			
			This is a legally binding instrument between ADHI Schools, LLC sometimes referred to in this document as �??the firm�?� or �??the school�?� or �??we�?� and the above named party, hereafter referred to as �??the student�?� or �??you�?�.  This document is intended to have a binding effect, please read slowly and carefully.  This document will confirm that you are enrolling in Real Estate Practice - Correspondence offered by ADHI Schools, LLC.  You understand that your enrollment in this course does not provide you with any classroom instruction.  To complete this course, you will be required to spend a minimum of eighteen (18) days with the material and complete a 100 question, multiple choice, open-book final examination.  The Department of Real Estate has approved this course as a correspondence course.  
			
			Information regarding the 100 question final exam
			
			During our 100 question multiple choice examination, you may refer to the instructional material supplied to you through the course.  A passing score on this exam is 60 percent or better.  You will be given 2 hours and 30 minutes to complete this examination.  Final examinations are either administered at one of our school locations during class time or by designated proctor.  If the student decides to take the examination in the firm�??s environment, the student should know that they are administered every class session by an employee of the school in an area separate from the classroom.  Currently, Department of Real Estate guidelines dictate that you must wait a minimum of eighteen (18) days from the date of receipt of materials before taking the final exam.  Upon passing the final exam you will receive a certificate of completion issued by the school.  If you pass this examination the transcript of completion will be mailed to the student within 72 hours of grading.  Reading the provided text will obviously prove useful in completing this examination, so make use of the textbook that is provided to you!
			
			Once again, the final examination may also be administered by a proctor who cannot be related to you by blood, marriage, domestic partnership or any other relationship that would impair the ability of the proctor to fairly administer the exam.  We will mail this examination to the proctor, not to your address.  The proctor will be required to sign a form indicating that they administered the examination and must return your answer sheet and the final exam to our headquarters.  If we do not get the final exam back we will not issue a certificate to you for this course!  We take the integrity of our material very seriously and cannot run the risk of our exams floating around.  Under NO circumstances will the final exam be given directly to the student. 
			
			In the event the student fails the final exam, the student may retake the test until they pass for no additional cost.  However, in the event of a failed examination the student must wait another eighteen (18) days from the date they last took the examination before they are allowed to retest.  The objective here is to learn and retain as much about the subject matter as possible.
			
			No legal advice given
			
			Throughout this course you will learn about various aspects of real estate.  It is the intention of the course and the firm to provide each student with up-to-date, timely and accurate information.  However, the firm is not a legal one and our instructors are not attorneys.  As such, none of the information disseminated should be relied upon as legal advice of any kind.  Please consult your tax and legal advisors if you desire tax or legal advice.  Also note that the Department of Real Estate has a website www.dre.ca.gov and on this site there is a form you may download to evaluate the course as a whole.
			
			Cost of the course and what it includes 
			
			The cost of the course is $129.00 payable by cash, check, money order or credit card.  The student also agrees to pay ten ($10) dollars for shipping and handling charges to wherever the materials are sent.  This entitles you to a two (2) year enrollment.  This includes the text book, the administration of the final exam, the grading of that final exam, fifteen (15) ungraded chapter quizzes, and the issuance of your Real Estate  Practice  certificate, provided the course is completed within our two (2) year time frame.  You are advised that the possession of a certificate of completion from this class alone does not allow you to act as a real estate salesperson.  The student understands that in the event they write a check returned marked �??NSF�?� the student will be charged a $20.00 processing fee for such.
			
			Refund and cancellation policy
			
			The student shall be entitled seven (7) calendar days from the date of enrollment to request a refund.  If a refund is requested, the school will refund all monies received with the exception of a $25.00 processing fee.  The textbook must also be returned to the school in unused condition.  Return shipping is the responsibility of the student.  If the school determines that unusual wear and tear has occurred with the textbook, or the text has been written in, the school will (in addition to the $25.00 processing fee) retain $39.95 for the textbook.  All refunds will be mailed to the student within ten (10) days of receiving the request.  No refunds will be issued after the seven (7) calendar days have lapsed.  In lieu of a refund, the student may transfer the enrollment to another party within thirty (30) days of the date of enrollment. In the event of transfer, the transferee must sign a new enrollment agreement and you must sign a form indicating that you wish to transfer this enrollment.   Once thirty (30) days have passed, no refunds or transfers will be allowed.  All refunds will be made by business check to the student named above, regardless of who wrote the check or method of payment.
			
			All refund requests must be made in writing to the above address and be postmarked no later than seven (7) days from the date of enrollment.
			
			Course approval from the Department of Real Estate
			
			The course is approved by the California Department of Real Estate and has been issued approval number 2079-04.
			
			Errors or omissions in the textbook
			
			ADHI Schools believes that the materials are published in good faith.  The textbook is published by Dearborn Publishing.  ADHI Schools is not responsible and will accept no responsibility for errata in any of the textbooks, review materials or study aids provided or sold to the student.
			
			My signature below confirms that I have been given a reasonable amount of time to make a decision as to my enrollment in the course and all my questions regarding the course have been answered.  I have read and understand all of the above including the refund and cancellation policy of the school.  If paying by credit card, my signature below authorizes the school to charge the card the amount indicated on this contract, and I agree to abide by the terms of my cardholder agreement.
			
			By ______________________					Payment method:   cash    check     cc
					   Student signature						Card number: _______________________
													Type of card:  VISA   M/C   AMEX   DISC
			__________________________ (Printed name)				Expiration date: _________
			
			
			</textarea>
						</div>	
						
						<div  class="filedforterm" >
						<input type="checkbox" name="agree<?php echo $courses_m['id']; ?>" id="agree<?php echo $courses_m['id']; ?>" value="<?php echo $courses_m['id']; ?>" onClick="javascript:showcheck(this.value),checkrate();">I Agree  <input type="checkbox" name="disagree<?php echo $courses_m['id']; ?>" id="disagree<?php echo $courses_m['id']; ?>" value="<?php echo $courses_m['id']; ?>" onClick="javascript:showuncheck(this.value),checkrate();"  /> I Don't Agree 
						</div>	
				   </div>
				   <div class="clearboth"></div> 
		<?php } ?>		   
	     <!--End Terms and condition-->
	   

	  <?php  if($courses_m['child_cnt'] !=0){?>
	  <div class="clearboth">&nbsp;</div>
	 	  <div id="shodiv" style="display:block;" >
	  	 <input  type="hidden"  name="subcourseprice"  id="subcourseprice" value="0" />
		<?php foreach($subcourses as $subcourses){ ?>
			<div  class="filedforrate" >
			  <div  class="filedforrate" >
			  <input  type="hidden"  name="subprice<?php echo $subcourses['id']; ?>" id="subprice<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['amount']; ?>" />
				<input  type="radio" class="subcheck" name="subcourse" id="subcourse" value="<?php echo $subcourses['id']; ?>" onClick="javascript:show_sub_opt_terms(this.value,document.course.elements['subcourse']), checkrate();"/>
			
				<?php echo $subcourses['course_name'] ." - $".$subcourses['amount']; ?>
				 <input type="hidden" name="courseweight<?php echo $subcourses['id']; ?>" id="courseweight<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['wieght']; ?>"  />
				 
			 </div>
			</div>
			<div class="clearboth">&nbsp;</div>
				  <!--Terms and condition-->
		
				   <div  class="filedforrate" id="showdiv<?php echo $subcourses['id']; ?>" style="display:none;" >
						<div  class="filedforrate"  >
						<textarea class="textarea_txt"  rows="7" cols="60">			ADHI Schools, LLC
			Voice: 888 768 5285 Fax: 800 598 3258
			Headquarters, 1063 West 6th Street - Second Floor, Ontario, CA 91762
			
			Enrollment Agreement/General Information Page
												Date ____________________		
			Name _________________________________________________
			Telephone number ________________
			Mailing address __________________________________________________________
			City ___________________________	State ______	Zip code ________________
			
			This is a legally binding instrument between ADHI Schools, LLC sometimes referred to in this document as �??the firm�?� or �??the school�?� or �??we�?� and the above named party, hereafter referred to as �??the student�?� or �??you�?�.  This document is intended to have a binding effect, please read slowly and carefully.  This document will confirm that you are enrolling in Real Estate Practice - Correspondence offered by ADHI Schools, LLC.  You understand that your enrollment in this course does not provide you with any classroom instruction.  To complete this course, you will be required to spend a minimum of eighteen (18) days with the material and complete a 100 question, multiple choice, open-book final examination.  The Department of Real Estate has approved this course as a correspondence course.  
			
			Information regarding the 100 question final exam
			
			During our 100 question multiple choice examination, you may refer to the instructional material supplied to you through the course.  A passing score on this exam is 60 percent or better.  You will be given 2 hours and 30 minutes to complete this examination.  Final examinations are either administered at one of our school locations during class time or by designated proctor.  If the student decides to take the examination in the firm�??s environment, the student should know that they are administered every class session by an employee of the school in an area separate from the classroom.  Currently, Department of Real Estate guidelines dictate that you must wait a minimum of eighteen (18) days from the date of receipt of materials before taking the final exam.  Upon passing the final exam you will receive a certificate of completion issued by the school.  If you pass this examination the transcript of completion will be mailed to the student within 72 hours of grading.  Reading the provided text will obviously prove useful in completing this examination, so make use of the textbook that is provided to you!
			
			Once again, the final examination may also be administered by a proctor who cannot be related to you by blood, marriage, domestic partnership or any other relationship that would impair the ability of the proctor to fairly administer the exam.  We will mail this examination to the proctor, not to your address.  The proctor will be required to sign a form indicating that they administered the examination and must return your answer sheet and the final exam to our headquarters.  If we do not get the final exam back we will not issue a certificate to you for this course!  We take the integrity of our material very seriously and cannot run the risk of our exams floating around.  Under NO circumstances will the final exam be given directly to the student. 
			
			In the event the student fails the final exam, the student may retake the test until they pass for no additional cost.  However, in the event of a failed examination the student must wait another eighteen (18) days from the date they last took the examination before they are allowed to retest.  The objective here is to learn and retain as much about the subject matter as possible.
			
			No legal advice given
			
			Throughout this course you will learn about various aspects of real estate.  It is the intention of the course and the firm to provide each student with up-to-date, timely and accurate information.  However, the firm is not a legal one and our instructors are not attorneys.  As such, none of the information disseminated should be relied upon as legal advice of any kind.  Please consult your tax and legal advisors if you desire tax or legal advice.  Also note that the Department of Real Estate has a website www.dre.ca.gov and on this site there is a form you may download to evaluate the course as a whole.
			
			Cost of the course and what it includes 
			
			The cost of the course is $129.00 payable by cash, check, money order or credit card.  The student also agrees to pay ten ($10) dollars for shipping and handling charges to wherever the materials are sent.  This entitles you to a two (2) year enrollment.  This includes the text book, the administration of the final exam, the grading of that final exam, fifteen (15) ungraded chapter quizzes, and the issuance of your Real Estate  Practice  certificate, provided the course is completed within our two (2) year time frame.  You are advised that the possession of a certificate of completion from this class alone does not allow you to act as a real estate salesperson.  The student understands that in the event they write a check returned marked �??NSF�?� the student will be charged a $20.00 processing fee for such.
			
			Refund and cancellation policy
			
			The student shall be entitled seven (7) calendar days from the date of enrollment to request a refund.  If a refund is requested, the school will refund all monies received with the exception of a $25.00 processing fee.  The textbook must also be returned to the school in unused condition.  Return shipping is the responsibility of the student.  If the school determines that unusual wear and tear has occurred with the textbook, or the text has been written in, the school will (in addition to the $25.00 processing fee) retain $39.95 for the textbook.  All refunds will be mailed to the student within ten (10) days of receiving the request.  No refunds will be issued after the seven (7) calendar days have lapsed.  In lieu of a refund, the student may transfer the enrollment to another party within thirty (30) days of the date of enrollment. In the event of transfer, the transferee must sign a new enrollment agreement and you must sign a form indicating that you wish to transfer this enrollment.   Once thirty (30) days have passed, no refunds or transfers will be allowed.  All refunds will be made by business check to the student named above, regardless of who wrote the check or method of payment.
			
			All refund requests must be made in writing to the above address and be postmarked no later than seven (7) days from the date of enrollment.
			
			Course approval from the Department of Real Estate
			
			The course is approved by the California Department of Real Estate and has been issued approval number 2079-04.
			
			Errors or omissions in the textbook
			
			ADHI Schools believes that the materials are published in good faith.  The textbook is published by Dearborn Publishing.  ADHI Schools is not responsible and will accept no responsibility for errata in any of the textbooks, review materials or study aids provided or sold to the student.
			
			My signature below confirms that I have been given a reasonable amount of time to make a decision as to my enrollment in the course and all my questions regarding the course have been answered.  I have read and understand all of the above including the refund and cancellation policy of the school.  If paying by credit card, my signature below authorizes the school to charge the card the amount indicated on this contract, and I agree to abide by the terms of my cardholder agreement.
			
			By ______________________					Payment method:   cash    check     cc
					   Student signature						Card number: _______________________
													Type of card:  VISA   M/C   AMEX   DISC
			__________________________ (Printed name)				Expiration date: _________
			
			
			</textarea>
						</div>	
						
						<div  class="filedforterm"  >
						<input type="checkbox" name="agree<?php echo $subcourses['id']; ?>" id="agree<?php echo $subcourses['id']; ?>"  value="<?php echo $subcourses['id']; ?>" onClick="javascript:show_radio_check(this.value,document.course.elements['subcourse']),checkrate();">I Agree  <input type="checkbox" name="disagree<?php echo $subcourses['id']; ?>" id="disagree<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['id']; ?>"   onclick="javascript:show_radio_uncheck(this.value,document.course.elements['subcourse']),checkrate();"> I Don't Agree 
						</div>	
				   </div>
				   <div class="clearboth"></div>
			   
	     <!--End Terms and condition-->
			
			
			
			
		  <?php } ?>			
	
	  </div>
	  <?php } ?>
 	<div class="clearboth"></div>
     <?php } ?>
	 <!--Mandatory Courses-->	
	 
  	<?php  }?>
	
	 <!--End Courses For Sales-->
	 	 
		 
		   <!--Courses For Brokers-->
	<?php if($license == 'B'){ 
	
	 if($courses_mt !=false){
	?>
  	
			<div class="subhead_txt">The following courses are required </div>
		<div class="clearboth">&nbsp;</div>
		<!--Mandatory Courses-->	 
	   <?php foreach($courses_mt as $courses_mt){ ?>

	  <div  class="filedforrate" >
		<div  class="filedforrate" >
		
				<input type="hidden" name="courseprice<?php echo $courses_mt['id']; ?>" id="courseprice<?php echo $courses_mt['id']; ?>" value="<?php echo $courses_mt['amount']; ?>"  />
		     <input type="checkbox" <?php if($courses_mt['child_cnt'] ==0){?> class="scheck" <?php } ?>  name="course[]"   id="course<?php if($courses_mt['child_cnt'] ==0) echo $courses_mt['id']; else echo 0; ?>" value="<?php if($courses_mt['child_cnt'] ==0)  echo $courses_mt['id']; else echo 0; ?>" onClick="javascript:showterms(this.value), checkrate();"  />
		  <?php  if($courses_mt['child_cnt'] ==0){
		echo $courses_mt['course_name'] ." -  $".$courses_mt['amount']; 
		  }
		  else
		  echo $courses_mt['course_name'] ; 
		  ?>
		  <?php if($courses_mt['child_cnt'] ==0) ?>
		  <input type="hidden" name="courseweight<?php echo $courses_mt['id']; ?>" id="courseweight<?php echo $courses_mt['id']; ?>" value="<?php echo $courses_mt['wieght']; ?>"  />
		 </div>
	  </div>
		<div class="clearboth"></div> 
		 
	    <!--Terms and condition-->
		<?php  if($courses_mt['child_cnt'] ==0){?>
				   <div class="filedforrate" id="showdiv<?php echo $courses_mt['id']; ?>" style="display:none;" >
						<div  class="filedforrate"  >
						<textarea class="textarea_txt"   rows="7" cols="60">					ADHI Schools, LLC
			Voice: 888 768 5285 Fax: 800 598 3258
			Headquarters, 1063 West 6th Street - Second Floor, Ontario, CA 91762
			
			Enrollment Agreement/General Information Page
												Date ____________________		
			Name _________________________________________________
			Telephone number ________________
			Mailing address __________________________________________________________
			City ___________________________	State ______	Zip code ________________
			
			This is a legally binding instrument between ADHI Schools, LLC sometimes referred to in this document as �??the firm�?� or �??the school�?� or �??we�?� and the above named party, hereafter referred to as �??the student�?� or �??you�?�.  This document is intended to have a binding effect, please read slowly and carefully.  This document will confirm that you are enrolling in Real Estate Practice - Correspondence offered by ADHI Schools, LLC.  You understand that your enrollment in this course does not provide you with any classroom instruction.  To complete this course, you will be required to spend a minimum of eighteen (18) days with the material and complete a 100 question, multiple choice, open-book final examination.  The Department of Real Estate has approved this course as a correspondence course.  
			
			Information regarding the 100 question final exam
			
			During our 100 question multiple choice examination, you may refer to the instructional material supplied to you through the course.  A passing score on this exam is 60 percent or better.  You will be given 2 hours and 30 minutes to complete this examination.  Final examinations are either administered at one of our school locations during class time or by designated proctor.  If the student decides to take the examination in the firm�??s environment, the student should know that they are administered every class session by an employee of the school in an area separate from the classroom.  Currently, Department of Real Estate guidelines dictate that you must wait a minimum of eighteen (18) days from the date of receipt of materials before taking the final exam.  Upon passing the final exam you will receive a certificate of completion issued by the school.  If you pass this examination the transcript of completion will be mailed to the student within 72 hours of grading.  Reading the provided text will obviously prove useful in completing this examination, so make use of the textbook that is provided to you!
			
			Once again, the final examination may also be administered by a proctor who cannot be related to you by blood, marriage, domestic partnership or any other relationship that would impair the ability of the proctor to fairly administer the exam.  We will mail this examination to the proctor, not to your address.  The proctor will be required to sign a form indicating that they administered the examination and must return your answer sheet and the final exam to our headquarters.  If we do not get the final exam back we will not issue a certificate to you for this course!  We take the integrity of our material very seriously and cannot run the risk of our exams floating around.  Under NO circumstances will the final exam be given directly to the student. 
			
			In the event the student fails the final exam, the student may retake the test until they pass for no additional cost.  However, in the event of a failed examination the student must wait another eighteen (18) days from the date they last took the examination before they are allowed to retest.  The objective here is to learn and retain as much about the subject matter as possible.
			
			No legal advice given
			
			Throughout this course you will learn about various aspects of real estate.  It is the intention of the course and the firm to provide each student with up-to-date, timely and accurate information.  However, the firm is not a legal one and our instructors are not attorneys.  As such, none of the information disseminated should be relied upon as legal advice of any kind.  Please consult your tax and legal advisors if you desire tax or legal advice.  Also note that the Department of Real Estate has a website www.dre.ca.gov and on this site there is a form you may download to evaluate the course as a whole.
			
			Cost of the course and what it includes 
			
			The cost of the course is $129.00 payable by cash, check, money order or credit card.  The student also agrees to pay ten ($10) dollars for shipping and handling charges to wherever the materials are sent.  This entitles you to a two (2) year enrollment.  This includes the text book, the administration of the final exam, the grading of that final exam, fifteen (15) ungraded chapter quizzes, and the issuance of your Real Estate  Practice  certificate, provided the course is completed within our two (2) year time frame.  You are advised that the possession of a certificate of completion from this class alone does not allow you to act as a real estate salesperson.  The student understands that in the event they write a check returned marked �??NSF�?� the student will be charged a $20.00 processing fee for such.
			
			Refund and cancellation policy
			
			The student shall be entitled seven (7) calendar days from the date of enrollment to request a refund.  If a refund is requested, the school will refund all monies received with the exception of a $25.00 processing fee.  The textbook must also be returned to the school in unused condition.  Return shipping is the responsibility of the student.  If the school determines that unusual wear and tear has occurred with the textbook, or the text has been written in, the school will (in addition to the $25.00 processing fee) retain $39.95 for the textbook.  All refunds will be mailed to the student within ten (10) days of receiving the request.  No refunds will be issued after the seven (7) calendar days have lapsed.  In lieu of a refund, the student may transfer the enrollment to another party within thirty (30) days of the date of enrollment. In the event of transfer, the transferee must sign a new enrollment agreement and you must sign a form indicating that you wish to transfer this enrollment.   Once thirty (30) days have passed, no refunds or transfers will be allowed.  All refunds will be made by business check to the student named above, regardless of who wrote the check or method of payment.
			
			All refund requests must be made in writing to the above address and be postmarked no later than seven (7) days from the date of enrollment.
			
			Course approval from the Department of Real Estate
			
			The course is approved by the California Department of Real Estate and has been issued approval number 2079-04.
			
			Errors or omissions in the textbook
			
			ADHI Schools believes that the materials are published in good faith.  The textbook is published by Dearborn Publishing.  ADHI Schools is not responsible and will accept no responsibility for errata in any of the textbooks, review materials or study aids provided or sold to the student.
			
			My signature below confirms that I have been given a reasonable amount of time to make a decision as to my enrollment in the course and all my questions regarding the course have been answered.  I have read and understand all of the above including the refund and cancellation policy of the school.  If paying by credit card, my signature below authorizes the school to charge the card the amount indicated on this contract, and I agree to abide by the terms of my cardholder agreement.
			
			By ______________________					Payment method:   cash    check     cc
					   Student signature						Card number: _______________________
													Type of card:  VISA   M/C   AMEX   DISC
			__________________________ (Printed name)				Expiration date: _________
			
			
			</textarea>
						</div>							
						<div  class="filedforterm"  >
						<input type="checkbox" name="agree<?php echo $courses_mt['id']; ?>" id="agree<?php echo $courses_mt['id']; ?>" value="<?php echo $courses_mt['id']; ?>" onClick="javascript:showcheck(this.value), checkrate();">I Agree  <input type="checkbox" name="disagree<?php echo $courses_mt['id']; ?>" id="disagree<?php echo $courses_mt['id']; ?>" value="<?php echo $courses_mt['id']; ?>" onClick="javascript:showuncheck(this.value), checkrate();" /> I Don't Agree 
						</div>	
				   </div>
				   <div class="clearboth"></div>
		<?php } ?>		   
	     <!--End Terms and condition-->
	   
	   <!--List Sub Courses For Principle-->
	  <?php  if($courses_mt['child_cnt'] !=0){?>
	  <div id="shodiv" style="display:block;" >
	 
	  	 <input  type="hidden"  name="subcourseprice"  id="subcourseprice" value="0" />
		<?php foreach($subcourses as $subcourses){ ?>
		
			<div  class="filedforrate"  >
			  <div  class="filedforrate" >
			  <input  type="hidden"  name="subprice<?php echo $subcourses['id']; ?>" id="subprice<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['amount']; ?>" />
				<input  type="radio" class="subcheck" name="subcourse" id="subcourse" value="<?php echo $subcourses['id']; ?>" onClick="javascript:show_sub_opt_terms(this.value,document.course.elements['subcourse']), checkrate();"/>
			
				<?php echo $subcourses['course_name'] ." - $".$subcourses['amount']; ?>
				<input type="hidden" name="courseweight<?php echo $subcourses['id']; ?>" id="courseweight<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['wieght']; ?>"  />
			 </div>
			</div>
			 <div class="clearboth"></div>
				  <!--Terms and condition-->
		
				   <div  class="filedforrate" id="showdiv<?php echo $subcourses['id']; ?>" style="display:none;" >
						<div  class="filedforrate"  >
						<textarea class="textarea_txt"   rows="7" cols="60">			ADHI Schools, LLC
			Voice: 888 768 5285 Fax: 800 598 3258
			Headquarters, 1063 West 6th Street - Second Floor, Ontario, CA 91762
			
			Enrollment Agreement/General Information Page
												Date ____________________		
			Name _________________________________________________
			Telephone number ________________
			Mailing address __________________________________________________________
			City ___________________________	State ______	Zip code ________________
			
			This is a legally binding instrument between ADHI Schools, LLC sometimes referred to in this document as �??the firm�?� or �??the school�?� or �??we�?� and the above named party, hereafter referred to as �??the student�?� or �??you�?�.  This document is intended to have a binding effect, please read slowly and carefully.  This document will confirm that you are enrolling in Real Estate Practice - Correspondence offered by ADHI Schools, LLC.  You understand that your enrollment in this course does not provide you with any classroom instruction.  To complete this course, you will be required to spend a minimum of eighteen (18) days with the material and complete a 100 question, multiple choice, open-book final examination.  The Department of Real Estate has approved this course as a correspondence course.  
			
			Information regarding the 100 question final exam
			
			During our 100 question multiple choice examination, you may refer to the instructional material supplied to you through the course.  A passing score on this exam is 60 percent or better.  You will be given 2 hours and 30 minutes to complete this examination.  Final examinations are either administered at one of our school locations during class time or by designated proctor.  If the student decides to take the examination in the firm�??s environment, the student should know that they are administered every class session by an employee of the school in an area separate from the classroom.  Currently, Department of Real Estate guidelines dictate that you must wait a minimum of eighteen (18) days from the date of receipt of materials before taking the final exam.  Upon passing the final exam you will receive a certificate of completion issued by the school.  If you pass this examination the transcript of completion will be mailed to the student within 72 hours of grading.  Reading the provided text will obviously prove useful in completing this examination, so make use of the textbook that is provided to you!
			
			Once again, the final examination may also be administered by a proctor who cannot be related to you by blood, marriage, domestic partnership or any other relationship that would impair the ability of the proctor to fairly administer the exam.  We will mail this examination to the proctor, not to your address.  The proctor will be required to sign a form indicating that they administered the examination and must return your answer sheet and the final exam to our headquarters.  If we do not get the final exam back we will not issue a certificate to you for this course!  We take the integrity of our material very seriously and cannot run the risk of our exams floating around.  Under NO circumstances will the final exam be given directly to the student. 
			
			In the event the student fails the final exam, the student may retake the test until they pass for no additional cost.  However, in the event of a failed examination the student must wait another eighteen (18) days from the date they last took the examination before they are allowed to retest.  The objective here is to learn and retain as much about the subject matter as possible.
			
			No legal advice given
			
			Throughout this course you will learn about various aspects of real estate.  It is the intention of the course and the firm to provide each student with up-to-date, timely and accurate information.  However, the firm is not a legal one and our instructors are not attorneys.  As such, none of the information disseminated should be relied upon as legal advice of any kind.  Please consult your tax and legal advisors if you desire tax or legal advice.  Also note that the Department of Real Estate has a website www.dre.ca.gov and on this site there is a form you may download to evaluate the course as a whole.
			
			Cost of the course and what it includes 
			
			The cost of the course is $129.00 payable by cash, check, money order or credit card.  The student also agrees to pay ten ($10) dollars for shipping and handling charges to wherever the materials are sent.  This entitles you to a two (2) year enrollment.  This includes the text book, the administration of the final exam, the grading of that final exam, fifteen (15) ungraded chapter quizzes, and the issuance of your Real Estate  Practice  certificate, provided the course is completed within our two (2) year time frame.  You are advised that the possession of a certificate of completion from this class alone does not allow you to act as a real estate salesperson.  The student understands that in the event they write a check returned marked �??NSF�?� the student will be charged a $20.00 processing fee for such.
			
			Refund and cancellation policy
			
			The student shall be entitled seven (7) calendar days from the date of enrollment to request a refund.  If a refund is requested, the school will refund all monies received with the exception of a $25.00 processing fee.  The textbook must also be returned to the school in unused condition.  Return shipping is the responsibility of the student.  If the school determines that unusual wear and tear has occurred with the textbook, or the text has been written in, the school will (in addition to the $25.00 processing fee) retain $39.95 for the textbook.  All refunds will be mailed to the student within ten (10) days of receiving the request.  No refunds will be issued after the seven (7) calendar days have lapsed.  In lieu of a refund, the student may transfer the enrollment to another party within thirty (30) days of the date of enrollment. In the event of transfer, the transferee must sign a new enrollment agreement and you must sign a form indicating that you wish to transfer this enrollment.   Once thirty (30) days have passed, no refunds or transfers will be allowed.  All refunds will be made by business check to the student named above, regardless of who wrote the check or method of payment.
			
			All refund requests must be made in writing to the above address and be postmarked no later than seven (7) days from the date of enrollment.
			
			Course approval from the Department of Real Estate
			
			The course is approved by the California Department of Real Estate and has been issued approval number 2079-04.
			
			Errors or omissions in the textbook
			
			ADHI Schools believes that the materials are published in good faith.  The textbook is published by Dearborn Publishing.  ADHI Schools is not responsible and will accept no responsibility for errata in any of the textbooks, review materials or study aids provided or sold to the student.
			
			My signature below confirms that I have been given a reasonable amount of time to make a decision as to my enrollment in the course and all my questions regarding the course have been answered.  I have read and understand all of the above including the refund and cancellation policy of the school.  If paying by credit card, my signature below authorizes the school to charge the card the amount indicated on this contract, and I agree to abide by the terms of my cardholder agreement.
			
			By ______________________					Payment method:   cash    check     cc
					   Student signature						Card number: _______________________
													Type of card:  VISA   M/C   AMEX   DISC
			__________________________ (Printed name)				Expiration date: _________
			
			
			</textarea>
						</div>	
						
						<div  class="filedforterm"  >
						<input type="checkbox" name="agree<?php echo $subcourses['id']; ?>" id="agree<?php echo $subcourses['id']; ?>"  value="<?php echo $subcourses['id']; ?>" onClick="javascript:show_radio_check(this.value,document.course.elements['subcourse']),checkrate();">I Agree  <input type="checkbox" name="disagree<?php echo $subcourses['id']; ?>" id="disagree<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['id']; ?>"   onclick="javascript:show_radio_uncheck(this.value,document.course.elements['subcourse']),checkrate();"> I Don't Agree 
						</div>	
				   </div>
				   <div class="clearboth"></div>
			   
	     <!--End Terms and condition-->
			
			
			
			
		  <?php } ?>			
	
	  </div>
	  <?php } ?>
	    <!--End List Sub Courses For Principle-->
	  
	 
 	<div class="clearboth">&nbsp;</div>
     <?php }} ?>
	 <!--Mandatory Courses-->	
<?php 	 if($courses_mb !=false){
	?>
  				<div class="clearboth">&nbsp;</div>
			<div class="subhead_txt">Choose <?php echo $countnum;?> from bottom list </div>
		<div class="clearboth">&nbsp;</div>
		<!--Mandatory Courses-->	 
	   <?php foreach($courses_mb as $courses_mb){ ?>

	  <div  class="filedforrate" >
		<div  class="filedforrate" >
		
				<input type="hidden" name="courseprice<?php echo $courses_mb['id']; ?>" id="courseprice<?php echo $courses_mb['id']; ?>" value="<?php echo $courses_mb['amount']; ?>"  />
		     <input type="checkbox" <?php if($courses_mb['child_cnt'] ==0){?> class="scheck" <?php } ?>  name="course[]"   id="course<?php if($courses_mb['child_cnt'] ==0) echo $courses_mb['id']; else echo 0; ?>" value="<?php if($courses_mt['child_cnt'] ==0)  echo $courses_mb['id']; else echo 0; ?>" onClick="javascript:showterms(this.value), checkrate();"  />
		  <?php if($courses_mb['child_cnt'] ==0){
		echo $courses_mb['course_name'] ." -  $".$courses_mb['amount']; 
		  }
		  else
		  echo $courses_mb['course_name'] ; 
		  ?>
		  <?php if($courses_mb['child_cnt'] ==0) ?>
		  <input type="hidden" name="courseweight<?php echo $courses_mb['id']; ?>" id="courseweight<?php echo $courses_mb['id']; ?>" value="<?php echo $courses_mb['wieght']; ?>"  />
		 </div>
	  </div>
		<div class="clearboth"></div> 
		 
	    <!--Terms and condition-->
		<?php  if($courses_mb['child_cnt'] ==0){?>
				   <div class="filedforrate" id="showdiv<?php echo $courses_mb['id']; ?>" style="display:none;" >
						<div  class="filedforrate"  >
						<textarea class="textarea_txt"  rows="7" cols="60">					ADHI Schools, LLC
			Voice: 888 768 5285 Fax: 800 598 3258
			Headquarters, 1063 West 6th Street - Second Floor, Ontario, CA 91762
			
			Enrollment Agreement/General Information Page
												Date ____________________		
			Name _________________________________________________
			Telephone number ________________
			Mailing address __________________________________________________________
			City ___________________________	State ______	Zip code ________________
			
			This is a legally binding instrument between ADHI Schools, LLC sometimes referred to in this document as �??the firm�?� or �??the school�?� or �??we�?� and the above named party, hereafter referred to as �??the student�?� or �??you�?�.  This document is intended to have a binding effect, please read slowly and carefully.  This document will confirm that you are enrolling in Real Estate Practice - Correspondence offered by ADHI Schools, LLC.  You understand that your enrollment in this course does not provide you with any classroom instruction.  To complete this course, you will be required to spend a minimum of eighteen (18) days with the material and complete a 100 question, multiple choice, open-book final examination.  The Department of Real Estate has approved this course as a correspondence course.  
			
			Information regarding the 100 question final exam
			
			During our 100 question multiple choice examination, you may refer to the instructional material supplied to you through the course.  A passing score on this exam is 60 percent or better.  You will be given 2 hours and 30 minutes to complete this examination.  Final examinations are either administered at one of our school locations during class time or by designated proctor.  If the student decides to take the examination in the firm�??s environment, the student should know that they are administered every class session by an employee of the school in an area separate from the classroom.  Currently, Department of Real Estate guidelines dictate that you must wait a minimum of eighteen (18) days from the date of receipt of materials before taking the final exam.  Upon passing the final exam you will receive a certificate of completion issued by the school.  If you pass this examination the transcript of completion will be mailed to the student within 72 hours of grading.  Reading the provided text will obviously prove useful in completing this examination, so make use of the textbook that is provided to you!
			
			Once again, the final examination may also be administered by a proctor who cannot be related to you by blood, marriage, domestic partnership or any other relationship that would impair the ability of the proctor to fairly administer the exam.  We will mail this examination to the proctor, not to your address.  The proctor will be required to sign a form indicating that they administered the examination and must return your answer sheet and the final exam to our headquarters.  If we do not get the final exam back we will not issue a certificate to you for this course!  We take the integrity of our material very seriously and cannot run the risk of our exams floating around.  Under NO circumstances will the final exam be given directly to the student. 
			
			In the event the student fails the final exam, the student may retake the test until they pass for no additional cost.  However, in the event of a failed examination the student must wait another eighteen (18) days from the date they last took the examination before they are allowed to retest.  The objective here is to learn and retain as much about the subject matter as possible.
			
			No legal advice given
			
			Throughout this course you will learn about various aspects of real estate.  It is the intention of the course and the firm to provide each student with up-to-date, timely and accurate information.  However, the firm is not a legal one and our instructors are not attorneys.  As such, none of the information disseminated should be relied upon as legal advice of any kind.  Please consult your tax and legal advisors if you desire tax or legal advice.  Also note that the Department of Real Estate has a website www.dre.ca.gov and on this site there is a form you may download to evaluate the course as a whole.
			
			Cost of the course and what it includes 
			
			The cost of the course is $129.00 payable by cash, check, money order or credit card.  The student also agrees to pay ten ($10) dollars for shipping and handling charges to wherever the materials are sent.  This entitles you to a two (2) year enrollment.  This includes the text book, the administration of the final exam, the grading of that final exam, fifteen (15) ungraded chapter quizzes, and the issuance of your Real Estate  Practice  certificate, provided the course is completed within our two (2) year time frame.  You are advised that the possession of a certificate of completion from this class alone does not allow you to act as a real estate salesperson.  The student understands that in the event they write a check returned marked �??NSF�?� the student will be charged a $20.00 processing fee for such.
			
			Refund and cancellation policy
			
			The student shall be entitled seven (7) calendar days from the date of enrollment to request a refund.  If a refund is requested, the school will refund all monies received with the exception of a $25.00 processing fee.  The textbook must also be returned to the school in unused condition.  Return shipping is the responsibility of the student.  If the school determines that unusual wear and tear has occurred with the textbook, or the text has been written in, the school will (in addition to the $25.00 processing fee) retain $39.95 for the textbook.  All refunds will be mailed to the student within ten (10) days of receiving the request.  No refunds will be issued after the seven (7) calendar days have lapsed.  In lieu of a refund, the student may transfer the enrollment to another party within thirty (30) days of the date of enrollment. In the event of transfer, the transferee must sign a new enrollment agreement and you must sign a form indicating that you wish to transfer this enrollment.   Once thirty (30) days have passed, no refunds or transfers will be allowed.  All refunds will be made by business check to the student named above, regardless of who wrote the check or method of payment.
			
			All refund requests must be made in writing to the above address and be postmarked no later than seven (7) days from the date of enrollment.
			
			Course approval from the Department of Real Estate
			
			The course is approved by the California Department of Real Estate and has been issued approval number 2079-04.
			
			Errors or omissions in the textbook
			
			ADHI Schools believes that the materials are published in good faith.  The textbook is published by Dearborn Publishing.  ADHI Schools is not responsible and will accept no responsibility for errata in any of the textbooks, review materials or study aids provided or sold to the student.
			
			My signature below confirms that I have been given a reasonable amount of time to make a decision as to my enrollment in the course and all my questions regarding the course have been answered.  I have read and understand all of the above including the refund and cancellation policy of the school.  If paying by credit card, my signature below authorizes the school to charge the card the amount indicated on this contract, and I agree to abide by the terms of my cardholder agreement.
			
			By ______________________					Payment method:   cash    check     cc
					   Student signature						Card number: _______________________
													Type of card:  VISA   M/C   AMEX   DISC
			__________________________ (Printed name)				Expiration date: _________
			
			
			</textarea>
						</div>	
						
						<div  class="filedforterm" >
						<input type="checkbox" name="agree<?php echo $courses_mb['id']; ?>" id="agree<?php echo $courses_mb['id']; ?>" value="<?php echo $courses_mb['id']; ?>" onClick="javascript:showcheck(this.value), checkrate();">I Agree  <input type="checkbox" name="disagree<?php echo $courses_mb['id']; ?>" id="disagree<?php echo $courses_mb['id']; ?>" value="<?php echo $courses_mb['id']; ?>" onClick="javascript:showuncheck(this.value), checkrate();" /> I Don't Agree 
						</div>	
				   </div>
				   <div class="clearboth"></div>
		<?php } ?>		   
	     <!--End Terms and condition-->
	   
	   <!--List Sub Courses For Principle-->
	  <?php  if($courses_mb['child_cnt'] !=0){?>
	  <div class="clearboth">&nbsp;</div>
	  <div id="shodiv" style="display:block;" >
	 
	  	 <input  type="hidden"  name="subcourseprice"  id="subcourseprice" value="0" />
		<?php foreach($subcourses as $subcourses){ ?>
		
			<div  class="filedforrate"  >
			  <div  class="filedforrate" >
			  <input  type="hidden"  name="subprice<?php echo $subcourses['id']; ?>" id="subprice<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['amount']; ?>" />
				<input  type="radio" class="subcheck" name="subcourse" id="subcourse" value="<?php echo $subcourses['id']; ?>" onClick="javascript:show_sub_opt_terms(this.value,document.course.elements['subcourse']), checkrate();"/>
			
				<?php echo $subcourses['course_name'] ." - $".$subcourses['amount']; ?>
				<input type="hidden" name="courseweight<?php echo $subcourses['id']; ?>" id="courseweight<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['wieght']; ?>"  />
			 </div>
			</div>
			 <div class="clearboth"></div>
				  <!--Terms and condition-->
		
				   <div  class="filedforrate" id="showdiv<?php echo $subcourses['id']; ?>" style="display:none;" >
						<div  class="filedforrate" style="" >
						<textarea class="textarea_txt"   rows="7" cols="60">			ADHI Schools, LLC
			Voice: 888 768 5285 Fax: 800 598 3258
			Headquarters, 1063 West 6th Street - Second Floor, Ontario, CA 91762
			
			Enrollment Agreement/General Information Page
												Date ____________________		
			Name _________________________________________________
			Telephone number ________________
			Mailing address __________________________________________________________
			City ___________________________	State ______	Zip code ________________
			
			This is a legally binding instrument between ADHI Schools, LLC sometimes referred to in this document as �??the firm�?� or �??the school�?� or �??we�?� and the above named party, hereafter referred to as �??the student�?� or �??you�?�.  This document is intended to have a binding effect, please read slowly and carefully.  This document will confirm that you are enrolling in Real Estate Practice - Correspondence offered by ADHI Schools, LLC.  You understand that your enrollment in this course does not provide you with any classroom instruction.  To complete this course, you will be required to spend a minimum of eighteen (18) days with the material and complete a 100 question, multiple choice, open-book final examination.  The Department of Real Estate has approved this course as a correspondence course.  
			
			Information regarding the 100 question final exam
			
			During our 100 question multiple choice examination, you may refer to the instructional material supplied to you through the course.  A passing score on this exam is 60 percent or better.  You will be given 2 hours and 30 minutes to complete this examination.  Final examinations are either administered at one of our school locations during class time or by designated proctor.  If the student decides to take the examination in the firm�??s environment, the student should know that they are administered every class session by an employee of the school in an area separate from the classroom.  Currently, Department of Real Estate guidelines dictate that you must wait a minimum of eighteen (18) days from the date of receipt of materials before taking the final exam.  Upon passing the final exam you will receive a certificate of completion issued by the school.  If you pass this examination the transcript of completion will be mailed to the student within 72 hours of grading.  Reading the provided text will obviously prove useful in completing this examination, so make use of the textbook that is provided to you!
			
			Once again, the final examination may also be administered by a proctor who cannot be related to you by blood, marriage, domestic partnership or any other relationship that would impair the ability of the proctor to fairly administer the exam.  We will mail this examination to the proctor, not to your address.  The proctor will be required to sign a form indicating that they administered the examination and must return your answer sheet and the final exam to our headquarters.  If we do not get the final exam back we will not issue a certificate to you for this course!  We take the integrity of our material very seriously and cannot run the risk of our exams floating around.  Under NO circumstances will the final exam be given directly to the student. 
			
			In the event the student fails the final exam, the student may retake the test until they pass for no additional cost.  However, in the event of a failed examination the student must wait another eighteen (18) days from the date they last took the examination before they are allowed to retest.  The objective here is to learn and retain as much about the subject matter as possible.
			
			No legal advice given
			
			Throughout this course you will learn about various aspects of real estate.  It is the intention of the course and the firm to provide each student with up-to-date, timely and accurate information.  However, the firm is not a legal one and our instructors are not attorneys.  As such, none of the information disseminated should be relied upon as legal advice of any kind.  Please consult your tax and legal advisors if you desire tax or legal advice.  Also note that the Department of Real Estate has a website www.dre.ca.gov and on this site there is a form you may download to evaluate the course as a whole.
			
			Cost of the course and what it includes 
			
			The cost of the course is $129.00 payable by cash, check, money order or credit card.  The student also agrees to pay ten ($10) dollars for shipping and handling charges to wherever the materials are sent.  This entitles you to a two (2) year enrollment.  This includes the text book, the administration of the final exam, the grading of that final exam, fifteen (15) ungraded chapter quizzes, and the issuance of your Real Estate  Practice  certificate, provided the course is completed within our two (2) year time frame.  You are advised that the possession of a certificate of completion from this class alone does not allow you to act as a real estate salesperson.  The student understands that in the event they write a check returned marked �??NSF�?� the student will be charged a $20.00 processing fee for such.
			
			Refund and cancellation policy
			
			The student shall be entitled seven (7) calendar days from the date of enrollment to request a refund.  If a refund is requested, the school will refund all monies received with the exception of a $25.00 processing fee.  The textbook must also be returned to the school in unused condition.  Return shipping is the responsibility of the student.  If the school determines that unusual wear and tear has occurred with the textbook, or the text has been written in, the school will (in addition to the $25.00 processing fee) retain $39.95 for the textbook.  All refunds will be mailed to the student within ten (10) days of receiving the request.  No refunds will be issued after the seven (7) calendar days have lapsed.  In lieu of a refund, the student may transfer the enrollment to another party within thirty (30) days of the date of enrollment. In the event of transfer, the transferee must sign a new enrollment agreement and you must sign a form indicating that you wish to transfer this enrollment.   Once thirty (30) days have passed, no refunds or transfers will be allowed.  All refunds will be made by business check to the student named above, regardless of who wrote the check or method of payment.
			
			All refund requests must be made in writing to the above address and be postmarked no later than seven (7) days from the date of enrollment.
			
			Course approval from the Department of Real Estate
			
			The course is approved by the California Department of Real Estate and has been issued approval number 2079-04.
			
			Errors or omissions in the textbook
			
			ADHI Schools believes that the materials are published in good faith.  The textbook is published by Dearborn Publishing.  ADHI Schools is not responsible and will accept no responsibility for errata in any of the textbooks, review materials or study aids provided or sold to the student.
			
			My signature below confirms that I have been given a reasonable amount of time to make a decision as to my enrollment in the course and all my questions regarding the course have been answered.  I have read and understand all of the above including the refund and cancellation policy of the school.  If paying by credit card, my signature below authorizes the school to charge the card the amount indicated on this contract, and I agree to abide by the terms of my cardholder agreement.
			
			By ______________________					Payment method:   cash    check     cc
					   Student signature						Card number: _______________________
													Type of card:  VISA   M/C   AMEX   DISC
			__________________________ (Printed name)				Expiration date: _________
			
			
			</textarea>
						</div>	
						
						<div  class="filedforterm"  >
						<input type="checkbox" name="agree<?php echo $subcourses['id']; ?>" id="agree<?php echo $subcourses['id']; ?>"  value="<?php echo $subcourses['id']; ?>" onClick="javascript:show_radio_check(this.value,document.course.elements['subcourse']),checkrate();">I Agree  <input type="checkbox" name="disagree<?php echo $subcourses['id']; ?>" id="disagree<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['id']; ?>"   onclick="javascript:show_radio_uncheck(this.value,document.course.elements['subcourse']),checkrate();"> I Don't Agree 
						</div>	
				   </div>
				   <div class="clearboth">&nbsp;</div>
			   
	     <!--End Terms and condition-->
			
			
			
			
		  <?php } ?>			
	
	  </div>
	  <?php } ?>
	    <!--End List Sub Courses For Principle-->
	  
	  
 	<div class="clearboth"></div>
     <?php }} ?>
	 <!--Mandatory Courses-->
  	<?php  }?>
	 <!--Courses For Brokers-->



 <!--Bottom Course Listing For Sales-->
	  <?php if($license == 'S' and $courses_o !=false){?>
	  <div class="clearboth">&nbsp;</div>
   			<div class="subhead_txt">The candidates can pick from one of the below</div>
			<div class="clearboth">&nbsp;</div>
			 <input type="hidden" name="s_courseprice" id="s_courseprice" value="0"  />
			 <?php foreach($courses_o as $courses_o){ ?>
			  <div  class="filedforrate"  >
				<div  class="filedforrate" >
				  <input type="hidden" name="courseprice<?php echo $courses_o['id']; ?>" id="courseprice<?php echo $courses_o['id']; ?>" value="<?php echo $courses_o['amount']; ?>"  />
				  <input type="radio" class="bcheck" name="course_b" id="course_b" value="<?php echo $courses_o['id']; ?>" onClick="javascript:show_opt_terms(this.value,document.course.elements['course_b']), checkrate();"     />
				  <?php echo $courses_o['course_name'] ." - $".$courses_o['amount']; ?>
				  <?php if($courses_o['id'] !=5) ?>
				  <input type="hidden" name="courseweight_b<?php echo $courses_o['id']; ?>" id="courseweight_b<?php echo $courses_o['id']; ?>" value="<?php echo $courses_o['wieght']; ?>"  />
				 </div>
			  </div>
			<div class="clearboth">&nbsp;</div>
			
			  <!--Terms and condition For Principle-->
	
				   <div class="filedforrate" id="showdiv<?php echo $courses_o['id']; ?>" style="display:none;" >
						<div  class="filedforrate"  >
						<textarea class="textarea_txt"  rows="7" cols="60">				ADHI Schools, LLC
			Voice: 888 768 5285 Fax: 800 598 3258
			Headquarters, 1063 West 6th Street - Second Floor, Ontario, CA 91762
			
			Enrollment Agreement/General Information Page
												Date ____________________		
			Name _________________________________________________
			Telephone number ________________
			Mailing address __________________________________________________________
			City ___________________________	State ______	Zip code ________________
			
			This is a legally binding instrument between ADHI Schools, LLC sometimes referred to in this document as �??the firm�?� or �??the school�?� or �??we�?� and the above named party, hereafter referred to as �??the student�?� or �??you�?�.  This document is intended to have a binding effect, please read slowly and carefully.  This document will confirm that you are enrolling in Real Estate Practice - Correspondence offered by ADHI Schools, LLC.  You understand that your enrollment in this course does not provide you with any classroom instruction.  To complete this course, you will be required to spend a minimum of eighteen (18) days with the material and complete a 100 question, multiple choice, open-book final examination.  The Department of Real Estate has approved this course as a correspondence course.  
			
			Information regarding the 100 question final exam
			
			During our 100 question multiple choice examination, you may refer to the instructional material supplied to you through the course.  A passing score on this exam is 60 percent or better.  You will be given 2 hours and 30 minutes to complete this examination.  Final examinations are either administered at one of our school locations during class time or by designated proctor.  If the student decides to take the examination in the firm�??s environment, the student should know that they are administered every class session by an employee of the school in an area separate from the classroom.  Currently, Department of Real Estate guidelines dictate that you must wait a minimum of eighteen (18) days from the date of receipt of materials before taking the final exam.  Upon passing the final exam you will receive a certificate of completion issued by the school.  If you pass this examination the transcript of completion will be mailed to the student within 72 hours of grading.  Reading the provided text will obviously prove useful in completing this examination, so make use of the textbook that is provided to you!
			
			Once again, the final examination may also be administered by a proctor who cannot be related to you by blood, marriage, domestic partnership or any other relationship that would impair the ability of the proctor to fairly administer the exam.  We will mail this examination to the proctor, not to your address.  The proctor will be required to sign a form indicating that they administered the examination and must return your answer sheet and the final exam to our headquarters.  If we do not get the final exam back we will not issue a certificate to you for this course!  We take the integrity of our material very seriously and cannot run the risk of our exams floating around.  Under NO circumstances will the final exam be given directly to the student. 
			
			In the event the student fails the final exam, the student may retake the test until they pass for no additional cost.  However, in the event of a failed examination the student must wait another eighteen (18) days from the date they last took the examination before they are allowed to retest.  The objective here is to learn and retain as much about the subject matter as possible.
			
			No legal advice given
			
			Throughout this course you will learn about various aspects of real estate.  It is the intention of the course and the firm to provide each student with up-to-date, timely and accurate information.  However, the firm is not a legal one and our instructors are not attorneys.  As such, none of the information disseminated should be relied upon as legal advice of any kind.  Please consult your tax and legal advisors if you desire tax or legal advice.  Also note that the Department of Real Estate has a website www.dre.ca.gov and on this site there is a form you may download to evaluate the course as a whole.
			
			Cost of the course and what it includes 
			
			The cost of the course is $129.00 payable by cash, check, money order or credit card.  The student also agrees to pay ten ($10) dollars for shipping and handling charges to wherever the materials are sent.  This entitles you to a two (2) year enrollment.  This includes the text book, the administration of the final exam, the grading of that final exam, fifteen (15) ungraded chapter quizzes, and the issuance of your Real Estate  Practice  certificate, provided the course is completed within our two (2) year time frame.  You are advised that the possession of a certificate of completion from this class alone does not allow you to act as a real estate salesperson.  The student understands that in the event they write a check returned marked �??NSF�?� the student will be charged a $20.00 processing fee for such.
			
			Refund and cancellation policy
			
			The student shall be entitled seven (7) calendar days from the date of enrollment to request a refund.  If a refund is requested, the school will refund all monies received with the exception of a $25.00 processing fee.  The textbook must also be returned to the school in unused condition.  Return shipping is the responsibility of the student.  If the school determines that unusual wear and tear has occurred with the textbook, or the text has been written in, the school will (in addition to the $25.00 processing fee) retain $39.95 for the textbook.  All refunds will be mailed to the student within ten (10) days of receiving the request.  No refunds will be issued after the seven (7) calendar days have lapsed.  In lieu of a refund, the student may transfer the enrollment to another party within thirty (30) days of the date of enrollment. In the event of transfer, the transferee must sign a new enrollment agreement and you must sign a form indicating that you wish to transfer this enrollment.   Once thirty (30) days have passed, no refunds or transfers will be allowed.  All refunds will be made by business check to the student named above, regardless of who wrote the check or method of payment.
			
			All refund requests must be made in writing to the above address and be postmarked no later than seven (7) days from the date of enrollment.
			
			Course approval from the Department of Real Estate
			
			The course is approved by the California Department of Real Estate and has been issued approval number 2079-04.
			
			Errors or omissions in the textbook
			
			ADHI Schools believes that the materials are published in good faith.  The textbook is published by Dearborn Publishing.  ADHI Schools is not responsible and will accept no responsibility for errata in any of the textbooks, review materials or study aids provided or sold to the student.
			
			My signature below confirms that I have been given a reasonable amount of time to make a decision as to my enrollment in the course and all my questions regarding the course have been answered.  I have read and understand all of the above including the refund and cancellation policy of the school.  If paying by credit card, my signature below authorizes the school to charge the card the amount indicated on this contract, and I agree to abide by the terms of my cardholder agreement.
			
			By ______________________					Payment method:   cash    check     cc
					   Student signature						Card number: _______________________
													Type of card:  VISA   M/C   AMEX   DISC
			__________________________ (Printed name)				Expiration date: _________
			
			
			</textarea>
						</div>	
						<div  class="filedforterm"  >
						<input type="checkbox" name="agree<?php echo $courses_o['id']; ?>" id="agree<?php echo $courses_o['id']; ?>" value="<?php echo $courses_o['id']; ?>" onClick="javascript:show_radio_check_opt(this.value,document.course.elements['course_b']),checkrate();">I Agree  <input type="checkbox" name="disagree<?php echo $courses_o['id']; ?>" id="disagree<?php echo $courses_o['id']; ?>" value="<?php echo $courses_o['id']; ?>" onClick="javascript:show_radio_uncheck_opt(this.value,document.course.elements['course_b']),checkrate();" > I Don't Agree 
						</div>	
				   </div>
				  <div class="clearboth"></div>
		
	     <!--End Terms and condition For Principle-->
	   
			
			
			 <?php } ?>
	  	<?php  }?>
	  <!--End Bottom Course Listing For Sales-->

		<div class="clearboth">&nbsp;</div>
		<div class="subhead_txt">The candidates can select shipping method from one of the below</div>
		<div class="clearboth">&nbsp;</div>
		<div  class="filedforrate" id="shipbutton" style="display:block"  >
			<img  src="<?php  echo $this->config->item('images');?>/innerpages/show_ship.jpg" onclick="javascript:checkshipmethod();" class="stylebutton"  />
		</div>
		<div id="mygif"  style="display:none;"></div>				
		<div  class="filedforrate" id="showship" style="display:none;" ></div>
		
		<div class="clearboth">&nbsp;</div>
      <div  class="filedforrate">
        <input type="hidden" name="price"  id="price"  value="0" />
        <input type="hidden" name="shipprice"  id="shipprice"  value="0" />
        <input type="hidden" name="totalprice"  id="totalprice"  value="0" />
		
      </div>
    <div class="clearboth"></div>
    <!--total weight -->
	      <div  class="filedforrate"> 
        <input type="hidden" name="totalweight"  id="totalweight"  value="0" />
        
        <input type="hidden" name="totalweightb"  id="totalweightb"  value="0" />
        <input type="hidden" name="subcourseweight" id="subcourseweight" value="0"  />
		<input type="hidden" name="curyear"  id="curyear"  value="<?php echo date('Y');?>" />
		<input type="hidden" name="curmonth"  id="curmonth"  value="<?php echo date('m');?>" />

       
      </div>
 
    <div style="clear:both;"></div>
    <div   style="width:350px;" >
      <div  class="filedforrate " id="carttotal">
        <div  class="filedforrate page_error" >Course Price -&nbsp;$</div>
        <div  class="filedforrate page_error" id="cartcourseprice"> 0 </div>
        <div style="clear:both;">&nbsp;</div>
        <div  class="filedforrate page_error">Ship Rate   -&nbsp;$ </div>
        <div  class="filedforrate page_error" id="cartshiprate"> 0 </div>
        <div style="clear:both;">&nbsp;</div>
        <div  class="filedforrate page_error">Total Price - &nbsp;$</div>
        <div  class="filedforrate page_error" id="carttotalprice"> 0 </div>
      </div>
    </div>
	 <div class="clearboth">&nbsp;</div>
	 <div class="subhead_txt">Please Enter Payment Details Here</div>
	 <div class="clearboth">&nbsp;</div>
		  <div class="contents_registermain" >
		  <div class="leftside_register">Credit Card Type<span class="red_star">*</span> </div>
		 <div class="middlecolon_register">:</div>
		  <div class="rightsidedata_register">
			<select name="cardtype" id="cardtype" onchange="javascript:isCreditCard();"  >
			  <option value="">Select</option>
			  <option value="Visa" <?php if(set_value('cardtype')=='Visa'){?> selected="selected" <?php }?>>Visa</option>
			  <option value="MasterCard" <?php if(set_value('cardtype')=='MasterCard'){?> selected="selected" <?php }?>>MasterCard</option>
			  <option value="Amex" <?php if(set_value('cardtype')=='Amex'){?> selected="selected" <?php }?>>American Express</option>
			   <option value="Discover" <?php if(set_value('cardtype')=='Discover'){?> selected="selected" <?php }?>>Discover</option>
			</select>
		  </div>
   <div class="floatleft">
   <img  src="<?php  echo $this->config->item('images');?>/innerpages/visa.jpg" />
   <img  src="<?php  echo $this->config->item('images');?>/innerpages/mastercard.jpg" />
   <img  src="<?php  echo $this->config->item('images');?>/innerpages/amex.jpg" />
   <img  src="<?php  echo $this->config->item('images');?>/innerpages/discover.jpg" />  
   </div>
		<div class="clearboth"></div>
	
		<div class="leftside_register">Credit Card No <span class="red_star">*</span></div>
		<div class="middlecolon_register">:</div>
		<div class="rightsidedata_register">
		<input  type="text" name="ccno"  id="ccno" value="<?php echo set_value('ccno'); ?>" maxlength="30" size="25"/>
		</div>
		<div class="clearboth"></div>
		<div class="leftside_register">CVV2 No <span class="red_star">*</span></div>
		<div class="middlecolon_register">:</div>
		<div class="rightsidedata_register">
		<input  type="text" name="cvv2no"  id="cvv2no" value="<?php echo set_value('cvv2no'); ?>" maxlength="10" size="25"/>
		</div>
		<div class="clearboth"></div>
		<div class="leftside_register">Expiration Date<span class="red_star">*</span> </div>
		<div class="middlecolon_register">:</div>
		<div class="rightsidedata_register">
		<select name="expmonth" id="expmonth" >
		<?php echo  $i=1; foreach($month as $month){ ?>
		<option value="<?php echo $i; ?>" <?php if(set_value('expmonth')==$i){?> selected="selected" <?php }?>><?php echo $month; ?></option>
		<?php $i++; } ?>
		</select>
		<select name="expyear" id="expyear" >
		<?php foreach($year as $year){ ?>
		<option value="<?php echo $year; ?> "<?php if(set_value('expyear')==$year){?> selected="selected" <?php }?>><?php echo $year; ?></option>
		<?php  } ?>
		</select>
		</div>
		  </div>
	     <!--contents_registermain end -->
		 <div class="clearboth">&nbsp;</div>
		 <div class="middlebutton">			
			<img  src="<?php  echo $this->config->item('images');?>/innerpages/sub_btn.jpg" onclick="javascript:addnewcourses();" class="stylebutton" /><span  id="newimg" style="display:none;"></span>
			</div>
		<div class="clearboth">&nbsp;</div>
		</div>
        <!--listregisterdata end -->
      </div>
      <!--profileinnerregistercontentdiv end -->
    </div>
  </div>
</div>
</form>
