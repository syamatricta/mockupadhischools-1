<span class="package_span margin-left58">
    <img  src="<?php echo ssl_url_img(); ?>radio_nonselection.png" width="13" height="13" id="course_bimg" onClick="javascript:show_radio_package_check_opt(<?php echo $courses[0]->course_id; ?>,document.course.elements['course_p']), checkrate();"/>&nbsp;&nbsp;
    <input type="radio"  class="bcheck display-none" name="course_p" id="course_b" value="<?php echo $courses[0]->course_id; ?>" onClick="javascript:show_radio_package_check_opt(this.value,document.course.elements['course_p']), checkrate();"     />
    <label for="course_b" style="color: #FDCC01;"><b>Pick this package:</b></label> <br></span>
<div style="margin-left:30px;">
<div  class="filedforrate "  >
    <input type="hidden" name="courseprice<?php echo $courses[0]->course_id; ?>" id="courseprice<?php echo $courses[0]->course_id; ?>" value="<?php echo $courses[0]->amount; ?>"  />
    <div style="float:left;  padding-top:20px;" class="margin-left58">
<!--		<input type="radio"  class="bcheck" name="course_p" id="course_b" value="<?php echo $courses[0]->course_id; ?>" onClick="javascript:show_radio_package_check_opt(this.value,document.course.elements['course_p']), checkrate();"     />-->
<!--		<div  class="bcheck" name="course_b" id="course_b" onClick="javascript:show_radio_package_check_opt(<?php echo $courses[0]->course_id; ?>,document.course.elements['course_b']), checkrate();" style="font-size:30px; text-align:center; float:left; font-weight:bold; color:#A6CE35; width:118px; height:75px; cursor:pointer; background:url(<?php echo $this->config->item('images') . 'pricebox.png'; ?>) no-repeat ; padding:20px;"><?php echo "$" . $courses[0]->amount; ?></div>-->
        <div  class="bcheck splice_pricebox"  style="font-size:30px; text-align:center; float:left; font-weight:bold; color:#A6CE35; width:118px; height:75px; padding:20px;"><?php echo "$" . $courses[0]->amount; ?></div>

        <input type="hidden" name="selagree<?php echo $courses[0]->course_id; ?>" id="selagree<?php echo $courses[0]->course_id; ?>" value="0" />
    </div>
    
    <?php if (set_value('coursetype') == 'Online')
        { ?>
            <div style="float:left; padding-top:30px; color:#9E9E9E; padding-left:25px; width:450px; font-size:12.7px; font-weight:bold;">
                This package contains access to our online courses with streaming video.
                You get physical textbooks for Real Estate Principles, Real Estate Practice and your choice of an elective course listed below.
                There’s also Chapter quizzes and exercises in the book and online to reinforce the course material.
            </div>
            <?php
        }
        else
        {
            ?>
            <div style="float:left; padding-top:30px; color:#9E9E9E; padding-left:25px; width:450px; font-size:12.7px; font-weight:bold;">

                Our most comprehensive package available. This includes Real Estate
                Principles, Real Estate Practice, and your choice of an elective class. All of these
                classes have an optional live component to them. You may attend according to
                our schedule.
            </div>
            <div class="clearboth"></div>
            <div class="margin-left58"><span class="package_span">
                    This package also comes with our legendary live two-day exam prep. This is
                    given on weekends and the itinerary is as follows:<br/><br/></span>
            </div>
            <div class="clearboth"></div>
            <div style="float:left; width:250px;font-size:12px; font-weight:bold;color:#9E9E9E;" class="margin-left58">
                <span class="package_span"><b>Saturday</b></span><br/>
                9am - 5pm - Lecture<br/>
            </div>
            <div style="float:left; width:450px; font-size:12px; font-weight:bold;color:#9E9E9E;">
                <span class="package_span"><b>Sunday</b></span><br/>
                9am - 1pm - Lecture<br/>
                1pm - 2pm - Lunch<br/>
                2pm - 515pm - Practice mock examination with your own laptop<br/><br/></label>

            </div>
        <?php } ?>

    <div class="clearboth"></div>
    <?php /* Terms and condition For Principle */ ?>
    <div class="filedforrate paddingbottom" id="showdiv<?php echo $courses[0]->course_id; ?>" style="display:none;" >
        <!--<div class="agreementbox">
            <div class="agreementinnerbox">
        <?php #$this->load->view('register/course_agreement')?>
            </div>
        </div>-->
        <div class="agreement_background">
            <div style="padding-left:30px;   padding-top:20px;">
                <div class="agreementinnerbox">
                    <?php $this->load->view('register/course_agreement') ?>
                </div>
            </div>
            <div  class="filedforterm agreement" >
                <div class="agreementagreecheck"><img  src="<?php echo ssl_url_img(); ?>checkbox_uncheck.png" width="25" height="24" id="agree<?php echo $courses[0]->course_id; ?>" onclick="javascript:showpackagecheck(<?php echo $courses[0]->course_id; ?>,'<?php echo $courses[0]->amount; ?>'),checkrate();"/><!--<input type="checkbox" name="agree<?php echo $courses[0]->course_id; ?>" id="agree<?php echo $courses[0]->course_id; ?>" value="<?php echo $courses[0]->course_id; ?>" onclick="javascript:showpackagecheck(this.value,'<?php echo $courses[0]->amount; ?>'),checkrate();">--></div>
                <div class="agreementagreetext" onclick="javascript:showpackagecheck(<?php echo $courses[0]->course_id; ?>,'<?php echo $courses[0]->amount; ?>'),checkrate();">I Agree</div>
                <div class="floatleft"><img  src="<?php echo ssl_url_img(); ?>checkbox_uncheck.png" width="25" height="24" id="disagree<?php echo $courses[0]->course_id; ?>" onclick="javascript:showpackageuncheck(<?php echo $courses[0]->course_id; ?>,document.course.elements['course_b']),checkrate();"/><!--<input type="checkbox" name="disagree<?php echo $courses[0]->course_id; ?>" id="disagree<?php echo $courses[0]->course_id; ?>" value="<?php echo $courses[0]->course_id; ?>" onclick="javascript:showpackageuncheck(this.value,document.course.elements['course_b']),checkrate();" >--></div>
                <div class="agreementdonttext" onclick="javascript:showpackageuncheck(<?php echo $courses[0]->course_id; ?>,document.course.elements['course_b']),checkrate();">I Don't Agree</div>
            </div>
        </div>
    </div>
    <input type="hidden" name="weight" id="weight" value="<?php echo $mandatory_course_weight; ?>" />
