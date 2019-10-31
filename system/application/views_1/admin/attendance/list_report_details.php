<?php echo form_open('attendance_report/list_report_details', array('name' => 'adminreportlistform', 'id' => 'adminreportlistform')); ?>
<div class="adminmainlist">
    <?php /* list headings starts here */ ?>
    <div class="adminpagebanner">
        <div class="adminpagetitle"><?php echo $page_title ?></div>
        <div class="fr" style="margin: 10px;">
            <a style="text-decoration:none;" href="<?php echo base_url(); ?>attendance_report/add_attendance" title="Add Attendance" class="btn btn-inverse  btn-small">
                + &nbsp;Add
            </a>    
        </div>
    </div>
    <div class="clearboth"> </div>
    <div class="page_error" id="errordisplay"></div>
    <div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error"); ?></div>
    <div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("msg");   ?></div>
    
    <div class="nodata" style="width:100%;">
        <div class="listdata">
            <div class="floatleft" style="width:6%;"><strong>Region</strong></div>
            <div class="fl">
                <select name="search_region" id="search_region" onchange="javascript: fncGetSubregion('search_region','search_sub_region');">
                        <option value="0">Select</option>
                        <?php 
                        if($regions){
                                foreach ($regions as $data){
                                        echo '<option value="'.$data->id.'" ';if(isset($search_region) && $search_region==$data->id){echo 'selected';} echo ' >'.$data->region_name.'</option>';
                                }
                        }
                        ?>
                </select>
            </div>
            <div class="floatleft" style="width:9%;margin-left:2%;"><strong>Sub Region</strong></div>
            <div class="fl">
                <select name="search_sub_region" id="search_sub_region" style="width:100px;">
                        <option value="0">Select</option>
                        <?php 
                        if(isset($search_region) && isset($raw_subregion)){ 
                                foreach ($raw_subregion as $data){
                                        if($data->regionid == $search_region){
                                                echo '<option value="'.$data->id.'" ';if(isset($search_sub_region) && $search_sub_region==$data->id){echo 'selected';} echo ' >'.$data->sub_name.'</option>';
                                        }
                                }
                        }
                        ?>
                </select>
            </div>
            <div class="floatleft" style="width:4%;margin-left:2%;margin-right:2%;"><strong>Course</strong></div>
            <div class="fl" style="margin-right:1%;">
                <select name="search_course" id="search_course">
                        <option value="0">Select</option>
                        <?php
                        if($course_list){
                                foreach ($course_list as $data){
                                        echo '<option value="'.$data->id.'" ';if(isset($search_course) && $search_course==$data->id){echo 'selected';} echo ' >'.$data->course_name.'</option>';
                                }
                        }
                        ?>
                </select>
            </div>
            
            <div class="floatleft" style="width:6%;margin-right:2%;"><strong>Instructor</strong></div>
            <div class="fl" style="margin-right:1%;">
                <select name="search_instructor" id="search_instructor">
                        <option value="0">Select</option>
                        <?php
                        if($instructor_list){
                                foreach ($instructor_list as $instructor){
                                        echo '<option value="'.$instructor->id.'" ';if(isset($search_instructor) && $search_instructor==$instructor->id){echo 'selected';} echo ' >'.$instructor->name.'</option>';
                                }
                        }
                        ?>
                </select>
            </div>
            <div class="clearboth"> &nbsp;</div>
            
            <div class="floatleft" style="width:7%;margin-top:5px;"><strong>Date From</strong></div>
            <div class="filter">
                <input type="text" maxlength="50"  name="search_date_from" id="search_date_from" readonly value="<?php
                    if ('' != $this->input->post('search_date_from')) {
                        echo formatDate($this->input->post('search_date_from'));
                    }
                    ?>"/>
                <img  src="<?php echo $this->config->item('images'); ?>calendar.gif" alt="calendar" title="calendar" onclick="displayCalendar(document.adminreportlistform.search_date_from,'mm/dd/yyyy',this)"/>
            </div>
            <div class="floatleft" style="width:6%;margin-top:5px;"><strong>Date To</strong></div>
            <div class="filter">
                <input type="text" maxlength="50"  name="search_date_to" id="search_date_to" readonly  value="<?php 
                        if ('' != $this->input->post('search_date_to')) {
                           echo formatDate($this->input->post('search_date_to'));
                       } else {
                           echo formatDate(convert_UTC_to_PST_date(date('Y-m-d H:i:s')));
                       } ?>"/>
                <img  src="<?php echo $this->config->item('images'); ?>calendar.gif" alt="calendar" title="calendar"  onclick="displayCalendar(document.adminreportlistform.search_date_to,'mm/dd/yyyy',this)"/>
            </div>
            
            <div class="floatleft">
                <a href="javascript:void(0);" onclick="javascript:fncAttendanceFilter(document.adminreportlistform.search_date_from.value,document.adminreportlistform.search_date_to.value,document.adminreportlistform.search_region.value,document.adminreportlistform.search_sub_region.value,document.adminreportlistform.search_course.value,document.adminreportlistform.search_instructor.value); return false;">
                    <img src="<?php echo base_url(); ?>images/indexsearch.jpg" border="0" alt="filter" title="filter" />
                </a>
            </div>
            <div class="clearboth"> &nbsp;</div>
            
        </div>
    </div>
