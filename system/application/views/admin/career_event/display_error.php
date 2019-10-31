<div class="page_error" align="center"  id="errordisplay">
	<?php 
	if($this->session->flashdata($msg))echo $this->session->flashdata($msg);
	if($msg)echo $msg;
	?>
</div>