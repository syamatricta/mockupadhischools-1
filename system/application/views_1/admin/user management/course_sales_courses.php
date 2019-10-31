<?php 
	if($license == 'S' and $courses_m !=false){?>
		<div class="admin_subhead_txt">The following courses are required </div>
		<div class="clearboth">&nbsp;</div>
<?php 	foreach($courses_m as $courses_m){ ?>
			<div  class="filedforrateinblack"  >
				<input type="hidden" name="courseprice<?php echo $courses_m['id']; ?>" id="courseprice<?php echo $courses_m['id']; ?>" value="<?php echo $courses_m['amount']; ?>"  />
				<input type="checkbox" <?php if($courses_m['child_cnt'] ==0){?> class="scheck" <?php }else{ ?>  DISABLED <?php }?> name="course[]"   id="course<?php if($courses_m['child_cnt'] ==0) echo $courses_m['id']; else echo 0; ?>" value="<?php if($courses_m['child_cnt'] ==0)  echo $courses_m['id']; else echo 0; ?>" onClick="javascript:showterms(this.value);"  />
					<?php 	if($courses_m['child_cnt'] ==0){
								echo $courses_m['course_name'] ." -  $".$courses_m['amount']; 
							} else {
								echo $courses_m['course_name'] ; 
							}
					?>
					<?php if($courses_m['child_cnt'] ==0) ?>
				<input type="hidden" name="courseweight<?php echo $courses_m['id']; ?>" id="courseweight<?php echo $courses_m['id']; ?>" value="<?php echo $courses_m['wieght']; ?>"  />
			</div>
			<?php /* Terms and condition */   
			if($courses_m['child_cnt'] ==0){?>
				<div class="clearboth">&nbsp;</div> 
				<div class="filedforrateinblack paddingbottom" id="showdiv<?php echo $courses_m['id']; ?>" style="display:none;" >
					<div class="admin_agreementbox">
						<div class="admin_agreementinnerbox">
							<?php $this->load->view('register/course_agreement')?>
						</div>								
					</div>	
					<div  class="filedforterm agreement" >
						<div class="agreementagreecheck"><input type="checkbox" name="agree<?php echo $courses_m['id']; ?>" id="agree<?php echo $courses_m['id']; ?>" value="<?php echo $courses_m['id']; ?>" onClick="javascript:showcheck_addnewcourse(this.value);"></div>
						<div class="admin_agreementagreetext">I Agree  </div>
						<div class="floatleft"><input type="checkbox" name="disagree<?php echo $courses_m['id']; ?>" id="disagree<?php echo $courses_m['id']; ?>" value="<?php echo $courses_m['id']; ?>" onClick="javascript:showuncheck(this.value);"  /> </div>
						<div class="admin_agreementdonttext">I Don't Agree </div>
					</div>	
				</div>
				<div class="clearboth"></div> 
		<?php } ?>		   
			<?php /* End Terms and condition */  
			if($courses_m['child_cnt'] !=0){?>
				<div class="clearboth">&nbsp;</div>
				<div id="shodiv" style="display:block;" >
					<input  type="hidden"  name="subcourseprice"  id="subcourseprice" value="0" />
			<?php  $i=0;	foreach($subcourses as $subcourses){ ?>
						<div  class="filedforrateinblack" >
							<input  type="hidden"  name="subprice<?php echo $subcourses['id']; ?>" id="subprice<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['amount']; ?>" />
							<input  type="radio" class="subcheck" name="subcourse" id="subcourse" value="<?php echo $subcourses['id']; ?>" onClick="javascript:show_sub_opt_terms(this.value,document.course.elements['subcourse']);"/>
							<?php echo $subcourses['course_name'] ." - $".$subcourses['amount']; ?>
							<input type="hidden" name="courseweight<?php echo $subcourses['id']; ?>" id="courseweight<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['wieght']; ?>"  />
						</div>
						<div class="clearboth">&nbsp;</div>
						<?php if($i==0) {?>   <div class="reg_course_msg">This option gives you access to any of our Principles locations listed on our &ldquo;Schedules and locations&rdquo; page for up to two years.  You will also have access to the final exam and quizzes for Real Estate Principles</div><?php }?>
						<?php if($i==1) {?>   <div class="reg_course_msg">This option gives you access to the final exam and quizzes for Real Estate Principles, but does not give you access to any of our review sessions</div><?php }?>

						<div class="clearboth">&nbsp;</div>
						<?php /* Terms and condition */ ?>
						<div  class="filedforrateinblack" id="showdiv<?php echo $subcourses['id']; ?>" style="display:none;" >
							<div class="admin_agreementbox">
								<div class="admin_agreementinnerbox">
								<?php $this->load->view('register/course_agreement')?>
								</div>								
							</div>	
							<div  class="filedforterm agreement"  >
								<div class="agreementagreecheck"><input type="checkbox" name="agree<?php echo $subcourses['id']; ?>" id="agree<?php echo $subcourses['id']; ?>"  value="<?php echo $subcourses['id']; ?>" onClick="javascript:show_radio_check(this.value,document.course.elements['subcourse']);"></div>
								<div class="admin_agreementagreetext">I Agree  </div>
								<div class="floatleft"><input type="checkbox" name="disagree<?php echo $subcourses['id']; ?>" id="disagree<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['id']; ?>"   onclick="javascript:show_radio_uncheck(this.value,document.course.elements['subcourse']);"> </div>
								<div class="admin_agreementdonttext">I Don't Agree </div>
							</div>	
						</div>
						<div class="clearboth"></div>
			<?php $i++;} ?>			
				</div>
		<?php } ?>
			<div class="clearboth"></div>
		<?php } ?>
<?php }?>