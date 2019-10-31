
<div class="floatleft">
      <div class="left_cntnr" style="position: relative;">
            <?php $this ->load->view('left_content.php');?>
    </div>
    <div class="right_cntnr">
        <div class="right_cntnr_bg_hd">
			 <div class="floatleft" style="width:100%;">
				 <div class="sitepagehead"><h1>Renewal of <?php foreach($renewcourse as $ren){echo $ren['course_name'];} ?><h1></div>
				 <div class="username"><?php disp_loggedin_username(); ?></div>
			 </div>
        </div>
        <div class="right_cntnr_bg">
        	<?php $this->load->view('second_navigation');?>
			
            
                    <?php echo form_open("user/renewal",array('name'=>'renewcourse','id'=>'renewcourse'));?>
                    <div id="maindiv" style="padding-top:100px;">
                      <div id="registerviewmain" >
                          <center>
                          <div style="width:820px;">
                        <div class="stmain" style="width:100%;">
                           <div class="registerinnerregistercontentdiv">
                              <div class="page_error" id="errordisplay"></div>
                                <?php
                                        if(isset($msg) || validation_errors ()) {
                                            $style = "block";
                                        } else {
                                            $style = "none";
                                        }
                                        if($this->session->flashdata("msg")) {
                                            $style_success = "block";
                                        } else {
                                            $style_success = "none";
                                        }
                                    ?>
                                <div class="wrap-box-fixed" id="wrap_error_box">  
                                    <div  class="page_error  box-fixed" id="errordiv" style="display:<?php echo $style;?>" >
                                    <?php if(isset($msg)) echo $msg; ?>
                                    <?php if (validation_errors ()) : echo validation_errors (); endif;?>
                                    </div>
                                    <button class="close" id="close_button" data-dismiss="alert" type="button" onclick="hide_errorbox();" style="display:<?php echo $style;?>">×</button>
                                
                                </div>
                                <div class="wrap-box-fixed" id="wrap_error_box">
                                    <div  class="form-fieldsaddcrs head_txt  box-fixed-success-profile" id="flashsuccess" style="display:<?php echo $style_success;?>"><?php echo $this->session->flashdata("msg");   ?></div>
                                    <button class="close-profile" id="close_button_success" data-dismiss="alert" type="button" onclick="hide_errorbox_success();" style="display:<?php echo $style_success;?>">×</button>
                                </div>
                              
                                  <!--<div  class="form-fieldsaddcrs head_txt" id="flashsuccess"><?php //echo $this->session->flashdata("msg");   ?></div>-->
                                    
                                    <input  type="hidden" name="bphone" id="bphone" size="30" value="<?php if(isset($phone))echo $phone;?>" />
                                    <input  type="hidden" name="firstname" id="firstname" size="30" value="<?php if(isset($firstname))echo $firstname;?>" />
                                    <input  type="hidden" name="lastname" id="lastname" size="30" value="<?php if(isset($lastname))echo $lastname;?>" />
                                    <input  type="hidden" name="emailid" id="emailid" size="30" value="<?php if(isset($emailid))echo $emailid;?>" />
                                    <input  type="hidden" name="usercourse" id="usercourse" size="30" value="<?php if(isset($usercourse))echo $usercourse;?>" />
                                    <input type="hidden" name="curyear"  id="curyear"  value="<?php echo convert_UTC_to_PST_year(date('Y-m-d H:i:s'));?>" />
                                    <input type="hidden" name="curmonth"  id="curmonth"  value="<?php echo convert_UTC_to_PST_month(date('Y-m-d H:i:s'));?>" />
                                    <div class="clearboth"></div>
                                    <div class="coursemain">
                                    <div class="" style="padding-left:25px;"><img  src="<?php  echo ssl_url_img();?>billing_address.png" alt="Billing Address" /></div>
                                    <div class="clearboth"></div>
                                    <?php $this->load->view("renew/renew_billing");?>
                                    <div class="clearboth" style="padding-bottom:20px;"></div>
                                    <div style="float:left; padding-left:40px;">
	                                    <div class="floatleft"><span class="cartdet_head">CART DETAILS</span></div>
	                                    <div class="clearboth">&nbsp;</div>
	                                    <div   style="width:350px;" >
	                                    <div  class="filedforrate " id="carttotal">
	                                    <?php foreach($renewcourse as $renewcourse1){?>
	                                            <input type="hidden" name="courseid" id="courseid" value="<?php echo $renewcourse1['id'];?>">
	                                            <input type="hidden" name="totalprice" id="totalprice" value="<?php echo $renewcourse1['amount'];?>">
	                                            <input type="hidden" name="coursename" id="coursename" value="<?php if ($renewcourse1['parent_course_name'])echo $renewcourse1['parent_course_name']."-".$renewcourse1['course_name'] ;
	                                             else echo $renewcourse1['course_name'] ;?>">
	
	                                              <table cellspacing="0" cellpadding="5" border="0" width="779px" class="gridborder">
	                                                  <tr class="gridtrfirst">
	                                                  <td class='firstrow' width="611px" style="border-right:1px solid #000;">Course Name</td> <td class="firstrow" width="118px">Amount($)</td>
	                                                  </tr>
	                                                  <tr class='gridrowfirst'>
	                                                   <td class='secondrow' width="611px" style="border-right:1px solid #000"><?php echo $renewcourse1['course_name']."-".$renewcourse1['course_code'] ; ?></td> <td  width="118px" class="secondrow"><?php echo $renewcourse1['amount'] ; ?></td>
	                                                  </tr>
	                                              </table>
	                                         <?php }?>
	                                      </div>
	                                    </div>
	                                </div>
                                    <div class="clearboth">&nbsp;</div>
                                    <?php  $this->load->view("renew/renew_payment_details");?>
                                    <div class="clearboth">&nbsp;</div>
                                    </div>
                                <!-- list registerdata-->
                              </div>
                            </div>
                          </div>
                          </center>
                          </div>
                        </div>
                    </form>
        </div>
    </div>
</div>














<style type="text/css">
        body {
        font-family: Arial, Helvetica, sans-serif;
        text-align: left;
        padding: 0px;
        margin-top:0px;
        background:url(<?php echo base_url().'images/bg_01.jpg'?>) #000000 no-repeat center top;
        height:auto;
        }
    </style>
<script>
function show() {
    document.getElementById("errordiv").style.display = "none";
    document.getElementById("close_button").style.display = "none";
    
    document.getElementById("flashsuccess").style.display = "none";
    document.getElementById("close_button_success").style.display = "none";
}
function hidealert() {
    setTimeout("show()", 9000);  
}
setTimeout("show()", 9000);  
</script>