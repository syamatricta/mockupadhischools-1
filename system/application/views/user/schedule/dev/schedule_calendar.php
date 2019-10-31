<div id="divHeaderTag">
	<div class="head_left"><img src="<?php echo base_url().'images/calendar_left.jpg'?>"/></div>

	<div class="head_right">
		<h2><?=$current_month_text?></h2>
	</div>
</div>
<div style="float:left;width:893px;">
<div style="float:left;width:620px;" >
<table cellspacing="0" id="tblCalendarId" align="right">
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
					echo '<td';

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
                                                //if($clr>0){ $httd=50 + (10 *count($clr)) ;}else{ $httd=50;}


						//adding the date_has_event class to the <td> and close it
                                                if($clsevt >0){
                                                    echo ' class="tooltip" height="50" width="80" onClick="Javascript:return fncShowEventList('.$day.','.$current_month.','.$current_year.');"';
                                                }else{
                                                    echo ' class="date_has_event tooltip" height="50" width="80" onClick="Javascript:return fncShowEventList('.$day.','.$current_month.','.$current_year.');"';
                                                }
                                                }
						//echo ' class="date_has_event tooltip" height="50" width="80" onClick="Javascript:return fncShowEventList('.$day.','.$current_month.','.$current_year.');"';}
                                                echo '>';
                                                //echo $day;
                                                //echo "<br>";
                                                 echo '<div class="eventscrs'.$clsevt.' >';
                                                if(count($clr)>0){

                                                	//gets all the class count to display the colors
                                                	$cntClass 	= count($clr);
                                                        $divWidth	= array(8);
                                                        //print_r($clr);
                                                	//


                                                	//manage to set the width according to the number of classes
                                                      //  print_r($div_width_crse);
                                                      //echo $cntClass;
                                                        if(0 < $cntClass){
                                                            for($q=0;$q<$cntClass;$q++){
                                                                $r=0;
                                                                do{

                                                                    $divWidth[$r]=$div_width_crse[$q][$r];
                                                                    $color[$r]='#'.$clr[$r];
                                                                    $r++;
                                                                } while($r<=$q);


                                                            }
                                                        }

                                                	/*if(1==$cntClass){
                                                		$divWidth[0] = '100%';

                                                		$color[0] 	= '#EBC1BF';

                                                	}else if(2==$cntClass){
                                                		$divWidth[0] = '50%';
                                                		$divWidth[1] = '50%';

                                                		$color[0] 	= '#EBC1BF';
                                                                $color[1] 	= '#DBDEA4';

                                                	}else if(3==$cntClass){
                                                		$divWidth[0] 	= '33%';
                                                		$divWidth[1] 	= '34%';
                                                		$divWidth[2] 	= '33%';
                                                		$color[0] 	= '#EBC1BF';
                                                                $color[1] 	= '#DBDEA4';
                                                                $color[2] 	= '#A8D8E8';

                                                	}else if(4==$cntClass){
                                                		$divWidth[0] 	= '25%';
                                                		$divWidth[1] 	= '25%';
                                                		$divWidth[2] 	= '25%';
                                                                $divWidth[3] 	= '25%';
                                                		$color[0] 	= '#EBC1BF';
                                                                $color[1] 	= '#DBDEA4';
                                                                $color[2] 	= '#A8D8E8';
                                                                $color[3] 	= '#B5F49A';

                                                	}else if(5==$cntClass){
                                                		$divWidth[0] 	= '20%';
                                                		$divWidth[1] 	= '20%';
                                                		$divWidth[2] 	= '20%';
                                                                $divWidth[3] 	= '20%';
                                                                $divWidth[4] 	= '20%';
                                                		$color[0] 	= '#EBC1BF';
                                                                $color[1] 	= '#DBDEA4';
                                                                $color[2] 	= '#A8D8E8';
                                                                $color[3] 	= '#B5F49A';
                                                                $color[4] 	= '#E2D289';

                                                	}
                                                        else if(6==$cntClass){
                                                		$divWidth[0] 	= '17%';
                                                		$divWidth[1] 	= '17%';
                                                		$divWidth[2] 	= '16%';
                                                                $divWidth[3] 	= '17%';
                                                                $divWidth[4] 	= '16%';
                                                                $divWidth[5] 	= '17%';
                                                		$color[0] 	= '#EBC1BF';
                                                                $color[1] 	= '#DBDEA4';
                                                                $color[2] 	= '#A8D8E8';
                                                                $color[3] 	= '#B5F49A';
                                                                $color[4] 	= '#E2D289';
                                                                $color[5] 	= '#F0FE57';

                                                	}
                                                        else if(7==$cntClass){
                                                		$divWidth[0] 	= '15%';
                                                		$divWidth[1] 	= '14%';
                                                		$divWidth[2] 	= '14%';
                                                                $divWidth[3] 	= '14%';
                                                                $divWidth[4] 	= '14%';
                                                                $divWidth[5] 	= '14%';
                                                                $divWidth[6] 	= '15%';
                                                		$color[0] 	= '#EBC1BF';
                                                                $color[1] 	= '#DBDEA4';
                                                                $color[2] 	= '#A8D8E8';
                                                                $color[3] 	= '#B5F49A';
                                                                $color[4] 	= '#E2D289';
                                                                $color[5] 	= '#F0FE57';
                                                                $color[6] 	= '#E8E2DF';

                                                	}
                                                         else if(8==$cntClass){
                                                		$divWidth[0] 	= '13%';
                                                		$divWidth[1] 	= '12%';
                                                		$divWidth[2] 	= '13%';
                                                                $divWidth[3] 	= '12%';
                                                                $divWidth[4] 	= '13%';
                                                                $divWidth[5] 	= '12%';
                                                                $divWidth[6] 	= '13%';
                                                                $divWidth[7] 	= '12%';
                                                		//$color[0] 	= '#F5D6D6';
                                                		//$color[1] 	= '#FAFAD1';
                                                		//$color[2] 	= '#ADD8E6';
                                                                //$color[3] 	= '#EEE685';
                                                               // $color[4] 	= '#CDFFB3';
                                                                //$color[5] 	= '#EED8AE';
                                                                //$color[6] 	= '#EEE5DE';
                                                                //$color[7] 	= '#FFC1C1';
                                                                $color[0] 	= '#EBC1BF';
                                                                $color[1] 	= '#DBDEA4';
                                                                $color[2] 	= '#A8D8E8';
                                                                $color[3] 	= '#B5F49A';
                                                                $color[4] 	= '#E2D289';
                                                                $color[5] 	= '#F0FE57';
                                                                $color[6] 	= '#E8E2DF';
                                                                $color[7] 	= '#F8AB93';

                                                	}*/

                                                        else{
                                                		$divWidth[0] = '100%';
                                                		$color[0] = '	#F5D6D6';
                                                	}

                                                	for($b=0;$b<$cntClass;$b++){
                                                		$tempColor =  $color[$b];?>
                                                    	
                                                    	<div style="background:<?php echo $tempColor;?>;width:<?php echo $divWidth[$b];?>;height:30px;float:left;">&nbsp;</div>
                                               	<?php }
                                                }
                                                else{ echo "&nbsp;&nbsp;";}
                                                	echo '<div ';
                                                        /*if($clsevt !=''){ echo $clsevt;}else {*/ echo 'style="position:relative;vertical-align:top;z-index:300;"'; /*}*/ echo '>'.$day.'</div>';
                                                echo '</div>';
                                                if($courseString!=''){
                                                        echo '<span>'.$courseString.'</span>';
                                                }


								//adding the eventTitle and eventContent wrapped inside <span> & <li> to <ul>
								//echo '<div class="events">&nbsp;';
									//echo '<ul>';

								/*foreach ($events as $key=>$event){
									if ($key == $day){
								  		foreach ($event as $single){

											echo  '<li>';
												echo anchor("admin_schedule/event_edit/$single->id",'<span class="title">'.$single->subregion.'(by '.$single->user.')</span><span class="desc">'.$single->eventContent.'</span>');
											echo '</li>';
										} // end of for each $event
									}

								} // end of foreach $events*/

								//echo '</ul></div>';
					} // end of if(array_key_exists...)
					else
					{
						//if there is not event on that date then just close the <td> tag $current_year/$current_month/$day

						echo ' > <div style="width:80px;height:30px;float:left;">&nbsp;</div><div ';
                                                if($clsevt>0){ echo 'style="width:80px;height:20px;float:left;background:#C1CDCD;"'; }else{ echo 'style="width:80px;height:20px;float:left;background:#25587E;"'; } echo ' >'.$day.'</div>';
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

	<tfoot>
			<th>
				<a href="javascript: void(0);" title="<?php echo $previous_year_text;?>" onclick="javascript: fncGetNextCalendar(<?php echo $previous_year;?>,'y',0);"><?php echo '&laquo;&laquo;';?></a>
			</th>
			<th>
				<a href="javascript: void(0);" title="<?php echo $previous_month_text;?>" onclick="javascript: fncGetNextCalendar(<?php echo $previous_month;?>,'m',0);"><?php echo '&laquo;';?></a>
			</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>
				<a href="javascript: void(0);" title="<?php echo $next_month_text;?>" onclick="javascript: fncGetNextCalendar(<?php echo $next_month;?>,'m',1);"><?php echo '&raquo;';?></a>
			</th>
			<th>
				<a href="javascript: void(0);" title="<?php echo $next_year_text;?>" onclick="javascript: fncGetNextCalendar(<?php echo $next_year;?>,'y',1);"><?php echo '&raquo;&raquo;';?></a>
			</th>
	</tfoot>
</table>
</div>
    <div style="float:right;width:230px;margin-top: 280px;">
        <?php if($course_list){
            foreach ($course_list as $data){
		echo '<div style="float:left;font-size:11px;color:#7E7E7E;width:210px;line-height:14px;background:url('.$this->config->item('sq_image_url').'small_77/'.$crse_color[$data->id].'.png) no-repeat center left;padding:0 0 0 20px;">'.$data->course_name.'</div>';
	    }
	} ?>
    </div>

</div>
<div id="divDisplayEventList">&nbsp;</div>