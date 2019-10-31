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
<meta name="google-site-verification" content="yAijLzSz4Id8bJZC-uxnpplWV6bYnaUw0fD94A8LaxI" />
	
    <link href="<?php echo $this->config->item('css_url_path').load_css_files($css) ; ?>" rel="stylesheet" type="text/css" />
	<script  type="text/javascript">
		var base_url = "<?php echo base_url();?>";
	</script>
</head>
<body>
		<?php if($this->authentication->logged_in ("normal")){
					$id_head=1;
					$class='navigationtextlog';
					$class_selected='navigationtextlog';
			}else if($this->authentication->logged_in ("admin")){
					$id_head=2;
					$class='navigationtextlog';
					$class_selected='navigationtextlog';
			}else {
			   		$id_head=0;
			   		$class='navigationtext';
			   		$class_selected='navigationtextlog';
			}

   		?>

	<script type="text/javascript" src="<?php  echo $this->config->item('js_url_path').load_admin_js_files($js) ; ?>"></script>
<?php /* header navigation ends here */?>
