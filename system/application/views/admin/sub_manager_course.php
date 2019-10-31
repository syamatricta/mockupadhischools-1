<?php echo form_open('admin/view_users/'.$userdetails->id, array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="adminmainlist">
	<?php 
	if(count($userdetails) > 0){
	?>
	<div class="adminpagebanner">
		<div class="adminpagetitle"> User Details </div>
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
			
			<div class="leftsideheadings_view">Email Id</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $userdetails->emailid; ?></div>
			<div class="clearboth"></div>
			
			<div class="leftsideheadings_view">Phone</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $userdetails->phone; ?></div>
			<div class="clearboth"></div>
                   
                        <h3> Course Details </h3>
                        <?php if(!empty($coursedetails)) { 
                            foreach($coursedetails as $course){
                        ?>
                        <div class="leftsideheadings_view">
                            <?php if(''==$course->parent_course_name){
                                    print $course->course_name."<br>";
                            }else{
                                    print $course->parent_course_name."(". $course->course_name.")"."<br>";
                            } ?>
                        </div>
                            <div class="middlecolon">:</div>
                            <div class="rightsidedata_view">
                                <?php echo ("P" == $course->status) ? "Completed on ". date("m/d/Y",strtotime($course->last_attemptdate)) : "Not Completed"; ?>
                            </div>
                        <?php
                                
                            }
                        }
                        ?>
                            
			<div class="clearboth"></div>
                        
                        <div class="leftsideheadings_view">Crash course account created</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $crash ? "Yes" : "No"; ?></div>
			<div class="clearboth"></div>

		</div>
	</div>
	<?php }?>
	<div class="backtolist"><a href="<?php echo base_url().'admin/sub_manager/'.$this->uri->segment(4); ?>"><< Back to users list </a></div>
 </div>
<input type="hidden" id="hid_user_id" value="<?php echo $userdetails->id;?>" />
<?php echo form_close();?>


<style>
    .listdata{width:40%;}
    .leftsideheadings_view{width:45%;}
    .rightsidedata_view{width:50%;}
</style>