<div id="sitepagemain">
	<!--<div>
		<img src="<?php //echo $this->config->item('banner_image_url').'thumbs/'.$banner_details[0]->banner_image;?>" />
	</div>-->
	<div class="sitepagetitle"><?php if(isset($banner_details[0]->banner_title) && $banner_details[0]->banner_title !=''){print($banner_details[0]->banner_title); } ?></div>
	<div class="clearboth"></div>
	<?php if(count($banner_details)>0){?>
			<div class="sitepagecontent"><?php print($banner_details[0]->banner_long_desc); ?></div>
	<?php } ?>
</div>
