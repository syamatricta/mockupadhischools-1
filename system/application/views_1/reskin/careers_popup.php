<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?php echo (isset($contentdetails->company_name))?$contentdetails->company_name:''; ?></h4>
        </div>
        <div class="modal-body">
        	<div class="row">
        		<div class="col-md-6">
        			<?php if(isset($contentdetails->image_name)) {?><img src="<?php echo $this->config->item('image_uploadbp_url').$contentdetails->image_name;?>" width="201"  height="135"> <?php  } ?>
        			<span class="row">
        				<span class="col-md-5">Company name </span>
        				<span class="col-md-7">:&nbsp;<?php echo (isset($contentdetails->company_name))?$contentdetails->company_name:''; ?></span>
        			</span>
        			<span class="row">
        				<span class="col-md-5">Address</span>
        				<span class="col-md-7">:&nbsp;<?php print(isset($contentdetails->address))?$contentdetails->address:''; ?></span>
        			</span>
        			<span class="row">
        				<span class="col-md-5">Hiring Contact</span>
        				<span class="col-md-7">:&nbsp;<?php echo (isset($contentdetails->hiring_contact_name))?$contentdetails->hiring_contact_name:''; ?></span>
        			</span>
        			<span class="row">
        				<span class="col-md-5">Phone number</span>
        				<span class="col-md-7">:&nbsp;<?php echo (isset($contentdetails->phone_number))?$contentdetails->phone_number:''; ?></span>
        			</span>
        			<span class="row">
        				<span class="col-md-5">Company Information</span>
        				<span class="col-md-7">:&nbsp;<?php print(isset($contentdetails->company_information))?$contentdetails->company_information:''; ?></span>
        			</span>
        		</div>
        		<div class="col-md-6">
        			<div id="youtube_vid"></div>
                     <?php if(isset($contentdetails->yt_video)) {?>                            
                        <input type="hidden" id="yt_video_id" />
                        <script>$('#yt_video_id').val(get_youtube_id('<?php echo $contentdetails->yt_video;?>'));initYoutubeVideo();once_played=true;</script>
                     <?php }?>
        		</div>
        	</div>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>            
        </div>
    </div><!-- /.modal-content -->
</div>

