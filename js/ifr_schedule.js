;
var day_temp = 0,
    month_temp = 0,
    year_temp = 0;
/*
function sizeFrame() {	
	var F= parent.document.getElementById('idIframe');
	if(F.contentDocument) {
		F.height = F.contentDocument.documentElement.scrollHeight+150; //FF 3.0.11, Opera 9.63, and Chrome
	} else {
		F.height = F.contentWindow.document.body.scrollHeight+150; //IE6, IE7 and Chrome
	}
}
*/
function fncGetClass(a) {
    $("hdnSubregion").value = a
}

function fncNextPrevRegion(a) {
    var b = $("hdnOffset").value;
    0 == a ? b = parseInt(b) - 5 : 1 == a && (b = parseInt(b) + 5);
    a = $("hdnSubregion").value;
    var c = $("hdnDated").value;
    new Ajax.Request(base_url + "home/related_region/", {
        method: "post",
        parameters: "dated=" + c + "&subregion=" + a + "&offset=" + b,
        onSuccess: function (a) {
            $("divShowRelatedImage").innerHTML = a.responseText;
            window.scroll(0, 50)
        },
        onFailure: function () {
            alert("Ajax request failed")
        }
    });
    $("divImage").innerHTML = '<center><img src="' + base_url + 'images/spinner.gif"/></center>'
}

function fncGetSubregion(a, b) {
    $("selectsltSearchSubregion").innerHTML = "Select";
    var c = $(a).value,
        d = eval(content);
    "" != d && ($(b).options.length = null, $(b).options[$(b).options.length] = new Option("Select", 0), d.R[c] && d.R[c].each(function (a) {
        $(b).options[$(b).options.length] = new Option(a.name, a.id)
    }));
    return !1
}

function fncDisplayDefaultList(a, b, c, d) {
    fncGetNextCalendar(a);
    day_temp = b;
    month_temp = c;
    year_temp = d
}

function fncGetNextCalendar(a) {
    $("chter_cnt").style.display = "none";
    var b = base_url + "ifrschedule/show_next_calendar/",
        c = $("sltSearchRegion").value,
        d = $("sltSearchSubregion").value,
        e = $("sltSearchCourse").value;
    if (5 == e) {
        $("chter_cnt").style.display = "block";
        var f = $("sltSearchChp").value,
            c = "timeid=" + a + "&region=" + c + "&subregion=" + d + "&course=" + e + "&chp=" + f
    } else $("chter_cnt").style.display = "none", c = "timeid=" + a + "&region=" + c + "&subregion=" + d + "&course=" + e;
    new Ajax.Request(b, {
        method: "post",
        parameters: c,
        onSuccess: function (b) {
            $("divUserCalendarnw").innerHTML = b.responseText;
            parseFloat($("hdnTimeline").value) == parseFloat(a) && fncShowEventList(day_temp, month_temp, year_temp)
        },
        onFailure: function () {
            alert("Ajax request failed")
        }
    });
    $("divUserCalendarnw").innerHTML = '<div style="width:300px;"><center><img src="' + base_url + 'images/spinner.gif"/></center></div>'
}

function fncShowEventList(a, b, c) {
    current_date = b + "/" + a + "/" + c;
    b = base_url + "index.php/ifrschedule/display_list";
    c = $("sltSearchRegion").value;
    var d = $("sltSearchSubregion").value,
        e = $("sltSearchCourse").value;
    if (5 == e) {
        $("chter_cnt").style.display = "block";
        var f = $("sltSearchChp").value;
        c = "datecurrent=" + current_date + "&region_id=" + c + "&subregion_id=" + d + "&course=" + e + "&chp=" + f
    } else $("chter_cnt").style.display = "none", c = "datecurrent=" + current_date + "&region_id=" + c + "&subregion_id=" + d + "&course=" + e;
    fncSetSelection(a);
    $("divDisplayEventList").style.display = "block";
    $("divDisplayEventList").innerHTML = 'Please wait ...<img src="' + base_url + 'images/spinner.gif">';
    new Ajax.Request(b, {
        method: "post",
        parameters: c,
        onSuccess: fncDisplayList
    })
}

