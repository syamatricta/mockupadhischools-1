;function fncUpadtesitepagedetails(a,b){$("flasherror").innerHTML="";$("errordisplay").innerHTML="";$("flashsuccess").innerHTML="";if(!1==is_field_empty("txtTitle","Please enter Title","errordisplay"))return!1;""==tinyMCE.get("txtContent").getContent()?($("errordisplay").style.display="block",$("errordisplay").innerHTML="Please enter Content",$("frmadhischool").txtContent.focus()):($("frmadhischool").action=base_url+"index.php/admin_sitepages/update_sitepage/"+a+"/"+b,$("frmadhischool").submit())} function gotolist(a){a?$("frmadhischool").action=base_url+"index.php/admin_sitepages/list_sitepage_details/"+a:$("frmadhischool").action=base_url+"index.php/admin_sitepages/list_sitepage_details/";$("frmadhischool").submit()}function deleteBanner(a){if(confirm("Do you really want to delete this banner details?"))$("hidBannerId").value=a,$("frmadhischool").action=base_url+"admin_sitepages/delete_banner/",$("frmadhischool").submit();else return!1} function deletefaq(a){if(confirm("Do you really want to delete this faq details?"))$("hidfaqId").value=a,$("frmadhischool").action=base_url+"admin_sitepages/delete_faq/",$("frmadhischool").submit();else return!1}function deletebrokerplacement(a){if(confirm("Do you really want to delete this Broker placement details?"))$("hidbrokerplacementId").value=a,$("frmadhischool").action=base_url+"admin_sitepages/delete_brokerplacement/",$("frmadhischool").submit();else return!1} function fncSavebrokerplacement(){$("flasherror").innerHTML="";$("errordisplay").innerHTML="";$("flashsuccess").innerHTML="";if(!1==is_field_empty("txtPostcode","Please enter Postcode","errordisplay")||!1==is_field_empty("txtAddress","Please enter Address","errordisplay")||""==id&&!1==is_field_empty("txtImage","Please enter Image","errordisplay")||!1==is_field_empty("txtYTVName","Please enter YouTube URL","errordisplay")||!1==is_field_empty("txtHCName","Please enter Hiring contact name","errordisplay")|| !1==is_field_empty("txtCName","Please enter Company name","errordisplay")||!1==is_field_empty("txtPhonenumber","Please enter Phone number","errordisplay")||!1==is_field_empty("txtcomDescription","Please enter Company Information","errordisplay"))return!1} function fncSaveBanner(){$("flasherror").innerHTML="";$("errordisplay").innerHTML="";$("flashsuccess").innerHTML="";if(!1==is_field_empty("txtTitle","Please enter Banner Title","errordisplay")||!1==is_field_empty("txtShortDesc","Please enter Short Description","errordisplay"))return!1;""==tinyMCE.get("txtContent").getContent()&&($("errordisplay").style.display="block",$("errordisplay").innerHTML="Please enter Description",$("frmadhischool").txtContent.focus())} function fncSaveFaq(){$("flasherror").innerHTML="";$("errordisplay").innerHTML="";$("flashsuccess").innerHTML="";if(!1==is_field_empty("txtTitle","Please enter Question","errordisplay"))return!1;""==tinyMCE.get("txtContent").getContent()&&($("errordisplay").style.display="block",$("errordisplay").innerHTML="Please enter Answer",$("frmadhischool").txtContent.focus())};