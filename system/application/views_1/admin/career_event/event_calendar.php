<h2><?=$current_month_text?></h2>
<table cellspacing="0" id="tblCalendarId">
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
				
				if($day>0 && $day<=$total_days_of_current_month)
				{
					//YYYY-MM-DD date format
					$date_form = "$current_year/$current_month/$day";
					
					echo '<td';
					
					//check if the date is today
					if($date_form == $today)
					{
						echo ' id="today"';
					}else{
						echo ' id="'.$day.'"';
					}
					
					//check if any event stored for the date
					if(@array_key_exists($day,$events))
					{
						//adding the date_has_event class to the <td> and close it
						echo ' class="date_has_event">';
								echo '<div id="divDate" style="height:12px;width:15%;float:left;">';
									echo '<img title="add event" src="'.$this->config->item('images').'/innerpages/add.gif" onClick="Javascript:return fncShowAdd('.$day.','.$current_month.','.$current_year.');" />';
								echo '</div>';
								echo '<div style="float:left;width:85%;" onClick="Javascript:return fncShowEventList('.$day.','.$current_month.','.$current_year.');" >&nbsp;</div>';
								echo '<div class="clearboth"></div>';
								echo '<div style="text-align:center;height:40px;padding-top:6px;" onClick="Javascript:return fncShowEventList('.$day.','.$current_month.','.$current_year.');">'.$day.'</div>';
						
								//adding the eventTitle and eventContent wrapped inside <span> & <li> to <ul>
								echo '<div class="events">';
									echo '<ul>';
						
								/*foreach ($events as $key=>$event){ 
									if ($key == $day){
								  		foreach ($event as $single){					
									
											echo  '<li>';
												echo anchor("admin_schedule/event_edit/$single->id",'<span class="title">'.$single->subregion.'(by '.$single->user.')</span><span class="desc">'.$single->eventContent.'</span>');
											echo '</li>'; 
										} // end of for each $event
									}
										
								} // end of foreach $events*/
		
								echo '</ul></div>';
					} // end of if(array_key_exists...)
					else 
					{
						//if there is not event on that date then just close the <td> tag $current_year/$current_month/$day
						echo ' style="cursor:pointer;"  title="add event" onClick="Javascript:return fncShowAdd('.$day.','.$current_month.','.$current_year.');"> <div id="divDate" style="height:20px;"><img src="'.$this->config->item('images').'/innerpages/add.gif"/></div><div style="text-align:center;height:40px;">'.$day.'</div>';
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
			<th><a href="javascript: void(0);" title="<?php echo $previous_year_text;?>" onclick="javascript: fncGetNextCalendar(<?php echo $previous_year;?>);"><?php echo '&laquo;&laquo;';?></a>
				<?php //echo anchor($calendar_path.$previous_year,'&laquo;&laquo;', array('title'=>$previous_year_text));?>
			</th>
			<th><a href="javascript: void(0);" title="<?php echo $previous_month_text;?>" onclick="javascript: fncGetNextCalendar(<?php echo $previous_month;?>);"><?php echo '&laquo;';?></a>
				<?php //echo anchor($calendar_path.$previous_month,'&laquo;', array('title'=>$previous_month_text));?>
			</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th><a href="javascript: void(0);" title="<?php echo $next_month_text;?>" onclick="javascript: fncGetNextCalendar(<?php echo $next_month;?>);"><?php echo '&raquo;';?></a>
				<?php //echo anchor($calendar_path.$next_month,'&raquo;', array('title'=>$next_month_text));?>
			</th>
			<th><a href="javascript: void(0);" title="<?php echo $next_year_text;?>" onclick="javascript: fncGetNextCalendar(<?php echo $next_year;?>);"><?php echo '&raquo;&raquo;';?></a>
				<?php //echo anchor($calendar_path.$next_year,'&raquo;&raquo;', array('title'=>$next_year_text));?>
			</th>		
	</tfoot>
</table>
<input type="hidden" id="hdnTimeid" name="hdnTimeid" value="<?php if($sec_timing){ echo $sec_timing;}else{ echo '0';}?>" />
<script>disable_refresh(this);</script>