<?php echo form_open('admin_meetourstaff', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="adminmainlist">
	<?php 
	if(count($staff) > 0){
	?>
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div>
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		
		<div class="listdata">
			<div class="leftsideheadings_view">Name</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $staff->name; ?><br />
				<img src="<?php echo $this->config->item('staff_image_upload_url').$staff->photo; ?>" alt="<?php echo $staff->name; ?>" title="<?php echo $staff->name; ?>" />
			</div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">Working From</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $staff->since; ?></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">Description</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $staff->description; ?></div>
			
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">Base hours</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $staff->basehour; ?></div>
			<div class="clearboth"></div>
				<div class="leftsideheadings_view">Weekly hour<span class="red_star">*</span></div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view">
					<div class="weekly"><span id="settotalweekly"><?php echo $staff->totalhour?> </span>&nbsp;&nbsp;
					 <a href="#" class="addweekly">Add Weekly hour</a>
					 <div id="addweeksec" style="display: none " > 
					 	<div class="leftsideheadings_view">Hour</div>
						<div class="middlecolon">:</div>
						<div class="rightsidedata_view"> 
							<input type="text" placeholder="Weekly hours" class="key-numeric" name="weeklyhour" id="weeklyhour" value="" />
							&nbsp;&nbsp;<a href="#" id="addhour" data-staff="<?php echo $staff->id?>">Add</a><span id="weekmsg"></span>
						</div>
					 </div>
					</div>	
				</div>
		</div>
	</div>
	
	<?php }?>
	<div class="backtolist"><a href="javascript:void(null);" onclick="javascript:gotolist(<?php echo $this->uri->segment(4);?>); return false;"><< Back to staff list </a></div>
 </div>
<?php echo form_close();?>
 