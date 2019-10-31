<form id="user_export_form">
    <input type="hidden" id="first_name" name="first_name" value="<?php echo $search_firstname;?>" />
    <input type="hidden" id="last_name" name="last_name" value="<?php echo $search_lastname;?>" />
    <input type="hidden" id="email" name="email" value="<?php echo $search_email;?>" />
    <input type="hidden" id="phone" name="phone" value="<?php echo $search_phone;?>" />
    <input type="hidden" id="city" name="city" value="<?php echo $search_city;?>" />
    <input type="hidden" id="zipcode" name="zipcode" value="<?php echo $search_zipcode;?>" />
    <input type="hidden" id="cor_completed" name="c_completed" value="<?php echo $course_completed;?>" />
    <input type="hidden" id="brokerage" name="brokerage" value="<?php echo $search_brokerage;?>" />
    <input type="hidden" id="lic_type" name="lic_type" value="<?php echo (isset($license_type) && ('S' == $license_type || 'B' == $license_type)) ? $license_type : '';?>" />
    <input type="hidden" id="c_type" name="c_type" value="<?php echo (isset($course_type) && ('online' == $course_type|| 'live' == $course_type)) ? $course_type : '';?>" />
</form>
<?php 
$form_action    = (2 == s('ADMINTYPE')) ? $this->current_controller.'/list_user_details' : $this->current_controller;
echo form_open_multipart($form_action, array('name'=>'frmadhischool','id' => 'frmadhischool'));
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
			<div align="right" class="floatleft" style="width: 99%; text-align: right; border: 1px solid rgb(153, 153, 153);
			padding: 5px; background: none repeat scroll 0% 0% rgb(232, 227, 220);margin-bottom: 10px;">
                            <div class="floatleft smallpaddingright">First Name : <br /><input type="text" value="<?php echo $search_firstname;?>"
                                               name="txtSrchFirstname" id="txtSrchFirstname" style="width:100px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
                            <div class="floatleft smallpaddingright">Last Name :  <br /><input type="text" value="<?php echo $search_lastname;?>"
                                                name="txtSrchLastname" id="txtSrchLastname" style="width:100px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
                            <div class="floatleft smallpaddingright">Email :  <br /><input type="text" value="<?php echo $search_email;?>"
                                                name="txtSrchEmail" id="txtSrchEmail" style="width:100px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>

                            <div class="floatleft smallpaddingright">Phone :  <br /><input type="text" value="<?php echo $search_phone;?>"
                                               name="txtSrchPhone" id="txtSrchPhone" style="width:90px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
                            
                            <div class="floatleft smallpaddingright">City :  <br /><input type="text" value="<?php echo $search_city;?>"
                                              name="txtSrchCity" id="txtSrchCity" style="width:80px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
                            
                            <div class="floatleft smallpaddingright">Zipcode :  <br /><input type="text" value="<?php echo $search_zipcode;?>"
                                             name="txtSrchZipcode" id="txtSrchZipcode" style="width:70px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>

                            <div class="floatleft smallpaddingright">Brokerage :  <br /><input type="text" value="<?php echo $search_brokerage;?>"
                                            name="txtBrokerage" id="txtBrokerage" style="width:80px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>

                            <div class="floatleft smallpaddingright">License :  <br /><select id="license_type" name="license_type" style="margin-top: 5px;">
                                    <option value="" >all</option>
                                    <option <?php echo (isset($license_type) && 'S' == $license_type)?'selected':'';?>  value="S" >Sales</option>
                                    <option <?php echo (isset($license_type) && 'B' == $license_type)?'selected':'';?>  value="B" >Broker</option>
                                </select>
                                &nbsp;&nbsp;&nbsp;
                            </div>
                            <div class="floatleft smallpaddingright">Course Type :  <br /><select id="course_type" name="course_type" style="margin-top: 5px;">
                                    <option value="" >all</option>
                                    <option <?php echo (isset($course_type) && 'live' == $course_type)?'selected':'';?>  value="live" >Live</option>
                                    <option <?php echo (isset($course_type) && 'online' == $course_type)?'selected':'';?>  value="online" >Online</option>
                                </select>
                                &nbsp;&nbsp;&nbsp;
                            </div>

                            <div class="floatright">
                                <br /><input type="submit" value="Search" style=""/>&nbsp;&nbsp;</div>
			</div>
                        <div class="floatleft"><?php echo $total;?> User(s) found</div>
                        <div class="floatright"><a style="margin-right:10px;" href="#" id="export_users_brokerage" onclick="fncsUserExportBrokerage()">Export</a></div>
                        
                        <?php 
			if(count($userdetails) > 0){
				/* list headings starts here*/		
			?>
			<div class="listdata">
				
				<div class="clearboth">&nbsp;</div>
				<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");   ?></div>
				<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
				<div class="clearboth"> </div>
				<div class="admintopheads">
                                        <?php
                                            $column1= '5%';
                                            $column2= '15%';
                                            $column3= '15%';
                                            $column4= '8%';
                                            $column5= '15%';
                                            $column6= '10%';
                                            $column7= '12%';
                                            $column8= '10%';
                                            $column9= '10%';
                                            if(2 == s('ADMINTYPE')){
                                                $column5= '10%';
                                                $column6= '8%';
                                                $column7= '15%';
                                            }
                                        ?>
					<div class="adminlistheadings" style="width:<?php echo $column1;?>; text-align:center;">Sl. No</div>
					<div class="adminlistheadings" style="width:<?php echo $column2;?>">Name</div>
					<div class="adminlistheadings" style="width:<?php echo $column3;?>">Email Id</div>
                                        <div class="adminlistheadings" style="width:<?php echo $column4;?>;text-align:center;">License Type</div>
                                        <div class="adminlistheadings" style="width:<?php echo $column5;?>;text-align:center;">Broker</div>
                                        <div class="adminlistheadings" style="width:<?php echo $column6;?>text-align:center;">Phone</div>
                                        <div class="adminlistheadings" style="width:<?php echo $column7;?>text-align:center;">City</div>
                                        <div class="adminlistheadings" style="width:<?php echo $column8;?>text-align:center;">Zipcode</div>
					<div class="adminlistheadings" style="width:<?php echo $column9;?>;text-align:center;">Actions</div>
				</div>
			</div>
			<div class="clearboth"> </div>
		<?php  
                           $count=1; 
			   if ($this->uri->segment(3)){
					$count = $count+$this->uri->segment(3);
				} 
				   foreach($userdetails as $data){
				  $bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';
	
				 ?>
				  <div class="<?php print($bg_color);?>">
                                        <div class="floatleft" style="width:<?php echo $column1;?>;  text-align:center;"><?php print $count;?></div> 

				 	<div class="floatleft" style="width:<?php echo $column2;?>;overflow: hidden"><?php echo $data->firstname.' '.$data->lastname;?></div>
				 	<div class="floatleft" style="width:<?php echo $column3;?>;overflow: hidden;"><?php if($data->emailid !='') {echo $data->emailid; } else { echo  '&nbsp' ;} ?></div> 
				 	<div class="floatleft" style="width:<?php echo $column4;?>;text-align:center;">
                                            <?php  
                                            if($data->licensetype !=''){ 
                                                if('B' == $data->licensetype){
                                                        echo "Broker";
                                                } else {
                                                        echo "Sales";
                                                }
                                            } else { 
                                                echo  '&nbsp' ;
                                            } 
                                            ?>
                                        </div> 
                                        <div class="floatleft" style="width:<?php echo $column5;?>;  text-align:center;"><?php print $data->broker_name;?></div> 
                                        <div class="floatleft" style="width:<?php echo $column6;?>;  text-align:center;"><?php print $data->phone;?></div> 
                                        <div class="floatleft" style="width:<?php echo $column7;?>;  text-align:center;"><?php print $data->city;?></div> 
                                        <div class="floatleft" style="width:<?php echo $column8;?>;  text-align:center;"><?php print $data->zipcode;?></div> 
					<div class="floatleft" style="width:<?php echo $column9;?>;text-align:center;">
						<?php echo anchor($this->current_controller.'/view_users/'.$data->id.'/'.$segment,'Details')?> |
                                                <?php echo anchor($this->current_controller.'/user_course_details/'.$data->id.'/'.$segment,'Course')?>
                                        </div>
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

<style>
    .smallpaddingright{padding-right: 0;}
</style>