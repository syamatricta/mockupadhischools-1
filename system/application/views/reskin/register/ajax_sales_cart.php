<div class="row">
	<div class="col-md-12"><div class="pack_title">COURSE LIST</div></div>
	<div class="col-md-12 plr5">

		<div class="class_optional margin20">The following courses are required </div>
		<div class="row margin30">
			<div class="col-md-12 mandatory">
			<?php foreach($courses_m as $courses_m) : ?>
				 
					<input type="hidden" name="courseprice<?php echo $courses_m['course_id']; ?>" id="courseprice<?php echo $courses_m['course_id']; ?>" value="<?php echo $courses_m['amount']; ?>"  />
					<div class="checkbox checkbox-danger">
						<input type="checkbox"  name="course[]" id="course<?php echo $courses_m['course_id']; ?>" value="<?php echo $courses_m['course_id']; ?>"  data-price="<?php echo $courses_m['amount']; ?>"  data-course_name="<?php echo $courses_m['course_name']; ?>" data-courseweight="<?php echo $courses_m['wieght']; ?>" >
						<label for="course<?php echo $courses_m['course_id']; ?>"><?php echo trim($courses_m['course_name']) ." - $".$courses_m['amount']; ?> </label>
					</div>
					<input type="hidden" name="selagree<?php echo $courses_m['course_id']; ?>" id="selagree<?php echo $courses_m['course_id']; ?>" value="0" />
	        		<input type="hidden" name="courseweight<?php echo $courses_m['course_id']; ?>" id="courseweight<?php echo $courses_m['course_id']; ?>" value="<?php echo $courses_m['wieght']; ?>"  />
				 
			<?php endforeach;?>
			</div>
		</div>
		<div class="class_optional margin20">The candidates can pick from one of the below</div>
		<?php 	if($license == 'S'):?>
			<div class="row margin30">
				<div class="col-md-12 optionalcart">
				<?php foreach($courses_o as $courses_o): ?>
					<input type="hidden" name="courseprice<?php echo $courses_o['course_id']; ?>" id="courseprice<?php echo $courses_o['course_id']; ?>" value="<?php echo $courses_o['amount']; ?>"  />
					<input type="hidden" name="selagree<?php echo $courses_o['course_id']; ?>" id="selagree<?php echo $courses_o['course_id']; ?>" value="0" />
				    <input type="hidden" name="courseweight_b<?php echo $courses_o['course_id']; ?>" id="courseweight_b<?php echo $courses_o['course_id']; ?>" value="<?php echo $courses_o['wieght']; ?>"  />
					<div class="radio radio-danger">
						<input type="radio" name="course_b" id="course_b<?php echo $courses_o['course_id']; ?>" value="<?php echo $courses_o['course_id']; ?>" data-price="<?php echo $courses_o['amount']; ?>"  data-course_name="<?php echo $courses_o['course_name']; ?>" data-courseweight="<?php echo $courses_o['wieght']; ?>">
						<label for="course_b<?php echo $courses_o['course_id']; ?>"><?php echo trim($courses_o['course_name']) ." - $".$courses_o['amount']; ?> </label>
					</div>
				<?php endforeach;?>
				</div>
			</div>
		<?php endif;?>
	</div>
</div>

<?php	/* SALES MANDATORY COURSES*/
			
	//$this->load->view("user/userregister/register_course_sales_mandatory");
			/* SALES OPTIONAL COURSES */
	//$this->load->view("user/userregister/register_course_sales_optional"); 
 
 
    $this->load->view("reskin/register/register_shpping_course");
    /* PAYMENT */
    $this->load->view('reskin/register/registration_payment_details');
 
 
  $carr = array();
   foreach($courses as $coursearr){ 
 		$carr[] 	= Array('course_id'=> $coursearr->course_id , 'course_name' => $coursearr->course_name, 'amount' =>$coursearr->amount);
	}
	$jsonscript =  json_encode($carr);
   ?>
    <input type="hidden" name="sel_course_b" id="sel_course_b" value="0"  />
    <input type="hidden" name="sel_course_m" id="sel_course_m" value="0"  />
	<input type="hidden" id="hidJson" name="hidJson" value='<?php echo $jsonscript; ?>'/>
