<?php /* main division for twitter, face book, you tube, login and flash starts here */ ?>
<!-- override twitter classes -->
<style type="text/css">
    .twtr-hd{
        display:none
    }
    .twtr-ft{
        display:none
    }
    .twtr-widget .twtr-tweet{
        border:1px solid #272727;
    }
    .twtr-timestamp{
        color:white;
    }

</style>
<?php
    if ($this->authentication->logged_in("normal"))
    {
        $id_head = 1;
        $class = 'navigationtextlog_new';
        $class_selected = 'navigationtextlog_new';
    }
    else
    {
        $id_head = 0;
        $class = 'navigationtext_new';
        $class_selected = 'navigationtextlog_new';
    }
?>
<div class="floatleft">
    <div class="left_cntnr" >


        <a href="<?php echo base_url() ?>"><div class="logo_cntnr"></div></a>

        <div class="links_cntnr" id="home_links">
            <div  <?php if ('register' == $this->uri->segment(2) || 'profile' == $this->uri->segment(1))
{ ?> class="<?php echo $class_selected; ?>" <?php
            }
            else
            {
        ?> class="<?php echo $class; ?>"<?php } ?> ><?php
                if (0 == $id_head)
                    echo anchor('user/register', '<!--&nbsp;&nbsp;Register&nbsp;&nbsp;-->', array('title' => 'California Real Estate Exam'));else
                    echo anchor('profile', '&nbsp;&nbsp;Profile&nbsp;&nbsp;', array('title' => 'California Real Estate Examination'));
