<script src="<?php echo base_url();?>js/jwplayer/jwplayer.js"></script>
<div class="floatleft">
	<div class="left_cntnr" style="position: relative;"><?php $this ->load->view('left_content.php');?></div>
    <div class="right_cntnr">
    	<div class="right_cntnr_bg_hd">
    		<div class="floatleft" style="width:100%;">
    			<div class="sitepagehead"><h1>Classroom</h1></div>
    			<div class="username"><?php disp_loggedin_username(); ?></div>
			 </div>
        </div>
        <div class="right_cntnr_bg">
        	<?php $this->load->view('second_navigation');?>
        	<?php $chapter_title_str = '';?>
        	<?php echo  form_open ('classroom/view', array('name'=>'classroom_video_form','id' => 'classroom_video_form', 'class' => '')); ?>
        		<div id="maindiv">
        			<?php /*functional part */?>
        			<div class="clearboth">&nbsp;</div>
        			<div class="profileinnercontentdiv">
	        			<center>
	        				<div id="classroom-div">
	        				
	        					<div class="page_error" id="errordisplay"></div>
	                        	<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error"); ?></div>
	                            <div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
	                            <div class="clearboth">&nbsp;</div>
	                            
	                            <!-- Course -->
	                            <div class="testbox_label width120">Course</div>
	                            <div class="select_box_div">
	                            	<select name="course" id="course" class="styled" onchange = "ajax_load_chapters();">
	                            		<option>--Select Course--</option>
	                            		<?php foreach($courses as $course): ?>
	                            			<option value="<?php echo $course->id?>" <?php echo ($course_id ===  $course->id) ? "SELECTED" : "" ?>><?php echo $course->course_name?></option>
	                            			<?php $chapter_title_str = ($course_id ===  $course->id) ?  $course->course_name : $chapter_title_str; ?>
	                            		<?php endforeach;?>
	                            	</select>
	                            </div>
	                            
	                            <!-- chapter -->
	                            <div class="testbox_label">Chapter</div>
	                            <div class="select_box_div">
	                            	<select name="chapter" id="chapter" class="styled" onchange="goto_list();">
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
	                  	</center>
	               	</div>
	    		</div>
           	<?php echo form_close();?>
           	<div class="clearboth"></div>
           	
         	<div id="show-videos-wrapper">
         		<!--<div class="border_bottom">&nbsp;</div>-->
           		<div id="chapter-title"><?php echo $chapter_title_str;?></div>	
           		<div class="border_bottom">&nbsp;</div>
           		<?php if(!empty($videos)):?>
	           		<?php foreach($videos as $video):?>
		           		<div id="show-videos">
		           			<div id="show-video-single">
		           				<div id="video-player" class="floatleft">
		           					<?php $file_path = $this->config->item('quiz_video_location') . trim($video->video);?>
		           					<!--<video id='classroom-video_<?php echo $video->id;?>' src="<?php echo $file_path; ?>" ></video>-->
		           					<div id='classroom-video_<?php echo $video->id;?>'  ></div>
		           					<!-- loading player -->
		 							<script type="text/javascript">
		 								jwplayer("classroom-video_<?php echo $video->id;?>").setup({
		 									//autostart: true,
		 									width: 400,
			 								flashplayer: "<?php echo base_url()?>/js/jwplayer/player.swf?file=<?php echo $file_path; ?>",
			 								file: "<?php echo $file_path; ?>"
				 								
				 						});
				 					</script>
		           				</div>
		           				<div id="show-video-single-right" class="floatleft">
			           				<div id="mark-as-watched-div">
			           					<span id="mark-as-watched-label-<?php echo $video->id; ?>" name="mark-as-watched-label-<?php echo $video->id; ?>" >
			           						<?php echo ($video->watched) ? "Watched" : "Mark as watched" ;?> 
			           					</span>
			           					<input type="checkbox" 
			           						    <?php echo ($video->watched == TRUE) ? 'checked' : '' ;?> 
			           						   name="mark_as_watched" 
			           						   id="mark_as_watched" 
			           						   onchange="add_remove_watch_list(this,'<?php echo $video->id; ?>');" />  
			           				</div>
			           				<div id="video-description" class="floatleft"><?php echo nl2br($video->description); ?></div>
		           				</div>
		           			</div>
		           			<div class="clearboth"></div>
		           			<div class="border_bottom">&nbsp;</div>
		           			
		           		</div>
		           		<div class="clearboth"></div>
	           		<?php endforeach; ?>
	           		<!-- pagination -->
	           		<?php if(isset($paginate)):?>
	           			<div  class="quiz_result_paginate__"><?php  echo $paginate;?></div>
	           		<?php endif; ?>
	           	<?php else: ?>
	           		<?php if((isset($course_id) && !empty($course_id)) || (isset($chapter_id) && !empty($chapter_id))):?>
           				<div class="page_error" style="padding-top: 20px;"><center>No videos for this chapter</center></div>
           			<?php else: ?>
           				<div class="page_error" style="padding-top: 20px;"><center>Please select course and chapter.</center></div>
           			<?php endif; ?>
           		<?php endif;?>
           	</div>
		</div>
    </div>
</div>

<style type="text/css">
        body {
        font-family: Arial, Helvetica, sans-serif;
        text-align: left;
        padding: 0px;
        margin-top:0px;
        background:url(<?php echo base_url().'images/bg_01.jpg'?>) #000000 no-repeat center top;
        height:auto;
        }
</style>