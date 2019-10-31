<?php 	if($license == 'S'){?>
		    <div class="clearboth"></div>
		   	<div class="subhead_txt margin-left58">The candidates can pick from one of the below</div>
			<div class="clearboth">&nbsp;</div>
		    <input type="hidden" name="s_courseprice" id="s_courseprice" value="0"  />
  <?php 	foreach($courses_o as $courses_o){ ?>
				<div  class="filedforrate margin-left58"  >
					<input type="hidden" name="courseprice<?php echo $courses_o['course_id']; ?>" id="courseprice<?php echo $courses_o['course_id']; ?>" value="<?php echo $courses_o['amount']; ?>"  />
			        <img  src="<?php  echo ssl_url_img();?>radio_nonselection.png" width="13" height="13" id="course_bimg<?php echo $courses_o['course_id']; ?>" onClick="javascript:show_opt_terms(<?php echo $courses_o['course_id']; ?>,document.course.elements['course_b']), checkrate();"/>&nbsp;&nbsp;
                                <input type="radio"  class="bcheck display-none" name="course_b" id="course_b<?php echo $courses_o['course_id']; ?>" value="<?php echo $courses_o['course_id']; ?>" />
			        <span onClick="javascript:show_opt_terms(<?php echo $courses_o['course_id']; ?>,document.course.elements['course_b']), checkrate();"><?php echo $courses_o['course_name'] ." - $".$courses_o['amount']; ?></span>
			        <?php //if($courses_o['id'] !=5) ?>
                                <input type="hidden" name="selagree<?php echo $courses_o['course_id']; ?>" id="selagree<?php echo $courses_o['course_id']; ?>" value="0" />
			        <input type="hidden" name="courseweight_b<?php echo $courses_o['course_id']; ?>" id="courseweight_b<?php echo $courses_o['course_id']; ?>" value="<?php echo $courses_o['wieght']; ?>"  />
				</div>
				<div class="clearboth">&nbsp;</div>
				<?php /* Terms and condition For Principle */ ?>
			    <div class="filedforrate paddingbottom" id="showdiv<?php echo $courses_o['course_id']; ?>" style="display:none;" >
					<!--<div class="agreementbox">
						<div class="agreementinnerbox">
							<?php #$this->load->view('register/course_agreement')?>
						</div>								
					</div>-->
					<div class="agreement_background">
						<div style="padding-left:30px;   padding-top:20px;">
							<div class="agreementinnerbox">
								<?php $this->load->view('register/course_agreement')?>
							</div>
						</div>
					   	<div  class="filedforterm agreement" >
					        <div class="agreementagreecheck"><img  src="<?php  echo ssl_url_img();?>checkbox_uncheck.png" width="25" height="24" id="agree<?php echo $courses_o['course_id']; ?>" onclick="javascript:show_radio_check_opt(<?php echo $courses_o['course_id']; ?>,document.course.elements['course_b']),checkrate();"/><!--<input type="checkbox" name="agree<?php echo $courses_o['course_id']; ?>" id="agree<?php echo $courses_o['course_id']; ?>" value="<?php echo $courses_o['course_id']; ?>" onclick="javascript:show_radio_check_opt(this.value,document.course.elements['course_b']),checkrate();">--></div>
					        <div class="agreementagreetext" onclick="javascript:show_radio_check_opt(<?php echo $courses_o['course_id']; ?>,document.course.elements['course_b']),checkrate();" >I Agree</div>
					        <div class="floatleft"><img  src="<?php  echo ssl_url_img();?>checkbox_uncheck.png" width="25" height="24" id="disagree<?php echo $courses_o['course_id']; ?>" onclick="javascript:show_radio_uncheck_opt(<?php echo $courses_o['course_id']; ?>,document.course.elements['course_b']),checkrate();"/><!--<input type="checkbox" name="disagree<?php echo $courses_o['course_id']; ?>" id="disagree<?php echo $courses_o['course_id']; ?>" value="<?php echo $courses_o['course_id']; ?>" onclick="javascript:show_radio_uncheck_opt(this.value,document.course.elements['course_b']),checkrate();" >--></div>
					        <div class="agreementdonttext"  onclick="javascript:show_radio_uncheck_opt(<?php echo $courses_o['course_id']; ?>,document.course.elements['course_b']),checkrate();">I Don't Agree </div>
					    </div>
					</div>
		    	</div>
				<div class="clearboth"></div>
	<?php 	} ?>
<?php  }?>
                                 <input type="hidden" name="sel_course_b" id="sel_course_b" value="0"  />
                                 <input type="hidden" name="sel_course_m" id="sel_course_m" value="0"  />