<?php echo form_open($this->current_controller, array('name' => 'frmadhischool', 'id' => 'frmadhischool')); ?>
<div class="adminmainlist">
    <div class="adminpagebanner">
            <div class="adminpagetitle"><?php echo $page_title?></div>
    </div>
    <div class="clearboth"></div>
    <?php
    if (count($orderdet) > 0) {
        ?>
        <div class="admininnercontentdiv">
            <div class="addressdivisionleft"><strong>Order details of <?php echo $userdetails->firstname . " " . $userdetails->lastname ?> </strong></div>
            <div class="clearboth"> &nbsp;</div>

            <div class="listdata">
                <?php $count = 1;
                foreach ($orderdet as $data) {
                    ?>
                    <div class="leftsideheadings_view">Order Id</div>
                    <div class="middlecolon">:</div>
                    <div class="rightsidedata_view"><strong><?php echo "# " . $data->id; ?></strong></div>
                    <div class="clearboth"></div>
                    <div class="leftsideheadings_view">Transaction Id</div>
                    <div class="middlecolon">:</div>
                    <div class="rightsidedata_view"><?php echo "-" ?></div>
                    <div class="clearboth"></div>
                    <div class="leftsideheadings_view">User Name</div>
                    <div class="middlecolon">:</div>
                    <div class="rightsidedata_view"><?php if (!empty($userdetails)) {
                echo $userdetails->firstname . " " . $userdetails->lastname;
            } ?></div>
                    <div class="clearboth"></div>
                    <div class="leftsideheadings_view">Course Details</div>
                    <div class="middlecolon">:</div>
                    <div class="rightsidedata_view"><?php echo anchor($this->current_controller . '/user_renew_course_details/' . $data->userid . '/' . $data->id . '/' . $this->uri->segment(5), 'Click here') ?> for Course Details</div>
                    <div class="clearboth"></div>

                    <div class="leftsideheadings_view">Course Price</div>
                    <div class="middlecolon">:</div>
                    <div class="rightsidedata_view"><?php echo $data->course_price; ?></div>
                    <div class="clearboth"></div>

                    <div class="leftsideheadings_view">Shipping rate</div>
                    <div class="middlecolon">:</div>
                    <div class="rightsidedata_view"><?php echo $data->ship_rate; ?></div>
                    <div class="clearboth"></div>

                    <?php
                    if (1 == $data->is_promocode_applied) {
                        $promocode_details = json_decode($data->promocode_details);
                        $discount = '';
                        if (1 == $promocode_details->redeem_type) {
                            $discount = '$' . $promocode_details->redeem_value;
                        } else {
                            $discount = $promocode_details->redeem_value . '%';
                        }
                        ?>
                        <div class="leftsideheadings_view">Promocode Applied</div>
                        <div class="middlecolon">:</div>
                        <div class="rightsidedata_view"><i><b><?php echo $promocode_details->promocode; ?></b></i> - <?php echo $discount; ?> Discount availed</div>
                        <div class="clearboth"></div>
                    <?php
                    }
                    ?>

                    <div class="leftsideheadings_view">Amount</div>
                    <div class="middlecolon">:</div>
                    <div class="rightsidedata_view"><?php echo $data->total_amount; ?></div>
                    <div class="clearboth"></div>

                    <div class="leftsideheadings_view">Order Date</div>
                    <div class="middlecolon">:</div>
                    <div class="rightsidedata_view"><?php echo formatDate($data->orderdate); ?></div>
                    <div class="clearboth"></div>
                    <div class="leftsideheadings_view">Status</div>
                    <div class="middlecolon">:</div>
                    <div class="rightsidedata_view"><?php
                        if ('S' == $data->status) {
                            echo "Shipped";
                        } else if ('Q' == $data->status) {
                            echo "Queue";
                        } else if ('C' == $data->status) {
                            echo "Completed";
                        }
                        ?></div>
                    <div class="clearboth"></div>

                    <div class="leftsideheadings_view">Shipping Method</div>
                    <div class="middlecolon">:</div>
                    <div class="rightsidedata_view"><?php echo $data->ship_method ?></div>
                    <div class="clearboth"></div>

                    <div class="leftsideheadings_view">Packaging Type</div>
                    <div class="middlecolon">:</div>
                    <div class="rightsidedata_view">
                    <?php
                    if ($data->ship_rate > 0) {
                        echo ('' == trim($data->packaging_type)) ? 'YOUR PACKAGING' : str_replace('_', ' ', $data->packaging_type);
                    }
                    ?>
                    </div>
                    <div class="clearboth"></div>

                    <div class="leftsideheadings_view">Shipping Address</div>
                    <div class="middlecolon">:</div>
                    <div class="rightsidedata_view">
                        <?php echo $data->s_address; ?><br>
                        <?php echo $data->s_city . ", " . $data->s_state; ?><br>
                        <?php echo $data->s_country . ", " . $data->s_zipcode; ?><br>

                    </div>
                    <div class="leftsideheadings_view">Billing Address</div>
                    <div class="middlecolon">:</div>
                    <div class="rightsidedata_view">
                    <?php echo $data->b_address; ?><br>
                    <?php echo $data->b_city . ", " . $data->b_state; ?><br>
                    <?php echo $data->b_country . ", " . $data->b_zipcode; ?><br>

                    </div>
                    <div class="clearboth"></div>
    <?php } ?>
            </div>
        </div>
<?php } else{ echo "No details captured"; }?>
    <div class="backtolist">
        <a href="javascript:void(null);" onclick="javascript:gotoMissedlist(<?php echo $this->uri->segment(5); ?>); return false;"><< Back to users list </a>
    </div>
    <input type="hidden" id="hidorderid" name="hidorderid"  value="<?php if (isset($_POST['hidorderid'])) {
    echo $_POST['hidorderid'];
} ?>" />
</div>
<?php echo form_close(); ?>
<script>
    function gotoMissedlist(a){
        a?$("frmadhischool").action=base_url+"index.php/admin_missed_user/list_renew_reenroll_details/"+a:$("frmadhischool").action=base_url+"index.php/admin_missed_user/list_renew_reenroll_details/";
        $("frmadhischool").submit()
    }
</script>