<?php echo form_open_multipart('admin_user', array('name'=>'adminorderlistform','id' => 'adminorderlistform')); ?>
<div class="adminmainlist">
		<?php /* list headings starts here*/?>
		<div class="adminpagebanner">
			<div class="adminpagetitle"><?php echo $page_title?></div>
		</div>
		<div class="clearboth"> </div>
		<div class="page_error" id="errordisplay"></div>
		<div class="nodata" style="width:100%;">
			<div class="listdata">
				<div class="floatleft" style="width:8%;"><strong>Date From</strong></div> 
				<div class="filter">
					<input type="text" maxlength="50"  name="date_from" id="date_from" readonly value="<?php 
																										 if('' != $this->input->post('date_from') ){ 
																											echo formatDate($this->input->post('date_from'));
																										} else if(0 != $this->uri->segment(3)){ 
																											echo formatDate($this->uri->segment(3));
																										} else if(0 == $this->uri->segment(3)){ 
																											echo '';
																										}else {
																											echo formatDate(convert_UTC_to_PST_date(date('Y-m-d H:i:s'))); 
																										} ?>"/>
					<img  src="<?php  echo $this->config->item('images');?>calendar.gif" alt="calendar" title="calendar" onclick="displayCalendar(document.adminorderlistform.date_from,'mm/dd/yyyy',this)"/>
				</div>
				<div class="floatleft" style="width:8%;"><strong>Date To</strong></div>
				<div class="filter">
					<input type="text" maxlength="50"  name="date_to" id="date_to" readonly  value="<?php if('' != $this->uri->segment(4)){ echo formatDate($this->uri->segment(4));} else if('' != $this->input->post('date_to')){ echo formatDate($this->input->post('date_to'));} else { echo formatDate(convert_UTC_to_PST_date(date('Y-m-d H:i:s'))); }  ?>"/>
					<img  src="<?php  echo $this->config->item('images');?>calendar.gif" alt="calendar" title="calendar"  onclick="displayCalendar(document.adminorderlistform.date_to,'mm/dd/yyyy',this)"/>
				</div>
				<div class="floatleft"><a href="javascript:void(0);" onclick="javascript:fncFilter(document.adminorderlistform.date_from.value,document.adminorderlistform.date_to.value); return false;"><img src="<?php echo base_url();?>images/indexsearch.jpg" border="0" alt="filter" title="filter" /></a></div>
				<div class="clearboth"> &nbsp;</div>
			</div>
		</div>
			<?php if(count($orders) > 0){?>
		<div class="admininnercontentdiv">
			<div class="listdata">
				<div class="admintopheads">
					<div class="adminlistheadings" style="width:10%; text-align:center;">Sl. No</div>
					<div class="adminlistheadings" style="width:15%;">Order Id</div>
					<div class="adminlistheadings" style="width:15%;">Amount ($)</div>
					<div class="adminlistheadings" style="width:15%;">Order Date</div>
					<div class="adminlistheadings" style="width:15%;">Delivered Date</div>
					<div class="adminlistheadings" style="width:15%;">Status</div>
					<div class="adminlistheadings" style="width:15%;">Action</div>
				</div>
			</div>
			<div class="clearboth"> </div>
		<?php  
	/* list headings ends here*/
				$count=1; 
			   if ($this->uri->segment(5)){
					$count = $count+$this->uri->segment(5);
				} 
				   foreach($orders as $data){
				  $bg_color = ($count%2==0) ? 'div_row_first' : 'div_row_second';
	/* data list starts here */ 
					?>
						<div class="<?php print($bg_color);?>">
						 	<div class="floatleft" style="width:10%;  text-align:center;"><?php print $count; ?></div> 
						 	<div class="floatleft" style="width:15%;"><?php echo $data->id	; ?></div> 
						 	<div class="floatleft" style="width:15%;"><?php echo $data->total_amount; ?></div> 
						 	<div class="floatleft" style="width:15%;"><?php echo formatDate($data->orderdate);	?></div> 
						 	<div class="floatleft" style="width:15%;"><?php if('0000-00-00'== $data->delivered_date){
																			echo "Not Delivered";
																		} else {
																			echo formatDate($data->delivered_date);
																		} ?></div> 
							<div class="floatleft" style="width:15%;"><?php if('S'== $data->status){
																			echo "Shipped";
																		} else if('Q'== $data->status){
																			echo "Queue";
																		} else if('C'== $data->status){
																			echo "Completed";
																		} else 
																		{
																			echo "&nbsp;";	
																		}?></div> 
							<?php if('' != $this->input->post('date_from')  ){
										$date_from = formatDate_search($this->input->post('date_from'));
									}
									else if(0 == $this->uri->segment(3) ){
										$date_from = 0;
									} 
									else if ('' != $this->uri->segment(3) && 0 != $this->uri->segment(3)){
										$date_from = $this->uri->segment(3);
									}
										else {
										$date_from = convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
									}
								if('' != $this->input->post('date_to')){
										$date_to = formatDate_search($this->input->post('date_to'));
									} else {
										$date_to = convert_UTC_to_PST_date(date('Y-m-d H:i:s'));
									}
								?>

							<div class="floatleft" style="width:15%;"><?php echo anchor('admin_orders/view_orders/'.$data->id.'/'.$date_from.'/'.$date_to.'/'.$this->uri->segment(5),'View');?></div> 
						</div>
						<div class="clearboth"> </div>
				<?php 
				$count++; 
				}
	/* data list ends here */ 			
			?>
		</div>
		<div class="pagination"><?  echo $paginate;?></div>
		<div style="clear:both">&nbsp;</div>
	<?php }else { ?>
			<div class="nodata">No orders in this date</div>
		<?php }?>
</div>
<input type="hidden" id="hidusertype" name="hidusertype"  value="<?php if(isset($_POST['hidusertype'])){echo $_POST['hidusertype'];}?>" />
<?php echo form_close();?>