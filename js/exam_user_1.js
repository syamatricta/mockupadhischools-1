;
var win, wimpyWindow, countdown, netTimer, myAjaxRequest, gCallCount = 0,
    answerOptions = '<div id="answer-option-alphabet" class="floatleft answer-option-alphabet" >{{alphabet}}</div><div id="answer-option-text" class="floatleft answer-option-text" >{{option}}</div>';

function cancel_confirm(a) {
    window.location = a
}

function check_password() {
    if (!1 == is_field_empty("txt_password", "Please enter Password", "errordisplay")) return !1
}

function confirm_go(a) {
    window.location = a
}

function exam_rule() {
    $("poptry").value = 1;
    $("rule_form_adhi").action = base_url + "exam/exam_rule";
    $("rule_form_adhi").submit()
}

function exam_rule_start(a) {
    "" != $("popup_blocked_status").value && 0 == parseInt($("popup_blocked_status").value) && (url_mode = base_url + "index.php/exam/change_exammode", ajax_exam_mode(a, url_mode))
}

function ajax_exam_mode(a, b) {
    new Ajax.Request(b, {
        method: "post",
        onSuccess: check_exam_status
    })
}

function check_exam_status_old(a) {
    "false" == a.responseText ? alert("You are allowed to take only one exam at a time") : (url = base_url + "index.php/exam/exam_start", wimpyWindow = window.open(url, "", "width=1050, height=900, left=45, top=15, scrollbars=yes, menubar=no,resizable=no,directories=no,location=no"))
}

function check_exam_status(a) {
    "false" == a.responseText ? alert("You are allowed to take only one exam at a time") : ($("strtexm").style.display = "none", url = base_url + "exam/exam_start", a = document.createElement("form"), a.setAttribute("method", "post"), a.setAttribute("action", url), a.setAttribute("target", "formresult"), document.body.appendChild(a), window.open("", "formresult", "scrollbars=yes,menubar=no,height=900,width=1500,resizable=no,toolbar=no,status=no,location=no"), a.submit())
}

function exam_action(a) {
    $("examination_form_adhi").action = base_url + "exam/examination/n/" + a;
    $("examination_form_adhi").submit()
}

function exam_action_previous(a) {
    $("examination_form_adhi").action = base_url + "exam/examination/p/" + a;
    $("examination_form_adhi").submit()
}

function timer(a) {
    hour = parseInt(a / 60);
    minute = a % 60;
    second = $("second_hid").value;
    if ("0" == hour && "0" >= minute && 1 >= second) return que = $("unique_page").value, clearTimeout(countdown), JSfncEndExam(), !1;
    20 > 2 * minute && (minute = "0" + minute);
    20 > 2 * second && (second = "0" + second);
    "00" == hour && "29" == minute ? ($("alert").innerHTML = " 30 minutes left", $("divAlert").style.display = "block") : ($("alert").innerHTML = "", $("divAlert").style.display = "none");
    "00" == hour && "29" != minute && ("00" == hour && "19" == minute ? ($("alert").innerHTML = " 20 minutes left", $("divAlert").style.display = "block") : ($("alert").innerHTML = "", $("divAlert").style.display = "none"));
    "00" == hour && ("29" != minute && "00" == hour && "19" != minute) && ("00" == hour && "09" == minute ? ($("alert").innerHTML = " 10 minutes left", $("divAlert").style.display = "block") : ($("alert").innerHTML = "", $("divAlert").style.display = "none"));
    "00" == hour && ("29" != minute && "00" == hour && "19" != minute && "00" == hour && "09" != minute) && ("00" == hour && "04" == minute ? ($("alert").innerHTML = " 5 minutes left", $("divAlert").style.display = "block") : ($("alert").innerHTML = "", $("divAlert").style.display = "none"));
    time_remaining = "0" + hour + ":" + minute + ":" + second + " hrs";
    $("latest").innerHTML = time_remaining;
    countdown = setTimeout("show_second()", 1E3)
}

function show_second() {
    $("timer_hid") && (time_now = $("timer_hid").value, second = $("second_hid").value, sec = second - 1, -1 == sec && (sec = 59, time_now -= 1, $("timer_hid").value = time_now), $("second_hid").value = sec, timer(time_now))
}

function exam_end(a) {
    window.location = a + "/exam/exam_end"
}

