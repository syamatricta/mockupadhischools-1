<?php 
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?>
<div id="sitepagemain">
	<div class="sitepagetitle"><?php if(isset($page_title) && $page_title !=''){print($page_title); } ?></div>
	<div class="clearboth"></div>
	<div class="sitepagecontent"><?php print($pagedetails); ?></div>
</div>