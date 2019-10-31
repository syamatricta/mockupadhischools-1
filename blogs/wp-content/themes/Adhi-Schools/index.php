<?php
	get_header();
?>
		<div id="wpContent">
<?php get_sidebar(); ?>
			<div id="content">
			<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); update_post_caches($posts); ?>
				<div class="post" id="post-<?php the_ID(); ?>">
					<div class="postUst">
						<div class="postTarih">
							<span class="gun"><?php the_time('d') ?></span>
							<span class="month"><?php the_time('M') ?></span>
							<span class="year"><?php the_time('Y') ?></span>
						</div>
						<div class="postAyrinti">
							<p><?php the_category(', ') ?> | by <?php the_author_posts_link(); ?></p>
							<span class="cocomment"><a href="<?php the_permalink() ?>#comments"><?php comments_number('0','1','%'); ?></a></span>
						</div>
					</div>
					<h2 class="baslik"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
					<?php 
                    $thumb = get_post_meta($post->ID, "thumbnail", true);
                    if(!empty($thumb)):    
                    ?>
                    <img src="<?php bloginfo('template_directory'); ?>/timthumb.php?src=<?php echo $thumb ?>&amp;w=536&amp;h=219&amp;zc=1&amp;cropfrom=<?php echo get_option('wpt_image_crop'); ?>" alt="<?php the_title_attribute(); ?>" class="postThumb"/>
                    <?php endif; ?>
					<p><?php limit_content(get_the_content(),500); ?></p>
					<a class="continue" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">Read More</a>
				</div>
				<?php endwhile; ?>
				<div class="navigation">
                    <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else{ ?>
        			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
        			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
                    <?php } ?>
				</div>
			<?php endif; ?>
            </div>
		</div>
<?php get_footer(); ?>