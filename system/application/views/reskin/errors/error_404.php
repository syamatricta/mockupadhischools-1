<?php page_heading('Page not found' , 'banner-inner');?>
<div class="container error-page-wrapper">
    <div class="divide80"></div>
    <div class="row margin50">
        <div class="col-sm-12 text-center margin10">
            <img src="<?php echo $this->config->item('images').'reskin/errors/404.png'?>" />
        </div>
        <!--<div class="col-sm-12 text-center margin30">
            <h2 class="margin10">THIS PAGE NOT BE FOUND</h2>
            <p>We are really sorry, but the page you requested is missing.</p>
        </div>-->
        <di class="col-sm-6 col-sm-offset-3 text-center ">
            <h2 class="margin10">Whoops - There’s nothing here</h2>
            <h4 class="bold-cont text-center ">Are you looking for:</h4>
            <div class="row">
                <di class="col-xs-6 text-right">
                    <ul class="nopad list-unstyled">
                        <li><a href="<?php echo base_url();?>user/register">Register <i class="fa fa-star"></i></a></li>
                        <li><a href="#" class="login-popup">Login <i class="fa fa-star"></i></a></li>
                        <li><a href="<?php echo base_url();?>about-us">About Us <i class="fa fa-star"></i></a></li>
                        <li><a href="<?php echo base_url();?>contact-us" >Contact Us <i class="fa fa-star"></i></a></li>
                        <?php if(!$this->authentication->logged_in("normal") || ( $this->authentication->logged_in("normal") && 'Online' != $this->session->userdata('COURSE_TYPE'))){ ?>
                        <li><a href="<?php echo base_url();?>find-real-estate-classes" >Find a Class <i class="fa fa-star"></i></a></li>
                        <?php }?>
                        
                    </ul>
                </di>
                <di class="col-xs-6 text-left">
                    <ul class="nopad  list-unstyled">
                        <li><a href="<?php echo base_url();?>careers"><i class="fa fa-star"></i> Careers</a></li>
                        <li><a href="<?php echo base_url();?>testimonials"><i class="fa fa-star"></i> Testimonials</a></li>
                        <li><a href="<?php echo base_url();?>faq"><i class="fa fa-star"></i> Got Questions</a></li>
                        <li><a href="<?php echo base_url();?>sitemap"><i class="fa fa-star"></i> Sitemap</a></li>            
                    </ul>
                </di>
            </div>
            <h4 class="bold-cont text-center" style="margin-top: 15px;">Love, ADHI Schools</h4>
        </di>
    </div>
</div>