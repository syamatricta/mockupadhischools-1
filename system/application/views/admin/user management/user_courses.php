<?php echo form_open_multipart('admin_user', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="adminmainlist">
		<div class="adminpagebanner">
			<div class="adminpagetitle"><?php echo $page_title?></div>
		</div>
		<div class="clearboth"> </div>
		<div class="admininnercontentdiv">
			<div class="listdata">
				<div class="page_error" id="errordisplay"></div>
				<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");  ?></div>
				<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
				<?php /* course details */?>
			<?php if(count($coursedetails)>0){?>
				<div class="addressdivisionleft"><strong>Course details of <?php echo $username->firstname. " ".$username->lastname ?> </strong></div>
				<div class="clearboth"></div>
				<div class="admintopheads">
					<div class="adminlistheadings" style="width:4%; text-align:center">Sl. No</div>
					<div class="adminlistheadings" style="width:15%">Course</div>
					<div class="adminlistheadings" style="width:5%">Edition</div>
					<div class="adminlistheadings" style="width:4%"></div>
					<div class="adminlistheadings" style="width:13%">Enrolled Date</div>
					<div class="adminlistheadings" style="width:13%">Delivered Date</div>
					<div class="adminlistheadings" style="width:13%">Effective Date</div>
					<div class="adminlistheadings" style="width:13%">Attended Date</div>
					<div class="adminlistheadings" style="width:6%">Status</div>
					<div class="adminlistheadings" style="width:6%">Score</div>
					<div class="adminlistheadings" style="width:5%">Action</div>
				</div>
				<div class="clearboth"></div>
				<?php $count=1; 
				 foreach($coursedetails as $data){
				 $bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';	
				 $editions = get_editions($data->courseid);
				 ?>
				  <div class="<?php print($bg_color);?>">
					<div class="adminlistheadings" style="width:4%; text-align:center"><?php echo $count;?></div>
					<div class="adminlistheadings" style="width:15%"><?php echo $data->course_name; ?></div>
					<div class="adminlistheadings" style="width:5%">
					<select name="edition<?php echo $count;?>" id="edition<?php echo $count;?>">
					<option value="0">Select</option>
					<?php foreach ($editions as $ed_no){ ?>
					<option value="<?php echo $ed_no['id']; ?>" <?php echo ($ed_no['id']==$data->edition)?"selected":"";?>><?php echo $ed_no['edition_no']; ?></option>
					<?php } ?>
					</select>
					</div>
					<div class="adminlistheadings" style="width:5%"><?php if( $data->ship_status=='S'){ ?>
					<img  src="<?php  echo $this->config->item('images');?>fedex_log.jpg"  />
					<?php } ?>
					</div>
					<div class="adminlistheadings" style="width:13%">
						<input type="text" class="success_border" name="txtenrolled<?php echo $count;?>" size="10" id="txtenrolled<?php echo $count;?>" readonly value="<?php if('0000-00-00' == $data->enrolled_date) { echo ""; } else { echo formatDate($data->enrolled_date); }  ?>" />
						<img  src="<?php  echo $this->config->item('images');?>calendar.gif"  onclick="displayCalendar(document.frmadhischool.txtenrolled<?php echo $count;?>,'mm/dd/yyyy',this)"/>

					<?php //echo formatDate($data->enrolled_date); ?></div>
					<div class="adminlistheadings" style="width:13%"><?php if('0000-00-00' == $data->delivered_date) { echo "Not Delivered"; } else { echo formatDate($data->delivered_date);} ?></div>
					<div class="adminlistheadings" style="width:13%">
						<input type="text" class="success_border" name="txtEffective<?php echo $count;?>" size="10" id="txtEffective<?php echo $count;?>" readonly value="<?php if('0000-00-00' == $data->effective_date) { echo ""; } else { echo formatDate($data->effective_date); }  ?>" />
						<img  src="<?php  echo $this->config->item('images');?>calendar.gif"  onclick="displayCalendar(document.frmadhischool.txtEffective<?php echo $count;?>,'mm/dd/yyyy',this)"/>
					</div>
					<div class="adminlistheadings" style="width:13%"><?php if('0000-00-00' == $data->last_attemptdate) { echo "Not Attended"; } else { echo formatDate($data->last_attemptdate);} ?></div>
					<div class="adminlistheadings" style="width:5%"><?php 
							if('P'== $data->status){
								echo "Passed";
							}
							else if('F'== $data->status){ 
								echo "Failed";
							}
					#echo $data->status; ?></div>
					<div class="adminlistheadings" style="width:6%"><?php echo $data->final_score; ?></div>
					<div class="adminlistheadings" style="width:7%"><?php $curdate = convert_UTC_to_PST_date_slash(date('m/d/Y H:i:s')); ?>
						<a href="javascript:void(null);" onclick="javascript:edit_effective_date_det('<?php echo $data->courseid;?>','<?php echo $userid;?>','<?php echo $count;?>','<?php echo $this->uri->segment(4);?>',document.frmadhischool.txtenrolled<?php echo $count;?>.value,document.frmadhischool.txtEffective<?php echo $count;?>.value,'<?php echo $curdate;?>'); return false;">Update</a>
					<?php # echo anchor('admin_users/edit_course','Edit')?></div>
					<div class="clearboth"></div>
				</div>
				 <?php $count++; 
				 }		
				}?>
		</div>
		<div class="backtolist">
			<?php if('view_order_details' == $this->uri->segment(2)){?>
				<a href="javascript:void(null);" onclick="javascript:gotolist(<?php echo $this->uri->segment(4);?>); return false;"><< Back to users list</a>
			<?php }
			else
			{?>
				<a href="javascript:void(null);" onclick="javascript:gotoorder('<?php echo $this->uri->segment(3);?>','<?php echo $this->uri->segment(5);?>'); return false;"><< Back to order details</a>
			<?php }?>	
		</div>
	</div>
</div>
<input type="hidden" id="hidcount" name="hidcount"  value="<?php if(isset($_POST['hidcount'])){echo $_POST['hidcount'];}?>" />
<?php echo form_close();?>