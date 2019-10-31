;
var effect_slide = null;
var answerOptions = '<div id="answer-option-alphabet" class="floatleft answer-option-alphabet" >{{alphabet}}</div>'
    			  + '<div id="answer-option-text" class="floatleft answer-option-text" >{{option}}</div>';
var selAnsId = '<input type="radio" value="{{sel_answer}}" id="option_{{sel_answer_id}}" name="right_ans" onclick="javascript: JSfncSetValue({{sel_answer_pass}});">';
var divVideo = '<div id="quiz-video"></div>';
var divQuizExit = '<a href="javascript:void(null);" onclick="javascript: quiz_exit({{quiz_sl_no}});return false;"><img  src="'+base_url+'images/innerpages/endquiz.jpg" /></a>';
var current_user_type;
function show_quizList(a) {
    window.location = a
}

function quiz_rule() {
    if($('popup_blocked_status').value != '' && parseInt($('popup_blocked_status').value) == 0) {     
		document.getElementById('hide_strt_btn').innerHTML = '<img src="'+base_url+'images/spinner.gif">'; 
		ajax_quiz_mode();
	}
}

function quiz_rule_check(a, b, c) {
	document.getElementById('hide_strt_btn').innerHTML = '<img src="'+base_url+'images/spinner.gif">';
    $("poptry").value = 1;
    a = $("hdnQuizNo").value;
    var url  = ('trial' == current_user_type) ? "trial_quiz/quizrule/" : "quiz/quizrule/";
    $("confirm_password_form_adhi").action = base_url + url + b + "/" + c + "/" + a;    
    $("confirm_password_form_adhi").submit()
}

