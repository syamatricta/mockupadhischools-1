<?php echo form_open('admin_recruiter', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="adminmainlist">
	<?php 
	if(count($recruiterdetails) > 0){
	?>
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div>
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		
		<div class="listdata">
			<div class="leftsideheadingsr_view">Recruiter First Name</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedatar_view"><?php echo $recruiterdetails->recruiter_name; ?></div>
			<div class="clearboth"></div>
                        
                        <div class="leftsideheadingsr_view">Recruiter Last Name</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedatar_view"><?php echo $recruiterdetails->recruiter_last_name; ?></div>
			<div class="clearboth"></div>
			
			<div class="leftsideheadingsr_view">Recruiter Email Id</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedatar_view"><?php echo $recruiterdetails->recruiter_mail; ?></div>
			<div class="clearboth"></div>
			
			<div class="leftsideheadingsr_view">Brokerage</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedatar_view"><?php echo substr($recruiterdetails->recruiter_brokerage, 0, 50); ?></div>
                        <div class="clearboth"></div>
		</div>
	</div>
        
        <div class="row" style="margin:10% 0% 0% 11%;">
              <input class="btn red" type="button" value="Edit" onclick ="javascript : fncViewEditRecruiterMaildetails(<?php echo $recruiterdetails->adhi_recruiter_id; ?>);" />
        </div>
	<?php }?>
	<div class="backtolist"><a href="javascript:void(null);" onclick="javascript:gotolist(<?php echo $this->uri->segment(4);?>); return false;"><< Back to recruiters list </a></div>
 </div>
<?php echo form_close();?>