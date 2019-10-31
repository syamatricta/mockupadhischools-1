var carr = new Array();
function hide_div(id){
    if (Object.isElement($(id))){$(id).style.display ='none';}



}
function checkuser(){
	var error =''

	if (false == is_field_empty ("firstname", 'Enter First Name',"errordiv", "close_button")) {
		$('psword').value ='';
		$('psword1').value ='';
	    return false;
	} else {
		$('errordiv').style.display     = "none";
                $('close_button').style.display     = "none";
	}

	if (false == is_field_empty ("lastname", 'Enter Last Name',"errordiv", "close_button")) {
	    $('psword').value ='';
		$('psword1').value ='';
	   return false;
	} else {
		$('errordiv').style.display     = "none";
                $('close_button').style.display     = "none";
	}

	/*if (false == is_field_empty ("name_on_certificate", 'Enter Certificate Name',"errordiv")) {
	    $('psword').value ='';
		$('psword1').value ='';
	   return false;
	} else {
		$('errordiv').style.display     = "none";
	}*/

	/*if (false == is_field_empty ("forumalias", 'Enter Forum Alias',"errordiv")) {
	    $('psword').value ='';
		$('psword1').value ='';
	   return false;
	} else {
		if($('forumalias').value.length < 3){
		 	$('errordiv').style.display     = "block";
			$('errordiv').innerHTML     = "Forum Alias should be minimum 3 characters";
			$('forumalias').focus();
			$('psword').value ='';
			$('psword1').value ='';
			return false;
		 }
		$('errordiv').style.display     = "none";
	}



	if (false == is_field_empty ("license", 'Select License Type',"errordiv")) {
	    $('psword').value ='';
		$('psword1').value ='';
	   return false;
	} else {
		$('errordiv').style.display     = "none";
	}*/

	if (false == is_field_empty ("email", 'Enter Email',"errordiv", "close_button")) {
	    $('psword').value ='';
		$('psword1').value ='';
	   return false;
	} else {
			if (false == is_field_empty ("confirmemail", 'Enter Confirm Email',"errordiv", "close_button")) {
				$('psword').value ='';
				$('psword1').value ='';
				return false;
			} else {
		$('errordiv').style.display     = "none";
                $('close_button').style.display     = "none";
		}
		$('errordiv').style.display     = "none";
                $('close_button').style.display     = "none";
	}

	if (checkEmail($('email').value) == false){
		$('errordiv').style.display     = "block";
		$('errordiv').innerHTML     = "Email is not valid ";
                $('close_button').style.display     = "block";
		$('email').focus();
		 $('psword').value ='';
			$('psword1').value ='';
		 return false;
	}else{
		if($('email').value != $('confirmemail').value){
			$('errordiv').style.display     = "block";
			$('errordiv').innerHTML     = "Email and Confirm Email do not match";
                        $('close_button').style.display     = "block";
			$('email').focus();
			 $('psword').value ='';
			$('psword1').value ='';
			return false;
			}


	}
	if (false == is_field_empty ("psword", 'Enter Password',"errordiv", "close_button")) {
	    $('psword').value ='';
		$('psword1').value ='';
	   return false;
	} else {
		 if($('psword').value.length >= 6){
			 	if(is_valid_password ($('psword').value) == true){
					 $('errordiv').style.display     = "none";
                                         $('close_button').style.display     = "none";
					}
				else{
						$('errordiv').style.display     = "block";
						$('errordiv').innerHTML     = "Password should be in alphanumeric format";
                                                $('close_button').style.display     = "block";
						$('psword').focus();
						 $('psword').value ='';
						$('psword1').value ='';
						return false;

					}
				 $('errordiv').style.display     = "none";
                                 $('close_button').style.display     = "none";
			 }else{

				$('errordiv').style.display     = "block";
				$('errordiv').innerHTML     = "Password should be minimum 6 characters";
                                $('close_button').style.display     = "block";
				$('psword').focus();
				 $('psword').value ='';
				$('psword1').value ='';
				return false;
				 }
		$('errordiv').style.display     = "none";
                $('close_button').style.display     = "none";
	}

	if (false == is_field_empty ("psword1", 'Enter Confirm Password',"errordiv", "close_button")) {
	    $('psword').value ='';
		$('psword1').value ='';
	   return false;
	} else {
		$('errordiv').style.display     = "none";
                $('close_button').style.display     = "none";
	}

	if (trim($('psword').value) != trim($('psword1').value)) {
		$('errordiv').style.display     = "block";
		$('errordiv').innerHTML     = "Password and Confirm Password do not match";
                $('close_button').style.display     = "block";
		$('psword').focus();
	    $('psword').value ='';
		$('psword1').value ='';
	   return false;
	} else {
		$('errordiv').style.display     = "none";
                $('close_button').style.display     = "none";
	}

	if (false == is_field_empty ("address", 'Enter Address',"errordiv", "close_button")) {
	     $('psword').value ='';
		$('psword1').value ='';
		return false;
	} else {
		$('errordiv').style.display     = "none";
                $('close_button').style.display     = "none";
	}
	

	if (false == is_field_empty ("city", 'Enter City',"errordiv", "close_button")) {
	     $('psword').value ='';
		$('psword1').value ='';
		return false;
	} else {
		$('errordiv').style.display     = "none";
                $('close_button').style.display     = "none";
	}

	if (false == is_field_empty_wt_dummmy ("state","block_state",'Select State',"errordiv", "close_button")) {

	    $('psword').value ='';
		$('psword1').value ='';
	   return false;
	} else {
		$('errordiv').style.display     = "none";
                $('close_button').style.display     = "none";
	}
	
	if (false == is_field_empty ("zipcode", 'Enter Zipcode',"errordiv", "close_button")) {
	    $('psword').value ='';
		$('psword1').value ='';
	   return false;
	} else {

			if(checkzip($('zipcode')) == true){
				if((IsNumeric($('zipcode').value) == true)){
						$('errordiv').style.display     = "none";
                                                $('close_button').style.display     = "none";
						}
						else{

							$('errordiv').style.display     = "block";
							$('errordiv').innerHTML     = "Zipcode must be 5 digits";
                                                        $('close_button').style.display     = "block";
							$('zipcode').focus();
							 $('psword').value ='';
							$('psword1').value ='';
							return false;

							}
				$('errordiv').style.display     = "none";
                                $('close_button').style.display     = "none";

			 }else{

				$('errordiv').style.display     = "block";
				$('errordiv').innerHTML     = "Zipcode must be 5 digits";
                                $('close_button').style.display     = "block";
				$('zipcode').focus();
				 $('psword').value ='';
				$('psword1').value ='';
				return false;
			 }
	}
	if (false == is_field_empty ("phone", 'Enter Phone Number',"errordiv", "close_button")) {
	     $('psword').value ='';
		$('psword1').value ='';
		return false;
	} else {
		/*if(checkphoneno($('phone').value) == true){
		$('errordiv').style.display     = "none";
		}else{
			$('errordiv').style.display     = "block";
			$('errordiv').innerHTML     = "Phone Number is not valid ";
			$('phone').focus();
			$('psword').value ='';
			$('psword1').value ='';
			return false;

			}*/
		if($('phone').value.length < 10){
			$('errordiv').style.display     = "block";
			$('errordiv').innerHTML     = "Phone Number should contain minimum 10 numbers";
                        $('close_button').style.display     = "block";
			$('phone').focus();
			$('psword').value ='';
			$('psword1').value ='';
			return false;
		}else {
			$('errordiv').style.display     = "none";
                        $('close_button').style.display     = "none";
		}

	}
	/*if (false == is_field_empty ("testimonial", 'Enter Testimonial',"errordiv")) {
	    $('psword').value ='';
		$('psword1').value ='';
	   return false;
	} else {
		$('errordiv').style.display     = "none";
	}
	if (false == is_field_empty ("captcha_code", 'Enter Verification Code',"errordiv")) {
	     $('psword').value ='';
		$('psword1').value ='';
		return false;
	} else {
		$('errordiv').style.display     = "none";
	}*/


	$('step1').value =1
	/*$('myform').action = base_url+'user/register';*/
	$('myform').submit();
}



	function checkEmail(email) {
	  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
	  return (true)
	  }
	  else{
		    return false
		  }

    }
	// check zipcode
	function checkzip(z){
		if(z.value.length != 5){
			return false;
		}else{
			return true;
			}

		}


	function backhome(){
		$('myform').action = base_url+'home';
		$('myform').submit();

		}
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


/*function checkbilling(){

	if($('bsame').checked == false){
		$('billing').style.display   = "block";

	}else{

		$('billing').style.display		= "none";
		$('b_address').value	 		= '';
		$('b_state').value		 		= '';
		$('b_city').value 		 		= '';
		$('b_zipcode').value 	 		= '';

	}
}
*/

	function checkbilling(id){


		if($('bsame').checked == false){
			//$('shipping').style.display   = "block";
			$('b_address').value			= '';
			$('block_b_state').value		= 'Select State';
			$('b_state').value		 		= '';
			$('b_city').value		 		= '';
			$('b_zipcode').value	 		= '';
			$('b_address').readOnly			= false;
			$('b_city').readOnly			= false;
			$('b_state').readOnly			= false;
			$('b_zipcode').readOnly			= false;
			$('sttdiv').setAttribute("onClick", "javascript:__fncShowData('"+id+"');return false;");
			$('b_state').setAttribute('readonly',false);

		}else{


			//$('shipping').style.display		= "none";
			if( $('s_address').value !=''){
				//alert('hi');
				$('b_address').value			= $('s_address').value;
				$('block_b_state').value		= $('block_s_state').value;
				$('b_state').value		 		= $('s_state').value;
				$('b_city').value		 		= $('s_city').value;
				$('b_zipcode').value	 		= $('s_zipcode').value;
				$('b_address').readOnly=true;
				$('b_city').readOnly=true;
				$('sttdiv').removeAttribute("onClick");
                                 //$('sttdiv').onClick= null;
				$('b_state').setAttribute('readonly',true);
				$('b_zipcode').readOnly=true;
			}else{

				$('b_address').value			= '';
				$('block_b_state').value		= '';
				$('b_state').value		 		= '';
				$('b_city').value		 		= '';
				$('b_zipcode').value	 		= '';
                                $('sttdiv').removeAttribute("onClick");
                                //$('sttdiv').onClick= null;
				$('b_state').setAttribute('readonly',true);
				$('b_zipcode').readOnly=true;


			}





		}
	}

function checkpackageshipmethod(){
    if($('price').value !=0){

		//alert('go');
	}
	else{

		$('errordiv').style.display     = "block";
                $('close_button').style.display     = "block";
		$('errordiv').innerHTML     = "Select package";
		return false;
	}
	$('mygif').style.display ="block";
	$('mygif').innerHTML = '<img src='+base_url+'images/spinner.gif>';
	var update_div  =   'showship';
	var url         =   base_url + "register_ajax/get_ship";
	var params      =   's_address='+escape($('s_address').value)+'&s_city='+escape($('s_city').value)+'&s_zipcode='+escape($('s_zipcode').value)+'&s_state='+escape($('s_state').value)
						+'&s_country='+escape($('s_country').value)+'&s_phone='+escape($('bphone').value)+'&weight='+escape($('weight').value);
  //  url = base_url + url;

	new Ajax.Request(url,{
	                       method      : "post",
	                       onSuccess   : shoshipmethod,
						   parameters  : params,
	                       onFailure   : disp_shiperror
	                     }
	                );
}
// List shipmethod
function checkshipmethod(){
	var usertype = $('hidusertype').value;
        var new_package = 0;
        
        if($('new_package'))
        {
            new_package = $('new_package').value;
        }
        
        if($('price').value !=0){
        try{
			if(($('sel_course_b').value) == 0 && ($('sel_course_m').value == 0) && (usertype == 5 || usertype == 7) && (new_package != 1)){
				$('errordiv').style.display     = "block";
				$('close_button').style.display     = "block";
	                        $('errordiv').innerHTML     = "Select at least one course";
				return false;
			}
        }catch(err){
        	
        }
		
		//alert('go');return;
	}
	else{ 
		$('errordiv').style.display     = "block";
                $('close_button').style.display     = "block";
		if(usertype == 1 || usertype == 3 || usertype == 5 || usertype == 7 ){
			$('errordiv').innerHTML     = "Select package";
		}else {
			$('errordiv').innerHTML     = "Select at least one course";
		}
		return false;
	}
	// ajax function for listing

if(checkzip($('s_zipcode')) == true || checkzip($('b_zipcode')) == true){

	var weight = 0.0;
	try{
		if($('totalweight').value!=0)
			weight= Math.round((parseFloat(weight)+ parseFloat($('totalweight').value))*10)/10;
		if($('totalweightb').value!=0)
			weight= Math.round((parseFloat(weight)+ parseFloat($('totalweightb').value))*10)/10;
		if($('subcourseweight').value!=0)
			weight= Math.round((parseFloat(weight)+ parseFloat($('subcourseweight').value))*10)/10;
		
		var cc= weight.toString();
		var weight =  BRS(cc);
	}catch(err){
		weight= parseFloat($('weight').value);
	}
	//alert(weight);
	
	$('mygif').style.display ="block";
	$('mygif').innerHTML = '<img src='+base_url+'images/spinner.gif>';
	var update_div  =   'showship';
	var url             =   base_url + "register_ajax/get_ship";
	var params      =   's_address='+escape($('s_address').value)+'&s_city='+escape($('s_city').value)+'&s_zipcode='+escape($('s_zipcode').value)+'&s_state='+escape($('s_state').value)
						+'&s_country='+escape($('s_country').value)+'&s_phone='+escape($('bphone').value)+'&weight='+weight;
  //  url = base_url + url;
  //alert(params);
	new Ajax.Request(url,{
	                       method      : "post",
	                       onSuccess   : shoshipmethod,
                                parameters  : params,
	                       onFailure   : disp_shiperror
	                     }
	                );


// end ajax function
}else{

	$('errordiv').style.display     = "block";
        $('close_button').style.display     = "block";
	$('errordiv').innerHTML     = "Billing Zipcode must be 5 digits";
	$('b_zipcode').focus();
	return false;


	}

}
function disp_shiperror() {
		alert("Ajax request failed");
		$('mygif').style.display ="none";
}


