<?php page_heading('Registered Courses' , 'banner-inner'); ?>
<div class="divide40"></div>
<div class="container margin40">
	<div class="col-sm-11 col-sm-offset-1">
		 <?php $i=1;
	  if(isset($courselist) && $courselist){
			foreach ($courselist as $course){ ?>
					<div class="row">
						<div class="col-md-12 margin10">							
							<span class="head_txt"><?php echo $i.".";?>&nbsp;</span>
							<a style="text-decoration: underline" href="<?php echo site_url()."quiz/quizlist/".$course->id?>" ><?php if( $course->parent_course_name) echo $course->parent_course_name ."(".$course->course_name.")"." - ".$course->course_code; else echo $course->course_name." - ".$course->course_code;  ?></a>
						</div>
					</div>
					 
		<?php	$i++; }
		
	  }?>
	</div>
</div>