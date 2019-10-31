<?php echo form_open('admin_region/edit_region', array('name'=>'adminregionform','id' => 'adminregionform')); ?>
<div class="adminmainlist">
	
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div>
	
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		<div  class="page_error" id="divError">
			<?php  
				if(validation_errors()) echo  validation_errors();
				if(isset($error_region)) echo $error_region;
			?>
		</div>
		<div class="listdata copyright">
				<div class="leftsideheadings_view">Region Name<span class="red_star">*</span></div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><input type="text" name="txtName" id="txtName" value="<?php echo $region->region_name;?>" /></div>
				<div class="clearboth"></div>
				<div class="subregion_addbutton">
					<input type="image" name="txtAdd" id="txtAdd" onclick="javascript:return fncUpdateRegion(<?php echo $region->id;?>);" src="<?php  echo $this->config->item('images');?>innerpages/update.jpg" />
				</div>
				<div class="clearboth"></div>
		</div>
	</div>
	
	<div class="backtolist"><?php echo anchor('admin_region/list_region/'.$page_no,'<< Back to regions list')?></div>
 </div>
<?php echo form_close();?>