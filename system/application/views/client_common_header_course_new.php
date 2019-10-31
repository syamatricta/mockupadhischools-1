<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
	$meta_data	=	set_meta_data();
	$title		=	(isset($title) && !empty($title)) ? $title : "adhischools";
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" >
	<meta name="description" content="<?php if (isset($meta_data['description'])) echo  strip_tags($meta_data['description']); ?>"  />
	<meta name="keywords" content="<?php if (isset($meta_data['keyword'])) echo strip_tags($meta_data['keyword']); ?>"  />
	<title><?php echo(isset($meta_data['page_title']) && !empty($meta_data['page_title'])) ? $meta_data['page_title'] : $title?></title>
<?php $ssl_css_url_path=   ssl_css_url_path();  ?>
    <link href="<?php echo   $ssl_css_url_path.load_css_files($css) ; ?>" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" type="image/x-icon" href="<?php  echo $this->config->item('images');?>favicon.ico">
    <script  language="javascript">
            var base_url = "<?php echo base_url();?>";
    </script>
    <?php echo google_tracking_code();?>
</head>
<body onload="javascript:checkcourse();">
		<?php if($this->authentication->logged_in ("normal")){
					$id_head=1;
					$class='navigationtextlog';
					$class_selected='navigationtextlog';
			} else {
			   		$id_head=0;
			   		$class='navigationtext';
			   		$class_selected='navigationtext';
			}

   		?>
<?php $ssl_js_url_path=   ssl_js_url_path(); ?>
	<script language="JavaScript" src="<?php echo  $ssl_js_url_path.load_admin_js_files($js).'?'.time() ; ?>"></script>
<!--	<div class="outermaindiv">-->
		
<?php /* header navigation starts here */?>
<!--		<div class="headernavmain">
			<div class="headerleftnav"><img  src="<?php  echo  ssl_url_img();?>adhi_left_nav.jpg" /></div>
			<div class="headermiddlenav">
				<div class="navigationmain">
					<div  <?php if('register' == $this->uri->segment(2) || 'profile' == $this->uri->segment(1)){?> class="<?php echo $class_selected; ?>" <?php } else {?> class="<?php echo $class; ?>"<?php }?> ><?php if(0 == $id_head)echo '<a href="'.c('site_ssl_baseurl').'user/register'.'" title="California Real Estate License Registration">Register</a>';else echo anchor('profile','Profile',array('title'=>'California Real Estate Examination'));?></div>
					<div class="headerleftnav"><img  src="<?php  echo  ssl_url_img();?>seperator.jpg" /></div>
					<div  <?php if($siteurl[7]->name == $this->uri->segment(1)){?> class="<?php echo $class_selected; ?>" <?php } else {?> class="<?php echo $class; ?>"<?php }?> ><?php echo anchor('index.php/'.$siteurl[7]->name,'Testimonials',array('title'=>'California Real Estate Exam'));?></div>
					<div class="headerleftnav"><img  src="<?php  echo  ssl_url_img();?>seperator.jpg" /></div>
					<div class="<?php echo $class; ?>"><?php  echo anchor('index.php/schedule','Schedules & Locations',array('title'=>'Real Estate License Classes'));?></div>
					<div class="headerleftnav"><img  src="<?php  echo  ssl_url_img();?>seperator.jpg" /></div>
					<div class="<?php echo $class; ?>"><?php echo anchor('http://adhischools.blogspot.com/','Blog',array('title'=>'California Real Estate License','target'=>'_blank'));?></div>
                                         <div class="headerleftnav"><img  src="<?php  echo $this->config->item('images');?>seperator.jpg" /></div>
					<div class="<?php echo $class; ?>"><?php echo anchor('index.php/forum','Forum',array('title'=>'Real Estate Crash Course','target'=>'_blank'));?></div>
					<?php if(1 == $id_head){?>
					<div class="headerleftnav"><img  src="<?php  echo  ssl_url_img();?>seperator.jpg" /></div>
					<div class="<?php echo $class?>"><?php echo anchor('user/logout','Logout')?></div>
					<?php }?>
				</div>
			</div>
			<div class="headerleftnav"><img src="<?php  echo  ssl_url_img();?>adhi_right_nav.jpg" /></div>
		</div>-->
	<div class="outer_main_div">
        <div class="header_space">
        	<?php if(1 == $id_head){?>
                <a class="log_out" href="<?php echo base_url().'user/logout' ?>" title="Logout" rel="nofollow"></a>
                <?php } ?>
        </div>
		<div id="inner_page_main_cntnr">
<?php /* header navigation ends here */?>
