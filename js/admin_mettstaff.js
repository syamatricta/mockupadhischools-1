;

function fncSaveStaff(a, b) {
    $("flasherror").innerHTML = "";
    $("errordisplay").innerHTML = "";
    $("flashsuccess").innerHTML = "";
    if (!1 == is_field_empty("txtName", "Please enter Name", "errordisplay")||!1 == is_drop_down_empty("cboyear", "Please select year", "errordisplay")||!1 == is_field_empty("txtHours", "Please enter Base hour", "errordisplay") ||  !1 == is_field_empty("txtimg", "Please enter Photo", "errordisplay")) return !1;
    "" == tinyMCE.get("txtContent").getContent() ? ($("errordisplay").style.display = "block", $("errordisplay").innerHTML = "Please enter Description", $("frmadhischool").txtContent.focus()) : ("" == a ? $("frmadhischool").action = base_url + "admin_meetourstaff/add_staff/" : ($("hidStaffid").value = a, $("frmadhischool").action = base_url + "admin_meetourstaff/update_staff/" + a + "/" + b), $("frmadhischool").submit())
}

function gotolist(a) {
    a ? $("frmadhischool").action = base_url + "admin_meetourstaff/list_staff/" + a : $("frmadhischool").action = base_url + "admin_meetourstaff/list_staff/";
    $("frmadhischool").submit()
}

function deleteStaff(a) {
    if (confirm("Do you really want to delete this staff?")) $("hidstaffid").value = a, $("frmadhischool").action = base_url + "admin_meetourstaff/delete_staff/", $("frmadhischool").submit();
    else return !1
};

jQuery(document).ready(function() {
	    jQuery('#weekmsg').hide();
		jQuery('#addhour').click(function(e) {
 			  e.preventDefault();
 			  jQuery('#weekmsg').html(''); 
	 		  that = jQuery(this);
	 		  if(jQuery('#weeklyhour').val()==''){
	 		  	jQuery('#weekmsg').show().html('<span style="color:red"> &nbsp; Enter hours</span>');
	 		  	return false;
	 		  }	
	 			jQuery.ajax({
			        type: "POST",
			        url: base_url + "admin_meetourstaff/add_weeklyhours",
			        dataType: 'json',
			        data : {id:that.data('staff'),hour:jQuery('#weeklyhour').val()},
			        cache: false, 
			        success:function(data){				        	
			        	if (data.success==true){
			        		var current = jQuery('#settotalweekly').html()
			        		var new_hour  = parseInt (current)+ parseInt (jQuery('#weeklyhour').val());
			        		jQuery('#settotalweekly').html(new_hour);
			        		jQuery('#weeklyhour').val('');
			        		jQuery('#weekmsg').show().html('<span style="color:green"> &nbsp;'+data.msg+'</span>');
			        	}else{
			        		jQuery('#weekmsg').show().html('<span style="color:red"> &nbsp;'+data.msg+'</span>');
			        	}	        	 
			        	
			            setTimeout(function(){ jQuery( "#addweeksec" ).hide( "slow") }, 1000);    
			        }	 
 			 
 				});
 		});
 		jQuery('.addweekly').click(function(e) {
 			e.preventDefault(); 
 			  jQuery('#weekmsg').hide();		
 			  jQuery( "#addweeksec" ).toggle( "slow", function() {
			   
			  });	 
 			 
 		});
	    jQuery('.key-numeric').keypress(function(e) {
	            var verified = (e.which == 8 || e.which == undefined || e.which == 0) ? null : String.fromCharCode(e.which).match(/[^0-9]/);
	            if (verified) {e.preventDefault();}
	    });
	});