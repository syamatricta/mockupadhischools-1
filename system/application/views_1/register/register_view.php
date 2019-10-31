<div class="clearboth"></div>
<div   style="border:#000000 solid 2px;" >
  <div  class="form-fields head_txt"> REGISTER </div>
  <div  class="form-fields" style="height:20px;" >
    <div  class="filed" >First Name</div>
    <div class="filed" >
      <input type="text" name="firstname" id="firstname" size="35"  value=""/>
    </div>
  </div>
  <div  class="form-fields" style="height:20px;" >
    <div  class="filed">Last Name</div>
    <div  class="filed">
      <input type="text" name="lastname" id="lastname" size="35"  value=""/>
    </div>
  </div>
  <div  class="form-fields" style="height:20px;" >
    <div  class="filed">License Type</div>
    <div  class="filed">
      <select name="license">
        <option value="">Select License</option>
        <option value="S">Sales</option>
        <option value="B">Broker</option>
      </select>
    </div>
  </div>
  <div  class="form-fields" style="height:20px;" >
    <div  class="filed">E-mail</div>
    <div  class="filed">
      <input type="text" name="email" id="email"  size="35" value=""/>
    </div>
  </div>
  <div  class="form-fields" style="height:20px;" >
    <div  class="filed">Password</div>
    <div  class="filed">
      <input type="text" name="psword" id="psword"  size="35" value=""/>
    </div>
  </div>
  <div  class="form-fields" style="height:20px;" >
    <div  class="filed">Confirm Password</div>
    <div  class="filed">
      <input type="text" name="psword1" id="psword1"  size="35" value=""/>
    </div>
  </div>
  <div  class="form-fields subhead_txt"> Contact Address </div>
  <div  class="form-fields" style="height:20px;" >
    <div  class="filed">Address</div>
    <div  class="filed">
      <input type="text" name="address" id="address"  size="35" value=""/>
    </div>
  </div>
  <div  class="form-fields" style="height:20px;" >
    <div  class="filed">State</div>
    <div  class="filed">
      <select name="state"  id="state">
        <option value="">Select</option>
        <?php 
			$state1= $state;
			$state2= $state;
			foreach($state as $state){?>
        <option value="<?php echo $state['state_code'];?>"  <?php if(set_value('state')==$state['state_code']){?> selected="selected" <?php } ?>><?php echo $state['state'];?></option>
        <?php }?>
      </select>
    </div>
  </div>
  <div  class="form-fields" style="height:20px;" >
    <div  class="filed">Country</div>
    <div  class="filed">
      <select name="country" id="country">
        <option value="US">United States</option>
      </select>
    </div>
  </div>
  <div  class="form-fields" style="height:20px;" >
    <div  class="filed">City</div>
    <div  class="filed">
      <input type="text" name="city" id="city"  size="35" value=""/>
    </div>
  </div>
  <div  class="form-fields" style="height:20px;" >
    <div  class="filed">Zipcode</div>
    <div  class="filed">
      <input type="text" name="zipcode" id="zipcode"  size="20" value=""/>
    </div>
  </div>
  <div  class="form-fields" style="height:20px;" >
    <div  class="filed">Phone No</div>
    <div  class="filed">
      <input type="text" name="phone" id="phone"  size="35" value=""/>
    </div>
  </div>
  <div  class="form-fields subhead_txt"> Billing Address</div>
  <div  class="form-fields" style="height:20px;" >
    <div  class="filed">
      <input type="checkbox" name="bsame" id="bsame" />
      Billing Address is same as Contact Address </div>
  </div>
  <div  class="form-fields"  id="billing" >
    <div  class="form-fields" style="height:20px;" >
      <div  class="filed">Address</div>
      <div  class="filed">
        <input type="text" name="b_address" id="b_address"  size="35" value=""/>
      </div>
    </div>
    <div  class="form-fields" style="height:20px;" >
      <div  class="filed">State</div>
      <div  class="filed">
        <select name="b_state"  id="b_state">
          <option value="">Select</option>
          <?php 
					
				foreach($state1 as $state1){?>
          <option value="<?php echo $state1['state_code'];?>"  <?php if(set_value('b_state')==$state1['state_code']){?> selected="selected" <?php } ?>><?php echo $state1['state'];?></option>
          <?php }?>
        </select>
      </div>
    </div>
    <div  class="form-fields" style="height:20px;" >
      <div  class="filed">Country</div>
      <div  class="filed">
        <select name="b_country" id="b_country">
          <option value="US">United States</option>
        </select>
      </div>
    </div>
    <div  class="form-fields" style="height:20px;" >
      <div  class="filed">City</div>
      <div  class="filed">
        <input type="text" name="b_city" id="b_city"  size="35" value=""/>
      </div>
    </div>
    <div  class="form-fields" style="height:20px;" >
      <div  class="filed">Zipcode</div>
      <div  class="filed">
        <input type="text" name="b_zipcode" id="b_zipcode"  size="20" value=""/>
      </div>
    </div>
  </div>
  <div  class="form-fields subhead_txt"> Shipping Address</div>
  <div  class="form-fields" style="height:20px;" >
    <div  class="filed">
      <input type="checkbox" name="ssame" id="ssame" value="" />
      Shipping Address is same as Billing Address </div>
  </div>
  <div  class="form-fields"  id="shipping" >
    <div  class="form-fields" style="height:20px;" >
      <div  class="filed">Address</div>
      <div  class="filed">
        <input type="text" name="s_address" id="s_address"  size="35" value=""/>
      </div>
    </div>
    <div  class="form-fields" style="height:20px;" >
      <div  class="filed">State</div>
      <div  class="filed">
        <select name="s_state"  id="s_state">
          <option value="">Select</option>
          <?php 
					
				foreach($state2 as $state2){?>
          <option value="<?php echo $state2['state_code'];?>"  <?php if(set_value('b_state')==$state2['state_code']){?> selected="selected" <?php } ?>><?php echo $state2['state'];?></option>
          <?php }?>
        </select>
      </div>
    </div>
    <div  class="form-fields" style="height:20px;" >
      <div  class="filed">Country</div>
      <div  class="filed">
        <select name="s_country" id="s_country">
          <option value="US">United States</option>
        </select>
      </div>
    </div>
    <div  class="form-fields" style="height:20px;" >
      <div  class="filed">City</div>
      <div  class="filed">
        <input type="text" name="s_city" id="s_city"  size="35" value=""/>
      </div>
    </div>
    <div  class="form-fields" style="height:20px;" >
      <div  class="filed">Zipcode</div>
      <div  class="filed">
        <input type="text" name="s_zipcode" id="s_zipcode"  size="20" value=""/>
      </div>
    </div>
  </div>
    <div  class="form-fields" style="height:20px;" >
  
      <div  class="filed">
       <? 

	 
	  ?>	
	   
      </div>
    </div>
    <div  class="form-fields" style="height:20px;" >
  
      <div  class="filed">
        <input type="button" name="submit"  value="submit" onclick="javascript:checkuser():"/>
      </div>
    </div>

</div>