function shoshipmethod(resp_obj)
    {
		var update_div  =   'showship';
		if(trim(resp_obj.responseText) !='error'){
			$(update_div).style.display ="block";
			$(update_div).innerHTML = resp_obj.responseText;
			$('shipbutton').style.display ="none";
			$('mygif').style.display ="none";
		}else{
			$('shipbutton').style.display ="block";
			$('mygif').style.display ="none";
			$('errordiv').style.display ="block";
			$('errordiv').innerHTML ="Recipient country requires a postal code served by FedEx";
			$(update_div).style.display ="none";
			}
    }

	function checkrate(){

		if($('showship').style.display =="block"){
				$('shipbutton').style.display ="block";
				$('shipprice').value = 0;
				$('totalprice').value = 0;

				$('showship').style.display = "none";

			}


		}

 function checkrate1(){
	// alert('hi');
	 	if($('showship').style.display =="block"){
				$('shipbutton').style.display ="block";
				$('shipprice').value = 0;
				$('totalprice').value = 0;
				$('shipamount').innerHTML = $('shipprice').value;
				$('totalamount').innerHTML = '$'+$('totalprice').value;
				$('showship').style.display = "none";

			}
	 }
	 function BRS(Str) {
    var L = Str.length, P = Str.indexOf('.'), Q;
    if (P < 0) {
        return Str + ".0";
    }else{
	 return Str;
	}

}


// list ship method
function addcourses(){
	var usertype = $('hidusertype').value;
	/*var my_month=new Date()
	var month=my_month.getMonth()+1;
	var year= my_month.getFullYear()*/
		var year=$('curyear').value;
		var month=$('curmonth').value;
		//alert($('price').value);
		if($('price').value==0){
			/*$('errordiv').style.display     = "block";
			$('errordiv').innerHTML     = "Select a course";
			return false;*/
			$('errordiv').style.display     = "block";
                        $('close_button').style.display     = "block";
			if(usertype == 1 || usertype == 3 || usertype == 5 || usertype == 7 ){
				$('errordiv').innerHTML     = "Select package";
			}else {
				$('errordiv').innerHTML     = "Select at least one course";
			}
			return false;

		}

	if($('shipprice').value == 0){
		$('errordiv').style.display     = "block";
                $('close_button').style.display     = "block";
		$('errordiv').innerHTML     = "Select ship method";
		return false;
	}
	if (false == is_field_empty ("cardtype", 'Select Card Type',"errordiv","close_button")) {
	    return false;
	} else {
		$('errordiv').style.display     = "none";
                $('close_button').style.display     = "none";
	}
                         
        
	if (false == is_field_empty ("ccno", 'Enter Credit Card No',"errordiv","close_button")) {
	    return false;
	}
        
        
	 if($('cardtype').value == 'Amex' ){
		if($('ccno').value.length != 15){

				$('errordiv').style.display     = "block";
                                $('close_button').style.display     = "block";
				$('errordiv').innerHTML     = "Enter valid Credit Card Number";
				$('ccno').focus();
				return false;
		}
		if($('cvv2no').value.length != 4 ){
				$('errordiv').style.display     = "block";
                                $('close_button').style.display     = "block";
				$('errordiv').innerHTML     = "Enter valid Credit Card Validation Code";
				$('cvv2no').focus();
				return false;

		}
	}else{
		if($('ccno').value.length != 16){
				$('errordiv').style.display     = "block";
                                $('close_button').style.display     = "block";
				$('errordiv').innerHTML     = "Enter valid Credit Card Number";
				$('ccno').focus();
				return false;

		}
		if($('cvv2no').value.length != 3 ){
				$('errordiv').style.display     = "block";
                                $('close_button').style.display     = "block";
				$('errordiv').innerHTML     = "Enter valid Credit Card Validation Code";
				$('cvv2no').focus();
				return false;
		}
	}
        
        //Validate selected card with card no.
        var selectedcard = $("block_cardtype").value;
        var cardno = $('ccno').value;
        var flag = 0;
        if(isValidCreditCard(selectedcard, cardno)) { 
            $('errordiv').style.display     = "none";
            $('close_button').style.display     = "none";
            if (false == is_field_empty ("expmonth", 'Enter Expiry Month',"errordiv","close_button")) {
                //$$('div.page_error').style.height = "none";
                flag = 1;
                return false;
            }
            
            if (false == is_field_empty ("expyear", 'Enter Expiry Year',"errordiv","close_button")) { 
                //$$('div.page_error').style.display = "none";
                flag = 1;
               return false;
            }
            
        } else {
            document.getElementById('errordiv').innerHTML="Credit Card No should match selected Credit Card Type";
            $('errordiv').style.display     = "block";
            $('close_button').style.display     = "block";
            return false;
        }
        
        
		if(trim($('expyear').value) == year){

			if(trim($('expmonth').value) < month){
					$('errordiv').style.display     = "block";
                                        $('close_button').style.display     = "block";
					$('errordiv').innerHTML     = "Enter Valid Expiry month and Year";
					$('expmonth').focus();
					 return false;
			}
		}


                 $('sb_btn').setAttribute('disabled', true);
		$('course').action = base_url+'user/courseadd';

		$('newimg').style.display ="block";
		$('newimg').innerHTML = '<img src='+base_url+'images/spinner.gif>';
		if(flag == 0) {
                    $('course').submit();
                }
                



}

 function isValidCreditCard(type, ccnum) {
   if (type == "Visa") {
      // Visa: length 16, prefix 4, dashes optional.
      var re = /^4\d{3}-?\d{4}-?\d{4}-?\d{4}$/;
   } else if (type == "MasterCard") {
      // Mastercard: length 16, prefix 51-55, dashes optional.
      var re = /^5[1-5]\d{2}-?\d{4}-?\d{4}-?\d{4}$/;
   } else if (type == "Discover") {
      // Discover: length 16, prefix 6011, dashes optional.
      var re = /^6011-?\d{4}-?\d{4}-?\d{4}$/;
   } else if (type == "Amex") {
      // American Express: length 15, prefix 34 or 37.
      var re = /^3[4,7]\d{13}$/;
   } 
   
   if (!re.test(ccnum)) return false;
   // Remove all dashes for the checksum checks to eliminate negative numbers
   ccnum = ccnum.split("-").join("");
   // Checksum ("Mod 10")
   // Add even digits in even length strings or odd digits in odd length strings.
   var checksum = 0;
   for (var i=(2-(ccnum.length % 2)); i<=ccnum.length; i+=2) {
      checksum += parseInt(ccnum.charAt(i-1));
   }
   // Analyze odd digits in even length strings or even digits in odd length strings.
   for (var i=(ccnum.length % 2) + 1; i<ccnum.length; i+=2) {
      var digit = parseInt(ccnum.charAt(i-1)) * 2;
      if (digit < 10) { checksum += digit; } else { checksum += (digit-9); }
   }
   if ((checksum % 10) == 0) return true; else return false;
}

// add new course

	function addnewcourses(){
		/*var my_month=new Date()
		var month=my_month.getMonth()+1;
		var year= my_month.getFullYear()*/
		var year=$('curyear').value
		var month=$('curmonth').value

		if($('shipprice').value == 0){
		$('errordiv').style.display     = "block";
                $('close_button').style.display     = "block";
		$('errordiv').innerHTML     = "Select ship method";
		return false;
		}
		if (false == is_field_empty ("cardtype", 'Select Card Type',"errordiv","close_button")) {
		return false;
		} else {
		$('errordiv').style.display     = "none";
                $('close_button').style.display     = "none";
		}
		if (false == is_field_empty ("ccno", 'Enter Credit Card No',"errordiv","close_button")) {
		return false;
		}

		if($('cardtype').value == 'Amex' ){
		if($('ccno').value.length != 15){

				$('errordiv').style.display     = "block";
                                $('close_button').style.display     = "block";
				$('errordiv').innerHTML     = "Enter valid Credit Card Number";
				$('ccno').focus();
				return false;
		}
		if($('cvv2no').value.length != 4 ){
				$('errordiv').style.display     = "block";
                                $('close_button').style.display     = "block";
				$('errordiv').innerHTML     = "Enter valid Credit Card Validation Code";
				$('cvv2no').focus();
				return false;

		}
		}else{
		if($('ccno').value.length != 16){
				$('errordiv').style.display     = "block";
                                $('close_button').style.display     = "block";
				$('errordiv').innerHTML     = "Enter valid Credit Card Number";
				$('ccno').focus();
				return false;

		}
		if($('cvv2no').value.length != 3 ){
				$('errordiv').style.display     = "block";
                                $('close_button').style.display     = "block";
				$('errordiv').innerHTML     = "Enter valid Credit Card Validation Code";
				$('cvv2no').focus();
				return false;
		}
		}

		if(trim($('expyear').value) == year){

			if(trim($('expmonth').value) < month){
					$('errordiv').style.display     = "block";
                                        $('close_button').style.display     = "block";
					$('errordiv').innerHTML     = "Enter Valid Expiry month and Year";
					$('expmonth').focus();
					 return false;
			}
		}
		//$('step').value =1;
		//alert(	$('step2'));
		$('course').action = base_url+'user/listremainingcourse';

		$('newimg').style.display ="block";
		$('newimg').innerHTML = '<img src='+base_url+'images/spinner.gif>';
		$('course').submit();


	}
	// add renew course
	function renew_course(){

		/*var my_month=new Date()
		var month=my_month.getMonth()+1;
		var year= my_month.getFullYear()*/
		var year=$('curyear').value
		var month=$('curmonth').value


		if (false == is_field_empty ("b_address", 'Enter Billing Address',"errordiv","close_button")) {
			return false;
		} else {
			$('errordiv').style.display     = "none";
                        $('close_button').style.display     = "none";
		}

		if (false == is_field_empty ("b_state", 'Select Billing State',"errordiv","close_button")) {
			return false;
		} else {
			$('errordiv').style.display     = "none";
                        $('close_button').style.display     = "none";
		}

		if (false == is_field_empty ("b_city", 'Enter Billing City',"errordiv","close_button")) {
			return false;
		} else {
			$('errordiv').style.display     = "none";
                        $('close_button').style.display     = "none";
		}

		if (false == is_field_empty ("b_zipcode", 'Enter Billing Zipcode',"errordiv","close_button")) {
			return false;
		} else {
				if(checkzip($('b_zipcode')) == true){
				if((IsNumeric($('b_zipcode').value) == true)){
						$('errordiv').style.display     = "none";
                                                $('close_button').style.display     = "none";
						}
						else{

							$('errordiv').style.display     = "block";
                                                        $('close_button').style.display     = "block";
							$('errordiv').innerHTML     = "Billing Zipcode must be 5 digits";
							$('b_zipcode').focus();
							return false;

							}
				$('errordiv').style.display     = "none";
                                $('close_button').style.display     = "none";

			 }else{

				$('errordiv').style.display     = "block";
                                $('close_button').style.display     = "block";
				$('errordiv').innerHTML     = "Billing Zipcode must be 5 digits";
				$('b_zipcode').focus();
				return false;
			 }

		}

		if (false == is_field_empty ("cardtype", 'Select Card Type',"errordiv","close_button")) {
		return false;
		} else {
		$('errordiv').style.display     = "none";
                $('close_button').style.display     = "none";
		}
		if (false == is_field_empty ("ccno", 'Enter Credit Card No',"errordiv","close_button")) {
		return false;
		}

		if($('cardtype').value == 'Amex' ){
		if($('ccno').value.length != 15){

				$('errordiv').style.display     = "block";
                                $('close_button').style.display     = "block";
				$('errordiv').innerHTML     = "Enter valid Credit Card Number";
				$('ccno').focus();
				return false;
		}
		if($('cvv2no').value.length != 4 ){
				$('errordiv').style.display     = "block";
                                $('close_button').style.display     = "block";
				$('errordiv').innerHTML     = "Enter valid Credit Card Validation Code";
				$('cvv2no').focus();
				return false;

		}
		}else{
		if($('ccno').value.length != 16){
				$('errordiv').style.display     = "block";
                                $('close_button').style.display     = "block";
				$('errordiv').innerHTML     = "Enter valid Credit Card Number";
				$('ccno').focus();
				return false;

		}
		if($('cvv2no').value.length != 3 ){
				$('errordiv').style.display     = "block";
                                $('close_button').style.display     = "block";
				$('errordiv').innerHTML     = "Enter valid Credit Card Validation Code";
				$('cvv2no').focus();
				return false;
		}
		}
                
                //Validate selected card with card no.
            var selectedcard = $("block_cardtype").value;
            var cardno = $('ccno').value;
            var flag = 0;
            if(isValidCreditCard(selectedcard, cardno)) { 
                $('errordiv').style.display     = "none";
                $('close_button').style.display     = "none";
                if (false == is_field_empty ("expmonth", 'Enter Expiry Month',"errordiv","close_button")) {
                    //$$('div.page_error').style.height = "none";
                    flag = 1;
                    return false;
                }

                if (false == is_field_empty ("expyear", 'Enter Expiry Year',"errordiv","close_button")) { 
                    //$$('div.page_error').style.display = "none";
                    flag = 1;
                   return false;
                }

            } else {
                document.getElementById('errordiv').innerHTML="Credit Card No should match selected Credit Card Type";
                $('errordiv').style.display     = "block";
                $('close_button').style.display     = "block";
                return false;
            }
        
		if(trim($('expyear').value) == year){

			if(trim($('expmonth').value) < month){
					$('errordiv').style.display     = "block";
                                        $('close_button').style.display     = "block";
					$('errordiv').innerHTML     = "Enter Valid Expiry month and Year";
					$('expmonth').focus();
					 return false;
			}
		}


		$('renewcourse').action = base_url+'user/renewal';
		$('newimg').style.display ="block";
		$('newimg').innerHTML = '<img src='+base_url+'images/spinner.gif>';

		$('renewcourse').submit();


	}
