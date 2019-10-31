;function fncSearch(){	
	frm_date = $('date_from').value;
	var res_f_date = frm_date.split("/"); 
	var frmDate = new Date(res_f_date[2], res_f_date[0] - 1, res_f_date[1]);
	to_date = $('date_to').value;
	var res_t_date = to_date.split("/");
	var toDate = new Date(res_t_date[2], res_t_date[0] - 1, res_t_date[1]);
	if(frmDate>toDate){
		if($('date_from').value>$('date_to').value)return $("errordisplay").style.display="block",$("errordisplay").innerHTML="Please select a valid date range",$("date_from").focus(),!1;
	}
	$("frmadhischool").submit()
}
function numbersonly(e){
    var unicode=e.charCode? e.charCode : e.keyCode
	
    if ((unicode!=8) && (unicode!=9) && (unicode!=13)){ //backspace,tab,enter,
        if (unicode<48||unicode>57) //if not a number
            return false //disable key press
    }
}
function addEdition(){	
	frm_date = $('date_from').value;
	var res_f_date = frm_date.split("/"); 
	var frmDate = new Date(res_f_date[2], res_f_date[0] - 1, res_f_date[1]);
	$("errordisplay").style.display="none";             
	if($('course_id').value==''){
		return $("errordisplay").style.display="block",$("errordisplay").innerHTML="Please select course",$("course_id").focus(),!1;
	}	
	if($('edition').value==''){
		return $("errordisplay").style.display="block",$("errordisplay").innerHTML="Please enter edition number",$("edition").focus(),!1;
	}
	if($('edition').value<1){
		return $("errordisplay").style.display="block",$("errordisplay").innerHTML="Please enter valid edition number",$("edition").focus(),!1;
	}
	if($('date_from').value==''){
		return $("errordisplay").style.display="block",$("errordisplay").innerHTML="Please enter from date",$("date_from").focus(),!1;
	}
	if($('date_from').value!='' && $('date_to').value!=''){
		to_date = $('date_to').value;
		var res_t_date = to_date.split("/");
		var toDate = new Date(res_t_date[2], res_t_date[0] - 1, res_t_date[1]);
		if(frmDate>toDate){
			return $("errordisplay").style.display="block",$("errordisplay").innerHTML="To date should be greater than or equal to From date",$("date_from").focus(),!1;
		}
	}
	
	url	= base_url+'edition/check_exam_status/' + $('course_id').value;
	myAjaxRequest = new Ajax.Request(url, {method:"get", onSuccess: submitMe, onFailure: errFun });
}

function errFun(){
	alert('Ann error occurred');
}
function submitMe(obj){
	if(obj.responseText=='E'){
		return $("errordisplay").style.display="block",$("errordisplay").innerHTML="Please disable the course and then continue with add edition",$("edition").focus(),!1;;
	}
	else {
		if($('default_edition').checked){
			alert('All the new registrants will fall under this edition as it is marked as default edition.');
		}
		$("frmAddEdition").submit();
	}
}

function clearSearch(){
	$('date_from').value = '';
	$('date_to').value = '';
	$('course_id').value = '';
}
function updateEdition(id){
	frm_date = $('date_from').value;
	var res_f_date = frm_date.split("/"); 
	var frmDate = new Date(res_f_date[2], res_f_date[0] - 1, res_f_date[1]);
	             
	if($('course_id').value==''){
		return $("errordisplay").style.display="block",$("errordisplay").innerHTML="Please select course",$("course_id").focus(),!1;
	}
	if($('edition').value==''){
		return $("errordisplay").style.display="block",$("errordisplay").innerHTML="Please enter edition number",$("edition").focus(),!1;
	}
	if($('edition').value<1){
		return $("errordisplay").style.display="block",$("errordisplay").innerHTML="Please enter valid edition number",$("edition").focus(),!1;
	}
	if($('date_from').value==''){
		return $("errordisplay").style.display="block",$("errordisplay").innerHTML="Please enter from date",$("date_from").focus(),!1;
	}
	if($('date_from').value!='' && $('date_to').value!=''){
		to_date = $('date_to').value;
		var res_t_date = to_date.split("/");
		var toDate = new Date(res_t_date[2], res_t_date[0] - 1, res_t_date[1]);
		if(frmDate>toDate){
			return $("errordisplay").style.display="block",$("errordisplay").innerHTML="To date should be greater than or equal to From date",$("date_from").focus(),!1;
		}
	}
	url	= base_url+'edition/check_exam_status/' + $('course_id').value;
	myAjaxRequest = new Ajax.Request(url, {method:"get", onSuccess: updateMe, onFailure: errFun });
	
	
}
function updateMe(obj){
	if(obj.responseText=='E'){
		return $("errordisplay").style.display="block",$("errordisplay").innerHTML="Please disable the course and then continue with add edition",$("edition").focus(),!1;;
	}
	else {
		if($('default_edition').checked){
			alert('All the new registrants will fall under this edition as it is marked as default edition.');
		}
		id = $('edit_id').value;
		$("frmEditEdition").action=base_url+"edition/edit/"+id;
		$("frmEditEdition").submit();
	}
}
function clearaddedit(){
	$('course_id').value = '';
	$('edition').value = '';
	$('date_from').value = '';
	$('date_to').value = '';
	$('date_to').value = '';
	$('default_edition').checked = false;
}