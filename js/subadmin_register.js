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
        if (false == is_field_empty ("username", 'Enter User Name',"errordiv")) {
	    $('username').value ='';
		$('username').value ='';
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

	if (false == is_field_empty ("address", 'Enter Address',"errordiv")) {
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


	$('register_sub').value =1
	$('myform').action = base_url+'admin_sub/add';
	$('myform').submit();
}

function checksubadmin_update(subadmin_id){
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
        if (false == is_field_empty ("username", 'Enter User Name',"errordiv")) {
	    $('username').value ='';
		$('username').value ='';
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
	
	if (false == is_field_empty ("address", 'Enter Address',"errordiv")) {
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


	$('register_sub').value =1;
	$('myform').action = base_url+'admin_sub/update/'+subadmin_id;
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

function delete_subadmin(id)
{
    if(confirm("Are you sure to delete this Sub-Admin?")) 
    {
        window.location.href= base_url+"admin_sub/delete/"+id;
        return false;
    }
    else
    {
        return false;
    }
}

function reset_password(subadmin)
{
    
    if (false == is_field_empty ("r_password", 'Enter Password',"errordiv")) 
    {
        $('r_password').value ='';
        return false;
    } 
    else 
    {
         if($('r_password').value.length >= 6)
         {
            if(is_valid_password ($('r_password').value) == true)
            {
                $('errordiv').style.display     = "none";
            }
            else
            {
                $('errordiv').style.display     = "block";
                $('errordiv').innerHTML     = "Password should be the combination of Alphanumeric";
                $('r_password').focus();
                $('r_password').value ='';
                return false;
            }
                $('errordiv').style.display     = "none";
          }
          else
          {

                $('errordiv').style.display     = "block";
                $('errordiv').innerHTML     = "Password should be minimum 6 characters";
                $('r_password').focus();
                $('r_password').value ='';
                return false;
          }
        $('errordiv').style.display     = "none";

    }
    if(confirm("Are you sure to reset password?"))
    {
        $('resetted').value =1
        $('frmadhischool').action = base_url+'admin_sub/reset_password/'+subadmin;
        $('frmadhischool').submit();  
    }
    else
    {
        return false;
    }
}

function gotolist(a){a?$("frmadhischool").action=base_url+"index.php/admin_sub/list_subadmins/"+a:$("frmadhischool").action=base_url+"index.php/admin_sub/list_subadmins/";$("frmadhischool").submit()} 

function gotolistnew(a){a?$("myform").action=base_url+"index.php/admin_sub/list_subadmins/"+a:$("myform").action=base_url+"index.php/admin_sub/list_subadmins/";$("myform").submit()} 