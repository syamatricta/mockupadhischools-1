<section class="page_head " style="height: 150px;"><div class="row title">
        <div class="container"><h1 class="float_title">Contact</h1></div>
        <div class="col-sm-5 part1">&nbsp;</div>
        <div class="col-sm-6 hidden-xs part2"></div>
        <div class="col-sm-1 hidden-xs"></div>
    </div></section>
<section class="register">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-sm12 col-md-offset-1 text-center">
                <h2 class="reg-note">We are in the process of revamping our real estate courses for higher quality online content.  Please leave your information and we will contact you regarding future classes.</h2>
            </div>
        </div>
        <div class="row">
            <?php
            showMessage();
            echo form_open("user/register", array('name'=>'course','id'=>'course_pre_apply'));
            ?>
            <div class="row margin20">
                <div class="col-sm-12">
                    <div class="heading_band">User Details</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="first_name">FIRST NAME*</label>
                    <input type="text" name="first_name" id="first_name" required placeholder="FIRST NAME*"  class="form-control" maxlength="128" value="<?php echo set_value('first_name'); ?>"/>
                </div>
                <div class="col-md-6 form-group">
                    <label for="last_name">LAST NAME*</label>
                    <input type="text" name="last_name" id="last_name" required placeholder="LAST NAME*"  class="form-control" maxlength="128" value="<?php echo set_value('last_name'); ?>"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="email">EMAIL*</label>
                    <input type="text" name="email" id="email" required placeholder="EMAIL*"  class="form-control" maxlength="128" value="<?php echo set_value('email'); ?>"/>
                </div>
                <div class="col-md-6 form-group">
                    <label for="phone_number">PHONE NUMBER*</label>
                    <input type="text" name="phone_number" id="phone_number" required placeholder="PHONE NUMBER*"  class="form-control" maxlength="128" value="<?php echo set_value('phone_number'); ?>"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="city">CITY OF RESIDENCE*</label>
                    <input type="text" placeholder="CITY*" name="city" required id="city" class="form-control" maxlength="40" value="<?php echo set_value('city'); ?>" />
                </div>
                <div class="col-md-6 form-group">
                    <label for="city" style="width: 100%;">COURSE PREFERENCE*</label>
                    <div style="width: 100%;clear: both;overflow: hidden" id="class_preference_div">
                        <div class="checkbox  checkbox-danger pull-left">
                            <input type="checkbox" name="class_preference[]" id="class_preference_1" value="1"
                                <?php echo set_checkbox_ext('class_preference', 1, '');?> required>
                            <label for="class_preference_1">Online</label>
                        </div>
                        <div class="checkbox  checkbox-danger pull-left" style="margin-top: 10px;margin-left: 20px;">
                            <input type="checkbox" name="class_preference[]" id="class_preference_2" value="2"
                                <?php echo set_checkbox_ext('class_preference', 2, '');?> required>
                            <label for="class_preference_2">Classroom</label>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <input type="submit" class=" btn-adhi" value="Submit" />
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .reg-note{font-size: 20px;text-transform: inherit;line-height: 32px;padding-bottom: 15px;}
    .alert{text-align: center;}
</style>