</div>

<?php
    /* SALES OPTIONAL COURSES */
    $this->load->view("user/userregister/register_course_sales_package_optional");
?></div>
<div class="clearboth">&nbsp;</div>
<!-- New package starts here -->
<span class="package_span margin-left58">
    <img  src="<?php echo ssl_url_img(); ?>radio_nonselection.png" width="13" height="13" id="course_bimg_newpackage" onClick="javascript:show_radio_package_check_opt_newpackage(<?php echo $courses_newpackage[0]->course_id; ?>,document.course.elements['course_p_newpackage']), checkrate();"/>&nbsp;&nbsp;
    <input type="radio"  class="bcheck display-none" name="course_p_newpackage" id="course_b_newpackage" value="<?php echo $courses_newpackage[0]->course_id; ?>" onClick="javascript:show_radio_package_check_opt_newpackage(this.value,document.course.elements['course_p_newpackage']), checkrate();"     />
    <label for="course_b_newpackage" style="color: #FDCC01;"><b>Pick this package:</b></label> <br>
</span>
<div style="margin-left:30px;">
<div  class="filedforrate "  >
    <input type="hidden" name="courseprice_newpackage<?php echo $courses_newpackage[0]->course_id; ?>" id="courseprice_newpackage<?php echo $courses_newpackage[0]->course_id; ?>" value="<?php echo $courses_newpackage[0]->amount; ?>"  />
    <div style="float:left;  padding-top:20px;" class="margin-left58">
