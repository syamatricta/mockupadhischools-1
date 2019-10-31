<?php echo form_open_multipart('admin_user/list_trial_users', array('name'=>'frmadhischool','id' => 'frmadhischool'));
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
		<div class="clearboth"> </div>
		<div class="admininnercontentdiv">
			<div align="right" class="floatleft" style="width: 99%; text-align: right; border: 1px solid rgb(153, 153, 153); padding: 5px; background: none repeat scroll 0% 0% rgb(232, 227, 220);">
                            
                            <div class="floatleft smallpaddingright">First Name : <br /><input type="text" value="<?php echo $search_firstname;?>" name="txtSrchFirstname" id="txtSrchFirstname" style="width:110px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
                            <div class="floatleft smallpaddingright">Last Name : <br /><input type="text" value="<?php echo $search_lastname;?>" name="txtSrchLastname" id="txtSrchLastname" style="width:110px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
                            <div class="floatleft smallpaddingright">Email :  <br /><input type="text" value="<?php echo $search_email;?>" name="txtSrchEmail" id="txtSrchEmail" style="width:150px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
                            <div class="floatleft smallpaddingright">Phone :  <br /><input type="text" value="<?php echo $search_phone;?>" name="txtSrchPhone" id="txtSrchPhone" style="width:100px;margin-top: 5px;" /></div>
                            <div class="floatleft smallpaddingright" style="text-align:center">Adhi User :  <br /><input type="checkbox" value="yes" name="txtSrchAdhiUser" id="txtSrchAdhiUser" <?php echo ('yes' == $adhi_user_only) ? 'checked': '';?> style="width:80px;margin-top: 8px;" /></div>
                            
                            <div class="floatleft smallpaddingright">From :  <br />
                                <input type="text" maxlength="20" style="width:110px;margin-top: 5px;" name="txtSrchDateFrom" id="txtSrchDateFrom" readonly value="<?php echo $date_from;?>"/>
                                <img  src="<?php  echo $this->config->item('images');?>calendar.gif" alt="calendar" title="calendar" onclick="displayCalendar(document.frmadhischool.txtSrchDateFrom,'mm/dd/yyyy',this)" style="margin-bottom:-3px;"/>
                            </div>
                            
                            <div class="floatleft smallpaddingright">To :  <br />
                                <input type="text" maxlength="20" style="width:110px;margin-top: 5px;" name="txtSrchDateTo" id="txtSrchDateTo" readonly value="<?php echo  $date_to;?>"/>
                                <img  src="<?php  echo $this->config->item('images');?>calendar.gif" alt="calendar" title="calendar" onclick="displayCalendar(document.frmadhischool.txtSrchDateTo,'mm/dd/yyyy',this)" style="margin-bottom:-3px;"/>
                            </div>
                            
                            <div class="floatleft"><input type="submit" value="Search" style="margin-top: 18px;"/></div>
                            <a href="#" id="clearSearchFields" class="floatright" style="margin-top: 5px;margin-right: 24px;">Clear All</a>
			</div>
                    
                        <div class="floatright" style="margin-top:10px;"><a href="<?php echo site_url()."admin_user/add_trial_user"?>">Add Guest User</a></div>
                        <div class="floatright" style="margin-top:10px;margin-right:20px"><b>Total Count : <?php echo $total_user;?></b></div>
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
					<div class="adminlistheadings" style="width:9%; text-align:center;">Sl. No</div>
					<div class="adminlistheadings" style="width:13%;">First Name</div>
					<div class="adminlistheadings" style="width:16%;">Last Name</div>
					<div class="adminlistheadings" style="width:20%;">Email Id</div>
					<div class="adminlistheadings" style="width:15%;">Phone</div>
					<div class="adminlistheadings" style="width:15%;text-align:center;">Status</div>
					<div class="adminlistheadings" style="width:10%;text-align:center;">Actions</div>
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
                                                <div class="floatleft" style="width:9%;  text-align:center;"><?php print $count;?></div> 
                                                <div class="floatleft" style="width:13%;overflow: hidden"><?php echo $data->first_name; ?></div>
                                                <div class="floatleft" style="width:16%;overflow: hidden"><?php echo $data->last_name; ?></div>
                                                <div class="floatleft" style="width:20%;overflow: hidden;"><?php if($data->email !='') {echo $data->email; } else { echo  '&nbsp' ;} ?></div> 
                                                <div class="floatleft" style="width:15%;"><?php echo ($data->phone !="") ? $data->phone : "<span style='visibility:hidden'>Nil</span>"; ?></div>                                                                                          
                                                <div class="floatleft" style="width:15%;text-align:center;">
                                                        <?php if(0 == $data->status){
                                                                echo "Pending";
                                                        } else if(1 == $data->status) {
                                                                echo "Active";
                                                        } else if(2 == $data->status) {
                                                                //echo '<a href="'.base_url().'admin_user/view_users/'.$data->reg_user_id.'">Adhi User</a>';
                                                                echo 'Adhi User';
                                                        } else if(3 == $data->status)  {
                                                                echo "Expired";
                                                        }	
                                                        ?>
                                                </div> 
                                                <div class="floatleft" style="width:10%;text-align:center;">
                                                    <?php if(1 == $data->status){
                                                            echo '<a href="'.base_url().'admin_user/edit_trial_user/'.$data->id.'">Edit</a>';
                                                        }
                                                    ?>
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
				<div class="nodata">No Guest Users</div>
			<?php }?>
		</div>
		
</div>
<input type="hidden" id="hiduserid" name="hiduserid"  value="<?php if(isset($_POST['hiduserid'])){echo $_POST['hiduserid'];}?>" />
<input type="hidden" id="d_status" name="d_status"  value="" />
<?php echo form_close();?>
<script>
    $('clearSearchFields').addEventListener("click", function(event){
        event.preventDefault();
        $('txtSrchFirstname').value='';
        $('txtSrchLastname').value='';
        $('txtSrchEmail').value='';
        $('txtSrchPhone').value='';
        $('txtSrchDateFrom').value='';
        $('txtSrchDateTo').value='';
        $('txtSrchAdhiUser').checked=false;
        
         $("frmadhischool").submit();
    });
    </script>
    