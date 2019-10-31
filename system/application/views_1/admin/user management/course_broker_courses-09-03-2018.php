<?php 
	if($license == 'B'){ 
		if($courses_mt !=false){ ?>
			<div class="admin_subhead_txt">The following courses are required </div>
			<div class="clearboth">&nbsp;</div>
<?php /* Mandatory Courses */
			foreach($courses_mt as $courses_mt){ ?>
				<div  class="filedforrateinblack" >
					<input type="hidden" name="courseprice<?php echo $courses_mt['id']; ?>" id="courseprice<?php echo $courses_mt['id']; ?>" value="<?php echo $courses_mt['amount']; ?>"  />
					<input type="checkbox" <?php if($courses_mt['child_cnt'] ==0){?> class="scheck" <?php } else{ ?>  DISABLED <?php }?>  name="course[]"   id="course<?php if($courses_mt['child_cnt'] ==0) echo $courses_mt['id']; else echo 0; ?>" value="<?php if($courses_mt['child_cnt'] ==0)  echo $courses_mt['id']; else echo 0; ?>" onClick="javascript:showterms(this.value);"  />
						<?php  	if($courses_mt['child_cnt'] ==0){
									echo $courses_mt['course_name'] ." -  $".$courses_mt['amount']; 
								} else {
									echo $courses_mt['course_name'] ; 
								}
								 if($courses_mt['child_cnt'] ==0) {?>
									<input type="hidden" name="courseweight<?php echo $courses_mt['id']; ?>" id="courseweight<?php echo $courses_mt['id']; ?>" value="<?php echo $courses_mt['wieght']; ?>"  />
							<?php 	}?>
				</div>
				<div class="clearboth"></div> 
<?php /* Terms and condition */ 
				if($courses_mt['child_cnt'] ==0){?>
					<div class="filedforrateinblack paddingbottom" id="showdiv<?php echo $courses_mt['id']; ?>" style="display:none;" >
						<div class="agreementbox">
							<div class="agreementinnerbox">
								<?php $this->load->view('register/course_agreement')?>
							</div>								
						</div>					
						<div  class="filedforterm agreement" >
							<div class="agreementagreecheck"><input type="checkbox" name="agree<?php echo $courses_mt['id']; ?>" id="agree<?php echo $courses_mt['id']; ?>" value="<?php echo $courses_mt['id']; ?>" onClick="javascript:showcheck_addnewcourse(this.value);"></div>
							<div class="admin_agreementagreetext">I Agree  </div>
							<div class="floatleft"><input type="checkbox" name="disagree<?php echo $courses_mt['id']; ?>" id="disagree<?php echo $courses_mt['id']; ?>" value="<?php echo $courses_mt['id']; ?>" onClick="javascript:showuncheck(this.value);" /> </div>
							<div class="admin_agreementdonttext">I Don't Agree </div>
						</div>	
					</div>
					<div class="clearboth"></div>
		<?php 	} ?>		   
<?php 	/* End Terms and condition  */ 
		
		/*List Sub Courses For Principle*/
				if($courses_mt['child_cnt'] !=0){?>
					<div id="shodiv" style="display:block;" >
						<input  type="hidden"  name="subcourseprice"  id="subcourseprice" value="0" />
				<?php 	foreach($subcourses as $subcourses){ ?>
							<div  class="filedforrateinblack"  >
								<input  type="hidden"  name="subprice<?php echo $subcourses['id']; ?>" id="subprice<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['amount']; ?>" />
								<input  type="radio" class="subcheck" name="subcourse" id="subcourse" value="<?php echo $subcourses['id']; ?>" onClick="javascript:show_sub_opt_terms(this.value,document.course.elements['subcourse']);"/>
								<?php echo $subcourses['course_name'] ." - $".$subcourses['amount']; ?>
								<input type="hidden" name="courseweight<?php echo $subcourses['id']; ?>" id="courseweight<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['wieght']; ?>"  />
							</div>
							<div class="clearboth"></div>
<?php /* Terms and condition */ ?>
							<div  class="filedforrateinblack paddingbottom" id="showdiv<?php echo $subcourses['id']; ?>" style="display:none;" >
								<div class="admin_agreementbox">
									<div class="agreementinnerbox">
										<?php $this->load->view('register/course_agreement')?>
									</div>								
								</div>		
								<div  class="filedforterm agreement" >
									<div class="agreementagreecheck"><input type="checkbox" name="agree<?php echo $subcourses['id']; ?>" id="agree<?php echo $subcourses['id']; ?>"  value="<?php echo $subcourses['id']; ?>" onClick="javascript:show_radio_check(this.value,document.course.elements['subcourse']);"></div>
									<div class="admin_agreementagreetext">I Agree  </div>
									<div class="floatleft"><input type="checkbox" name="disagree<?php echo $subcourses['id']; ?>" id="disagree<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['id']; ?>"   onclick="javascript:show_radio_uncheck(this.value,document.course.elements['subcourse']);"> </div>
									<div class="admin_agreementdonttext">I Don't Agree </div>
								</div>	
							</div>
							<div class="clearboth"></div>
<?php /* End Terms and condition */ 
				 		} ?>			
					</div>
		<?php 	} 
	/* End List Sub Courses For Principle */ ?>
	<div class="clearboth">&nbsp;</div>
<?php		}
		}
 if($courses_mb !=false){
	?>
  	
		<div class="admin_subhead_txt">Choose <?php echo $countnum;?> from bottom list </div>
		<div class="clearboth">&nbsp;</div>
	   <?php foreach($courses_mb as $courses_mb){ ?>
	  <div  class="filedforrateinblack" >
		<div  class="filedforrateinblack" >
			<input type="hidden" name="courseprice<?php echo $courses_mb['id']; ?>" id="courseprice<?php echo $courses_mb['id']; ?>" value="<?php echo $courses_mb['amount']; ?>"  />
			<input type="checkbox" <?php if($courses_mb['child_cnt'] ==0){?> class="scheck" <?php } ?>  name="course[]"   id="course<?php if($courses_mb['child_cnt'] ==0) echo $courses_mb['id']; else echo 0; ?>" value="<?php if($courses_mt['child_cnt'] ==0)  echo $courses_mb['id']; else echo 0; ?>" onClick="javascript:showterms(this.value);"  />
			<?php if($courses_mb['child_cnt'] ==0){
			echo $courses_mb['course_name'] ." -  $".$courses_mb['amount']; 
			}
			else
			echo $courses_mb['course_name'] ; 
			?>
			<?php if($courses_mb['child_cnt'] ==0) ?>
			<input type="hidden" name="courseweight<?php echo $courses_mb['id']; ?>" id="courseweight<?php echo $courses_mb['id']; ?>" value="<?php echo $courses_mb['wieght']; ?>"  />
		 </div>
	  </div>
		<div class="clearboth">&nbsp;</div> 
		 
		<?php  if($courses_mb['child_cnt'] ==0){?>
		 
			<div  class="filedforrateinblack paddingbottom" id="showdiv<?php echo $courses_mb['id']; ?>" style="display:none;" >
				<div class="agreementbox">
					<div class="agreementinnerbox">
						<?php $this->load->view('register/course_agreement')?>
					</div>								
				</div>		
					<div  class="filedforterm agreement" >
					<div class="agreementagreecheck"><input type="checkbox" name="agree<?php echo $courses_mb['id']; ?>" id="agree<?php echo $courses_mb['id']; ?>"  value="<?php echo $courses_mb['id']; ?>" onClick="javascript:showcheck_addnewcourse(this.value);"></div>
					<div class="agreementagreetext">I Agree  </div>
					<div class="floatleft"><input type="checkbox" name="disagree<?php echo $courses_mb['id']; ?>" id="disagree<?php echo $courses_mb['id']; ?>" value="<?php echo $courses_mb['id']; ?>"   onClick="javascript:showuncheck(this.value);" > </div>
					<div class="agreementdonttext">I Don't Agree </div>
				</div>	
			</div>
			<div class="clearboth"></div>
					
		<?php } ?>		   
   
	   <!--List Sub Courses For Principle-->
	  <?php  if($courses_mb['child_cnt'] !=0){?>
	  <div id="shodiv" style="display:block;" >
			<input  type="hidden"  name="subcourseprice"  id="subcourseprice" value="0" />
			<?php $i=0; foreach($subcourses as $subcourses){ ?>
			<div  class="filedforrateinblack"  >
				<div  class="filedforrateinblack" >
					<input  type="hidden"  name="subprice<?php echo $subcourses['id']; ?>" id="subprice<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['amount']; ?>" />
					<input  type="radio" class="subcheck" name="subcourse" id="subcourse" value="<?php echo $subcourses['id']; ?>" onClick="javascript:show_sub_opt_terms(this.value,document.course.elements['subcourse']);"/>
					<?php echo $subcourses['course_name'] ." - $".$subcourses['amount']; ?>
					<input type="hidden" name="courseweight<?php echo $subcourses['id']; ?>" id="courseweight<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['wieght']; ?>"  />
				 </div>
			</div>
			<div class="clearboth">&nbsp;</div>
			<?php if($i==0) {?>   <div class="reg_course_msg">This option gives you access to any of our Principles locations listed on our &ldquo;Schedules and locations&rdquo; page for up to two years.  You will also have access to the final exam and quizzes for Real Estate Principles</div><?php }?>
			<?php if($i==1) {?>   <div class="reg_course_msg">This option gives you access to the final exam and quizzes for Real Estate Principles, but does not give you access to any of our review sessions</div><?php }?>
			
			 <div class="clearboth"></div>
				<!--Terms and condition-->
				<div class="filedforrateinblack paddingbottom" id="showdiv<?php echo $subcourses['id']; ?>" style="display:none;" >
					<div class="agreementbox">
						<div class="agreementinnerbox">
						<?php $this->load->view('register/course_agreement')?>
						</div>								
					</div>					
					<div  class="filedforterm agreement" >
					<div class="agreementagreecheck"><input type="checkbox" name="agree<?php echo $subcourses['id']; ?>" id="agree<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['id']; ?>"  onClick="javascript:show_radio_check(this.value,document.course.elements['subcourse']);"></div>
					<div class="agreementagreetext">I Agree  </div>
					<div class="floatleft"><input type="checkbox" name="disagree<?php echo $subcourses['id']; ?>" id="disagree<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['id']; ?>" onclick="javascript:show_radio_uncheck(this.value,document.course.elements['subcourse']);" /> </div>
					<div class="agreementdonttext">I Don't Agree </div>
					</div>	
				</div>
				<div class="clearboth">&nbsp;</div>
				
		  <?php $i++; } ?>			
	
	  </div>
	  <?php } ?>
 	<div class="clearboth"></div>
     <?php }} 
} ?>
	
	