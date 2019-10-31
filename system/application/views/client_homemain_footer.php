		</div>
<?php /* main division for bottom navigation starts here */?>
		<div class="bottomnavigationmain">
			<div class="floatleft">
				<div class="floatleft"><img  src="<?php  echo $this->config->item('images');?>bottom_nav_left.jpg" /></div>
				<div class="bottomnavmiddle">
					<div class="bottomnavtextdiv">
						<div class="copyright"><small>Copyright 2003 - <?php echo date('Y'); ?> Adhischools,LLC</small></div>
						<div class="floatright">
                            <div class="navigation_bottom"><?php echo anchor(base_url().'articles','Articles',array('title'=>'Articles'));?></div>
							<div class="navigation_bottom">|</div>
							<div class="navigation_bottom"><?php echo anchor(base_url().$siteurl[0]->name,'About Us',array('title'=>'About Us'));?></div>
							<div class="navigation_bottom">|</div>
							<div class="navigation_bottom"><?php echo anchor(base_url().$siteurl[1]->name,'Contact Us',array('title'=>'Contact Us'));?></div>
							<div class="navigation_bottom">|</div>
							<div class="navigation_bottom"><?php echo anchor(base_url().$siteurl[4]->name,'Terms of Use',array('title'=>'Terms of Use'));?></div>
							<div class="navigation_bottom">|</div>
							<div class="navigation_bottom"><?php echo anchor(base_url().$siteurl[5]->name,'Privacy Policy',array('title'=>'Privacy Policy'));?></div>
							<div class="navigation_bottom">|</div>
							<div class="navigation_bottom"><?php echo anchor(base_url().'sitemap.html','Sitemap',array('title'=>'Sitemap'));?></div>
						</div>
					</div>
				</div>
				<div class="floatleft"><img  src="<?php  echo $this->config->item('images');?>bottom_nav_right.jpg" /></div>
			</div>
		</div>
<?php /*main division for bottom navigation ends here */ ?>
<!--                <script src="<?php echo $this->config->item('site_baseurl');?>js/jquery-1.4.2.min.js" type="text/javascript"></script>-->
                 <div class="bottomnavigationmain" id="morediv" onclick="javascript:__blockbtmdiv();"><b>more >></b></div>
                <div class="bottomnavigationmain" id="moredivcnt" style="display:none;width:890px;">
                    <p><b>Do You Want to Earn Your Real Estate Broker License?</b></p><br/>
                    <p>We can help!  At <b>ADHI Schools, Inc.,</b> we put our industry expertise to work for you.  With our help, you can achieve your real estate license and start enjoying the career of your dreams.  With nearly a decade of experience educating people just like you in the real estate field, we are here to simplify the process of obtaining your real estate broker license. No matter how much or how little knowledge you have about the field—we can get you on the right path in no time.  Let us help you achieve your dreams!</p><br/>
                    <br/><p>ADHI Offers Classes Including:</p>
                    <ul>
                        <li><b>Real Estate Classes—Los Angeles</b></li>
                        <li><b>Real Estate Classes—Orange County</b></li>
                        <li><b>Real Estate School—Orange County, Los Angeles, High Desert, Inland Empire, San Gabriel Valley, and More</b></li>
                    </ul>
                    <p>When you choose ADHI, you’ll also have access to top-notch educators that can give you the tools you need to build a successful and rewarding career. Whether your goal is to join a major brokerage or start your own real estate company, our expertise will pay off.  Earn your real estate license or real estate broker license from a team of experts that truly cares about your future.</p>
                    <br/><p><b>Real Estate Classes—Los Angeles Careers Start Here</b></p>
                    <br/><p>Are you ready to jump-start your career?  We can make it happen!  Now that you’ve found ADHI, you have instant access to the real estate classes in Orange County and the surrounding areas that will transform your career.  Why trust your future to any other real estate school in Orange County?  Let our educational team share their California real estate expertise with you.  When you want to start your career, we’re here to make it simple.  Build the real estate practice of your dreams with the help of our Los Angeles real estate classes or Orange County real estate school.  Now is the time to think about your financial future. Build a career with security and unlimited potential.  Get your real estate license today.</p>
                    <br/><p><b>Learn the Ins and Outs of the Business From the Experts</b></p>
                    <br/><p>When you select ADHI Orange County real estate classes, you will have the advantage of learning the trade some the industry leaders.  After spending many years in the industry, the team of educators you’ll find at ADHI is ready to share their knowledge with you.  Earn your real estate broker license today and find out just how rewarding this field can be.  When you’re ready to get started, our online registration system makes it simple.  In just minutes you can register for real estate classes in Los Angeles and the surrounding areas.  What are you waiting for? Your career is waiting!</p>
                    <br/><p>If you need further assistance or would like more information about our Orange County real estate school, feel free to contact us.  We are standing by to help you on your way to obtaining your real estate license!  Call us at <b>888-768-5285</b> or email <a href="mailto:Info@ADHISchools.com">Info@ADHISchools.com</a>.  We look forward to hearing from you soon.</p>
                </div>
	</div>
 <script>
     function __blockbtmdiv(){
         if($('moredivcnt').style.display=='block'){
                $('moredivcnt').style.display='none';
         }else{
                $('moredivcnt').style.display='block';
         }
 }
    //$(document).ready(function() {
         //$("#morediv").click(function () {
            //if ($("#moredivcnt").is(":hidden")) {
              //  $("#moredivcnt").slideDown("slow");
            //}else {
            //    $("#moredivcnt").slideUp("slow");
           // }
        // });
   // });
</script>
</body>
</html>
