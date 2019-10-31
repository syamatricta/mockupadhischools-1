<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" >
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo (isset($title) && !empty($title) ? $title : "adhischools");?></title>
	<link href="<?php echo $this->config->item('css_url_path').load_css_files($css) ; ?>" rel="stylesheet" type="text/css" />
	<script  language="javascript">
		var base_url = "<?php echo base_url();?>";
		var img_url = "<?php echo $this->config->item('images');?>";
	</script>
	
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
    <script language="JavaScript" src="<?php echo $this->config->item('js_url_path').load_admin_js_files($js).'?'.time()  ; ?>"></script>
</head>
<body>
	
	
	<div class="quizoutermaindiv">
		<div class="placelogo"><img  src="<?php  echo $this->config->item('images');?>adhilogo.jpg"  alt="Real Estate Classes Los Angeles" title="Real Estate Classes Los Angeles"/></div>
		<div class="placeadhischool"><img  src="<?php  echo $this->config->item('images');?>adhischools.jpg" alt="adhischools" title="adhischools" /></div>
		<div id="examinnerpagemain">
			<?php if(!isset($quiz_design)){?>
			<div class="innerbackground_left"><img  src="<?php  echo $this->config->item('images');?>innerpages/inner_background_left.jpg" /></div>
				<div class="innerbackground_middle">
			<?php } ?>	