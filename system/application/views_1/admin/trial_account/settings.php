<?php echo form_open('admin_trial_account/settings'); ?>
<div class="adminmainlist">
	<div class="adminpagebanner">
            <div class="adminpagetitle"><?php echo $title?></div>
	</div> 
        <?php /*end of  adminpagebanner */?>
	
	<div class="admininnercontentdiv">
		<div class="page_error" id="errordisplay"></div>
		<div  class="page_error" id="flasherror"><?php echo $this->session->flashdata("error"); ?></div>
		<div  class="page_success" id="flashsuccess"><?php echo $this->session->flashdata("success");   ?></div>
		<?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
		<div class="listdata">
			<div class="leftsideheadings_view">Trail Account Validity</div>
			<div class="middlecolon">:</div>
			<div class="rightsidedata_view">
                            <select name="validity" id="validity">
                                <?php for($i=1; $i<=100;$i++){?> 
                                    <option value="<?php echo $i;?>" <?php echo ($i == $settings->validity_days) ? 'selected="selected"' : ''; ?>><?php echo $i;?></option>
                                <?php }?>
                            </select>    
                            &nbsp; Days
                        </div>
			<div class="clearboth"></div>
			<div class="leftsideheadings_view">Quiz</div>
			<div class="middlecolon">:</div>
                        <div class="rightsidedata_view">
                            <div class="floatleft" style="margin-right: 10px;">
                                <span>Course</span><br>
                                <select name="course" id="course" onchange = "ajax_load_chapters();" style="margin-top: 3px;">
                                        <option value="">--Select Course--</option>
                                        <?php foreach($courses as $course): ?>
                                                <option value="<?php echo $course->id?>" <?php echo ($course_id ===  $course->id) ? "SELECTED" : "" ?>><?php echo $course->course_name?></option>
                                        <?php endforeach;?>
                                </select>
                            </div>
                            <div class="floatleft" style="margin-right: 10px;">
                                <span>Edition</span><br>
                                <select name="edition" id="edition" onchange = "ajax_load_edition_chapters();" style="width:120px;margin-top: 3px;">
                                    <option value="">--Select Edition--</option>
                                    <?php 
                                            $edition_id_new = ($this->input->post('edition')) ? $this->input->post('edition') : $edition_id;
                                            if(isset($editions)):
                                                    foreach($editions as $edition): 
                                    ?>
                                            <option value="<?php echo $edition['id']; ?>" <?php echo ($edition_id_new ===  $edition['id']) ? "SELECTED" : "" ?>><?php echo $edition['edition_no']; ?></option>
                                    <?php
                                                    endforeach; 
                                            endif;
                                    ?>
                                </select>
                            </div>
                            <div class="floatleft">
                                <span>Chapter</span><br>
                                <select name="chapter" id="chapter" onchange="view_video()" style="margin-top: 3px;">
                                    <option value="">--Select Chapter--</option>
                                        <?php 
                                                if(isset($chapters)):
                                                        foreach($chapters as $chapter): 
                                        ?>
                                                <option value="<?php echo $chapter->id; ?>" <?php echo ($chapter_id ===  $chapter->id) ? "SELECTED" : "" ?>><?php echo $chapter->quiz_name; ?></option>
                                        <?php
                                                        endforeach; 
                                                endif;
                                        ?>
                                </select>
                            </div>
                            <?php  $this->load->view('admin/trial_account/_video');?>
                        </div>
			
			<div class="leftsideheadings_view">&nbsp;</div>
			<div class="middlecolon">&nbsp;</div>
                        <div class="rightsidedata_view"><input type="submit" name="butUpdate" value="Update" /></div>
			</div> <?php /* end of listdata */?>
		</div> <?php /* end of admininnercontentdiv */?>
	
</div> <?php /* end of adminmainlist */ ?>
<?php echo form_close();?>
<style>
.leftsideheadings_view{width:15%;}    
.rightsidedata_view{width:75%;}   
#video-player{width:100%;float:left;}   
</style>
