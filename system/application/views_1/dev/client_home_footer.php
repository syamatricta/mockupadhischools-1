		</div>
<?php /* main division for bottom navigation starts here */?>
		<div class="bottomnavigationmain">
			<div class="floatleft">
				<div class="floatleft"><img  src="<?php  echo $this->config->item('images');?>bottom_nav_left.jpg" /></div>
				<div class="bottomnavmiddle">
					<div class="bottomnavtextdiv">
						<div class="copyright"><small>Copyright 2003 - <?php echo date('Y'); ?> Adhischools,LLC</small></div>
						<div class="floatright">
							<div class="navigation_bottom"><small><?php echo anchor(base_url().$siteurl[0]->name,'About Us');?></small></div>
							<div class="navigation_bottom">|</div>
							<div class="navigation_bottom"><small><?php echo anchor(base_url().$siteurl[1]->name,'Contact Us');?></small></div>
							<div class="navigation_bottom">|</div>
							<div class="navigation_bottom"><small><?php echo anchor(base_url().$siteurl[4]->name,'Terms of Use');?></small></div>
							<div class="navigation_bottom">|</div>
							<div class="navigation_bottom"><small><?php echo anchor(base_url().$siteurl[5]->name,'Privacy Policy');?></small></div>
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
