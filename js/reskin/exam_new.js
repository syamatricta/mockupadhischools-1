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
           // alert('We have detected that you are using popup blocker.\n Please disable the pop up blocker to Start Examination.');
			$('#examerror').modal({keyboard: true})
		}
        else {
            loginWindow.close();
        }
    }, 1000);
} else {
 $( document ).ready(function() {
	   check_popup_status();
 })
/*; Event.observe(window,"load",check_popup_status,!1);function check_popup_status(){var a=!0,b=window.open();parent.window.focus();b?(a=!1,b.close()):a=!0;a&&alert("We have detected that you are using popup blocker.\n Please disable the pop up blocker to Start Examination.");a?$("popup_blocked_status").value=1:$("popup_blocked_status").value=0;""!=$("poptry").value&&1==parseInt($("poptry").value)&&exam_rule_start()};*/
}

function check_popup_status() {
    var a = !0,
        b = window.open();
    parent.window.focus();
    b ? (a = !1, b.close()) : a = !0;
     a && $('#examerror').modal({keyboard: true}) ;
    //a && alert("We have detected that you are using popup blocker.\n Please disable the pop up blocker to access quiz.");
    a ? $("#popup_blocked_status").val(1) : $("#popup_blocked_status").val(0);
    "" != $("#poptry").val() && 1 == parseInt($("#poptry").val()) && exam_rule_start()
}

function exam_rule_start(url){
	if( $('#popup_blocked_status').val() != '' && parseInt($('#popup_blocked_status').val()) == 0) { 
		$('#hide_strt_btn').html('<img src="'+base_url+'images/spinner.gif">') ; 
		url_mode	= base_url+'index.php/course/change_exammode';	
		ajax_exam_mode(url,url_mode);
	}
}
 

function ajax_exam_mode(url,url_mode){ 
    $.ajax({
        type: "POST",
        url:url_mode,
        dataType: 'json',
        data : {},
        cache: false, 
        success:function(data){	
        	check_exam_status(data)                 
        }
        
	})
}


function check_exam_status(obj) {
	if(obj.responseText =='false'){
		alert("You are allowed to take only one exam at a time");
	}else{
            //$('strtexm').style.display = 'none';
       	url	= base_url+'course/exam_start/'+url_d.getTime();
		var form = document.createElement("form");
		form.setAttribute("method", "post");
		form.setAttribute("action", url);
		
		// setting form target to a window named 'formresult'
		form.setAttribute("target", "formresult");
		document.body.appendChild(form);
		
		// creating the 'formresult' window with custom features prior to submitting the form
		window.open('', 'formresult', 'scrollbars=yes,menubar=no,height=900,width=1500,resizable=no,toolbar=no,status=no,location=no');
		form.submit();
		document.getElementById('hide_strt_btn').innerHTML = '';
	}
}
var url_d = new Date();