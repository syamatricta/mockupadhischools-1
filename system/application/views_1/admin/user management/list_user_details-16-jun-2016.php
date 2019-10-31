<?php echo form_open_multipart('admin_user', array('name'=>'frmadhischool','id' => 'frmadhischool'));
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
		<!--<div class="page_success"><?php /*echo $success_message*/?></div>-->
		<div class="clearboth"> </div>
		<div class="admininnercontentdiv">
			<div align="right" class="floatleft" style="width: 99%; text-align: right; border: 1px solid rgb(153, 153, 153); padding: 5px; background: none repeat scroll 0% 0% rgb(232, 227, 220);">
                            <div class="floatleft smallpaddingright">First Name : <br /><input type="text" value="<?php echo $search_firstname;?>" name="txtSrchFirstname" id="txtSrchFirstname" style="width:110px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
				<div class="floatleft smallpaddingright">Last Name :  <br /><input type="text" value="<?php echo $search_lastname;?>" name="txtSrchLastname" id="txtSrchLastname" style="width:110px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
				<div class="floatleft smallpaddingright">Email :  <br /><input type="text" value="<?php echo $search_email;?>" name="txtSrchEmail" id="txtSrchEmail" style="width:150px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
                                
                                <div class="floatleft smallpaddingright">Phone :  <br /><input type="text" value="<?php echo $search_phone;?>" name="txtSrchPhone" id="txtSrchPhone" style="width:110px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
                                <div class="floatleft smallpaddingright">Zipcode :  <br /><input type="text" value="<?php echo $search_zipcode;?>" name="txtSrchZipcode" id="txtSrchZipcode" style="width:110px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
                                
                                <div class="floatleft smallpaddingright">License :  <br /><select id="license_type" name="license_type" style="margin-top: 5px;">
                                        <option value="" >all</option>
                                        <option <?php echo (isset($license_type) && 'S' == $license_type)?'selected':'';?>  value="S" >Sales</option>
                                        <option <?php echo (isset($license_type) && 'B' == $license_type)?'selected':'';?>  value="B" >Broker</option>
                                    </select>
                                    &nbsp;&nbsp;&nbsp;
                                </div>
				<div class="floatleft smallpaddingright">Course Status :  <br /><select id="course_completed" name="course_completed" style="margin-top: 5px;">
                                        <option value="0" >all</option>
                                        <option <?php echo (isset($course_completed) && $course_completed)?'selected':'';?>  value="1" >completed</option></select>
                                </div>

				<div class="floatleft"> &nbsp;&nbsp;&nbsp; <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Search" style="margin-top: 5px;"/></div>
			</div>
			<div class="floatright"><a href="<?php echo site_url()."admin_register/register"?>">Add new user</a></div>
			<?php 
			if(count($userdetails) > 0){
				/* list headings starts here*/		
			?>
			<div class="listdata">
				
				<div class="clearboth">&nbsp;</div>
				<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");   ?></div>
				<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
				<div class="clearboth"> </div>
<?php /* Freezing of a user with reason starts here  */?>
				<div class="listdata" id="reason" style="display:none">
					<fieldset>
	   					 <legend><strong>Reason for freezing</strong></legend>
	   					<div class="page_error" id="errordisplay"></div>
						
						<div class="leftsideheadings_view">Submit your reason for freezing this user<span class="red_star">*</span></div>
						<div class="middlecolon">:</div>
						<div class="rightsidedata_view"><textarea class="success_border" name="txtReason" id="txtReason" rows="4" cols="70" ></textarea></div>
						<div class="clearboth"></div>
						<div class="middlebutton">
						<input type="button" name="butUpdate" value="Submit" onclick="javascript:fncUpadtefreezinguser(<?php echo @$this->uri->segment(3);?>);" />
						<input type="button" name="butCancel" value="Cancel" onclick="javascript:fncCancelFreezing();" />
						</div>
					</fieldset>
				</div>

				<div class="clearboth"> </div>
<?php /* Freezing of a user with reason ends here  */?>
				<div class="admintopheads">
					<div class="adminlistheadings" style="width:5%; text-align:center;">Sl. No</div>
					<div class="adminlistheadings" style="width:15%;">Name</div>
					<div class="adminlistheadings" style="width:20%;">Email Id</div>
                                        <div class="adminlistheadings" style="width:7%;">Created by</div>
					<div class="adminlistheadings" style="width:5%;text-align:center;">License Type</div>
					<div class="adminlistheadings" style="width:6%;text-align:center;">Status</div>
					<div class="adminlistheadings" style="width:12%;text-align:center;">Actions</div>
					<div class="adminlistheadings" style="width:10%;text-align:center;">Course</div>
					<div class="adminlistheadings" style="width:10%;text-align:center;">Order</div>
					<div class="adminlistheadings" style="width:10%;text-align:center;">Conversation</div>
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

				 	<?php  

                                        if($data->created_by !=0)
                                        {
                                            //$created_by = $this->admin_subadmin_model->select_subadmin($data->created_by);
                                            //$created_by_name = $created_by->username;
                                             if($data->created_by == 1) $created_by_name = "Admin";
                                             elseif($data->created_by == 2) $created_by_name = "Sub-Admin";
                                        }
                                        else
                                        {
                                            $created_by_name = "Self";
                                        }
                                        ?>
                                        <div class="floatleft" style="width:5%;  text-align:center;"><?php print $count;?></div> 

				 	<div class="floatleft" style="width:15%;overflow: hidden"><?php echo $data->firstname.' '.$data->lastname;?></div>
				 	<div class="floatleft" style="width:20%;overflow: hidden;"><?php if($data->emailid !='') {echo $data->emailid; } else { echo  '&nbsp' ;} ?></div> 
				 	<div class="floatleft" style="width:7%;"><?php echo $created_by_name;?></div>
                                        <div class="floatleft" style="width:5%;text-align:center;"><?php  if($data->licensetype !=''){ 

				 														if('B' == $data->licensetype){
				 															echo "Broker";
				 														} else {
				 															echo "Sales";
				 														}
				 														// echo $data->licensetype;
				 													} else { 
				 														echo  '&nbsp' ;
				 													} ?></div> 
				 	<div class="floatleft" style="width:6%;text-align:center;">
				 		<?php if('A' == $data->status){
									echo "Active";
								 } else {
									echo "Freeze";
								 }	?>
					</div> 
					<div class="floatleft" style="width:12%;text-align:center;">
						<?php echo anchor('admin_user/view_users/'.$data->id.'/'.$segment,'View')?>&nbsp;|&nbsp;
						<?php echo anchor('admin_user/edit_users/'.$data->id.'/'.$segment,'Edit');?>&nbsp;|&nbsp; 
						<?php if($data->status == 'A'){?>
						<a href="javascript:void(null);" onclick="javascript:freeze_user(<?php echo $data->id?>); return false;">Freeze</a>
						<?php } else { echo "Freezed"; }?>
					</div> 
					<div class="floatleft" style="width:10%;text-align:center;"><?php echo anchor('admin_user/user_course_details/'.$data->id.'/'.$segment,'Course Details')?></div> 
					<div class="floatleft" style="width:10%;text-align:center;"><?php echo anchor('admin_user/view_order_details/'.$data->id.'/'.$segment,'Order Details')?></div> 
					<div class="floatleft" style="width:10%;text-align:center;"><a href="<?php echo base_url().'admin_user/conversations/'.$data->id;?>"><img title="Conversation" alt="Conversation" src="<?php echo $this->config->item('images').'conversation.png';?>" /></a></div> 
				</div>
				<div class="clearboth"> </div>
				<?php $count++; 
	/* data list ends here */ 			
			}?>
			<div class="pagination"><?php  echo $paginate;?></div>
			<div style="clear:both">&nbsp;</div>
			<?php }else { ?>
				<div class="nodata">No Registered Users</div>
			<?php }?>
		</div>
		
</div>
<input type="hidden" id="hiduserid" name="hiduserid"  value="<?php if(isset($_POST['hiduserid'])){echo $_POST['hiduserid'];}?>" />
<?php echo form_close();?>