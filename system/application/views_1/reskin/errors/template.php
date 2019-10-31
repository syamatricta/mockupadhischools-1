<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

$meta_data	=	set_meta_data();
$title		=	(isset($title) && !empty($title)) ? $title : "adhischools";

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="<?php if (isset($meta_data['description'])) echo  strip_tags($meta_data['description']); ?>"  />
    <meta name="keywords" content="<?php if (isset($meta_data['keyword'])) echo strip_tags($meta_data['keyword']); ?>"  />
    <title><?php echo(isset($meta_data['page_title']) && !empty($meta_data['page_title'])) ? $meta_data['page_title'] : $title?></title>
    <?php $ssl_css_url_path=   ssl_css_url_path();  ?>
    <link rel="shortcut icon" type="image/x-icon" href="<?php  echo $this->config->item('images');?>favicon.ico">
    <script  language="javascript">
        var base_url = "<?php echo base_url();?>";
    </script>
    <?php //echo google_tracking_code();?>
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" >

    <link rel="stylesheet" href="<?php echo $this->config->item('style_url');?>style.css" />
    <link rel="stylesheet" href="<?php echo $this->config->item('style_url');?>rubick_pres.css" />
    <link rel="stylesheet" href="<?php echo $this->config->item('style_url');?>fullcalendar.min.css" />
    <link rel="stylesheet" href="<?php echo $this->config->item('style_url');?>owl.carousel.css" />
    
    <link rel="stylesheet" href="<?php echo $this->config->item('style_url')?>animate.css" type="text/css" media="screen">
    
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,600,300,800,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:700,300' rel='stylesheet' type='text/css'>
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  </head>
  <body>
       <?php
       /*
        <nav class="navbar navbar-default navbar-fixed-top navbar-burger navbar-ext" role="navigation">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
                <a class="navbar-brand" href="#"><img src="<?php echo $this->config->item('image_url');?>logo.svg" class="img-responsive" /></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse navbar-right">
              <ul class="nav navbar-nav">
                <li><a href="#"><i class="fa fa-pencil-square-o"></i> Register</a></li>
                <li><a href="#"><i class="fa fa-unlock"></i> Login</a></li>
                <li><a href="#">MENU <i class="fa fa-bars"></i></a></li>
              </ul>
            </div>
          </div>
        </nav>
        */
        ?>
       <nav class="navbar navbar-default navbar-fixed-top navbar-burger navbar-ext" role="navigation">
            <!-- if you want to keep the navbar hidden you can add this class to the navbar "navbar-burger"-->
            <div class="container">
                <div class="navbar-header">
                    <button id="menu-toggle" type="button" class="navbar-toggle navbar-right" data-toggle="collapse" data-target="#example">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button> 
                    <a class="navbar-brand" href="<?php echo base_url();?>"><img src="<?php echo $this->config->item('image_url');?>logo1.svg" class="img-responsive" /></a>                    
                    <div id="navbar" class="navbar-right hidden-xs">
                        <ul class="nav navbar-nav">
                            <?php $selected_nav = (!isset($selected_nav)) ? '' : $selected_nav;?>
                            <?php if($this->authentication->logged_in("normal")){?>
                            <li class="<?php echo ('schedule' == $selected_nav) ? 'active' : '';?>"><a href="<?php echo base_url();?>schedule">Find a Class</a></li>
                            <li class="<?php echo ('course' == $selected_nav) ? 'active' : '';?>"><a href="<?php echo base_url();?>course/courselist">Course</a></li>
                            <li class="<?php echo ('change_password' == $selected_nav) ? 'active' : '';?>"><a href="<?php echo base_url();?>user/change_password">Change Password</a></li>
                            <li class="<?php echo ('profile' == $selected_nav) ? 'active' : '';?>"><a href="<?php echo base_url();?>profile">My Profile</a></li>
                            <?php if(find_date_diff($this->config->item("cut_off_date"),$this->session->userdata ( 'USER_CREATED_AT' )) > 0){ ?>
                                <li class="<?php echo ('classroom' == $selected_nav) ? 'active' : '';?>"><a href="<?php echo base_url();?>classroom/view">Classroom</a></li>
                            <?php } ?>
                            <li class="logout-link"><a href="<?php echo base_url();?>user/logout"><i class="fa fa-power-off"></i> Logout</a></li>
                            <?php }else{?>
                            <li><a href="<?php /*class="adhilogin" */ echo base_url();?>user/register"><i class="fa fa-pencil-square-o"></i> Register</a></li>
                            <li><a href="#" class="login-popup"><i class="fa fa-unlock"></i> Login</a></li>
                            <?php }?>
                        </ul>
                    </div>
                </div>
                
                <div id="sidemenu-section" class="collapse navbar-collapse" >
                     
                    
                    <ul class="nav navbar-nav navbar-right navbar-uppercase">
                    	<li class="pull-right navbar-burger" style="z-index: 2000">
	                    	<button data-target="#example" data-toggle="collapse" class="navbar-toggle toggled" type="button" id="menu-toggle">
		                        <span class="sr-only">Toggle navigation</span>
		                        <span class="icon-bar bar1"></span>
		                        <span class="icon-bar bar2"></span>
		                        <span class="icon-bar bar3"></span>
		                    </button>
                    	</li>
                        <li class="clearfix" style="height: 86px;"></li>
                        <li class="sidemenu-logo">
                            <a class="" href="<?php echo base_url();?>new"><img src="<?php echo $this->config->item('image_url');?>logo1.svg" class="img-responsive" /></a>
                        </li>
                        <li class="visible-xs"><a href="#"><i class="fa fa-pencil-square-o"></i> Register</a></li>
                        <li class="visible-xs"><a href="#" class="login-popup"><i class="fa fa-unlock"></i> Login</a></li>
                        <li><a href="<?php echo base_url();?>about-us" data-scroll="true" >About Us</a></li>
                        <li><a href="<?php echo base_url();?>contact-us" data-scroll="true" >Contact Us</a></li>
                        <li><a href="<?php echo base_url();?>schedule" data-scroll="true" >Find a Class</a></li>
                        <li><a href="<?php echo base_url();?>careers" data-scroll="true" >Careers</a></li>
                        <li><a href="<?php echo base_url();?>testimonials" data-scroll="true" >Testimonials</a></li>
                        <li><a href="<?php echo base_url();?>faq" data-scroll="true" >Got Questions</a></li>
                        <li><a href="<?php echo base_url();?>sitemap" data-scroll="true" >Sitemap</a></li><!--data-id="#contact"-->
                        <li class="social-links">
                            <a href="https://facebook.com/adhischools/" target="_blank"><i class="fa fa-facebook"></i></a>
                            <a href="https://twitter.com/adhischools/" target="_blank"><i class="fa fa-twitter"></i></a>
                            <a href="https://www.youtube.com/channel/UCKnNFzHOoFcrh0vNBRWcEBQ" target="_blank"><i class="fa fa-youtube"></i></a>
                            <a href="https://www.instagram.com/adhischools/" target="_blank"><i class="fa fa-instagram"></i></a>
                            <a href="http://www.yelp.com/biz/adhi-schools-newport-beach" target="_blank"><i class="fa fa-yelp"></i></a>
                            <a href="http://www.adhischools.com/blog/" target="_blank"><i class="fa fa-wordpress"></i></a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!--<div id="loginbox" class="loginbox">
            	<?php  $this->load->view("reskin/login");?>
            </div>-->
        </nav>
        

      
    <?php echo $content;?>
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
                                        <div class="margin10"><img class="img-responsive" src="<?php echo $this->config->item('image_url');?>adhi_footer_logo.svg"></div>
					<div class="row">
						<div class="col-xs-1"><i class="fa fa-map-marker f20"></i></div>
						<div class="col-xs-10">
							 <p  class="ad-title">Headquarters</p>
							 <address>
							 	1063 West 6th Street ,Second floor</br>
							 	<!--3350 Shelby Street #200-->							
								Ontario, CA 91762
                                                                <!--Ontario, CA 91764-->
							 </address>
						</div>
					</div>
					<div class="row margin10">
						<div class="col-xs-1"><i class="fa fa-phone"></i></div>
						<div class="col-xs-10 ">888-768-5285</div>
					</div>
					<div class="row margin10">
						<div class="col-xs-1"><i class="fa  fa-fax"></i></div>
						<div class="col-xs-10">949-625-8007</div>
					</div>
					<div class="row margin10">
						<div class="col-xs-1"><i class="fa fa-envelope-o"></i></div>
						<div class="col-xs-10 sf">info@adhischools.com</div>
						
					</div>
				</div>
				<div class="col-sm-9 noplmd">
					<div class="row">
						<div class="col-sm-3 nopadmd">
							<ul>
                                                            <li><a href="<?php echo base_url();?>blog">Blog</a></li>
                                                            <li><a href="#" class="login-popup">Login</a></li>
                                                            <li><a href="<?php echo base_url();?>our-terms-of-use">Terms of Use</a></li>
                                                            <li><a href="<?php echo base_url();?>our-privacy-policy">Privacy Policy</a></li>
							</ul>
						</div>
						<div class="col-sm-3 nopadmd">
							<ul>
                                                            <li><a href="http://crashcourseonline.com">Crash course online</a></li>
                                                            <li><a href="<?php echo base_url();?>schedule">Class schedule</a></li>
                                                            <li><a href="<?php echo base_url();?>faq">FAQ</a></li>
                                                            <li><a href="<?php echo base_url();?>careers">Careers</a></li>
							</ul>
						</div>
						<div class="col-sm-2 ">
							<ul>
                                                            <li><a href="<?php echo base_url();?>testimonials">Success stories</a></li>
                                                            <li><a href="<?php echo base_url();?>about-us">About us</a></li>
                                                            <!--<li><a href="#">Our team</a></li>-->
                                                            <li><a href="<?php echo base_url();?>sitemap">Sitemap</a></li>
                                                            <li><a href="<?php echo base_url();?>contact-us">Contact us</a></li>
							</ul>
						</div>
						<div class="col-sm-4 nopadmd">
							<div class="text-right social">
								<a href="https://twitter.com/adhischools/" target="_blank"><span class="fa fa-twitter"></span></a>
								<a href="https://facebook.com/adhischools/" target="_blank"><span class="fa fa-facebook"></span></a>
								<a href="https://www.youtube.com/channel/UCKnNFzHOoFcrh0vNBRWcEBQ" target="_blank"><span class="fa fa-youtube"></span></a>
								<a href="https://www.instagram.com/adhischools/" target="_blank"><span class="fa fa-instagram"></span></a>
								<a href="http://www.yelp.com/biz/adhi-schools-newport-beach" target="_blank"><span class="fa fa-yelp"></span></a>
								<a href="http://www.adhischools.com/blog/" target="_blank"><span class="fa fa-wordpress"></span></a>
							</div>
                                                    <div class="text-right xf ">Copyright &COPY; <?php echo date('Y');?> Adhischools.com</div>
                                                    <div class="text-right xf ">CalBRE Statutory Sponsor ID #S0348</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
   
    <!-- Latest compiled and minified JavaScript -->
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?php echo $this->config->item('script_url');?>jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->config->item('script_url');?>moment.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->config->item('script_url');?>fullcalendar.min.js"></script>    
    <script type="text/javascript" src="<?php echo $this->config->item('script_url');?>modernizr.js"></script>
    <script type="text/javascript" src="<?php echo $this->config->item('script_url');?>rubick_pres.js"></script>
    <script type="text/javascript" src="<?php echo $this->config->item('script_url');?>owl.carousel.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->config->item('script_url');?>jquery.countTo.js"></script>
    <script src="<?php echo $this->config->item('script_url')?>wow.min.js" type="text/javascript"></script> 
    <script src="<?php echo $this->config->item('script_url')?>user.js" type="text/javascript"></script> 
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

