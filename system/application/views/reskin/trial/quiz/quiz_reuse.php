<?php echo  form_open ('user/change_password', array('name'=>'change_password_form_adhi','id' => 'change_password_form_adhi', 'class' => '',  'onsubmit'=>'javascript: return change_password ();') ); ?>
<div id="maindiv">
	<div id="profileviewmain" >
  	<?php /*functional part */?>
	   
		<div class="clearboth" style="height:90px;">&nbsp;</div>
		<div class="examdata" >
			<div class="profile_personal_left"><img  src="<?php  echo $this->config->item('images');?>innerpages/profile_personal_left.jpg" /></div>
			<div class="exam_middle" >
				<div class="change_password_main"  >
					<div class="page_error" style="padding-top:70px;padding-left:80px;" align="center"  id="errordisplay">
						<?php 
						if($msg==1)
							echo "Sorry..Your operation is against the rule ....";
						elseif ($msg==2)
							echo "Your session has been expired due to inactivity. Please login again.";
						elseif ($msg==3)
							echo "Sorry please try again..";	
						?>
						
					</div>
				</div> <?php /* end of listdata */?>
			</div>
			<div class="profile_personal_right"><img  src="<?php  echo $this->config->item('images');?>innerpages/profile_personal_right.jpg" /></div>		
			<div class="clearboth"></div>
		</div>
	</div>
</div>
	<?php echo form_close();?>