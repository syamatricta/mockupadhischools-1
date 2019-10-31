<?php
$i  = 1; 
if($courselist){
    $renew_course_count = 0;
    foreach ($courselist as $course){ 	
	$ended_exam                 = 0;					
	$actual_time_exceeded       = false;
	if($course['tracking_id'] > 0){
            $ended_exam	= $course['exam_ended'];
            $cur_time	= convert_UTC_to_PST_datetime(date('m/d/Y H:i:s'));		
            //extra 30min; user will get exta 30 for updating while offline
            $actual_time_exceeded   = (strtotime($cur_time) > strtotime($course['will_end_at'].'+30 minutes')) ? true : false;
	}else{
            $actual_time_exceeded   = true;
	}
	$view_score	= false;
	if(0 != $ended_exam || $actual_time_exceeded){
            $view_score	= true;
	}
?>
        <div class="row margin20">
            <div class="col-sm-12">
                <div class="heading_band">
                    <?php if( $course['parent_course_name']) echo $course['parent_course_name'] ."(".$course['course_name'].")"; else echo $course['course_name'];  ?>
                    <?php
                        if( isset($course['disable_status']) && $course['disable_status'] == 'reniew' && $course['reinstate_status'] != 1){
                            $renew_course_count++;
                    ?>
                            <div class="checkbox checkbox-danger pull-right" data-toggle="tooltip" data-title="Select course for Renewal">
                                <input type="checkbox" name="courses[]" id="course-<?php echo $course['id'];?>" value="<?php echo $course['id'];?>"/>
                                <label for="course-<?php echo $course['id'];?>" ></label>
                            </div>
                    <?php }?>
                </div>
            </div>
        </div>
        
        <?php
        $disabled_msg   = '';
        if($course['disable_status'] == 'disable' && $course['exam_status'] !='E'){
            $disabled_msg   = 'Admin has disabled this exam for maintenance purpose';
        } else if($course['exam_count'] <9){
            $disabled_msg   = 'Admin has not uploaded questions into this course';
        }
        if(!empty($disabled_msg)){
            echo '<div class="row margin10"><div class="col-sm-12"><div class="alert alert-danger text-center">'.$disabled_msg.'</div></div></div>';
        }
        ?>
        
        <div class="row margin20">
            <div class="col-sm-8">
                <?php /*<div class="row margin10">
                    <div class="col-xs-6 text-right nolpadxs">Course Code :</div>
                    <div class="col-xs-6 norpadxs"><?php echo $course['course_code'];  ?></div>
                </div> */ ?>
                <div class="row margin10">
                    <div class="col-xs-6 text-right nolpadxs">Course Registration :</div>
                    <div class="col-xs-6 norpadxs"><?php echo formatDate($course['enrolled_date']);  ?></div>
                </div>
                <?php if(FALSE === array_search(s('USERID'), c('course_except_exam_users'))) { ?>
                <div class="row margin10">
                    <div class="col-xs-6 text-right nolpadxs">Last attempted on :</div>
                    <div class="col-xs-6 norpadxs"><?php if('0000-00-00' == $course['last_attemptdate']) { echo "Not Attended"; } else { echo formatDate($course['last_attemptdate']);} ?></div>
                </div>
                <?php }?>
                <?php if($course['effective_date'] !='0000-00-00' && FALSE === array_search(s('USERID'), c('course_except_exam_users'))) { ?>
                <div class="row margin10">
                    <div class="col-xs-6 text-right nolpadxs">Date Final Exam Available :</div>
                    <div class="col-xs-6 norpadxs"><?php echo formatDate($course['effective_date']);  ?></div>
                </div>
                <?php }else if($course['delivered_date'] =='0000-00-00'){ ?>
                <div class="row margin10">
                    <div class="col-xs-12 "><h5>Track Information</h5></div>
                </div>
                <div class="row margin10">
                    <div class="col-xs-6 text-right nolpadxs">Track Location :</div>
                    <div class="col-xs-6 norpadxs"><?php if(isset($course['tracklocation'])){echo $course['tracklocation']; }else{ echo '';} ?></div>
                </div>
                <div class="row margin10">
                    <div class="col-xs-6 text-right nolpadxs">Track Date :</div>
                    <div class="col-xs-6 norpadxs"><?php if(isset($course['lasttrackdate']) && '0000-00-00 00:00:00' != $course['lasttrackdate']) { echo formatDate($course['lasttrackdate']); }else{ echo '';} ?></div>
                </div>
                <?php } ?>
                
            </div>
            <div class="col-sm-4">
                <?php
                    $renroll_alert = 0;
                    
                    if(find_date_diff($this->config->item("cut_off_date"),$course['enrolled_date']) > 0){
                        $reenroll_status = 0;
                    }else{
                        $reenroll_status     = $course_reenroll_status[$course['id']];
                    }
                    
                    if(FALSE === array_search($this->session->userdata ('USERID'), c('regulator_test_accounts')) && 1 == $reenroll_status){
                        //echo '<div class="alert alert-warning">Please call office at 888 7685285 to reregister for course</div>';
                        $renroll_alert = 1;
                        
                        echo '<a rel="nofollow" data-course-id="'.$course['id'].'"
                                class="btn-adhi margin10 reenroll-btn">Re-Enroll</a><br/>';
                        //echo '<div class="alert alert-warning">You should re-enroll the course since you failed to pass the exam 2 times.</div>';
                    }
                    if(!$course['disable_status'] && $course['effective_date']!='0000-00-00'
                        && $course['exam_status'] =='E' &&  $course['exam_count'] >=9
                        && FALSE === array_search(s('USERID'), c('course_except_exam_users'))){
                       if(0 == $reenroll_status || FALSE !== array_search($this->session->userdata ('USERID'), c('regulator_test_accounts'))){
                            echo '<a rel="nofollow" data-check="yes" href="'.base_url().'course/confirm_go/'.$course['regid'].'/'.$course['id'].'" class="btn-adhi margin10">Take Final Exam</a><br/>';
                        }else if(1 == $reenroll_status && !$renroll_alert){
                            echo '<a rel="nofollow" data-course-id="'.$course['id'].'"
                                class="btn-adhi margin10 reenroll-btn">Re-Enroll</a><br/>';
                        }else if(2 == $reenroll_status){
                            echo 'Re-enrolled<br/>';
                        }
                        
                    } else {
                        if($course['disable_status'] == 'reniew'){ 
                            if($course['reinstate_status'] == 1  && FALSE === array_search(s('USERID'), c('course_except_exam_users'))){

                                if(find_date_diff($this->config->item("cut_off_date"),$course['enrolled_date']) > 0){
                                    $reenroll_status = 0;
                                }else{
                                    $reenroll_status     = $course_reenroll_status[$course['id']];
                                }
                                if(0 == $reenroll_status && strtotime($course['effective_date']) <= strtotime(convert_UTC_to_PST_date(date('Y-m-d H:i:s')))){
                                    echo '<a rel="nofollow" data-check="no" href="'.base_url().'course/confirm_go/'.$course['regid'].'/'.$course['id'].'" class="btn-adhi margin10">Take Final Exam</a><br/>';
                                }else if(1 == $reenroll_status && !$renroll_alert){
                                    echo '<a rel="nofollow" data-course-id="'.$course['id'].'"
                                            class="btn-adhi margin10 reenroll-btn">Re-Enroll</a><br/>';
                                }else if(2 == $reenroll_status){
                                    echo 'Re-enrolled<br/>';
                                }
                                
                                /*echo '<a rel="nofollow" href="'.base_url().'course/confirm_go/'.$course['regid'].'/'.$course['id'].'" class="btn-adhi margin10">Take Final Exam</a><br/>';*/
                            }else{
                                //echo '<a rel="nofollow" href="'.base_url().'user/renewal/'.$course['regid'].'" class="btn-adhi margin10">Renew</a><br/>';
                                echo '<a rel="nofollow" data-course-id="'.$course['id'].'" class="btn-adhi margin10 renew_single_course">Renew</a><br/>';
                            }
                        }
                    }
                    
                    if(($course['disable_status'] != 'reniew' || ($course['reinstate_status'] == 1)) && FALSE === array_search(s('USERID'), c('disable_quiz_for_users'))) {
                        echo '<a rel="nofollow" href="' . base_url() . 'quiz/quizlist/' . $course['id'] . '" role="button" class="btn-adhi margin10">Take Quiz</a><br/>';
                    }
                    if($course['last_attemptdate']!='0000-00-00'){
                        if($view_score){
                            echo '<a rel="nofollow" href="#" class="btn-adhi margin10" data-toggle="modal" data-target="#view_score_'.$course['id'].'">View Score</a><br/>';
                            echo '<div class="modal fade bs-example-modal-sm" id="view_score_'.$course['id'].'" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                    <div class="modal-dialog modal-sm">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="gridSystemModalLabel">Exam Score</h4>
                                        </div>
                                        <div class="modal-body text-center">
                                            <h5>Your Score is <b>'.$course['final_score'].'</b></h5>
                                        </div>
                                      </div>
                                    </div>
                                  </div>';
                        }
                    }
                    
                    if(find_date_diff($this->config->item("cut_off_date"),$course['enrolled_date']) > 0){
                            $edition        = get_user_edition($course['id'], $this->session->userdata ( 'USERID' ) );
                            $supplements    = getSupplement($course['id'], $edition );
                            if(count($supplements)>0 && FALSE === array_search(s('USERID'), c('disable_supplement_for_users'))){
                                $select_optoins = '';
                                foreach ($supplements as $row) { 
                                    $select_optoins .= '<option value="'.$row['id'].'">'.$row['title'].'</option>';
                                }
                                echo '<a rel="nofollow" href="#" class="btn-adhi margin10" data-toggle="modal" data-target="#download_supplement_'.$course['id'].'">View Supplement</a><br/>';
                                    echo '<div class="modal fade" id="download_supplement_'.$course['id'].'" tabindex="-1" role="dialog">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="gridSystemModalLabel">View Supplement</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <select class="form-control" name="sel_supplement'.$course['id'].'" id="sel_supplement'.$course['id'].'">
                                                        '.$select_optoins.'
                                                    </select>
                                                    <a rel="nofollow" class="btn-adhi margin10 download_supplement_btn" data-courseid="'.$course['id'].'">Download Supplement</a>
                                                </div>
                                              </div>
                                            </div>
                                          </div>';
                            }
                    }
                ?>
            </div>
        </div>
<?php
    $i++;
    }
?>
    <?php if($renew_course_count > 0){?>
        <div class="text-center" style="margin-top:50px;margin-bottom:20px;">
            <hr>
            <form id="form_renew_courses" action="<?php echo base_url();?>user/renew_courses" method="POST">
                <input type="hidden" name="courses_ids" id="courses_ids" />
                <a id="renew_courses" style="margin:0 auto;;" rel="nofollow" class="btn-adhi margin10">Renew Courses</a>
            </form>
        </div>
    <?php }?>
    
<?php
}
?>
<form id="form_reenroll" action="<?php echo base_url();?>course/reenroll" method="POST">
    <input type="hidden" name="reenroll_course_id" id="reenroll_course_id" />
