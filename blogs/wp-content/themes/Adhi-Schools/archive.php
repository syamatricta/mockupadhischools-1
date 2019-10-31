<?php
	get_header();
?>
		<div id="wpContent">
			<div class="featured">Featured</div>
			<div id="wpFeatured">
             <?php 
                $count = 0;
                $fkat = get_option('wpt_featured_cat');
                $ckat = get_option('wpt_featured_number');
                $my_query = new WP_Query('category_name='.$fkat.'&showposts='.$ckat);
                while ($my_query->have_posts()) : $my_query->the_post();
             ?>
            <?php 
            $thumb = get_post_meta($post->ID, "thumbnail", true);
            if(!empty($thumb)):    
            ?>
				<div class="slides"  id="Tab<?php echo $count; ?>">
					<a href="<?php the_permalink() ?>"><img src="<?php bloginfo('template_directory'); ?>/timthumb.php?src=<?php echo $thumb ?>&amp;w=851&amp;h=255&amp;zc=1" alt="<?php the_title_attribute(); ?>" /></a>
				</div>
            <?php
            else:
                continue;
            endif;
            $count++; endwhile;
            ?>
            </div>
			<ul class="fnav">
                <?php for($i=0;$i<$count;$i++){ ?>
				<li><a class="navli" href="#Tab<?php echo $i; ?>" rel="<?php echo $i; ?>"><?php echo $i+1; ?></a></li>
                <?php } ?>
			</ul>
<?php get_sidebar(); ?>
			<div id="content">
			<?php if (have_posts()) : ?>
         	  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
         	  <?php /* If this is a category archive */ if (is_category()) { ?>
        		<h2 class="pagetitle">Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h2>
         	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
        		<h2 class="pagetitle">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
         	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
        		<h2 class="pagetitle">Archive for <?php the_time('F jS, Y'); ?></h2>
         	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
        		<h2 class="pagetitle">Archive for <?php the_time('F, Y'); ?></h2>
         	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
        		<h2 class="pagetitle">Archive for <?php the_time('Y'); ?></h2>
        	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
        		<h2 class="pagetitle">Author Archive</h2>
         	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
        		<h2 class="pagetitle">Blog Archives</h2>
         	  <?php } ?>
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
							<span class="cocomment"><a href="<?php the_permalink() ?>#comments"><?php comments_number(__('0'), __('1'), __('%')); ?></a></span>
						</div>
					</div>
					<h2 class="baslik"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
					<?php 
                    $thumb = get_post_meta($post->ID, "thumbnail", true);
                    if(!empty($thumb)):    
                    ?>
                    <img src="<?php bloginfo('template_directory'); ?>/timthumb.php?src=<?php echo $thumb ?>&amp;w=536&amp;h=219&amp;zc=1" alt="<?php the_title_attribute(); ?>" class="postThumb"/>
                    <?php endif; ?>
					<p><?php limit_content(get_the_content(),500); ?></p>
					<a class="continue" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">Read More</a>
				</div>
				<?php endwhile; ?>
				<div class="navigation">
                    <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
				</div>
            <?php else:
		if ( is_category() ) { // If this is a category archive
			printf("<h2 class='center'>Sorry, but there aren't any posts in the %s category yet.</h2>", single_cat_title('',false));
		} else if ( is_date() ) { // If this is a date archive
			echo("<h2>Sorry, but there aren't any posts with this date.</h2>");
		} else if ( is_author() ) { // If this is a category archive
			$userdata = get_userdatabylogin(get_query_var('author_name'));
			printf("<h2 class='center'>Sorry, but there aren't any posts by %s yet.</h2>", $userdata->display_name);
		} else {
			echo("<h2 class='center'>No posts found.</h2>");
		}
		get_search_form();
        ?>
			<?php endif; ?>
            </div>
		</div>
<?php get_footer(); ?>