<?php	/* SALES MANDATORY COURSES*/
			$this->load->view("admin/register/register_course_sales_mandatory");
			/* SALES OPTIONAL COURSES */
			$this->load->view("admin/register/register_course_sales_optional");?>
<div class="clearboth">&nbsp;</div>
<div id='show_ship_div_select'>
<?php 	/* SHIPPING */
	$this->load->view("admin/register/register_shpping_course");
	/* PAYMENT */?>
</div>
<div  class="filedforrate " id="grid"></div>
<div id='show_payment_div_select'>
<?php	$this->load->view('admin/register/registration_payment_details');?>
</div>
<div class="clearboth">&nbsp;</div>
			   		<div align="center" class="rightsidedata_register" style="text-align:center; width:50%;">
<!--						<img  src="<?php  echo ssl_url_img();?>innerpages/sub_btn.jpg" onclick="javascript:addcourses();" class="stylebutton" />-->
                                                <input type="image"  src="<?php  echo ssl_url_img();?>innerpages/sub_btn.jpg" onclick="javascript:return addcourses();" class="stylebutton" id="sb_btn"/>
                                                <span  id="newimg" style="display:none;"></span>
					</div>
	        	</div>
                        <?php
$carr = array();
foreach($courses as $coursearr){
		$carr[] 	= Array('course_id'=> $coursearr->course_id , 'course_name' => $coursearr->course_name, 'amount' =>$coursearr->amount);
}
$jsonscript =  json_encode($carr);
?>
<input type="hidden" id="hidJson" name="hidJson" value='<?php echo $jsonscript; ?>'/>
