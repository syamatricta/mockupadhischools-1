/*cancel confirm */
var win;
var timer;
var wimpyWindow;
var countdown;
var netTimer;
var myAjaxRequest;
var gCallCount = 0;
var url_d = new Date();
var answerOptions = '<div id="answer-option-alphabet" class="floatleft answer-option-alphabet" >{{alphabet}}</div>'
    			  + '<div id="answer-option-text" class="floatleft answer-option-text" >{{option}}</div>';

    			  
var is_online	= true;// Internet connection available or not
var exam_data	= {};//new Array();
var exam_ended	= 0;
var sel_time	= 0;
var choice_val 	= '';
var question_view_at = new Array();

setTimeout("hideExamWarn()", 300000);
function hideExamWarn() {
    document.getElementById("exm_warn").style.display = "none";
}
function cancel_confirm(url){
	
	window.location=url;
}
/*password check */

function check_password(){
	
	if(is_field_empty("txt_password",'Please enter Password',"errordiv")==false){
		$('close_button').style.display     = "inline";
		return false;}else{
		$('errordiv').style.display     = "none";
        $('close_button').style.display     = "none";
	}
}
/* confirm */

function confirm_go(url){
	
	window.location=url;
}

/**********change*************/
function exam_rule(url){

    document.getElementById('hide_strt_btn').innerHTML = '<img src="'+base_url+'images/spinner.gif">';
    $('poptry').value=1;
    $('rule_form_adhi').action=base_url+"exam/exam_rule";
    $('rule_form_adhi').submit();
}


function exam_rule_start(url){
	if($('popup_blocked_status').value != '' && parseInt($('popup_blocked_status').value) == 0) {     
		document.getElementById('hide_strt_btn').innerHTML = '<img src="'+base_url+'images/spinner.gif">'; 
		url_mode	= base_url+'index.php/exam/change_exammode';	
		ajax_exam_mode(url,url_mode);
	}
}

/**********end **************/

function ajax_exam_mode(url,url_mode){	
	new Ajax.Request(url_mode,
                { 
                    method:"post",
                    onSuccess: check_exam_status
                }
    );	
}


function check_exam_status(obj) {
	if(obj.responseText =='false'){
		alert("You are allowed to take only one exam at a time");
	}else{
            //$('strtexm').style.display = 'none';
       	url	= base_url+'exam/exam_start/'+url_d.getTime();
		var form = document.createElement("form");
		form.setAttribute("method", "post");
		form.setAttribute("action", url);
		
		// setting form target to a window named 'formresult'
		form.setAttribute("target", "formresult");
		document.body.appendChild(form);
		
		// creating the 'formresult' window with custom features prior to submitting the form
		window.open('', 'formresult', 'scrollbars=yes,menubar=no,height=900,width=1500,resizable=no,toolbar=no,status=no,location=no');
		form.submit();
		document.getElementById('hide_strt_btn').innerHTML = '';
	}
}

/* start Exam */

function exam_action(url){
	$('examination_form_adhi').action=base_url+'exam/examination/n/'+	url;
	$('examination_form_adhi').submit();
	
}
function exam_action_previous(url){
	$('examination_form_adhi').action=base_url+'exam/examination/p/'+	url;
	$('examination_form_adhi').submit();
	
}

