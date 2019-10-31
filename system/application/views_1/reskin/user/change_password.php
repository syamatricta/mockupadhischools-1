<?php page_heading('Change Password' , 'banner-inner');?>
<div class="container">
    <div class="divide50"></div>
    <div class="row">
        <?php echo  form_open ('user/change_password', array('name'=>'change_password','id' => 'change_password', 'class' => '',  'onsubmit'=>'javascript: return change_password ();') ); ?>
        <div class="col-sm-4 col-sm-offset-4">
            
            <div class="row">
                <?php if($this->session->flashdata("error")){?>
                    <div class="col-sm-12"><div class="alert alert-danger"><?php echo $this->session->flashdata("error"); ?></div></div>
                <?php }else if($this->session->flashdata("success")){?>
                    <div class="col-sm-12"><div class="alert alert-success"><?php echo $this->session->flashdata("success"); ?></div></div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="col-md-12 form-group">
                    <input type="password" name="old_password" maxlength="50" size="25" id="old_password" placeholder="Current Password" class="form-control" value="<?php echo $this->input->post('txtSearchengine', s('txtSearchengine')); ?>" required />
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 form-group">
                    <input type="password" name="new_password" maxlength="50" size="25" id="new_password" placeholder="New Password" class="form-control" value="<?php echo $this->input->post('txtSearchengine', s('txtSearchengine')); ?>" required />
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 form-group">
                    <input type="password" name="confirm_password" maxlength="50" size="25" id="confirm_password" placeholder="Retype Password" class="form-control" value="<?php echo $this->input->post('txtSearchengine', s('txtSearchengine')); ?>" required />
                </div>
            </div>
            
            <div class="row margin70">
                <div class="col-md-12 text-center">
                    <input type="submit" class=" btn-adhi" value="Change Password" />
                </div>
            </div>
        
        </div>
        <?php echo form_close();?>
    </div>
</div>