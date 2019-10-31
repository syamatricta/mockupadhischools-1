<div class="class_popup">
	<div class="clearboth paddingbottom"></div>
	<div class="details_head"><?php echo $arr_class->region.' >> '.$arr_class->subregion;?></div>
	<div class="clearboth paddingbottom"></div>
		<div class="details_image_main">
			<div class="details_image_contianer"><img width="148" height="79" class="frame_format" src="<?php echo $image_url;?>"/></div>
		</div>
		<div class="details_data_contianer">
			<div class="left_class">Date</div>
			<div class="middelcolon_class">:</div>
			<div class="right_class"><?php echo $dated;?></div>
			<div class="clearboth paddingbottom"></div>
			<div class="left_class">Location Address</div>
			<div class="middelcolon_class">:</div>
			<div class="right_class"><?php echo $arr_class->subregion_address;?></div>
			<div class="clearboth paddingbottom"></div>
			<div class="left_class">Location details</div>
			<div class="middelcolon_class">:</div>
			<div class="right_class"><?php echo $arr_class->subregion_description;?></div>
			<div class="clearboth paddingbottom"></div>

			<div class="left_class">Class hours</div>
			<div class="middelcolon_class">:</div>
			<div class="right_class"><?php echo $arr_class->start_hr.':'.$arr_class->start_mts.' '.$arr_class->meridiean_start.' - '.$arr_class->end_hr.':'.$arr_class->end_mts.' '.$arr_class->meridiean_end;?></div>
			<div class="clearboth paddingbottom"></div>
                        <div class="left_class">Course</div>
			<div class="middelcolon_class">:</div>
			<div class="right_class"><?php echo $arr_class->crsname;?></div>
			<div class="clearboth paddingbottom"></div>
			<div class="left_class">Chapter Details</div>
			<div class="middelcolon_class">:</div>
			<div class="right_class"><?php echo $arr_class->descp;?></div>
			<div class="clearboth paddingbottom"></div>
			
	</div>
</div>