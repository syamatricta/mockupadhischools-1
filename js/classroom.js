;
$selectChapterString = "--Select Chapter--";

function ajax_load_chapters() {
    courseId = $("course").value;
    "" != courseId ? (url = base_url + "classroom/load_chapters/" + $("course").value, new Ajax.Request(url, {
        method: "get",
        onSuccess: populate_chapter_options
    })) : ($("chapter").options.length = null, $("chapter").options[$("chapter").options.length] = new Option($selectChapterString, 0), $("selectchapter").innerHTML = $selectChapterString)
}

function populate_chapter_options(a) {
    a = eval(a.responseText);
    "" != a ? ($("chapter").options.length = null, $("chapter").options[$("chapter").options.length] = new Option($selectChapterString, 0), a.each(function(a) {
        $("chapter").options[$("chapter").options.length] = new Option(a.name, a.id)
    }), $("selectchapter").innerHTML = $selectChapterString) : ($("chapter").options.length = null, $("chapter").options[$("chapter").options.length] = new Option($selectChapterString, 0), $("selectchapter").innerHTML = "--Select Chapter--")
}

function goto_list() {
    courseId = $("course").value;
    chapterId = $("chapter").value;
    "" != courseId && "" != chapterId ? window.location.href = base_url + "classroom/view/" + courseId + "/" + chapterId : $("page_error").innerHTML = "Please select a course and a chapter."
}

function cancel_action(a) {
    window.location = a
}

function paginate(a) {
    window.location.href = a
}

function add_remove_watch_list(a, b) {
    "" != b && (url = base_url + "classroom/update_watched_list/", new Ajax.Request(url, {
        method: "post",
        parameters: {
            video_id: b
        },
        onSuccess: function(c) {
            "TRUE" == c.responseText && (a.value = 1, $("mark-as-watched-label-" + b).innerHTML = "Watched");
            "FALSE" == c.responseText && (a.value = 0, $("mark-as-watched-label-" + b).innerHTML = "Mark as watched")
        }
    }))
};