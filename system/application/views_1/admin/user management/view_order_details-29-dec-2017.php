<?php echo form_open($this->current_controller, array('name'=>'frmadhischool','id' => 'frmadhischool')); ?>
<div class="adminmainlist">
	<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error");   ?></div>
	<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
	<?php 
		if(count($freezedorder) > 0){
			$ordercount = 1;
			foreach($freezedorder as $order){
			?>
				<div class="order_freezing"><?php echo "Order # <strong>".$order->order_id."</strong> is freezed ";?></div>
				<div class="clearboth" style="paddimg-bottom:30px;">&nbsp;</div>
				<?php $ordercount++;
			}
		}?>
	<?php 
	if(count($orderdet) > 0){
	?>
	<div class="adminpagebanner">
		<div class="adminpagetitle"><?php echo $page_title?></div>
	</div>
	<div class="clearboth"></div>
	<div class="admininnercontentdiv">
		<div class="addressdivisionleft"><strong>Order details of <?php echo $userdetails->firstname. " ".$userdetails->lastname ?> </strong></div>
		<?php /* Freezing of a user with reason starts here  */?>
		<div class="listdata" id="reason" style="display:none">
			<fieldset>
					 <legend><strong>Reason for freezing</strong></legend>
					<div class="page_error" id="errordisplay"></div>
				
				<div class="leftsideheadings_view">Submit your reason for freezing this order<span class="red_star">*</span></div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><textarea class="success_border" name="txtReason" id="txtReason" rows="4" cols="70" ></textarea></div>
				<div class="clearboth"></div>
				<div class="middlebutton">
				<input type="button" name="butUpdate" value="Submit" onclick="javascript:fncUpadtefreezingorder(<?php echo $this->uri->segment(3);?>);" />
				<input type="button" name="butCancel" value="Cancel" onclick="javascript:fncCancelFreezing();" />
				</div>
			</fieldset>
		</div>
		<div class="clearboth"> &nbsp;</div>
<?php /* Freezing of a user with reason ends here  */?>
		<div class="listdata">
			<?php $count=1; 
			foreach($orderdet as $data){?>
				<div class="leftsideheadings_view">Order Id</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><strong><?php echo "# ".$data->id; ?></strong></div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Transaction Id</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><?php echo $data->transactionid; ?></div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">User Name</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><?php if(!empty($userdetails)){ echo $userdetails->firstname." ". $userdetails->lastname; }?></div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Course Details</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><?php echo anchor($this->current_controller.'/user_course_details/'.$data->userid.'/'.$data->id.'/'.$this->uri->segment(4),'Click here')?> for Course Details</div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Amount</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><?php echo $data->total_amount;	?></div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Order Date</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><?php echo formatDate($data->orderdate); ?></div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Delivered Date</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><?php if('0000-00-00'== $data->delivered_date){
															echo "Not Delivered";
														} else {
															echo formatDate($data->delivered_date);
														} ?></div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Status</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><?php if('S'== $data->status){
															echo "Shipped";
														} else if('Q'== $data->status){
															echo "Queue";
														} else if('C'== $data->status){
															echo "Completed";
														}  ?></div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Shipping Method</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><?php echo $data->ship_method ?></div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Shipping Address</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view">
                                    <?php echo $data->s_address; ?><br>
                                    <?php echo $data->s_city. ", ". $data->s_state; ?><br>
                                    <?php echo $data->s_country. ", ". $data->s_zipcode; ?><br>
                                    
                                </div>
                                <div class="leftsideheadings_view">Billing Address</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view">
                                    <?php echo $data->b_address; ?><br>
                                    <?php echo $data->b_city. ", ". $data->b_state; ?><br>
                                    <?php echo $data->b_country. ", ". $data->b_zipcode; ?><br>
                                    
                                </div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view"><strong>Tracking Details</strong></div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Tracking Number</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><?php echo $data->trackingno; ?></div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Last Tracked Date & Time</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><?php if ($data->last_trackdate !='0000-00-00 00:00:00')echo formatDate($data->last_trackdate); ?></div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view">Current Location</div>
				<div class="middlecolon">:</div>
				<div class="rightsidedata_view"><?php echo $data->current_location; ?></div>
				<div class="clearboth"></div>
				<div class="leftsideheadings_view"><?php if($data->label_path !=''){?><a href="<?php echo site_url(); ?>admin_orders/label_print/<?php echo $data->id;?>"  target="_blank"  > Generate Label</a><?php }?></div>

				<div class="clearboth"></div>
                                <?php if($this->authentication->check_permission_redirect('super_admin', FALSE)){ ?>
                                    <div class="floatright" style="width:20%;">
                                            <a href="javascript:void(null);" onclick="javascript:freeze_order(<?php echo $data->id?>); return false;">Freeze this Order</a>
                                    </div> 
                                    <?php if('Q'== $data->status){?>
                                        <div class="floatright" style="width:20%;">
                                            <a href="javascript:void(null);" onclick="javascript:ship_order(<?php echo $data->id?>,<?php echo $data->userid?>); return false;">Ship this Order</a>
					
                                        </div> 
                                     <?php }?>
                                <?php }?>
				<div class="clearboth" style="padding-bottom:30px;">&nbsp;</div>
			<?php }?>
		</div>
	</div>
	<?php }?>
	<div class="backtolist">
		<a href="javascript:void(null);" onclick="javascript:gotolist(<?php echo $this->uri->segment(4);?>); return false;"><< Back to users list </a>
	</div>
	<input type="hidden" id="hidorderid" name="hidorderid"  value="<?php if(isset($_POST['hidorderid'])){echo $_POST['hidorderid'];}?>" />
 </div>
<?php echo form_close();?>