<div id ="recruiter_report">
    <div class="clearboth"> </div>
    <div class="rec_head" id="rec_head"> Recruiter Email Report</div>
    <div class="rec_piechart"> 
        <div id="piechart5" style="height:325px;"></div>  
    </div>
    <div class="rec_drop_div">
        <select name="recruiter"  id="rec_select_browser"  class="osbdd_select" onChange ="recruiterPlatformCount();" style="margin: 0% 0% 2% 2% ;">
                <option value="">All Brokerages</option>
                <?php
                    if(!empty($recruiter_detail)):
                        foreach($recruiter_detail as $recruiter):
                ?>
                        <option value="<?php echo $recruiter;?>"  <?php echo ((set_value('recruiter') == $recruiter) || (isset($data) && $data['recruiter_brokerage'] == $recruiter)) ? 'SELECTED' : '';?>><?php echo $recruiter;?></option>
                <?php endforeach; ?>
             <?php endif; ?>
        </select> 
        <div class="clearboth"> </div>
        <div class="admininnercontentdiv" style="color:#626262;">
                    <?php
                           $height = 0;
                           $height += (!empty($recruiter_data)) ? (count($recruiter_data)* 28) + 34: '34';
                           $height .= 'px';?>
                    <div align="center" class="floatleft rec_list_div" style="height:<?php echo $height; ?>;">
                    <?php 
                    if(!empty($recruiter_data)){
                            /* list headings starts here*/		
                    ?>
                    <div class="listdata">
                            <div class="clearboth"> </div>

                            <div class="admintopheads" style="background-color:#29b3cf;">
                                    <div class="adminlistheadings" style="width:10%; text-align:center;">Sl. No</div>
                                    <div class="adminlistheadings" style="width:20%;">Recruiter Name</div>
                                    <div class="adminlistheadings" style="width:25%;">Recruiter Email Id</div>
                                    <div class="adminlistheadings" style="width:20%;text-align:center">Brokerage</div>
                                    <div class="adminlistheadings" style="width:20%;text-align:right;">Mail Count</div>
                            </div>
                    </div>
                    <div class="clearboth"> </div>
            <?php  
                /* list headings ends here*/
                            $count=1; 
                            if ($this->uri->segment(3)){
                                    $count = $count+$this->uri->segment(3);
                            }
                            if(!empty($recruiter_data)){
                            foreach($recruiter_data as $data){
                                    $bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';
                                    /* data list starts here */ 
                                    ?>
                                    <div class="<?php print($bg_color);?>" style="padding: 7px 0;">

                                    <div class="floatleft" style="width:10%;  text-align:center;"><?php print $count;?></div>

                                    <div class="floatleft" style="width:20%;overflow: hidden;">      <?php echo $data['full_name']; ?>       </div>
                                    <div class="floatleft" style="width:30%;overflow: hidden;">      <?php echo $data['mail_id']; ?>       </div> 
                                    <div class="floatleft" style="width:30%;text-align:left;">&nbsp; <?php echo $data['brokerage']; ?>  </div> 
                                    <div class="floatleft" style="width:5%;text-align:left;">        <?php echo $data['count'];?>             </div>
                                 </div>
                            <div class="clearboth"> </div>
                            <?php $count++; 
                            /* data list ends here */ 			
                            } } ?>
                    <?php /* <div class="pagination"><?php  echo $paginate;?></div>
                    <div style="clear:both">&nbsp;</div>
                    <?php 
                    */
                    }else { 
                        if($brokerage == '') {?>
                            <div class="nodata">No Recruiter Email history during the selected date range</div>
                        <?php } else{ ?>
                            <div class="nodata">No Emails sent to this recruiter</div>
                    <?php } } ?>
                 </div>
          </div>
     </div>
</div>