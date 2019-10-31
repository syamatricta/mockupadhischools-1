<?php
    if($average_time_spent){
        foreach($average_time_spent as $ats){
?>
            <div class="ct_row">
                <div class="ct_td" style="width:542px;"><?php echo str_replace('//', '/', $ats[0].''.$ats[1]);?></div>
                <div class="ct_td" style="width:120px;"><?php echo round($ats[2],2);?></div>
            </div>
<?php   }?>
            <?php if('' != $paginate) {?><div class="pagination"><?php echo $paginate;?></div><?php }?>
<?php }else{?>
    <div class="ct_row"><div class="empty_data">No record found</div></div>
<?php } ?>
