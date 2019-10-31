<?php 
$attributes = array( 'name' => 'upload_exam_form');
$url='admin_quiz/upload_file/'.$course_id;
echo  form_open_multipart($url,$attributes);?>
<div class="adminmainlist">
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div> <!-- end of  adminpagebanner -->
	
	<div class="admininnercontentdiv">
	
		<div  class="page_error" id="display_server_error" align="center">
				
				<?php if(validation_errors()){
							echo validation_errors();
						}
						
					if($this->session->flashdata('msg'))
						echo $this->session->flashdata('msg');
								
					?>
			</div>
			<div  id="error"  class="page_error" align="center" id="display_error">	</div>
			
			<input type="hidden" value="0" id="exams_replace" name="exams_replace">
			
			<div class="form-fields"  style="height:20px">
				<div class="floatleft" style="width:40%;">&nbsp;</div>
				<div class="floatleft" style="width:10%;">Topic</div>
				<div class="floatleft" style="width:45%;">
					<input type="text" name="topic" id="topic" placeholder="enter a topic">
				</div>
			</div>
			
			<div class="form-fields"  style="height:20px">
				<div class="floatleft" style="width:40%;">&nbsp;</div>
				<div class="floatleft" style="width:10%;">Upload</div>
				<div class="floatleft" style="width:45%;">
					<input type="file" name="userfile" id="userfile">(only .xls file)
				</div>
			</div>
			<div class="form-fields"  style="height:20px;">
				<div class="floatleft" style="width:40%;">&nbsp;</div>
				<div class="floatleft" style="width:10%;">Course</div>
				<div class="floatleft" style="width:40%;">
			<select name="course"  id="course" onchange="ajax_load_edition();">
			<?php 
			foreach($course as $course){ 
						/*if($course->count_sub){$i=$course->count_sub */?>
						 	<!--<optgroup label=" <?php //echo  $course->course_name?>">-->
				<?php /*}*/ if($course->parent_course_id){$i--;?>
			     	 		<option value="<?php echo  $course->id?>"<?php echo ($course_id==$course->id)?"Selected":''?>><?php echo  $course->course_name?></option>
	    		<?php }else{?>
	
							<option value="<?php echo $course->id?>"<?php echo ($course_id==$course->id)?"Selected":''?> ><?php echo $course->course_name?></option>
				<?php }
						/*if($i==0){?>
						</optgroup>
				<?php }*/
			}
			?>
			</select>
				</div>
			</div>		
			<div class="form-fields"  style="height:20px">
				<div class="floatleft" style="width:40%;">&nbsp;</div>
				<div class="floatleft" style="width:10%;">Edition</div>
				<div class="floatleft" style="width:45%;">
					<select name="edition" id="edition">
						<option value="">Select Edition</option>
						<?php 
							$edition_id_new = ($this->input->post('edition')) ? $this->input->post('edition') : $edition_id;
							if(isset($editions)):
								foreach($editions as $edition): 
						?>
							<option value="<?php echo $edition['id']; ?>" <?php echo ($edition_id_new ===  $edition['id']) ? "SELECTED" : "" ?>><?php echo $edition['edition_no']; ?></option>
						<?php
								endforeach; 
							endif;
						?>
					</select>
				</div>
			</div>
			<div class="form-fields"  style="height:20px">
				<div class="floatleft" style="width:55%;">&nbsp;</div>
				<div  class="floatleft" style="width:10%;">
					<input type="submit" value="Upload" onclick="javascript:return validate_upload_file()">
				</div>
			</div>
			<div class="backtolist"><?php echo anchor(base_url().'admin_quiz/list_quiz/'.$course_id,'<< Back to list')?></div>
		</div>
	</div>
</form>