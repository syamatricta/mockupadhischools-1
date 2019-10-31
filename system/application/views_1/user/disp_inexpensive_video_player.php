<?php
/**
 * Partial view to render video player
 * Arguments
 * @param integer video_id, if not set treat it as empty
 * @param string $file_path, path to the file
 *
 */

	$video_id = (isset($video_id)) ? $video_id : '0';
	$player_path = base_url() . 'js/jwplayer/player.swf';
?>

<!--<video id='classroom-video_<?php echo $video_id;?>' src="<?php echo $video_path; ?>" ></video>-->
<div id='video_<?php echo $video_id;?>'  ></div>

<!-- loading player -->
<script type="text/javascript">
	var jw_player = jwplayer("video_<?php echo $video_id;?>").setup({
		autostart: true,
		width: 600,
                height: 350,
		flashplayer: "<?php echo $player_path; ?>",
		file: "<?php echo $video_path; ?>"
	});
</script>