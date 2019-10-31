<div class="admin_subhead_txt">Please select shipping method below</div>
<div class="clearboth">&nbsp;</div>
<div  class="filedforrate" id="shipbutton" style="display:block"  >
<?php if($this->session->userdata('course_usertype') == 1 || $this->session->userdata('course_usertype') == 3 ){?>
	<img  src="<?php  echo ssl_url_img();?>innerpages/show_ship.jpg" onclick="javascript:checkpackageshipmethod();" class="stylebutton"  />
<?php } else {?>
	<img  src="<?php  echo ssl_url_img();?>innerpages/show_ship.jpg" onclick="javascript:checkshipmethod();" class="stylebutton"  />
<?php } ?>
</div>
<div id="mygif"  style="display:none;"></div>	
<div  class="filedforrate" id="showship" style="display:none;" ></div>
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
	<input type="hidden" name="totalweightb"  id="totalweightb"  value="<?php echo (isset($total_weight))?$total_weight:'';?>" />
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
	<!--<div  class="filedforrate " id="grid"></div>-->
<div class="clearboth">&nbsp;</div>