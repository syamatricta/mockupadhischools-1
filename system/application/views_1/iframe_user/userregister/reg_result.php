<div class="main_wrapper">		
       	<section>
        	<div class="register_desc">
                <h1><?php 

					  if("SUCCESS" == strtoupper($payment["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($payment["ACK"])) {
					  	echo "Payment Succefully Completed<br>";
					  }
						if(isset($msg)) echo $msg;
					?></h1>	
                 
         	</div>
           
            <div class="clearboth"></div>
			<div class="page_error" id="errordisplay"></div>
			<div  class="page_error" id="errordiv" ><?php if(isset($msg)) echo $msg; ?></div>
			<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("msg");   ?></div>
			<?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
			<?php 
 			
  			if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
			<div class="clearboth">&nbsp;</div>
              
	    </section>
</div><!--end of main_wrapper--> 