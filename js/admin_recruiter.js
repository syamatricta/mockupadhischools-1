function fncAddRecruiterdetails(){
	if (false == is_field_empty ("firstname", 'Enter Name',"errordiv")) {
	    return false;
	} else {
		$('errordiv').style.display     = "none";
	}
	

	if (false == is_field_empty ("email", 'Enter Email Id',"errordiv")) {
	   return false;
	} 
        else {
            if (false == is_field_empty ("confirmemail", 'Enter Confirm Email Id',"errordiv")) {
                    return false;
            } else {
                    $('errordiv').style.display     = "none";
            }
         $('errordiv').style.display     = "none";
	}

	if (checkEmail($('email').value) == false){
		$('errordiv').style.display = "block";
		$('errordiv').innerHTML     = "Email is not valid ";
		 return false;
	}else{
		if($('email').value != $('confirmemail').value){
			$('errordiv').style.display = "block";
			$('errordiv').innerHTML     = "Email Id and Confirm Email Id do not match";
			$('email').focus();
			return false;
			}
	}
	
        if($("copy_email").value != ''){
                var split_arr = $("copy_email").value.split(',');
                var errs = 0;

                for(i = 0;i < split_arr.length;i++){
                    split_arr[i] = trim(split_arr[i]);
                    if (checkEmail(split_arr[i]) == false){
                            errs = 1;
                    }
                }

                if(errs){
                    $('errordiv').style.display = "block";
                    $('errordiv').innerHTML     = "Copy email is not valid ";
                    return false;
                }else{
                    $("copy_email").value = split_arr.join(',');
                }
        }

	if (false == is_field_empty ("brokerage", 'Enter Brokerage',"errordiv")) {
		return false;
	} else {
		$('errordiv').style.display     = "none";
	}
        
	$("addrecruiterform").action=base_url+"index.php/admin_recruiter/add_recruiter/";
        $("addrecruiterform").submit()
}

function checkEmail(email) {
      if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
        return (true)
      }else{
            return false
      }
    }    
function gotolist(a){
    a?$("frmadhischool").action=base_url+"index.php/admin_recruiter/list_recruiter/"+a:$("frmadhischool").action=base_url+"index.php/admin_recruiter/list_recruiter/";
    $("frmadhischool").submit()
    }    
    
function fncUpdateRecruiterdetails(a,b){
    $("flasherror").innerHTML="";
    $("errordisplay").innerHTML="";
    $("flashsuccess").innerHTML="";
    
    if(!1==is_field_empty("firstname","Please enter Name","errordisplay")||!1==is_field_empty("email","Please enter Email Address","errordisplay")|| !1==check_email("email","Please enter a valid Email Address","errordisplay")||!1==is_field_empty("confirmemail","Please confrim Email Address","errordisplay")||!1==is_field_empty("brokerage","Please enter Brokerage","errordisplay"))return!1;
    
    if($("copy_email").value != ''){
            var split_arr = $("copy_email").value.split(',');
            var errs = 0;
            
            for(i = 0;i < split_arr.length;i++){
                split_arr[i] = trim(split_arr[i]);
                if (checkEmail(split_arr[i]) == false){
                        errs = 1;
                }
            }
            
            if(errs){
                $('errordisplay').style.display = "block";
                $('errordisplay').innerHTML     = "Copy email is not valid ";
                return false;
            }else{
                $("copy_email").value = split_arr.join(',');
            }
    }
        
    if($('email').value != $('confirmemail').value){
            $('errordisplay').style.display = "block";
            $('errordisplay').innerHTML     = "Email Id and Confirm Email Id do not match";
            $('email').focus();
            return false;
    }

    $("errordisplay").style.display="none";
    $("frmadhischool").action=base_url+"index.php/admin_recruiter/update_recruiters/"+a+"/"+b;
    $("frmadhischool").submit()
    } 
    
/* Freeze */ 
function freeze_recruiter(a){
    $("flasherror").innerHTML="";
    $("errordisplay").innerHTML="";
    $("flashsuccess").innerHTML="";
    $("hidrecruiterid").value=a;
    $("reasonAct").style.display="none";
    $("reasonFreeze").style.display="block"
    }  
function fncUpdatefreezingrecruiter(a){
    recruiterid=$("hidrecruiterid").value;
    if(!1==is_field_empty("txtReasonFreeze","Please enter reason for freezing","errordisplay"))return!1;
    confirm("Do you really want to freeze the recruiter with this reason?")&&($("frmadhischool").action=base_url+"index.php/admin_recruiter/freeze_recruiter/"+recruiterid+"/"+a,$("frmadhischool").submit())
    }    
function fncCancelFreezing(){
    //$("reasonFreeze").style.display="block";
    $("reasonFreeze").style.display="none"
    }     
    
/* Activate */    
function activate_recruiter(a){
    $("flasherror").innerHTML="";
    $("errordisplays").innerHTML="";
    $("flashsuccess").innerHTML="";
    $("hidrecruiterid").value=a;
    $("reasonFreeze").style.display="none";
    $("reasonAct").style.display="block"
    }    
