<?php page_heading('Courses' , 'banner-inner');?>
<div class="container">
    <div class="divide40"></div>
    <div class="row margin40">
        <?php if($this->session->userdata("msg")) { ?>
        <div class="col-md-12" style="text-align:center;">
            <div class="btn" style="color:#F33333;"><b>
                <?php echo $this->session->userdata("msg"); $this->session->unset_userdata("msg"); ?>
            </b></div><br/><br/>
        </div>
        <?php } ?>
        <div class="col-sm-12">
            <?php $this->load->view('reskin/user/profile/_progress');?>
        </div>
        <div class="col-sm-10 col-sm-offset-1">
            <?php showMessage();?>
            <?php  echo $this->load->view('reskin/course/registered');?>
            <?php  echo $this->load->view('reskin/course/completed');?>
            <?php if ($add_status == true){?>
            <div class="row">
                <div class="col-sm-12 text-center">
                   <a rel="nofollow" href="<?php echo base_url();?>user/listremainingcourse" class="btn-adhi margin10">Apply New Course</a>
                </div>
            </div>
            <?php }?>
        </div>
    </div>
</div>