<div class="profile_personal_middle" >
	<div class="contentsmain">
		
		<div class="leftsideheadings_profileview">Address</div>
		<div class="middlecolon">:</div>
		<div class="rightsidedata_profileview"><?php echo $userdetails->b_address; ?></div>
		<div class="clearboth"></div>
		
		<div class="leftsideheadings_profileview">State</div>
		<div class="middlecolon">:</div>
		<div class="rightsidedata_profileview"><?php echo @$b_state->state; ?></div>
		<div class="clearboth"></div>
		
		<!--<div class="leftsideheadings_profileview">Country</div>
		<div class="middlecolon">:</div>
		<div class="rightsidedata_profileview"><?php if('US' == $userdetails->b_country) { echo "United States";}  ?></div>
		<div class="clearboth"></div>-->
		
		<div class="leftsideheadings_profileview">City</div>
		<div class="middlecolon">:</div>
		<div class="rightsidedata_profileview"><?php echo $userdetails->b_city; ?></div>
		<div class="clearboth"></div>
		
		<div class="leftsideheadings_profileview">Zip Code</div>
		<div class="middlecolon">:</div>
		<div class="rightsidedata_profileview"><?php echo $userdetails->b_zipcode; ?></div>
	</div>
</div>
