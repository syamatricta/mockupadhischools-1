<div class="learn_more_outer_wrapper" id="guest_pass_no_popup">
    <div class="learn_more_top">&nbsp;</div>
    <div class="learn_more_wrapper">
        <div class="license_learn_more">
            <h1>I'd like to learn more about getting my real estate license.</h1>
            <h2 class="dispNone">I'd like to learn more about getting my real estate license.</h2>
            <div class="learn_more_content">
                <div class="valid_msgs"></div>
                <?php echo form_open('#', array('id' => 'license_info_form')); ?>
                <span class="learn_more_quote_img"><img src="<?php echo $this->config->item('images'); ?>11.png" alt="quote"/></span>
                Hello, my name is
                <span><input type="text" id="licencee_name" name="licencee_name" placeholder="name" value=""></span>
                and i'd like to get more information on real estate classes.<br/> Please send me information to
                <span><input type="text" id="licencee_email" name="licencee_email" placeholder="email" value=""></span>
                <br/> Want to talk to a live person? What’s your number ? We’ll call you
                <span><input type="text" id="licencee_phone" name="licencee_phone" placeholder="phone number" value=""></span>
                <span class="learn_more_quote_img"><img src="<?php echo $this->config->item('images'); ?>quote_close.png" alt="quote"/></span><br/>
                <span class="learn_more_tick_img"><img src="<?php echo $this->config->item('images'); ?>tick.png" alt="tick"/></span>
                I am a human
                <span class="captcha_question" id="captcha_question"><?php echo $math_captcha_question; ?></span>
                <span class="captcha_answer"><?php echo form_input(array('name' => 'math_captcha', 'id' => 'math_captcha')); ?></span>
                <br/>
                <input type="image" src="<?php echo $this->config->item('images'); ?>submit.png" name="submit_form" id="learn_more_submit" onmouseover="this.src='<?php echo $this->config->item('images'); ?>submit_hover.png';" onmouseout="this.src='<?php echo $this->config->item('images'); ?>submit.png';">
                <input type="hidden" name="submit" value="submit" id="submit_learn_more">
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <div class="learn_more_bottom">&nbsp;</div>
</div>
<i id="loader_enquiry" style="position:relative;left:58%;top:135px;display:none;"> <img alt='Please wait' src="<?php echo $this->config->item('images'); ?>indicator.gif"/> </i>