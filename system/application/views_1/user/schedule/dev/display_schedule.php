<?php echo form_open("home/class_details", array('name'=>'classform','id' => 'classform'));
	if(isset($arr_result) && !empty($arr_result)){?>
		<div class="clearboth paddingbottom">
			<input type="hidden" name="hdnSubregion" id="hdnSubregion" value="<?php if(isset($hdnSubregion)){ echo $hdnSubregion;}?>" />
			<input type="hidden" name="hdnDated" id="hdnDated" onchange="javascript:$('classform').submit();" value="<?php if(isset($dated)){ echo $dated;}?>" />
		</div>
		<div id="divClass">
			<div id="divImageHead">Today's Classes</div>
			<div class="clearboth"></div>
			<div id="divShowRelatedImage">
				<?php $this->load->view('user/display_related_class');?>
			</div>
		</div>
<?php 
	}?>
	<div class="filter_container">
		<label class="filter_label">Region</label>
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
		<label class="filter_label">Sub-Region</label>
		<div id="divSubregion" class="filter_subregion">
			<select name="sltSearchSubregion" id="sltSearchSubregion" <?php if(isset($class_mode)){ echo 'disabled';}?> onchange="javascript: fncDisplayDefaultList(<?php echo $today_timeline;?>,<?php echo date('j',strtotime('-8 hour'))?>,<?php echo date('n',strtotime('-8 hour'))?>,<?php echo date('Y',strtotime('-8 hour'))?>);">
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
                 <label class="filter_label">Course</label>
		<div class="floatleft">
			<select name="sltSearchCourse" id="sltSearchCourse" <?php if(isset($class_mode)){ echo 'disabled';}?> onchange="javascript: fncDisplayDefaultList(<?php echo $today_timeline;?>,<?php echo date('j',strtotime('-8 hour'))?>,<?php echo date('n',strtotime('-8 hour'))?>,<?php echo date('Y',strtotime('-8 hour'))?>);">
				<option value="0">Select</option>
				<?php
				if($course_list){
					foreach ($course_list as $data){
						echo '<option style="background:url('.$this->config->item('sq_image_url').$crse_color[$data->id].'.png) no-repeat top right;" value="'.$data->id.'"';if(isset($course_search) && $course_search==$data->id){echo 'selected';} echo '>'.$data->course_name.'</option>';
					}
				}
				?>
			</select>
		</div>
                <div class="clearboth">&nbsp;</div>
                <div class="floatleft" id="chter_cnt" style="display:none;">
                    <label class="filter_label">Chapter</label>
                    <div class="floatleft">
			<select name="sltSearchChp" id="sltSearchChp" <?php if(isset($class_mode)){ echo 'disabled';}?> onchange="javascript: fncDisplayDefaultList(<?php echo $today_timeline;?>,<?php echo date('j',strtotime('-8 hour'))?>,<?php echo date('n',strtotime('-8 hour'))?>,<?php echo date('Y',strtotime('-8 hour'))?>);">
				<option value="0">Select</option>
				<?php
				if($chp_list){
					for($i=1;$i<=count($chp_list);$i++){
						echo '<option value="'.$i.'"';if(isset($chp_search) && $chp_search==$i){echo 'selected';} echo '>'.$chp_list[$i].'</option>';
					}
				}
				?>
			</select>
		   </div>

                </div>
	</div>
	<div class="clearboth"></div>
	<div id="divUserCalendar" class="admininnercontentdiv">
		<?php $this->load->view('user/schedule/schedule_calendar');?>
	</div>	
	<input type="hidden" name="hdnTimeline" id="hdnTimeline" value="<?php echo $today_timeline;?>" />
<?php echo form_close();
$content  		 	= "var content = ".$json_array.";";
$content  		 	.= "fncDisplayDefaultList(".$today_timeline.",".date('j',strtotime('-8 hour')).",".date('n',strtotime('-8 hour')).",".date('Y',strtotime('-8 hour')).");";
$script_encoded  	= fncEncodeJavascript($content);

?>
<script type="text/javascript" language="javascript">
	<?php echo $script_encoded;	?>
</script>