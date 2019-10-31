<div><b>Pick your package:</b></div>
<div  class="filedforrate"  >
	<input type="hidden" name="courseprice<?php echo $courses[0]->id; ?>" id="courseprice<?php echo $courses[0]->id; ?>"
           value="<?php echo $courses[0]->amount; ?>"
    />
	<div style="float:left"><input type="radio"  class="bcheck" name="course_b" id="course_b"
                                   value="<?php echo $courses[0]->id; ?>"
                                   data-books-count="<?php echo $courses[0]->books_count; ?>"
                                   onClick="javascript:show_radio_package_check_opt(this.value,document.course.elements['course_b']), checkrate();"     />
	<label for="course_b"><?php echo "$".$courses[0]->amount;?></label></div>
	<div style="float:left; margin-left:500px;"><a href="javascript:void(0);" onmouseover="javascript:show_courses_list(); return false;" onmouseout="javascript:hide_courses_list(); return false;" >Show me the course list</a></div>
	<div class="clearboth"></div>
	<input type="hidden" name="sel_package" id="sel_package" value=""  />
	<div style="width:200px; left:720px; top:290px; display: none; font-size:13px; padding:10px; border:1px solid #C2C2C2; background-color:#F7F9F8 ;" id="show_broker_livecourse"">
		<?php $n = 1;
		foreach($course_weight as $course){
			echo $n.". ".$course->course_name."<br/>";
			$n++;
		}
		?>
	</div>
	<input type="hidden" name="weight" id="weight" value="<?php echo $total_weight;?>" />
</div>
 <div class="filedforrate paddingbottom" id="showdiv<?php echo  $courses[0]->id; ?>" style="display:none;" >
	<div class="admin_agreementbox">
		<div class="admin_agreementinnerbox">
			<?php $this->load->view('register/course_agreement')?>
		</div>								
	</div>
    <div  class="filedforterm agreement" >
		<div class="agreementagreecheck"><input type="checkbox" name="agree<?php echo $courses[0]->id; ?>" id="agree<?php echo $courses[0]->id; ?>" value="<?php echo $courses[0]->id; ?>" onclick="javascript:show_broker_packagecheck(this.value,<?php echo $courses[0]->amount; ?>), checkrate();"></div>
        <div class="admin_agreementagreetext"><label for="agree<?php echo $courses[0]->id; ?>">I Agree</label></div>
        <div class="floatleft"><input type="checkbox" name="disagree<?php echo $courses[0]->id; ?>" id="disagree<?php echo $courses[0]->id; ?>>" value="<?php echo $courses[0]->id; ?>" onclick="javascript:show_broker_packageuncheck(this.value), checkrate();"  /></div>
        <div class="admin_agreementdonttext"><label for="disagree<?php echo $courses[0]->id; ?>">I Don't Agree</label> </div>
    </div>
</div>
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
<!--			<img  src="<?php  echo ssl_url_img();?>innerpages/sub_btn.jpg" onclick="javascript:addcourses();" class="stylebutton" />-->
                    <input type="image"  src="<?php  echo ssl_url_img();?>innerpages/sub_btn.jpg" onclick="javascript:return addcourses();" class="stylebutton" id="sb_btn"/>
                        <span  id="newimg" style="display:none;"></span>
		</div>
	</div>
	 <!--<input type="hidden" name="totalprice"  id="totalprice"  value="<?php #echo $courses[0]->amount; ?>" />-->
	
	