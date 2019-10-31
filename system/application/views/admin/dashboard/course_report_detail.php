<ul  class="report_nav_detail">
    <?php foreach($result_details as $data) { ?>
    <li><a href="<?php echo site_url()."admin_user/user_course_details/".$data['userid']?>" target="_blank"><?php echo $data['firstname']." ".$data['lastname']; ?></a></li>
    <?php } ?>
</ul>