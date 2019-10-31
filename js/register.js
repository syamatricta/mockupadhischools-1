var offsetxpoint=-60 //Customize x offset of tooltip
var offsetypoint=20 //Customize y offset of tooltip

     
var tooltip_body ='<div style="padding:10px 20px 20px 20px;background-color:#000; color:#FFF;">';
tooltip_body   +=   '<span style="color:#A5CE34"><h3><u>What is Certificate Name?</u></h3></span>';
tooltip_body   +=  '<p>Please enter your legal name here as it appears on your passport or birth certificate.  Completing this improperly will delay your license.';
tooltip_body   +=  '</p>';
 tooltip_body   += '</div>';
        
function show() {
    document.getElementById("errordiv").style.display = "none";
    document.getElementById("close_button").style.display = "none";
}
function hidealert() {
    setTimeout("show()", 9000);  
}
setTimeout("show()", 9000);  
function showFedexMsg(){
	document.getElementById("fedexMsg").style.display = "block";
}
function hideFedexMsg(){
	document.getElementById("fedexMsg").style.display = "none";
}
