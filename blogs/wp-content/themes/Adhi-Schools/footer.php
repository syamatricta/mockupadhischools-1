		<div id="wpFooter">
			<div id="footerWidget">
            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) : ?>
                <?php endif; ?>
				<div class="frow copyright">
					<h3>Copyright</h3>
					<p>Copyright © 2016 <?php bloginfo('name'); ?>. All Rights reserved.<br />Developed by <a target="_blank" href="http://sencerbugrahan.deviantart.com">SencerBugrahan</a> & <a href="http://alibahsisoglu.com.tr" target="_blank">Ali Bahsisoglu</a> <br />Powered by <a target="_blank" href="http://wordpress.org">Wordpress</a><br /><a class="alignleft top" href="javascript:void(0)">Top</a><a target="_blank" class="alignright" href="http://onlywp.com"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/onlywp.png" alt="OnlyWp"/></a></p>
				</div>
			</div>
		</div>
        <?php wp_footer(); ?>
        <?php echo get_option('wpt_analytics'); ?> 
	</body>
</html>