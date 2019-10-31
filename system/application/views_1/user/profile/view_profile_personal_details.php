	<div class="profile_personal_middle" >
		<div class="contentsmain">
			<div class="leftsideheadings_profileview">First Name</div>
			<div class="profileview_middlecolon">:</div>
			<div class="rightsidedata_profileview"><?php echo $userdetails->firstname; ?></div>
			<div class="clearboth"></div>
			
			<div class="leftsideheadings_profileview">Last Name</div>
			<div class="profileview_middlecolon">:</div>
			<div class="rightsidedata_profileview"><?php echo $userdetails->lastname; ?></div>
			<div class="clearboth"></div>
			
			<div class="leftsideheadings_profileview">Name on Certificate</div>
			<div class="profileview_middlecolon">:</div>
			<div class="rightsidedata_profileview"><?php echo $userdetails->name_on_certificate; ?></div>
			<div class="clearboth"></div>
			
			<div class="leftsideheadings_profileview">Forum Alias</div>
			<div class="profileview_middlecolon">:</div>
			<div class="rightsidedata_profileview"><?php echo $userdetails->forum_alias; ?></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_profileview">Email Id</div>
			<div class="profileview_middlecolon">:</div>
			<div class="rightsidedata_profileview"><?php echo $userdetails->emailid; ?></div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_profileview">Phone</div>
			<div class="profileview_middlecolon">:</div>
			<div class="rightsidedata_profileview"><?php echo $userdetails->phone; ?></div>
			<div class="clearboth"></div>
                        
                        <?php /*if($userdetails->note != ''){ ?>
                            <div class="leftsideheadings_profileview">Note</div>
                            <div class="profileview_middlecolon">:</div>
                            <div class="rightsidedata_profileview"><?php echo $userdetails->note; ?></div>
                            <div class="clearboth"></div>
                        <?php }*/ ?>
                        
			<div class="leftsideheadings_profileview">License Type</div>
			<div class="profileview_middlecolon">:</div>
			<div class="rightsidedata_profileview"><?php 
                                                            if('S' == $userdetails->licensetype )
                                                            {
                                                                    echo "Sales";
                                                            }
                                                            else
                                                            {
                                                                    echo "Broker";
                                                            }?>
<?php echo ', '.@$course_user_type->course_type.', '.@$course_user_type->payment_type;?>
			</div>
                        <div class="clearboth"></div>
			<div class="leftsideheadings_profileview">Unit Number</div>
			<div class="profileview_middlecolon">:</div>
			<div class="rightsidedata_profileview"><?php echo $userdetails->unit_number; ?></div>
               	</div>
	</div>
				