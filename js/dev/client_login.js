	var day_temp 	= 0;
	var month_temp 	= 0;
	var year_temp 	= 0;
	
	/*Validation for user login*/
	function validate_user_Login(){
		$('server_error').style.display='none';
		if(is_field_empty("username",'Please enter Email',"error")==false){return false;}
		if(check_email("username",'Please enter valid Email',"error")==false){return false;}
		if(is_field_empty("password",'Please enter Password',"error")==false){return false;}
		$('loginform').submit();
	}
	function clearusername()
	{
		$('username').value='';
	}
	function clearpassword()
	{
		$('password').value='';
	}	
	
	/*Validation for forgot password*/
	function forgot_password(){
		$('flasherror').innerHTML 		=	'';
		$('errordisplay').innerHTML 	=	'';	
		$('flashsuccess').innerHTML 	=	'';	
		if(is_field_empty("email",'Please enter Email',"errordisplay")==false){return false;}
		if(check_email("email",'Please enter valid Email',"errordisplay")==false){return false;}
		
		$('forgot_password_form_adhi').action = base_url+'user/forgot_password/';
		$("forgot_password_form_adhi").submit();
	}

	/** class display  */
	
	function fncGetClass(subregion){
		$('hdnSubregion').value = subregion;
	}
	
	function fncNextPrevRegion (nav) {
	
		var offset = $('hdnOffset').value;
		//nav - 0 for previous, nav - 1 for next
		if(nav == 0) {
			offset = parseInt(offset)-5;
		} else if(nav == 1) {
			offset = parseInt(offset)+5;
		}
		var subregion 		= $('hdnSubregion').value ;
		var dated 			= $('hdnDated').value ;
		var url             =   base_url + "home/related_region/";
		
		var params = "dated="+dated+"&subregion="+subregion+"&offset="+offset;
	  //  url = base_url + url;
		new Ajax.Request(url,{
		                       method      : "post",
		                       parameters  : params,
		                       onSuccess   : update_captcha_div,
		                       onFailure   : disp_error
		                     }
		                );
	
		 $('divImage').innerHTML = '<center><img src="'+base_url+'images/spinner.gif"/></center>';
	    function update_captcha_div(resp_obj)
	    {
	        $('divShowRelatedImage').innerHTML = resp_obj.responseText;
	    }	
	    function disp_error() {
			alert("Ajax request failed");
		}
	}
	
	/** populates a select box dynamically using Json array**/
	function fncGetSubregion(main,sub){
				
		var numb 		= $(main).value;
		var obj 		= eval(content);
		if(obj != ''){
			$(sub).options.length	= null;
			$(sub).options[$(sub).options.length] = new Option('Select',0);
			if(obj.R[numb]){
				
				obj.R[numb].each(function(n){
					$(sub).options[$(sub).options.length] = new Option(n.name,n.id);  
				});
			}
		}
	}
	
	function fncDisplayDefaultList(timeid,day,month,year){
		fncGetNextCalendar(timeid);
		day_temp 	= day;
		month_temp 	= month;
		year_temp 	= year;
		//setTimeout("fncShowEventList("+day+","+month+","+year+")",700);
		
	}
	
	function fncGetNextCalendar(timeid){
		
		var url   		= base_url + "schedule/show_next_calendar/";
		var region 		= $('sltSearchRegion').value ;
		var subregion 	= $('sltSearchSubregion').value ;
		
		 var course 	= $('sltSearchCourse').value ;
                if(course==5){
                    $('chter_cnt').style.display='block';
                    var chp 	= $('sltSearchChp').value;
                    var params 	= "timeid="+timeid+"&region="+region+"&subregion="+subregion+"&course="+course+"&chp="+chp;
                }else{
                    $('chter_cnt').style.display='none';
                    var params 	= "timeid="+timeid+"&region="+region+"&subregion="+subregion+"&course="+course;
                }
	  
		new Ajax.Request(url,{
		                       method      : "post",
		                       parameters  : params,
		                       onSuccess   : fncSuccess,
		                       onFailure   : fncError
		                     }
		                );
	
		 $('divUserCalendar').innerHTML = '<div style="width:300px;"><center><img src="'+base_url+'images/spinner.gif"/></center></div>';
		 
	    function fncSuccess(resp_obj)
	    {
	        $('divUserCalendar').innerHTML = resp_obj.responseText;
	        if(parseFloat($('hdnTimeline').value) == parseFloat(timeid)){
	        	fncShowEventList(day_temp,month_temp,year_temp);
	        }
	        
	    }	
	    function fncError() {
			alert("Ajax request failed");
		}
	}
	
	function fncShowEventList(day,month,year){
		current_date 	= month+'/'+day+'/'+year; 
		var url 		= base_url+'index.php/schedule/display_list';
		var region 		= $('sltSearchRegion').value;
		var subregion 	= $('sltSearchSubregion').value;
		 var course 	= $('sltSearchCourse').value ;
                 if(course==5){
                    $('chter_cnt').style.display='block';
                    var chp 	= $('sltSearchChp').value;
                    var params 	= "datecurrent="+current_date+"&region_id="+region+"&subregion_id="+subregion+"&course="+course+"&chp="+chp;
                }else{
                    $('chter_cnt').style.display='none';
                    var params 		= "datecurrent="+current_date+"&region_id="+region+"&subregion_id="+subregion+"&course="+course;
                }
		
		fncSetSelection(day);
		
		$('divDisplayEventList').style.display 	= 'block';
		$('divDisplayEventList').innerHTML 		= 'Please wait ...<img src="'+base_url+'images/spinner.gif">';
		
		new Ajax.Request(url,
	            { 
	                method		:"post",
	                parameters  : params,
	                onSuccess	: fncDisplayList
	            }
		);
		
	}
	//function used to change the selected dates color
	function fncSetSelection(day){
		var arrayElem      = $('tblCalendarId').getElementsByTagName('td');								
		for (var i in arrayElem)
		{
			if (arrayElem[i].id)
			{ 
				if(i<arrayElem.length)
				{
					if (arrayElem[i].id != day)
					{
						$(arrayElem[i].id).removeClassName('selectedDay');
					}
					else if (arrayElem[i].id == day)
					{ 
						$(arrayElem[i].id).addClassName('selectedDay');
					}
				}
			}
		}
	}
	function fncDisplayList(obj){
		$('divDisplayEventList').innerHTML = obj.responseText;
		$('divDisplayEventList').scrollTo();
	}