

<?php require_once 'template/header.php'; ?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>


<iframe id="idIframe" src="http://www.adhischools.com/iframe_user/register/isframe" style="overflow: hidden;border-style:none;" height="1200px" width="100%" ></iframe>



<script>
		var vHeight = null;
 		function iframeResize(vheight) {
 			vHeight = vheight;
 			console.log(" called ... ");
		    var iFrameID = document.getElementById('idIframe');
		    if(iFrameID) {
		          // here you can meke the height, I delete it first, then I make it again
		          iFrameID.height = "";
		          vHeight = (vHeight) ? vHeight : 35;
		          iFrameID.height = parseInt(iFrameID.contentWindow.document.body.scrollHeight)+ parseInt(vHeight) + "px";
		          
		          console.log(vHeight, iFrameID.height);
		    }   
	    }
   		
 	 	jQuery("#idIframe").load(function(){
		      iframeResize(vHeight);
		});
 	
</script>

<?php require_once 'template/footer.php'; ?> 