<div style="width:100%;">
	<div  class="page_error" id="divError">&nbsp;</div>
	<div class="clearboth paddingtop"></div>
	<div class="label_style">Region<span class="red_star">*</span></div>
	<div class="label_colon">:</div>
	<div style="float:left;">
		<?php
		if(isset($class_mode)){
			echo '<input type="hidden" id="sltRegion" name="sltRegion" value="'.$region_search.'" />';
			echo '<input type="hidden" id="sltSubregion" name="sltSubregion" value="'.$subregion_search.'" />';
			if($regions){
					foreach ($regions as $data){
						if(isset($region_search) && $region_search==$data->id){echo '<label style="float:left;padding:5px 5px 0px 5px;">'.$data->region_name.'&nbsp;</label>';}
						
					}
				}
			
		}else{?>
			<select name="sltRegion" id="sltRegion" onchange="javascript: fncGetSubregion('sltRegion','sltSubregion');">
				<option value="0">Select</option>
				<?php 
				if($regions){
					foreach ($regions as $data){
						echo '<option value="'.$data->id.'" ';if(isset($region_search) && $region_search==$data->id){echo 'selected';} echo ' >'.$data->region_name.'</option>';
					}
				}
				?>
			</select>
		<?php } ?>
	</div>
	<div class="clearboth paddingtop"></div>
	
	<div class="label_style">Sub-Region<span class="red_star">*</span></div>
	<div class="label_colon">:</div>
	<div class="floatleft">
		<?php
		if(isset($class_mode)){
			if(isset($region_search) && isset($raw_subregion)){ 
				foreach ($raw_subregion as $data){
					if($data->regionid == $region_search){
						if(isset($subregion_search) && $subregion_search==$data->id){echo '<label style="float:left;padding:5px 5px 0px 5px;">'.$data->sub_name.'&nbsp;</label>';}
					}
				}
			}
		}else{?>
			<select name="sltSubregion" id="sltSubregion">
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
		<?php } ?>
	</div>
    <div class="clearboth paddingtop"></div>
	<div class="label_style">Courses<span class="red_star">*</span></div>
	<div class="label_colon">:</div>
	<div style="float:left;">
            <select name="sltCourses" id="sltCourses" onchange="showCapacity()">
                    <option value="0">Select</option>
                    <?php
                    if($course_list){
                            foreach ($course_list as $data){
                                    echo '<option value="'.$data->id.'" ';echo ' >'.$data->course_name.'</option>';
                            }
                    }
                    ?>
            </select>
		
	</div>
        <div id="weeklychapters_checkbox_div" style="float:left;display:none;">
            <input type="checkbox" name="txtRepeatWeeklyChapters" id="txtRepeatWeeklyChapters" 
                   class="zero_margin" value="yes" style="margin:3px 0 0 10px;" onclick="selectWeeklyChapters(this)" /> 
            <b><label for="txtRepeatWeeklyChapters">Add 1 to 15 Chapters for 9 Weeks</label></b>
        </div>
	<div class="clearboth paddingtop"></div>
	<div class="label_style">Instructor <span class="red_star">*</span></div>
	<div class="label_colon">:</div>
	<div style="float:left;">
            <select name="instructor" id="instructor">
                    <option value="0">Select</option>
                    <?php
                    if($instructor_list){
                            foreach ($instructor_list as $instructor){
                                    echo '<option value="'.$instructor->id.'" ';echo ' >'.$instructor->name.'</option>';
                            }
                    }
                    ?>
            </select>
		
	</div>
	<div id="capacityDiv" style="display:none;">
		<div class="clearboth paddingtop"></div>
	
		<div class="label_style">Capacity<span class="red_star">*</span></div>
		<div class="label_colon">:</div>
		<div>
			<input type="text" name="capacity" id="capacity"  value="" size="10"/>
		</div>
	</div>
	<div class="clearboth paddingtop"></div>
	
	<div class="label_style">Date<span class="red_star">*</span></div>
	<div class="label_colon">:</div>
	<div>
		<input type="text" name="txtDateStart" id="txtDateStart"  value="<?php if($selected_date){echo date('m/d/Y',strtotime($selected_date));}else echo set_value('txtDateStart');?>" size="10" readonly/>
		<img src="<?php  echo $this->config->item('images');?>calendar.gif"  onclick="displayCalendar(document.adminscheduleform.txtDateStart,'mm/dd/yyyy',this)"/>
	</div>
	<div class="clearboth paddingtop"></div>
	
        <div id="repeat_div">
            <div class="label_style">Do you want to repeat?</div>
            <div class="label_colon">:</div>
            <div>
                    <div id="divRepeatCheck" class="floatleft">
                            <input type="checkbox" name="txtRepeat" id="txtRepeat" class="zero_margin" onclick="javascript: fncCheckRepeatMode();" />
                    </div>
                    <div id="divRepeat" style="float:left;display:none;">
                            <div class="floatleft">
                                    <select name="sltRepeatType" id="sltRepeatType">
                                            <option value="1">Daily</option>
                                            <option value="2">Weekly</option>
                                    </select>
                            </div>
                            <div class="floatleft" style="padding:0px 0px 0px 10px;">
                                    Repeat till<span class="red_star">*</span>&nbsp;:&nbsp;<input type="text" name="txtDateEnd" id="txtDateEnd"  value="<?php echo set_value('txtDateEnd');?>"  size="10" readonly/>
                                    <img src="<?php  echo $this->config->item('images');?>calendar.gif"  onclick="displayCalendar(document.adminscheduleform.txtDateEnd,'mm/dd/yyyy',this)"/>
                            </div>
                    </div>
            </div>
            <div class="clearboth paddingtop"></div>
	</div>
        
	<div class="label_style">Time<span class="red_star">*</span></div>
	<div class="label_colon">:</div>
	<div>
		<div class="floatleft">
			<select id="sltFromHr" name="sltFromHr"> 
				<?php 
				$time_hour = range(1, 12);
				foreach ($time_hour as $num) {
					$number = sprintf('%02d',$num);
				    echo '<option value="'.$number.'"> '.$number.'</option>';
				}?>
				
			</select>
			<select id="sltFromMts" name="sltFromMts"> 
				<?php 
				$time_mts = range(0, 55, 5);
				foreach ($time_mts as $num) {
					$number = sprintf('%02d',$num);
				    echo '<option value="'.$number.'"> '.$number.'</option>';
				}?>
				
			</select>
			<select name="sltFromAP" id="sltFromAP">
				<option value="A">AM</option>
				<option value="P">PM</option>
			</select>
		</div>
		<div id="divTimeBetween"> to </div>
		<div class="floatleft">
			<select id="sltToHr" name="sltToHr"> 
				<?php 
				$time_hour = range(1, 12);
				foreach ($time_hour as $num) {
					
					$number = sprintf('%02d',$num);
					
				    echo '<option value="'.$number.'"> '.$number.'</option>';
				}?>
				
			</select>
			<select id="sltToMts" name="sltToMts"> 
				<?php 
				$time_mts = range(0, 55, 5);
				foreach ($time_mts as $num) {
					$number = sprintf('%02d',$num);
				    echo '<option value="'.$number.'"> '.$number.'</option>';
				}?>
				
			</select>
			<select name="sltToAP" id="sltToAP">
				<option value="A">AM</option>
				<option value="P">PM</option>
			</select>
		</div>
	</div>
	<div class="clearboth paddingtop"></div>
        <div id="chapter_detail_div">
	<div class="label_style">Chapter details<span class="red_star">*</span></div>
	<div class="clearboth"></div>
	<div> <textarea id="txtContent" name="txtContent" style="width:550px;"></textarea></div>
	
	<div class="clearboth paddingtop"></div>
        </div>
        <?php  //enable_tiny_mce("txtContent","advanced",'false'); ?>
        <?php  enable_tiny_mce("txtContent","simple"); ?>
	<div class="pagination"><input type="button" name="btnAdd" value=" Add Event" onclick="javascript:return fncHandleEvent('add');" /></div>
	<div class="clearboth paddingtop"></div>
</div>