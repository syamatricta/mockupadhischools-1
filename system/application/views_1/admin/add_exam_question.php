<form action="" name="form_edit" id="form_add" method="POST">
<div class="adminmainlist">
		<div class="adminpagebanner">
			<div class="adminpagetitle"><?php echo ucfirst($page_title)?>
			</div>
		</div>
		<div class="clearboth"> </div>
		<div class="admininnercontentdiv">
				
				<div  id="error" align="center"  class="page_error" id="display_error">	</div>
					<div class="page_error" align="center" id="server_error">
						<?php if(validation_errors())echo validation_errors();				
						?>
					</div>	
				<div class="clearboth">&nbsp;</div>	
				<div class="div_row_first">
					<div class="floatleft" style="width:50%;">
						<select name="edition" id="edition">
						<option value="">Select Edition</option>
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
				</div>
				<div class="clearboth">&nbsp;</div>	
				<div class="div_row_first">
					<div class="floatleft" style="width:50%;">
						Question
					</div>
				</div>
				<div class="div_row_first" >
					<div class="floatleft" style="width:50%;">
						<textarea  rows="0" cols="100" name="questions"  id="questions"><?php echo set_value('questions')?></textarea>
					</div>
				</div>
				
				
				<div class="div_row_second">
					<div class="floatleft" style="width:40%;">
						Options
					</div>
					<div class="floatleft" style="width:50%;">
						Choose right answer
					</div>
					
					
				</div>
				<?php for($i=1;$i<=4;$i++){?>
					<div class="div_row_second">
						<div class="floatleft" style="width:2%;">&nbsp;</div>
						<div class="floatleft" style="width:40%;">
						<?php echo $i.')&nbsp;&nbsp;';?>
						
							<input type="text" size="40" maxlength="250" name="answers<?php echo $i;?>" id="answers<?php echo $i;?>" value="<?php echo set_value('answers'.$i)?>">
						
						</div>
						
						<div class="floatleft" style="width:40%;">
							<input type="radio" name="answer_option" value="<?php echo $i?>" checked='checked'>
							
						</div>
					</div>
				<?php }?>	
				
				<div class="div_row_second">
			 		<div class="floatleft" style="width:20%;">&nbsp;</div>
			 				<div class="floatleft" style="width:8%;">
								<input type="button" value="Add" onclick="javascript:return add_question('<?php echo base_url() ?>','<?php echo $course_id?>','<?php echo $edition_id?>');"/>
					 		</div>
					 		<div class="floatleft" style="width:40%;">
								<input type="button" onclick="javascript:cancel_action('<?php echo site_url().'admin_exam/edit/'.$course_id.'/'.$edition_id?>');" value="Cancel"/>
					 		</div>
				 	</div>	
			 	
				
				
				<div class="div_row_second" >
					<div class="floatleft" style="width:15%;">&nbsp;</div>
					<div class="backtolist">
						<a href="<?echo site_url()?>admin_exam/"><< Back to list</a>
					</div>
				</div>	
			</div>
		</div>
	</div>
</form>