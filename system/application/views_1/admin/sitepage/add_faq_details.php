<?php echo form_open_multipart('admin_sitepages/add_faq', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
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
			<div class="leftsideheadings_view">Question<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtTitle" id="txtTitle" maxlength="250" value="<?php echo set_post_value('txtTitle');?>" /></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">Answer<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><textarea name="txtContent" id="txtContent" rows="4" cols="30"></textarea></div>
			<div class="clearboth"></div>
			<div class="middlebutton"><input type="image" onclick="return fncSaveFaq('','');" src="<?php echo $this->config->item('images').'innerpages/user_submit.jpg';?>" name="butAdd" value="" /></div>
			</div> <?php /* end of listdata */?>
		</div> <?php /* end of admininnercontentdiv */?>
	<div class="backtolist"><a href="<?php echo base_url().'admin_sitepages/list_faq';?>"><< Back to FAQ list </a></div>
	<input type="hidden" id="hiduserid" name="hiduserid"  value="" />
        <?php  enable_tiny_mce("txtContent","advanced"); ?>
</div> <?php /* end of adminmainlist */ ?>
<?php echo form_close();?>