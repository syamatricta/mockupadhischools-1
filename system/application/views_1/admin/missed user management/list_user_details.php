<?php
$form_action = (2 == s('ADMINTYPE')) ? $this->current_controller . '/list_user_details' : $this->current_controller;
echo form_open_multipart($form_action, array('name' => 'frmadhischool', 'id' => 'frmadhischool'));
if ('' != $this->uri->segment(3)) {
    $segment = $this->uri->segment(3);
} else {
    $segment = '';
}
?>

<div class="adminmainlist">
    <div class="clearboth"> </div>


    <div class="adminpagebanner">
        <div class="adminpagetitle"><?php echo $page_title ?></div>
    </div>
    <div class="clearboth"> </div>
    <div class="admininnercontentdiv">
        <div align="right" class="floatleft" style="width: 99%; text-align: right; border: 1px solid rgb(153, 153, 153);
             padding: 5px; background: none repeat scroll 0% 0% rgb(232, 227, 220);margin-bottom: 10px;">
            <div class="floatleft smallpaddingright">First Name : <br /><input type="text" value="<?php echo $search_firstname; ?>"
                                                                               name="txtTempSrchFirstname" id="txtTempSrchFirstname" style="margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
            <div class="floatleft smallpaddingright">Last Name :  <br /><input type="text" value="<?php echo $search_lastname; ?>"
                                                                               name="txtTempSrchLastname" id="txtTempSrchLastname" style="margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
            <div class="floatleft smallpaddingright">Email :  <br /><input type="text" value="<?php echo $search_email; ?>"
                                                                           name="txtTempSrchEmail" id="txtTempSrchEmail" style="margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>

            <div class="floatleft smallpaddingright">Phone :  <br /><input type="text" value="<?php echo $search_phone; ?>"
                                                                           name="txtTempSrchPhone" id="txtTempSrchPhone" style="margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>

            <div class="floatleft smallpaddingright">License :  <br />
                <select id="license_type" name="license_type" style="margin-top: 5px;">
                    <option value="" >all</option>
                    <option <?php echo (isset($license_type) && 'S' == $license_type) ? 'selected' : ''; ?>  value="S" >Sales</option>
                    <option <?php echo (isset($license_type) && 'B' == $license_type) ? 'selected' : ''; ?>  value="B" >Broker</option>
                </select>
                &nbsp;&nbsp;&nbsp;
            </div>
            
            <div class="floatleft smallpaddingright">Type :  <br />
                 <select id="type" name="type" style="margin-top: 5px;">
                    <option <?php echo (isset($search_type) && 0 == $search_type) ? 'selected' : ''; ?> value="0">Registration</option>
                    <option <?php echo (isset($search_type) && 1 == $search_type) ? 'selected' : ''; ?>  value="1" >Apply New Course</option>
                    <option <?php echo (isset($search_type) && 2 == $search_type) ? 'selected' : ''; ?>  value="2" >Renew</option>
                    <option <?php echo (isset($search_type) && 3 == $search_type) ? 'selected' : ''; ?>  value="3" >Reenroll</option>
                </select>
                &nbsp;&nbsp;&nbsp;
            </div>

            <div class="" style="margin-top:5px;">
                <br /><input type="submit" value="Search" style=""/>&nbsp;&nbsp;
            </div>
        </div>
        <div class="floatleft"><?php echo $total; ?> User(s) found</div>
        
        <?php
        if (count($userdetails) > 0) {
            /* list headings starts here */
            ?>
            <div class="listdata">

                <div class="clearboth">&nbsp;</div>
                <div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error"); ?></div>
                <div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success"); ?></div>
                <div class="clearboth"> </div>
                
                <div class="admintopheads">
                    <?php
                    $column1 = '5%';
                    $column2 = '15%';
                    $column3 = '25%';
                    $column4 = '10%';
                    $column5 = '7%';
                    $column6 = '7%';
                    $column7 = '7%';
                    $column8 = '10%';
                    $column9 = '10%';
                    ?>
                    <div class="adminlistheadings" style="width:<?php echo $column1; ?>; text-align:center;">Sl. No</div>
                    <div class="adminlistheadings" style="width:<?php echo $column2; ?>">Name</div>
                    <div class="adminlistheadings" style="width:<?php echo $column3; ?>">Email Id</div>
                    <div class="adminlistheadings" style="width:<?php echo $column4; ?>">Phone</div>
                    <div class="adminlistheadings" style="width:<?php echo $column5; ?>;text-align:center;">License Type</div>
                    <div class="adminlistheadings" style="width:<?php echo $column6; ?>;text-align:center;">Status</div>
                    <div class="adminlistheadings" style="width:<?php echo $column7; ?>;text-align:center;">Actions</div>
                    <div class="adminlistheadings" style="width:<?php echo $column8; ?>;text-align:center;">Course</div>
                    <div class="adminlistheadings" style="width:<?php echo $column9; ?>;text-align:center;">Order</div>
                </div>
            </div>
            <div class="clearboth"> </div>
            <?php
            /* list headings ends here */
            $count = 1;
            if ($this->uri->segment(3)) {
                $count = $count + $this->uri->segment(3);
            }
            foreach ($userdetails as $data) {
                $bg_color = ($count % 2 == 0) ? 'div_row_first' : 'div_row_second';
                /* data list starts here */
                ?>
                <div class="<?php print($bg_color); ?>">
                    <div class="floatleft" style="width:<?php echo $column1; ?>;  text-align:center;"><?php print $count; ?></div> 

                    <div class="floatleft" style="width:<?php echo $column2; ?>;overflow: hidden"><?php echo $data->firstname . ' ' . $data->lastname; ?></div>
                    <div class="floatleft" style="width:<?php echo $column3; ?>;overflow: hidden;"><?php if ($data->emailid != '') {
                            echo $data->emailid;
                        } else {
                            echo '&nbsp';
                        } ?>
                    </div> 
                    <div class="floatleft" style="width:<?php echo $column4; ?>;"><?php echo $data->phone; ?></div>
                    <div class="floatleft" style="width:<?php echo $column5; ?>;text-align:center;"><?php
                        if ($data->licensetype != '') {
                            if ('B' == $data->licensetype) {
                                echo "Broker";
                            } else {
                                echo "Sales";
                            }
                        } else {
                            echo '&nbsp';
                        }
                        ?>
                    </div> 
                    <div class="floatleft" style="width:<?php echo $column6; ?>;text-align:center;">
                        <?php
                        if ('A' == $data->status) {
                            echo "Active";
                        } else {
                            echo "Freeze";
                        }
                        ?>
                    </div> 
                    <div class="floatleft" style="width:<?php echo $column7; ?>;text-align:center;">
                        <?php echo anchor($this->current_controller . '/view_users/' . $data->temp_id . '/' . $segment, 'View') ?>
                    </div> 
                    <div class="floatleft" style="width:<?php echo $column8; ?>;text-align:center;"><?php echo anchor($this->current_controller . '/user_course_details/' . $data->temp_id . '/' . $segment, 'Course Details') ?></div> 
                    <div class="floatleft" style="width:<?php echo $column9; ?>;text-align:center;"><?php echo anchor($this->current_controller . '/view_order_details/' . $data->temp_id . '/' . $segment, 'Order Details') ?></div> 
                </div>
                <div class="clearboth"> </div>
        <?php
        $count++;
    }
    ?>
            <div class="pagination"><?php echo $paginate; ?></div>
            <div style="clear:both">&nbsp;</div>
<?php } else { ?>
            <div class="nodata">No Users</div>
<?php } ?>
    </div>

</div>
<input type="hidden" id="hiduserid" name="hiduserid"  value="<?php if (isset($_POST['hiduserid'])) {
    echo $_POST['hiduserid'];
} ?>" />
<?php echo form_close(); ?>

<style>
    .smallpaddingright{padding-right: 0;}
</style>