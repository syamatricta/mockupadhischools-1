<div id="maindiv" >
	<div id="profileviewmain" >
  	<?php /*functional part */?>
	   	<div  class="redheading"> Courses</div>
		<div class="clearboth">&nbsp;</div>
		  <div  class="page_success" id="flashsuccess"><?php if($this->session->userdata("msg")){ echo $this->session->userdata("msg");   $this->session->set_userdata("msg",'');}

if($this->session->flashdata("msg")){ echo $this->session->flashdata("msg"); } ?></div>
		  <div class="clearboth">&nbsp;</div>
		<div class="applucoursebutton"><?php if ($add_status == true){echo anchor('user/listremainingcourse','<img  src="'.$this->config->item('images').'/innerpages/applynewcourse.jpg" />'); }?></div>
		<div class="examdata" >
		  	<?php  echo $this->load->view('exam/registered_courses');?>
		
			<?php echo $this->load->view('exam/completed_courses');?>
		</div>
		<?php /*End functional part */?>
		
	</div>
	<?php /* show link */ ?>
		<div class="floatleft" >
			<?php echo $this->load->view('user/client_menu');?>
		</div>
		<?php /* End show link */ ?>
</div>
<script type="text/javascript">
	//timer = setInterval('polling()',100);
</script>