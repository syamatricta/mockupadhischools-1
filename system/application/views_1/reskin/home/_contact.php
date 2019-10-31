<section id="contactform" class="contactform">
    <div class="container text-center">
        <h2 class="wow fadeInUp">I'd like to learn more about getting my real estate license</h2>
        <div>
            <?php echo form_open('#', array('id' => 'license_info_form')); ?>
            <div class="valid_msgs"></div>
            <p class="wow fadeInUp" >             
                <span class="quote ">"</span>
                Hello, my name is
                <input type="text" value="" placeholder="Name" name="licencee_name" id="licencee_name"> 
                and I'd like to get more information on real estate classes.
                </p>  
                <p class="wow fadeInUp">
                Please send me information to
                <input type="text" value="" placeholder="Email" name="licencee_email" id="licencee_email">
                </p>
                <p class="wow fadeInUp">Want to talk to a live person? What’s your number ? We’ll call you
                <input type="text" value="" placeholder="Phone number" name="licencee_phone" id="licencee_phone">
                <span class="quote">"</span>
                </p>
                <p class="margin40 wow fadeInUp">
                I am a human
                <?php /*<span id="captcha_question" class="captcha_question"><?php echo $math_captcha_question; ?></span>
                 * 
                 */
                ?>
                &nbsp;&nbsp;  <span id="captcha_question"><?php echo $math_captcha_question['image']; ?></span>
                
                &nbsp;&nbsp;  <span class="captcha_answer"><input type="text" id="math_captcha" value="" name="math_captcha" style="text-transform: uppercase;"></span>
                
                &nbsp;&nbsp;  
                <span class="cantview floatleft">
                    <span class="bluelabelcaptcha">
                        <a style="color:white;text-decoration: underline;" href="javascript: void(null);" id="catcha_link" onclick="javascript: regenerate_home_captcha ('captcha_question'); return false;">Can't view this word?</a>
                    </span>
                </span>
                
                </p>
               <input type="hidden" name="submit" value="submit" id="submit_learn_more"> 
                <input type="submit" class="btncontact wow fadeInUp" id="submit_learn_more" value="submit" name="submit">
                <?php echo form_close(); ?>
                <i id="loader_enquiry" style="display:none;"> <img alt='Please wait' src="<?php echo $this->config->item('images'); ?>indicator.gif"/> </i>
         </div>
        <div class="divide30"></div>
        <div class="well trial-period_box">
            <h3 class="text-center">
                Interested in a free <?php echo $trial_account_validity;?> day trial of our industry-leading online program? <a  href="<?php echo base_url().'guestregister'; ?>" rel="nofollow">Click here</a>.
            </h3>
        </div>
    </div>
</section>