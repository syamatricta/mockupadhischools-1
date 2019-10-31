<?php 	if($license == 'S'){?>
<div class="class_optional margin10">The candidates can pick from one of the below</div>
<input type="hidden" name="s_courseprice" id="s_courseprice" value="0"  />
<div class="row">
	<div class="col-sm-12">
 <?php 	foreach($courses_o as $courses_o){ ?>
 	<input type="hidden" name="courseprice<?php echo $courses_o['course_id']; ?>" id="courseprice<?php echo $courses_o['course_id']; ?>" value="<?php echo $courses_o['amount']; ?>"  />
 	<input type="hidden" name="courseweight_b<?php echo $courses_o['course_id']; ?>" id="courseweight_b<?php echo $courses_o['course_id']; ?>" value="<?php echo $courses_o['wieght']; ?>"  />
	<input type="hidden" name="selagreeop<?php echo $courses_o['course_id']; ?>" id="selagreeop<?php echo $courses_o['course_id']; ?>" value="0" />
 	
 		<div class="col-sm-6">
	 		<div class="radio radio-danger">
				<input type="radio" name="course_bp" id="course_b<?php echo $courses_o['course_id']; ?>" value="<?php echo $courses_o['course_id']; ?>" data-courseweight="<?php echo $courses_o['wieght']; ?>" data-course_name="Package 1" >
                                <label for="course_b<?php echo $courses_o['course_id']; ?>" class="text-uppercase"><?php echo $courses_o['course_name']; ?></label>
			</div>
	 		
	 	</div>
 	
 	 
 <?php 	} ?>
 </div>
</div>
<?php  }?>

 
<input type="hidden" name="sel_course_b" id="sel_course_b" value="0"  />
<input type="hidden" name="sel_course_m" id="sel_course_m" value="0"  />