function timer(time_rem){
		
    //time_now	=	time_rem/60;
    hour		=	parseInt(time_rem/60);
    minute		=	time_rem % 60;
    second		=	$('second_hid').value;
    sel_time++;//for exam tracking
    offline_timer();
     if(hour=='0' && minute<='0' && second <=1)	{
		que	=	$('unique_page').value;
		//window.location=base_url+'index.php/exam/exam_end';
		clearTimeout(countdown);
		JSfncEndExam(0);
		return false;
   	}
   	if((minute*2) < 20)
   		 minute    ="0"+minute;
	if((second*2) < 20)
   		 second    ="0"+second;
   	if(hour=='00' && minute=='29'){ 
   		$('alert').innerHTML=" 30 minutes left";
   		$('divAlert').style.display = 'block';
   	}else{
		$('alert').innerHTML="";
		$('divAlert').style.display = 'none';
   	}
	if(hour=='00' && minute!='29'){
		if(hour=='00' && minute=='19'){
	   		$('alert').innerHTML=" 20 minutes left";
	   		$('divAlert').style.display = 'block';
		}else{
			$('alert').innerHTML="";
			$('divAlert').style.display = 'none';
		}
	}		
	if(hour=='00' && minute!='29' && hour=='00' && minute!='19'){
		if(hour=='00' && minute=='09'){
	   		$('alert').innerHTML=" 10 minutes left";
	   		$('divAlert').style.display = 'block';
		}else{
			$('alert').innerHTML="";
			$('divAlert').style.display = 'none';
		}
	}	
	
	if(hour=='00' && minute!='29' && hour=='00' && minute!='19' && hour=='00' && minute!='09'){
		if(hour=='00' && minute=='04'){
	   		$('alert').innerHTML=" 5 minutes left";
	   		$('divAlert').style.display = 'block';
		}else{
			$('alert').innerHTML="";
			$('divAlert').style.display = 'none';
		}	
	}
    time_remaining="0"+hour+":"+minute+":"+second+" hrs";
    $('latest').innerHTML=time_remaining;
    countdown = setTimeout("show_second()",1000);
       
    }


function show_second(){
	if($('timer_hid')){
		time_now	=	$('timer_hid').value;
	    second		=	$('second_hid').value;
	    sec			=	second-1;
	    if(sec==-1){
	    	 sec=59;
	    	 time_now	=	time_now-1;
	    	 $('timer_hid').value=time_now;
	    }
	    	
	    $('second_hid').value=sec;
	    timer(time_now);
	}
}



/* start Exam */

function exam_end(url){
	
	window.location= url+"/exam/exam_end";
	
}

function disable_rightClick(e){
	
	var message="Sorry, right-click has been disabled"; 
	/////////////////////////////////// 
	function clickIE() {if (document.all) {(message);return false;}} 
	function clickNS(e) {if 
	(document.layers||(document.getElementById&&!document.all)) { 
	if (e.which==2||e.which==3) {(message);return false;}}} 
	if (document.layers) 
	{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;} 
	else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;} 
	document.oncontextmenu=new Function("return false")
	
}

function ajax_update1(){	
	clearTimeout(netTimer);
	if(document.getElementById('divMode'))
		document.getElementById('divMode').innerHTML 	= 'Online';
	document.getElementById('hdnMode').value 		= 1;
	setTimeout("ajax_time_update1()",1000);
}

function ajaxFunction(obj){
	if(obj.responseText){
		if(obj.responseText=='session'){
			document.getElementById('examviewmain').innerHTML = '<div style="height:50px;"><font color="red">Your session has been expired due to inactivity. Please login again.</font></div>';
		}else{
			enable_offline_timer = false;
			changeOnlineStatus(true);
			if(is_online){
				//exam_data  = new Array();
			}
			ajax_update1();			
		}
	}else{
		if(!enable_offline_timer){
			enable_offline_timer = true;
		}
		JSfncOffline();
	}
}
function ajax_time_update1(){
	//a timer is set to 5 seconds to chekc if the connection is off or on
	netTimer = setTimeout("JSfncOffline()",10000);
	url	= base_url+'index.php/exam/ajax_update';
	//var jsonString 	= JSON.stringify({'exam_tracking_id' : eval(exam_tracking_id), 'exam_data' : exam_data});
	var is_online_num	= (is_online) ? 1 : 0;
	var jsonString 	= {'exam_tracking_id' : eval(exam_tracking_id), 'exam_data' : JSON.stringify(exam_data), 'is_online' :  is_online_num, 'exam_ended' : JSON.stringify({'ended' : exam_ended, 'time' : sel_time})};
	params	= jsonString;
	//var params 		= "jsonarray="+encodeURIComponent(jsonString);
	myAjaxRequest = new Ajax.Request(url,
	                { 
	                    method: "post",
	                    parameters: params,
	                    onSuccess: ajaxFunction,
	                    //asynchronous: true,
	                    onFailure: JSfncOffline
	                }
    );
    
}

