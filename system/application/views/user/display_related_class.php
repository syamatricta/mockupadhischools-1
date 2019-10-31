<input type="hidden" name="hdnOffset" id="hdnOffset" value="<?php echo $offset_hidden;?>" />
<div class="clearboth"></div>
<div id="divImageLeft"><?php if($prev_active == 1) {?><img src="<?php  echo $this->config->item('images');?>up.png" onclick="javascript:fncNextPrevRegion(0);" /><?php }?></div>
<div class="clearboth"></div>
<div id="divImage">
	<?php $i = 0;
		foreach($arr_result as $val){
			$i++;
			$full_image = $this->config->item('image_upload_path').'thumbs/'.$val->image;
			if($val->image && file_exists($full_image)){
				$full_image = $image_path.$val->image;
				$css_class  = 'image_tag divImageNameTag';
			}else{
				$full_image = $this->config->item('images').'default_image.jpg';
				$css_class  = 'image_tag';
			}
			
			if($i%2){
				$alt = 'Real Estate Classes Los Angeles';
			}else{
				$alt = 'Real Estate School Orange County';
			}
			?>

			<div id="divImageContainer">
			        <a rel="nofollow" href="javascript:void(0)" onclick="javascript:show_relatedclass('<?php echo $modal_path; ?>',<?php echo $val->subregion_id; ?>,'<?php echo $dated;?>'); return false;">
                            <div class="<?php echo $css_class;?>"><?php echo $val->subregion;?></div>
					<img width="148" height="79" src="<?php echo $full_image?>" alt="<?php echo $alt; ?>"/>
				</a>
			</div>    
			<div class="image_scroll_gap">&nbsp;</div>
<?php	} ?>                         
</div>
<?php /* popup starts */ ?>
<div class="rel_inline_css" id="relatedclass">
<?php  echo todaycls_box_top();?>
<div class="popup_content_main" id="rel"></div>
<?php echo todaycls_box_bottom();?>                            
</div>
<?php /* popup ends */ ?>
<div class="clearboth"></div>
<div id="divImageRight" ><?php if($next_active == 1) {?><img src="<?php  echo $this->config->item('images');?>down.png" onclick="javascript:fncNextPrevRegion(1);" /><?php } ?></div>