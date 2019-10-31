<?php 
$attributes = array( 'name' => 'frmCrashcourse');
$url='dictionary/upload/';
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
			<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
			<div  id="error"  class="page_error" align="center" id="display_error">	</div>
			<input type="hidden" value="0" id="exams_replace" name="exams_replace">			
			<div class="form-fields"  style="height:20px">
				<div class="floatleft" style="width:40%;">&nbsp;</div>
				<div class="floatleft" style="width:10%;">Select File<span class="red_star">*</span> :</div>
				<div class="floatleft" style="width:45%;">
					<input type="file" name="userfile" id="userfile"/> (only .xls file)
				</div>
			</div>
	
			<div class="form-fields"  style="height:20px">
				<div class="floatleft" style="width:55%;">&nbsp;</div>
				<div  class="floatleft" style="width:10%;">
					<input type="submit" value="Upload" onclick="javascript:return validate_upload_file();">
				</div>
			</div>
			<div class="backtolist">
				<a href="<?echo base_url()?>dictionary/dictionary_list/"><< Back to Listing Page</a>
			</div>
		</div>
	</div>
</form>