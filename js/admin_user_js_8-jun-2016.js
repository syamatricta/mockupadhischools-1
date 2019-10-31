;
function fncUpadteUserdetails(a,b){
    $("flasherror").innerHTML="";
    $("errordisplay").innerHTML="";
    $("flashsuccess").innerHTML="";
    if(!1==is_field_empty("txtFirstName","Please enter First Name","errordisplay")||!1==is_field_empty("txtLastName","Please enter Last Name","errordisplay")||!1==is_field_empty("forumalias","Please enter Forum Alias","errordisplay")||!1==is_field_empty("txtEmail","Please enter Email Address","errordisplay")|| !1==check_email("txtEmail","Please enter a valid Email Address","errordisplay")||!1==is_field_empty("txtPhone","Please enter Phone Number","errordisplay"))return!1;
    if(10>$("txtPhone").value.length)return $("errordisplay").style.display="block",$("errordisplay").innerHTML="Phone Number should contain minimum 10 numbers",$("txtPhone").focus(),!1;
    $("errordisplay").style.display="none";
    $("errordisplay").style.display="none";
    if(!1==is_field_empty("s_txtAddress","Please enter Shipping Address","errordisplay")|| !1==is_field_empty("s_txtCity","Please enter Shipping City","errordisplay")||!1==is_drop_down_empty("cmbstate_s","Please select Shipping State","errordisplay")||!1==is_field_empty("s_txtZip","Please enter Shipping Zipcode","errordisplay"))return!1;
    if(!0==checkzip($("s_txtZip"))){
        if(!0==IsNumeric($("s_txtZip").value))$("errordisplay").style.display="none";else return $("errordisplay").style.display="block",$("errordisplay").innerHTML="Shipping Zipcode must be 5 digits",$("s_txtZip").focus(),!1;
        $("errordisplay").style.display= "none"
        }else return $("errordisplay").style.display="block",$("errordisplay").innerHTML="Shipping Zipcode must be 5 digits",$("s_txtZip").focus(),!1;
    if(!1==is_field_empty("b_txtAddress","Please enter Billing Address","errordisplay")||!1==is_field_empty("b_txtCity","Please enter Billing City","errordisplay")||!1==is_drop_down_empty("cmbstate_b","Please select Billing State","errordisplay")||!1==is_field_empty("b_txtZip","Please enter Billing Zipcode","errordisplay"))return!1;
    if(!0==checkzip($("b_txtZip"))){
        if(!0== IsNumeric($("b_txtZip").value))$("errordisplay").style.display="none";else return $("errordisplay").style.display="block",$("errordisplay").innerHTML="Billing Zipcode must be 5 digits",$("b_txtZip").focus(),!1;
        $("errordisplay").style.display="none"
        }else return $("errordisplay").style.display="block",$("errordisplay").innerHTML="Billing Zipcode must be 5 digits",$("b_txtZip").focus(),!1;
    $("frmadhischool").action=base_url+"index.php/admin_user/update_users/"+a+"/"+b;
    $("frmadhischool").submit()
    }
    function freeze_user(a){
    $("flasherror").innerHTML="";
    $("errordisplay").innerHTML="";
    $("flashsuccess").innerHTML="";
    $("hiduserid").value=a;
    $("reason").style.display="none";
    $("reason").style.display="block"
    }
    function freeze_otp_user(a,b){
    $("flasherror").innerHTML="";
    $("errordisplay").innerHTML="";
    $("flashsuccess").innerHTML="";
    $("hiduserid").value=a;
    $("reason").style.display="none";
    $("reason").style.display="block"
    $("reason_text1").innerHTML = (b == 1) ? "Enabling" : "Disabling";
    $("reason_text2").innerHTML = (b == 1) ? "Enabling" : "Disabling";
    }
    function ship_order(a,b){
    confirm("Do you want to ship this order?")&&($("frmadhischool").action=base_url+"index.php/admin_user/ship_order/"+a+"/"+b,$("frmadhischool").submit())
    }
    function fncCancelFreezing(){
    $("reason").style.display="block";
    $("reason").style.display="none"
    }
    function fncUpadtefreezinguser(a){
    userid=$("hiduserid").value;
    if(!1==is_field_empty("txtReason","Please enter reason for freezing","errordisplay"))return!1;
    confirm("Do you really want to freeze the user with this reason?")&&($("frmadhischool").action=base_url+"index.php/admin_user/freeze_user/"+userid+"/"+a,$("frmadhischool").submit())
    }
    function fncUpadtefreezingOtpuser(){
    userid=$("hiduserid").value;
    stst = $("d_status").value;
    act = (stst ==1 ) ? "enable" : "disable";
    
    if(!1==is_field_empty("txtReason","Please enter reason for freezing","errordisplay"))return!1;
    confirm("Do you really want to "+act+" the user with this reason?")&&($("frmadhischool").action=base_url+"index.php/admin_user/freeze_otp_user/"+userid+"/"+stst,$("frmadhischool").submit())
    }
    function freeze_order(a){
    $("hidorderid").value=a;
    $("flasherror").innerHTML="";
    $("errordisplay").innerHTML="";
    $("flashsuccess").innerHTML="";
    $("reason").style.display="none";
    $("reason").style.display="block"
    }
    function fncUpadtefreezingorder(a){
    orderid=$("hidorderid").value;
    if(!1==is_field_empty("txtReason","Please enter reason for freezing","errordisplay"))return!1;
    confirm("Do you really want to freeze the order with this reason?")&&($("frmadhischool").action=base_url+"index.php/admin_user/freeze_order/"+a+"/"+orderid,$("frmadhischool").submit())
    }
    function edit_effective_date(a,b,c,f,d,e,g){
    $("errordisplay").innerHTML="";
    $("flasherror").innerHTML="";
    $("flashsuccess").innerHTML="";
    if(!1==is_field_empty("txtenrolled"+c,"Please enter Enrolled Date","errordisplay"))return!1;
    if(!1==CompareDates(d,g))return $("errordisplay").style.display="block",$("txtenrolled"+c).className="error_border",$("errordisplay").innerHTML="Enrolled Date should not be a Future Date",!1;
    $("txtenrolled"+c).className="success_border";
    if(""!=e){
        if(!1==CompareDates(d,e,c))return $("errordisplay").style.display= "block",$("txtEffective"+c).className="error_border",$("errordisplay").innerHTML="Please enter a date greater than the Enrolled Date",!1;
        $("txtEffective"+c).className="success_border"
        }
        $("hidcount").value=c;
    $("frmadhischool").action=base_url+"index.php/admin_user/edit_effective_date/"+b+"/"+a+"/"+f;
    $("frmadhischool").submit()
    }
    function edit_effective_date_det(a,b,c,f,d,e,g){
    $("errordisplay").innerHTML="";
    $("flasherror").innerHTML="";
    $("flashsuccess").innerHTML="";
    if(!1==is_field_empty("txtenrolled"+c,"Please enter Enrolled Date","errordisplay"))return!1;
    if(!1==CompareDates(d,g))return $("errordisplay").style.display="block",$("txtenrolled"+c).className="error_border",$("errordisplay").innerHTML="Enrolled Date should not be a Future Date",!1;
    $("txtenrolled"+c).className="success_border";
    if(""!=e){
        if(!1==CompareDates(d,e, c))return $("errordisplay").style.display="block",$("txtEffective"+c).className="error_border",$("errordisplay").innerHTML="Please enter a date greater than the Enrolled Date",!1;
        $("txtEffective"+c).className="success_border"
        }
        $("hidcount").value=c;
    $("frmadhischool").action=base_url+"index.php/admin_user/edit_effective_date_det/"+b+"/"+a+"/"+f;
    $("frmadhischool").submit()
    }
    function CompareDates(a,b){
    var c=parseInt(a.substring(0,2),10),f=parseInt(a.substring(3,5),10),d=parseInt(a.substring(6,10),10),e=parseInt(b.substring(0,2),10),g=parseInt(b.substring(3,5),10),h=parseInt(b.substring(6,10),10);
    return new Date(h,e,g)<new Date(d,c,f)?!1:!0
    }
    function gotolist(a){
    a?$("frmadhischool").action=base_url+"index.php/admin_user/list_user_details/"+a:$("frmadhischool").action=base_url+"index.php/admin_user/list_user_details/";
    $("frmadhischool").submit()
    }
    function gotoorder(a,b){
    b?$("frmadhischool").action=base_url+"index.php/admin_user/view_order_details/"+a+"/"+b:$("frmadhischool").action=base_url+"index.php/admin_user/view_order_details/"+a;
    $("frmadhischool").submit()
    }
    function getQuizDetails(a,b,c){
    c?$("frmadhischool").action=base_url+"index.php/admin_user/view_quiz_details/"+a+"/"+b+"/"+c:$("frmadhischool").action=base_url+"index.php/admin_user/view_quiz_details/"+a+"/"+b;
    $("frmadhischool").submit()
    }
    function gotocourselist(a,b){
    b?$("frmadhischool").action=base_url+"index.php/admin_user/user_course_details/"+a+"/"+b:$("frmadhischool").action=base_url+"index.php/admin_user/user_course_details/"+a;
    $("frmadhischool").submit()
    };
    function fnReinstate(){
	var error ='';
	if (false == is_field_empty ("expiry_date", 'Please select a date',"errordisplay")) {
	    return false;
	} else {
		$('errordisplay').style.display     = "none";
	}
	
	exp_date = $('expiry_date').value;
	var res_t_date = exp_date.split("-");

	var expDate = new Date(res_t_date[2], res_t_date[0] - 1, res_t_date[1]);	
	var d = new Date();
	var curDate = new Date(d.getFullYear(),(d.getMonth()),d.getDate());
	
	if(expDate<curDate){
		$('errordisplay').style.display = "block";
		$('errordisplay').innerHTML     = "Re-instate date should not be past date.";
		$('expiry_date').focus();
		return false;
	}
	if(confirm("Do you really want to reinstate this user ?")){
		$('frmadhischool').submit();
	}else{
		return false;
	}
    }
    function fncAddOtpUserdetails(){
        if (false == is_field_empty ("firstname", 'Enter Name',"errordiv")) {
	    return false;
	} else {
		$('errordiv').style.display     = "none";
	}
        
        /*
        if (false == is_field_empty ("phone", 'Enter Phone',"errordiv")) {
		return false;
	} else {
		$('errordiv').style.display     = "none";
	}
        */
	

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
        
	$("addotpuserform").action=base_url+"admin_user/add_otp_user/";
        $("addotpuserform").submit()
}