function JSfncOffline(){
	changeOnlineStatus(false);
	// alert in the div abt offline
	clearTimeout(netTimer);
	myAjaxRequest.abort();
	if(document.getElementById('divMode'))
		document.getElementById('divMode').innerHTML 	= '<font color="red" >Offline</font>';
	if(document.getElementById('hdnMode'))
		document.getElementById('hdnMode').value 		= 0;
	setTimeout("ajax_time_update1()",1000);
}
       

function JSfncNextQuestion (){   
       
    var obj 		= eval(content); // content is defined inline in the view page
    var count 		= obj.counter;
	var total 		= obj.total;
	var check 		= parseInt(total)-1;
	var choice		= document.getElementById('choice').value;
	
	// add navigation
	if(obj.navigation < total && obj.navigation <= count) {
		obj.navigation++;
	}
	
	if(choice!=0){
		obj.answer[count] = choice;		
	}
	
	if(count == parseInt(check)){
		document.getElementById('divNext').style.display 	= 'none';
		document.getElementById('divEnd').style.display 	= 'block';
	}
	
	//Update exam_data object
	updateExamDataObj(obj.questionid[count]);
	
	if(parseInt(count) <= check){
		document.getElementById('divCounter').innerHTML 		= parseInt(count)+1;
		document.getElementById('divCounterTotal').innerHTML 	= parseInt(count)+1;
		count			= parseInt(count)+1;
		document.getElementById('divQuestion').innerHTML 	= obj.question[count];
				
		// Answer options
		document.getElementById('divOption_1').innerHTML	= answerOptions.replace('{{alphabet}}', 'A').replace('{{option}}', obj.option[count][1]);
		document.getElementById('divOption_2').innerHTML	= answerOptions.replace('{{alphabet}}', 'B').replace('{{option}}', obj.option[count][2]);
		document.getElementById('divOption_3').innerHTML	= answerOptions.replace('{{alphabet}}', 'C').replace('{{option}}', obj.option[count][3]);
		document.getElementById('divOption_4').innerHTML	= answerOptions.replace('{{alphabet}}', 'D').replace('{{option}}', obj.option[count][4]);
		
		obj.counter 										= count;		
		if(count>0){
			document.getElementById('divPrevious').style.visibility = 'visible';
		}			
		
		if(obj.answer[count]){
			document.getElementById('choice').value			= obj.answer[count];
			document.getElementById('option_'+obj.answer[count]).checked = 'checked';
		}else{
			document.getElementById('option_1').checked = '';
			document.getElementById('option_2').checked = '';
			document.getElementById('option_3').checked = '';
			document.getElementById('option_4').checked = '';
			document.getElementById('choice').value		= 0;
		}
		
		//Update exam_data object
		updateExamDataObj(obj.questionid[count]);
	}	
	
	JSfncUpdateScore();
}

