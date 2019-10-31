<?php echo form_open('admin_sub', array('name'=>'frmadhischool','id' => 'frmadhischool'));
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
    <div class="clearboth"> </div>
    <div class="admininnercontentdiv">
        
        <div align="right" class="floatleft" style="width: 99%; text-align: right; border: 1px solid rgb(153, 153, 153); padding: 5px; background: none repeat scroll 0% 0% rgb(232, 227, 220);">
            <div class="floatleft smallpaddingright">First Name : <input type="text" value="<?php echo $search_firstname;?>" name="txtSrchFirstname" id="txtSrchFirstname" />&nbsp;&nbsp;&nbsp;</div>
            <div class="floatleft smallpaddingright">Last Name : <input type="text" value="<?php echo $search_lastname;?>" name="txtSrchLastname" id="txtSrchLastname" />&nbsp;&nbsp;&nbsp;</div>
            <div class="floatleft smallpaddingright">Email : <input type="text" value="<?php echo $search_email;?>" name="txtSrchEmail" id="txtSrchEmail" /></div>
            <div class="floatleft smallpaddingright"><label for="txtSrchPermission" style="float:left;margin-top:5px;margin-left:10px;display:inline-block">Extra Permission : </label><input type="checkbox" style="float:left;margin-top:6px;" value="1" <?php echo (1 == $search_permission) ? 'checked' : '';?> name="txtSrchPermission" id="txtSrchPermission" /></div>
            

            <div class="floatleft"> &nbsp;&nbsp;&nbsp;<input type="submit" value="Search" name="search" /></div>
	</div>
        
        <div class="floatright"><a href="<?php echo site_url()."admin_sub/add"?>">Add new Sub-Admin</a></div>
        <?php 
			if(count($subadmin_details) > 0){
				/* list headings starts here*/		
			?>
        <div class="listdata">
            
            <div class="clearboth">&nbsp;</div>
	    <div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");   ?></div>
	    <div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
            <div class="clearboth"> </div>
            
            <div class="admintopheads">
                <div class="adminlistheadings" style="width:5%; text-align:center;">Sl. No</div>
                <div class="adminlistheadings" style="width:15%;">Name</div>
                <div class="adminlistheadings" style="width:10%;">Userame</div>
                <div class="adminlistheadings" style="width:15%;">Email Id</div>
                <div class="adminlistheadings" style="width:15%;text-align:center;">Extra Permission</div>
                <div class="adminlistheadings" style="width:10%;text-align:center;">Status</div>
                <div class="adminlistheadings" style="width:30%;text-align:center;">Actions</div>
            </div>
            
            <div class="clearboth"> </div>
		<?php  
	/* list headings ends here*/
				$count=1; 
			   if ($this->uri->segment(3)){
					$count = $count+$this->uri->segment(3);
				} 
				   foreach($subadmin_details as $data){
				  $bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';
	/* data list starts here */ 
				 ?>
				  <div class="<?php print($bg_color);?>">
				 	<div class="floatleft" style="width:5%;  text-align:center;"><?php print $count;?></div> 
				 	<div class="floatleft" style="width:15%;"><?php echo $data->firstname.' '.$data->lastname;?></div>
				 	<div class="floatleft" style="width:10%;"><?php echo $data->username;?></div>
                                        <div class="floatleft" style="width:15%;"><?php if($data->emailid !='') {echo $data->emailid; } else { echo  '&nbsp' ;} ?></div> 
				 	
                                        <div class="floatleft" style="width:15%;text-align:center;"><?php echo (1 == $data->sub_admin_permission) ? 'Yes': 'No';?></div>
				 	<div class="floatleft" style="width:10%;text-align:center;">
				 		Active
					</div> 
					<div class="floatleft" style="width:30%;text-align:center;">
						<?php echo anchor('admin_sub/view/'.$data->id.'/'.$segment,'View')?>&nbsp;|&nbsp;
						<?php echo anchor('admin_sub/update/'.$data->id.'/'.$segment,'Edit');?>&nbsp;|&nbsp; 
                                                <?php echo anchor('admin_sub/'.$data->id.'/'.$segment,'Delete',array("onclick"=>"return delete_subadmin(".$data->id.")"));?>&nbsp;|&nbsp;
                                                <?php echo anchor('admin_sub/reset_password/'.$data->id.'/'.$segment,'Reset Password')?>
                                        </div> 
					 
				</div>
				<div class="clearboth"> </div>
				<?php $count++; 
	/* data list ends here */ 			
			}?>
			<div class="pagination"><?php  echo $paginate;?></div>
			<div style="clear:both">&nbsp;</div></div>
			<?php }else if($post_data == 1) { ?>
				<div class="nodata"style="padding-top:10px;">No sub-admin found</div>
			<?php } else { ?>
				<div class="nodata" style="margin-top:10px;">No sub-admin created</div>
			<?php }?>
        
    </div>
</div>               
<?php echo form_close();?>
