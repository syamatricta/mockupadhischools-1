<div class="floatleft" >
   <div class="left_cntnr pb_100 pos_rel">
         <?php $this ->load->view('left_content_home.php');?>
    </div> 
    <div class="right_cntnr">
        <div class="right_cntnr_bg_hd" >
            <div class="floatleft w100perc">
                 <div class="sitepagehead"><h1>Careers</h1><h2>Careers</h2></div>
                 <div class="username"><?php echo $this->session->userdata('USER_NAME')." ". $this->session->userdata('LAST_NAME'); ?></div>
            </div>          		
		</div>
        <div class="clearboth"></div>
        <div class="right_cntnr_bg" >
        	<div id="sitepagemain">               
				<div class="sitepagecontent">				
					<div id="test-accordion" class="accordion career_div ">
						<div class="accordion-toggle" id="career_image" onclick="change_bg('career_image')" >Careers at ADHI Schools</div>
						<div class="accordion-content crr_out_bg"   class="crr_out_bgin1">            
					        <div class="crr_out_bgin1">
						        <div class="crr_out_bgin2">Position:</div>
						        <div class="crr_out_bgin3">Real estate instructor</div>
						        <div class="crr_out_bgin4">Compensation:</div>
						        <div class="crr_out_bgin5">Depending on experience</div>
					        </div>
					        <div class="crr_out_bgin6">
						        <div class="crr_out_bgin7">Requirements:</div>
						        <div class="crr_out_bgin8"><img src="<?php echo base_url();  ?>images/career/bullet.png" alt="bullet" class="mr_10">Bachelors degree or masters preferred. </div>
						        <div class="crr_out_bgin9"><img src="<?php echo base_url();  ?>images/career/bullet.png" alt="bullet" class="mr_10">A minimum of three years of fulltime realestate experience. </div>
						        <div class="crr_out_bgin10"><img src="<?php echo base_url();  ?>images/career/bullet.png" alt="bullet" class="mr_10">Actively engaged in realestates sales, loan origination or property management.</div>
					        </div>
					        <div class="cb"></div>
					        <div class="crr_out_bgin11">Please submit resume to our corporate headquarters. <b class="bfsize" >Call 888 768 5285 </b> for more information.</div>
				        </div>
        				<div class="accordion-toggle mt_24" id="career_map" onclick="change_bg('career_map')" >Broker Placement</div>
						<div class="accordion-content"  >
				            <?php $this->load->view('user/career_brokerplacement'); ?>
				        </div>        
						<div class="accordion-toggle mt_24" id="career_videodiv" onclick="change_bg('career_videodiv')" >ADHI Job Creation</div>
							<div class="accordion-content">
					           <div class="crr_out_bgin12">Over the last ten years, ADHI Schools has helped place hundreds of our students with local brokers throughout California. Many of our alumni have gone on to become top producers, mentors and managers at their respective companies. We have deep
					                relationships with over 150 real estate offices and can help you get placed with the right broker. All of our broker placement services are free of charge and an added benefit of being part of the ADHI family.</div>
					
					           <div class="crr_out_bgin13"><img src="<?php echo base_url();  ?>images/career/header_02.png" alt="carrer-header"></div>
					           <div class="crr_out_bgin14">
					               <iframe width="640" height="389" src="http://www.youtube.com/embed/9cU5sP47NSY?html5=1" frameborder="0" allowfullscreen></iframe>
					           </div>
							</div>						
						</div>							
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

   