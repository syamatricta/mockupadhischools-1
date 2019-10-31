<div style="padding-left: 20px;">
    <div style="margin: 10px 0 10px 0px;">Welcome <?php echo ucfirst($this->session->userdata("USERNAME")); ?></div>
</div>

<!--<form id="user_export_form">
    <input type="hidden" id="first_name" name="first_name" value="<?php echo $ssearch_firstname;?>" />
    <input type="hidden" id="last_name" name="last_name" value="<?php echo $ssearch_lastname;?>" />
    <input type="hidden" id="email" name="email" value="<?php echo $ssearch_email;?>" />
    <input type="hidden" id="phone" name="phone" value="<?php echo $ssearch_phone;?>" />
</form>-->
<?php 
$form_action    = 'admin/sub_manager';
echo form_open_multipart($form_action, array('name'=>'frmadhischool','id' => 'frmadhischool'));
if('' != $this->uri->segment(3)){
    $segment = $this->uri->segment(3); 
} else{
    $segment ='';
}?>

<div class="adminmainlist">
	<div class="clearboth"> </div>
		<div class="adminpagebanner">
			<div class="adminpagetitle"><?php echo $page_title?></div>
		</div>
		<div class="clearboth"> </div>
		<div class="admininnercontentdiv">
			<div align="right" class="floatleft" style="width: 99%; text-align: right; border: 1px solid rgb(153, 153, 153);
			padding: 5px; background: none repeat scroll 0% 0% rgb(232, 227, 220);margin-bottom: 10px;">
                            <div class="floatleft smallpaddingright">First Name : <br /><input type="text" value="<?php echo $ssearch_firstname;?>"
                                               name="txtSrchFirstname" id="txtSrchFirstname" style="width:100px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
                            <div class="floatleft smallpaddingright">Last Name :  <br /><input type="text" value="<?php echo $ssearch_lastname;?>"
                                                name="txtSrchLastname" id="txtSrchLastname" style="width:100px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
                            <div class="floatleft smallpaddingright">Email :  <br /><input type="text" value="<?php echo $ssearch_email;?>"
                                                name="txtSrchEmail" id="txtSrchEmail" style="width:100px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>

                            <div class="floatleft smallpaddingright">Phone :  <br /><input type="text" value="<?php echo $ssearch_phone;?>"
                                               name="txtSrchPhone" id="txtSrchPhone" style="width:90px;margin-top: 5px;" />&nbsp;&nbsp;&nbsp;</div>
                            
                            <div class="floatleft smallpaddingright">
                                <br /><input type="submit" value="Search" style=""/>&nbsp;&nbsp;
                            </div>
			</div>
                    
                        <?php 
			if(count($userdetails) > 0){	
			?>
			<div class="listdata">
				<div class="clearboth">&nbsp;</div>
				<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");   ?></div>
				<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
				<div class="clearboth"> </div>

				<div class="admintopheads">
                                        <?php
                                            $column1= '5%';
                                            $column2= '20%';
                                            $column3= '20%';
                                            $column4= '25%';
                                            $column5= '20%';
                                            $column6= '10%';
                                        ?>
					<div class="adminlistheadings" style="width:<?php echo $column1;?>; text-align:center;">Sl. No</div>
					<div class="adminlistheadings" style="width:<?php echo $column2;?>">First Name</div>
					<div class="adminlistheadings" style="width:<?php echo $column3;?>">Last Name</div>
                                        <div class="adminlistheadings" style="width:<?php echo $column4;?>">Email Id</div>
					<div class="adminlistheadings" style="width:<?php echo $column5;?>">Phone</div>
					<div class="adminlistheadings" style="width:<?php echo $column6;?>;text-align:center;">Courses</div>
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
                                        <div class="floatleft" style="width:<?php echo $column2;?>;overflow: hidden"><?php echo $data->firstname;?></div>
                                        <div class="floatleft" style="width:<?php echo $column3;?>;overflow: hidden"><?php echo $data->lastname;?></div>
				 	<div class="floatleft" style="width:<?php echo $column4;?>;overflow: hidden;"><?php if($data->emailid !='') {echo $data->emailid; } else { echo  '&nbsp' ;} ?></div> 
				 	<div class="floatleft" style="width:<?php echo $column5;?>;overflow: hidden"><?php echo $data->phone;?></div>
				 	
					<div class="floatleft" style="width:<?php echo $column6;?>;text-align:center;">
                                            <?php echo anchor('admin/view_users/'.$data->id.'/'.$segment,'View')?>
					</div>
				</div>
				<div class="clearboth"> </div>
				<?php $count++; 
	/* data list ends here */ 			
			}?>
			<div class="pagination"><?php  echo $paginate;?></div>
			<div style="clear:both">&nbsp;</div>
			<?php } else { ?>
                            <div> No matching data </div>
                        <?php  } ?>
		</div>
		
</div>
<input type="hidden" id="hiduserid" name="hiduserid"  value="<?php if(isset($_POST['hiduserid'])){echo $_POST['hiduserid'];}?>" />
<?php echo form_close();?>

<style>
    .smallpaddingright{padding-right: 0;}
</style>
