<span class="package_span margin-left58">
    <img  src="<?php  echo ssl_url_img();?>radio_nonselection.png" width="13" height="13" id="course_bimg" onClick="javascript:show_radio_package_check_opt(<?php echo $courses[0]->acpid; ?>,document.course.elements['course_p']), checkrate();"/>&nbsp;&nbsp;
    <input type="radio"  class="bcheck display-none" name="course_b" id="course_b"
           value="<?php echo $courses[0]->acpid; ?>"
           data-books-count = "<?php echo $courses[0]->books_count; ?>"
           onClick="javascript:show_radio_package_check_opt(this.value,document.course.elements['course_b']), checkrate();"     />
    <label for="course_b"><b>Pick your package:</b></label><br></span>
<div  class="filedforrate margin-left58"  >
	<input type="hidden" name="courseprice<?php echo $courses[0]->acpid; ?>" id="courseprice<?php echo $courses[0]->acpid; ?>" value="<?php echo $courses[0]->amount; ?>"  />
	<div style="float:left; padding-top:20px;">
		<!--<input type="radio"  class="bcheck" name="course_b" id="course_b" value="<?php echo $courses[0]->id; ?>" onClick="javascript:show_radio_package_check_opt(this.value,document.course.elements['course_b']), checkrate();"     />-->
<!--		<div  class="bcheck" name="course_b" id="course_b" onClick="javascript:show_radio_package_check_opt(<?php echo $courses[0]->acpid; ?>,document.course.elements['course_b']), checkrate();" style="font-size:30px; text-align:center; float:left; font-weight:bold; cursor:pointer; color:#A6CE35; width:118px; height:75px; background:url(<?php echo $this->config->item('images').'pricebox.png'; ?>) no-repeat ; padding:20px;"><?php echo "$".$courses[0]->amount;?></div>-->
            <!--div  class="bcheck" name="course_b" id="course_b" style="font-size:30px; text-align:center; float:left; font-weight:bold;color:#A6CE35; width:118px; height:75px; background:url(<?php echo $this->config->item('images').'pricebox.png'; ?>) no-repeat ; padding:20px;"><?php echo "$".$courses[0]->amount;?></div-->
            
        <div class="fl">
        	<input type="button" class="button_green" value="<?php echo "$".$courses[0]->amount;?>" />
        </div>   
		<div style="float:left; margin-left:330px;">
			<a href="javascript:void(0);" style="color:#A5CE34" onmouseover="javascript:show_courses_list(); return false;" onmouseout="javascript:hide_courses_list(); return false;" class="show_me_btn">
					<h4>Show Me the Course list</h4>
			</a>
			
			</div>
	</div>
	<div class="clearboth"></div>
	
	<div style=" display: none; font-size:13px; background:url(<?php echo $this->config->item('images').'tooltip.png';?>) no-repeat ; " id="show_broker_livecourse"">
		<div style="padding:20px 70px 0px; line-height:25px;">
		<?php $n = 1;
		foreach($course_weight as $course){
			echo '<span class="package_span">'.$n.'</span>'."<span style='color:#A1A5A4; padding-left:10px;'>".$course->course_name."</span><br/>";
			$n++;
		}
		?>
		</div>
	</div>
	<input type="hidden" name="weight" id="weight" value="<?php echo $total_weight;?>" />
        <input type="hidden" name="selagree<?php echo $courses[0]->acpid; ?>" id="selagree<?php echo $courses[0]->acpid; ?>" value="0" />
</div>
<div class="filedforrate paddingbottom" id="showdiv<?php echo  $courses[0]->acpid; ?>" style="display:none;" >
	
	<div class="license_agreement_wrapper"> 
        	<div class="example">
            <div id="main_content" style="height:90%;">
                <div class="parent">
                	<?php $this->load->view('register/course_agreement')?>
                 </div>
            </div>
        </div>
        <div class="custom_checkbox clearfix">
        	<div  class="filedforterm agreement" >
				<div class="agreementagreecheck fl"><img  src="<?php  echo ssl_url_img();?>checkbox_uncheck.png" width="25" height="24" id="agree<?php echo $courses[0]->acpid; ?>" onclick="javascript:show_broker_packagecheck(<?php echo $courses[0]->acpid; ?>,<?php echo $courses[0]->amount; ?>), checkrate();"/><!--<input type="checkbox" name="agree<?php echo $courses[0]->id; ?>" id="agree<?php echo $courses[0]->id; ?>" value="<?php echo $courses[0]->id; ?>" onclick="javascript:show_broker_packagecheck(this.value,<?php echo $courses[0]->amount; ?>), checkrate();">--></div>
		        <div class="agreementagreetext fl" onclick="javascript:show_broker_packagecheck(<?php echo $courses[0]->acpid; ?>,<?php echo $courses[0]->amount; ?>), checkrate();">I Agree</div>
		        <div class="fl"><img  src="<?php  echo ssl_url_img();?>checkbox_uncheck.png" width="25" height="24" id="disagree<?php echo $courses[0]->acpid; ?>" onclick="javascript:show_broker_packageuncheck(<?php echo $courses[0]->acpid; ?>), checkrate();"/><!--<input type="checkbox" name="disagree<?php echo $courses[0]->id; ?>" id="disagree<?php echo $courses[0]->id; ?>>" value="<?php echo $courses[0]->id; ?>" onclick="javascript:show_broker_packageuncheck(this.value), checkrate();"  />--></div>
		        <div class="agreementdonttext fl" onclick="javascript:show_broker_packageuncheck(<?php echo $courses[0]->acpid; ?>), checkrate();">I Don't Agree</div>
		    </div> 
		    <div class="clearboth"></div>                  
        </div>
	</div>
		 
	 
</div>
<div class="clearboth">&nbsp;</div>
<!--<div id='show_ship_div_select'>-->
<?php 
/* SHIPPING */
			$this->load->view("iframe_user/register/register_shpping_course");
			/* PAYMENT */
			$this->load->view('iframe_user/register/registration_payment_details');?>
		<div  class="filedforrate " id="grid"></div>



<?php
/* SHIPPING */
	//$this->load->view("admin/register/register_shpping_course");
	/* PAYMENT */?>
<!--</div>
-->
<!--<div id='show_payment_div_select'>-->
<?php	//$this->load->view('admin/register/registration_payment_details');?>
<!--</div>
<div class="clearboth">&nbsp;</div>
	<div align="center" class="rightsidedata_register" style="text-align:center; width:50%;">
	<img  src="<?php  echo ssl_url_img();?>innerpages/sub_btn.jpg" onclick="javascript:addcourses();" class="stylebutton" /><span  id="newimg" style="display:none;"></span>
</div>
</div>-->