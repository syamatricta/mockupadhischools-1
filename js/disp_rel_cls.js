function show_relatedclass(modal_path,id,hddate){
    var url = base_url+modal_path;
	var pars = '';
	pars += 'hdnSubregion=' + id;
	pars += '&hdnDated=' + escape(hddate);

	var myAjax = new Ajax.Request(
		url,
		{
			method: 'post',
			parameters: pars,
			onComplete: getMessageResponse
		});

	$('hdnSubregion').value=id;
	$('hdnDated').value=hddate;
	$('relatedclass').show();

}
function popup_close(id){
	$('relatedclass').hide();
}
function getMessageResponse(originalRequest)
{
	$('rel').innerHTML=originalRequest.responseText;
	$('relatedclass').show();
	document.getElementById("relatedclass").style.display='block';
}