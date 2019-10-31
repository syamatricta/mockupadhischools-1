<form name="addFlyerForm" id="addFlyerForm" method="post" action="">
    <div class="adminmainlist">
        <div class="adminpagebanner">
            <div class="adminpagetitle"><?php echo $head; ?></div>
        </div>
        <div class="clearboth"></div>
        <div class="admininnercontentdiv">
            <div class="page_error" id="errordisplay"></div>
            <div  class="page_error" id="errordiv" ><?php if(isset($msg)) echo $msg; ?></div>
            <div  class="page_success" id="flashsuccess"><?php if(isset($msgs)) echo $msgs;   ?></div>
            <?php if (validation_errors ()) : echo '<div class="page_error">'.validation_errors ().'</div>'; endif;?>
            <div class="clearboth"></div>
            <div class="listdata">
                <div class="clearboth">&nbsp;</div>
                <div class="leftsideheadings_view padding_r">File Title:<span class="red_star">*</span></div>
                <div class="middlecolon">&nbsp;</div>
                <div class="rightsidedata_view">
                    <?php 
                    $sel_title = (isset($_POST['title'])) ? $_POST['title'] : '';
                    $sel_title = ('' == $sel_title && array_key_exists("title", $flyer))  ?  $flyer['title'] : $sel_title;
                    ?>
                    <input type="text" name="title" id="title" class="textwidth" style="width:250px;"  
                        maxlength="128"  
                        value="<?php echo $sel_title; ?>"/></div>
                <div class="clearboth"></div>
                <hr class="spl_hr"/>
                <div class="clearboth divide10"></div>
                <div><h3>PDF Contents</h3></div>
                <div class="clearboth divide20"></div>
                <div>Select header image<span class="red_star">*</span></div>
                <div class="clearboth divide10"></div>
                <div class="clearboth"></div>
                <div class="flyer_selection">
                    <?php
                        $sel_head_image = (isset($_POST['head_image'])) ? $_POST['head_image'] : '';
                        $sel_head_image = array_key_exists("head_image", $flyer) ? $flyer['head_image'] : $sel_head_image;
                        
                        foreach($flyer_heading_images as $image){
                           ?>
                            <div class="flyer_item">
                                <div class="fi_input"><input type="radio" value ="<?php echo $image->id;?>" <?php echo ($image->id == $sel_head_image) ? 'checked' : '';?> name="head_image" /></div>
                                <div class="fi_image"><img width="150" src="<?php echo $this->config->item('image_url').'pdf/head/'.$image->file_name;?>"/></div>
                                <div class="fi_title"><?php echo $image->name;?></div>
                            </div>
                           <?php
                        }
                    ?>
                </div>
                <div class="clearboth"></div>
                <div class="leftsideheadings_view padding_r">Heading :<span class="red_star">*</span></div>
                <div class="middlecolon">&nbsp;</div>
                <div class="rightsidedata_view"><input  type="text" name="heading" id="heading" class="flyer_input textwidth"   maxlength="80"  value="<?php echo array_key_exists("heading", $flyer)  ?  $flyer['heading'] : set_value('heading'); ?>"/></div>
                <div class="clearboth"></div>

                <div class="leftsideheadings_view padding_r">Sub Heading :<span class="red_star">*</span></div>
                <div class="middlecolon">&nbsp;</div>
                <div class="rightsidedata_view"><input type="text" name="sub_heading" id="sub_heading"  class="textwidth flyer_input fli_small" maxlength="180" value="<?php echo array_key_exists("sub_heading", $flyer)  ?  $flyer['sub_heading'] : set_value('sub_heading'); ?>"/></div>
                <div class="clearboth"></div>

                <div class="leftsideheadings_view padding_r">Date & Time :<span class="red_star">*</span></div>
                <div class="middlecolon">&nbsp;</div>
                <div class="rightsidedata_view">
                    <div class="floatleft">
                        <input type="text" class="flyer_input fli_med" name="date" id="date"  value="<?php if(isset($_POST['date'])){echo $_POST['date'];}else if(array_key_exists("date_time", $flyer)){echo formatDate($flyer['date_time']);}?>" size="10" readonly/>
                        <img src="<?php  echo $this->config->item('images');?>calendar.gif" height="25" style="margin-bottom:-5px;"  onclick="displayCalendar(document.addFlyerForm.date,'mm/dd/yyyy',this)"/>
                    </div>
                    <div class="floatleft" style="margin-left:10px;margin-top: 3px;">
                        <select id="hr" name="hr" class="fly_select"> 
				<?php 
				$time_hour = range(1, 12);
                                $sel_hour   = (isset($_POST['hr'])) ? $_POST['hr'] : '';
                                $sel_hour   = ('' == $sel_hour && array_key_exists("date_time", $flyer)) ? date('h', strtotime($flyer['date_time'])) : $sel_hour;
                                
				foreach ($time_hour as $num) {
                                    $number = sprintf('%02d',$num);
                                    $selected = ($sel_hour == $number) ? 'selected' : '';
				    echo '<option value="'.$number.'" '.$selected.'> '.$number.'</option>';
				}?>
				
			</select>
			<select id="min" name="min" class="fly_select"> 
				<?php 
				$time_mts = range(0, 55, 5);
                                $sel_min   = (isset($_POST['min'])) ? $_POST['min'] : '';
                                $sel_min   = ('' == $sel_min && array_key_exists("date_time", $flyer)) ? date('i', strtotime($flyer['date_time'])) : $sel_min;
				foreach ($time_mts as $num) {
                                    $number = sprintf('%02d',$num);
                                    $selected = ($sel_min == $number) ? 'selected' : '';
				    echo '<option value="'.$number.'" '.$selected.'> '.$number.'</option>';
				}?>
				
			</select>
                        <?php 
                        $sel_merdian   = (isset($_POST['ap'])) ? $_POST['ap'] : '';
                        $sel_merdian   = (array_key_exists("date_time", $flyer)) ? date('A', strtotime($flyer['date_time'])) : $sel_merdian;
                        ?>
			<select name="ap" id="ap" class="fly_select">
				<option value="AM" <?php echo ('AM' == $sel_merdian) ? 'selected' : '';?>>AM</option>
				<option value="PM"<?php echo ('PM' == $sel_merdian) ? 'selected' : '';?>>PM</option>
			</select>
                        
                        
                    </div>                    
                </div>
                <div class="clearboth"></div>
                
                <div class="clearboth divide10"></div>
                
                <div class="leftsideheadings_view padding_r">&nbsp;</div>
                <div class="middlecolon">&nbsp;</div>
                <div class="rightsidedata_view"><input class="btn red fly_submit" type="button" value="<?php echo $btn; ?>" onclick ="javascript : fncSaveFlyer(<?php echo (!$is_edit) ?  0 : $flyer_id; ?>)" ></div>
                <div class="clearboth"></div>
                
                <div class="clearboth divide10"></div>
                
                <div class="row padding_l">
                    <div class="backtolist"><?php echo anchor('admin_flyer/list_flyers','<< Back to Flyer list')?></div>
                </div>
                
                
                
            </div>
            <div class="register_instructionmark" style="padding-right:10px; margin-right: 142px;"><span class="instruction">Marked with </span><span class="red_star">*</span> <span class="instruction">are mandatory fields</span></div>
            <div class="clearboth">&nbsp;</div>
        </div>
    </div>
</form>



<style>
    .leftsideheadings_view{width:15%;}
    .rightsidedata_view{width:70%;}
</style>
