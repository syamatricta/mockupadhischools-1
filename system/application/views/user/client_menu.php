<div id="clientmenumain">
	<div class="clientmenumain_left"><img  src="<?php  echo $this->config->item('images');?>innerpages/inner_menu_left.jpg" /></div>
	<div class="clientmenumain_middle">
		<div class="menubackground" ><div <?php if('profile' == $this->uri->segment(1)){?> class="menutext_selected" <?php } else {?> class="menutext"<?php }?>><?php echo anchor('profile','My Profile');?></div></div>
		<div class="menubackground"><div <?php if('change_password' == $this->uri->segment(2)){?> class="menutext_selected" <?php } else {?> class="menutext"<?php }?>><?php echo anchor('user/change_password','Change Password');?></div></div>
		<div class="menubackground"><div <?php if('exam' == $this->uri->segment(1) || 'quiz' == $this->uri->segment(1)){?> class="menutext_selected" <?php } else {?> class="menutext"<?php }?>><?php echo anchor('exam/courselist','Course');?></div></div>
	</div>
	<div class="clientmenumain_right"><img  src="<?php  echo $this->config->item('images');?>innerpages/inner_menu_right.jpg" /></div>
</div>
