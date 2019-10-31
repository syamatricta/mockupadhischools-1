
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $meta_title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <meta name="description" content="<?php echo $meta_description; ?> "/>
        <meta name="keywords" content="<?php echo $meta_keywords; ?>" />
        <link rel="canonical" href="<?php echo current_url(); ?>" />
        <?php if ("production" != ENVIRONMENT) { ?>
            <meta name="robots" content="noindex" />
        <?php } ?>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" >
        <link href="<?php echo base_url(); ?>style/reskin/new_blog.css" rel="stylesheet"/>
    </head>
    <body>
        <header>
            <div class="container">
                <nav class="navbar navbar-light bg-light">
                    <div class="col-md-12">
                        <div class="col-md-4 col-xs-12 col-sm-4">
                            <a href="<?php echo base_url(); ?>blog">
                                <img src="<?php echo base_url(); ?>images/Adhi-LLC-Logo.png"  width="40%" class="logo" alt="">
                            </a>
                        </div>

                        <div class="col-md-8 col-xs-12 col-sm-12 topnav">
                            <b>
                                <a href=""><i class="fa fa-search"></i></a>
                                <a  href="<?php echo base_url(); ?>blog">BLOG</a>
                                <a href="<?php echo base_url(); ?>contact-us">CONTACT US</a>
                                <a href="<?php echo base_url(); ?>about-us">ABOUT US</a>
                                <a href="<?php echo base_url(); ?>">HOME</a>
                            </b>
                        </div>
                    </div>

                </nav>
            </div>
        </header>
        <section class="content-con-1 col-md-12">
            <div class="container">
                <h1 class="s3">
                    <?php echo $blog->post_title; ?>
                </h1>
                <p class="s4">Published by <b><a class="admin" href="<?php echo base_url(); ?>/blog/author/admin/">admin</a></b> on September 7, 2019</p>
            </div>
        </section>
        <section>
            <div class="container">

                <div class="col-md-12">
                    <div class="col-md-8">
                        <p class="p3 text-justify"><?php echo $blog->post_content; ?></p>
                    </div>
                    <div class="col-md-4">
                        <h5 class="recent">Recent Posts</h5>

                        <?php 
                            if(!empty($recent)){ 
                                foreach($recent as $each){
                        ?>
                            <p class="recent_post">
                                <a href="<?php echo base_url(); ?>blog/<?php echo $each->post_name; ?>" target="_blank">
                                   <?php echo $each->post_title; ?> 
                                </a>
                            </p>
                        <?php
                                }
                            }
                        ?>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="col-md-6 cate">
                        Categories: 
                        <?php if("" != $blog->category){ ?>
                            <a class="link category" href="<?php echo base_url(); ?>blog/category/<?php echo str_replace(" ","-",strtolower($blog->category)); ?>"><?php echo $blog->category; ?></a>
                        <?php }else { ?>
                            <a class="link category" href="#">Uncategorized</a>
                        <?php } ?>
                    </div>

                    <div class="col-md-4 col-sm-6 cate_1">
                        <div class="rounded-social-buttons">
                            <a class="social-button facebook" href="#"></a>
                            <a class="social-button twitter" href="#"></a>
                        </div>
                    </div>
                </div>
                <?php /*<div class="col-md-12">
                    <div class="col-md-8">
                        <h3 class="leave text-center">Leave a Reply</h3>
                        <div class="row">
                            <div class="col-md-4  col-xs-12 form-group ">
                                <input class="post_form" type="text" placeholder="Name *" name="name">
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                <input type="email" class="post_form" placeholder="Email *" name="email">
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                <input type="text" class="post_form" placeholder="Website" name="website">
                            </div>
                        </div> <!-- /.row -->
                        <div class="form-group">
                            <textarea  class="post_form_text"  placeholder="What's on your mind?"  name="what's on your mind?"></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn post_button">POST COMMENT</button>
                        </div>
                    </div>
                </div>*/ ?>
            </div>
        </section>
        <?php if(!empty($related)){ ?>
            <section class="content-con-2">
                <div class="container rela_post">
                    <h2 class="Related_head text-center">Related Posts</h2>
                    <div class="col-md-12">
                        <?php
                            foreach($related as $relate){
                        ?>
                            <div class="col-md-4 col-sm-4 col-xs-12 related_post_1">
                                <a href="<?php echo base_url(); ?>blog/category/<?php echo str_replace(" ","-",strtolower($relate->category)); ?>" target="_blank"><h6 class="uncat categoryF"><?php echo $relate->category; ?></h6></a>
                                <h4 class="single"> 
                                    <a href="<?php echo base_url(); ?>blog/<?php echo $relate->post_name; ?>" target="_blank">
                                        <?php echo $relate->post_title; ?>
                                    </a>
                                </h4>
                                <p class="rela_para">
                                    <?php echo substr($relate->post_content,0,strpos($relate->post_content, ' ', 200) ); ?> 
                                    <br/><br/>
                                    <a class="text-right" href="<?php echo base_url(); ?>blog/<?php echo $relate->post_name; ?>" target="_blank">
                                        Read more...
                                    </a>
                                </p>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </section>
        <?php } ?>
        <footer>
            <section class="blog_foot">
                <div class="container">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-9 footer_content_1">
                                <div class="col-md-2 col-sm-3 col-xs-3">
                                    <a href="<?php echo base_url(); ?>">HOME</a>
                                </div>
                                <div class="col-md-2 col-sm-3 col-xs-3">
                                    <a href="<?php echo base_url(); ?>about-us">ABOUT US</a>
                                </div>
                                <div class="col-md-2 col-sm-3 col-xs-3">
                                    <a href="<?php echo base_url(); ?>contact-us">CONTACT US</a>
                                </div>
                                <div class="col-md-2 col-sm-3 col-xs-3">
                                   <a href="<?php echo base_url(); ?>blog"> BLOG</a>
                                </div>
                            </div>
                            <div class="col-md-3 footer_content">
                                Copyright © <?php echo date('Y'); ?> Adhischools.com
                            </div>
                        </div>
                    </div>

                </div>
            </section>

        </footer>
        <script type='text/javascript'>
            window.__lo_site_id = 164872;
            (function() {

                var wa = document.createElement('script'); wa.type = 'text/javascript'; wa.async = true;

                wa.src = 'https://d10lpsik1i8c69.cloudfront.net/w.js';

                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(wa, s);

              })();
        </script>
    </body>
</html>