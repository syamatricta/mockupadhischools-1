<?php
if($license == 'B'){ 
    if($courses_mt !=false){
?>
    <div class="row">
        <div class="col-sm-12"><div class="class_optional margin10">The following courses are required</div></div>
    </div>
    <div class="row margin30">
        <div class="col-sm-12 mandatory">
            <?php
            $j = 0;
            foreach($courses_mt as $courses_mt) :
                    $j = $j+1; 	
                    if($j == 6){ ?>
                        <div class="row">
                            <div class="col-md-12"><div class="class_optional margin20">Choose three from the bottom list </div></div>
                        </div> 
            <?php   } ?>	 
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="courseprice<?php echo $courses_mt['id']; ?>" id="courseprice<?php echo $courses_mt['id']; ?>" value="<?php echo $courses_mt['amount']; ?>"  />
                                <div class="checkbox checkbox-danger">
                                    <input type="checkbox"  name="course[]" id="course<?php echo $courses_mt['id']; ?>" value="<?php echo $courses_mt['id']; ?>" data-price="<?php echo $courses_mt['amount']; ?>"  data-course_name="<?php echo $courses_mt['course_name']; ?>" data-courseweight="<?php echo $courses_mt['wieght']; ?>">
                                    <label for="course<?php echo $courses_mt['id']; ?>">							 
                                            <?php 	if($courses_mt['amount'] !=0.00){
                                                    echo $courses_mt['course_name'] ." -  $".$courses_mt['amount']; 
                                            }else {
                                                    echo $courses_mt['course_name'] ; 
                                            }?>	
                                    </label>
                                </div>
                                <input type="hidden" name="selagree<?php echo $courses_mt['id']; ?>" id="selagree<?php echo $courses_mt['id']; ?>" value="0" />
                                <input type="hidden" name="courseweight<?php echo $courses_mt['id']; ?>" id="courseweight<?php echo $courses_mt['id']; ?>" value="<?php echo $courses_mt['wieght']; ?>"  />
                            </div>
                        </div>
            <?php endforeach;?>
        </div>
    </div>
<?php 
    }
    if($courses_mb !=false){
?>
    <div class="row">
        <div class="col-sm-12"><div class="class_optional margin10">Choose <?php echo $countnum;?> from bottom list </div></div>
    </div>
    <div class="row margin30">
        <div class="col-sm-12 mandatory">
            <?php foreach($courses_mb as $courses_mb) : ?>	 
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="courseprice<?php echo $courses_mb['id']; ?>" id="courseprice<?php echo $courses_mb['id']; ?>" value="<?php echo $courses_mb['amount']; ?>"  />
                            <div class="checkbox checkbox-danger">
                                <input type="checkbox"  name="course[]" id="course<?php echo $courses_mb['id']; ?>" value="<?php echo $courses_mb['id']; ?>" data-price="<?php echo $courses_mb['amount']; ?>"  data-course_name="<?php echo $courses_mb['course_name']; ?>" data-courseweight="<?php echo $courses_mb['wieght']; ?>">
                                <label for="course<?php echo $courses_mb['id']; ?>">							 
                                        <?php 	if($courses_mb['amount'] !=0.00){
                                                echo $courses_mb['course_name'] ." -  $".$courses_mb['amount']; 
                                        }else {
                                                echo $courses_mb['course_name'] ; 
                                        }?>	
                                </label>
                            </div>
                            <input type="hidden" name="selagree<?php echo $courses_mb['id']; ?>" id="selagree<?php echo $courses_mb['id']; ?>" value="0" />
                            <input type="hidden" name="courseweight<?php echo $courses_mb['id']; ?>" id="courseweight<?php echo $courses_mb['id']; ?>" value="<?php echo $courses_mb['wieght']; ?>"  />
                        </div>
                    </div>
            <?php endforeach;?>
        </div>
    </div>
    
<?php  
    }
}
?>