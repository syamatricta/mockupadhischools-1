<?php echo form_open_multipart('admin_recruiter/recruiter_report', array('name' => 'adminreportlistform', 'id' => 'adminreportlistform')); ?>
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
                    }
                    ?>"/>
                <img  src="<?php echo $this->config->item('images'); ?>calendar.gif" alt="calendar" title="calendar" onclick="displayCalendar(document.adminreportlistform.date_from,'mm/dd/yyyy',this)"/>
            </div>
            <div class="floatleft" style="width:8%;margin-top:5px;"><strong>Date To</strong></div>
            <div class="filter">
                <input type="text" maxlength="50"  name="date_to" id="date_to" readonly  value="<?php 
                       if ('' != $this->input->post('date_to')) {
                           echo formatDate($this->input->post('date_to'));
                       } else {
                           echo formatDate(convert_UTC_to_PST_date(date('Y-m-d H:i:s')));
                       }
                       ?>
                       
                       "/>
                <img  src="<?php echo $this->config->item('images'); ?>calendar.gif" alt="calendar" title="calendar"  onclick="displayCalendar(document.adminreportlistform.date_to,'mm/dd/yyyy',this)"/>
            </div>
            
            <?php 
            if('' == $brokerage){ 
                if(!empty($recruiters)){
                    $o = 0;
                    foreach($recruiters as $broker){
                        $post_broker[$o++] = $broker['adhi_recruiter_id'];
                    }
                }
            }else{
                $post_broker = $brokerage;
            }
            
            ?>
            
            <?php if(!empty($recruiters)){ ?>
                <div class="floatleft" style="width:14%;margin-top:5px;"><strong>Recruiter Brokerage</strong></div>
                <div class="fl">
                    <select name="brokerage[]" id="brokerage" multiple>
                        <?php foreach($recruiters as $broker){ ?>
                            <option value="<?php echo $broker['adhi_recruiter_id']; ?>" <?php echo (in_array($broker['adhi_recruiter_id'],$post_broker)) ? 'selected="selected"' : ''; ?>><?php echo $broker['recruiter_brokerage'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
            
            <div class="clearboth"> &nbsp;</div> 
            
            <div class="floatleft" style="width:15%;margin-top:5px;"><strong>Student First Name</strong></div>
            <div class="fl">
                 <input type="text" id="student_first_name" name="student_first_name" value="<?php echo ("" != $this->input->post('student_first_name') ? $this->input->post('student_first_name') : $student_first_name); ?>"/>
             </div>

            <div class="floatleft" style="width:15%;margin-top:5px;margin-left:10px;"><strong>Student Last Name</strong></div>
            <div class="fl">
                 <input type="text" id="student_last_name" name="student_last_name" value="<?php echo ("" != $this->input->post('student_last_name') ? $this->input->post('student_last_name') : $student_last_name); ; ?>"/>
            </div>

            <div class="floatleft" style="width:13%;margin-top:5px;margin-left:10px;"><strong>Student Email</strong></div>
            <div class="fl">
                 <input type="text" id="student_mail_id" name="student_mail_id" value="<?php echo ("" != $this->input->post('student_mail_id') ? $this->input->post('student_mail_id') : $student_mail_id); ; ?>"/>
            </div>
            
            <div class="floatleft" style="margin-left:10px;">
                <a href="javascript:void(0);" onclick="javascript:fncFilter(document.adminreportlistform.date_from.value,document.adminreportlistform.date_to.value,document.adminreportlistform.brokerage.value); return false;">
                    <img src="<?php echo base_url(); ?>images/indexsearch.jpg" border="0" alt="filter" title="filter" />
                </a>
            </div>
            <div class="clearboth"> &nbsp;</div>
        </div>
    </div>
<?php if (count($reports) > 0) { ?>

        <div class="fr" style="margin: 10px;">
            <a href="javascript:void(0)" title="Excel Export" class="btn btn-inverse  btn-small" id="excelclicknew" onClick ="javascript:fncExport(document.adminreportlistform.date_from.value,document.adminreportlistform.date_to.value,document.adminreportlistform.brokerage.value,document.adminreportlistform.student_first_name.value,document.adminreportlistform.student_last_name.value,document.adminreportlistform.student_mail_id.value);//exportTableToCSV([$('#tabledata>table'), $('.adminpagetitle').html()+'.csv']);">
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
                    <div class="adminlistheadings" style="width:12%;">Residence Area</div>
                    <div class="adminlistheadings" style="width:15%;">Brokerage</div>
                    <div class="adminlistheadings" style="width:15%;text-align:center;">Referral Date</div>
                    <div class="adminlistheadings" style="width:8%;text-align:center;">Referrals</div>
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
                    <div class="floatleft" style="width:15%;overflow: hidden;" title="<?php echo ucfirst($data['student_first_name'])." ".ucfirst($data['student_last_name']); ?>"><?php echo ucfirst($data['student_first_name'])." ".ucfirst($data['student_last_name']); ?></div>
                    <div class="floatleft" style="width:20%;overflow: hidden;" title="<?php echo $data['student_mail_id']; ?>"><?php echo $data['student_mail_id']; ?></div>
                    <div class="floatleft" style="width:10%;overflow: hidden;" title="<?php echo $data['student_phone_number']; ?>"><?php echo $data['student_phone_number']; ?></div>
                    <div class="floatleft" style="width:12%;overflow: hidden;" title="<?php echo $data['area_of_interest']; ?>"><?php echo $data['area_of_interest']; ?></div>
                    <div class="floatleft" style="width:15%;overflow: hidden;" title="<?php echo $data['recruiter_brokerage']; ?>"><?php echo $data['recruiter_brokerage']; ?></div>
                    <div class="floatleft" style="width:15%;overflow: hidden;text-align:center;" title="<?php echo formatDate($data['created_date']); ?>"><?php echo formatDate($data['created_date']); ?></div>
                    <div class="floatleft" style="width:8%;overflow: hidden;text-align:center;" title="<?php echo $data['count']; ?>">
                        <a href="<?php echo base_url(); ?>admin_recruiter/get_referral_details/<?php echo $page_no ? $page_no : 1; ?>/<?php echo $data['id']; ?>"  style="text-decoration:none;"><?php echo $data['count']; ?></a>
                    </div>
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
        <div class="nodata">No data available</div>
<?php } ?>
</div>
<?php echo form_close(); ?>