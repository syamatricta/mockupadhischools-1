<?php page_heading('Classroom' , 'banner-inner'); ?>
<div class="divide40"></div>
<div class="container margin40">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="row" id="show-videos-wrapper">
			<div class="col-md-12">
				<div id="chapter-title" class="heading_band margin10"><?php echo $chapter_title;?></div>	
			</div>
			<?php if(!empty($video)):?>
		            <div class="row" id="show-videos">
					<?php $file_path = $this->config->item('quiz_video_location') . trim($video->video);?>
						<div class="col-sm-8 col-sm-offset-2">
							<video width="100%"  controls="controls">
                                                            <source src="<?php echo $file_path ?>" type="video/mp4">
                                                            Your browser does not support the video tag.
							</video> 
						</div>
						<div class="col-sm-8 col-sm-offset-2">
							<?php echo nl2br($video->desc); ?>
						</div>
					</div>
	        <?php else: ?>
                        <div class="col-md-12 page_error" style="padding-top: 20px;"><center>No videos for this chapter</center></div>
           	<?php endif;?>
		</div>
	</div>
</div>