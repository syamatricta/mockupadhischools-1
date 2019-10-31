<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<div class="dash_outer fl">
	<div class="dash_l_box fl">
		<div class="box_head fl" style="font-size:17px;">Active User : 30</div>
		<div class="box_head mt10 fl">Visitors Analysis</div>
		<div class="dash_lin_box fl">
			<div class="view_more"><a href="#">View More</a></div>
			<div class="count_row fl">
				<div class="dash_icon uniq_icon fl"></div>
				<span class="fl">Unique User</span>
				<div class="dash_cnt fr">12</div>
			</div>
			<div class="subcount_row fl">
				<span class="fl">Guest User</span>
				<div class="dash_cnt fr">12</div>
			</div>
			<div class="subcount_row fl">
				<span class="fl">Active User</span>
				<div class="dash_cnt fr">12</div>
			</div>
			<div class="dotted_hr"></div>
			<div class="count_row fl">
				<div class="dash_icon act_icon fl"></div>
				<span class="fl">Active User</span>
				<div class="dash_cnt fr">12</div>
			</div>
			<div class="subcount_row fl">
				<span class="fl">Guest User</span>
				<div class="dash_cnt fr">12</div>
			</div>
			<div class="subcount_row fl">
				<span class="fl">Active User</span>
				<div class="dash_cnt fr">12</div>
			</div>
		</div>
		<div class="box_head mt20 fl">Exam Reports</div>
		<div class="dash_lin_box fl">
			<div class="view_more"><a href="#">View More</a></div>
			<div class="count_row fl">
				<div class="dash_icon pass_icon fl"></div>
				<span class="fl">Passed</span>
				<div class="dash_cnt fr">12</div>
			</div>
			<div class="dotted_hr"></div>
			<div class="count_row fl">
				<div class="dash_icon fail_icon fl"></div>
				<span class="fl">Failed</span>
				<div class="dash_cnt fr">12</div>
			</div>
			<div class="subcount_row fl">
				<span class="fl">Unexpectedly Ended</span>
				<div class="dash_cnt fr">12</div>
			</div>
			<div class="dotted_hr"></div>
			<div class="count_row fl">
				<div class="dash_icon ongoing_icon fl"></div>
				<span class="fl">Ongoing</span>
				<div class="dash_cnt fr">12</div>
			</div>
		</div>
		<div class="box_head mt20 fl">Browser & Platform Used</div>
		<div class="dash_lin_box fl">
			<div class="view_more"><a href="#">View More</a></div>
                        <?php foreach($browser_data as $key => $browser_data ){ if($key == 3){break;}?>
			<div class="count_row fl">
                            <div class="dash_icon <?php echo icon_class($browser_data->getBrowser());?>_icon fl"></div>
				<span class="fl"><?php echo $browser_data;?></span>
				<div class="dash_cnt fr"><?php echo $browser_data->getPageviews();?></div>
			</div>
			<div class="dotted_hr"></div>
			<?php } ?>
                        
                        <?php foreach($os_data as $key => $os_data ){ if($key == 3){break;}?>
			<div class="count_row fl">
				<div class="dash_icon <?php echo icon_class($os_data->getOperatingSystem());?>_icon fl"></div>
				<span class="fl"><?php echo $os_data;?></span>
				<div class="dash_cnt fr"><?php echo $os_data->getPageviews();?></div>
			</div>
			<div class="dotted_hr"></div>
			<?php } ?>
		</div>
	</div>
	<div class="dash_r_box fl">
		<div class="searchbox fl">
                    <form name="frmadhischool" id="frmadhischool">
			From <input type="text" name="date_from" id="date_from" class="searchtxtbox" onclick="displayCalendar(document.frmadhischool.date_from,'mm/dd/yyyy',this)">
			&nbsp;&nbsp;To <input type="text" name="date_to" id="date_to" class="searchtxtbox" onclick="displayCalendar(document.frmadhischool.date_to,'mm/dd/yyyy',this)">
			<input type="button" class="searchbtn" value="Search">
                    </form>
		</div>
		<div class="mt20 fl">
			<div class="boxr_head fl">User Reports</div>
			<div class="boxr_head_spc fl"></div>
			<div class="boxr_head fl">Visitors Analysis</div>
			<div class="boxr_head_spc fl"></div>
			<div class="boxr_head fl">Course</div>
			<div class="boxr_head_spc fl"></div>
			<div class="boxr_head fl">Exam Reports</div>
			<div class="boxr_head_spc fl"></div>
			<div class="boxr_head_sel fl">Browser & Platform Used</div>
		</div>
		<div class="fl dash_rpt">
                    <div id="piechart1" style="float:left;width: 350px; height: 400px;"></div>
                    <div id="piechart2" style="float:left;margin-left:10px;width: 350px; height: 400px;"></div>
                    <div class="os_browser_comb_div">
                        <div class="obcd_l">Top 5 Browser/Platform<br/>Combinations</div>
                        <div class="obcd_r">
                            <?php if($os_browser_data){
                                foreach($os_browser_data as  $os_browser_data){
                                    echo $os_browser_data.'<br/>';
                                }
                            };?>
                        </div>
                    </div>
		</div>
            
	</div>
</div>

 <script type="text/javascript">
     
        Array.prototype.reduce = undefined;
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(
                [<?php echo $browser_pie_object;?>]
                );

        var options = {
          width: 390,
          title: 'Browser type used by Visitors',
          legend: 'none',
          pieSliceText: 'label',
          colors: ['#049CC2', '#14B9D5', '#1586D7', '#9D8FF6', '#35D4E5'],
          pieSliceBorderColor: 'transparent'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart1'));
        chart.draw(data, options);
        
        var data = google.visualization.arrayToDataTable(
                [<?php echo $os_pie_object;?>]
                );

        var options = {
          width: 390,
          title: 'Platforms type used by Visitors',
          legend: 'none',
          pieSliceText: 'label',
          colors: ['#049CC2', '#14B9D5', '#1586D7', '#9D8FF6', '#35D4E5'],
          pieSliceBorderColor: 'transparent'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
        chart.draw(data, options);
      }
      
      
    </script>