?></div>
            <?php if (1 == $id_head)
                { ?>
                    <div class="<?php echo $class ?>"><?php echo anchor('user/logout', '&nbsp;&nbsp;Logout&nbsp;&nbsp;') ?></div>
                <?php } ?>
        </div>
        <?php if (isset($arr_result) && !empty($arr_result))
            { ?>
                <div class="todays_class_contnr">
                    <div class="todays_classes_img"></div>
                </div>
                <div class="todays_classes_listing_cntnr">
                    <?php #if(isset($arr_result) && !empty($arr_result)){
                    echo form_open("home/class_details", array('name' => 'tonightclassform', 'id' => 'tonightclassform')); ?>
                    <div class="clearboth paddingbottom">
                        <input type="hidden" name="hdnSubregion" id="hdnSubregion" />
                        <input type="hidden" name="hdnDated" id="hdnDated" onchange="javascript:$('classform').submit();" value="<?php echo date('m/d/Y'); ?>" />
                    </div>
                    <div id="divClass" class="flashtwittermain" style="width:261px;">
                        <div class="clearboth"></div>
                        <div id="divShowRelatedImage">
                            <?php $this->load->view('user/display_related_class'); ?>
                        </div>
                    </div>
                    <?php
                    echo form_close();
                    //}
                    ?>
                </div>
            <?php } ?>
        <div class="cb"></div>
        <div class="fl">
            <div class="phone_div"></div>
            <div class="phone_no">888.768.5285</div>
            <div class="cb"></div>
            <div class="notepad_div"></div>
            <div class="fax_no">949 625 8007</div>
        </div>
        <div class="community_txt_img" style="margin-top:15px;"></div>
        <div class="icons_cntnr" style="margin-bottom:7px;width:258px;">
            <a href="http://facebook.com/adhischools/" target="_blank"><div class="face_book_img"></div></a>
            <a href="http://twitter.com/adhischools/" target="_blank"><div class="twitter_img"></div></a>
            <a href="http://youtube.com/adhischoolsllc/" target="_blank"><div class="youtube_img"></div></a>
            <a href="<?php echo base_url() . 'forums' ?>" target="_blank"><div class="forum_img"></div></a>
            <a href="http://www.yelp.com/biz/adhi-schools-newport-beach" target="_blank"><div class="yelp_img"></div></a>
            <a href="http://www.adhischools.com/blog/" target="_blank"><div class="blog_img"></div></a>
        </div>
        <div class="links_div">
            Copyright 2003 - <?php echo date('Y'); ?> Adhischools,LLC<br />
            <?php echo anchor(base_url() . $siteurl[0]->name, 'About Us', array('title' => 'About Us')); ?>&nbsp;
            <?php echo anchor(base_url() . $siteurl[1]->name, 'Contact Us', array('title' => 'Contact Us')); ?>&nbsp;
            <?php echo anchor(base_url() . 'articles', 'Articles', array('title' => 'Articles')); ?>&nbsp;
            <?php echo anchor(base_url() . 'brokerplacement', 'Careers', array('title' => 'Careers')); ?>&nbsp;
            <?php echo anchor(base_url() . 'sitemap.php', 'Sitemap', array('title' => 'Sitemap')); ?><br />
            <?php echo anchor(base_url() . 'testimonial', 'Testimonials', array('title' => 'Testimonials')); ?>&nbsp;
            <?php echo anchor(base_url() . $siteurl[4]->name, 'Terms of Use', array('title' => 'Terms of Use')); ?>&nbsp;
            <?php echo anchor(base_url() . $siteurl[5]->name, 'Privacy Policy', array('title' => 'Privacy Policy')); ?>&nbsp;
        </div>
        <div class="sponsorid">DRE Statutory Sponsor ID #S0348</div>

    </div>

    <div class="right_cntnr">
        <div class="flashplayer" style="width:961px;height:563px;float:left;position:relative;" onmouseover="javascript:displayIndex();" onmouseout="javascript:hideIndex();">
            <?php ?>
            <div id="slideshow" style="visibility:hidden;width:961px;height:563px;float:left; background:#A2A5A5"  >
                <a href="<?php echo base_url() ?>"><img src="<?php echo $this->config->item('images') . 'banner/c1.jpg' ?>" width="961" height="563"></a>
                <a href="<?php echo base_url() . 'meet_our_staff'; ?>"><img src="<?php echo $this->config->item('images') . 'banner/c2.jpg' ?>" width="961" height="563"></a>
                <a href="<?php echo base_url() . 'find-real-estate-classes'; ?>"><img src="<?php echo $this->config->item('images') . 'banner/c3.jpg' ?>" width="961" height="563"></a>
                <a href="<?php echo base_url() . 'testimonial'; ?>"><img src="<?php echo $this->config->item('images') . 'banner/c4.jpg' ?>" width="961" height="563"></a>
                <a href="<?php echo base_url() . 'inexpensive'; ?>"><img src="<?php echo $this->config->item('images') . 'banner/c5.jpg' ?>" width="961" height="563"></a>

                <?php
                    //   echo '<a href="'.base_url().'" <img src="'.$this->config->item('images').'banner/c1.jpg" width="961" height="563" title=" " alt=" " /></a>';
                    //  echo '<a href="'.base_url().'" <img src="'.$this->config->item('images').'banner/c1.jpg" width="961" height="563" title=" " alt=" " /></a>';
                    //   echo '<a href="'.base_url().'" <img src="'.$this->config->item('images').'banner/c2.jpg" width="961" height="563" title=" " alt=" " /></a>';
                    //   echo '<a href="'.base_url().'schedule/" <img src="'.$this->config->item('images').'banner/c3.jpg" width="961" height="563" title=" " alt=" " /></a>';
                    //   echo '<a href="'.base_url().'testimonial/" <img src="'.$this->config->item('images').'banner/c4.jpg" width="961" height="563" title=" " alt=" " /></a>';
                    //   echo '<a href="'.base_url().'" <img src="'.$this->config->item('images').'banner/c5.jpg" width="961" height="563" title=" " alt=" " /></a>';
                ?>
            </div>