function JSfncPreviousQuestion(){
	var obj 		= eval(content);
	var count 		= obj.counter;
	var choice		= document.getElementById('choice').value;
	var total 		= obj.total;
	var check 		= parseInt(total)-1;
	
	if(choice!=0)
		obj.answer[count] = choice;
	
	//Update exam_data object
	updateExamDataObj(obj.questionid[count]);
	
	if(count != parseInt(check)-1){
		document.getElementById('divEnd').style.display = 'none';
	}	
	if(parseInt(count) > 0){
		
		document.getElementById('divNext').style.display = 'block';
		count			= parseInt(count)-1;
		document.getElementById('divCounter').innerHTML 	= parseInt(count);
		document.getElementById('divCounterTotal').innerHTML= parseInt(count);
		document.getElementById('divQuestion').innerHTML 	= obj.question[count];
		
		// Answer options
		document.getElementById('divOption_1').innerHTML	= answerOptions.replace('{{alphabet}}', 'A').replace('{{option}}', obj.option[count][1]);
		document.getElementById('divOption_2').innerHTML	= answerOptions.replace('{{alphabet}}', 'B').replace('{{option}}', obj.option[count][2]);
		document.getElementById('divOption_3').innerHTML	= answerOptions.replace('{{alphabet}}', 'C').replace('{{option}}', obj.option[count][3]);
		document.getElementById('divOption_4').innerHTML	= answerOptions.replace('{{alphabet}}', 'D').replace('{{option}}', obj.option[count][4]);
		
		/*
		answerOptions.replace('{{alphabet}}', 'A').replace('{{option}}', obj.option[count][1])
		document.getElementById('divOption_1').innerHTML	= obj.option[count][1];
		document.getElementById('divOption_2').innerHTML	= obj.option[count][2];
		document.getElementById('divOption_3').innerHTML	= obj.option[count][3];
		document.getElementById('divOption_4').innerHTML	= obj.option[count][4];
		*/
		
		obj.counter 										= count;
		
		if(count==1)
		document.getElementById('divPrevious').style.visibility = 'hidden';
		
		if(obj.answer[count]){
			document.getElementById('choice').value			= obj.answer[count];
			document.getElementById('option_'+obj.answer[count]).checked = 'checked';
		}else{
			document.getElementById('option_1').checked = '';
			document.getElementById('option_2').checked = '';
			document.getElementById('option_3').checked = '';
			document.getElementById('option_4').checked = '';
			document.getElementById('choice').value		= 0;
		}
		
		//Update exam_data object
		updateExamDataObj(obj.questionid[count]);
	}
	JSfncUpdateScore();
}

/**
 * Goto selected question
 * Function will load the corresponding question
 * @access public
 */
function gotoQuestion()
{
	var obj = eval(content); // content is defined inline in the view page
	var count = obj.counter;
	var total = obj.total;
	var check = parseInt(total)-1;
	var choice = document.getElementById('choice').value;
	
	// Update previous answer
	if(choice!=0){
		obj.answer[count] = choice;
	}
	
	//Update exam_data object
	updateExamDataObj(obj.questionid[count]);
	
	// Get question value enter by user
	var questionNumber = parseInt(document.getElementById('jumpToQuestion').value);
	
	
	// Validate question number
	if(questionNumber === ''  ){
		return false;
	}
	
	// if question is the last question show end exam link
	if(questionNumber == parseInt(check)){
		document.getElementById('divNext').style.display 	= 'none';
		document.getElementById('divEnd').style.display 	= 'block';
	} else {
		document.getElementById('divNext').style.display 	= 'block';
		document.getElementById('divEnd').style.display 	= 'none';
	}
	
	// Show and hide previous button
	if(questionNumber == 0){
		document.getElementById('divPrevious').style.visibility = 'hidden';
	} else {
		document.getElementById('divPrevious').style.visibility = 'visible';
	}
	
	//if(parseInt(count) <= check){
	if(parseInt(questionNumber) <= check){
		document.getElementById('divCounter').innerHTML 		= parseInt(questionNumber)+1;
		document.getElementById('divCounterTotal').innerHTML 	= parseInt(questionNumber)+1;
		
		//count			= parseInt(count)+1;
		count = parseInt(questionNumber)+1;
		
		document.getElementById('divQuestion').innerHTML = obj.question[count];
				
		// Answer options
		document.getElementById('divOption_1').innerHTML = answerOptions.replace('{{alphabet}}', 'A').replace('{{option}}', obj.option[count][1]);
		document.getElementById('divOption_2').innerHTML = answerOptions.replace('{{alphabet}}', 'B').replace('{{option}}', obj.option[count][2]);
		document.getElementById('divOption_3').innerHTML = answerOptions.replace('{{alphabet}}', 'C').replace('{{option}}', obj.option[count][3]);
		document.getElementById('divOption_4').innerHTML = answerOptions.replace('{{alphabet}}', 'D').replace('{{option}}', obj.option[count][4]);
		
		// Updating counter
		obj.counter = count;
		
		if(obj.answer[count]){
			document.getElementById('choice').value = obj.answer[count];
			document.getElementById('option_'+obj.answer[count]).checked = 'checked';
		}else{
			document.getElementById('option_1').checked = '';
			document.getElementById('option_2').checked = '';
			document.getElementById('option_3').checked = '';
			document.getElementById('option_4').checked = '';
			document.getElementById('choice').value		= 0;
		}
		//Update exam_data object
		updateExamDataObj(obj.questionid[count]);
	}
	
	// Updating schore
	JSfncUpdateScore();
}

