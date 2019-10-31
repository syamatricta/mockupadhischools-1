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
        	
        	
			
			<div class="floatleft"><span class="redsubheading">COURSE LIST</span></div>
			<div class="clearboth">&nbsp;</div>
			<?php 
			/* Sales courses */
			$this->load->view('admin/user management/course_sales_courses');
			/* Sales courses optional */
			$this->load->view('admin/user management/course_sales_courses_optional');

			/* broker courses */
			$this->load->view('admin/user management/course_broker_courses');
			/* broker courses optional */
			
		
			/* SHIPPING */
			//$this->load->view("addnewcourse/order_shpping_course");
			/* PAYMENT */
			//$this->load->view('addnewcourse/order_payment_details');
			?>
		   	<div class="clearboth">&nbsp;</div>
			<div class="leftside_register">&nbsp;</div>
			<div class="middlecolon_register">&nbsp;</div>
			
			
			
			<div  class="filedforrate">
				<input type="hidden" name="price"  id="price"  value="0" />
				<input type="hidden" name="shipprice"  id="shipprice"  value="0" />
				<input type="hidden" name="totalprice"  id="totalprice"  value="0" />
				<input type="hidden" name="curyear"  id="curyear"  value="<?php echo convert_UTC_to_PST_year(date('Y-m-d H:i:s'));?>" />
				<input type="hidden" name="curmonth"  id="curmonth"  value="<?php echo convert_UTC_to_PST_month(date('Y-m-d H:i:s'));?>" />
			</div>
			<div class="clearboth"></div>
			<?php /* total weight */?>
			<div  class="filedforrate"> 
				<input type="hidden" name="totalweight"  id="totalweight"  value="0" />
				<input type="hidden" name="totalweightb"  id="totalweightb"  value="0" />
				<input type="hidden" name="subcourseweight" id="subcourseweight" value="0"  />
				<input  type="hidden" name="step2"  id="step2" value="2" />
			</div>
			
			<div  class="filedforrate " id="grid"></div>
			<div class="clearboth">&nbsp;</div>
			<div class="rightsidedata_register">
				<img  src="<?php  echo ssl_url_img();?>innerpages/sub_btn.jpg" onclick="javascript:addnewcourses(<?php echo $userid;?>);" class="stylebutton" /><span  id="newimg" style="display:none;"></span>
			</div>
        </div>
        <div class="backtolist">
			<a href="javascript:void(null);" onclick="javascript:gotolist('<?php echo $userid;?>'); return false;"><< Back to users list </a>
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
