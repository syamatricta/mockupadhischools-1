<?php echo form_open_multipart('admin_user', array('name'=>'frmCrashcourse','id' => 'frmCrashcourse')); ?>
<div class="adminmainlist">	
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div> <?php /*end of  adminpagebanner */?>
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		<div class="page_error" id="errordisplay"></div>
		<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");?></div>
		<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
		<?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
		
		<div class="listdata">
			<div class="leftsideheadings_view">Name</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $conversations->ud_first_name; ?></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">Email Id</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $conversations->ud_emailid; ?></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">Title</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $conversations->cd_title; ?></div>
			<div class="clearboth"></div>
			<?php if($conversations->cd_filename != ''){?>
			<div class="leftsideheadings_view">Attachment</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo '<a target="_blank" href="'.$this->config->item('conversations_upload_file_url').$conversations->cd_filename.'">'.$conversations->cd_filename.'</a>'; ?></div>
			<div class="clearboth"></div>
			<?php }?>
			<div class="leftsideheadings_view">Date</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $conversations->created_date; ?></div>
			<div class="clearboth"></div>			
			<div class="leftsideheadings_view">Content</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view" style="border:1px solid #CCC;width:80%;padding:5px;"><?php echo $conversations->cd_content; ?></div>
			<div class="clearboth"></div>
		</div> <?php /* end of listdata */?>
	</div> <?php /* end of admininnercontentdiv */?>
	<div class="backtolist"><a href="javascript:void(null);" onclick="javascript:gotolist('<?php echo $conversations->user_id.'/'.$this->uri->segment(4);?>'); return false;"><< Back to Conversation List </a></div>
	<input type="hidden" id="hiduserid" name="hiduserid"  value="" />
</div> <?php /* end of adminmainlist */ ?>
<?php echo form_close();?>
