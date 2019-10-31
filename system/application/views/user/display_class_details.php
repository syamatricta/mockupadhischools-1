<div class="class_popup">
    <div class="popup_content_name">Chapter Details</div>
														<div class="cb"></div>
	<div class="clearboth paddingbottom">
<!--		<input type="text" name="hdnSubregion" id="hdnSubregion" value="<?php //if(isset($hdnSubregion)){ echo $hdnSubregion;}?>" />
		<input type="text" name="hdnDated" id="hdnDated" onchange="javascript:$('classform').submit();" value="<?php //if(isset($dated)){ echo $dated;}?>" />-->
	</div>
	<div class="details_head"><?php if(isset($arr_subregion)){ echo $arr_subregion->region.' >> '.$arr_subregion->sub_name;}?></div>
	<div class="clearboth paddingbottom"></div>
		<div class="details_image_main">
			<?php if(isset($arr_subregion)){ ?><div class="details_image_contianer"><img width="148" height="79" class="frame_format" src="<?php echo $image_url;?>"/></div><?php } ?>
		</div>
		<div class="details_data_contianer" style="height:auto;">
			<div class="left_class">Date</div>
			<div class="middelcolon_class">:</div>
			<div class="right_class"><?php if(isset($dated)){ echo $dated;}?></div>
			<div class="clearboth paddingbottom"></div>
		<?php if(isset($arr_subregion)){  ?>
			<div class="left_class">Location address</div>
			<div class="middelcolon_class">:</div>
			<div class="right_class"><?php if(isset($arr_subregion)){ echo $arr_subregion->subregion_address;}?></div>
			<div class="clearboth paddingbottom"></div>
			<div class="left_class">Location details</div>
			<div class="middelcolon_class">:</div>
			<div class="right_class"><?php if(isset($arr_subregion)){ echo $arr_subregion->subregion_description;}?></div>
			<div class="clearboth paddingbottom"></div>
		<?php } ?>
		<?php
			if(isset($arr_class)){
				foreach ($arr_class as $data){
					echo '<div class="left_class">Class hours</div>';
					echo '<div class="middelcolon_class">:</div>';
					echo '<div class="right_class">'.$data->start_hr.':'.$data->start_mts.' '.$data->meridiean_start.' - '.$data->end_hr.':'.$data->end_mts.' '.$data->meridiean_end.'</div>';
					echo '<div class="clearboth paddingbottom"></div>';
					echo '<div class="left_class">Course</div>';
					echo '<div class="middelcolon_class">:</div>';
					echo '<div class="right_class">'.$data->course.'</div>';
					echo '<div class="clearboth paddingbottom"></div>';
					echo '<div class="left_class">Chapter Details</div>';
					echo '<div class="middelcolon_class">:</div>';
					echo '<div class="right_class">'.$data->descp.'</div>';
					echo '<div class="clearboth paddingbottom"></div>';
				}
		 } 
	echo '</div>';
     
        if(@$adhi_course->id != @$arr_class[0]->course_id){
?>
<br/><div class="details_head" style="font-weight:normal;"> 
    Students must spend 18 days and 45 hours with the course material per course.  Attendance is not required to obtain a certificate of completion.
</div>
<?php  }
echo '</div>';
?>
                 