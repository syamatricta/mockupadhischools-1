var current_date;
function fncGetNextCalendar(timeid){
	$('hdnTimeid').value = timeid;
	$('hdnCurrentDate').value 	= '';
	$('adminscheduleform').submit();
}

function fncShowAdd(day,month,year){
	//scroll(0,0);	
	current_date 				= month+'/'+day+'/'+year;
	$('hdnCurrentDate').value 	= year+'/'+month+'/'+day;
	
	fncSetSelection(day);
	$('divPopUpDrag').innerHTML = 'Add Career Event';
	new Popup("divAddEvent",'',{modal:true,opacity:0,duration:0,hide_duration:0});
	$('divAddEvent').popup.show();
	
	getAjaxForAdd();
}

function getAjaxForAdd(){
	url				= base_url+'admin_career_event/add_event';
	
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

function fncCheckRepeatMode(){
	if($('txtRepeat').checked == true){
		$('divRepeat').style.display = 'block';
	}else{
		$('divRepeat').style.display = 'none';
	}
}

function fncHandleEvent(type){
	
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
	/*if(15 == $('sltCourses').value){
		if('' == $('capacity').value){
			$('capacity').focus();
			$('divError').innerHTML = 'Please enter capacity';
			return false;
		}
		if(!IsNumeric($('capacity').value)){
	        $('capacity').focus();
	        $('divError').innerHTML = 'Please enter valid capacity';
	        return false;
	    }
	}*/
	if('' == $('txtDateStart').value){
		$('txtDateStart').focus();
		$('divError').innerHTML = 'Please enter a date';
		return false;
	}
	if($('txtRepeat').checked == true){
		if('' == $('txtDateEnd').value){
			$('txtDateEnd').focus();
			$('divError').innerHTML = 'Repeat till date missing';
			return false;
		}
		
		if(compare_two_dates($('txtDateStart').value,$('txtDateEnd').value,'m/d/Y')==false){
			$('txtDateEnd').focus();
			$('divError').innerHTML = 'Incorrect repeat till date';
			return false;
		}
	}
	
	var time1 = $('sltFromHr').value+':'+$('sltFromMts').value+':'+$('sltFromAP').value;
	var time2 = $('sltToHr').value+':'+$('sltToMts').value+':'+$('sltToAP').value;
	
	if(fncCompareTime(time1,time2,'H:m:P')==false){
		$('divError').innerHTML = 'Incorrect timing';
		return false;
	}
	

	if(tinyMCE.get('txtContent').getContent()==''){
		tinyMCE.execCommand('mceFocus',false,'txtContent');
		$('divError').innerHTML = 'Chapter details missing';
		return false;
	}
	$('divError').innerHTML = '';
	if(type=='edit'){
            cnfrm = confirm('This operation will delete all scheduled details for this event, Do you want to continue?');
	}else{
		cnfrm = true;
	}
	if(cnfrm){
		$('txtWhat2Do').value 	= type;
		$('adminscheduleform').submit();
                //tinymce.EditorManager.execCommand('mceRemoveEditor',true, 'txtContent');
	}
}


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

function fncShowDefaultEvent(){
	var dateString 	= $('hdnCurrentDate').value;
	dateString		= dateString.split('/');
	fncShowEventList(dateString[2],dateString[1],dateString[0]);
}

function fncShowEventList(day,month,year){
	current_date 				= month+'/'+day+'/'+year; 
	$('hdnCurrentDate').value 	= year+'/'+month+'/'+day; 
	
	var url 		= base_url+'admin_career_event/display_list';
	var region 		= $('sltSearchRegion').value;
	var subregion 	= $('sltSearchSubregion').value;
	var params 		= "datecurrent="+current_date+"&region_id="+region+"&subregion_id="+subregion;
	
	fncSetSelection(day);
	
	$('divDisplayEventList').style.display 	= 'block';
	$('divDisplayEventList').innerHTML 		= 'Please wait ...<img src="'+base_url+'images/spinner.gif">';
	
	new Ajax.Request(url,
            { 
                method		:"post",
                parameters  : params,
                onSuccess	: fncDisplayList
            }
	);
	
}


//function used to change the selected dates color
function fncSetSelection(day){
	var arrayElem      = $('tblCalendarId').getElementsByTagName('td');								
	for (var i in arrayElem)
	{
		if (arrayElem[i].id)
		{ 
			if(i<arrayElem.length)
			{
				if (arrayElem[i].id != day)
				{
					$(arrayElem[i].id).removeClassName('selectedDay');
				}
				else if (arrayElem[i].id == day)
				{ 
					$(arrayElem[i].id).addClassName('selectedDay');
				}
			}
		}
	}
}
	
function fncDisplayList(obj){
	$('divDisplayEventList').innerHTML = obj.responseText;
	$('divDisplayEventList').scrollTo();
}
	
function fncViewEvents(mainid){
	
		
	$('divPopUpDrag').innerHTML = 'View Event';
	new Popup("divAddEvent",'',{modal:true,opacity:0,duration:0.3,hide_duration:0});
	$('divAddEvent').popup.show();
	
	var url	= base_url+'admin_career_event/view_event';
	getAjaxForViewEdit(mainid,url);
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
	
function fncDisplayEditEvents(mainid){	
	
	$('hdnMasterid').value 		= mainid;
	$('divPopUpDrag').innerHTML = 'Edit Event';
	
	new Popup("divAddEvent",'',{modal:true,opacity:0,duration:0.3,hide_duration:0});
	$('divAddEvent').popup.show();
	
	var url	= base_url+'admin_career_event/edit_event';
	getAjaxForViewEdit(mainid,url);
	
}

function fncEditEvent(){
	$('adminscheduleform').submit();
}
	
function fncDeleteEvent(masterid){
	var cnfrm = confirm('Do you want to delete the event(s)?');
	if(cnfrm){
            $('hdnMasterid').value 	= masterid;
            $('txtWhat2Do').value 	= 'delete';
	
            $('adminscheduleform').submit();
	}else{
            return false;
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
		
	if(mode1=='P' && mode2=='A'){
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
function showCapacity(){
        $('capacityDiv').hide();
}
function disable_refresh(e){	
    document.onkeydown = function (e) {
        if(e.which == 17 || e.which == 116){
                return false;
        }
    }
}


function fncBookingExport(){
    if($('txtSrchEvent').value > 0){
        $('user_export_form').method = "post";
        $('user_export_form').action = base_url+'admin_career_event/list_export_to_excel';
        $("user_export_form").submit();
    }else{
        $('flasherror').style.display = 'block';
        $('flasherror').innerHTML = "Please select Event";
    }
}