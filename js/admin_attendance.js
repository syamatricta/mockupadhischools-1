/** populates a select box dynamically using Json array**/
function fncGetSubregion(main,sub){
			
	var numb 		= $(main).value;
	var obj 		= eval(content);
        
	if(obj != ''){
		$(sub).options.length	= null;
		$(sub).options[$(sub).options.length] = new Option('Select',0);
		if(obj.R[numb]){
			
			obj.R[numb].each(function(n){
				$(sub).options[$(sub).options.length] = new Option(n.name,n.id);  
			});
		}
	}
}

// function to compare 2 dates
function compare_two_dates(start_date,end_date,format)
{ 
	start_date		= start_date;
	var point1		= 0;
	var point2		= 0;
	var arrDate1 	= start_date.split("/");
	var arrDate2 	= end_date.split("/");
	
	if(format =='m/d/Y'){
		//start date
		var month1	= arrDate1[0]; 
		var day1	= arrDate1[1]; 
		var year1	= arrDate1[2];
		//end date
		var month2	= arrDate2[0]; 
		var day2	= arrDate2[1]; 
		var year2	= arrDate2[2];
	}else if(format=='Y/m/d'){
		//start date
		var year1	= arrDate1[0];
		var month1	= arrDate1[1]; 
		var day1	= arrDate1[2]; 
		
		//end date
		var year2	= arrDate2[0];
		var month2	= arrDate2[1]; 
		var day2	= arrDate2[2]; 
	}
	else{
		//default format 'd/m/Y'
		var day1	= arrDate1[0]; 
		var month1	= arrDate1[1]; 
		var year1	= arrDate1[2];
		//end date
		var day2	= arrDate2[0]; 
		var month2	= arrDate2[1]; 
		var year2	= arrDate2[2];
	}
	
	var year1 		= parseInt(year1);
	var year2 		= parseInt(year2);
	
	if(year1>year2){
		point1++; 
	}
	else if(year1<year2){
		point2++;
	}
	else{
		point1++;point2++;			
	}
	
	if(month1>month2 && point1>0){
		point1++; 
	}
	else if(month1<month2 && point2>0){
		point2++; 
	}
	else{
		point1++;point2++;
	}
	
	if(day1>day2 && point1>1){ 
		point1++; 
	}
	else if(day1<day2 && point2>1){
		point2++;
	}
	else{
		point1++;point2++;
	}	
	
	if(point1>point2 ){
		return false;
	}
	else{
		return true;
	}
}
	
function fncCompareTime(start_time,end_time,format){
	
	var arrTime1 	= start_time.split(":");
	var arrTime2 	= end_time.split(":");
	
	if(format=='H:m:P'){ //hour:minutes:(am/pm)
		
		//start time
		var hour1	= parseFloat(arrTime1[0]); 
		var mts1	= parseFloat(arrTime1[1]); 
		var mode1	= arrTime1[2];
		//end time
		var hour2	= parseFloat(arrTime2[0]); 
		var mts2	= parseFloat(arrTime2[1]); 
		var mode2	= arrTime2[2];
	}
		
	if(mode1=='PM' && mode2=='AM'){
		return false;
	}
	if(mode1==mode2){
		
		if(hour1>hour2)
			return false;
		
		if(hour1==hour2 && mts1==mts2)
			return false;
			
		if(hour1==hour2 && mts1>mts2)
			return false;
	}
	return true;
}

function disable_refresh(e){	
    document.onkeydown = function (e) {
        if(e.which == 17 || e.which == 116){
                return false;
        }
    }
}

function isValidTimeRange(){
    
    var start_time = $('txtDateStart').value+' '+$('sltFromHr').value+':'+$('sltFromMts').value;
    start_time = ('AM' == $('sltFromAP').value) ? start_time+' AM' : start_time+' PM';
    
    var end_time = $('txtDateStart').value+' '+$('sltToHr').value+':'+$('sltToMts').value;
    end_time = ('AM' == $('sltToAP').value) ? end_time+' AM' : end_time+' PM';
    
    start_time = Date.parse(start_time);
    end_time = Date.parse(end_time);
    
    if (start_time >= end_time){
        return false;
    }
    return true;
}

