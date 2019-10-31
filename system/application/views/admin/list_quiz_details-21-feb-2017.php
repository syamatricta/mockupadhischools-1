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
		
		<div class="page_error" id="display_error" align="center"></div>
		<div class="page_error" id="display_server_error" align="center">
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
		<div style="width:80%" class="floatleft">
		
		
			<select name="course" onchange="javascript:show_quiz(this.value,'<?php echo base_url();?>');">
			<?php 
			
			foreach($course as $course){ 
					if($course->count_sub){$i=$course->count_sub?>
					 	<optgroup label=" <?php echo  $course->course_name?>">
			<?php }else if($course->parent_course_id){$i--;?>
		     	 		<option value="<?php echo  $course->id?>"<?php echo ($course_id==$course->id)?"Selected":'';?>><?php echo  $course->course_name?></option>
    		<?php }else{?>

						<option value="<?php echo $course->id?>"<?php echo ($course_id==$course->id)?"Selected":'';?> ><?php echo $course->course_name?></option>
			<?php }
					if($i==0){?>
					</optgroup>
			<?php }}?>
			</select>
		
		
		</div>
		<div class="floatleft" style="width:20%;">
			<a href="<?php echo site_url()."/admin_quiz/upload/".$course_id?>">Upload</a>
		</div>
			<div class="admintopheads">
				<div class="adminlistheadings" style="width:2%;">&nbsp;</div>
				<div class="adminlistheadings" style="width:10%;">Sl. No</div>
				<div class="adminlistheadings" style="width:10%;">Edition</div>
				<div class="adminlistheadings" style="width:10%;">Chapter Name</div>
				<div class="adminlistheadings" style="width:15%;">Topic</div>
				<div class="adminlistheadings" style="width:10%;">Number of Questions</div>
				<div class="adminlistheadings" style="width:14%;">No of Persons Taking Quiz</div>
				<div class="adminlistheadings" style="width:11%;">Quiz Status</div>

				<div class="adminlistheadings" style="width:10%;">Edit</div>
				<div class="adminlistheadings" style="width:5%;">Delete</div>
			</div>
			<div class="clearboth"> </div>
		<?php  
	/* list headings ends here*/
				$count=1; 
			   /*if ($this->uri->segment(3)){
					$count = $count+$this->uri->segment(3);
				} */
		   if($quiz){
				   foreach($quiz as $data){
				  $bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';
	/* data list starts here */ 
				 ?>
				  <div class="<?php print($bg_color);?>">
				  	<div class="floatleft" style="width:2%;">&nbsp;</div> 
				 	<div class="floatleft" style="width:10%;"><?php print $count;?></div> 
				 	<div class="floatleft" style="width:10%;">Edition <?php echo $data['edition_no']; ?></div> 
				 	<div class="floatleft" style="width:10%;"><?php echo $data['quiz_name']; ?></div> 
				 	<div class="floatleft" style="width:15%;"><?php echo $data['topic']; ?>&nbsp;</div> 
				 	<div class="floatleft" style="width:10%;"><?php echo $data['qn_count'];?></div>
				 	<div class="floatleft" style="width:14%;"><?php echo $data['ex_count'];?></div>
				 	<div class="floatleft" style="width:11%;">&nbsp;
				 		<?php if($data['quiz_status']=='DEL') { 
				 			echo "Deleted";
				 		}else{?>
				 			<a href="javascript:void(null);" onclick="javascript:return change_status('<?php echo $data['quiz_status'] ?>','<?php echo site_url()."/admin_quiz/change_status/".$data['id']."/".$data['quiz_status']."/".$course_id; ?>',<?php echo $data['ex_count'];?>);">
				 			
					 			<?php if($data['quiz_status']=='D') { 
					 					echo "Enable";
			 					} else if($data['quiz_status']=='E') {
			 							echo "Disable";
		 						} ?>
							</a>
						<?php } ?>
					</div> 
				 	
				 	

					<div class="floatleft" style="width:10%;">
						<?php if(!$data['qn_count'] || $data['quiz_status']=='E'){ 
								echo"Edit";
						}else{?>
							<a href="<?php echo base_url()?>index.php/admin_quiz/edit/<?php  echo $course_id ?>/<?php  echo $data['id'] ?>/<?php  echo $data['edition'] ?>">Edit</a> 
						<?php }?>
					</div>
						<div class="floatleft" style="width:5%;">
						<?php if(!$data['qn_count'] || $data['quiz_status']=='E'){ 
								echo"Delete";
						}else{?>
						<a href="<?php echo site_url()."/admin_quiz/delete_question/".$data['id'] ."/".$course_id ?>" onclick="javascript:return delete_all_quest();">Delete</a>
						<?php }?>
					</div> 
					 
					<div class="floatleft" style="width:12%;">&nbsp;</div> 
				</div>
				<div class="clearboth"> </div>
				<?php $count++; 
	/* data list ends here */ 			
			}?>
		</div>
		<div class="pagination"><?php // echo $paginate;?></div>
		<div style="clear:both">&nbsp;</div>
		<?php }
		else{ ?>
		<div>No Records Found</div>
		<?php }}?>
</div>
<input type="hidden" id="hiduserid" name="hiduserid"  value="<?php if(isset($_POST['hiduserid'])){echo $_POST['hiduserid'];}?>" />
