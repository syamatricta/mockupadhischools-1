<?php echo form_open_multipart('admin_user/list_otp_users', array('name'=>'frmadhischool','id' => 'frmadhischool'));
if('' != $this->uri->segment(3)){
	$segment = $this->uri->segment(3); 
}
else{
	$segment ='';
}
$the_action = "Disabling";
?>

<div class="adminmainlist">
	<div class="clearboth"> </div>
	

		<div class="adminpagebanner">
			<div class="adminpagetitle"><?php echo $page_title?></div>
		</div>
		<div class="page_success"><?php echo $success_message?></div>
		<div class="clearboth"> </div>
		<div class="admininnercontentdiv">
			<div align="right" class="floatleft" style="width: 99%; text-align: right; border: 1px solid rgb(153, 153, 153); padding: 5px; background: none repeat scroll 0% 0% rgb(232, 227, 220);">
                            
                            <div class="floatleft smallpaddingright">Name : <br /><input type="text" value="<?php echo $search_firstname;?>" name="txtSrchFirstname" id="txtSrchFirstname" style="width:110px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
                            <div class="floatleft smallpaddingright">Email :  <br /><input type="text" value="<?php echo $search_email;?>" name="txtSrchEmail" id="txtSrchEmail" style="width:150px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
                            <div class="floatleft smallpaddingright">Phone :  <br /><input type="text" value="<?php echo $search_phone;?>" name="txtSrchPhone" id="txtSrchPhone" style="width:110px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
                            <div class="floatleft"> &nbsp;&nbsp;&nbsp; <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Search" style="margin-top: 5px;"/></div>
			</div>
			<div class="floatright"><a href="<?php echo site_url()."admin_user/add_otp_user"?>">Add new user</a></div>
			<?php 
			if(count($userdetails) > 0){
                        /* list headings starts here*/		
			?>
			<div class="listdata">
				
				<div class="clearboth">&nbsp;</div>
				<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");   ?></div>
				<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
				<div class="clearboth"> </div>
                                
                                <?php /* Enabling/Disabling of a user with reason starts here  */?>
				<div class="listdata" id="reason" style="display:none">
					<fieldset>
	   					 <legend ><strong>Reason for <span id="reason_text1"> </span></strong></legend>
	   					<div class="page_error" id="errordisplay"></div>
						
						<div class="leftsideheadings_view" style="width:25% ! important;">Submit your reason for <span id="reason_text2"> </span> this user<span class="red_star">*</span></div>
						<div class="middlecolon">:</div>
						<div class="rightsidedata_view" style="width:65% ! important;"><textarea class="success_border" name="txtReason" id="txtReason" rows="4" cols="70" ></textarea></div>
						<div class="clearboth"></div>
						<div class="middlebutton">
						<input type="button" name="butUpdate" value="Submit" onclick="javascript:fncUpadtefreezingOtpuser();" />
						<input type="button" name="butCancel" value="Cancel" onclick="javascript:fncCancelFreezing();" />
						</div>
					</fieldset>
				</div>

				<div class="clearboth"> </div>
                                <?php /* Enabling/Disabling of a user with reason ends here  */?>
                                
				<div class="admintopheads">
					<div class="adminlistheadings" style="width:10%; text-align:center;">Sl. No</div>
					<div class="adminlistheadings" style="width:25%;">Name</div>
					<div class="adminlistheadings" style="width:25%;">Email Id</div>
					<div class="adminlistheadings" style="width:15%;">Phone</div>
					<div class="adminlistheadings" style="width:10%;text-align:center;">Status</div>
					<div class="adminlistheadings" style="width:15%;text-align:center;">Actions</div>
				</div>
			</div>
			<div class="clearboth"> </div>
                        <?php  
                        /* list headings ends here*/
                           $count=1; 
			   if ($this->uri->segment(3)){
                                   $count = $count+$this->uri->segment(3);
                           } 
				  foreach($userdetails as $data){
                                        $bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';
                                        /* data list starts here */ 
                        ?>
                                          <div class="<?php print($bg_color);?>">
                                                <div class="floatleft" style="width:10%;  text-align:center;"><?php print $count;?></div> 
                                                <div class="floatleft" style="width:25%;overflow: hidden"><?php echo $data->name; ?></div>
                                                <div class="floatleft" style="width:25%;overflow: hidden;"><?php if($data->email_id !='') {echo $data->email_id; } else { echo  '&nbsp' ;} ?></div> 
                                                <div class="floatleft" style="width:15%;"><?php echo ($data->phone !="") ? $data->phone : "<span style='visibility:hidden'>Nil</span>"; ?></div>                                                                                          
                                                <div class="floatleft" style="width:10%;text-align:center;">
                                                        <?php if(1 == $data->active_status){
                                                                echo "Enabled";
                                                        } else {
                                                                echo "Disabled";
                                                        }	
                                                        ?>
                                                </div> 
                                                <div class="floatleft" style="width:15%;text-align:center;">
                                                        <?php echo anchor('admin_user/edit_otp_user/'.$data->id.'/'.$segment,'Edit');?>&nbsp;|&nbsp; 
                                                        <?php if($data->active_status == 1){?>
                                                            <a href="javascript:void(null);" onclick="; $('d_status').value = 0; javascript:freeze_otp_user(<?php echo $data->id; ?>,0); return false;">Disable</a>
                                                        <?php } else { ?>
                                                            <a href="javascript:void(null);" onclick="; $('d_status').value = 1; javascript:freeze_otp_user(<?php echo $data->id; ?>,1); return false;">Enable</a>
                                                        <?php } ?>
                                                </div> 
                                          </div>
                                          <div class="clearboth"> </div>
                        <?php $count++; 
                        /* data list ends here */ 			
                            } 
                        ?>
			<div class="pagination"><?php  echo $paginate;?></div>
			<div style="clear:both">&nbsp;</div>
			<?php } else { ?>
				<div class="nodata">No OTP Users</div>
			<?php }?>
		</div>
		
</div>
<input type="hidden" id="hiduserid" name="hiduserid"  value="<?php if(isset($_POST['hiduserid'])){echo $_POST['hiduserid'];}?>" />
<input type="hidden" id="d_status" name="d_status"  value="" />
<?php echo form_close();?>