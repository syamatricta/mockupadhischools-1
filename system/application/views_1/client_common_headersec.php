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
    <link href="<?php echo $this->config->item('css_url_path').load_css_files($css) ; ?>" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" type="image/x-icon" href="<?php  echo $this->config->item('images');?>favicon.ico">
	<script  language="javascript">
		var base_url = "<?php echo base_url();?>";
	</script>
		<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-5713717-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
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
	<div class="outermaindiv">
		<div class="placelogo"><a href="<?php echo $this->config->item('site_baseurl')?>index.php/home/"><img  src="<?php  echo $this->config->item('images');?>adhilogo.jpg" alt="Real Estate Classes Los Angeles" title="Real Estate Classes Los Angeles" /></a></div>
		<div class="placeadhischool"><a href="<?php echo $this->config->item('site_baseurl')?>index.php/home/"><img  src="<?php  echo $this->config->item('images');?>adhischools.jpg" alt="adhischools" title="adhischools" /></a></div>
<?php /* header navigation starts here */?>
		<div class="headernavmain">
			<div class="headerleftnav"><img  src="<?php  echo $this->config->item('images');?>adhi_left_nav.jpg" /></div>
			<div class="headermiddlenav">
				<div class="navigationmain">
					<div  <?php if('register' == $this->uri->segment(2) || 'profile' == $this->uri->segment(1)){?> class="<?php echo $class_selected; ?>" <?php } else {?> class="<?php echo $class; ?>"<?php }?> ><?php if(0 == $id_head)echo anchor('user/register','Register',array('title'=>'California Real Estate Examination'));else echo anchor('profile','Profile',array('title'=>'California Real Estate Examination'));?></div>
					<div class="headerleftnav"><img  src="<?php  echo $this->config->item('images');?>seperator.jpg" /></div>
					<div  <?php if($siteurl[7]->name == $this->uri->segment(1)){?> class="<?php echo $class_selected; ?>" <?php } else {?> class="<?php echo $class; ?>"<?php }?> ><?php echo anchor($siteurl[7]->name,'Testimonials',array('title'=>'California Real Estate Exam'));?></div>
					<div class="headerleftnav"><img  src="<?php  echo $this->config->item('images');?>seperator.jpg" /></div>
					<div class="<?php echo $class; ?>"><?php  echo anchor('schedule','Schedules & Locations',array('title'=>'Real Estate License Classes'));?></div>
					<div class="headerleftnav"><img  src="<?php  echo $this->config->item('images');?>seperator.jpg" /></div>
					<div class="<?php echo $class; ?>"><?php echo anchor('http://adhischools.blogspot.com/','Blog',array('title'=>'California Real Estate License','target'=>'_blank'));?></div>
                                        <div class="headerleftnav"><img  src="<?php  echo $this->config->item('images');?>seperator.jpg" /></div>
					<div class="<?php echo $class; ?>"><?php echo anchor('forum','Forum',array('title'=>'Real Estate Crash Course','target'=>'_blank'));?></div>
					<?php if(1 == $id_head){?>
					<div class="headerleftnav"><img  src="<?php  echo $this->config->item('images');?>seperator.jpg" /></div>
					<div class="<?php echo $class?>"><?php echo anchor('user/logout','Logout')?></div>
					<?php }?>
				</div>
			</div>
			<div class="headerleftnav"><img src="<?php  echo $this->config->item('images');?>adhi_right_nav.jpg" /></div>
		</div>
		<div id="innerpagemain">
			<div class="innerbackground_left"><img  src="<?php  echo $this->config->item('images');?>innerpages/inner_background_left.jpg" /></div>
			<div class="innerbackground_middle" >
<?php /* header navigation ends here */?>
