<?php 
$usertype = $this->input->post('cmbType');
$coursetype = $this->input->post('cmbCourseType');
$paymenttype = $this->input->post('cmbPaymentType');
echo form_open('admin_course/list_course_details/', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="adminmainlist">
		<?php 
		if(count($courses) > 0){
/* list headings starts here*/		
		?>
		<div class="adminpagebanner">
			<div class="adminpagetitle"><?php echo $page_title?></div>
		</div>
		<div class="clearboth"> </div>
		<div class="admininnercontentdiv">
			<div class="listdata">
				<div  class="page_error"><?php echo $this->session->flashdata("error");  ?></div>
				<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
				<div align="right" class="floatleft" style="width: 99%; text-align: right; border: 1px solid rgb(153, 153, 153); padding: 5px; background: none repeat scroll 0% 0% rgb(232, 227, 220);">
					<div class="floatleft smallpaddingright">
						User Type : 
						<select name="cmbType" id="cmbType" >
							<option value="all" <?php if($usertype == 'all'){ echo "selected";} ?>>All</option>
							<option value="B" <?php if($usertype == 'B'){ echo "selected";} ?>>Broker</option>
							<option value="S" <?php if($usertype == 'S'){ echo "selected"; } ?>>Sales</option>
						</select>&nbsp;&nbsp;&nbsp;
					</div>
					<div class="floatleft" id="showTypes">
							<div class="floatleft smallpaddingright">
								Course Type : 
								<select name="cmbCourseType" id="cmbCourseType">
									<option value="0" <?php if($coursetype == ''){ echo "selected";} ?>>Select</option>
									<option value="Live" <?php if($coursetype == 'Live'){ echo "selected";} ?>>Live</option>
									<option value="Online" <?php if($coursetype == 'Online'){ echo "selected"; } ?>>Online</option>
								</select>
								&nbsp;&nbsp;&nbsp;
							</div>
							<div class="floatleft smallpaddingright">
								Payment Type : 
								<select name="cmbPaymentType" id="cmbPaymentType">
									<option value="0" <?php if($paymenttype == ''){ echo "selected";} ?>>Select</option>
									<option value="Package" <?php if($paymenttype == 'Package'){ echo "selected";} ?>>Package</option>
									<option value="Cart" <?php if($paymenttype == 'Cart'){ echo "selected"; } ?>>Cart</option>
								</select>
							</div>
					</div>
	
					<div class="floatleft"> &nbsp;&nbsp;&nbsp;<input type="button" value="Search" onclick="javascript:onTypeChange()" /></div>
				</div>
				<div class="clearboth"> &nbsp;</div>
				<div class="admintopheads">
				<?php if('' == $this->input->post('cmbType') || 'all' == $this->input->post('cmbType')){?>
						<div class="adminlistheadings" style="width:10%; text-align:center;">Sl. No</div>
						<div class="adminlistheadings" style="width:15%;">Course Code</div>
						<div class="adminlistheadings" style="width:55%;">Course Name</div>
						<div class="adminlistheadings" style="width:10%;">Weight (Kg)</div>						
						<div class="adminlistheadings" style="width:10%;">Actions</div>
				<?php } else if($user_coursetype == 2 || $user_coursetype == 4 || $user_coursetype == 6 || $user_coursetype == 8 ) {	?>
						<div class="adminlistheadings" style="width:10%; text-align:center;">Sl. No</div>
						<div class="adminlistheadings" style="width:15%;">Course Code</div>
						<div class="adminlistheadings" style="width:55%;">Course Name</div>
						<div class="adminlistheadings" style="width:10%;">Amount ($)</div>
						<div class="adminlistheadings" style="width:10%;">Action</div>
				<?php } else if($user_coursetype == 1 || $user_coursetype == 3 || $user_coursetype == 5 || $user_coursetype == 7 ) {	 ?>
						<div class="adminlistheadings" style="width:10%; text-align:center;">Sl. No</div>
						<div class="adminlistheadings" style="width:65%;">Course Name</div>
						<div class="adminlistheadings" style="width:10%;">Amount ($)</div>
						<div class="adminlistheadings" style="width:10%;">Action</div>
				<?php } ?>
				</div>
			</div>
			<div class="clearboth"> </div>
		<?php  
	/* list headings ends here*/
				$count=1; 
				$weight = 0;
			   if ($this->uri->segment(4)){
					$count = $count+$this->uri->segment(4);
				}
				   foreach($courses as $data){
				  	$bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';
				  	$roundedweight = fncCalculateFloat(($data->wieght/2.2),2);
	/* data list starts here */ 
					
						if('' == $this->input->post('cmbType') || 'all' == $this->input->post('cmbType')){
						?>
							<div class="<?php print($bg_color);?>">
							 	<div class="floatleft" style="width:10%;  text-align:center;"><?php print $count; ?></div> 
							 	<div class="floatleft" style="width:15%;"><?php echo $data->course_code	; ?></div> 
							 	<div class="floatleft" style="width:55%;"><?php echo $data->course_name ; ?></div> 
							 	<div class="floatleft" style="width:10%;"><?php echo $roundedweight;	?></div> 
							 	<div class="floatleft" style="width:10%;"><?php echo anchor('admin_course/edit_courseweight/'.$data->id.'/'.$this->uri->segment(3).'/'.$this->uri->segment(4),'Edit');?></div> 
								<?php $weight+=$roundedweight?>
							</div>
						<?php 
						} else if($user_coursetype == 2 || $user_coursetype == 4 || $user_coursetype == 6 || $user_coursetype == 8 ) {						 		
						 	?><div class="<?php print($bg_color);?>">
							 		<div class="floatleft" style="width:10%;  text-align:center;"><?php print $count; ?></div> 
							 		<div class="floatleft" style="width:15%;"><?php echo $data->course_code; ?></div> 
								 	<div class="floatleft" style="width:55%;"><?php echo $data->course_name; ?></div> 
								 	<div class="floatleft" style="width:10%;"><?php echo $data->amount;	?></div> 
								 	<div class="floatleft" style="width:10%;"><?php echo anchor('admin_course/edit_courserate/'.$data->id.'/'.$this->uri->segment(3).'/'.$this->uri->segment(4),'Edit');?></div> 
								</div>
						 	<?php 
						}else if($user_coursetype == 1 || $user_coursetype == 3 || $user_coursetype == 5 || $user_coursetype == 7 ) {						 		
						 	?><div class="<?php print($bg_color);?>">
							 		<div class="floatleft" style="width:10%;  text-align:center;"><?php print $count; ?></div> 
							 		<div class="floatleft" style="width:65%;">
							 			<?php foreach($courses_list as $list){
							 				echo $list->course_name."<br/><br/>";
							 			}
							 				?>

							 		</div> 
								 	<div class="floatleft" style="width:10%;"><?php echo $data->amount;	?></div> 
								 	<div class="floatleft" style="width:10%;"><?php echo anchor('admin_course/edit_courserate/'.$data->id.'/'.$this->uri->segment(3).'/'.$this->uri->segment(4),'Edit');?></div> 
							 	</div>
						 	<?php 
						}
						
						?>
						<div class="clearboth"> </div>
				<?php  $count++; 
	/* data list ends here */ 			
			} if('' == $this->input->post('cmbType') || 'all' == $this->input->post('cmbType')){?>
			
			<div class="floatleft" style="width:80%;  text-align:center;"><strong>Total Weight</strong></div>
			<div class="floatleft" style="width:10%;  text-align:left;"><strong><?php echo $weight;?> Kg</strong></div>
			<div class="clearboth"></div>
			<div class="floatleft page_error">Total course weight allowed for shipping is 68 Kg</div>
			<?php } ?>
		</div>
		<div class="pagination"><?  echo $paginate;?></div>
		<div style="clear:both">&nbsp;</div>
		<?php } else { ?>
			<div class="nodata">No Courses</div>
		<?php }?> 
</div>
<input type="hidden" id="hidusertype" name="hidusertype"  value="<?php if(isset($_POST['hidusertype'])){echo $_POST['hidusertype'];}?>" />
<?php echo form_close();?>