<!--		<input type="radio"  class="bcheck" name="course_p" id="course_b" value="<?php echo $courses[0]->course_id; ?>" onClick="javascript:show_radio_package_check_opt(this.value,document.course.elements['course_p']), checkrate();"     />-->
<!--		<div  class="bcheck" name="course_b" id="course_b" onClick="javascript:show_radio_package_check_opt(<?php echo $courses[0]->course_id; ?>,document.course.elements['course_b']), checkrate();" style="font-size:30px; text-align:center; float:left; font-weight:bold; color:#A6CE35; width:118px; height:75px; cursor:pointer; background:url(<?php echo $this->config->item('images') . 'pricebox.png'; ?>) no-repeat ; padding:20px;"><?php echo "$" . $courses[0]->amount; ?></div>-->
        <div  class="bcheck splice_pricebox"  style="font-size:30px; text-align:center; float:left; font-weight:bold; color:#A6CE35; width:118px; height:75px; padding:20px;"><?php echo "$" . $courses_newpackage[0]->amount; ?></div>

        <input type="hidden" name="selagree_newpackage<?php echo $courses_newpackage[0]->course_id; ?>" id="selagree_newpackage<?php echo $courses_newpackage[0]->course_id; ?>" value="0" />
    </div>
    <?php
    
    if (set_value('coursetype') == 'Online')
        { ?>
            <div style="float:left; padding-top:30px; color:#9E9E9E; padding-left:25px; width:450px; font-size:12.7px; font-weight:bold;">
                This includes Real Estate Principles and Real Estate Practice.  For students who have taken economics, accounting and business law in college and passed with a "C" or better.
            </div>
            <?php
        }
        else
        {
            ?>
            <div style="float:left; padding-top:30px; color:#9E9E9E; padding-left:25px; width:450px; font-size:12.7px; font-weight:bold;">

                This includes Real Estate Principles and Real Estate Practice.  For students who have taken economics, accounting and business law in college and passed with a "C" or better.
            </div>
            <div class="clearboth"></div>
            <div class="margin-left58"><span class="package_span">
                    This package also comes with our legendary live two-day exam prep. This is
                    given on weekends and the itinerary is as follows:<br/><br/></span>
            </div>
            <div class="clearboth"></div>
            <div style="float:left; width:250px;font-size:12px; font-weight:bold;color:#9E9E9E;" class="margin-left58">
                <span class="package_span"><b>Saturday</b></span><br/>
                9am - 5pm - Lecture<br/>
            </div>
            <div style="float:left; width:450px; font-size:12px; font-weight:bold;color:#9E9E9E;">
                <span class="package_span"><b>Sunday</b></span><br/>
                9am - 1pm - Lecture<br/>
                1pm - 2pm - Lunch<br/>
                2pm - 515pm - Practice mock examination with your own laptop<br/><br/></label>

            </div>
        <?php } ?>

    <div class="clearboth"></div>
    <?php /* Terms and condition For Principle */ ?>
    <div class="filedforrate paddingbottom" id="showdiv_newpackage<?php echo $courses_newpackage[0]->course_id; ?>" style="display:none;" >
        <!--<div class="agreementbox">
            <div class="agreementinnerbox">
        <?php #$this->load->view('register/course_agreement')?>
            </div>
        </div>-->
        <div class="agreement_background">
            <div style="padding-left:30px;   padding-top:20px;">
                <div class="agreementinnerbox">
                    <?php $this->load->view('register/course_agreement') ?>
                </div>
            </div>
            <div  class="filedforterm agreement" >
                <div class="agreementagreecheck"><img  src="<?php echo ssl_url_img(); ?>checkbox_uncheck.png" width="25" height="24" id="agree_newpackage<?php echo $courses_newpackage[0]->course_id; ?>" onclick="javascript:showpackagecheck_newpackage(<?php echo $courses_newpackage[0]->course_id; ?>,'<?php echo $courses_newpackage[0]->amount; ?>'),checkrate();"/></div>
                <div class="agreementagreetext" onclick="javascript:showpackagecheck_newpackage(<?php echo $courses_newpackage[0]->course_id; ?>,'<?php echo $courses_newpackage[0]->amount; ?>'),checkrate();">I Agree</div>
                <div class="floatleft"><img  src="<?php echo ssl_url_img(); ?>checkbox_uncheck.png" width="25" height="24" id="disagree_newpackage<?php echo $courses_newpackage[0]->course_id; ?>" onclick="javascript:showpackageuncheck_newpackage(<?php echo $courses_newpackage[0]->course_id; ?>,document.course.elements['course_b_newpackage']),checkrate();"/></div>
                <div class="agreementdonttext" onclick="javascript:showpackageuncheck_newpackage(<?php echo $courses_newpackage[0]->course_id; ?>,document.course.elements['course_b_newpackage']),checkrate();">I Don't Agree</div>
            </div>
        </div>
    </div>
    <input type="hidden" name="weight_newpackage" id="weight_newpackage" value="<?php echo $mandatory_course_weight_new_package; ?>" />
</div>
</div>
<!-- New package ends here -->
<div class="clearboth">&nbsp;</div>

<?php
    /* SHIPPING */
    $this->load->view("register/register_shpping_course");
    /* PAYMENT */
    $this->load->view('register/registration_payment_details');
?>

<input type="hidden" name="hidcrsid" id="hidcrsid" value="0">
<input type="hidden" name="hidwt" id="hidwt" value="0">