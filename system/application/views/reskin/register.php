<?php page_heading('Create Account', '');?>
<div class="text-right" style="margin-right:8%;">		
    <span><a href="<?php echo base_url(); ?>">Home</a></span>		
    <span class="content">|Register</span>		
</div>
<section class="register">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-sm12 col-md-offset-1 text-right reg_needhelp">
                <h2 class="inherit"><i class="fa fa-phone"></i> Need help? Call 888 768 5285</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-sm12 col-md-offset-1 wtbg">                
                <div class="row">
                    <div class="col-md-10 col-sm12 col-md-offset-1">	 
                        <div class="row  mtb50 reg-step-info">
                            <div class="col-xs-4 step active">STEP 1</div>
                            <div class="col-xs-4 step text-center bl">STEP 2</div>
                            <div class="col-xs-4 step text-right bl">STEP 3</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 text-center">
                        <div  class="alert alert-danger" id="errordiv" style="display:none">
                            <?php if(isset($msg)) echo $msg; ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="registration-carousel" class="carousel slide col-sm-12" data-ride="carousel" data-interval="false" data-keyboard="false">
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <div class="carousel-caption1">
                                   <?php $this->load->view('reskin/register/step1');?>
                                </div>
                            </div>
                            <div class="item">
                                <div class="carousel-caption1">
                                    <?php $this->load->view('reskin/register/step2');?>
                                </div>
                            </div>
                            <div class="item">
                                <div class="carousel-caption1">
                                    <?php $this->load->view('reskin/register/step3');?>
                                </div>
                            </div>
                            <div class="item">
                                <div class="carousel-caption1" id="registraion_message_slide">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $this->load->view('reskin/register/course_agreement') ;?>

