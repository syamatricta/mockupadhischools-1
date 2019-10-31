<?php echo form_open_multipart('admin_user', array('name' => 'adminreportlistform', 'id' => 'adminreportlistform')); ?>
<div class="adminmainlist">
    <?php /* list headings starts here */ ?>
    <div class="adminpagebanner">
        <div class="adminpagetitle"><?php echo $page_title ?></div>
    </div>
    <div class="clearboth"> </div>
    <div class="page_error" id="errordisplay"></div>
    
    <div class="nodata" style="width:100%;">
        <div class="listdata">
            <div class="floatleft" style="width:8%;margin-top:5px;"><strong>Date From</strong></div>
            <div class="filter">
                <input type="text" maxlength="50"  name="date_from" id="date_from" readonly value="<?php
                    if ('' != $this->input->post('date_from')) {
                        echo formatDate($this->input->post('date_from'));
                    } else if (0 != $this->uri->segment(3)) {
                        echo formatDate($this->uri->segment(3));
                    } else if (0 == $this->uri->segment(3)) {
                        echo '';
                    } else {
                        echo formatDate(convert_UTC_to_PST_date(date('Y-m-d H:i:s')));
                    }
                    ?>"/>
                <img  src="<?php echo $this->config->item('images'); ?>calendar.gif" alt="calendar" title="calendar" onclick="displayCalendar(document.adminreportlistform.date_from,'mm/dd/yyyy',this)"/>
            </div>
            <div class="floatleft" style="width:8%;margin-top:5px;"><strong>Date To</strong></div>
            <div class="filter">
                <input type="text" maxlength="50"  name="date_to" id="date_to" readonly  value="<?php if ('' != $this->uri->segment(4)) {
                           echo formatDate($this->uri->segment(4));
                       } else if ('' != $this->input->post('date_to')) {
                           echo formatDate($this->input->post('date_to'));
                       } else {
                           echo formatDate(convert_UTC_to_PST_date(date('Y-m-d H:i:s')));
                       } ?>"/>
                <img  src="<?php echo $this->config->item('images'); ?>calendar.gif" alt="calendar" title="calendar"  onclick="displayCalendar(document.adminreportlistform.date_to,'mm/dd/yyyy',this)"/>
            </div>
            <div class="floatleft" style="width:8%;margin-top:5px;"><strong>Created By</strong></div>
            <div class="fl">
                <select name="reg_type" id="reg_type">
                    <option value="3" <?php echo ($reg_type == 3 || (!isset($reg_type))) ? 'selected' : ''; ?>>All</option>
                    <option value="1" <?php echo ($reg_type == 1) ? 'selected' : ''; ?>>Admin</option>
                    <option value="2" <?php echo ($reg_type == 2) ? 'selected' : ''; ?>>Sub-Admin</option>
                    <option value="0" <?php echo ($reg_type == 0) ? 'selected' : ''; ?>>Student</option>
                </select>
            </div>
            <div class="floatleft" style="width:4%;margin-left:3%;margin-right:3%;margin-top:5px;"><strong>Package</strong></div>
            <div class="fl" style="margin-right:3%;">
                <select name="course_type" id="course_type">
                    <option value="3" <?php echo ($course_type == 3 || (!isset($course_type))) ? 'selected' : ''; ?>>Both</option>
                    <option value="1" <?php echo ($course_type == 1) ? 'selected' : ''; ?>>LIVE</option>
                    <option value="2" <?php echo ($course_type == 2) ? 'selected' : ''; ?>>ONLINE</option>
                </select>
            </div>

            <div class="floatleft">
                <a href="javascript:void(0);" onclick="javascript:fncFilter(document.adminreportlistform.date_from.value,document.adminreportlistform.date_to.value,document.adminreportlistform.reg_type.value,document.adminreportlistform.course_type.value); return false;">
                    <img src="<?php echo base_url(); ?>images/indexsearch.jpg" border="0" alt="filter" title="filter" />
                </a>
            </div>
            <div class="clearboth"> &nbsp;</div>
        </div>
    </div>
