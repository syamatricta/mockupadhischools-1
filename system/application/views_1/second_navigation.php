<div class="nav_menu">
	<div class="nav_menu_right">
		<?php $class = ('schedule' == $this->uri->segment(1)) ? "find_a_class_menu1" : "find_a_class_menu"; ?>
		<a href="<?php echo base_url().'schedule'; ?>" class="<?php echo $class; ?>" rel="nofollow"></a>
		
		<?php $class = ('exam' == $this->uri->segment(1) || 'quiz' == $this->uri->segment(1) || 'listremainingcourse' == $this->uri->segment(2)) ? "course_menu1" : "course_menu"; ?>
		<a href="<?php echo base_url().'exam/courselist'; ?>" class="<?php echo $class; ?>" rel="nofollow"></a>
		
		<?php $class = ('change_password' == $this->uri->segment(2)) ? "change_pwd_menu1" : "change_pwd_menu"; ?>
		<a href="<?php echo base_url().'user/change_password'; ?>" class="<?php echo $class; ?>" rel="nofollow"></a>
		
		<?php $class = ('profile' == $this->uri->segment(1)) ? "my_profile_menu1" : "my_profile_menu"; ?>
		<a href="<?php echo base_url().'profile'; ?>" class = "<?php echo $class; ?>" rel="nofollow"></a>
		
		<?php $class = ('classroom' == $this->uri->segment(1)) ? "classroom_menu1" : "classroom_menu"; ?>
		<a href="<?php echo base_url().'classroom/view'; ?>" class = "<?php echo $class; ?>" rel="nofollow"></a>
		
	</div>
</div>