<?php
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	if ( post_password_required() ) { ?>
		<p class="wp_nocomments">This post is password protected. Enter the password to view comments.</p>
	<?php
		return;
	}
?>
<a id="comments" href="comments"></a>
<!-- You can start editing here. -->
 <div id="comment">
<?php if ( have_comments() ) : ?>
    <div id="comment_ust">
        <h4>Comments</h4>
        <span class="cocomment"><a href="<?php the_permalink() ?>#comments"><?php comments_number('0','1','%'); ?></a></span>
    </div>
    <div id="comment_list">
	<?php wp_list_comments('type=comment&callback=wp_list_comment'); ?>
    </div>
    
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="wp_nocomments">Comments are closed.</p>

	<?php endif; ?>
<?php endif; ?>


<?php if ( comments_open() ) : ?>
<div id="respond">
    <div id="comment_form">
        <div id="form_ust">
            <h3><?php comment_form_title( 'Leave a Reply', 'Leave a Reply to %s' ); ?></h3>
        </div>
        <div id="form_alt">
        <div class="cancel-comment-reply">
            <small><?php cancel_comment_reply_link(); ?></small>
        </div>       
            <?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
            <p>You must be <a href="<?php echo wp_login_url( get_permalink() ); ?>">logged in</a> to post a comment.</p>
            <?php else : ?>
                <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
                <?php if ( is_user_logged_in() ) : ?>
                    <p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>
                <?php else : ?>
                    <p><label for="author"><span class="element"><strong>Name</strong> <?php if ($req) echo "(required)"; ?></span><input type="text" name="author" value="<?php echo esc_attr($comment_author); ?>" id="author" /></label></p>
                    <p><label for="email"><span class="element"><strong>Email</strong> <?php if ($req) echo "(required)"; ?> (will not be published)</span><input value="<?php echo esc_attr($comment_author_email); ?>" type="text" name="email" id="email" /></label></p>
                    <p><label for="url"><span class="element"><strong>Website</strong></span><input value="<?php echo esc_attr($comment_author_url); ?>" type="text" name="url" id="url" /></label></p>
                <?php endif; ?>
                    <p><label for="comment"><span class="element"><strong>If you want a picture to show with your comment, go get a <a href="http://gravatar.com">Gravatar</a></strong></span><textarea id="comment" name="comment"></textarea></label></p>
                    <p><input class="formsubmit" value="Submit Comment" type="submit" /><?php comment_id_fields(); ?></p>
                    <?php do_action('comment_form', $post->ID); ?>
                </form>
            <?php endif; ?>
        </div>
    </div>
    </div>

<?php endif; // if you delete this the sky will fall on your head ?>
</div>