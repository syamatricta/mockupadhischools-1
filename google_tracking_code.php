<?php
    ob_start();
    include('index.php');
    ob_end_clean();
    $CI =& get_instance();
    if($CI->session->userdata('USERID') > 0){
        $ga_user_type   = 'Member';
        $ga_user_id     = $CI->session->userdata('USERID');
    }else{
        $ga_user_type   = 'Guest';
        $ga_user_id     = 0;
    }
    echo google_tracking_code();
?>