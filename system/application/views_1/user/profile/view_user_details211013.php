<?php echo form_open_multipart('admin_user', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div id="maindiv">
	<div id="profileviewmain">
		<?php 
		if(count($userdetails) > 0){
		?>
		<div class="floatleft" >
			<div class="floatleft"><div class="redheading"><?php echo $page_title;?></div> <div class="bluelabel"><?php echo $userdetails->firstname." ".$userdetails->lastname; ?></div> </div>
			<div class="clearboth"></div>
			<div class="editprofile" ><?php echo anchor('profile/edit_profile','Edit My Profile');?></div>
		</div>
		<div class="clearboth"></div>
		<div class="profileinnercontentdiv">
			<div class="listdata">
				<div class="commonaddressheads">Personal Details</div>
				<?php echo $this->load->view('user/profile/view_profile_personal_details');?>
				<div class="clearboth">&nbsp;</div>
				<div class="commonaddressheads">Contact Address</div>
				<?php echo $this->load->view('user/profile/view_profile_contact_details');?>
				<div class="clearboth">&nbsp;</div>
				<div class="commonaddressheads">Shipping Address</div>
				<?php echo $this->load->view('user/profile/view_profile_shipping_details');?>
				<div class="clearboth">&nbsp;</div>
				<div class="commonaddressheads">Billing Address</div>
				<?php echo $this->load->view('user/profile/view_profile_billing_details')?>
				<div class="clearboth" style="padding-bottom:30px;"></div>
			</div>
		</div>
		<?php }?>
	</div>
	<div class="floatleft">
		<?php echo $this->load->view('user/client_menu');?>
	</div>
</div>
<?php echo form_close();?>
