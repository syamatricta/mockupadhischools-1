<?php echo form_open('admin_career_event/display_calendar', array('name'=>'adminscheduleform','id' => 'adminscheduleform')); ?>
<div class="adminmainlist">
	<?php /* list headings starts here*/ ?>
	<div style="float:left;padding:10px 0px 0px 0px;width:100%;color:#000000;">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div>
	<div  class="page_error"><?php if(isset($error_message))echo $error_message;?></div>
	<div  class="page_success"><?php if(isset($success_message))echo $success_message;?></div>
	<div class="clearboth paddingtop"></div>
	
	<div style="float:left;padding:10px 0px 0px 10px;width:90%;color:#000000;">
		<?php 
			if(isset($class_mode)){
				echo '<input type="hidden" id="sltSearchRegion" name="sltSearchRegion" value="'.$region_search.'" />';
				echo '<input type="hidden" id="sltSearchSubregion" name="sltSearchSubregion" value="'.$subregion_search.'" />';
				if($regions){
						foreach ($regions as $data){
							if(isset($region_search) && $region_search==$data->id){echo '<label style="float:left;padding:5px 5px 0px 7px;color:#868686;">'.$data->region_name.'&nbsp;>></label>';}
							
						}
					}
				if(isset($region_search) && isset($raw_subregion)){ 
						foreach ($raw_subregion as $data){
							if(isset($subregion_search) && $subregion_search==$data->id){echo '<label style="float:left;padding:5px 5px 0px 7px;color:#868686;">'.$data->sub_name.'</label>';}
							
						}
				}
			}else{?>
				<label style="float:left;padding:5px 5px 0px 7px;">Region</label>
				<div class="floatleft">
					<select name="sltSearchRegion" id="sltSearchRegion" onchange="javascript: fncGetSubregion('sltSearchRegion','sltSearchSubregion');" <?php if(isset($class_mode)){ echo 'disabled';}?>>
						<option value="0">Select</option>
						<?php 
						if($regions){
							foreach ($regions as $data){
								echo '<option value="'.$data->id.'"';if(isset($region_search) && $region_search==$data->id){echo 'selected';} echo '>'.$data->region_name.'</option>';
							}
						}
						?>
					</select>
				</div>
				<label style="float:left;padding:5px 5px 0px 7px;">Sub-Region</label>
				<div id="divSubregion" style="float:left;padding:0px 5px 0px 0px;">
					<select name="sltSearchSubregion" id="sltSearchSubregion" <?php if(isset($class_mode)){ echo 'disabled';}?>>
						<option value="0">Select</option>
						<?php 
						if(isset($region_search) && isset($raw_subregion)){ 
							foreach ($raw_subregion as $data){
								if($data->regionid == $region_search){
									echo '<option value="'.$data->id.'" ';if(isset($subregion_search) && $subregion_search==$data->id){echo 'selected';} echo ' >'.$data->sub_name.'</option>';
								}
							}
						}
						?>
					</select>
				</div>
				<div>
					<input type="submit" value="Search" <?php if(isset($class_mode)){ echo 'disabled';}?> />
				</div>
		<?php } ?>
		
	</div>	
	<div style="float:left;padding:10px 0px 0px 10px;"><!--<a href="javscript: void(0);" onclick="javascript:return fncShowAdd(<?php //echo date('j'); ?>,<?php //echo date('n'); ?>,<?php //echo date('Y'); ?>);">Add Event</a>--></div>
	<div class="clearboth"></div>
	<div id="divMainCalendar" class="admininnercontentdiv">
		<?php $this->load->view('admin/career_event/event_calendar');?>
	</div>
	<div class="clearboth"></div>
	<?php //display event list ?>
	<div id="divDisplayEventList"></div>
	
	<?php //popup div ?>
	<div id="divAddEvent" style="display:none;">
		<div id="divPopHeader">
			<div id="divPopUpDrag" class="popup_draghandle" >Add Event</div>
			<div id="divPopClose"> <a  href="javascript:void(0);" onclick="tinyMCE.execCommand('mceRemoveControl', false, 'txtContent');" > <img class="popup_closebox" src="<?php echo $this->config->item('images');?>innerpages/icon_close.gif" /> </a></div>
		</div>
		<div id="divContent"><?php //paste your content here through ajax or javascript ?></div>
	</div>
	<input type="hidden" id="txtWhat2Do" name="txtWhat2Do" value="display"/>
	<input type="hidden" name="hdnCurrentDate" id="hdnCurrentDate" value="<?php if(isset($hdnCurrentDate))echo $hdnCurrentDate;else echo $today;?>"/>
	<?php  enable_tiny_mce("txtContent","simple"); ?>
</div>
<?php echo form_close();

$content  		 = "var content = ".$json_array.";";
if(($actual_month_year == $current_month_year) || (isset($hdnCurrentDate) && $hdnCurrentDate!= '1970/01/01')){
	$content  	.= "fncShowDefaultEvent();";
}

$script_encoded  	= fncEncodeJavascript($content);

?>
<script type="text/javascript" language="javascript">
	<?php echo $script_encoded;	?>
</script>