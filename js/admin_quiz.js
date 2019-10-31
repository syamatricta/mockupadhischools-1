;
function ajax_load_edition()
{
	courseId = $('course').value;
	if(courseId != '') {
		
		url_e	= base_url+'admin_classroom/load_editions/' + $('course').value;
		new Ajax.Request(url_e, {method:"get", onSuccess: populate_edition_options });
		
	} else {
		
		$('edition').options.length = null;
		$('edition').options[$('edition').options.length] = new Option('--Select Edition--', '');
	}
}
function populate_edition_options(j_arr)
{
	var obj = eval(j_arr.responseText);
	
	if(obj != '') {
		$('edition').options.length = null;
		$('edition').options[$('edition').options.length] = new Option('--Select Edition--', '');
		obj.each(function(edition){
			$('edition').options[$('edition').options.length] = new Option(edition.edition_no, edition.id);
		});
	} else {
		$('edition').options.length = null;
		$('edition').options[$('edition').options.length] = new Option('--Select Edition--', '');
	}
	return;
}
function license_select(a) {
    "broker" == a ? $("broker_div").style.display = "block" : $("broker_div").style.display = "none";
    "sales" == a ? $("sales_div").style.display = "block" : $("sales_div").style.display = "none"
}

function uploadExam() {
    var a = $("userfile"),
        b = [];
    $("display_server_error").style.display = "none";
    if ("" == a.value) return $("error").innerHTML = "Please upload a Xls file", !1;
    b = a.value.split(".");
    return "xls" != b[1] ? ($("error").innerHTML = "Please upload a Xls file", !1) : !0
}

function show_quiz(a, b) {
    window.location = b + "index.php/admin_quiz/list_quiz/" + a
}

function check_extension(a) {
    a = a.split(".");
    try {
        var b = a[parseInt(a.length) - 1]
    } catch (c) {
        return !1
    }
    b = b.toLowerCase();
    return "xls" == b ? !0 : !1
}

function validate_upload_file() {
    elem = $("userfile");
    course = $("course");
    $("error").innerHTML = "";
    if (!1 == validate_topic()) return !1;
    document.getElementById("display_server_error").style.display = "none";    
    if ("" == trim(elem.value)) return $("error").innerHTML = "Please upload an xls file..", !1;
    if ("" == trim($("edition").value)) return $("error").innerHTML = "Please select edition", $("edition").value = "", !1;
    if (!0 == check_extension(elem.value)) return !0;
    validate_topic();
    elem.value = "";
    $("error").innerHTML = "Please upload an Xls file...";
    return !1
}

function validate_topic() {
    topic = $("topic");
    if ("" == trim(topic.value)) return $("error").innerHTML = "Please Enter a topic", !1
}

function trim(a) {
    return a.replace(/^\s*|\s*$|\n|\r/g, "")
}

function change_question(a, b, c, d, e) {
    window.location = b + "index.php/admin_quiz/edit/" + c + "/" + d + "/" + e + "/" + a
}

function show_edit_quest() {
    $("show_edit").style.display = "block";
    $("show_list").style.display = "none";
    $("question_box").style.display = "none";
    $("display_server_error").style.display = "none";
    return !1
}

function edit_questions(a, b, c, d, f) {
    var e;
    show_edit_quest();
    document.getElementById("display_server_error").style.display = "none";
    if ("" == trim($("questions").value)) return $("display_error").innerHTML = "Question is empty", !1;
    for (e = 1; 4 >= e; e++)
        if ("" == trim($("answers" + e).value)) return $("display_error").innerHTML = " Option " + e + " is empty", !1;
    if (!confirm("Please confirm you have selected the right answer")) return !1;
    url = a + "index.php/admin_quiz/edit/" + b + "/" + c + "/" + d +"/" + f;
    $("form_edit").action = url;
    $("form_edit").submit()
}

function delete_quest() {
    if (1 == $("ques_cnt").value) {
        if (confirm("Deleting this question leads to the deletion of this quiz")) return !0
    } else if (confirm("Do you want to delete this Question and its Answers?")) return !0;
    return !1
}

function delete_all_quest() {
    return confirm("Do you want to delete this Chapter? ") ? !0 : !1
}

function add_question(a, b, c, ed) {
    var d;
    $("server_error").style.display = "none";
    if ("" == trim($("edition").value)) return $("error").innerHTML = "Please select edition", !1;
    if ("" == trim($("questions").value)) return $("error").innerHTML = "Question is empty", !1;
    for (d = 1; 4 >= d; d++)
        if ("" == trim($("answers" + d).value)) return $("error").innerHTML = " Option " + d + " is empty", !1;
    if (!confirm("Please confirm you have selected the right answer")) return !1;
    url = a + "index.php/admin_quiz/add_question/" + b + "/" + c + "/"+ ed;
    
    $("form_add").action = url;
    $("form_add").submit()
}

function change_status(a, b, c) {
    if (0 == c)
        if (confirm("Do you want to " + ("D" == a ? "enable" : "disable") + " the Chapter Status?")) window.location = b;
        else return !1;
        else return alert(c + " user(s) taking the quiz, so you are not allowed to disable this Quiz "), !1
}

function suspend_action() {
    alert("Some one taking the exam so you are not allow to do any process for this Course ");
    return !1
}

function cancel_action(a) {
    window.location = a
};