<?php if (count($reports) > 0) { ?>

        <div class="fr" style="margin: 10px;">
            <a href="javascript:void(0)" title="Excel Export" class="btn btn-inverse  btn-small" id="excelclicknew" onClick ="javascript:fncExport(document.adminreportlistform.date_from.value,document.adminreportlistform.date_to.value,document.adminreportlistform.reg_type.value,document.adminreportlistform.course_type.value);//exportTableToCSV([$('#tabledata>table'), $('.adminpagetitle').html()+'.csv']);">
                Export
            </a>    
        </div>
        <div class="clearboth"> </div>

        <div class="admininnercontentdiv" id="tabledata">
            <div class="listdata">
                <div class="admintopheads">
                    <div class="adminlistheadings" style="width:5%; text-align:center;">Sl. No</div>
                    <div class="adminlistheadings" style="width:15%;">Name</div>
                    <div class="adminlistheadings" style="width:20%;">Email</div>
                    <div class="adminlistheadings" style="width:10%;">Phone</div>
                    <div class="adminlistheadings" style="width:10%;">Enrolled Date</div>
                    <div class="adminlistheadings" style="width:7%;">Package</div>
                    <div class="adminlistheadings" style="width:16%;">Created By</div>
                    <div class="adminlistheadings" style="width:17%;">Reference</div>
                </div>
            </div>
            <div class="clearboth"> </div>
            <?php
            /* list headings ends here */
            $count = 1;
            if ($this->uri->segment(7)) {
                $count = $count + $this->uri->segment(7);
            }
            foreach ($reports as $data) {
                $bg_color = ($count % 2 == 0) ? 'div_row_first' : 'div_row_second';
                /* data list starts here */
                ?>
                <div class="<?php print($bg_color); ?>">
                    <div class="floatleft" style="width:5%;  text-align:center;"><?php print $count; ?></div>
                    <div class="floatleft" style="width:15%;overflow: hidden;" title="<?php echo ucfirst($data->firstname)." ".ucfirst($data->lastname); ?>"><?php echo ucfirst($data->firstname)." ".ucfirst($data->lastname); ?></div>
                    <div class="floatleft" style="width:20%;overflow: hidden;" title="<?php echo $data->emailid; ?>"><?php echo $data->emailid; ?></div>
                    <div class="floatleft" style="width:10%;overflow: hidden;" title="<?php echo $data->phone; ?>"><?php echo $data->phone; ?></div>
                    <div class="floatleft" style="width:10%;overflow: hidden;" title="<?php echo formatDate($data->enrolled_date); ?>"><?php echo formatDate($data->enrolled_date); ?></div>
                    <div class="floatleft" style="width:7%;overflow: hidden;">
                        <?php echo $data->course_type; ?>
                    </div>
                    <div class="floatleft" style="width:16%;overflow: hidden;">
                    <?php
                        switch($data->created_by){
                            case 1:
                                $by =  'Admin';
                                break;
                            case 2:
                                $by =  'Sub-Admin';
                                break;
                            default:
                                $by =  'Student';
                                break;
                        } 
                        echo $by;
                        if(($data->admin_fname != "" && $data->created_by != 1)){ 
                            echo "(".ucfirst($data->admin_fname)." ".ucfirst($data->admin_lname).")"; 
                        }else { ?>
                               &nbsp;
                        <?php } ?>
                    </div>
                    <div class="floatleft" style="width:17%;overflow: hidden;">
                    <?php if(($data->testimonial != "")){ 
                        echo $data->testimonial;
                        
                        if(($data->reason != "")){ 
                            echo "(".$data->reason.")";
                        }
                    }
                    ?>
                    </div>
                    <?php
                    if ('' != $this->input->post('date_from')) {
                        $date_from = formatDate_search($this->input->post('date_from'));
                    } else if (0 == $this->uri->segment(3)) {
                        $date_from = 0;
                    } else if ('' != $this->uri->segment(3) && 0 != $this->uri->segment(3)) {
                        $date_from = $this->uri->segment(3);
                    } else {
                        $date_from = convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
                    }
                    if ('' != $this->input->post('date_to')) {
                        $date_to = formatDate_search($this->input->post('date_to'));
                    } else {
                        $date_to = convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
                    }
                    ?>
                </div>
                <div class="clearboth"> </div>
            <?php
            $count++;
        }
        /* data list ends here */
        ?>
        </div>
        <div class="pagination"><?php echo $paginate; ?></div>
        <div style="clear:both">&nbsp;</div>
<?php } else { ?>
        <div class="nodata">No data in this date</div>
<?php } ?>
</div>
<?php echo form_close(); ?>
<script>
    
</script>