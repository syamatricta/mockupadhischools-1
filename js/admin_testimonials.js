;function fncSavetestimonials(a,b){$("flasherror").innerHTML="";$("errordisplay").innerHTML="";$("flashsuccess").innerHTML="";if(!1==is_field_empty("txtshortTitle","Please enter Short Testimonial","errordisplay"))return!1;""==tinyMCE.get("txtContent").getContent()?($("errordisplay").style.display="block",$("errordisplay").innerHTML="Please enter Content",$("frmadhischool").txtContent.focus()):(""==a?$("frmadhischool").action=base_url+"admin_testimonials/add_testimonial/":($("hidtestm_id").value=a, $("frmadhischool").action=base_url+"admin_testimonials/update_testimonial/"+a+"/"+b),$("frmadhischool").submit())}function gotolist(a){a?$("frmadhischool").action=base_url+"admin_testimonials/list_testimonials/"+a:$("frmadhischool").action=base_url+"admin_testimonials/list_testimonials/";$("frmadhischool").submit()} function deleteTestimonial(a){if(confirm("Do you really want to delete this testimonial?"))$("hidtestimonialid").value=a,$("frmadhischool").action=base_url+"admin_testimonials/delete_testimonial/",$("frmadhischool").submit();else return!1};