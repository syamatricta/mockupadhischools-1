<div class="floatleft">
      <div class="left_cntnr" style="position: relative;">
            <?php $this ->load->view('left_content.php');?>
    </div>
    <div class="right_cntnr">
        <div class="right_cntnr_bg_hd">
        	 <div class="floatleft" style="width:100%;">
            	<div class="sitepagehead"><h1>Add New Courses</h1></div>
            	<div class="username"><?php disp_loggedin_username(); ?></div>
            </div>
        </div>
        <div class="right_cntnr_bg">
        	<?php $this->load->view('second_navigation');?>
        	
        
        				
                            <div class="clearboth"></div>
                            <?php echo form_open("user/listremainingcourse",array('name'=>'course','id'=>'course'));?>
                            <?php
                                        if(isset($msg) || validation_errors () || $this->session->flashdata("msg")) {
                                            $style = "block";
                                        } else {
                                            $style = "none";
                                        }
                                    ?>
                            <div id="maindiv" style="padding-top:100px;">
                              <div id="registerviewmain" >
                                  <center>
                                <div style="width:820px;">
                                <div class="stmain" >
                                  <div class="clearboth"></div>
                                  <div class="registerinnerregistercontentdiv">
                                    
                                      
                                    <div class="page_error" id="errordisplay"></div>
                                    <div class="wrap-box-fixed" id="wrap_error_box">  
                                        <div  class="page_error box-fixed" id="errordiv" style="display:<?php echo $style;?>">
                                          <?php if(isset($msg)) echo $msg; ?>
                                          <?php if (validation_errors ()) : echo validation_errors (); endif;?>
                                           <?php  echo $this->session->flashdata("msg");   ?>
                                        </div>
                                        <button class="close" id="close_button" data-dismiss="alert" type="button" onclick="hide_errorbox();" style="display:<?php echo $style;?>">×</button>
                                     </div>
                                    <div class="clearboth"></div>
                                    <input  type="hidden" name="bphone" id="bphone" size="30" value="<?php if(isset($phone))echo $phone;?>" />
                                    <input  type="hidden" name="firstname" id="firstname" size="30" value="<?php if(isset($firstname))echo $firstname;?>" />
                                    <input  type="hidden" name="lastname" id="lastname" size="30" value="<?php if(isset($lastname))echo $lastname;?>" />
                                    <input  type="hidden" name="emailid" id="emailid" size="30" value="<?php if(isset($emailid))echo $emailid;?>"  />
                                    <div class="clearboth"></div>
                                    <div class="listregistermain">                                   
                                    	<input type="hidden" name="hidusertype" id="hidusertype" value="<?php echo $course_user_type;?>" />
                                        <div class=""  style="padding-left:25px;"><img  align="left" src="<?php  echo ssl_url_img();?>shipping_address.png" alt="Shipping Address" title="Shipping Address" /></div>
                                        <div class="clearboth20"></div>
                                        <?php /* shipping address*/
                                        $this->load->view("addnewcourse/course_shipping_address");
                                        ?>
                                        <div class="clearboth">&nbsp;</div>
                                        <div  style="padding-left:25px;"><img  align="left" src="<?php  echo ssl_url_img();?>billing_address.png" alt="Billing Address" title="Billing Address" /></div>
                                        <div class="clearboth20" ></div>
                                        <?php /* billing address*/
                                            $this->load->view("addnewcourse/course_billing_address");?>
                                        <div class="clearboth20"></div>
                                        <div style="float:left; padding-left:55px;">
                                        <div class="floatleft">
                                            <div class="course_list_txt">COURSE LIST</div>
                                        </div>
                                        <input type="hidden" name="sel_course_b" id="sel_course_b" value="0"  />
        								<input type="hidden" name="sel_course_m" id="sel_course_m" value="0"  />
                                        <div class="clearboth">&nbsp;</div>
                                         <input type="hidden" name="sel_course_b" id="sel_course_b" value="0"  />
                                         <input type="hidden" name="sel_course_m" id="sel_course_m" value="0"  />
                                        <?php
                                        /* Sales courses */
                                        $this->load->view('addnewcourse/course_sales_courses');
                                        /* Sales courses optional */
                                        $this->load->view('addnewcourse/course_sales_courses_optional');

                                        /* broker courses */
                                        $this->load->view('addnewcourse/course_broker_courses');
                                        /* broker courses optional */

 				
                                        /* SHIPPING */
                                        $this->load->view("addnewcourse/order_shpping_course");?>
                                        
                                        </div>
                                        <?php 
                                        /* PAYMENT */
                                        $this->load->view('addnewcourse/order_payment_details');
                                        ?>
                                       
                                       <div class="clearboth">&nbsp;</div>
                                    </div>
                                    <!-- list registerdata-->
                                  </div>
                                </div>
                              </div>
                             </center>
                              </div>
                            </div>
        </div>
    </div>
</div>


<?php
  $carr = array();
   foreach($courses as $coursearr){
 		$carr[] 	= Array('course_id'=> $coursearr->course_id , 'course_name' => $coursearr->course_name, 'amount' =>$coursearr->amount);
	}
	$jsonscript =  json_encode($carr);
   ?>
	<input type="hidden" id="hidJson" name="hidJson" value='<?php echo $jsonscript; ?>'/>
       
<script type="text/javascript" >load_courses();</script>

<?php echo form_close(); ?>
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
}
function hidealert() {
    setTimeout("show()", 9000);  
}
setTimeout("show()", 9000);  
</script>