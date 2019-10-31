<?php /* main division for twitter, face book, you tube, login and flash starts here */ ?>
<?php
    if ($this->authentication->logged_in("normal"))
    {
        $id_head = 1;
        $class = 'navigationtextlog_new';
        $class_selected = 'navigationtextlog_new';
    }
    else
    {
        $id_head = 0;
        $class = 'navigationtext_new';
        $class_selected = 'navigationtextlog_new';
    }
?>
<div class="floatleft">
    <div class="left_cntnr" >
        <a href="<?php echo base_url() ?>"><div class="logo_cntnr"></div></a>
        <div class="links_cntnr" id="home_links">
            <div  <?php if ('register' == $this->uri->segment(2) || 'profile' == $this->uri->segment(1))
{ ?> class="<?php echo $class_selected; ?>" <?php
            }
            else
            {
        ?> class="<?php echo $class; ?>"<?php } ?> ><?php
                if (0 == $id_head)
                  	echo '<a href="'.c('site_ssl_baseurl').'user/register'.'" title="California Real Estate License Registration"><!--&nbsp;&nbsp;Register&nbsp;&nbsp;--></a>';
                else
                    echo anchor('profile', '&nbsp;&nbsp;Profile&nbsp;&nbsp;', array('title' => 'California Real Estate Examination'));
