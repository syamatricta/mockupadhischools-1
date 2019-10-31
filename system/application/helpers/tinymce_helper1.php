<?php
if(!function_exists('enable_tiny_mce'))
{
	function enable_tiny_mce ($elementID, $theme = 'advanced'){	?>
		 <script type="text/javascript" src="<?php echo base_url();?>jscripts/tiny_mce/tiny_mce.js"></script> 
		 <script type="text/javascript">
			tinyMCE.init({
				mode : "exact",
				elements : "<?php echo($elementID); ?>", 
				theme : "<?php print($theme); ?>",
				convert_urls : false,
				plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
				theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,cut,copy,paste,|",
				theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,|,sub,sup,|,anchor,image,cleanup,code,|,insertdate,inserttime,preview,|",
				theme_advanced_buttons3 : "forecolor,backcolor,styleprops,fontselect,fontsizeselect",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_statusbar_location : "bottom",
				theme_advanced_resizing : true,				
				content_css : './../style/style.css',
				template_external_list_url : "lists/template_list.js",
				external_link_list_url : "lists/link_list.js",
				external_image_list_url : 'upload_Image_list.php',
				media_external_list_url : "lists/media_list.js"
			});
		</script>
	<?php
	}
}
?>
