<div class="registermaindiv">
	<div class="registerinnerdiv">

  <!--functional part-->
  <div  class="filedforrate" style=" width:550px;" >
  <div  class="form-fields head_txt"> Registered Courses</div>
	<div class="clearboth">&nbsp;</div>
	  <?php $i=1;
	  if(isset($courselist) && $courselist){
			foreach ($courselist as $course){ ?>
					
					<div  class="filedforrate"> <span class="head_txt"><?php echo $i.".";?>&nbsp;</span><a href="javascript:void(null);" onclick="javascript:show_quizList('<?php echo site_url()."quiz/quizlist/".$course->id?>');"><?php if( $course->parent_course_name) echo $course->parent_course_name ."(".$course->course_name.")"." - ".$course->course_code; else echo $course->course_name." - ".$course->course_code;  ?></a></div>
					<div class="clearboth">&nbsp;</div>
					
					<div class="clearboth">&nbsp;</div>
		<?php	$i++; }
		
	  }?>



	<!--End functional part-->
	<!-- show link-->
<!--	<div  class="filed-right" style="width:300px; color:#FFFFFF; background-color:#7F0303;">
		<div  class="filedlink"><a href="#" style=" color:#FFFFFF;">My Profile</a></div>
		<div class="clearboth">&nbsp;</div>
		<div  class="filedlink"><a href="#" style=" color:#FFFFFF;">Change Password</a></div>
		<div class="clearboth">&nbsp;</div>
		<div  class="filedlink"><a href="<?php echo base_url();  ?>index.php/exam/courselist" style=" color:#FFFFFF;">Examination</a></div>
		<div class="clearboth">&nbsp;</div>
		<div  class="filedlink"><a href="#" style=" color:#FFFFFF;">Quiz Engine</a></div>
		<div class="clearboth">&nbsp;</div>

	</div>-->
	<!-- End show link-->

  </div>
  </div>