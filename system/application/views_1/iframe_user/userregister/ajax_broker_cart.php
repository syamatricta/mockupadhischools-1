
<?php

$this->load->view("iframe_user/userregister/register_course_broker_mandatory");?>
<div class="clearboth">&nbsp;</div>
<?php /* SHIPPING */
	$this->load->view("iframe_user/register/register_shpping_course");
	/* PAYMENT */
	$this->load->view('iframe_user/register/registration_payment_details');?>
	<div class="clearboth">&nbsp;</div>

<?php 
$carr = array();
foreach($courses as $coursearr){ 
		$carr[] 	= Array('course_id'=> $coursearr->course_id , 'course_name' => $coursearr->course_name, 'amount' =>$coursearr->amount);
}
$jsonscript =  json_encode($carr);
?>
<input type="hidden" id="hidJson" name="hidJson" value='<?php echo $jsonscript; ?>'/>
<input type="hidden" name="sel_course_b" id="sel_course_b" value="0"  />
<input type="hidden" name="sel_course_m" id="sel_course_m" value="0"  />