function fncUpdateactivatingrecruiter(a){
    recruiterid=$("hidrecruiterid").value;
    if(!1==is_field_empty("txtReasonAct","Please enter reason for activating","errordisplays"))return!1;
    confirm("Do you really want to activate the recruiter with this reason?")&&($("frmadhischool").action=base_url+"index.php/admin_recruiter/activate_recruiter/"+recruiterid+"/"+a,$("frmadhischool").submit())
    }    
function fncCancelActivating(){
   // $("reasonAct").style.display="block";
    $("reasonAct").style.display="none"
    }     
    
//function search_function(){
//    $("frmadhischool").action=base_url+"index.php/admin_recruiter/list_recruiter/";
//    $("frmadhischool").submit();
//}

/** RECRUITER SEND MAIL **/

window.onload = function() {
   var  elements=  document.getElementsByTagName('form');
   var id = elements[0].getAttribute( 'id' );
   
   if(id == 'getmailcontents'){
       var rec_id = document.getElementById('hidprevrecruiterid').value; 
           if(rec_id != ''){
               select_brokerage(rec_id);
           }
   }

   if(id == 'frmPreviewmail'){
       var err_id = document.getElementById('errordiv').innerHTML; 
       var suc_id = document.getElementById('flashsuccess').innerHTML; 
       
           if(err_id != '' || suc_id != ''){
              $('hidmailid').value        =       'back';
              $('hidrecruiterid').value   =       '';
              $("frmPreviewmail").action=base_url+"index.php/admin_recruiter/recruiter_mail/";
              $("frmPreviewmail").submit(); 
           }
   }
};

function fncAddRecruiterMaildetails(){
	
        if (false == is_field_empty ("recruiter", 'Select Recruiter Name',"errordiv")) {
	    return false;
	} else {
		$('errordiv').style.display     = "none";
	}
        
        if (false == is_field_empty ("firstname", 'Enter First Name',"errordiv")) {
	    return false;
	} else {
		$('errordiv').style.display     = "none";
	}
        
        if (false == is_field_empty ("lastname", 'Enter Last Name',"errordiv")) {
	    return false;
	} else {
		$('errordiv').style.display     = "none";
	}
        
        if(($("gender_f").checked == false) && ($("gender_m").checked == false)){
            $('errordiv').style.display     = "block";
            $("errordiv").innerHTML = "Select Gender";
            return false;
        } else{
            $('errordiv').style.display     = "none";
        }
        
        if (false == is_field_empty ("area_of_interest", 'Enter Student Area of Interest',"errordiv")) {
	    return false;
	} else {
		$('errordiv').style.display     = "none";
	}
        
        if (false == is_field_empty ("licensure", 'Select Stage of Licensure',"errordiv")) {
	    return false;
	} else {
		$('errordiv').style.display     = "none";
	}
   
	if (false == is_field_empty ("email", 'Enter Email Id',"errordiv")) {
	   return false;
	} 
//        else {
//            if (false == is_field_empty ("confirmemail", 'Enter Confirm Email Id',"errordiv")) {
//                    return false;
//            } else {
//                    $('errordiv').style.display     = "none";
//            }
//         $('errordiv').style.display     = "none";
//	}

	if (checkEmail($('email').value) == false){
		$('errordiv').style.display = "block";
		$('errordiv').innerHTML     = "Email is not valid ";
		 return false;
	}
//        else{
//		if($('email').value != $('confirmemail').value){
//			$('errordiv').style.display = "block";
//			$('errordiv').innerHTML     = "Email Id and Confirm Email Id do not match";
//			$('email').focus();
//			return false;
//			}
//	}
	
        if (false == is_field_empty ("phone", 'Enter Phone Number',"errordiv")) {
		return false;
	} else if($('phone').value.length < 10){
			$('errordiv').style.display     = "block";
			$('errordiv').innerHTML         = "Phone Number should contain minimum 10 numbers";
			$('phone').focus();
			return false;
	}else {
            var ph = $('phone').value;
            var len = ph.length;
            for (var i = 0;  i < len; i++) {
                 if((ph[i] != '') && (isNaN(ph[i])) && (ph[i] != '-')){
                     $('errordiv').style.display     = "block";
                     $('errordiv').innerHTML         = "Invalid Phone Number";
                     $('phone').focus();
                     return false;
                 }
            }
            $('errordiv').style.display     = "none";
	}
        
        if("" == $("hidprevrecruiterid").value){
            var url = base_url+"index.php/admin_recruiter/check_recruiter_mail/";
            var email      = $("email").value;
            var recruiter  = $("recruiter").value;
            var parameters = "email="+email+"&recruiter="+recruiter;
            new Ajax.Request(url,
                { 
                    method          :       "post",
                    parameters      :       parameters,
                    evalScripts     :       true,
                    onSuccess	:       alertAdmin
                }
            );
        }else{
            $("getmailcontents").action=base_url+"index.php/admin_recruiter/recruiter_mail/";
            $("getmailcontents").submit();
        }
}

