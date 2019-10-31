<?php	
	if($license == 'B'){ 
		$j=0;?>
  		<div class="subhead_txt">The following courses are required </div>
	 	<div class="clearboth">&nbsp;</div>
	    <?php /* Mandatory Courses */ ?>
<?php 	foreach($courses_m as $courses_m){ 
			$j = $j+1; ?>
<?php  		if($j == 6){ ?>
  				<div class="clearboth">&nbsp;</div>
			    <div class="subhead_txt">Choose three from the bottom list </div>
				<div class="clearboth">&nbsp;</div>
<?php 		} ?>
			    <div  class="filedforrate" >
			   		<input type="hidden" name="courseprice<?php echo $courses_m['id']; ?>" id="courseprice<?php echo $courses_m['id']; ?>" value="<?php echo $courses_m['amount']; ?>"   />
			        <input type="checkbox" <?php if($courses_m['child_cnt'] ==0){?> class="scheck" <?php }else{ ?> DISABLED <?php }?>  name="course[]" id="course<?php if($courses_m['child_cnt'] ==0) echo $courses_m['id']; else echo 0;  ?>" value="<?php if($courses_m['child_cnt'] ==0)  echo $courses_m['id']; else echo 0;?>" onClick="javascript:showterms(this.value), checkrate();"  />
			        <?php 	if($courses_m['amount'] !=0.00){
								echo $courses_m['course_name'] ." -  $".$courses_m['amount']; 
							}else {
								echo $courses_m['course_name'] ; 
							}		
							if($courses_m['child_cnt'] ==0) { ?>
				        		<input type="hidden" name="courseweight<?php echo $courses_m['id']; ?>" id="courseweight<?php echo $courses_m['id']; ?>" value="<?php echo $courses_m['wieght']; ?>"  />
				    <?php 	}?>
			    </div>
			    <div class="clearboth">&nbsp;</div>
			    <?php /* Terms and condition starts here  */
			    if($courses_m['child_cnt'] ==0){?>
					<div class="filedforrate paddingbottom" id="showdiv<?php echo $courses_m['id']; ?>" style="display:none;" >
						<div class="agreementbox">
							<div class="agreementinnerbox">
								<?php $this->load->view('register/course_agreement')?>
							</div>								
						</div>
					    <div  class="filedforterm agreement" >
							<div class="agreementagreecheck"><input type="checkbox" name="agree<?php echo $courses_m['id']; ?>" id="agree<?php echo $courses_m['id']; ?>" value="<?php echo $courses_m['id']; ?>" onclick="javascript:showcheck(this.value), checkrate();"></div>
					        <div class="agreementagreetext">I Agree</div>
					        <div class="floatleft"><input type="checkbox" name="disagree<?php echo $courses_m['id']; ?>" id="disagree<?php echo $courses_m['id']; ?>" value="<?php echo $courses_m['id']; ?>" onclick="javascript:showuncheck(this.value), checkrate();"  /></div>
					        <div class="agreementdonttext">I Don't Agree </div>
					    </div>
				    </div>
		 			<div class="clearboth"></div>
		<?php 	} 
				/*  End Terms and condition */
			    /*List Sub Courses For Principle */ 
				if($courses_m['child_cnt'] !=0){?>
					<div id="shodiv" style="display:block;" >
						<input  type="hidden"  name="subcourseprice"  id="subcourseprice" value="0" />
				<?php $i=0; 	foreach($subcourses as $subcourses){  ?>
							<div  class="filedforrate"  >
						         <input  type="hidden"  name="subprice<?php echo $subcourses['id']; ?>" id="subprice<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['amount']; ?>" />
						          <input  type="radio" class="subcheck"  name="subcourse" id="subcourse" value="<?php echo $subcourses['id']; ?>" onclick="javascript:show_sub_opt_terms(this.value,document.course.elements['subcourse']), checkrate();"/>
						          <?php echo $subcourses['course_name'] ." - $".$subcourses['amount']; ?>
						          <input type="hidden" name="courseweight<?php echo $subcourses['id']; ?>" id="courseweight<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['wieght']; ?>"  />
						    </div>
							<div class="clearboth">&nbsp;</div>
							 <?php if($i==0) {?>   <div class="reg_course_msg">This option gives you access to any of our Principles locations listed on our &ldquo;Schedules and locations&rdquo; page for up to two years.  You will also have access to the final exam and quizzes for Real Estate Principles</div><?php }?>
					<?php if($i==1) {?>   <div class="reg_course_msg">This option gives you access to the final exam and quizzes for Real Estate Principles, but does not give you access to any of our review sessions</div><?php }?>
							<div class="clearboth">&nbsp;</div>
							<?php /* Terms and condition */ ?>
							<div  class="filedforrate paddingbottom" id="showdiv<?php echo $subcourses['id']; ?>" style="display:none;" >
								<div class="agreementbox">
									<div class="agreementinnerbox">
										<?php $this->load->view('register/course_agreement')?>
									</div>								
								</div>
								<div  class="filedforterm agreement"  >
						          	<div class="agreementagreecheck"><input type="checkbox" name="agree<?php echo $subcourses['id']; ?>" id="agree<?php echo $subcourses['id']; ?>"  value="<?php echo $subcourses['id']; ?>" onclick="javascript:show_radio_check(this.value,document.course.elements['subcourse']),checkrate();"></div>
						          	<div class="agreementagreetext">I Agree</div>
						          	<div class="floatleft"><input type="checkbox" name="disagree<?php echo $subcourses['id']; ?>" id="disagree<?php echo $subcourses['id']; ?>" value="<?php echo $subcourses['id']; ?>"   onclick="javascript:show_radio_uncheck(this.value,document.course.elements['subcourse']),checkrate();"></div>
						          	<div class="agreementdonttext">I Don't Agree </div>
						      	</div>
							</div>
						    <div class="clearboth"></div>
							<?php /* End Terms and condition */
				 		$i++;} ?>
					</div>
		<?php 	} 
			   	/* End List Sub Courses For Principle */ ?>
			    <div class="clearboth"></div>
			    <?php } ?>
<?php }?>
    <div class="clearboth">&nbsp;</div>