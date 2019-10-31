<div>
	<div  class="page_error" id="divError">&nbsp;</div>
	<div class="clearboth paddingtop"></div>
	
	<div class="label_style">Region<span class="red_star">*</span></div>
	<div class="label_colon">:</div>
	<div style="float:left;">
		<?php
		if(isset($class_mode)){
			echo '<input type="hidden" id="sltRegion" name="sltRegion" value="'.$arr_event->region_id.'" />';
			echo '<input type="hidden" id="sltSubregion" name="sltSubregion" value="'.$arr_event->subregion_id.'" />';
			if($regions){
					foreach ($regions as $data){
						if(isset($arr_event->region_id) && $arr_event->region_id==$data->id){echo '<label style="float:left;padding:5px 5px 0px 5px;">'.$data->region_name.'&nbsp;</label>';}
						
					}
				}
			
		}else{?>
			<select name="sltRegion" id="sltRegion" onchange="javascript: fncGetSubregion('sltRegion','sltSubregion');">
				<option value="0">Select</option>
				<?php 
				if($regions){
					foreach ($regions as $data){
						echo '<option value="'.$data->id.'" ';if(isset($arr_event->region_id) && $arr_event->region_id==$data->id){echo 'selected';} echo ' >'.$data->region_name.'</option>';
					}
				}
				?>
			</select>
		<?php } ?>
	</div>
	<div class="clearboth paddingtop"></div>
	
	<div class="label_style">Sub-Region<span class="red_star">*</span></div>
	<div class="label_colon">:</div>
	<div style="float:left;">
		<?php
		if(isset($class_mode)){
			if(isset($arr_event->region_id) && isset($raw_subregion)){ 
				foreach ($raw_subregion as $data){
					if($data->regionid == $arr_event->region_id){
						if(isset($arr_event->subregion_id) && $arr_event->subregion_id==$data->id){echo '<label style="float:left;padding:5px 5px 0px 5px;">'.$data->sub_name.'&nbsp;</label>';}
					}
				}
			}
		}else{?>
			<select name="sltSubregion" id="sltSubregion">
				<option value="0">Select</option>
				<?php 
				if(isset($arr_event->region_id) && isset($raw_subregion)){ 
					foreach ($raw_subregion as $data){
						if($data->regionid == $arr_event->region_id){
							echo '<option value="'.$data->id.'" ';if(isset($arr_event->subregion_id) && $arr_event->subregion_id==$data->id){echo 'selected';} echo ' >'.$data->sub_name.'</option>';
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
		<select name="sltCourses" id="sltCourses">
                    <option value="0">Select</option>
                    <?php
                    if($course_list){
                            foreach ($course_list as $data){
                                    echo '<option value="'.$data->id.'" ';if(isset($arr_event->course_id) && $arr_event->course_id==$data->id){echo 'selected';}echo ' >'.$data->course_name.'</option>';
                            }
                    }
                    ?>
		</select>

	</div>
	<div class="clearboth paddingtop"></div>
	
	<div class="label_style">Date<span class="red_star">*</span></div>
	<div class="label_colon">:</div>
	<div>
		<input type="text" name="txtDateStart" id="txtDateStart"  value="<?php if($arr_event->start_date){echo $arr_event->start_date;}?>" size="10" readonly/>
		<img src="<?php  echo $this->config->item('images');?>calendar.gif"  onclick="displayCalendar(document.adminscheduleform.txtDateStart,'mm/dd/yyyy',this)"/>
	</div>
	<div class="clearboth paddingtop"></div>
	
	<div class="label_style">Do you want to repeat?</div>
	<div class="label_colon">:</div>
	<div>
		<div id="divRepeatCheck">
			<input type="checkbox" name="txtRepeat" id="txtRepeat" style="margin:0px;" onclick="javascript: fncCheckRepeatMode();" <?php if($arr_event->repeat_status!=0){echo 'checked';}?> />
		</div>
		<div id="divRepeat" class="floatleft" <?php if($arr_event->repeat_status==0){ echo 'style="display:none;"';}?>>
			<div class="floatleft">
				<select name="sltRepeatType" id="sltRepeatType">
					<option value="1" <?php if($arr_event->repeat_status==1){echo 'selected';}?>>Daily</option>
					<option value="2" <?php if($arr_event->repeat_status==2){echo 'selected';}?>>Weekly</option>
				</select>
			</div>
			<div class="floatleft" style="padding:0px 0px 0px 10px;">
				Repeat till<span class="red_star">*</span>&nbsp;:&nbsp;<input type="text" name="txtDateEnd" id="txtDateEnd"  value="<?php if($arr_event->repeat_ends != '00/00/0000'){echo $arr_event->repeat_ends;}?>"  size="10" readonly/>
				<img src="<?php  echo $this->config->item('images');?>calendar.gif"  onclick="displayCalendar(document.adminscheduleform.txtDateEnd,'mm/dd/yyyy',this)"/>
			</div>
		</div>
	</div>
	<div class="clearboth paddingtop"></div>
	
	<div class="label_style">Time<span class="red_star">*</span></div>
	<div class="label_colon">:</div>
	<div>
		<div class="floatleft">
			<select id="sltFromHr" name="sltFromHr"> 
				<?php 
				$time_hour = range(1, 12);
				foreach ($time_hour as $num) {
					$number = sprintf('%02d',$num);
				    echo '<option value="'.$number.'"'; if($arr_event->start_hr==$number){echo 'selected';} echo '> '.$number.'</option>';
				}?>
				
			</select>
			<select id="sltFromMts" name="sltFromMts"> 
				<?php 
				$time_mts = range(0, 55, 5);
				foreach ($time_mts as $num) {
					$number = sprintf('%02d',$num);
				    echo '<option value="'.$number.'"'; if($arr_event->start_mts==$number){echo 'selected';} echo '> '.$number.'</option>';
				}?>
				
			</select>
			<select name="sltFromAP" id="sltFromAP">
				<option value="A" <?php if($arr_event->meridiean_start=='AM'){echo 'selected';}?>>AM</option>
				<option value="P" <?php if($arr_event->meridiean_start=='PM'){echo 'selected';}?>>PM</option>
			</select>
		</div>
		<div id="divTimeBetween"> to </div>
		<div class="floatleft">
			<select id="sltToHr" name="sltToHr"> 
				<?php 
				$time_hour = range(1, 12);
				foreach ($time_hour as $num) {
					
					$number = sprintf('%02d',$num);
					
				    echo '<option value="'.$number.'"'; if($arr_event->end_hr==$number){echo 'selected';} echo '> '.$number.'</option>';
				}?>
				
			</select>
			<select id="sltToMts" name="sltToMts"> 
				<?php 
				$time_mts = range(0, 55, 5);
				foreach ($time_mts as $num) {
					$number = sprintf('%02d',$num);
				    echo '<option value="'.$number.'"'; if($arr_event->end_mts==$number){echo 'selected';} echo '> '.$number.'</option>';
				}?>
				
			</select>
			<select name="sltToAP" id="sltToAP">
				<option value="A" <?php if($arr_event->meridiean_end=='AM'){echo 'selected';}?>>AM</option>
				<option value="P" <?php if($arr_event->meridiean_end=='PM'){echo 'selected';}?>>PM</option>
			</select>
		</div>
	</div>
	<div class="clearboth paddingtop"></div>
	
	<div class="label_style">Chapter details<span class="red_star">*</span></div>
	<div class="clearboth"></div>
	<div> <textarea id="txtContent" name="txtContent" style="width:550px;"><?php echo $arr_event->descp;?> </textarea></div>
	
	<div class="clearboth paddingtop"></div>
	<div class="pagination"><input type="button" name="btnEdit" value=" Update Event" onclick="javascript:return fncHandleEvent('edit');" /></div>
	<div class="clearboth paddingtop"></div>
</div>