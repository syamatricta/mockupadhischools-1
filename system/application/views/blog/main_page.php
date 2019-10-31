
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $meta_title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <meta name="description" content="<?php echo $meta_description; ?> "/>
        <meta name="keywords" content="<?php echo $meta_keywords; ?>"/>
        <?php if ("production" != ENVIRONMENT) { ?>
            <meta name="robots" content="noindex" />
        <?php } ?>
        <link rel="canonical" href="<?php echo current_url(); ?>" />
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" >
        <link href="<?php echo base_url(); ?>style/reskin/new_blog.css" rel="stylesheet"/>
    </head>
    <body>
        <header>
            <div class="container" id="header">
                <nav class="navbar navbar-light bg-light">
                    <div class="col-md-12">
                        <div class="col-md-4 col-xs-12 col-sm-4">
                            <a href="<?php echo base_url(); ?>blog">
                                <img src="<?php echo base_url(); ?>images/Adhi-LLC-Logo.png"  width="50%" class="logo" alt="">
                            </a>
                        </div>

                        <div class="col-md-8 col-xs-12 col-sm-12 topnav">
                            <b>
                                <a class="footer_link" href=""><i class="fa fa-search"></i></a>
                                <a title="Blog" class="footer_link" href="<?php echo base_url(); ?>blog">BLOG</a>
                                <a title="Contact us" class="footer_link" href="<?php echo base_url(); ?>contact-us">CONTACT US</a>
                                <a title="About us" class="footer_link" href="<?php echo base_url(); ?>about-us">ABOUT US</a>
                                <a title="Home" class="footer_link" href="<?php echo base_url(); ?>">HOME</a>
                            </b>
                        </div>
                    </div>

                </nav>
            </div>
        </header>
        <section class="content-con-1 col-md-12">
            <div class="container">
                <h1 class="s3" style="margin : 70px 0px;">
                    AdhiSchools Blog 
                </h1>
            </div>
        </section>
        <section class="section_3" style="background-color:white;">
            <div class="container ">
                <div class="col-md-12">
                    <?php echo form_open('blog', array('name' => 'blog_form', 'id' => 'blog_form')); ?>
                        <div class="col-md-8 content">
                            <?php
                            if(!empty($blog)) { 
                                foreach($blog as $value) { 
                            ?>
                                <h6 class="head_uncat" >
                                    <?php if("" != $value->category) { ?>
                                        <a class="uncat_link" target="_blank" href="<?php echo base_url(); ?>blog/category/<?php echo str_replace(" ","-",strtolower($value->category)); ?>">
                                            <?php echo $value->category; ?>
                                        </a>
                                    <?php } else { ?>
                                        <a class="uncat_link" href="javascript:void(0);">
                                             Uncategorized
                                        </a>
                                    <?php } ?>
                                </h6>
                                <h2 class="head_single">
                                    <a class="singel_link" href="<?php echo base_url(); ?>blog/<?php echo $value->post_name; ?>" style="font-weight:bolder;font-size:25px;color:black;">
                                        <?php echo $value->post_title; ?>
                                    </a>
                                </h2>
                                <p class="para_content">
                                    <?php echo substr($value->post_content,0,strpos($value->post_content, ' ', 200) ); ?> 
                                    <a class="read" href="<?php echo base_url(); ?>blog/<?php echo $value->post_name; ?>">
                                        Read more
                                    </a> 
                                </p>
                                <div>
                                    By 
                                    <a class="admin_link" href="<?php echo base_url(); ?>blog"><b>admin</b></a>,
                                    <a class="time" href=""> <?php echo date("F d, Y", strtotime($value->date)); ?></a>
                                </div>
                            <?php
                                }
                            }
                            ?>
                        </div>

                        <div class="col-md-4 content_1">
                            <h5 class="recent">Recent Posts</h5>
                            <?php if(!empty($recent)) { 
                                foreach($recent as $each){
                            ?>
                                <p class="recent_post">
                                    <a class="recent_link" href="<?php echo base_url(); ?>blog/<?php echo $each->post_name; ?>">
                                        <?php echo $each->post_title; ?>
                                    </a>
                                </p>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    <?php echo form_close(); ?>
                </div>

                <div class="col-md-8 page_link text-center">
                    <b>
                        <div class="pagination"><?php echo $paginate; ?></div>
                        <div style="clear:both">&nbsp;</div>
                    </b>
                </div>

            </div>
        </section>
  <a href="#header" id="return-to-top"><i class="fa fa-angle-double-up"></i></a>
        <footer>
            <section class="blog_foot">
                <div class="container">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-9 footer_content_1">
                                <div class="col-md-2 col-sm-3 col-xs-3">  
                                    <a class="footer_link" href="<?php echo base_url(); ?>">HOME</a>
                                </div>
                                <div class="col-md-2 col-sm-3 col-xs-3">  
                                    <a class="footer_link" href="<?php echo base_url(); ?>about-us">ABOUT US </a>
                                </div>
                                <div class="col-md-2 col-sm-3 col-xs-3">  
                                    <a class="footer_link" href="<?php echo base_url();?>contact-us">CONTACT US</a>
                                </div>
                                <div class="col-md-2 col-sm-3 col-xs-3">  
                                    <a class="footer_link" href="<?php echo base_url(); ?>blog"> BLOG</a>
                                </div>
                            </div>
                            <div class="col-md-3 footer_content">
                                Copyright © <?php echo date('Y'); ?> 
                                <a class="footer_link" href="<?php echo base_url(); ?>">Adhischools.com</a>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

        </footer>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    
        <script type="text/javascript">
        $(window).scroll(function () {
            if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
                $('#return-to-top').fadeIn(200);    // Fade in the arrow
            } else {
                $('#return-to-top').fadeOut(200);   // Else fade out the arrow
            }
        });
        $('#return-to-top').click(function () {      // When arrow is clicked
            $('body,html').animate({
                scrollTop: 0                       // Scroll to top of body
            }, 500);
        });
        function paginate(a) {
            $("#blog_form").attr("action",a);
            $("#blog_form").submit();
        }
        </script>
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

