<?php if($license == 'S'){?>
	<div class="subhead_txt margin-left58">The following courses are required </div>
	<div class="clearboth">&nbsp;</div>
   	<?php foreach($courses_m as $courses_m){ ?>
    <div  class="filedforrate margin-left58"  >
        <input type="hidden" name="courseprice<?php echo $courses_m['course_id']; ?>" id="courseprice<?php echo $courses_m['course_id']; ?>" value="<?php echo $courses_m['amount']; ?>"  />
        <img  src="<?php  echo ssl_url_img();?>course_checkbox_uncheck.png" width="13" height="13" id="course_chkimg<?php echo $courses_m['course_id']; ?>" onClick="javascript:showterms(<?php echo $courses_m['course_id']; ?>), checkrate();"/>&nbsp;&nbsp;
        <input type="checkbox" class="scheck display-none" name="course[]"   id="course<?php echo $courses_m['course_id']; ?>" value="<?php echo $courses_m['course_id']; ?>" onClick="javascript:showterms(this.value), checkrate();"  />
        <span onClick="javascript:showterms(<?php echo $courses_m['course_id']; ?>), checkrate();"><?php
					echo $courses_m['course_name'] ." -  $".$courses_m['amount']; 
		  		 ?></span>
        <input type="hidden" name="selagree<?php echo $courses_m['course_id']; ?>" id="selagree<?php echo $courses_m['course_id']; ?>" value="0" />
        <input type="hidden" name="courseweight<?php echo $courses_m['course_id']; ?>" id="courseweight<?php echo $courses_m['course_id']; ?>" value="<?php echo $courses_m['wieght']; ?>"  />
    </div>
    
    <?php /* Terms and condition */ ?>
    <?php //if($courses_m['child_cnt'] ==0){ ?>
	    <div class="clearboth">&nbsp;</div>
	    <div class="filedforrate paddingbottom" id="showdiv<?php echo $courses_m['course_id']; ?>" style="display:none;" >
	    	<div class="floatleft">
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
				    	<div class="agreementagreecheck"><img  src="<?php  echo ssl_url_img();?>checkbox_uncheck.png" width="25" height="24" id="agree<?php echo $courses_m['course_id']; ?>" onclick="javascript:showcheck(<?php echo $courses_m['course_id']; ?>), checkrate();"/><!--<input type="checkbox" name="agree<?php echo $courses_m['course_id']; ?>" id="agree<?php echo $courses_m['course_id']; ?>" value="<?php echo $courses_m['course_id']; ?>" onclick="javascript:showcheck(this.value),checkrate();">--></div>
				       	<div class="agreementagreetext" onclick="javascript:showcheck(<?php echo $courses_m['course_id']; ?>), checkrate();">I Agree</div>
				        <div class="floatleft"><img  src="<?php  echo ssl_url_img();?>checkbox_uncheck.png" width="25" height="24" id="disagree<?php echo $courses_m['course_id']; ?>" onclick="javascript:showuncheck(<?php echo $courses_m['course_id']; ?>), checkrate();"/><!--<input type="checkbox" name="disagree<?php echo $courses_m['course_id']; ?>" id="disagree<?php echo $courses_m['id']; ?>" value="<?php echo $courses_m['course_id']; ?>" onclick="javascript:showuncheck(this.value),checkrate();"  />--></div>
				        <div class="agreementdonttext" onclick="javascript:showuncheck(<?php echo $courses_m['course_id']; ?>), checkrate();"> I Don't Agree</div>
				     </div>
				 </div>
		    </div>
		</div>
	    <div class="clearboth">&nbsp;</div>
    <?php //} ?>
    <?php /* End Terms and condition */ ?>
    
<?php /* if($courses_m['child_cnt'] !=0){?>
		    <div class="clearboth">&nbsp;</div>
		    <div id="shodiv" style="display:block;" >
		    	<input  type="hidden"  name="subcourseprice"  id="subcourseprice" value="0" />
		  <?php $i=0;foreach($subcourses as $subcourses){ ?>
				     	<div  class="filedforrate" >
				        	<input  type="hidden"  name="subprice<?php echo $subcourses['id']; ?>" id="subprice<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['amount']; ?>" />
				          	<input  type="radio" class="subcheck"  name="subcourse" id="subcourse" value="<?php echo $subcourses['id']; ?>" onclick="javascript:show_sub_opt_terms(this.value,document.course.elements['subcourse']), checkrate();"/>
				         	<?php echo $subcourses['course_name'] ." - $".$subcourses['amount']; ?>
				          	<input type="hidden" name="courseweight<?php echo $subcourses['id']; ?>" id="courseweight<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['wieght']; ?>"  />
				        </div>
				        <div class="clearboth">&nbsp;</div>
				    <?php if($i==0) {?>   <div class="reg_course_msg">This option gives you access to any of our Principles locations listed on our  &ldquo; Schedules and locations &rdquo; page for up to two years.  You will also have access to the final exam and quizzes for Real Estate Principles</div><?php }?>
					<?php if($i==1) {?>   <div class="reg_course_msg">This option gives you access to the final exam and quizzes for Real Estate Principles, but does not give you access to any of our review sessions</div><?php }?>

				    
				    <div class="clearboth">&nbsp;</div>
				      	<?php /* Terms and condition */ ?>
				      	<!--<div  class="filedforrate paddingbottom" id="showdiv<?php echo $subcourses['id']; ?>" style="display:none;" >
					        <div class="floatleft">
								<div class="agreementbox">
									<div class="agreementinnerbox">
										<?php #$this->load->view('register/course_agreement')?>
									</div>								
								</div>
								<div  class="filedforterm agreement" >
									<div class="agreementagreecheck"><input type="checkbox" name="agree<?php echo $subcourses['id']; ?>" id="agree<?php echo $subcourses['id']; ?>"  value="<?php echo $subcourses['id']; ?>" onclick="javascript:show_radio_check(this.value,document.course.elements['subcourse']),checkrate();"></div>
									<div class="agreementagreetext">I Agree</div>
									<div class="floatleft"><input type="checkbox" name="disagree<?php echo $subcourses['id']; ?>" id="disagree<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['id']; ?>"   onclick="javascript:show_radio_uncheck(this.value,document.course.elements['subcourse']),checkrate();"></div>
									<div class="agreementdonttext">I Don't Agree </div>
								</div>
							</div>
						</div>
				      	<div class="clearboth"></div>-->
				      <?php /* End Terms and condition */ ?>
		  <?php /*$i++;} ?>
		    </div>
    <?php }*/ ?>
    <div class="clearboth"></div>
  <?php } ?>
<?php }?>  