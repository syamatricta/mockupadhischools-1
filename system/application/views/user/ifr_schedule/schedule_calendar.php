<style type="text/css">
.cal_month_left{
	float:left; 
	padding-top:3px;
	padding-right:30px;
}
.cal_month_right{
	float:left; 
	padding-left:30px;
	padding-top:3px;
}
</style>

<div style="float:left;width:700px;margin-left: 200px;">
<div style="float:left; width:420px; padding-top:50px;">
	<center>
		<div style="width:300px; padding-left:90px">
			<div class="cal_month_left floatleft" style="padding-right:30px; ">
				<a rel="nofollow" href="javascript: void(0);" title="<?php echo $previous_month_text;?>" onclick="javascript: fncGetNextCalendar(<?php echo $previous_month;?>,'m',0);">
					<img  src="<?php echo base_url().'images/red_calendar_month_left.png'?>"/>
				</a>
			</div>
			<div class="fl divSheduleHeaderTag floatleft">
				<span><?php echo $current_month_text;$httd=0;?></span>
			</div>
			<div class="cal_month_right floatleft" style="padding-left:30px;">
				<a rel="nofollow" href="javascript: void(0);" title="<?php echo $next_month_text;?>" onclick="javascript: fncGetNextCalendar(<?php echo $next_month;?>,'m',1);">
					<img src="<?php echo base_url().'images/red_calendar_month_right.png'?>"/>
				</a>
			</div>
		</div>
	</center>
