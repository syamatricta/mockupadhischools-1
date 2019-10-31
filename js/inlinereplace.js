;function change_bg(id)
{
	
    var closed = 'url("'+base_url+'images/career/ar01.png")';
    var opened = 'url("'+base_url+'images/career/ar02.png")';    
    $$(".accordion-toggle").each(function(elmt) { elmt.setStyle({'backgroundImage':closed}) });  
    var current_bg = $(id).getStyle('backgroundImage'); 
    if(current_bg == closed)
    {
        $(id).setStyle({'backgroundImage':opened}); 
    }    
     
}



//youtube video api

function initYoutubeVideo(){
    if(once_played){
        onYouTubeIframeAPIReady();
    }else{
	// 2. This code loads the IFrame Player API code asynchronously.
	var tag = document.createElement('script');
	
	tag.src = "https://www.youtube.com/iframe_api";
	var firstScriptTag = document.getElementsByTagName('script')[0];
	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    }
}

// 3. This function creates an <iframe> (and YouTube player)
//    after the API code downloads.
var player;
function onYouTubeIframeAPIReady() {    
    player = new YT.Player('youtube_vid', {
        height: '220',
        width: '320',
        videoId: $('yt_video_id').value,
        playerVars: {
            //controls: 0,
            showinfo: 0 ,
            modestbranding: 1,
            wmode: "opaque",
            html5: 1
        },
        events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
        }
    });
}

// 4. The API will call this function when the video player is ready.
function onPlayerReady(event) {
	//event.target.playVideo();
}

// 5. The API calls this function when the player's state changes.
//    The function indicates that when playing a video (state=1),
//    the player should play for six seconds and then stop.
var done = false;
function onPlayerStateChange(event) {
	/*if (event.data == YT.PlayerState.PLAYING && !done) {
	  setTimeout(stopVideo, 6000);
	  done = true;
	}*/
}
function stopVideo() {
	player.stopVideo();
}

function get_youtube_id(url){
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
    var match = url.match(regExp);
    if (match&&match[7].length==11){        
        return match[7];
    }
}
var once_played = false;