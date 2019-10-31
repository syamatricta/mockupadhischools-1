<?php 
$attributes = array( 'name' => 'upload_exam_form');
$url='admin_exam/upload_file/'.$course_id;
echo  form_open_multipart($url,$attributes);?>
<div class="adminmainlist">
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo ucfirst($page_title)?></div>
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
			
			<div class="form-fields"  style="height:30px">
				<div class="floatleft" style="width:40%;">&nbsp;</div>
				<div class="floatleft" style="width:10%;">Upload</div>
				<div class="floatleft" style="width:45%;">
					<input type="file" name="userfile" id="userfile">(only .xls file)
				</div>
			</div>
			<div class="form-fields"  style="height:30px;">
				<div class="floatleft" style="width:40%;">&nbsp;</div>
				<div class="floatleft" style="width:10%;">Course</div>
				<div class="floatleft" style="width:30%;">
					<select name="course" id="course" onchange="ajax_load_edition();">
					<?php foreach($course as $data){/*if(!$data['child_cnt']){*/?>
						<option value="<?php  echo $data['id'];?>" <?php if($data['id']==$course_id){?>selected="selected"<?php }?>><?php echo $data['course_name']?></option>
					<?php /*}*/}?>
					</select>
					<?php $i=1;$j=1; foreach($course as $data){?>
					<?php if($data['exam_status']=='E'){?>
						<input type="hidden" value="<?php echo $data['id'];?>" id="disable_course<?php echo $j?>" >
					<?php $j++;} if($data['qn_count']){?>
						<input type="hidden" value="<?php echo $data['id'];?>" id="exist_course<?php echo $i?>" >
					<?php $i++;} }?>
						<input type="hidden" value="<?php echo $i?>" id="count" >
						<input type="hidden" value="<?php echo $j?>" id="count_enable" >
				</div>
                <div class="floatleft" style="width:20%;">
                    <input type="checkbox" value="Y" id="replace_old_questions" name="replace_old_questions"> <label for="replace_old_questions">Remove old Questions</label>
                </div>
			</div>		
			<div class="form-fields"  style="height:30px">
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
			<div class="form-fields"  style="height:30px">
				<div class="floatleft" style="width:50%;">&nbsp;</div>
				<div  class="floatleft" style="width:10%;">
					<input type="submit" value="Upload" onclick="javascript:return validate_upload_file();">
				</div>
			</div>
			<div class="backtolist">
				<a href="<?php echo site_url()?>admin_exam/"><< Back to list</a>
			</div>
		</div>
	</div>
</form>