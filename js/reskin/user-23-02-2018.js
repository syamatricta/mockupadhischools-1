$(document).ready(function() {
    $.fn.preload = function() {
        this.each(function(){
            $('<img/>')[0].src = this;
        });
    }
    
    $("#change_password").validate({
        rules: {
            old_password: {
                required: true,		
                minlength: 6,	       
            },
            new_password: {		
              required: true,
              minlength: 6,
            },
            confirm_password: {		
              required: true,
              minlength: 6,         
              equalTo: "#new_password",
            }
        },
        submitHandler: function(form) {
           form.submit();
        }
    });
    
    $("#renewcourse").validate({
        rules: {
            b_zipcode: {
                required: true,
                zipcodeUS: true
            },
            ccno: {		
                required: true,			     
                creditcard: true			      
            },

        },
        submitHandler: function(form) {
            form.submit();
        }
    });
    
    $("#apply_new_course").validate({
        rules: {
             zipcode: {
                required: true,
                zipcodeUS: true
              },
              b_zipcode: {
                required: true,
                zipcodeUS: true
              },
              ccno: {		
                    required: true,			     
                    creditcard: true			      
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

            form.submit();
        }
    });
    
    
    
    $('.download_supplement_btn').on('click', function (){
        var sel_box = $(this).attr('data-courseid');
        window.location = base_url+'course/download/'+$('#sel_supplement'+sel_box).val();
    });
    //initOurPrinciples();3
    hoverPrinciple();
    //$('#process-wrapper area').tooltip({title : 'Click to view'});
    $('#process-wrapper area').hover(
        function (){
            var img = $(this).parent().parent().find('img');
            img.attr('src', base_url+'images/reskin/licensing_process/'+img.data('imagename')+'-hover.png');            
        },
        function (){
            var img = $(this).parent().parent().find('img');
            img.attr('src', base_url+'images/reskin/licensing_process/'+img.data('imagename')+'.png');
        }
    );
    
    $('#process-wrapper area').popover();
    
    $('#process-wrapper area').on('click', function (e) {
        $('#process-wrapper area').not(this).popover('hide');
        
    });
    
    
    
    $("#form_edit_profile").validate({
        rules: {
            email: {
                required: true,
                email: false,
                customemail: true
            },
            phone: {
                required: true,
                phoneUS: true,
                digits: true
            },
            zipcode: {
                required: true,
                zipcodeUS: true
            },
            b_zipcode: {
                required: true,
                zipcodeUS: true
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
    
    $('.go_to_url').on('click',function (e){
        e.preventDefault();
        console.log($(this).data('url'));
        window.location = $(this).data('url');
    });
    
    $("#trial_registration_form").validate({
            rules: {
                email: {
                    required: true,
                    email: false,
                    customemail: true
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
                },
                phone: {
                    required: true,
                    phoneUS: true,
                    digits: true
                },
                terms: {
                    required: true
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "confirm_email" || element.attr("name") == "terms") {
                    $('#'+element.attr("name")+'_id').parent('div').after(error);
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                plsWaitDiv('body', 'show');
                url = base_url+'trial_account/ajax_register';
                $.ajax({
                    type    : "POST",
                    url     : url,
                    dataType: "json",
                    data    : $("#trial_registration_form").serialize(), // serializes the form's elements.
                    success : function(data){
                        plsWaitDiv('body', 'hide');
                        if(data.proceed){
                            $('#trial_registraion_message_slide').html(data.page_view);
                            $('#errordiv').html('').hide();
                            $('#trial-registration-carousel').carousel('next');
                            $("html, body").animate({ scrollTop: $('.page_head .part1').offset().top-90 }, "slow");                
                        }else{
                            $('#errordiv').html(data.errors).show();
                        }
                    }
                });

            }
        });
        $('#trial_registration_form').on('click','#terms_id',function (event) {	
		event.preventDefault();
                $('#guest_agreement').modal();
                $('#iagree_guest_terms, #inoagree_guest_terms').prop('checked',false);
                if(guest_agreement_checked){
                    $('#iagree_guest_terms').prop('checked',true);
                }
	});
        $('#guest_agreement').on('click','#iagree_guest_terms',function(){ 	
            $('#guest_agreement').modal('hide');
            $('#terms_id').prop('checked',true);
            guest_agreement_checked = true;
        });
        $('#guest_agreement').on('click','#inoagree_guest_terms',function(){ 	
            $('#guest_agreement').modal('hide');
            $('#terms_id').prop('checked',false);
            guest_agreement_checked = false;
        });
	
       $('.guest_pass_popup').on('click', function (){
           guestPassPopup();
       });
       
       $('#profile_progress_bar').on('click', '.profile-progress-bar li.active', function (){
            var elm_id  = $(this).attr('id');
            if('obtained_license' == elm_id){
                var confirm_msg     = 'Are you with a broker yet?';
                var confirm_label   = 'YES';
                var cancel_label    = 'NO';
            }else{
                var confirm_msg = 'Are you sure?';
                var confirm_label   = 'OK';
                var cancel_label    = 'Cancel';
            }
            var broker_name = '';
            bootbox.confirm({
                size    : 'small',
                message : confirm_msg, 
                buttons: {
                    cancel: {
                        label: cancel_label,
                        className: "btn-adhi"
                    },
                    confirm: {
                        label: confirm_label,
                        className: "btn-adhi"
                    }
                },
                callback: function(result){                    
                    $('.bootbox .btn').removeClass('btn btn-default btn-primary').addClass('btn-adhi');
                    if(result){
                        if('obtained_license' == elm_id){
                            bootbox.prompt({
                                title : 'Which broker you are working with?',
                                buttons: {
                                    cancel: {
                                        label: 'Cancel',
                                        className: "btn-adhi"
                                    },
                                    confirm: {
                                        label: 'Submit',
                                        className: "btn-adhi"
                                    }
                                },
                                callback: function(broker_name) {
                                    if(null == broker_name){                                        
                                        broker_name = '';
                                    }else{
                                        sendProfileProgress(elm_id, broker_name);
                                    }
                                    $('#'+elm_id).removeClass('hover');                                    
                                }
                            }).on("shown.bs.modal", function() {
                                $('.bootbox .btn').removeClass('btn btn-default btn-primary').addClass('btn-adhi');
                            }).on("hidden.bs.modal", function(e) {
                                plsWaitDiv('body', 'hide');
                            });
                        }else{
                            $('#'+elm_id).removeClass('hover');
                            sendProfileProgress(elm_id, broker_name);
                        }
                    }else{
                        $('#'+elm_id).removeClass('hover');
                    }
                }
            }).init(function (){
                $('#'+elm_id).addClass('hover');
                $('.bootbox .btn').removeClass('btn');
            });
       });
       
        $('.p_hover a').click(function (e){
            e.stopPropagation();
        });
        $('ul.profile-progress-bar li.status').hover(
            function() {
                $(this).prevAll('li').addClass('temp_visit');
            }, function() {
                $(this).prevAll('li').removeClass('temp_visit');
            }
        );
        $('#career_event_strip').on('click',  function (e){
            e.preventDefault();
            if('close_strip' == e.target.id){
                return false;
            }
            window.location = $(this).attr('href');
            
        })
        $('#career_event_strip i').on('click', function (e){
            e.preventDefault();
            $('#career_event_strip').remove();
            $('.menu_after_strip').removeClass('menu_after_strip');
            setCookie('event_strip', 1, 1);
        });
        showEventStrip();
});

function showMessage(selector, type, message){
    if('success' == type ){
        $(selector).removeClass('hidden alert-danger alert-info alert-warning').addClass('alert-success').text(message).show();
    }else if('info' == type){
        $(selector).removeClass('hidden alert-danger alert-info alert-warning').addClass('alert-info').text(message).show();
    }else if('error' == type){
        $(selector).removeClass('hidden alert-success alert-info alert-warning').addClass('alert-danger').text(message).show();
    }
}
var guest_agreement_checked = false;
setTimeout(function(){
  if ($('#login_continue_msg').length > 0) {
      $('#login_continue_msg').slideUp("slow", function() { 
        $('#login_continue_msg').remove();
      });
  }
}, 7000)

function sendProfileProgress(item_name, broker_name, overlay){
    $('#message_box').hide();
    plsWaitDiv('body', 'show');
    url = base_url+'course/update_progress';
    $.ajax({
        type    : 'POST',
        url     :  url,
        dataType: 'json',
        data    : {item : item_name, 'broker_name' : broker_name}, // serializes the form's elements.
        success : function(data){
            plsWaitDiv('body', 'hide');
            if('success' == data.type){
               $('#'+item_name).removeClass('active').addClass('visited');
               if('state_exam_applied' == item_name){
                   $('#obtained_license').addClass('active');
               }
               showMessage('#message_box', data.type, data.message);
            }else{
                showMessage('#message_box', data.type, data.message);
            }
            $('#message_box').delay(3000).hide(500);
        }
    });
}


setTimeout(function(){
  if ($('#flashdata_msg').length > 0) {
      $('#flashdata_msg').slideUp("slow", function() { 
        $('#flashdata_msg').remove();
      });
  }
}, 15000);

function hoverPrinciple(){
    $('.principle').hover(
        function (){
            $('.principle:not(#'+$(this).attr('id')+')').fadeTo(300, 0.5);            
        },
        function (){
            $('.principle').css('opacity', 1);
        }
    );
}
function initOurPrinciples(){
    var imgs    = [];
    for(var i = 1;i < number_count; i++){
        imgs.push(base_url+'images/reskin/faces/'+i+'.jpg');
    }
    $(imgs).preload();    
    initFacesAnimation();
}
var left_arr, right_arr;
var number_count = 26;
function initFacesAnimation(){
    left_arr   = [];
    $('.faces-grid.left  > img').each(function (){
        left_arr.push($(this).data('id'));
    });
    
    right_arr   = [];
    $('.faces-grid.right  > img').each(function (){
        right_arr.push($(this).data('id'));
    });
    setInterval(setIntervalfaceChange, 3000);
    
}
function setIntervalfaceChange(){
    faceChangeRandomly('left');
    setTimeout(function (){
        faceChangeRandomly('right');
    }, 3000);
    
}
function faceChangeRandomly(type){
    var pickId  = Math.ceil(Math.random()* number_count);
    var putId   = Math.ceil(Math.random()* number_count);
    var pickImg = $('.faces-grid.'+type+'  > img[data-id='+pickId+']');
    $(pickImg).fadeTo('fast', 0.3, function() {
        $(pickImg).attr("src", base_url+'images/reskin/faces/'+putId+'.jpg');
        $(pickImg).fadeTo('slow', 0.5);
    });
}

function guestPassPopup(){
    $('#popup-guestpass').modal();
}
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function showEventStrip() {
    var strip = getCookie("event_strip_687");
    if (strip != "") {
        $('#career_event_strip').hide();
        $('.navbar-ext').removeClass('menu_after_strip');
    }else{
        $('#career_event_strip').show();
        $('.navbar-ext').addClass('menu_after_strip');
    }
}

function regenerate_home_captcha(div_to_update){
    
    var url             =   base_url + "user_ajax/regenerate_home_captcha";
    $.ajax({
        type    : "POST",
        url     : url,
        success : function(data){
            $('#'+div_to_update).html(data);
        },
        error:function(data){
            $('#'+div_to_update).html(data);
        }
    });
}