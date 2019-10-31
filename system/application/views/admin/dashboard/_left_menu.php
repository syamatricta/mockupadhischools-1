<div class="dash_l_box fl">
    <div class="box_head fl gr-bg active_total_cnt">Active Users : <span id="active_total"><?php echo $active_users;?></span></div>
    <div class="box_head mt10 fl gr-bg">Visitors Analysis</div>
    <div class="dash_lin_box fl">
            <a class="view_more" onclick="javascript:viewTab('visitors_analysis');">View More</a>
            <div class="count_row fl">
                    <div class="dash_icon uniq_icon fl"></div>
                    <span class="fl">Unique Users</span>
                    <div class="dash_cnt count_bg fr" id="unique_user_count"><?php echo $unique_users;?></div>
            </div>
            <?php //if($unique_users > 0){?>
            <div class="dotted_hr"></div>
            <div class="subcount_row fl">
                    <span class="fl">Guest Users</span>
                    <div class="dash_cnt fr" id="unique_users_guest_count"><?php echo (isset($unique_user_seperate['guest'])) ? $unique_user_seperate['guest'] : 0;?></div>
            </div>
            <div class="subcount_row fl">
                    <span class="fl">Registered Users</span>
                    <div class="dash_cnt fr" id="unique_users_reg_count"><?php echo (isset($unique_user_seperate['member'])) ?  $unique_user_seperate['member'] : 0;?></div>
            </div>
            <?php //}?>
            <div class="dotted_hr"></div>
            <div class="count_row fl">
                    <div class="dash_icon act_icon fl"></div>
                    <span class="fl">Active Users</span>
                    <div class="dash_cnt count_bg fr" id="active_total_1"><?php echo $active_users;?></div>
            </div>
            <?php //if($active_users > 0){?>
            <div class="subcount_row fl">
                    <span class="fl">Guest Users</span>
                    <div class="dash_cnt fr" id="active_guest"><?php echo $active_user_seperate['guest'];?></div>
            </div>
            <div class="subcount_row fl">
                    <span class="fl">Registered Users</span>
                    <div class="dash_cnt fr" id="active_registered"><?php echo $active_user_seperate['registered'];?></div>
            </div>
            <?php //}?>
    </div>
    <div class="box_head mt20 fl gr-bg">Exam Reports</div>
    <div class="dash_lin_box fl">

            <a class="view_more" onclick="javascript:viewTab('exam_report');">View More</a>

            <div class="count_row fl">
                    <div class="dash_icon pass_icon fl"></div>
                    <span class="fl">Passed</span>
                    <div class="dash_cnt fr"><?php echo $total_passed;?></div>
            </div>
            <div class="subcount_row fl">
                    <span class="fl">Unexpectedly Ended</span>
                    <div class="dash_cnt fr"><?php echo $total_unexpected_passed;?></div>
            </div>
            <div class="dotted_hr"></div>
            <div class="count_row fl">
                    <div class="dash_icon fail_icon fl"></div>
                    <span class="fl">Failed</span>
                    <div class="dash_cnt fr"><?php echo $total_failed;?></div>
            </div>
            <div class="subcount_row fl">
                    <span class="fl">Unexpectedly Ended</span>
                    <div class="dash_cnt fr"><?php echo $total_unexpected_failed ;?></div>
            </div>
            <div class="dotted_hr"></div>
            <div class="count_row fl">
                    <div class="dash_icon ongoing_icon fl"></div>
                    <span class="fl">Ongoing</span>
                    <div class="dash_cnt fr"><?php echo $total_ongoing;?></div>
            </div>
    </div>
    <div class="box_head mt20 fl gr-bg">Browser & Platform Used</div>
    <div class="dash_lin_box fl">
        <div class="view_more"><a onclick="javascript:viewTab('browser_platform');">View More</a></div>
            <?php
                if(isset($browser_data)){
                    foreach($browser_data as $key => $browser_data ){
            ?>
            <div class="count_row fl">
                <div class="dash_icon <?php echo icon_class($browser_data[0]);?>_icon fl"></div>
                    <span class="fl"><?php echo $browser_data[0].' '.$browser_data[1];?></span>
                    <div class="dash_cnt fr"><?php echo $browser_data[2];?></div>
            </div>
            <div class="dotted_hr"></div>
                <?php }} ?>

            <?php
                if(isset($os_data)){
                    foreach($os_data as $key => $os_data ){
            ?>
            <div class="count_row fl os_bg">
                    <div class="dash_icon <?php echo icon_class($os_data[0]);?>_icon fl"></div>
                    <span class="fl"><?php echo $os_data[0].' '.$os_data[1];?></span>
                    <div class="dash_cnt fr"><?php echo $os_data[2];?></div>
            </div>
            <?php if(count($os_data) > $key){?><div class="dotted_hr"></div><?php }?>
                <?php }} ?>
    </div>
    <div class="box_head mt20 fl gr-bg">Recruiter <span class="dash_cnt fr count_bg"> <?php echo $recruiter_mail_count; ?> </span></div>
    <div class="dash_lin_box fl">
        <div class="view_more"><a onclick="javascript:viewTab('recruiter');">View More</a></div>
            <?php /*<div class="count_row fl os_bg">
                    <div class="dash_icon <?php //echo icon_class($os_data[0]);?>_icon fl"></div>
                    <span class="fl"><?php echo $recruiter_mail_count;?></span>
                    <div class="dash_cnt fr"><?php echo $recruiter_mail_count;?></div> 
            </div>
             * 
             */ ?>
    </div>
</div>