			</div>
			<div class="innerbakground_right"><img  src="<?php  echo  ssl_url_img();?>innerpages/inner_background_right.jpg" /></div>		
		</div>
<?php /* main division for bottom navigation starts here */?>
		<div class="bottomnavigationmain">
			<div class="floatleft">
				<div class="floatleft"><img  src="<?php  echo  ssl_url_img();?>bottom_nav_left.jpg" /></div>
				<div class="bottomnavmiddle">
					<div class="bottomnavtextdiv">
						<div class="copyright">Copyright 2003 - <?php echo date('Y'); ?> Adhischools,LLC</div>
						<div class="floatright"> <?php /*
                                                        <div class="navigation_bottom"><?php echo anchor('index.php/articles','Articles',array('title'=>'Articlesr'));?></div>
							<div class="navigation_bottom">|</div> */ ?>
							<div class="navigation_bottom"><?php echo anchor('index.php/'.$siteurl[0]->name,'About Us',array('title'=>'About Us'));?></div>
							<div class="navigation_bottom">|</div>
							<div class="navigation_bottom"><?php echo anchor('index.php/'.$siteurl[1]->name,'Contact Us',array('title'=>'Contact Us'));?></div>
							<div class="navigation_bottom">|</div>
							<div class="navigation_bottom"><?php echo anchor('index.php/'.$siteurl[4]->name,'Terms of Use',array('title'=>'Terms of Use'));?></div>
							<div class="navigation_bottom">|</div>
							<div class="navigation_bottom"><?php echo anchor('index.php/'.$siteurl[5]->name,'Privacy Policy',array('title'=>'Privacy Policy'));?></div>
							<div class="navigation_bottom">|</div>
							<div class="navigation_bottom"><?php echo anchor('index.php/sitemap.html','Sitemap',array('title'=>'Sitemap'));?></div>
						</div>
					</div>
				</div>
				<div class="floatleft"><img  src="<?php  echo  ssl_url_img();?>bottom_nav_right.jpg" /></div>
			</div>
		</div>
<?php /*main division for bottom navigation ends here */ ?>
	</div>
</body>
</html>
