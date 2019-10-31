;
var day_temp = 0,
    month_temp = 0,
    year_temp = 0;

function validate_user_Login() {
    $("server_error").style.display = "none";
    if (false == is_field_equal ("username",'Email Address', 'Please enter Email Address',"error") || !1 == is_field_empty("username", "Please enter Email Address", "error") || !1 == check_email("username", "Please enter valid Email Address", "error") || !1 == is_field_empty("password", "Please enter Password", "error") || false == is_field_equal ("password",'Password', 'Please enter Password',"error")) return !1;
    $("loginform").submit()
}

function clearusername() {
    $("username").value = ""
}

function clearpassword() {
    $("password").value = ""
}
function clearField(id){
    if(trim(id.title)==trim(id.value)) 
    { 		
        id.value = '';			
    }
}
function fillField(id){		
    if(id.value=='') {
        id.value = id.title;		
    }
}
function passwordFieldFocus(current,changeId,ishelpnote){
    if($(current).value=='Password' || $(current).value=='New Password' || $(current).attr('id')=='sign_temp_password'){
        $(current).hide();
        $(changeId).show();
        $(changeId).focus();
		
        if(ishelpnote){
            //getting the position of the text box
            var p = $(changeId).position();
            var Leftp0s = p.left;
            var Toppos = p.top;
            $('show_helpnote').css({
                top: parseInt(Toppos-25, 10) + 'px',
                left: parseInt(Leftp0s-280, 10) + 'px' ,
                position:'absolute' 
            });
        
            $(changeId).bind("onclick",$('show_helpnote').show());
        }
    }
}

function signPassAddComon(current,changeId){
    if($(current).value == '')	{		
        $(changeId).show();
        $(current).hide();
    }
}
function forgot_password() {
    $("flasherror").innerHTML = "";
    $("errordisplay").innerHTML = "";
    $("flashsuccess").innerHTML = "";
    if (!1 == is_field_empty("email", "Please enter Email", "errordisplay") || !1 == check_email("email", "Please enter valid Email", "errordisplay")) return !1;
    $("forgot_password_form_adhi").action = base_url + "forgot-password";
    $("forgot_password_form_adhi").submit()
}

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
    var b = base_url + "schedule/show_next_calendar/",
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
    b = base_url + "index.php/schedule/display_list";
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
    $("divDisplayEventList").scrollTo()
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

function checkuserregister_1() {
    if (!1 == is_field_empty("firstname", "Enter First Name", "errordiv")) return $("upassword").value = "", $("cupassword").value = "", !1;
    $("errordiv").style.display = "none";
    if (!1 == is_field_empty("lastname", "Enter Last Name", "errordiv")) return $("upassword").value = "", $("cupassword").value = "", !1;
    $("errordiv").style.display = "none";
    if (!1 == is_field_empty("email", "Enter Email", "errordiv")) return $("upassword").value = "", $("cupassword").value = "", !1;
    $("errordiv").style.display = "none";
    if (!1 == checkEmail($("email").value)) return $("errordiv").style.display = "block", $("errordiv").innerHTML = "Email is not valid ", $("upassword").value = "", $("cupassword").value = "", !1;
    $("errordiv").style.display = "none";
    if (!1 == is_field_empty("phonenumber", "Enter Phone Number", "errordiv")) return $("upassword").value = "", $("cupassword").value = "", !1;
    if (10 > $("phonenumber").value.length) return $("errordiv").style.display = "block", $("errordiv").innerHTML = "Phone Number should contain minimum 10 numbers", $("phonenumber").focus(), $("upassword").value = "", $("cupassword").value = "", !1;
    $("errordiv").style.display = "none";
    if (!1 == is_field_empty("upassword", "Enter Password", "errordiv")) return $("upassword").value = "", $("cupassword").value = "", !1;
    if (6 <= $("upassword").value.length) {
        if (!0 == is_valid_password($("upassword").value)) $("errordiv").style.display = "none";
        else return $("errordiv").style.display = "block", $("errordiv").innerHTML = "Password should be in alphanumeric format", $("upassword").focus(), $("upassword").value = "", $("cupassword").value = "", !1;
        $("errordiv").style.display = "none"
    } else return $("errordiv").style.display = "block", $("errordiv").innerHTML = "Password should be minimum 6 characters", $("upassword").focus(), $("upassword").value = "", $("cupassword").value = "", !1;
    $("errordiv").style.display = "none";
    if (!1 == is_field_empty("cupassword", "Enter Confirm Password", "errordiv")) return $("upassword").value = "", $("cupassword").value = "", !1;
    $("errordiv").style.display = "none";
    if (trim($("upassword").value) != trim($("cupassword").value)) return $("errordiv").style.display = "block", $("errordiv").innerHTML = "Password and Confirm Password do not match", $("upassword").focus(), $("upassword").value = "", $("cupassword").value = "", !1;
    $("errordiv").style.display = "none";
    $("userregstep1").value = 1;
    $("myform").action = base_url + "userregister";
    $("myform").submit()
}

function checkuserregister_3(a) {
    if (!1 == is_field_empty("txtREP", "Enter Pick your package: Real Estate Principles classes most often", "errordiv")) return !1;
    $("errordiv").style.display = "none";
    if (!1 == is_field_empty("txtREPmf", "Enter Live crash course: Real Estate Principles classes most often", "errordiv")) return !1;
    $("errordiv").style.display = "none";
    $("userregstep1").value = 3;
    $("myform").action = base_url + "userregister/registerstep3/" + a;
    $("myform").submit()
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

function __fncSetSelectedValuehh(a, b, c, d) {
    a = document.getElementById(a).innerHTML;
    document.getElementById(c).value = a;
    document.getElementById(b).style.display = "none";
    document.getElementById("hh1").style.display = "none";
    document.getElementById("hh1_txt").style.display = "none";
    document.getElementById("hh2").style.display = "none";
    document.getElementById("hh2_txt").style.display = "none";
    document.getElementById("hear-about-us-box").style.display = "none";
    "Search engine" == d && (document.getElementById("hh1").style.display = "block", document.getElementById("hh1_txt").style.display = "block", document.getElementById("hear-about-us-box").style.display = "block", document.getElementById("hh2").style.display = "none", document.getElementById("hh2_txt").style.display = "none", document.getElementById("hear-about-us-box").style.display = "none");
    "Referral from a real estate office" == d && (document.getElementById("hh2").style.display = "block", document.getElementById("hh2_txt").style.display = "block", document.getElementById("hear-about-us-box").style.display = "block", document.getElementById("hh1").style.display = "none", document.getElementById("hh1_txt").style.display = "none", document.getElementById("hear-about-us-box").style.display = "none")
}

function fncGettestimonial(a, b) {
    a = "prev" == b ? parseInt(a) - 1 : parseInt(a) + 1;
    $("hidTestmId").value = a;
    $("hidDirection").value = b;
    //$("testimonial").submit()
    url	= base_url+'testimonial/get_next/' + a +'/'+b;
	myAjaxRequest = new Ajax.Request(url, {method:"get", onSuccess: nextTestimonial, onFailure: errFun });
}
function nextTestimonial(obj){
	
	carr = eval('('+obj.responseText+')');
	var carr = eval('(' + obj.responseText + ')'); 
	 $("testimonial_name").innerHTML = carr.testimonial_name;
	 $("testimonial_content").innerHTML = carr.testimonial;
	 $("hidTestmId").value = carr.offset;
	 $("hidDirection").value = carr.direction;
}
function errFun(){
	alert('Ann error occurred');
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

function test() {
    alert("its blurred")
};