function fncHandleEvent(type){
	$('flashsuccess').innerHTML= "";
        
	if(0 == $('sltRegion').value){
		$('sltRegion').focus();
		$('divError').innerHTML = 'Please select a region';
		return false;
	}
	if(0 == $('sltSubregion').value){
		$('sltSubregion').focus();
		$('divError').innerHTML = 'Please select a subregion';
		return false;
	}
        if(0 == $('sltCourses').value){
		$('sltCourses').focus();
		$('divError').innerHTML = 'Please select a course';
		return false;
	}
	if(0 == $('instructor').value){
		$('instructor').focus();
		$('divError').innerHTML = 'Please select instructor';
		return false;
	}
	if('' == $('txtDateStart').value){
		$('txtDateStart').focus();
		$('divError').innerHTML = 'Please enter a date';
		return false;
	}
        
        if(isFutureDate($('txtDateStart').value)){
                $('txtDateStart').focus();
		$('divError').innerHTML = 'Please do not enter a future date';
		return false;
        }
	
	var time1 = $('sltFromHr').value+':'+$('sltFromMts').value+':'+$('sltFromAP').value;
	var time2 = $('sltToHr').value+':'+$('sltToMts').value+':'+$('sltToAP').value;
	
	//if(fncCompareTime(time1,time2,'H:m:P')==false){
	if(isValidTimeRange()==false){
		$('divError').innerHTML = 'Incorrect timing';
		return false;
	}
	
        if('' == $('txtAttendance').value){
		$('txtAttendance').focus();
		$('divError').innerHTML = 'Please enter attendance count';
		return false;
	}
        
        if(!IsNumeric($('txtAttendance').value)){
            $('txtAttendance').focus();
            $('divError').innerHTML = 'Please enter valid attendance count';
            return false;
        }
        
        if('' == $('titled_guests').value){
		$('titled_guests').focus();
		$('divError').innerHTML = 'Please enter guest count';
		return false;
	}
        
        if(!IsNumeric($('titled_guests').value)){
            $('titled_guests').focus();
            $('divError').innerHTML = 'Please enter valid guest count';
            return false;
        }
        
        /*if('edit' == type){
            if(tinyMCE.get('txtContent').getContent()==''){
                    tinyMCE.execCommand('mceFocus',false,'txtContent');
                    $('divError').innerHTML = 'Notes missing';
                    return false;
            }
        }*/
        
	$('divError').innerHTML = '';
        $('txtWhat2Do').value 	= type;
        $('addattendanceform').submit();
        //tinymce.EditorManager.execCommand('mceRemoveEditor',true, 'txtContent');
}

function gotolist(a){
    a?$("frmadhischool").action=base_url+"index.php/attendance_report/list_report_details/"+a:$("frmadhischool").action=base_url+"index.php/attendance_report/list_report_details/";
    $("frmadhischool").submit()
}

