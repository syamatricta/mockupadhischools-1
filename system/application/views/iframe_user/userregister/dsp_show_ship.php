 <?php if(array_key_exists('error', $return_value) || count($return_value)==0):?>
 	<span class='red_star'>Please provide correct zipcode based on the selected state</span><br>
 	<div id='zipcode-correct-div' class='text_box_div'>
 		<input type="text" id='zipcode_correct' name = "zipcode_correct" value="" autocomplete="off" maxlength="5"/>
 	</div>
 	<div  class='rightsidedata_register' style="padding-left:5px;">
 		<input type="image" src="<?php echo base_url()?>images/innerpages/update.png" name="update_s_zipcode_btn" id="update_s_zipcode_btn" value="update" onclick="update_s_zipcode(); return false;" ><br>
 	</div>
 	<span id='zipcode_correct_error' class='red_star'></span>
 <?php else:?>
   <?php foreach($return_value as $return_value): ?>
	  <div  class="regcourcediv" style="height:20px;" >
		<div  class="filedforrate" >
                  <img class="shiprate_radios" src="<?php  echo ssl_url_img();?>radio_nonselection.png" width="13" height="13" id="ship<?php echo $return_value['methodno']; ?>" onclick="javascript:selectrate('<?php echo $return_value['methodno']; ?>');"/>
<!--		  <input type="radio" name="shipid" id="shipid" value="<?php echo $return_value['methodno']; ?>"   onclick="javascript:selectrate(this.value);" />-->
		  <input type="hidden" name="shiprate<?php echo $return_value['methodno']; ?>" id="shiprate<?php echo $return_value['methodno']; ?>" value="<?php echo $return_value['rate']; ?>"   />
		  <span onclick="javascript:selectrate('<?php echo $return_value['methodno']; ?>');"><?php  echo $return_value['service'] ." - "."$".$return_value['rate'] ; ?></span>
		 </div>
	  	</div>
	<?php  endforeach; ?>
	<div class="clearboth"></div>
	<div class="clearboth"><h4><i>Note : FedEx will not deliver to P.O. Boxes</i></h4></div>
<?php endif;?>
<div class="clearboth">&nbsp;</div>

 <input  type="hidden"  name="shipid" id="shipid" value="" />