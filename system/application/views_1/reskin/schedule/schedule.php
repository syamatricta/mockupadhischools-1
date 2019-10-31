<?php page_heading('Schedule ', '');?>
<h2 class="hidden"><?php echo date('F Y');?></h2>
<section class="page-content">
    <div class="container scheduledetails">
		<div class="row">
			<div class="col-md-12 mb50">
				<div class="col-md-4 nopad">
					<div>
						<select class="form-control" name="sltSearchRegion" id="sltSearchRegion"  <?php if(isset($class_mode)){ echo 'disabled';}?> > <!-- onchange="javascript: fncGetSubregion('sltSearchRegion','sltSearchSubregion');" -->
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
					 <select class="form-control" name="sltSearchSubregion" id="sltSearchSubregion" <?php if(isset($class_mode)){ echo 'disabled';}?>   > 
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
				<div class="col-md-4 nopad">
					<select class="form-control" name="sltSearchCourse" id="sltSearchCourse" <?php if(isset($class_mode)){ echo 'disabled';}?>  > <!--onchange="javascript: fncDisplayDefaultList(<?php echo $today_timeline;?>,<?php echo date('j',strtotime('-8 hour'))?>,<?php echo date('n',strtotime('-8 hour'))?>,<?php echo date('Y',strtotime('-8 hour'))?>);" -->
                         <option value="0" >Course</option>
                        <?php
                        if($course_list_all){
                            foreach ($course_list_all as $data){
                                echo '<option style="background:url('.$this->config->item('sq_image_url').$crse_color[$data->id].'.png) no-repeat top right;" value="'.$data->id.'"';if(isset($course_search) && $course_search==$data->id){echo 'selected';} echo '>'.$data->course_name.'</option>';
                            }
                        }
                        ?>
                    </select>
				</div>
				<div class="col-md-4 nopad" id="chter_cnt" style="display:none;" >
					
					 <select class="form-control" name="sltSearchChp" id="sltSearchChp" <?php if(isset($class_mode)){ echo 'disabled';}?> > 
                                         <option value="0" >Chapter</option>
                                        <?php
                                        if($chp_list){
                                            for($i=1;$i<=count($chp_list);$i++){
                                                echo '<option value="'.$i.'"';if(isset($chp_search) && $chp_search==$i){echo 'selected';} echo '>'.$chp_list[$i].'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
				</div>
			</div>
			<script>
				<?php echo $content  		 	= "var content = ".$json_array.";"; ?>
			</script>
			<div class="col-md-12">
				<div id="calendar"></div>
			</div>
			
		</div>
		<div class="col-md-12 mb50"></div>
		<div class="col-md-12 mb50"></div>
	</div>
</div>

 <script>
$(document).ready(function (){
/*moment.createFromInputFallback = function(config) {
  // unreliable string magic, or
  config._d = new Date(config._i);
};
*/
});
</script>
