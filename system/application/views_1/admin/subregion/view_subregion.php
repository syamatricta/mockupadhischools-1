<?php echo form_open('admin_subregion/edit_subregion', array('name'=>'adminregionform','id' => 'adminregionform')); ?>
<div class="adminmainlist">
	
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div>
	
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		
		<div class="clearboth paddingtop" >&nbsp;</div>
		<div class="subregion_main">
			<div class="floatleft subregion_label">Region Name</div>
			<div class="floatleft subregion_midcolon">:</div>
			<div class="floatleft subregion_data"><?php echo $region;?><input type="hidden" name="sltRegion" id="sltRegion" value="<?php if(set_value('sltRegion')){ echo set_value('sltRegion');}else{echo $subregion->region_id;}?>"/></div>
			<div class="clearboth paddingtop"></div>
			<div class="floatleft subregion_label">Sub-Region Name</div>
			<div class="floatleft subregion_midcolon">:</div>
			<div class="floatleft subregion_data"><?php echo $subregion->subregion_name;?></div>
			<div class="clearboth paddingtop"></div>
			<div class="floatleft subregion_label">Address</div>
			<div class="floatleft subregion_midcolon">:</div>
			<div class="floatleft subregion_data"><?php echo $subregion->subregion_address;?></div>
			<div class="clearboth paddingtop"></div>
			<div class="floatleft subregion_label">Description</div>
			<div class="floatleft subregion_midcolon">:</div>
			<div class="floatleft subregion_data"><?php echo $subregion->subregion_description;?></div>
			<div class="clearboth paddingtop"></div>
		</div>
		<div class="floatleft">
			<?php 
				$full_image = $this->config->item('image_upload_path').'thumbs/'.$subregion->image_name;
				if($subregion->image_name && file_exists($full_image)){
					$full_image = $this->config->item('image_upload_url').'thumbs/'.$subregion->image_name;
				}else{
					$full_image = $this->config->item('images').'default_image.jpg';
				}
				?><img src="<?php echo $full_image;?>" />
		</div>
	</div>
	<div class="backtolist"><?php echo anchor('admin_subregion/list_subregion/'.$page_no,'<< Back to sub-regions list')?></div>
 </div>
<?php echo form_close();?>
