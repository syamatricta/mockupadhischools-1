<div class="report_head"><?php echo $page_title;?></div>

<div class="report_content exam_report_content">
    <div class="report_left_content">
        <ul class="report_nav">
            <li class="current" id="report_total" onclick="showReport('report_total','');">Total Students</li>
            <li class="" id="report_passed" onclick="showReport('report_passed','P');">No. of students passed</li>
            <li class="" id="report_failed" onclick="showReport('report_failed','F');">No. of students failed</li>
            <li class="" id="report_ongoing" onclick="showReport('report_ongoing','O');">Ongoing</li>
        </ul>
    </div>
    <div class="report_right_content">
        <?php //echo count($passed_data);$passed_count?>
        <div class="report_detail">
            <div id="total_students">Total Students attended exams: <?php echo count($passed_data);?></div>
            <div class="report_underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div>
            
            
            <div id="detail_students">
                <ul class="report_nav_detail">
                    <?php $i=0;foreach($passed_data as $data) { ?>
                    <li><a href="<?php echo site_url()."admin_user/view_user_exam_details/".$data['user_id'].'/'.$data['course_id'];?>" target="_blank"><?php echo $data['firstname']." ".$data['lastname']; ?></a></li>
                    <?php $i++;} ?>
                </ul>
            </div>
            <!--<div id="track1"><div id="handle1"></div></div>-->
            <div class="chart_title" id="chart_title" style="float: left;display: block;"><?php if(count($passed_data) > 0){ ?>Exam Report<?php } ?></div>
            <div id="piechart1" style="overflow:hidden;width:270px;"></div>
        </div>
    </div>
</div>

