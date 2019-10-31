<?php echo form_open_multipart('admin_user', array('name'=>'frmadhischool','id' => 'adminufrmadhischool'));?>
<div class="adminmainlist">
		<div class="adminpagebanner">
			<div class="adminpagetitle"><?php echo $page_title?></div>
		</div>
		<div class="clearboth"> </div>
		<div class="admininnercontentdiv">
			
			<div class="listdata">
				<div  class="page_error"><?php echo $this->session->flashdata("error");  ?></div>
				<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
				<?php /* course details */?>
			<?php if(count($coursedetails)>0){?>
				<div class="addressdivisionleft"><strong>Course Details of <?php echo $username->firstname. " ".$username->lastname ?> </strong></div>
				<div class="clearboth"></div>
				<div class="admintopheads">
					<div class="adminlistheadings" style="width:6%; text-align:center">Sl. No</div>
					<div class="adminlistheadings" style="width:22%">Course</div>
					<div class="adminlistheadings" style="width:13%">Enrolled Date</div>
					<div class="adminlistheadings" style="width:13%">Delivered Date</div>
					<div class="adminlistheadings" style="width:13%">Effective Date</div>
					<div class="adminlistheadings" style="width:13%">Attended Date</div>
					<div class="adminlistheadings" style="width:9%">Status</div>
					<div class="adminlistheadings" style="width:10%">Score</div>
				</div>
				<div class="clearboth"></div>
				<?php $count=1; 
				 foreach($coursedetails as $data){
				 $bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';	
				 ?>
				  <div class="<?php print($bg_color);?>">
					<div class="adminlistheadings" style="width:6%; text-align:center"><?php echo $count;?></div>
					<div class="adminlistheadings" style="width:22%"><?php echo $data->course_name; ?></div>
					<div class="adminlistheadings" style="width:13%"><?php if('0000-00-00' == $data->enrolled_date) { echo ""; } else { echo formatDate($data->enrolled_date); }?></div>
					<div class="adminlistheadings" style="width:13%"><?php if('0000-00-00' == $data->delivered_date) { echo "Not delivered"; } else { echo formatDate($data->delivered_date); } ?></div>
					<div class="adminlistheadings" style="width:13%"><?php if('0000-00-00' == $data->delivered_date) { echo " "; } else { echo formatDate($data->effective_date);} ?></div>
					<div class="adminlistheadings" style="width:13%"><?php if('0000-00-00' == $data->last_attemptdate) { echo "Not attended "; } else { echo formatDate($data->last_attemptdate); }?></div>
					<div class="adminlistheadings" style="width:9%"><?php 
							if('P'== $data->status){
								echo "Passed";
							}
							else if('F'== $data->status){ 
								echo "Failed";
							}
					#echo $data->status; ?></div>
					<div class="adminlistheadings" style="width:10%"><?php echo $data->final_score; ?></div>
					<div class="clearboth"></div>
				</div>
				 <? $count++; 
				 }		
				} else {
					echo "<strong>No courses in this order</strong>";
				}?>
				<div class="backtolist"><?php echo anchor('admin_orders/view_orders/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6),'<< Back to order details')?></div>
		</div>
	</div>
</div>
<input type="hidden" id="hidcount" name="hidcount"  value="<?php if(isset($_POST['hidcount'])){echo $_POST['hidcount'];}?>" />
<?php echo form_close();?>