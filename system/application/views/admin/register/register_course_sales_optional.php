<?php 	if($license == 'S'){?> 
		    <div class="clearboth"></div>
		   	<div class="admin_subhead_txt">The candidates can pick from one of the below</div>
			<div class="clearboth">&nbsp;</div>
		    <input type="hidden" name="s_courseprice" id="s_courseprice" value="0"  />
  <?php 	foreach($courses_o as $courses_o){ ?>
				<div  class="filedforrate"  > 
					<input type="hidden" name="courseprice<?php echo $courses_o['course_id']; ?>" id="courseprice<?php echo $courses_o['course_id']; ?>" value="<?php echo $courses_o['amount']; ?>"  />
			        <input type="radio"  class="bcheck" name="course_b" id="course_b<?php echo $courses_o['course_id']; ?>" value="<?php echo $courses_o['course_id']; ?>" onClick="javascript:show_opt_terms(this.value,document.course.elements['course_b']), checkrate();"     />
			        <label for="course_b<?php echo $courses_o['course_id']; ?>"><?php echo $courses_o['course_name'] ." - $".$courses_o['amount']; ?></label>
			        <?php //if($courses_o['id'] !=5) ?>
			        <input type="hidden" name="courseweight_b<?php echo $courses_o['course_id']; ?>" id="courseweight_b<?php echo $courses_o['course_id']; ?>" value="<?php echo $courses_o['wieght']; ?>"  />
				</div>
				<div class="clearboth">&nbsp;</div>
				<?php /* Terms and condition For Principle */ ?>
			    <div class="filedforrate paddingbottom" id="showdiv<?php echo $courses_o['course_id']; ?>" style="display:none;" >
					<div class="admin_agreementbox">
						<div class="admin_agreementinnerbox">
							<?php $this->load->view('register/course_agreement')?>
						</div>								
					</div>
				   	<div  class="filedforterm agreement" >
				   		<div class="agreementagreecheck"><input type="checkbox" name="agree<?php echo $courses_o['course_id']; ?>" id="agree<?php echo $courses_o['course_id']; ?>" value="<?php echo $courses_o['course_id']; ?>" onclick="javascript:show_radio_check_opt(this.value,document.course.elements['course_b']),checkrate();"></div>
				        <div class="admin_agreementagreetext"><label for="agree<?php echo $courses_o['course_id']; ?>">I Agree</label></div>
				        <div class="floatleft"><input type="checkbox" name="disagree<?php echo $courses_o['course_id']; ?>" id="disagree<?php echo $courses_o['course_id']; ?>" value="<?php echo $courses_o['course_id']; ?>" onclick="javascript:show_radio_uncheck_opt(this.value,document.course.elements['course_b']),checkrate();" ></div>
				        <div class="admin_agreementdonttext"><label for="disagree<?php echo $courses_o['course_id']; ?>">I Don't Agree</label> </div>
				    </div>
		    	</div>
				<div class="clearboth"></div>
	<?php 	} ?>
<?php  }?>

