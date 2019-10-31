<?php page_heading('Add New Courses', 'banner-inner renewal-heading');?>
<div class="text-right" style="margin-right:8%;">		
    <span><a href="<?php echo base_url(); ?>">Home</a></span>		
    <span class="content">|Apply New Courses</span> 		
</div>
<div class="container apply-new-course">
    <div class="divide40"></div>
    <div class="row">
        <div class="col-md-12">
            <div id="wrap_error_box" class="wrap-box-fixed">
                <div id="fixederror" class="page_error box-fixed" style="display: none;"></div>					
            </div>
        </div>
    </div>
    <div class="row margin40">
        <div class="col-sm-8 col-sm-offset-2">
            <?php 
            showMessage();
            echo form_open("user/listremainingcourse", array('name'=>'course','id'=>'apply_new_course'));
            ?>
            <input type="hidden" name="bphone"      id="bphone"     size="30" value="<?php if(isset($phone))echo $phone;?>" />
            <input type="hidden" name="firstname"   id="firstname"  size="30" value="<?php if(isset($firstname))echo $firstname;?>" />
            <input type="hidden" name="lastname"    id="lastname"   size="30" value="<?php if(isset($lastname))echo $lastname;?>" />
            <input type="hidden" name="emailid"     id="emailid"    size="30" value="<?php if(isset($emailid))echo $emailid;?>"  />
            <input type="hidden" name="hidusertype" id="hidusertype" value="<?php echo $course_user_type;?>" />
            <?php
            $this->load->view("reskin/course/apply_new/_shipping_address");
            $this->load->view("reskin/course/apply_new/_billing_address");
            $this->load->view("reskin/course/apply_new/_course_list");
            $this->load->view("reskin/register/register_shpping_course");        
            $this->load->view('reskin/register/registration_payment_details');
            ?>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <input type="submit" class=" btn-adhi" value="Submit" />
                    <input type="button" class=" btn-adhi go_to_url" value="Cancel" data-url="<?php echo base_url().'course/courselist'; ?>" />
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
       
<script type="text/javascript" >
    $(document).ready(function (){
        load_courses();
    });
    
</script>

<?php echo form_close(); ?>
<?php $this->load->view('reskin/register/course_agreement') ;?>