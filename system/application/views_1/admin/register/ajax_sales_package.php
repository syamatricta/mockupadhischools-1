
<div><b>Pick this package:</b></div>
<div  class="filedforrate"  >
	<input type="hidden" name="courseprice<?php echo $courses[0]->course_id; ?>" id="courseprice<?php echo $courses[0]->course_id; ?>"
           value="<?php echo $courses[0]->amount; ?>"
    />
	<div style="float:left"><input type="radio"  class="bcheck" name="course_b" id="course_b"
                                   value="<?php echo $courses[0]->course_id; ?>"
                                   data-books-count="<?php echo $courses[0]->books_count; ?>"
                                   onClick="javascript:show_radio_package_check_opt(this.value,document.course.elements['course_b']), checkrate();"     />
	<label for="course_b"><?php echo "<b>$".$courses[0]->amount."</b>";?> - <?php if(set_value('coursetype')== 'Online'){?>
                 This package contains access to our online courses with streaming video.
                 You get physical textbooks for Real Estate Principles, Real Estate Practice and your choice of an elective course listed below.
                 There’s also Chapter quizzes and exercises in the book and online to reinforce the course material.
             <?php }
             else{?>
                Our most comprehensive package available. This includes Real Estate
                Principles, Real Estate Practice, and your choice of an elective class. All of these
                classes have an optional live component to them. You may attend according to
                our schedule.
            <br/><br/>
This package also comes with our legendary live two-day exam prep. This is
given on weekends and the itinerary is as follows:<br/><br/>

<b>Saturday</b><br/>
9am - 5pm - Lecture<br/><br/>
<b>Sunday</b><br/>
9am - 1pm - Lecture<br/>
1pm - 2pm - Lunch<br/>
2pm - 515pm - Practice mock examination with your own laptop<br/><br/></label>
<?php }?>
</div>

	<div class="clearboth"></div>
<?php /* Terms and condition For Principle */ ?>
    <div class="filedforrate paddingbottom" id="showdiv<?php echo $courses[0]->course_id; ?>" style="display:none;" >
		<div class="admin_agreementbox">
			<div class="admin_agreementinnerbox">
				<?php $this->load->view('register/course_agreement')?>
			</div>
		</div>
	   	<div  class="filedforterm agreement" >
	   		<div class="agreementagreecheck"><input type="checkbox" name="agree<?php echo $courses[0]->course_id; ?>" id="agree<?php echo $courses[0]->course_id; ?>" value="<?php echo $courses[0]->course_id; ?>" onclick="javascript:showpackagecheck(this.value,'<?php echo $courses[0]->amount; ?>'),checkrate();"></div>
	        <div class="admin_agreementagreetext"><label for="agree<?php echo $courses[0]->course_id; ?>">I Agree</label></div>
	        <div class="floatleft"><input type="checkbox" name="disagree<?php echo $courses[0]->course_id; ?>" id="disagree<?php echo $courses[0]->course_id; ?>" value="<?php echo $courses[0]->course_id; ?>" onclick="javascript:showpackageuncheck(this.value,document.course.elements['course_b']),checkrate();" ></div>
	        <div class="admin_agreementdonttext"><label for="disagree<?php echo $courses[0]->course_id; ?>">I Don't Agree</label> </div>
	    </div>
	</div>

	<input type="hidden" name="weight" id="weight" value="<?php echo $mandatory_course_weight;?>" />
</div>

<?php

