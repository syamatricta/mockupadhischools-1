<ul  class="report_nav_detail">
    <?php foreach($result_details as $data) { ?>
    <li><a href="<?php echo site_url()."admin_user/view_user_exam_details/".$data['user_id'].'/'.$data['course_id']?>" target="_blank"><?php echo $data['firstname']." ".$data['lastname']; ?></a></li>
    <?php } ?>
</ul>