function fncSetSelection(a) {
    var b = $("tblCalendarId").getElementsByTagName("td"),
        c;
    for (c in b) b[c].id && c < b.length && (b[c].id != a ? $(b[c].id).removeClassName("selectedDay") : b[c].id == a && $(b[c].id).addClassName("selectedDay"))
}

function fncDisplayList(a) {
    $("divDisplayEventList").innerHTML = a.responseText;
    $("divDisplayEventList").scrollTo();
    //sizeFrame();
}

function ietruebody() {
    return document.compatMode && "BackCompat" != document.compatMode ? document.documentElement : document.body
}

function open_tooltip(a, b, c) {
    if (ns6 || ie) return "undefined" != typeof c && (tipobj.style.width = c + "px"), "undefined" != typeof b && "" != b && (tipobj.style.backgroundColor = b), tipobj.innerHTML = a, enabletip = !0, !1
}

function positiontip(a) {
    if (enabletip) {
        var b = ns6 ? a.pageX : event.clientX + ietruebody().scrollLeft,
            c = ns6 ? a.pageY : event.clientY + ietruebody().scrollTop,
            d = ie && !window.opera ? ietruebody().clientWidth - event.clientX - offsetxpoint : window.innerWidth - a.clientX - offsetxpoint - 20,
            e = ie && !window.opera ? ietruebody().clientHeight - event.clientY - offsetypoint : window.innerHeight - a.clientY - offsetypoint - 20,
            f = 0 > offsetxpoint ? -1 * offsetxpoint : -1E3;
        tipobj.style.left = d < tipobj.offsetWidth ? ie ? ietruebody().scrollLeft + event.clientX - tipobj.offsetWidth + "px" : window.pageXOffset + a.clientX - tipobj.offsetWidth + "px" : b < f ? "5px" : b + offsetxpoint + "px";
        tipobj.style.top = e < tipobj.offsetHeight ? ie ? ietruebody().scrollTop + event.clientY - tipobj.offsetHeight - offsetypoint + "px" : window.pageYOffset + a.clientY - tipobj.offsetHeight - offsetypoint + "px" : c + offsetypoint + "px";
        tipobj.style.visibility = "visible"
    }
}

function hide_tooltip() {
    if (ns6 || ie) enabletip = !1, tipobj.style.visibility = "hidden", tipobj.style.left = "-1000px", tipobj.style.backgroundColor = "", tipobj.style.width = ""
}

function __fncShowData(a) {
    "none" == document.getElementById(a).style.display ? document.getElementById(a).style.display = "block" : document.getElementById(a).style.display = "none"
}

function __fncShowdiv(a) {
    document.getElementById(a).style.background = "#999999"
}

function __fncChangeColor(a) {
    document.getElementById(a).style.background = "#6D6D6D"
}

function __fncSetSelectedValue(a, b, c, d, e) {
    a = document.getElementById(a).innerHTML;
    document.getElementById(c).value = d;
    document.getElementById(e).value = a
}

function __fncShowDatahh(a) {
    "none" == document.getElementById(a).style.display ? document.getElementById(a).style.display = "block" : document.getElementById(a).style.display = "none";
    removeselected()
}

function removeselected() {
    $("txtSearchengine").value = "";
    $("txtREO").value = ""
}

function __fncShowdivhh(a) {
    document.getElementById(a).style.background = "#999999"
}

function __fncChangeColorhh(a) {
    document.getElementById(a).style.background = "#6D6D6D"
}

function fncGoBottom() {
    var a = document.getElementById("content");
    a.scrollBottom = a.scrollHeight
}

function fncGoTop() {
    var a = document.getElementById("content");
    a.scrollTop = a.scrollHeight
}

function displayIndex() {
    $("indexBox").style.display = "block"
}

function hideIndex() {
    $("indexBox").style.display = "none"
}