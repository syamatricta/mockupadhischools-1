<?php echo form_open_multipart('admin_sitepages/edit_brokerplacement/'.$brokerplacement_details[0]->id, array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
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
			<div class="rightsidedata_view"><input type="text" name="txtPostcode" id="txtPostcode" maxlength="250" value="<?php echo set_post_value('txtPostcode',$brokerplacement_details[0]->sub_postcode);?>" /></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">Address<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtAddress" id="txtAddress"  value="<?php echo set_post_value('txtAddress',$brokerplacement_details[0]->address);?>" size="24"/></div>
			<div class="clearboth"></div>
                        <div class="leftsideheadings_view">Image<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="file" name="txtImage" id="txtImage"/></div>
			<div class="clearboth"></div>
                        <div class="leftsideheadings_view">YouTube URL<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtYTVName" id="txtYTVName"  value="<?php echo set_post_value('txtYTVName',$brokerplacement_details[0]->yt_video);?>" size="24" maxlength="500"/></div>
			<div class="clearboth"></div>
                        <div class="leftsideheadings_view">Hiring contact name<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtHCName" id="txtHCName"  value="<?php echo set_post_value('txtHCName',$brokerplacement_details[0]->hiring_contact_name);?>" size="24" maxlength="500"/></div>
                        <div class="clearboth"></div>
                        <div class="leftsideheadings_view">Company name<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtCName" id="txtCName"  value="<?php echo set_post_value('txtCName',$brokerplacement_details[0]->company_name);?>" size="24" maxlength="500"/></div>
                        <div class="clearboth"></div>
                        <div class="leftsideheadings_view">Phone number<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><input type="text" name="txtPhonenumber" id="txtPhonenumber"  value="<?php echo set_post_value('txtPhonenumber',$brokerplacement_details[0]->phone_number);?>" size="24" maxlength="500"/></div>
                         <div class="clearboth"></div>
                        <div class="leftsideheadings_view">Company Information<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><textarea name="txtcomDescription" id="txtcomDescription" rows="3" cols="34"><?php echo set_post_value('txtcomDescription',$brokerplacement_details[0]->company_information);?></textarea></div>
                        <div class="clearboth"></div>
                        <div class="middlebutton"><input type="image" onclick="javascript:return fncSavebrokerplacement('<?php echo $brokerplacement_details[0]->id; ?>','');" src="<?php echo $this->config->item('images').'innerpages/update.jpg';?>" name="butAdd" value="" /></div>
			</div> <?php /* end of listdata */?>
		</div> <?php /* end of admininnercontentdiv */?>
	<div class="backtolist"><a href="<?php echo base_url().'admin_sitepages/list_brokerplacement';?>"><< Back to Broker placement list </a></div>
	<input type="hidden" id="hiduserid" name="hiduserid"  value="" />
<?php  enable_tiny_mce("txtContent","advanced"); ?>
</div> <?php /* end of adminmainlist */ ?>
<?php echo form_close();?>
