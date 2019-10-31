<form id="user_export_form">
    <input type="hidden" id="first_name" name="first_name" value="<?php echo $first_name;?>" />
    <input type="hidden" id="last_name" name="last_name" value="<?php echo $last_name;?>" />
    <input type="hidden" id="email" name="email" value="<?php echo $email;?>" />
    <input type="hidden" id="phone" name="phone" value="<?php echo $phone;?>" />
    <input type="hidden" id="event_id" name="event_id" value="<?php echo $event_id;?>" />
</form>
<?php 
echo form_open_multipart(base_url().'admin_career_event/list_bookings', array('name'=>'frmadhischool','id' => 'frmadhischool'));
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
                            <div class="floatleft smallpaddingright">Events :  <br /><select id="txtSrchEvent" onchange="document.getElementById('frmadhischool').submit();" name="txtSrchEvent" style="margin-top: 5px;">
                                    <option value="" >all</option>
                                    <?php
                                        foreach($events as $event){
                                            $selected = ($event->id == $event_id) ? 'selected' : '';
                                            echo '<option '.$selected.' value="'.$event->id.'" >'.$event->title.'</option>';
                                        }
                                    ?>
                                    
                                </select>
                                &nbsp;&nbsp;&nbsp;
                            </div>
                            <div class="floatleft smallpaddingright">First Name : <br /><input type="text" value="<?php echo $first_name;?>" name="txtSrchFirstname" id="txtSrchFirstname" style="width:110px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
                            <div class="floatleft smallpaddingright">Last Name :  <br /><input type="text" value="<?php echo $last_name;?>" name="txtSrchLastname" id="txtSrchLastname" style="width:110px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
                            <div class="floatleft smallpaddingright">Email :  <br /><input type="text" value="<?php echo $email;?>" name="txtSrchEmail" id="txtSrchEmail" style="width:130px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>

                            <div class="floatleft smallpaddingright">Phone :  <br /><input type="text" value="<?php echo $phone;?>" name="txtSrchPhone" id="txtSrchPhone" style="width:90px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
                            <div class="floatleft"> &nbsp;&nbsp;&nbsp; <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Search" style="margin-top: 5px;"/></div>
			</div>
                        <div class="floatright"><a style="margin-right:10px;" href="#" id="export_users" onclick="fncBookingExport()">Event wise Export</a></div>
                        
                        <?php 
			if(count($bookings) > 0){
			?>
			<div class="listdata">
				
				<div class="clearboth">&nbsp;</div>
				<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");   ?></div>
				<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
				<div class="clearboth"> </div>

				<div class="clearboth"> </div>
				<div class="admintopheads">
                                        <?php
                                            $column1= '5%';
                                            $column2= '15%';
                                            $column3= '20%';
                                            $column4= '15%';
                                            $column5= '25%';
                                            $column6= '20%';
                                            $column7= '10%';
                                        ?>
					<div class="adminlistheadings" style="width:<?php echo $column1;?>; text-align:center;">Sl. No</div>
					<div class="adminlistheadings" style="width:<?php echo $column2;?>">Name</div>
					<div class="adminlistheadings" style="width:<?php echo $column3;?>">Email Id</div>
					<div class="adminlistheadings" style="width:<?php echo $column4;?>">Phone</div>
					<div class="adminlistheadings" style="width:<?php echo $column5;?>">Event Name</div>
                                        <div class="adminlistheadings" style="width:<?php echo $column6;?>%">Event Date</div>
                                        
				</div>
			</div>
			<div class="clearboth"> </div>
                        <?php
                            $count=1; 
                            if ($this->uri->segment(3)){
                                $count = $count+$this->uri->segment(3);
                            }
                            foreach($bookings as $data){
				  $bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';
                        ?>
				<div class="<?php print($bg_color);?>">
                                    <div class="floatleft" style="width:<?php echo $column1;?>;  text-align:center;"><?php print $count;?></div> 
                                    <div class="floatleft" style="width:<?php echo $column2;?>;overflow: hidden"><?php echo $data->first_name.' '.$data->last_name;?></div>
                                    <div class="floatleft" style="width:<?php echo $column3;?>;overflow: hidden;"><?php echo $data->email;?></div> 
                                    <div class="floatleft" style="width:<?php echo $column4;?>;"><?php echo $data->phone;?></div>
                                    <div class="floatleft" style="width:<?php echo $column5;?>;"><?php echo $data->event_name?></div> 
                                    <div class="floatleft" style="width:<?php echo $column6;?>;"><?php echo formatDate($data->event_date);?></div> 
                                    <!--<div class="floatleft" style="width:<?php echo $column7;?>;text-align:center;">
                                        <a href="javascript:void(null);" onclick="javascript:cancelBooking(<?php echo $data->id?>); return false;">Cancel Booking</a>                                                    
                                    </div>-->
				</div>
				<div class="clearboth"> </div>
				<?php $count++; 
	/* data list ends here */ 			
			}?>
			<div class="pagination"><?php  echo $paginate;?></div>
			<div style="clear:both">&nbsp;</div>
			<?php }else { ?>
				<div class="nodata">No recored found</div>
			<?php }?>
		</div>
</div>
<?php echo form_close();?>