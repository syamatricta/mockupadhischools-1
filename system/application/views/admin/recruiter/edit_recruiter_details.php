<?php echo form_open('admin_recruiter', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="adminmainlist">
	<?php 
	if(count($recruiterdetails) > 0){
	?>
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div> 
        <?php /*end of  adminpagebanner */?>
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		<div class="page_error" id="errordisplay"></div>
		<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error"); ?></div>
		<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
		<?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
		<div class="listdata">
			<div class="leftsideheadingsr_view">Recruiter First Name<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedatar_view"><input type="text" class="success_border" name="firstname" id="firstname" size="40" maxlength="128" value="<?php echo $recruiterdetails->recruiter_name; ?>"/></div>
			<div class="clearboth"></div>
                        
                        <div class="leftsideheadingsr_view">Recruiter Last Name</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedatar_view"><input type="text" class="success_border" name="lastname" id="lastname" size="40" maxlength="128" value="<?php echo $recruiterdetails->recruiter_last_name; ?>"/></div>
			<div class="clearboth"></div>
			
			<div class="leftsideheadingsr_view">Recruiter Email Id<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedatar_view"><input type="text" name="email" class="success_border" id="email" size="40" maxlength="128" value="<?php echo $recruiterdetails->recruiter_mail; ?>" /></div>
			<div class="clearboth"></div>
                        
                        <div class="leftsideheadingsr_view">Confrim Email Id<span class="red_star">*</span></div>
			<div class="middlecolon">:</div>
			<div class="rightsidedatar_view"><input type="text" name="confirmemail" class="success_border" id="confirmemail" size="40" maxlength="128" value="<?php echo $recruiterdetails->recruiter_mail; ?>" /></div>
			<div class="clearboth"></div>
                        
                        <div class="leftsideheadingsr_view">Copy Email</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedatar_view"><input type="text" name="copy_email" class="success_border" id="copy_email" size="80" maxlength="128" value="<?php echo $recruiterdetails->recruiter_copy_mail; ?>" /></div>
			<div class="clearboth"></div>
                        
                        <div class="leftsideheadingsr_view">Brokerage</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedatar_view"><input type="text" name="brokerage" class="success_border" id="brokerage" size="40" maxlength="128" value="<?php echo $recruiterdetails->recruiter_brokerage; ?>" /></div>
			<div class="clearboth"></div>
			
			<div class="clearboth"></div>
			<?php 
			if('' != $this->uri->segment(4)) {
                            $pageid =  $this->uri->segment(4);
                        } else {
				$pageid ='';
			}
			?>
			<div class="middlebutton edit_bt"><input type="button" name="butUpdate" value="Update" onclick="javascript:fncUpdateRecruiterdetails('<?php  echo $recruiterdetails->adhi_recruiter_id;  ?>','<?php echo $pageid; ?>');" /></div>
			</div> <?php /* end of listdata */?>
	</div> 
        <?php /* end of admininnercontentdiv */?>
	<?php }?>
	<div class="backtolist"><a href="javascript:void(null);" onclick="javascript:gotolist(<?php echo $this->uri->segment(4);?>); return false;"><< Back to recruiters list </a></div>
	<input type="hidden" id="hidrecruiterid" name="hidrecruiterid"  value="<?php echo $recruiterid;?>" />
</div> <?php /* end of adminmainlist */ ?>
<?php echo form_close();?>
