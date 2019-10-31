<div class="floatleft">
      <div class="left_cntnr" style="position: relative;">
            <?php $this ->load->view('left_content_home.php');?>
    </div>
    <div class="right_cntnr">
        <div class="right_cntnr_bg_hd">
            <div class="sitepagehead"><h1>Meet our staff</h1></div>
        </div>
        <div class="right_cntnr_bg">
                <div id="sitepagemain">
                     <?php if(count($pagedetails)>0){?>
                            <div class="meetstaffcontent">
                            	<div><?php print($pagedetails->content); ?></div>
                            	<div class="cb"></div>
                            	<div class="stafflistmain">
                            		<?php 
                            		foreach($staffs as $staff){?>
                            			<div class="staffmain">
	                            			<div class="staffname"><a style="color:#A3A3A3; text-decoration:none;"href="javascript:void(0)" onclick="javascript:show_staff(<?php echo $staff->id; ?>); return false;"><?php echo substr($staff->name,0,20); ?></a></div>
	                            			<div class="cb"></div>
	                            			<div class="staffimage">
	                            				<a href="javascript:void(0)" onclick="javascript:show_staff(<?php echo $staff->id; ?>); return false;"><img  border="0" src="<?php echo $this->config->item('staff_image_upload_url').'thumb_large_'.$staff->photo; ?>" alt="<?php echo $staff->name; ?>" title="<?php echo $staff->name; ?>" /></a>
	                            			</div>
	                            			<?php /* popup starts */ ?>
	                            			<div style="width:720px;left:510px; top:280px; display: none;" id="meetstaff_<?php echo $staff->id; ?>">
												<?php  echo popup_box_top($staff->id);?>
													<div class="popup_content_main">
														<div class="popup_content_name"><?php echo $staff->name; ?></div>
														<div class="cb"></div>
														<div class="popup_content_image"><img src="<?php echo $this->config->item('staff_image_upload_url').'thumb_large_'.$staff->photo; ?>" alt="<?php echo $staff->name; ?>" title="<?php echo $staff->name; ?>" /></div>
														<div class="popup_desc"><?php echo $staff->description?></div>
													</div>
												<?php echo popup_box_bottom();?>
												
												<style type="text/css">
	                            					#meetstaff_<?php echo $staff->id; ?> {
														position:absolute;
														width:600px;
														z-index:1001;
													}
		                            			</style>
											</div>
											<?php /* popup ends */ ?>
                            			</div>
                            		<?php }
                            		?>
                            		
                            	</div>
                            </div>
                    <?php } ?>
                </div>
           </div>
    </div>
 </div>


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

<script>
	function show_staff(id){
		$('meetstaff_'+id).show();
	}
	function popup_close(id){
		$('meetstaff_'+id).hide();
	}
</script>