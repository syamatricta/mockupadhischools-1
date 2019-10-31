<div id="sitepagemain">
	<div class="sitepagetitle"><?php if(isset($pagedetails->title) && $pagedetails->title !=''){print($pagedetails->title); } ?></div>
	<div class="clearboth"></div>
	<?php if(count($pagedetails)>0){?>
			<div class="sitepagecontent"><?php print($pagedetails->content); ?></div>
	<?php } ?>
</div>
