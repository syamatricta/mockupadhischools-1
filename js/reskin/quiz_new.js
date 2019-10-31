var isOpera = !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
    // Opera 8.0+ (UA detection to detect Blink/v8-powered Opera)
var isFirefox = typeof InstallTrigger !== 'undefined';   // Firefox 1.0+
var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
    // At least Safari 3+: "[object HTMLElementConstructor]"
var isChrome = !!window.chrome && !isOpera; 
if(isChrome) {
    loginWindow = window.open("about:blank", '_blank',"width=100,height=100");

    setTimeout(function () {
        if (!loginWindow || loginWindow.closed || typeof loginWindow.closed == 'undefined' || parseInt(loginWindow.outerWidth) == 0) {
           // alert('We have detected that you are using popup blocker.\n Please disable the pop up blocker to access quiz.');
            $('#quizerror').modal({keyboard: true}) 
        }
        else {
            loginWindow.close();
        }
    }, 1000);
     //Event.observe(window, "load", check_popup_status, !1); 
    $( document ).ready(function() {
	   check_popup_status();
	})
} else {
	$( document ).ready(function() {
	   check_popup_status()
	})
   // Event.observe(window, "load", , !1); 
}

function check_popup_status() {
    var a = !0,
        b = window.open();
    parent.window.focus();
    b ? (a = !1, b.close()) : a = !0;
    
     a && $('#quizerror').modal({keyboard: true}) ;
    //a && alert("We have detected that you are using popup blocker.\n Please disable the pop up blocker to access quiz.");
    a ? $("#popup_blocked_status").val(1) : $("#popup_blocked_status").val(0);
    "" != $("#poptry").val() && 1 == parseInt($("#poptry").val()) && quiz_rule()
};
function quiz_rule() {
    if($('#popup_blocked_status').val() != '' && parseInt($('#popup_blocked_status').val()) == 0) {     
		$('#hide_strt_btn').html('<img src="'+base_url+'images/spinner.gif">') ; 
		ajax_quiz_mode();
	}
}
function ajax_quiz_mode(a, b) {    
    var mode_url = ($('#user_type').length > 0 && 'trial' == $('#user_type').val()) ? 'trial_quiz/change_quizmode' : 'quiz/change_quizmode';
    $.ajax({
        type: "POST",
        url: base_url + mode_url,
        dataType: 'json',
        data : {},
        cache: false, 
        success:function(data){	
        	check_quiz_status(data)                 
        }
        
	})
}

function check_quiz_status(a) {
    var screenW = 1400, screenH = 800;
    if (parseInt(navigator.appVersion)>3) {
     screenW = screen.width;
     screenH = screen.height-100;
    }
    else if (navigator.appName == "Netscape" 
        && parseInt(navigator.appVersion)==3
        && navigator.javaEnabled()
       ) 
    {
     var jToolkit = java.awt.Toolkit.getDefaultToolkit();
     var jScreenSize = jToolkit.getScreenSize();
     screenW = jScreenSize.width;
     screenH = jScreenSize.height-100;
    }
    var quiz_url = ($('#user_type').length > 0 && 'trial' == $('#user_type').val()) ? 'trial_quiz/quiz_start' : 'quiz/quiz_start';
    
   $('#hide_strt_btn').html('');
    "false" == a.responseText ? alert("You are allowed to take only one quiz at a time") : (url = base_url + quiz_url, a = document.createElement("form"), a.setAttribute("method", "post"), a.setAttribute("action", url), a.setAttribute("target", "formresult"), document.body.appendChild(a), window.open("", "formresult", "scrollbars=yes,menubar=no,height="+screenH+",width="+screenW+",resizable=no,toolbar=no,status=no,location=no"), a.submit())
}

/*; Event.observe(window,"load",check_popup_status,!1);function check_popup_status(){var a=!0,b=window.open();parent.window.focus();b?(a=!1,b.close()):a=!0;a&&alert("We have detected that you are using popup blocker.\n Please disable the pop up blocker to access quiz.");a?$("popup_blocked_status").value=1:$("popup_blocked_status").value=0;""!=$("poptry").value&&1==parseInt($("poptry").value)&&quiz_rule()};*/