<?php 
$ti = '';
foreach($courses as $ren){
    $ti = $ren['course_name'];    
}
page_heading('Renewal of Courses', 'banner-inner renewal-heading');
?>
<div class="text-right" style="margin-right:8%;">		
    <span><a href="<?php echo base_url(); ?>">Home</a></span>		
    <span class="content">|Renew course</span> 		
</div>
<div class="container" id="renew_courses_cnt">
    <div class="divide40"></div>
    <div class="row margin40">
        <div class="col-sm-8 col-sm-offset-2">
            <?php if (validation_errors ()){?>
            <div class="row">
                <div class="col-sm-12 alert alert-danger"><?php echo validation_errors ();?></div>
            </div>
            <?php }else {showMessage();}?>
            <?php echo form_open("user/renew_courses", array('name'=>'renewcourse','id'=>'renewcourse'));?>
                <?php /*<input type="hidden" name="bphone" id="bphone" size="30" value="<?php if(isset($phone))echo $phone;?>" />
                <input type="hidden" name="firstname" id="firstname" size="30" value="<?php if(isset($firstname))echo $firstname;?>" />
                <input type="hidden" name="lastname" id="lastname" size="30" value="<?php if(isset($lastname))echo $lastname;?>" />
                <input type="hidden" name="emailid" id="emailid" size="30" value="<?php if(isset($emailid))echo $emailid;?>" />
                 */
                ?>
                
                
                <input type="hidden" name="curyear"  id="curyear"  value="<?php echo convert_UTC_to_PST_year(date('Y-m-d H:i:s'));?>" />
                <input type="hidden" name="curmonth"  id="curmonth"  value="<?php echo convert_UTC_to_PST_month(date('Y-m-d H:i:s'));?>" />                
                
                <?php
                    $this->load->view('reskin/user/profile/_edit_personal_info');
                    
                    $this->load->view('reskin/user/profile/_edit_shipping_info');
                    
                    $this->load->view('reskin/user/profile/_edit_billing_info');
                ?>
                
                <div class="row margin20">
                    <div class="col-sm-12">
                        <div class="heading_band">Cart Details</div>
                    </div>
                </div>
                <div class="row" id="grid">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <tr class="gridheading">
                                <th width="75%">COURSE NAME</th>	
                                <th class="darkgray text-center" align="center">AMOUNT($)</th>	
                            </tr>
                            <?php 
                            $course_ids = array();
                            $usercourse_ids = array();
                            $amount     = 0.00;
                            $course_name = '';
                            foreach($courses as $course){
                                array_push($course_ids, $course['id']);
                                array_push($usercourse_ids, $course['usercourse']);
                                $amount     += $course['amount'];
                                if ($course['parent_course_name']){
                                    $course_name .= $course['parent_course_name']."-".$course['course_name'].',';
                                }else{
                                    $course_name .= $course['course_name'].',';
                                }
                            ?> 
                            <tr>
                                <td><?php echo $course['course_name']."-".$course['course_code'] ; ?> </td>
                                <td class="prcolor" align="center">
                                    <div class="amount-cnt">
                                        $<?php echo $course['amount'] ; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php }?>
                            <tr class="shiprate_tr">
                                <td align="right"> 
                                    <?php if('error' == $shipping_rate['status']){ echo '<span class="text-danger">'.$shipping_rate['error'].'&nbsp;&nbsp;</span>Ship Rate';}else{echo 'Ship Rate';}?>
                                </td>
                                <td class="prcolor" align="center">
                                    <div class="amount-cnt">
                                    <?php
                                        $price_wo_ship  = $amount;
                                        $ship_rate      = 0;
                                        if(isset($shipping_rate['amount'])){
                                            $ship_rate = $shipping_rate['amount'];
                                            $amount = $amount + $ship_rate;
                                    ?>
                                        
                                            $<?php echo number_format($shipping_rate['amount'], 2);?>
                                        </div>
                                    <?php }else{ echo '<span class="text-danger">error</span>';$amount = 'NA';}?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="totlabel" align="right">Total Price</td>
                                <td class="totparice" class="prcolor" align="right">
                                    <div class="amount-cnt">
                                        <?php if('NA' != $amount){?>
                                        <div class="amount-cnt"><b>$<?php echo number_format($amount, 2);?></b></div>
                                        <?php }else{ echo '<span class="text-danger">--</span>';}?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <input type="hidden" name="courses_ids"     id="course_id"      value="<?php echo implode(',', $course_ids);?>" />
                        <input type="hidden" name="price_wo_ship"   id="price_wo_ship"  value="<?php echo $price_wo_ship;?>" />
                        <input type="hidden" name="ship_rate"       id="ship_rate"      value="<?php echo $ship_rate;?>" />
                        <input type="hidden" name="totalprice"      id="total_price"    value="<?php echo $amount;?>" />
                        <input type="hidden" name="course_name"     id="course_name"    value="<?php echo rtrim($course_name, ',') ;?>" />
                        <input type="hidden" name="usercourse"      id="usercourse"     value="<?php echo implode(',', $usercourse_ids);?>" />
                        
                    </div>
                </div>
                
                <div class="row margin20">
                    <div class="col-sm-12">
                        <div class="heading_band">Please enter payment details here</div>
                    </div>
                </div>

                <?php  echo $this->load->view("reskin/register/registration_payment_details", array(), TRUE);?>
                
                <div class="row">
                    <div class="divide20"></div>
                    <div class="col-md-12 text-center">
                        <a class="" style="text-decoration:underline;margin-right:20px;" href="<?php echo base_url();?>course/courselist">Back to Courses</a>
                        <input type="submit" class="btn-adhi" data-form-id="renewcourse" value="SUBMIT" />
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<style>
    .amount-cnt{width: 75px;margin:0 auto;text-align: right;}
</style>
<script>
    $(document).ready(function (){
        if($('#renewcourse #email').length > 0){
            $('#renewcourse #email').removeAttr('disabled');
        }
    });
</script>