</div>
<div style="clear:both"></div>
<div style="float:left;width:420px;" >
<table cellspacing="0" id="tblCalendarId" align="right" border="0">
	<thead>
		<tr>
			<th>Sun</th>
			<th>Mon</th>
			<th>Tue</th>
			<th>Wed</th>
			<th>Thu</th>
			<th>Fri</th>
			<th>Sat</th>
		</tr>
	</thead>
	<tr>
	<?php
             $htrghdiv=0;
             $htrghdiv +=$total_rows *50;
             $htrghdiv +=50;
             $htrghdiv -=156;
            for($i=0; $i< $total_rows; $i++)
		{
			for($j=0; $j<7;$j++)
			{
				$day++;
                                $courseString ='';

				if($day>0 && $day<=$total_days_of_current_month)
				{
					//YYYY-MM-DD date format
					$date_form = "$current_year/$current_month/$day";
					$clsevt=0;
					echo '<td width="20"';

					//check if the date is today
                                        $evnttd=0;
                                        //$to_dat=date("d");
					if($date_form == $today)
					{
						echo ' id="today"';
					}else{
						echo ' id="'.$day.'"';$clsevt=1;

					}

					//check if any event stored for the date
					if(@array_key_exists($day,$events))
					{
                                            //if($to_dat !=$day){ $clsevt=1;}
                                            $clr=array();$crsnam=array();
                                                if(@array_key_exists($day,$events_clr)){
                                                    if($events_clr[$day] !=''){
                                                        $events_clorlis=explode(',',$events_clr[$day]);
                                                        sort($events_clorlis);
                                                        $t=0;
                                                        $courseString ='';
                                                        if(count($events_clorlis)>0){
	                                                        for($n=0;$n<count($events_clorlis);$n++){
	                                                            if($events_clorlis[$n] !=''){
	                                                                if(isset($crse_color[$events_clorlis[$n]])){
		                                                            	if(!@in_array($crse_color[$events_clorlis[$n]], $clr, true)){
		                                                                    $clr[$t]=$crse_color[$events_clorlis[$n]];
		                                                                    for($r=0;$r<count($events_crs);$r++){
		                                                                        if($events_crs[$r]['id']==$events_clorlis[$n]){
		                                                                            $crsnam[$t]=$events_crs[$r]['course_name'];
		                                                                            if($courseString!=='')
		                                                                                $courseString .= '<br/>* '.$crsnam[$t];
		                                                                            else
		                                                                                $courseString .= '* '.$crsnam[$t];
		                                                                        }
		                                                                    }
		                                                                    $t++;
		                                                                }
	                                                                }
	                                                            }
	                                                        }
                                                        }
                                                    }
                                                echo ' class="date_has_event" height="30"   onmouseover="javascript:return show_calclass('.$day.');" onmouseout="javascript:return hide_calclass('.$day.');" onClick="Javascript:return fncShowEventList('.$day.','.$current_month.','.$current_year.');"';
                                                }
						echo '>';
                                                echo '<div ';echo 'style="text-align:center; width:50px; font-size:20px; color:#000; padding-top:14px; z-index:300;"'; echo ' onmouseover="javascript:return show_calclass('.$day.');" onmouseout="javascript:return hide_calclass('.$day.');">'.$day;
                                                
                                                if($courseString!=''){
                                                		//echo '<span style="width:170px;">'.$courseString.'</span>';?>
<!--                                                   <span style="width:250px;">-->
                                                       <?php /* popup starts */ ?>
                                                      <?php 
                                                        $ct_day_class = "";
                                                        $ht1=46;
                                                        for($g=0;$g<$t;$g++){
                                                            $ht1 +=9;
                                                        } 
                                                        //Fix to show current day box
                                                        $datetime = date('Y-m-d H:i:s');
                                                        $convertdatetime = date('d',strtotime($datetime.'-8 hour'));
                                                        
                                                        if($day == $convertdatetime) {
                                                            $width = 210;
                                                            $htl = "80";
                                                            $ct_day_class = "cal_popup_width";
                                                        } else {
                                                            $width = 250;
                                                        }
                                                        ?>
                                                        <div  style="width:<?php echo $width;?>px;display: none;margin-top:-<?php echo $ht1;?>px;margin-left:-215px;position:absolute;" id="caldat_<?php echo $day;?>">
                                                             <?php  echo cal_popup_box_top($day);?>
                                                            <div class="cal_popup_content_main <?php echo $ct_day_class;?>"><?php echo $courseString;?></div>
                                                             <?php echo cal_popup_box_bottom($t,$day);?>
                                                         </div>
                                                        <?php /* popup ends */ ?>
<!--                                                       </span>-->
<!--                                                    </span>-->
                                                        <style type="text/css">
                                                         #caldat_<?php echo $day;?> {
                                                            position:absolute;
                                                             width:600px;
                                                             
                                                             z-index:1001;
                                                         }
                                                         </style>

                                               <?php }
                                                echo '</div>';
                                                echo '<div class="eventscrs1" style="margin-top:-40px;" >';
                                                if(count($clr)>0){

                                                	//gets all the class count to display the colors
                                                	$cntClass 	= count($clr);
                                                        $divWidth	= array(8);
                                                        
                                                	//manage to set the width according to the number of classes
                                                      
                                                        if(0 < $cntClass){
                                                            for($q=0;$q<$cntClass;$q++){
                                                                $r=0;
                                                                do{

                                                                    $divWidth[$r]=$div_width_crse[$q][$r];
                                                                    $color[$r]='#'.$clr[$r];
                                                                    $r++;
                                                                } while($r<=$q);


                                                            }
                                                        }else{
                                                		$divWidth[0] = '100%';
                                                		$color[0] = '	#F5D6D6';
                                                	}

                                                	for($b=0;$b<$cntClass;$b++){
                                                		$tempColor =  $color[$b];
                                                    	
                                                          //if($day != $convertdatetime) {      
                                                          ?>
                                                         
                                                         <div style="background:<?php echo $tempColor;?>;width:<?php echo $divWidth[$b];?>;height:50px;float:left;">&nbsp;</div>
                                               	<?php 
                                                         // }
                                                    }
                                                }
                                                else{ echo "&nbsp;&nbsp;";}
                                                
                                                
                                                
                                                echo '</div>';
                                                
                                        } // end of if(array_key_exists...)
					else
					{ echo ' >  '.$day;
						//if there is not event on that date then just close the <td> tag $current_year/$current_month/$day		
					}
					echo "</td>";
				}
				else
				{
					//showing empty cells in the first and last row
					echo '<td class="padding">&nbsp;</td>';
				}
			}
			echo "</tr><tr>";
		}

		?>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tfoot>
		<td colspan="2">
			<a rel="nofollow" href="javascript: void(0);" title="<?php echo $previous_year_text;?>" onclick="javascript: fncGetNextCalendar(<?php echo $previous_year;?>,'y',0);">
				<div class="view_prev_year_img"></div>
			</a>	
		</td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="2">
			<a  rel="nofollow" href="javascript: void(0);" title="<?php echo $next_year_text;?>" onclick="javascript: fncGetNextCalendar(<?php echo $next_year;?>,'y',1);">
				<div class="view_next_year_img"></div>
			</a>
		</td>
        </tfoot>
</table>
</div>
    <div style="float:left;width:200px; margin-left:20px; margin-top:<?php echo $htrghdiv;?>px">
        <?php if($course_list){
            foreach ($course_list as $data){
		echo '<div style="float:left;font-size:13px;color:#930F0D;width:210px;line-height:18px;background:url('.$this->config->item('sq_image_url').'small_77/'.@$crse_color[$data->id].'.png) no-repeat center left;padding:0 0 0 20px;">'.$data->course_name.'</div>';
	    }
	} ?>
    </div>

</div>
<div id="divDisplayEventList">&nbsp;</div>
<script>
function show_calclass(dayy){
     $('caldat_'+dayy).show();
}
function hide_calclass(dayy){
     $('caldat_'+dayy).hide();
}
function popup_close(id){
		$('caldat_'+dayy).hide();
	}
</script>