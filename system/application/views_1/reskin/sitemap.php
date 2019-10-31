<?php page_heading('Sitemap', '');?>
<section class="page-content">
    <div class="container">
        <div class="col-sm-12">
            <ul class="list-unstyled sitemap-list">
                <li><a href="<?php echo base_url();?>" title="Real Estate Classes Los Angeles" class="sitemap_s"><i class="fa fa-angle-double-right"></i> Home</a></li>
                <li><a href="<?php echo base_url();?>about-us" class="sitemap_s" title="Real Estate Broker"><i class="fa fa-angle-double-right"></i> About Us</a></li>			            
                <li><a href="<?php echo base_url();?>our-terms-of-use" class="sitemap_s" title="Real Estate Broker License"><i class="fa fa-angle-double-right"></i> Terms of Use</a></li>
                <li><a href="<?php echo base_url();?>our-privacy-policy" class="sitemap_s" title="California Real Estate Examination"><i class="fa fa-angle-double-right"></i> Privacy Policy</a></li>
                <li><a href="<?php echo base_url();?>blog/weekend-class-4252009-crash-course/" rel="nofollow" class="sitemap_s" title="Real Estate Crash Course"><i class="fa fa-angle-double-right"></i> Weekend  Class 4/25/2009 Crash Course </a></li>
                <li><a href="<?php echo base_url();?>blog/" rel="nofollow" class="sitemap_s" title="California Real Estate License"><i class="fa fa-angle-double-right"></i> Our  Blog</a></li>
                <li><a href="<?php echo base_url();?>user/register" class="sitemap_s" title="California Real Estate Examination"><i class="fa fa-angle-double-right"></i> Our  Registration Form</a></li>
                <li><a href="<?php echo base_url();?>testimonials" class="sitemap_s" title="California Real Estate Exam"><i class="fa fa-angle-double-right"></i> Our  Client Testimonials</a></li>
                <?php if(!$this->authentication->logged_in("normal") || ( $this->authentication->logged_in("normal") && 'Online' != $this->session->userdata('COURSE_TYPE'))){ ?>
                    <li><a href="<?php echo base_url();?>schedule" rel="nofollow" class="sitemap_s" title="Real Estate License Classes"><i class="fa fa-angle-double-right"></i> Our  Schedules and Locations</a></li>
                <?php }?>                
                <li><a href="<?php echo base_url();?>got-question" class="sitemap_s" title="California Real Estate License"><i class="fa fa-angle-double-right"></i> Got  Questions</a></li>
                <li><a href="<?php echo base_url();?>contact-us" class="sitemap_s" title="Real Estate Broker"><i class="fa fa-angle-double-right"></i> Contact Us</a></li>
            </ul>
        </div>
    </div>
</section>
