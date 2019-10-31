<div class="row pack2">
	<div class="col-md-12">
		<div class="radio radio-info radio-inline">
			<input type="radio"   name="course_b" id="course_b" value="<?php echo $courses[0]->acpid; ?>"
                   data-course_id="<?php echo $courses[0]->course_id; ?>"
                   data-price="<?php echo $courses[0]->amount; ?>"
                   data-books-count="<?php echo $courses[0]->books_count; ?>"
                   data-course_name="Package"/>
			<label for="course_b" ><span class="package_title">Package </span><br> Pick this package: </label>			
		</div>
		<hr />
	</div>
</div>
<div class="row margin50">
	<div class="col-md-12 plr5">
		<div class="row">
			<div class="col-md-3">
				 <input type="hidden" name="courseprice<?php echo $courses[0]->acpid; ?>" id="courseprice<?php echo $courses[0]->acpid; ?>" value="<?php echo $courses[0]->amount; ?>"  />
				 <input type="hidden" name="weight" id="weight" value="<?php echo $total_weight;?>" />
    			 <input type="hidden" name="selagree<?php echo $courses[0]->acpid; ?>" id="selagree<?php echo $courses[0]->acpid; ?>" value="0" />
				 <div class="pricebox1">
				 	<span class="sign">$</span><?php echo $courses[0]->amount; ?>
				 </div>
			</div>
			<div class="col-md-9 clist">
                            <div class="class_optional margin20 ">Course list</div>
                            <div class="row">
                                <?php $n = 1;
                                foreach($course_weight as $course){
                                        echo '<div class="col-md-6 margin10 text-uppercase"><i class="fa fa-arrow-circle-right"></i>&nbsp;'.$course->course_name."</div>";
                                        $n++;
                                }
                                ?>
                             </div>
                        </div>
		</div>
	</div>
</div>



 
<?php 

/* SHIPPING */
$this->load->view("reskin/register/register_shpping_course");

/* PAYMENT */
$this->load->view('reskin/register/registration_payment_details');

?>
 



