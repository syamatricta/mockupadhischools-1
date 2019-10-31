<?php 
$attributes = array( 'name' => 'upload_exam_form');
$url='admin_exam/upload_file/'.$course_id;
echo  form_open_multipart($url,$attributes);?>
	<div>
		<div class="form-fields"  style="height:20px">
			<div class="display_error" id="display_error">
				<?php if(validation_errors()){
						echo validation_errors();
					}
					if(isset($msg) && $msg!='' )
						echo $msg;	
				?>
			</div>
			<div  id="error"  class="display_error" id="display_error">	</div>
		</div>
		<div class="form-fields"  style="height:20px">
			<div class="filed">Upload</div>
			<div class="filed">
				<input type="file" name="userfile" id="userfile">
			</div>
		</div>
		<div class="form-fields"  style="height:20px">
			<div class="filed">License Type</div>
			<div class="filed">
				<?php echo $licensetype;?>
			</div>
		</div>
		
		<div class="form-fields"  style="height:20px;">
			<div class="filed">Course</div>
			<div class="filed">
				<?php echo $data->course_name;?>
			</div>
		</div>		

		<div class="form-fields"  style="height:20px">
			<div class="filed">&nbsp;</div>
			<div class="filed">
				<input type="submit" value="Upload" onclick="javascript:return validate_upload_file();">
			</div>
		</div>
		
	</div>
</form>