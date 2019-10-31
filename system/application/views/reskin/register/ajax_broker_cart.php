<?php if($license == 'B'){ $j=0;?>
<div class="row">
	<div class="col-md-12"><div class="pack_title">COURSE LIST</div></div>
	<div class="col-md-12 plr5">
		<div class="class_optional margin20">The following courses are required </div>
		<div class="row margin30">
			<div class="col-md-12 mandatory">
			<?php foreach($courses_m as $courses_m) : 
				$j = $j+1; 	?>
			<?php  		if($j == 6){ ?>
  				<div class="row">
			     <div class="col-md-12"><div class="class_optional margin20">Choose three from the bottom list </div></div>
				</div> 
			<?php 		} ?>	 
                                        <div class="row">
                                            <div class="col-md-12">
                                                
                                            
					<input type="hidden" name="courseprice<?php echo $courses_m['course_id']; ?>" id="courseprice<?php echo $courses_m['course_id']; ?>" value="<?php echo $courses_m['amount']; ?>"  />
					<div class="checkbox checkbox-danger">
						<input type="checkbox"  name="course[]" id="course<?php echo $courses_m['course_id']; ?>" value="<?php echo $courses_m['course_id']; ?>" data-price="<?php echo $courses_m['amount']; ?>"  data-course_name="<?php echo $courses_m['course_name']; ?>" data-courseweight="<?php echo $courses_m['wieght']; ?>">
						<label for="course<?php echo $courses_m['course_id']; ?>">							 
							<?php 	if($courses_m['amount'] !=0.00){
								echo trim($courses_m['course_name']) ." - $".$courses_m['amount']; 
							}else {
								echo $courses_m['course_name'] ; 
							}?>	
						</label>
					</div>
					<input type="hidden" name="selagree<?php echo $courses_m['course_id']; ?>" id="selagree<?php echo $courses_m['course_id']; ?>" value="0" />
	        		<input type="hidden" name="courseweight<?php echo $courses_m['course_id']; ?>" id="courseweight<?php echo $courses_m['course_id']; ?>" value="<?php echo $courses_m['wieght']; ?>"  />
				 </div>
                                            </div>
			<?php endforeach;?>
			</div>
		</div>
	</div>
</div>
<?php } ?>

<?php 
/* SHIPPING */
$this->load->view("reskin/register/register_shpping_course");

/* PAYMENT */
$this->load->view('reskin/register/registration_payment_details');

$carr = array();
foreach($courses as $coursearr){ 
    $carr[] 	= Array('course_id'=> $coursearr->course_id , 'course_name' => $coursearr->course_name, 'amount' =>$coursearr->amount);
}
$jsonscript =  json_encode($carr);
?>
<input type="hidden" id="hidJson" name="hidJson" value='<?php echo $jsonscript; ?>'/>
<input type="hidden" name="sel_course_b" id="sel_course_b" value="0"  />
<input type="hidden" name="sel_course_m" id="sel_course_m" value="0"  />