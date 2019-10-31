<div class="container">
    <div class="star-heading">
            <i class="fa fa-star fa1 wow fadeInUp"></i>
            <i class="fa fa-star fa2 wow fadeInUp"></i>
            <i class="fa fa-star fa1 wow fadeInUp"></i>
            <h2 class="wow fadeInUp">OUR BLOG</h2>
            <hr class="wow fadeInUp" />
    </div>
    <p class="text-right loc-cnt wow fadeInUp"><a class="loc" href="http://adhischools.com/blog">View all Blogs &nbsp;<i class="fa fa-arrow-right"></i> </a></p>
    <div id="blog_view" class="owl-carousel">  
            <?php $i = 0;
            $image_path = $this->config->item('image_upload_url');
            foreach($blog as $post):
                $i++;
                //$full_image = $this->config->item('images').'blog-default.jpg'; 
            ?>

                <div class="item  wow fadeInUp" data-wow-delay="<?php echo $i*.2;?>s" data-url="<?php echo $post['url']?>">

                    <div class="">
                        <?php
                        /*
                        <a href="<?php echo $post['url']?>" title="<?php echo $post['slug']?>">
                            <img class="img-responsive" src="<?php echo base_url()?>timthumb.php?src=<?php echo $full_image ; ?>&w=270&q=100&h=192"  alt=""/>
                        </a>
                        */
                        ?>
                        <h4 class="blog-name">
                            <?php echo $post['title']?>
                        </h4>   

                        <div class="blog-details">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="col-xs-12 shortdesc"><?php  
                                    //$text =strip_tags($post['excerpt']);
                                    $text = strip_tags($post['content']);
                                    if(strlen($text) > 500) {
                                        $text = preg_replace("/^(.{1,500})(\s.*|$)/s", '\\1 ...', $text);
                                    }
                                    echo $text;?></div>
                                </div>
                            </div>
                            <div class="row ">		              					
                                <div class="col-sm-12">
                                    <div class="blogcomt">
                                        <div class="col-xs-6 f13i date nopad"><i class="fa fa-calendar-o"></i> <?php echo date("M j, Y",strtotime($post['date']) )?></div>
                                        <div class="col-xs-6 f13i "><i class="fa fa-comment-o"></i><?php echo $post['comment_count']?>&nbsp;Comment</div>
                                    </div>          					 		
                                </div>		                   				
                            </div>
                        </div>
                </div>
            </div>

        <?php endforeach;?>
        <?php
                        /*
        <div class="item  wow fadeInUp"  data-wow-delay="10s">
            <a href="http://www.adhischools.com/blog/">
                <img class="img-responsive" src="<?php echo $this->config->item('image_url');?>viewall.jpg"  alt=""/>
            </a>
        </div>
                         */
        ?>
    </div>

 </div>