<div class="modal fade" id="terms-and-condition" tabindex="-1" role="dialog" aria-labelledby="geninformation">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <button type="button" data-dismiss="modal" aria-label="Close" style="margin:2%;" class="close"><span aria-hidden="true">X</span></button>
            <div class="modal-header"><h2>Terms and Conditions</h2></div>
            <div class="modal-body" style='text-align:justify;'>
                <?php $this->load->view('reskin/register/terms_and_conditions') ;?>
                <!--ADHI Schools, LLC - Statutory Sponsor ID #S0348<br/>
                Voice:  888 768 5285 <br/>
                9267 Haven Avenue Suite 210 Rancho Cucamonga, CA  91730 <br/><br/>
                Enrollment Agreement/General Information Page<br/>
                <div style="text-align:right;">Date: ___________________</div><br/><br/>
                
                Name__________________________________<br/><br/>
                Telephone number__________________________________<br/><br/>
                Mailing address__________________________________<br/><br/>
                City____________________   State________    Zip Code______________________<br/><br/><br/>
                
                <p> 
                    This is a legally binding instrument between ADHI Schools, LLC sometimes referred to in this document as "the firm" or "the school" or "we" and "the student" or "you".  Please read this slowly and carefully.  This will confirm that you are enrolling in one or more of the correspondence courses outlined below offered by ADHI Schools, LLC.     You understand that your enrollment in this course may or may not entitle you to optional study sessions. To complete this course, you will be required to spend a minimum of forty-five (45) hours and eighteen (18) days with the material and complete a 100 question, multiple choice, open-book final examination.  The Department of Real Estate has approved these courses as a correspondence courses
                </p>
                
                <p class="pagetitles">Course descriptions</p>
                
                <p><b><u> Real Estate Principles </u> </b> </p>
                This correspondence course aims to teach the student the fundamentals of real estate.  Learn about finance, landlord tenant law, escrow as well as title insurance.  The history of California real estate is also explored along with property ownership and land use controls
                <br/><br/>
                
                <p><b><u> Real Estate Practice </u> </b> </p>
                This correspondence course aims to teach the student the fundamentals of the real estate business.  Various topics include the different escrow practices in both northern and southern California, how to show property and how to take listings.  Common objection handlers are introduced as well as a comprehensive section on working with buyers.
                <br/><br/>
                
                <p><b><u> Legal Aspects of Real Estate </u> </b> </p>
                This correspondence course includes more than 200 case studies to help students apply legal concepts in real estate to real life.  The legal environment of real estate transactions is explored along with a thorough discussion of real estate finance, landlord tenant laws and escrow.  
                <br/><br/>
                
                <p><b><u> Escrows </u> </b> </p>
                This correspondence course aims to teach the student the fundamentals of escrow, buyer and seller costs in a real estate transaction and proration.  Topics include the different escrow practices in both northern and southern California and a discussion of the California Civil Code, as well as federal laws. The book also includes information on the latest forces in the regulatory environment, and follows the entire escrow process from preliminary discussions all the way through closing.
                <br/><br/>
                
                <p><b><u> Property Management</u> </b> </p>
                This correspondence course aims to teach the student about the daily issues facing practitioners, such as maintenance, accounting, administrative, and legal activities. In addition, it has up-to-date content on federal regulations, such as civil rights, fair housing, ADA issues, and environmental concerns.  
                <br/><br/>
                
                <p><b><u> Real Estate Finance</u> </b> </p>
                This correspondence course aims to teach the student about government organizations like Fannie Mae, Freddie Mac, and the new Consumer Financial Protection Bureau. This course takes the pulse of the current financial environment and explains it with clear language and advanced educational concepts. Students will receive a thorough background on basic tax issues, calculations, and formulas in order to better assist clients on tax-related questions and issues.
                <br/><br/>
                
                <p><b><u> Real Estate Economics</u> </b> </p>
                This correspondence course aims to teach the student about how real estate fits into the economy and economic vitality. “In California�? section and state appendices relate the discussion to local issues affecting our state.  
                <br/><br/>
                
                <p><b><u> Real Estate Appraisal</u> </b> </p>
                This correspondence course aims to teach the student about the modern appraisal process, gross living area, the division of outdoor spaces, the concept of curb appeal, interior house design, landscaping plans, Historical Landmark Designation, retrospective value, and financial calculators.  The three appraisal approaches are discussed in detail.
                <br/><br/>
                
                <p><b><u> Escrows</u> </b> </p>
                This correspondence course aims to teach the student the fundamentals of the real estate business.  Various topics include the different escrow practices in both northern and southern California, how to show property and how to take listings.  Common objection handlers are introduced as well as a comprehensive section on working with buyers.  
                <br/><br/>
                
                
                
                
                
                <p class="pagetitles">Information regarding the 100 question final exam</p>
                During our 100 question multiple choice examination, you may refer to the instructional material supplied to you through the course.  A passing score on this exam is 60 percent or better.  You will be given 2 hours and 30 minutes to complete this examination.  Final examinations can only be taken online on our website at 
                <a href="www.adhischools.com" target="_blank">www.adhischools.com.</a>  Currently, Department of Real Estate guidelines dictate that you must wait a minimum of eighteen (18) days from the date of receipt of materials before taking the final exam and spend 45 hours with the course material. Reading the provided text will obviously prove useful in completing this examination, so make use of the textbook that is provided to you!
                <br/><br/>
                
                <p class="pagetitles">In the event of a failed final exam</p>
                In the event the student fails the final exam, the student may retake the examination one more time at no additional cost.  The student must wait another eighteen (18) days from the date they last took the examination before they are allowed to retest.  The second final exam will have completely different questions than the first exam that was taken.  If the student fails this next examination, they must reregister for the entire course.
                <br/><br/>
                
                <p class="pagetitles">No legal advice given</p>
                Throughout this course you will learn about various aspects of real estate.  It is the intention of the course and the firm to provide each student with up-to-date, timely and accurate information.  However, the firm is not a legal one and our instructors are not attorneys.  As such, none of the information disseminated should be relied upon as legal advice of any kind.  Please consult your tax and legal advisors if you desire tax or legal advice.
                <br/><br/>
                
                <p class="pagetitles">Cost of the course and what it includes </p>
                The cost of the course is dependent on the package chosen on the subsequent pages and is payable by cash, check, money order or credit card.  The student also agrees to pay related FedEx charges for shipping and handling charges to wherever the materials are sent.  This entitles you to a one (1) year enrollment.  This includes the text book, the administration of the final exam, the grading of that final exam, fifteen (15) ungraded chapter quizzes, and the issuance of your Real Estate Practice certificate, provided the course is completed within our one (1) year time frame.  You are advised that the possession of a certificate of completion from this class alone does not allow you to act as a real estate salesperson.  The student understands that in the event they write a check returned marked "NSF" the student will be charged a $20.00 processing fee for such.
                <br/><br/>
                
                <p class="pagetitles">Refund and cancellation policy</p>
                The student shall be entitled seven (7) calendar days from the date of enrollment to request a refund.  If a refund is requested, the school will refund all monies received with the exception of a $25.00 processing fee.  The textbook must also be returned to the school in unused condition.  Return shipping is the responsibility of the student.  If the school determines that unusual wear and tear has occurred with the textbook, or the text has been written in, the school will (in addition to the $25.00 processing fee) retain $39.95 for the textbook.  All refunds will be mailed to the student within ten (10) days of receiving the request.  No refunds will be issued after the seven (7) calendar days have lapsed.  In lieu of a refund, the student may transfer the enrollment to another party within thirty (30) days of the date of enrollment. In the event of transfer, the transferee must sign a new enrollment agreement and you must sign a form indicating that you wish to transfer this enrollment.   Once thirty (30) days have passed, no refunds or transfers will be allowed.  All refunds will be made by business check to the student named above, regardless of who wrote the check or method of payment.

                <br/> <br/>All refund requests must be made in writing to the above address and be postmarked no later than seven (7) days from the date of enrollment.
                <br/><br/>
                
                <p class="pagetitles">Course approval from the Department of Real Estate</p>
                The course is approved by the California Department of Real Estate.
                <br/><br/>
                
                <p class="pagetitles">Online evaluation statement</p>
                Once you have completed the course, please take a moment to fill out the California Department of Real Estate's course and instructor evaluation form (RE 318A) located at: 
                <a href="http://www.dre.ca.gov/files/pdf/forms/re318a.pdfa" target="_blank"> http://www.dre.ca.gov/files/pdf/forms/re318a.pdfa </a>
                <br/><br/>
                
                <p class="pagetitles">DRE Disclaimer Statement</p>
                These courses are approved for pre-license education credit by the California Department of Real Estate. However, this approval does not constitute an endorsement of the views or opinions which are expressed by the course sponsor, instructor, authors, and lecturers.
                <br/><br/>
                
                <p class="pagetitles">Course Provider Complaint Statement</p>
                A course provider complaint form is available on the California Department of Real Estate (DRE) website at 
                <a href="http://dre.ca.gov/files/pdf/forms/re340.pdf" target="_blank"> http://dre.ca.gov/files/pdf/forms/re340.pdf </a>
                <br/><br/>
                
                <p class="pagetitles">Internet Control Statement</p>
                The school has various methods of control in place to ensure the integrity of our final exams.  First, the exams are not printable nor are they downloadable.  Access to the final exam will only unlock after you have indicated that you are the person registered in the course under penalty of perjury and that you have spent the forty-five (45) hours and eighteen (18) days with the course material.  Students will also need to provide their drivers license number in order to register for the course and this number will again need to be input in order to access the final exam.  Once the 2 hours and 30 minutes have lapsed, the final exam will automatically time out and score the exam for the questions answered.  Any unanswered questions will automatically be scored as incorrect.  Final exam access is limited to 'one time only'.  If a second final exam is offered it will have completely different questions.  If the student fails the second final exam they must reregister for the course and complete it again.
                <br/><br/>
                
                <p class="pagetitles">Errors or omissions in the textbook</p>
                ADHI Schools believes that the materials are published in good faith.  The editions of the textbooks are as outlined below and are published by Dearborn Publishing.  ADHI Schools is not responsible and will accept no responsibility for errata in any of the textbooks, review materials or study aids provided or sold to the student.
                <br/><br/>
                
                <i>
                California Real Estate Principles; Dearborn Publishing 10th edition<br/><br/>
                California Real Estate Practice; Dearborn Publishing 9th edition <br/><br/>
                California Real Estate Law; Dearborn Publishing 9th edition<br/><br/>
                Real Estate Finance; Dearborn Publishing 9th Edition<br/><br/>
                Property Management; Dearborn Publishing 10th edition revised<br/><br/>
                Real Estate Appraisal; Dearborn Publishing  12th Edition<br/><br/>
                Escrows; Dearborn Publishing<br/><br/>
                California Real Estate Economics, Dearborn Publishing 5th edition<br/><br/>
                </i>
                
                My acceptance confirms that I have been given a reasonable amount of time to make a decision as to my enrollment in the course and all my questions regarding the course have been answered.  I have read and understand all of the above including the refund and cancellation policy of the school.  If paying by credit card, my signature below authorizes the school to charge the card the amount indicated on this contract, and I agree to abide by the terms of my cardholder agreement.
            --></div>
            <div class="modal-footer">
                <div class="row termspop">
                    <div class="col-md-12">
                        <center><input type="button" value="AGREE" class="btn-adhi" id="close-terms-and-condition"></center>
                    </div>
                    <div class="visible-xs visible-sm"> <br/><br/> </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--<div class="modal fade" id="terms-and-condition" tabindex="-1" role="dialog" aria-labelledby="geninformation">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header"><h2>Terms and Conditions</h2></div>
            <div class="modal-body">
                <p class="pagetitles">General Information Page</p>
                This is a legally binding instrument between ADHI Schools, LLC sometimes referred to in this document as the firm or the school or we and the above named party, hereafter referred to as the student or you. This is intended to have a binding effect, please read slowly and carefully. This document will confirm that you are enrolling in the above mentioned class offered by ADHI Schools, LLC. You understand that your enrollment in this course does not provide you with any classroom instruction. To complete this course, you will be required to spend a minimum of 45 hours and eighteen (18) calendar days per course with the material and complete a 100 question, multiple choice, open-book final examination. The Bureau of Real Estate has approved this course as a correspondence course.
                <br/><br/>
                <p class="pagetitles">Optional live lecture supplementation</p>
                If you are signing up for a class that has live lecture supplementation time, you are welcome to come to any of those optional review sessions. These sessions are designed so that you can ask any questions to our instructors and review key course material. These lectures are optional and are not a requirement to obtaining your course certificate.
                <br/><br/>
                <p class="pagetitles">Information regarding the 100 question final exam</p>
                During our 100 question multiple choice examination, you may refer to the instructional material supplied to you through the course. A passing score on this exam is 60 percent or better. You will be given 2 hours and 30 minutes to complete this examination. Final examinations are either administered at one of our school locations during class time or by designated proctor. If the student decides to take the examination in the firms environment, the student should know that they are administered every class session by an employee of the school in an area separate from the classroom. Currently, Bureau of Real Estate guidelines dictate that you must wait a minimum of eighteen (18) days from the date of receipt of materials before taking the final exam. Upon passing the final exam you will receive a certificate of completion issued by the school. If you pass this examination the transcript of completion will be mailed to the student within 72 hours of grading. Reading the provided text will obviously prove useful in completing this examination, so make use of the textbook that is provided to you!
                <br/> <br/>
                If you decide to take the 100 question examination through our online system you are also welcome to do so. If you are going to take it online you will not be able to cut, copy, or print during the examination. The system will score your examination for you and store your certificate in your profile assuming you have passed.
                <br/> <br/>
                In the event the student fails the final exam, the student may retake the test until they pass for no additional cost. However, in the event of a failed examination the student must wait another eighteen (18) days from the date they last took the examination before they are allowed to retest. The objective here is to learn and retain as much about the subject matter as possible.
                <br/><br/>
                <p class="pagetitles">No legal advice given</p>
                Throughout this course you will learn about various aspects of real estate. It is the intention of the course and the firm to provide each student with up-to-date, timely and accurate information. However, the firm is not a legal one and our instructors are not attorneys. As such, none of the information disseminated should be relied upon as legal advice of any kind. Please consult your tax and legal advisors if you desire tax or legal advice. Also note that the Bureau of Real Estate has a website <a href="http://www.calbre.ca.gov" target="_blank" rel="nofollow">www.calbre.ca.gov</a> and on this site there is a form you may download to evaluate the course as a whole.
                <br/><br/>
                <p class="pagetitles">Cost of the course and what it includes</p>
                The cost of the course is as outlined and shipping charges are calculated per FedEx. Your enrollment is valid for a two year time period. Your fee includes the text book, the administration of the final exam, the grading of that final exam, fifteen (15) ungraded chapter quizzes, and the issuance of your course certificate, provided the course is completed within our two (2) year time frame. You are advised that the possession of a certificate of completion from this class alone does not allow you to act as a real estate salesperson.
                <br/><br/>
                <p class="pagetitles">Refund and cancellation policy</p>
                The student shall be entitled seven (7) calendar days from the date of enrollment to request a refund. If a refund is requested, the school will refund all monies received with the exception of a $25.00 processing fee. The textbook must also be returned to the school in unused condition. Return shipping is the responsibility of the student. If the school determines that unusual wear and tear has occurred with the textbook, or the text has been written in, the school will (in addition to the $25.00 processing fee) retain $39.95 for the textbook. All refunds will be mailed to the student within ten (10) days of receiving the request. No refunds will be issued after the seven (7) calendar days have lapsed. In lieu of a refund, the student may transfer the enrollment to another party within thirty (30) days of the date of enrollment. In the event of transfer, the transferee must sign a new enrollment agreement and you must sign a form indicating that you wish to transfer this enrollment. Once thirty (30) days have passed, no refunds or transfers will be allowed. All refunds will be made by business check to the student named above, regardless of who wrote the check or method of payment.
                <br/><br/>
                All refund requests must be made in writing to the above address and be postmarked no later than seven (7) days from the date of enrollment.
                <br/><br/>
                <p class="pagetitles">Course approval from the Bureau of Real Estate</p>
                The course is approved by the California Bureau of Real Estate.
                <br/><br/>
                <p class="pagetitles">Errors or omissions in the textbook</p>
                ADHI Schools believes that the materials are published in good faith. ADHI Schools is not responsible and will accept no responsibility for errata in any of the textbooks, review materials or study aids provided or sold to the student.
                <br/><br/>
                My signature below confirms that I have been given a reasonable amount of time to make a decision as to my enrollment in the course and all my questions regarding the course have been answered. I have read and understand all of the above including the refund and cancellation policy of the school. If paying by credit card, the school is authorized to charge the card the amount indicated below and I agree to abide by the terms of my card holder agreement.
                <br/><br/>
                Private providers of pre-license statutory real estate courses must obtain course approval from the Bureau of Real Estate (CalBRE). As part of the approval process, the CalBRE reviews the course materials only. The CalBRE does not qualify the school or course provider. In addition, there is no regulatory oversight of private pre-license course providers who offer courses or programs costing $500 or less. For courses or programs over $500, qualification by the Bureau for Private Postsecondary and Vocational Education is required, in addition to CalBRE course approval. As a result, if a course provider offering a course costing $500 or less fails to deliver the educational course/program as represented, a studentâ€™s monetary remedy is to seek redress in Small Claims Court. Students are cautioned to fully understand the education course/program offered by the provider before enrolling or registering. A list of pre-license statutory courses approved by the CalBRE can be found on the CalBRE Web site at <a href="http://www.calbre.ca.gov" target="_blank" rel="nofollow">www.calbre.ca.gov</a> under CalBRE Records.

            </div>
            <div class="modal-footer">
                <div class="row termspop">
                    <div class="col-md-12">
                        <center><input type="button" value="AGREE" class="btn-adhi" id="close-terms-and-condition"></center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->