/* SALES OPTIONAL COURSES */
$this->load->view("admin/register/register_course_sales_package_optional");?>
<div class="clearboth">&nbsp;</div>
<!-- New package starts here -->
<div><b>Pick this package:</b></div>
<div  class="filedforrate"  >
	<input type="hidden" name="courseprice_newpackage<?php echo $courses_newpackage[0]->course_id; ?>" id="courseprice_newpackage<?php echo $courses_newpackage[0]->course_id; ?>" value="<?php echo $courses_newpackage[0]->amount; ?>"  />
	<div style="float:left"><input type="radio"  class="bcheck" name="course_b_newpackage" id="course_b_newpackage"
                                   value="<?php echo $courses_newpackage[0]->course_id; ?>"
                                   data-books-count="<?php echo $courses_newpackage[0]->books_count; ?>"
                                   onClick="javascript:show_radio_package_check_opt_newpackage(this.value,document.course.elements['course_b_newpackage']), checkrate();"
        />
	<label for="course_b_newpackage"><?php echo "<b>$".$courses_newpackage[0]->amount."</b>";?> - <?php if(set_value('coursetype')== 'Online'){?>
                 This includes Real Estate Principles and Real Estate Practice.  For students who have taken economics, accounting and business law in college and passed with a "C" or better.
             <?php }
             else{?>
               This includes Real Estate Principles and Real Estate Practice.  For students who have taken economics, accounting and business law in college and passed with a "C" or better.
            <br/><br/>
This package also comes with our legendary live two-day exam prep. This is
given on weekends and the itinerary is as follows:<br/><br/>

<b>Saturday</b><br/>
9am - 5pm - Lecture<br/><br/>
<b>Sunday</b><br/>
9am - 1pm - Lecture<br/>
1pm - 2pm - Lunch<br/>
2pm - 515pm - Practice mock examination with your own laptop<br/><br/></label>
<?php }?>
</div>

	<div class="clearboth"></div>
<?php /* Terms and condition For Principle */ ?>
    <div class="filedforrate paddingbottom" id="showdiv_newpackage<?php echo $courses_newpackage[0]->course_id; ?>" style="display:none;" >
		<div class="admin_agreementbox">
			<div class="admin_agreementinnerbox">
				<?php $this->load->view('register/course_agreement')?>
			</div>
		</div>
	   	<div  class="filedforterm agreement" >
	   		<div class="agreementagreecheck"><input type="checkbox" name="agree_newpackage<?php echo $courses_newpackage[0]->course_id; ?>" id="agree_newpackage<?php echo $courses_newpackage[0]->course_id; ?>" value="<?php echo $courses_newpackage[0]->course_id; ?>" onclick="javascript:showpackagecheck_newpackage(this.value,'<?php echo $courses_newpackage[0]->amount; ?>'),checkrate();"></div>
	        <div class="admin_agreementagreetext"><label for="agree_newpackage<?php echo $courses_newpackage[0]->course_id; ?>">I Agree</label></div>
	        <div class="floatleft"><input type="checkbox" name="disagree_newpackage<?php echo $courses_newpackage[0]->course_id; ?>" id="disagree_newpackage<?php echo $courses_newpackage[0]->course_id; ?>" value="<?php echo $courses_newpackage[0]->course_id; ?>" onclick="javascript:showpackageuncheck_newpackage(this.value,document.course.elements['course_b_newpackage']),checkrate();" ></div>
	        <div class="admin_agreementdonttext"><label for="disagree_newpackage<?php echo $courses_newpackage[0]->course_id; ?>">I Don't Agree</label> </div>
	    </div>
	</div>

	<input type="hidden" name="weight_newpackage" id="weight_newpackage" value="<?php echo $mandatory_course_weight_new_package;?>" />
</div>

<div class="clearboth">&nbsp;</div>
<div id='show_ship_div_select'>

<?php 	/* SHIPPING */
	$this->load->view("admin/register/register_shpping_course");
	/* PAYMENT */?>
</div>
<div  class="filedforrate " id="grid"></div>
<div id='show_payment_div_select'>
<?php	$this->load->view('admin/register/registration_payment_details');?>
</div>
<div class="clearboth">&nbsp;</div>
			   		<div align="center" class="rightsidedata_register" style="text-align:center; width:50%;">
<!--						<img  src="<?php  echo ssl_url_img();?>innerpages/sub_btn.jpg" onclick="javascript:addcourses();" class="stylebutton" />-->
                                            <input type="image"  src="<?php  echo ssl_url_img();?>innerpages/sub_btn.jpg" onclick="javascript:return addcourses();" class="stylebutton" id="sb_btn"/>
                                                <span  id="newimg" style="display:none;"></span>
					</div>
	        	</div>
                         <input type="hidden" name="hidcrsid" id="hidcrsid" value="0">
                         <input type="hidden" name="hidwt" id="hidwt" value="0">
                         <!--<input type="hidden" name="totalprice"  id="totalprice"  value="<?php #echo $courses[0]->amount; ?>" />       -->
