<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php header("HTTP/1.1 404 Not Found"); ?>
<html>
<head>
<title>Adhischools | Error</title>
 <?php
$baseurl = "http://".$_SERVER['SERVER_NAME'];
$baseurl.= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
?>

<link href="<?php echo $baseurl; ?>style/article_pages.css" rel="stylesheet" type="text/css" />
</head>
<body topmargin="0">
	<div class="outer_main_div">
	       <div class="header_space"></div>
	       <div id="inner_page_main_cntnr">
				<div class="floatleft">
			      	<div class="left_cntnr" style="position: relative;">
			          <!-- left content start -->
			
						<?php require_once('left_menus.php')?>
						<!-- left content end -->
			
			      	</div>
				    <div class="right_cntnr">
				        <div class="right_cntnr_bg_hd">
							 <div class="sitepagehead"><h1></h1></div>
				        </div>
				        <div class="right_cntnr_bg">
				        	<div class="message">
								<?php echo $message; ?>
							</div>
						</div>
				    </div>
				</div>
			</div>
		</div>
	 <div class="footer_img">&nbsp; </div>
</body>
</html>
<style type="text/css">
        body {
        font-family: Arial, Helvetica, sans-serif;
        text-align: left;
        padding: 0px;
        margin-top:0px;
        background:url(<?php echo $baseurl.'images/bg_01.jpg'?>) #000000 no-repeat center top;
        height:auto;
        }
        
 .message{
	float:left;
	margin:170px 0px 170px 0px;
	width:100%;
	text-align:center;
	font-size:18px;
	font-weight:bold;
	color:#A5CE34;
}
    </style>