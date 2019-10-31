<?php page_heading('Free Online Real Estate Classes (7-Day Trial)', ''); ?>
<div class="text-right" style="margin-right:8%;">		
    <span><a href="<?php echo base_url(); ?>">Home</a></span>		
    <span class="content">|Free Online Real Estate Classes </span> 		
</div>
<section class="register">
    <div class="container">
        <div>
            <p>Would you like to take a completely free trial course to see if a real estate career is right for you? Check out the ADHI free online class. There's no credit card required and it costs absolutely nothing. Signing up gives you a sneak-peek into the online courses at the best real estate school in California.  Free online real estate courses are hard to come by, so take advantage of this opportunity while it lasts. </p>

            <p> You have nothing to lose and can quickly see whether you are suited to a career in real estate. This actual online course is like many of the others in our full curriculum for real estate professionals. You take it at your own pace in the privacy of your home or wherever you want to take it.  You'll have 7 days to test drive the program and see if it's right for you!</p>

            <p> This free online real estate trial has limited availability so sign up now and lock down your seat. Many people seek out free real estate classes when they are considering a career in the real estate  industry. Before you get a real estate license and take the state licensing exam, you'll want to check out the best real estate schools. </p>
            <p> Remember the only way to qualify for the actual real estate exam is to take an actual course.</p>
            <p>Prospective real estate agents who need to get a glimpse of the pre license classes that are part of California's education requirements should sign up for ADHI's free course. You'll get to try it out free of charge, and learn about the state's licensing requirements and be able to decide for yourself is real estate is the career for you. Secure your spot today!</p>
            <p> Remember:</p>
            <p>  o No credit card is required!</p>
            <p> o Jump in at any time!</p>
            <p>o See if real estate interests you!</p>
        </div>

        <br></br>
        <div class="row">
            <div class="col-md-10 col-sm12 col-md-offset-1 text-right reg_needhelp">
                <h2 class="inherit"><i class="fa fa-phone"></i> Need help? Call 888 768 5285</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-sm12 col-md-offset-1 wtbg">
                <div class="divide40"></div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 text-center">
                        <div  class="alert alert-danger" id="errordiv" style="display:none">
                            <?php if (isset($msg)) echo $msg; ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="trial-registration-carousel" class="carousel slide col-sm-12" data-ride="carousel" data-interval="false" data-keyboard="false">
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <div class="carousel-caption1">
                                    <?php $this->load->view('reskin/trial/_reg_form'); ?>
                                </div>
                            </div>
                            <div class="item">
                                <div class="carousel-caption1" id="trial_registraion_message_slide"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $this->load->view('reskin/trial/_agreement'); ?>