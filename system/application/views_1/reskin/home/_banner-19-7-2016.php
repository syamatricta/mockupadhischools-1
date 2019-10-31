<header id="myCarousel" class="carousel slide"  data-ride="carousel" data-interval="false" data-keyboard="true">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
        <li data-target="#myCarousel" data-slide-to="4"></li>

    </ol>

    <!-- Wrapper for Slides -->
    <!-- Slide 1 -->
    <div class="carousel-inner homebanner">
        <div class="item most-comprehensive active">
            <div class="fill" style="background-image:url('<?php echo $this->config->item('image_url');?>banners/comprehensive.jpg');"></div>
            <div class="carousel-caption">
                <div class="container">
                    <div class="banner-content">
                        <div class="row btext margin40">
                            <div class="col-md-9 col-xs-12">
                                <h1>California's most <span>comprehensive real estate</span><span> education</span></h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <a href="<?php echo base_url();?>california-real-estate-classes" class="banner-btn btn_margin ml5">Learn more</a>
                                <a href="<?php echo base_url();?>user/register" class="banner-btn btn-b-blue">Enroll Now</a>
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-xs-12 bphone"><i class="fa fa-phone"></i> 888-768-5285
                        	</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 2 -->
        <div class="item history-of-excellence">
            <div class="fill" style="background-image:url('<?php echo $this->config->item('image_url');?>banners/history-of-excellence.jpg');"></div>
            <div class="carousel-caption">
                <div class="container ">
                    <div class="banner-content">
                        <div class="row btext margin40">
                            <div class="col-sm-10 col-xs-12">
                                <h1>History <span>of</span><br/><span>Excellence</span></h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <a href="<?php echo base_url();?>best-real-estate-school" class="banner-btn btn_margin ml5">Learn more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 3 -->
        <div class="item pass-your-exam">
            <div class="fill" style="background-image:url('<?php echo $this->config->item('image_url');?>banners/pass-your-exam.jpg');"></div>
            <div class="carousel-caption">
                <div class="container">
                    <div class="banner-content">
                        <div class="row btext margin40">
                            <div class="col-md-10 col-xs-12">
                                <h1>Pass Your<br/>Real Estate Exam<span> With California's No1 Prep Course!</span></h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <a href="http://www.crashcourseonline.com" class="banner-btn btn_margin ml5" style="text-transform: lowercase">crashcourseonline.com</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 4 -->
        <div class="item exam-prepare-app">
            <div class="fill" style="background-image:url('<?php echo $this->config->item('image_url');?>banners/exam-prepare-app.jpg');"></div>
            <div class="carousel-caption">
                <div class="container">
                    <div class="banner-content">
                        <div class="row btext margin40">
                            <div class="col-sm-10 col-xs-12">
                                <h1>Our Exam Prep App <br/><span>years ahead of the competition</span></h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <a href="<?php echo base_url();?>real-estate-exam-app" class="banner-btn btn_margin ml5">Learn more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slide 5 -->
        <div class="item endorsed-program">
            <div class="fill" style="background-image:url('<?php echo $this->config->item('image_url');?>banners/endorsed-program.jpg');"></div>
            <div class="carousel-caption">
                <div class="container">
                    <div class="banner-content">
                        <div class="row btext margin40">
                            <div class="col-md-7 col-xs-12">
                                <h1>The most widely endorsed real estate program in California.<br/>
                                <span >
                                  Our school has more class options to choose from and we're in more real estate offices than any other.
                                </span>
                                </h1>
                            </div>
                            <div class="col-md-5  hidden-xs hidden-sm">
                                <img class="img-responsive pull-right" src="<?php echo $this->config->item('images').'reskin/companies-logo.png'?>"  >
                            </div>
                        </div>
                    </div>	        
                </div>
            </div>  
        </div>
        
       
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev" role="button">
        <span class="custom-nav left-prev"></span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next" role="button"> 
        <span class="custom-nav right-next"></span>
    </a>
</header>