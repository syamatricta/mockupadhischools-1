<div class="floatleft" style="width:100%;">
	<div style="padding:5px 0px;font-weight:bold;">Events on <?php echo date('m/d/Y',strtotime($current_date));?></div>
	<div class="floatleft" style="background:#A80403;width:100%;color:white;padding:5px 0px 5px 0px;">
		<div class="floatleft" style="width:35%;margin-left:5px;">Region >> Sub-region</div>
		<div class="floatleft" style="width:20%;margin-left:3px;">Time</div>
		<div class="floatleft" style="width:10%;margin-left:3px;">Repeat status</div>
		<div class="floatleft" style="width:15%;margin-left:3px;">Repeat ends</div>
		<div class="floatleft" style="margin-left:5px;">Actions</div>
	</div>
	<div class="clearboth paddingtop"></div>
	<div class="floatleft" style="width:100%;">
	<?php if($arr_list){
		
			foreach ($arr_list as $val){ ?>
				<div class="floatleft" style="width:35%;margin-left:5px;"><?php echo $val->region.' >> '.$val->subregion;?> </div>
				<div class="floatleft" style="width:20%;margin-left:3px;"><?php echo $val->time_start.' '.$val->meridiean_start.' - '.$val->time_end.' '.$val->meridiean_end; ?></div>
				<div class="floatleft" style="width:10%;margin-left:3px;"><?php if($val->repeat_status==1){ echo 'Daily';}else if($val->repeat_status==2){echo 'Weekly';}else{ echo 'N/A';}?></div>
				<div class="floatleft" style="width:15%;margin-left:3px;"><?php if($val->repeat_status!=0){echo $val->repeat_ends;}else{echo 'N/A';}?></div>
				<div class="floatleft" style="margin-left:3px;">
					<span style="margin:0px 10px 0px 0px;"><a href="javascript: void(0);" onclick="javascript: fncViewEvents(<?php echo $val->master_id;?>);">View</a></span>
					<span style="margin:0px 10px 0px 0px;"><a href="javascript: void(0);" onclick="javascript: fncDisplayEditEvents(<?php echo $val->master_id;?>);">Edit</a></span>
					<span style="margin:0px 10px 0px 0px;"><a href="javascript: void(0);" onclick="javascript:return fncDeleteEvent(<?php echo $val->master_id;?>);">Delete</a></span>
				</div>
				<div class="clearboth paddingtop"></div>
<?php 		}
		
		}else{
			echo 'No records found';
		}?>
		<input type="hidden" name="hdnMasterid" id="hdnMasterid"/>
	</div>
</div>