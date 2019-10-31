<section id="popup-contactform" class="contactform">
    <div class="row text-center">
        <div class="col-sm-12">
            <h2 class=" fadeInUp">I'd like to learn more about getting my real estate license</h2>
            <div id="popup-form-wrapper">
                <?php echo form_open('#', array('id' => 'license_info_form_popup')); ?>
                    <div class="valid_msgs"></div>
                    <p class=" fadeInUp" >             
                        <span class="quote ">"</span>
                        Hello, my name is
                        <input type="text" value="" placeholder="Name" name="licencee_name" id="licencee_name_popup"> 
                        and I'd like to get more information on real estate classes.
                    </p>  
                    <p class=" fadeInUp">
                    Please send me information to
                    <input type="text" value="" placeholder="Email" name="licencee_email" id="licencee_email_popup">
                    </p>
                    <p class=" fadeInUp">Want to talk to a live person? What’s your number ? We’ll call you
                    <input type="text" value="" placeholder="Phone number" name="licencee_phone" id="licencee_phone_popup">
                    <span class="quote">"</span>
                    </p>
                    <p class="margin40  fadeInUp">
                    I am a human
                    <?php /*<span id="captcha_question_popup" class="captcha_question"><?php echo $math_captcha_question; ?></span>*/ ?>
                    &nbsp;&nbsp;  <span id="captcha_question_popup"><?php echo $math_captcha_question['image']; ?></span>
                
                    &nbsp;&nbsp;  <span class="captcha_answer"><input type="text" id="math_captcha_popup" value="" name="math_captcha" style="text-transform: uppercase;"></span>

                    &nbsp;&nbsp;  
                    <span class="cantview floatleft">
                        <span class="bluelabelcaptcha">
                            <a style="color:white;text-decoration: underline;" href="javascript: void(null);" id="catcha_link" onclick="javascript: regenerate_home_captcha ('captcha_question_popup'); return false;">Can't view this word?</a>
                        </span>
                    </span>
                    </p>
                    <input type="hidden" name="submit" value="submit" id="submit_learn_more"> 
                    <input type="submit" class="btncontact  fadeInUp" id="submit_learn_more" value="submit" name="submit">
                <?php echo form_close(); ?>
                <i id="loader_enquiry" style="display:none;"> <img alt='Please wait' src="<?php echo $this->config->item('images'); ?>indicator.gif"/> </i>
            
                <div class="col-xs-12">
                    <div class="divide30"></div>
                    <div class="well trial-period_box">
                        <h3 class="text-center">
                            Interested in a free <?php echo $trial_account_validity;?> day trial of our industry-leading online program? <a  href="<?php echo base_url().'guestregister'; ?>" rel="nofollow">Click here</a>.
                        </h3>
                    </div>
                </div>
                <div class="col-sm-5">
                    <img alt='I Passed!' class="img-responsive" src="<?php echo $this->config->item('image_url'); ?>i-passed.png"/>                
                </div>
                <div class="col-sm-7 text-left ipassed-testimonial">
                    "Hey guys,<br/><br/>

                        I took the exam today and passed!!!!!<br/>

                        It only took me one try which was one

                        of my goals. I took the online classes

                        and follow your suggestions so I took

                        the crash course, used the crash course

                        app a lot, took 7 mock tests and went

                        confident to present the exam. Thank

                        you for the great job you are doing, you

                        guys are awesome!!!! May God continue

                        to bless you!"<br/><br/>

                        Willie V.
                </div>
            </div>
        </div>
    </div>
</section>