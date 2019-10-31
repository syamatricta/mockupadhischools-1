<div class="subhead_txt margin-left58">Please select shipping method below</div>
<div class="clearboth">&nbsp;</div>
<div  class="filedforrate margin-left58" id="shipbutton" style="display:block"  >
<?php if($this->session->userdata('course_usertype') == 1 || $this->session->userdata('course_usertype') == 3 ){?>
<!--	<img  src="<?php  echo ssl_url_img();?>innerpages/show_ship.png" onclick="javascript:checkpackageshipmethod();" class="stylebutton show_ship_btn"  />-->
    <a rel="nofollow" href="javascript:void(null);" onclick="javascript:checkpackageshipmethod();hidealert();return false;" class="show_ship_btn">&nbsp;</a>
<?php } else {?>
<!--	<img  src="<?php  echo ssl_url_img();?>innerpages/show_ship.png" onclick="javascript:checkshipmethod();" class="stylebutton show_ship_btn"  />-->
        <a rel="nofollow" href="javascript:void(null);" onclick="javascript:checkshipmethod();hidealert();return false;" class="show_ship_btn">&nbsp;</a>
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

<script>
function show() {
    document.getElementById("errordiv").style.display = "none";
    document.getElementById("close_button").style.display = "none";
}
function hidealert() {
    setTimeout("show()", 9000);  
}
setTimeout("show()", 9000);  
</script>