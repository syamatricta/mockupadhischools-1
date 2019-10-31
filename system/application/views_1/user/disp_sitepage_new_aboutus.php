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
                <div class="sitepagecontent_new">
                	<div class="center_wrapper">
		           		<div class="title_class">
		                	<h1>ADHI Schools</h1>
		                    <h3>was founded by one real estate teacher with a simple, yet revolutionary idea</h3>
		                    <span>"People will learn more if they're interested and engaged."</span>
		                </div>
		           		<div class="profile_photo_desc clearfix">
		                	<div class="profile_pic float_l">
		                    	<img alt="profile-pic" title="Kartik Subramaniam" src="<?php echo base_url(); ?>images/profile-photo.png">
		                    </div>
		                    <div class="profile_desc float_r">
		                    	
		                    	<p class="profile_desc_01">This isn't one of those times where the classroom and real life don't intersect" Explained Kartik Subramaniam, Adhi School's founder. "Our optional classroom lectures are designed to blend real world and academic in a very special way."</p>
		                        <span class="profile_desc_02">Kartik Subramaniam is one of the most respected and well known real estate lecturers in the country.<img class="punctuation_bottom" alt="punc-bottom" src="<?php echo base_url(); ?>images/punctuation-bottom.png"></span>		                        
		                    </div>
		                </div>
		                <div class="caption_desc">
		                	<img class="caption_img" alt="caption-txt" src="<?php echo base_url(); ?>images/caption-img.png">
		                    <p class="desc_01"> Since 2003, Adhi Schools has helped students not only pass the examination but also build a career in real estate. We are invested in the success of our students. If you succeed, then we succeed.</p>
		                    <p class="desc_02">Just take a look at where we hold our classes - inside of the largest names in real estate brokerage on the planet. These companies rely on us to provide real estate education services to their new agents. We won't let them or our students down.</p>
		                </div>
					</div>
				</div>
				<div class="clearboth"></div>
			</div>
		</div>
	</div>
</div>