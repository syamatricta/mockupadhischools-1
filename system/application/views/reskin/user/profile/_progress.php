<link rel="stylesheet" href="<?php echo $this->config->item('style_url');?>profile-progress-bar.css" />
<link href='https://fonts.googleapis.com/css?family=PT+Sans+Caption:400,700' rel='stylesheet' type='text/css'>

<div class="row">
    <div class="col-sm-12">
        <div class="col-sm-8 col-sm-offset-2">
            <div id="message_box" class="alert hidden"></div>
        </div>
        <div class="checkout-wrap" id="profile_progress_bar">
            <ul class="profile-progress-bar">

                <li class="visited status first">
                    <div class="p_ti">Enrolled in<br/>Classes</div>
                    <div class="p_hover">Congrats! You're on your way to a license!</div>
                </li>
                
                <li class="status <?php echo ($user_stat['completed_all_exams']) ? $user_stat['completed_all_exams']['class'] : '' ;?>">
                    <div class="p_ti">Take final<br/>examinations</div>
                    <div class="p_hover">You have to complete the finals on our website to take the state exam</div>
                </li>

                <li id="state_exam_applied" class="status <?php echo ($user_stat['state_exam_applied']) ? $user_stat['state_exam_applied']['class'] : '' ;?>">
                    <div class="p_ti">Apply for state<br/>exam</div>
                    <div class="p_hover">Apply for state exam - click this <a target="_blank" href="https://www.adhischools.com/blog/forms-that-you-need-to-schedule-your-state-exam-salesperson-not-broker/">link</a></div>
                </li>
                
                <li class="status <?php echo ($user_stat['registerd_in_crashcourse']) ? $user_stat['registerd_in_crashcourse']['class'] : '' ;?>">
                    <div class="p_ti">Register for a<br/>crash course</div>
                    <div class="p_hover">You'll want to register for our legendary <a target="_blank" href="https://www.crashcourseonline.com">crashcourseonline.com</a> site before you take the test</div>
                </li>

                <li id="obtained_license" class="status <?php echo ($user_stat['obtained_license']) ? $user_stat['obtained_license']['class'] : '' ;?> last">
                    <div class="p_ti">Obtain license and<br/>sign with a broker</div>
                    <div class="p_hover">Click here if your license has been issued!</div>
                </li>

            </ul>
        </div>
    </div>
</div>
<div class="divide80"></div>
