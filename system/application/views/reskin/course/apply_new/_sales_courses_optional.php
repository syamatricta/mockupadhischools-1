<?php if($license == 'S' && $courses_o !=false){?>
<div class="class_optional margin20">The candidates can pick from one of the below</div>
<input type="hidden" name="s_courseprice" id="s_courseprice" value="0"  />
<div class="row margin30">
        <div class="col-md-12 optionalcart">
        <?php foreach($courses_o as $courses_o): ?>
                <input type="hidden" name="courseprice<?php echo $courses_o['id']; ?>" id="courseprice<?php echo $courses_o['id']; ?>" value="<?php echo $courses_o['amount']; ?>"  />
                <input type="hidden" name="selagree<?php echo $courses_o['id']; ?>" id="selagree<?php echo $courses_o['id']; ?>" value="0" />
                <?php if($courses_o['id'] !=5) ?>
                <input type="hidden" name="courseweight_b<?php echo $courses_o['id']; ?>" id="courseweight_b<?php echo $courses_o['id']; ?>" value="<?php echo $courses_o['wieght']; ?>"  />
                <div class="radio radio-danger">
                        <input type="radio" name="course_b" id="course_b<?php echo $courses_o['id']; ?>" value="<?php echo $courses_o['id']; ?>" data-price="<?php echo $courses_o['amount']; ?>"  data-course_name="<?php echo $courses_o['course_name']; ?>" data-courseweight="<?php echo $courses_o['wieght']; ?>">
                        <label for="course_b<?php echo $courses_o['id']; ?>"><?php echo $courses_o['course_name'] ." - $".$courses_o['amount']; ?> </label>
                </div>
        <?php endforeach;?>
        </div>
</div>
<?php }?>
