<?php 
$ti = '';
foreach($renewcourse as $ren){$ti = $ren['course_name'];}
page_heading('Renewal of '.$ti, 'banner-inner renewal-heading');
?>
<div class="container">
    <div class="divide40"></div>
    <div class="row margin40">
        <div class="col-sm-8 col-sm-offset-2">
            <?php if (validation_errors ()){?>
            <div class="row">
                <div class="col-sm-12 alert alert-danger"><?php echo validation_errors ();?></div>
            </div>
            <?php }else {showMessage();}?>
            <?php echo form_open("user/renewal/".$usercourse, array('name'=>'renewcourse','id'=>'renewcourse'));?>
                <input  type="hidden" name="bphone" id="bphone" size="30" value="<?php if(isset($phone))echo $phone;?>" />
                <input  type="hidden" name="firstname" id="firstname" size="30" value="<?php if(isset($firstname))echo $firstname;?>" />
                <input  type="hidden" name="lastname" id="lastname" size="30" value="<?php if(isset($lastname))echo $lastname;?>" />
                <input  type="hidden" name="emailid" id="emailid" size="30" value="<?php if(isset($emailid))echo $emailid;?>" />
                <input  type="hidden" name="usercourse" id="usercourse" size="30" value="<?php if(isset($usercourse))echo $usercourse;?>" />
                <input type="hidden" name="curyear"  id="curyear"  value="<?php echo convert_UTC_to_PST_year(date('Y-m-d H:i:s'));?>" />
                <input type="hidden" name="curmonth"  id="curmonth"  value="<?php echo convert_UTC_to_PST_month(date('Y-m-d H:i:s'));?>" />
                <h3>BILLING ADDRESS </h3>
                <div class="row">
                    <div class="col-md-6 form-group">		
                        <input type="text" name="b_address" id="b_address" placeholder="ADDRESS" required  class="form-control" maxlength="128" value="<?php if(isset($billing['b_address'])) echo $billing['b_address']; else echo set_value('b_address'); ?>" /> 		
                    </div>
                    <div class="col-md-6  form-group">		
                        <input type="hidden" name="b_country" id="b_country" value="US" >
                            <?php
                                $b_state = '';
                                if($this->input->post('b_state')){
                                    $b_state = $this->input->post('b_state');
                                }else if(isset($billing['b_state'])){
                                    $b_state = $billing['b_state'];
                                }
                            ?>
                            <select class="state form-control" id="b_state" name="b_state" required>
                                <option value="">SELECT STATE</option>
                                <?php foreach($state as $state){
                                    $selected = ($state['state_code'] == $b_state) ? 'selected="selected" ' : '';
                                ?>
                                        <option value="<?php echo $state['state_code'] ?>" <?php echo $selected;?>><?php echo $state['state']?></option>
                                <?php }?>
                            </select>	
                    </div>
                    
                </div>		 
                <div class="row">
                    <div class="col-md-6  form-group">
                        <input type="text" placeholder="COUNTRY" disabled="" class="form-control" maxlength="0"  value="United States" />
                    </div>
                    <div class="col-md-6  form-group">
                        <input type="text" name="b_city" id="b_city" placeholder="CITY*" required  class="form-control" maxlength="40"  value="<?php if(isset($billing['b_city']))echo $billing['b_city']; else echo set_value('b_city'); ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <input type="text" name="b_zipcode" id="b_zipcode" placeholder="ZIP CODE" required  class="form-control" maxlength="5" value="<?php echo isset($billing['b_zipcode']) ? $billing['b_zipcode'] : set_value('b_zipcode'); ?>"/>
                        <div class="text-right guide-cnt">Zip code must be 5 digits</div>
                    </div>
                </div>
                
                <h3>CART DETAILS </h3>
                <div class="row" id="grid">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <tr class="gridheading">
                                <th width="75%">COURSE NAME</th>	
                                <th class="darkgray text-center" align="center">AMOUNT($)</th>	
                            </tr>
                            <?php foreach($renewcourse as $renewcourse1){?>
                                <input type="hidden" name="courseid" id="courseid" value="<?php echo $renewcourse1['id'];?>">
                                <input type="hidden" name="totalprice" id="totalprice" value="<?php echo $renewcourse1['amount'];?>">
                                <input type="hidden" name="coursename" id="coursename" value="<?php if ($renewcourse1['parent_course_name'])echo $renewcourse1['parent_course_name']."-".$renewcourse1['course_name'] ;else echo $renewcourse1['course_name'] ;?>">
                            <tr>
                                <td ><?php echo $renewcourse1['course_name']."-".$renewcourse1['course_code'] ; ?> </td>
                                <td class="prcolor" align="center"><?php echo $renewcourse1['amount'] ; ?></td>
                            </tr>
                            <?php }?>
                        </table>
                    </div>
                </div>
                
                <h3>PLEASE ENTER PAYMENT DETAILS HERE </h3>

                <?php  $this->load->view("reskin/register/registration_payment_details");?>
                
                <div class="row">
                    <div class="divide20"></div>
                    <div class="col-md-12 text-center">
                        <input type="submit" class=" btn-adhi" value="SUBMIT" />
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>