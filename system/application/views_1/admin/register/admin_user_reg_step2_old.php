<div class="clearboth"></div>
<?php echo form_open("user/courseadd",array('name'=>'course','id'=>'course'));  ?>
<div id="maindiv">
  <div id="registerviewmain" >
    <div class="stmain">
      <div class="floatleft"><span class="redheading">Registration</span>&nbsp;&nbsp;<span class="register_step">Step 2 </span></div>
      <div class="clearboth"></div>
	  <div class="registerinnerregistercontentdiv">
        <div class="page_error" id="errordisplay"></div>
        <div  class="page_error" id="errordiv" >
          <?php if(isset($msg)) echo $msg; ?>
        </div>
        <div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("msg");   ?></div>
        <?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
        <input  type="hidden" name="bphone" id="bphone" value="<?php if(isset($phone))echo $phone;?>" />
        <div class="clearboth"></div>
        

        
        <div class="listregistermain">
	        <div class="commonaddressheads">
	        	Need Shipping
	        	<input type="radio" checked="checked" name="need_ship" id="need_ship" value="yes" onclick="javascript:show_ship(); checkcourse();">Yes
	        	<input type="radio" name="need_ship" id="need_ship" value="no"  onclick="javascript:show_ship(); checkcourse();">No
      	  </div>
      	  <div class="clearboth"></div>
  	     <div class="commonaddressheads">
	        	Need Payment
	        	<input type="radio" name="need_payment" id="need_payment" value="yes" onclick="javascript:show_payment(); checkcourse();" checked="checked">Yes
	        	<input type="radio" name="need_payment" id="need_payment" value="no" onclick="javascript:show_payment(); checkcourse();">No
      	  </div>
      	  
        	<div id="show_ship_div_addr"> 
	        	<div class="commonaddressheads">Shipping Address</div>
				<div class="clearboth"></div>
			  	<?php $this->load->view("admin/register/register_step2_shipping"); ?>
		  	</div>
		  	<div id="show_payment_div_addr"> 
			  	<div class="clearboth">&nbsp;</div>
	          	<div class="commonaddressheads">Billing Address</div>
	          	<div class="clearboth"></div>
			 	<?php $this->load->view("admin/register/register_step2_billing");?>
		 	</div>
		 	<div class="clearboth" style="padding-bottom:20px;"></div>
			<div class="floatleft"><span class="redsubheading">COURSE LIST</span></div>
			<div class="clearboth">&nbsp;</div>
			<?
			/* SALES MANDATORY COURSES*/
			$this->load->view("admin/register/register_course_sales_mandatory");
			/* SALES OPTIONAL COURSES */
			$this->load->view("admin/register/register_course_sales_optional");
			/* BROKERS COURSES */
			$this->load->view("admin/register/register_course_broker_mandatory");
			echo "<div id='show_ship_div_select'>";
				/* SHIPPING */
				$this->load->view("admin/register/register_shpping_course");
				/* PAYMENT */
			echo "</div>";?>
			<div  class="filedforrate " id="grid"></div>
		<?php	echo "<div id='show_payment_div_select'>";
				$this->load->view('admin/register/registration_payment_details');
			
			echo "</div>";
			?>
			
		   <div class="clearboth">&nbsp;</div>
		   		<div class="rightsidedata_register">
			<img  src="<?php  echo ssl_url_img();?>innerpages/sub_btn.jpg" onclick="javascript:addcourses();" class="stylebutton" /><span  id="newimg" style="display:none;"></span>
		</div>
        </div>
		<!-- list registerdata-->
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" >
show_payment();
show_ship();
var carr = new Array();
<?php foreach($coursearr as $coursearr){ ?>
	carr[<?php echo $coursearr['id']?>] 	= new Array();
	carr[<?php echo $coursearr['id']?>][0]	= "<?php echo $coursearr['course_name']?>";
	carr[<?php echo $coursearr['id']?>][1]	= "<?php echo $coursearr['amount']?>";
<?php }?>
</script>
</form>
