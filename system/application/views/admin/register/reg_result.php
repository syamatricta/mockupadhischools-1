<div class="registermaindiv">
	<div class="registerinnerdiv">
  <div  class="form-fields head_txt"> <?php 

  if("SUCCESS" == strtoupper($payment["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($payment["ACK"])) {
  echo "Payment Succefully Completed<br>";
 }
if(isset($msg)) echo $msg;
	?></div>
  </div>
  </div>