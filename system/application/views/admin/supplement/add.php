<?php echo form_open_multipart('supplement/add/', array('name'=>'frmAddSupplement','id' => 'frmAddSupplement')); ?>
<div class="adminmainlist">	
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
		<div class="clearboth paddingtop"></div>
	</div>	
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">	
		<div id="errordisplay" class="page_error"><?php if (isset($error) && ''!= $error) : echo ''.$error.''; endif;?></div>
		<div class="page_error"><?php echo $this->session->flashdata("error"); ?></div>
		<div class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success"); ?></div>
		<div class="clearboth paddingtop">&nbsp;</div>
		<div class="listdata form_wrapper">
				<div class="floatleft region_leftlabel">Course<span class="red_star">*</span></div>
				<div class="floatleft region_midcolon">:</div>
				<div class="floatleft course_div">
					<select name="course_id" id="course_id" onchange="getEditions();">
						<option value="">Select Course</option>
						<?php 
							foreach($courses as $course){ ?>
								<option value="<?php echo $course->id?>"<?php echo ($this->input->post('course_id')==$course->id)?"Selected":''?> ><?php echo $course->course_name?></option>			
						<?php }?>
					</select>
					<img id="edition_wait" src="<?php echo c('images');?>indicator.gif" />
				</div>
				<div class="clearboth paddingtop"></div>
				<div class="floatleft region_leftlabel">Edition<span class="red_star">*</span></div>
				<div class="floatleft region_midcolon">:</div>
				<div class="floatleft" id="edition_div">
					<select name="edition_id" id="edition_id" >
						<option value="">Select Edition</option>
						<?php 
							foreach($editions as $edition){ ?>
								<option value="<?php echo $edition->id?>"<?php echo ($this->input->post('edition_id') == $edition->id)?"Selected":''?> >
								Edition <?php echo $edition->edition_no;?> <?php echo ($edition->default_edition == 1)? "<b>(Default)</b>":""	; ?></option>
						<?php }?>
					</select>					
				</div>
				<div class="clearboth paddingtop"></div>
				<div class="multi_row">
					<label for="title_1">Title<span class="red_star">*</span></label><span class="sep_col">:</span><input type="text" name="title[]" id="title_1" maxlength="40" class="<?php echo (isset($title_err_fld) && in_array(0, $title_err_fld)) ? 'err': '';?>" value="<?php echo (isset($_POST['title'][0])) ? $_POST['title'][0] : '';?>" />
					<label for="file_1" class="file_label" style="padding-top:5px;">File (pdf only)<span class="red_star">*</span></label><input type="file" name="file_0" id="file_1" class="<?php echo (isset($file_err_fld) && in_array(0, $file_err_fld)) ? 'err': '';?>" />
				</div>	
				<div id="addmore_div">
					<?php
						if(isset($_POST['title']) && count($_POST['title']) > 1){
							foreach ($_POST['title'] as $key => $title ){
								if(0 == $key){continue;}
								$fld_id = $key+1;
								?>
									<div class="multi_row" id="addmore_div_<?php echo $fld_id;?>" >
										<label for="title_<?php echo $fld_id;?>">Title<span class="red_star">*</span></label>
										<span class="sep_col">:</span>
										<input type="text" name="title[]" id="title_<?php echo $fld_id;?>" 
												maxlength="40"
												class="<?php (in_array($key, $title_err_fld)) ? 'err': '';?>"  
												value="<?php echo (isset($_POST['title'][$key])) ? $_POST['title'][$key] : '';?>"/>
										<label for="file_<?php echo $fld_id;?>" class="file_label" style="padding-top:5px;">File (pdf only)<span class="red_star">*</span></label>
										<input type="file" name="file_<?php echo $key;?>" id="file_<?php echo $fld_id;?>" 
												class="<?php echo (in_array($key, $file_err_fld)) ? 'err': '';?>" />
										<a id="remove_row_<?php echo $fld_id;?>" class="remove_row" onclick="removeRow(<?php echo $fld_id;?>, 'add')" title="Remove"></a>
									</div>
								<?php
							}
						}
					?>
				</div>
				<div class="clearboth paddingtop"></div>
				<div class="floatleft region_leftlabel">&nbsp;</div>
				<div class="floatleft region_midcolon">&nbsp;</div>
				<div class="floatleft"><a class="add_more" onclick="addMoreSuppliment()">Add More</a></div>
				<div class="clearboth paddingtop"></div>
				<div class="clearboth paddingtop"></div>
				<div class="subregion_addbutton">
					<input id="supplement_add" type="button" onclick="return validateSupplement('add');" name="supplement_add" value="Add">
				</div>
				<div class="clearboth"></div>
		</div>
	</div>
	
	<div class="backtolist"><?php echo anchor('supplement/all/','<< Back to Supplement Summary')?></div>
 </div>
<?php echo form_close();?>




