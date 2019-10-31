<?php echo form_open('admin_attendance_view', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<style>
    .leftsideheadingsr_view{
        width:15%;
        float:left;
        font-weight: bold;
    }
    .middlecolon{
        width:5%;
        float:left;
    }
    .rightsidedatar_view{
        width:70%;
        float:right;
    }
</style>
<div class="adminmainlist">
	<?php 
	if(count($attendance_details) > 0){
	?>
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div>
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		
		<div class="listdata">
			<div class="leftsideheadingsr_view">Region</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedatar_view"><?php echo $attendance_details->region_name; ?></div>
			<div class="clearboth"></div>
                        
                        <div class="leftsideheadingsr_view">Sub Region</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedatar_view"><?php echo $attendance_details->subregion_name; ?></div>
			<div class="clearboth"></div>
			
			<div class="leftsideheadingsr_view">Course</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedatar_view"><?php echo $attendance_details->course_name; ?></div>
			<div class="clearboth"></div>
			
			<div class="leftsideheadingsr_view">Instructor</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedatar_view"><?php echo $attendance_details->instructor_name; ?></div>
                        <div class="clearboth"></div>
                        
                        <div class="leftsideheadingsr_view">Class Date</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedatar_view"><?php echo date('m-d-Y',strtotime($attendance_details->date)); ?></div>
                        <div class="clearboth"></div>
                        
                        <div class="leftsideheadingsr_view">Class Day</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedatar_view"><?php echo date('l',strtotime($attendance_details->date)); ?></div>
                        <div class="clearboth"></div>
                        
                        <div class="leftsideheadingsr_view">Class Time</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedatar_view"><?php echo $attendance_details->time_from." - ".$attendance_details->time_to; ?></div>
                        <div class="clearboth"></div>
                        
                        <div class="leftsideheadingsr_view">Attendance</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedatar_view"><?php echo $attendance_details->attendance; ?></div>
                        <div class="clearboth"></div>
                        
                        <div class="leftsideheadingsr_view">Titled Guests</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedatar_view"><?php echo $attendance_details->titled_guests; ?></div>
                        <div class="clearboth"></div>
                        
                        <div class="leftsideheadingsr_view">Notes</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedatar_view"><?php echo $attendance_details->notes; ?></div>
                        <div class="clearboth"></div>
                        
                        <div class="leftsideheadingsr_view">Sign Report</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedatar_view">
                            <?php if("" != $attendance_details->report){ ?>
                                <a target="_blank" download href="<?php echo base_url().'/image_uploads/attendance/'.$attendance_details->report; ?>"> Download </a>
                            <?php } ?>
                        </div>
                        <div class="clearboth"></div>
                        
                        <div class="leftsideheadingsr_view">Created On</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedatar_view"><?php echo date('m-d-Y',strtotime($attendance_details->created_date)); ?></div>
                        <div class="clearboth"></div>
		</div>
	</div>
        
	<?php }?>
	<div class="backtolist"><a href="javascript:void(null);" onclick="javascript:gotolist(<?php echo $this->uri->segment(5);?>); return false;"><< Back to attendance list </a></div>
 </div>
<?php echo form_close();?>