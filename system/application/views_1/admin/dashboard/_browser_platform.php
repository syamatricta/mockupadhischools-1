<div class="chart_cont">
    <div class="browser_pie_cnt">
        <div class="pie_title">Browser type used by Visitors</div>
        <div id="piechart1" style="float:left;width: 390px; height: 390px;"></div>
    </div>
    <div class="platform_pie_cnt">
        <div class="pie_title">Platforms type used by Visitors</div>
        <div id="piechart2" style="float:left;width: 390px; height: 390px;"></div>
</div>
</div>
<div class="os_browser_comb_div">
    <div class="obcd_l">Top 5 Browser/Platform<br/>Combinations</div>
    <div class="obcd_r">
        <?php if($os_browser_data){
            foreach($os_browser_data as  $os_browser_data){
                echo '<span class="osbr_ti">'.$os_browser_data[0].' '.$os_browser_data[1].' '.$os_browser_data[2].' '.$os_browser_data[3].'</span><span class="osbr_sep">:</span><span class="osbr_count"> '.$os_browser_data[4].'</span>';
            }
        };?>
    </div>
</div>

<div class="os_browser_drop_div">
    <div class="osbdd_ti">Browser/Platform Combination</div>
    <select class="osbdd_select" id="osbdd_select_browser">
        <?php
            foreach($browser_data as $browser_data){
                $class_name = ($browser_data[2]) ? 'highlight': '';
                echo '<option class="'.$class_name.'" value="'.$browser_data[0].'">'.$browser_data[1].'</option>';
            }
        ?>
    </select>
    <select class="osbdd_select" id="osbdd_select_platform">
        <?php
            foreach($os_data as $os_data){
                $class_name = ($os_data[2]) ? 'highlight': '';
                echo '<option class="'.$class_name.'" value="'.$os_data[0].'">'.$os_data[1].'</option>';
            }
        ?>
    </select>
    <div class="combination_count">: <span id="browser_platform_count"></span></div>
</div>
