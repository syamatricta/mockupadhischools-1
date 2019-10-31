/**
 * Function to play the videos
 */
;
function viewVideo(videoLink,playerpath) {
   
    jw_player.setup({
        flashplayer: playerpath,
        file: videoLink,
        width: 600,
        height: 350,
        autostart: true
    });
    jw_player.load();
}

