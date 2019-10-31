<?php page_heading((isset($pagedetails->title) && $pagedetails->title !='') ? $pagedetails->title : '' , 'banner-about');?>

<?php print(filter_content($pagedetails->content)); ?>