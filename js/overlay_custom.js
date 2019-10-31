; jQuery(document).ready(function(a){
    // show popup when you click on the link
    
    a('.show-popup').click(function(event){
        event.preventDefault(); // disable normal link function so that it doesn't refresh the page
        var docHeight = a(document).height(); //grab the height of the page
        var scrollTop = a(window).scrollTop(); //grab the px value from the top of the page to where you're scrolling
        var selectedPopup = 1; //a(this).attr('showpopup'); //get the corresponding popup to show
        
       a('.overlay-bg').show().css({'height' : docHeight}); //display your popup background and set height to the page height
       a('.ppopup'+selectedPopup).show().css({'top': scrollTop+20+'px'}); //show the appropriate popup and set the content 20px from the window top
    });
  
    // hide popup when user clicks on close button or if user clicks anywhere outside the container
    a('.my_popup_close, .overlay-bg').click(function(){ 
        a('.overlay-bg, .overlay-content').hide(); // hide the overlay
        setcookie('popup',0,1);
    });
    
    // hide the popup when user presses the esc key
    a(document).keyup(function(e) {
        if (e.keyCode == 27) { // if user presses esc key
            a('.overlay-bg, .overlay-content').hide(); //hide the overlay
            setcookie('popup',0,1);
        }
    });
   a(window).scroll(function(e) { 
       var hide_popup = getCookie('popup');
       
       if(hide_popup == ""){
           var scrollTop = a(window).scrollTop();
           var selectedPopup = 1;
           a('.ppopup'+selectedPopup).show().css({'top': scrollTop+20+'px'});
       }
    });
    
     a('.show-popup').trigger("click");
     
     function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for(var i=0; i<ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1);
                if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
            }
            return "";
    }
    
    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    }
     
});

