;function validateLogin(){var a=$("username"),b=$("password"),c=$("captcha_code");$("display_error").style.display="none";return""==trim(a.value)?($("error").innerHTML="Please enter Username",a.focus(),!1):""==trim(b.value)?($("error").innerHTML="Please enter Password",b.focus(),!1):""==trim(c.value)?($("error").innerHTML="Please enter Verification code",c.focus(),!1):!0} function validate_user_Login(){var a=$("username"),b=$("password");$("display_error").style.display="none";return""==trim(a.value)?($("error").innerHTML="Please Enter Username",!1):!is_valid_email(a.value)?($("error").innerHTML="Please Enter valid Username",!1):""==trim(b.value)?($("error").innerHTML="Please Enter Password",!1):!0}function is_valid_email(a){return/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i.test(a)?!0:!1} function trim(a){return a.replace(/^\s*|\s*$|\n|\r/g,"")} function change_password(){$("flasherror").innerHTML="";$("errordisplay").innerHTML="";$("flashsuccess").innerHTML="";if(!1==is_field_empty("old_password","Please enter Current Password ","errordisplay")||!1==is_field_empty("new_password","Please enter New Password ","errordisplay")||!1==is_field_empty("confirm_password","Please Retype your Password ","errordisplay"))return!1;var a=$("new_password").value,b=$("confirm_password").value,c=$("old_password").value;if(6<=a.length){if(!0==is_valid_password(a))$("errordisplay").style.display= "none";else return $("errordisplay").style.display="block",$("errordisplay").innerHTML="Password should be the combination of Alphanumeric",$("new_password").focus(),!1;$("errordisplay").style.display="none"}else return $("errordisplay").style.display="block",$("errordisplay").innerHTML="Password should be minimum 6 characters",$("new_password").focus(),!1;$("errordisplay").style.display="none";if(a!=b)return $("errordisplay").style.display="block",$("errordisplay").innerHTML="Password and Confirm Password do not match", !1;if(a==c)return $("errordisplay").style.display="block",$("errordisplay").innerHTML="New Password should not be same as Current Password",!1;$("change_password_form_adhi").action=base_url+"index.php/admin/change_password/";$("change_password_form_adhi").submit()}function regenerate_captcha(a){new Ajax.Request(base_url+"index.php/user_ajax/regenerate_captcha",{method:"post",onSuccess:function(b){$(a).innerHTML=b.responseText},onFailure:disp_error})} function disp_error(){alert("Ajax request failed")};

/*Validation for otp login*/
    function validateOtp(){
            var otp_credential=$('otp_credential');
            
            $('display_error').style.display='none';

            if(trim(otp_credential.value)==''){
                    $('error').innerHTML="The OTP Credential is required";
                    return false;
            }
            
            return true;
    }
    
    /*Validation for otp value*/
    function validateOtpValue(){
            var otp = $('otp');
            
            $('display_error').style.display='none';

            if(trim(otp.value)==''){
                    $('error').innerHTML="OTP is required";
                    return false;
            }
            
            return true;
    }