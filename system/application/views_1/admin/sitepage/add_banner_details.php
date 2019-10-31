<?php echo form_open_multipart('admin_sitepages/add_banner', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
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
			<div class="rightsidedata_view"><?php echo form_dropdown('sitepage',$sitepages,set_post_value('sitepage'),'id="sitepage"');?></div>
			<div class="clearboth"></div>-->
			<div class="leftsideheadings_view">Banner Title<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtTitle" id="txtTitle" maxlength="25" value="<?php echo set_post_value('txtTitle');?>" /></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">Short Description<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtShortDesc" id="txtShortDesc" maxlength="50" value="<?php echo set_post_value('txtShortDesc');?>" /></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">Banner Image<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="file" name="txtImage" id="txtImage" value="" /></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">&nbsp;</div>
			<div class="middlecolon">&nbsp;</div>
			<div class="rightsidedata_view image_specification">( Image formats: jpg,jpeg and png <br/>&nbsp;&nbsp;&nbsp;Max image resolution: <?php  echo $this->config->item('image_max_width');?>px X <?php  echo $this->config->item('image_max_height');?>px <br/> &nbsp;&nbsp;&nbsp;Max image size : <?php  echo $this->config->item('image_max_size');?>KB&nbsp;)</div>
			<div class="clearboth"></div>				
			<div class="middlebutton"><input type="image" src="<?php echo $this->config->item('images').'innerpages/user_submit.jpg';?>" name="butAdd" value="" /></div>
			</div> <?php /* end of listdata */?>
		</div> <?php /* end of admininnercontentdiv */?>
	<div class="backtolist"><a href="<?php echo base_url().'admin_sitepages/list_banners';?>"><< Back to banners list </a></div>
	<input type="hidden" id="hiduserid" name="hiduserid"  value="" />
</div> <?php /* end of adminmainlist */ ?>
<?php echo form_close();?>