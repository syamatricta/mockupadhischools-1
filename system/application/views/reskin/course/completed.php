<?php
$i=1;
if($passedcourselist){  ?>
    <div class="row margin20">
        <div class="col-sm-12">
            <div class="heading_band_bg">Completed Courses</div>
        </div>
    </div>
<?php foreach ($passedcourselist as $pcourse){?>
<?php /* Completed course list */ ?>
<div class="row margin20">
    <div class="col-sm-12">
        <div class="heading_band"><?php if( $pcourse->parent_course_name) echo $pcourse->parent_course_name."(".$pcourse->course_name.")"; else echo $pcourse->course_name;  ?></div>
    </div>
</div>
<div class="row margin10">
    <div class="col-sm-8">
        <?php /*<div class="row margin10">
            <div class="col-xs-6 text-right nolpadxs">Course Code :</div>
            <div class="col-xs-6 norpadxs"><?php echo $pcourse->course_code;  ?></div>
        </div> */ ?>
        <div class="row margin10">
            <div class="col-xs-6 text-right nolpadxs">Course Registration :</div>
            <div class="col-xs-6 norpadxs"><?php echo formatDate($pcourse->enrolled_date);  ?></div>
        </div>
        <div class="row margin10">
            <div class="col-xs-6 text-right nolpadxs">Passed Date :</div>
            <div class="col-xs-6 norpadxs"><?php echo formatDate($pcourse->passeddate); ?></div>
        </div>
    </div>
    <div class="col-sm-4">
        <a rel="nofollow" href="<?php echo base_url().'quiz/quizlist/'.$pcourse->courseid;?>" role="button" class="btn-adhi margin10">Take Quiz</a><br/>
        
        <a rel="nofollow" href="#" class="btn-adhi margin10" data-toggle="modal" data-target="#view_score_<?php echo $pcourse->courseid;?>">View Score</a><br/>
        <div class="modal fade bs-example-modal-sm" id="view_score_<?php echo $pcourse->courseid;?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">Exam Score</h4>
                    </div>
                    <div class="modal-body text-center">
                        <h5>Your Score is <b><?php echo $pcourse->final_score;?></b></h5>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
        if(find_date_diff($this->config->item("cut_off_date"),$course['enrolled_date']) > 0){
                $edition        = get_user_edition($pcourse->courseid, $this->session->userdata ( 'USERID' ) );
                $supplements    = getSupplement($pcourse->courseid, $edition );
                if(count($supplements)>0){
                    $select_optoins = '';
                    foreach ($supplements as $row) { 
                        $select_optoins .= '<option value="'.$row['id'].'">'.$row['title'].'</option>';
                    }
                    echo '<a rel="nofollow" href="#" class="btn-adhi margin10" data-toggle="modal" data-target="#download_supplement_'.$pcourse->courseid.'">View Supplement</a><br/>';
                        echo '<div class="modal fade" id="download_supplement_'.$pcourse->courseid.'" tabindex="-1" role="dialog">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="gridSystemModalLabel">View Supplement</h4>
                                    </div>
                                    <div class="modal-body">
                                        <select class="form-control" name="sel_supplement'.$pcourse->courseid.'" id="sel_supplement'.$pcourse->courseid.'">
                                            '.$select_optoins.'
                                        </select>
                                        <a rel="nofollow" class="btn-adhi margin10 download_supplement_btn" data-courseid="'.$pcourse->courseid.'">Download Supplement</a>
                                    </div>
                                  </div>
                                </div>
                              </div>';
                }
        }
        if($pcourse->expired>0){
            echo '<a rel="nofollow" href="pdf_create/'.$pcourse->courseid.'/'.$pcourse->courseid.'" class="btn-adhi margin10">View Certificate</a><br/>';
        }
        ?>
        
    </div>
</div>

<?php
        $i++; 
    } 
}
?>
