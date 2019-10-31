<head>
<link href="<?php echo $this->config->item('css_url_path').load_css_files($css) ; ?>" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/x-icon" href="<?php  echo $this->config->item('images');?>favicon.ico">
<script  type="text/javascript">
	var base_url = "<?php echo base_url();?>";
</script>
<script type="text/javascript" src="<?php  echo $this->config->item('js_url_path').load_admin_js_files($js).'?'.time() ; ?>"></script>
</head>
<body>
<div class="">
<?php /* header navigation starts here */?>		
	<div id="inner_page_main_cntnr">
<?php /* header navigation ends here */?>
