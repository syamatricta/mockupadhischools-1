
<form name="addattendanceform" id="addattendanceform" method="post" action="" enctype="multipart/form-data">
<div class="adminmainlist">
	<div class="adminpagebanner">
		<div class="adminpagetitle">Add Attendance</div>
	</div> 
        <?php /*end of  adminpagebanner */?>
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		<div class="page_error" id="errordisplay"></div>
                <div  class="page_error" id="errordiv" ><?php if(isset($msg)) echo $msg; ?></div>
                <div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("msg");   ?></div>
                <?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
                <div class="clearboth"></div>
                
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
                                                echo '<option value="'.$data->id.'" ';if(isset($region_search) && $region_search==$data->id){echo 'selected';} echo ' >'.$data->region_name.'</option>';
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
                                                        echo '<option value="'.$data->id.'" ';if(isset($subregion_search) && $subregion_search==$data->id){echo 'selected';} echo ' >'.$data->sub_name.'</option>';
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
                                                echo '<option value="'.$data->id.'" ';echo ' >'.$data->course_name.'</option>';
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
                                                echo '<option value="'.$instructor->id.'" ';echo ' >'.$instructor->name.'</option>';
                                        }
                                }
                                ?>
                        </select>

                    </div>
                    <div class="clearboth paddingtop"></div>
                    
                    <div class="label_style">Date<span class="red_star">*</span></div>
                    <div class="label_colon">:</div>
                    <div>
                            <input type="text" name="txtDateStart" id="txtDateStart"  value="<?php if($selected_date){echo date('m/d/Y',strtotime($selected_date));}else echo set_value('txtDateStart');?>" size="10" readonly/>
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
                    
                    <div class="label_style">Attendance<span class="red_star">*</span></div>
                    <div> <input type="text" id="txtAttendance" name="txtAttendance" value="<?php $this->input->post("txtAttendance"); ?>"/></div>

                    <div class="clearboth paddingtop"></div>
                    
                    <div class="label_style">Guests<span class="red_star">*</span></div>
                    <div> <input type="text" id="titled_guests" name="titled_guests" value="<?php $this->input->post("titled_guests"); ?>"/></div>

                    <div class="clearboth paddingtop"></div>
                    
                    <div class="label_style">Sign Report</div>
                    <div> <input type="file" name="report" id="report" value="<?php $this->input->post("report"); ?>"/></div>
                    <span style="color:red;"> Upload image file only </span>
                    <div class="clearboth paddingtop"></div>
                    
                    <div id="chapter_detail_div">
                    <div class="label_style">Notes</div>
                    <div class="clearboth"></div>
                    <div> <textarea id="txtContent" name="txtContent" style="width:550px;"></textarea></div>

                    <div class="clearboth paddingtop"></div>
                    </div>
                    <?php  //enable_tiny_mce("txtContent","advanced",'false'); ?>
                    <?php  enable_tiny_mce("txtContent","simple"); ?>
                    <input type="hidden" value="add" id="txtWhat2Do" name="txtWhat2Do" />
                    <div class="pagination"><input type="button" name="btnAdd" value="Submit" onclick="javascript:return fncHandleEvent('add');" /></div>
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



