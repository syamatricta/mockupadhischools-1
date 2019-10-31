<style>
    .leftsideheadings_view{
        width:35%;
    }
    .rightsidedata_view{
        width:60%;
    }
</style>
<div class="adminmainlist">
	<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");   ?></div>
	<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
	
	<?php 
	if(count($report) > 0){
	?>
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div>
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		<div class="addressdivisionleft">
                        <div class="leftsideheadings_view">Student Name</div>
                        <div class="middlecolon">:</div>
                        <div class="rightsidedata_view"><b><?php echo $report[0]['student_first_name']. " ".$report[0]['student_last_name'] ?></b></div>
                        <div class="clearboth"></div>
                        
                        <div class="leftsideheadings_view">Email Id</div>
                        <div class="middlecolon">:</div>
                        <div class="rightsidedata_view"><b><?php echo $report[0]['student_mail_id']; ?></b></div>
                        <div class="clearboth"></div>
                        
                        <div class="leftsideheadings_view">Phone</div>
                        <div class="middlecolon">:</div>
                        <div class="rightsidedata_view"><b><?php echo $report[0]['student_phone_number']; ?></b></div>
                        <div class="clearboth"></div>
                        <br/> <br/>
                        
                        <h3> Recruiter Details </h3>
                        <div class="leftsideheadings_view">Recruiter Referred</div>
                        <div class="middlecolon">:</div>
                        <div class="rightsidedata_view"><b><?php echo ucfirst($report[0]['recruiter_name'])." ".$report[0]['recruiter_last_name']; ?></b></div>
                        <div class="clearboth"></div>

                        <div class="leftsideheadings_view">Recruiter Email</div>
                        <div class="middlecolon">:</div>
                        <div class="rightsidedata_view"><b><?php echo $report[0]['recruiter_mail']; ?></b></div>
                        <div class="clearboth"></div>

                        <div class="leftsideheadings_view">Recruiter Company</div>
                        <div class="middlecolon">:</div>
                        <div class="rightsidedata_view"><b><?php echo $report[0]['recruiter_brokerage']; ?></b></div>
                        <div class="clearboth"></div><br/>
                        
                        <div class="listdata">
                        <?php foreach($report as $key => $rpt){ ?>
                            <h3> <?php echo $key+1; ?>. <u>Referred on <?php echo formatDate(convert_UTC_to_PST_date($rpt['created_date'])); ?> </u></h3>
                            <br/>
                            
                            <div class="leftsideheadings_view">Area of Residence</div>
                            <div class="middlecolon">:</div>
                            <div class="rightsidedata_view"><b><?php echo $rpt['area_of_interest']; ?></b></div>
                            <div class="clearboth"></div>
                            
                            <div class="leftsideheadings_view">Stage of Licensure</div>
                            <div class="middlecolon">:</div>
                            <div class="rightsidedata_view">
                                <b>
                                    <?php 
                                        if(!empty($stages)) { 
                                            foreach($stages as $stage){
                                                if($stage['id'] == $rpt['stage_of_licensure']) { 
                                                    echo ucfirst($stage['name']);
                                                }
                                            } 
                                        } 
                                    ?>
                                </b>
                            </div>
                            <div class="clearboth"></div><br/>
                            
                            <h3> Referral Email </h3>
                            <div class="leftsideheadings_view">Email body</div>
                            <div class="middlecolon">:</div>
                            <div class="rightsidedata_view"><b><?php echo $rpt['mail_body']; ?></b></div>
                            <div class="clearboth"></div>
                        <?php } ?>
                        </div>
                </div>
        </div>
</div>
<?php }
$page = (1 != $this->uri->segment(3)) ? $this->uri->segment(3) : "";
?>
<div class="backtolist">
        <a href="<?php echo base_url();?>index.php/admin_recruiter/recruiter_report/<?php echo $page;?>"><< Back to list </a>
</div>
</div>