/* Start WebsiteAlive AliveTracker Code */
function wsa_include_js(){
var wsa_host = (("https:" == document.location.protocol) ? "https://" : "http://");
var js = document.createElement("script");
js.setAttribute("language", "javascript");
js.setAttribute("type", "text/javascript");
js.setAttribute("src",wsa_host + "tracking-v3.websitealive.com/3.0/?objectref=c1&groupid=687&websiteid=0");
document.getElementsByTagName("head").item(0).appendChild(js);
}
if (window.attachEvent) {window.attachEvent("onload", wsa_include_js);}
else if (window.addEventListener) {window.addEventListener("load", wsa_include_js, false);}
else {document.addEventListener("load", wsa_include_js, false);}
/* End WebsiteAlive AliveTracker v3.0 Code */

/*Start AliveChat Tracking Code
function wsa_include_js(){
    	var wsa_host = (('https:' == document.location.protocol) ? 'https://' : 'http://');
	var js = document.createElement('script');
	js.setAttribute('language', 'javascript');
	js.setAttribute('type', 'text/javascript');
	js.setAttribute('src',wsa_host + 'tracking.websitealive.com/vTracker_v2.asp?objectref=c1&groupid=687&websiteid=0');
	document.getElementsByTagName('head').item(0).appendChild(js);
}
if (window.attachEvent) {window.attachEvent('onload', wsa_include_js);}
else if (window.addEventListener) {window.addEventListener('load', wsa_include_js, false);}
else {document.addEventListener('load', wsa_include_js, false);}
/*End AliveChat Tracking Code*/

</script>
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none;">
        <div class="modal-dialog">
            <div id="loginbox" class="loginbox modal-content">
                <?php $this->load->view('reskin/login');?>
            </div>
        </div>
    </div>

    <?php
    if($this->session->flashdata('login_continue_message')){
        echo '<div class="alert alert-info" id="login_continue_msg">'.$this->session->flashdata('login_continue_message').'</div>';
    }else if($this->session->flashdata('msg')){
        
        switch($this->session->flashdata('msg_type')){
            case 'error':
                $alert_class = 'alert-danger';
                break;
            case 'success':
                $alert_class = 'alert-success';
                break;
            case 'info':
                $alert_class = 'alert-info';
                break;
            
        }
            
        echo '<div class="alert '.$alert_class.'" id="flashdata_msg">'.$this->session->flashdata('msg').'</div>';
    }
    ?>


  </body>
</html>
