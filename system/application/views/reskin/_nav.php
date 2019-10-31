<!-- PAGE OVERLAY WHEN MENU ACTIVE -->
<div class="do-side-menu-overlay"></div>
<!-- PAGE OVERLAY WHEN MENU ACTIVE END -->

<div class="do-side-menu-wrap">
    <!-- OVERLAY -->
    <div class="do-dark-overlay"></div>
    <!-- OVERLAY END -->

    <nav class="do-side-menu">
        <div class="do-side-menu-widget-wrap">
            <!-- LOGO -->
            <div class="do-side-menu-logo-wrap">
                <a href="<?php echo base_url() ?>">
                    <img src="<?php echo c('assets_img_url'); ?>rainconcert_logo.jpg" width="65%" alt="Rain Concert">
                </a>
            </div>
            <!-- LOGO -->

            <!-- MENU -->
            <div class="do-side-menu-menu-wrap">
                <ul>
                    <li>
                        <a href="<?php echo base_url() . 'about-us'; ?>">About</a>
                    </li>
                    <li>
                        <a href="">Services</a>
                        <ul class="do-side-menu-menu-dropdown">
                            <li>
                                <a href="<?php echo base_url() . 'services/web-application'; ?>">Web Application</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo base_url() . 'solutions'; ?>">Solutions</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() . 'portfolio'; ?>">Portfolio</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() . 'contact'; ?>">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- MENU END -->

            <!-- SOCIAL ICONS -->
            <div class="do-side-menu-social-icon">
                <ul>
                    <li>
                        <a href="https://www.facebook.com/rainconcert" target="_blank">
                            <i class="fa fa-facebook"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com/rainconcert" target="_blank">
                            <i class="fa fa-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.linkedin.com/company/rainconcert" target="_blank">
                            <i class="fa fa-linkedin"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- SOCIAL ICONS END -->
        </div>
    </nav>
    <button class="do-side-menu-close-button" id="do-side-menu-close-button">Close Menu</button>
</div>
<!-- SIDE MENU END -->

<!--================================
HEADER
=================================-->
<header>
<!-- Navigation Menu start-->
    <nav class="navbar do-main-menu" role="navigation">
    <div class="container">

    <!-- Navbar Toggle -->
    <div class="navbar-header">

    <!-- Logo -->
    <a class="navbar-brand" href="<?php echo base_url() ?>"><img class="logo" src="<?php echo c('assets_img_url'); ?>rainconcert_logo.jpg" alt="Rain Concert Technologies"></a>

    </div>
    <!-- Navbar Toggle End -->

    <!-- navbar-collapse start-->
    <div id="nav-menu" class="navbar-collapse do-menu-wrapper collapse" role="navigation">
    <ul class="nav navbar-nav do-menus">
    <li>
    <a href="<?php echo base_url() ?>">Home</a>
    </li>
    <li <?php if ($this->uri->segment(1) == 'about-us' || $this->uri->segment(1) == 'team' || $this->uri->segment(1) == 'people' || $this->uri->segment(1) == 'whyus' || $this->uri->segment(1) == 'factsandfigures' || $this->uri->segment(1) == 'careers')
    echo 'class="active"' ?>>
    <a href="<?php echo base_url() . 'about-us'; ?>">About us</a>
    <ul class="sub-menu">
    <li>
    <a href="<?php echo base_url() . 'about-us'; ?>">Company</a>
    </li>
    <li>
    <a href="<?php echo base_url() . 'team'; ?>">Our Team</a>
    </li>
    <li>
    <a href="<?php echo base_url() . 'people'; ?>">People</a>
    </li>
    <li>
    <a href="<?php echo base_url() . 'whyus'; ?>">Why Us?</a>
    </li>
    <li>
    <a href="<?php echo base_url() . 'factsandfigures'; ?>">Facts and Figures</a>
    </li>
    <?php /*
    <li>
    <a href="<?php echo base_url().'clients';?>">Clients Speak</a>
    </li> */ ?>
    </ul>
    </li>
    <?php /* <li <?php //if($this->uri->segment(1) == 'people' || $this->uri->segment(1) == 'whyus' || $this->uri->segment(1) == 'factsandfigures' || $this->uri->segment(1) == 'careers') echo 'class="active"'?>>
    <a href="#">Company</a>
    <ul class="sub-menu">
    <li>
    <a href="about_us">About Us</a>
    </li>
    <li>
    <a href="<?php //echo base_url().'people';?>">People</a>
    </li>
    <li>
    <a href="<?php //echo base_url().'whyus';?>">Why Us?</a>
    </li>
    <li>
    <a href="<?php //echo base_url().'factsandfigures';?>">Facts and Figures</a>
    </li>
    <!-- <li>
    <a href="<?php //echo base_url().'careers';?>">Careers</a>
    </li>

    </ul>
    </li> */ ?>
    <li <?php if ($this->uri->segment(1) == 'services')
    echo 'class="active"' ?>>
    <a href="#">Services</a>
    <ul class="sub-menu">
    <li>
    <a href="<?php echo base_url() . 'services/mobile-application'; ?>">Mobile Application</a>
    </li>
    <li>
    <a href="<?php echo base_url() . 'services/web-application'; ?>">Web Application</a>
    </li>
    <li>
    <a href="<?php echo base_url() . 'services/ux-ui-design'; ?>">UX/UI Design</a>
    </li>
    <li>
    <a href="<?php echo base_url() . 'services/open-source-software'; ?>">Open Source Software</a>
    </li>
    <li>
    <a href="<?php echo base_url() . 'services/engagement-models'; ?>">Engagement Models</a>
    </li>
    <li>
    <a href="<?php echo base_url() . 'services/project-implementation'; ?>">Project Implementation Methodology</a>
    </li>

    </ul>
    </li>
    <li <?php if ($this->uri->segment(1) == 'solutions')
    echo 'class="active"' ?>>
    <a href="#">Solutions</a>
    <ul class="sub-menu">
    <li>
    <a href="<?php echo base_url() . 'solutions'; ?>">Ecommerce Solutions</a>
    </li>
    </ul>
    </li>
    <li <?php if ($this->uri->segment(1) == 'portfolio')
    echo 'class="active"' ?>>
    <a href="<?php echo base_url() . 'portfolio'; ?>">Portfolio</a>
    </li>
    <li <?php if ($this->uri->segment(1) == 'contact')
    echo 'class="active"' ?>>
    <a href="<?php echo base_url() . 'contact'; ?>">Contact</a>
    </li>
    </ul>
    </div>
    <!-- navbar-collapse end-->

    <!-- SIDE MENU BTN -->
    <div class="do-side-menu-opener">
        <button class="do-side-menu-button" id="do-side-menu-open-button"></button>
    </div>
    <!-- SIDE MENU BTN END -->

    </div>
    </nav>
<!-- Navigation Menu end-->
</header>