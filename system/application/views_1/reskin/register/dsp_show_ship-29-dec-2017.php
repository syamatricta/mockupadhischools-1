<?php 
 if(array_key_exists('error', $return_value) || count($return_value)==0) :?>
 	<P class='red_star'>Please provide correct zipcode based on the selected state</P>
 	<div class="form-inline">
 		<div id='zipcode-correct-div' class='form-group'>
	 		<input type="text" id='zipcode_correct' class="form-control" name = "zipcode_correct" value="" autocomplete="off" maxlength="5"/>
	 	</div>
	 	<input class=" btn-adhi" type="button" name="update_s_zipcode_btn" id="update_s_zipcode_btn" value="Update">
 	</div>
 	<p id='zipcode_correct_error' class='red_star'></p>  
 <?php else:?> 	
    <div class="row">
   <?php
        foreach($return_value as $return_value): 
            if('FEDEX_GROUND' != $return_value['methodno']){continue;}
   ?>
        <div  class="filedforrate col-sm-6" >
            <div  class="filedforrate" >
                <div class="radio radio-danger"  style="margin:0;">
                        <input  id="ship<?php echo $return_value['methodno']; ?>" data-method="<?php echo $return_value['methodno']; ?>"  type="radio"  name="shiprate_radios" data-shiptate="<?php echo $return_value['rate']; ?>">
                        <label for="ship<?php echo $return_value['methodno']; ?>"><?php  echo $return_value['service'] ." - "."$".$return_value['rate'] ; ?></label>
                </div>                  
                <input type="hidden" name="shiprate<?php echo $return_value['methodno']; ?>" id="shiprate<?php echo $return_value['methodno']; ?>" value="<?php echo $return_value['rate']; ?>"   />
             </div>
        </div>
		 
	<?php  endforeach; ?>	
	<div class="col-sm-6 text-right color-note"><i>Note : FedEx will not deliver to P.O. Boxes</i></div>
    </div>
<?php endif;?>
 <input  type="hidden"  name="shipid" id="shipid" value="" /> 
 