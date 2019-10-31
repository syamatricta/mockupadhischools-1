<?php page_heading('Classroom' , 'banner-inner'); ?>
<div class="text-right" style="margin-right:8%;">		
    <span><a href="<?php echo base_url(); ?>">Home</a></span>		
    <span class="content">|Classroom</span> 		
</div>
<div class="divide40"></div>
<div class="container margin40">
	<?php $chapter_title_str = '';?>
	<div class="col-sm-11 col-sm-offset-1">
		<?php echo  form_open ('classroom/view', array('name'=>'classroom_video_form','id' => 'classroom_video_form', 'class' => '')); ?>
		<div class="row">
			<div class="col-md-6">
				<div class="heading_band margin10">Course</div>
				<div>
					<select name="course" id="course" class="form-control" ">
                		<option>--Select Course--</option>
                		<?php foreach($courses as $course): ?>
                			<option value="<?php echo $course->id?>" <?php echo ($course_id ===  $course->id) ? "SELECTED" : "" ?>><?php echo $course->course_name?></option>
                			<?php $chapter_title_str = ($course_id ===  $course->id) ?  $course->course_name : $chapter_title_str; ?>
                		<?php endforeach;?>
                	</select>
				</div>
			</div>
			<div class="col-md-6">
			</div>
			<div class="col-md-6">
				<div class="heading_band margin10">Chapter</div>
				<div>
					<select name="chapter" id="chapter" class="form-control">
                		<option value="0">--Select Chapter--</option>
                		<?php if(isset($chapters)): ?>
                			<?php foreach($chapters as $chapter): ?>
                				<option value="<?php echo $chapter->id; ?>" <?php echo ($chapter_id ===  $chapter->id) ? "SELECTED" : "" ?>><?php echo $chapter->quiz_name; ?></option>
                				<?php $chapter_title_str = ($chapter_id ===  $chapter->id) ?  $chapter_title_str. ' > ' . $chapter->quiz_name : $chapter_title_str; ?>
                			<?php endforeach; ?>
                		<?php endif; ?>
                	</select>
				</div>
			</div>
		</div>
		<?php echo form_close();?>
		<div class="row" id="show-videos-wrapper">
			<div class="col-md-12">
				<div id="chapter-title" class="heading_band margin10"><?php echo $chapter_title_str;?></div>	
			</div>
			<?php if(!empty($videos)):?>
	           	<?php foreach($videos as $video):?>
		            <div class="row" id="show-videos">
					<?php $file_path = $this->config->item('quiz_video_location') . trim($video->video);?>
						<div class="col-sm-8 col-sm-offset-2">
							 <video width="100%"  controls="controls">
							  <source src="<?php echo $file_path ?>" type="video/mp4">
								Your browser does not support the video tag.
							</video> 
						</div>
						<div class="col-sm-8 col-sm-offset-2 margin20">
							<div class="checkbox" >
        						<input type="checkbox" <?php echo ($video->watched == TRUE) ? 'checked' : '' ;?> 
			           						   name="mark_as_watched"  
			           						   id="mark_as_watched"  class="mark_as_watched"
			           						    data-videoid="<?php echo $video->id; ?>">
						        <label for="mark_as_watched" id="mark-as-watched-label-<?php echo $video->id; ?>">
						          <?php echo ($video->watched) ? "Watched" : "Mark as watched" ;?> 
						        </label>
							</div>							 
						</div>
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo nl2br($video->description); ?>
						</div>
					</div>
			  	<?php endforeach; ?>
	           		<!-- pagination -->
	           		<?php if(isset($paginate)):?>
	           			<div  class="quiz_result_paginate__"><?php  echo $paginate;?></div>
	           		<?php endif; ?>
	        <?php else: ?>
	           		<?php if((isset($course_id) && !empty($course_id)) || (isset($chapter_id) && !empty($chapter_id))):?>
           				<div class="col-md-12 page_error" style="padding-top: 20px;"><center>No videos for this chapter</center></div>
           			<?php else: ?>
           				<div class="col-md-12 page_error" style="padding-top: 20px;"><center>Please select course and chapter.</center></div>
           			<?php endif; ?>
           	<?php endif;?>
		</div>
	</div>
</div>