<?php if (count($reports) > 0) { ?>

        <div class="fr" style="margin: 10px;">
            <a href="javascript:void(0)" title="Excel Export" class="btn btn-inverse  btn-small" id="excelclicknew" onClick ="javascript:fncAttendanceExport(document.adminreportlistform.search_date_from.value,document.adminreportlistform.search_date_to.value,document.adminreportlistform.search_region.value,document.adminreportlistform.search_sub_region.value,document.adminreportlistform.search_course.value,document.adminreportlistform.search_instructor.value);//exportTableToCSV([$('#tabledata>table'), $('.adminpagetitle').html()+'.csv']);">
                Export
            </a>    
        </div>
        <div class="clearboth"> </div>

        <div class="admininnercontentdiv" id="tabledata">
            <form name="workattendanceform" id="workattendanceform" method="POST" action="<?php echo base_url(); ?>">
                <div class="listdata">
                <div class="admintopheads">
                    <div class="adminlistheadings" style="width:5%; text-align:center;">Sl. No</div>
                    <div class="adminlistheadings" style="width:10%;">Region</div>
                    <div class="adminlistheadings" style="width:13%;">Sub Region</div>
                    <div class="adminlistheadings" style="width:17%;">Course</div>
                    <div class="adminlistheadings" style="width:18%;">Instructor</div>
                    <div class="adminlistheadings" style="width:13%;text-align:center;">Date &nbsp;&nbsp;&nbsp;&nbsp;</div>
                    <div class="adminlistheadings" style="width:12%;text-align:center;">Time &nbsp;&nbsp;&nbsp;&nbsp;</div>
                    <div class="adminlistheadings" style="width:12%;text-align:center;">Actions &nbsp;&nbsp;&nbsp;&nbsp;</div>
                </div>
            </div>
                <div class="clearboth"> </div>
                <?php
                /* list headings ends here */
                $count = 1;
                if ($this->uri->segment(7)) {
                    $count = $count + $this->uri->segment(7);
                }
                foreach ($reports as $data) {
                    $bg_color = ($count % 2 == 0) ? 'div_row_first' : 'div_row_second';
                    /* data list starts here */
                    ?>
                    <div class="<?php print($bg_color); ?>" id="rowVal_<?php echo $data->adhi_attendance_report_id; ?>">
                        <div class="floatleft" style="width:5%;  text-align:center;"><?php print $count; ?></div>
                        <div class="floatleft" style="width:10%;overflow: hidden;" title="<?php echo $data->region_name ?>"><?php echo $data->region_name; ?></div>
                        <div class="floatleft" style="width:13%;overflow: hidden;" title="<?php echo $data->subregion_name; ?>"><?php echo $data->subregion_name; ?></div>
                        <div class="floatleft" style="width:17%;overflow: hidden;" title="<?php echo $data->course_name; ?>"><?php echo $data->course_name; ?></div>
                        <div class="floatleft" style="width:18%;overflow: hidden;" title="<?php echo $data->instructor_name; ?>"><?php echo $data->instructor_name; ?></div>
                        <div class="floatleft" style="width:13%;overflow: hidden;text-align:center;" title="<?php echo date('l',strtotime($data->date)); ?>"><?php echo formatDate($data->date); ?></div>
                        <div class="floatleft" style="width:12%;overflow: hidden;text-align:center;" title="<?php echo $data->time_from." - ".$data->time_to; ?>"><?php echo $data->time_from." - ".$data->time_to; ?></div>
                        <div class="floatleft" style="width:12%;overflow: hidden;text-align:center;">
                            <a href="<?php echo base_url(); ?>attendance_report/view_attendance/<?php echo (isset($page_no) && is_numeric($page_no)) ? $page_no : 0; ?>/<?php echo $data->adhi_attendance_report_id;?>" alt="View" title="View">
                                <img src="<?php echo base_url(); ?>images/icon_img2.png" alt="View" title="View" height="18" style="margin-bottom:5px;margin-right: 3px;"/>
                            </a>
                            <a href="<?php echo base_url(); ?>attendance_report/edit_attendance/<?php echo (isset($page_no) && is_numeric($page_no)) ? $page_no : 0; ?>/<?php echo $data->adhi_attendance_report_id;?>" alt="Edit" title="Edit">
                                <img src="<?php echo base_url(); ?>images/note.png" alt="Edit" title="Edit" height="20" style="margin-bottom:5px;filter:brightness(20%);"/>
                            </a>
                            <a href="javascript:void(0);" alt="Delete" title="Delete"  onclick="javascript:return fncDeleteAttendance('<?php echo $data->adhi_attendance_report_id;?>');">
                                <img src="<?php echo base_url(); ?>images/wrong_answer.png" alt="Delete" title="Delete" width="19" style="margin-bottom:7px;"/>
                            </a>
                        </div>
                    </div>
                    <div class="clearboth"> </div>
                    <?php
                    $count++;
                }
                /* data list ends here */
                ?>

                <input type="hidden" id="hidid" value="" name="hidid"/>
                <input type="hidden" value="delete" id="txtWhat2Do" name="txtWhat2Do" />
            </form>
        </div>
        <div class="pagination"><?php echo $paginate; ?></div>
        <div style="clear:both">&nbsp;</div>
<?php } else { ?>
        <div class="nodata">No data in this date</div>
<?php } ?>
</div>

<script type="text/javascript" language="javascript">
	<?php echo fncEncodeJavascript("var content = ".$json_array.";"); ?>
</script>