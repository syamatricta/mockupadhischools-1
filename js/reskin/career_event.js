$(document).ready(function(){
    $('#sltEventSearchRegion').on('change',function(event){
    	$sel = $(this).val();
    	 
    	var $secondChoice = $("#sltEventSearchSubregion");
		$secondChoice.empty();
		$secondChoice.append("<option value=''>Select</option>");
		$.each(content.R, function(index, value) {
			if(index ==$sel){
				$.each(value, function(index1, value1) {
				$secondChoice.append("<option value='"+value1.id+"'>" + value1.name + "</option>");
				});
			} 
		}); 
    	getCareerEventResponse();
    });
     $('#sltEventSearchSubregion').on('change',function(event){    	
    	getCareerEventResponse();
    });
    $('#sltEventSearchCourse').on('change',function(event){
    	$sel = $(this).val();
    	 if (5 == $sel) {
        	$("#chter_cnt").show();
    	 } else 
    		$("#chter_cnt").hide() ;
    	 getCareerEventResponse();
    });
     $('#sltEventSearchChp').on('change',function(event){    	
    	getCareerEventResponse();
    });
    if($('#event_calendar').length > 0){
        getCareerEventResponse();
    }
        
    
});
$(document.body).on('click', '.career_event_booking_btn', function(){
    $(".event_booking_form").each(function (){
         $(this).validate({
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
                }
            },
            submitHandler: function(form, event) {
                var id = $(form).data('id');
                event.preventDefault();
                plsWaitDiv('#accordion', 'show');
                var url = base_url+'career_event/book_event';
                $.ajax({
                    type    : 'POST',
                    url     : url,
                    dataType: 'json',
                    data    : $('#event_booking_form_'+id).serialize(), // serializes the form's elements.
                    success : function(data){
                        plsWaitDiv('#accordion', 'hide');
                        if('success' == data.type){ 
                            $('#message_div_'+id).removeClass('hidden alert-danger alert-success').addClass('alert-success').html(data.message).show().delay(5000).fadeOut('slow');
                            $('#event_booking_form_'+id).trigger('reset');
                        }else{
                            $('#message_div_'+id).removeClass('hidden alert-danger alert-success').addClass('alert-danger').html(data.message).show();
                        }
                    }
                });
                return false;
            }
        });
    });
    
});
function getCareerEventResponse(viewmode,gotodate){
	$('body').off('shown.bs.modal'); 
	loading_next_step(1,'show');
	$('#event_calendar').empty();
	$('#event_calendar').fullCalendar('destroy'); 
	$('#event_calendar').fullCalendar('render'); 
	 
	$('#event_calendar').fullCalendar({
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
                        url: base_url + "career_event/getClassforDay",
                        dataType: 'json',
                        data :  {
                                    date        : date.format('YYYY-MM-DD'),
                                    region      : $('#sltEventSearchRegion').val(),
                                    subregion   : $('#sltEventSearchSubregion').val()
                                },
                        cache: false,		        
                        complete:function(data){	
                            loading_next_step(1,'hide');
                            //console.log(data)			 
                            data1 =  data.responseText; 
                            if(data1){
                                $modal = $('<div class="modal " id="eventlist"></div>');
                                $modal.html(data1)               
                                $('body').append($modal);                                
                                setTimeout(function(){ $('div[href=#panel0]').trigger('click'); }, 300);
                                $modal.modal({keyboard: true});
                                $modal.show();
                            }			                
                        }
                    }); 
	    },eventRender: function (event, element) {
                $(element).addClass('clickThrough');
	    },
            viewRender:function(view, element){
			 
			//$("#loading").css("display","block");
			$("#event_calendar").fullCalendar('removeEvents');	
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
                            url: base_url + "career_event/get_classes",
                            dataType: 'json',
                            data : {
                                        s_date:whole_start_date,
                                        e_date:whole_end_date,
                                        region:$('#sltEventSearchRegion').val(),
                                        subregion:$('#sltEventSearchSubregion').val(),
                                        device:sw
                                    },
                            cache: false,		        
                            complete:function(data){	
                                    loading_next_step(1,'hide');				 
                                    data1 =  jQuery.parseJSON(data.responseText); 
                                            $("#event_calendar").fullCalendar('removeEvents')
                                            $("#event_calendar").fullCalendar('addEventSource',data1, true);	

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
	
	$('body').on('shown.bs.modal','#eventlist', function (event) {
						 
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
	$('body').on('hidden.bs.modal','#eventlist', function (event) {		 
		 $('#eventlist').remove();
	})
	
	
	
	  		
}