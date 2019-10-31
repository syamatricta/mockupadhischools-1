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
	<meta name="description" content="<?php if (isset($meta_data['description'])) echo  strip_tags($meta_data['description']); ?>"  />
	<meta name="keywords" content="<?php if (isset($meta_data['keyword'])) echo strip_tags($meta_data['keyword']); ?>"  />
	<title><?php echo(isset($meta_data['page_title']) && !empty($meta_data['page_title'])) ? $meta_data['page_title'] : $title?></title>	
<SCRIPT LANGUAGE="JavaScript" SRC="<?php echo base_url(); ?>js/popcalendar.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="<?php echo base_url(); ?>js/userdetails.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="<?php echo base_url(); ?>js/prototype.js"></SCRIPT>
<link href="<?php echo base_url(); ?>style/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>style/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>style/admin_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
 var base_url = '<?php echo base_url(); ?>'
</script>

</head>
<body >
<div style="width:1024px;margin:auto;">
    <div style="background-color:grey;clear:both;">
        <div style="float:left;padding:5px;"> <?php echo anchor("user/profile","Profile");?>  </div>
        <div style="float:left;padding:5px;"> <?php echo anchor("user/exam","Examination");?> </div>
        <div style="float:left;padding:5px;">  <?php echo anchor("user/Quiz","Quiz");?>       </div>
        <div style="float:right;padding:5px;"> <?php echo anchor("user/logout","Logout");?>    </div>        
    </div>
    <div style="clear:both"></div>
