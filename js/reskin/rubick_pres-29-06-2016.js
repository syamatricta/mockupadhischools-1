var searchVisible = 0;
var transparent = true;

var transparentDemo = true;
var fixedTop = false;

var navbar_initialized = false;

var big_image; 
var scroll;
var project_content;
var $project;
scroll = ( 2500 - $(window).width() ) / $(window).width();

var $ScrollTop;
var $ScrollBot;

var pixels;

var modal;
var $project_content;

var test = true;        

var timerStart = Date.now();
var delay;

var no_of_elements = 0;
var window_height;
var window_width;

var content_opacity = 0;
var content_transition = 0;
var no_touch_screen = false;

var burger_menu;

var loginform_validator;
var forgotpasswod_validator;

var package_radio_id;
var package_option_radio_id;

var cart_checkbox_ids = [];
        
$(document).ready(function(){
	var check = 1;
    BrowserDetect.init();
    
    if(BrowserDetect.browser == 'Explorer' && BrowserDetect.version <= 9){
        $('body').html(better_browser);   
    }

    window_width = $(window).width();
    window_height = $(window).height();

    burger_menu = $('nav').hasClass('navbar-burger') ? true : false;
    
    if (!Modernizr.touch){
        $('body').addClass('no-touch');
        no_touch_screen = true;
    }
    
    rubik.initAnimationsCheck();
    
    // Init navigation toggle for small screens   
    if(window_width < 979 || burger_menu){
        rubik.initRightMenu();   
    }

    if(window_width < 979){
        $('.over-area').each(function(){
            var click = $(this).attr("onClick");
            if(click == ''){
                src = "rubik.showModal(this)";
                $(this).attr("onClick", src);
            }
        });
        
        rubik.checkResponsiveImage();
    } 
    
    
    
    if($('#contactUsMap').length != 0){
        rubik.initGoogleMaps();   
    }
    
    if($('.content-with-opacity').length != 0){
        content_opacity = 1;
    }
    
    $("#classess_view").owlCarousel({
            items       : 3,
            margin      : 20,
            navigation  : true,
            loop        : true,
            navText     : [ '<i class="fa fa-chevron-left madan"></i>', '<i class="fa fa-chevron-right madan"></i>' ],
            nav         : true,
            responsiveClass:true,
            responsive  :{
              0:{
                  items:1,	            
              },
              600:{
                  items:2,	           
              },
              1000:{
                  items:3,	            

              }
            },
            onInitialize: function (event) {
                  if ($('#section-class .owl-carousel .item').length <= 1) {
                     this.settings.loop = false;
                     
                  }
            }
    });
	$("#blog_view").owlCarousel({
 
	      
	      items : 4,
	      margin:20,
	      navigation : true,
	      navText: [ '<i class="fa fa-chevron-left madan"></i>', '<i class="fa fa-chevron-right madan"></i>' ],
	      nav:true,
	      loop:true,
	      responsiveClass:true,
	      responsive:{
	        0:{
	            items:1,	            
	        },
	        600:{
	            items:2,	           
	        },
	        1000:{
	            items:4,	            
	            
	        }
	      }
	  });
	$("#video_view").owlCarousel({
 
	      
	      items : 1,
	      navigation : true,
	      navText: [ '<i class="fa fa-chevron-left madan"></i>', '<i class="fa fa-chevron-right madan"></i>' ],
	      nav:true,
              margin:10,
              video:true,
              lazyLoad:true,
              loop:true
	 
	  });
	  $("#testimonial_view").owlCarousel({	      
	      items : 1,	     
	      navigation : true,
	      autoHeight : true,
	      navText: [ '<i class="fa fa-chevron-left madan"></i>', '<i class="fa fa-chevron-right madan"></i>' ],
	      nav:true,	 
              loop:true,
              autoHeight : true,
	  });
	  $('#license_info_form, #license_info_form_popup').submit(function(event) {
                var formid  = $(this).attr('id');
                if('license_info_form_popup' == formid){
                    var wrapper         = '#popup-contactform';
                    var licencee_name   = '#licencee_name_popup';
                    var licencee_email  = '#licencee_email_popup';
                    var math_captcha    = '#math_captcha_popup';
                    var licencee_phone  = '#licencee_phone_popup';
                    var valid_msgs      = '#license_info_form_popup .valid_msgs';
                    var captcha_question= '#captcha_question_popup';
                }else{
                    var wrapper         = '#contactform';
                    var licencee_name   = '#licencee_name';
                    var licencee_email  = '#licencee_email';
                    var math_captcha    = '#math_captcha';
                    var licencee_phone  = '#licencee_phone';
                    var valid_msgs      = '.valid_msgs';
                    var captcha_question= '#captcha_question';
                }
                
                event.preventDefault();
		
		//if(check == 1){
                    var warning  = '';

                    if($(licencee_name).val() == ''){
                        warning += 'The Name field is required.' + "\n";
                    }
                    if($(licencee_email).val() == ''){
                        warning += 'The Email field is required.' + "\n";
                    }else if (!is_valid_email($(licencee_email).val())){
                        warning += 'The Email given is not valid.' + "\n";
                    }
                    if($(math_captcha).val() == ''){
                        warning += 'The Captcha field is required.' + "\n";
                    }
                    if(warning !=''){
                        $(valid_msgs).text(warning).addClass('error_msg');
                    }else{
                        check       = 0;
                        var remove  = '';
                        var first   = 0;
                        if($(valid_msgs).hasClass('success_msg')){
                            remove = 'success_msg';
                            first = 1;
                        }
                        if($(valid_msgs).hasClass('error_msg')){		                
                            if(first == 1){
                                remove = ' error_msg';
                            } else{
                                remove = 'error_msg';
                            }
                        }


                        $(valid_msgs).removeClass(remove).hide();
                        //jQuery('.valid_msgs').removeClass(remove).html('Please wait...');

                        //$('#loader_enquiry').show();
                        plsWaitDiv(wrapper, 'show');
                        $.post(base_url+'home/real_estate_license_info', $(this).serialize(), function(resp) {
                            //$('#loader_enquiry').hide()   
                            plsWaitDiv(wrapper, 'hide');
                            if(resp.status !=200){
                                $(valid_msgs).removeClass('success_msg').addClass('error_msg').html(resp.msg).show();
                                $(math_captcha).val('');
                            }else {
                                if('#popup-contactform' == wrapper){
                                    $('#popup-form-wrapper').html('<div class="col-sm-10 col-sm-offset-1 text-center"><h3 class="registration-success-msg"><div class="margin10 text-center"><span class="fa-stack fa-lg"><i class="fa fa-circle-thin fa-stack-2x"></i><i class="fa fa-check fa-stack-1x"></i></span></div><b> '+resp.msg+'</b></h3><button class="btn-adhi" data-dismiss="modal">OK</button></div>');
                                }else{
                                    $(valid_msgs).removeClass('error_msg').addClass('success_msg').html(resp.msg).show();
                                }
                                $(math_captcha+','+licencee_name+','+licencee_email+','+licencee_phone).val('');
                            }
                            $(captcha_question).html(resp.math_captcha_question);
                            check = 1;
                        });
                    }
		//}
		return false;
            });
		
     
	var $active = $('#accordion .panel-collapse.in').prev().addClass('active');
	$active.find('a').append('<span class="faa-minus pull-right"></span>');
	$('#accordion .panel-heading').not($active).find('a').prepend('<span class="faa-plus pull-right"></span>');
	$('#accordion').on('show.bs.collapse', function (e)
	{
		$('#accordion .panel-heading.active').removeClass('active').find('span').toggleClass('faa-plus faa-minus');
		$(e.target).prev().addClass('active').find('span').toggleClass('faa-plus faa-minus');
	});
	$('#accordion').on('hide.bs.collapse', function (e)
	{
		$(e.target).prev().removeClass('active').find('span').removeClass('faa-minus').addClass('faa-plus');
	});
	$('[data-toggle="tooltip"]').tooltip();
	
	 
	$('[data-toggle="popover"]').popover();
	$('#txthowhear').on('change', function (e) {
		$('#extrafield').hide();
		$('.hearoptions').hide();	
		if($(this).val()=='Search engine'){
			$('#extrafield').show();
		  	$('#txtSearchengine').show();
		}
		if($(this).val()=='Referral from a real estate office'){
			$('#extrafield').show();
		  	$('#txtREO').show();
		}
	});
	$('#setaddr').on('click', function (e) {	
            if ($(this).is(':checked')) {
                var address = ($('#address').length > 0)    ? $('#address').val()   : $('#s_address').val();
                var city    = ($('#city').length > 0)       ? $('#city').val()      : $('#s_city').val();
                var state   = ($('#state').length > 0)      ? $('#state').val()     : $('#s_state').val();
                var zip     = ($('#zipcode').length > 0)    ? $('#zipcode').val()   : $('#s_zipcode').val();
                
                $('#b_address').val(address);
                $('#b_city').val(city);
                $('#b_state').val(state);
                //there is no #zipcode in course add page                
                $('#b_zipcode').val(zip);

               /*$('#indicator').css('display','inline');
                $('#indicator').html('<img src='+base_url+'images/spinner.gif>');.
                $.ajax({
	            type: "POST",
	            url: base_url +'user/setShippingAddrToBillingAddr',
	            dataType: 'json',
	            data : {},
	            cache: false, 
	            success:function(data){	
	            	console.log(data.status)            	 
	            	var json = data
               
		              if(data.status = 200){
		                  $('#indicator').hide();
		                  $('#indicator').html('')  
		                  $('#b_address').val(json.data.address);
		                  $('#b_city').val(json.data.city);
		                  $('#b_state').val(json.data.state_code);
		                  //$('#block_b_state').val(json.data.state) ;
		                  //$('b_country').setValue(json.data.country);
		                  $('#b_zipcode').val(json.data.zipcode);
		              }    
	                    
	            }
	            
			});*/
        }else{
           $('#b_address, #b_city, #b_state, #b_zipcode').val('');
        }
    });
	
	$.validator.addMethod("phoneUS", function(phone_number, element) {
		phone_number = phone_number.replace(/\s+/g, "");
		return this.optional(element) || phone_number.length > 9 &&
			phone_number.match(/^(\+?1-?)?(\([2-9]([02-9]\d|1[02-9])\)|[2-9]([02-9]\d|1[02-9]))-?[2-9]([02-9]\d|1[02-9])-?\d{4}$/);
	}, "Please specify a valid phone number"); 
	
	$.validator.addMethod("zipcodeUS", function(value, element) {
		return this.optional(element) || /^\d{5}(-\d{4})?$/.test(value);
	}, "The specified US ZIP Code is invalid");
	$.validator.addMethod("creditcardtypes", function(value, element, param) {
		if (/[^0-9\-]+/.test(value)) {
			return false;
		}
	
		value = value.replace(/\D/g, "");
	
		var validTypes = 0x0000;
	
		if (param.mastercard) {
			validTypes |= 0x0001;
		}
		if (param.visa) {
			validTypes |= 0x0002;
		}
		if (param.amex) {
			validTypes |= 0x0004;
		}
		if (param.dinersclub) {
			validTypes |= 0x0008;
		}
		if (param.enroute) {
			validTypes |= 0x0010;
		}
		if (param.discover) {
			validTypes |= 0x0020;
		}
		if (param.jcb) {
			validTypes |= 0x0040;
		}
		if (param.unknown) {
			validTypes |= 0x0080;
		}
		if (param.all) {
			validTypes = 0x0001 | 0x0002 | 0x0004 | 0x0008 | 0x0010 | 0x0020 | 0x0040 | 0x0080;
		}
		if (validTypes & 0x0001 && /^(5[12345])/.test(value)) { //mastercard
			return value.length === 16;
		}
		if (validTypes & 0x0002 && /^(4)/.test(value)) { //visa
			return value.length === 16;
		}
		if (validTypes & 0x0004 && /^(3[47])/.test(value)) { //amex
			return value.length === 15;
		}
		if (validTypes & 0x0008 && /^(3(0[012345]|[68]))/.test(value)) { //dinersclub
			return value.length === 14;
		}
		if (validTypes & 0x0010 && /^(2(014|149))/.test(value)) { //enroute
			return value.length === 15;
		}
		if (validTypes & 0x0020 && /^(6011)/.test(value)) { //discover
			return value.length === 16;
		}
		if (validTypes & 0x0040 && /^(3)/.test(value)) { //jcb
			return value.length === 16;
		}
		if (validTypes & 0x0040 && /^(2131|1800)/.test(value)) { //jcb
			return value.length === 15;
		}
		if (validTypes & 0x0080) { //unknown
			return true;
		}
		return false;
	}, "Please enter a valid credit card number.");
        
        
        $.validator.addMethod("customemail", 
            function(value, element) {
                var str = /(^[a-zA-Z0-9]+[\._-]{0,1})+([a-zA-Z0-9]+[_]{0,1})*@([a-zA-Z0-9]+[-]{0,1})+(\.[a-zA-Z0-9]+)*(\.[a-zA-Z]{2,3})$/;
                return str.test(value);
            }, 
            "Please enter a valid email address."
        );
        /* Registration Step 1 */
        $("#registerform_step1").validate({
            rules: {
                phone: {
                    required: true,
                    phoneUS: true,
                    digits: true
                },
                email: {
                    required: true,
                    email: false,
                    customemail: true
                },
                confirm_name: {
                    required: true
                },
                confirm_email: {
                    required: true
                },
                psword: {
                    required: true,		
                    minlength: 6,	       
                },
                psword1: {		
                  required: true,
                  minlength: 6,         
                  equalTo: "#psword",
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "confirm_name" || element.attr("name") == "confirm_email") {
                    $('#'+element.attr("name")+'_id').parent('div').after(error);
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                loading_next_step(1, 'show');
                url = base_url+'register_ajax/register';
                $.ajax({
                    type    : "POST",
                    url     : url,
                    dataType: "json",
                    data    : $("#registerform_step1").serialize(), // serializes the form's elements.
                    success : function(data){
                        loading_next_step(1, 'hide');
                        if(data.proceed){
                            $('#errordiv').html('').hide();
                            $('#registration-carousel').carousel('next');
                            set_reg_step_info(2);
                            $("html, body").animate({ scrollTop: $('.page_head .part1').offset().top-82 }, "slow");
                        }else{
                            $('#errordiv').html(data.errors).show();
                            $("html, body").animate({ scrollTop: $('.register').offset().top }, "slow");
                        }
                    }
                });
            }
        });
        
        /* Registration Step 2 */
	$("#registerform_step2").validate({
            rules: {
                zipcode: {
                  required: true,
                  zipcodeUS: true
                },
                b_zipcode: {
                  required: true,
                  zipcodeUS: true
                }/*,
                forumalias: {		
                  required: true,
                   minlength: 3
                }*/
            },
            submitHandler: function(form) {
                loading_next_step(2, 'show');
                url = base_url+'register_ajax/register';
                $.ajax({
                    type    : "POST",
                    url     : url,
                    dataType: "json",
                    data    : $("#registerform_step2").serialize(), // serializes the form's elements.
                    success : function(data){
                        loading_next_step(2, 'hide');
                        if(data.proceed){
                            $('#errordiv').html('').hide();
                            $('#registration-carousel').carousel('next');
                            $("html, body").animate({ scrollTop: $('.page_head .part1').offset().top-82 }, "slow");
                            
                            var reg_data = data.reg_data;
                            $('#hidlicensetype').val(reg_data.licensetype);
                            $('#s_state').val(reg_data.s_state);
                            $('#unitnumber').val(reg_data.unit_number);
                            $('#s_address').val(reg_data.s_address);
                            $('#s_city').val(reg_data.s_city);
                            $('#s_zipcode').val(reg_data.s_zipcode);
                            $('#s_country').val(reg_data.s_country);
                            $('#bphone').val(reg_data.phone);
                            $('#register_user').val(1);
                            //Check if user changed State or Zipcode after selecting shipping in 3rd step and cameback in 2nd step
                            if(data.reset_shipping == 1){
                                resetShipping();
                            }
                            set_reg_step_info(3);
                        }else{
                            $('#errordiv').html(data.errors).show();
                            $("html, body").animate({ scrollTop: $('.register').offset().top }, "slow");
                        }
                    }
                });
            }
        });
        
        /* Registration Step 3 */
        $("#registerform_step3").validate({
            rules: {
                package_type: {
                    required: true
                },
                ccno: {		
                    required: true,			     
                    creditcard: true			      
                },
		     
            },
            messages: {
                package_type: {
                    required: 'Please select one of the above options'
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "package_type") {
                  //error.insertAfter("#fixederror");
                  $('#radio4').parent('div').after(error);
                } else {
                  error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                var usertype = $('#hidusertype').val();
                if($('#price').val() == 0){ 
                    $('#fixederror').show();

                    if(usertype == 1 || usertype == 3 || usertype == 5 || usertype == 7 ){						 
                        $('#fixederror').html("Select package");
                    }else {
                        $('#fixederror').html("Select at least one course");						 
                    }
                    return false;		
                }

                if($('#shipprice').val() == 0){
                    $('#fixederror').show();
                    $('#fixederror').html("Select ship method");
                    return false;
                }
                
                
                loading_next_step(3, 'show');
                url = base_url+'register_ajax/register';
                $.ajax({
                    type    : "POST",
                    url     : url,
                    dataType: "json",
                    data    : $("#registerform_step3").serialize(), // serializes the form's elements.
                    success : function(data){
                        loading_next_step(3, 'hide');
                        if(data.proceed){
                            $('#registraion_message_slide').html(data.page_view);
                            $('#errordiv').html('').hide();
                            $('.reg-step-info').html('');
                            $('#registration-carousel').carousel('next');
                            $("html, body").animate({ scrollTop: $('.page_head .part1').offset().top-90 }, "slow");
                            //set_reg_step_info(3);                            
                        }else{
                            $('#errordiv').html(data.errors).show();
                        }
                    }
                });

            }
        });
        
        $('#hidcoursetype').val('Live');
	$('.register a[data-toggle="tab"], .apply-new-course  a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $('#hidcoursetype').val(e.target.innerHTML);
	    show_courses(e.target.innerHTML,$('input[name=package_type]:radio:checked').val());	
            initializeRadio();
	    $('#fixederror').hide();	
	});
	$('.register input[name=package_type]:radio, .apply-new-course  input[name=package_type]:radio').on('click',function () {
            $('.radio-info label').removeClass('selected_label');
            $(this).next('label').addClass('selected_label');
            show_courses($('#hidcoursetype').val(),$('input[name=package_type]:radio:checked').val());
            initializeRadio();
            $('#fixederror').hide();	
	});
        
	$('.register, .apply-new-course').on('click','input[name=course_p]:radio',function (event) {
		event.preventDefault();
                checkRadio('course_p', $(this).attr('id'), 'iagree');
                changeAgreeInuptId('iagree');
                $('#geninformation').modal();
		$('#geninformation').data('price',$(this).data('price'));
		$('#geninformation').data('fromid',$(this).attr('id'));
		$('#fixederror').hide();
	});
	$('.register, .apply-new-course').on('click','input[name=course_bp]:radio',function (event) {	
		 event.preventDefault()	;
                 checkRadio('course_bp', $(this).attr('id'), 'iagree');
                 changeAgreeInuptId('iagree');
		 $('#geninformation').modal();
		 $('#geninformation').data('price',$('#course_b').data('price'));
		 $('#geninformation').data('fromid',$(this).attr('id'));
		  $('#fixederror').hide();
	});
	
	$('.register, .apply-new-course').on('show.bs.modal','#geninformation', function (event) {
		$('.modal .modal-body').css('overflow-y', 'auto'); 
    	$('.modal .modal-body').css('max-height', $(window).height() * 0.7);		
	});
 	 
 	
 	
 	$('#geninformation').on('click','#iagree',function(){ 		
 		amount = $('#geninformation').data('price');
 		radio  = $('#geninformation').data('fromid');
 		radioname =   $('#'+radio).attr('name');
 		course_name = $('#'+radio).data('course_name');
                
		if ($('#'+radio).is(':checked')) {
                    $('#geninformation').modal('hide');
                    //return;
		}
		$('#new_package').val(0) ;
		$('#hidcrsid').val(0) ;
 		$('#price').val(amount) ;
 		$('#gridtable').show();
 		//$('#pakageprice').html('$'+amount); 
 		$('#gridtotalprice').html('$'+amount); 
 		$('#geninformation').modal('hide');
 		//$('input[name=course_p]:radio').prop('checked',false); 
                if($('#'+radio).attr('name') == 'course_p'){
                    if(package_radio_id != radio){
                        package_option_radio_id = '';
                    }
                    package_radio_id        = radio;
                }else if($('#'+radio).attr('name') == 'course_bp'){
                    package_option_radio_id = radio;
                }
 		$( "#grid").find('.salesrow').remove();
 		$( "<tr id=gridtr"+radio+" class='salesrow'><td>"+course_name+"</td><td class='prcolor' align='center'>$"+amount+"</td></tr>" ).insertAfter( "#grid .gridheading" );	
 		if(course_name=='Package 2'){
 			$('#new_package').val(1) ;
 		}
 		if(radio!='course_b')
 			$('input[name=course_bp]:radio').prop('checked',false); 		 			 
 		if(radioname=='course_bp'){
 			 $('#course_b').prop('checked',true);	
 			 $('#hidcrsid').val($('#'+radio).val())	;
 		} 		
 		$('#' + radio).prop('checked',true);
 		$('#shipprice').val(0);
		$('#totalprice').val(amount);
		// $("input[name=test]").is(":checked")
                if($('#course_b').is(":checked") && $("input[name=course_bp]").is(":checked")){ 	
                    $('#totalweight').val(parseFloat($('#weight').val()) +  parseFloat($('input[name="course_bp"]:checked').data('courseweight'))); 
                }else{
                    $('#totalweight').val(parseFloat($('#weight').val()));  
                }
        
        
        if($('#course_b_newpackage').is(":checked"))         
			$('#totalweight').val(parseFloat($('#weight_newpackage').val() )); 
         
 		$('#hidwt').val(parseFloat($("#totalweight").val()));
 		$('#shiprate').html('$ 0.00');
 		$('#shipbutton').show();
		$('#showship').html('');
 		
 	});
 	
 	$('#geninformation').on('click','#inoagree',function(){
 		radio_check  = $('#geninformation').data('fromid'); 	
 		$('#' + radio_check).prop('checked',false);	
                if($('#'+radio_check).attr('name') == 'course_p' && $('#'+radio_check).attr('id') == package_radio_id){
                    package_radio_id    = '';
                }
                if($('#'+radio_check).attr('name') == 'course_bp'  && $('#'+radio_check).attr('id') == package_option_radio_id){
                    package_option_radio_id    = '';
                }
 		$('#geninformation').modal('hide');	
 		$( "#grid").find('.salesrow').remove();	
 		$('#price').val(0) ;
 		$('#gridtable').hide();
 		$('#shipprice').val(0);
		$('#totalprice').val(0);
		$('#totalweightb').val(0);
		$('#totalweight').val(0);
 		$('#shiprate').html('$ 0.00');
 		$('#shipbutton').show();
		$('#showship').html('');
		$('#new_package').val(0) ;
		$('#hidcrsid').val(0) ;
 		
 	});
 	$('.register, .apply-new-course').on('click','.mandatory input[type=checkbox]',function (event) { 	
            	 event.preventDefault();
                 checkCheckbox($(this).attr('id'), 'iagree_cart');
                 changeAgreeInuptId('iagree_cart');
		 $('#geninformation').modal('show');
                 $('#geninformation').data('price',$(this).data('price'));
		 $('#geninformation').data('fromid',$(this).attr('id'));
		 $('#fixederror').hide();
	})
 
	$('.register, .apply-new-course').on('click','input[name=course_b]:radio',function (event) {			 
		 event.preventDefault();
                 checkRadio('course_b', $(this).attr('id'), 'iagree_cart');
                 changeAgreeInuptId('iagree_cart');
		 $('#geninformation').modal();
                 $('#geninformation').data('price',$(this).data('price'));
		 $('#geninformation').data('fromid',$(this).attr('id'));
		 $('#fixederror').hide();
	})
 	$('#geninformation').on('click','#iagree_cart',function(e){ 
 		radio_check  = $('#geninformation').data('fromid');	
                //$('#' + radio_check).prop('checked',false);
                amount = $('#geninformation').data('price');
                
 		course_name = $('#'+radio_check).data('course_name');
 		cweight = 	  $('#'+radio_check).data('courseweight');
		if ($('#'+radio_check).is(':checked')) {
			$('#geninformation').modal('hide');
			return;
		}
 		//radio_checkname =   $('#'+radio_check).attr('name');
 		$('#new_package').val(0) ;
 		$('#price').val(amount) ;
 		$('#gridtable').show(); 
 		$( "#gridtr"+radio_check).remove();
 		
 		var type_class='';
 		if($('#'+radio_check).attr('type')=='radio'){
 			$( "#grid").find(".radioclass").remove();
 			type_class= "class='radioclass'";
 		}
		$( "<tr "+type_class+" id=gridtr"+radio_check+"><td>"+course_name+"</td><td class='prcolor' align='center'>$"+amount+"</td></tr>" ).insertAfter( "#grid .gridheading" );
 		//var g_total = parseFloat($('#totalprice').val())+parseFloat(amount);
                
                
                
                
 		$('#geninformation').modal('hide');
 		$('input[name=course_p]:radio').prop('checked',false); 	
	
 		$('#' + radio_check).prop('checked',true);
                
                /* Calculating grand total */
                checklength = $('input[name="course[]"]:checked').length;
                g_total = 0;
                if(checklength > 1){
                    $('input[name="course[]"]:checked').each(function(c) {
                       g_total += parseFloat($(this).data('price'));
                    });
                }else if(checklength > 0){
                  g_total = parseFloat($('input[name="course[]"]:checked').data('price'));
                }
                if($('input[name="course_b"]:checked').length > 0){
                    g_total += parseFloat($('input[name="course_b"]:checked').data('price'));
                }
                
                if($('#'+radio_check).attr('name') == 'course_b' && $('#'+radio_check).attr('type')=='radio'){
                    package_option_radio_id = radio_check;
                }
                
 		$('#shipprice').val(0);
		$('#totalprice').val(g_total);
		$('#gridtotalprice').html('$'+g_total.toFixed(2)); 
		if( $('#'+radio_check).attr('type')=='checkbox'){
                    cart_checkbox_ids.push(radio_check);
                    //console.log(cart_checkbox_ids);
                    var totlal = parseFloat($('#totalweight').val())+ parseFloat(cweight);
                    $('#totalweight').val(totlal);
		}else{
                    $('#totalweightb').val(cweight);
		}
                
 		$('#hidwt').val(parseFloat($("#totalweight").val()));
 		$('#shiprate').html('$0.00');
 		$('#shipbutton').show();
		$('#showship').html('');
 	});
 	
 	$('#geninformation').on('click','#inoagree_cart',function(){
 		radio_check  = $('#geninformation').data('fromid'); 
 		var amount = parseFloat($('#geninformation').data('price'));	
 		 
 		var total = parseFloat($('#totalprice').val())- parseFloat($('#shipprice').val());
                
                if (!$('#'+radio_check).is(':checked')) {
                    $('#geninformation').modal('hide');
                    return;
		}
 		$('#' + radio_check).prop('checked',false);	
 		$('#gridtr'+ radio_check).remove();
                new_total   = 0;
 		if(total>=amount ){
 			var new_total = total - amount;
 			$('#totalprice').val(new_total);
 		}
 		if($('#'+radio_check).attr('type')=='radio' && $('#'+radio_check).attr('name') == 'course_b' && $('#'+radio_check).attr('id') == package_option_radio_id){
                    package_option_radio_id    = '';
                }
 		if( $('#'+radio_check).attr('type')=='checkbox'){
                    popCartCheckboxId(radio_check);
                    //var totlal = parseFloat($('#totalweight').val())- parseFloat(cweight);
                    var totalweight = parseFloat($('#totalweight').val())- parseFloat($('#'+radio_check).data('courseweight'));
                    $('#totalweight').val(totalweight);
		}else{
                    $('#totalweightb').val(0);
		}
 		
 		$('#gridtotalprice').html('$'+new_total.toFixed(2)); 
 		$('#geninformation').modal('hide');
 		$('#shiprate').html('$ 0.00');
 		$('#shipbutton').show();
		$('#showship').html('');
		$('#new_package').val(0) ;
		
 	});
 	
	$('.register, .apply-new-course').on('click','.show_ship_btn',function(event){
            event.preventDefault() 
		 
            $('#fixederror').hide();
            var usertype = $('#hidusertype').val();
		 
            var new_package = 0;
        
            if($('input[name="package_type"]:checked').val()=='Package'){
                if( $("input[name=course_p]").is(":checked")){
                    //$('input[name="course_bp"]:checked').data('courseweight')
                    if($('input[name="course_bp"]').length>0 && $('input[name="course_p"]:checked').attr('id')=='course_b'){
                        if( $("input[name=course_bp]").is(":checked")){
                        }else{
                            $('#fixederror').show();
                            $('#fixederror').html("Select at least one course") ;
                            return false;
                        }
                    }
                }else{
                    $('#fixederror').show();
                    $('#fixederror').html("Select package");
                    return false;
                }
            }else{
                if($("input[type=checkbox][name^=course]:checked").length==0 &&  !$("input[name=course_b]").is(":checked")){
                    $('#fixederror').show();
                    $('#fixederror').html("Select at least one course") ;
                    return false;
                }
            }
        
            // ajax function for listing

            //if(checkzip($('#s_zipcode').val()) == true || checkzip($('#b_zipcode').val()) == true){
            if(checkzip($('#s_zipcode').val()) == true){
                var weight = 0.0;
                try{
                    if($('#totalweight').val()!=0){
                        weight= Math.round((parseFloat(weight)+ parseFloat($('#totalweight').val()))*10)/10;
                    }
                    if($('#totalweightb').value!=0){
                        weight= Math.round((parseFloat(weight)+ parseFloat($('#totalweightb').val()))*10)/10;
                    }
                    if($('#subcourseweight').value!=0){
                        weight= Math.round((parseFloat(weight)+ parseFloat($('#subcourseweight').val()))*10)/10;
                    }
                    var cc= weight.toString();
                    var weight =  BRS(cc);
                }catch(err){
                    weight= parseFloat($('#weight').val());
                }
                  //alert(weight);

                $('#mygif').show();
                $('#mygif').html('<img src='+base_url+'images/spinner.gif>');
                var update_div  = 'showship';

                $.ajax({
                    type    : "POST",
                    url     :  base_url + "register_ajax/get_ship",
                    dataType: 'json',
                    data : {
                            s_address   : $('#s_address').val(),
                            s_city      : $('#s_city').val(),
                            s_zipcode   : $('#s_zipcode').val(),
                            s_state     : $('#s_state').val(),
                            s_country   : $('#s_country').val(),
                            s_phone     : $('#s_phone').val(),
                            weight      : weight,
                            view		:'bs'
                           },
                    cache: false, 
                    complete:function(resp_obj){	

                        var update_div  = '#showship';
                        if(resp_obj.responseText !='error'){
                            $(update_div).show();
                            $(update_div).html(resp_obj.responseText) ;
                            $('#shipbutton').hide();
                            $('#mygif').hide();
                        }else{
                            $('#shipbutton').show();
                            $('#mygif').hide();
                            $('#fixederror').show();
                            $('#fixederror').html("Recipient country requires a postal code served by FedEx");
                            $(update_div).hide();
                        }
                    }
                });

          // end ajax function
          }else{

                  $('#errordiv').show();

                  $('errordiv').html("Billing Zipcode must be 5 digits") ;
                  //$('b_zipcode').focus();
                  return false;


          }
		
		
		
		
		
	});
	$('.register, .apply-new-course').on('click','.show_ship_btn_broker',function(event){
                event.preventDefault() 
		 
		$('#fixederror').hide();
                    if(checkzip($('#s_zipcode').val()) == true){
		 	 
                        if($('input[name="package_type"]:checked').val()=='Package'){
		 	 	 
                            if( ! $("input[name=course_b]").is(":checked")){
                                $('#fixederror').show();
                                            $('#fixederror').html("Select package");
                                            return false;		        	
                            }
                        }else{
                            if($("input[type=checkbox][name^=course]:checked").length==0 &&  !$("input[name=course_b]").is(":checked")){
                                    $('#fixederror').show();
                                            $('#fixederror').html("Select at least one course") ;
                                            return false;
                            }
                        }
                        $('#mygif').show();
                        $('#mygif').html('<img src='+base_url+'images/spinner.gif>');
                        var update_div  =   'showship';
                        var url         =   base_url + "register_ajax/get_ship";
                        $.ajax({
                            type: "POST",
                            url:  base_url + "register_ajax/get_ship",
                            dataType: 'json',
                            data : {s_address:$('#s_address').val(),
                                        s_city:$('#s_city').val(),
                                        s_zipcode:$('#s_zipcode').val(),
                                        s_state:$('#s_state').val(),
                                        s_country:$('#s_country').val(),
                                        s_phone:$('#s_phone').val(),
                                        weight:$('#weight').val(),
                                        view :'bs'

                                   },
                            cache: false, 
                            complete:function(resp_obj){	

                                var update_div  =   '#showship';
                                                if(resp_obj.responseText !='error'){
                                                        $(update_div).show();
                                                        $(update_div).html(resp_obj.responseText) ;
                                                        $('#shipbutton').hide();
                                                        $('#mygif').hide();
                                                }else{
                                                        $('#shipbutton').show();
                                                        $('#mygif').hide();
                                                        $('#fixederror').show();
                                                        $('#fixederror').html("Recipient country requires a postal code served by FedEx");
                                                        $(update_div).hide();
                                                }	


                            }

                        });
			
                    }else{
		
			$('#errordiv').show();
		       
			$('errordiv').html("Billing Zipcode must be 5 digits") ;
			//$('b_zipcode').focus();
			return false;		
                    }
	});
	
	
	$('.register, .apply-new-course').on('click','#update_s_zipcode_btn',function(event){ 
		new_zipcode = $('#zipcode_correct').val();
	
		// return false if zipcode is null
		if(new_zipcode == ''){
			$('#zipcode_correct_error').html('please enter zip code.');
			return false;
		}
	       
		// return erron if zipcode length lesthan 5
		if(new_zipcode.length < 5 || new_zipcode.length > 5){
			$('#zipcode_correct_error').html('Zip code must have 5 digits');
			return false;
		}
                $('#zipcode').val(new_zipcode);
		// if everything ok then show shipping button
		$('#s_zipcode').val(new_zipcode);
		$('#showship').hide();
		$('#shipbutton').show();		 
		$('.register .show_ship_btn, .apply-new-course .show_ship_btn').trigger( "click" );
	});
	
	$('.register, .apply-new-course').on('click','input[name=shiprate_radios]:radio',function (event) { 				
            //unselect all
            if($(this).data('price-added') == 1){return false;}
            
            $('#fixederror').hide();             
            $('#shipid').val($(this).data('method'));
            $('#shipprice').val(0);
            if($('#price').val() !=0){
                $('#shipprice').val($(this).data('shiptate'));
                //var total = Math.round((parseFloat($(this).data('shiptate')) + parseFloat($('#price').val()) )*100)/100;
                var total = parseFloat($('#totalprice').val())+parseFloat($(this).data('shiptate'));
                
                $('#totalprice').val(total.toFixed(2));
                //$('carttotal').style.display   = "block";
                //$('cartcourseprice').innerHTML   = $('price').value;
                if($('#shipprice').val())					 
                    $('#shiprate').html('$'+parseFloat($('#shipprice').val()).toFixed(2));


                if($('#totalprice').val())
                //$('carttotalprice').innerHTML      = $('totalprice').value;
                $('#gridtotalprice').html('$'+$('#totalprice').val());

            }
            $(this).data('price-added', 1);
	});
	
    
    
    var wow = new WOW(
            {
                boxClass: 'wow', // animated element css class (default is wow)
                animateClass: 'animated', // animation css class (default is animated)
                offset: 100, // distance to the element when triggering the animation (default is 0)
                mobile: false        // trigger animations on mobile devices (true is default)
            }
    );
    wow.init();
       
    
    $('.loginbox').on('click','.loginlinks',function (event) {    	 
    	  if($(this).data('sec')=='login'){
    	  	 $(".login").hide();
    	  	 $(".lostpassword").show();
    	  }else{
    	  	 $(".login").show();
    	  	 $(".lostpassword").hide();
    	  }
    }); 
    
    loginform_validator = $("#loginform").validate({
    	 rules: {
    	},
		submitHandler: function(form) {			 
			plsWaitDiv('body', 'show');
			 $.ajax({ 
		        type: "POST",
		        url: base_url + "user/login",
		        dataType: 'json',
		        data : $(form).serialize(),
		        cache: false, 
		        complete:function(data){	
                                plsWaitDiv('body', 'hide');
		        	response =$.parseJSON(data.responseText);
		        	if(response.status=='success'){
		        		if(response.error_status=='profilepage'){
                                            window.location = base_url+'profile';
		        		}else if(response.error_status=='success'){
                                            window.location = base_url+'course/courselist';
		        		}else if(response.error_status=='trial_login_success'){
                                            window.location = base_url+'trial_account/profile';
		        		}
		        		
		        	}else{
		        		if(response.error_status=='login_unique_page'){
                                            $('#forcelogin').show();
		        		}else if(response.error_status=='trial_period_expired'){
                                            window.location = base_url+'trial_account/expired';
                                            return false;
		        		}
		        		if(response.msg){
                                            $('#login_error').html(response.msg).show();		        		
                                        }
		        	}
		                
		        }
		        
			}); 
	     }         
	});	
	
	forgotpasswod_validator = $("#forgot_password_form_adhi").validate({
            submitHandler: function(form) {
                $('#fgetpass_error').html('').hide();
                plsWaitDiv('body', 'show');
                $.ajax({ 
                    type: "POST",
                    url: base_url + "forgot-password",
                    dataType: 'json',
                    data : $(form).serialize(),
                    cache: false, 
                    complete:function(data){	
                            plsWaitDiv('body', 'hide');
                            response =$.parseJSON(data.responseText);

                            if(response.status=='success'){
                                    $('#forgot_email').val('');
                                    if(response.error_status=='profilepage'){
                                            window.location =base_url+'profile';
                                    }else{
                                            $('#fgetpass_error').removeClass( "alert-danger").addClass('alert-success');
                                            $('#fgetpass_error').show().html(response.msg);
                                    }

                            }else{		        		 
                                     $('#fgetpass_error').removeClass( "alert-success").addClass('alert-danger');
                                            $('#fgetpass_error').html(response.msg).show();		        		
                            }

                    }

                }); 
            }         
	});	
	$('#navbar').on('click','.adhilogin',function (event) {	
		event.preventDefault();			 
  		$('.loginbox').toggle('slow');
    });
	$('.loginbox').on('click','.clear',function (event) {		 
		/*$(".error").html('');
  		$(".error").removeClass("error");
                */
                $('#login-modal').modal('hide');
  		//$(".error").removeClass("error");
                
  		//$(".login").show();
    	//$(".lostpassword").hide();
  		//$('.loginbox').hide('slow');
    }); 
    
    $('#sltSearchRegion').on('change',function(event){
    	$sel = $(this).val();
    	 
    	var $secondChoice = $("#sltSearchSubregion");
		$secondChoice.empty();
		$secondChoice.append("<option value=''>Select</option>");
		$.each(content.R, function(index, value) {
			if(index ==$sel){
				$.each(value, function(index1, value1) {
				$secondChoice.append("<option value='"+value1.id+"'>" + value1.name + "</option>");
				});
			} chter_cnt
		}); 
    	getEventResponse();
    });
     $('#sltSearchSubregion').on('change',function(event){    	
    	getEventResponse();
    });
    $('#sltSearchCourse').on('change',function(event){
    	$sel = $(this).val();
    	 if (5 == $sel) {
        	$("#chter_cnt").show();
    	 } else 
    		$("#chter_cnt").hide() ;
    	 getEventResponse();
    });
     $('#sltSearchChp').on('change',function(event){    	
    	getEventResponse();
    });
    if($('#calendar').length > 0){
        getEventResponse();
    }
    
 
    $('.previous_step').on('click', function (){
        $('#registration-carousel').carousel('prev');
        set_reg_step_info($(this).prev('#step').val()-1);
        $("html, body").animate({ scrollTop: $('.page_head .part1').offset().top-82 }, "slow");
    })
    $('#txtLicencetype').on('change', function (){
        $('#update_course_div').html('');
        $('input[name=package_type]').prop('checked', false);       
        initializeRadio();
    })
    
    $('body').on('click', '.login-popup',function (event){
        event.preventDefault();
        loginform_validator.resetForm();
        forgotpasswod_validator.resetForm();
        $('#login_error').html('').hide();
        $(".login").show();
        $(".lostpassword").hide();
        $('#login-modal').modal();
    });
    
    $('#classess_view').on('click','.owl-item',function(event){
    	$('#course_details').modal({keyboard: true}) 
		$('#course_name_title').html($(this).find('.class-name').html());
		$('#course_location_title').html($(this).find('.class-details').data('location'));
		$('#course_time_title').html($(this).find('.cls_c_time').html());
		$('#course_time').html($(this).find('.cls_c_time').html());
		$('#course_image').attr('src',$(this).find('.img-responsive').attr('src'));
		$('#course_date_top').html($(this).find('.cls_c_date').html());		
		$('#course_location').html($(this).find('.class-details').data('location'));
		$('#course_subaddress').html($(this).find('.cls_c_address').html());		
		$('#course_subregion_description').html($(this).find('.cls_c_chapter').data('description'));
		$('#course_descp').html($(this).find('.cls_c_chapter').html());
	})
	 $('#blog_view').on('click','.owl-item',function(event){
    	window.location= $(this).find('.item').data('url')
	})
	var ct =0;
	 
	
	
	$('.counter').countTo({
	        speed: 3500
    });
   
	
	$(".staff_box").each(function() {
			var maxLength = 200;
			var this_box = $(this);
			var original = this_box.find('.staff_desc').html();
			var text = original;
		    if (text.length > maxLength) {
		        text = text.substr(0,maxLength-3) + "...";
		    }
			this_box.find('.staff_cnt').html(text);
			 
			 
	
			this_box.hover(function() {		 
				 
	  			 this_box.find('.staff_cnt').html(original);	  			 
	  			 this_box.css({'z-index':100});
	  			 
			}, function() {			 
				 
	  			 this_box.find('.staff_cnt').html(text);
	  			 this_box.css({'z-index':1});
	  			 
	  			 
			});
		}); 
		
 
	setTimeout(function(){ 
		var $grid =  $('.grid').masonry({
		  // set itemSelector so .grid-sizer is not used in layout
		  itemSelector: '.staff_box',
		  // use element for option
		  columnWidth: '.grid-sizer',
		  percentPosition: true,
		 
		});
    }, 1000);
	$('#strtexm').on('click',function(event){
		$('#hide_strt_btn').html('<img src="'+base_url+'images/spinner.gif">');
	    $("#poptry").val(1);
	    a = $("#hdnQuizNo").val();
	    b = $(this).data('quizid');
	    c = $(this).data('segfore');
            url = ($('#user_type').length > 0 && 'trial' == $('#user_type').val()) ? 'trial_quiz/quizrule/' : 'quiz/quizrule/';
	    $("#confirm_password_form_adhi").attr('action',base_url + url + b + "/" + c + "/" + a) ;
	    $("#confirm_password_form_adhi").submit()
	});
	$('.mark_as_watched').on('click',function(event){
		var videoid =  $(this).data('videoid');
		if(videoid==''){
			return;
		}
		$.ajax({
	        type: "POST",
	        url: base_url + "classroom/update_watched_list/",
	        dataType: 'json',
	        data : {video_id:videoid},
	        cache: false, 
	        success:function(data){	
	                  
	        },
	        complete: function(data) {
	        	if(data.responseText =="TRUE") {
	        		$("#mark-as-watched-label-" + videoid).html("Watched");
	        	}else{
	        		 $("#mark-as-watched-label-" + videoid).html("Mark as watched");
	        	}  
	        }       
		})
	});
 	$('#course').on('change',function(event){
 		var  courseId = $("#course").val();
 		if(courseId==''){
			return;
		}
		$.ajax({
	        type: "GET",
	        url: base_url + "classroom/load_chapters/" + courseId,	      
	        success:function(data){	                  
                  var $select = $('#chapter'); 
                  $select.find('option').remove();   
                  $select.append('<option value="0">--Select Chapter--</option>'); 
                  data1 =  jQuery.parseJSON(data); 
                  $.each(data1,function(key, value) 
				  {
					$select.append('<option value=' + value.id + '>' + value.name + '</option>');
				  });
	        }
	             
		})
 	});
	$('#chapter').on('change',function(event){
		courseId = $("#course").val();
	    chapterId = $("#chapter").val();
	    "" != courseId && "" != chapterId ? window.location.href = base_url + "classroom/view/" + courseId + "/" + chapterId : $("page_error").innerHTML = "Please select a course and a chapter."
	});
	$('#cancelpdconfirm').on('click',function(e){
		window.location =base_url+'course/courselist';
	})
  	$("#examconfirm_password_form_adhi").validate({
        rules: {                
            txt_password: {
                required: true,		
                minlength: 6,	       
            },
             
        },         
        submitHandler: function(form) {
        	//console.log(form)
            form.submit()
            
        }
    });
    $('#strtfinalexam').on('click',function(event){
		$('#hide_strt_btn').html('<img src="'+base_url+'images/spinner.gif">');
	    $("#poptry").val(1);	   
	    $("#rule_form_adhi").attr('action',base_url + "course/exam_rule/") ;	    
	    $("#rule_form_adhi").submit()
	});
        
        $('.apply-new-course').on('change','#s_state',function (event) {
            resetShippingButton();
        });
        
        $('.apply-new-course').on('blur','#s_zipcode',function (event) {
            if($('#apply_check_zipcode').val() != $(this).val()){
                resetShippingButton();
            }
            $('#apply_check_zipcode').val($(this).val());
        });
});

    
function getEventResponse(viewmode,gotodate){
	$('body').off('shown.bs.modal'); 
	loading_next_step(1,'show');
	$('#calendar').empty();
	$('#calendar').fullCalendar('destroy'); 
	$('#calendar').fullCalendar('render'); 
	 
	$('#calendar').fullCalendar({
		header: {
			left: 'prev',
			center: 'title',
			right: 'next', 
		},	
		fixedWeekCount:false,
		displayEventTime: false,
		
		editable: true,
		defaultDate: new Date(),
		columnFormat: {
                month: 'ddd',    // Monday, Wednesday, etc              
        },		
	    dayClick: function(date, jsEvent, view) {
	    	 
	    	$('.fc-widget-content').css('background-color', '#ffffff');
			$(this).css('background-color', '#ffbd33');		
			loading_next_step(1,'show');
			$.ajax({ 
		        type: "POST",
		        url: base_url + "schedule/getClassforDay",
		        dataType: 'json',
		        data : {date:date.format('YYYY-MM-DD'),
		        		 
	        			region:$('#sltSearchRegion').val(),
	        			subregion:$('#sltSearchSubregion').val(),
	        			course:$('#sltSearchCourse').val(),
	        			chp:$('#sltSearchChp').val()
        				},
		        cache: false,		        
		        complete:function(data){	
		        	loading_next_step(1,'hide');
		        	//console.log(data)			 
		        	data1 =  data.responseText; 
					if(data1){
					 	  $modal = $('<div class="modal " id="courselist"></div>');
			              $modal.html(data1)               
			              $('body').append($modal);
			              $modal.modal({keyboard: true});
			              $modal.show();
					 }
					 
							                
		        }
		        
			}); 

			 
	    },		 
		eventRender: function (event, element) {
	        $(element).addClass('clickThrough');
	        
	    },
		viewRender:function(view, element)
		{
			 
			//$("#loading").css("display","block");
			$("#calendar").fullCalendar('removeEvents');	
			var dateObj = view.start._d;
			var month = dateObj.getUTCMonth() + 1; //months from 1-12
			var day = dateObj.getUTCDate();
			var year = dateObj.getUTCFullYear();
			day = (day < 10)?"0" + String(day):String(day);
			month = (month < 10)?"0" + String(month):String(month);
			var whole_start_date = String(year) + "/" + String(month) + "/" + String(day);
			//console.log("whole_start_date " + whole_start_date)
		
		    var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
			if(width <=768){
				sw ='small';
			}else{
				sw ='large';
			}
			var dateObj = view.end._d;
			var month = dateObj.getUTCMonth() + 1; //months from 1-12
			var day = dateObj.getUTCDate();
			var year = dateObj.getUTCFullYear();
			day = (day < 10)?"0" + String(day):String(day);
			month = (month < 10)?"0" + String(month):String(month);
			var whole_end_date = String(year) + "/" + String(month) + "/" + String(day);	
			 
			 $.ajax({ 
		        type: "POST",
		        url: base_url + "schedule/get_classes",
		        dataType: 'json',
		        data : {s_date:whole_start_date,
		        		e_date:whole_end_date,
		        		region:$('#sltSearchRegion').val(),
		        		subregion:$('#sltSearchSubregion').val(),
		        		course:$('#sltSearchCourse').val(),
		        		chp:$('#sltSearchChp').val(),
		        		device:sw
		        		},
		        cache: false,		        
		        complete:function(data){	
		        	loading_next_step(1,'hide');				 
		        	data1 =  jQuery.parseJSON(data.responseText); 
					$("#calendar").fullCalendar('removeEvents')
					$("#calendar").fullCalendar('addEventSource',data1, true);	
					                
		        }
		        
			}); 

			
		},
	 	 
		eventAfterRender: function (event, element, view) {
	        
	        if (event.id==5) {	            
	            element.css('color', '#606060');
	        } else if (event.id==6) {	            
	            element.css('color', '#984da8');
	        } else if (event.id==7) {	             
	            element.css('color', '#F86868');
	        } else if (event.id==8) {	             
	            element.css('color', '#1c8407');
	        }else if (event.id==9) {	             
	            element.css('color', '#0962dc');
	        }else if (event.id==10) {	             
	            element.css('color', '#a60808');
	        }else if (event.id==11) {	             
	            element.css('color', '#1ba6ab');
	        }else if (event.id==12) {	             
	            element.css('color', '#9460aa');
	        }else if (event.id==15) {	             
	            element.css('color', '#0184a8');
	        }else if (event.id==16) {	             
	            element.css('color', '#5e7cbc');
	        }else{
	        	element.css('color', '#606060');
	        }
	    }, 
	}); 
	
	$('body').on('shown.bs.modal','#courselist', function (event) {
						 
	   var $active = $('#accordion .panel-collapse.in').prev().addClass('active');
		$active.find('a').append('<span class="faa-minus pull-right"></span>');
		$('#accordion .panel-heading').not($active).find('a').prepend('<span class="faa-plus pull-right"></span>');
		$('#accordion').on('show.bs.collapse', function (e)
		{
			$('#accordion .panel-heading.active').removeClass('active').find('span').toggleClass('faa-plus faa-minus');
			$(e.target).prev().addClass('active').find('span').toggleClass('faa-plus faa-minus');
		});
		$('#accordion').on('hide.bs.collapse', function (e)
		{
			$(e.target).prev().removeClass('active').find('span').removeClass('faa-minus').addClass('faa-plus');
		});
	}) ;
	$('body').on('hidden.bs.modal','#courselist', function (event) {		 
		 $('#courselist').remove();
	})
	
	
	
	  		
}
function set_reg_step_info(step){
    $('.reg-step-info > div').removeClass('active');
    $('.reg-step-info > div:nth-child('+step+')').addClass('active');
}
function loading_next_step(step, visibility){
    if('show' == visibility){
        //$('#registerform_step'+step)
        $('body').append('<div class="step_overlay">Please wait<span class="dots"><span>.</span><span>.</span><span>.</span></span></div>');
        
    }else{
        $('.step_overlay').remove();
    }
    
}
$(window).on('scroll',function(){
	/*if ($(window).scrollTop() > 400) {
		 $('nav').css("margin-top", 0)
		}
		else {
		 $('nav').css("margin-top", 30)
	}*/
  
   if(window_width > 980){
        rubik.checkScrollForParallax();
   }
   
   //rubik.checkScrollForTransparentNavbar();    
         
});

$(window).load(function(){
    
    //after the content is loaded we reinitialize all the waypoints for the animations
    rubik.initAnimationsCheck();
    
});  

//activate collapse right menu when the windows is resized 
$(window).resize(function(){
    if($(window).width() < 979){
        rubik.initRightMenu();   
    }
    if($(window).width() > 979 && !burger_menu){
        $('nav').removeClass('navbar-burger');
        rubik.misc.navbar_menu_visible = 1;
        navbar_initialized = false;
    }
    
    
});

$('a[data-scroll="true"]').click(function(e){         
    var scroll_target = $(this).data('id');
    var scroll_trigger = $(this).data('scroll');
    
    if(scroll_trigger == true && scroll_target !== undefined){
        e.preventDefault();
        
        $('html, body').animate({
             scrollTop: $(scroll_target).offset().top - 50
        }, 1000);
    }
                
});

    
rubik = {
    misc:{
        navbar_menu_visible: 0
    },
    initAnimationsCheck: function(){
        
        $('[class*="add-animation"]').each(function(){
           offset_diff = 30;
           if($(this).hasClass('title')){
               offset_diff = 110;
           }
           
           var waypoints = $(this).waypoint(function(direction) {
                if(direction == 'down'){
                        $(this.element).addClass('animate');    
                   } else {
                       $(this.element).removeClass('animate');
                   }
                }, {
                  offset: window_height - offset_diff
           });
        });
  
    },
    initRightMenu: function(){  
         if(!navbar_initialized){
            $nav = $('nav');
            $nav.addClass('navbar-burger');
             
            $navbar = $nav.find('.navbar-collapse').first().clone(true);
            $navbar.css('min-height', window.screen.height);
              
            ul_content = '';
             
            $navbar.children('ul').each(function(){
                content_buff = $(this).html();
                ul_content = ul_content + content_buff;   
            });
             
            ul_content = '<ul class="nav navbar-nav">' + ul_content + '</ul>';
            $navbar.html(ul_content);
             
            $('body').append($navbar);
                            
            background_image = $navbar.data('nav-image');
            if(background_image != undefined){
                $navbar.css('background',"url('" + background_image + "')")
                       .removeAttr('data-nav-image')
                       .css('background-size',"cover")
                       .addClass('has-image');                
            }
             
            $toggle = $('.navbar-toggle');
             
            $navbar.find('a').removeClass('btn btn-round btn-default');
            $navbar.find('button').removeClass('btn-round btn-fill btn-info btn-primary btn-success btn-danger btn-warning btn-neutral');
            $navbar.find('button').addClass('btn-simple btn-block');

            $link = $navbar.find('a');
            
            $link.click(function(e){
                var scroll_target = $(this).data('id');
                var scroll_trigger = $(this).data('scroll');
                
                if(scroll_trigger == true && scroll_target !== undefined){
                    e.preventDefault();

                    $('html, body').animate({
                         scrollTop: $(scroll_target).offset().top - 50
                    }, 1000);
                }
                
             });

            
            $toggle.click(function (){    

                if(rubik.misc.navbar_menu_visible == 1) {                    
                    $('html').removeClass('nav-open'); 
                    rubik.misc.navbar_menu_visible = 0;
                    $('#bodyClick').remove();
                     setTimeout(function(){
                        $toggle.removeClass('toggled');
                     }, 550);
                
                } else {
                    setTimeout(function(){
                        $toggle.addClass('toggled');
                    }, 580);
                    
                    div = '<div id="bodyClick"></div>';
                    $(div).appendTo("body").click(function() {
                        $('html').removeClass('nav-open');
                        rubik.misc.navbar_menu_visible = 0;
                        $('#bodyClick').remove();
                         setTimeout(function(){
                            $toggle.removeClass('toggled');
                         }, 550);
                    });
                   
                    $('html').addClass('nav-open');
                    rubik.misc.navbar_menu_visible = 1;
                    
                }
            });
            navbar_initialized = true;
        }
   
    },

    checkResponsiveImage: function(){
        $('.section-header > div > img, .section-header video').each(function(){
            var $image = $(this);
            var src = $image.attr("responsive-src");
    
            if(!src){
               src = $image.attr('src'); 
            }
    
            div = '<div class="responsive-background" style="background-image:url(' + src + ')"/>';
            $image.after(div);
            $image.addClass('hidden-xs'); 
        });
    },  
    
    checkScrollForTransparentNavbar: debounce(function() {	
        	if($(document).scrollTop() > 560 ) {
                if(transparent) {
                    transparent = false;
                    $('nav[role="navigation"]').removeClass('navbar-transparent');
                }
            } else {
                if( !transparent ) {
                    transparent = true;
                    $('nav[role="navigation"]').addClass('navbar-transparent');
                }
            }
    }, 17),
    
    checkScrollForParallax: debounce(function() {	

        	no_of_elements = 0;
        	$('.parallax').each(function() {
        	    var $elem = $(this);
        	    
        	    if(isElementInViewport($elem)){
                  var parent_top = $elem.offset().top;          
                  var window_bottom = $(window).scrollTop();
                  var $image = $elem.find('img')
                              	  
            	  oVal = ((window_bottom - parent_top) / 3);
                  $image.css('transform','translate3d(0px, ' + oVal + 'px, 0px)');    
        	    }
            });
    		
    }, 6),
    
    checkScrollForContentTransitions: debounce(function() {
         $('.content-with-opacity').each(function() {
             var $content = $(this);
             
             if(isElementInViewport($content)){          
                  var window_top = $(window).scrollTop();
            	  opacityVal = 1 - (window_top / 230);
                  
                  if(opacityVal < 0){
                      opacityVal = 0;
                      return;
                  } else {
                    $content.css('opacity',opacityVal);    
                  }
                      
        	    }            
         });
    }, 6),
    
    showModal: function(button){
        var id = $(button).data('target');
        var $project = $(button).closest('.project');
        
        var scrollTop = $(window).scrollTop();
        var distanceTop = $project.offset().top;

        var projectTop = distanceTop - scrollTop; 
        var projectLeft = $project.offset().left;
        var projectHeight = $project.innerHeight();
        var projectWidth = $project.innerWidth();

        modal = $('#' + id);

        $(modal).css({
         'top'  :    projectTop,
         'left' :    projectLeft, 
         'width' :   projectWidth,
         'height' :  projectHeight,
         'z-index'  : '1032'
        });
        
        $(modal).addClass('has-background');
        
        setTimeout(function(){
           $(modal).addClass('open');
        },30);

        setTimeout(function(){
           $('body').addClass('noscroll');
           $(modal).addClass('scroll');
        },1000);
    
        $('.icon-close').click(function(){
          $project_content = $(this).closest('.project-content');
          $project_content.removeClass('open scroll');
          
          $('body').removeClass("noscroll");
          //$('a').removeClass('no-opacity');
            setTimeout(function(){
                $project_content.removeClass('has-background');
                setTimeout(function(){    
                    $project_content.removeAttr('style');     
                }, 450); 
            },500);
        });
    },
    
    initGoogleMaps: function(){
        var myLatlng = new google.maps.LatLng(44.433530, 26.093928);
        
        
                
        
        var mapOptions = {
          zoom: 14,
          center: myLatlng,
          scrollwheel: false, //we disable de scroll over the map, it is a really annoing when you scroll through page
          disableDefaultUI: true,
          styles: [{"featureType":"administrative","elementType":"labels","stylers":[{"visibility":"on"},{"gamma":"1.82"}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"visibility":"on"},{"gamma":"1.96"},{"lightness":"-9"}]},{"featureType":"administrative","elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"all","stylers":[{"visibility":"on"},{"lightness":"25"},{"gamma":"1.00"},{"saturation":"-100"}]},{"featureType":"poi.business","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"hue":"#ffaa00"},{"saturation":"-43"},{"visibility":"on"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"labels","stylers":[{"visibility":"simplified"},{"hue":"#ffaa00"},{"saturation":"-70"}]},{"featureType":"road.highway.controlled_access","elementType":"labels","stylers":[{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"all","stylers":[{"visibility":"on"},{"saturation":"-100"},{"lightness":"30"}]},{"featureType":"road.local","elementType":"all","stylers":[{"saturation":"-100"},{"lightness":"40"},{"visibility":"off"}]},{"featureType":"transit.station.airport","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"gamma":"0.80"}]},{"featureType":"water","elementType":"all","stylers":[{"visibility":"off"}]}]
        }
        var map = new google.maps.Map(document.getElementById("contactUsMap"), mapOptions);
        
        var marker = new google.maps.Marker({
            position: myLatlng,
            title:"Hello World!"
        });
        
        // To add the marker to the map, call setMap();
        marker.setMap(map);
    }

}

function show_courses(coursetype,paymenttype){	
	$('#update_course_div').html('<center><img src="'+base_url+'images/spinner.gif"/></center>');
	
	var licensetype = $('#txtLicencetype').val();
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
    if(usertype==2 || usertype==4 || usertype==6 || usertype==8) $('crs_list_heading').show();
    else $('#crs_list_heading').hide();
    $('#hidusertype').val(usertype);

	//var params = "licensetype="+licensetype+"&coursetype="+coursetype+"&paymentype="+paymenttype;

	 $.ajax({
        type: "POST",
        url: base_url + "register_ajax/get_courses",
        dataType: 'json',
        data : {licensetype:licensetype,coursetype:coursetype,paymentype:paymenttype},
        cache: false, 
        complete:function(data){	
        	$('#update_course_div').html(data.responseText);
                
        }
        
	});
}
// Returns a function, that, as long as it continues to be invoked, will not
// be triggered. The function will be called after it stops being called for
// N milliseconds. If `immediate` is passed, trigger the function on the
// leading edge, instead of the trailing.

function debounce(func, wait, immediate) {
	var timeout;
	return function() {
		var context = this, args = arguments;
		clearTimeout(timeout);
		timeout = setTimeout(function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		}, wait);
		if (immediate && !timeout) func.apply(context, args);
	};
};


function isElementInViewport(elem) {
    var $elem = $(elem);

    // Get the scroll position of the page.
    var scrollElem = ((navigator.userAgent.toLowerCase().indexOf('webkit') != -1) ? 'body' : 'html');
    var viewportTop = $(scrollElem).scrollTop();
    var viewportBottom = viewportTop + $(window).height();

    // Get the position of the element on the page.
    var elemTop = Math.round( $elem.offset().top );
    var elemBottom = elemTop + $elem.height();

    return ((elemTop < viewportBottom) && (elemBottom > viewportTop));
}

function is_valid_email(value){
    return /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(value);
}
//youtube video api

function initYoutubeVideo(){
    if(once_played){
        onYouTubeIframeAPIReady();
    }else{
	// 2. This code loads the IFrame Player API code asynchronously.
	var tag = document.createElement('script');
	
	tag.src = "https://www.youtube.com/iframe_api";
	var firstScriptTag = document.getElementsByTagName('script')[0];
	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    }
}
function populate_certificate_name(){
	var firstname = $('#firstname').val();
	var lastname = $('#lastname').val();
	$('#name_on_certificate').val(firstname+' '+lastname) ;
}
// 3. This function creates an <iframe> (and YouTube player)
//    after the API code downloads.
var player;
function onYouTubeIframeAPIReady() {    
    player = new YT.Player('youtube_vid', {
        height: '220',
        width: '320',
        videoId: $('#yt_video_id').val(),
        playerVars: {
            //controls: 0,
            showinfo: 0 ,
            modestbranding: 1,
            wmode: "opaque",
            html5: 1
        },
        events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
        }
    });
}

// 4. The API will call this function when the video player is ready.
function onPlayerReady(event) {
	//event.target.playVideo();
}

// 5. The API calls this function when the player's state changes.
//    The function indicates that when playing a video (state=1),
//    the player should play for six seconds and then stop.
var done = false;
function onPlayerStateChange(event) {
	/*if (event.data == YT.PlayerState.PLAYING && !done) {
	  setTimeout(stopVideo, 6000);
	  done = true;
	}*/
}
function stopVideo() {
	player.stopVideo();
}

function get_youtube_id(url){	 
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
    var match = url.match(regExp);
    if (match&&match[7].length==11){        
        return match[7];
    }
}
 function checkrate1(){	 
 	if($('#showship').css('display') =="block"){
			$('#shipbutton').hide();
			$('#shipprice').val(0);// = 0;
			$('#totalprice').val(0);// = 0;
			$('#shipamount').html( $('shipprice').val());
			$('#totalamount').html('$'+$('totalprice').val());
			$('#showship').hide() ;
	}
}
function checkzip(z){
	if(z.length != 5){
		return false;
	}else{
		return true;
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
var once_played = false;
var BrowserDetect = {
    init: function () {
        this.browser = this.searchString(this.dataBrowser) || "Other";
        this.version = this.searchVersion(navigator.userAgent) || this.searchVersion(navigator.appVersion) || "Unknown";
    },
    searchString: function (data) {
        for (var i = 0; i < data.length; i++) {
            var dataString = data[i].string;
            this.versionSearchString = data[i].subString;

            if (dataString.indexOf(data[i].subString) !== -1) {
                return data[i].identity;
            }
        }
    },
    searchVersion: function (dataString) {
        var index = dataString.indexOf(this.versionSearchString);
        if (index === -1) {
            return;
        }

        var rv = dataString.indexOf("rv:");
        if (this.versionSearchString === "Trident" && rv !== -1) {
            return parseFloat(dataString.substring(rv + 3));
        } else {
            return parseFloat(dataString.substring(index + this.versionSearchString.length + 1));
        }
    },

    dataBrowser: [
        {string: navigator.userAgent, subString: "Chrome", identity: "Chrome"},
        {string: navigator.userAgent, subString: "MSIE", identity: "Explorer"},
        {string: navigator.userAgent, subString: "Trident", identity: "Explorer"},
        {string: navigator.userAgent, subString: "Firefox", identity: "Firefox"},
        {string: navigator.userAgent, subString: "Safari", identity: "Safari"},
        {string: navigator.userAgent, subString: "Opera", identity: "Opera"}
    ]

};

var better_browser = '<div class="container"><div class="better-browser row"><div class="col-md-2"></div><div class="col-md-8"><h3>We are sorry but it looks like your Browser doesn\'t support our website Features. In order to get the full experience please download a new version of your favourite browser.</h3></div><div class="col-md-2"></div><br><div class="col-md-4"><a href="https://www.mozilla.org/ro/firefox/new/" class="btn btn-warning">Mozilla</a><br></div><div class="col-md-4"><a href="https://www.google.com/chrome/browser/desktop/index.html" class="btn ">Chrome</a><br></div><div class="col-md-4"><a href="http://windows.microsoft.com/en-us/internet-explorer/ie-11-worldwide-languages" class="btn">Internet Explorer</a><br></div><br><br><h4>Thank you!</h4></div></div>';

var $panels = $('.panel');

$('#search_faq').on('keyup', function() {
    var val = this.value.toLowerCase();

    $panels.show().filter(function() {
        var panelTitleText = $(this).find('.panel-title').text().toLowerCase();
        var panelText = $(this).find('.panel-body').text().toLowerCase();
        return (panelTitleText.indexOf(val) < 0 && panelText.indexOf(val) < 0) ;
    }).hide();
});

$('body').on('keyup', '.numbers_only', function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    }
});

$('textarea.expand').focus(function(){
    $(this).animate({height:'80px'}, 500);
});

$('textarea.expand').blur(function(){
    $(this).animate({height:'44px'}, 500);
});

function checkRadio(input_name, id, agreeid){
    $('#geninformation input[type="checkbox"]').prop( "checked", false);
    if('course_p' == input_name && package_radio_id == id){
        //var var_name = 'package_radio_id';
         $('#geninformation #'+agreeid).prop( "checked", true);
    }else if(('course_bp' == input_name || 'course_b' == input_name) && package_option_radio_id == id){
        var var_name = 'package_option_radio_id';
        $('#geninformation #'+agreeid).prop( "checked", true);
    }    
}
function checkCheckbox(id, agreeid){
    $('#geninformation input[type="checkbox"]').prop( "checked", false);
    if(cart_checkbox_ids.indexOf(id) >= 0){
        $('#geninformation #'+agreeid).prop( "checked", true);
    }
}
function initializeRadio(){
    package_radio_id        = '';
    package_option_radio_id = '';
    cart_checkbox_ids       = [];
}
function popCartCheckboxId(id){
    if(cart_checkbox_ids.indexOf(id) >= 0){
        cart_checkbox_ids.splice(cart_checkbox_ids.indexOf(id), 1);
    }
}
function changeAgreeInuptId(id){
    if('iagree' == id){
        $('#geninformation #iagree_cart').attr('id', 'iagree');
        $('#geninformation #inoagree_cart').attr('id', 'inoagree');
        $('#geninformation label[for="iagree_cart"]').attr('for', 'iagree');
        $('#geninformation label[for="inoagree_cart"]').attr('for', 'inoagree');
    }else{
        $('#geninformation #iagree').attr('id', 'iagree_cart');
        $('#geninformation #inoagree').attr('id', 'inoagree_cart');
        $('#geninformation label[for="iagree"]').attr('for', 'iagree_cart');
        $('#geninformation label[for="inoagree"]').attr('for', 'inoagree_cart');
    }
}

/* For testing purpose */
function fillReg(){
    $('#firstname').val('Rahul');
    $('#lastname').val('PK');
    $('#email').val('rahul'+Math.round(Math.random() * 1000)+'@dispostable.com');
    $('#psword').val('rain123');
    $('#psword1').val('rain123');
    $('#phone').val('9999999999');
    $('#confirm_name_id, #confirm_email_id').prop('checked', true);
    
    $('#txtLicencetype').val('S');
    $('#txthowhear').val('Friend');
    $('#address').val('New Address');
    $('#unitnumber').val('8989');
    $('#city').val('New City');
    $('#zipcode').val('90005');
    $('#setaddr').trigger('click');
    $('#registerform_step1').submit();
    
}


function resetShipping(){
    if($('#shipid').length > 0){
        if(parseFloat($('#totalprice').val()) > 0){
            var newtotal    = parseFloat($('#totalprice').val()) - parseFloat($('#shipprice').val());
            $('#totalprice').val(newtotal);
            $('#gridtotalprice').html('$'+newtotal);
        }
        $('#shipprice').val(0);
        $('#shiprate').html('$ 0.00');
        $('#shipbutton').show();
        $('#showship').html('');
    }
}
function plsWaitDiv(selector, visibility){    
    var overlay_id = selector.replace(/[\. \#]/g, "")+'_overlay';
    if('show' == visibility){
        $(selector).css('position', 'relative');
        $(selector).append('<div id="'+overlay_id+'" class="plswait_overlay">Please wait<span class="dots"><span>.</span><span>.</span><span>.</span></span></div>');
    }else{
        $(selector).css('position', 'static');
        $('#'+overlay_id).remove();
    }
}
function load_courses(){
        var jsonArrassy = $('#hidJson').val();
        carr = eval('('+jsonArrassy+')');

        for(var i=0; i<carr.length; i++){
                //alert(carr[i]['course_id']);
                carr["'"+carr[i]['course_id']+"'"] 	= new Array();
                carr["'"+carr[i]['course_id']+"'"][0]	= carr[i]['course_name'];
                carr["'"+carr[i]['course_id']+"'"][1]	= carr[i]['amount'];
        }
}

function resetShippingButton(){
    /* Calculating grand total */
    checklength = $('input[name="course[]"]:checked').length;
    g_total = 0;
    g_weight = 0;
    if(checklength > 1){
        $('input[name="course[]"]:checked').each(function(c) {
           g_total += parseFloat($(this).data('price'));
           g_weight += parseFloat($(this).data('courseweight'));
        });
    }else if(checklength > 0){
      g_total = parseFloat($('input[name="course[]"]:checked').data('price'));
      g_weight = parseFloat($('input[name="course[]"]:checked').data('courseweight'));
    }
    if($('input[name="course_b"]:checked').length > 0){
        g_total += parseFloat($('input[name="course_b"]:checked').data('price'));
        g_weight += parseFloat($('input[name="course_b"]:checked').data('courseweight'));
    }

    $('#shipprice').val(0);
    $('#totalprice').val(g_total);
    $('#gridtotalprice').html('$'+g_total.toFixed(2)); 

    $('#totalweight').val(g_weight);

    $('#hidwt').val(parseFloat($("#totalweight").val()));
    $('#shiprate').html('$0.00');
    $('#shipbutton').show();
    $('#showship').html('');
}
function triggerUserLogin(){
    $('.login-popup').trigger('click');
}