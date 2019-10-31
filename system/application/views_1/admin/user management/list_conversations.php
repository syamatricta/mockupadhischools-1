<?php echo form_open_multipart('admin_user', array('name'=>'frmCrashcourse','id' => 'frmCrashcourse')); ?>
<div class="adminmainlist">
		<div class="adminpagebanner">
			<div class="adminpagetitle"><?php echo $page_title?></div>
		</div>
		<div class="page_error" id="errordisplay"></div>
		<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");?></div>
		<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
		<?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
		<div class="clearboth"></div>
		<?php 
		if(count($conversations) > 0){
/* list headings starts here*/		
		?>		
		<div class="clearboth"> </div>		
		<div class="admininnercontentdiv">
			<div style="float:right;margin:10px 0px 5px 0px;"><?php echo anchor('admin_user/add_conversation/'.$user_id,"Add Conversation");?></div>	
			<div class="clearboth"></div>
			<div class="listdata">
				<div class="admintopheads">
					<div class="adminlistheadings" style="width:10%; text-align:center;">Sl. No</div>
					<div class="adminlistheadings" style="width:40%;">Conversation Title</div>
					<div class="adminlistheadings" style="width:15%;">Date of Conversation</div>
					<div class="adminlistheadings" style="width:35%;">Actions</div>
				</div>
			</div>
			<div class="clearboth"> </div>
		<?php  
	/* list headings ends here*/
				$count=1; 
			   if ($this->uri->segment(4)){
					$count = $count+$this->uri->segment(4);
				} 
				   foreach($conversations as $data){
				  $bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';
	/* data list starts here */ 
					?>
						<div class="<?php print($bg_color);?>">
						 	<div class="floatleft" style="width:10%;  text-align:center;"><?php print $count; ?></div> 
						 	<div class="floatleft" style="width:40%;"><?php echo $data->cd_title; ?></div> 
						 	<div class="floatleft" style="width:15%;"><?php echo $data->created_date; ?></div> 
						 	<div class="floatleft" style="width:35%;">
						 		<?php 
						 			echo anchor('admin_user/view_conversation/'.$data->cd_id.'/'.$this->uri->segment(4),'View');
						 			echo ' | '.anchor('admin_user/edit_conversation/'.$data->cd_id.'/'.$this->uri->segment(4),'Edit');
						 			echo ' | <a href="javascript:void(0);" onclick="javascript:deleteConversation('.$data->cd_id.')">Delete</a>';
						 			if($data->cd_filename != '') {
						 				echo ' | <a target="_blank" href="'.$this->config->item('conversations_upload_file_url').$data->cd_filename.'" >View Attachment</a>';
						 				echo ' | <a href="javascript:void(0);" onclick="javascript:deleteAttachment(\''.$data->cd_id.'/'.$this->uri->segment(4).'\')">Delete Attachment</a>';
						 			} else {
						 				//echo ' No Attachment';
						 				echo '&nbsp;';
						 			}
						 		?>
						 	</div> 
						</div>
						<div class="clearboth"> </div>
				<?php 
				$count++; 
				}
	/* data list ends here */ 			
			?>
			<div class="pagination"><?php  echo $paginate;?></div>
		</div>
		
		<div style="clear:both">&nbsp;</div>
	<?php } else { ?>
			<div style="float:right;margin:10px 0px 5px 0px;"><?php echo anchor('admin_user/add_conversation/'.$user_id,"Add Conversation");?></div>	
			<div class="clearboth"></div>
			<div class="nodata">No Conversations found</div>
		<?php }?> 
</div>
<input type="hidden" id="hidsitepage" name="hidsitepage"  value="<?php if(isset($_POST['hidsitepage'])){echo $_POST['hidsitepage'];}?>" />
<?php echo form_close();?>