/**********Credit Card Validation**********************/

/*function checkcc(id){
	if(id == 1){
		var valid	=	0;
		valid		=	isCreditCard(document.checkout_one_form.card_number.value);
		if(!valid){
		alert("Please enter a valid credit card number!");
		return false;
		}
		else{

			return true;
		}
	}else{
	return true;
	}

}*/
 function isCreditCard(){
	// alert($('cardtype').value);
	if($('cardtype').value == 'Amex')	{

		document.getElementById('ccno').setAttribute('maxLength', 155);
		document.getElementById('cvv2no').setAttribute('maxLength', 4);

	}else{
		document.getElementById('ccno').setAttribute('maxLength', 16);
		document.getElementById('cvv2no').setAttribute('maxLength', 3);

	}
}


/*function isCreditCard(textObj){
	var ccNum;
	var odd = 1;
	var even = 2;
	var calcCard = 0;
	var calcs = 0;
	var ccNum2 = "";
	var aChar = '';
	var cc;
	var r;

	ccNum = textObj.value;
	for(var i = 0; i != ccNum.length; i++) {
	  aChar = ccNum.substring(i,i+1);
	  if(aChar == '-') {
		 continue;
	  }

	  ccNum2 = ccNum2 + aChar;
	}
	cc = parseInt(ccNum2);
	if(cc == 0) {
	  return false;
	}
	r = ccNum.length / 2;
	if(ccNum.length - (parseInt(r)*2) == 0) {
	  odd = 2;
	  even = 1;
	}

	for(var x = ccNum.length - 1; x > 0; x--) {
	  r = x / 2;
	  if(r < 1) {
		 r++;
	  }
	  if(x - (parseInt(r) * 2) != 0) {
		 calcs = (parseInt(ccNum.charAt(x - 1))) * odd;
	  }
	  else {
		 calcs = (parseInt(ccNum.charAt(x - 1))) * even;
	  }
	  if(calcs >= 10) {
		 calcs = calcs - 10 + 1;
	  }
	  calcCard = calcCard + calcs;
	}

	calcs = 10 - (calcCard % 10);
	if(calcs == 10) {
	  calcs = 0;
	}

	if(calcs == (parseInt(ccNum.charAt(ccNum.length - 1)))) {
	  return true;
	}
	else {
	  return false;
	}
	}*/


/****************************/

	function is_field_empty (txtfield, errmsg, errdiv, close_button)
	{
		if ("" == trim ($(txtfield).value))
		{
			$(errdiv).style.display   = "block";
			$(errdiv).innerHTML       = errmsg;
			$(txtfield).value         = '';
			$(txtfield).focus();
                        if (typeof close_button != 'undefined' ) {
                            $(close_button).style.display     = "block";
                        }
                        
                        
			return false;
		}
		else
		{
			$(errdiv).innerHTML       = "";
			$(errdiv).style.display   = "none";
                        if (typeof close_button != 'undefined' ) {
                            $(close_button).style.display   = "none";
                        }
			return true;
		}
	}

//phone no validation
function checkphoneno(v) {
					if(/^\(\d{3}\)[\s]\d{3}[\s]\d{4}$/.test(v) )
					{
						return true;
					}
					else if( /^\d{3}([-,\s])\d{3}([-,\s])\d{4}$/.test(v) ){
						ph = '('+v.substring(0,3)+') '+v.substring(4,7)+' '+v.substring(8,15);
						v.value = ph;
						return true;
					}
					else if(/^\(\d{3}\)([-,\s])\d{3}([-,\s])\d{4}$/.test(v) ) {
						ph = v.substring(0,5)+' '+v.substring(6,9)+' '+v.substring(10,15);
						v.value = ph;
						return true;
					}
					else
					{
						return false;
					}
				}