function disable_rightClick() {
    function a() {
        if (document.all) return c, !1
    }

    function b(a) {
        if (document.layers || document.getElementById && !document.all)
            if (2 == a.which || 3 == a.which) return c, !1
    }
    var c = "Sorry, right-click has been disabled";
    document.layers ? (document.captureEvents(Event.MOUSEDOWN), document.onmousedown = b) : (document.onmouseup = b, document.oncontextmenu = a);
    document.oncontextmenu = new Function("return false")
}

function ajax_update1() {
    clearTimeout(netTimer);
    document.getElementById("divMode") && (document.getElementById("divMode").innerHTML = "Online");
    document.getElementById("hdnMode").value = 1;
    setTimeout("ajax_time_update1()", 1E3)
}

function ajaxFunction(a) {
    a.responseText ? "session" == a.responseText ? document.getElementById("examviewmain").innerHTML = '<div style="height:50px;"><font color="red">Your session has been expired</font></div>' : ajax_update1() : JSfncOffline()
}

function ajax_time_update1() {
    netTimer = setTimeout("JSfncOffline()", 1E4);
    url = base_url + "index.php/exam/ajax_update";
    myAjaxRequest = new Ajax.Request(url, {
        method: "post",
        onSuccess: ajaxFunction,
        onFailure: JSfncOffline
    })
}

function JSfncOffline() {
    clearTimeout(netTimer);
    myAjaxRequest.abort();
    document.getElementById("divMode") && (document.getElementById("divMode").innerHTML = '<font color="red" >Offline</font>');
    document.getElementById("hdnMode") && (document.getElementById("hdnMode").value = 0);
    setTimeout("ajax_time_update1()", 1E3)
}

function JSfncNextQuestion() { 
    var a = eval(content),
        b = a.counter,
        c = a.total,
        d = parseInt(c) - 1,
        e = document.getElementById("choice").value;
    a.navigation < c && a.navigation <= b && a.navigation++;
    0 != e && (a.answer[b] = e);
    b == parseInt(d) && (document.getElementById("divNext").style.display = "none", document.getElementById("divEnd").style.display = "block");
    parseInt(b) <= d && (document.getElementById("divCounter").innerHTML = parseInt(b) + 1, document.getElementById("divCounterTotal").innerHTML = parseInt(b) + 1, b = parseInt(b) + 1, document.getElementById("divQuestion").innerHTML = a.question[b], document.getElementById("divOption_1").innerHTML = answerOptions.replace("{{alphabet}}", "A").replace("{{option}}", a.option[b][1]), document.getElementById("divOption_2").innerHTML = answerOptions.replace("{{alphabet}}", "B").replace("{{option}}", a.option[b][2]), document.getElementById("divOption_3").innerHTML = answerOptions.replace("{{alphabet}}", "C").replace("{{option}}", a.option[b][3]), document.getElementById("divOption_4").innerHTML = answerOptions.replace("{{alphabet}}", "D").replace("{{option}}", a.option[b][4]), a.counter = b, 0 < b && (document.getElementById("divPrevious").style.visibility = "visible"), a.answer[b] ? (document.getElementById("choice").value = a.answer[b], document.getElementById("option_" + a.answer[b]).checked = "checked") : (document.getElementById("option_1").checked = "", document.getElementById("option_2").checked = "", document.getElementById("option_3").checked = "", document.getElementById("option_4").checked = "", document.getElementById("choice").value = 0));
    JSfncUpdateScore()
}

function JSfncPreviousQuestion() {
    var a = eval(content),
        b = a.counter,
        c = document.getElementById("choice").value,
        d = parseInt(a.total) - 1;
    0 != c && (a.answer[b] = c);
    b != parseInt(d) - 1 && (document.getElementById("divEnd").style.display = "none");
    0 < parseInt(b) && (document.getElementById("divNext").style.display = "block", b = parseInt(b) - 1, document.getElementById("divCounter").innerHTML = parseInt(b), document.getElementById("divCounterTotal").innerHTML = parseInt(b), document.getElementById("divQuestion").innerHTML = a.question[b], document.getElementById("divOption_1").innerHTML = answerOptions.replace("{{alphabet}}", "A").replace("{{option}}", a.option[b][1]), document.getElementById("divOption_2").innerHTML = answerOptions.replace("{{alphabet}}", "B").replace("{{option}}", a.option[b][2]), document.getElementById("divOption_3").innerHTML = answerOptions.replace("{{alphabet}}", "C").replace("{{option}}", a.option[b][3]), document.getElementById("divOption_4").innerHTML = answerOptions.replace("{{alphabet}}", "D").replace("{{option}}", a.option[b][4]), a.counter = b, 1 == b && (document.getElementById("divPrevious").style.visibility = "hidden"), a.answer[b] ? (document.getElementById("choice").value = a.answer[b], document.getElementById("option_" + a.answer[b]).checked = "checked") : (document.getElementById("option_1").checked = "", document.getElementById("option_2").checked = "", document.getElementById("option_3").checked = "", document.getElementById("option_4").checked = "", document.getElementById("choice").value = 0));
    JSfncUpdateScore()
}