function disable_rightClick() {
    function a() {
        if (document.all) return c, !1
    }

    function b(a) {
        if (document.layers || document.getElementById && !document.all)
            if (2 == a.which || 3 == a.which) return c, !1
    }
    var c = "Sorry, right-click has been disabled";
    document.layers ? (document.captureEvents(Event.MOUSEDOWN), document.onmousedown = b) : (document.onmouseup = b, document.oncontextmenu = a);
    document.oncontextmenu = new Function("return false")
}
function JSfncNextQuizQuestion (){   
       
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
		document.getElementById('divRadio_1').innerHTML	= selAnsId.replace('{{sel_answer}}', obj.optionid[count][1]).replace('{{sel_answer_id}}', obj.optionid[count][1]).replace('{{sel_answer_pass}}', obj.optionid[count][1]);
		document.getElementById('divRadio_2').innerHTML	= selAnsId.replace('{{sel_answer}}', obj.optionid[count][2]).replace('{{sel_answer_id}}', obj.optionid[count][2]).replace('{{sel_answer_pass}}', obj.optionid[count][2]);
		document.getElementById('divRadio_3').innerHTML	= selAnsId.replace('{{sel_answer}}', obj.optionid[count][3]).replace('{{sel_answer_id}}', obj.optionid[count][3]).replace('{{sel_answer_pass}}', obj.optionid[count][3]);
		document.getElementById('divRadio_4').innerHTML	= selAnsId.replace('{{sel_answer}}', obj.optionid[count][4]).replace('{{sel_answer_id}}', obj.optionid[count][4]).replace('{{sel_answer_pass}}', obj.optionid[count][4]);
		document.getElementById('videoDiv').innerHTML	= divVideo;		
		document.getElementById('quizExit').innerHTML	= divQuizExit.replace('{{quiz_sl_no}}', parseInt(count));		
		if(obj.video_url[count]!=''){
			jwplayer("quiz-video").setup({
	 								flashplayer: base_url+"/js/jwplayer/player.swf?file="+obj.video_url[count],
	 								file: obj.video_url[count],
	 								width: '275',
	 								height: '200'
		 						});
		}
		$$("span.help").each( function(link) {
			new Tooltip_new(link, {mouseFollow: true,delay : 60});
		});
		 						
		obj.counter 										= count;		
		if(count>0){
			document.getElementById('divPrevious').style.visibility = 'visible';
		}			
		
		if(obj.answer[count]){
			document.getElementById('choice').value			= obj.answer[count];
			document.getElementById('option_'+obj.answer[count]).checked = 'checked';
		}else{
			/*document.getElementById('option_1').checked = '';
			document.getElementById('option_2').checked = '';
			document.getElementById('option_3').checked = '';
			document.getElementById('option_4').checked = '';*/
			document.getElementById('choice').value		= 0;
		}
	}
	JSfncUpdateQuizScore();
}
function JSfncPreviousQuizQuestion(){
	var obj 		= eval(content);
	var count 		= obj.counter;
	var choice		= document.getElementById('choice').value;
	var total 		= obj.total;
	var check 		= parseInt(total)-1;
	
	if(choice!=0)
		obj.answer[count] = choice;
		
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
		document.getElementById('divRadio_1').innerHTML	= selAnsId.replace('{{sel_answer}}', obj.optionid[count][1]).replace('{{sel_answer_id}}', obj.optionid[count][1]).replace('{{sel_answer_pass}}', obj.optionid[count][1]);
		document.getElementById('divRadio_2').innerHTML	= selAnsId.replace('{{sel_answer}}', obj.optionid[count][2]).replace('{{sel_answer_id}}', obj.optionid[count][2]).replace('{{sel_answer_pass}}', obj.optionid[count][2]);
		document.getElementById('divRadio_3').innerHTML	= selAnsId.replace('{{sel_answer}}', obj.optionid[count][3]).replace('{{sel_answer_id}}', obj.optionid[count][3]).replace('{{sel_answer_pass}}', obj.optionid[count][3]);
		document.getElementById('divRadio_4').innerHTML	= selAnsId.replace('{{sel_answer}}', obj.optionid[count][4]).replace('{{sel_answer_id}}', obj.optionid[count][4]).replace('{{sel_answer_pass}}', obj.optionid[count][4]);
		document.getElementById('videoDiv').innerHTML	= divVideo;
		document.getElementById('quizExit').innerHTML	= divQuizExit.replace('{{quiz_sl_no}}', parseInt(count));
		if(obj.video_url[count]!=''){
			jwplayer("quiz-video").setup({
	 								flashplayer: base_url+"/js/jwplayer/player.swf?file="+obj.video_url[count],
	 								file: obj.video_url[count],
	 								width: '275',
	 								height: '200'
		 						});
		}
		$$("span.help").each( function(link) {
			new Tooltip_new(link, {mouseFollow: true,delay : 60});
		});
		
		obj.counter 										= count;
		
		if(count==1)
		document.getElementById('divPrevious').style.visibility = 'hidden';		
		if(obj.answer[count]){
			document.getElementById('choice').value			= obj.answer[count];
			document.getElementById('option_'+obj.answer[count]).checked = 'checked';
		}else{
			/*document.getElementById('option_1').checked = '';
			document.getElementById('option_2').checked = '';
			document.getElementById('option_3').checked = '';
			document.getElementById('option_4').checked = '';*/
			document.getElementById('choice').value		= 0;
		}
	}
	JSfncUpdateQuizScore();
}
function JSfncSetValue(val){
	document.getElementById('choice').value = val;
}
function quiz_action(a) {
    document.getElementById('divEnd').innerHTML = '<img src="'+base_url+'images/spinner.gif">';
    var url  = ('trial' == current_user_type) ? "trial_quiz/quizpage/n/" : "quiz/quizpage/n/";
    $("quiz_form_adhi").action = base_url + url + a;
    $("quiz_form_adhi").submit()
}
function JSfncUpdateQuizScore(){
	var mode = document.getElementById('hdnMode').value;
	if(1==mode){
		var jsonString 	= JSON.stringify(content);
		var params 		= "jsonarray="+encodeURIComponent(jsonString);
                var url                 = ('trial' == current_user_type) ? "trial_quiz/update_score" : "quiz/update_score";
		url			= base_url + url;
                
                new Ajax.Request(url,
	                { 
	                    method		:"post",
	                    parameters  : params
	                }
                );
	}
}
function quiz_action_previous(a) {
    var url = ('trial' == current_user_type) ? "trial_quiz/quizpage/p/" : "quiz/quizpage/p/";
    $("quiz_form_adhi").action = base_url + url + a;
    $("quiz_form_adhi").submit()
}

