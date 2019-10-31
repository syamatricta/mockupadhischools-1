<div class="adminpagetitle"><?php echo $page_title?></div>
<div class="clearboth">&nbsp;</div>
<?php $this->load->view ('/admin/user management/add_conversation'); ?>
<div class="clearboth">&nbsp;</div>
<div class="adminpagetitle">Conversation History</div>
<div class="clearboth">&nbsp;</div>
<?php echo form_open_multipart('admin_user', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="adminmainlist">
		<div class="adminpagebanner">
			<div class="adminpagetitle"><?php //echo $page_title?></div>
		</div>
		<!--<div class="page_error" id="errordisplay"></div>
		<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");?></div>
		<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
		<?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
		<div class="clearboth"></div>-->
		<?php 
		if(count($conversations) > 0){
/* list headings starts here*/		
		?>		
		<div class="clearboth"> </div>		
		<div class="admininnercontentdiv">
		<?php  
	/* list headings ends here*/
				$count=1; 
			   if ($this->uri->segment(4)){
					$count = $count+$this->uri->segment(4);
				} 
				   foreach($conversations as $data){
				  $bg_color = ($count%2==0) ? 'div_list_first' : 'div_list_second';
	/* data list starts here */ 
					?>
						<div class="<?php print($bg_color);?>" style="padding-left:7px;">
						 	
							<div class="floatleft" style="width:83%;font-weight:bold"><?php echo ucfirst($data->cd_title); ?></div>
							<div class="floatleft" style="width:15%;font-weight:bold"><?php echo $data->created_date; ?></div> 
							<div class="clearboth">&nbsp;</div>
							
							
							<div class="floatleft" style="width:98%;" id="small_<?php echo  $data->cd_id;?>" onclick="javascript:show_conv_content ('content_<?php echo  $data->cd_id;?>','small_<?php echo $data->cd_id;?>');">
								<div class="floatleft" style="width:2%"><?php if(strlen($data->cd_content)>120){?><img src="<?php echo $this->config->item('images').'plus.jpeg';?>"/><?php }?></div>
								<div class="floatleft" style="width:96%;">
									<?php echo strip_tags(substr($data->cd_content,0,120));echo (strlen($data->cd_content)>120) ? '....' :''; ?>
								</div>
 							</div>
	
							<div class="floatleft" style="width:98%;display:none;" id="<?php echo 'content_'.$data->cd_id;?>" onclick="javascript:hide_conv_content ('content_<?php echo $data->cd_id;?>','small_<?php echo $data->cd_id;?>');">
								<div class="floatleft" style="width:2%"><?php if(strlen($data->cd_content)>120){?><img src="<?php echo $this->config->item('images').'minus.jpeg';?>"/><?php }?></div>
								<div class="floatleft" style="width:96%"><?php echo $data->cd_content; ?></div>
							</div>
 				
						 	<div class="clearboth">&nbsp;</div>
						 	<div class="floatleft" style="width:35%;">
						 		<?php 
						 			//echo anchor('admin_user/view_conversation/'.$data->cd_id.'/'.$this->uri->segment(4),'View');
						 			echo anchor('admin_user/edit_conversation/'.$data->cd_id.'/'.$this->uri->segment(4),'Edit');
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
			<div class="pagination" style="width:100%"><?php  echo $paginate;?></div>
		</div>
		
		<div style="clear:both">&nbsp;</div>
	<?php } else { ?>
			
			<div class="clearboth"></div>
			<div class="nodata">No Conversations found</div>
		<?php }?> 
</div>
<input type="hidden" id="hidsitepage" name="hidsitepage"  value="<?php if(isset($_POST['hidsitepage'])){echo $_POST['hidsitepage'];}?>" />
<?php echo form_close();?>