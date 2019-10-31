;function show_class(urls,id,hddate){
    var url = urls;
	var pars = '';
	pars += 'masterid=' + id;
	pars += '&currentdate=' + escape(hddate);
        
	var myAjax = new Ajax.Request(
		url,
		{
			method: 'post',
			parameters: pars,
			onComplete: getMessageResponse
		});


	function getMessageResponse(originalRequest)
	{   
	    $('relatedclass').show();
	        $('rel').innerHTML=originalRequest.responseText;
		 
	}

    $('hdnMasterid').value=id;
     //$('hdnDated').value=hddate;
     $('relatedclass').show();

}

function popup_close(id){
	$('relatedclass').hide();
};