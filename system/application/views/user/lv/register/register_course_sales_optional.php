<?php 	if($license == 'S'){?>
		    <div class="clearboth"></div>
		   	<div class="subhead_txt">The candidates can pick from one of the below</div>
			<div class="clearboth">&nbsp;</div>
		    <input type="hidden" name="s_courseprice" id="s_courseprice" value="0"  />
	 <?php 	foreach($courses_o as $courses_o){ ?>
				<div  class="filedforrate"  > 
					<input type="hidden" name="courseprice<?php echo $courses_o['id']; ?>" id="courseprice<?php echo $courses_o['id']; ?>" value="<?php echo $courses_o['amount']; ?>"  />
			        <input type="radio"  class="bcheck" name="course_b" id="course_b" value="<?php echo $courses_o['id']; ?>" onClick="javascript:show_opt_terms(this.value,document.course.elements['course_b']), checkrate();"     />
			        <?php echo $courses_o['course_name'] ." - $".$courses_o['amount']; ?>
			        <?php if($courses_o['id'] !=5) ?>
			        <input type="hidden" name="courseweight_b<?php echo $courses_o['id']; ?>" id="courseweight_b<?php echo $courses_o['id']; ?>" value="<?php echo $courses_o['wieght']; ?>"  />
				</div>
				<div class="clearboth">&nbsp;</div>
				<?php /* Terms and condition For Principle */ ?>
			    <div class="filedforrate paddingbottom" id="showdiv<?php echo $courses_o['id']; ?>" style="display:none;" >
					<div class="agreementbox">
						<div class="agreementinnerbox">
							<?php $this->load->view('register/course_agreement')?>
						</div>								
					</div>
				   	<div  class="filedforterm agreement" >
				   		<div class="agreementagreecheck"><input type="checkbox" name="agree<?php echo $courses_o['id']; ?>" id="agree<?php echo $courses_o['id']; ?>" value="<?php echo $courses_o['id']; ?>" onclick="javascript:show_radio_check_opt(this.value,document.course.elements['course_b']),checkrate();"></div>
				        <div class="agreementagreetext">I Agree</div>
				        <div class="floatleft"><input type="checkbox" name="disagree<?php echo $courses_o['id']; ?>" id="disagree<?php echo $courses_o['id']; ?>" value="<?php echo $courses_o['id']; ?>" onclick="javascript:show_radio_uncheck_opt(this.value,document.course.elements['course_b']),checkrate();" ></div>
				        <div class="agreementdonttext">I Don't Agree </div>
				    </div>
		    	</div>
				<div class="clearboth"></div>
	<?php 	} ?>
<?php  }?>	