<?php 
$attributes = array( 'name' => 'frmAdhi','id'=>'frmAdhi');
$url='dictionary/add';
echo  form_open($url,$attributes);?>
<div class="adminmainlist">
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo ucfirst($page_title)?></div>
	</div> <!-- end of  adminpagebanner -->
	
	<div class="admininnercontentdiv">
		<div  class="page_error" id="display_server_error" align="center">				
					<?php 
						if($this->session->flashdata('msg'))
							echo $this->session->flashdata('msg');
						if(isset($msg) && '' != $msg) {
							echo $msg;
						}
					?>
			</div>
			<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
			<div  id="error"  class="page_error" align="center" id="display_error">	</div>
						
			<div class="form-fields"  style="height:20px">
				<div class="floatleft" style="width:30%;">&nbsp;</div>
				<div class="floatleft" style="width:10%;">Keyword<span class="red_star">*</span> :</div>
				<div class="floatleft" style="width:45%;"> 
					<?php
						$keyword = '';
						if(isset($_POST['dctKeyword']) && '' != $_POST['dctKeyword']) {
							$keyword = $_POST['dctKeyword'];
						}
					?>
					<input type="text" maxlength="150" name="dctKeyword" id="dctKeyword" value="<?php echo $keyword;?>"> 
				</div>
			</div>
			
			<div class="form-fields"  style="height:60px">
				<div class="floatleft" style="width:30%;">&nbsp;</div>
				<div class="floatleft" style="width:10%;">Definition<span class="red_star">*</span> :</div>
				<div class="floatleft" style="width:45%;"> 
					<?php
						$definition = '';
						if(isset($_POST['dctDefinition']) && '' != $_POST['dctDefinition']) {
							$definition = $_POST['dctDefinition'];
						} 
					?>
					<textarea name="dctDefinition" id="dctDefinition" cols="50" rows="2" ><?php echo $definition;?></textarea>
				</div>
			</div>
	
			<div class="form-fields"  style="height:20px">
				<div class="floatleft" style="width:40%;">&nbsp;</div>
				<div  class="floatleft" style="width:10%;">
					<input type="submit" value="Add" onclick="javascript:return validate_dictionary_details();">
				</div>
			</div>
			<div class="backtolist">
				<a href="<?echo site_url()?>dictionary/"><< Back to Listing Page</a>
			</div>
		</div>
	</div>
</form>