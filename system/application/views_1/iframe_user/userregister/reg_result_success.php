<div id="inner_page_main_cntnr">
	<div class="main_wrapper">		
	       	<section>
	        	<div class="success_desc">
	                <h1>Registration Completed Successfully</h1>	
	                 
	         	</div>
	           
	            <div class="clearboth"></div>
				<div class="page_error" id="errordisplay"></div>
				<div  class="page_error" id="errordiv" ><?php if(isset($msg)) echo $msg; ?></div>
				<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("msg");   ?></div>
				<div class="clearboth">&nbsp;</div>
	              
		    </section>
	</div><!--end of main_wrapper-->
</div>
<script type="text/javascript">
parent.iframeResize(450);
</script>