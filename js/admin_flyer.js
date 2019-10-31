function fncSaveFlyer(flyer_id){
    if(false == is_field_empty('title', 'Please enter File title', 'errordiv')) {
        return false;
    }else if(false == is_radio_empty('head_image', 'Please select Head Image', 'errordiv')) {
        return false;
    }else if(false == is_field_empty('heading', 'Please enter Heading', 'errordiv')) {
        return false;
    }else if(false == is_field_empty('sub_heading', 'Please enter Sub Heading', 'errordiv')) {
        return false;
    }else if(false == is_field_empty('date', 'Please select Date', 'errordiv')) {
        return false;
    }else{
        $('errordiv').style.display     = 'none';
    }
    if( 0 == flyer_id){
        $("addFlyerForm").action  = base_url+'admin_flyer/add_flyer/';
    }else{
        $("addFlyerForm").action  = base_url+'admin_flyer/edit_flyer/'+flyer_id;
    }
    $("addFlyerForm").submit();
}

function checkedRadioBtn(sGroupName)
{   
    var group = document.getElementsByName(sGroupName);

    for ( var i = 0; i < group.length; i++) {
        if (group.item(i).checked) {
            return group.item(i).id;
        } else if (group[0].type !== 'radio') {
            //if you find any in the group not a radio button return null
            return null;
        }
    }
}

function is_radio_empty (sGroupName, errmsg, errdiv){
	if(null == checkedRadioBtn(sGroupName)){
		$(errdiv).style.display   = "block";
		//$(txtfield).className     = 'error_border';
		$(errdiv).innerHTML       = errmsg;
		//$(txtfield).value         = '';
                //$(txtfield).focus();
		return false;
	}else{
		$(errdiv).innerHTML       = "";
		$(errdiv).style.display   = "none";
	}
}
function deleteFlyer(id){
    if(confirm('Do you realy want to delete this Flyer?')){
        window.location = base_url+'admin_flyer/delete_flyer/'+id;
    }
}