<?php echo form_open_multipart('admin_subregion/edit_subregion', array('name'=>'adminregionform','id' => 'adminregionform')); ?>
<div class="adminmainlist">
	
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div>
	
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		<div  class="page_error" id="divError">&nbsp;
			<?php  
				if(validation_errors()) echo  validation_errors();
				if(isset($error_region)) echo $error_region;
			?>
		</div>
		<div class="clearboth paddingbottom">&nbsp;</div>
		<div class="subregion_main">
				<div class="floatleft subregion_label">Region Name</div>
				<div class="floatleft subregion_midcolon">:</div>
				<div class="floatleft subregion_data"><?php echo $region;?><input type="hidden" name="sltRegion" id="sltRegion" value="<?php if(set_value('sltRegion')){ echo set_value('sltRegion');}else{echo $subregion->region_id;}?>"/></div>
				<div class="clearboth paddingtop"></div>
				<div class="floatleft subregion_label">Sub-Region Name<span class="red_star">*</span></div>
				<div class="floatleft subregion_midcolon">:</div>
				<div class="floatleft subregion_data">
					<input type="text" name="txtName" id="txtName"  value="<?php if(set_value('txtName')){ echo set_value('txtName');}else{echo $subregion->subregion_name;}?>" size="24" maxlength="40"/>
				</div>
				<div class="clearboth paddingtop"></div>
				<div class="floatleft subregion_label">Address<span class="red_star">*</span></div>
				<div class="floatleft subregion_midcolon">:</div>
				<div class="floatleft subregion_data">
					<input type="text" name="txtAddress" id="txtAddress"  value="<?php if(set_value('txtAddress')){ echo set_value('txtAddress');}else{echo $subregion->subregion_address;}?>" size="24"/>
				</div>
				<div class="clearboth paddingtop"></div>
				<div class="floatleft subregion_label">Image</div>
				<div class="floatleft subregion_midcolon">:</div>
				<div class="floatleft subregion_data">
					<input type="file" name="txtImage" id="txtImage"/>
				</div>
				<div class="clearboth"></div>
				<div class="floatleft subregion_label">&nbsp;</div>
				<div class="image_specification subregion_data">( Image formats: jpg,jpeg and png <br/>&nbsp;&nbsp;&nbsp;Max image resolution: <?php  echo $this->config->item('image_max_width');?>px x <?php  echo $this->config->item('image_max_height');?>px <br/> &nbsp;&nbsp;&nbsp;Max image size : <?php  echo $this->config->item('image_max_size');?>KB&nbsp;)</div>
				<div class="clearboth paddingtop"></div>
				<div class="floatleft subregion_label">Description<span class="red_star">*</span></div>
				<div class="floatleft subregion_midcolon">:</div>
				<div class="floatleft subregion_data">
					<textarea name="txtaDescription" id="txtaDescription" rows="3" cols="34"><?php if(set_value('txtaDescription')){ echo set_value('txtaDescription');}else{echo $subregion->subregion_description;}?></textarea>
				</div>
				<div class="clearboth paddingtop"></div>
				<div class="subregion_addbutton">
					<input type="image" name="btnUpdate" id="btnUpdate" onclick="javascript:return fncUpdateSubRegion(<?php echo $subregion->id;?>,<?php echo $page_no;?>);" src="<?php  echo $this->config->item('images');?>innerpages/user_submit.jpg" />
				</div>
				<div class="clearboth"></div>
		</div>
		<div class="floatleft">
			<?php
				$full_image = $this->config->item('image_upload_path').'thumbs/'.$subregion->image_name;
				if($subregion->image_name && file_exists($full_image)){
					$full_image = $this->config->item('image_upload_url').'thumbs/'.$subregion->image_name;
				}else{
					$full_image = $this->config->item('images').'default_image.jpg';
				}	
			?><img src="<?php echo $full_image;?>" /></div>
	</div>
	
	<div class="backtolist"><?php echo anchor('admin_subregion/list_subregion/'.$page_no,'<< Back to sub-regions list')?></div>
 </div>
<?php echo form_close();?>