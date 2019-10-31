<?php page_heading((isset($pagedetails->title) && $pagedetails->title !='') ? $pagedetails->title : '' , 'banner-about');?>
<div class="text-right" style="margin-right:8%;">
   <span><a href="<?php echo base_url(); ?>">Home</a></span>
   <span class="content">|About Us</span> 
</div>
<?php print(filter_content($pagedetails->content)); ?>