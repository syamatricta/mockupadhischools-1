<?php echo form_open('admin_classroom/edit') ?>
<div class="adminmainlist">
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo ucfirst($page_title)?></div>
	</div> <!-- end of  adminpagebanner -->
	
	<div class="admininnercontentdiv">
		<div class="page_error" id="errordisplay"></div>
		<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");?></div>
		<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
		<?php if (isset($error) && ''!= $error) : echo '<div class="page_error">'.$error.'</div>'; endif;?>
		<div  class="page_error" id="display_server_error" align="center">
			<?php 
				if(validation_errors()):
					echo validation_errors();
				endif;

				if($this->session->flashdata('msg')):
					echo $this->session->flashdata('msg');
				endif;
								
			?>
		</div>
		<div  id="error"  class="page_error" align="center" id="display_error">	</div>
			
			<input type="hidden" name="video-id" id="video-id" value="<?php echo $video->id; ?>" />	
			<!-- Course list -->	
			<div class="form-fields"  style="height:20px">
				<div class="floatleft" style="width:40%;">&nbsp;</div>
				<div class="floatleft" style="width:10%;">Course</div>
				<div class="floatleft" style="width:45%;">
					<select name="course" id="course" onchange = "ajax_load_chapters();">
						<option value="">--Select Course--</option>
						<?php foreach($courses as $course): ?>
							<option value="<?php echo $course->id?>" <?php echo ($course_id ===  $course->id) ? "SELECTED" : "" ?>><?php echo $course->course_name?></option>
						<?php endforeach;?>
					</select>
				</div>
			</div>
			<div class="form-fields"  style="height:20px">
				<div class="floatleft" style="width:40%;">&nbsp;</div>
				<div class="floatleft" style="width:10%;">Edition</div>
				<div class="floatleft" style="width:45%;">
					<select name="edition" id="edition" onchange = "ajax_load_edition_chapters();">
						<option value="">--Select Edition--</option>
						<?php 
							$edition_id_new = ($this->input->post('edition')) ? $this->input->post('edition') : $edition_id;
							if(isset($editions)):
								foreach($editions as $edition): 
						?>
							<option value="<?php echo $edition['id']; ?>" <?php echo ($edition_id ===  $edition['id']) ? "SELECTED" : "" ?>><?php echo $edition['edition_no']; ?></option>
						<?php
								endforeach; 
							endif;
						?>
					</select>
				</div>
			</div>
			<!-- chapter list -->
			<div class="form-fields"  style="height:20px">
				<div class="floatleft" style="width:40%;">&nbsp;</div>
				<div class="floatleft" style="width:10%;">Chapter</div>
				<div class="floatleft" style="width:45%;">
					<select name="chapter" id="chapter">
						<option value="">--Select Chapter--</option>
						<?php 
							if(isset($chapters)):
								foreach($chapters as $chapter): 
						?>
							<option value="<?php echo $chapter->id; ?>" <?php echo ($chapter_id ===  $chapter->id) ? "SELECTED" : "" ?>><?php echo $chapter->quiz_name; ?></option>
						<?php
								endforeach; 
							endif;
						?>
					</select>
				</div>
			</div>
			
			<!-- Video -->
			<div class="form-fields"  style="height:20px">
				<div class="floatleft" style="width:40%;">&nbsp;</div>
				<div class="floatleft" style="width:10%;">Video</div>
				<div class="floatleft" style="width:45%;">
					<input type="text" value="<?php echo set_value_without_validation('video', $video->video); ?>" name="video" id="video" />
				</div>
			</div>
			
			<?php if(isset($video->video) && !empty($video->video)) : ?>
				<!-- Video preview -->
				<div class="form-fields">
					<div class="floatleft" style="width:40%;">&nbsp;</div>
					<div class="floatleft" style="width:10%;">&nbsp;</div>
					<!-- video preview -->
					<div class="floatleft">
						<?php 
							$video_info_array = array(
								'video_id' => '0',
								'video_path' => $this->config->item('quiz_video_location') . set_value_without_validation('video', $video->video)
							);
							
							$this->load->view('partial/jwplayer', $video_info_array);
						?>
					</div>
				</div>
			<?php endif; ?>
			
			<!-- Description -->
			<div class="form-fields" >
				<div class="floatleft" style="width:40%;">&nbsp;</div>
				<div class="floatleft" style="width:10%;">Description</div>
				<div class="floatleft" style="width:45%;">
					<textarea name="description" id='description' ><?php echo set_value_without_validation('description', $video->description);  ?></textarea>
				</div>
			</div>
			
					
			<div class="form-fields"  style="height:20px">
				<div class="floatleft" style="width:55%;">&nbsp;</div>
				<div  class="floatleft" style="width:45%;">
					<input type="submit" value="Update" name="submit-video" />
					<input type="button" value="Cancel" name="cancel" onclick="cancel_action('<?php echo base_url() . "admin_classroom/view/" . @$course_id . "/" . $chapter_id; ?>')" />
				</div>
			</div>
			<div class="backtolist"> 
				<a href="<?echo site_url()?>admin_classroom/view/<?php echo @$course_id?>/<?php echo $chapter_id ?>/<?php echo $edition_id ?>"> << Back to list</a>
			</div>
		</div>
	</div>
<?php echo form_close(); ?>