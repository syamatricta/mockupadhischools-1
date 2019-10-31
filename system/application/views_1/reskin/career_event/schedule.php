<section class="page_head banner-career-event">
    <div class="career-event-bg-dim"></div>
    <div class="container">		 
        <div class="row">
            <center class="col-sm-12">
                <h3>What is a Career Event?</h3>
                <p>Don't worry, we won't take much of your time. This one hour event is an opportunity to meet with some experienced industry experts and find out more about what it means to be a Real Estate Agent and ask any questions you might have. You will also learn what is required to get your license and the different ways we can help you get started.</p>
                <p>Register here to reserve your seat and make sure we have an information packet and refreshments for you!</p>
                <p>Simply find a Career Seminar below in your local area and enter your name, email and phone number to book your reservation today.</p>
            </center>
        </div>
    </div>
    <?php page_heading('Career Events', '', TRUE, FALSE);?>
</section>



<script type="text/javascript" src="<?php echo $this->config->item('script_url');?>career_event.js"></script>
<h2 class="hidden"><?php echo date('F Y');?></h2>
<section class="page-content">
    <div class="container scheduledetails">
        <div class="row">
            <div class="col-md-12 mb50">
                <div class="col-md-4 nopad">
                    <div>
                        <select class="form-control" name="sltSearchRegion" id="sltEventSearchRegion"  <?php if(isset($class_mode)){ echo 'disabled';}?> > <!-- onchange="javascript: fncGetSubregion('sltSearchRegion','sltSearchSubregion');" -->
                            <option value="0" >Region</option>
                            <?php
                            if($regions){
                                foreach ($regions as $data){
                                    echo '<option value="'.$data->id.'"';if(isset($region_search) && $region_search==$data->id){echo 'selected';} echo '>'.$data->region_name.'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 nopadsm">
                    <select class="form-control" name="sltSearchSubregion" id="sltEventSearchSubregion" <?php if(isset($class_mode)){ echo 'disabled';}?>   > 
                        <option value="0" >Sub Region</option>
                       <?php 
                       if(isset($region_search) && isset($raw_subregion)){
                           foreach ($raw_subregion as $data){
                               if($data->regionid == $region_search){
                                   echo '<option value="'.$data->id.'" ';if(isset($subregion_search) && $subregion_search==$data->id){echo 'selected';} echo ' >'.$data->sub_name.'</option>';
                               }
                           }
                       }
                       ?>
                    </select>
                </div>
            </div>
            <script>
                <?php echo $content = "var content = ".$json_array.";"; ?>
            </script>
            <div class="col-md-12">
                <div id="event_calendar"></div>
            </div>

        </div>
        <div class="col-md-12 mb50"></div>
        <div class="col-md-12 mb50"></div>
    </div>
</section>

 