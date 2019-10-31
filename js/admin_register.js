
function checkuser(){
	var error =''

	if (false == is_field_empty ("firstname", 'Enter First Name',"errordiv")) {
		$('psword').value ='';
		$('psword1').value ='';
	    return false;
	} else {
		$('errordiv').style.display     = "none";
	}
	if (false == is_field_empty ("lastname", 'Enter Last Name',"errordiv")) {
	    $('psword').value ='';
		$('psword1').value ='';
	   return false;
	} else {
		$('errordiv').style.display     = "none";
	}
        
	/*if (false == is_field_empty ("name_on_certificate", 'Enter Certificate Name',"errordiv")) {
	    $('psword').value ='';
		$('psword1').value ='';
	   return false;
	} else {
		$('errordiv').style.display     = "none";
	}*/
        if (false == is_field_empty ("driving_license", 'Enter Drivers License Number',"errordiv")) {
	    $('psword').value ='';
		$('psword1').value ='';
	   return false;
	} else {
		$('errordiv').style.display     = "none";
	}

	if (false == is_field_empty ("email", 'Enter Email Id',"errordiv")) {
	    $('psword').value ='';
		$('psword1').value ='';
	   return false;
	} else {
			if (false == is_field_empty ("confirmemail", 'Enter Confirm Email Id',"errordiv")) {
				$('psword').value ='';
				$('psword1').value ='';
				return false;
			} else {
		$('errordiv').style.display     = "none";
		}
		$('errordiv').style.display     = "none";
	}

	if (checkEmail($('email').value) == false){
		$('errordiv').style.display     = "block";
		$('errordiv').innerHTML     = "Email is not valid ";
                $('email').focus();
		 $('psword').value ='';
			$('psword1').value ='';
		 return false;
	}else{
		if($('email').value != $('confirmemail').value){
			$('errordiv').style.display     = "block";
			$('errordiv').innerHTML     = "Email Id and Confirm Email Id do not match";
			$('email').focus();
			 $('psword').value ='';
			$('psword1').value ='';
			return false;
			}


	}
	if (false == is_field_empty ("psword", 'Enter Password',"errordiv")) {
	    $('psword').value ='';
		$('psword1').value ='';
	   return false;
	} else {
		 if($('psword').value.length >= 6){
			 	if(is_valid_password ($('psword').value) == true){
					 $('errordiv').style.display     = "none";
					}
				else{
						$('errordiv').style.display     = "block";
						$('errordiv').innerHTML     = "Password should be the combination of Alphanumeric";
						$('psword').focus();
						 $('psword').value ='';
						$('psword1').value ='';
						return false;

					}
				 $('errordiv').style.display     = "none";
			 }else{

				$('errordiv').style.display     = "block";
				$('errordiv').innerHTML     = "Password should be minimum 6 characters";
				$('psword').focus();
				 $('psword').value ='';
				$('psword1').value ='';
				return false;
				 }
		$('errordiv').style.display     = "none";

	}

	if (false == is_field_empty ("psword1", 'Enter Confirm Password',"errordiv")) {
	    $('psword').value ='';
		$('psword1').value ='';
	   return false;
	} else {
		$('errordiv').style.display     = "none";
	}

	if (trim($('psword').value) != trim($('psword1').value)) {
		$('errordiv').style.display     = "block";
		$('errordiv').innerHTML     = "Password and Confirm Password do not match";
		$('psword').focus();
	    $('psword').value ='';
		$('psword1').value ='';
	   return false;
	} else {
		$('errordiv').style.display     = "none";

	}

	if (false == is_field_empty ("address", 'Enter Contact Address',"errordiv")) {
	     $('psword').value ='';
		$('psword1').value ='';
		return false;
	} else {
		$('errordiv').style.display     = "none";
	}

	if (false == is_field_empty ("city", 'Enter City',"errordiv")) {
	     $('psword').value ='';
		$('psword1').value ='';
		return false;
	} else {
		$('errordiv').style.display     = "none";
	}
	
	if (false == is_field_empty ("state", 'Select State',"errordiv")) {
	    $('psword').value ='';
		$('psword1').value ='';
	   return false;
	} else {
		$('errordiv').style.display     = "none";
	}
	
	if (false == is_field_empty ("phone", 'Enter Phone Number',"errordiv")) {
	     $('psword').value ='';
		$('psword1').value ='';
		return false;
	} else if($('phone').value.length < 10){
			$('errordiv').style.display     = "block";
			$('errordiv').innerHTML     = "Phone Number should contain minimum 10 numbers";
			$('phone').focus();
			$('psword').value ='';
			$('psword1').value ='';
			return false;
		}else {
			$('errordiv').style.display     = "none";
		}


	if (false == is_field_empty ("zipcode", 'Enter Zipcode',"errordiv")) {
	    $('psword').value ='';
		$('psword1').value ='';
	   return false;
	} else {

			if(checkzip($('zipcode')) == true){
				if((IsNumeric($('zipcode').value) == true)){
						$('errordiv').style.display     = "none";
						}
						else{
							$('errordiv').style.display     = "block";
							$('errordiv').innerHTML     = "Zipcode must be 5 digits";
							$('zipcode').focus();
							 $('psword').value ='';
							$('psword1').value ='';
							return false;
						}
				$('errordiv').style.display     = "none";

			 }else{

				$('errordiv').style.display     = "block";
				$('errordiv').innerHTML     = "Zipcode must be 5 digits";
				$('zipcode').focus();
				 $('psword').value ='';
				$('psword1').value ='';
				return false;
			 }
	}

	if (false == is_field_empty ("testimonial", 'Enter how did you hear about us',"errordiv")) {
	    $('psword').value ='';
		$('psword1').value ='';
	   return false;
	} else {
		$('errordiv').style.display     = "none";
	}
        
        if (false == is_field_empty ("txtSearchengine", 'Enter which search engine',"errordiv") && $('testimonial').value == "Search engine") {
	    $('psword').value ='';
		$('psword1').value ='';
	   return false;
	} else {
		$('errordiv').style.display     = "none";
	}
        
        if (false == is_field_empty ("txtREO", 'Enter which real estate office',"errordiv") && $('testimonial').value == "Referral from a real estate office") {
	    $('psword').value ='';
		$('psword1').value ='';
	   return false;
	} else {
		$('errordiv').style.display     = "none";
	}
        /*
	if (false == is_field_empty ("captcha_code", 'Enter Verification Code',"errordiv")) {
	     $('psword').value ='';
		$('psword1').value ='';
		return false;
	} else {
		$('errordiv').style.display     = "none";
	}
        */


	$('step1').value =1
	$('myform').action = base_url+'admin_register/register';
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

	function checkbilling(){


		if($('bsame').checked == false){

			//$('shipping').style.display   = "block";
			$('b_address').value			= '';
			$('b_state').value		 		= '';
			$('b_city').value		 		= '';
			$('b_zipcode').value	 		= '';
			$('b_address').readOnly			= false;
			$('b_city').readOnly			= false;
			$('b_state').readOnly			= false;
			$('b_zipcode').readOnly			= false;

			$('b_state').setAttribute('readonly',false);

		}else{

			//$('shipping').style.display		= "none";
			if( $('s_address').value !=''){
				//alert('hi');
				$('b_address').value			= $('s_address').value;
				$('b_state').value		 		= $('s_state').value;
				$('b_city').value		 		= $('s_city').value;
				$('b_zipcode').value	 		= $('s_zipcode').value;
				$('b_address').readOnly=true;
				$('b_city').readOnly=true;

				$('b_state').setAttribute('readonly',true);
				$('b_zipcode').readOnly=true;
			}else{

				$('b_address').value			= '';
				$('b_state').value		 		= '';
				$('b_city').value		 		= '';
				$('b_zipcode').value	 		= '';

			}

		}
	}

	/**
	For registration without shipping
	*/

	function no_shipping(){


			if (false == is_field_empty ("b_address", 'Enter Billing Address',"errordiv")) {
				return false;
			} else {
				$('errordiv').style.display     = "none";
			}

			if (false == is_field_empty ("b_state", 'Select Billing State',"errordiv")) {
				return false;
			} else {
				$('errordiv').style.display     = "none";
			}

			if (false == is_field_empty ("b_city", 'Enter Billing City',"errordiv")) {
				return false;
			} else {
				$('errordiv').style.display     = "none";
			}

			if (false == is_field_empty ("b_zipcode", 'Enter Billing Zipcode',"errordiv")) {
				return false;
			} else {
					if(checkzip($('b_zipcode')) == true){
					if((IsNumeric($('b_zipcode').value) == true)){
							$('errordiv').style.display     = "none";
							}
							else{

								$('errordiv').style.display     = "block";
								$('errordiv').innerHTML     = "Billing Zipcode must be 5 digits";
								$('b_zipcode').focus();
								return false;

								}
					$('errordiv').style.display     = "none";

				 }else{

					$('errordiv').style.display     = "block";
					$('errordiv').innerHTML     = "Billing Zipcode must be 5 digits";
					$('b_zipcode').focus();
					return false;
				 }

			}
			return true;

	}

function checkpackageshipmethod(){
	if($('sel_package').value == ''){
		$('errordiv').style.display     = "block";
		$('errordiv').innerHTML     = "Select Package";
		return false;
	}else {
		$('mygif').style.display ="block";
		$('mygif').innerHTML = '<img src='+base_url+'images/spinner.gif>';
		var update_div  =   'showship';


        var book_count  = 0;
        if($$('input[type="radio"][name="paymenttype"]:checked]').length > 0
            && 'Package' == $$('input[type="radio"][name="paymenttype"]:checked')[0].value){//if user selects Package
            if('S' == $('hidlicensetype').value){//Course type Sales
                book_count = $$('input[name="course_p"]:checked')[0].readAttribute('data-books-count');
            }else{//Course type Broker
                book_count = $$('input[name="course_b"]:checked')[0].readAttribute('data-books-count');
            }
        }else{//if user selects Cart
            if('S' == $('hidlicensetype').value){//Course type Sales
                book_count = $$('input[name="course[]"]:checked').length + $$('input[name="course_b"]:checked').length;
            }else{//Course type Sales
                book_count = $$('input[name="course[]"]:checked').length;
            }
        }

		var url         =   base_url + "register_ajax/get_ship";
		var params      =   's_address='+escape($('s_address').value)+'&s_city='+escape($('s_city').value)+'&s_zipcode='+escape($('s_zipcode').value)+'&s_state='+escape($('s_state').value)
							+'&s_country='+escape($('s_country').value)+'&s_phone='+escape($('bphone').value)+'&weight='+escape($('weight').value)+'&book_count='+book_count;
	  //  url = base_url + url;

		new Ajax.Request(url,{
		                       method      : "post",
		                       onSuccess   : shoshipmethod,
							   parameters  : params,
		                       onFailure   : disp_shiperror
		                     }
		                );
	}
}
// List ship method
function checkshipmethod(){
	var weight = 0.0;
	//alert($('totalweight').value);
	//alert($('totalweightb').value);
	//alert($('subcourseweight').value);
	if($('totalweight').value!=0)
		weight= Math.round((parseFloat(weight)+ parseFloat($('totalweight').value))*10)/10;
	if($('totalweightb').value!=0)
		weight= Math.round((parseFloat(weight)+ parseFloat($('totalweightb').value))*10)/10;
	/*if($('subcourseweight').value!=0)
		weight= Math.round((parseFloat(weight)+ parseFloat($('subcourseweight').value))*10)/10;*/

	var cc= weight.toString();
	var weight =  BRS(cc);
	//alert(weight);

    var new_package = 0;
	var usertype = $('hidusertype').value;

	if($('new_package')){
        new_package = $('new_package').value;
    }

	if($('price').value !=0){
		try{
			if(($('sel_course_b').value) == 0 && ($('sel_course_m').value == 0) && (usertype == 5 || usertype == 7) && (new_package != 1)){
					$('errordiv').style.display     = "block";
					$('errordiv').innerHTML     = "Select at least one course";
					return false;
			}
		}catch(err){
        	
		}
	}else{
		
		$('errordiv').style.display     = "block";
		if(usertype == 1 || usertype == 3 || usertype == 5 || usertype == 7 ){
			$('errordiv').innerHTML     = "Select package";
		}else {
			$('errordiv').innerHTML     = "Select at least one course";
		}
		return false;
	}

	$('mygif').style.display ="block";
	$('mygif').innerHTML = '<img src='+base_url+'images/spinner.gif>';
	var update_div  =   'showship';

    var book_count  = 0;
    console.log('paymenttype checked '+$$('input[type="radio"][name="paymenttype"]:checked]').length);
    if($$('input[type="radio"][name="paymenttype"]:checked]').length > 0
		&& 'Package' == $$('input[type="radio"][name="paymenttype"]:checked')[0].value){//if user selects Package
        console.log('license type '+$('hidlicensetype').value);
        if('S' == $('hidlicensetype').value){//Course type Sales
			if($$('input[name="course_b_newpackage"]:checked').length > 0){
                book_count = $$('input[name="course_b_newpackage"]:checked')[0].readAttribute('data-books-count');
            }else{
                book_count = $$('input[name="course_b"]:checked')[0].readAttribute('data-books-count');
            }
        }else{//Course type Broker
            book_count = $$('input[name="course_b"]:checked')[0].readAttribute('data-books-count');
        }
        console.log(book_count);
    }else{//if user selects Cart
        if('S' == $('hidlicensetype').value){//Course type Sales
            book_count = $$('input[name="course[]"]:checked').length + $$('input[name="course_b"]:checked').length;
        }else{//Course type Sales
            book_count = $$('input[name="course[]"]:checked').length;
        }
    }
    console.log('book_count is '+book_count);



	var url             =   base_url + "register_ajax/get_ship";
	var params      =   's_address='+escape($('s_address').value)+'&s_city='+escape($('s_city').value)+'&s_zipcode='+escape($('s_zipcode').value)+'&s_state='+escape($('s_state').value)
						+'&s_country='+escape($('s_country').value)+'&s_phone='+escape($('bphone').value)+'&weight='+weight+'&book_count='+book_count;
	new Ajax.Request(url,{
	                       method      : "post",
	                       onSuccess   : shoshipmethod,
                               parameters  : params,
	                       onFailure   : disp_shiperror
	                     }
	                );

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
			$('update_s_zipcode_btn').src = base_url + 'images/innerpages/update.jpg';
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
function check_step2(){
	/*if (false == is_field_empty ("forumalias", 'Enter Forum Alias',"errordiv")) {
	    return false;
	} else {
		if($('forumalias').value.length < 3){
		 	$('errordiv').style.display     = "block";
			$('errordiv').innerHTML     = "Forum Alias should be minimum 3 characters";
			$('forumalias').focus();
			return false;
		 }
		$('errordiv').style.display     = "none";
	}
    */
        
	if (false == is_field_empty ("license", 'Select License Type',"errordiv")) {
	   return false;
	} else {
		$('errordiv').style.display     = "none";
	}
	if($('need_payment_yes').checked){
		//if($('bsame').checked == false){

				if (false == is_field_empty ("b_address", 'Enter Billing Address',"errordiv")) {
					return false;
				} else {
					$('errordiv').style.display     = "none";
				}

				if (false == is_field_empty ("b_state", 'Select Billing State',"errordiv")) {
					return false;
				} else {
					$('errordiv').style.display     = "none";
				}

				if (false == is_field_empty ("b_city", 'Enter Billing City',"errordiv")) {
					return false;
				} else {
					$('errordiv').style.display     = "none";
				}

				if (false == is_field_empty ("b_zipcode", 'Enter Billing Zipcode',"errordiv")) {
					return false;
				} else {
					if(checkzip($('b_zipcode')) == true){
					if((IsNumeric($('b_zipcode').value) == true)){
							$('errordiv').style.display     = "none";
							}
							else{

								$('errordiv').style.display     = "block";
								$('errordiv').innerHTML     = "Billing Zipcode must be 5 digits";
								$('b_zipcode').focus();
								return false;

								}
					$('errordiv').style.display     = "none";

				 }else{

					$('errordiv').style.display     = "block";
					$('errordiv').innerHTML     = "Billing Zipcode must be 5 digits";
					$('b_zipcode').focus();
					return false;
				 }

				}
		//}


	}

	$('step2').value =2
	$('myform').action = base_url+'admin_register/register_step2';
	$('myform').submit();
}

// list ship method
function addcourses(){ 
	var error =0 ;
	var year=$('curyear').value;
	var month=$('curmonth').value;

	var usertype = $('hidusertype').value;
	if($('price').value !=0){
		if(($('sel_course_b').value) == 0 && (usertype == 5 || usertype == 7) && $('course_b').checked){
			$('errordiv').style.display     = "block";
			$('errordiv').innerHTML     = "Select a course";
			return false;
		}
	}else{
		$('errordiv').style.display     = "block";
		if(usertype == 1 || usertype == 3 || usertype == 5 || usertype == 7 ){
			$('errordiv').innerHTML     = "Select package";
		}else {
			$('errordiv').innerHTML     = "Select at least one course";
		}
		return false;
	}

	if($('need_ship').value =='yes'){

		if($('shipprice').value == 0){
			$('errordiv').style.display     = "block";
			$('errordiv').innerHTML     = "Select ship method";
			return false;
		}
	}

	if($('need_payment').value =='yes'){
		if (false == is_field_empty ("cardtype", 'Select Card Type',"errordiv")) {
		   return false;
		} else {
			$('errordiv').style.display     = "none";
		}
		if (false == is_field_empty ("ccno", 'Enter Credit Card No',"errordiv")) {

		   return false;
		}
		 if($('cardtype').value == 'Amex' ){
			if($('ccno').value.length != 15){

					$('errordiv').style.display     = "block";
					$('errordiv').innerHTML     = "Enter valid Credit Card Number";
					$('ccno').focus();
					return false;
			}
			if($('cvv2no').value.length != 4 ){
					$('errordiv').style.display     = "block";
					$('errordiv').innerHTML     = "Enter valid Credit Card Validation Code";
					$('cvv2no').focus();
					return false;

			}
		}else{
			if($('ccno').value.length != 16){
					$('errordiv').style.display     = "block";
					$('errordiv').innerHTML     = "Enter valid Credit Card Number";
					$('ccno').focus();
					return false;

			}
			if($('cvv2no').value.length != 3 ){
					$('errordiv').style.display     = "block";
					$('errordiv').innerHTML     = "Enter valid Credit Card Validation Code";
					$('cvv2no').focus();
					return false;
			}
		}
		if($('expyear').value == year){
			if($('expmonth').value < month){
				$('errordiv').style.display     = "block";
						$('errordiv').innerHTML     = "Enter Valid Expiry month and Year";
						$('expmonth').focus();
						return false;
			}
		}

	}

       $('sb_btn').setAttribute('disabled', true);

		$('course').action = base_url+'admin_register/courseadd';

		$('newimg').style.display ="block";
		$('newimg').innerHTML = '<img src='+base_url+'images/spinner.gif>';
		$('course').submit();



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
		$('errordiv').innerHTML     = "Select ship method";
		return false;
		}
		if (false == is_field_empty ("cardtype", 'Select Card Type',"errordiv")) {
		return false;
		} else {
		$('errordiv').style.display     = "none";
		}
		if (false == is_field_empty ("ccno", 'Enter Credit Card No',"errordiv")) {
		return false;
		}

		if($('cardtype').value == 'Amex' ){
		if($('ccno').value.length != 15){

				$('errordiv').style.display     = "block";
				$('errordiv').innerHTML     = "Enter valid Credit Card Number";
				$('ccno').focus();
				return false;
		}
		if($('cvv2no').value.length != 4 ){
				$('errordiv').style.display     = "block";
				$('errordiv').innerHTML     = "Enter valid Credit Card Validation Code";
				$('cvv2no').focus();
				return false;

		}
		}else{
		if($('ccno').value.length != 16){
				$('errordiv').style.display     = "block";
				$('errordiv').innerHTML     = "Enter valid Credit Card Number";
				$('ccno').focus();
				return false;

		}
		if($('cvv2no').value.length != 3 ){
				$('errordiv').style.display     = "block";
				$('errordiv').innerHTML     = "Enter valid Credit Card Validation Code";
				$('cvv2no').focus();
				return false;
		}
		}

		if(trim($('expyear').value) == year){

			if(trim($('expmonth').value) < month){
					$('errordiv').style.display     = "block";
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


		if (false == is_field_empty ("b_address", 'Enter Billing Address',"errordiv")) {
			return false;
		} else {
			$('errordiv').style.display     = "none";
		}

		if (false == is_field_empty ("b_state", 'Select Billing State',"errordiv")) {
			return false;
		} else {
			$('errordiv').style.display     = "none";
		}

		if (false == is_field_empty ("b_city", 'Enter Billing City',"errordiv")) {
			return false;
		} else {
			$('errordiv').style.display     = "none";
		}

		if (false == is_field_empty ("b_zipcode", 'Enter Billing Zipcode',"errordiv")) {
			return false;
		} else {
				if(checkzip($('b_zipcode')) == true){
				if((IsNumeric($('b_zipcode').value) == true)){
						$('errordiv').style.display     = "none";
						}
						else{

							$('errordiv').style.display     = "block";
							$('errordiv').innerHTML     = "Billing Zipcode must be 5 digits";
							$('b_zipcode').focus();
							return false;

							}
				$('errordiv').style.display     = "none";

			 }else{

				$('errordiv').style.display     = "block";
				$('errordiv').innerHTML     = "Billing Zipcode must be 5 digits";
				$('b_zipcode').focus();
				return false;
			 }

		}

		if (false == is_field_empty ("cardtype", 'Select Card Type',"errordiv")) {
		return false;
		} else {
		$('errordiv').style.display     = "none";
		}
		if (false == is_field_empty ("ccno", 'Enter Credit Card No',"errordiv")) {
		return false;
		}

		if($('cardtype').value == 'Amex' ){
		if($('ccno').value.length != 15){

				$('errordiv').style.display     = "block";
				$('errordiv').innerHTML     = "Enter valid Credit Card Number";
				$('ccno').focus();
				return false;
		}
		if($('cvv2no').value.length != 4 ){
				$('errordiv').style.display     = "block";
				$('errordiv').innerHTML     = "Enter valid Credit Card Validation Code";
				$('cvv2no').focus();
				return false;

		}
		}else{
		if($('ccno').value.length != 16){
				$('errordiv').style.display     = "block";
				$('errordiv').innerHTML     = "Enter valid Credit Card Number";
				$('ccno').focus();
				return false;

		}
		if($('cvv2no').value.length != 3 ){
				$('errordiv').style.display     = "block";
				$('errordiv').innerHTML     = "Enter valid Credit Card Validation Code";
				$('cvv2no').focus();
				return false;
		}
		}

		if(trim($('expyear').value) == year){

			if(trim($('expmonth').value) < month){
					$('errordiv').style.display     = "block";
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

		document.getElementById('ccno').setAttribute('maxLength', 15);
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

	function is_field_empty (txtfield, errmsg, errdiv)
	{
		if ("" == trim ($(txtfield).value))
		{
			$(errdiv).style.display   = "block";
			$(errdiv).innerHTML       = errmsg;
			$(txtfield).value         = '';
			$(txtfield).focus();
			return false;
		}
		else
		{
			$(errdiv).innerHTML       = "";
			$(errdiv).style.display   = "none";
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

		$$("input.subcheck").each(function (elem) { if(elem.checked) { $('price').value =  parseFloat($('price').value)+ parseFloat(( $("subprice" + elem.value).value ));	$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat(( $("courseweight" + elem.value).value));}
																																						  })
		$$("input.scheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) +  parseFloat(( $("courseprice" + elem.value).value));	$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat( ( $("courseweight" + elem.value).value));} })

		$$("input.bcheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));	$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));} })

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
		coursesum1=0;
		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";

		$$("input.scheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		} })
		$$("input.subcheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		} })
		$$("input.bcheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		} })
		var totalamnt= '$'+$('totalprice').value;
		if($('need_ship').value == 'yes'){
		 	gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;" >Ship Rate -</td>' + '<td class=gridtrlastsec width=100 style="padding-left:35px;"  ><div id=shipamount style="font-weight:bold; "  >'+$('shipprice').value+'</div></td></tr>';
		}else{
			totalamnt	=	coursesum1;
			$('totalprice').value=totalamnt;
		}

		 gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + '</td> <td class=admin_total_amt width=118  ><div id=totalamount>$'+totalamnt+'</div><input type="hidden" name="total_price" id="total_price" value='+$('totalprice').value+' /></td></tr></table>';
		gridtext =gridtext+"</table>";
		 if(a!=0){
			  //$('grid').className = 'gridborder';
			 $('grid').innerHTML   = gridtext;

			 }


	 }


	// show Mandatory course terms and condition
	function showterms(id){
		//alert(id);
		//alert(carr.length);
		// intiate variable
		/*for(i=5;i<carr.length;i++)*/


		var showdivid = 'showdiv'+id
		$(showdivid).style.display = "block";
		var coursediv = 'course' + id;
	//	var subcoursediv = 'subcourse' + id;
		//var coursebdiv = 'course_b' +id;
		var agreediv = 'agree' + id;
		var disagreediv = 'disagree' + id;

		if($(coursediv))
		$(coursediv).checked =false;

		if($(coursebdiv))
		$(coursebdiv).checked =false;

		//$(agreediv).checked =false;
		//$(disagreediv).checked =false;
		if($('sel_course_m').value > 0){
			$(agreediv).checked =true;
		}

		$('price').value =0;
		$('totalweight').value =0;
		$('totalweight').value = 0;
		$('totalweightb').value = 0;

		//add price and weight of checked element
		$$("input.subcheck").each(function (elem) { if(elem.checked) { $('price').value =  parseFloat($('price').value)+ parseFloat(( $("subprice" + elem.value).value ));	$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat(( $("courseweight" + elem.value).value));}
																																						  })
		$$("input.scheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) +  parseFloat(( $("courseprice" + elem.value).value));	$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat( ( $("courseweight" + elem.value).value));} })

		$$("input.bcheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));	$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));} })
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
		coursesum1=0;
		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";


			$$("input.scheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		}else{ gridtext = gridtext +''; } })
		$$("input.subcheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		} else{ gridtext = gridtext +''; }})
		$$("input.bcheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		}else{ gridtext = gridtext +''; } })
		var totalamnt= '$'+$('totalprice').value;
		if($('need_ship').checked){
			 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;">Ship Rate -</td>' + '<td class=gridtrlastsec width=100 style="padding-left:35px;"  ><div id=shipamount style="font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';
		}else{
			totalamnt	=	coursesum1;
			$('totalprice').value=totalamnt;
		}
		 gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + '<td class=admin_total_amt width=118  ><div id=totalamount>$'+totalamnt+'</div><input type="hidden" name="total_price" id="total_price" value='+$('totalprice').value+' /></td></tr></table>';
		gridtext =gridtext+"</table>";
		 if(a!=0){
			  //$('grid').className = 'gridborder';
			 $('grid').innerHTML   = gridtext;

			 }else{
				  $('grid').innerHTML   = '';

				 }





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
		$$("input.subcheck").each(function (elem) { if(elem.checked) { $('price').value =  parseFloat($('price').value)+ parseFloat(( $("subprice" + elem.value).value ));	$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat(( $("courseweight" + elem.value).value));}
																																						  })
		$$("input.scheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) +  parseFloat(( $("courseprice" + elem.value).value));	$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat( ( $("courseweight" + elem.value).value));} })

		$$("input.bcheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));	$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));} })

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


				$$("input.scheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		}else{ gridtext = gridtext +''; } })
		$$("input.subcheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		}else{ gridtext = gridtext +''; } })
		$$("input.bcheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		}else{ gridtext = gridtext +''; } })
		var totalamnt= '$'+$('totalprice').value;
		if($('need_ship').checked){
		 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;">Ship Rate -</td>' + '<td class=gridtrlastsec width=100  style="padding-left:35px;"><div id=shipamount style="font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';
		}else{
			totalamnt	=	coursesum1;
			$('totalprice').value=totalamnt;
		}

		 gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + '<td class=admin_total_amt width=118  ><div id=totalamount>$'+totalamnt+'</div><input type="hidden" name="total_price" id="total_price" value='+$('totalprice').value+' /></td></tr></table>';
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
		//alert(id);
		// intiate variable
		var showdivid = 'showdiv'+id
		$(showdivid).style.display = "block";
		var coursediv = 'course' + id;
		var subcoursediv = 'subcourse' + id;
		var coursebdiv = 'course_b' +id;
		var agreediv = 'agree' + id;
		var disagreediv = 'disagree' + id;
                
                if($('course_b_newpackage'))
                {
                   $('course_b_newpackage').checked = false;
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
		if($(coursediv))
		$(coursediv).checked =false;

		if($(coursebdiv))
		$(coursebdiv).checked =false;

		$(agreediv).checked =false;
		$(disagreediv).checked =false;
		if($('sel_course_b').value == id){
			$(agreediv).checked =true;
		}
			/*var radioLength			= index.length;
				for(var i = 0; i < radioLength; i++) {
					if(index[i].checked) {
					var indexid = i;
					}
                                        index[indexid].checked  = false;
				}*/



		$('price').value =0;
		$('totalweight').value =0;
		//$('totalweight').value = 0;
		$('totalweightb').value = 0;

		//add price and weight of checked element
		$$("input.subcheck").each(function (elem) { if(elem.checked) { $('price').value =  parseFloat($('price').value)+ parseFloat(( $("subprice" + elem.value).value ));	$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat(( $("courseweight" + elem.value).value));}
																																						  })
		$$("input.scheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) +  parseFloat(( $("courseprice" + elem.value).value));	$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat( ( $("courseweight" + elem.value).value));} })

		$$("input.bcheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));	$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));} })

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

		$$("input.scheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		} else{ gridtext = gridtext +''; }})
		$$("input.subcheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		}else{ gridtext = gridtext +''; } })
		$$("input.bcheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		} else{ gridtext = gridtext +''; }})
		var totalamnt= '$'+$('totalprice').value;
		if($('need_ship').checked){
		 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;">Ship Rate -</td>' + '<td class=gridtrlastsec width=100 style="padding-left:35px;"  ><div id=shipamount style="font-weight:bold; "  ><div id=shipamount>'+$('shipprice').value+'</div></td></tr>';
		}else{
			totalamnt	=	coursesum1;
			$('totalprice').value=totalamnt;
		}
		 gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + '<td class=admin_total_amt width=118  ><div id=totalamount>$'+totalamnt+'</div><input type="hidden" name="total_price" id="total_price" value='+$('totalprice').value+' /></td></tr></table>';
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
		var showdivid = 'showdiv'+id
		var coursediv = 'course' + id;
		var subcoursediv = 'subcourse';
		var coursebdiv = 'course_b' +id;
		var agreediv = 'agree' + id;
		var disagreediv = 'disagree' + id;
		$('sel_course_m').value = id;
		if($(coursediv))
		$(coursediv).checked =true;
		if($(subcoursediv)){
			//$('course0').disabled = true;

		}

		if($(coursebdiv))
		$(coursebdiv).checked =true;

		$('price').value =0;
		$('totalweight').value = 0;
		$('totalweightb').value = 0;
		var a =0;
		var s =0;
		 coursesum1=0;

		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td> <td class='firstrow' width='118'>Amount($)</td></tr>";

		//add price and weight of checked element
		//add price and weight of checked element
		/*$$("input.subcheck").each(function (elem) { if(elem.checked) { $('price').value =  parseFloat($('price').value)+ parseFloat(( $("subprice" + elem.value).value ));	$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat(( $("courseweight" + elem.value).value));}
																																				  })*/
		$$("input.scheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) +  parseFloat(( $("courseprice" + elem.value).value));	$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat( ( $("courseweight" + elem.value).value));} })

		$$("input.bcheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));	$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));} })

		//$('cartcourseprice').innerHTML   = $('price').value;


		$('shipprice').value =0;
		$('totalprice').value =0;
		/*if($('shipprice').value)
		$('cartshiprate').innerHTML      = $('shipprice').value;
		if($('totalprice').value)
		$('carttotalprice').innerHTML      = $('totalprice').value;*/

		$$("input.scheck").each(function (elem) { if(elem.checked) {
				num	=carr["'"+elem.value+"'"][1];

				coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' +' <td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';


		}else{ gridtext = gridtext +''; } })
		/*$$("input.subcheck").each(function (elem) { if(elem.checked) {num	=carr[elem.value][1];	coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td >'+carr[elem.value][0]+'</td>' + '<td>'+carr[elem.value][1]+'</td></tr>';


		}else{ gridtext = gridtext +''; } })*/
		$$("input.bcheck").each(function (elem) { if(elem.checked) { num	=carr["'"+elem.value+"'"][1];	coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		}else{ gridtext = gridtext +''; } })
		var totalamnt= $('totalprice').value;

		if($('need_ship').value =="yes"){
		 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;" >Ship Rate -</td>' + '<td class=gridtrlastsec width=100 style="padding-left:35px;"  ><div id=shipamount style="font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';
		}
                totalamnt= coursesum1;
		$('totalprice').value=totalamnt;
		gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470>Total Price -</td>' + ' <td class=admin_total_amt width=118  ><div id=totalamount>$'+totalamnt+'</div><input type="hidden" name="total_price" id="total_price" value='+$('totalprice').value+' /></td></tr></table>';
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
		var coursediv = 'course' + id;
		var subcoursediv = 'subcourse';
		var coursebdiv = 'course_b' +id;
		var agreediv = 'agree' + id;
		var disagreediv = 'disagree' + id;
		$(showdivid).style.display = "none";
		$('sel_course_m').value = 0;
		if($(coursediv))
		$(coursediv).checked =false;
		/*if($(subcoursediv))
		$(subcoursediv).checked =false;

		if($(coursebdiv))
		$(coursebdiv).checked =false;*/


		$('price').value =0;
		$('totalweight').value =0;

		$('totalweightb').value = 0;

		//add price and weight of checked element
		//$$("input.subcheck").each(function (elem) { if(elem.checked) { $('price').value =  parseFloat($('price').value)+ parseFloat(( $("subprice" + elem.value).value ));	$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat(( $("courseweight" + elem.value).value));}
	//																																					  })
		$$("input.scheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) +  parseFloat(( $("courseprice" + elem.value).value));	$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat( ( $("courseweight" + elem.value).value));} })

		$$("input.bcheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));	$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));} })

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
		coursesum1=0;
		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";

			$$("input.scheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		} else{ gridtext = gridtext +''; }})
		/*$$("input.subcheck").each(function (elem) { if(elem.checked) {num	=carr[elem.value][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
			 a =1;
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td >'+carr[elem.value][0]+'</td>' + '<td>'+carr[elem.value][1]+'</td></tr>';


		}else{ gridtext = gridtext +''; } })*/
		$$("input.bcheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		}else{ gridtext = gridtext +''; } })
		var totalamnt= $('totalprice').value;
		if($('need_ship').value=="yes"){
		 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;">Ship Rate -</td>' + '<td class=gridtrlastsec width=100 style="padding-left:35px;"  ><div id=shipamount style="font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';
		}
			totalamnt=coursesum1;
		$('totalprice').value=totalamnt;
		gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + '<td class=admin_total_amt width=118  ><div id=totalamount>$'+totalamnt+'</div><input type="hidden" name="total_price" id="total_price" value='+$('totalprice').value+' /></td></tr></table>';
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
		coursesum1=0;
		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";


		//add price and weight of checked element
		$$("input.subcheck").each(function (elem) { if(elem.checked) { $('price').value =  parseFloat($('price').value)+ parseFloat(( $("subprice" + elem.value).value ));	$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat(( $("courseweight" + elem.value).value));}
																																						  })
		$$("input.scheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) +  parseFloat(( $("courseprice" + elem.value).value));	$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat( ( $("courseweight" + elem.value).value));} })

		$$("input.bcheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));	$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));} })

		//$('cartcourseprice').innerHTML   = $('price').value;
		$('shipprice').value =0;
		$('totalprice').value =0;
		/*if($('shipprice').value)
		$('cartshiprate').innerHTML      = $('shipprice').value;
		if($('totalprice').value)
		$('carttotalprice').innerHTML      = $('totalprice').value;*/

		$$("input.scheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		} else{ gridtext = gridtext +''; }})
		$$("input.subcheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		}else{ gridtext = gridtext +''; } })
		$$("input.bcheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		}else{ gridtext = gridtext +''; }})
		var totalamnt= '$'+$('totalprice').value;
		if($('need_ship').value == "yes"){
		 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;">Ship Rate -</td>' + '<td class=gridtrlastsec width=100  style="padding-left:35px;"  ><div id=shipamount style="font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';
		}else{
			var totalamnt=coursesum1;
		}
		gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + '<td class=admin_total_amt width=118  ><div id=totalamount>$'+totalamnt+'</div><input type="hidden" name="total_price" id="total_price" value='+$('totalprice').value+' /></td></tr></table>';
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
		$$("input.subcheck").each(function (elem) { if(elem.checked) { $('price').value =  parseFloat($('price').value)+ parseFloat(( $("subprice" + elem.value).value ));	$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat(( $("courseweight" + elem.value).value));}
																																						  })
		$$("input.scheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) +  parseFloat(( $("courseprice" + elem.value).value));	$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat( ( $("courseweight" + elem.value).value));} })

		$$("input.bcheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));	$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));} })

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
		coursesum1=0;
		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";

				$$("input.scheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		}else{ gridtext = gridtext +''; } })
		$$("input.subcheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		} else{ gridtext = gridtext +''; }})
		$$("input.bcheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		}else{ gridtext = gridtext +''; } })
		var totalamnt= '$'+$('totalprice').value;
		if($('need_ship').checked){
		 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;"  >Ship Rate -</td>' + '<td class=gridtrlastsec width=100 style="padding-left:35px;"  ><div id=shipamount style="font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';
		}else{
			totalamnt=coursesum1;
		}
		 gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + '<td class=admin_total_amt width=118  ><div id=totalamount>$'+totalamnt+'</div><input type="hidden" name="total_price" id="total_price" value='+$('totalprice').value+' /></td></tr></table>';
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


		var showdivid = 'showdiv'+id
		var coursediv = 'course' + id;
		var subcoursediv = 'subcourse';
		var coursebdiv = 'course_b' +id;
		var agreediv = 'agree' + id;
		var disagreediv = 'disagree' + id;
		$('sel_course_b').value = id;
		if($(coursediv))
		$(coursediv).checked =true;
		if($(subcoursediv)){
			//$('course0').disabled = true;

		}

		if($(coursebdiv))
		$(coursebdiv).checked =true;
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
		coursesum1=0;
		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";

		//add price and weight of checked element
		$$("input.subcheck").each(function (elem) { if(elem.checked) { $('price').value =  parseFloat($('price').value)+ parseFloat(( $("subprice" + elem.value).value ));	$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat(( $("courseweight" + elem.value).value));}
																																						  })
		$$("input.scheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) +  parseFloat(( $("courseprice" + elem.value).value));	$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat( ( $("courseweight" + elem.value).value));} })

		$$("input.bcheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));	$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));} })

		//$('cartcourseprice').innerHTML   = $('price').value;
		$('shipprice').value =0;
		$('totalprice').value =0;
		/*if($('shipprice').value)
		$('cartshiprate').innerHTML      = $('shipprice').value;
		if($('totalprice').value)
		$('carttotalprice').innerHTML      = $('totalprice').value;*/


		$$("input.scheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		}else{ gridtext = gridtext +''; } })

		$$("input.subcheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		}else{ gridtext = gridtext +''; } })
		$$("input.bcheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		} else{ gridtext = gridtext +''; }})
		var totalamnt= $('totalprice').value;
		if($('need_ship').value=='yes'){
		 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;" >Ship Rate -</td>' + '<td class=gridtrlastsec width=100  style="padding-left:35px;"  ><div id=shipamount style="font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';

		}
			totalamnt=coursesum1;
		$('totalprice').value=totalamnt;
		gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + '<td class=admin_total_amt width=118  ><div id=totalamount>$'+totalamnt+'</div><input type="hidden" name="total_price" id="total_price" value='+$('totalprice').value+' /></td></tr></table>';

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
		$('sel_course_b').value = 0;
		if($(coursediv))
		$(coursediv).checked =false;
		if($(subcoursediv)){
			/*$('course0').checked = false;
			$('course0').disabled = false;*/
		}
		if($(coursebdiv))
		$(coursebdiv).checked =false;

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
		$$("input.subcheck").each(function (elem) { if(elem.checked) { $('price').value =  parseFloat($('price').value)+ parseFloat(( $("subprice" + elem.value).value ));	$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat(( $("courseweight" + elem.value).value));}
																																						  })
		$$("input.scheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) +  parseFloat(( $("courseprice" + elem.value).value));	$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat( ( $("courseweight" + elem.value).value));} })

		$$("input.bcheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));	$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));} })

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
		coursesum1=0;
		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";
		$$("input.scheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		}else{ gridtext = gridtext +''; } })
		$$("input.subcheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		} else{ gridtext = gridtext +''; }})
		$$("input.bcheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		} else{ gridtext = gridtext +''; }})
		var totalamnt= $('totalprice').value;
		if($('need_ship').value=="yes"){
		 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;">Ship Rate -</td>' + '<td class=gridtrlastsec width=100 style="padding-left:35px;"  ><div id=shipamount style="font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';
		}
			totalamnt=coursesum1;
			$('totalprice').value=totalamnt;

		gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + '<td class=admin_total_amt width=118  ><div id=totalamount>$'+totalamnt+'</div><input type="hidden" name="total_price" id="total_price" value='+$('totalprice').value+' /></td></tr></table>';
		gridtext =gridtext+"</table>";
		 if(a!=0){
			  //$('grid').className = 'gridborder';
			 $('grid').innerHTML   = gridtext;

			 }else{
				  $('grid').innerHTML   = '';

				 }




	}


function show_broker_packagecheck(id,amount){
             // intiate variable
        $('sel_package').value = amount;


		if(id !=0 && id !=''){
			var showdivid = 'showdiv'+id
			var coursediv = 'course' + id;
			var coursebdiv = 'course_b' +id;

			var agreediv = 'agree' + id;
			var disagreediv = 'disagree' + id;

			if($(coursediv))
			$(coursediv).checked =true;

			if($(coursebdiv))
			$(coursebdiv).checked =true;



			$('price').value =amount;
			$('totalweight').value =0;

			var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";
			//add price and weight of checked element
			//add price and weight of checked element
			//$$("input.pcheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));	$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));} })
			gridtext =gridtext+ '<tr class=gridrowsec ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">Package</td>' +' <td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+amount+'</td></tr>';

			$('shipprice').value =0;
			$('totalprice').value =0;
			var coursesum1 = amount;
			var totalamnt= $('totalprice').value;

			 //gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;" >Ship Rate -</td>' + '<td class=gridtrlastsec width=100 style="padding-left:35px;"  ><div id=shipamount style="font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';
                        if($('need_ship').value=='yes'){
			 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;"  >Ship Rate -</td>' + '<td class=gridtrlastsec width=100 style="padding-left:35px;"  ><div id=shipamount style="font-weight:bold;">'+$('shipprice').value+'</div></td></tr>';
			}else totalamnt= coursesum1;

			gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + ' <td class=admin_total_amt width=118  ><div id=totalamount>$'+totalamnt+'</div><input type="hidden" name="total_price" id="total_price" value='+$('totalprice').value+' /></td></tr></table>';
			gridtext =gridtext+"</table>";
			$('course_b').checked=1;

			$('grid').innerHTML   = gridtext;
			$(showdivid).style.display = "none";
		}else{
                        var showdivid = 'showdiv';
			var coursediv = 'course';
			var coursebdiv = 'course_b';

			var agreediv = 'agree';
			var disagreediv = 'disagree';

			if($(coursediv))
			$(coursediv).checked =true;

			if($(coursebdiv))
			$(coursebdiv).checked =true;



			$('price').value =amount;
			$('totalweight').value =0;

			var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";
			//add price and weight of checked element
			//add price and weight of checked element
			//$$("input.pcheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));	$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));} })
			gridtext =gridtext+ '<tr class=gridrowsec ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">Package</td>' +' <td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+amount+'</td></tr>';

			$('shipprice').value =0;
			$('totalprice').value =0;
			var coursesum1 = amount;
			var totalamnt= $('totalprice').value;

			 //gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;" >Ship Rate -</td>' + '<td class=gridtrlastsec width=100 style="padding-left:35px;"  ><div id=shipamount style="font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';
                        if($('need_ship').value=='yes'){
			 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;"  >Ship Rate -</td>' + '<td class=gridtrlastsec width=100 style="padding-left:35px;"  ><div id=shipamount style="font-weight:bold;">'+$('shipprice').value+'</div></td></tr>';
			} totalamnt= coursesum1;
                        $('totalprice').value=totalamnt;
			gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + ' <td class=admin_total_amt width=118  ><div id=totalamount>$'+totalamnt+'</div><input type="hidden" name="total_price" id="total_price" value='+$('totalprice').value+' /></td></tr></table>';
			gridtext =gridtext+"</table>";
			$('course_b').checked=1;

			$('grid').innerHTML   = gridtext;
			$(showdivid).style.display = "none";
                }
	}


	// uncheck packages
	function show_broker_packageuncheck(id){
		$('sel_package').value = '';
		// intiate variable
		var showdivid = 'showdiv'+id
		var coursediv = 'course' + id;
		var coursebdiv = 'course_b' +id;
		var coursepdiv = 'course_p' +id;
		var agreediv = 'agree' + id;
		var disagreediv = 'disagree' + id;
		$(showdivid).style.display = "none";

		if($(coursediv))
		$(coursediv).checked =false;


		$('price').value =0;
		$('totalweightb').value = 0;
		$('totalprice').value = 0;
		$('course_b').checked=0;
		$('grid').innerHTML   = '';
	}



// select rate
	function selectrate(val){

                     //unselect all
                         $$(".shiprate_radios").each(function(elmt) { elmt.src = base_url+'/images/radio_nonselection.png'; });

		 	if($('shipid').value>0)  $('ship'+$('shipid').value).src	=	base_url+'/images/radio_nonselection.png';
		        $('ship'+val).src	=	base_url+'/images/radio_select.png';
		        $('shipid').value=val;

			$('shipprice').value=0;
			if($('price').value !=0){
				var shiprate= 'shiprate'+val;


				$('shipprice').value=$(shiprate).value;

                                //to take the original total amount to db by removing the unwanted hidden element name totalprice
                               // $('totalprice').remove();



				$('totalprice').value=Math.round((parseFloat($(shiprate).value) + parseFloat($('price').value) )*100)/100;



                                $('total_price').value = $('totalprice').value;
					//$('carttotal').style.display   = "block";
					//$('cartcourseprice').innerHTML   = $('price').value;
					if($('shipprice').value)
					//$('cartshiprate').innerHTML      = $('shipprice').value;
					$('shipamount').innerHTML      = $('shipprice').value;


					if($('totalprice').value)
					//$('carttotalprice').innerHTML = $('totalprice').value;
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
		if(is_field_empty("old_password",'Please enter Current Password ',"errordisplay")==false){return false;}
		if(is_field_empty("new_password",'Please enter New Password ',"errordisplay")==false){return false;}
		if(is_field_empty("confirm_password",'Please Retype your Password ',"errordisplay")==false){return false;}
		var password		=	$('new_password').value;
		var confirmpassword	=	$('confirm_password').value;
		var oldpassword		=	$('old_password').value;
		if(password.length >= 6){
			 	if(is_valid_password (password) == true){
					 $('errordisplay').style.display     = "none";
				}else{
						$('errordisplay').style.display     = "block";
						$('errordisplay').innerHTML     = "Password should be the combination of Alphanumeric";
						$('new_password').focus();
						return false;
					}
				 $('errordisplay').style.display     = "none";
			 }else{

				$('errordisplay').style.display     = "block";
				$('errordisplay').innerHTML     = "Password should be minimum 6 characters";
				$('new_password').focus();
				return false;
			}
		$('errordisplay').style.display     = "none";
		if(password!=confirmpassword){
			$('errordisplay').style.display     = "block";
			$('errordisplay').innerHTML = 'Password and Confirm Password do not match';
			return false;
		}
		if(password == oldpassword){
			$('errordisplay').style.display     = "block";
			$('errordisplay').innerHTML = 'New Password should not be same as Current Password';
			return false;
		}
		$('change_password_form_adhi').action = base_url+'user/change_password/';
		$("change_password_form_adhi").submit();
	}

	function show_ship(){

		if($('need_ship_yes').checked ){
			$('show_ship_div_addr').style.display="block";
		/*	$('show_ship_div_select').style.display="block";*/
			$('billing_same').style.display	="block";
		}else{
			$('billing_same').style.display	="none";
			$('show_ship_div_addr').style.display="none";
		/*	$('show_ship_div_select').style.display="none";*/

		}
	}
	function show_payment(){

		if($('need_payment_yes').checked){
			$('show_payment_div_addr').style.display	="block";
			/*$('show_payment_div_select').style.display	="block";*/
		}else{
			$('show_payment_div_addr').style.display	="none";
			/*$('show_payment_div_select').style.display	="none";*/

		}
	}
	function load_courses(){

		var jsonArrassy = $('hidJson').value;
		carr = eval('('+jsonArrassy+')');

		for(var i=0; i<carr.length; i++){
			//alert(carr[i]['id']);
			carr["'"+carr[i]['course_id']+"'"] 	= new Array();
			carr["'"+carr[i]['course_id']+"'"][0]	= carr[i]['course_name'];
			carr["'"+carr[i]['course_id']+"'"][1]	= carr[i]['amount'];
		}
	}
	function show_courses(){

		var coursetype = Form.getInputs('course','radio','coursetype').find(function(radio) { return radio.checked; }).value;
		var paymenttype	=  Form.getInputs('course','radio','paymenttype').find(function(radio) { return radio.checked; }).value;
		var licensetype = $('hidlicensetype').value;
		$('sel_course_b').value = 0;
		$('sel_course_m').value = 0;
		var usertype;
		if(coursetype == 'Live' && paymenttype == 'Package' && licensetype == 'B'){
			usertype = 1;
		}else if(coursetype == 'Live' && paymenttype == 'Cart' && licensetype == 'B'){
			usertype = 2;
		}else if(coursetype == 'Online' && paymenttype == 'Package' && licensetype == 'B'){
			usertype = 3;
		}else if(coursetype == 'Online' && paymenttype == 'Cart' && licensetype == 'B'){
			usertype = 4;
		}else if(coursetype == 'Live' && paymenttype == 'Package' && licensetype == 'S'){
			usertype = 5;
		}else if(coursetype == 'Live' && paymenttype == 'Cart' && licensetype == 'S'){
			usertype = 6;
		}else if(coursetype == 'Online' && paymenttype == 'Package' && licensetype == 'S'){
			usertype = 7;
		}else if(coursetype == 'Online' && paymenttype == 'Cart' && licensetype == 'S'){
			usertype = 8;
		}
		$('hidusertype').value = usertype;


		var url             =   base_url + "register_ajax/admin_get_courses";


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

	    	if($('need_ship').value =='yes'){
				$('show_ship_div_select').style.display="block";
			}else{
				$('show_ship_div_select').style.display="none";
			}
	    	if($('need_payment').value =='yes'){
				$('show_payment_div_select').style.display="block";
			}else{
				$('show_payment_div_select').style.display="none";
			}
                        load_courses();


	    }
	    function disp_error() {
			alert("Ajax request failed");
		}
	}





	function disp_error() {
		alert("Ajax request failed");
	}





	function show_radio_package_check_opt(id,index){
		// intiate variable
		var showdivid = 'showdiv'+id
		$(showdivid).style.display = "block";
                
                var coursediv = 'course' + id;
		var coursebdiv = 'course_b' +id;
		var agreediv = 'agree' + id;
		var disagreediv = 'disagree' + id;

		if($(coursediv))
		$(coursediv).checked =false;

		if($(coursebdiv))
		$(coursebdiv).checked =false;

		$(agreediv).checked =false;
		$(disagreediv).checked =false;
		$('course_b').checked=0;

		$('price').value =0;
		$('totalweight').value =0;
		$('totalweightb').value = 0;
                
                var showdivid_new = 'showdiv_newpackage'+id
		$(showdivid_new).style.display = "none";
	}
        
        function show_radio_package_check_opt_newpackage(id,index){

		// intiate variable
		var showdivid = 'showdiv_newpackage'+id
		$(showdivid).style.display = "block";
                             
		var coursediv = 'course_newpackage' + id;
		var coursebdiv = 'course_b_newpackage' +id;
		var agreediv = 'agree_newpackage' + id;
		var disagreediv = 'disagree_newpackage' + id;
                var sel = 'selagree_newpackage' + id;
		                
		if($(coursediv))
		$(coursediv).checked =false;

		if($(coursebdiv))
		$(coursebdiv).checked =false;


		$(agreediv).checked =false;
		$(disagreediv).checked =false;
		$('course_b_newpackage').checked=0;
	
		$('price').value =0;
		$('totalweight').value =0;
		$('totalweightb').value = 0;
                
                var showdividold = 'showdiv'+id
		$(showdividold).style.display = "none";
                
	}
        
	function showpackagecheck(id,amount){
		//alert(amount);
		// intiate variable
		if(id ==0){ if($('hidcrsid').value>0)
                        $('course_b'+$('hidcrsid').value).checked ==false;
			var showdivid = 'showdiv'+id
			var coursediv = 'course' + id;
			var coursebdiv = 'course_b' +id;
			var agreediv = 'agree' + id;
			var disagreediv = 'disagree' + id;

			if($(coursediv))
			$(coursediv).checked =true;

			if($(coursebdiv))
			$(coursebdiv).checked =true;
                        /*if($('new_package'))
                        {
                              if($('new_package').value == 1)
                              {
                                    $('new_package').value = 0;

                              }  
                        } */   
                           
                    
			$('price').value =amount;
                        $('course_b_newpackage').checked = false; 
			if($('course_b').checked ==true && $('course_b'+id).checked ==true)
			$('totalweight').value =  parseFloat($('weight').value) +  parseFloat($("courseweight_b"+id).value)
                        else $('totalweight').value =  parseFloat($('weight').value)
                        $('hidwt').value =parseFloat($("totalweight").value);

			var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td> <td class='firstrow' width='118'>Amount($)</td></tr>";
			//add price and weight of checked element
			//add price and weight of checked element

			gridtext =gridtext+ '<tr class=gridrowsec ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">Package</td>' +' <td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+amount+'</td></tr>';

			$('shipprice').value =0;
			$('totalprice').value =0;
			var coursesum1 = amount;
			var totalamnt= $('totalprice').value;
			if($('need_ship').value=='yes'){
			 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;"  >Ship Rate -</td>' + '<td class=gridtrlastsec width=100 style="padding-left:35px;"  ><div id=shipamount style="font-weight:bold;">'+$('shipprice').value+'</div></td></tr>';
			}else totalamnt= coursesum1;

			gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + ' <td class=admin_total_amt width=118  ><div id=totalamount>$'+amount+'</div><input type="hidden" name="total_price" id="total_price" value='+$('totalprice').value+' /></td></tr></table>';
			gridtext =gridtext+"</table>";
			$('course_b').checked=1;
			  $('totalprice').value =totalamnt;
			$('grid').innerHTML   = gridtext;
			$(showdivid).style.display = "none";
                        $('new_package').value = 0;
		}
	}
        
        function showpackagecheck_newpackage(id,amount){
		//alert(amount);
		// intiate variable
                
		if(id ==0){ if($('hidcrsid').value>0)
                        $('course_b'+$('hidcrsid').value).checked =false;
			var showdivid = 'showdiv_newpackage'+id
			var coursediv = 'course_newpackage' + id;
			var coursebdiv = 'course_b_newpackage' +id;
			var agreediv = 'agree_newpackage' + id;
			var disagreediv = 'disagree_newpackage' + id;

			if($(coursediv))
			$(coursediv).checked =true;

			if($(coursebdiv))
			$(coursebdiv).checked =true;

			$('price').value =amount;
                        $('course_b').checked = false; 
			if($('course_b_newpackage').checked ==true && $('course_b_newpackage'+id).checked ==true)
			$('totalweight').value =  parseFloat($('weight_newpackage').value) +  parseFloat($("courseweight_b"+id).value)
                        else $('totalweight').value =  parseFloat($('weight').value)
                        $('hidwt').value =parseFloat($("totalweight").value);

			var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td> <td class='firstrow' width='118'>Amount($)</td></tr>";
			//add price and weight of checked element
			//add price and weight of checked element

			gridtext =gridtext+ '<tr class=gridrowsec ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">Package</td>' +' <td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+amount+'</td></tr>';

			$('shipprice').value =0;
			$('totalprice').value =0;
			var coursesum1 = amount;
			var totalamnt= $('totalprice').value;
			if($('need_ship').value=='yes'){
			 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;"  >Ship Rate -</td>' + '<td class=gridtrlastsec width=100 style="padding-left:35px;"  ><div id=shipamount style="font-weight:bold;">'+$('shipprice').value+'</div></td></tr>';
			}else totalamnt= coursesum1;

			gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + ' <td class=admin_total_amt width=118  ><div id=totalamount>$'+amount+'</div><input type="hidden" name="total_price" id="total_price" value='+$('totalprice').value+' /></td></tr></table>';
			gridtext =gridtext+"</table>";
			$('course_b_newpackage').checked=1;
			  $('totalprice').value =totalamnt;
			$('grid').innerHTML   = gridtext;
			$(showdivid).style.display = "none";
                        $('new_package').value =1;
                        $('sel_course_b').value = 0;
                        $('sel_course_m').value = 0;
		}
	}

	// uncheck packages
	function showpackageuncheck(id){
		// intiate variable
		var showdivid = 'showdiv'+id
		var coursediv = 'course' + id;
		var coursebdiv = 'course_b' +id;
		var agreediv = 'agree' + id;
		var disagreediv = 'disagree' + id;
		$(showdivid).style.display = "none";
		$('sel_course_b').value = 0;
		if($(coursediv))
		$(coursediv).checked =false;

		$('price').value =0;
		$('totalweightb').value = 0;
		$('totalprice').value = 0;
		$('course_b').checked=0;
		$('grid').innerHTML   = '';
	}
        
        
	// uncheck packages
	function showpackageuncheck_newpackage(id){
		// intiate variable
		var showdivid = 'showdiv_newpackage'+id
		var coursediv = 'course_newpackage' + id;
		var coursebdiv = 'course_b_newpackage' +id;
		var agreediv = 'agree_newpackage' + id;
		var disagreediv = 'disagree_newpackage' + id;
		$(showdivid).style.display = "none";
		$('sel_course_b_newpackage').value = 0;
		if($(coursediv))
		$(coursediv).checked =false;

		$('price').value =0;
		$('totalweightb').value = 0;
		$('totalprice').value = 0;
		$('course_b_newpackage').checked=0;
		$('grid').innerHTML   = '';
	}
        function showpackage_opt_check(id,index){

			var showdivid = 'showdiv'+id
			var coursediv = 'course' + id;
			var coursebdiv = 'course_b' +id;
			var agreediv = 'agree' + id;
			var disagreediv = 'disagree' + id;
            var indexid = 'disagree' + id;

            $('sel_course_b').value = id;
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
                        
			if($(coursebdiv)) {
                            $(coursebdiv).checked =true;
                        }
                        if($('course_b').checked ==true && $('course_b'+id).checked ==true)
			$('totalweight').value =  parseFloat($('weight').value) +  parseFloat($("courseweight_b"+id).value)
                    else
                        $('totalweight').value =  parseFloat($("courseweight_b"+id).value);
                        $('hidwt').value =parseFloat($("totalweight").value);

			$('course_b'+id).checked=1;
                        //if($('hidcrsid').value >0)
                       // $('course_b'+$('hidcrsid').value).checked =false;
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
			$('sel_course_b').value = 0;
                        /* var radioLength			= index.length;
				for(var i = 0; i < radioLength; i++) {
					if(index[i].value == id) {
					var indexid = i;
                                        if(index[indexid].checked  = true) sel=i;
                                        index[indexid].checked  = false;
					}
				}*/


			$('totalweight').value =  parseFloat($('hidwt').value) -  parseFloat($("courseweight_b"+id).value)
                        $('hidwt').value =parseFloat($("totalweight").value);

			$('course_b'+id).checked=0;
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
		$$("input.subcheck").each(function (elem) { if(elem.checked) { $('price').value =  parseFloat($('price').value)+ parseFloat(( $("subprice" + elem.value).value ));	$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat(( $("courseweight" + elem.value).value));}
																																						  })
		$$("input.scheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) +  parseFloat(( $("courseprice" + elem.value).value));	$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat( ( $("courseweight" + elem.value).value));} })

		$$("input.bcheck").each(function (elem) { if(elem.checked) { $('price').value = parseFloat($('price').value) + parseFloat(( $("courseprice" + elem.value).value));	$('totalweightb').value =  parseFloat($('totalweightb').value) +   parseFloat(( $("courseweight_b" + elem.value).value));} })

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

		$$("input.scheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		} else{ gridtext = gridtext +''; }})
		$$("input.subcheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		}else{ gridtext = gridtext +''; } })
		$$("input.bcheck").each(function (elem) { if(elem.checked) {num	=carr["'"+elem.value+"'"][1];		coursesum1	=	parseFloat(num)+parseFloat(coursesum1);
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


		} else{ gridtext = gridtext +''; }})
		var totalamnt= '$'+$('totalprice').value;
		if($('need_ship').checked){
		 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;" >Ship Rate -</td>' + '<td class=gridtrlastsec width=100  style="padding-left:35px;"  ><div id=shipamount style="font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';
		}else{
			totalamnt	=	coursesum1;
			$('totalprice').value=totalamnt;
		}
		 gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + '<td class=admin_total_amt width=118  ><div id=totalamount>$'+totalamnt+'</div><input type="hidden" name="total_price" id="total_price" value='+$('totalprice').value+' /></td></tr></table>';
		gridtext =gridtext+"</table>";
		 if(a!=0){
			  //$('grid').className = 'gridborder';
			 $('grid').innerHTML   = gridtext;

			 }else{
				  $('grid').innerHTML   = '';

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
          onSuccess: function(response) {
              var json = response.responseText.evalJSON();
              console.log(json.data);
              if(json.status = 200){
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
function change_hear_about_us(howhear){
    if( howhear == 'Search engine'){
            $("hh1_txt").show();
    }else{
            $("hh1_txt").hide();
    }
    if( howhear == 'Referral from a real estate office'){
            $("hh2_txt").show();
    }else{
            $("hh2_txt").hide();
    }
}
function gotolist(a){
    a?$("frmadhischool").action=base_url+"admin_register/list_user_details/"+a:$("frmadhischool").action=base_url+"admin_register/list_user_details/";
    $("frmadhischool").submit()
}
function gotoorder(a,b){
    b?$("frmadhischool").action=base_url+"admin_register/view_order_details/"+a+"/"+b:$("frmadhischool").action=base_url+"admin_register/view_order_details/"+a;
    $("frmadhischool").submit()
}
