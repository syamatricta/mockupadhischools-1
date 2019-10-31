<link rel="stylesheet" href="<?php echo $this->config->item('style_url');?>profile-progress-bar.css" />
<link href='https://fonts.googleapis.com/css?family=PT+Sans+Caption:400,700' rel='stylesheet' type='text/css'>
<div id="message_box" class="message_box_progress" style="display:none;"></div>
<div class="checkout-wrap" id="profile_progress_bar">
    <ul class="profile-progress-bar">

        <li class="visited first">Enrolled in<br/>Classes</li>

        <li class="<?php echo ($user_stat['completed_all_exams']) ? $user_stat['completed_all_exams']['class'] : '' ;?>">Take final<br/>examinations</li>

        <li id="state_exam_applied" class="<?php echo ($user_stat['state_exam_applied']) ? $user_stat['state_exam_applied']['class'] : '' ;?>">Apply for state<br/>examination</li>

        <li class="<?php echo ($user_stat['registerd_in_crashcourse']) ? $user_stat['registerd_in_crashcourse']['class'] : '' ;?>">Register for a<br/>crashcourse</li>

        <li id="obtained_license" class="<?php echo ($user_stat['obtained_license']) ? $user_stat['obtained_license']['class'] : '' ;?> last">Obtain license and<br/>sign with a broker</li>

    </ul>
</div>
<style>
    ul.profile-progress-bar li:before{
        width:65px;
        height:65px;
        background-size: 40% 40% !important;
        top:-75px;
    }
    ul.profile-progress-bar li:after{
        top:-48px!important;
    }
    .checkout-wrap{margin-left: -30px;}
    ul.profile-progress-bar li{
        font-size: 13px;
        line-height: 14px;
    }
    ul.profile-progress-bar li.active:before{
      width:65px;
      height:65px;
      transition: all .2s ease-in-out;
    }
    ul.profile-progress-bar li.active:hover:before,  ul.profile-progress-bar li.active.hover:before{
      width:65px;
      height:65px;
      top: -75px;
      background-image:url("./../../images/reskin/tick-white.png") !important ;
      left:25%;
    }
    ul.profile-progress-bar li.active.hover, ul.profile-progress-bar li.active:hover{
        color: inherit;
    }
    ul.profile-progress-bar li.active:nth-child(4):hover:before , ul.profile-progress-bar li.active.hover:nth-child(4):before{
        content: "";
        padding:0;
        line-height: inherit;
        font-weight: inherit;
    }
</style>