?></div>
            <?php if (1 == $id_head)
                { ?>
                    <div class="<?php echo $class ?>"><?php echo anchor('user/logout', '&nbsp;&nbsp;Logout&nbsp;&nbsp;') ?></div>
                <?php } ?>
        </div>
        <?php if (isset($arr_result) && !empty($arr_result))
            { ?>
                <div class="todays_class_contnr">
                    <div class="todays_classes_img"></div>
                </div>
                <div class="todays_classes_listing_cntnr">
                    <?php echo form_open("home/class_details", array('name' => 'tonightclassform', 'id' => 'tonightclassform')); ?>
                    <div class="clearboth paddingbottom">
                        <input type="hidden" name="hdnSubregion" id="hdnSubregion" />
                        <input type="hidden" name="hdnDated" id="hdnDated" onchange="javascript:$('classform').submit();" value="<?php echo date('m/d/Y'); ?>" />
                    </div>
                    <div id="divClass" class="flashtwittermain cl261">
                        <div class="clearboth"></div>
                        <div id="divShowRelatedImage">
                            <?php $this->load->view('user/display_related_class'); ?>
                        </div>
                    </div>
                    <?php
                    echo form_close();
                    ?>
                </div>
            <?php } ?>
        <div class="testimonial_image">
             <a href="<?php echo base_url() . 'testimonial'; ?>">
                <img src="<?php echo $this->config->item('images') . 'testimonial.png' ?>" width="237" height="71" alt="Testimonials" title="Testimonials" onmouseover="this.src='<?php echo $this->config->item('images'); ?>testimonial_hover.png';" onmouseout="this.src='<?php echo $this->config->item('images'); ?>testimonial.png';"/>
             </a>
        </div>
        <div class="cb"></div>
        <div class="fl">
            <div class="phone_div"></div>
            <div class="phone_no">888.768.5285</div>
            <div class="cb"></div>
            <div class="notepad_div"></div>
            <div class="fax_no">949 625 8007</div>
        </div>
        <div class="community_txt_img mt_15"></div>
        <div class="icons_cntnr iicon_contr">
            <a href="https://www.facebook.com/adhischools" target="_blank" rel="nofollow"><span class="face_book_img"></span></a>
            <a href="https://twitter.com/adhischools" target="_blank" rel="nofollow"><span class="twitter_img"></span></a>
            <a href="https://www.youtube.com/channel/UCKnNFzHOoFcrh0vNBRWcEBQ" target="_blank" rel="nofollow"><span class="youtube_img"></span></a>
            <a href="https://www.instagram.com/adhischools/" target="_blank" rel="nofollow"><div class="forum_img"></div></a>
            <a href="http://www.yelp.com/biz/adhi-schools-newport-beach" target="_blank" rel="nofollow"><span class="yelp_img"></span></a>
            <a href="http://www.adhischools.com/blog/" target="_blank" rel="nofollow"><span class="blog_img"></span></a>
        </div>
        <div class="links_div">
            Copyright 2003 - <?php echo date('Y'); ?> Adhischools,LLC<br />
            <?php echo anchor(base_url() . $siteurl[0]->name, 'About Us', array('title' => 'About Us')); ?>&nbsp;
            <?php echo anchor(base_url() . $siteurl[1]->name, 'Contact Us', array('title' => 'Contact Us')); ?>&nbsp;
            <?php //echo anchor(base_url() . 'articles', 'Articles', array('title' => 'Articles')); ?>&nbsp; 
            <?php echo anchor(base_url() . 'brokerplacement', 'Careers', array('title' => 'Careers')); ?>&nbsp;
            <?php echo anchor(base_url() . 'sitemap.php', 'Sitemap', array('title' => 'Sitemap')); ?><br />
            <?php echo anchor(base_url() . $siteurl[4]->name, 'Terms of Use', array('title' => 'Terms of Use')); ?>&nbsp;
            <?php echo anchor(base_url() . $siteurl[5]->name, 'Privacy Policy', array('title' => 'Privacy Policy')); ?>&nbsp;
            <?php echo anchor(base_url() . 'faq', 'FAQ', array('title' => 'FAQ')); ?>&nbsp;
        </div>
        <div class="sponsorid">CalBRE Statutory Sponsor ID #S0348</div>
    </div>

    <div class="right_cntnr">
        <div class="flashplayer flpDiv" onmouseover="javascript:displayIndex();" onmouseout="javascript:hideIndex();">
            <?php ?>
            <div id="slideshow" class="slshwDiv">
                <a href="<?php echo base_url() ?>"><img src="<?php echo $this->config->item('images') . 'banner/Who-endorses-us.jpg' ?>" alt="Who endorses us" title="Who endorses us" width="961" height="563" /></a>
                <a href="http://www.crashcourseonline.com/" target="_blank"><img src="<?php echo $this->config->item('images') . 'banner/Crashcourse.jpg' ?>" alt="Crash Course Online" title="Crash Course Online" width="961" height="563" /></a>
                <a href="<?php echo base_url() . 'meet-our-staff'; ?>"><img src="<?php echo $this->config->item('images') . 'banner/Meet-our-staff.jpg' ?>" alt="Meet our staff" title="Meet our staff" width="961" height="563" /></a>
                <a href="<?php echo base_url() . 'schedule'; ?>" rel="nofollow"><img src="<?php echo $this->config->item('images') . 'banner/Where-are-our-classes.jpg' ?>" alt="Where are our classes" title="Where are our classes" width="961" height="563" /></a>
                <a href="<?php echo base_url() . 'testimonial'; ?>"><img src="<?php echo $this->config->item('images') . 'banner/Who-are-our-students.jpg' ?>" alt="Who are our students" title="Who are our students" width="961" height="563" /></a>
                <a href="<?php echo base_url() . 'inexpensive'; ?>"><img src="<?php echo $this->config->item('images') . 'banner/Inexpensive-online-only-classes.jpg' ?>" alt="Inexpensive online only classes" title="Inexpensive online only classes" width="961" height="563" /></a>
            </div>
            <div id="indexBox" class="dispNone">
                <p id="indexText" class="inBoxText"></p>
                <div id="playpause" onclick="onPausePlay()" onmouseover="onMouseOverPP()" onmouseout="onMouseOutPP()"><img id="playpauseimg" src="<?php echo $this->config->item('images') . 'pause-btn.png'; ?>" alt="Pause" title="Pause" width="20" height="45" /></div>
            </div>
        </div>

        <div class="right_center_cntnr">
            <div class="right_center_fac_cntnr">
                <a class="find_a_class_img" href="<?php echo base_url() . 'schedule' ?>" title="" rel="nofollow"> </a>
            </div>
            <div class="right_center_got_questions_cntnr">
                <a href="<?php echo base_url() . "faq"; ?>" title=""><span class="questions_div"></span></a>
            </div>
        </div>
        <div class="right_bottom_cntnr">
            <div class="right_bottom_top_div">
                <div class="youtuve_vid">
                    <div id="youtuve_vid"></div>
                </div>
                <div class="blog_post_cntnr" id="blog_post_wrapper">
                    <span class="loading"></span>
                </div>
            </div>
            <div class="right_bottom_middle_fb_div">
                <div class="fb_lk_dv">
                    <div id="fb-root"></div>
                    <div class="fb-like" data-href="https://www.facebook.com/adhischools" data-send="false" data-width="100" data-show-faces="false" data-colorscheme="dark" data-font="tahoma"></div>
                </div>
                <div class="adhi_on_fb"></div>
            </div>
            <div class="right_bottom_last_div">                
                <div class="posts_div" id="tweets_wrapper">
                    <span class="loading"></span>
                </div>

                <div class="communities_div">
                    <a href="https://twitter.com/adhischools" class="twitter_bird" rel="nofollow">&nbsp;</a>
                    <div class="communities_cntnr">
                        <div class="community_txt_img"></div>
                        <div class="icons_cntnr">
                            <a href="https://www.facebook.com/adhischools" target="_blank" rel="nofollow"><span class="face_book_img"></span></a>
                            <a href="https://twitter.com/adhischools" target="_blank" rel="nofollow"><span class="twitter_img"></span></a>
                            <a href="https://www.youtube.com/channel/UCKnNFzHOoFcrh0vNBRWcEBQ" target="_blank" rel="nofollow"><span class="youtube_img"></span></a>
                            <a href="https://www.instagram.com/adhischools/" target="_blank" rel="nofollow"><div class="forum_img"></div></a>
                            <a href="http://www.yelp.com/biz/adhi-schools-newport-beach" target="_blank" rel="nofollow"><span class="yelp_img"></span></a>
                            <a href="http://www.adhischools.com/blog/" target="_blank" rel="nofollow"><span class="blog_img"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php /*
    <div class="more_div_cntnr">
        <div class="more_info_button" id="morediv" onclick="javascript:__blockbtmdiv();"></div>
    </div>
    <div class="more_info_div dispNone" id="moredivcnt">
        <p><b>Do You Want to Earn Your Real Estate Broker License?</b></p><br/>
        <p>We can help! At ADHI Schools, LLC, we put our industry expertise to work for you. With our help, you can earn your real estate(RE) license and start enjoying the career of your dreams. With thousands of RE classes taught educating people just like you, we are here to simplify the process of obtaining your California real estate salesperson license or California real estate broker license. No matter how much or how little knowledge you have about the RE field or the California RE license process —we can get you on the right path in no time. Let us help you achieve your dreams!</p><br/>
        <br/><p>ADHI Schools offers Real Estate classes in all of the following areas:</p>
        <ul>
            <li><b>Los Angeles</b></li>
            <li><b>Orange County</b></li>
            <li><b>South Bay</b></li>
            <li><b>High Desert</b></li>
            <li><b>Inland Empire</b></li>
            <li><b>San Gabriel Valley</b></li>
        </ul>
        <p>When you choose ADHI, you’ll also have access to top-notch RE educators and a highly innovative RE school that gives you the tools you need to build a successful and rewarding career. Whether your goal is to join a major RE company or start your own RE brokerage, our expertise will pay off. Earn your RE salesperson or broker license from a team of experts that truly cares about your future.</p>
        <br/><p><b>Real Estate Classes—Los Angeles Careers Start Here</b></p>
        <br/><p>Are you ready to jump-start your RE career and pass the RE exam?  We can make it happen! Now that you’ve found ADHI, you have instant access to RE classes in Orange County and surrounding areas that will transform your life. Why trust your future in the RE business to any other California RE school? Let our educational team share their California RE exam expertise with you. When you want to start your RE career, we’re here to make it simple. Build the RE practice of your dreams with the help of our Los Angeles RE classes or Orange County RE school. Now is the time to think about your financial future. Build a career with security and unlimited potential. Get your California real estate license today.</p>
        <br/><p><b>Learn the Ins and Outs of the Real Estate Business From the Experts</b></p>
        <br/><p>When you select ADHI’s California live RE classes, you will have the advantage of learning the trade from respected California RE industry leaders. After spending many years in the RE industry, our team of educators you’ll find at ADHI is ready to share their knowledge with you. Earn your RE broker license today and find out just how rewarding this field can be. When you’re ready to get started, our online registration system for RE classes makes it simple. In just minutes you can register for California RE classes in Los Angeles and the surrounding areas. What are you waiting for? Your career in RE is waiting!</p>
        <br/><p>If you need further assistance or would like more information about our Orange County real estate school, feel free to contact us. We are standing by to help you on your way to obtaining your RE license! Call us at <b>888-768-5285</b> or email <img src="<?php echo $this->config->item('images') . 'info-email.jpg' ?>" alt="info email" title="info email" class="va-b cp" onclick="sendFromJs();">  We look forward to hearing from you soon.</p>
    </div> */ ?>
    <?php $this->view('view_license_info'); ?>