<!--				<div id="playpause" onclick="onPausePlay()" onmouseover="onMouseOverPP()" onmouseout="onMouseOutPP()"><img id="playpauseimg" src="<?php echo $this->config->item('images') . 'pause-btn.png'; ?>" width="20" height="45" /></div>-->

            <div id="indexBox"  style="display:none;">
                <p id="indexText" class="inBoxText"></p>
                <div id="playpause" onclick="onPausePlay()" onmouseover="onMouseOverPP()" onmouseout="onMouseOutPP()"><img id="playpauseimg" src="<?php echo $this->config->item('images') . 'pause-btn.png'; ?>" width="20" height="45" /></div>
            </div>

        </div>




        <!--        -->
        <!--                <div class="slid_show_div">

                        <div id="slideshow" style="visibility:hidden;" >
        <?php
            echo '<a href="' . base_url() . '" <img src="' . $this->config->item('images') . 'banner/c1.jpg" width="961" height="563" title=" " alt=" " /></a>';
            echo '<a href="' . base_url() . '" <img src="' . $this->config->item('images') . 'banner/c2.jpg" width="961" height="563" title=" " alt=" " /></a>';
            echo '<a href="' . base_url() . 'find-real-estate-classes/" <img src="' . $this->config->item('images') . 'banner/c3.jpg" width="961" height="563" title=" " alt=" " /></a>';
            echo '<a href="' . base_url() . 'testimonial/" <img src="' . $this->config->item('images') . 'banner/c4.jpg" width="961" height="563" title=" " alt=" " /></a>';
            echo '<a href="' . base_url() . '" <img src="' . $this->config->item('images') . 'banner/c5.jpg" width="961" height="563" title=" " alt=" " /></a>';
        ?>
                        </div>
                        <div id="playpause" onclick="onPausePlay()" onmouseover="onMouseOverPP()" onmouseout="onMouseOutPP()"><img id="playpauseimg" src="<?php echo $this->config->item('images') . 'pause-btn.png'; ?>" width="20" height="45" /></div>
                        <div id="indexBox">
                            <p id="indexText" class="inBoxText"></p>
                            <div id="playpause" onclick="onPausePlay()" onmouseover="onMouseOverPP()" onmouseout="onMouseOutPP()"><img id="playpauseimg" src="<?php echo $this->config->item('images') . 'pause-btn.png'; ?>" width="20" height="45" /></div>
                        </div>
                        </div>-->

        <div class="right_center_cntnr">
            <div class="right_center_fac_cntnr">
                <a class="find_a_class_img" href="<?php echo base_url() . 'schedule' ?>" title=""> </a>
            </div>
            <div class="right_center_got_questions_cntnr">
                <a href="<?php echo base_url() . "faq"; ?>" title=""><div class="questions_div"></div></a>
            </div>
        </div>
        <div class="right_bottom_cntnr">
            <div class="right_bottom_top_div">
                <div class="youtuve_vid">
                    <object width="435" height="268">
                     <!-- <param name="movie" value="https://www.youtube.com/v/AyPzM5WK8ys" />-->
                        <param name="movie" value="http://www.youtube.com/v/uqGcHnn_Dgk" />
                        <param name="wmode" value="transparent" />
                        <embed src="http://www.youtube.com/v/uqGcHnn_Dgk"
                               type="application/x-shockwave-flash"
                               wmode="transparent" width="435" height="268" />
                    </object>
                </div>
                <div class="blog_post_cntnr">
                    <?php foreach ($blog_posts_rss as $blog_post)
                        { ?>
                            <div class="blog_img_cntnr">
                                <img  src="<?php echo $this->config->item('images'); ?>blog_default.jpg" width="195" height="264" />
                                <div class="blog_post_date_cntnr">
                                    <span class="post_gun"><?php echo date('d', strtotime($blog_post['pubDate'])); ?></span>
                                    <span class="post_month"><?php echo date('M', strtotime($blog_post['pubDate'])); ?></span>
                                    <span class="post_year"><?php echo date('Y', strtotime($blog_post['pubDate'])); ?></span>
                                    <?php //echo date('Y-m-d',strtotime($blog_post['pubDate']));   ?>
                                </div>
                            </div>
                            <div class="blog_cntnt_cntnr">
                                <div class="blog_cntnt_head">
                                    <?php echo htmlentities(cutText($blog_post['title'], 45)); ?>
                                </div>
                                <div class="blog_cntnt_txts">
                                    <?php echo htmlentities(cutText($blog_post['description'], 240)); ?>
                                </div>
                                <div class="learn_more_cntnr">
                                    <a href="<?php echo $blog_post['link']; ?>" target="_blank"><div class="learn_more_button"></div></a>
                                </div>
                            </div>
                        <?php } ?>
                </div>
            </div>
            <div class="right_bottom_middle_fb_div">
                <div class="fb_lk_dv">
                    <div id="fb-root"></div>
                    <script>(function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) {return;}
                    js = d.createElement(s); js.id = id;
                    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));</script>

                    <div class="fb-like" data-href="http://facebook.com/adhischools/" data-send="false" data-width="100" data-show-faces="false" data-colorscheme="dark" data-font="tahoma"></div>
                </div>
                <div class="adhi_on_fb"></div>
            </div>
            <div class="right_bottom_last_div">
                <!--                <div class="posts_div">
                                        <script src="http://widgets.twimg.com/j/2/widget.js"></script>
                                        <script>
                                        new TWTR.Widget({
                                          version: 2,
                                          type: 'profile',
                                          rpp: 3,
                                          interval: 30000,
                                          width: 380,
                                          height: 300,
                                          theme: {
                                            shell: {
                                              background: '#333333',
                                              color: '#ffffff'
                                            },
                                            tweets: {
                                              background: '#000000',
                                              color: '#ffffff',
                                              links: '#4aed05'
                                            }
                                          },
                                          features: {
                                            scrollbar: false,
                                            loop: false,
                                            live: false,
                                            hashtags: true,
                                            timestamp: true,
                                            avatars: true,
                                            behavior: 'all'
                                          }
                                        }).render().setUser('adhischools').start();
                                        </script>
                                </div>-->
                <?php
                    //$user = urlencode("adhischools");
                    //$tweets = json_decode(file_get_contents("http://twitter.com/statuses/user_timeline/{$user}.json?count=1"));
                    //$tweets = json_decode(file_get_contents("http://api.twitter.com/1/statuses/user_timeline.json?include_entities=true&include_rts=true&screen_name=adhischools&count=3"));
                    //print "<pre>";
                ?>
                <div class="posts_div">
                    <?php $this->load->view('user/home_twitter'); ?>

                </div>

                <div class="communities_div">
                    <div class="communities_cntnr">
                        <div class="community_txt_img"></div>
                        <div class="icons_cntnr">
                            <a href="http://facebook.com/adhischools/" target="_blank"><div class="face_book_img"></div></a>
                            <a href="http://twitter.com/adhischools/" target="_blank"><div class="twitter_img"></div></a>
                            <a href="http://youtube.com/adhischoolsllc/" target="_blank"><div class="youtube_img"></div></a>
                            <a href="<?php echo base_url() . 'forums' ?>" target="_blank"><div class="forum_img"></div></a>
                            <a href="http://www.yelp.com/biz/adhi-schools-newport-beach" target="_blank"><div class="yelp_img"></div></a>
                            <a href="http://www.adhischools.com/blog/" target="_blank"><div class="blog_img"></div></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="more_div_cntnr">
        <div class="more_info_button" id="morediv" onclick="javascript:__blockbtmdiv();"></div>
    </div>
    <div class="more_info_div" id="moredivcnt" style="display:none;" >
        <p><b>Do You Want to Earn Your Real Estate Broker License?</b></p><br/>
        <p>We can help! At ADHI Schools, LLC, we put our industry expertise to work for you. With our help, you can earn your real estate license and start enjoying the career of your dreams. With thousands of real estate classes taught educating people just like you, we are here to simplify the process of obtaining your California real estate salesperson license or California real estate broker license. No matter how much or how little knowledge you have about the real estate field or the California real estate license process —we can get you on the right path in no time. Let us help you achieve your dreams!</p><br/>
        <br/><p>ADHI Schools offers real estate classes in all of the following areas:</p>
        <ul>
            <li><b>Real Estate Classes—Los Angeles</b></li>
            <li><b>Real Estate Classes—Orange County</b></li>
            <li><b>Real Estate Classes in the South Bay</b></li>
            <li><b>Real Estate Classes in the High Desert</b></li>
            <li><b>Real Estate Classes in the Inland Empire</b></li>
            <li><b>Real Estate Classes in the San Gabriel Valley</b></li>
        </ul>
        <p>When you choose ADHI, you’ll also have access to top-notch real estate educators and a highly innovative real estate school that gives you the tools you need to build a successful and rewarding career. Whether your goal is to join a major real estate company or start your own real estate brokerage, our expertise will pay off. Earn your real estate license or real estate broker license from a team of experts that truly cares about your future.</p>
        <br/><p><b>Real Estate Classes—Los Angeles Careers Start Here</b></p>
        <br/><p>Are you ready to jump-start your real estate career and pass the real estate exam?  We can make it happen! Now that you’ve found ADHI, you have instant access to real estate classes in Orange County and surrounding areas that will transform your life. Why trust your future in the real estate business to any other California real estate school? Let our educational team share their California real estate exam expertise with you. When you want to start your real estate career, we’re here to make it simple. Build the real estate practice of your dreams with the help of our Los Angeles real estate classes or Orange County real estate school. Now is the time to think about your financial future. Build a career with security and unlimited potential. Get your California real estate license today.</p>
        <br/><p><b>Learn the Ins and Outs of the Real Estate Business From the Experts</b></p>
        <br/><p>When you select ADHI’s California live real estate classes, you will have the advantage of learning the trade from respected California real estate industry leaders. After spending many years in the real estate industry, our team of educators you’ll find at ADHI is ready to share their knowledge with you. Earn your real estate broker license today and find out just how rewarding this field can be. When you’re ready to get started, our online registration system for rela estate classes makes it simple. In just minutes you can register for California real estate classes in Los Angeles and the surrounding areas. What are you waiting for? Your career in real estate is waiting!</p>
        <br/><p>If you need further assistance or would like more information about our Orange County real estate school, feel free to contact us. We are standing by to help you on your way to obtaining your real estate license! Call us at <b>888-768-5285</b> or email <a href="mailto:Info@ADHISchools.com">Info@ADHISchools.com</a>.  We look forward to hearing from you soon.</p>
    </div>
    <?php $this->view('view_license_info'); ?>
