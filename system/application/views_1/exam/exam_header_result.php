<?php 
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
	<META HTTP-EQUIV="Expires" CONTENT="-1">
    <title><?php echo (isset($title) && !empty($title) ? $title : "adhischools");?></title>
    <link href="<?php echo $this->config->item('css_url_path').load_css_files($css) ; ?>" rel="stylesheet" type="text/css" />
    <script  language="javascript">
		var base_url = "<?php echo base_url();?>";
	</script>
    <script language="JavaScript" src="<?php  echo $this->config->item('js_url_path').load_admin_js_files($js).'?'.time()  ; ?>"></script>
	
    <script language="JavaScript1.2">
            //Disable select-text script (IE4+, NS6+)
            function disableselect(e){
            return false
            }
            function reEnable(){
                    return true
            }
            //if IE4+
            document.onselectstart=new Function ("return false")
            //if NS6
            if (window.sidebar){
                    document.onmousedown=disableselect
                    document.onclick=reEnable
            }
    </script>
    <?php echo google_tracking_code();?>
    <style type="text/css"> @media print { body { display:none } } </style>
</head>
<body>
	
	<div class="outermaindiv">
		<div class="placelogo"><img  src="<?php  echo $this->config->item('images');?>adhi_logo.jpg"  alt="Real Estate Classes Los Angeles" title="Real Estate Classes Los Angeles" /></div>
		<div class="placeadhischool"><img  src="<?php  echo $this->config->item('images');?>adhischools.png" alt="adhischools" title="adhischools" /></div>
		<?php if($this->uri->segment(2)=='exam_start'){?>
		<div class="cb" id="exm_warn">
			<div class="ex_warn_img"><img src="<?php  echo $this->config->item('images');?>warn.png" /></div>
			<div class="ex_warn">Please don't refresh the exam window.<br>Please ensure your internet is connected during exam.</div>
		</div>
		<?php } ?>
		<div id="" style="padding-top:20px;">
			
			<div class="" >
