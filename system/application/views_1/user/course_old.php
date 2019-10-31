<?php echo form_open("user/courseadd",array('name'=>'course','id'=>'course'));  ?>

<div class="registermaindiv">
	<div class="registerinnerdiv">
<div class="clearboth">&nbsp;</div>
	 	<div  class="form-fields head_txt"> REGISTRATION : <span class="steps">STEP 2</span></div>
	 	<div class="clearboth">&nbsp;</div>
	 	<div  class="page_error" id="errordiv" ><?php if(isset($msg)) echo $msg; 
	 							if($this->session->userdata('msg')){
								
								echo $this->session->userdata('msg');
								$this->session->unset_userdata ('msg');
								}
								echo validation_errors(); 
								?></div>
	  	
		<div class="clearboth">&nbsp;</div>
	<div  class="filed" ><input  type="hidden" name="bphone" id="bphone" value="<?php if(isset($phone))echo $phone;?>" /></div>
	
<fieldset style="width:90%">
   			<legend class="subhead_txt">Billing Address</legend>
	
	  	
	 	 <div class="clearboth">&nbsp;</div>
	 	<div   id="billing"  style="display:block; width:845px;">
	    	<div  class="filed">Address<span class="red_star">*</span></div>
	      	<div  class="filed-right"><input type="text" name="b_address" id="b_address"  size="30" value="<?php echo set_value('b_address'); ?>" onblur="javascript:checkrate1(); "/></div>
		 	<div  class="filed">State<span class="red_star">*</span></div>
	      	<div  class="filed-right">
		        <select name="b_state"  id="b_state" onchange="javascript:checkrate1();">
		          <option value="">Select</option>
		          <?php 
						foreach($state as $state1){?>
		          <option value="<?php echo $state1['state_code'];?>"  <?php if(set_value('b_state')==$state1['state_code']){?> selected="selected" <?php } ?>><?php echo $state1['state'];?></option>
		          <?php }?>
		        </select>
	     	</div>
	     	<div class="clearboth">&nbsp;</div>
		 	<div  class="filed">Country</div>
	      	<div  class="filed-right">
		      
				<label id="lblcountry">United States</label><input type="hidden" name="b_country" id="b_country" value="US">
		     </div>
	    	<div  class="filed">City<span class="red_star">*</span></div>
		    <div  class="filed-right"><input type="text" name="b_city" id="b_city"  size="30" value="<?php echo set_value('b_city'); ?>" onblur="javascript:checkrate1(); "/></div>
		    <div class="clearboth">&nbsp;</div>
		  	<div  class="filed">Zipcode<span class="red_star">*</span></div>
		    <div  class="filed-right"><input type="text" name="b_zipcode" id="b_zipcode"  size="20" value="<?php echo set_value('b_zipcode'); ?>" onblur="javascript:checkrate1(); "/></div>
		<div style="clear:both;"></div>
		 	<div  class="filed">&nbsp;</div><div  class="filed-right"><span class="instruction">Zipcode must be 5 or 9 digits</span></div>
		</div>
			<div class="clearboth">&nbsp;</div>
		</fieldset>
		
	  	<div class="clearboth">&nbsp;</div>
		<fieldset style="width:90%">
   			<legend class="subhead_txt">Shipping Address</legend>

	 
	   	<div class="clearboth">&nbsp;</div>
	  	<div  class="checkboxtext"><input type="checkbox" name="ssame" id="ssame"    onclick="javascript:checkshipping(),checkrate1();" />Shipping Address is same as Billing Address </div>
	 	<div class="clearboth">&nbsp;</div>
	  	<div   id="shipping" style="display:block;width:845px;" >
	    	<div  class="filed">Address<span class="red_star">*</span></div>
	      	<div  class="filed-right"><input type="text" name="s_address" id="s_address"  size="30" value="<?php echo set_value('s_address'); ?>" onblur="javascript:checkrate1(); "/></div>
		  	<div  class="filed">State<span class="red_star">*</span></div>
	     	<div  class="filed-right">
		        <select name="s_state"  id="s_state"  onchange="javascript:checkrate();" >
		          <option value="">Select</option>
		          <?php 
						foreach($state as $state2){?>
		          <option value="<?php echo $state2['state_code'];?>"  <?php if(set_value('s_state')==$state2['state_code']){?> selected="selected" <?php } ?>><?php echo $state2['state'];?></option>
		          <?php }?>
		        </select>
	     	</div>
	     	<div class="clearboth">&nbsp;</div>
		    <div  class="filed">Country</div>
	      	<div  class="filed-right">
				<label id="lblcountry">United States</label><input type="hidden" name="s_country" id="s_country" value="US">
		    </div>
	     	<div  class="filed">City<span class="red_star">*</span></div>
	     	<div  class="filed-right"><input type="text" name="s_city" id="s_city"  size="30" value="<?php echo set_value('s_city'); ?>" onblur="javascript:checkrate1(); "/></div>
		  	<div class="clearboth">&nbsp;</div>
	   		<div  class="filed">Zipcode<span class="red_star">*</span></div>
	      	<div  class="filed-right"><input type="text" name="s_zipcode" id="s_zipcode"  size="20" value="<?php echo set_value('s_zipcode'); ?>" onblur="javascript:checkrate1(); "/></div>
				<div style="clear:both;"></div>
		 	<div  class="filed">&nbsp;</div><div  class="filed-right"><span class="instruction">Zipcode must be 5 or 9 digits</span></div>

		</div>
		<div class="clearboth">&nbsp;</div>
		</fieldset>
		<div class="clearboth">&nbsp;</div>
  <div  class="form-fields head_txt"> COURSE LIST </div>
   <div  class="form-fields subhead_txt" id="disperror"></div>
   <div class="clearboth">&nbsp;</div>
	  <!--Courses For Sales-->
	    	
     <?php if($license == 'S'){?>	
	 <fieldset style="width:80%">
			<legend class="subhead_txt">The following courses are required </legend>
		<!--Mandatory Courses-->	 
	   <?php foreach($courses_m as $courses_m){ ?>
	  <div  class="filedforrate"  >
		<div  class="filedforrate" >
		  <input type="hidden" name="courseprice<?php echo $courses_m['id']; ?>" id="courseprice<?php echo $courses_m['id']; ?>" value="<?php echo $courses_m['amount']; ?>"  />
		  <input type="checkbox" class="scheck" name="course[]" id="course<?php echo $courses_m['id']; ?>" value="<?php echo $courses_m['id']; ?>" onClick="javascript:showsub(this.value), showterms(this.value), checkrate();"  />
		  <?php if($courses_m['amount'] !=0.00){
		echo $courses_m['course_name'] ." -  $".$courses_m['amount']; 
		  }
		  else
		  echo $courses_m['course_name'] ; 
		  ?>
		 <?php if($courses_m['id'] !=5) ?>
		  <input type="hidden" name="courseweight<?php echo $courses_m['id']; ?>" id="courseweight<?php echo $courses_m['id']; ?>" value="<?php echo $courses_m['wieght']; ?>"  />
		 </div>
	  </div>
	  
	    <!--Terms and condition-->
		<?php  if($courses_m['id'] != 5){?>
		 <div class="clearboth">&nbsp;</div> 
				   <div class="filedforrate" id="showdiv<?php echo $courses_m['id']; ?>" style="display:none;" >
						<div  class="filedforrate" style="height:60px;" >
						<textarea class="textarea_txt"  rows="3" cols="40">					ADHI Schools, LLC
			Voice: 888 768 5285 Fax: 800 598 3258
			5000 Birch St. �?? West Tower - Suite 3000 - Newport Beach, CA 92660
			
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
						<div class="clearboth">&nbsp;</div> 
						<div  class="filedforrate" style="height:20px;" >
						<input type="checkbox" name="agree<?php echo $courses_m['id']; ?>" id="agree<?php echo $courses_m['id']; ?>" value="<?php echo $courses_m['id']; ?>" onclick="javascript:checkagree(this.value);">I Agree  <input type="checkbox" name="disagree<?php echo $courses_m['id']; ?>" id="disagree<?php echo $courses_m['id']; ?>" value="<?php echo $courses_m['id']; ?>" onclick="javascript:checkdisagree(this.value);"  /> I Don't Agree 
						</div>	
				   </div>
				   <div class="clearboth">&nbsp;</div> 
		<?php } ?>		   
	     <!--End Terms and condition-->
	   
	  <?php  if($courses_m['id'] == 5){?>
	  <div class="clearboth">&nbsp;</div>
	 	  <div id="shodiv" style="display:block;" >
	  	 <input  type="hidden"  name="subcourseprice"  id="subcourseprice" value="0" />
		<?php foreach($subcourses as $subcourses){ ?>
			<div  class="filedforrate" >
			  <div  class="filedforrate" >
			  <input  type="hidden"  name="subprice<?php echo $subcourses['id']; ?>" id="subprice<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['amount']; ?>" />
				<input  type="radio" class="subcheck"  name="subcourse" id="subcourse" value="<?php echo $subcourses['id']; ?>" onclick="javascript:showterms_sopt(this.value,document.course.elements['subcourse']),checkrate();"/>
			
				<?php echo $subcourses['course_name'] ." - $".$subcourses['amount']; ?>
				 <input type="hidden" name="courseweight<?php echo $subcourses['id']; ?>" id="courseweight<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['wieght']; ?>"  />
				 
			 </div>
			</div>
			<div class="clearboth">&nbsp;</div>
				  <!--Terms and condition-->
		
				   <div  class="filedforrate" id="showdiv<?php echo $subcourses['id']; ?>" style="display:none;" >
						<div  class="filedforrate" style="height:60px;" >
						<textarea class="textarea_txt"  rows="3" cols="40">			ADHI Schools, LLC
			Voice: 888 768 5285 Fax: 800 598 3258
			5000 Birch St. �?? West Tower - Suite 3000 - Newport Beach, CA 92660
			
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
						<div class="clearboth">&nbsp;</div>
						<div  class="filedforrate" style="height:20px;" >
						<input type="checkbox" name="agree<?php echo $subcourses['id']; ?>" id="agree<?php echo $subcourses['id']; ?>"  value="<?php echo $subcourses['id']; ?>" onclick="javascript:checksubagree(this.value,document.course.elements['subcourse']);">I Agree  <input type="checkbox" name="disagree<?php echo $subcourses['id']; ?>" id="disagree<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['id']; ?>"   onclick="javascript:checksubdisagree(this.value,document.course.elements['subcourse']);"> I Don't Agree 
						</div>	
				   </div>
				   <div class="clearboth">&nbsp;</div>
			   
	     <!--End Terms and condition-->
			
			
			
			
		  <?php } ?>			
	
	  </div>
	  <?php } ?>
 	<div class="clearboth">&nbsp;</div>
     <?php } ?>
	 <!--Mandatory Courses-->	
	 </fieldset>
  	<?php  }?>
	
	 <!--End Courses For Sales-->
	 	 
	 
	  <!--Courses For Brokers-->
	<?php if($license == 'B'){ $j=0;?>
	 <fieldset style="width:80%">
			<legend class="subhead_txt">The following courses are required </legend>
	
		<!--Mandatory Courses-->	 
	   <?php foreach($courses_m as $courses_m){ $j = $j+1; ?>
	 	 <?php  if($j == 6){ ?></fieldset>
		 <div class="clearboth">&nbsp;</div>
		  <fieldset style="width:80%">
			<legend class="subhead_txt">Choose three from the bottom list </legend>
		
		 <?php } ?>
	  <div  class="filedforrate" >
		<div  class="filedforrate" >
		
				<input type="hidden" name="courseprice<?php echo $courses_m['id']; ?>" id="courseprice<?php echo $courses_m['id']; ?>" value="<?php echo $courses_m['amount']; ?>" onClick="javascript:showsub(this.value), showterms(this.value);"  />

		  <input type="checkbox" class="scheck" name="course[]" id="course<?php echo $courses_m['id']; ?>" value="<?php echo $courses_m['id']; ?>" onClick="javascript:showsub(this.value), showterms(this.value),checkrate();"  />
		  <?php if($courses_m['amount'] !=0.00){
		echo $courses_m['course_name'] ." -  $".$courses_m['amount']; 
		  }
		  else
		  echo $courses_m['course_name'] ; 
		  ?>
		  <?php if($courses_m['id'] !=5) ?>
		  <input type="hidden" name="courseweight<?php echo $courses_m['id']; ?>" id="courseweight<?php echo $courses_m['id']; ?>" value="<?php echo $courses_m['wieght']; ?>"  />
		 </div>
	  </div>
		<div class="clearboth">&nbsp;</div> 
		 
	    <!--Terms and condition-->
		<?php  if($courses_m['id'] != 5){?>
				   <div class="filedforrate" id="showdiv<?php echo $courses_m['id']; ?>" style="display:none;" >
						<div  class="filedforrate" style="height:60px;" >
						<textarea class="textarea_txt"  rows="3" cols="40">					ADHI Schools, LLC
			Voice: 888 768 5285 Fax: 800 598 3258
			5000 Birch St. �?? West Tower - Suite 3000 - Newport Beach, CA 92660
			
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
						<div class="clearboth">&nbsp;</div>
						<div  class="filedforrate" style="height:20px;" >
						<input type="checkbox" name="agree<?php echo $courses_m['id']; ?>" id="agree<?php echo $courses_m['id']; ?>" value="<?php echo $courses_m['id']; ?>" onclick="javascript:checkagree(this.value);">I Agree  <input type="checkbox" name="disagree<?php echo $courses_m['id']; ?>" id="disagree<?php echo $courses_m['id']; ?>" value="<?php echo $courses_m['id']; ?>" onclick="javascript:checkdisagree(this.value);"  /> I Don't Agree 
						</div>	
				   </div>
				   <div class="clearboth">&nbsp;</div>
		<?php } ?>		   
	     <!--End Terms and condition-->
	   
	   <!--List Sub Courses For Principle-->
	  <?php  if($courses_m['id'] == 5){?>
	  <div id="shodiv" style="display:block;" >
	 
	  	 <input  type="hidden"  name="subcourseprice"  id="subcourseprice" value="0" />
		<?php foreach($subcourses as $subcourses){ ?>
		
			<div  class="filedforrate"  >
			  <div  class="filedforrate" >
			  <input  type="hidden"  name="subprice<?php echo $subcourses['id']; ?>" id="subprice<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['amount']; ?>" />
				<input  type="radio" class="subcheck"  name="subcourse" id="subcourse" value="<?php echo $subcourses['id']; ?>" onclick="javascript:showterms_sopt(this.value,document.course.elements['subcourse']),checkrate();"/>
			
				<?php echo $subcourses['course_name'] ." - $".$subcourses['amount']; ?>
				<input type="hidden" name="courseweight<?php echo $subcourses['id']; ?>" id="courseweight<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['wieght']; ?>"  />
			 </div>
			</div>
			 <div class="clearboth">&nbsp;</div>
				  <!--Terms and condition-->
		
				   <div  class="filedforrate" id="showdiv<?php echo $subcourses['id']; ?>" style="display:none;" >
						<div  class="filedforrate" style="height:60px;" >
						<textarea class="textarea_txt"  rows="3" cols="40">			ADHI Schools, LLC
			Voice: 888 768 5285 Fax: 800 598 3258
			5000 Birch St. �?? West Tower - Suite 3000 - Newport Beach, CA 92660
			
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
						<div class="clearboth">&nbsp;</div>
						<div  class="filedforrate" style="height:20px;" >
						<input type="checkbox" name="agree<?php echo $subcourses['id']; ?>" id="agree<?php echo $subcourses['id']; ?>"  value="<?php echo $subcourses['id']; ?>" onclick="javascript:checksubagree(this.value,document.course.elements['subcourse']);">I Agree  <input type="checkbox" name="disagree<?php echo $subcourses['id']; ?>" id="disagree<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['id']; ?>"   onclick="javascript:checksubdisagree(this.value,document.course.elements['subcourse']);"> I Don't Agree 
						</div>	
				   </div>
				   <div class="clearboth">&nbsp;</div>
			   
	     <!--End Terms and condition-->
			
			
			
			
		  <?php } ?>			
	
	  </div>
	  <?php } ?>
	    <!--End List Sub Courses For Principle-->
	  
	  
 	<div class="clearboth">&nbsp;</div>
     <?php } ?>
	 <!--Mandatory Courses-->	
	 </fieldset>
  	<?php  }?>
	 <!--Courses For Brokers-->
	 
	 
	 

	 
	 <!--Bottom Course Listing For Sales-->
	  <?php if($license == 'S'){?>
	  <div class="clearboth">&nbsp;</div>
	  <fieldset style="width:80%">
   			<legend class="subhead_txt">The candidates can pick from one of the below</legend>
			
			 <input type="hidden" name="s_courseprice" id="s_courseprice" value="0"  />
			 <?php foreach($courses_o as $courses_o){ ?>
			  <div  class="filedforrate"  >
				<div  class="filedforrate" >
				  <input type="hidden" name="courseprice<?php echo $courses_o['id']; ?>" id="courseprice<?php echo $courses_o['id']; ?>" value="<?php echo $courses_o['amount']; ?>"  />
				  <input type="radio"  class="bcheck" name="course_b" id="course_b" value="<?php echo $courses_o['id']; ?>" onClick="javascript:showsub(this.value), showterms_opt(this.value,document.course.elements['course_b']),checkrate();"     />
				  <?php echo $courses_o['course_name'] ." - $".$courses_o['amount']; ?>
				  <?php if($courses_o['id'] !=5) ?>
				  <input type="hidden" name="courseweight_b<?php echo $courses_o['id']; ?>" id="courseweight_b<?php echo $courses_o['id']; ?>" value="<?php echo $courses_o['wieght']; ?>"  />
				 </div>
			  </div>
			<div class="clearboth">&nbsp;</div>
			
			
			
			  <!--Terms and condition For Principle-->
	
				   <div class="filedforrate" id="showdiv<?php echo $courses_o['id']; ?>" style="display:none;" >
						<div  class="filedforrate" style="height:60px;" >
						<textarea class="textarea_txt"  rows="3" cols="40">				ADHI Schools, LLC
			Voice: 888 768 5285 Fax: 800 598 3258
			5000 Birch St. �?? West Tower - Suite 3000 - Newport Beach, CA 92660
			
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
						<div class="clearboth">&nbsp;</div>
						<div  class="filedforrate" style="height:20px;" >
						<input type="checkbox" name="agree<?php echo $courses_o['id']; ?>" id="agree<?php echo $courses_o['id']; ?>" value="<?php echo $courses_o['id']; ?>" onclick="javascript:check_sagree(this.value,document.course.elements['course_b']),checkrate();">I Agree  <input type="checkbox" name="disagree<?php echo $courses_o['id']; ?>" id="disagree<?php echo $courses_o['id']; ?>" value="<?php echo $courses_o['id']; ?>" onclick="javascript:check_disagree(this.value,document.course.elements['course_b']),checkrate();" > I Don't Agree 
						</div>	
				   </div>
				  <div class="clearboth">&nbsp;</div>
		
	     <!--End Terms and condition For Principle-->
	   
			
			
			 <?php } ?>
			 </fieldset>
	  	<?php  }?>
	  <!--End Bottom Course Listing For Sales-->
	  
	  
	 
	
	<!--List Shipping Method-->
	
	<div class="clearboth">&nbsp;</div>
	<fieldset style="width:80%">
   			<legend class="subhead_txt">The candidates can select shipping method from one of the below</legend>
		<div class="clearboth">&nbsp;</div>
		<div  class="filedforrate"  >
			<div  class="filedforrate" id="shipbutton" style="display:block"  >
			<input  type="button" name="reloadship" id="reloadship"  value="Show Ship Method" onclick="javascript:checkshipmethod();"/>
			
			</div>
			<div id="mygif"  style="display:none;"></div>
		</div>
		<div  class="filedforrate" >
			<div  class="filedforrate" id="showship" style="display:none;" >&nbsp;</div>
		</div>
		<div class="clearboth">&nbsp;</div>
	</fieldset>
	  <div  class="form-fields" >
	  <div  class="filedforrate">
	  	<input type="hidden" name="price"  id="price"  value="0" />
		<input type="hidden" name="shipprice"  id="shipprice"  value="0" />
		<input type="hidden" name="totalprice"  id="totalprice"  value="0" />
	  </div>
	</div>
	
