var check = 1;
function sendFromJs(){
    window.location="mailto:Info@ADHISchools.com";
}
var browser = "";					// this is here to create the dots for picture navigation using the css for 'fancymenu'
var Play = true;
jQuery.noConflict();

function __fnctwitteryoutubewindow(id){
url	= base_url+'home/twitter_youtubevideo/'+id;
window.open(url,"","width=580, height=335, left=45, top=15, scrollbars=yes, menubar=no,resizable=no,directories=no,location=no");
}


function show_twtvideo(id){
$('twtvideo'+id).show();
}
function twtr_popup_close(id){
$('twtvideo'+id).hide();
}

function is_valid_email(value){
    return /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(value);
}
jQuery(document).ready(function() {
jQuery('#license_info_form').submit(function(event) {
    
event.preventDefault();

if(check == 1){
        var warning  = '';

        if(jQuery('#licencee_name').val()==undefined || jQuery('#licencee_name').val()=='')
            warning += 'The Name field is required.' + "\n";

        if(jQuery('#licencee_email').val()==undefined || jQuery('#licencee_email').val()=='')
            warning += 'The Email field is required.' + "\n";
        else if (!is_valid_email(jQuery('#licencee_email').val()))
            warning += 'The Email given is not valid.' + "\n";

        if(jQuery('#math_captcha').val()==undefined || jQuery('#math_captcha').val()=='')
            warning += 'The Captcha field is required.' + "\n";
        if(warning !=''){
            jQuery('.valid_msgs').text(warning).addClass('error_msg');
        }
        else
        {
            check = 0;
            var remove = '';
            var first = 0;
            if(jQuery('.valid_msgs').hasClass('success_msg')){
                remove = 'success_msg';
                first = 1;
            } 
            if(jQuery('.valid_msgs').hasClass('error_msg')){
                
                if(first == 1){
                    remove = ' error_msg';
                } else{
                    remove = 'error_msg';
                }
                
            }
            
            
            jQuery('.valid_msgs').removeClass(remove);
            //jQuery('.valid_msgs').removeClass(remove).html('Please wait...');
            $('guest_pass_no_popup').style.opacity     = "0.5";
            $('loader_enquiry').style.display     = "block";
            jQuery.post(base_url+'index.php/home/real_estate_license_info',jQuery('#license_info_form').serialize(), function(resp) {
            $('loader_enquiry').style.display     = "none";    
            $('guest_pass_no_popup').style.opacity     = "1";
                if(resp.status !=200){
                    jQuery('.valid_msgs').removeClass('success_msg').addClass('error_msg').html(resp.msg);
                    jQuery('#math_captcha').val('');
                }
                else {
                    jQuery('#math_captcha,#licencee_name,#licencee_email,#licencee_phone').val('');
                    jQuery('.valid_msgs').removeClass('error_msg').addClass('success_msg').html(resp.msg);
                }
            jQuery('#captcha_question').html(resp.math_captcha_question.image);
            check = 1;
            });
        }
}
return false;
});

jQuery('#license_info_form_popup').submit(function(event) {

event.preventDefault();
if(check == 1){
        var warning  = '';
        if(jQuery('#licencee_name_popup').val()==undefined || jQuery('#licencee_name_popup').val()=='')
            warning += 'The Name field is required.' + "<br>";

        if(jQuery('#licencee_email_popup').val()==undefined || jQuery('#licencee_email_popup').val()=='')
            warning += 'The Email field is required.' + "<br>";
        else if (!is_valid_email(jQuery('#licencee_email_popup').val()))
            warning += 'The Email given is not valid.' + "<br>";

        if(jQuery('#math_captcha_popup').val()==undefined || jQuery('#math_captcha_popup').val()=='')
            warning += 'The Captcha field is required.' + "<br>";
        if(warning !=''){
            jQuery('.valid_msgs_popup').html(warning + "<br>").addClass('error_msg');
        }
        else
        {
            check = 0;
            var remove_pop = '';
            var first_pop = 0;
            if(jQuery('.valid_msgs_popup').hasClass('success_msg')){
                remove_pop = 'success_msg';
                first_pop = 1;
            } 
            if(jQuery('.valid_msgs_popup').hasClass('error_msg')){
                
                if(first_pop == 1){
                    remove_pop = ' error_msg';
                } else{
                    remove_pop = 'error_msg';
                }
                
            }
            
            
            jQuery('.valid_msgs_popup').removeClass(remove_pop);
            // jQuery('.valid_msgs_popup').removeClass(remove_pop).html('Please wait...');
            $('guest_pass_popup').style.opacity         = "0.8";
            $('loader_enquiry_popup').style.display     = "block";
           
            jQuery.post(base_url+'index.php/home/real_estate_license_info?'+randomNumberCaptcha(1000, 2222222222222222),jQuery('#license_info_form_popup').serialize(), function(resp) {
                
            $('loader_enquiry_popup').style.display     = "none";    
            $('guest_pass_popup').style.opacity         = "1";
            
                if(resp.status !=200){
                    jQuery('.valid_msgs_popup').removeClass('success_msg').addClass('error_msg').html(resp.msg);
                    jQuery('#captcha_question_popup').html(resp.math_captcha_question_popup.image);
                    jQuery('#math_captcha_popup,#licencee_name_popup,#licencee_email_popup,#licencee_phone_popup').val('');
                }
                else {
                    jQuery('.valid_msgs_popup').removeClass('error_msg').addClass('success_msg').html(resp.msg);
                    jQuery('#captcha_question_popup').html(resp.math_captcha_question_popup.image);
                    setcookie('popup',0,1);
                    setTimeout(function(){ jQuery('.overlay-bg, .overlay-content').hide(); }, 7000);
                }
            check = 1;    

            });
        }
}
return false;
});


new Ajax.Request(
		base_url+'home/load_blog_post',
	    { 
	    	method: "get",
	        onSuccess: function (obj){$('blog_post_wrapper').innerHTML=obj.responseText;},
	        onFailure: function (){$('blog_post_wrapper').innerHTML='Loading error';}
		});

new Ajax.Request(
		base_url+'home/load_tweets',
	    { 
	    	method: "get",
	        onSuccess: function (obj){$('tweets_wrapper').innerHTML=obj.responseText;},
	        onFailure: function (){$('tweets_wrapper').innerHTML='Loading error';}
		});
});
(function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id)) {return;}
                    js = d.createElement(s);js.id = id;
                    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));


//youtube video api

function initYoutubeVideo(){
	// 2. This code loads the IFrame Player API code asynchronously.
	var tag = document.createElement('script');
	
	tag.src = "https://www.youtube.com/iframe_api";
	var firstScriptTag = document.getElementsByTagName('script')[0];
	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

// 3. This function creates an <iframe> (and YouTube player)
//    after the API code downloads.
var player;
function onYouTubeIframeAPIReady() {
	player = new YT.Player('youtuve_vid', {
	height: '268',
	width: '435',
	videoId: 'uqGcHnn_Dgk',
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

 function randomNumberCaptcha(min, max) {
    return Math.floor(Math.random() * (max - min + 1) + min);
};

function setcookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}