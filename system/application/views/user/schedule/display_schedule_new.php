<div class="floatleft">
      <div class="left_cntnr" style="position: relative;">
            <?php $this ->load->view('left_content_home.php');?>
    </div>
    <div class="right_cntnr">
        <div class="right_cntnr_bg_hd">
            <div class="sitepagehead"><h1>Schedules</h1></div>
        </div>
        <div class="right_cntnr_bg">
        	<?php 
        	$pt = '';
        	if($this->session->userdata('USERID') && $this->session->userdata('USERTYPE')=='N'){
        		$this->load->view('second_navigation');
        		$pt = 'style="padding-top:100px;"';
        	}
        	?>
                        <?php echo form_open("home/class_details", array('name'=>'classform','id' => 'classform'));
                            if(isset($arr_result) && !empty($arr_result)){?>
                                <!--<div class="clearboth paddingbottom">
                                    <input type="hidden" name="hdnSubregion" id="hdnSubregion" value="<?php if(isset($hdnSubregion)){ echo $hdnSubregion;}?>" />
                                    <input type="hidden" name="hdnDated" id="hdnDated" onchange="javascript:$('classform').submit();" value="<?php if(isset($dated)){ echo $dated;}?>" />
                                </div>
                                <div id="divClass">
                                    <div id="divImageHead">Today's Classes</div>
                                    <div class="clearboth"></div>
                                    <div id="divShowRelatedImage">
                                        <?php #$this->load->view('user/display_related_class');?>
                                    </div>
                                </div>-->
                        <?php
                            }?>
                            <script type="text/javascript">
                                var today_timeline = "<?php echo $today_timeline; ?>";
                                var parameter2     = "<?php echo date('j',strtotime('-8 hour')); ?>";
                                var parameter3     = "<?php echo date('n',strtotime('-8 hour')); ?>";
                                var parameter4     = "<?php echo date('Y',strtotime('-8 hour')); ?>";
                            </script>
                            <div class="filter_container" <?php echo $pt;?>>
                              <div class="filter_fields_cntnr">
                                    <div class="label_filter">
                                        <label class="filter_label"><img src="<?php echo $this->config->item('images').'region.png'?>" alt="Region" title="Region"  style="cursor:pointer" /></label>
                                    </div>
                                    <div class="floatleft" style="position:relative;top:5px;">
                                        <select class="styled" name="sltSearchRegion" id="sltSearchRegion"  onchange="javascript: fncGetSubregion('sltSearchRegion','sltSearchSubregion');" <?php if(isset($class_mode)){ echo 'disabled';}?> style="width:427px;line-height:52px;" > <!-- onchange="javascript: fncGetSubregion('sltSearchRegion','sltSearchSubregion');" -->
                                            <option value="0">Select</option>
                                            <?php
                                            if($regions){
                                                foreach ($regions as $data){
                                                    echo '<option value="'.$data->id.'"';if(isset($region_search) && $region_search==$data->id){echo 'selected';} echo '>'.$data->region_name.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="filter_fields_cntnr">
                                        <div class="label_filter">
                                            <label class="filter_label"><img src="<?php echo $this->config->item('images').'sub-region.png'?>" alt="Sub Region" title="Sub Region" style="cursor:pointer" /></label>
                                        </div>
                                        <div id="divSubregion" class="filter_subregion" style="position:relative;top:5px;">
                                            <select class="styled" name="sltSearchSubregion" id="sltSearchSubregion" <?php if(isset($class_mode)){ echo 'disabled';}?>  style="width:427px;line-height:52px;" onchange="javascript: fncDisplayDefaultList(<?php echo $today_timeline;?>,<?php echo date('j',strtotime('-8 hour'))?>,<?php echo date('n',strtotime('-8 hour'))?>,<?php echo date('Y',strtotime('-8 hour'))?>);"> <!-- onchange="javascript: fncDisplayDefaultList(<?php echo $today_timeline;?>,<?php echo date('j',strtotime('-8 hour'))?>,<?php echo date('n',strtotime('-8 hour'))?>,<?php echo date('Y',strtotime('-8 hour'))?>);" -->
                                                <option value="0">Select</option>
                                                <?php 
                                                if(isset($region_search) && isset($raw_subregion)){
                                                    foreach ($raw_subregion as $data){
                                                        if($data->regionid == $region_search){
                                                            echo '<option value="'.$data->id.'" ';if(isset($subregion_search) && $subregion_search==$data->id){echo 'selected';} echo ' >'.$data->sub_name.'</option>';
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                </div>

                                <div class="filter_fields_cntnr">
                                      <div class="label_filter">
                                           <label class="filter_label"><img src="<?php echo $this->config->item('images').'course.png'?>" alt="Course" title="Course" style="cursor:pointer" /></label>
                                      </div>
                                    <div class="floatleft" style="position:relative;top:5px;">
                                        <select class="styled" name="sltSearchCourse" id="sltSearchCourse" <?php if(isset($class_mode)){ echo 'disabled';}?>  style="width:427px;line-height:52px;"> <!--onchange="javascript: fncDisplayDefaultList(<?php echo $today_timeline;?>,<?php echo date('j',strtotime('-8 hour'))?>,<?php echo date('n',strtotime('-8 hour'))?>,<?php echo date('Y',strtotime('-8 hour'))?>);" -->
                                            <option value="0">Select</option>
                                            <?php
                                            if($course_list_all){
                                                foreach ($course_list_all as $data){
                                                    echo '<option style="background:url('.$this->config->item('sq_image_url').$crse_color[$data->id].'.png) no-repeat top right;" value="'.$data->id.'"';if(isset($course_search) && $course_search==$data->id){echo 'selected';} echo '>'.$data->course_name.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="filter_fields_cntnr">
                                        <div class="floatleft" id="chter_cnt" style="display:none;">
                                            <div class="label_filter">
                                                <label class="filter_label"><img src="<?php echo $this->config->item('images').'chapter.png'?>" style="cursor:pointer" /></label>
                                            </div>
                                            <div class="floatleft" style="position:relative;top:5px;">
                                    <select class="styled" name="sltSearchChp" id="sltSearchChp" <?php if(isset($class_mode)){ echo 'disabled';}?>  style="width:427px;"> <!-- onchange="javascript: fncDisplayDefaultList(<?php echo $today_timeline;?>,<?php echo date('j',strtotime('-8 hour'))?>,<?php echo date('n',strtotime('-8 hour'))?>,<?php echo date('Y',strtotime('-8 hour'))?>);" -->
                                        <option value="0">Select</option>
                                        <?php
                                        if($chp_list){
                                            for($i=1;$i<=count($chp_list);$i++){
                                                echo '<option value="'.$i.'"';if(isset($chp_search) && $chp_search==$i){echo 'selected';} echo '>'.$chp_list[$i].'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                   </div>

                                   </div>
                                </div>
                            </div>
                            <div class="clearboth"></div>
                            <div id="divUserCalendarnw" class="admininnercontentdiv">
								<?php $this->load->view('user/schedule/schedule_calendar');?>
                            </div>
                            <input type="hidden" name="hdnTimeline" id="hdnTimeline" value="<?php echo $today_timeline;?>" />
                        <?php echo form_close();
                        $content  		 	= "var content = ".$json_array.";";
                        $content  		 	.= "fncDisplayDefaultList(".$today_timeline.",".date('j',strtotime('-8 hour')).",".date('n',strtotime('-8 hour')).",".date('Y',strtotime('-8 hour')).");";
                        $script_encoded  	= fncEncodeJavascript($content);

                        ?>

  </div>
 </div>
</div>



<script type="text/javascript" language="javascript">
	<?php echo $script_encoded;	?>
</script>
<script>
function show_class(urls,id,hddate){
    var url = urls;
	var pars = '';
	pars += 'masterid=' + id;
	pars += '&currentdate=' + escape(hddate);
        
	var myAjax = new Ajax.Request(
		url,
		{
			method: 'post',
			parameters: pars,
			onComplete: getMessageResponse
		});


function getMessageResponse(originalRequest)
{   
    $('relatedclass').show();
        $('rel').innerHTML=originalRequest.responseText;
	 
}

    $('hdnMasterid').value=id;
     //$('hdnDated').value=hddate;
     $('relatedclass').show();

	}



	function popup_close(id){
		$('relatedclass').hide();
	}
</script>

<style type="text/css">
        body {
        font-family: Arial, Helvetica, sans-serif;
        text-align: left;
        padding: 0px;
        margin-top:0px;
        background:url(<?php echo base_url().'images/bg_01.jpg'?>) #000000 no-repeat center top;
        height:auto;
        }

         .select {
            position: absolute;
            top:2px;
            left: 2px;
            line-height:55px;
            width: 426px; /* With the padding included, the width is 300 pixels: the actual width of the image. */
            height: 42px;
            padding:18px 1px 1px 10px;
            color: #000000;
            font: 13px/21px arial,sans-serif;
            background:url(<?php echo base_url().'images/inputselect_big.png'?>)  no-repeat center top;
            overflow: hidden;
            font-weight:bold;
         }
        select {
            background:#6D6D6D none repeat scroll 0 0;
            border:0 none;
            color:#000;
            font-weight:bold;
            float:left;
            height:52px;
            margin-left:6px;
            margin-top:5px;
            width:290px;
        }

</style>