		</div>
<?php /* main division for bottom navigation starts here */?>
		<div class="bottomnavigationmain">
			<div class="floatleft">
				<div class="floatleft"><img  src="<?php  echo $this->config->item('images');?>bottom_nav_left.jpg" /></div>
				<div class="bottomnavmiddle">
					<div class="bottomnavtextdiv">
						<div class="copyright"><small>Copyright 2003 - <?php echo date('Y'); ?> Adhischools,LLC</small></div>
						<div class="floatright"> <?php /*
                                                        <div class="navigation_bottom"><?php echo anchor(base_url().'articles','Articles',array('title'=>'Articles'));?></div>
							<div class="navigation_bottom">|</div> */ ?>
							<div class="navigation_bottom"><?php echo anchor(base_url().$siteurl[0]->name,'About Us',array('title'=>'About Us'));?></div>
							<div class="navigation_bottom">|</div>
							<div class="navigation_bottom"><?php echo anchor(base_url().$siteurl[1]->name,'Contact Us',array('title'=>'Contact Us'));?></div>
							<div class="navigation_bottom">|</div>
							<div class="navigation_bottom"><?php echo anchor(base_url().$siteurl[4]->name,'Terms of Use',array('title'=>'Terms of Use'));?></div>
							<div class="navigation_bottom">|</div>
							<div class="navigation_bottom"><?php echo anchor(base_url().$siteurl[5]->name,'Privacy Policy',array('title'=>'Privacy Policy'));?></div>
							<div class="navigation_bottom">|</div>
							<div class="navigation_bottom"><?php echo anchor(base_url().'sitemap.php','Sitemap',array('title'=>'Sitemap'));?></div>
						</div>
					</div>
				</div>
				<div class="floatleft"><img  src="<?php  echo $this->config->item('images');?>bottom_nav_right.jpg" /></div>
			</div>
		</div>
<?php /*main division for bottom navigation ends here */ ?>
               
	</div>
</body>
</html>
