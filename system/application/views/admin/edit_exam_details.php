<form action="" name="form_edit" id="form_edit" method="POST">
<div class="adminmainlist">
		<?php 
		//if(count($questions) > 0){
/* list headings starts here*/		
		?>
		<div class="adminpagebanner">
			<div class="adminpagetitle"><?php echo ucfirst($page_title)?></div>
		</div>
		<div class="clearboth"> </div>
		<div class="admininnercontentdiv">
			<div class="listdata">
				<div class="page_error" id="display_error"></div>
				<div  class="page_error" id="display_server_error" ><?php echo $this->session->userdata("error");  $this->session->unset_userdata("error"); ?>
				
						<?php if(validation_errors())
								echo validation_errors();
							
							if(isset($msg) && $msg!='' ){
								if($msg==1)
									echo 'Deleted successfully';
								elseif ($msg==2)
									echo 'Updated successfully';
								elseif ($msg==3)
									echo 'Updation failed';
								elseif ($msg==4)
									echo 'Deletion failed';	
								elseif ($msg==5)
									echo 'Question and Answers added successfully';	
								else 
									echo $msg;	
								}
							if($this->session->flashdata('msg'))
								echo $this->session->flashdata('msg');	
								if(isset($display) && $display=='display'){	
									$edit_que='block';
									$list_que='none';
								}else{ 
									$edit_que='none';
									$list_que='block';
								}		
								
							
							?>
				</div>
 			<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
			<!--	<div class="admintopheads">
					<div class="adminlistheadings" style="width:10%;">Question and Answers</div>
				</div>-->
				
			<div class="clearboth"> </div>
			<div class="div_row_first">
			
				<div class="floatleft" >
					<select name="edition" id="edition" onchange="change_question(this.value,'<?php echo base_url()?>','<?php echo $course_id?>',0)">
						<option value="0">Select Edition</option>
						<?php 
							$edition_id_new = ($this->input->post('edition')) ? $this->input->post('edition') : $edition_id;
							if(isset($editions)):
								foreach($editions as $edition): 
						?>
							<option value="<?php echo $edition['id']; ?>" <?php echo ($edition_id ===  $edition['id']) ? "SELECTED" : "" ?>>Edition <?php echo $edition['edition_no']; ?></option>
						<?php
								endforeach; 
							endif;
						?>
					</select>
				</div>
				<div style="clear:both">&nbsp;</div>
				<div class="clearboth"> </div>
				<div class="floatleft" style="width:50%;display:<?php echo $list_que?>" id="question_box" >
					<select name="select_ques"  onchange="change_question(document.getElementById('edition').value,'<?php echo base_url()?>','<?php echo $course_id?>',this.value)">
						<?php
							if (empty($questions)){
								?>
								<option value="">Select Question</option>
								<?php
							}
							$i=0;
							foreach($questions as $data){?>
								<option value="<?php echo $data->id?>" <?php if($ques_id==$data->id){?>selected="selected"<?php }?>><?php echo ++$i.")&nbsp;".substr(trim(stripslashes($data->questions)),0,50)?></option>
						<?php	}
						?>
					</select>
				</div> 
			</div>
			
		
		<?php if (!empty($questions)) { ?>
		<div  id="show_list" style="display:<?php echo $list_que?>"  >
		<?php  if(isset($ques_ans) && (!empty($ques_ans))){$i=1;foreach($ques_ans as $data1){
				if($i==1){
			?>
		    <div class="div_row_first" id="list_ques">
		    	<div class="floatleft" style="width:1%;">&nbsp;</div>
		 		<div class="floatleft" style="width:50%;">
		 			<b><?php echo trim(stripslashes($data1->questions));?></b>
		 		</div>
		 		<div class="floatleft" style="width:15%;"><a href="<?php echo base_url()?>index.php/admin_exam/add_question/<?php echo $course_id?>/<?php echo $edition_id?>/<?php echo $ques_id?>">Add</a></div>
		 		<div class="floatleft" style="width:15%;"><a href="" onclick="javascript:return show_edit_quest();">Edit</a></div>
		 		<div class="floatleft" style="width:15%;">
			 		<?php //echo anchor('post/deletepost/'.$postlist->repository_id, 'Delete',"onclick='return deleteconfirm()'");?>
			 		<a href="<?php echo base_url()?>index.php/admin_exam/delete/<?php echo $course_id?>/<?php echo $edition_id?>/<?php echo $ques_id?>" onclick="javascript:return delete_quest();">Delete</a>
		 		</div>
			</div>
	 		
	 		<?php }?>
		    <div class="div_row_second"  id="list_ans" >
		    	<div class="floatleft" style="width:2%;">&nbsp;</div>
		 		<div class="floatleft" style="width:40%;">
		 			<?php 
					$str= trim(stripslashes($data1->answers));
					echo $i.')&nbsp;&nbsp;'. $str;?>
		 		</div>
		 		<div class="floatleft" style="width:40%;">
		 			<?php echo stripslashes($data1->answer_option);?>
		 		</div>
	 		</div>
	 		<?php $i++;}}?>
 		</div>
 
	 		<div style="display:<?php echo $edit_que?>" id="show_edit" >
	 			<div class="div_row_first"  id="edit_ques">
	 			<div class="floatleft" style="width:40%;">
						Question
					</div>
				</div>
		 		<?php if(isset($ques_ans) && (!empty($ques_ans))){ $i=1;foreach($ques_ans as $data1){
		 			if($i==1){
				?>
			    <div class="div_row_first"  id="edit_ques">
			 		<div class="floatleft" style="width:50%;">
			 			<textarea  rows="0" cols="100" name="questions" id="questions"><?php echo stripslashes($data1->questions);?></textarea>

			 		</div>
	
		 		</div>
		 		  <div class="div_row_second"  id="edit_ans" >
		 		  <div class="floatleft" style="width:40%;">
						Options
					</div>
					<div class="floatleft" style="width:50%;">
						Choose right answer
					</div>
				</div>
		 		<?php }?>
		 		
		 		
			    <div class="div_row_second"  id="edit_ans" >
			 	   
			   	 <div class="floatleft" style="width:2%;">&nbsp;</div>
			 		<div class="floatleft" style="width:40%;">
			 			<?php echo $i.')&nbsp;&nbsp;';?><?php $val = stripslashes($data1->answers);?>
			 			<input type="text" size="40" maxlength="250" name="answers<?php echo $i;?>" id="answers<?php echo $i;?>" value="<?php echo $val;?>">
			 			<input type="hidden" name="ansid<?php echo $i;?>" id="ansid<?php echo $i;?>" value="<?php echo $data1->ansid;?>">
			 		</div>
			 		<div class="floatleft" style="width:40%;">
			 			<input type="radio" name="answer_option"value="<?php echo $data1->ansid;?>"<?php if($data1->answer_option=='Y'){?>checked="checked"<?php }?>>
			 			<?php echo $data1->answer_option;?>
			 		</div>
	
		 		</div>
	
	 		<?php $i++;}}?>
	 		<div class="div_row_first"  id="edit_ans" >
		 		<div class="floatleft" style="width:20%;">&nbsp;</div>
		 				<div class="floatleft" style="width:8%;">
							<input type="button"  onclick="javascript: return edit_questions('<?php echo base_url() ?>','<?php echo $course_id?>','<?php echo $edition_id?>');" value="Update ">
				 		</div>
				 		<div class="floatleft" style="width:40%;">
							<input type="button" onclick="javascript:cancel_action('<?php echo site_url().'admin_exam/edit/'.$course_id.'/'.$edition_id.'/'.$ques_id?>');" value="Cancel">
				 		</div>
			 	</div>	
			 </div>		
		
		<input type="hidden" id="hidquestid" name="hidquestid"  value="<?php echo $ques_id?>" />
	<?php } else{?>
	<div class="admininnercontentdiv" align="center" style="height="200px;">No records Found</div>
	<?php }?>
	</div>			
		<div style="clear:both">&nbsp;</div>
	<div class="backtolist">
				<a href="<?php echo site_url()?>admin_exam/"><< Back to list</a>
	</div>
</div>
		
<?php echo form_close();?>