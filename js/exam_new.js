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
            alert('We have detected that you are using popup blocker.\n Please disable the pop up blocker to Start Examination.');
            
        }
        else {
            loginWindow.close();
        }
    }, 1000);
} else {
Event.observe(window, "load", check_popup_status, !1); 
/*; Event.observe(window,"load",check_popup_status,!1);function check_popup_status(){var a=!0,b=window.open();parent.window.focus();b?(a=!1,b.close()):a=!0;a&&alert("We have detected that you are using popup blocker.\n Please disable the pop up blocker to Start Examination.");a?$("popup_blocked_status").value=1:$("popup_blocked_status").value=0;""!=$("poptry").value&&1==parseInt($("poptry").value)&&exam_rule_start()};*/
}

function check_popup_status() {
    var a = !0,
        b = window.open();
    parent.window.focus();
    b ? (a = !1, b.close()) : a = !0;
    a && alert("We have detected that you are using popup blocker.\n Please disable the pop up blocker to Start Examination.");
    a ? $("popup_blocked_status").value = 1 : $("popup_blocked_status").value = 0;
    "" != $("poptry").value && 1 == parseInt($("poptry").value) && exam_rule_start()
}