function fncAttendanceFilter(a, b, region, sub_region, course, instructor) {
    "" == a && (a = 0);
    
    var date1 = new Date(a);
    var date2 = new Date(b);
    var timeDiff = date2.getTime() - date1.getTime();
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
  
    if ("" != a && diffDays < 0) return $("errordisplay").style.display = "block", $("errordisplay").innerHTML = "Please select a valid date range", $("search_date_from").focus(), !1;
    b && (date_to = date_change_format(b));
    date_from = a ? date_change_format(a) : a;

    //$("adminreportlistform").action = base_url + "index.php/attendance_report/list_report_details/" + date_from + "/" + date_to + "/" + region+ "/" + sub_region + "/" + course + "/" + instructor;
    $("adminreportlistform").action = base_url + "index.php/attendance_report/list_report_details/";
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

function fncAttendanceExport(a, b, region, sub_region, course, instructor) {
    "" == a && (a = 0);
    
    var date1 = new Date(a);
    var date2 = new Date(b);
    var timeDiff = date2.getTime() - date1.getTime();
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
    
    if ("" != a && diffDays < 0) return $("errordisplay").style.display = "block", $("errordisplay").innerHTML = "Please select a valid date range", $("search_date_from").focus(), !1;
    b && (date_to = date_change_format(b));
    date_from = a ? date_change_format(a) : 0;

    $("adminreportlistform").action = base_url + "index.php/attendance_report/list_report_details_excel/" + date_from + "/" + date_to + "/" + region+ "/" + sub_region + "/" + course + "/" + instructor;
    $("adminreportlistform").submit();
} 

function fncDeleteAttendance(masterid){
    if(confirm('Do you want to delete this ?')){
        var url			= base_url+'index.php/attendance_report/delete_attendance';
	var params 		= "masterid="+masterid;
	$('rowVal_'+masterid).remove();
        
	new Ajax.Request(url,
            { 
                method		: "post",
                parameters  : params,
                evalScripts : true,
                onSuccess	: deleteAttendanceInterface
            }
        );
    }else{
        return false;
    }
}

function deleteAttendanceInterface(){
    alert("Deleted Successfully");
    window.location.reload();
}









/*
function fncUpdateactivatingrecruiter(a){
    recruiterid=$("hidrecruiterid").value;
    if(!1==is_field_empty("txtReasonAct","Please enter reason for activating","errordisplays"))return!1;
    confirm("Do you really want to activate the recruiter with this reason?")&&($("frmadhischool").action=base_url+"index.php/admin_recruiter/activate_recruiter/"+recruiterid+"/"+a,$("frmadhischool").submit())
}

function getAjaxForAdd(){
	url				= base_url+'index.php/admin_schedule/add_event';
	
	var region 		= $('sltSearchRegion').value;
	var subregion 	= $('sltSearchSubregion').value;
	var params 		= "datecurrent="+current_date+"&region_id="+region+"&subregion_id="+subregion;
	
	new Ajax.Request(url,
                { 
                    method		: "post",
                    parameters  : params,
                    evalScripts : true,
                    onSuccess	: ajaxDisplayEventInterface
                }
    );
}

function ajaxDisplayEventInterface(obj){
	//scroll(0,0);
	$('divContent').innerHTML 	= '';
	$('divContent').innerHTML 	= obj.responseText;
	
	if($('txtContent')){
		tinyMCE.execCommand('mceAddControl', false, 'txtContent');}
		
	if($('sltRegion')){
		$('sltRegion').focus();
	}
}


	
function getAjaxForViewEdit(mainid,url){

	var params 		= "main_id="+mainid;
	
	new Ajax.Request(url,
	            { 
	                method		: "post",
	                parameters  : params,
	                onSuccess	: ajaxDisplayEventInterface
	            }
	);
}
	
function fncDisplayEditEvents(mainid,course_id){	
	
	$('hdnMasterid').value 		= mainid;
	$('divPopUpDrag').innerHTML = 'Edit Event';
	
	new Popup("divAddEvent",'',{modal:true,opacity:0,duration:0.3,hide_duration:0});
	$('divAddEvent').popup.show();
	
	var url	= base_url+'index.php/admin_schedule/edit_event';
	getAjaxForViewEdit(mainid,url);
	
}

function fncEditEvent(){
    $('addattendanceform').submit();
}
*/	

function isFutureDate(idate){
    var today = new Date().getTime(),
    idate = idate.split("/");

    idate = new Date(idate[2], idate[0] - 1, idate[1]).getTime();
    return (today - idate) < 0 ? true : false;
}

function removeFile(){
    $('report').value = '';
    $('fileRemoved').value = 1;
    $('removeFile').hide();
    $('imageDiv').remove();
}

function fileChanged(){
    $('removeFile').show();
    $('fileRemoved').value = 0;
}


window.onload = function(){
    $('removeFile').hide();
    var what = $('txtWhat2Do').value;
    
    if("add" == what){
        if("" != $('report').value){
            $('removeFile').show();
        }
    }else{
        var ss = $('imageDiv');
        if (typeof(ss) != 'undefined' && ss != null){
          $('removeFile').show();
        }
    }
}