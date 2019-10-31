<?php foreach ($blog_posts_rss as $blog_post){ ?>
    <div class="blog_img_cntnr">
        <img  src="<?php echo $this->config->item('images'); ?>blog-default.jpg" title="Blog" alt="Blog" width="195" height="264" />
        <div class="blog_post_date_cntnr">
            <span class="post_gun"><?php echo date('d', strtotime($blog_post['pubDate'])); ?></span>
            <span class="post_month"><?php echo date('M', strtotime($blog_post['pubDate'])); ?></span>
            <span class="post_year"><?php echo date('Y', strtotime($blog_post['pubDate'])); ?></span>
        </div>
    </div>
    <div class="blog_cntnt_cntnr">
        <div class="blog_cntnt_head">
            <?php //echo htmlentities(cutText($blog_post['title'], 45)); ?>
            <?php echo cutText($blog_post['title'], 45); ?>
        </div>
        <div class="blog_cntnt_txts">
            <?php //echo htmlentities(cutText($blog_post['description'], 240)); ?>
            <?php echo cutText($blog_post['description'], 240); ?>
        </div>
        <div class="learn_more_cntnr">
            <a href="<?php echo $blog_post['link']; ?>" target="_blank" rel="nofollow"><span class="learn_more_button"></span></a>
        </div>
    </div>
<?php } ?>