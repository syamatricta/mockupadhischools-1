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
});
var guest_agreement_checked = false;
setTimeout(function(){
  if ($('#login_continue_msg').length > 0) {
      $('#login_continue_msg').slideUp("slow", function() { 
        $('#login_continue_msg').remove();
      });
  }
}, 7000)


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
