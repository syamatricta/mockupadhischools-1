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
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="<?php if (isset($meta_data['description'])) echo  strip_tags($meta_data['description']); ?>"  />
	<meta name="keywords" content="<?php if (isset($meta_data['keyword'])) echo strip_tags($meta_data['keyword']); ?>"  />
	<title><?php echo(isset($meta_data['page_title']) && !empty($meta_data['page_title'])) ? $meta_data['page_title'] : $title?></title>
    <link href="<?php echo $this->config->item('css_url_path').load_css_files($css) ; ?>" rel="stylesheet" media="screen" type="text/css" />
    <link rel="shortcut icon" type="image/x-icon" href="<?php  echo $this->config->item('images');?>favicon.ico">
    <script  type="text/javascript">
            var base_url = "<?php echo base_url();?>";
    </script>
    <?php echo google_tracking_code();?>
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
	<script type="text/javascript" src="<?php  echo $this->config->item('js_url_path').load_admin_js_files($js).'?'.time() ; ?>"></script>
    
	<div class="outer_main_div">
		
        <?php if('' == $this->session->userdata('USERID') || (2 == $id_head)){?>
          <div class="log_reg_cntnr">
          		<a class="homeicon" href="<?php echo base_url(); ?>" title="Home"></a>
                <a class="reg_div" href="<?php echo c('site_ssl_baseurl').'user/register'?>" title="Register"></a>
                <a class="log_div" href="<?php echo base_url().'login' ?>" title="Login" rel="nofollow"></a>                
            </div>
           <?php } else {?>
            <div class="header_space">
            	<a class="homeicon" href="<?php echo base_url(); ?>" title="Home"></a>
	        	<?php if(1 == $id_head){?>	        	
	            <a class="log_out" href="<?php echo base_url().'user/logout' ?>" title="Logout" rel="nofollow"></a>
	            <?php } ?>
	        </div>
	        <?php } ?>
		<div id="inner_page_main_cntnr">

<?php /* header navigation ends here */?>
