<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <tr>
        <th style="width:7%;text-align:left">SI.No</th>
        <th style="width:25%;text-align:left">Course Name</th>
        <th style="width:14%;text-align:left">Enrolled Date</th>
        <th style="width:14%;text-align:left">Final Exam Date</th>
        <th style="width:11%;text-align:center">Score</th>
        <th style="width:29%;text-align:left">Validation Status</th>
    </tr>
    <?php
        if($courses){
            foreach ($courses as $key => $course){                
    ?>
                <tr>
                    <td><?php echo $key+1;?></td>
                    <td><?php echo ('' != $course['course_name']) ? $course['course_name'] : '<span class="text-error">'.$course['course_name_from_excel'].'</span>';?></td>
                    <td><?php echo ('' != $course['enrolled_date']) ?  date('m/d/Y', strtotime($course['enrolled_date'])) : '';?></td>
                    <td><?php echo ('' != $course['exam_date']) ? date('m/d/Y', strtotime($course['exam_date'])) : '';?></td>
                    <td style="text-align: center"><?php echo $course['score'];?></td>
                    <td>
                        <?php
                        if(FALSE !== $course['validation_errors']){
                            echo '<ol style="padding-left:15px;">';
                            $validation_errors = $course['validation_errors'];
                            if(count($validation_errors['fatal']) > 0){
                                foreach ($validation_errors['fatal'] as $error){
                                    echo '<li><span class="text-error">'.$error.'</span></li>';
                                }
                            }
                            if(count($validation_errors['warning']) > 0){
                                foreach ($validation_errors['warning'] as $error){
                                    echo '<li style="margin-bottom:5px;"><span class="text-warning">'.$error.'</span></li>';
                                }
                            }
                            echo '</ol>';
                        }else {
                            echo '<span class="text-success">SUCCESS</span>';
                            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.base_url().'admin_legacy_student/download_certificate/'.$course['student_id'].'/'.$course['course_id'].'">Download Certificate</a>';
                        }
                        ?>
                    </td>
                </tr>
    <?php
        }}
    ?>
            
    
    
</table>