<?php 
    if($license == 'S' and $courses_m !=false){?>
        <div class="row">
            <div class="col-sm-12"><div class="class_optional margin10">The following courses are required</div></div>
        </div>
        <div class="row margin30">
            <div class="col-sm-12 mandatory">
                <?php foreach($courses_m as $courses_m) : ?>
                        <input type="hidden" name="courseprice<?php echo $courses_m['id']; ?>" id="courseprice<?php echo $courses_m['id']; ?>" value="<?php echo $courses_m['amount']; ?>"  />
                        <div class="checkbox checkbox-danger">
                            <input type="checkbox"  name="course[]" id="course<?php echo $courses_m['id']; ?>" value="<?php echo $courses_m['id']; ?>"  data-price="<?php echo $courses_m['amount']; ?>"  data-course_name="<?php echo $courses_m['course_name']; ?>" data-courseweight="<?php echo $courses_m['wieght']; ?>" >
                            <label for="course<?php echo $courses_m['id']; ?>"><?php echo $courses_m['course_name'] ." -  $".$courses_m['amount']; ?> </label>
                        </div>
                        <input type="hidden" name="selagree<?php echo $courses_m['course_id']; ?>" id="selagree<?php echo $courses_m['course_id']; ?>" value="0" />
                        <input type="hidden" name="courseweight<?php echo $courses_m['course_id']; ?>" id="courseweight<?php echo $courses_m['course_id']; ?>" value="<?php echo $courses_m['wieght']; ?>"  />

                <?php endforeach;?>
            </div>
        </div>
<?php }?>