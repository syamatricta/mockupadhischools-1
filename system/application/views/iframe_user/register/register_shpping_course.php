<h4>Please select shipping method below</h4>
<div  class="filedforrate" style="padding-top:20px;" id="shipbutton" style="display:block"  >
<?php if($this->session->userdata('course_usertype') == 1 || $this->session->userdata('course_usertype') == 3 ){?>
<!--	<img  src="<?php  echo ssl_url_img();?>innerpages/show_ship.png" onclick="javascript:checkpackageshipmethod();" class="stylebutton show_ship_btn"  />-->
	
	<div class="payment_Details_wrapper">
    	<hr>
        <input type="button" class="button_orange btn_shipping" value="Shipping Methods" onclick="javascript:checkpackageshipmethod();return false;"> 
    </div>

    <!--a href="javascript:void(null);" onclick="javascript:checkpackageshipmethod();return false;" class="show_ship_btn">&nbsp;</a-->
<?php } else {?>
<!--	<img  src="<?php  echo ssl_url_img();?>innerpages/show_ship.png" onclick="javascript:checkshipmethod();" class="stylebutton show_ship_btn"  />-->
    <div class="payment_Details_wrapper">
    	<hr>
        <input type="button" class="button_orange btn_shipping" value="Shipping Methods"  onclick="javascript:checkshipmethod();return false;"> 
    </div>
    
    <!--a href="javascript:void(null);" onclick="javascript:checkshipmethod();return false;" class="show_ship_btn">&nbsp;</a-->
<?php } ?>
</div>
<div id="mygif"  style="display:none;"></div>	
<div  class="filedforrate margin-left58" id="showship" style="display:none;" ></div>
<div class="clearboth"></div>

<div  class="filedforrate">
	<input type="hidden" name="price"  id="price"  value="0" />
	<input type="hidden" name="shipprice"  id="shipprice"  value="0" />
	<input type="hidden" name="totalprice"  id="totalprice"  value="0" />
	<input type="hidden" name="curyear"  id="curyear"  value="<?php echo convert_UTC_to_PST_year(date('Y-m-d H:i:s'));?>" />
	<input type="hidden" name="curmonth"  id="curmonth"  value="<?php echo convert_UTC_to_PST_month(date('Y-m-d H:i:s'));?>" />
</div>
<div class="clearboth"></div>
<?php /* total weight */?>
<?php if($this->session->userdata('course_usertype') == 1 || $this->session->userdata('course_usertype') == 3 ){?>
	<input type="hidden" name="totalweight"  id="totalweight"  value="0" />
	<input type="hidden" name="totalweightb"  id="totalweightb"  value="<?php echo (isset($total_weight))?$total_weight:'';?>"/>
	<input  type="hidden" name="step3"  id="step3" value="3" />
<?php } else {?>
<div  class="filedforrate"> 
	<input type="hidden" name="totalweight"  id="totalweight"  value="0" />
	<input type="hidden" name="totalweightb"  id="totalweightb"  value="0" />
	<input type="hidden" name="subcourseweight" id="subcourseweight" value="0"  />
	<input  type="hidden" name="step3"  id="step3" value="3" />
</div>
<?php } ?>

<div class="clearboth">&nbsp;</div>
<div  class="filedforrate margin-left58 " id="grid"></div>
<div class="clearboth">&nbsp;</div>