function quiz_exit(a) {
    if (!confirm('Do you really want to end this quiz?')) {
        return false;
    }
    document.getElementById('quizExit').innerHTML = '<img src="'+base_url+'images/spinner.gif">';
    var url = ('trial' == current_user_type) ? "trial_quiz/quizpage/n/" : "quiz/quizpage/n/";
    $("quiz_form_adhi").action = base_url + url + a + "/E";
    $("quiz_form_adhi").submit()
}

function cancel_confirm(a) {
    window.location = a
}

function ajax_update() {
    setTimeout("ajax_time_update()", 1E3)
}

function ajax_time_update() {
    var url = ('trial' == current_user_type) ? "trial_quiz/quiz_update" : "quiz/quiz_update";
    url     = base_url + url;
    new Ajax.Request(url, {
        method: "post",
        onSuccess: ajax_update
    })
}

function ajax_quiz_mode(a, b) {
    var url = ('trial' == current_user_type) ? "trial_quiz/change_quizmode" : "quiz/change_quizmode";
    url     = base_url + url;
    new Ajax.Request(url, {
        method: "post",
        onSuccess: check_quiz_status
    })
}

function check_quiz_status(a) {
    var screenW = 1400, screenH = 800;
    if (parseInt(navigator.appVersion)>3) {
     screenW = screen.width;
     screenH = screen.height-100;
    }
    else if (navigator.appName == "Netscape" 
        && parseInt(navigator.appVersion)==3
        && navigator.javaEnabled()
       ) 
    {
     var jToolkit = java.awt.Toolkit.getDefaultToolkit();
     var jScreenSize = jToolkit.getScreenSize();
     screenW = jScreenSize.width;
     screenH = jScreenSize.height-100;
    }
    var url = ('trial' == current_user_type) ? "trial_quiz/quiz_start" : "quiz/quiz_start";
    document.getElementById('hide_strt_btn').innerHTML = '';
    "false" == a.responseText ? alert("You are allowed to take only one quiz at a time") : (url = base_url + url, a = document.createElement("form"), a.setAttribute("method", "post"), a.setAttribute("action", url), a.setAttribute("target", "formresult"), document.body.appendChild(a), window.open("", "formresult", "scrollbars=yes,menubar=no,height="+screenH+",width="+screenW+",resizable=no,toolbar=no,status=no,location=no"), a.submit())
}

function JSfncSlideDown() {
    effect_slide = Effect.SlideDown("divQuizlist", {
        duration: 0.8,
        fps: 40
    });
    setTimeout("JSfncChangeMode('U')", 700);
    return !1
}

function JSfncSlideUp() {
    effect_slide = Effect.SlideUp("divQuizlist", {
        duration: 0.8
    });
    setTimeout("JSfncChangeMode('D')", 700);
    return !1
}

function JSfncChangeMode(a) {
    "U" == a ? ($("divPlus").style.display = "none", $("divMinus").style.display = "block") : ($("divMinus").style.display = "none", $("divPlus").style.display = "block")
}

function JSfncSetQuiz(a) {
    $("hdnQuizId").value = a
}

function JSfncChangeQuiz(a) {
    var b = $("hdnQuizId").value;
    if (0 == b) return alert("Please choose a quiz"), !1;
    
    var url = ('trial' == current_user_type) ? "trial_quiz/change_quiz/" : "quiz/change_quiz/";
    url_mode = base_url + url + b;
    $(a).action = url_mode;
    $(a).submit()
}
function fncDisplayList() {
    0 == $("hdnListMode").value ? ($("divShowActive").className = "middlebutton invisible", $("divShowAll").className = "middlebutton visible", $("hdnListMode").value = 1, $("showhide").innerHTML = '<a href="javascript: void(0);" onClick="javascript: fncDisplayList();" class="hideinactive"></a>') : ($("divShowActive").className = "middlebutton visible", $("divShowAll").className = "middlebutton invisible", $("hdnListMode").value = 0, $("showhide").innerHTML = '<a href="javascript: void(0);" onClick="javascript: fncDisplayList();" class="showall"></a>')
};