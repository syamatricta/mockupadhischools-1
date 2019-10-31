<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
	<head profile="http://gmpg.org/xfn/11">
        <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
        <link href="<?php bloginfo('stylesheet_directory'); ?>/favicon.png" rel="shortcut icon" type="image/x-icon" />
    	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
		<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<link href="<?php bloginfo('stylesheet_directory'); ?>/reset.css" type="text/css" rel="stylesheet" />
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
		<link href="<?php bloginfo('stylesheet_directory'); ?>/sifr.css" type="text/css" rel="stylesheet" />
        <!--[if lt IE 8]>
        <link href="<?php bloginfo('stylesheet_directory'); ?>/ie.css" type="text/css" rel="stylesheet" />
        <![endif]-->
		<script src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.js" type="text/javascript"></script>
        <?php
        if(is_home() || is_archive && !is_single() && !is_page()):?>
        <script src="<?php bloginfo('stylesheet_directory'); ?>/js/tabswitch.js" type="text/javascript"></script>
        <script type="text/javascript">
        	$(function(){
        		$('.slides').tabSwitch('create',{width: 851, height: 255});
        		$('.navli').click(function(e){
        			$('.slides').tabSwitch('moveTo',{index: parseInt($(this).attr("rel"))});
        			e.preventDefault();
        		});
        		$('.slides').tabSwitch('startAuto',{interval: 5000});
        	});
        </script>
        <?php endif; ?>
        <script src="<?php bloginfo('stylesheet_directory'); ?>/js/whitepress.js" type="text/javascript"></script>   
		<script src="<?php bloginfo('stylesheet_directory'); ?>/js/sifr.js" type="text/javascript"></script> 
        <script type="text/javascript">
            <?php $sifr = get_bloginfo('template_directory'); ?>
            var helvetica = { src: "<?php echo $sifr; ?>/helvetica.swf" };
        </script>
		<script src="<?php bloginfo('stylesheet_directory'); ?>/js/sifr-config.js" type="text/javascript"></script>
        <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?> 
<?php wp_head(); ?>
	</head>
	<body>
		<div id="wpHeader">
			<a class="logo" href="<?php bloginfo('wpurl'); ?>">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo.png" alt="Whitepress Wordpress Theme" />
			</a>
			<div id="wpInformation">
				<ul>
					<li class="twitter"><a href="https://twitter.com/adhischools" target="_blank">Twitter</a></li>
					<li class="rss"><a href="<?php if(get_option('wpt_feed_url') != ''): echo get_option('wpt_feed_url'); else: bloginfo('rss2_url'); endif; ?>"><?php if(get_option('wpt_feed_uri')): echo get_feedburner(get_option('wpt_feed_uri')); else: echo "RSS"; endif; ?></a></li>
				</ul>
			</div>
			<ul id="wpMenu">
				<li><a href="<?php bloginfo('wpurl'); ?>">Home</a></li>
                <?php wp_list_pages('sort_column=menu_order&exclude='.get_option('wpt_page_ex').'&title_li='); ?>
				<li><a href="http://www.adhischools.com/about-us" target="_blank">About Us</a></li>
				<li><a href="http://www.adhischools.com/contact-us" target="_blank">Contact Us</a></li> 
			</ul>
			<div id="wpSearch">
				<form id="searchform" name="searchform" action="<?php echo get_option('home') ?>">
					<input type="text" onfocus="if(this.value==this.defaultValue)this.value='';" value="Search" name="s" />
					<input type="image" src="<?php bloginfo('stylesheet_directory'); ?>/images/spacer.gif" />
				</form>
			</div>
		</div>
