		<?php if($this->authentication->logged_in ("normal")){
					$id_head=1;
					$class='navigationtextlog_new';
					$class_selected='navigationtextlog_new';
			} else {
			   		$id_head=0;
			   		$class='navigationtext_new';
			   		$class_selected='navigationtext_new';
			}

   		?>


<a href="<?php echo base_url()?>"><div class="logo_cntnr"></div></a>
    		<div class="testimonial_image">
                     <a href="<?php echo base_url() . 'testimonial'; ?>">
                        <img src="<?php echo $this->config->item('images') . 'testimonial.png' ?>" width="237" height="71" alt="Testimonials" title="Testimonials" onmouseover="this.src='<?php echo $this->config->item('images'); ?>testimonial_hover.png';" onmouseout="this.src='<?php echo $this->config->item('images'); ?>testimonial.png';"/>
                     </a>
                </div>
                <div class="cb"></div>
	        <div class="floatleft">
	        	<div class="phone_div"></div>
	        	<div class="phone_no">888.768.5285</div>
	        	<div class="cb"></div>
	        	<div class="notepad_div"></div>
	        	<div class="fax_no">949 625 8007</div>
	        </div>
            <div class="community_txt_img" style="margin-top:15px;"></div>
            <div class="icons_cntnr" style="margin-bottom:7px;width:258px;">
                <a href="https://facebook.com/adhischools/" target="_blank" rel="nofollow"><div class="face_book_img"></div></a>
                <a href="https://twitter.com/adhischools/" target="_blank" rel="nofollow"><div class="twitter_img"></div></a>
                <a href="https://www.youtube.com/channel/UCKnNFzHOoFcrh0vNBRWcEBQ" target="_blank" rel="nofollow"><div class="youtube_img"></div></a>
                <a href="https://www.instagram.com/adhischools/" target="_blank" rel="nofollow"><div class="forum_img"></div></a>
                <a href="http://www.yelp.com/biz/adhi-schools-newport-beach" target="_blank" rel="nofollow"><div class="yelp_img"></div></a>
                <a href="http://www.adhischools.com/blog/" target="_blank" rel="nofollow"><div class="blog_img"></div></a>
            </div>

        <div class="links_div">
                Copyright 2003 - 2016 <?php //echo date('Y'); ?> Adhischools,LLC<br />
                <?php echo anchor(base_url().$siteurl[0]->name,'About Us',array('title'=>'About Us'));?>&nbsp;
                <?php echo anchor(base_url().$siteurl[1]->name,'Contact Us',array('title'=>'Contact Us'));?>&nbsp;<?php /*
                <?php echo anchor(base_url().'articles','Articles',array('title'=>'Articles'));?>&nbsp; */ ?>
                <?php echo anchor(base_url().'brokerplacement','Careers',array('title'=>'Careers'));?>&nbsp;
                 <?php echo anchor(base_url().'sitemap.php','Sitemap',array('title'=>'Sitemap'));?><br />
                 <!--<?php //echo anchor(base_url().'testimonial','Testimonials',array('title'=>'Testimonials'));?>&nbsp;-->
                <?php echo anchor(base_url().$siteurl[4]->name,'Terms of Use',array('title'=>'Terms of Use'));?>&nbsp;
                <?php echo anchor(base_url().$siteurl[5]->name,'Privacy Policy',array('title'=>'Privacy Policy'));?>&nbsp;
                <?php echo anchor(base_url() . 'faq', 'FAQ', array('title' => 'FAQ')); ?>&nbsp;
        </div>