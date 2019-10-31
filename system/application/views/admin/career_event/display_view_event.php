<div style="float:left;overflow:auto;height:auto !important;max-height:400px;height: 400px;min-height:200px;width:70%">
	<div class="clearboth paddingtop"></div>
	<?php 
	if($arr_event){?>
		<div class="label_style">Region</div>
		<div class="label_colon">:</div>
		<div class="floatleft view_event"><?php echo $arr_event->region;?></div>
		<div class="clearboth paddingtop"></div>
		
		<div class="label_style">Sub-Region</div>
		<div class="label_colon">:</div>
		<div class="floatleft view_event"><?php echo $arr_event->subregion;?></div>
		<div class="clearboth paddingtop"></div>
        
                <div class="label_style">Title</div>
		<div class="label_colon">:</div>
		<div class="floatleft view_event"><?php echo $arr_event->title;?></div>
		<div class="clearboth paddingtop"></div>
        
		<div class="label_style">Date</div>
		<div class="label_colon">:</div>
		<div class="floatleft view_event"><?php echo $arr_event->start_date;?></div>
		<div class="clearboth paddingtop"></div>
		<?php 
		if($arr_event->repeat_status==1){
			$mode 	= 'Daily';
			$status ='Yes,';
		}else if($arr_event->repeat_status==2){
			$mode 	= 'Weekly';
			$status ='Yes,';
		}else{ 
			$mode 	= '';
			$status ='No';
		}
		?>
		<div class="label_style">Do you want to repeat?</div>
		<div class="label_colon">:</div>
		<div style="color:#544E4F;float:left;">
			<div id="divRepeatCheck" class="floatleft"><?php echo $status;?></div>
			<div id="divRepeat" class="floatleft" style="padding-top:5px;">
				<div class="floatleft" style="width:45px;">
					<?php echo '&nbsp;&nbsp;'.$mode;?>
				</div>
				<div class="floatleft">
					<?php if($arr_event->repeat_status!=0){echo '&nbsp;&nbsp;Repeat till&nbsp;:&nbsp;'.$arr_event->repeat_ends;}?>
				</div>
			</div>
		</div>
		<div class="clearboth paddingtop"></div>
		
		<div class="label_style">Time</div>
		<div class="label_colon">:</div>
		<div class="view_event">
			<div class="floatleft">
				<?php echo $arr_event->start_hr.':'.$arr_event->start_mts.' '.$arr_event->meridiean_start;?>
			</div>
			<div id="divTimeBetween"> to </div>
			<div class="floatleft">
				<?php echo $arr_event->end_hr.':'.$arr_event->end_mts.' '.$arr_event->meridiean_end;?>
			</div>
		</div>
		<div class="clearboth paddingtop"></div>
		
		<div class="label_style">Details</div>
		<div class="label_colon">:</div>
		<div class="floatleft view_event"><?php echo $arr_event->descp;?></div>
		<div class="clearboth paddingtop"></div>
                
                <div class="clearboth paddingtop"></div>
		
		<div class="label_style">Parking Info</div>
		<div class="label_colon">:</div>
		<div class="floatleft view_event"><?php echo $arr_event->parking_info;?></div>
		<div class="clearboth paddingtop"></div>
                
		
	<?php 
	} ?>
</div>
<div class="" style="float:left;width:30%">
    <?php 
        
        $full_image = $this->config->item('image_upload_path').'thumbs/'.$arr_event->image_name;
        if($arr_event->image_name && file_exists($full_image)){
            $full_image = $this->config->item('site_ssl_baseurl').'image_uploads/thumbs/'.$arr_event->image_name;
            //$full_image = $this->config->item('image_upload_url').'thumbs/'.$arr_event->image_name;
        }else{
            $full_image = $this->config->item('site_ssl_baseurl').'images/default_image.jpg';
        }
    ?>
    <img src="<?php echo $full_image;?>" />
</div>
<style>
    .view_event{width:65%;}
</style>