</div>

<?php /* main division for Real Estate and Questions ends  here */ ?>

<script type="text/javascript">
var browser = "";					// this is here to create the dots for picture navigation using the css for 'fancymenu'
var Play = true;
jQuery.noConflict();

function __fnctwitteryoutubewindow(id){
url	= base_url+'home/twitter_youtubevideo/'+id;
window.open(url,"","width=580, height=335, left=45, top=15, scrollbars=yes, menubar=no,resizable=no,directories=no,location=no");
}

</script>

<style type="text/css">
    body {
        font-family: Arial, Helvetica, sans-serif;
        text-align: left;
        padding: 0px;
        margin-top:0px;
        background:url(<?php echo base_url() . 'images/bg_01.jpg' ?>) #000000 no-repeat center top;
        height:auto;
    }
    #twtr-widget-1 .twtr-new-results, #twtr-widget-1 .twtr-results-inner, #twtr-widget-1 .twtr-timeline {
        background:transparent none repeat scroll 0 0 !important;
    }
    #twtr-widget-1 .twtr-doc, #twtr-widget-1 .twtr-hd a, #twtr-widget-1 h3, #twtr-widget-1 h4, #twtr-widget-1 .twtr-popular{
        background-color:transparent !important;
    }
    .like_button_dark div.connect_widget_button_count_count {
        background-color:green !important;
        border-color:#D7D7D7;
    }
    .connect_widget_button_count_count {
        background:#FFFFFF none repeat scroll 0 0;
        border:1px solid #D1D1D1;
        float:left;
        font-weight:normal;
        height:14px;
        line-height:14px;
        margin-left:1px;
        min-width:15px;
        padding:1px 2px;
        text-align:center;
        white-space:nowrap;
    }
