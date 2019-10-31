<?php
    //Widget
    if (function_exists('register_sidebar')){	
        register_sidebar(array(
        'name' => 'Sidebar',
        'before_title' => '<h3>',
        'after_title' => '</h3><hr />',
        'before_widget' => '<div class="row">',
        'after_widget' => '</div>'
        ));
        
        register_sidebar(array(
        'name' => 'Footer',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
        'before_widget' => '<div class="frow">',
        'after_widget' => '</div>'
        ));
    }



    //Limit Content
    function limit_content($content, $ilimit = false){
        $limit = ($ilimit) ? $ilimit : 270;
        $last = "...";
        $content = strip_tags($content);
        if(strlen($content) > $limit){
            $content = substr($content,0,$limit);
        }
        echo $content.$last;
    }
    
    // Fetured Widget
    class Featured extends WP_Widget {
        function Featured() {
            parent::WP_Widget(false, $name = 'whitePress Featured');	
        }
    
        function widget($args, $instance) {		
            extract( $args );
            global $post;
            $fkat = get_option('wpt_featured_cat');
            $ckat = get_option('wpt_featured_snumber');
            query_posts('category_name='.$fkat.'&showposts='.$ckat);
            $title = apply_filters('widget_title', $instance['title']);
            ?>
            <?php echo $before_widget; ?>
            <?php if ($title) echo $before_title . $title . $after_title; ?>
			<ul class="sideFeatured">
        <?php
        if ( have_posts() ) : while ( have_posts() ) : the_post();
            $thumb = get_post_meta($post->ID, "thumbnail", true);
            if(!empty($thumb)): 
        ?>
        <!-- Featured // -->
			<li>
                <div class="smfeatured">Featured</div>
                <img src="<?php bloginfo('template_directory'); ?>/timthumb.php?src=<?php echo $thumb ?>&amp;w=279&amp;h=113&amp;zc=1&cropfrom=<?php echo get_option('wpt_image_crop'); ?>" alt="<?php the_title_attribute(); ?>" class="sfeatured"/>
				<h4><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
				<p><?php limit_content(get_the_content(),300); ?></p>
			</li>
        <!-- // Featured -->
        <?php
            endif;
        endwhile;
        endif;
        ?>
			</ul>
            <?php echo $after_widget; ?>
        <?php
        wp_reset_query();
        }
            
        function update($new_instance, $old_instance) {				
            return $new_instance;
        }
    
        function form($instance) {		
            $title = esc_attr( ($instance['title']) ? $instance['title'] : "Featured" );
            ?>
                <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php echo "Title"; ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            <?php 
        }       
    }

    // About Me Widget
    class About_Me extends WP_Widget {
        function About_Me() {
            parent::WP_Widget(false, $name = 'whitePress About Me');	
        }
    
        function widget($args, $instance) {		
            extract( $args );
            $title = apply_filters('widget_title', $instance['title']);
            ?>
            <?php echo $before_widget; ?>
            <?php if ($title)
                echo $before_title . $title . $after_title; ?>
            <img class="avatar" src="<?php echo get_option('wpt_about_image'); ?>" alt="Avatar" /><p><?php echo get_option('wpt_about_text'); ?></p>    
            <?php echo $after_widget; ?>
        <?php
        }
            
        function update($new_instance, $old_instance) {				
            return $new_instance;
        }
    
        function form($instance) {				
            $title = esc_attr( ($instance['title']) ? $instance['title'] : "About Me" );
            ?>
                <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php echo "Title"; ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            <?php 
        }       
    }
    
    // Sponsor Widget
    class Sponsors extends WP_Widget {
        function Sponsors() {
            parent::WP_Widget(false, $name = 'whitePress Sponsors');	
        }
    
        function widget($args, $instance) {		
            extract( $args );
            $title = apply_filters('widget_title', $instance['title']);
            ?>
            <?php echo $before_widget; ?>
            <?php if ($title) echo $before_title . $title . $after_title; ?>
			<ul class="sponsor">
                <?php for($i=1; $i<5; $i++){
                if(get_option('wpt_link'.$i.'_url') == "" || get_option('wpt_link'.$i.'_image' == "")){continue;}
                ?>
				<li><a href="<?php echo get_option('wpt_link'.$i.'_image'); ?>"><img src="<?php echo get_option('wpt_link'.$i.'_url'); ?>" alt="Sponsor" /></a></li>
                <?php }?>
			</ul>                
            <?php echo $after_widget; ?>
        <?php
        }
            
        function update($new_instance, $old_instance) {				
            return $new_instance;
        }
    
        function form($instance) {				
            $title = esc_attr( ($instance['title']) ? $instance['title'] : "Sponsors" );
            ?>
                <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php echo "Title"; ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            <?php 
        }       
    }
    
    // Categories Widget
    class Categories extends WP_Widget {
        function Categories() {
            parent::WP_Widget(false, $name = 'whitePress Categories');	
        }
    
        function widget($args, $instance) {		
            extract( $args );
            $title = apply_filters('widget_title', $instance['title']);
            ?>
            <?php echo $before_widget; ?>
            <?php if ($title) echo $before_title . $title . $after_title; ?>
    		<ul class="categories">

    			<?php wp_list_categories('sort_column=menu_order&exclude='.get_option('wpt_cat_ex').'&title_li='); ?>

    		</ul>               
            <?php echo $after_widget; ?>
        <?php
        }
            
        function update($new_instance, $old_instance) {				
            return $new_instance;
        }
    
        function form($instance) {				
            $title = esc_attr( ($instance['title']) ? $instance['title'] : "Categories" );
            ?>
                <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php echo "Title"; ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            <?php 
        }       
    }    
        
    //Add first image to thumbnail custom
    function thumb_custom_add($post_ID){
        $id = $post_ID;
        $custom = "thumbnail";
        $var = get_post_meta($id, $custom, true);
        if($var == ''):
            $file =& get_children(array('post_parent' => $id, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'ID'));
            if($file != ''):
                $first = array_shift($file);
            endif;
            $last = wp_get_attachment_image_src($first->ID,'full');
            $url = $last[0];
            if($url != ''):
                add_post_meta($id, $custom, $url, true);
            endif;            
        endif;
    } 
    
    //Twitter counter
    function get_twitter($username){
    	$last = intval(get_option('wpt_tlupdate'));
    	$now = time();
    	if(($now - $last) > (60*60*24)) :
            $twit = file_get_contents('http://twitter.com/users/show/'.$username.'.xml');
            $begin = '<followers_count>'; $end = '</followers_count>';
            $page = $twit;
            $parts = explode($begin,$page);
            $page = $parts[1];
            $parts = explode($end,$page);
            $tcount = $parts[0];
            if($tcount == '') { $tcount = '0'; }
    		update_option("wpt_twitter_count", $tcount);    
    		update_option("wpt_tlupdate", $now);
            return $tcount;
        else:
            return get_option("wpt_twitter_count");
        endif;
    }
    
    //Feedburner Counter
    function get_feedburner($username){
    	$last_update = intval(get_option('wpt_lupdate'));
    	$now = time();
    	if(($now - $last_update) > (60*60*24)) :   		
    		$whaturl="https://feedburner.google.com/api/awareness/1.0/GetFeedData?uri=$username";
    		$ch = curl_init();
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    		curl_setopt($ch, CURLOPT_URL, $whaturl);
    		$data = curl_exec($ch);
    		curl_close($ch);
    		$xml = new SimpleXMLElement($data);
    		$fb = $xml->feed->entry['circulation'];
    		if(!$fb) :
    			$fb = 0;
    		endif;
    		update_option("wpt_feed_count", $fb."");    
    		update_option("wpt_lupdate", $now."");
            return $fb;
        else:
            return get_option("wpt_feed_count");
    	endif;
    }

    //Comment template callback
    function wp_list_comment($comment, $args, $depth)
    {
    	$GLOBALS['comment'] = $comment; 
    ?>
        <div <?php comment_class('wp_list'); ?> id="li-comment-<?php comment_ID() ?>">
            <div class="colist_left">
                <div class="colist_leftu">
                    <?php echo get_avatar($comment,$size='60',$default=''. get_bloginfo('stylesheet_directory') .'/images/gravatar.png'); ?>
                </div>
                <div class="colist_lefta">
					<span class="gun"><?php echo get_comment_date('j'); ?></span>
					<span class="month"><?php echo get_comment_date('M'); ?></span>
					<span class="year"><?php echo get_comment_date('Y'); ?></span>
                </div>
            </div>
            <div class="colist_right">
                <p>
                <?php if ($comment->comment_approved == '0') : ?>
                    <strong><?php echo "Your comment is awaiting moderation."; ?></strong><br /><br />
                <?php endif; ?>
                <span class="say"><a href="#"><?php comment_author_link(); ?></a> says;</span>
                    <?php comment_text() ?>
                </p>
				<?php
					comment_reply_link(array_merge($args, array(
						'reply_text'	=>	'Reply',
						'depth' => $depth,
						'max_depth' => $args['max_depth']
					)));
				?>
            </div>
        </div>
        <div id="comment-<?php comment_ID(); ?>"></div>
    <?php
    }
    
    //Admin theme
    require_once("library/adminOptions.php");
    require_once("library/adminTheme.php");
    
    add_action('widgets_init', create_function('', 'return register_widget("About_Me");'));
    add_action('widgets_init', create_function('', 'return register_widget("Sponsors");'));
    add_action('widgets_init', create_function('', 'return register_widget("Categories");'));
    add_action('widgets_init', create_function('', 'return register_widget("Featured");'));
    add_action('publish_post', 'thumb_custom_add');
?>