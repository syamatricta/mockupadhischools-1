; var win,wimpyWindow;function cancel_confirm(a){window.location=a}function check_password(){if(!1==is_field_empty("txt_password","Please enter Password","errordisplay"))return!1}function confirm_go(a){window.location=a}function exam_rule(a){url_mode=base_url+"index.php/exam/change_exammode";ajax_exam_mode(a,url_mode)}function ajax_exam_mode(a,b){new Ajax.Request(b,{method:"post",onSuccess:check_exam_status})} function check_exam_status(a){"false"==a.responseText?alert("Not allow to take exam"):$("rule_form_adhi").submit()}function exam_action(a){$("examination_form_adhi").action=base_url+"index.php/exam/exam_start/n/"+a;$("examination_form_adhi").submit()}function exam_action_previous(a){$("examination_form_adhi").action=base_url+"index.php/exam/exam_start/p/"+a;$("examination_form_adhi").submit()} function timer(a){hour=parseInt(a/60);minute=a%60;second=$("second_hid").value;"0"==hour&&("0">=minute&&1>=second)&&(que=$("unique_page").value,window.location=base_url+"index.php/exam/exam_end");20>2*minute&&(minute="0"+minute);20>2*second&&(second="0"+second);"00"==hour&&"29"==minute?$("alert").innerHTML="<img align='top' src='"+base_url+"images/innerpages/alert.jpg' border='0' />":$("alert").innerHTML="";"00"==hour&&"29"!=minute&&("00"==hour&&"19"==minute?$("alert").innerHTML="<img align='top' src='"+ base_url+"images/innerpages/alert.jpg' border='0' />":$("alert").innerHTML="");"00"==hour&&("29"!=minute&&"00"==hour&&"19"!=minute)&&("00"==hour&&"09"==minute?$("alert").innerHTML="<img align='top' src='"+base_url+"images/innerpages/alert.jpg' border='0' />":$("alert").innerHTML="");"00"==hour&&("29"!=minute&&"00"==hour&&"19"!=minute&&"00"==hour&&"09"!=minute)&&("00"==hour&&"04"==minute?$("alert").innerHTML="<img align='top' src='"+base_url+"images/innerpages/alert.jpg' border=0>":$("alert").innerHTML= "");time_remaining="0"+hour+":"+minute+":"+second+" hrs";$("latest").innerHTML=time_remaining;setTimeout("show_second()",1E3)}function show_second(){time_now=$("timer_hid").value;second=$("second_hid").value;sec=second-1;-1==sec&&(sec=59,time_now-=1,$("timer_hid").value=time_now);$("second_hid").value=sec;timer(time_now)}function exam_end(a){window.location=a+"/exam/exam_end"} function disable_rightClick(){function a(){if(document.all)return c,!1}function b(a){if(document.layers||document.getElementById&&!document.all)if(2==a.which||3==a.which)return c,!1}var c="Sorry, right-click has been disabled";document.layers?(document.captureEvents(Event.MOUSEDOWN),document.onmousedown=b):(document.onmouseup=b,document.oncontextmenu=a);document.oncontextmenu=new Function("return false")}function ajax_update(){setTimeout("ajaxFunction()",1E3)} function ajaxFunction(){url=base_url+"index.php/exam/ajax_update";var a;window.XMLHttpRequest?a=new XMLHttpRequest:window.ActiveXObject?a=new ActiveXObject("Microsoft.XMLHTTP"):alert("Your browser does not support XMLHTTP!");a.onreadystatechange=function(){4==a.readyState&&ajax_update()};a.open("GET",url,!0);a.send(null)};