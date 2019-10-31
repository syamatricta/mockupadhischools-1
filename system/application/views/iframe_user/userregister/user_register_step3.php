<?php echo $this->load->view('iframe_user/userregister/package_menu'); ?>
<div class="main_wrapper">		
       	<section>
                <input type="hidden" id="hid_up" class="hid_up"/>
        	<div class="register_desc">
                <h1>Create Account</h1>	
                <p>
    				Note to student: Make sure that you input your name exactly as it appears on
					your drivers license and other legal documents.<br/> Don’t use any nicknames. For
					example, if your legal name is “Jonathan” don’t enter “John”.<br/>
					The names need to match up because your name will appear on your course
					completion certificates that you submit to the Bureau of Real Estate. Your
					license and exam application will be delayed if the name on your certificates
					doesn’t match the name on your legal documents.
    			</p>
         	</div>
   			
 			<div class="clearboth">&nbsp;</div>
			
    		<h3 class="register_heading"><img src="<?php echo base_url() ;?>images/iframe_user/images/arrow_smbl.png" alt="a"/><span class="register_heading_H01">Create Account</span><span class="register_heading_step1">Step 3</span></h3>         
            <div class="contactUs_Step1_Form">
            	<?php echo form_open("iframe_user/courseadd/".$site,array('name'=>'course','id'=>'course'));  ?>
            		<input type="hidden" name="s_state" id="s_state" value="<?php echo $this->session->userdata('s_state');?>"/>
					<input type="hidden" name="s_address" id="s_address" value="<?php echo $this->session->userdata('s_address');?>" />
					<input type="hidden" name="s_city" id="s_city" value="<?php echo $this->session->userdata('s_city');?>" />
					<input type="hidden" name="s_zipcode" id="s_zipcode" value="<?php echo $this->session->userdata('s_zipcode');?>" />
					<input type="hidden" name="s_country" id="s_country" value="<?php echo $this->session->userdata('s_country');?>" />
					<input type="hidden" name="bphone" id="bphone" value="<?php echo $this->session->userdata('phone');?>" />
					<input type="hidden" name="hidlicensetype" id="hidlicensetype" value="<?php echo $license;?>" />
					<input type="hidden" name="new_package" id="new_package" value="" />
                                        
					<div class="announcement_banner">
                    	<img src="<?php echo base_url();?>images/iframe_user/images/notification_icon.png" class="float_l notification_icon" alt="notification_icon"/>
                    	<div class="announce_text">
                        	<p>Do you want to take your classes with an optional live component or online?</p>
                            <span>Click below</span>
                        </div>
                    </div>
                    <div class="online_live_buttons">
 	                   <input type="button" value="LIVE" id="coursetypel" class="button_orange btn btn_withArrow" onclick="javascript:show_courses(1,'Live')" /> 
    	               <input type="button" value="ONLINE" id="coursetypeo" class="button_red btn btn_withArrow" onclick="javascript:show_courses(1,'Online')" /> 
                    </div>
                    
                    <input type="hidden" name="hidcoursetype" id="hidcoursetype" value="<?php echo set_value('hidcoursetype');?>"/>
                    
                    <div class="paytype_cntr radiobutton_group" id="paytype">
                     	<input type="radio" name="preferred_color" id="preferred_colorp" value="Package" onclick="javascript:show_courses(2,'Package');"  /><label for="preferred_colorp"> Select one of our package deals- recommended. It'll save you some cash in the long run</label><br/><br/>
                        <input type="radio" name="preferred_color" id="preferred_colorc" value="Cart" onclick="javascript:show_courses(2,'Cart');" /><label for="preferred_colorc"> buy each course on an a la carte basis</label><br/>
                    
                    	<hr/>
                    </div>
                    <input type="hidden" name="hidpaymenttype" id="hidpaymenttype" value="<?php echo set_value('hidpaymenttype');?>" />
                    
                    
                    
                    <div id="show_courses" class="display-none">
		      	 		<div class="courselist_head727 margin-left29 display-none" id="crs_list_heading"><h4>COURSE LIST</h4></div>
 						<div class="clearboth46">&nbsp;</div>
						<div id="update_course_div"></div>
 					</div>
					
                    <input  type="hidden" name="step3"  id="step3" value="3" />
                    <input  type="hidden" name="hidusertype"  id="hidusertype" value="" />
            		
            	
            	</form>
            	
            </div>	
             <div class="cb" id="page3_error" style="display: block;">
        	
			<?php if(isset($msg)) {?>
			<div  class="page_error errordiv"  ><?php if(isset($msg)) echo $msg; ?></div>
			<?php }  ?>
			<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("msg");   ?></div>
			<?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
        </div>
             
        </section>
    
     
</div>
<script>
show_courses(1,'Live');
</script>
 