<?php echo form_open('admin_subregion/list_subregion', array('name'=>'adminregionform','id' => 'adminregionform')); ?>
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
		<div  class="floatleft paddingbottom" >Region&nbsp;:
			<select name="sltRegionList" id="sltRegionList" style="width:182px;">
				<option value="0">Select</option>
				<?php 
				if(count($region_list)>0){ 
					foreach($region_list as $data){
						echo '<option value="'.$data->id.'"';
							if($region_id == $data->id)
							{
								echo 'selected';
							}
						echo ' >'.$data->region_name.'</option>';
					}
				} ?>
			</select>
			<input type="button" name="btnSearch" id="btnSearch" value="Search" onclick="javascript: fncSearch();"/>
		</div>
		<div class="list_regionadd"><a href="javascript: void(0);" onclick="javascript: fncDisplayAddSubRegion(<?php echo (int)$page_no;?>);">Add Sub-Region</a></div>
		<div class="clearboth"></div>
		<div class="listdata">
			<div class="admintopheads">
				<div class="adminlistheadings list_slno">Sl. No</div>
				<div class="adminlistheadings" style="width:25%;">Sub-Region Name</div>
				<div class="adminlistheadings" style="width:20%;">Region Name</div>
				<div class="adminlistheadings region_leftlabel_midcolon">Schedule</div>
				<div class="adminlistheadings list_others">View</div>
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
				 	<div class="list_slno"><?php print $count; ?></div> 
				 	<div class="floatleft" style="width:25%;"><?php echo $data->sub_name; ?></div> 
				 	<div class="floatleft" style="width:20%;"><?php echo $data->region; ?>&nbsp;</div> 
				 	<div class="floatleft region_leftlabel_midcolon"><a href="javascript: void(0);" onclick="javascript: fncGetClassDetails(<?php echo $data->region_id;?>,<?php echo $data->id;?>);">Class details</a></div> 
				 	<div class="list_others"><a href="javascript: void(0);" onclick="javascript: fncDisplayViewSubRegion(<?php echo $data->id;?>,<?php echo (int)$page_no;?>);">View</a></div> 
				 	<div class="list_others"><a href="javascript: void(0);" onclick="javascript: fncDisplayEditSubRegion(<?php echo $data->id;?>,<?php echo (int)$page_no;?>);">Edit</a></div> 
				 	<div class="list_others"><a href="javascript: void(0);" onclick="javascript:return fncDeleteRegionDetails(<?php echo $data->id;?>,<?php echo (int)$page_no;?>);">Delete</a></div> 
				</div>
				<div class="clearboth"> </div>
				<?php 
				$count++; 
			}
			?>
			</div>
			<div class="pagination"><?php  echo $paginate;?></div>
			<div class="clearboth">
				<input type="hidden" id="sltSearchRegion" name="sltSearchRegion" />
				<input type="hidden" id="sltSearchSubregion" name="sltSearchSubregion" />
			</div>
<?php }else { ?>
			</div>
			<div class="nodata">No sub-region(s) found</div>
<?php }?>
</div>
<?php echo form_close();?>