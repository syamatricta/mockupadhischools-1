<?php echo form_open_multipart('admin_sitepages/edit_banner/'.$banner_details[0]->banner_id, array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="adminmainlist">	
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div> <?php /*end of  adminpagebanner */?>
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		<div class="page_error" id="errordisplay"></div>
		<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");?></div>
		<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
		<?php if (isset($error) && ''!= $error) : echo '<div class="page_error">'.$error.'</div>'; endif;?>		
		<div class="listdata">
			<!--<div class="leftsideheadings_view">Select Sitepage<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php //echo form_dropdown('sitepage',$sitepages,set_post_value('sitepage',$banner_details[0]->sitepage_id),'id="sitepage"');?></div>
			<div class="clearboth"></div>-->
			<div class="leftsideheadings_view">Banner Title<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtTitle" id="txtTitle" maxlength="25" value="<?php echo set_post_value('txtTitle',$banner_details[0]->banner_title);?>" /></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">Short Description<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtShortDesc" id="txtShortDesc" maxlength="50" value="<?php echo set_post_value('txtShortDesc',$banner_details[0]->banner_short_dec);?>" /></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">Banner Image</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="file" name="txtImage" id="txtImage" value="" /></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">&nbsp;</div>
			<div class="middlecolon">&nbsp;</div>
			<div class="rightsidedata_view image_specification">( Image formats: jpg,jpeg and png <br/>&nbsp;&nbsp;&nbsp;Max image resolution: <?php  echo $this->config->item('image_max_width');?>px X <?php  echo $this->config->item('image_max_height');?>px <br/> &nbsp;&nbsp;&nbsp;Max image size : <?php  echo $this->config->item('image_max_size');?>KB&nbsp;)</div>
			<div class="clearboth"></div>	
			<div class="leftsideheadings_view">Description<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><textarea name="txtContent" id="txtContent" rows="4" cols="30"><?php echo set_post_value('txtContent',$banner_details[0]->banner_long_desc);?></textarea></div>
			<div class="clearboth"></div>			
			<div class="middlebutton"><input type="image" onclick="javascript:return fncSaveBanner('<?php echo $banner_details[0]->banner_id; ?>','');"src="<?php echo $this->config->item('images').'innerpages/user_submit.jpg';?>" name="butAdd" value="" /></div>
			</div> <?php /* end of listdata */?>
		</div> <?php /* end of admininnercontentdiv */?>
	<div class="backtolist"><a href="<?php echo base_url().'admin_sitepages/list_banners';?>"><< Back to banners list </a></div>
	<input type="hidden" id="hiduserid" name="hiduserid"  value="" />
<?php  enable_tiny_mce("txtContent","advanced"); ?>
</div> <?php /* end of adminmainlist */ ?>
<?php echo form_close();?>
