<?php echo form_open(base_url().'dictionary/dictionary_list/',array('name'=>'frmadhischool','id' => 'frmadhischool','onsubmit'=>'javascript: return JSfncSearch();'));?>
	<div class="adminmainlist">
			
			<div class="adminpagebanner">
				<div class="adminpagetitle"><?php echo $page_title?>
				</div>
			</div>
			<div class="clearboth"> </div>
			
			<div class="page_error" id="display_error" align="center"></div>
			<div class="page_error" id="display_server_error" align="center">
			<?php 
				if(validation_errors()){
					echo validation_errors();
				}
				
				if($this->session->flashdata('msg'))
					echo $this->session->flashdata('msg');	
			?>
			</div>
			<div  class="page_success" id="flashsuccess"><?php  echo $this->session->flashdata("success"); ?></div>
			<div class="clearboth">&nbsp; </div>
				<div class="floatleft" style="width:25%;margin:0px 0px 5px 10px;">
					<input type="text" value="<?php echo set_value('search_keyword');?>" id="search_keyword" name="search_keyword" autocomplete="off">
					<input type="submit" value="Search" onclick="javascript: JSfncSearch();" />
				</div>
				
				<div class="floatleft" style="width:25%;margin:0px 0px 5px 10px;">Number of persons attending Quiz : <?php if(isset($quiz_count)) echo $quiz_count; else echo 0;?></div>
				<div class="floatleft" style="margin:0px 0px 5px 10px;">
					<?php	
				 		/*if($upload_status == 0) { 
				 			echo '<input type="button" value="Enable" onclick="javascript:change_status ('.$upload_status.','.$quiz_count.');">';
				 		} else if($upload_status == 1 && $quiz_count == 0) {
			 				echo '<input type="button" value="Disable" onclick="javascript:change_status ('.$upload_status.','.$quiz_count.');">';
			 			}else if($quiz_count > 0){
			 				echo '<input type="button" value="Disable" disabled>';
						}else echo "&nbsp";*/
			 		?>
				</div>
				<div class="floatright" style="width:5%;">
					<?php if($upload_status == 0 && $quiz_count == 0) {
						  	  echo anchor('dictionary/upload/','Upload');
						  } else if($quiz_count > 0) {
							  echo '<a href="javascript:void(0);" onclick="javascript:return suspend_quiz_action('.$quiz_count.',\'Upload\');">Upload</a>';
						  } else {
							  echo '<a href="javascript:void(0);" onclick="javascript:return disable_quiz_process(\'Upload\');">Upload</a>';
						  }?>

				</div>
				<div class="floatright" style="width:11%;">
					<?php if($upload_status == 0 && $quiz_count == 0) {
							echo anchor('dictionary/add/','Add New Keyword');
						  } else if($quiz_count > 0) {
							  echo '<a href="javascript:void(0);" onclick="javascript:return suspend_quiz_action('.$quiz_count.',\'Add new keyword\');">Add New Keyword</a>';
						  } else {
							  echo '<a href="javascript:void(0);" onclick="javascript:return disable_quiz_process(\'Add New Keyword\');">Add New Keyword</a>';
						  }?>
				</div>
			<?php 
				if(count($dictionary_details) > 0){
				/* list headings starts here*/		
			?>
				<div class="floatright" style="width:10%;">
				<?php if($upload_status == 0 && $quiz_count == 0) {?>
						<a href="javascript:void(0);" onclick="javascript:empty_dictionariy();">Empty Dictionary</a>
				<?php } else if($quiz_count > 0) {
						  echo '<a href="javascript:void(0);" onclick="javascript:return suspend_quiz_action('.$quiz_count.',\'Empty Dictionary\');">Empty Dictionary</a>';
					  } else {
						  echo '<a href="javascript:void(0);" onclick="javascript:return disable_quiz_process(\'Empty Dictionary\');">Empty Dictionary</a>';
					  }?>
				</div>
				<div class="admininnercontentdiv">				
					
					<div class="admintopheads">
						<div class="adminlistheadings" style="width:2%;">&nbsp;</div>
						<div class="adminlistheadings" style="width:10%;">Sl. No</div>
						<div class="adminlistheadings" style="width:15%;">Keyword</div>
						<div class="adminlistheadings" style="width:40%;">Definition</div>
						<div class="adminlistheadings" style="width:15%;text-align:center;">Edit</div>
						<div class="adminlistheadings" style="width:15%;text-align:center;">Delete</div>
					</div>
					<div class="clearboth"> </div>
				<?php  
			/* list headings ends here*/
						$count=1; 
					   /*if ($this->uri->segment(3)){
							$count = $count+$this->uri->segment(3);
						} */
				  // if($dictionary_details){
						   foreach($dictionary_details as $key_dictionary){
						  $bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';
			/* data list starts here */ 
						 ?>
						  <div class="<?php print($bg_color);?>">
						  	<div class="floatleft" style="width:2%;">&nbsp;</div> 
						 	<div class="floatleft" style="width:10%;"><?php print ($slno+$count);?></div> 
						 	<div class="floatleft" style="width:15%;"><?php echo $key_dictionary['dct_keyword'];?> </div> 
						 	<div class="floatleft" style="width:40%;"><?php echo $key_dictionary['dct_definition'];?></div>
						 	
							<div class="floatleft" style="width:15%;text-align:center;">
							<?php if($upload_status == 0 && $quiz_count == 0) {?>
										<a href="<?php echo base_url().'dictionary/edit/'.$key_dictionary['dct_id'].'/'.$offset_val;?>">Edit</a> 
							<?php } else if($quiz_count > 0) {
									  echo '<a href="javascript:void(0);" onclick="javascript:return suspend_quiz_action('.$quiz_count.',\'Edit\');">Edit</a>';
								  } else {
									  echo '<a href="javascript:void(0);" onclick="javascript:return disable_quiz_process(\'Edit\');">Edit</a>';
								  }?>
							</div>
							<div class="floatleft" style="width:15%;text-align:center;">	
							<?php 
								if($upload_status == 0 && $quiz_count == 0){?>				
									<a href="javascript:void(0);" onclick="javascript:return delete_dictionary('<?php  echo $key_dictionary['dct_id'] ?>');">Delete</a>
							<?php }else{
									echo 'Delete';
								 }?>
							</div> 					 				
						</div>
						<div class="clearboth"> </div>
						<?php $count++; 
			/* data list ends here */ 			
					}?>
					
				</div>
				<div class="pagination"><?php  echo $paginate;?></div>
				<div style="clear:both">&nbsp;</div>
			<?php }
			else{ 
				
					echo '<div class="floatleft" style="width:75%;margin:0px 0px 5px 10px;"><div>No Records Found</div></div>';
			}//}?>
	</div>
	<input type="hidden" id="hdn_offset_value" name="hdn_offset_value" value="<?php echo $offset_val;?>">
	<input type="hidden" id="hdn_dict_id" name="hdn_dict_id" value="">
<?php echo form_close();?>