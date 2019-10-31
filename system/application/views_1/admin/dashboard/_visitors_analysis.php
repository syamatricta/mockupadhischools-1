<div class="dash_item_page">
    <div class="dip_head">
        <div class="dip_head_ti b">Total Number of Unique Users: <?php echo $unique_users;?></div>
        <div class="dip_head_sep">
            <div class="dip_head_sep_left"><?php echo 'GUEST USERS : <span class="num_big">'.$unique_user_seperate['guest'].'</span>';?></div>
            <div class="dip_head_sep_right"><?php echo 'REGISTERED USERS : <span class="num_big">'.$unique_user_seperate['member'].'</span>';?></div>
        </div>
    </div>
    <div id="linechart1" style="overflow: hidden;">
        <?php echo ($unique_users == 0) ? '<div class="no_record_found">No Records found</div>' : ''; ?>
    </div>
    
    <div class="dip_head">
        <div class="dip_head_ti">Total Number of Active Users: <span id="active_total_inpage"><?php echo $active_users; ?></span></div>
        <div class="dip_head_sep">
            <div class="dip_head_sep_left"><?php echo 'GUEST USERS : <span class="num_big" id="active_guest_inpage">'.$active_guest.'</span>';?></div>
            <div class="dip_head_sep_right"><?php echo 'REGISTERED USERS : <span class="num_big" id="active_registered_inpage">'.$active_registered.'</span>';?></div>
        </div>
    </div>
    <div id="linechart2" style="overflow: hidden;height:350px;">
        <?php echo ($active_users == 0) ? '<div class="no_record_found">No Records found</div>' : ''; ?>
    </div>
    <div class="average_time_spent_cnt">
        <div class="dip_head_ti b">Average time spent by users - page wise</div>
        <div class="custom_table">
            <div class="ct_head gr-bg">
                <div class="ct_td" style="width:542px;">Page</div>
                <div class="ct_td" style="width:120px;">Avg time (seconds)</div>
            </div>
            <div class="ct_data_rows" id="ats_data"><?php $this->load->view('admin/dashboard/_average_time_spent');?></div>
        </div>
    </div>
</div>