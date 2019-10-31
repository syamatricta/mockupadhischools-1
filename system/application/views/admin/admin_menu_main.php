<?php 
if($this->session->userdata ('ADMINTYPE') == 1) { ?>
<div class="headernavmain">
	<div class="headerleftnav"><img  src="<?php  echo  ssl_url_img();?>adhi_left_nav.jpg" /></div>
	<div class="headermiddlenav">
		<div class="navigationmain">
			<div class="navigationtext" id="admin_users_menu" style="height:40px;margin:0px;text-align:center;width:90px;padding-top:10px;"><a href="<?php  echo $this->config->item('site_baseurl')?>admin_user/list_user_details">User</a></div>
			<div class="headerleftnav"><img  src="<?php  echo  ssl_url_img();?>seperator.jpg" /></div>
			<div class="navigationtext" ><a href="<?php  echo $this->config->item('site_baseurl')?>admin_exam">Exam</a>
			<?php //echo anchor('admin_exam','Exam ');?></div>
			<div class="headerleftnav"><img  src="<?php  echo  ssl_url_img();?>seperator.jpg" /></div>
			<div class="navigationtext" >
			<a href="<?php  echo $this->config->item('site_baseurl')?>admin_quiz">Quiz</a>
			<?php //echo anchor('admin_quiz','Quiz ');?></div>
			<div class="headerleftnav"><img  src="<?php  echo  ssl_url_img();?>seperator.jpg" /></div>
			<div class="navigationtext" >
			<a href="<?php  echo $this->config->item('site_baseurl')?>admin_course/list_course_details/">Course</a>
			<?php // echo anchor('admin_course/list_course_details/','Course');?></div>
			<div class="headerleftnav"><img  src="<?php  echo  ssl_url_img();?>seperator.jpg" /></div>
                        
                        
			<div class="navigationtext" ><?php echo anchor('admin_classroom/view','Classroom');?></div>
			<div class="headerleftnav"><img  src="<?php  echo $this->config->item('images');?>seperator.jpg" /></div>
                        
			<div class="navigationtext" >
			<a href="<?php  echo $this->config->item('site_baseurl')?>admin_orders/list_order_details/0">Order</a>
			<?php // echo anchor('admin_orders/list_order_details/0','Order');?></div>
			<div class="headerleftnav"><img  src="<?php  echo  ssl_url_img();?>seperator.jpg" /></div>
			<div class="navigationtext"  id="admin_class_menu" style="height:40px;margin:0px;text-align:center;width:90px;padding-top:10px;">
			<a href="<?php  echo $this->config->item('site_baseurl')?>admin_sitepages/list_sitepage_details">Class</a>
			<?php // echo anchor('admin_sitepages/list_sitepage_details','Sitepage');?></div>
			<div class="headerleftnav"><img  src="<?php  echo  ssl_url_img();?>seperator.jpg" /></div>
			<div class="navigationtext"  id="admin_settings" style="height:40px;margin:0px;text-align:center;width:90px;padding-top:10px;" ><?php echo anchor('admin_sitepages/list_sitepage_details','Settings');?></div>
			<div class="headerleftnav"><img  src="<?php  echo $this->config->item('images');?>seperator.jpg" /></div>
			
			<!--<div class="navigationtext" >
			<a href="<?php // echo $this->config->item('site_baseurl')?>admin_sitepages/list_sitepage_details">Sitepage</a>
			<?php // echo anchor('admin_sitepages/list_sitepage_details','Sitepage');?>
			</div>
			
			<div class="headerleftnav"><img  src="<?php  echo  ssl_url_img();?>seperator.jpg" /></div>-->
			<div class="navigationtext" >
				<a href="<?php  echo $this->config->item('site_baseurl')?>admin/change_password">Change password</a>
				<?php  //echo anchor('admin/change_password','Change password');?>
			</div>
			<div class="headerleftnav"><img  src="<?php  echo  ssl_url_img();?>seperator.jpg" /></div>
			<div class="navigationtext" >
				<a href="<?php  echo $this->config->item('site_baseurl')?>admin/logout">Logout</a>
			<?php // echo anchor('admin/logout','Logout');?></div>
		</div>
	</div>
	<div class="headerleftnav"><img  src="<?php  echo  ssl_url_img();?>adhi_right_nav.jpg" /></div>
</div>
<div id="admin_users_menu_sub"  class="admin_menu_sub">
    <ul class="ulstyle" style="width: 200px;">			
		<li class="AboutNotSelected" onmouseout="this.className='AboutNotSelected'" onmouseover="this.className='AboutSelected'">
			<a class="menuItem" href="<?php echo base_url().'admin_user/list_user_details';?>" ><div>Users</div></a>
		</li>
                <li class="AboutNotSelected" onmouseout="this.className='AboutNotSelected'" onmouseover="this.className='AboutSelected'">
			<a class="menuItem" href="<?php echo base_url().'admin_sub';?>" ><div>Sub-Admins</div></a>
		</li>
                <li class="AboutNotSelected" onmouseout="this.className='AboutNotSelected'" onmouseover="this.className='AboutSelected'">
			<a class="menuItem" href="<?php echo base_url().'admin_user/list_otp_users';?>" ><div>OTP Users</div></a>
		</li>
    </ul>            
</div>
<div id="admin_class_menu_sub"  class="admin_menu_sub">
	<ul class="ulstyle" style="width: 200px;">			
		<li class="AboutNotSelected" onmouseout="this.className='AboutNotSelected'" onmouseover="this.className='AboutSelected'">
			<a class="menuItem" href="<?php echo base_url().'admin_region/list_region';?>" ><div>Region</div></a>
		</li>
		<li class="AboutNotSelected" onmouseout="this.className='AboutNotSelected'" onmouseover="this.className='AboutSelected'">
			<a class="menuItem" href="<?php echo base_url().'admin_subregion/list_subregion';?>" ><div>Sub-region</div></a>
		</li>
		<li class="AboutNotSelected" onmouseout="this.className='AboutNotSelected'" onmouseover="this.className='AboutSelected'">
			<a class="menuItem" href="<?php echo base_url().'admin_schedule';?>" ><div>Schedule</div></a>
		</li>
	</ul>
</div>
<div id="admin_settings_menu_sub" class="admin_menu_sub">
	<ul class="ulstyle" style="width: 200px;">			
		<li class="AboutNotSelected" onmouseout="this.className='AboutNotSelected'" onmouseover="this.className='AboutSelected'">
			<a class="menuItem" href="<?php echo base_url().'admin_sitepages/list_sitepage_details';?>" ><div>Sitepage</div></a>
		</li>
		<li class="AboutNotSelected" onmouseout="this.className='AboutNotSelected'" onmouseover="this.className='AboutSelected'">
			<a class="menuItem" href="<?php echo base_url().'admin_meta/list_items';?>" ><div>Meta Tag</div></a>
		</li>
		<li class="AboutNotSelected" onmouseout="this.className='AboutNotSelected'" onmouseover="this.className='AboutSelected'">
			<a class="menuItem" href="<?php echo base_url().'admin_sitepages/list_banners';?>" ><div>Banners</div></a>
		</li>
	</ul>
</div>
<script language="javascript" type="text/javascript">
	at_attach("admin_users_menu", "admin_users_menu_sub", "hover", "y", "pointer");
        at_attach("admin_class_menu", "admin_class_menu_sub", "hover", "y", "pointer");
	at_attach("admin_settings", "admin_settings_menu_sub", "hover", "y", "pointer");
</script>
<?php } else if($this->session->userdata ('ADMINTYPE') == 2) { ?>
<div class="headernavmain">
	<div class="headerleftnav"><img  src="<?php  echo $this->config->item('images');?>adhi_left_nav.jpg" /></div>
	<div class="headermiddlenav">
		<div class="navigationmain">
			<div class="navigationtext" id="admin_users_menu" style="height:40px;margin:0px;text-align:center;width:90px;padding-top:10px;"><?php echo anchor('admin/home','User ');?></div>
			<div class="headerleftnav"><img  src="<?php  echo $this->config->item('images');?>seperator.jpg" /></div>
			
                        <?php if($this->authentication->check_permission_redirect('sub_permission_1', FALSE)){ ?>
                            <div class="navigationtext"  id="admin_class_menu" style="height:40px;margin:0px;text-align:center;width:85px;padding-top:10px;" ><?php echo anchor('admin_region/list_region','Class');?></div>
                            <div class="headerleftnav"><img  src="<?php  echo $this->config->item('images');?>seperator.jpg" /></div>
                        <?php }?>
                        
                        <div class="navigationtext"  id="sub_admin_recruiter_menu" style="height:40px;margin:0px;text-align:center;width:85px;padding-top:10px;" ><?php echo anchor('admin_recruiter/list_recruiter','Recruiter');?></div>
			<div class="headerleftnav"><img  src="<?php  echo $this->config->item('images');?>seperator.jpg" /></div>
                        
			<div class="navigationtext" ><?php echo anchor('admin/logout','Logout');?></div>
		</div>
	</div>
	<div class="headerleftnav"><img  src="<?php  echo $this->config->item('images');?>adhi_right_nav.jpg" /></div>
</div>

<?php if($this->authentication->check_permission_redirect('sub_permission_1', FALSE)){ ?>
<div id="admin_class_menu_sub" class="admin_menu_sub">
	<ul class="ulstyle" style="width: 200px;">			
		<li class="AboutNotSelected" onmouseout="this.className='AboutNotSelected'" onmouseover="this.className='AboutSelected'">
			<a class="menuItem" href="<?php echo base_url().'admin_region/list_region';?>" ><div>Region</div></a>
		</li>
		<li class="AboutNotSelected" onmouseout="this.className='AboutNotSelected'" onmouseover="this.className='AboutSelected'">
			<a class="menuItem" href="<?php echo base_url().'admin_subregion/list_subregion';?>" ><div>Sub-region</div></a>
		</li>
		<li class="AboutNotSelected" onmouseout="this.className='AboutNotSelected'" onmouseover="this.className='AboutSelected'">
			<a class="menuItem" href="<?php echo base_url().'admin_schedule';?>" ><div>Schedule</div></a>
		</li>
	</ul>
</div>  
<?php }?>


<div id="sub_admin_recruiter_menu_sub" class="admin_menu_sub">
	<ul class="ulstyle" style="width: 200px;">	
                <li class="AboutNotSelected" onmouseout="this.className='AboutNotSelected'" onmouseover="this.className='AboutSelected'">
			<a class="menuItem" href="<?php echo base_url().'admin_recruiter/recruiter_mail';?>" ><div>Recruiter Email</div></a>
		</li>
                
		<li class="AboutNotSelected" onmouseout="this.className='AboutNotSelected'" onmouseover="this.className='AboutSelected'">
			<a class="menuItem" href="<?php echo base_url().'admin_recruiter/list_recruiter';?>" ><div>Manage Recruiters</div></a>
		</li>
	</ul>
</div>
<script language="javascript" type="text/javascript">
<?php if($this->authentication->check_permission_redirect('sub_permission_1', FALSE)){ ?>
at_attach("admin_class_menu", "admin_class_menu_sub", "hover", "y", "pointer");
<?php }?>
at_attach("sub_admin_recruiter_menu", "sub_admin_recruiter_menu_sub", "hover", "y", "pointer");
</script>


<?php } ?>
