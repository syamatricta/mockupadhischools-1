function fncFilter(a, b, reg_type, course_type) {
    "" == a && (a = 0);
    
    var date1 = new Date(a);
    var date2 = new Date(b);
    var timeDiff = date2.getTime() - date1.getTime();
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
  
    if ("" != a && diffDays < 0) return $("errordisplay").style.display = "block", $("errordisplay").innerHTML = "Please select a valid date range", $("date_from").focus(), !1;
    b && (date_to = date_change_format(b));
    date_from = a ? date_change_format(a) : a;

    $("adminreportlistform").action = base_url + "index.php/income_report/list_report_details/" + date_from + "/" + date_to + "/" + reg_type + "/" + course_type;
    $("adminreportlistform").submit()
}

function paginate(a) {
    $("adminreportlistform").action = a;
    $("adminreportlistform").submit();
}

function date_change_format(a) {
    var b = [],
    b = a.split("/");
    return date_format = b[2] + "-" + b[0] + "-" + b[1]
}

function fncExport(a, b, reg_type, course_type) {
    "" == a && (a = 0);
    
    var date1 = new Date(a);
    var date2 = new Date(b);
    var timeDiff = date2.getTime() - date1.getTime();
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
    
    if ("" != a && diffDays < 0) return $("errordisplay").style.display = "block", $("errordisplay").innerHTML = "Please select a valid date range", $("date_from").focus(), !1;
    b && (date_to = date_change_format(b));
    date_from = a ? date_change_format(a) : 0;

    $("adminreportlistform").action = base_url + "index.php/income_report/list_report_details_excel/" + date_from + "/" + date_to + "/" + reg_type + "/" + course_type;
    $("adminreportlistform").submit()
}