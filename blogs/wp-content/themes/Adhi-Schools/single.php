<?php
	get_header();
?>
		<div id="wpContent">
<?php get_sidebar(); ?>
			<div id="content">
			<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<div class="post" id="post-<?php the_ID(); ?>">
					<div class="postUst">
						<div class="postTarih">
							<span class="gun"><?php the_time('d') ?></span>
							<span class="month"><?php the_time('M') ?></span>
							<span class="year"><?php the_time('Y') ?></span>
						</div>
						<div class="postAyrinti">
							<p><?php the_category(', ') ?> | by <?php the_author_posts_link(); ?></p>
						</div>
					</div>
					<h2 class="baslik"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
					<?php 
                    $thumb = get_post_meta($post->ID, "thumbnail", true);
                    if(!empty($thumb)):    
                    ?>
                    <img src="<?php bloginfo('template_directory'); ?>/timthumb.php?src=<?php echo $thumb ?>&w=536&h=219&zc=1&cropfrom=<?php echo get_option('wpt_image_crop'); ?>" alt="<?php the_title_attribute(); ?>" class="postThumb"/>
                    <?php endif; ?>
					<p><?php the_content() ?></p>
                    <p><?php the_tags('<span id="tag">',', ','</span>'); ?></p>
				</div>
				<?php endwhile; ?>
                <?php endif; ?>
            </div>
            <?php comments_template(); ?>
		</div>
        
<?php get_footer(); ?>