</style>
<script>
function show_twtvideo(id){
$('twtvideo'+id).show();
}
function twtr_popup_close(id){
$('twtvideo'+id).hide();
}
</script>
<script>
function is_valid_email(value){
    return /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(value);
}
jQuery(document).ready(function() {
jQuery('#license_info_form').submit(function() {
var warning  = '';
if(jQuery('#licencee_name').val()==undefined || jQuery('#licencee_name').val()=='')
    warning += 'The Name field is required.' + "\n";

if(jQuery('#licencee_email').val()==undefined || jQuery('#licencee_email').val()=='')
    warning += 'The Email field is required.' + "\n";
else if (!is_valid_email(jQuery('#licencee_email').val()))
    warning += 'The Email given is not valid.' + "\n";

if(jQuery('#math_captcha').val()==undefined || jQuery('#math_captcha').val()=='')
    warning += 'The captcha field is required.' + "\n";
if(warning !=''){
    jQuery('.valid_msgs').text(warning).addClass('error_msg');
}
else
{
    jQuery.post('<?php echo base_url() ?>index.php/home/real_estate_license_info',jQuery('#license_info_form').serialize(), function(resp) {
        if(resp.status !=200){
            jQuery('.valid_msgs').addClass('error_msg').text(resp.msg);
        }
        else {
            jQuery('.valid_msgs').addClass('success_msg').text(resp.msg);
        }
    });
}
return false;
});
});


</script>