function alertAdmin(obj) {
    var obj1 = JSON.parse(obj.responseText);
    var proceed = obj1.proceed;
    
    if(1 == proceed){
        $("getmailcontents").action=base_url+"index.php/admin_recruiter/recruiter_mail/";
        $("getmailcontents").submit();
    }else{
        var date = obj1.date;
        var rec_name = obj1.recruiter;
        var r = confirm("You already introduced this student to "+rec_name+" on "+date+" .Are you sure you want to proceed?");
        if (r == true) {
          $("getmailcontents").action=base_url+"index.php/admin_recruiter/recruiter_mail/";
          $("getmailcontents").submit();
        }
    }
}

function fncClearRecruiterMaildetails(){
    $('brokerage_referred').innerHTML       =      '';
    $('brokerage_referred_to').value        =       '';

    var myForm = document.getElementById('getmailcontents');

    for (var i = 0; i < myForm.elements.length; i++)
    {
       if ('submit' != myForm.elements[i].type  && 'button' != myForm.elements[i].type){
           myForm.elements[i].checked = false;
           myForm.elements[i].value = '';
           myForm.elements[i].selectedIndex = 0;
       }
    }

}
 
function select_brokerage(recruiter_id){
    
    if(recruiter_id != ''){
        var url = base_url+"index.php/admin_recruiter/get_brokerage_onrecruiter/";
        var parameters = "recruiter_id="+recruiter_id;
        new Ajax.Request(url,
                    { 
                        method          :       "post",
                        parameters      :       parameters,
                        evalScripts     :       true,
                        onSuccess	:       ajaxDisplayInterface
                    }
        );
    }
} 

function ajaxDisplayInterface(obj){
        var obj1 = JSON.parse(obj.responseText);
        
	$('brokerage_referred').innerHTML       =      '';
	$('brokerage_referred').innerHTML       =       obj1.recruiter_brokerage;
        
        $('brokerage_referred_to').value        =       '';
        $('brokerage_referred_to').value        =       obj1.recruiter_brokerage;
        
        
        $('copy_email').innerHTML               =      '';
	$('copy_email').innerHTML               =      (obj1.recruiter_copy_mail == null) ? '-' : obj1.recruiter_copy_mail;
        
        $('copy_email_to').value                =       '';
        $('copy_email_to').value                =       obj1.recruiter_copy_mail;
        
}

function fncSendRecruiterMail(){
   $('mail_btn_send').style.display     = "none";
   $('mail_btn_edit').style.display     = "none";
   //$('loader').innerHTML='<img src="'+base_url+'images/indicator.gif" />';
   //$('loader').style.display     = "block";
   $('frmPreviewmail').style.opacity     = 0.5;
   $("frmPreviewmail").action=base_url+"index.php/admin_recruiter/recruiter_send_mail/";
   $("frmPreviewmail").submit();
}

function fncEditRecruiterMail(){
   //history.go(-1);
   $("frmPreviewmail").action=base_url+"index.php/admin_recruiter/recruiter_mail/";
   $("frmPreviewmail").submit();
}

function fncViewEditRecruiterMaildetails(id){
    $("frmadhischool").action=base_url+"index.php/admin_recruiter/edit_recruiters/"+id;
    $("frmadhischool").submit();
}

function fncFilter(a, b, brokerage) {
    "" == a && (a = 0);
    
    var date1 = new Date(a);
    var date2 = new Date(b);
    var timeDiff = date2.getTime() - date1.getTime();
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
  
    if ("" != a && diffDays < 0) return $("errordisplay").style.display = "block", $("errordisplay").innerHTML = "Please select a valid date range", $("date_from").focus(), !1;
    b && (date_to = date_change_format(b));
    date_from = a ? date_change_format(a) : a;

    //$("adminreportlistform").action = base_url + "index.php/admin_recruiter/recruiter_report/" + date_from + "/" + date_to + "/" + brokerage;
    $("adminreportlistform").action = base_url + "index.php/admin_recruiter/recruiter_report/";
    
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

function fncExport(a, b, brokerage,fname,lname,mail) {
    "" == a && (a = 0);
    
    var date1 = new Date(a);
    var date2 = new Date(b);
    var timeDiff = date2.getTime() - date1.getTime();
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
    
    if ("" != a && diffDays < 0) return $("errordisplay").style.display = "block", $("errordisplay").innerHTML = "Please select a valid date range", $("date_from").focus(), !1;
    b && (date_to = date_change_format(b));
    date_from = a ? date_change_format(a) : 0;

    $("adminreportlistform").action = base_url + "index.php/admin_recruiter/recruiter_report_excel/" + date_from + "/" + date_to + "/" + brokerage+ "/" + fname+ "/" + lname+ "/" + mail;
    $("adminreportlistform").submit()
}

function gotoreportlist(a){
    a?$("frmadhischool").action=base_url+"index.php/admin_recruiter/recruiter_report/"+a:$("frmadhischool").action=base_url+"index.php/admin_recruiter/recruiter_report/";
    $("frmadhischool").submit()
}    