<div class="subhead_txt">The candidates can select shipping method from one of the below</div>
<div class="clearboth">&nbsp;</div>
<div  class="filedforrate" id="shipbutton" style="display:block"  >
	<img  src="<?php  echo ssl_url_img();?>innerpages/show_ship.jpg" onclick="javascript:checkshipmethod();" class="stylebutton"  />
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
<div  class="filedforrate"> 
	<input type="hidden" name="totalweight"  id="totalweight"  value="0" />
	<input type="hidden" name="totalweightb"  id="totalweightb"  value="0" />
	<input type="hidden" name="subcourseweight" id="subcourseweight" value="0"  />
	<input  type="hidden" name="step2"  id="step2" value="2" />
</div>


<div class="clearboth">&nbsp;</div>
	<div  class="filedforrate " id="grid"></div>
<div class="clearboth">&nbsp;</div>