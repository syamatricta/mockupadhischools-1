<form action="" name="form_edit" id="form_edit" method="POST">
<div class="adminmainlist">
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div>
	
	<div class="clearboth"> </div>
	<div class="admininnercontentdiv">
		<div class="page_error" id="display_error" align="center"> <?php echo validation_errors();?> </div>
		<div  class="page_error" id="display_server_error" align="center">
			<?php echo $this->session->userdata("error");  $this->session->unset_userdata("error"); ?>
		</div>
		<div  class="page_success" id="flashsuccess"><?php echo $this->session->userdata("successMsg"); $this->session->unset_userdata("successMsg");   ?></div>
		<input type="hidden" name="list_id" value="<?php echo $quizList->id?>" />
		<div class="div_row_first">
			<div class="floatleft topic-form-div">Topic Name : <input type="text" name="topic" value="<?php echo $quizList->topic?>" placeholder="Enter a topic" /></div>
		</div>
		<div class="div_row_second">
			<div class="topic-form-div">
				<input type="submit" name="submit" value="Update"/>
				<input type="button" name="cancel" value="Cancel" onclick="javascript:cancel_action('<?php echo base_url().'/admin_quiz/edit/'. $quizList->course_id . "/" . $quizList->id. "/" . $edition_id ?>');">
			</div>
		</div>
		<div class="backtolist"><?php echo anchor(base_url().'/admin_quiz/edit/'. $quizList->course_id . "/" . $quizList->id. "/" . $edition_id ,'<< Back to chapter edit')?></div>
		
	</div>
</div>
<?php form_close(); ?>