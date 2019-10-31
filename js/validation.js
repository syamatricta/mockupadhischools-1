// JavaScript Document
//checking for empty fields

function trim(str) {
	return str.replace(/^\s*|\s*$|\n|\r/g,"");
}	
	
function is_field_empty (txtfield, errmsg, errdiv, close_button)
{
	//$(txtfield).className     = 'success_border';
	if("" == trim ($(txtfield).value))
	{
		$(errdiv).style.display   = "block";
		//$(txtfield).className     = 'error_border';
		$(errdiv).innerHTML       = errmsg;
		$(txtfield).value         = '';
                if (typeof close_button != 'undefined' ) {
                            $(close_button).style.display     = "block";
                        }
		$(txtfield).focus();
		return false;
	}
	else
	{
		$(errdiv).innerHTML       = "";
		//$(txtfield).className     = 'success_border';
		$(errdiv).style.display   = "none";
                if (typeof close_button != 'undefined' ) {
                    $(close_button).style.display   = "none";
                }
	}
}
function is_field_empty_wt_dummmy (txtfield,dummyid, errmsg, errdiv, close_button)
{ 
	//$(txtfield).className     = 'success_border';
	if("" == trim ($(txtfield).value))
	{
		$(errdiv).style.display   = "block";
		//$(txtfield).className     = 'error_border';
                if (typeof close_button != 'undefined' ) {
                   $(close_button).style.display     = "block";
                }
		$(errdiv).innerHTML       = errmsg;
		$(txtfield).value         = '';
		if($(dummyid)) $(dummyid).focus();
		return false;
	}
	else
	{
		$(errdiv).innerHTML       = "";
		//$(txtfield).className     = 'success_border';
		$(errdiv).style.display   = "none";
                if (typeof close_button != 'undefined' ) {
                    $(close_button).style.display   = "none";
                }
	}
}
function is_field_equal (txtfield,match, errmsg, errdiv, close_button)
{
	//$(txtfield).className     = 'success_border';
	if(match == trim ($(txtfield).value) || ''==trim ($(txtfield).value))
	{
		$(errdiv).style.display   = "block";
		//$(txtfield).className     = 'error_border';
                if (typeof close_button != 'undefined' ) {
                   $(close_button).style.display     = "block";
                }
		$(errdiv).innerHTML       = errmsg;
		$(txtfield).value         = match;
		$(txtfield).focus();
		return false;
	}
	else
	{
		$(errdiv).innerHTML       = "";
		//$(txtfield).className     = 'success_border';
		$(errdiv).style.display   = "none";
                if (typeof close_button != 'undefined' ) {
                    $(close_button).style.display   = "none";
                }
	}
}
function is_drop_down_empty (sltfield, errmsg, errdiv, close_button)
{
	//$(sltfield).className    	 = 'success_border';
	if("" == trim ($(sltfield).value) || 0 == trim ($(sltfield).value))
	{
		$(errdiv).style.display   = "block";
		//$(sltfield).className     = 'error_border';
                if (typeof close_button != 'undefined' ) {
                   $(close_button).style.display     = "block";
                }
		$(errdiv).innerHTML       = errmsg;
		$(sltfield).focus();
		return false;
	}
	else
	{
		$(errdiv).innerHTML       = "";
		//$(sltfield).className     = 'success_border';
		$(errdiv).style.display   = "none";
                if (typeof close_button != 'undefined' ) {
                    $(close_button).style.display   = "none";
                }    
	}
}
//email validation functions
function isValidEmail(email)
{
	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
	if (filter.test(email))
	{
		return true;
	}
	else
	{
		return false;
	}
}
function check_email(txtfield,errmsg,errdiv)
{
	if(!isValidEmail($(txtfield).value))
	{
		$(errdiv).style.display="block";
		$(errdiv).innerHTML=errmsg;
		$(txtfield).select();
		return false;
	}
	return true;
}//end of email validation functions
function isNumber(filed)
{ 
	var fileds =filed;
	var valo = new String();
	var numere = "0123456789.";
	var chars = fileds.value.split("");
	for (i = 0; i < chars.length; i++)
	{
		if (numere.indexOf(chars[i]) != -1)
		valo += chars[i];
		else
		{
			fileds.value="";
			return false;
		}
	}
	return true;
}
function isvalidPhoneNumber(filed)
{ 
	
	var fileds =filed;
	var valo = new String();
	var numere = "0123456789";
	var chars = fileds.value.split("");	
	for (i = 0; i < chars.length; i++)
	{
		if (numere.indexOf(chars[i]) != -1)
		valo += chars[i];		
		else
		{			
			str = fileds.value;			
			substring = str.substring(0, str.length - 1);			
			fileds.value=substring;
			return false;
		}
	}
	return true;
}

//phone number auto maintain position
function phone_no_maintain(position){
	if($('txtphone_'+position))
	if(($('txtphone_'+position).value.length)>2){
		position++;
		$('txtphone_'+position).focus();
	}
}
//phone no validation
function checkphoneno(phone) {
	if(/^\(\d{3}\)[\s]\d{3}[\s]\d{4}$/.test(phone) )
	{
		return true;
	}
	else if( /^\d{3}([-,\s])\d{3}([-,\s])\d{4}$/.test(phone) ){						
		ph = '('+phone.substring(0,3)+') '+phone.substring(4,7)+' '+phone.substring(8,15);
		phone.value = ph;
		return true;
	}
	else if(/^\(\d{3}\)([-,\s])\d{3}([-,\s])\d{4}$/.test(phone) ) {
		ph = phone.substring(0,5)+' '+phone.substring(6,9)+' '+phone.substring(10,15);
		phone.value = ph;
		return true;
	}
	else
	{
		return false;
	}
}

// check zipcode
	function checkzip(zip){
	if(zip.value.length != 5 ){
		return false;
	}else{
		return true;
		}
	
	}	
// check the number is numeric
	function IsNumeric(strString)
   //  check for valid numeric strings	
   {
   var strValidChars = "0123456789";
   var strChar;
   var blnResult = true;

   if (strString.length == 0) return false;

   //  test strString consists of valid characters listed above
   for (i = 0; i < strString.length && blnResult == true; i++)
      {
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1)
         {
         blnResult = false;
         }
      }
   return blnResult;
   }
   /**
   * password validation
   */
   function is_valid_password (pwd) {
        	var filter=/[a-zA-Z]/i
        	if (filter.test(pwd))
        	{
        	    var filter=/[0-9]/i;   	    
            	if (filter.test(pwd))
            	{	    
        	       	return true;
            	} else {
        	       	return false;    	    
            	}
        	}
        	else
        	{
        		return false;
        	}
        }  
        
function hide_errorbox() {
    document.getElementById("errordisplay").style.display = "none";
    document.getElementById("close_button").style.display = "none";
}

function hide_errorbox_success() {
    document.getElementById("flashsuccess").style.display = "none";
    document.getElementById("close_button_success").style.display = "none";
}