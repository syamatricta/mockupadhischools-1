<?php echo form_open('admin_user', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="adminmainlist">
		<?php 
		if(count($sitepages) > 0){
/* list headings starts here*/		
		?>
		<div class="adminpagebanner">
			<div class="adminpagetitle"><?php echo $page_title?></div>
		</div>
		<div class="clearboth"> </div>
		<div class="admininnercontentdiv">
			<div class="listdata">
				<div class="admintopheads">
					<div class="adminlistheadings" style="width:10%; text-align:center;">Sl. No</div>
					<div class="adminlistheadings" style="width:80%;">Sitepage</div>
					<div class="adminlistheadings" style="width:10%;">Action</div>
				</div>
			</div>
			<div class="clearboth"> </div>
		<?php  
	/* list headings ends here*/
				$count=1; 
			   if ($this->uri->segment(3)){
					$count = $count+$this->uri->segment(3);
				} 
				   foreach($sitepages as $data){
				  $bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';
	/* data list starts here */ 
					?>
						<div class="<?php print($bg_color);?>">
						 	<div class="floatleft" style="width:10%;  text-align:center;"><?php print $count; ?></div> 
						 	<div class="floatleft" style="width:80%;"><?php echo $data->title	; ?></div> 
						 	<div class="floatleft" style="width:10%;"><?php echo anchor('admin_sitepages/edit_sitepages/'.$data->id.'/'.$this->uri->segment(3),'Edit');?></div> 
						</div>
						<div class="clearboth"> </div>
				<?php 
				$count++; 
				}
	/* data list ends here */ 			
			?>
		</div>
		<div class="pagination"><?  echo $paginate;?></div>
		<div style="clear:both">&nbsp;</div>
	<?php } else { ?>
			<div class="nodata">No Sitepages</div>
		<?php }?> 
</div>
<input type="hidden" id="hidsitepage" name="hidsitepage"  value="<?php if(isset($_POST['hidsitepage'])){echo $_POST['hidsitepage'];}?>" />
<?php echo form_close();?>