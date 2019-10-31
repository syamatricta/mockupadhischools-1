<div class="report_head"><?php echo $page_title;?></div>

<div class="report_content">
    <div class="report_left_content">
        <ul class="report_nav">
            <?php 
                $i = 0;
                foreach($courses as $course) { 
                  $id = "course_".$course['id'];  
                  $current = $i == 0 ? "current":""; 
                ?>
            <li class="<?php echo $current;?>" id="<?php echo $id;?>" onclick="showCourse('<?php echo $id;?>', '<?php echo $course['id'];?>');"><?php echo $course['course_name'];?></li>
            <?php 
                $i++;
            } ?>
        </ul>
    </div>
    <div class="report_right_content">
        <?php //echo count($course_count);?>
        <div class="report_detail">
            <div id="total_students">Students: <?php echo count($course_data);?></div>
            <div class="report_underline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div>
            
            
            <div id="detail_students" style="width:250px;">
                <ul class="report_nav_detail">
                    <?php $i=0;foreach($course_data as $data) { ?>
                    <li><a href="<?php echo site_url()."admin_user/user_course_details/".$data['userid']?>" target="_blank"><?php echo $data['firstname']." ".$data['lastname']; ?></a></li>
                    <?php $i++;} ?>
                </ul>
            </div>
            
        </div>
    </div>
</div>

