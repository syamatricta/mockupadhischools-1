<?php echo form_open_multipart('admin_sitepages', array('name'=>'frmCrashcourse','id' => 'frmCrashcourse')); ?>
<div class="adminmainlist">	
	<div class="adminpagebanner">
		<!--<div class="adminpagetitle"><?php echo $page_title?></div>-->
	</div> <?php /*end of  adminpagebanner */?>
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		<div class="page_error" id="errordisplay"></div>
		<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");?></div>
		<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
		<?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
		<?php if ($msg != ''){ echo '<div  class="page_error" id="flasherror">'.$msg.'</div>';}?>
		<div class="listdata">
			<div class="clearboth"></div>
			<div class="leftsidespacing_view">Title<span class="red_star">*</span></div>
			<div class="middlecolon_spacing">:</div>
			<div class="rightsidedataspacing_view" ><input type="text" name="txtTitle" id="txtTitle" class="textwidth" size="36" maxlength="150" value="<?php echo set_value('txtTitle'); ?>" /></div>
			<!--<div class="clearboth"></div>-->
			<div class="leftsidespacing_view">Date<span class="red_star">*</span></div>
			<div class="middlecolon_spacing">:</div>
			<div class="rightsidedataspacing_view">
				<input type="text" name="conver_date" id="conver_date" maxlength="100" class="textwidth"  value="<?php echo set_value('conver_date'); ?>" readonly/>
				<img  src="<?php  echo ssl_url_img();?>calendar.gif" alt="calendar" title="calendar" onclick="javascript: displayCalendar(document.getElementById('conver_date'),'mm/dd/yyyy hh:ii',this,true)"/>
			</div>
			<div class="clearboth"></div>	
			<div class="leftsidespacing_view">Content<span class="red_star">*</span></div>
			<div class="middlecolon_spacing">:</div>
			<div class="rightsidedataspacing_view"><textarea name="txtContent" id="txtContent" rows="4" cols="30" style="width:750px;height:130px"><?php echo set_value('txtContent'); ?></textarea></div>
			<div class="clearboth"></div>
			<div class="leftsidespacing_view">Attachment</div>
			<div class="middlecolon_spacing">:</div>
			<div class="rightsidedataspacing_view"><input type="file" name="userfile" id="userfile" class="textwidth" value="" /><br />(Allowed file formats are <?php echo str_replace('|',' , ',$this->config->item('conversation_extensions_display'));?>. Max size : 2048KB)</div>
			<div class="clearboth"></div>	
			<div class="leftsidespacing_view">&nbsp;</div>
			<div class="middlecolon_spacing">&nbsp;</div>
			<div class="rightsidedataspacing_view">
				<div class="backtolist" style="text-align:left;">
				<input type="button" name="butSave" value="Save" onclick="javascript:fncSaveConversationDetails(<?php echo $user_id;?>);" />
				</div>
			</div>
			<div class="clearboth"></div>
		</div> <?php /* end of listdata */?>
	</div> <?php /* end of admininnercontentdiv */?>
	<?php  enable_tiny_mce("txtContent","advanced",'false'); ?>
	<input type="hidden" id="hiduserid" name="hiduserid"  value="" />
	<input type="hidden" id="action_add" name="action_add"  value="1" />
</div> <?php /* end of adminmainlist */ ?>
<?php echo form_close();?>