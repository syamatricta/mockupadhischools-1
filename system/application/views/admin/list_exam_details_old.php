<form action="" method="POST">
<div class="adminmainlist">
		<?php 
		if(count($course) > 0){
/* list headings starts here*/		
		?>
		<div class="adminpagebanner">
			<div class="adminpagetitle"><?php echo $page_title?>
			<select name="license" id="license" onchange="javascript:select_course(this.value,'<?php echo base_url() ?>')">
					<option value="">SELECT LICENSE</option>
					<option value="broker" <?php if($licen=='broker'){?> selected="selected"<?php }?>>Broker</option>
					<option value="sales" <?php if($licen=='sales'){?> selected="selected"<?php }?>>Sales</option>
				</select>
				
			</div>
		</div>
		<div class="clearboth"> </div>
		<div class="admininnercontentdiv">
			<div class="listdata">
				<div class="adminlistheadings" style="width:10%;">Sl. No</div>
				<div class="adminlistheadings" style="width:25%;">Course Name</div>
				<div class="adminlistheadings" style="width:15%;"></div>
				<div class="adminlistheadings" style="width:10%;"></div>
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
	/* data list starts here */ 
				 ?>
				  <div class="<?php print($bg_color);?>">
				 	<div class="floatleft" style="width:10%;"><?php print $count;?></div> 
				 	<div class="floatleft" style="width:25%;"><?php if($data['course_name'] !='') {echo $data['course_name']; } else { echo  '&nbsp' ;} ?></div> 
				 	<div class="floatleft" style="width:15%;">&nbsp;</div> 
				 	<div class="floatleft" style="width:10%;"><a href="<?php echo base_url()?>index.php/admin_exam/upload/<?php  echo $data['id'] ?>/<?php  echo $licen ?>">Upload</a></div> 
					<div class="floatleft" style="width:5%;"><a href="">View</a></div> 
					<div class="floatleft" style="width:5%;"><a href="">Edit</a></div> 
					<div class="floatleft" style="width:7%;">&nbsp;</div> 
					<div class="floatleft" style="width:11%;">&nbsp;</div> 
					<div class="floatleft" style="width:12%;">&nbsp;</div> 
				</div>
				<div class="clearboth"> </div>
				<?php $count++; 
	/* data list ends here */ 			
			}?>
		</div>
		<div class="pagination"><? // echo $paginate;?></div>
		<div style="clear:both">&nbsp;</div>
		<?php } ?>
</div>
<input type="hidden" id="hiduserid" name="hiduserid"  value="<?php if(isset($_POST['hiduserid'])){echo $_POST['hiduserid'];}?>" />
<?php echo form_close();?>