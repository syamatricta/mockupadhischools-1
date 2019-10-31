<div class="cb">&nbsp;</div> 
<div class="reg_step2_box_left"></div>
<div class="reg_step2_box_middle">
	<div class="reg2_box_add_inner">
		<div class="login_email_pwd"><img  src="<?php echo $this->config->item('images');?>address.png" alt="Address"/></div>
		<div class="text_box_register_space">&nbsp;</div>
		<div class="login_email_pwd"><img src="<?php echo $this->config->item('images');?>state.png" alt="State"/></div>
		<div class="text_box_register_space">&nbsp;</div>
		<div class="login_email_pwd"><img  src="<?php echo $this->config->item('images');?>country.png" alt="Country"/></div>
		<div class="cb"></div> 
		               
		<div class="text_box_div_register">
			<input type="text" name="s_address" id="s_address"   class="usertextwidth" maxlength="128" value="<?php if($this->session->userdata('address'))echo 	$this->session->userdata('address'); else echo set_value('s_address'); ?>" onblur="javascript:checkrate1(); " tabindex="19"/>
			<img class="register_form_arrow"  src="<?php  echo base_url();?>images/register_form_arrow.png"/>
		</div>	
		
		<div class="text_box_div_register_select2" onClick="javascript:__fncShowData('stateBillDiv');return false;" onmouseout="javascript:hide_div('stateBillDiv');return false;">
		 	<div style="clear:both; float:left;margin-bottom:10px;height:30px;font-size:18px;">
		 		<input type="text" readonly name="block_s_state" id="block_s_state" class="droplisRenewDivtxtbx" value="<?php if($this->session->userdata('state')){echo get_statename($this->session->userdata('state'));} else{ echo "Select State";}?>" onchange="javascript:checkrate1();" tabindex="20"/>
		 		<input type="hidden" readonly name="s_state" id="s_state" class="droplisRenewDivtxtbx" value="<?php if($this->session->userdata('state')){ echo $this->session->userdata('state'); } else { echo set_value('s_state'); }?>" onchange="javascript:checkrate1();"/>
		 	</div>
			<div id="stateBillDiv" style="display:none; position:relative;z-index:1000;top:18px;" > <!--- onclick="javascript:__fncShowData('stateBillDiv');return false;" onmouseover="javascript:__fncShowData('stateBillDiv');return false;" -->
				<div class="dropdownoverflow">
				<?php 
				foreach($state as $state2){?>
				 <div id="stateBillDiv<?php echo $state2['state_code'];?>" class="droplisRegStateDiv"  onmouseover="javascript:__fncShowdiv('stateBillDiv<?php echo $state2['state_code'];?>');" onmouseout="javascript:__fncChangeColor('stateBillDiv<?php echo $state2['state_code'];?>');" onclick="javascript:__fncSetSelectedValue('stateBillDiv<?php echo $state2['state_code'];?>', 'stateBillDiv', 's_state','<?php echo $state2['state_code'];?>','block_s_state');"><?php echo $state2['state'];?></div>
		 	 <?php }?>
		 	 </div>
		 	</div>
		 	<img class="register_form_arrow"  src="<?php  echo base_url();?>images/register_form_arrow.png"/>
		</div>
		 <div class="text_box_div_register_right">
		 	<input type="hidden" name="s_country" id="s_country" value="US">
		   <input type="text" name="s_country_show" id="s_country_show"  class="usertextwidth" value="United States" readonly tabindex="21"/>
		    
		</div>	    
		<div class="ht50"></div> 
		    
		<div class="login_email_pwd"><img  src="<?php echo $this->config->item('images');?>city.png" alt="City"/></div>
		<div class="text_box_register_space">&nbsp;</div>
		<div class="login_email_pwd"><img src="<?php echo $this->config->item('images');?>zip_code.png" alt="Zipcode"/></div>
		
		<div class="cb"></div> 
		               
		<div class="text_box_div_register">
			<input type="text" name="s_city" id="s_city"   class="usertextwidth" maxlength="40"  value="<?php if($this->session->userdata('city'))echo 	$this->session->userdata('city'); else echo set_value('s_city'); ?>" onblur="javascript:checkrate1(); " tabindex="22"/>
			<img class="register_form_arrow"  src="<?php  echo base_url();?>images/register_form_arrow.png"/>
		</div>	
		 <div class="text_box_div_register">
		 	<input type="text" name="s_zipcode" id="s_zipcode"   class="usertextwidth" maxlength="5" value="<?php if($this->session->userdata('zipcode'))echo 	$this->session->userdata('zipcode'); else echo set_value('s_zipcode'); ?>" onblur="javascript:checkrate1(); " tabindex="23"/>
		    <img class="register_form_text"  src="<?php  echo base_url();?>images/zipcode_lim.png" alt="Zipcode limit"/>
		</div>
	</div>	      
</div>
<div class="reg_step2_box_right"></div>
<div class="ht30"></div> 