function checkEmail(email) {
      if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
        return (true)
      }else{
            return false
      }
    }    
function gotolists(a){
    a?$("frmadhischool").action=base_url+"index.php/admin_user/list_otp_users/"+a:$("frmadhischool").action=base_url+"index.php/admin_user/list_otp_users/";
    $("frmadhischool").submit()
    }    
    
function fncUpdateOtpUserdetails(a){
    $("errordisplay").innerHTML="";
    $("flashsuccess").innerHTML="";
    
    if(!1==is_field_empty("firstname","Please enter Name","errordisplay")||!1==is_field_empty("email","Please enter Email Address","errordisplay")|| !1==check_email("email","Please enter a valid Email Address","errordisplay")||!1==is_field_empty("confirmemail","Please confrim Email Address","errordisplay"))return!1;
    
    if($('email').value != $('confirmemail').value){
            $('errordisplay').style.display = "block";
            $('errordisplay').innerHTML     = "Email Id and Confirm Email Id do not match";
            $('email').focus();
            return false;
    }

    $("errordisplay").style.display="none";
    $("addotpuserform").action=base_url+"admin_user/edit_otp_user/"+a;
    $("addotpuserform").submit()
}


    function fncSaveTrialUser(){
        if(false == is_field_empty('first_name', 'Enter First Name', 'errordiv')) {
            return false;
        }else if(false == is_field_empty('last_name', 'Enter Last Name', 'errordiv')) {
            return false;
        }else if(false == is_field_empty('email', 'Enter Email', 'errordiv')) {
            return false;
        }else if(false == is_field_empty('confirmemail', 'Enter Confirm Email', 'errordiv')) {
            return false;
        }else if(checkEmail($('email').value) == false){
            $('errordiv').style.display = 'block';
            $('errordiv').innerHTML     = 'Email is not valid';
            return false;
        }else if($('email').value != $('confirmemail').value){
            $('errordiv').style.display = 'block';
            $('errordiv').innerHTML     = 'Email Id and Confirm Email Id do not match';
            $('email').focus();
            return false;
        }else if(false == is_field_empty('psword', 'Enter Password', 'errordiv') && '' == $('userid').value) {
            return false;
        }else if($('psword').value != $('psword1').value  && '' == $('userid').value){
            $('errordiv').style.display = 'block';
            $('errordiv').innerHTML     = 'Password and Confirm Password do not match';
            $('email').focus();
            return false;
        }else{
            $('errordiv').style.display     = 'none';
        }
        if('' == $('userid').value){
            $("addotpuserform").action  = base_url+'admin_user/add_trial_user/';
        }else{
            $("addotpuserform").action  = base_url+'admin_user/edit_trial_user/'+$('userid').value;
        }
        $("addotpuserform").submit();
    }