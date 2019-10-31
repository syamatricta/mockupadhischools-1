<?php echo form_open_multipart('supplement/edit/'.$course_id.'/'.$edition_id, array('name'=>'frmAddSupplement','id' => 'frmAddSupplement')); ?>
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
					<?php echo $supplement_details[0]->course_name;?>
				</div>
				<div class="clearboth paddingtop"></div>
				<div class="floatleft region_leftlabel">Edition<span class="red_star">*</span></div>
				<div class="floatleft region_midcolon">:</div>
				<div class="floatleft" id="edition_div">
					<?php echo 'Edition '.$supplement_details[0]->edition_no;?><?php echo ($supplement_details[0]->default_edition == 1)? " (Default)":""	; ?>
				</div>
				<div class="clearboth paddingtop"></div>
				<?php
					foreach ($supplement_details as $supplement_detail){
				?>
					<div class="multi_row_edit" id="edit_div_<?php echo $supplement_detail->id;?>">
						<label for="edit_title_<?php echo $supplement_detail->id;?>">Title<span class="red_star">*</span></label><span class="sep_col">:</span><input type="text" name="edit_title[<?php echo $supplement_detail->id;?>]" id="edit_title_<?php echo $supplement_detail->id;?>" maxlength="40" class="<?php echo (isset($edit_title_err_fld) && in_array($supplement_detail->id, $edit_title_err_fld)) ? 'err': '';?>" value="<?php echo (isset($_POST['edit_title'][$supplement_detail->id])) ? $_POST['edit_title'][$supplement_detail->id] : $supplement_detail->title;?>" />
						<a class="supplement_download"  title="Click to download" name="<?php echo $supplement_detail->id;?>" onclick="downloadSupplement(this);" ><?php echo supplementFileName($supplement_details[0]->course_name, $supplement_details[0]->edition_no, $supplement_detail->title);?></a>
						<a id="remove_row_edit_<?php echo $supplement_detail->id;?>" class="remove_row" onclick="removeRow(<?php echo $supplement_detail->id;?>)" title="Remove supplement"></a>
						<img id="file_del_wait_<?php echo $supplement_detail->id;?>" class="wait_loading" src="<?php echo c('images');?>indicator.gif" />
						<span class="wait_overlay"></span>
					</div>
				<?php }?>
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
										<a id="remove_row_<?php echo $fld_id;?>" class="remove_row" onclick="removeRow(<?php echo $fld_id;?>, 'edit')" title="Remove"></a>
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
					<input id="supplement_update" type="button" onclick="return validateSupplement('edit');" name="supplement_add" value="Update">
				</div>
				<div class="clearboth"></div>
		</div>
	</div>
	
	<div class="backtolist"><?php echo anchor('supplement/all/','<< Back to Supplement Summary')?></div>
 </div>
<?php echo form_close();?>




