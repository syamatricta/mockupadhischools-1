<?php page_heading((isset($pagedetails->title) && $pagedetails->title !='') ? $pagedetails->title : '' , '');?>
<section class="page-content">
    <div class="container">
        <?php print(filter_content($pagedetails->content)); ?>
    </div>
</section>
 