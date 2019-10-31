<div class="row">
	<div class="col-sm-6 form-group"> 
		<select name="cardtype" id="cardtype" class="form-control" required>
			<option value="">Card Type</option>
			<option value="Visa" <?php echo ($this->input->post('cardtype') == 'Visa' ) ? 'selected="selected"' : '' ;?>>Visa</option>
			<option value="MasterCard" <?php echo ($this->input->post('cardtype') == 'MasterCard' ) ? 'selected="selected"' : '' ;?>>MasterCard</option>
			<option value="Amex" <?php echo ($this->input->post('cardtype') == 'Amex' ) ? 'selected="selected"' : '' ;?>>American Express</option>
			<option value="Discover" <?php echo ($this->input->post('cardtype') == 'Discover' ) ? 'selected="selected"' : '' ;?>>Discover</option>
		</select>
		<div>
			<img  src="<?php  echo ssl_url_img();?>innerpages/visa.jpg" alt="Visa" title="Visa" />
			<img  src="<?php  echo ssl_url_img();?>innerpages/mastercard.jpg" alt="Mastercard" title="Mastercard" />
			<img  src="<?php  echo ssl_url_img();?>innerpages/amex.jpg" alt="American Express" title="American Express" />
			<img  src="<?php  echo ssl_url_img();?>innerpages/discover.jpg" alt="Discover" title="Discover" />
		</div>
	</div>
	<div class="col-sm-6 form-group"> 
		<input  type="text" name="ccno" placeholder="Credit Card No"  id="ccno" value="<?php echo set_value('ccno'); ?>" class="form-control" maxlength="30" required />
	</div>
</div>
<div class="row">
	<div class="col-sm-6 form-group"> 
		<input  type="text" name="cvv2no" class="form-control" placeholder="CVV2 No" id="cvv2no" value="<?php echo set_value('cvv2no'); ?>" maxlength="10" size="25" required/>
	</div>
	<div class="col-sm-6 "> 
		<div class="row">
			<div class="col-xs-6 form-group">
				<select name="expmonth" id="expmonth" class="form-control" required>
						<option value="">Month</option>
					<?php $i=1;foreach($month as $month){  ?> 
						<option value="<?php echo $i?>" <?php echo ($this->input->post('expmonth') == $i) ? 'selected="selected"' : '' ;?>><?php echo $month?></option>
					<?php $i++; } ?>
				</select>
			</div>
			<div class="col-xs-6 form-group">
				<select name="expyear" id="expyear" class="form-control" required>
						<option value="">Year</option>
					<?php foreach($year as $year){ ?> 
						<option value="<?php echo $year?>" <?php echo ($this->input->post('expyear') == $year) ? 'selected="selected"' : '' ;?>><?php echo $year?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		
	</div>
</div>