</form>
<script>
    $(document).ready(function (){
        
        $('body').on('click', '#renew_courses', function (e){
            $(this).prop('disabled', true).addClass('disabled').text('Please wait..')
            e.preventDefault();
            if($('[name="courses[]"]:checked').length > 0){
                var ids = '';
                $.each($('[name="courses[]"]:checked'), function (i, element){                    
                    ids += $(element).val()+',';
                })
                ids = ids.replace(/,(\s+)?$/, '');
                $('#courses_ids').val(ids);
                $('#form_renew_courses').submit();
            }
            
            
        });
        $('[name="courses[]"]').on('click', function (){
            initRenewCoursesBtn();
        });
        
        $('.renew_single_course').on('click', function (){
            $('input[name="courses[]"]').prop('checked', false);
            $(this).prop('disabled', true).addClass('disabled').text('Please wait..');
            var course_id = $(this).data('course-id');
            $('input#course-'+course_id+'[name="courses[]"]').prop('checked', true);
            $('#renew_courses').trigger('click');
            
        });
        if($('[name="courses[]"]').length > 0){
            $('[name="courses[]"]:checked').removeAttr('checked');
            $('.renew_single_course').prop('disabled', false).removeClass('disabled').text('Renew');            
        }

        $('body').on('click', '.reenroll-btn', function (e){
            $(this).prop('disabled', true).addClass('disabled').text('Please wait..');
            var course_id = $(this).data('course-id');
            $('#reenroll_course_id').val(course_id);
            $('#form_reenroll').submit();
        })
        initRenewCoursesBtn();
    });
    function initRenewCoursesBtn(){
        if($('[name="courses[]"]:checked').length > 0){
            $('#renew_courses').removeClass('disabled');            
        }else{
            $('#renew_courses').addClass('disabled');
        }
    }
    
</script>