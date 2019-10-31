<?php echo form_open($this->current_controller, array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
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
			
			<div class="leftsideheadings_view">Certificate Name</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $userdetails->name_on_certificate; ?></div>
			<div class="clearboth"></div>
			<?php if('' != $userdetails->driving_license){?>
                            <div class="leftsideheadings_view">Drivers License Number</div>
                            <div class="middlecolon">:</div>
                            <div class="rightsidedata_view">xxxxxxxxxx</div>
                            <div class="clearboth"></div>
                        <?php }?>
			<!--<div class="leftsideheadings_view">Forum Alias</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $userdetails->forum_alias; ?></div>
                        <div class="clearboth"></div>
                        -->
			<div class="leftsideheadings_view">Email Id</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $userdetails->emailid; ?></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">License Type</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php 
												if('S' == $userdetails->licensetype )
												{
													echo "Sales";
												}
												else 
												{
													echo "Broker";
												}
                        echo ', '.@$course_user_type->course_type.', '.@$course_user_type->payment_type?>
			</div>
                        <div class="clearboth"></div>
			<div class="leftsideheadings_view">Unit Number</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $userdetails->unit_number; ?></div>
                        <div class="clearboth"></div>
			<div class="leftsideheadings_view">How did you hear about us?</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $userdetails->testimonial;if ($userdetails->testimonial !='' && $userdetails->reason !='') echo ', ';echo $userdetails->reason; ?></div>
			<div class="clearboth"></div>
			
			<!--<div class="leftsideheadings_view">Address</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $userdetails->address; ?></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">State</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $state->state; ?></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">Country</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $userdetails->country; ?></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">Zip Code</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $userdetails->zipcode; ?></div>
			<div class="clearboth"></div>-->
			
			<div class="leftsideheadings_view">Shipping Address</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view">
											<?php echo $userdetails->s_address; ?><br>
											<?php echo $userdetails->s_city. ", ". @$s_state->state; ?><br>
											<?php echo $userdetails->s_country. ", ". $userdetails->s_zipcode; ?><br>
											</div>
			<div class="clearboth"></div>
			<?php if( trim($userdetails->b_address)!=''){ ?>
			<div class="leftsideheadings_view">Billing Address</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $userdetails->b_address; ?><br>
											<?php echo $userdetails->b_city. ", ". @$b_state->state; ?><br>
											<?php echo $userdetails->b_country." ". $userdetails->b_zipcode; ?><br>
											</div>
			<?php } ?>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">Phone</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $userdetails->phone; ?></div>
			<div class="clearboth"></div>
                   
			<div class="leftsideheadings_view">Note</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view"><?php echo $userdetails->note; ?></div>
			<div class="clearboth"></div>
                        
			<div class="leftsideheadings_view">Course Details</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view">
				<?php 
				foreach($coursedetails as $course){
					if(''==$course->parent_course_name){
						print $course->course_name."<br>";
					}
					else 
					{
						print $course->parent_course_name."(". $course->course_name.")"."<br>";
					}
				}?></div>
			<div class="clearboth"></div>
                        
                        <?php if(array_key_exists('obtained_license_from',$user_stat) && "" != $user_stat["obtained_license_from"]) { ?>
                            <div class="leftsideheadings_view">Hired By</div>
                            <div class="middlecolon">:</div>
                            <div class="rightsidedata_view"><?php echo ucfirst($user_stat['obtained_license_from']); ?></div>
                            <div class="clearboth"></div>
                        <?php } ?>
		</div>
	</div>
	<?php }?>
	<div class="backtolist"><a href="javascript:void(null);" onclick="javascript:gotobrokerlist(<?php echo $this->uri->segment(4);?>); return false;"><< Back to users list </a></div>
 </div>
<input type="hidden" id="hid_user_id" value="<?php echo $userdetails->id;?>" />
<?php echo form_close();?>


<style>
    .listdata{width:40%;}
    .leftsideheadings_view{width:35%;}
    .rightsidedata_view{width:60%;}
</style>