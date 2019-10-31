<?php 
	if($license == 'B'){ 
	 if($courses_mb !=false){
	?>
  	
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
		<div class="clearboth">&nbsp;</div> 
		 
	    <!--Terms and condition-->
		<?php  if($courses_mb['child_cnt'] ==0){?>
				   <div class="filedforrate" id="showdiv<?php echo $courses_mb['id']; ?>" style="display:none;" >
						<div  class="filedforrate"  >
						<textarea class="textarea_txt"  rows="5" cols="50">
                                                    <?php $this->load->view('reskin/register/terms_and_conditions') ;?>					
                        <!--ADHI Schools, LLC
			Voice: 888 768 5285 Fax: 800 598 3258
			5000 Birch St. �?? West Tower - Suite 3000 - Newport Beach, CA 92660
			
			Enrollment Agreement/General Information Page
												Date ____________________		
			Name _________________________________________________
			Telephone number ________________
			Mailing address __________________________________________________________
			City ___________________________	State ______	Zip code ________________
			
			This is a legally binding instrument between ADHI Schools, LLC sometimes referred to in this document as �??the firm�?� or �??the school�?� or �??we�?� and the above named party, hereafter referred to as �??the student�?� or �??you�?�.  This document is intended to have a binding effect, please read slowly and carefully.  This document will confirm that you are enrolling in Real Estate Practice - Correspondence offered by ADHI Schools, LLC.  You understand that your enrollment in this course does not provide you with any classroom instruction. To complete this course, you will be required to spend a minimum of 45 hours and eighteen (18) calendar days per course with the material and complete a 100 question, multiple choice, open-book final examination.  The Bureau of Real Estate has approved this course as a correspondence course.
			
			Information regarding the 100 question final exam
			
			During our 100 question multiple choice examination, you may refer to the instructional material supplied to you through the course.  A passing score on this exam is 60 percent or better.  You will be given 2 hours and 30 minutes to complete this examination.  Final examinations are either administered at one of our school locations during class time or by designated proctor.  If the student decides to take the examination in the firm�??s environment, the student should know that they are administered every class session by an employee of the school in an area separate from the classroom.  Currently, Bureau of Real Estate guidelines dictate that you must wait a minimum of eighteen (18) days from the date of receipt of materials before taking the final exam.  Upon passing the final exam you will receive a certificate of completion issued by the school.  If you pass this examination the transcript of completion will be mailed to the student within 72 hours of grading.  Reading the provided text will obviously prove useful in completing this examination, so make use of the textbook that is provided to you!
			
			Once again, the final examination may also be administered by a proctor who cannot be related to you by blood, marriage, domestic partnership or any other relationship that would impair the ability of the proctor to fairly administer the exam.  We will mail this examination to the proctor, not to your address.  The proctor will be required to sign a form indicating that they administered the examination and must return your answer sheet and the final exam to our headquarters.  If we do not get the final exam back we will not issue a certificate to you for this course!  We take the integrity of our material very seriously and cannot run the risk of our exams floating around.  Under NO circumstances will the final exam be given directly to the student. 
			
			In the event the student fails the final exam, the student may retake the test until they pass for no additional cost.  However, in the event of a failed examination the student must wait another eighteen (18) days from the date they last took the examination before they are allowed to retest.  The objective here is to learn and retain as much about the subject matter as possible.
			
			No legal advice given
			
			Throughout this course you will learn about various aspects of real estate.  It is the intention of the course and the firm to provide each student with up-to-date, timely and accurate information.  However, the firm is not a legal one and our instructors are not attorneys.  As such, none of the information disseminated should be relied upon as legal advice of any kind.  Please consult your tax and legal advisors if you desire tax or legal advice.  Also note that the Bureau of Real Estate has a website www.calbre.ca.gov and on this site there is a form you may download to evaluate the course as a whole.
			
			Cost of the course and what it includes 
			
			The cost of the course is $129.00 payable by cash, check, money order or credit card.  The student also agrees to pay ten ($10) dollars for shipping and handling charges to wherever the materials are sent.  This entitles you to a two (2) year enrollment.  This includes the text book, the administration of the final exam, the grading of that final exam, fifteen (15) ungraded chapter quizzes, and the issuance of your Real Estate  Practice  certificate, provided the course is completed within our two (2) year time frame.  You are advised that the possession of a certificate of completion from this class alone does not allow you to act as a real estate salesperson.  The student understands that in the event they write a check returned marked �??NSF�?� the student will be charged a $20.00 processing fee for such.
			
			Refund and cancellation policy
			
			The student shall be entitled seven (7) calendar days from the date of enrollment to request a refund.  If a refund is requested, the school will refund all monies received with the exception of a $25.00 processing fee.  The textbook must also be returned to the school in unused condition.  Return shipping is the responsibility of the student.  If the school determines that unusual wear and tear has occurred with the textbook, or the text has been written in, the school will (in addition to the $25.00 processing fee) retain $39.95 for the textbook.  All refunds will be mailed to the student within ten (10) days of receiving the request.  No refunds will be issued after the seven (7) calendar days have lapsed.  In lieu of a refund, the student may transfer the enrollment to another party within thirty (30) days of the date of enrollment. In the event of transfer, the transferee must sign a new enrollment agreement and you must sign a form indicating that you wish to transfer this enrollment.   Once thirty (30) days have passed, no refunds or transfers will be allowed.  All refunds will be made by business check to the student named above, regardless of who wrote the check or method of payment.
			
			All refund requests must be made in writing to the above address and be postmarked no later than seven (7) days from the date of enrollment.
			
			Course approval from the Bureau of Real Estate
			
			The course is approved by the California Bureau of Real Estate and has been issued approval number 2079-04.
			
			Errors or omissions in the textbook
			
			ADHI Schools believes that the materials are published in good faith.  The textbook is published by Dearborn Publishing.  ADHI Schools is not responsible and will accept no responsibility for errata in any of the textbooks, review materials or study aids provided or sold to the student.
			
			My signature below confirms that I have been given a reasonable amount of time to make a decision as to my enrollment in the course and all my questions regarding the course have been answered.  I have read and understand all of the above including the refund and cancellation policy of the school.  If paying by credit card, my signature below authorizes the school to charge the card the amount indicated on this contract, and I agree to abide by the terms of my cardholder agreement.
			
			By ______________________					Payment method:   cash    check     cc
					   Student signature						Card number: _______________________
													Type of card:  VISA   M/C   AMEX   DISC
			__________________________ (Printed name)				Expiration date: _________
			
			
			--></textarea>
						</div>	
						<div class="clearboth" style="height:20px;" >&nbsp;</div>
						<div  class="filedforrate" >
						<input type="checkbox" name="agree<?php echo $courses_mb['id']; ?>" id="agree<?php echo $courses_mb['id']; ?>" value="<?php echo $courses_mb['id']; ?>" onClick="javascript:showcheck_addnewcourse(this.value), checkrate();">I Agree  <input type="checkbox" name="disagree<?php echo $courses_mb['id']; ?>" id="disagree<?php echo $courses_mb['id']; ?>" value="<?php echo $courses_mb['id']; ?>" onClick="javascript:showuncheck(this.value), checkrate();" /> I Don't Agree
						</div>	
				   </div>
				   <div class="clearboth">&nbsp;</div>
		<?php } ?>		   
	     <!--End Terms and condition-->
	   
	   <!--List Sub Courses For Principle-->
	  <?php  if($courses_mb['child_cnt'] !=0){?>
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
			 <div class="clearboth">&nbsp;</div>
				  <!--Terms and condition-->
		
				   <div  class="filedforrate" id="showdiv<?php echo $subcourses['id']; ?>" style="display:none;" >
						<div  class="filedforrate" style="" >
						<textarea class="textarea_txt"   rows="5" cols="50">
			<?php $this->load->view('reskin/register/terms_and_conditions') ;?>
                        <!--ADHI Schools, LLC
			Voice: 888 768 5285 Fax: 800 598 3258
			5000 Birch St. �?? West Tower - Suite 3000 - Newport Beach, CA 92660
			
			Enrollment Agreement/General Information Page
												Date ____________________		
			Name _________________________________________________
			Telephone number ________________
			Mailing address __________________________________________________________
			City ___________________________	State ______	Zip code ________________
			
			This is a legally binding instrument between ADHI Schools, LLC sometimes referred to in this document as �??the firm�?� or �??the school�?� or �??we�?� and the above named party, hereafter referred to as �??the student�?� or �??you�?�.  This document is intended to have a binding effect, please read slowly and carefully.  This document will confirm that you are enrolling in Real Estate Practice - Correspondence offered by ADHI Schools, LLC.  You understand that your enrollment in this course does not provide you with any classroom instruction.  To complete this course, you will be required to spend a minimum of eighteen (18) days with the material and complete a 100 question, multiple choice, open-book final examination.  The Bureau of Real Estate has approved this course as a correspondence course.
			
			Information regarding the 100 question final exam
			
			During our 100 question multiple choice examination, you may refer to the instructional material supplied to you through the course.  A passing score on this exam is 60 percent or better.  You will be given 2 hours and 30 minutes to complete this examination.  Final examinations are either administered at one of our school locations during class time or by designated proctor.  If the student decides to take the examination in the firm�??s environment, the student should know that they are administered every class session by an employee of the school in an area separate from the classroom.  Currently, Bureau of Real Estate guidelines dictate that you must wait a minimum of eighteen (18) days from the date of receipt of materials before taking the final exam.  Upon passing the final exam you will receive a certificate of completion issued by the school.  If you pass this examination the transcript of completion will be mailed to the student within 72 hours of grading.  Reading the provided text will obviously prove useful in completing this examination, so make use of the textbook that is provided to you!
			
			Once again, the final examination may also be administered by a proctor who cannot be related to you by blood, marriage, domestic partnership or any other relationship that would impair the ability of the proctor to fairly administer the exam.  We will mail this examination to the proctor, not to your address.  The proctor will be required to sign a form indicating that they administered the examination and must return your answer sheet and the final exam to our headquarters.  If we do not get the final exam back we will not issue a certificate to you for this course!  We take the integrity of our material very seriously and cannot run the risk of our exams floating around.  Under NO circumstances will the final exam be given directly to the student. 
			
			In the event the student fails the final exam, the student may retake the test until they pass for no additional cost.  However, in the event of a failed examination the student must wait another eighteen (18) days from the date they last took the examination before they are allowed to retest.  The objective here is to learn and retain as much about the subject matter as possible.
			
			No legal advice given
			
			Throughout this course you will learn about various aspects of real estate.  It is the intention of the course and the firm to provide each student with up-to-date, timely and accurate information.  However, the firm is not a legal one and our instructors are not attorneys.  As such, none of the information disseminated should be relied upon as legal advice of any kind.  Please consult your tax and legal advisors if you desire tax or legal advice.  Also note that the Bureau of Real Estate has a website www.calbre.ca.gov and on this site there is a form you may download to evaluate the course as a whole.
			
			Cost of the course and what it includes 
			
			The cost of the course is $129.00 payable by cash, check, money order or credit card.  The student also agrees to pay ten ($10) dollars for shipping and handling charges to wherever the materials are sent.  This entitles you to a two (2) year enrollment.  This includes the text book, the administration of the final exam, the grading of that final exam, fifteen (15) ungraded chapter quizzes, and the issuance of your Real Estate  Practice  certificate, provided the course is completed within our two (2) year time frame.  You are advised that the possession of a certificate of completion from this class alone does not allow you to act as a real estate salesperson.  The student understands that in the event they write a check returned marked �??NSF�?� the student will be charged a $20.00 processing fee for such.
			
			Refund and cancellation policy
			
			The student shall be entitled seven (7) calendar days from the date of enrollment to request a refund.  If a refund is requested, the school will refund all monies received with the exception of a $25.00 processing fee.  The textbook must also be returned to the school in unused condition.  Return shipping is the responsibility of the student.  If the school determines that unusual wear and tear has occurred with the textbook, or the text has been written in, the school will (in addition to the $25.00 processing fee) retain $39.95 for the textbook.  All refunds will be mailed to the student within ten (10) days of receiving the request.  No refunds will be issued after the seven (7) calendar days have lapsed.  In lieu of a refund, the student may transfer the enrollment to another party within thirty (30) days of the date of enrollment. In the event of transfer, the transferee must sign a new enrollment agreement and you must sign a form indicating that you wish to transfer this enrollment.   Once thirty (30) days have passed, no refunds or transfers will be allowed.  All refunds will be made by business check to the student named above, regardless of who wrote the check or method of payment.
			
			All refund requests must be made in writing to the above address and be postmarked no later than seven (7) days from the date of enrollment.
			
			Course approval from the Bureau of Real Estate
			
			The course is approved by the California Bureau of Real Estate and has been issued approval number 2079-04.
			
			Errors or omissions in the textbook
			
			ADHI Schools believes that the materials are published in good faith.  The textbook is published by Dearborn Publishing.  ADHI Schools is not responsible and will accept no responsibility for errata in any of the textbooks, review materials or study aids provided or sold to the student.
			
			My signature below confirms that I have been given a reasonable amount of time to make a decision as to my enrollment in the course and all my questions regarding the course have been answered.  I have read and understand all of the above including the refund and cancellation policy of the school.  If paying by credit card, my signature below authorizes the school to charge the card the amount indicated on this contract, and I agree to abide by the terms of my cardholder agreement.
			
			By ______________________					Payment method:   cash    check     cc
					   Student signature						Card number: _______________________
													Type of card:  VISA   M/C   AMEX   DISC
			__________________________ (Printed name)				Expiration date: _________
			
			
			--></textarea>
						</div>	
						<div  style="height:20px;"  class="clearboth">&nbsp;</div>
						<div  class="filedforrate" style="height:20px;" >
						<input type="checkbox" name="agree<?php echo $subcourses['id']; ?>" id="agree<?php echo $subcourses['id']; ?>"  value="<?php echo $subcourses['id']; ?>" onClick="javascript:show_radio_check(this.value,document.course.elements['subcourse']),checkrate();">I Agree  <input type="checkbox" name="disagree<?php echo $subcourses['id']; ?>" id="disagree<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['id']; ?>"   onclick="javascript:show_radio_uncheck(this.value,document.course.elements['subcourse']),checkrate();"> I Don't Agree 
						</div>	
				   </div>
				   <div class="clearboth">&nbsp;</div>
			   
	     <!--End Terms and condition-->
			
			
			
			
		  <?php } ?>			
	
	  </div>
	  <?php } ?>
	    <!--End List Sub Courses For Principle-->
	  
	  
 	<div class="clearboth">&nbsp;</div>
     <?php }}} ?>	 