// phone no validatin

	function is_valid_email (email){
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
	 function trim(str) {
    	return str.replace(/^\s*|\s*$|\n|\r/g,"");
	}


/*Validation for admin login*/
	function validateLogin(){
		var username=$('username');
		var password=$('password');
		$('display_error').style.display='none';

		if(trim(username.value)==''){
			$('error').innerHTML="Please Enter Username";
			return false;
		}

		if(trim(password.value)==''){
			$('error').innerHTML="Please Enter Password";
			return false;
		}

		return true;
	}


function regenerate_captcha(div_to_update)
{
    var update_div  =   div_to_update;

    var url             =   base_url + "user_ajax/regenerate_captcha";

  //  url = base_url + url;
	new Ajax.Request(url,{
	                       method      : "post",
	                       onSuccess   : update_captcha_div,
	                       onFailure   : disp_error
	                     }
	                );
function update_captcha_div(resp_obj)
    {
        $(update_div).innerHTML = resp_obj.responseText;
    }

}


function disp_error() {
		alert("Ajax request failed");
}

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


	function checkcourse(){

		$('price').value = 0;
		$('totalweight').value = 0;
		$('totalweightb').value = 0;

		$$("input.subcheck").each(function (elem) {if(elem.checked) {$('price').value =  parseFloat($('price').value)+ parseFloat(( $("subprice" + elem.value).value ));$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat(( $("courseweight" + elem.value).value));}
																																						  })
		$$("input.scheck").each(function (elem) {if(elem.checked) {$('price').value = parseFloat($('price').value) +  parseFloat(( $("courseprice" + elem.value).value));$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat( ( $("courseweight" + elem.value).value));}})

		$$("input.bcheck").each(function (elem) {if(elem.checked) {$('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));}})

		//$('cartcourseprice').innerHTML   = $('price').value;
		$('shipprice').value =0;
		$('totalprice').value =0;
		/*if($('shipprice').value)
		$('cartshiprate').innerHTML      = $('shipprice').value;
		if($('totalprice').value)
		$('carttotalprice').innerHTML      = $('totalprice').value;*/

		/**grid**/
		var a =0;
		var s =0;
		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";
		$$("input.scheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' +'<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		}})
		$$("input.subcheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' + '<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		}})
		$$("input.bcheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' +'<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		}})
		var totalamnt= '$'+$('totalprice').value;
		 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;">Ship Rate -</td>' + '<td class=gridtrlastsec width=118  ><div id=shipamount style="padding-left:35px; font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';
		gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + '<td class=gridlastsectd width=10px ></td> <td class=page_error width=118  ><div id=totalamount>'+totalamnt+'</div></td></tr></table>';
		gridtext =gridtext+"</table>";
		 if(a!=0){
			  //$('grid').className = 'gridborder';
			 $('grid').innerHTML   = gridtext;

			 }


	 }


	// show Mandatory course terms and condition
	function showterms(id){
		// intiate variable
		var showdivid = 'showdiv'+id
		$(showdivid).style.display = "block";
		var coursediv = 'course' + id;
		var subcoursediv = 'subcourse' + id;
		var coursebdiv = 'course_b' +id;
		var agreediv = 'agree' + id;
		var disagreediv = 'disagree' + id;
                var sel = 'selagree' + id;

		if($(coursediv)){
                    $(coursediv).checked =false;
                    $('course_chkimg'+id).src	=	base_url+'/images/course_checkbox_uncheck.png';
                }
		if($(coursebdiv))
		$(coursebdiv).checked =false;

		$(agreediv).checked =false;
		$(disagreediv).checked =false;

                $(sel).value =1;

		$('price').value =0;
		$('totalweight').value =0;
		$('totalweight').value = 0;
		$('totalweightb').value = 0;

		//add price and weight of checked element
		$$("input.subcheck").each(function (elem) {if(elem.checked) {$('price').value =  parseFloat($('price').value)+ parseFloat(( $("subprice" + elem.value).value ));$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat(( $("courseweight" + elem.value).value));}
																																						  })
		$$("input.scheck").each(function (elem) {if(elem.checked) {$('price').value = parseFloat($('price').value) +  parseFloat(( $("courseprice" + elem.value).value));$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat( ( $("courseweight" + elem.value).value));}})

		$$("input.bcheck").each(function (elem) {if(elem.checked) {$('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));}})
		/*$$("input.bcheck").each(function (elem) { if(elem.checked) {

			alert(elem.value);

		} })*/
		// cart total
		//$('cartcourseprice').innerHTML   = $('price').value;
		$('shipprice').value =0;
		$('totalprice').value =0;
	/*	if($('shipprice').value)
		$('cartshiprate').innerHTML      = $('shipprice').value;
		if($('totalprice').value)
		$('carttotalprice').innerHTML      = $('totalprice').value;*/
		/*******Grid********/
		var a =0;
		var s =0;
		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";


			$$("input.scheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' +'<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		}else{gridtext = gridtext +'';}})
		$$("input.subcheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' + '<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		} else{gridtext = gridtext +'';}})
		$$("input.bcheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' +'<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		}else{gridtext = gridtext +'';}})
		var totalamnt= '$'+$('totalprice').value;
		 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;">Ship Rate -</td>' + '<td class=gridtrlastsec width=118  ><div id=shipamount style="padding-left:35px; font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';
		gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + '<td class=gridlastsectd width=10px ></td> <td class=page_error width=118  ><div id=totalamount>'+totalamnt+'</div></td></tr></table>';
		gridtext =gridtext+"</table>";
		 if(a!=0){
			  //$('grid').className = 'gridborder';
			 $('grid').innerHTML   = gridtext;

			 }else{
				  $('grid').innerHTML   = '';

				 }


                                 smoothScroll(showdivid);


	}

	// show Sub Optional course terms and condition
		function show_sub_opt_terms(id,index){
		//alert(id);
		// intiate variable
		var showdivid = 'showdiv'+id
		$(showdivid).style.display = "block";
		var coursediv = 'course' + id;
		var subcoursediv = 'subcourse' + id;
		var coursebdiv = 'course_b' +id;
		var agreediv = 'agree' + id;
		var disagreediv = 'disagree' + id;

		if($(coursediv))
		$(coursediv).checked =false;

		if($(coursebdiv))
		$(coursebdiv).checked =false;

			$('course0').checked = false;
			$('course0').disabled = true;


		$(agreediv).checked =false;
		$(disagreediv).checked =false;

			var radioLength			= index.length;
				for(var i = 0; i < radioLength; i++) {
					if(index[i].checked) {
					var indexid = i;
					}
				}
			index[indexid].checked  = false;


		$('price').value =0;
		$('totalweight').value =0;
		$('totalweight').value = 0;
		$('totalweightb').value = 0;

		//add price and weight of checked element
		$$("input.subcheck").each(function (elem) {if(elem.checked) {$('price').value =  parseFloat($('price').value)+ parseFloat(( $("subprice" + elem.value).value ));$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat(( $("courseweight" + elem.value).value));}
																																						  })
		$$("input.scheck").each(function (elem) {if(elem.checked) {$('price').value = parseFloat($('price').value) +  parseFloat(( $("courseprice" + elem.value).value));$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat( ( $("courseweight" + elem.value).value));}})

		$$("input.bcheck").each(function (elem) {if(elem.checked) {$('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));}})

		// cart total
		//$('cartcourseprice').innerHTML   = $('price').value;
		$('shipprice').value =0;
		$('totalprice').value =0;
		/*if($('shipprice').value)
		$('cartshiprate').innerHTML      = $('shipprice').value;
		if($('totalprice').value)
		$('carttotalprice').innerHTML      = $('totalprice').value;*/
		/*******Grid********/
		var a =0;
		var s =0;
		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";


				$$("input.scheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' +'<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		}else{gridtext = gridtext +'';}})
		$$("input.subcheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' + '<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		}else{gridtext = gridtext +'';}})
		$$("input.bcheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' +'<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		}else{gridtext = gridtext +'';}})
		var totalamnt= '$'+$('totalprice').value;
		 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;">Ship Rate -</td>' + '<td class=gridtrlastsec width=118  ><div id=shipamount style="padding-left:35px; font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';
		gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + '<td class=gridlastsectd width=10px ></td> <td class=page_error width=118  ><div id=totalamount>'+totalamnt+'</div></td></tr></table>';
		gridtext =gridtext+"</table>";
		 if(a!=0){
			  //$('grid').className = 'gridborder';
			 $('grid').innerHTML   = gridtext;

			 }else{
				  $('grid').innerHTML   = '';

				 }


 }

	// show Optional course terms and condition
	function show_opt_terms(id,index){
                if($('course_b_newpackage'))
                {
                   $('course_b_newpackage').checked = false;
                   $('course_bimg_newpackage').src	= base_url+'/images/radio_nonselection.png';
                  
                }
                if($('agree_newpackage0'))
                {
                    $('agree_newpackage0').src	=	base_url+'/images/checkbox_uncheck.png';
                    $('disagree_newpackage0').src	=	base_url+'/images/checkbox_uncheck.png';
                }
                if($('new_package')) 
                {    
                    if($('new_package').value == 1)
                    {
                        $('new_package').value = 0;
                        $('price').value = 0;
                        $('grid').innerHTML   = '';
                    } 
                }   
                //alert(id);
		// intiate variable
		var showdivid = 'showdiv'+id
		$(showdivid).style.display = "block";
		var coursediv = 'course' + id;
		var subcoursediv = 'subcourse' + id;
		var coursebdiv = 'course_b' +id;
		var agreediv = 'agree' + id;
		var disagreediv = 'disagree' + id;

		if($(coursediv)){
                    $(coursediv).checked =false;
                     $('course_bimg'+id).src	=	base_url+'/images/radio_nonselection.png';
                }
		if($(coursebdiv))
		$(coursebdiv).checked =false;

		$(agreediv).checked =false;
		$(disagreediv).checked =false;

			var radioLength			= index.length;
				for(var i = 0; i < radioLength; i++) {
					if(index[i].checked) {
					var indexid = i;
					}
				}
			index[indexid].checked  = false;


		$('price').value =0;
		$('totalweight').value =0;
		$('totalweight').value = 0;
		$('totalweightb').value = 0;

		//add price and weight of checked element
		$$("input.subcheck").each(function (elem) {if(elem.checked) {$('price').value =  parseFloat($('price').value)+ parseFloat(( $("subprice" + elem.value).value ));$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat(( $("courseweight" + elem.value).value));}
																																						  })
		$$("input.scheck").each(function (elem) {if(elem.checked) {$('price').value = parseFloat($('price').value) +  parseFloat(( $("courseprice" + elem.value).value));$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat( ( $("courseweight" + elem.value).value));}})

		$$("input.bcheck").each(function (elem) {if(elem.checked) {$('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));}})

		// cart total
		//$('cartcourseprice').innerHTML   = $('price').value;
		$('shipprice').value =0;
		$('totalprice').value =0;
		/*if($('shipprice').value)
		$('cartshiprate').innerHTML      = $('shipprice').value;
		if($('totalprice').value)
		$('carttotalprice').innerHTML      = $('totalprice').value;*/

		/*******Grid********/
		var a =0;
		var s =0;
		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";

		$$("input.scheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' +'<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		} else{gridtext = gridtext +'';}})
		$$("input.subcheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' + '<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		}else{gridtext = gridtext +'';}})
		$$("input.bcheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' +'<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		} else{gridtext = gridtext +'';}})
		var totalamnt= '$'+$('totalprice').value;
		 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 >Ship Rate -</td>' + '<td  class=gridsectd ></td> <td class=gridtrlastsec width=100  ><div id=shipamount>'+$('shipprice').value+'</div></td></tr>';
		gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + '<td class=gridlastsectd width=10px ></td> <td class=page_error width=118  ><div id=totalamount>'+totalamnt+'</div></td></tr></table>';
		gridtext =gridtext+"</table>";
		 if(a!=0){
			  //$('grid').className = 'gridborder';
			 $('grid').innerHTML   = gridtext;

			 }else{
				  $('grid').innerHTML   = '';

				 }


 }

// check for Mandatory fields
	// check course
	function showcheck(id){

		// intiate variable
		if(id !=0){
                        $('agree'+id).src	=	base_url+'/images/checkbox_check.png';
                        $('disagree'+id).src	=	base_url+'/images/checkbox_uncheck.png';

		var showdivid = 'showdiv'+id
		var coursediv = 'course' + id;
		var subcoursediv = 'subcourse';
		var coursebdiv = 'course_b' +id;
		var agreediv = 'agree' + id;
		var disagreediv = 'disagree' + id;
		var selagree = 'selagree' + id;
        $('sel_course_m').value =  id;
		if($(coursediv)){
                    $(coursediv).checked =true;
                    $('course_chkimg'+id).src	=	base_url+'/images/course_checkbox_checked.png';
                }
		//if($(subcoursediv)){
			//$('course0').disabled = true;

		//}
                $(selagree).value=1;
		if($(coursebdiv))
		$(coursebdiv).checked =true;

		$('price').value =0;
		$('totalweight').value =0;
		$('totalweight').value = 0;
		$('totalweightb').value = 0;
		var a =0;
		var s =0;

		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";
		//add price and weight of checked element
		//$$("input.subcheck").each(function (elem) { if(elem.checked) { $('price').value =  parseFloat($('price').value)+ parseFloat(( $("subprice" + elem.value).value ));	$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat(( $("courseweight" + elem.value).value));}
																																						 // })
		$$("input.scheck").each(function (elem) {if(elem.checked) {$('price').value = parseFloat($('price').value) +  parseFloat(( $("courseprice" + elem.value).value));$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat( ( $("courseweight" + elem.value).value));}})

		$$("input.bcheck").each(function (elem) {if(elem.checked) {$('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));}})

		//$('cartcourseprice').innerHTML   = $('price').value;
		$('shipprice').value =0;
		$('totalprice').value =0;
		/*if($('shipprice').value)
		$('cartshiprate').innerHTML      = $('shipprice').value;
		if($('totalprice').value)
		$('carttotalprice').innerHTML      = $('totalprice').value;*/

		var totalamnt = 0;
		$$("input.scheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			// alert(elem.value);
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' +'<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';
			totalamnt += parseFloat(carr["'"+elem.value+"'"][1]);

		}else{gridtext = gridtext +'';}})
		$$("input.bcheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' +'<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';
			totalamnt += parseFloat(carr["'"+elem.value+"'"][1]);

		}else{gridtext = gridtext +'';}})
		//var totalamnt= '$'+$('totalprice').value;
		 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;">Ship Rate -</td>' + '<td class=gridtrlastsec width=118  ><div id=shipamount style="padding-left:35px; font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';
		gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + '<td class=gridlastsectd width=10px ></td> <td class=page_error width=118  ><div id=totalamount>$'+totalamnt+'</div></td></tr></table>';
		gridtext =gridtext+"</table>";
		 if(a!=0){
			  //$('grid').className = 'gridborder';
			 $('grid').innerHTML   = gridtext;

			 }else{
				  $('grid').innerHTML   = '';

				 }

		// cart total
		/*$('cartcourseprice').innerHTML   = $('price').value;
		$('shipprice').value =0;
		$('totalprice').value =0;
		if($('shipprice').value)
		$('cartshiprate').innerHTML      = $('shipprice').value;
		if($('totalprice').value)
		$('carttotalprice').innerHTML      = $('totalprice').value;*/

		$(showdivid).style.display = "none";
		}
	}
	// uncheck course
	function showuncheck(id){
		// intiate variable
		var showdivid = 'showdiv'+id
		var coursediv = 'course'+id;
		var subcoursediv = 'subcourse';
		var coursebdiv = 'course_b' +id;
		var agreediv = 'agree' + id;
		var disagreediv = 'disagree' + id;
        var selagree = 'selagree' + id;
        $('sel_course_b').value = 0;

		$(showdivid).style.display = "none";
		$('agree'+id).src	=	base_url+'/images/checkbox_uncheck.png';
                $('disagree'+id).src	=	base_url+'/images/checkbox_uncheck.png';
		if($(coursediv)){
                    $(coursediv).checked =false;
                    $('course_chkimg'+id).src	=	base_url+'/images/course_checkbox_uncheck.png';
                }
               /*if($(subcoursediv))
		$(subcoursediv).checked =false;

		if($(coursebdiv))
		$(coursebdiv).checked =false;*/

		$(selagree).value=0;
		$('price').value =0;
		$('totalweight').value =0;
		$('totalweight').value = 0;
		$('totalweightb').value = 0;

		//add price and weight of checked element
		//$$("input.subcheck").each(function (elem) { if(elem.checked) { $('price').value =  parseFloat($('price').value)+ parseFloat(( $("subprice" + elem.value).value ));	$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat(( $("courseweight" + elem.value).value));}
																																						  //})
		$$("input.scheck").each(function (elem) {if(elem.checked) {$('price').value = parseFloat($('price').value) +  parseFloat(( $("courseprice" + elem.value).value));$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat( ( $("courseweight" + elem.value).value));}})

		$$("input.bcheck").each(function (elem) {if(elem.checked) {$('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));}})

		// cart total
		//$('cartcourseprice').innerHTML   = $('price').value;
		$('shipprice').value =0;
		$('totalprice').value =0;
		/*if($('shipprice').value)
		$('cartshiprate').innerHTML      = $('shipprice').value;
		if($('totalprice').value)
		$('carttotalprice').innerHTML      = $('totalprice').value;*/
		/******Grid***/
		var a =0;
		var s =0;
		var totalamnt = 0;
		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";
			$$("input.scheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' +'<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';

			totalamnt += parseFloat(carr["'"+elem.value+"'"][1]);
		} else{gridtext = gridtext +'';}})
		/*$$("input.subcheck").each(function (elem) { if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' + '<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		}else{ gridtext = gridtext +''; } })*/
		$$("input.bcheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' +'<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';
			totalamnt += parseFloat(carr["'"+elem.value+"'"][1]);

		}else{gridtext = gridtext +'';}})

		//var totalamnt= '$'+$('totalprice').value;
		 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300  style="border-right:1px solid #000;">Ship Rate -</td>' + '<td class=gridtrlastsec width=118  ><div id=shipamount style="padding-left:35px; font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';
		gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + '<td class=gridlastsectd width=10px ></td> <td class=page_error width=118  ><div id=totalamount>$'+totalamnt+'</div></td></tr></table>';
		gridtext =gridtext+"</table>";

                 if(a!=0){
			  //$('grid').className = 'gridborder';
			 $('grid').innerHTML   = gridtext;

			 }else{
				  $('grid').innerHTML   = '';

				 }




	}

	// check for sub

	function show_radio_check(id,index){

		// intiate variable
		var showdivid = 'showdiv'+id
		var coursediv = 'course' + id;
		var subcoursediv = 'subcourse';
		var coursebdiv = 'course_b' +id;
		var agreediv = 'agree' + id;
		var disagreediv = 'disagree' + id;

		if($(coursediv))
		$(coursediv).checked =true;
		if($(subcoursediv)){
			$('course0').checked = true;
			$('course0').disabled = true;

		}

		if($(coursebdiv))
		$(coursebdiv).checked =true;

			var radioLength			= index.length;
			if(radioLength){
				for(var i = 0; i < radioLength; i++) {
					if(index[i].value == id) {
					var indexid = i;
					}
				}

			index[indexid].checked  = true;
			}


		$('price').value =0;
		$('totalweight').value =0;
		$('totalweight').value = 0;
		$('totalweightb').value = 0;
		var a =0;
		var s =0;
		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";


		//add price and weight of checked element
		$$("input.subcheck").each(function (elem) {if(elem.checked) {$('price').value =  parseFloat($('price').value)+ parseFloat(( $("subprice" + elem.value).value ));$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat(( $("courseweight" + elem.value).value));}
																																						  })
		$$("input.scheck").each(function (elem) {if(elem.checked) {$('price').value = parseFloat($('price').value) +  parseFloat(( $("courseprice" + elem.value).value));$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat( ( $("courseweight" + elem.value).value));}})

		$$("input.bcheck").each(function (elem) {if(elem.checked) {$('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));}})

		//$('cartcourseprice').innerHTML   = $('price').value;
		$('shipprice').value =0;
		$('totalprice').value =0;
		/*if($('shipprice').value)
		$('cartshiprate').innerHTML      = $('shipprice').value;
		if($('totalprice').value)
		$('carttotalprice').innerHTML      = $('totalprice').value;*/

		$$("input.scheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' + '<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		} else{gridtext = gridtext +'';}})
		$$("input.subcheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' + '<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		}else{gridtext = gridtext +'';}})
		$$("input.bcheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' + '<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		}else{gridtext = gridtext +'';}})
		var totalamnt= '$'+$('totalprice').value;
		 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;">Ship Rate -</td>' + '<td class=gridtrlastsec width=118  ><div id=shipamount style="padding-left:35px; font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';
		gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + '<td class=page_error width=118  ><div id=totalamount>'+totalamnt+'</div></td></tr></table>';
		 gridtext =gridtext+"</table>";
		 if(a!=0){
			  //$('grid').className = 'gridborder';
			 $('grid').innerHTML   = gridtext;

			 }else{
				  $('grid').innerHTML   = '';

				 }


		// cart total
	/*	$('cartcourseprice').innerHTML   = $('price').value;
		$('shipprice').value =0;
		$('totalprice').value =0;
		if($('shipprice').value)
		$('cartshiprate').innerHTML      = $('shipprice').value;
		if($('totalprice').value)
		$('carttotalprice').innerHTML      = $('totalprice').value;*/

		$(showdivid).style.display = "none";



	}

	function show_radio_uncheck(id,index){

		// intiate variable
		var showdivid = 'showdiv'+id
		var coursediv = 'course' + id;
		var subcoursediv = 'subcourse';
		var coursebdiv = 'course_b' +id;
		var agreediv = 'agree' + id;
		var disagreediv = 'disagree' + id;
		$(showdivid).style.display = "none";

		if($(coursediv))
		$(coursediv).checked =false;
		if($(subcoursediv)){
			$('course0').checked = false;
			$('course0').disabled = true;
		}
		/*if($(coursebdiv))
		$(coursebdiv).checked =false;*/

			var radioLength			= index.length;
				for(var i = 0; i < radioLength; i++) {
					if(index[i].value == id) {
					var indexid = i;
					}
				}
			index[indexid].checked  = false;


		$('price').value =0;
		$('totalweight').value =0;
		$('totalweight').value = 0;
		$('totalweightb').value = 0;

		//add price and weight of checked element
		$$("input.subcheck").each(function (elem) {if(elem.checked) {$('price').value =  parseFloat($('price').value)+ parseFloat(( $("subprice" + elem.value).value ));$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat(( $("courseweight" + elem.value).value));}
																																						  })
		$$("input.scheck").each(function (elem) {if(elem.checked) {$('price').value = parseFloat($('price').value) +  parseFloat(( $("courseprice" + elem.value).value));$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat( ( $("courseweight" + elem.value).value));}})

		$$("input.bcheck").each(function (elem) {if(elem.checked) {$('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));}})

		// cart total
		//$('cartcourseprice').innerHTML   = $('price').value;
		$('shipprice').value =0;
		$('totalprice').value =0;
		/*if($('shipprice').value)
		$('cartshiprate').innerHTML      = $('shipprice').value;
		if($('totalprice').value)
		$('carttotalprice').innerHTML      = $('totalprice').value;*/
		/***Grid**/
		var a =0;
		var s =0;

		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";

				$$("input.scheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' +'<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		}else{gridtext = gridtext +'';}})
		$$("input.subcheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' + '<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		} else{gridtext = gridtext +'';}})
		$$("input.bcheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' +'<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		}else{gridtext = gridtext +'';}})
		var totalamnt= '$'+$('totalprice').value;
		 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;">Ship Rate -</td>' + ' <td class=gridtrlastsec width=118  style="padding-left:35px; font-weight:bold; "><div id=shipamount>'+$('shipprice').value+'</div></td></tr>';
		gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + '<td class=gridlastsectd width=10px ></td> <td class=page_error width=118  ><div id=totalamount>'+totalamnt+'</div></td></tr></table>';
		gridtext =gridtext+"</table>";
		 if(a!=0){
			  //$('grid').className = 'gridborder';
			 $('grid').innerHTML   = gridtext;

			 }else{
				  $('grid').innerHTML   = '';

				 }





	}


	// Check for Optional Fileds
	function show_radio_check_opt(id,index){
		$('agree'+id).src	=	base_url+'/images/checkbox_check.png';
        $('disagree'+id).src	=	base_url+'/images/checkbox_uncheck.png';
		var showdivid = 'showdiv'+id
		var coursediv = 'course' + id;
		var subcoursediv = 'subcourse';
		var coursebdiv = 'course_b' +id;
		var agreediv = 'agree' + id;
		var disagreediv = 'disagree' + id;

		if($(coursediv))
		$(coursediv).checked =true;
		if($(subcoursediv)){
			//$('course0').disabled = true;

		}

		if($(coursebdiv)){
                    if($('sel_course_b').value >0) $('course_bimg'+$('sel_course_b').value).src	=	base_url+'/images/radio_nonselection.png';
                    $('sel_course_b').value=id
                    $(coursebdiv).checked =true;
                    $('course_bimg'+id).src	=	base_url+'/images/radio_select.png';
                }
		if(index){
		var radioLength			= index.length;
				for(var i = 0; i < radioLength; i++) {
					if(index[i].value == id) {
					var indexid = i;
					}
				}
			index[indexid].checked  = true;
		}

		$('price').value =0;
		$('totalweight').value =0;
		$('totalweight').value = 0;
		$('totalweightb').value = 0;
		var a =0;
		var s =0;
		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";

		//add price and weight of checked element
		$$("input.subcheck").each(function (elem) {if(elem.checked) {$('price').value =  parseFloat($('price').value)+ parseFloat(( $("subprice" + elem.value).value ));$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat(( $("courseweight" + elem.value).value));}
																																						  })
		$$("input.scheck").each(function (elem) {if(elem.checked) {$('price').value = parseFloat($('price').value) +  parseFloat(( $("courseprice" + elem.value).value));$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat( ( $("courseweight" + elem.value).value));}})

		$$("input.bcheck").each(function (elem) {if(elem.checked) {$('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));}})

		//$('cartcourseprice').innerHTML   = $('price').value;
		$('shipprice').value =0;
		$('totalprice').value =0;
		/*if($('shipprice').value)
		$('cartshiprate').innerHTML      = $('shipprice').value;
		if($('totalprice').value)
		$('carttotalprice').innerHTML      = $('totalprice').value;*/

		var totalamnt=0;
		$$("input.scheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' + '<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';

			totalamnt += parseFloat(carr["'"+elem.value+"'"][1]);
		}else{gridtext = gridtext +'';}})

		$$("input.subcheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td class="secondrow" width="611px" style="border-right:1px solid #000; border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][0]+'</td>' + ' <td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';
			totalamnt += parseFloat(carr["'"+elem.value+"'"][1]);

		}else{gridtext = gridtext +'';}})
		$$("input.bcheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td class="secondrow" width="611px" style="border-right:1px solid #000;  border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][0]+'</td>' + '<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';

			totalamnt += parseFloat(carr["'"+elem.value+"'"][1]);
		} else{gridtext = gridtext +'';}})
		//var totalamnt= '$'+$('totalprice').value;
		 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;">Ship Rate -</td>' + ' <td class=gridtrlastsec width=118 ><div id=shipamount style="padding-left:35px; font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';
		gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470>Total Price -</td>' + '<td class=gridlastsectd width=10px ></td> <td class=page_error width=118  ><div id=totalamount>$'+totalamnt+'</div></td></tr></table>';

		 gridtext =gridtext+"</table>";
		 if(a!=0){
			  //$('grid').className = 'gridborder';
			 $('grid').innerHTML   = gridtext;

			 }else{
				  $('grid').innerHTML   = '';

				 }


		// cart total
		/*$('cartcourseprice').innerHTML   = $('price').value;
		$('shipprice').value =0;
		$('totalprice').value =0;
		if($('shipprice').value)
		$('cartshiprate').innerHTML      = $('shipprice').value;
		if($('totalprice').value)
		$('carttotalprice').innerHTML      = $('totalprice').value;*/

		$(showdivid).style.display = "none";



	}
	function show_radio_uncheck_opt(id,index){

		// intiate variable
		var showdivid = 'showdiv'+id
		var coursediv = 'course' + id;
		var subcoursediv = 'subcourse';
		var coursebdiv = 'course_b' +id;
		var agreediv = 'agree' + id;
		var disagreediv = 'disagree' + id;
		$(showdivid).style.display = "none";

		if($(coursediv)){
                    $(coursediv).checked =false;

                }
		if($(subcoursediv)){
			/*$('course0').checked = false;
			$('course0').disabled = false;*/
		}
		if($(coursebdiv)){
		$(coursebdiv).checked =false;
                $('course_bimg'+id).src	=	base_url+'/images/radio_nonselection.png';
                }
			var radioLength			= index.length;
				for(var i = 0; i < radioLength; i++) {
					if(index[i].value == id) {
					var indexid = i;
					}
				}
			index[indexid].checked  = false;


		$('price').value =0;
		$('totalweight').value =0;
		$('totalweight').value = 0;
		$('totalweightb').value = 0;

		//add price and weight of checked element
		$$("input.subcheck").each(function (elem) {if(elem.checked) {$('price').value =  parseFloat($('price').value)+ parseFloat(( $("subprice" + elem.value).value ));$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat(( $("courseweight" + elem.value).value));}
																																						  })
		$$("input.scheck").each(function (elem) {if(elem.checked) {$('price').value = parseFloat($('price').value) +  parseFloat(( $("courseprice" + elem.value).value));$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat( ( $("courseweight" + elem.value).value));}})

		$$("input.bcheck").each(function (elem) {if(elem.checked) {$('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));}})

		// cart total
		//$('cartcourseprice').innerHTML   = $('price').value;
		$('shipprice').value =0;
		$('totalprice').value =0;
		/*if($('shipprice').value)
		$('cartshiprate').innerHTML      = $('shipprice').value;
		if($('totalprice').value)
		$('carttotalprice').innerHTML      = $('totalprice').value;*/
		/***Grid**/
		var a =0;
		var s =0;
		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";
		$$("input.scheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' +'<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		}else{gridtext = gridtext +'';}})
		$$("input.subcheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' + '<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		} else{gridtext = gridtext +'';}})
		$$("input.bcheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px" >'+carr["'"+elem.value+"'"][0]+'</td>' +'<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		} else{gridtext = gridtext +'';}})
		var totalamnt= '$'+$('totalprice').value;
		 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;">Ship Rate -</td>' + '<td class=gridtrlastsec width=118 style="padding-left:35px; font-weight:bold; "  ><div id=shipamount>'+$('shipprice').value+'</div></td></tr>';
		gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + '<td class=gridlastsectd width=10px ></td> <td class=page_error width=118  ><div id=totalamount>'+totalamnt+'</div></td></tr></table>';
		gridtext =gridtext+"</table>";
		 if(a!=0){
			  //$('grid').className = 'gridborder';
			 $('grid').innerHTML   = gridtext;

			 }else{
				  $('grid').innerHTML   = '';

				 }




	}



	// select rate
	function selectrate(val){
                         //unselect all
                         $$(".shiprate_radios").each(function(elmt) {elmt.src = base_url+'/images/radio_nonselection.png';});
                        if($('shipid').value>0)  $('ship'+$('shipid').value).src	=	base_url+'/images/radio_nonselection.png';
                        $('ship'+val).src	=	base_url+'/images/radio_select.png';
                        $('shipid').value=val;
			$('shipprice').value=0;
			if($('price').value !=0){
				var shiprate= 'shiprate'+val;
				$('shipprice').value=$(shiprate).value;
				$('totalprice').value=Math.round((parseFloat($(shiprate).value) + parseFloat($('price').value) )*100)/100;
					//$('carttotal').style.display   = "block";
					//$('cartcourseprice').innerHTML   = $('price').value;
					if($('shipprice').value)
					//$('cartshiprate').innerHTML      = $('shipprice').value;
					$('shipamount').innerHTML      = $('shipprice').value;


					if($('totalprice').value)
					//$('carttotalprice').innerHTML      = $('totalprice').value;
					$('totalamount').innerHTML      = '$'+$('totalprice').value;

			}
			else{
				//alert('Select course');
				$('shipid').checked=false;
			}
	}

	function change_password() {
		$('flasherror').innerHTML 		=	'';
		$('errordisplay').innerHTML 	=	'';
		$('flashsuccess').innerHTML 	=	'';
                $("flashsuccess").style.display     = "none";
                $("close_button_success").style.display     = "none";
		if(is_field_empty("old_password",'Please enter Current Password ',"errordisplay", "close_button")==false){return false;}
		if(is_field_empty("new_password",'Please enter New Password ',"errordisplay", "close_button")==false){return false;}
		if(is_field_empty("confirm_password",'Please Retype your Password ',"errordisplay", "close_button")==false){return false;}
		var password		=	$('new_password').value;
		var confirmpassword	=	$('confirm_password').value;
		var oldpassword		=	$('old_password').value;
		if(password.length >= 6){
			 	if(is_valid_password (password) == true){
					 $('errordisplay').style.display     = "none";
                                         $('close_button').style.display     = "none";
				}else{
						$('errordisplay').style.display     = "block";
                                                $('close_button').style.display     = "block";
						$('errordisplay').innerHTML     = "Password should be in alphanumeric format";
						$('new_password').focus();
						return false;
					}
				 $('errordisplay').style.display     = "none";
                                 $('close_button').style.display     = "none";
			 }else{

				$('errordisplay').style.display     = "block";
                                $('close_button').style.display     = "block";
				$('errordisplay').innerHTML     = "Password should be minimum 6 characters";
				$('new_password').focus();
				return false;
			}
		$('errordisplay').style.display     = "none";$('close_button').style.display     = "none";
		if(password!=confirmpassword){
			$('errordisplay').style.display     = "block";
                        $('close_button').style.display     = "block";
			$('errordisplay').innerHTML = 'Password and Confirm Password do not match';
			return false;
		}
		if(password == oldpassword){
			$('errordisplay').style.display     = "block";
                        $('close_button').style.display     = "block";
			$('errordisplay').innerHTML = 'New Password should not be same as Current Password';
			return false;
		}
		$('change_password_form_adhi').action = base_url+'user/change_password/';
		$("change_password_form_adhi").submit();
	}

	function checkuserregister_2(uid){
	var error =''

	if (false == is_field_empty ("forumalias", 'Enter Forum Alias',"errordiv", "close_button")) {
	   return false;
	} else {
		if ($('forumalias').value.length < 3 ){
		   $('errordiv').style.display = "block";
                   $('close_button').style.display     = "block";
			$('forumalias').focus();
			$('errordiv').innerHTML     = "The Forum Alias field must be at least 3 characters in length";
			return false;
		} else {
			$('errordiv').style.display     = "none";
                        $('close_button').style.display     = "none";
		}
	}
	if (false == is_field_empty_wt_dummmy ("txtLicencetype","block_txtLicencetype",'Enter Licence type',"errordiv","close_button")) {

	   return false;
	} else {
		$('errordiv').style.display     = "none";
                $('close_button').style.display     = "none";
	}
	if (false == is_field_equal ("txthowhear",'Select', 'Enter So how did you hear about us?',"errordiv","close_button")) {

	   return false;
	} else {
		if($('txthowhear').value == 'Search engine' ){
			if('' == $('txtSearchengine').value){
				$('errordiv').style.display = "block";
                                $('close_button').style.display     = "block";
				$('txtSearchengine').focus();
				$('errordiv').innerHTML     = "Please enter Search Engine";
				return false;
			}
		}else if($('txthowhear').value == 'Referral from a real estate office'){
			if('' == $('txtREO').value){
				$('errordiv').style.display = "block";
                                $('close_button').style.display     = "block";
				$('txtREO').focus();
				$('errordiv').innerHTML     = "Please enter Which real estate office";
				return false;
			}
		} else {
			$('errordiv').style.display     = "none";
                        $('close_button').style.display     = "none";
		}
	}
	/*
	if (false == is_field_empty ("s_address", 'Enter Shipping Address',"errordiv")) {
		return false;
	} else {
		$('errordiv').style.display     = "none";
	}

	if (false == is_field_empty ("s_state", 'Select Shipping State',"errordiv")) {
		return false;
	} else {
		$('errordiv').style.display     = "none";
	}

	if (false == is_field_empty ("s_city", 'Enter Shipping City',"errordiv")) {
		return false;
	} else {
		$('errordiv').style.display     = "none";
	}

	if (false == is_field_empty ("s_zipcode", 'Enter Shipping Zipcode',"errordiv")) {
		return false;
	} else {
		if(checkzip($('s_zipcode')) == true){
			if((IsNumeric($('s_zipcode').value) == true)){
					$('errordiv').style.display     = "none";
					}
					else{

						$('errordiv').style.display     = "block";
						$('errordiv').innerHTML     = "Shipping Zipcode must be 5 digits";
						$('s_zipcode').focus();
						return false;

						}
			$('errordiv').style.display     = "none";

		 }else{

			$('errordiv').style.display     = "block";
			$('errordiv').innerHTML     = "Shipping Zipcode must be 5 digits";
			$('s_zipcode').focus();
			return false;
		 }

	}
		*/

	//if($('bsame').checked == false){

		if (false == is_field_empty ("b_address", 'Enter Billing Address',"errordiv","close_button")) {
			return false;
		} else {
			$('errordiv').style.display     = "none";
                        $('close_button').style.display     = "none";
		}
		if (false == is_field_empty ("b_city", 'Enter Billing City',"errordiv","close_button")) {
			return false;
		} else {
			$('errordiv').style.display     = "none";
                        $('close_button').style.display     = "none";
		}
		if (false == is_field_empty_wt_dummmy ("b_state","block_b_state", 'Select Billing State',"errordiv","close_button")) {
			return false;
		} else {
			$('errordiv').style.display     = "none";
                        $('close_button').style.display     = "none";
		}



		if (false == is_field_empty ("b_zipcode", 'Enter Billing Zipcode',"errordiv","close_button")) {
			return false;
		} else {
			if(checkzip($('b_zipcode')) == true){
			if((IsNumeric($('b_zipcode').value) == true)){
					$('errordiv').style.display     = "none";
                                        $('close_button').style.display     = "none";
					}
					else{

						$('errordiv').style.display     = "block";
                                                $('close_button').style.display     = "block";
						$('errordiv').innerHTML     = "Billing Zipcode must be 5 digits";
						$('b_zipcode').focus();
						return false;

						}
			$('errordiv').style.display     = "none";
                        $('close_button').style.display     = "none";
		 }else{

			$('errordiv').style.display     = "block";
                        $('close_button').style.display     = "block";
			$('errordiv').innerHTML     = "Billing Zipcode must be 5 digits";
			$('b_zipcode').focus();
			return false;
		 }

	}
	//}
	$('step2').value =2
	$('myform').action = base_url+'user/register_step2/'+uid;
	$('myform').submit();
}

	function show_courses(id,selval){
            if($('hidcoursetype').value !='')  var coursetype	= $('hidcoursetype').value;
            if(id==1){
                var coursetype	= selval;
                $('hidcoursetype').value=selval;
                if(coursetype =='Live'){
                    $("coursetypel").className="live_divsel";
                    $("coursetypeo").className="online_div";
                }else if(coursetype =='Online'){
                    $("coursetypel").className="live_div";
                    $("coursetypeo").className="online_divsel";
                }else{
                    $("coursetypel").className="live_div";
                    $("coursetypeo").className="online_div";
                }


                /*if(coursetype =='Live'){
                    document.getElementById("coursetypel").src	=	base_url+'/images/live_hover.png';
                    document.getElementById("coursetypeo").src	=	base_url+'/images/online_normal.png';
                }else if(coursetype =='Online'){
                    document.getElementById("coursetypel").src	=	base_url+'/images/live_normal.png';
                    document.getElementById("coursetypeo").src	=	base_url+'/images/online_hover.png';
                }else {
                    document.getElementById("coursetypel").src	=	base_url+'/images/live_normal.png';
                    document.getElementById("coursetypeo").src	=	base_url+'/images/online_normal.png';
                }*/
                $('paytype').style.display='block';
                $('hidpaymenttype').value='';
                    document.getElementById("paymenttypep").src	=	base_url+'/images/radio_nonselection.png';
                    document.getElementById("paymenttypec").src	=	base_url+'/images/radio_nonselection.png';
            }


            if($('hidpaymenttype').value !='')  var paymenttype	= $('hidpaymenttype').value;
            if(id==2){

                var paymenttype	= selval;
                $('hidpaymenttype').value=selval;
                if(paymenttype =='Package'){
                    document.getElementById("paymenttypep").src	=	base_url+'/images/radio_select.png';
                    document.getElementById("paymenttypec").src	=	base_url+'/images/radio_nonselection.png';
                }else if(paymenttype =='Cart'){
                    document.getElementById("paymenttypep").src	=	base_url+'/images/radio_nonselection.png';
                    document.getElementById("paymenttypec").src	=	base_url+'/images/radio_select.png';
                }else {
                    document.getElementById("paymenttypep").src	=	base_url+'/images/radio_nonselection.png';
                    document.getElementById("paymenttypec").src	=	base_url+'/images/radio_nonselection.png';
                }
            }
               // var coursetype = Form.getInputs('course','radio','coursetype').find(function(radio) { return radio.checked; }).value;
		//var paymenttype	=  Form.getInputs('course','radio','paymenttype').find(function(radio) { return radio.checked; }).value;
		var licensetype = $('hidlicensetype').value;
                var usertype='';
                if((licensetype == 'B') && (coursetype == 'Live') && (paymenttype == 'Package')){
				usertype = '1';
			}else if((licensetype == 'B') && (coursetype == 'Live') && (paymenttype == 'Cart')){
				usertype= '2';
			}else if((licensetype == 'B') && (coursetype == 'Online') && (paymenttype == 'Package')){
				usertype= '3';
			}else if((licensetype == 'B') && (coursetype == 'Online') && (paymenttype == 'Cart')){
				usertype = '4';
			}else if((licensetype == 'S') && (coursetype == 'Live') && (paymenttype == 'Package')){
				usertype = '5';
			}else if((licensetype == 'S') && (coursetype == 'Live') && (paymenttype == 'Cart')){
				usertype = '6';
			}else if((licensetype == 'S') && (coursetype== 'Online') && (paymenttype == 'Package')){
				usertype = '7';
			}else if((licensetype == 'S') && (coursetype == 'Online') && (paymenttype == 'Cart')){
				usertype = '8';
			}else {
				usertype = '';
			}
                        if(usertype==2 || usertype==4 || usertype==6 || usertype==8) $('crs_list_heading').style.display='block';
                        else $('crs_list_heading').style.display='none';
                        $('hidusertype').value=usertype;

		var url             =   base_url + "register_ajax/get_courses";


		var params = "licensetype="+licensetype+"&coursetype="+coursetype+"&paymentype="+paymenttype;

		new Ajax.Request(url,{
		                       method      : "post",
		                       parameters  : params,
		                       onSuccess   : update_courses,
		                       onFailure   : disp_error
		                     }
		                );

		 $('update_course_div').innerHTML = '<center><img src="'+base_url+'images/spinner.gif"/></center>';

	    function update_courses(resp_obj)
	    {
	    	$('show_courses').style.display="block";

	    	$('update_course_div').innerHTML = resp_obj.responseText;
                var  usertype=$('hidusertype').value;
                 /*if(usertype==1 || usertype==3 || usertype==5 || usertype==7) $('crs_list_heading').style.display='none';
                 else $('crs_list_heading').style.display='block';*/
	   		load_courses();
	    	//$('show_ship_div_select').style.display="block";
			//$('show_payment_div_select').style.display="block";
	    }
	    function disp_error() {
			alert("Ajax request failed");
		}
	}
	function load_courses(){
		var jsonArrassy = $('hidJson').value;
		carr = eval('('+jsonArrassy+')');

		for(var i=0; i<carr.length; i++){
			//alert(carr[i]['course_id']);
			carr["'"+carr[i]['course_id']+"'"] 	= new Array();
			carr["'"+carr[i]['course_id']+"'"][0]	= carr[i]['course_name'];
			carr["'"+carr[i]['course_id']+"'"][1]	= carr[i]['amount'];
		}
	}
	function show_radio_package_check_opt(id,index){

		// intiate variable
		var showdivid = 'showdiv'+id
		$(showdivid).style.display = "block";
		var coursediv = 'course' + id;
		var coursebdiv = 'course_b' +id;
		/*var coursepdiv = 'course_p' +id;*/
		var agreediv = 'agree' + id;
		var disagreediv = 'disagree' + id;
                var sel = 'selagree' + id;
		if($(sel).value >0) {$('agree'+id).src	=	base_url+'/images/checkbox_check.png';
                        $('disagree'+id).src	=	base_url+'/images/checkbox_uncheck.png';
                        
                }
                if( $('agree_newpackage'+id))
                $('agree_newpackage'+id).src	=	base_url+'/images/checkbox_uncheck.png';
                if( $('disagree_newpackage'+id))
                $('disagree_newpackage'+id).src	=	base_url+'/images/checkbox_uncheck.png';
		
                if($(coursediv))
		$(coursediv).checked =false;

		if($(coursebdiv))
		$(coursebdiv).checked =false;

		/*if($(coursepdiv))
		$(coursepdiv).checked =true;*/

		$(agreediv).checked =false;
		$(disagreediv).checked =false;
		$('course_b').checked=0;
	/*	$('course_p').checked=0;		*/
		$('price').value =0;
		$('totalweight').value =0;
		$('totalweightb').value = 0;
                //window.location.hash = showdivid;
                //document.getElementById(showdivid).scrollIntoView();
                smoothScroll(showdivid);
	}
        function show_radio_package_check_opt_newpackage(id,index){

		// intiate variable
		var showdivid = 'showdiv_newpackage'+id
		$(showdivid).style.display = "block";
		var coursediv = 'course_newpackage' + id;
		var coursebdiv = 'course_b_newpackage' +id;
		/*var coursepdiv = 'course_p' +id;*/
		var agreediv = 'agree_newpackage' + id;
		var disagreediv = 'disagree_newpackage' + id;
                var sel = 'selagree_newpackage' + id;
		if($(sel).value >0) {$('agree_newpackage'+id).src	=	base_url+'/images/checkbox_check.png';
                        $('disagree_newpackage'+id).src	=	base_url+'/images/checkbox_uncheck.png';
                }
                
                $('agree'+id).src	=	base_url+'/images/checkbox_uncheck.png';
                $('disagree'+id).src	=	base_url+'/images/checkbox_uncheck.png';
                
		if($(coursediv))
		$(coursediv).checked =false;

		if($(coursebdiv))
		$(coursebdiv).checked =false;

		/*if($(coursepdiv))
		$(coursepdiv).checked =true;*/

		$(agreediv).checked =false;
		$(disagreediv).checked =false;
		$('course_b_newpackage').checked=0;
	/*	$('course_p').checked=0;		*/
		$('price').value =0;
		$('totalweight').value =0;
		$('totalweightb').value = 0;
                //window.location.hash = showdivid;
                //document.getElementById(showdivid).scrollIntoView();
                smoothScroll(showdivid);
	}
function currentYPosition() {
    // Firefox, Chrome, Opera, Safari
    if (self.pageYOffset) return self.pageYOffset;
    // Internet Explorer 6 - standards mode
    if (document.documentElement && document.documentElement.scrollTop)
        return document.documentElement.scrollTop;
    // Internet Explorer 6, 7 and 8
    if (document.body.scrollTop) return document.body.scrollTop;
    return 0;
}
function elmYPosition(eID) {
    var elm = document.getElementById(eID);
    var y = elm.offsetTop;
    var node = elm;
    while (node.offsetParent && node.offsetParent != document.body) {
        node = node.offsetParent;
        y += node.offsetTop;
    } return y;
}
function smoothScroll(eID) {
    var startY = currentYPosition();
    var stopY = elmYPosition(eID);
    var distance = stopY > startY ? stopY - startY : startY - stopY;
    if (distance < 100) {
        scrollTo(0, stopY); return;
    }
    var speed = Math.round(distance / 100);
    if (speed >= 20) speed = 20;
    var step = Math.round(distance / 25);
    var leapY = stopY > startY ? startY + step : startY - step;
    var timer = 0;
    if (stopY > startY) {
        for ( var i=startY; i<stopY; i+=step ) {
            setTimeout("window.scrollTo(0, "+leapY+")", timer * speed);
            leapY += step; if (leapY > stopY) leapY = stopY; timer++;
        } return;
    }
    for ( var i=startY; i>stopY; i-=step ) {
        setTimeout("window.scrollTo(0, "+leapY+")", timer * speed);
        leapY -= step; if (leapY < stopY) leapY = stopY; timer++;
    }
    return false;
}

function show_broker_packagecheck(id,amount){

		// intiate variable
		if(id !=0){
                        $('agree'+id).src	=	base_url+'/images/checkbox_check.png';
                        $('disagree'+id).src	=	base_url+'/images/checkbox_uncheck.png';
			var showdivid = 'showdiv'+id
			var coursediv = 'course' + id;
			var coursebdiv = 'course_b' +id;

			var agreediv = 'agree' + id;
			var disagreediv = 'disagree' + id;
                        var sel = 'selagree' + id;

			if($(coursediv))
			$(coursediv).checked =true;

			if($(coursebdiv))
			$(coursebdiv).checked =true;
			$('course_bimg').src	=	base_url+'/images/radio_select.png';


			$('price').value =amount;
			//$('totalweight').value =0;

			var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";
			//add price and weight of checked element
			//add price and weight of checked element
			//$$("input.pcheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));	$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));} })
			gridtext =gridtext+ '<tr class=gridrowsec ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">Package</td>' +' <td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+amount+'</td></tr>';

			$('shipprice').value =0;
			//$('totalprice').value =0;
			var coursesum1 = amount;
			var totalamnt= amount;
			 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;" >Ship Rate -</td>' + '<td class=gridtrlastsec width=100 style="padding-left:35px;"  ><div id=shipamount style="font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';


			gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + ' <td class=page_error width=118  ><div id=totalamount>$'+totalamnt+'</div></td></tr></table>';
			gridtext =gridtext+"</table>";
			$('course_b').checked=1;
			$(sel).value=1;
			$('grid').innerHTML   = gridtext;
			$(showdivid).style.display = "none";
		}
	}


	// uncheck packages
	function show_broker_packageuncheck(id){
		// intiate variable
		var showdivid = 'showdiv'+id
		var coursediv = 'course' + id;
		var coursebdiv = 'course_b' +id;
		var coursepdiv = 'course_p' +id;
		var agreediv = 'agree' + id;
		var disagreediv = 'disagree' + id;
                var sel = 'selagree' + id;
		$(showdivid).style.display = "none";

		if($(coursediv))
		$(coursediv).checked =false;

		$(sel).value =0;
                 $('agree'+id).src	=	base_url+'/images/checkbox_uncheck.png';
                        $('disagree'+id).src	=	base_url+'/images/checkbox_uncheck.png';
		$('price').value =0;
		$('totalweightb').value = 0;
		$('totalprice').value = 0;
		$('course_b').checked=0;
                $('course_bimg').src	=	base_url+'/images/radio_nonselection.png';
		$('grid').innerHTML   = '';
	}



	function showpackagecheck(id,amount){
		if(id ==0){if($('hidcrsid').value>0)
                        $('course_b'+$('hidcrsid').value).checked ==false;
		// intiate variable
		        $('agree'+id).src	=	base_url+'/images/checkbox_check.png';
                        $('disagree'+id).src	=	base_url+'/images/checkbox_uncheck.png';
			var showdivid = 'showdiv'+id
			var coursediv = 'course' + id;
			var coursebdiv = 'course_b' +id;
		/*	var coursepdiv = 'course_p' +id;*/
			var agreediv = 'agree' + id;
			var disagreediv = 'disagree' + id;
			var sel = 'selagree' + id;
			if($(coursediv))
			$(coursediv).checked =true;

			if($('courseb'))
                        {
                            $('courseb').checked =true;
                            $('courseb_newpackage').checked =false;
                        }
			
                        $('course_bimg').src	=	base_url+'/images/radio_select.png';
                        $('course_bimg_newpackage').src	=	base_url+'/images/radio_nonselection.png';


			/*if($(coursepdiv))
		$(coursepdiv).checked =true;*/

			$('price').value =amount;
			//$('totalweight').value =0;
			if($('course_b').checked ==true && $('course_b'+id).checked ==true)
			$('totalweight').value =  parseFloat($('weight').value) +  parseFloat($("courseweight_b"+id).value)
                        else $('totalweight').value =  parseFloat($('weight').value)
                        $('hidwt').value =parseFloat($("totalweight").value);

			var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";
			//add price and weight of checked element
			//add price and weight of checked element
			//$$("input.pcheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));	$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));} })
			gridtext =gridtext+ '<tr class=gridrowsec ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">Package</td>' +' <td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+amount+'</td></tr>';

			$('shipprice').value =0;
			$('totalprice').value =amount;
			var coursesum1 = amount;
			var totalamnt= $('totalprice').value;

			 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;" >Ship Rate -</td>' + '<td class=gridtrlastsec width=100 style="padding-left:35px;"  ><div id=shipamount style="font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';


			gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + ' <td class=page_error width=118  ><div id=totalamount>$'+totalamnt+'</div></td></tr></table>';
			gridtext =gridtext+"</table>";
			$('course_b').checked=1;

			$('grid').innerHTML   = gridtext;
			$(showdivid).style.display = "none";
                        $('new_package').value = 0;
		}
	}


	// uncheck packages
	function showpackageuncheck(id){
		// intiate variable
		var showdivid = 'showdiv'+id
		var coursediv = 'course' + id;
		var coursebdiv = 'course_b' +id;
		/*var coursepdiv = 'course_p' +id;*/
		var agreediv = 'agree' + id;
		var disagreediv = 'disagree' + id;
                var sel = 'selagree' + id;
		$(showdivid).style.display = "none";

		if($(coursediv))
		$(coursediv).checked =false;
		$(sel).value =0;
                $('agree'+id).src	=	base_url+'/images/checkbox_uncheck.png';
                $('disagree'+id).src	=	base_url+'/images/checkbox_uncheck.png';
		if($(coursebdiv))
		$(coursepdiv).checked =false;
                if($('courseb'))
		$('courseb').checked =false;
                $('course_bimg').src	=	base_url+'/images/radio_nonselection.png';



		$('price').value =0;
		$('totalweightb').value = 0;
		$('totalprice').value = 0;
		$('course_b').checked=0;
		/*$('course_p').checked=0;*/
		$('grid').innerHTML   = '';
	}
        
        
	function showpackagecheck_newpackage(id,amount){
		if(id ==0){
                       if($('hidcrsid').value>0){
                            $('course_b'+$('hidcrsid').value).checked = false;
                            $('course_bimg'+$('hidcrsid').value).src	=	base_url+'/images/radio_nonselection.png';
                            $('agree'+$('hidcrsid').value).src	=	base_url+'/images/checkbox_uncheck.png';
                        }
		// intiate variable
		        $('agree_newpackage'+id).src	=	base_url+'/images/checkbox_check.png';
                        $('disagree_newpackage'+id).src	=	base_url+'/images/checkbox_uncheck.png';
			var showdivid = 'showdiv_newpackage'+id
			var coursediv = 'course_newpackage' + id;
			var coursebdiv = 'course_b_newpackage' +id;
		/*	var coursepdiv = 'course_p' +id;*/
			var agreediv = 'agree_newpackage' + id;
			var disagreediv = 'disagree_newpackage' + id;
			var sel = 'selagree_newpackage' + id;
			if($(coursediv))
			$(coursediv).checked =true;

			if($('courseb_newpackage')) 
                        {
                            $('courseb_newpackage').checked =true;
                            $('courseb').checked =false;
                        }
			
                        $('course_bimg_newpackage').src	=	base_url+'/images/radio_select.png';
                        $('course_bimg').src	=	base_url+'/images/radio_nonselection.png';

			/*if($(coursepdiv))
		$(coursepdiv).checked =true;*/

			$('price').value =amount;
			//$('totalweight').value =0;
			if($('course_b_newpackage').checked ==true && $('course_b_newpackage'+id).checked ==true)
			$('totalweight').value =  parseFloat($('weight_newpackage').value) 
                        else $('totalweight').value =  parseFloat($('weight_newpackage').value)
                        $('hidwt').value =parseFloat($("totalweight").value);

			var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";
			//add price and weight of checked element
			//add price and weight of checked element
			//$$("input.pcheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));	$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));} })
			gridtext =gridtext+ '<tr class=gridrowsec ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">Package</td>' +' <td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+amount+'</td></tr>';

			$('shipprice').value =0;
			$('totalprice').value =amount;
			var coursesum1 = amount;
			var totalamnt= $('totalprice').value;

			 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;" >Ship Rate -</td>' + '<td class=gridtrlastsec width=100 style="padding-left:35px;"  ><div id=shipamount style="font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';


			gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + ' <td class=page_error width=118  ><div id=totalamount>$'+totalamnt+'</div></td></tr></table>';
			gridtext =gridtext+"</table>";
			$('course_b').checked=1;

			$('grid').innerHTML   = gridtext;
			$(showdivid).style.display = "none";
                        $('new_package').value =1;
                        $('sel_course_b').value = 0;
                        $('sel_course_m').value = 0;
                        
		}
	}


	// uncheck packages
	function showpackageuncheck_newpackage(id){
		// intiate variable
		var showdivid = 'showdiv_newpackage'+id
		var coursediv = 'course_newpackage' + id;
		var coursebdiv = 'course_b_newpackage' +id;
		/*var coursepdiv = 'course_p' +id;*/
		var agreediv = 'agree_newpackage' + id;
		var disagreediv = 'disagree_newpackage' + id;
                var sel = 'selagree_newpackage' + id;
		$(showdivid).style.display = "none";

		if($(coursediv))
		$(coursediv).checked =false;
		$(sel).value =0;
                 $('agree_newpackage'+id).src	=	base_url+'/images/checkbox_uncheck.png';
                        $('disagree'+id).src	=	base_url+'/images/checkbox_uncheck.png';
		if($(coursebdiv))
		$(coursepdiv).checked =false;
                if($('courseb_newpackage'))
		$('courseb_newpackage').checked =false;
                 $('course_bimg_newpackage').src	=	base_url+'/images/radio_nonselection.png';



		$('price').value =0;
		$('totalweightb').value = 0;
		$('totalprice').value = 0;
		$('course_b_newpackage').checked=0;
		/*$('course_p').checked=0;*/
		$('grid').innerHTML   = '';
	}
        
	function showpackage_opt_check(id,index){
            $('agree'+id).src	=	base_url+'/images/checkbox_check.png';
            $('disagree'+id).src	=	base_url+'/images/checkbox_uncheck.png';
			var showdivid = 'showdiv'+id
			var coursediv = 'course' + id;
			var coursebdiv = 'course_b' +id;
			var agreediv = 'agree' + id;
			var disagreediv = 'disagree' + id;
            var indexid = 'disagree' + id;
            var sel = 'selagreeop' + id;
            $(sel).value=1;
                        /* var radioLength			= index.length;
				for(var i = 0; i < radioLength; i++) {
					if(index[i].value == id) {
					var indexid = i;
                                        if(index[indexid].checked  = true) sel=i;
                                        index[indexid].checked  = false;
					}
				}*/

			if($(coursediv))
			$(coursediv).checked =true;

			if($(coursebdiv)){
                            if($('sel_course_b').value >0) $('course_bimg'+$('sel_course_b').value).src	=	base_url+'/images/radio_nonselection.png';
                             $('sel_course_b').value=id;
                            $(coursebdiv).checked =true;
                            $('course_bimg'+id).src	=	base_url+'/images/radio_select.png';
                        }
                        if($('course_b').checked ==true && $('course_b'+id).checked ==true)
			$('totalweight').value =  parseFloat($('weight').value) +  parseFloat($("courseweight_b"+id).value)
                    else
                        $('totalweight').value =  parseFloat($("courseweight_b"+id).value);
                        $('hidwt').value =parseFloat($("totalweight").value);

			$('course_b'+id).checked=1;
                        if($('hidcrsid').value >0)
                        $('course_b'+$('hidcrsid').value).checked =false;
                        $('hidcrsid').value=id;
			//$('grid').innerHTML   = gridtext;
			$(showdivid).style.display = "none";

	}
        function showpackage_opt_uncheck(id,index){

			var showdivid = 'showdiv'+id
			var coursediv = 'course' + id;
			var coursebdiv = 'course_b' +id;
			var agreediv = 'agree' + id;
			var disagreediv = 'disagree' + id;
                        var indexid = 'disagree' + id;
                        var sel = 'selagreeop' + id;

                        /* var radioLength			= index.length;
				for(var i = 0; i < radioLength; i++) {
					if(index[i].value == id) {
					var indexid = i;
                                        if(index[indexid].checked  = true) sel=i;
                                        index[indexid].checked  = false;
					}
				}*/
                        $(sel).value=0;
                        $('sel_course_b').value = 0;
			$('agree'+id).src	=	base_url+'/images/checkbox_uncheck.png';
                        $('disagree'+id).src	=	base_url+'/images/checkbox_uncheck.png';
			$('totalweight').value =  parseFloat($('hidwt').value) -  parseFloat($("courseweight_b"+id).value)
                        $('hidwt').value =parseFloat($("totalweight").value);

			$('course_b'+id).checked=false;
                        $('course_bimg'+id).src	=	base_url+'/images/radio_nonselection.png';
                        if($('hidcrsid').value >0 && $('hidcrsid').value !=id)
                        $('course_b'+$('hidcrsid').value).checked =true;
                        else    $('hidcrsid').value=0;
                       	//$('grid').innerHTML   = gridtext;
			$(showdivid).style.display = "none";

	}
function show_courses_list(){
	$('show_broker_livecourse').style.display="block";
}
function hide_courses_list(){
	$('show_broker_livecourse').style.display="none";
}
function show_opt_package_terms(id,index){

		// intiate variable
		var showdivid = 'showdiv'+id
		$(showdivid).style.display = "block";
		var coursediv = 'course' + id;
		var subcoursediv = 'subcourse' + id;
		var coursebdiv = 'course_b' +id;
		var agreediv = 'agree' + id;
		var disagreediv = 'disagree' + id;

		if($(coursediv))
		$(coursediv).checked =false;

		if($(coursebdiv))
		$(coursebdiv).checked =false;

		$(agreediv).checked =false;
		$(disagreediv).checked =false;

			var radioLength			= index.length;
				for(var i = 0; i < radioLength; i++) {
					if(index[i].checked) {
					var indexid = i;
					}
				}
			index[indexid].checked  = false;


		$('price').value =0;
		$('totalweight').value =$('weight').value;
		$('totalweightb').value = $('weight').value;;

		//add price and weight of checked element
		$$("input.subcheck").each(function (elem) {if(elem.checked) {$('price').value =  parseFloat($('price').value)+ parseFloat(( $("subprice" + elem.value).value ));$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat(( $("courseweight" + elem.value).value));}
																																						  })
		$$("input.scheck").each(function (elem) {if(elem.checked) {$('price').value = parseFloat($('price').value) +  parseFloat(( $("courseprice" + elem.value).value));$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat( ( $("courseweight" + elem.value).value));}})

		$$("input.bcheck").each(function (elem) {if(elem.checked) {$('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));}})

		// cart total
		//$('cartcourseprice').innerHTML   = $('price').value;
		$('shipprice').value =0;
		$('totalprice').value =0;
		/*if($('shipprice').value)
		$('cartshiprate').innerHTML      = $('shipprice').value;
		if($('totalprice').value)
		$('carttotalprice').innerHTML      = $('totalprice').value;*/

		/*******Grid********/
		var a =0;
		var s =0;
		coursesum1=0;
		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";

		$$("input.scheck").each(function (elem) {if(elem.checked) {num	=carr["'"+elem.value+"'"][1];coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' +'<td style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		} else{gridtext = gridtext +'';}})
		$$("input.subcheck").each(function (elem) {if(elem.checked) {num	=carr["'"+elem.value+"'"][1];coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' + '<td style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		}else{gridtext = gridtext +'';}})
		$$("input.bcheck").each(function (elem) {if(elem.checked) {num	=carr["'"+elem.value+"'"][1];coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' +'<td style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		} else{gridtext = gridtext +'';}})
		var totalamnt= '$'+$('totalprice').value;

		 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;">Ship Rate -</td>' + '<td class=gridtrlastsec width=118  ><div id=shipamount style="padding-left:35px; font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';

			$('totalprice').value=totalamnt;

		 gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + '<td class=page_error width=118  ><div id=totalamount >'+totalamnt+'</div></td></tr></table>';
		gridtext =gridtext+"</table>";
		 if(a!=0){
			  //$('grid').className = 'gridborder';
			 $('grid').innerHTML   = gridtext;

			 }else{
				  $('grid').innerHTML   = '';

				 }


 }




 // check for Mandatory fields
	// check course
	function showcheck_addnewcourse(id){
		$('agree'+id).src	=	base_url+'/images/checkbox_check.png';
                $('disagree'+id).src	=	base_url+'/images/checkbox_uncheck.png';
		// intiate variable
		if(id !=0){
		var showdivid = 'showdiv'+id
		var coursediv = 'course' + id;
		var subcoursediv = 'subcourse';
		var coursebdiv = 'course_b' +id;
		var agreediv = 'agree' + id;
		var disagreediv = 'disagree' + id;
		var sel = 'selagree' + id;
                $(sel).value=1;
		if($(coursediv)){
		$(coursediv).checked =true;
                 $('course_chkimg'+id).src	=	base_url+'/images/course_checkbox_checked.png';
                }
		if($(subcoursediv)){
			//$('course0').disabled = true;

		}

		if($(coursebdiv)){
                    $(coursebdiv).checked =true;

                }

		$('price').value =0;
		$('totalweight').value =0;
		$('totalweight').value = 0;
		$('totalweightb').value = 0;
		var a =0;
		var s =0;
		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";
		//add price and weight of checked element
		//add price and weight of checked element
		$$("input.subcheck").each(function (elem) {if(elem.checked) {$('price').value =  parseFloat($('price').value)+ parseFloat(( $("subprice" + elem.value).value ));$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat(( $("courseweight" + elem.value).value));}
																																						  })
		$$("input.scheck").each(function (elem) {if(elem.checked) {$('price').value = parseFloat($('price').value) +  parseFloat(( $("courseprice" + elem.value).value));$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat( ( $("courseweight" + elem.value).value));}})

		$$("input.bcheck").each(function (elem) {if(elem.checked) {$('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));}})

		$('shipprice').value =0;
		$('totalprice').value =0;

		$$("input.scheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' +'<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		}else{gridtext = gridtext +'';}})
		$$("input.subcheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' + ' <td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		}else{gridtext = gridtext +'';}})
		$$("input.bcheck").each(function (elem) {if(elem.checked) {
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' +'<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		}else{gridtext = gridtext +'';}})
		var totalamnt= '$'+$('totalprice').value;
		 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;">Ship Rate -</td>' + '<td class=gridtrlastsec width=118  ><div id=shipamount style="padding-left:35px; font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';
		gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + '<td class=gridlastsectd width=10px ></td> <td class=page_error width=118  ><div id=totalamount>'+totalamnt+'</div></td></tr></table>';
		gridtext =gridtext+"</table>";
		 if(a!=0){
			  //$('grid').className = 'gridborder';
			 $('grid').innerHTML   = gridtext;

			 }else{
				  $('grid').innerHTML   = '';

				 }
		$(showdivid).style.display = "none";
		}
	}

/**
 * Update zip code
 * if zipcode is wrong then call this function
 */
function update_s_zipcode()
{
	new_zipcode = $('zipcode_correct').value;

	// return false if zipcode is null
	if(new_zipcode == ''){
		$('zipcode_correct_error').innerHTML = 'please enter zip code.'
		return false;
	}
       
	// return erron if zipcode length lesthan 5
	if(new_zipcode.length < 5 || new_zipcode.length > 5){
		$('zipcode_correct_error').innerHTML = 'Zip code must have 5 digits'
		return false;
	}

	// if everything ok then show shipping button
	$('s_zipcode').value = new_zipcode;
	$('showship').hide();
	$('shipbutton').show();
	checkshipmethod();
}
function populate_certificate_name(){
	var firstname = $('firstname').value;
	var lastname = $('lastname').value;
	$('name_on_certificate').value = firstname+' '+lastname;
}

function setBillingAddr() {
    if($('setaddr').getValue() != null) {
        //
        //var https_base_url = base_url.replace(/^http:\/\//i, 'https://');
        new Ajax.Request(base_url +'user/setShippingAddrToBillingAddr', {
            method: 'post',
            parameters:'',
          onCreate: function(){
                //$('indicator').show();
                $('indicator').style.display ="inline";
		$('indicator').innerHTML = '<img src='+base_url+'images/spinner.gif>';
           },  
          onSuccess: function(response) {
              var json = response.responseText.evalJSON();
              console.log(json.data);
              if(json.status = 200){
                  $('indicator').style.display ="none";
                  $('indicator').innerHTML = '';
                  $('b_address').setValue(json.data.address);
                  $('b_city').setValue(json.data.city);
                  $('b_state').value = json.data.state_code;
                  $('block_b_state').value = json.data.state;
                  //$('b_country').setValue(json.data.country);
                  $('b_zipcode').setValue(json.data.zipcode);
              }
          }
        });

    }
    else {
        $('b_address').setValue('');
        $('b_city').setValue('');
        $('b_state').value = '';
        $('block_b_state').value = '';
        //$('b_country').setValue(json.data.country);
        $('b_zipcode').setValue('');
    }
}

function hide_errorbox() {
    document.getElementById("errordiv").style.display = "none";
    document.getElementById("close_button").style.display = "none";
}

function hide_errorbox_profile() {
    document.getElementById("errordisplay").style.display = "none";
    document.getElementById("close_button").style.display = "none";
}

function hide_errorbox_success() {
    document.getElementById("flashsuccess").style.display = "none";
    document.getElementById("close_button_success").style.display = "none";
}