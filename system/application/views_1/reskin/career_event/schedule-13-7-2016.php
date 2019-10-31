<?php page_heading('Career Events ', '');?>
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

 