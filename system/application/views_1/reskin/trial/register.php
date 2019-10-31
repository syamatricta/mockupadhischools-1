<?php page_heading('Create Trial Account', '');?>
<section class="register">
    <div class="container">
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
                            <?php if(isset($msg)) echo $msg; ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="trial-registration-carousel" class="carousel slide col-sm-12" data-ride="carousel" data-interval="false" data-keyboard="false">
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <div class="carousel-caption1">
                                    <?php $this->load->view('reskin/trial/_reg_form');?>
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
<?php $this->load->view('reskin/trial/_agreement');?>