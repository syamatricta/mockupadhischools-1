<div class="cb">&nbsp;</div> 
<div class="reg_step2_box_left"></div>
<div class="reg_step2_box_middle">
	<div class="reg2_box_add_inner">
		<div class="login_email_pwd"><div class="splice_address"></div></div>

		<div class="login_email_pwd"><div class="splice_city_02"></div></div>

		<div class="login_email_pwd"><div class="splice_state_02"></div></div>

		
		
		
		<!-- <div class="login_email_pwd"><img  src="<?php echo $this->config->item('images');?>country.png"/></div> -->
		<div class="cb"></div> 
		               
		<div class="text_box_div_register">
			<input type="text" name="b_address" id="b_address"   class="usertextwidth" maxlength="128" value="<?php echo set_value('b_address'); ?>" onblur="javascript:checkrate1(); " tabindex="25"/>
			<div class="register_form_arrow_02"></div>
		</div>	
		
		<div class="text_box_div_register">
			<input type="text" name="b_city" id="b_city"   class="usertextwidth" maxlength="40"  value="<?php echo set_value('b_city'); ?>" onblur="javascript:checkrate1(); " tabindex="26"/>
			<div class="register_form_arrow_02"></div>
		</div>
		
		<div class="text_box_div_register_select2" onClick="javascript:__fncShowData('stateBillDiv_bill');return false;" id="sttdiv" ><!--onmouseout="javascript:hide_div('stateBillDiv_bill');return false;" -->
		 	<div style="clear:both; float:left;margin-bottom:10px;height:30px;font-size:18px;">
		 		<input type="text" readonly name="block_b_state" id="block_b_state" class="droplisRenewDivtxtbx" value="<?php if(set_value('b_state')){ echo get_statename(set_value('b_state'));} else { echo "Select State";} ?>" onchange="javascript:checkrate1();" tabindex="28"/>
		 		<input type="hidden" readonly name="b_state" id="b_state" class="droplisRenewDivtxtbx" value="<?php if(set_value('b_state')){ echo set_value('b_state');}?>" onchange="javascript:checkrate1();"/>
		 	</div>
			<div id="stateBillDiv_bill" style="display:none; position:relative; z-index:1000;top:18px; " ><!-- onclick="javascript:__fncShowData('stateBillDiv_bill');return false;" onmouseover="javascript:__fncShowData('stateBillDiv_bill');return false;" -->
				<div class="dropdownoverflow">
				<?php 
				foreach($state as $state1){?>
				 <div id="stateBillDiv_bill<?php echo $state1['state_code'];?>" class="droplisRegStateDiv"  onmouseover="javascript:__fncShowdiv('stateBillDiv_bill<?php echo $state1['state_code'];?>');" onmouseout="javascript:__fncChangeColor('stateBillDiv_bill<?php echo $state1['state_code'];?>','block_b_state');" onclick="javascript:__fncSetSelectedValue('stateBillDiv_bill<?php echo $state1['state_code'];?>', 'stateBillDiv_bill', 'b_state','<?php echo $state1['state_code'];?>','block_b_state');"><?php echo $state1['state'];?></div>
		 	 	<?php }?>
		 	 	</div>
		 	</div>
		 	<!-- <img class="register_form_arrow"  src="<?php  echo base_url();?>images/register_form_arrow.png"/> -->
		</div>
		
		
		
		
		<!--  <div class="text_box_div_register_right">  -->
		 	<input type="hidden" name="b_country" id="b_country" value="US" tabindex="26">
		  <!-- <input type="text" name="b_country_show" id="b_country_show"  class="usertextwidth" value="United States" readonly tabindex="27"/> -->
		    
		<!-- </div> -->
			    
		<div class="ht50"></div> 
		    
		
		
		<div class="login_email_pwd"><img src="<?php echo $this->config->item('images');?>zip_code.png"/></div>
		
		<div class="cb"></div> 
		               
		
		
			
		 <div class="text_box_div_register">
		 	<input type="text" name="b_zipcode" id="b_zipcode"   class="usertextwidth" maxlength="5" value="<?php echo set_value('b_zipcode'); ?>" onblur="javascript:checkrate1(); " tabindex="29"/>
		    <div class="register_form_text splice_zipcode_lmt"></div>
		</div>
	</div>	      
</div>
<div class="reg_step2_box_right"></div>
<div class="ht30"></div>