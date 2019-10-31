<?php echo form_open_multipart('admin_user', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div id="maindiv">
	<div id="profileviewmain" >
		<?php 
		if(count($userdetails) > 0){
		?>
		<div class="floatleft" >
			<div class="floatleft"><span class="redheading"><?php echo $page_title;?> </span>  &nbsp; &nbsp;<span class="bluelabel"><?php echo $userdetails->firstname." ".$userdetails->lastname; ?></span> </div>
		</div>
		<div class="clearboth"></div>
		<div class="profileinnercontentdiv">
		<div class="page_error" id="errordisplay"></div>
		<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error"); ?></div>
		<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
		<?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
			<div class="listdata">
				<!--<div class="leftsideheadings_profileedit">License Type</div>
				<div class="middlecolon_profile_edit">:</div>
				<div class="rightsidedata_profileedit">--><?php 
													if('S' == $userdetails->licensetype )
													{
														$licensetype =  "Sales";
													}
													else 
													{
														$licensetype = "Broker";
													}?>
				<!--</div>-->
				
				<div class="commonaddressheads">
					<div style="float:left; font-size:12px;">Personal Details</div> 
					<div style="float:right; width:150px; font-size:12px;">License Type :<?php echo $licensetype?> </div>
				</div>
				<div class="clearboth"></div>
				<?php echo $this->load->view('user/profile/edit_profile_personal_details');?>
				<div class="clearboth">&nbsp;</div>
				<div class="commonaddressheads">Contact Address</div>
				<?php echo $this->load->view('user/profile/edit_profile_contact_details');?>
				<div class="clearboth">&nbsp;</div>
				<div class="commonaddressheads">Shipping Address</div>
				<?php echo $this->load->view('user/profile/edit_profile_shipping_details');?>
				<div class="clearboth">&nbsp;</div>
				<div class="commonaddressheads">Billing Address</div>
				<?php echo $this->load->view('user/profile/edit_profile_billing_details')?>
				<div class="clearboth" style="padding-bottom:30px;"></div>
			</div>
		</div>
		<?php }?>
		<div class="middlebutton">
			<img src="<? echo $this->config->item('images').'innerpages/update.jpg'?>" alt="Update" style="cursor:pointer" onclick="javascript:return fncUpadteUserprofile();return false;" />
		</div>
	</div>
	<div class="floatleft" >
		<?php echo $this->load->view('user/client_menu');?>
	</div>
</div>
<?php echo form_close();?>