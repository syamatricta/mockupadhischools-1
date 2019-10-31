<?php	/* SALES MANDATORY COURSES*/
			$this->load->view("user/userregister/register_course_sales_mandatory");
			/* SALES OPTIONAL COURSES */
			$this->load->view("user/userregister/register_course_sales_optional");?>
<div class="clearboth">&nbsp;</div>
<?php 
/* SHIPPING */
			$this->load->view("register/register_shpping_course");
			/* PAYMENT */
			$this->load->view('register/registration_payment_details');?>
<div class="clearboth">&nbsp;</div>
	   		<!--<div align="center" class="rightsidedata_register" style="text-align:center; width:50%;">
				<img  src="<?php  echo ssl_url_img();?>innerpages/sub_btn.jpg" onclick="javascript:addcourses();" class="stylebutton" /><span  id="newimg" style="display:none;"></span>
			</div>-->
    	</div>
<?php 
  $carr = array();
   foreach($courses as $coursearr){ 
 		$carr[] 	= Array('course_id'=> $coursearr->course_id , 'course_name' => $coursearr->course_name, 'amount' =>$coursearr->amount);
	}
	$jsonscript =  json_encode($carr);
   ?>
	<input type="hidden" id="hidJson" name="hidJson" value='<?php echo $jsonscript; ?>'/>

