<div id="video-player" class="" style="margin:10px 0;">
<?php if(isset($video) && '' != $video){?>
    <?php $file_path = $this->config->item('quiz_video_location') . trim($video);?>
    <div id='classroom-video_<?php echo $chapter_id;?>'  ></div>
    <!-- loading player -->
    <script type="text/javascript">
        jwplayer("classroom-video_<?php echo $chapter_id;?>").setup({
                //autostart: true,
                width: 400,
                flashplayer: "<?php echo base_url()?>/js/jwplayer/player.swf?file=<?php echo $file_path; ?>",
                file: "<?php echo $file_path; ?>"

        });
    </script>

<?php }else{?>
<b>No Classroom video found for this Quiz</b>
<?php } ?>
</div>
