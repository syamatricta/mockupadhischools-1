<?php 
$title		=	(isset($title) && !empty($title)) ? $title : "California Real Estate School - Online & Live Classes | ADHI Schools";
if ("home" == $this->router->fetch_class() && "new_about" == $this->router->fetch_method()) { ?>
    <meta name="description" content="Learn about the history of ADHI Schools and how it's founder, Kartik Subramaniam, came up with this revolutionary approach to real estate education."  />
    <title>About Us | ADHI Schools</title>
<?php } 

else if("home" == $this->router->fetch_class() && "index" == $this->router->fetch_method()) {
    ?>
    <meta name="description" content="ADHI Schools is a real estate license school offering California students both live and online classes. Enroll in a free trial and start your real estate exam prep today!"  />
    <title>California Real Estate School - Online & Live Classes | ADHI Schools</title>
<?php }

else if("career_event" == $this->router->fetch_class() && "index" == $this->router->fetch_method()) {
    ?>
    <meta name="description" content="Find a real estate career event near you and discover how you can start your new career as a real estate agent or broker."  />
    <title>Real Estate Career Events in California | ADHI Schools</title>
<?php } 

else if("home" == $this->router->fetch_class() && "contactus" == $this->router->fetch_method()) {
    ?>
    <meta name="description" content="For questions regarding our class curriculum, available classes or real estate career questions, please fill out this form or call us at 888-768-5285."  />
    <title>Contact Us - (888) 768-5285 | ADHI Schools</title>
<?php } 


else if("home" == $this->router->fetch_class() && "faq" == $this->router->fetch_method()) {
    ?>
    <meta name="description" content="Get answers to student's most frequently asked questions about ADHI Schools."  />
    <title>Frequently Asked Questions | ADHI Schools</title>
<?php }

else if("home" == $this->router->fetch_class() && "termsofuse" == $this->router->fetch_method()) {
    ?>
    <meta name="description" content="Please review the terms of use of adhischools.com including acceptance, warranties, liability and copyright and trademark protection."  />
    <title>Terms of Use | ADHI Schools</title>
<?php }

//new pages
else if("schedule" == $this->router->fetch_class() && "index" == $this->router->fetch_method()) {
    ?>
     <title>Find Real Estate Classes Near You | ADHI Schools</title>
    <meta name="description" content="ADHI Schools offers real estate classes throughout Los Angeles and Orange County. Find a class near you and be one step closer to passing your real estate license exam."  />
   
<?php }

else if("trial_account" == $this->router->fetch_class() && "register" == $this->router->fetch_method()) {
    ?>
    <title>Free Online Real Estate Classes (7-Day Trial) | ADHI Schools</title>
    <meta name="description" content="Sign up for a free 7-day trial and get access to free online real estate classes and study materials offered by ADHI Schools." />
    
<?php }

else if("home" == $this->router->fetch_class() && "california_real_estate_classes" == $this->router->fetch_method()) {
    ?>
    <title>Real Estate Classes Online | ADHI Schools</title>
    <meta name="description" content="ADHI Schools online real estate classes offers students the flexibility to study at their own pace. Stream interactive videos and take practice exams on the go." />
<?php }

else if("home" == $this->router->fetch_class() && "licensing_process" == $this->router->fetch_method()) {
    ?>
    <title>How to Get a Real Estate License in California | ADHI Schools</title>
    <meta name="description" content=" Learn about the requirements, necessary steps and frequently asked questions on how you can obtain a real estate license in California." />
    
<?php } else if ("home" == $this->router->fetch_class() && "history_of_excellence" == $this->router->fetch_method()) { 
    ?>
    <title>Best Real Estate School in California | ADHI Schools</title>
    <meta name="description" content="Discover why ADHI Schools is regarded as the best real estate school in California."  />

<?php } else if("home" == $this->router->fetch_class() && "real_estate_education_app" == $this->router->fetch_method()) { ?>
    <title>Real Estate Exam App | ADHI Schools</title>
    <meta name="description" content="Download our real estate exam app and be one step closer to passing your California real estate license exam."  />  

<?php } else if("home" == $this->router->fetch_class() && "california_real_estate_classes" == $this->router->fetch_method()) { ?>
    <title>Real Estate Classes Online | ADHI Schools</title>
    <meta name="description" content="ADHI Schools online real estate classes offers students the flexibility to study at their own pace. Stream interactive videos and take practice exams on the go."  />

<?php }else if("home" == $this->router->fetch_class() && "privacypolicy" == $this->router->fetch_method()) { ?>
    <title>Our Privacy Policy | ADHI Schools</title>
    <meta name="description" content="Please review the privacy policy of adhischools.com and get a clear understanding of the security and date we collect from our website."  />

<?php } else if("home" == $this->router->fetch_class() && "brokerplacement" == $this->router->fetch_method()) { ?>
    <title>Become a Real Estate Instructor | ADHI Schools</title>
    <meta name="description" content="Looking to become an ADHI Schools real estate instructor? Reach out to us and inquire about open positions throughout Southern California."  />

<?php } else if("home" == $this->router->fetch_class() && "meet_our_staff" == $this->router->fetch_method()) { ?>
    <title>Meet Our Staff | ADHI Schools</title>
    <meta name="description" content="Meet the instructors at ADHI Schools. With over 16,000 combined hours of teaching, these instructors are poised to helping you pass your real estate license exam."/>
        
<?php } else if("home" == $this->router->fetch_class() && "our_principles" == $this->router->fetch_method()) { ?>
    <title>Our Principles | ADHI Schools</title>
    <meta name="description" content="Learn about the 10 principles that guide the development, evolution and operation of our real estate education curriculum. "/>
        
<?php }else if("home" == $this->router->fetch_class() && "testimonial" == $this->router->fetch_method()) { ?>
    <title>ADHI Schools Testimonials & Reviews</title>
    <meta name="description" content="Hear what previous students have to say about their experience with ADHI Schools. "/>
        
<?php } else{ ?>
    <title><?php echo(isset($meta_data['page_title']) && !empty($meta_data['page_title'])) ? $meta_data['page_title'] : $title?></title>
    <meta name="description" content="<?php echo $mt_desc; ?>"  />
<?php }?>