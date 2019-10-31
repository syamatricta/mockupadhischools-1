<?php echo form_open_multipart('admin_subregion/add_subregion', array('name'=>'adminregionform','id' => 'adminregionform')); ?>
<div class="adminmainlist">
	
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
		<div class="clearboth paddingtop"></div>
	</div>
	
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		<div  class="page_error" id="divError">&nbsp;
			<?php 
				if(validation_errors()) echo  validation_errors();
				if(isset($error_region)) echo $error_region;
			?>
		</div>
		<div class="page_success">&nbsp;<?php if($this->session->flashdata('success')){ echo $this->session->flashdata('success');}?></div>
		<div class="clearboth paddingtop">&nbsp;</div>
		<div class="listdata">
				<div class="floatleft region_leftlabel">Region Name<span class="red_star">*</span></div>
				<div class="floatleft region_midcolon">:</div>
				<div class="floatleft">
					<select name="sltRegion" id="sltRegion" style="width:182px;">
						<option value="0">Select</option>
						<?php 
						if(count($region)>0){ 
							foreach($region as $data){
								echo '<option value="'.$data->id.'"';
									if(set_value('sltRegion') == $data->id)
									{
										echo 'selected';
									}
								echo ' >'.$data->region_name.'</option>';
							}
						} ?>
					</select>
				</div>
				<div class="clearboth paddingtop"></div>
				<div class="floatleft region_leftlabel">Sub-Region Name<span class="red_star">*</span></div>
				<div class="floatleft region_midcolon">:</div>
				<div class="floatleft">
					<input type="text" name="txtName" id="txtName"  value="<?php echo set_value('txtName');?>" size="24" maxlength="40"/>
				</div>
				<div class="clearboth paddingtop"></div>
				<div  class="floatleft region_leftlabel">Address<span class="red_star">*</span></div>
				<div class="floatleft region_midcolon">:</div>
				<div class="floatleft">
					<input type="text" name="txtAddress" id="txtAddress"  value="<?php echo set_value('txtAddress');?>" size="24"/>
				</div>
				<div class="clearboth paddingtop"></div>
				<div  class="floatleft region_leftlabel">Image</div>
				<div class="floatleft region_midcolon">:</div>
				<div class="floatleft">
					<input type="file" name="txtImage" id="txtImage"/>
				</div>
				<div class="clearboth"></div>
				<div class="floatleft region_leftlabel_midcolon">&nbsp;</div>
				<div class="image_specification">( Image formats: jpg,jpeg and png <br/>&nbsp;&nbsp;&nbsp;Max image resolution: <?php  echo $this->config->item('image_max_width');?>px x <?php  echo $this->config->item('image_max_height');?>px <br/> &nbsp;&nbsp;&nbsp;Max image size : <?php  echo $this->config->item('image_max_size');?>KB&nbsp;)</div>
				<div class="clearboth paddingtop"></div>
				<div  class="floatleft region_leftlabel">Description<span class="red_star">*</span></div>
				<div class="floatleft region_midcolon">:</div>
				<div class="floatleft">
					<textarea name="txtaDescription" id="txtaDescription" rows="3" cols="34"><?php echo set_value('txtaDescription');?></textarea>
				</div>
				<div class="clearboth paddingtop"></div>
				<div class="subregion_addbutton">
					<input type="image" name="btnAdd" id="btnAdd" onclick="javascript:return fncAddNewSubRegion(<?php echo $page_no;?>);" src="<?php  echo $this->config->item('images');?>innerpages/user_submit.jpg" />
				</div>
				<div class="clearboth"></div>
		</div>
	</div>
	
	<div class="backtolist"><?php echo anchor('admin_subregion/list_subregion/'.$page_no,'<< Back to sub-regions list')?></div>
 </div>
<?php echo form_close();?>