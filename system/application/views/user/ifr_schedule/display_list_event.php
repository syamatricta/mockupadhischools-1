<div class="list_container">
	<div class="list_heading">Classes on <?php echo date('m/d/Y',strtotime($current_date));?></div>
	<div class="list_main">
		<div class="column_name" style="font-size:13px;">Region</div>
        <div class="column_name1" style="font-size:13px;">Sub-Region</div>
		<div class="column_time" style="font-size:13px;">Time</div>
                <div class="column_time" style="font-size:13px;">Course</div>
		<div class="column_details" style="font-size:13px;">Chapter Details</div>
	</div>
	<div class="clearboth paddingtop"></div>
	<div class="list_sub">
	<?php if($arr_list){
			$i = 0;
			foreach ($arr_list as $val){ 
				if($i==0){
					$color = 'background:#efefef;';
					$i=1;
				}else {
					$color = 'background:#efefef;';
					$i=0;
				}
				?>
				<div class="row_container" style="<?php echo $color;?>">
					<div class="column_name"><?php echo $val->region;?> </div>
                    <div class="column_name1"><?php echo $val->subregion;?> </div>
					<div class="column_time"><?php echo $val->time_start.' '.$val->meridiean_start.' - '.$val->time_end.' '.$val->meridiean_end; ?></div>
                                        <div class="column_time"><?php echo ($val->crsname !='')?$val->crsname:'--'; ?></div>
                                        
					<div class="column_details"> <?php $dat3 =date('m/d/Y',strtotime($current_date));?>
						<!--<a class="column_details_link" href="javascript: void(0);" onclick="Modalbox.show('<?php #echo site_url().$modal_path;?>', {title: 'Chapter Details', width: 700,closeStatus: 0,closeValue:'close', fromTop : 300,method: 'POST', params: {masterid :'<?php #echo $val->master_id;?>',currentdate : '<?php #echo date('m/d/Y',strtotime($current_date));?>'}}); return false;" > <div class="view_chapter_det_img"></div></a>-->
<!--						<a class="column_details_link" href="javascript: void(0);" onclick="Modalbox.show('<?php echo site_url().$modal_path;?>', {title: ' ', width: 700,closeStatus: 0,closeValue:'Close', fromTop : 300,method: 'POST', params: {masterid :'<?php echo $val->master_id;?>',currentdate : '<?php echo date('m/d/Y',strtotime($current_date));?>'}}); return false;" >-->
                                                <a href="javascript:void(0)" onclick="javascript:show_class('<?php echo site_url().$modal_path;?>','<?php echo $val->master_id;?>','<?php echo $dat3;?>'); return false;">
                                                    <div class="view_chapter_det_img"></div></a>
					</div>
                                        <?php /* popup starts */ ?>
                                            <div class="popup-position" style="width:720px; display: none;" id="relatedclass">
                                                 <?php  echo red_popup_box_top();?>
                                                 <div class="list_popup_content_main" id="rel" ></div>
                                                 <?php echo popup_box_bottom();?>
                                                <style type="text/css">
                                                 #relatedclass {
                                                     position:fixed;
                                                     width:600px;
                                                     z-index:1001;
                                                 }
                                                 .popup-position {
                                                     left:450px;
                                                     top:130px;
                                                 }
                                                 /* iPad Portrait */
                                                @media screen and (min-device-width: 481px) and (orientation:portrait) {
                                                    .popup-position {
                                                    left:290px;
                                                    top:600px;
                                                    }
                                                }

                                                /* iPad Landscape */
                                                @media screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape) {
                                                    .popup-position {
                                                    left:355px;
                                                    top:180px;
                                                    }
                                                 }
                                                 
                                                 @media only screen 
                                            and (min-device-width : 320px) 
                                            and (max-device-width : 480px) 
                                            and (orientation : portrait) {
                                            .popup-position {
                                                    left:300px;
                                                    top:600px;
                                                    }
                                            }
                                            @media only screen 
                                            and (min-device-width : 320px) 
                                            and (max-device-width : 480px) 
                                            and (orientation : landscape) { 
                                                 .popup-position {
                                                    left:340px;
                                                    top:180px;
                                                    }
                                            }
                                          
                                            @media only screen 
                                        and (min-device-width : 320px) 
                                        and (max-device-width : 568px) 
                                        and (orientation : landscape) {
                                            .popup-position {
                                                    left:340px;
                                                    top:180px;
                                                    }}
                                        
                                        @media only screen 
                                        and (min-device-width : 320px) 
                                        and (max-device-width : 568px) 
                                        and (orientation : portrait) { 
                                            .popup-position {
                                                    left:140px;
                                                    top:600px;
                                                    }
                                        }
                                                 
                                                 </style>
                                             </div>
                                         <?php /* popup ends */ ?>
				</div>
				<div class="clearboth paddingtop"></div>
<?php 		}
		
		}else{
			echo '<div class="nodata row_container" style="width:691px;">No classes found</div>';
		}?>
		<input type="hidden" name="hdnMasterid" id="hdnMasterid"/>
	</div>
	<div class="clearboth"></div>
    <div class="list_bottom">
		
	</div>
</div>