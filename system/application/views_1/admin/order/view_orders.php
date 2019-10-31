<?php echo form_open('admin_user', array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="adminmainlist">
	<div  class="page_error"><?php echo $this->session->userdata("error");  $this->session->unset_userdata("error"); ?></div>
	<?php 
	if(count($orderdet) > 0){
	?>
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div>
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		<div class="addressdivisionleft"><strong>Order Details of <?php echo $user->firstname. " ".$user->lastname ?> </strong></div>
		<div class="listdata">
				<div class="leftsideheadings_view">Order Id</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><strong><?php echo "# ".$orderdet->id; ?></strong></div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Transaction Id</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><?php echo $orderdet->transactionid; ?></div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">User Name</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><?php if(!empty($user)){ echo $user->firstname." ". $user->lastname; }?></div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Course Details</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><?php echo anchor('admin_orders/courses_in_order/'.$orderdet->id.'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6),'Click here')?> for Course Details</div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Amount</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><?php echo $orderdet->total_amount;	?></div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Order Date</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><?php echo formatDate($orderdet->orderdate); ?></div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Delivered Date</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><?php if('0000-00-00'== $orderdet->delivered_date){
															echo "Not Delivered";
														} else {
															echo formatDate($orderdet->delivered_date);
														} ?></div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Status</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><?php if('S'== $orderdet->status){
														echo "Shipping in progress";
														} else if('Q'== $orderdet->status){
															echo "Queue";
														} else if('C'== $orderdet->status){
															echo "Completed";
														}  ?></div>
				<div class="clearboth"></div>

				<div class="leftsideheadings_view">Shipping Method</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><?php echo $orderdet->ship_method ?></div>
				<div class="clearboth"></div>

                <div class="leftsideheadings_view">Packaging Type</div>
                <div class="middlecolon">:</div>
                <div class="rightsidedata_view">
                    <?php echo ('' == trim($orderdet->packaging_type)) ? 'YOUR PACKAGING' :  str_replace('_', ' ',$orderdet->packaging_type)?>
                </div>
                <div class="clearboth"></div>

				<div class="leftsideheadings_view">Shipping Address</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><?php echo $orderdet->s_address; ?><br>
												<?php echo $orderdet->s_city. ", ". $s_state->state; ?><br>
												<?php echo $orderdet->s_country. ", ". $orderdet->s_zipcode; ?><br></div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view"><strong>Tracking Details</strong></div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Tracking Number</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><?php echo $orderdet->trackingno; ?></div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Last Tracked Date & Time</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><?php if('0000-00-00 00:00:00' == $orderdet->last_trackdate) { echo "Not Tracked"; } else { echo formatDate($orderdet->last_trackdate); }?></div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Current Location</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><?php echo $orderdet->current_location; ?></div>
				<div class="clearboth" style="paddimg-bottom:30px;">&nbsp;</div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view"><?php if($orderdet->label_path !=''){?><a href="<?php echo site_url(); ?>admin_orders/label_print/<?php echo $orderdet->id;?>"  target="_blank"  > Generate Label</a><?php }?></div>
			
		</div>
	</div>
	<?php }?>
	<div class="backtolist"><?php echo anchor('admin_orders/list_order_details/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6),'<< Back to orders list')?></div>
	<input type="hidden" id="hidorderid" name="hidorderid"  value="<?php if(isset($_POST['hidorderid'])){echo $_POST['hidorderid'];}?>" />
 </div>
<?php echo form_close();?>