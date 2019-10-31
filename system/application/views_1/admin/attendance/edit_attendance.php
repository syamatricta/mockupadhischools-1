<form name="addattendanceform" id="addattendanceform" method="post" action="" enctype="multipart/form-data">
<div class="adminmainlist">
	<div class="adminpagebanner">
		<div class="adminpagetitle">Edit Attendance</div>
	</div> 
        <?php /*end of  adminpagebanner */?>
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		
                <?php if (validation_errors ()) {
                    echo '<div class="page_error">'.validation_errors ().'</div>'; $msg = ''; ?>
                    <div class="clearboth"></div>
                <?php } ?>
                    
                <div class="page_error" id="errordisplay"></div>
                <div  class="page_success" id="flashsuccess"><?php if(isset($msg)) echo $msg; ?></div>
                <div class="clearboth"></div>
                
                <?php 
                    $region_search = $attendance_details->region;
                    $sub_region_search = $attendance_details->sub_region;
                ?>
                
                <div style="width:100%;">
                    <div  class="page_error" id="divError">&nbsp;</div>
                    <div class="clearboth paddingtop"></div>
                    <div class="label_style">Region<span class="red_star">*</span></div>
                    <div class="label_colon">:</div>
                    <div style="float:left;">
                        <select name="sltRegion" id="sltRegion" onchange="javascript: fncGetSubregion('sltRegion','sltSubregion');">
                                <option value="0">Select</option>
                                <?php 
                                if($regions){
                                        foreach ($regions as $data){
                                                echo '<option value="'.$data->id.'" ';if(isset($attendance_details->region) && $attendance_details->region==$data->id){echo 'selected';} echo ' >'.$data->region_name.'</option>';
                                        }
                                }
                                ?>
                        </select>
                    </div>
                    <div class="clearboth paddingtop"></div>

                    <div class="label_style">Sub-Region<span class="red_star">*</span></div>
                    <div class="label_colon">:</div>
                    <div class="floatleft">
                        <select name="sltSubregion" id="sltSubregion">
                                <option value="0">Select</option>
                                <?php 
                                if(isset($region_search) && isset($raw_subregion)){ 
                                        foreach ($raw_subregion as $data){
                                                if($data->regionid == $region_search){
                                                        echo '<option value="'.$data->id.'" ';if(isset($attendance_details->sub_region) && $attendance_details->sub_region==$data->id){echo 'selected';} echo ' >'.$data->sub_name.'</option>';
                                                }
                                        }
                                }
                                ?>
                        </select>
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
                                                echo '<option value="'.$data->id.'" ';if(isset($attendance_details->course) && $attendance_details->course==$data->id){echo 'selected';} echo ' >'.$data->course_name.'</option>';
                                        }
                                }
                                ?>
                        </select>
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
                                                echo '<option value="'.$instructor->id.'" ';if(isset($attendance_details->instructor) && $attendance_details->instructor ==$instructor->id){echo 'selected';} echo ' >'.$instructor->name.'</option>';
                                        }
                                }
                                ?>
                        </select>

                    </div>
                    <div class="clearboth paddingtop"></div>
                    
                    <div class="label_style">Date<span class="red_star">*</span></div>
                    <div class="label_colon">:</div>
                    <div>
                            <input type="text" name="txtDateStart" id="txtDateStart"  value="<?php if($attendance_details->date){echo date('m/d/Y',strtotime($attendance_details->date));}else echo set_value('txtDateStart');?>" size="10" readonly/>
                            <img src="<?php  echo $this->config->item('images');?>calendar.gif"  onclick="displayCalendar(document.addattendanceform.txtDateStart,'mm/dd/yyyy',this)"/>
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
                                                echo '<option value="'.$number.'" ';if(isset($sltHr1) && $sltHr1 == $number){echo 'selected';} echo '> '.$number.'</option>';
                                            }?>

                                    </select>
                                    <select id="sltFromMts" name="sltFromMts"> 
                                            <?php 
                                            $time_mts = range(0, 55, 5);
                                            foreach ($time_mts as $num) {
                                                    $number = sprintf('%02d',$num);
                                                echo '<option value="'.$number.'" ';if(isset($sltMin1) && $sltMin1 ==$number){echo 'selected';} echo '> '.$number.'</option>';
                                            }?>

                                    </select>
                                    <select name="sltFromAP" id="sltFromAP">
                                            <option value="AM" <?php if(isset($sltMer1) && $sltMer1 == "AM"){echo 'selected';} ?>>AM</option>
                                            <option value="PM" <?php if(isset($sltMer1) && $sltMer1 == "PM"){echo 'selected';} ?>>PM</option>
                                    </select>
                            </div>
                            <div id="divTimeBetween"> to </div>
                            <div class="floatleft">
                                    <select id="sltToHr" name="sltToHr"> 
                                            <?php 
                                            $time_hour = range(1, 12);
                                            foreach ($time_hour as $num) {

                                                    $number = sprintf('%02d',$num);

                                                echo '<option value="'.$number.'" ';if(isset($sltHr2) && $sltHr2 ==$number){echo 'selected';} echo '> '.$number.'</option>';
                                            }?>

                                    </select>
                                    <select id="sltToMts" name="sltToMts"> 
                                            <?php 
                                            $time_mts = range(0, 55, 5);
                                            foreach ($time_mts as $num) {
                                                    $number = sprintf('%02d',$num);
                                                echo '<option value="'.$number.'" ';if(isset($sltMin2) && $sltMin2 ==$number){echo 'selected';} echo '> '.$number.'</option>';
                                            }?>

                                    </select>
                                    <select name="sltToAP" id="sltToAP">
                                            <option value="AM" <?php if(isset($sltMer2) && $sltMer2 == "AM"){echo 'selected';} ?>>AM</option>
                                            <option value="PM" <?php if(isset($sltMer2) && $sltMer2 == "PM"){echo 'selected';} ?>>PM</option>
                                    </select>
                            </div>
                    </div>
                    <div class="clearboth paddingtop"></div>
                    
                    <div class="label_style">Attendance<span class="red_star">*</span></div>
                    <div> <input type="text" id="txtAttendance" name="txtAttendance" value="<?php echo ("" != $this->input->post("txtAttendance")) ? $this->input->post("txtAttendance") : $attendance_details->attendance; ?>"/></div>

                    <div class="clearboth paddingtop"></div>
                    
                    <div class="label_style">Guests<span class="red_star">*</span></div>
                    <div> <input type="text" id="titled_guests" name="titled_guests" value="<?php echo ("" != $this->input->post("titled_guests")) ? $this->input->post("titled_guests") : $attendance_details->titled_guests; ?>"/></div>

                    <div class="clearboth paddingtop"></div>
                    
                    <div class="label_style">Sign Report</div>
                    <div> 
                        <input type="file" name="report" id="report" value="<?php echo ("" != $this->input->post("report")) ? $this->input->post("report") : $attendance_details->report; ?>" onChange="fileChanged();"/>
                        <a href="javascript:void(0);" onClick="removeFile();" id="removeFile">Remove</a>
                        </div>
                    <span style="color:red;"> Upload image file only </span>
                    <input type="hidden" id="fileRemoved" name="fileRemoved" value="0" />
                    
                    <?php if("" != $attendance_details->report){ ?>
                        <div id="imageDiv" style="text-align:center;"><img width="100" src="<?php echo base_url().'/image_uploads/attendance/'.$attendance_details->report; ?>"/></div>
                    <?php } ?>
                    <div class="clearboth paddingtop"></div>
                    
                    <div id="chapter_detail_div">
                    <div class="label_style">Notes</div>
                    <div class="clearboth"></div>
                    <div> <textarea id="txtContent" name="txtContent" style="width:550px;"><?php echo ("" != $this->input->post("txtContent")) ? $this->input->post("txtContent") : $attendance_details->notes; ?></textarea></div>

                    <div class="clearboth paddingtop"></div>
                    </div>
                    <?php  //enable_tiny_mce("txtContent","advanced",'false'); ?>
                    <?php  enable_tiny_mce("txtContent","simple"); ?>
                    <input type="hidden" value="edit" id="txtWhat2Do" name="txtWhat2Do" />
                    <input type="hidden" value="<?php echo $attendance_details->adhi_attendance_report_id; ?>" id="hidid" name="hidid" />
                    <div class="pagination"><input type="button" name="btnAdd" value="Update" onclick="javascript:return fncHandleEvent('edit');" /></div>
                    <div class="clearboth paddingtop"></div>
                    
                     <div class="backtolist"><?php echo anchor('attendance_report/list_report_details/'.$page_no,'<< Back to attendance list')?></div>
            </div>
                <div class="register_instructionmark" style="padding-right:10px; margin-right: 142px;"><span class="instruction">Marked with </span><span class="red_star">*</span> <span class="instruction">are mandatory fields</span></div>
        <div class="clearboth">&nbsp;</div>
			
    </div> <?php /* end of adminmainlist */ ?>
</div>
</form>

<script type="text/javascript" language="javascript">
	<?php echo fncEncodeJavascript("var content = ".$json_array.";"); ?>
</script>



