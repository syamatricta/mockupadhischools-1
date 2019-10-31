function fncSearch(){	
	$("frmadhischool").submit();
}
function numbersonly(e){
    var unicode=e.charCode? e.charCode : e.keyCode
	
    if ((unicode!=8) && (unicode!=9) && (unicode!=13)){ //backspace,tab,enter,
        if (unicode<48||unicode>57) //if not a number
            return false //disable key press
    }
}
function getEditions(){
	$$('#edition_wait')[0].style.display = "block";
	url	= base_url+'supplement/get_editions';
	myAjaxRequest = new Ajax.Request(url, {method:"post", parameters :  {course_id : $('course_id').value}, onSuccess: function (resp){$$('#edition_wait')[0].style.display = "none";$('edition_div').innerHTML=resp.responseText;}, onFailure: errFun });
}
function addMoreSuppliment(){
	var count	= $$('.multi_row').length+1;
	var file_name	= 'file_'+$$('.multi_row').length;
	var html		= '	<div class="multi_row" id="addmore_div_'+count+'" >\
							<label for="title_'+count+'">Title<span class="red_star">*</span></label><span class="sep_col">:</span><input type="text" name="title[]" id="title_'+count+'" maxlength="40" />\
							<label for="file_'+count+'" class="file_label" style="padding-top:5px;">File (pdf only)<span class="red_star">*</span></label><input type="file" name="'+file_name+'" id="file_'+count+'" />\
							<a id="remove_row_'+count+'" class="remove_row" onclick="removeRow('+count+', \'add\')" title="Remove"></a>\
						</div>';
	$('addmore_div').insert(html);
}
function removeRow(no, type){
	if('add' == type){
		var count	= $$('.multi_row').length;
		$('addmore_div_'+no).remove();		
		if(count > 1 && no < count){
			for(var i = no+1; i <= count; i++){
				var new_id		= i-1;
				var file_name	= new_id-1;
				$('addmore_div_'+i).id 	= 'addmore_div_'+new_id;
				$('title_'+i).id 		= 'title_'+new_id;
				$('file_'+i).name 		= 'file_'+file_name;
				$('file_'+i).id 		= 'file_'+new_id;
				$('remove_row_'+i).removeAttribute('onclick');
				$('remove_row_'+i).setAttribute('onclick', "removeRow("+new_id+", 'add');");
				$('remove_row_'+i).id	= 'remove_row_'+new_id;
			}
		}
	}else{
		if(confirm('Do you really want to delete this Supplement?')){
			$('supplement_update').setAttribute('disabled', true);
			$$('#file_del_wait_'+no)[0].style.display = "block";
			$$('#edit_div_'+no+' .wait_overlay')[0].style.display = "block";
			var url	= base_url+'supplement/delete';
			new Ajax.Request(
						url, {
							method		: "post", 
							parameters	: {'id' : no}, 
							onSuccess	: function (resp){
								var result	= JSON.parse(resp.responseText);
								if(result.success == 0){displayValidateError('errordisplay', result.message, 'edition_div');}
								else{
									$('edit_div_'+no).remove();
									if(0 == result.no_supplements && 0 == $$('.multi_row').length){
										addMoreSuppliment();
									}
									$('supplement_update').removeAttribute('disabled');
									$('flashsuccess').update(result.message);
								}
							}, onFailure: errFun
						});
		}
	}
}
function validateSupplement(type){	
	var error_div				= 'errordisplay';
	$(error_div).style.display	= "none";
	$('flashsuccess').update('');
	if('add' == type){
		if($('course_id').value==''){
			displayValidateError(error_div, 'Please select Course', 'course_id');return false;
		}else if($('edition_id').value==''){
			displayValidateError(error_div, 'Please select Edition', 'edition_id');return false;
		}
	}
	var validation_error		= false;
	var validation_unique_error	= false;
	var row_count				= $$('.multi_row').length;
	var first_elm				= '';	
	var title_arr				= new Array();
	
	if('edit' == type){
		var row_count_edit		= $$('.multi_row_edit').length;
		if('edit' == type && 0 == row_count_edit && 0 == row_count){
			displayValidateError(error_div, 'Please click Add More to add Supplement', 'edition_div');return false;
		}
		var row_edit_div		= $$('.multi_row_edit input[type="text"]');
		row_edit_div.each(function (elment){
			var i	= elment.id.replace('edit_title_', '');
			if(elment.value.strip() == ''){
				if(!validation_error){first_elm = 'edit_title_'+i;}
				elment.addClassName('err');
				validation_error = true;
			}else{
				var title_trimmed	= elment.value.toLowerCase().replace(/^(\s*)|(\s*)$/g, '').replace(/\s+/g, ' ');
				if(title_arr.length >= 1 && title_arr.indexOf(title_trimmed) >= 0){
					elment.addClassName('err');
					validation_unique_error = true;
					if(!validation_error){first_elm = 'edit_title_'+i;}
				}else{
					title_arr.push(title_trimmed);
					elment.removeClassName('err');
				}
			}
		});
	}
	for(var i = 1; i <= row_count; i++){
		if($('title_'+i).value.strip() == ''){
			if(!validation_error){first_elm = 'title_'+i;}
			$('title_'+i).addClassName('err');
			validation_error = true;
		}else{
			var title_trimmed	= $('title_'+i).value.toLowerCase().replace(/^(\s*)|(\s*)$/g, '').replace(/\s+/g, ' ');
			if(title_arr.length >= 1 && title_arr.indexOf(title_trimmed) >= 0){
				$('title_'+i).addClassName('err');
				validation_unique_error = true;
				if(!validation_error){first_elm = 'title_'+i;}
			}else{
				title_arr.push(title_trimmed);
				$('title_'+i).removeClassName('err');
			}
		}
		if($('file_'+i).value.strip() == ''){
			if(!validation_error){first_elm = 'file_'+i;}
			$('file_'+i).addClassName('err');
			validation_error = true;
		}else{
			$('file_'+i).removeClassName('err');
		}		
	}
	
	if(validation_error){
		displayValidateError(error_div, 'Empty Title / File', first_elm);return false;
	}else if(validation_unique_error){
		displayValidateError(error_div, 'Title is not unique', first_elm);return false;
	}else{
		if('add' == type){
			$('supplement_add').setAttribute('disabled', true);			
		}else{
			$('supplement_update').setAttribute('disabled', true);
		}
		$('frmAddSupplement').submit();
	}
}
function displayValidateError(error_div, msg, field){
	$(error_div).style.display = "block", $(error_div).innerHTML = msg,$(field).focus();
}
function errFun(){
	alert('Ann error occurred');
}
function downloadSupplement(elm){
	var url	= base_url+'supplement/download';
	var id	= elm.name;
	window.location = base_url+'supplement/download/'+id;
	/*$$('.outermaindiv')[0].insert({top : '<div id="download_overlay">Please wait...</div>'});
	myAjaxRequest = new Ajax.Request(
						url, {
							method		:"post", 
							parameters	:  {'id' : id}, 
							onSuccess	: function (resp){
								$('download_overlay').remove();
								if('' != resp.responseText){displayValidateError('errordisplay', resp.responseText, 'edition_div');}
							}, onFailure: errFun
						});*/
}


function deleteAllSupplements(course_id, edition_id,crs,edn){
	if(confirm('This action will remove all supplements under Edition - ' +edn+ ' of ' +crs+'.\nDo you really want to delete Supplements?')){
		window.location	= base_url+'supplement/delete_all/'+course_id+'/'+edition_id;
	}
}


