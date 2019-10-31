<div class="clearboth"></div>
<?php echo form_open("user/listremainingcourse",array('name'=>'course','id'=>'course'));?>
<div id="maindiv">
  <div id="registerviewmain" >
    <div class="stmain" >
      <div class="floatleft"><span class="redheading">Add</span>&nbsp;&nbsp;<span class="register_step">New Courses </span></div>
      <div class="clearboth"></div>
      <div class="registerinnerregistercontentdiv">
        <div class="page_error" id="errordisplay"></div>
        <div  class="page_error" id="errordiv" >
          <?php if(isset($msg)) echo $msg; ?>
        </div>
        <div  class="page_error" >
          <?php  echo $this->session->flashdata("msg");   ?>
        </div>
        <?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
        <div class="clearboth"></div>
        <input  type="hidden" name="bphone" id="bphone" size="30" value="<?php if(isset($phone))echo $phone;?>" />
        <input  type="hidden" name="firstname" id="firstname" size="30" value="<?php if(isset($firstname))echo $firstname;?>" />
        <input  type="hidden" name="lastname" id="lastname" size="30" value="<?php if(isset($lastname))echo $lastname;?>" />
        <input  type="hidden" name="emailid" id="emailid" size="30" value="<?php if(isset($emailid))echo $emailid;?>"  />
        <div class="clearboth"></div>
        <div class="listregistermain"> 
        	<div class="commonaddressheads">Shipping Address</div>
			<div class="clearboth"></div>
			<?php /* shipping address*/
			$this->load->view("addnewcourse/course_shipping_address");
			?>
			<div class="clearboth">&nbsp;</div>
			<div class="commonaddressheads">Billing Address</div>
			<div class="clearboth"></div>
			<?php /* billing address*/ 
				$this->load->view("addnewcourse/course_billing_address");?>
			<div class="clearboth" style="padding-bottom:20px;"></div>
			<div class="floatleft"><span class="redsubheading">COURSE LIST</span></div>
			<div class="clearboth">&nbsp;</div>
			<?php 
			/* Sales courses */
			$this->load->view('addnewcourse/course_sales_courses');
			/* Sales courses optional */
			$this->load->view('addnewcourse/course_sales_courses_optional');

			/* broker courses */
			$this->load->view('addnewcourse/course_broker_courses');
			/* broker courses optional */
			
		
			/* SHIPPING */
			$this->load->view("addnewcourse/order_shpping_course");
			/* PAYMENT */
			$this->load->view('addnewcourse/order_payment_details');
			?>
		   <div class="clearboth">&nbsp;</div>
        </div>
		<!-- list registerdata-->
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" >
var carr = new Array();
<?php foreach($coursearr as $coursearr){ ?>
	carr[<?php echo $coursearr['id']?>] 	= new Array();
	carr[<?php echo $coursearr['id']?>][0]	= "<?php echo $coursearr['course_name']?>";
	carr[<?php echo $coursearr['id']?>][1]	= "<?php echo $coursearr['amount']?>";
<?php }?>
</script>
</form>