function gotoQuestion() {
    var a = eval(content),
        b = a.counter,
        c = parseInt(a.total) - 1,
        d = document.getElementById("choice").value;
    0 != d && (a.answer[b] = d);
    b = parseInt(document.getElementById("jumpToQuestion").value);
    if ("" === b) return !1;
    b == parseInt(c) ? (document.getElementById("divNext").style.display = "none", document.getElementById("divEnd").style.display = "block") : (document.getElementById("divNext").style.display = "block", document.getElementById("divEnd").style.display = "none");
    0 == b ? document.getElementById("divPrevious").style.visibility = "hidden" : document.getElementById("divPrevious").style.visibility = "visible";
    parseInt(b) <= c && (document.getElementById("divCounter").innerHTML = parseInt(b) + 1, document.getElementById("divCounterTotal").innerHTML = parseInt(b) + 1, b = parseInt(b) + 1, document.getElementById("divQuestion").innerHTML = a.question[b], document.getElementById("divOption_1").innerHTML = answerOptions.replace("{{alphabet}}", "A").replace("{{option}}", a.option[b][1]), document.getElementById("divOption_2").innerHTML = answerOptions.replace("{{alphabet}}", "B").replace("{{option}}", a.option[b][2]), document.getElementById("divOption_3").innerHTML = answerOptions.replace("{{alphabet}}", "C").replace("{{option}}", a.option[b][3]), document.getElementById("divOption_4").innerHTML = answerOptions.replace("{{alphabet}}", "D").replace("{{option}}", a.option[b][4]), a.counter = b, a.answer[b] ? (document.getElementById("choice").value = a.answer[b], document.getElementById("option_" + a.answer[b]).checked = "checked") : (document.getElementById("option_1").checked = "", document.getElementById("option_2").checked = "", document.getElementById("option_3").checked = "", document.getElementById("option_4").checked = "", document.getElementById("choice").value = 0));
    JSfncUpdateScore()
}

function questionDropBox() {
    var a = eval(content),
        b = document.getElementById("jumpToQuestion");
    b.options.length = null;
    b.options[b.options.length] = new Option("--", 0);
    for (i = 1; i <= a.navigation; i++) option_value = parseInt(i) - 1, b.options[b.options.length] = new Option(i, option_value);
    b.value = parseInt(a.counter) - 1
}

function JSfncEndExam() {
    var a = eval(content),
        b = a.counter,
        c = document.getElementById("choice").value;
    0 != c && (a.answer[b] = c);
    new PeriodicalExecuter(function (a) {
        var b = document.getElementById("hdnMode").value;
        gCallCount++;
        1800 < gCallCount ? (clearInterval(countdown), document.getElementById("examviewmain").innerHTML = '<div style="height:50px;"><font color="red">Sorry timeout, No connection available. Hence scores cannot be updated.</font></div>', a.stop()) : 0 == b ? document.getElementById("examviewmain").innerHTML = '<div style="height:50px;"><font color="red">The exam is in offline mode. Hence please wait...</font></div>' : (a.stop(), a = JSON.stringify(content), a = "jsonarray=" + escape(a), new Ajax.Request(base_url + "exam/update_score", {
            method: "post",
            parameters: a,
            onSuccess: fncCheck
        }))
    }, 1);
    ajax_time_update1()
}

function JSfncUpdateScore() {
    if (1 == document.getElementById("hdnMode").value) {
        var a = JSON.stringify(content),
            a = "jsonarray=" + escape(a);
        new Ajax.Request(base_url + "exam/update_score", {
            method: "post",
            parameters: a
        })
    }
    questionDropBox()
}

function fnc_update_time(a) {
    timer(a.responseText)
}

function fncCheck() {
    window.location = base_url + "index.php/exam/exam_end"
}

function JSfncSetValue(a) {
    document.getElementById("choice").value = a
};