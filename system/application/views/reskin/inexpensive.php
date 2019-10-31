<?php page_heading('Inexpensive Online Classes', '');?>
<?php
    $video_details = array('intro.mp4','Chapter1.mp4', 'Chapter2.mp4', 'Chapter6.mp4' );   

    $video_path1 = 'http://streams.adhischools.com/inexpensive/'.urlencode($video_details[0]);
    $video_path2 = 'http://streams.adhischools.com/inexpensive/'.urlencode($video_details[1]);
    $video_path3 = 'http://streams.adhischools.com/inexpensive/'.urlencode($video_details[2]);
    $video_path4 = 'http://streams.adhischools.com/inexpensive/'.urlencode($video_details[3]);


?>
<section class="inexpensive">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="page-heading">Taking classes online</h3>
                <p class="font-big font-light">Can be challenging for anyone. So how do you make sure that you have the greatest chances of success? We have a few things up our sleeve to make sure that you actually finish. </p>
            </div>
        </div>
        <div class="row portions-row margin40">
            <div class="col-sm-9 col-xs-12">
                <div class="row">
                    <div class="col-sm-10 col-xs-12">
                        <video width="100%" height="">
                            <source src="<?php echo $video_path1;?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <div class="col-sm-2 clips">
                        <div class="margin5 pull-left"><img src="<?php print base_url();?>images/inexpensive/meet-ourstaff01_slice_10.jpg"></div>
                        <div class="margin5 pull-left"><img src="<?php print base_url();?>images/inexpensive/meet-ourstaff01_slice_07.jpg"></div>
                        <div class="margin5 pull-left"><img src="<?php print base_url();?>images/inexpensive/meet-ourstaff01_slice_12.jpg"></div>
                        <div class="margin5 pull-left"><img src="<?php print base_url();?>images/inexpensive/meet-ourstaff01_slice_10.jpg"></div>
                    </div>
                </div>
                
            </div>
            <div class="col-sm-3 col-xs-12">
                <div class="container-box margin20">
                    <h5><i class="fa fa-laptop"></i> <span>INTERNET FORUM</span></h5>
                    <div>
                        <p>We have an Internet forum that is constantly monitored for new posts and we respond quickly.Try us.</p>
                    </div>
                </div>
                <div class="container-box helpdesk-box">
                    <h5><i class="fa fa-comments"></i> <span>HELP DESK</span></h5>
                    <div>
                        <p>Need more help with the course material? Post to our Facebook wall, send us a tweet , or just call us at</p>
                        <h6>888 768 5285</h6>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3"><img class="img-responsive" src="<?php echo $this->config->item('images').'reskin/books.png';?>"></div>
            <div class="col-sm-9 course-matetial margin40">
                <h4>Course Materials</h4>
                <p>Don’t forget that the price of our course includes all of your course materials. Each book contains over 450 pages of real estate goodness. The Real Estate Principles book covers some basic real estate law and a general overview of real estate. The Real Estate Practice book is going to help you jumpstart your career and pick a great office in which to work. You have your choice of an elective course</p>
                <p class="font-med font-bold">You also get access to practice quizzes on our website and within each of the provided textbooks. </p>
            </div>
            <div class="col-sm-12 text-center"><button class="btn-adhi btn-big">CLICK HERE TO REGISTER</button></div>
        </div>
    </div>
</section>