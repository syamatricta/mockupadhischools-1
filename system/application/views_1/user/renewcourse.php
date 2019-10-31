<div class="clearboth"></div>
<?php echo form_open("user/renewal",array('name'=>'renewcourse','id'=>'renewcourse'));?>
<div id="maindiv">
  <div id="registerviewmain" >
    <div class="stmain">
     <div class="floatleft"><span class="redheading">Renewal of </span>&nbsp;&nbsp;<span class="register_step"> <?php foreach($renewcourse as $ren){echo $ren['course_name'];} ?> </span></div>
      <div class="clearboth"></div>
	 	 <div class="registerinnerregistercontentdiv">
          <div class="page_error" id="errordisplay"></div>
          	<div  class="page_error" id="errordiv" >
            <?php if(isset($msg)) echo $msg; ?>
         	 </div>
			  <div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("msg");   ?></div>
				<?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
				<input  type="hidden" name="bphone" id="bphone" size="30" value="<?php if(isset($phone))echo $phone;?>" />
				<input  type="hidden" name="firstname" id="firstname" size="30" value="<?php if(isset($firstname))echo $firstname;?>" />
				<input  type="hidden" name="lastname" id="lastname" size="30" value="<?php if(isset($lastname))echo $lastname;?>" />
				<input  type="hidden" name="emailid" id="emailid" size="30" value="<?php if(isset($emailid))echo $emailid;?>" />
				<input  type="hidden" name="usercourse" id="usercourse" size="30" value="<?php if(isset($usercourse))echo $usercourse;?>" />
				<input type="hidden" name="curyear"  id="curyear"  value="<?php echo convert_UTC_to_PST_year(date('Y-m-d H:i:s'));?>" />
				<input type="hidden" name="curmonth"  id="curmonth"  value="<?php echo convert_UTC_to_PST_month(date('Y-m-d H:i:s'));?>" />
				<div class="clearboth"></div>
				<div class="listregistermain">
				<div class="commonaddressheads">Billing Address</div>
				<div class="clearboth"></div>
				<?php $this->load->view("renew/renew_billing");?>
				<div class="clearboth" style="padding-bottom:20px;"></div>
				<div class="floatleft"><span class="redsubheading">CART DETAILS</span></div>
				<div class="clearboth">&nbsp;</div>
				<div   style="width:350px;" >
				  <div  class="filedforrate " id="carttotal">
				  <?php foreach($renewcourse as $renewcourse1){?>
						<input type="hidden" name="courseid" id="courseid" value="<?php echo $renewcourse1['id'];?>">
						<input type="hidden" name="totalprice" id="totalprice" value="<?php echo $renewcourse1['amount'];?>">
						<input type="hidden" name="coursename" id="coursename" value="<?php if ($renewcourse1['parent_course_name'])echo $renewcourse1['parent_course_name']."-".$renewcourse1['course_name'] ;
						 else echo $renewcourse1['course_name'] ;?>">
			
						  <table cellspacing="0" cellpadding="5" border="0" width="629px" class="gridborder">
							  <tr class="gridtrfirst">
							  <td class='firstrow' width="511px">Course Name</td><td  class="gridsectd" ></td> <td class="firstrow" width="118px">Amount($)</td>
							  </tr>
							  <tr class='gridrowfirst'>
							   <td  width="511px"><?php echo $renewcourse1['course_name']."-".$renewcourse1['course_code'] ; ?></td><td  class="gridsectd" ></td> <td  width="118px"><?php echo $renewcourse1['amount'] ; ?></td>
							  </tr>
						  </table>
					 <?php }?>
				  </div>
				</div>
				<div class="clearboth">&nbsp;</div>
				<?php $this->load->view("renew/renew_payment_details");?>
				<div class="clearboth">&nbsp;</div>
				</div>
			<!-- list registerdata-->
		  </div>
		</div>
	  </div>
	</div>
</form>
