<?php

	if($license == 'B'){ 
		$j=0;?>
  		<div class="subhead_txt margin-left58">The following courses are required </div>
	 	<div class="clearboth">&nbsp;</div>
	    <?php /* Mandatory Courses */ ?>
	    <?php #print_r($courses_m);?>

<?php 	
		$courses_cbm = $courses_m;
		foreach($courses_cbm as $courses_m){ 
			$j = $j+1; ?>
<?php  		if($j == 6){ ?>
  				<div class="clearboth">&nbsp;</div>
			    <div class="regcourcediv subhead_txt margin-left58">Choose three from the bottom list </div>
				<div class="clearboth">&nbsp;</div>
<?php 		} ?>
			    <div  class="regcourcediv  " >
			   		<input type="hidden" name="courseprice<?php echo $courses_m['course_id']; ?>" id="courseprice<?php echo $courses_m['course_id']; ?>" value="<?php echo $courses_m['amount']; ?>"   />
 			        <img  src="<?php  echo ssl_url_img();?>course_checkbox_uncheck.png" width="13" height="13" id="course_chkimg<?php echo $courses_m['course_id']; ?>" onClick="javascript:showterms(<?php echo $courses_m['course_id']; ?>), checkrate();"/>&nbsp;&nbsp;
                    <input  type="checkbox" class="scheck display-none" name="course[]" id="course<?php echo $courses_m['course_id']; ?>" value="<?php echo $courses_m['course_id']; ?>"  />
			        <span onClick="javascript:showterms(<?php echo $courses_m['course_id']; ?>), checkrate();"><?php 	if($courses_m['amount'] !=0.00){
								echo $courses_m['course_name'] ." -  $".$courses_m['amount']; 
							}else {
								echo $courses_m['course_name'] ; 
							}  ?>
 					</span>
                    <input type="hidden" name="selagree<?php echo $courses_m['course_id']; ?>" id="selagree<?php echo $courses_m['course_id']; ?>" value="0" />
				    <input type="hidden" name="courseweight<?php echo $courses_m['course_id']; ?>" id="courseweight<?php echo $courses_m['course_id']; ?>" value="<?php echo $courses_m['wieght']; ?>"  />
 			    </div>
 			      
		 
 			    <?php } ?>
  			    <div class="clearboth">&nbsp;</div>
 
				<?php 			
				foreach($courses_cbm as $courses_m){ 
					$j = $j+1; 
					 
 					  /* Terms and condition starts here  */ ?>
							<div class="filedforrate paddingbottom courses_csmTC" id="showdiv<?php echo $courses_m['course_id']; ?>" style="display:none;" >
		 						
		 						<div class="license_agreement_wrapper"> 
							        	<div class="example">
							            <div id="main_content" style="height:90%;">
							                <div class="parent">
							                	<?php $this->load->view('register/course_agreement')?>
							                 </div>
							            </div>
							        </div>
							        <div class="custom_checkbox clearfix">
							        	<div  class="filedforterm agreement" >
											<div class="agreementagreecheck fl"><img  src="<?php  echo ssl_url_img();?>checkbox_uncheck.png" width="25" height="24" id="agree<?php echo $courses_m['course_id']; ?>" onclick="javascript:showcheck(<?php echo $courses_m['course_id']; ?>), checkrate();"/><!--<input type="checkbox" name="agree<?php echo $courses_m['course_id']; ?>" id="agree<?php echo $courses_m['course_id']; ?>" value="<?php echo $courses_m['course_id']; ?>" onclick="javascript:showcheck(this.value), checkrate();">--></div>
									        <div class="agreementagreetext fl" onclick="javascript:showcheck(<?php echo $courses_m['course_id']; ?>), checkrate();">I Agree</div>
									        <div class="fl"><img  src="<?php  echo ssl_url_img();?>checkbox_uncheck.png" width="25" height="24" id="disagree<?php echo $courses_m['course_id']; ?>" onclick="javascript:showuncheck(<?php echo $courses_m['course_id']; ?>), checkrate();"/><!--<input type="checkbox" name="disagree<?php echo $courses_m['course_id']; ?>" id="disagree<?php echo $courses_m['course_id']; ?>" value="<?php echo $courses_m['course_id']; ?>" onclick="javascript:showuncheck(this.value), checkrate();"  />--></div>
									        <div class="agreementdonttext fl" onclick="javascript:showuncheck(<?php echo $courses_m['course_id']; ?>), checkrate();">I Don't Agree</div>
									    </div> 
									    <div class="clearboth"></div>                  
							        </div>
								</div>
								
 						    </div>
				 		<div class="clearboth"></div>
		 
 			    <?php } 


 			    
 			    
 			    
 			    
 			    
 			    ?>
<?php }?>
    <div class="clearboth">&nbsp;</div>
 
