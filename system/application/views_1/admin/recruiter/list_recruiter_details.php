<?php echo form_open_multipart('admin_recruiter/list_recruiter/', array('name'=>'frmadhischool','id' => 'frmadhischool'));
if('' != $this->uri->segment(3)){
	$segment = $this->uri->segment(3); 
}
else{
	$segment ='';
}?>

<div class="adminmainlist">
	<div class="clearboth"> </div>
		<div class="adminpagebanner">
			<div class="adminpagetitle"><?php echo $page_title?></div>
		</div>
		<?php /* <div class="page_success"><?php echo isset($success_message)? $success_message: '';?></div> */ ?>
		<div class="clearboth"> </div>
		<div class="admininnercontentdiv">
			<div align="right" class="floatleft" style="width: 99%; text-align: right; border: 1px solid rgb(153, 153, 153); padding: 5px; background: none repeat scroll 0% 0% rgb(232, 227, 220);">
                            <div class="floatleft smallpaddingright">Recruiter First Name : <br /><input type="text" value="<?php echo $search_firstname;?>" name="txtSearch_Rfirstname" id="txtSearch_Rfirstname" style="width:120px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
                            <div class="floatleft smallpaddingright">Recruiter Last Name : <br /><input type="text" value="<?php echo $search_lastname;?>" name="txtSearch_Rlastname" id="txtSearch_Rlastname" style="width:120px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
                            <div class="floatleft smallpaddingright">Recruiter Email :      <br /><input type="text" value="<?php echo $search_email;?>" name="txtSearch_Remail" id="txtSearch_Remail" style="width:150px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
                            <div class="floatleft smallpaddingright">Brokerage :  <br /><input type="text" value="<?php echo $search_brokerage;?>" name="txtSearch_Rbrokerage" id="txtSearch_Rbrokerage" style="width:150px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
                            
                            <div class="floatleft"> &nbsp;&nbsp;&nbsp; <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Search" style="margin-top: 5px;"/></div>
			</div>
			<div class="floatright"><a href="<?php echo site_url()."admin_recruiter/add_recruiter"?>">Add new Recruiter</a></div>
			<?php 
			if(count($recruiterdetails) > 0){
				/* list headings starts here*/		
			?>
			<div class="listdata">
				<div class="clearboth">&nbsp;</div>
				<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");   ?></div>
				<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
				<div class="clearboth"> </div>
                                <?php /* Freezing of a recruiter with reason starts here  */?>
				<div class="listdata" id="reasonFreeze" style="display:none">
					<fieldset>
	   					 <legend><strong>Reason for freezing</strong></legend>
	   					<div class="page_error" id="errordisplay"></div>
						
						<div class="leftsideheadings_view">Submit your reason for freezing this recruiter<span class="red_star">*</span></div>
						<div class="middlecolon">:</div>
						<div class="rightsidedata_view"><textarea class="success_border" name="txtReasonFreeze" id="txtReasonFreeze" rows="4" cols="70" ><?php isset($reason)? $reason : '';?></textarea></div>
						<div class="clearboth"></div>
						<div class="middlebutton">
						<input type="button" name="butUpdate" value="Submit" onclick="javascript:fncUpdatefreezingrecruiter(<?php echo $this->uri->segment(3);?>);" />
						<input type="button" name="butCancel" value="Cancel" onclick="javascript:fncCancelFreezing();" />
						</div>
					</fieldset>
				</div>

				<div class="clearboth"> </div>
                                <?php /* Freezing of a recruiter with reason ends here  */?>
                                
                                <?php /* Activation of a recruiter with reason starts here  */?>
				<div class="listdata" id="reasonAct" style="display:none">
					<fieldset>
	   					 <legend><strong>Reason for activating</strong></legend>
	   					<div class="page_error" id="errordisplays"></div>
						
						<div class="leftsideheadings_view">Submit your reason for activating this recruiter<span class="red_star">*</span></div>
						<div class="middlecolon">:</div>
						<div class="rightsidedata_view"><textarea class="success_border" name="txtReasonAct" id="txtReasonAct" rows="4" cols="70" ><?php isset($reason)? $reason : '';?></textarea></div>
						<div class="clearboth"></div>
						<div class="middlebutton">
						<input type="button" name="butUpdate" value="Submit" onclick="javascript:fncUpdateactivatingrecruiter(<?php echo $this->uri->segment(3);?>);" />
						<input type="button" name="butCancel" value="Cancel" onclick="javascript:fncCancelActivating();" />
						</div>
					</fieldset>
				</div>

				<div class="clearboth"> </div>
                                <?php /* Activation of a recruiter with reason ends here  */?>
				<div class="admintopheads">
					<div class="adminlistheadings" style="width:5%; text-align:center;">Sl. No</div>
					<div class="adminlistheadings" style="width:20%;">Recruiter Name</div>
					<div class="adminlistheadings" style="width:20%;">Recruiter Email Id</div>
                                        <div class="adminlistheadings" style="width:20%;">Brokerage</div>
					<div class="adminlistheadings" style="width:10%;text-align:center;">Created by</div>
					<div class="adminlistheadings" style="width:10%;text-align:center;">Status</div>
					<div class="adminlistheadings" style="width:12%;text-align:center;">Actions</div>
				</div>
			</div>
			<div class="clearboth"> </div>
		<?php  
                    /* list headings ends here*/
				$count=1; 
                                if ($this->uri->segment(3)){
					$count = $count+$this->uri->segment(3);
				}
                                if(!empty($recruiterdetails)){
				foreach($recruiterdetails as $data){
                                        $bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';
                                        /* data list starts here */ 
                                        ?>
                                        <div class="<?php print($bg_color);?>">

				 	<?php 
                                          if($data->user_type == 1) 
                                                    $created_by_name = "Admin";
                                            elseif($data->user_type == 2) 
                                                    $created_by_name = "Sub-Admin"; 
                                            else
                                                    $created_by_name = "Admin";
                                       
                                        ?>
                                        <div class="floatleft" style="width:5%;  text-align:center;"><?php print $count;?></div> 

				 	<div class="floatleft" style="width:20%;overflow: hidden">       <?php echo $data->recruiter_name.' '.$data->recruiter_last_name; ?>       </div>
				 	<div class="floatleft" style="width:20%;overflow: hidden;">      <?php echo $data->recruiter_mail; ?>       </div> 
                                        <div class="floatleft" style="width:20%;text-align:left;">&nbsp; <?php echo $data->recruiter_brokerage; ?>  </div> 
				 	<div class="floatleft" style="width:10%;text-align:center;">     <?php echo $created_by_name;?>             </div>
                                       
				 	<div class="floatleft" style="width:10%;text-align:center;">
				 		<?php if(1 == $data->recruiter_status){
									echo "Active";
								 } else {
									echo "Freezed";
								 }	?>
					</div> 
					<div class="floatleft" style="width:12%;text-align:left;">
						<?php echo anchor('admin_recruiter/view_recruiters/'.$data->adhi_recruiter_id.'/'.$segment,'View')?>&nbsp;|&nbsp;
						<?php echo anchor('admin_recruiter/edit_recruiters/'.$data->adhi_recruiter_id.'/'.$segment,'Edit');?>&nbsp;|&nbsp; 
						<?php if($data->recruiter_status == 1){ ?>
						<a href="javascript:void(null);" onclick="javascript:freeze_recruiter(<?php echo $data->adhi_recruiter_id?>); return false;">Freeze</a>
						<?php } else { ?>
                                                <a href="javascript:void(null);" onclick="javascript:activate_recruiter(<?php echo $data->adhi_recruiter_id?>); return false;">Activate</a>
                                                <?php }?>
					</div> 
                                  </div>
				<div class="clearboth"> </div>
				<?php $count++; 
                                /* data list ends here */ 			
			} } ?>
			<div class="pagination"><?php  echo $paginate;?></div>
			<div style="clear:both">&nbsp;</div>
			<?php }else { ?>
				<div class="nodata">No Recruiters</div>
			<?php }?>
		</div>
		
</div>
<input type="hidden" id="hidrecruiterid" name="hidrecruiterid"  value="<?php if(isset($_POST['hidrecruiterid'])){echo $_POST['hidrecruiterid'];}?>" />
<?php echo form_close();?>