<?php echo form_open('admin_user', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="adminmainlist">
	<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");   ?></div>
	<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
	<?php 
	if(count($quiz_details) > 0){
	?>
		<div class="adminpagebanner">
			<div class="adminpagetitle"><?php echo $page_title?></div>
		</div>
		<div class="clearboth"></div>
		<div class="admininnercontentdiv">
			<div class="addressdivisionleft"><strong>Quiz details of <?php echo $userdetails->firstname. " ".$userdetails->lastname ?> </strong></div>
			<div class="clearboth"> &nbsp;</div>
			<div class="listdata">
				<?php $count=1; 
				foreach($quiz_details as $data){?>
					<div class="leftsideheadings_view">Quiz Name</div>
					<div class="middlecolon">:</div>
					<div class="rightsidedata_view"><strong><?php echo $data->quiz_name . (($data->topic) ? ' - ' . $data->topic : ''); ?></strong></div>
					<div class="clearboth"></div>
					<div class="leftsideheadings_view">Last attempted on</div>
					<div class="middlecolon">:</div>
					<div class="rightsidedata_view"><?php echo $data->last_date; ?></div>
					<div class="clearboth"></div>
					<div class="clearboth" style="paddimg-bottom:30px;">&nbsp;</div>
			<?php }?>
			</div>
		</div>
	<?php }?>
	<div class="backtolist">
		<a href="javascript:void(null);" onclick="javascript:gotocourselist(<?php echo $this->uri->segment(4);?>,<?php echo ($this->uri->segment(5))?$this->uri->segment(5):0;?>); return false;"><< Back to course list </a>
	</div>
 </div>
<?php echo form_close();?>