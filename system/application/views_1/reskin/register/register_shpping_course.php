
<div class="class_ship margin20">Please select shipping method below</div>
 
<div id="shipbutton" class="margin20">
<?php if(isset($this->regdata) && ($this->regdata['course_usertype'] == 1 || $this->regdata['course_usertype'] == 3 )){?>
    <a href="#" class="show_ship_btn_broker"><i class="fa fa-arrow-right"></i>&nbsp;SHOW SHIP METHODS</a>
<?php } else {?>
     <a  href="#" class="show_ship_btn"><i class="fa fa-arrow-right"></i>&nbsp;SHOW SHIP METHODS</a>
<?php } ?>
</div>
<div id="mygif"  style="display:none;"></div>	
<div id="showship" class="margin20" style="display:none;" ></div>
 

<div  class="filedforrate">
	<input type="hidden" name="price"  id="price"  value="0" />
	<input type="hidden" name="shipprice"  id="shipprice"  value="0" />
	<input type="hidden" name="totalprice"  id="totalprice"  value="0" />
	<input type="hidden" name="curyear"  id="curyear"  value="<?php echo convert_UTC_to_PST_year(date('Y-m-d H:i:s'));?>" />
	<input type="hidden" name="curmonth"  id="curmonth"  value="<?php echo convert_UTC_to_PST_month(date('Y-m-d H:i:s'));?>" />
</div>
 
<?php if(isset($this->regdata) && ($this->regdata['course_usertype'] == 1 || $this->regdata['course_usertype'] == 3 )){?>
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
 
<div id="grid">
	<table class="table table-bordered" id="gridtable" style="display: none">
 		<tr class="gridheading">
			<th width="75%">COURSE NAME</th>	
			<th class="darkgray text-center" align="center">AMOUNT($)</th>	
		</tr>		 
		<tr>
			<td align="right">Ship rate </td>
			<td id="shiprate" class="prcolor" align="center">$0.0</td>
		</tr>
		<tr>
			<td align="right" class="totlabel">Total Price</td>
			<td class="totparice" id="gridtotalprice" align="center">$0.0</td>
		</tr>
	</table>
</div>
 
 