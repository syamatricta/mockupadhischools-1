<?php echo form_open('admin_region/list_region', array('name'=>'adminregionform','id' => 'adminregionform')); ?>
<div class="adminmainlist">
	<?php /* list headings starts here*/?>
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div>
	<div class="clearboth"></div>
	<div class="page_error paddingleft" id="errordisplay"><?php if($this->session->flashdata('error')){ echo $this->session->flashdata('error');}?></div>
	<div class="page_success paddingleft"><?php if($this->session->flashdata('success')){ echo $this->session->flashdata('success');}?></div>
	<div class="clearboth"></div>
		
	<div class="admininnercontentdiv">
                <?php //if($this->authentication->check_permission_redirect('super_admin', FALSE)){?>
                    <div class="list_regionadd"><a href="javascript: void(0);" onclick="javascript: fncDisplayAddRegion(<?php echo (int)$page_no;?>);">Add Region</a></div>
                <?php //}?>
		<div class="listdata">
			<div class="admintopheads">
				<div class="adminlistheadings list_slno" >Sl. No</div>
				<div class="adminlistheadings" style="width:25%;">Region Name</div>
				<div class="adminlistheadings" style="width:25%;text-align:center;">Manage Sub-Region</div>
				<div class="adminlistheadings list_others">Edit</div>
				<div class="adminlistheadings list_others">Delete</div>
			</div>
		</div>
		<div class="clearboth"></div>
		<?php  
		/* list headings ends here*/
		if(count($regions) > 0){
			$count=1; 
			if ($page_no){
				$count = $count+$page_no;
			} 
			foreach($regions as $data){
				$bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';
				/* data list starts here */ 
				?>
				<div class="<?php print($bg_color);?>">
				 	<div class="floatleft list_slno"><?php print $count; ?></div> 
				 	<div class="floatleft" style="width:25%;"><?php echo $data->region_name	; ?></div> 
				 	<div  class="floatleft region_leftlabel"><a href="javascript: void(0);" onclick="javascript: fncDisplayAllSubRegion(<?php echo $data->id;?>,<?php echo (int)$page_no;?>);">View Sub-Regions</a></div> 
				 	<div class="floatleft" style="width:13%;"><a href="javascript: void(0);" onclick="javascript: fncDisplayNewSubRegion(<?php echo $data->id;?>,<?php echo (int)$page_no;?>);">Add Sub-Region</a></div> 
				 	<div class="list_others"><a href="javascript: void(0);" onclick="javascript: fncDisplayEditRegion(<?php echo $data->id;?>,<?php echo (int)$page_no;?>);">Edit</a></div> 
				 	<div class="list_others"><a href="javascript: void(0);" onclick="javascript:return fncDeleteRegionDetails(<?php echo $data->id;?>,<?php echo (int)$page_no;?>);">Delete</a></div> 
				</div>
				<div class="clearboth"> </div>
				<?php 
				$count++; 
			}
			?>
			</div>
			<div class="pagination"><?php  echo $paginate;?></div>
			<div class="clearboth">&nbsp;</div>
<?php }else { ?>
			</div>
			<div class="nodata">No region(s) found</div>
<?php }?>
</div>
<?php echo form_close();?>