/**
 * Jump to question drop box
 * Function to genarate jump to question drop box
 * @acces public
 * 
 */
function questionDropBox()
{
	var obj = eval(content); // content is defined inline in the view page
	//var selectStr = '<option value={{value}}>{{text}}</option>\n';
	var returnStr = "";
	var ele = document.getElementById('jumpToQuestion');
	var selectedQuestion = '';
	var questionArray = new Array();
	
	// Get the selected value from dropbox
	selectedQuestion = ele.value;
	
	ele.options.length = null;
	
	ele.options[ele.options.length] = new Option('--', 0);
	// populate options
	for(i=1; i<= obj.navigation; i++){
		option_value = parseInt(i)-1;
		ele.options[ele.options.length] = new Option(i, option_value );
	}
	
	// set current question
	//ele.value = selectedQuestion;
	ele.value = parseInt(obj.counter) - 1;
	return;
}


function JSfncEndExam(endexm){
	if(endexm==1){
		if(!confirm('Do you really want to end this exam?')){
			return false;
		}
	}	
	document.getElementById('spinID').innerHTML = '<img src="'+base_url+'images/spinner.gif">';
	var obj 		= eval(content); // content is defined inline in the view page
	var count 		= obj.counter;
	var choice		= document.getElementById('choice').value;
	
	if(choice!=0){
		obj.answer[count] = choice;
	}	
	sec_left = 59;
	tot_left = 60*2;
	min_left = 1;
	new PeriodicalExecuter(function(pe) {
	  var mode = document.getElementById('hdnMode').value;
	  //if the counter has reached the maximum allotted time to expire is net connection is not available. here it is 30 mts
	 gCallCount++;
	 
	  if (gCallCount > (60*2)){
	    	clearInterval(countdown);
			document.getElementById('examviewmain').innerHTML = '<div style="height:50px;"><div style="height:50px;color: #FF0000;font-size: 17px;line-height: 25px;padding: 35px;text-align:left;">We are sorry, timeout. No internet connection is available. Hence your scores cannot be updated.</div></div>';
		 	pe.stop();
		 	
	  }else{
	  	//if it is offline it just displays a message
	  	exam_ended				= 1;
	    if( mode == 0){
	    	updateExamDataObj(obj.questionid[count]);
	    	/*if(min_left==0){
	    		disp_left_val = sec_left+' seconds';
	    	}else{*/
	    		disp_left_val = min_left+' minutes'+' '+sec_left+' seconds';
	    	//}
	    	document.getElementById('examviewmain').innerHTML = '<div style="height:50px;color: #FF0000;font-size: 17px;line-height: 25px;padding: 35px;text-align:left;"><img class="oa_img" src=\"'+base_url+'images/warn.png\">The exam is in offline mode due to internet connection unavailability.<br>Please wait, so that we can update your exam scores if internet connection is available within '+disp_left_val+'.</div>';
	    	tot_left--;
	    	if(tot_left % 60==0){
	    		min_left--;
	    		sec_left = 60;
	    	}	    	
	    	sec_left--;
	    	hideExamWarn();
	    }else{
	    	updateExamDataObj(obj.questionid[count]);
			//if it is online, it redirects to result page
	        pe.stop();
	        
	        /* update whole exam data once again */
	        var is_online_num		= (is_online) ? 1 : 0;
	        var exam_jsonString 	= "&exam_tracking_id="+ eval(exam_tracking_id)+"&exam_data="+JSON.stringify(exam_data)+"&is_online="+is_online_num+'&exam_ended='+JSON.stringify({'ended': exam_ended, 'time' : sel_time});
	        
	        var jsonString 	= JSON.stringify(content);
			var params 		= "jsonarray="+encodeURIComponent(jsonString)+exam_jsonString;
			var url			= base_url+"exam/update_score";
			new Ajax.Request(url,
		                { 
		                    method		:"post",
		                    parameters  : params,
		                    onSuccess   : fncCheck
		                }
		    );
			//window.location = base_url+'index.php/exam/exam_end';
	    }
	  }
	}, 1);
	ajax_time_update1();//for checking the net
	switchon_offline_timer = false;//dont need to execute offline message timer
}

