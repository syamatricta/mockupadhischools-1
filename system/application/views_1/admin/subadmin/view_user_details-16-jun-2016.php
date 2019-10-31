<?php echo form_open('admin_sub', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="adminmainlist">
	<?php 
	if(count($userdetails) > 0){
	?>
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
                
                
        </div>
        
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		
		<div class="listdata">
			<div class="leftsideheadings_view">First Name</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $userdetails->firstname; ?></div>
			<div class="clearboth"></div>
                        
			<div class="leftsideheadings_view">Last Name</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $userdetails->lastname; ?></div>
			<div class="clearboth"></div>
			
                        <div class="leftsideheadings_view">User Name</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $userdetails->username; ?></div>
			<div class="clearboth"></div>
			
			<div class="leftsideheadings_view">Email Id</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $userdetails->emailid; ?></div>
			<div class="clearboth"></div>
                        
                        <div class="leftsideheadings_view">Address</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $userdetails->company_address; ?></div>
			<div class="clearboth"></div>
			
                        <div class="leftsideheadings_view">City</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $userdetails->city; ?></div>
			<div class="clearboth"></div>
                        
                        <div class="leftsideheadings_view">State</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $state->state; ?></div>
			<div class="clearboth"></div>
                        
			<div class="leftsideheadings_view">Phone</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $userdetails->phone; ?></div>
			<div class="clearboth"></div>
                        
                        <div class="leftsideheadings_view">Zipcode</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $userdetails->zpcode; ?></div>
			<div class="clearboth"></div>
			
                        
		</div>
	</div>
	<?php }?>
        <div class="backtolist">
            <a href="javascript:void(null);" onclick="javascript:gotolist(<?php echo $this->uri->segment(4);?>); return false;"><< Back to Sub-Admins list </a>
            
        </div>
 </div>
<?php echo form_close();?>