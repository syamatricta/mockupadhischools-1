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

function select_course(a, b) {
    window.location = b + "admin_exam/list_exam/" + a
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
    course_enable = $("course_enable");
    var a;
    $("error").innerHTML = "";
    console.log($('replace_old_questions').value);
    var confirm_message = ($('replace_old_questions').checked) ? "Do you want to replace the existing xls with new one (if one already there)" : "Do you want to upload new questions?";
    document.getElementById("display_server_error").style.display = "none";
    if ("" == trim(elem.value)) return $("error").innerHTML = "Please upload an xls file", $("userfile").value = "", !1;
    if ("" == trim($("edition").value)) return $("error").innerHTML = "Please select edition", $("edition").value = "", !1;
    if (!0 == check_extension(elem.value)) {
        for (j = 1; j < $("count_enable").value; j++)
            if ($("disable_course" + j).value == course.value) return alert("Disable the course you have selected and then continue with uploading "), $("userfile").value = "", !1;
        for (a = 1; a < $("count").value; a++)
            if ($("exist_course" + a).value == course.value)
                if (confirm(confirm_message)) {
                    document.getElementById("exams_replace").value = course.value;
                    break
                } else return $("userfile").value = "", !1;
        return !0
    }
    elem.value = "";
    $("error").innerHTML = "Please upload an Xls file";
    return !1
}

function trim(a) {
    return a.replace(/^\s*|\s*$|\n|\r/g, "")
}

function change_question(a, b, c, d) {
    window.location = b + "admin_exam/edit/" + c + "/" + a + "/" + d
}

function show_edit_quest() {
    $("show_edit").style.display = "block";
    $("show_list").style.display = "none";
    $("question_box").style.display = "none";
    $("display_server_error").style.display = "none";
    return !1
}

function edit_questions(a, b,ed) {
    var c;
    show_edit_quest();
    document.getElementById("display_server_error").style.display = "none";
    if ("" == trim($("questions").value)) return $("display_error").innerHTML = "Question is empty", !1;
    for (c = 1; 4 >= c; c++)
        if ("" == trim($("answers" + c).value)) return $("display_error").innerHTML = " Option " + c + " is empty", $("answers" + c).focus(), !1;
    if (!confirm("Please confirm you have selected the right answer")) return !1;
    url = a + "admin_exam/edit/" + b+"/" + ed;

    $("form_edit").action = url;
    $("form_edit").submit()
}

function delete_quest() {
    return confirm("Do you want to delete this Question and its Answers?") ? !0 : !1
}

function delete_all_quest() {
    return confirm("Do you want to delete the entire questions and Answers from this Course?") ? !0 : !1
}

function add_question(a, b) {
    var c;
    $("server_error").style.display = "none";
    if ("" == trim($("edition").value)) return $("error").innerHTML = "Please select edition", !1;
    if ("" == trim($("questions").value)) return $("error").innerHTML = "Question is empty", !1;
    for (c = 1; 4 >= c; c++)
        if ("" == trim($("answers" + c).value)) return $("error").innerHTML = " Option " + c + " is empty", $("answers" + c).focus(), !1;
    if (!confirm("Please confirm you have selected the right answer")) return !1;
    url = a + "admin_exam/add_question/" + b;
    $("form_add").action = url;
    $("form_add").submit()
}

function change_status(a, b) {
    if (confirm("Do you want to " + ("D" == a ? "enable" : "disable") + " the Exam Status?")) window.location = b;
    else return !1
}

function suspend_action(a) {
    alert(a + " user(s) taking the exam, so you are not allowed to disable this Course ");
    return !1
}

function cancel_action(a) {
    window.location = a
}

function disable_process(a) {
    alert("Please disable the course and then continue with " + a);
    return !1
};