</div>
<?php 
if(@$is_users_first_visit == true){ 
        $is_users_first_visit = false;
?>
    <div class="overlay-bg"></div><a class="show-popup" href="#" data-showpopup="1" ></a>
        <div class="overlay-content ppopup1" id="guest_pass_popup" style="text-align:center;color:black;" align="center">
            <a class="my_popup_close" href="#">X</a>
            <h1>I'd like to learn more about getting my real estate license.</h1>
            <div class="valid_msgs_popup"></div>
            <?php echo form_open('#', array('id' => 'license_info_form_popup')); ?>
            <span class="learn_more_quote_img"><img src="<?php echo $this->config->item('images'); ?>11.png" alt="quote"/></span>
            Hello, my name is
            <span><input type="text" id="licencee_name_popup" name="licencee_name_popup" placeholder="name" value=""></span>
            and i'd like to get more information on real estate classes.<br/> Please send me information to
            <span style="margin-bottom:5px;"><input type="text" id="licencee_email_popup" name="licencee_email_popup" placeholder="email" value=""></span>
            <br/> Want to talk to a live person? What’s your number ? We’ll call you
            <span><input type="text" id="licencee_phone_popup" name="licencee_phone_popup" placeholder="phone number" value=""></span>
            <span class="learn_more_quote_img"><img src="<?php echo $this->config->item('images'); ?>quote_close.png" alt="quote"/></span><br/>
            <span class="learn_more_tick_img"><img src="<?php echo $this->config->item('images'); ?>tick.png" alt="tick"/></span>
            I am a human
            <span class="captcha_question" id="captcha_question_popup"><?php echo $math_captcha_question_popup; ?></span>
            <span class="captcha_answer"><?php echo form_input(array('name' => 'math_captcha_popup', 'id' => 'math_captcha_popup')); ?></span>
            <br/>
            <input type="image" src="<?php echo $this->config->item('images'); ?>submit.png" name="submit_form_popup" id="learn_more_submit_popup" onmouseover="this.src='<?php echo $this->config->item('images'); ?>submit_hover.png';" onmouseout="this.src='<?php echo $this->config->item('images'); ?>submit.png';">
            <input type="hidden" name="submit_popup" value="submit_popup" id="submit_learn_more">
            <?php echo form_close(); ?>
            <br>
            <i id="loader_enquiry_popup" style="position:relative;bottom:185px;display:none;"> <img alt='Please wait' src="<?php echo $this->config->item('images'); ?>indicator.gif"/> </i>
        </div>
<?php } ?>
<script>initYoutubeVideo();</script>