<div class="floatleft">
     <div class="left_cntnr" style="position: relative;">
            <?php $this ->load->view('left_content.php');?>
    </div>
    <div class="right_cntnr">
        <div class="right_cntnr_bg_hd">
            <div class="floatleft" style="width:100%">
            	<div class="sitepagehead"><h1>Courses</h1></div>
            	<div class="username"><?php disp_loggedin_username(); ?></div> 
            </div>
            <div class="user_name_display">
              <?php //if(count($userdetails) > 0){ echo $userdetails->firstname." ".$userdetails->lastname; } ?>
            </div>
        </div>
        <div class="right_cntnr_bg">
        <?php $this->load->view('second_navigation');?>
            <div class="registermaindivaddcrs">
                <div  class="registerinnerdivaddcrs">
                    <div  class="form-fieldsaddcrs head_txt">
                        <?php if($this->session->flashdata("msg")) echo $this->session->flashdata("msg");   ?>
                        <?php if($this->session->userdata("msg")) { echo $this->session->userdata("msg"); $this->session->unset_userdata("msg"); }  ?>
                    </div>
                     <div  class="form-fieldsaddcrs page_error">
                        <?php //if($this->session->flashdata("error")) echo $this->session->flashdata("error");
                        if( $this->uri->segment(3)) { echo  base64_decode($this->uri->segment(3));}
                        ?>
                    </div>
                </div>
            </div>
                     
                 <div id="maindiv" style="padding-top:15px;">
                     <center>
                        <div id="courseviewmain">
                            <div class="clearboth"></div>
                            <div class="coursepginnercontentdiv">
                                <div class="listdata">
                                        <?php  echo $this->load->view('exam/registered_courses');?>
										<div class="clearboth"></div>
                                        <?php  echo $this->load->view('exam/completed_courses');?>
                                </div>
                            </div>
                             <div class="floatleft" >
                                <div class="editprofile" >
                                            <?php //echo anchor('profile/edit_profile','Edit My Profile');?>
                                    <?php if ($add_status == true){
                                    	echo anchor('user/listremainingcourse','<img  src="'.$this->config->item('images').'/innerpages/apply_new_course.png" />'); }?>
                                </div>
                            </div>

                        </div>
                    </center>
               </div>
            
        </div>
    </div>
</div>
<!--<div id="maindiv" >
	<div id="profileviewmain" >
  	<?php /*functional part */?>
		  <div  class="page_success" id="flashsuccess"><?php if($this->session->userdata("msg")){ echo $this->session->userdata("msg");   $this->session->set_userdata("msg",'');}

if($this->session->flashdata("msg")){ echo $this->session->flashdata("msg"); } ?></div>
		<div class="examdata" >
		  	<?php  //echo $this->load->view('exam/registered_courses');?>

			<?php //echo $this->load->view('exam/completed_courses');?>
		</div>
		<?php /*End functional part */?>

	</div>

</div>
<script type="text/javascript">
	//timer = setInterval('polling()',100);
</script>-->

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