<div class="floatleft">
    <div class="left_cntnr pos_rel">
            <?php $this ->load->view('left_content_home.php');?>
    </div>
    <div class="right_cntnr">
        <div class="right_cntnr_bg_hd">
        	 <div class="floatleft w100perc">
				 <div class="sitepagehead"><h1><?php if(isset($pagedetails->title) && $pagedetails->title !=''){print($pagedetails->title); } ?></h1><h2><?php if(isset($pagedetails->title) && $pagedetails->title !=''){print($pagedetails->title); } ?></h2></div>
				 <div class="username"><?php disp_loggedin_username(); ?></div>
			 </div>           
        </div>
        <div class="right_cntnr_bg">
            <div id="sitepagemain">
                <div class="clearboth"></div>
                <?php if(count($pagedetails)>0){?>
                        <div class="sitepagecontent_new"><?php print(filter_content($pagedetails->content)); ?></div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>