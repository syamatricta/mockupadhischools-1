<?php $result_title = '';?>
<div class="adminmainlist">
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div>
	<div class="clearboth"> </div>
	
	<div class="admininnercontentdiv">
		<div class="listdata">
			<div id="page_error" class="page_error"><?php echo $this->session->flashdata("error");  ?></div>
			<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
			
			<form name="videoListForm" id="videoListForm" method="post">
				<div align="right" class="floatleft" style="width: 99%; text-align: right; border: 1px solid rgb(153, 153, 153); padding: 5px; background: none repeat scroll 0% 0% rgb(232, 227, 220);">
					<div class="floatleft smallpaddingright">
						Course :  
						<select name="course" id="course" onchange = "ajax_load_chapters();">
							<option value="">--Select Course--</option>
							<?php foreach($courses as $course): ?>
								<?php $result_title = ($course_id ===  $course->id) ? $course->course_name  : $result_title; ?>
								<option value="<?php echo $course->id?>" <?php echo ($course_id ===  $course->id) ? "SELECTED" : "" ?>><?php echo $course->course_name?></option>
							<?php endforeach;?>
						</select>&nbsp;&nbsp;&nbsp;
					</div>
					<div class="floatleft" id="showTypes">
						<div class="floatleft smallpaddingright" >
							Editions :
														
							<select name="edition" id="edition" onchange = "ajax_load_edition_chapters();" style="width:120px">
								<option value="">--Select Edition--</option>
								<?php 
									$edition_id_new = ($this->input->post('edition')) ? $this->input->post('edition') : $edition_id;
									if(isset($editions)):
										foreach($editions as $edition): 
								?>
									<option value="<?php echo $edition['id']; ?>" <?php echo ($edition_id_new ===  $edition['id']) ? "SELECTED" : "" ?>><?php echo $edition['edition_no']; ?></option>
								<?php
										endforeach; 
									endif;
								?>
							</select>
						</div>
								
					</div>
					<div class="floatleft" id="showTypes">
						<div class="floatleft smallpaddingright">
							Chapters :
														
							<select name="chapter" id="chapter" onchange="goto_list()">
								<option value="">--Select Chapter--</option>
									<?php 
										if(isset($chapters)):
											foreach($chapters as $chapter): 
									?>
										<?php $result_title = ($chapter_id ===  $chapter->id) ? $result_title . " > " .$chapter->quiz_name  : $result_title; ?>
										<option value="<?php echo $chapter->id; ?>" <?php echo ($chapter_id ===  $chapter->id) ? "SELECTED" : "" ?>><?php echo $chapter->quiz_name; ?></option>
									<?php
											endforeach; 
										endif;
									?>
								</select>
						</div>
								
					</div>
					<div class="floatright" style="width:20%;">
						<a href="javascript:void(0);" onclick="goto_page_action('add');">Add</a>&nbsp;
						<a href="javascript:void(0);" onclick="goto_page_action('upload')">Upload</a>
					</div>
					
				</div>
			</form>
			
			<div class="clearboth"> &nbsp;</div>
			
			<div id="result-title"><?php echo $result_title; ?></div>
			<div class="clearboth"> &nbsp;</div>
			
			<div class="admintopheads">
				<div class="adminlistheadings" style="width:10%; text-align:center;">Sl. No</div>
				<div class="adminlistheadings" style="width:15%;">Video</div>
				<div class="adminlistheadings" style="width:10%;">Edition</div>
				<div class="adminlistheadings" style="width:55%;">Description</div>
				<div class="adminlistheadings" style="width:10%;">Actions</div>						
			</div>
		</div>
		<div class="clearboth"> </div>
		<?php if(isset($course_id) && isset($chapter_id)):?>
			<?php if(isset($videos) && '' != $videos): ?>
				<?php $count = 1; ?>
				<?php foreach($videos as $video): ?>
					<?php $bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second'; ?>
					<div class="<?php print($bg_color);?>">
						<div class="floatleft" style="width:10%;  text-align:center;"><?php echo $count++; ?></div> 
					 	<div class="floatleft" style="width:15%;"><?php echo $video->video;?></div> 
					 	<div class="floatleft" style="width:10%;"><?php echo $video->edition_no;?></div> 
					 	<div class="floatleft" style="width:55%;"><?php echo nl2br($video->description); ?>&nbsp;</div> 
					 	<div class="floatleft" style="width:10%;">
					 		<?php echo anchor('admin_classroom/edit/' . $video->id, 'Edit');?>&nbsp;
					 		<?php //echo anchor('admin_classroom/delete_video/' . $video->id . '/' . $video->quiz_id . '/' . $video->course_id, 'Delete'); ?>
					 		<a href="javascript:void(0)" onclick="confirm_delete('<?php echo base_url() . 'admin_classroom/delete_video/' . $video->id . '/' . $video->quiz_id . '/' . $video->course_id ?>')">Delete</a>
					 	</div> 
					</div>
				<?php endforeach; ?>
			<?php else: ?>
				<div class="div_row_first">No videos found</div>
			<?php endif; ?>
		<?php else: ?>
			<div class="div_row_first">Please select course and chapter.</div>
		<?php endif;?>
		<!--<div class="pagination"><? //echo $paginate;?> </div>-->
		<div style="clear:both">&nbsp;</div>
	</div>
</div>