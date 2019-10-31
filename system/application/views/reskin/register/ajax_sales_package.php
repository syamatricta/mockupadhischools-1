<div class="row pack1">
	<div class="col-md-12">
		<div class="radio radio-info radio-inline">
			<input id="course_b" type="radio"   name="course_p" value="<?php echo $courses[0]->course_id; ?>"
                   data-course_id="<?php echo $courses[0]->course_id; ?>"
                   data-price="<?php echo $courses[0]->amount; ?>"
                   data-books-count="<?php echo $courses[0]->books_count; ?>"
                   data-course_name="Package 1"/>
			<label for="course_b" ><span class="package_title">Pick this package:</span> </label>			
		</div>
		<hr />
	</div>
</div>
<div class="row pack1">
	<div class="col-md-12 plr5">
		<div class="row margin10">
			<div class="col-md-3">
				 <input type="hidden" name="selagree<?php echo $courses[0]->course_id; ?>" id="selagree<?php echo $courses[0]->course_id; ?>" value="0" />
				 <input type="hidden" name="courseprice<?php echo $courses[0]->course_id; ?>" id="courseprice<?php echo $courses[0]->course_id; ?>" value="<?php echo $courses[0]->amount; ?>"  />
				 <div class="pricebox1">
				 	<span class="sign">$</span><?php echo  $courses[0]->amount; ?>
				 </div>
			</div>
			<div class="col-md-9">
				<?php  if (set_value('coursetype') == 'Online'):?>
					 
						This package contains access to our online courses with streaming video.
		                You get physical textbooks for Real Estate Principles, Real Estate Practice and your choice of an elective course listed below.
		                There’s also Chapter quizzes and exercises in the book and online to reinforce the course material.
					 
				<?php else:?>
					 Our most comprehensive package available. This includes Real Estate
		                Principles, Real Estate Practice, and your choice of an elective class. All of these
		                classes have an optional live component to them. You may attend according to
		                our schedule.                                
		        <?php endif;?> 
		     </div>
		</div>
	     <?php  /*if (set_value('coursetype') != 'Online'):?>
	     <div class="row">
                    <div class="col-sm-12">
                        <p class="mt5 f-light">This package also comes with our legendary live two-day exam prep. This is given on weekends and the itinerary is as follows:</p>                        
                       </p>
                    </div>
                    <div class="col-sm-6">
                        <div class="day bb">Saturday</div>
                        <span class="row tbborder bb">
                            <span class="col-sm-4 time"><i class="fa fa-clock-o"></i> 9am - 5pm</span>
                            <span class="col-sm-8 todo">Lecture</span>
                            
                        </span>
                    </div>
                    <div class="col-sm-6">
                        <div class="day bb">Sunday</div>
                        <span class="row tbborder bb">
                            <span class="col-sm-4 time"><i class="fa fa-clock-o"></i> 9am - 1pm</span>
                            <span class="col-sm-8 todo">Lecture</span>
                       </span>
                        <span class="row tbborder bb">
                           <span class="col-sm-4 time"><i class="fa fa-clock-o"></i> 1pm - 2pm</span>
                           <span class="col-sm-8 todo">Lunch</span>
                           
                       </span>
                        <span class="row tbborder bb bbnone">
                           <span class="col-sm-4 time"><i class="fa fa-clock-o"></i> 2pm - 5:15pm</span>
                            <span class="col-sm-8 todo">Practice mock examination with your own laptop</span>
                           
                       </span>
                    </div>
                    
				
		</div>
		<?php endif;*/?>
		<div class="row margin40">	
			<div class="col-md-12">
                            <input type="hidden" name="weight" id="weight" value="<?php echo $mandatory_course_weight; ?>" />
				<?php $this->load->view("reskin/register/register_course_sales_package_optional");?>
			</div>
		</div>

	</div>
</div>
<div class="row pack2">
	<div class="col-md-12">
		<div class="radio radio-info radio-inline">
			<input type="radio"  name="course_p" id="course_b_newpackage" value="<?php echo $courses_newpackage[0]->course_id; ?>"
                   data-price="<?php echo $courses_newpackage[0]->amount; ?>"
                   data-books-count="<?php echo $courses_newpackage[0]->books_count; ?>"
                   data-course_name="Package 2" >
			<label for="course_b_newpackage" ><span class="package_title">Pick this package:</span></label>			
		</div>
		<hr />
	</div>
</div>
<div class="row margin30">
	<div class="col-md-12 plr5">
		<div class="row">
			<div class="col-md-3">
                            <input type="hidden" name="courseprice_newpackage<?php echo $courses_newpackage[0]->course_id; ?>" id="courseprice_newpackage<?php echo $courses_newpackage[0]->course_id; ?>" value="<?php echo $courses_newpackage[0]->amount; ?>"  />
                            <input type="hidden" name="selagree_newpackage<?php echo $courses_newpackage[0]->course_id; ?>" id="selagree_newpackage<?php echo $courses_newpackage[0]->course_id; ?>" value="0" />
                            <input type="hidden" name="weight_newpackage" id="weight_newpackage" value="<?php echo $mandatory_course_weight_new_package; ?>" />
                            <div class="pricebox2">
                                   <span class="sign">$</span><?php echo $courses_newpackage[0]->amount; ?>
                            </div>
			</div>
			<div class="col-md-9">
				<?php  if (set_value('coursetype') == 'Online'):?>
					<p>
						 This includes Real Estate Principles and Real Estate Practice.  For students who have taken economics, accounting and business law in college and passed with a "C" or better.
					</p>
				<?php else:?>
					<p>This includes Real Estate Principles and Real Estate Practice.  For students who have taken economics, accounting and business law in college and passed with a "C" or better.
		            </p>
		        <?php endif;?> 
		     </div>
		</div>
		<?php /* if (set_value('coursetype') != 'Online'):?>
		     <div class="row margin30">
                        <div class="col-md-12">   
                            <p class="mt5 f-light">
                                This package also comes with our legendary live two-day exam prep. This is given on weekends and the itinerary is as follows:
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <div class="day bb">Saturday</div>
		            <span class="row tbborder bb">
		            	<span class="col-sm-4 time"><i class="fa fa-clock-o"></i> 9am - 5pm</span>
                                <span class="col-sm-8 todo">Lecture</span>
		            </span>
                        </div>
                        <div class="col-sm-6">
		            <div class="day bb">Sunday</div>
		             <span class="row tbborder bb">
                                 <span class="col-sm-4 time"><i class="fa fa-clock-o"></i> 9am - 1pm</span>
		            	<span class="col-sm-8 todo">Lecture</span>
		            </span>
		             <span class="row tbborder bb">
                                 <span class="col-sm-4 time"><i class="fa fa-clock-o"></i> 1pm - 2pm</span>
		            	<span class="col-sm-8 todo">Lunch</span>
		            	
		            </span>
		             <span class="row tbborder bb">
		            	<span class="col-sm-4 time"><i class="fa fa-clock-o"></i> 2pm - 5:15pm</span>
                                 <span class="col-sm-8 todo">Practice mock examination with your own laptop</span>
		            	
		            </span>	
		             				
                        </div>
                    </div>
		<?php endif; */?>
	</div>
</div>




<?php
    /* SHIPPING */
    $this->load->view("reskin/register/register_shpping_course");
    /* PAYMENT */
    $this->load->view('reskin/register/registration_payment_details');
?>

<input type="hidden" name="hidcrsid" id="hidcrsid" value="0">
<input type="hidden" name="hidwt" id="hidwt" value="0">