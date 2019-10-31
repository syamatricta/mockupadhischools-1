<div class="dash_item_page">
    <div class="dip_head" style="margin-left:20px;margin-bottom:60px;clear:both;overflow: hidden;">
        <div class="dip_head_ti b">User registration via different sources</div>
        <div class="dip_head_sep">
            <?php foreach ($count as $key => $count){
                $title = '';
                switch($key){
                    case 'normal':
                        $title = 'Normal';
                        $color = '#35D4E5';break;                                
                    case 'living':
                        $title = 'Living Social';
                        $color = '#049CC2';break;
                    case 'amazon':
                        $title = 'Amazon';
                        $color = '#14BCD5';break;
                    case 'groupon':
                        $title = 'Groupon';
                        $color = '#9D8FF6';break;
                }
            ?>
            <div class="dip_head_sep_left" style="width:22%;background-color:<?php echo $color;?>"><?php echo '<span class="num_big">'.$count.'</span>';?></div>
            <?php }?>
        </div>
    </div>
    <div id="user_report_piechart1" style="height:700px;width:700px;overflow: hidden;">
        <?php echo ($show_chart == false) ? '<div class="no_record_found">No Records found</div>' : ''; ?>
    </div>
</div>