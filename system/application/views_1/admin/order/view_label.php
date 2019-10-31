		<html><head>
		<STYLE MEDIA='screen'> .subbuttons { display : visible ;  } </STYLE>
		
		<STYLE MEDIA='print'> .subbuttons { display : none ; } </STYLE>
		
		<STYLE> .mainbuttons { display : none ; } </STYLE>
		
		<STYLE MEDIA='print'> .subbuttons1 { display : visible ; } </STYLE>
		
		<STYLE MEDIA='screen'> .subbuttons1 { display : visible; } </STYLE>
<style>
body{
margin: 0px auto 0px;
font-family:Arial, Helvetica, sans-serif;
}
DIV, TR, TD, SPAN, INPUT, SELECT{
	FONT-FAMILY: Arial, Helvetica, sans-serif;
	FONT-SIZE: 12px;
	text-align:left;
	 color:#660099;
}
img{
	border:0px;
}
.head_txt{

 height:25px; background-color:#cccccc; width:900px; color:#660099; text-align:center;}
</style>
		
		</head>
		<body >
		<center>
		<div class="subbuttons head_txt" ><a href="javascript:window.print()"><img alt="Print" src="<?php echo $this->config->item('images'); ?>icon_print.gif"/> print</a></div>
		<div class="clearboth"> </div>
		<div class="clearboth">&nbsp; </div>
		<div class="head_txt" >
			<img src="<?php echo $this->config->item('tmp_label').$img; ?>"  width="900" height="600">
		</div>
		
		</center>
		</body>
		</html>