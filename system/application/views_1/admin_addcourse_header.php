<?php 
header("Content-Type: text/html; charset=UTF-8"); 
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo (isset($title) && !empty($title) ? $title : "adhischools");?></title>
	<link href="<?php echo $this->config->item('css_url_path').load_css_files($css) ; ?>" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" type="image/x-icon" href="<?php  echo $this->config->item('images');?>favicon.ico">
	<script  language="javascript">
		var base_url = "<?php echo base_url();?>";
	</script>
</head>
<body onload="javascript:checkcourse();">
	<script language="javascript" type="text/javascript" src="<?php echo $this->config->item('js_url_path').load_admin_js_files($js).'?'.time() ; ?>"></script>
	<div class="outermaindiv">

		<div class="placelogo"><a href="<?php echo base_url()?>index.php/admin/home/"><img  src="<?php  echo $this->config->item('images');?>adhilogo.jpg"  alt="Real Estate Classes Los Angeles" title="Real Estate Classes Los Angeles"/></a></div>
		<div class="placeadhischool"><a href="<?php echo base_url()?>index.php/admin/home/"><img  src="<?php  echo $this->config->item('images');?>adhischools.jpg" /></a></div>
		<div class="clearboth"></div>
		<div class="floatleft" style="width:100%">
<?php /* header navigation starts here */?>
		<?php 
		if ($this->authentication->logged_in ("admin"))
		{
		echo $this->load->view('admin/admin_menu');
		}
		
/* header navigation ends here */
		?>