function JSfncUpdateScore(){
	var mode = document.getElementById('hdnMode').value;
	if(1==mode){
		var jsonString 	= JSON.stringify(content);
		var params 		= "jsonarray="+encodeURIComponent(jsonString);
		var url			= base_url+"exam/update_score";
                var url                 = 
                new Ajax.Request(url,
	                { 
	                    method		:"post",
	                    parameters  : params
	                }
	    );
	}
	
	// Update question dropbox on exam page
	questionDropBox();
	/*if(1==mode){
	
		var url			= base_url+"exam/update_time";
		new Ajax.Request(url,
	                { 
	                    method		:"post",
	                    onSuccess   : fnc_update_time
	                }
	    );
	}	*/
}

function addslashes( str ) {
    return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
}
function fnc_update_time (obj){
	timer(obj.responseText);
}
function fncCheck(obj){
	
	window.location = base_url+'index.php/exam/exam_end';
}

function JSfncSetValue(val){
	document.getElementById('choice').value = val;
	choice_val	= val;
}

/* Set is user is online or not (online - true/false)*/
function changeOnlineStatus(online){
	is_online = online;
}

function updateExamDataObj(question_id){	
	var obj 		= eval(content); // content is defined inline in the view page
    var count 		= obj.counter;
	online			= is_online ? 1 : 0;
	if(obj.answer[count]){
		//for the first question
		if(undefined == question_view_at[question_id]){
			question_view_at[question_id]	= 0;
		}		
		exam_data[question_id]	= { 'option_id' : obj.optionid[count][choice_val], 'online' : online, 'view_at' : question_view_at[question_id], 'answer_at' : sel_time};
	}else{
		exam_data[question_id]	= { 'online' : online, 'view_at' : sel_time};
		question_view_at[question_id]	= sel_time;
	}
}


/* Offline message showing timer start here */

var switchon_offline_timer	= true; // enable all offline timer, it will false during end exam
var enable_offline_timer	= false; // will true if offline and will false when return back to online
var offline_interval		= 1*60;//eval(offline_interval_time);//15*60; // in seconds - set in siteconfig.php - 15min
var offline_countdown		= offline_interval;
var auto_close_start		= false;
var auto_close_time			= 0;
function offline_timer(){
	if(switchon_offline_timer){
		if(enable_offline_timer){
			if(offline_countdown > 0){
				offline_countdown--;
				if(0 == offline_countdown){				
					offlineMessage('show');
				}
			}
			if(auto_close_start){
				auto_close_time++;
				if(auto_close_time >= 10){ //automatically hide the offline message
					offlineMessage('hide');
				}
			}
		}else if('block' == document.getElementById('offline_alert').style.display){
			offlineMessage('hide');
			
		}
	}
}
function offlineMessage(cond){
	if('show' == cond){
		var html	= '<img class="oa_img" src=\"'+base_url+'images/warn.png\">You are currently offline!<br><div class=\"oa_msg_step2\">Please connect back to internet to score your exam.<br> Don\'t refresh your exam window.<br/>System will automatically detect and score if you go online.<br/><input type=\"button\" value=\"Continue Exam\" class=\"oa_btn\" onclick=\"offlineMessage(\'hide\')\">';
		document.getElementById('offline_alert').innerHTML			= html;
		document.getElementById('offline_alert').style.display 		= 'block';
		document.getElementById('examdetmainview').style.display 	= 'none';
		document.getElementById('spinID').style.display 			= 'none';
		auto_close_start = true;
	}else{
		document.getElementById('offline_alert').style.display 		= 'none';
		document.getElementById('examdetmainview').style.display 	= 'block';
		document.getElementById('spinID').style.display 			= 'block';
		offline_countdown = offline_interval;
		auto_close_start	= false;
		auto_close_time		= 0;
	}
}
/* Offline message showing timer end here */