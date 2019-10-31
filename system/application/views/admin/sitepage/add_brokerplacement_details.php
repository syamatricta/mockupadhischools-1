<?php echo form_open_multipart('admin_sitepages/add_brokerplacement', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
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
			<div class="leftsideheadings_view">Postcode<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtPostcode" id="txtPostcode" maxlength="250" value="<?php echo set_post_value('txtPostcode');?>" /></div>
			<div class="clearboth"></div>
            <div class="leftsideheadings_view">Address<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtAddress" id="txtAddress"  value="<?php echo set_value('txtAddress');?>" size="24"/></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">Image<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="file" name="txtImage" id="txtImage"/></div>
			<div class="clearboth"></div>
                        <div class="leftsideheadings_view">YouTube URL<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtYTVName" id="txtYTVName"  value="<?php echo set_value('txtYTVName');?>" size="24" maxlength="500"/></div>
			<div class="clearboth"></div>
                        <div class="leftsideheadings_view">Hiring contact name<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtHCName" id="txtHCName"  value="<?php echo set_value('txtHCName');?>" size="24" maxlength="40"/></div>
			<div class="clearboth"></div>
                        <div class="leftsideheadings_view">Company name<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtCName" id="txtCName"  value="<?php echo set_value('txtCName');?>" size="24" maxlength="40"/></div>
			<div class="clearboth"></div>
                        <div class="leftsideheadings_view">Phone number<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtPhonenumber" id="txtPhonenumber"  value="<?php echo set_value('txtPhonenumber');?>" size="24" maxlength="40"/></div>
			<div class="clearboth"></div>
                        <div class="leftsideheadings_view">Company Information<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><textarea name="txtcomDescription" id="txtcomDescription" rows="3" cols="34"><?php echo set_value('txtcomDescription');?></textarea></div>
			<div class="clearboth"></div>
			<div class="middlebutton"><input type="image" onclick="javascript:return fncSavebrokerplacement('','');" src="<?php echo $this->config->item('images').'innerpages/user_submit.jpg';?>" name="butAdd" value="" /></div>
			</div> <?php /* end of listdata */?>
		</div> <?php /* end of admininnercontentdiv */?>
	<div class="backtolist"><a href="<?php echo base_url().'admin_sitepages/list_brokerplacement';?>"><< Back to Broker placement list </a></div>
	<input type="hidden" id="hiduserid" name="hiduserid"  value="" />
        <?php  enable_tiny_mce("txtContent","advanced"); ?>
</div> <?php /* end of adminmainlist */ ?>
<?php echo form_close();?>