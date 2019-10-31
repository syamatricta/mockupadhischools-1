;$.noConflict();

function DropDown(el) {
  	this.dd = el;
	this.placeholder = this.dd.children('span');
	this.opts = this.dd.find('ul.dropdown > li');
	this.val = '';
	this.index = -1;
	this.initEvents();
}

DropDown.prototype = {
	initEvents : function() {
		var obj = this;

		obj.dd.on('click', function(event){
			jQuery(this).toggleClass('active');
			return false;
		});

		obj.opts.on('click',function(){
			var opt = jQuery(this);
			obj.val = opt.text();
			obj.index = opt.index();
			obj.placeholder.text(obj.val);
		});
	},
	getValue : function() {
		return this.val;
	},
	getIndex : function() {
		return this.index;
	}
}


jQuery(function() {
		
	var dd = new DropDown( jQuery('#dd') );
	var dd = new DropDown( jQuery('#dd1') );
	var dd = new DropDown( jQuery('#dd2') );
	jQuery(document).click(function() {
		// all dropdowns
		jQuery('.wrapper-dropdown-5').removeClass('active');
 	});
	
});

 
	var carr = new Array();
	function hide_div(id){
	    if (Object.isElement($(id))){ $(id).style.display ='none'; }  
	}

	function checkuser(){
		var error =''
	
 		if (false == is_field_empty ("firstname", 'Enter First Name',"errordiv")) {
			$('psword').value =''; 
			$('psword1').value =''; 
			gotoTop();
		    return false;
		} else {
			$('errordiv').style.display     = "none";
		}
 
		if (false == is_field_empty ("lastname", 'Enter Last Name',"errordiv")) {
		    $('psword').value =''; 
			$('psword1').value =''; 
			gotoTop();
		   return false;
		} else {
			$('errordiv').style.display     = "none";
		}
		
		if (false == is_field_empty ("email", 'Enter Email',"errordiv")) {
		    $('psword').value =''; 
			$('psword1').value =''; gotoTop();
		   return false;
		} else {
				if (false == is_field_empty ("confirmemail", 'Enter Confirm Email',"errordiv")) {
					$('psword').value =''; 
					$('psword1').value ='';  gotoTop();
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
			gotoTop();
			return false;
		}else{
			if($('email').value != $('confirmemail').value){
				$('errordiv').style.display     = "block";
				$('errordiv').innerHTML     = "Email and Confirm Email do not match";
				$('email').focus();
				$('psword').value =''; 
				$('psword1').value =''; 
				gotoTop();
				return false;			
			}
			
			
		}
		if (false == is_field_empty ("psword", 'Enter Password',"errordiv")) {
		    $('psword').value =''; 
			$('psword1').value =''; 
			gotoTop();
		   return false;
		} else {
			 if($('psword').value.length >= 6){
				 	if(is_valid_password ($('psword').value) == true){
						 $('errordiv').style.display     = "none";
						}
					else{
							$('errordiv').style.display     = "block";
							$('errordiv').innerHTML     = "Password should be in alphanumeric format";
							$('psword').focus();
							$('psword').value =''; 
							$('psword1').value =''; 
							gotoTop();
							return false;
 						}
					 $('errordiv').style.display     = "none";
				 }else{
					 
					$('errordiv').style.display     = "block";
					$('errordiv').innerHTML     = "Password should be minimum 6 characters";
					$('psword').focus();
					$('psword').value =''; 
					$('psword1').value ='';
					gotoTop(); 
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
			gotoTop();
		   return false;
		} else {
			$('errordiv').style.display     = "none";
			
		}
	
		if (false == is_field_empty ("address", 'Enter Address',"errordiv")) {
		    $('psword').value =''; 
			$('psword1').value ='';
			gotoTop(); 
			return false;
		} else {
			$('errordiv').style.display     = "none";
		}	
	
		if (false == is_field_empty ("city", 'Enter City',"errordiv")) {
		    $('psword').value =''; 
			$('psword1').value =''; 
			gotoTop();
			return false;
		} else {
			$('errordiv').style.display     = "none";
		}
		
		if (false == is_field_empty_wt_dummmy ("state","block_state",'Select State',"errordiv")) {
	            
		    $('psword').value =''; 
			$('psword1').value =''; 
		   return false;
		} else {
			$('errordiv').style.display     = "none";
		}
		
 		if (false == is_field_empty ("zipcode", 'Enter Zipcode',"errordiv")) {
		    $('psword').value =''; 
			$('psword1').value =''; 
			gotoTop();
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
								gotoTop();
								return false;
								
								}
					$('errordiv').style.display     = "none";
					
				 }else{
						
					$('errordiv').style.display     = "block";
					$('errordiv').innerHTML     = "Zipcode must be 5 digits";
					$('zipcode').focus();
					$('psword').value =''; 
					$('psword1').value =''; 
					gotoTop();
					return false;	
				 }
		}
		if (false == is_field_empty ("phone", 'Enter Phone Number',"errordiv")) {
		    $('psword').value =''; 
			$('psword1').value =''; 
			gotoTop();
			return false;
		} else {
			

			if($('phone').value.length < 10){
				$('errordiv').style.display     = "block";
				$('errordiv').innerHTML     = "Phone Number should contain minimum 10 numbers";
				$('phone').focus();
				$('psword').value =''; 
				$('psword1').value =''; 
				gotoTop();
				return false;
			}else {
				$('errordiv').style.display     = "none";
			}
 		}
		 
 		$('step1').value =1
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
   
   function populate_certificate_name(){
		var firstname = $('firstname').value;
		var lastname = $('lastname').value;
		$('name_on_certificate').value = firstname+' '+lastname;		
   }
   
   
   function checkuserregister_2(uid){  
   		
		var error = '';
                /*
		if (false == is_field_empty ("forumalias", 'Enter Forum Alias',"errordiv")) {
			gotoTop();
		   return false;
		} else {
			if ($('forumalias').value.length < 3 ){
			    $('errordiv').style.display = "block";
				$('forumalias').focus();
				$('errordiv').innerHTML     = "The Forum Alias field must be at least 3 characters in length";
				gotoTop();
				return false;
			} else {
				$('errordiv').style.display     = "none";
			}
		}
                */
                if (false == is_field_empty ("driving_license", 'Enter Drivers License Number',"errordiv")) {
		    gotoTop();
                    return false;
		} else {
                    $('errordiv').style.display     = "none";
		}
                
		if (false == is_field_empty_wt_dummmy ("txtLicencetype","block_txtLicencetype",'Enter Licence type',"errordiv")) {
                    gotoTop();     
                    return false;
		} else {
                    $('errordiv').style.display     = "none";
		}
		if (false == is_field_equal ("txthowhear",'Select', 'Enter So how did you hear about us?',"errordiv")) {
                    gotoTop();
		   return false;
		} else {
			if($('txthowhear').value == 'Search engine' ){
				if('' == $('txtSearchengine').value){
					$('errordiv').style.display = "block";
					$('txtSearchengine').focus();
					$('errordiv').innerHTML     = "Please enter Search Engine";
					gotoTop();
					return false;
				}
			}else if($('txthowhear').value == 'Referral from a real estate office'){
				if('' == $('txtREO').value){
					$('errordiv').style.display = "block";
					$('txtREO').focus();
					$('errordiv').innerHTML     = "Please enter Which real estate office";
					gotoTop();
					return false;
				}
			} else {
				$('errordiv').style.display     = "none";
			}
		}
		  
		if (false == is_field_empty ("b_address", 'Enter Billing Address',"errordiv")) {
			gotoTop();
			return false;
		} else {
			$('errordiv').style.display     = "none";
		}
		if (false == is_field_empty ("b_city", 'Enter Billing City',"errordiv")) {
			gotoTop();
			return false;
		} else {
			$('errordiv').style.display     = "none";
		}
		if (false == is_field_empty_wt_dummmy ("b_state","block_b_state", 'Select Billing State',"errordiv")) {
			gotoTop();
			return false;
		} else {
			$('errordiv').style.display     = "none";
		}
		
		if (false == is_field_empty ("b_zipcode", 'Enter Billing Zipcode',"errordiv")) {
			gotoTop();
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
				gotoTop();
				return false;
 			}
			$('errordiv').style.display     = "none";
			
		 }else{
				
			$('errordiv').style.display     = "block";
			$('errordiv').innerHTML     = "Billing Zipcode must be 5 digits";
			$('b_zipcode').focus();
			gotoTop();
			return false;	
		 }
 		}
		
		$('step2').value =2
 		$('myform').action = base_url+'iframe_user/register_step2/'+uid;
		$('myform').submit();
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
	
	function show_courses(id,selval){ 
			
            if($('hidcoursetype').value !='')  var coursetype	= $('hidcoursetype').value;
            if(id==1){
                var coursetype	= selval;
                $('hidcoursetype').value=selval;
                if(coursetype =='Live'){
                	$("preferred_colorp").checked=false;
                	$("preferred_colorc").checked=false;
                	$("coursetypel").removeClassName("button_orange"); //red
                    $("coursetypel").className="button_orange btn btn_withArrow_down";
                    $("coursetypeo").className="button_red btn btn_withArrow";
                }else if(coursetype =='Online'){
                	$("preferred_colorp").checked=false;
                	$("preferred_colorc").checked=false;
                	$("coursetypeo").removeClassName("button_red");
                    $("coursetypel").className="button_orange btn btn_withArrow"; //red
                    $("coursetypeo").className="button_red btn btn_withArrow_down";
                }else{
                    $("coursetypel").className="button_orange btn btn_withArrow";
                    $("coursetypeo").className="button_red btn btn_withArrow";
                }
                
                
                $('paytype').style.display='block';
                $('hidpaymenttype').value='';
            }
			
            if($('hidpaymenttype').value !='')  var paymenttype	= $('hidpaymenttype').value;
            if(id==2){
                var paymenttype	= selval;
            	$('hidpaymenttype').value=selval;
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
            
			var url =   base_url + "register_ajax/iframe_get_courses";

		
			var params = "licensetype="+licensetype+"&coursetype="+coursetype+"&paymentype="+paymenttype;
	
			new Ajax.Request(url,{
		                       method      : "post",
		                       parameters  : params,
		                       onSuccess   : update_courses,
		                       onFailure   : disp_error,
		                       onComplete : loadcustomparams
		                     }
		                );
			
 		 	$('update_course_div').innerHTML = '<center><img src="'+base_url+'images/spinner.gif"/></center>';
		 // load dropdown
		 function loadcustomparams(){ 
	 		if( jQuery("input[name='preferred_color']:checked").length > 0 ){
	 			jQuery('.wrapper-dropdown-5').removeClass('active');
				var dd = new DropDown( jQuery('#dd') );
				var dd = new DropDown( jQuery('#dd1') );
				var dd = new DropDown( jQuery('#dd2') );
				jQuery(document).click(function() {
					jQuery('.wrapper-dropdown-5').removeClass('active');
				});
 			}
 			// SET CARD TYPE AND OTHER DETAILS
 			jQuery('.cbocardtype').on('click', function(event){
  		     	jQuery("#cardtype").val( jQuery(this).attr("data-name") );
		    });
		  	jQuery('.select_month').on('click', function(event){
		     	jQuery("#expmonth").val( jQuery(this).attr("data-month") );
		    });
			jQuery('.select_year').on('click', function(event){
		     	jQuery("#expyear").val( jQuery(this).attr("data-year") );
		    });
		    
		   // parent.iframeResize(100);
		    
		 } 		 
         
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
		
	    
            
	}
	
	// show Mandatory course terms and condition
	function showterms(id){
		jQuery(".courses_csm").hide();
		jQuery(".courses_csmTC").hide();
		
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
		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";

		
			$$("input.scheck").each(function (elem) { if(elem.checked) {
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
		$$("input.subcheck").each(function (elem) { if(elem.checked) {
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
		$$("input.bcheck").each(function (elem) { if(elem.checked) {
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
		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";

		
				$$("input.scheck").each(function (elem) { if(elem.checked) {
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
		$$("input.subcheck").each(function (elem) { if(elem.checked) {
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
		$$("input.bcheck").each(function (elem) { if(elem.checked) {
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
		//alert(id);
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
                
                if($('new_package').value == 1)
                {
                    $('new_package').value = 0;
                    $('price').value = 0;
                    $('grid').innerHTML   = '';
                } 
		// intiate variable
		jQuery("div.showdivTC").hide();
		jQuery("div.courses_csoTC").hide();
		
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
		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";

		$$("input.scheck").each(function (elem) { if(elem.checked) {
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
		$$("input.subcheck").each(function (elem) { if(elem.checked) {
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
		$$("input.bcheck").each(function (elem) { if(elem.checked) {
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
		gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 >Ship Rate -</td>' + '<td  class=gridsectd ></td> <td class=gridtrlastsec width=100  ><div id=shipamount>'+$('shipprice').value+'</div></td></tr>';
		gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + '<td class=gridlastsectd width=10px ></td> <td class=page_error width=118  ><div id=totalamount>'+totalamnt+'</div></td></tr></table>';
		gridtext =gridtext+"</table>";
		if(a!=0){
			//$('grid').className = 'gridborder';
			$('grid').innerHTML   = gridtext;
		}else{
			$('grid').innerHTML   = '';
		}
		//parent.iframeResize(100);
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
		//add price and weight of checked element
		//$$("input.subcheck").each(function (elem) { if(elem.checked) { $('price').value =  parseFloat($('price').value)+ parseFloat(( $("subprice" + elem.value).value ));	$('totalweight').value =  parseFloat($('totalweight').value) +  parseFloat(( $("courseweight" + elem.value).value));}
																																						 // })
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
			 a =1;	
			 if(s==0){
			var rstyle= 'gridrowfirst';
			 s=1;
			 }
			 else{	
			var rstyle= 'gridrowsec';
			  s=0;
			 }
			 //alert(elem.value); 
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' +'<td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';
			 
													   
		}else{ gridtext = gridtext +''; } })
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
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' + ' <td width="118px" class="secondrow" style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';
			 
													   
		}else{ gridtext = gridtext +''; } })*/
		$$("input.bcheck").each(function (elem) { if(elem.checked) {
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
		 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;">Ship Rate -</td>' + '<td class=gridtrlastsec width=118  ><div id=shipamount style="padding-left:35px; font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';
		gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + '<td class=gridlastsectd width=10px ></td> <td class=page_error width=118  ><div id=totalamount>'+totalamnt+'</div></td></tr></table>';
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
		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";
			$$("input.scheck").each(function (elem) { if(elem.checked) { 
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
			 
													   
		} else{ gridtext = gridtext +''; } })
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
		$$("input.bcheck").each(function (elem) { if(elem.checked) {
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
		 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300  style="border-right:1px solid #000;">Ship Rate -</td>' + '<td class=gridtrlastsec width=118  ><div id=shipamount style="padding-left:35px; font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';
		gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + '<td class=gridlastsectd width=10px ></td> <td class=page_error width=118  ><div id=totalamount>'+totalamnt+'</div></td></tr></table>';
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

		$$("input.scheck").each(function (elem) { if(elem.checked) {
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
		$$("input.subcheck").each(function (elem) { if(elem.checked) {
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
		$$("input.bcheck").each(function (elem) { if(elem.checked) {
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
		
		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";

				$$("input.scheck").each(function (elem) { if(elem.checked) {
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
		$$("input.subcheck").each(function (elem) { if(elem.checked) {
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
		$$("input.bcheck").each(function (elem) { if(elem.checked) {
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

		
		$$("input.scheck").each(function (elem) { if(elem.checked) {
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

		$$("input.subcheck").each(function (elem) { if(elem.checked) {
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
			 
													   
		}else{ gridtext = gridtext +''; } })
		$$("input.bcheck").each(function (elem) { if(elem.checked) {
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
			 
													   
		} else{ gridtext = gridtext +''; }})
		var totalamnt= '$'+$('totalprice').value;
		 gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;">Ship Rate -</td>' + ' <td class=gridtrlastsec width=118 ><div id=shipamount style="padding-left:35px; font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';
		gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470>Total Price -</td>' + '<td class=gridlastsectd width=10px ></td> <td class=page_error width=118  ><div id=totalamount>'+totalamnt+'</div></td></tr></table>';

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
		var gridtext = "<table cellspacing='0' cellpadding='5' border='0' width='779' class='gridborder'><tr class='gridtrfirst'><td class='firstrow' width='611' style='border-right:1px solid #000;'>Course Name</td><td class='firstrow' width='118'>Amount($)</td></tr>";
		$$("input.scheck").each(function (elem) { if(elem.checked) {
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
		$$("input.subcheck").each(function (elem) { if(elem.checked) {
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
		$$("input.bcheck").each(function (elem) { if(elem.checked) {
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
			 
													   
		} else{ gridtext = gridtext +''; }})
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
		if($(sel).value >0) { $('agree'+id).src	=	base_url+'/images/checkbox_check.png';
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
		
		//parent.iframeResize(100);
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
	
	function showpackagecheck(id,amount){
 		
		if(id ==0){ if($('hidcrsid').value>0)
                        $('course_b'+$('hidcrsid').value).checked = false;
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
			$('totalprice').value =0;
			var coursesum1 = amount;
			var totalamnt= $('totalprice').value;
			
			gridtext =gridtext+ '<tr class=gridtrfirst><td class=gridtrlast width=300 style="border-right:1px solid #000;" >Ship Rate -</td>' + '<td class=gridtrlastsec width=100 style="padding-left:35px;"  ><div id=shipamount style="font-weight:bold; ">'+$('shipprice').value+'</div></td></tr>';
			
				
			gridtext =gridtext+ '<table cellspacing=0 cellpadding=5 border=0 width=769 ><tr><td class=gridtrlastprice width=470 >Total Price -</td>' + ' <td class=page_error width=118  ><div id=totalamount>$'+amount+'</div></td></tr></table>';
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
 	
 	// List ship method
	function checkshipmethod(){ 
		$(page3_error).style.display     = "none";
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
				$('errordiv').innerHTML     = "Select at least one course";
				gotoTop();
				return false;
                            }
                        }
                        catch(err){
        	
                        }
			
			//alert('go');
		}
		else{		
			$('errordiv').style.display     = "block";
			if(usertype == 1 || usertype == 3 || usertype == 5 || usertype == 7 ){
				$('errordiv').innerHTML     = "Select package";
			}else {		
				$('errordiv').innerHTML     = "Select at least one course";
			}
			gotoTop();
			return false;
		}
		// ajax function for listing
		
		if(checkzip($('s_zipcode')) == true || checkzip($('b_zipcode')) == true){
			//jQuery(".btn_shipping").addClass("btn_shipping_active");
			
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
			var url             =   base_url + "register_ajax/iframe_get_ship";
			var params      =   's_address='+escape($('s_address').value)+'&s_city='+escape($('s_city').value)+'&s_zipcode='+escape($('s_zipcode').value)+'&s_state='+escape($('s_state').value)
								+'&s_country='+escape($('s_country').value)+'&s_phone='+escape($('bphone').value)+'&weight='+weight;
		  //  url = base_url + url;
		  //alert(params);
			new Ajax.Request(url,{
			                       method      : "post",
			                       onSuccess   : shoshipmethod,
								   parameters  : params,
			                       onFailure   : disp_shiperror,
			                       onComplete  : complete_checkshipmethod
			                     }
			                );
	  		// end ajax function 
	  		
	  		
		}else{
	 		$('errordiv').style.display     = "block";
			$('errordiv').innerHTML     = "Billing Zipcode must be 5 digits";
			$('b_zipcode').focus();
			return false;
 		}
	}
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
	function complete_checkshipmethod(){
		//parent.iframeResize(100);
	}
	 
	// list ship method
	function addcourses(){
		var usertype = $('hidusertype').value; 
		/*var my_month=new Date()
		var month=my_month.getMonth()+1;
		var year= my_month.getFullYear()*/
		var year=$('curyear').value;
		var month=$('curmonth').value;
                $(page3_error).style.display     = "none";
		//alert($('price').value);
		if($('price').value==0){
			/*$('errordiv').style.display     = "block";
			$('errordiv').innerHTML     = "Select a course";
			return false;*/
			$('errordiv').style.display     = "block";
			if(usertype == 1 || usertype == 3 || usertype == 5 || usertype == 7 ){
				$('errordiv').innerHTML     = "Select package";
			}else {		
				$('errordiv').innerHTML     = "Select at least one course";
			}
			gotoTop();				
			return false;
		}
				
		if($('shipprice').value == 0){
			$('errordiv').style.display     = "block";
			$('errordiv').innerHTML     = "Select ship method";
			gotoTop();
			return false;
		}
		if (false == is_field_empty ("cardtype", 'Select Card Type',"errordiv")) {
			gotoTop();
		    return false;
		} else {
			$('errordiv').style.display     = "none";
		}
		if (false == is_field_empty ("ccno", 'Enter Credit Card No',"errordiv")) {
			gotoTop();
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
	
		 
        //Validate selected card with card no.
        var selectedcard = $("cardtype").value;
        var cardno = $('ccno').value;
        var flag = 0;
        if(isValidCreditCard(selectedcard, cardno)) { 
            $('errordiv').style.display     = "none";
            if (false == is_field_empty ("expmonth", 'Enter Expiry Month',"errordiv")) {
                //$$('div.page_error').style.height = "none";
                flag = 1;
                return false;
            }
            
            if (false == is_field_empty ("expyear", 'Enter Expiry Year',"errordiv")) { 
                //$$('div.page_error').style.display = "none";
                flag = 1;
               return false;
            }
            
        } else {
            document.getElementById('errordiv').innerHTML="Credit Card No should match selected Credit Card Type";
            $('errordiv').style.display     = "block";
            return false;
        }
        
                
                if(trim($('expyear').value) == year){
			
				if(trim($('expmonth').value) < month){
						$('errordiv').style.display     = "block";
						$('errordiv').innerHTML     = "Enter Valid Expiry month and Year";
						$('expmonth').focus();
						 return false;
				}
			}
	
	                
	                 $('sb_btn').setAttribute('disabled', true);
			$('course').action = base_url+'iframe_user/courseadd';	
		
			$('newimg').style.display ="block";
			$('newimg').innerHTML = '<img src='+base_url+'images/spinner.gif>'; 
			$('course').submit();
	 
	}
	
        function isValidCreditCard(type, ccnum) {
   if (type == "Visa") {
      // Visa: length 16, prefix 4, dashes optional.
      var re = /^4\d{3}-?\d{4}-?\d{4}-?\d{4}$/;
   } else if (type == "Mastercard") {
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
	
	function checkpackageshipmethod(){
	    if($('price').value !=0){
	
			//alert('go');
		}
		else{
	
			$('errordiv').style.display     = "block";
			$('errordiv').innerHTML     = "Select package";
			return false;
		}
		$('mygif').style.display ="block";
		$('mygif').innerHTML = '<img src='+base_url+'images/spinner.gif>';  
		var update_div  =   'showship';	
		var url         =   base_url + "register_ajax/iframe_get_ship";
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
	
	function isCreditCard(){
 		if($('cardtype').value == 'Amex')	{
 			document.getElementById('ccno').setAttribute('maxLength', 15);
			document.getElementById('cvv2no').setAttribute('maxLength', 4);
			
		}else{
			document.getElementById('ccno').setAttribute('maxLength', 16);
			document.getElementById('cvv2no').setAttribute('maxLength', 3);
 		}
	}
	 
	function gotoTop(){
		//console.log( jQuery("#errordisplay") );
		 //window.scrollTo(1,1);
 
 		//jQuery('#gototop').focus();
 	}
	
 	function ietruebody(){
		return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
	}
	
	function open_tooltip(thetext, thecolor, thewidth){ 
 		if (ns6||ie){
			if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px"
			if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor
			tipobj.innerHTML=thetext
			enabletip=true
			return false
		}
	}
	
	function positiontip(e){
		if (enabletip){
		var curX=(ns6)?e.pageX : event.clientX+ietruebody().scrollLeft;
		var curY=(ns6)?e.pageY : event.clientY+ietruebody().scrollTop;
		//Find out how close the mouse is to the corner of the window
		var rightedge=ie&&!window.opera? ietruebody().clientWidth-event.clientX-offsetxpoint : window.innerWidth-e.clientX-offsetxpoint-20
		var bottomedge=ie&&!window.opera? ietruebody().clientHeight-event.clientY-offsetypoint : window.innerHeight-e.clientY-offsetypoint-20
		
		var leftedge=(offsetxpoint<0)? offsetxpoint*(-1) : -1000
		
		//if the horizontal distance isn't enough to accomodate the width of the context menu
		if (rightedge<tipobj.offsetWidth)
		//move the horizontal position of the menu to the left by it's width
		tipobj.style.left=ie? ietruebody().scrollLeft+event.clientX-tipobj.offsetWidth+"px" : window.pageXOffset+e.clientX-tipobj.offsetWidth+"px"
		else if (curX<leftedge)
		tipobj.style.left="5px"
		else
		//position the horizontal position of the menu where the mouse is positioned
		tipobj.style.left=curX+offsetxpoint+"px"
		
		//same concept with the vertical position
		if (bottomedge<tipobj.offsetHeight)
		tipobj.style.top=ie? ietruebody().scrollTop+event.clientY-tipobj.offsetHeight-offsetypoint+"px" : window.pageYOffset+e.clientY-tipobj.offsetHeight-offsetypoint+"px"
		else
		tipobj.style.top=curY+offsetypoint+"px"
		tipobj.style.visibility="visible"
		}
	}
	
	function hide_tooltip(){
		if (ns6||ie){
			enabletip=false
			tipobj.style.visibility="hidden"
			tipobj.style.left="-1000px"
			tipobj.style.backgroundColor=''
			tipobj.style.width=''
		}
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
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' +'<td style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';
			 
													   
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
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' + '<td style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';
			 
													   
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
			 gridtext =gridtext+ '<tr class='+rstyle+' ><td style="border-right:1px solid #000;  border-bottom:1px solid #000;" class="secondrow" width="611px">'+carr["'"+elem.value+"'"][0]+'</td>' +'<td style=" border-bottom:1px solid #000;">'+carr["'"+elem.value+"'"][1]+'</td></tr>';
			 
													   
		} else{ gridtext = gridtext +''; }})
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
