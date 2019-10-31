<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<div class="dash_outer fl">
	<?php $this->load->view('admin/dashboard/_left_menu');?>
	<div class="dash_r_box fl">
            <div class="searchbox fl">
                <form name="frmadhischool" id="frmadhischool" method="post">
                    From <input type="text" name="date_from" id="date_from" class="searchtxtbox" value="<?php echo formatDate($start_date);?>" onclick="displayCalendar(document.frmadhischool.date_from,'mm/dd/yyyy',this)">
                    &nbsp;&nbsp;To <input type="text" name="date_to" id="date_to" class="searchtxtbox" value="<?php echo formatDate($end_date);?>" onclick="displayCalendar(document.frmadhischool.date_to,'mm/dd/yyyy',this)">
                    <input type="hidden" id="selected_section" name="selected_section" value="">
                    <input type="button" class="searchbtn" value="Search" onclick="dashboardDataWithDateRange()">
                    <div id="date_errordisplay"></div>
                </form> 
            </div>
            <div class="mt20 fl boxr_head_cnt">
                <div id="visitors_analysis_tab" class="boxr_head fl gr-bg" style="width:110px;margin-left:0px;">Visitors Analysis</div>
                <div id="exam_report_tab" class="boxr_head fl gr-bg" style="width:101px;">Exam Reports</div>
                <div id="browser_platform_tab" class="boxr_head fl gr-bg" style="width:180px;">Browser & Platform Used</div>
                <div id="user_report_tab" class="boxr_head fl gr-bg" style="width:90px;">User Reports</div>                
                <div id="course_tab" class="boxr_head fl gr-bg" style="width:60px;">Course</div>
                <div id="recruiter_tab" class="boxr_head fl gr-bg" style="width:60px;">Recruiter</div>
            </div>
            <div class="fl dash_rpt" id="dashboard_item_page"></div>
	</div>
</div>
<?php
   /* if(isset($google_auth_url) && $google_auth_url){
?>
<script>
    addOverlayDiv($$('.dash_outer')[0], 'dash_r_box_2');
    $('dash_r_box_2').insert('<a style="margin:0 auto;margin-top:50px;" href="<?php echo $google_auth_url;?>">Authrize request</a>');
</script>    
<?php
    }else{*/
?>
<script>
    var selected_dashboard_item = '<?php echo $selected_dashboard_item;?>';
    var start_date              = '<?php echo $start_date;?>';
    var end_date                = '<?php echo $end_date;?>';    
    window.onload   = function (){
        viewTab(selected_dashboard_item);
        initActiveUserCount();
    }
    
    Event.observe($('user_report_tab'), 'click', function (){viewTab('user_report');});
    Event.observe($('visitors_analysis_tab'), 'click', function (){viewTab('visitors_analysis');});
    Event.observe($('course_tab'), 'click', function (){viewTab('course');});
    Event.observe($('exam_report_tab'), 'click', function (){viewTab('exam_report');});
    Event.observe($('browser_platform_tab'), 'click', function (){viewTab('browser_platform');});
    Event.observe($('recruiter_tab'), 'click', function (){viewTab('recruiter');});
    
    
</script>
<?php
   // }
?>
<style>
    .boxr_head{
        padding :8px 8px;
    }
</style>
    