<div class="clearboth">&nbsp;</div>
	<!--total weight -->
	<div  class="form-fields" >
	  <div  class="filedforrate">
		M<input type="text" name="totalweight"  id="totalweight"  value="0" />
		O<input type="text" name="totalweightb"  id="totalweightb"  value="0" />
		<input type="hidden" name="subcourseweight" id="subcourseweight" value="0"  />
		<input  type="hidden" name="step2"  id="step2" value="2" />
	  </div>
	</div>
	<div style="clear:both;"></div>
	<!--end total weight -->
	<!-- cart Total-->
	<fieldset style="width:350px">
   			<legend class="subhead_txt">Cart Total</legend>
		<div   style="width:350px;" >
		  <div  class="filedforrate " id="carttotal">
		  <div  class="filedforrate page_error" >Course Price -&nbsp;$</div> <div  class="filedforrate page_error" id="cartcourseprice"> 0 </div>
			<div style="clear:both;">&nbsp;</div>
		   <div  class="filedforrate page_error">Ship Rate   -&nbsp;$ </div><div  class="filedforrate page_error" id="cartshiprate"> 0 </div>
		   	<div style="clear:both;">&nbsp;</div>
		   <div  class="filedforrate page_error">Total Price - &nbsp;$</div><div  class="filedforrate page_error" id="carttotalprice"> 0 </div>

		  </div>
	</div>
	</fieldset>
	<div style="clear:both;"></div>

	<!-- end cart totals-->
	<!--End List Shipping Method--> 
	
	<!--Paypal Payment Method-->
			<div class="clearboth">&nbsp;</div>
		<fieldset style="width:80%">
   			<legend class="subhead_txt">Please Enter Payment Details Here</legend>
	
	<div class="clearboth">&nbsp;</div>
	<div  class="filedforrate" style="height:20px;" >
	  <div  class="filedforrate">Credit Card Type<span class="red_star">*</span>  </div>
	  <div  class="filed-right">
	  <select name="cardtype" id="cardtype"  onchange="javascript:isCreditCard();">
	   <option value="">Select</option>
	  <option value="VISA">Visa</option>
	  <option value="MC">MasterCard</option>
	  <option value="AMEX">American Express</option>
	  </select>
	    </div>
	</div>
	<div class="clearboth">&nbsp;</div>
	

	  <div  class="filed">Credit Card No <span class="red_star">*</span></div>
	  <div  class="filed-right">
	  <input  type="text" name="ccno"  id="ccno" value="" maxlength="30" size="40"/>
	   </div>
	
	<div class="clearboth">&nbsp;</div>
	
	
	  <div  class="filedforrate">Expire Month & Year<span class="red_star">*</span> </div>
	  <div  class="filed-right">
	  <select name="expmonth" id="expmonth" >
	   <?php echo  $i=1; foreach($month as $month){ ?>
	     <option value="<?php echo $i; ?>"><?php echo $month; ?></option>
	   <?php $i++; } ?>
	  
	 </select>
	 <select name="expyear" id="expyear" >
	   <?php foreach($year as $year){ ?>
	     <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
	   <?php  } ?>
	  
	 </select>
	   </div>
	<div class="clearboth">&nbsp;</div>

	  <div  class="filed">CVV2 No <span class="red_star">*</span></div>
	  <div  class="filed-right">
	  <input  type="text" name="cvv2no"  id="cvv2no" value="" maxlength="10" size="15"/>
	   </div>
</fieldset>
	<div class="clearboth">&nbsp;</div>

	
	<!--List Paypal Payment Method-->
	
	 
	 <div  class="form-fields" style="height:20px;" >
	  <div  class="filed-right">
		<input type="button" name="Submit"  value="Submit" onClick="javascript:addcourses();"/>
	  </div>
	</div>
	<div class="clearboth">&nbsp;</div>
	   <div  class="filed-right"><span class="instruction">Marked with </span><span class="red_star">*</span> <span class="instruction">are mandatory fields</span></div>

</div>
</div>
</form>
