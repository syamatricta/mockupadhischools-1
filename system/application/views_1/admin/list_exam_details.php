<div class="adminmainlist">
		<?php 
		if(count($course) > 0){
/* list headings starts here*/		
		?>
		<div class="adminpagebanner">
			<div class="adminpagetitle"><?php echo $page_title?>
			</div>
		</div>
		<div class="clearboth"> </div>
		
		<div class="page_error" id="display_error"></div>
		<div class="page_error" id="display_server_error">
				<?php if(validation_errors()){
						echo validation_errors();
					}
					
					if($this->session->flashdata('msg'))
						echo $this->session->flashdata('msg');	
				?>
		</div>
		<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
		<div class="clearboth">&nbsp; </div>
		<div class="admininnercontentdiv">
			<div class="admintopheads">
				<div class="adminlistheadings" style="width:2%;">&nbsp;</div>
				<div class="adminlistheadings" style="width:10%;">Sl. No</div>
				<div class="adminlistheadings" style="width:20%;">Course Name</div>
				<div class="adminlistheadings" style="width:15%;">Number of Questions</div>
				<div class="adminlistheadings" style="width:10%;">Exam Status</div>
				<div class="adminlistheadings" style="width:15%;">No of Persons Taking Exams</div>
				<div class="adminlistheadings" style="width:10%;">Upload</div>
				<div class="adminlistheadings" style="width:5%;">Edit</div>
				<div class="adminlistheadings" style="width:5%;">Delete</div>
				
				
				
				
				
			</div>
			<div class="clearboth"> </div>
		<?php  
	/* list headings ends here*/
				$count=1; 
			   /*if ($this->uri->segment(3)){
					$count = $count+$this->uri->segment(3);
				} */
				   foreach($course as $data){
				  $bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';
				  if($data['parent_id'])$bg_color = 'div_row_third';
	/* data list starts here */ 
				 ?>
				  <div class="<?php print($bg_color);?>">
				  
				  	<div class="floatleft" style="width:2%;">&nbsp;</div> 
				  	
				 	<div class="floatleft" style="width:10%;"><?php /*if(!$data['parent_id']){*/print $count;/*}else echo "&nbsp";*/?></div>
				 	
				 	<?php //if($data['parent_id']){?>
<!--				 		<div class="floatleft" style="width:23%;padding-left:2%;">-->
			 		<?php  /*}else {*/?>
			 			<div class="floatleft" style="width:25%;">
		 			<?php //}?>
				 		<?php echo ($data['course_name'] !='') ? $data['course_name'] : '&nbsp' ; ?>
				 	</div> 
				 	
				 	<div class="floatleft" style="width:11%;"><?php /*if(!$data['child_cnt'])*/ echo $data['qn_count']; /*else echo '&nbsp;';*/?></div>
				 	
				 	<div class="floatleft" style="width:15%;">
				 		<?php
						/*if(!$data['child_cnt']){*/
					 		if($data['ex_count']) { ?>
					 			<a href="javascript:void(null);" onclick="javascript:return suspend_action('<?php echo $data['ex_count']?>');">
				 			<?php } else { ?>
				 				<a href="javascript:void(null);" onclick="javascript:return change_status('<?php echo $data['exam_status'] ?>','<?php echo site_url()."/admin_exam/change_status/".$data['id']."/".$data['exam_status']; ?>');">
				 			<?php }?>
				 			
				 			<?php if($data['exam_status']=='D') { 
				 					echo "Enable";
		 					} else {
		 							echo "Disable";
	 						} 
						/*}else echo "&nbsp";*/?>
						</a>
					</div> 
					
				 	<div class="adminlistheadings" style="width:10%;"><?php /*if(!$data['child_cnt']) */ echo $data['ex_count'];/*else echo "&nbsp;"*/?></div>
				 	
				 	<div class="floatleft" style="width:10%;">
				 	<?php 
				 	/*if(!$data['child_cnt']){*/
				 		if($data['exam_status']=='E'){?>
				 				<a href="javascript:void(null);" onclick="javascript:return disable_process('Upload');">
				 			<?php }elseif ($data['ex_count']) { ?>
					 			<a href="javascript:void(null);" onclick="javascript:return suspend_action('<?php echo $data['ex_count']?>');">
				 			<?php } else { ?>
				 				<a href="<?php echo site_url()."/admin_exam/upload/".$data['id']?>">
				 			<?php }?>
				 				Upload
				 				</a>
	 				<?php /*}else echo "&nbsp;"*/?>
	 				</div>
					<div class="floatleft" style="width:5%;">
					
					<?php 
					/*if(!$data['child_cnt']){*/
						
						if($data['exam_status']=='E' && $data['qn_count']){?>
				 				<a href="javascript:void(null);" onclick="javascript:return disable_process('Edit');">Edit</a>
				 			<?php } elseif($data['ex_count']) { ?>
					 			<a href="javascript:void(null);" onclick="javascript:return suspend_action('<?php echo $data['ex_count']?>');">Edit</a>
				 		<?php } else { 
					 				if(!$data['qn_count']){ echo "Edit";
					 				}else{
					 				?>
					 				<a href="<?php echo site_url()."admin_exam/edit/". $data['id'].'/'.@getDefaultEdition($data['id']); ?>">Edit</a>
					 			<?php }
				 			}
					/*}else echo "&nbsp;"*/?>
	
					</div> 
					<div class="floatleft" style="width:7%;">
					<?php //if(!$data['child_cnt']){
						if(!$data['qn_count'])echo "Delete";
						elseif($data['exam_status']=='E'){?>
			 				<a href="javascript:void(null);" onclick="javascript:return disable_process('Delete');">Delete</a>
			 			<?php } 
						else{?>
							<a href="<?php echo site_url()."/admin_exam/delete_question/".$data['id'] ?>" 
							<?php if($data['ex_count']){?>onclick="javascript:return suspend_action('<?php echo $data['ex_count']?>');"<?php } 
							else { ?> onclick="javascript:return delete_all_quest();"<?php } ?> >Delete</a> <?php }
					//}else echo"&nbsp;" ?>
						</div> 
				 
					<div class="floatleft" style="width:12%;">&nbsp;</div> 
				</div>
				<div class="clearboth"> </div>
				<?php /*if(!$data['parent_id'])*/$count++;
	/* data list ends here */ 			
			}?>
		</div>
		<div class="pagination"><?php // echo $paginate;?></div>
		<div style="clear:both">&nbsp;</div>
		<?php } ?>
</div>
<input type="hidden" id="hiduserid" name="hiduserid"  value="<?php if(isset($_POST['hiduserid'])){echo $_POST['hiduserid'];}?>" />
