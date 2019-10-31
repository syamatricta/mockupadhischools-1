;

var MapIconMaker = {};

MapIconMaker.createMarkerIcon = function(opts) {
  var width = opts.width || 32;
  var height = opts.height || 32;
  var primaryColor = opts.primaryColor || "#ff0000";
  var strokeColor = opts.strokeColor || "#000000";
  var cornerColor = opts.cornerColor || "#ffffff";
  var  iconUrl  =opts.iconurl;
 // alert(iconUrl);
 /* var baseUrl = "http://chart.apis.google.com/chart?cht=mm";
  var iconUrl = baseUrl + "&chs=" + width + "x" + height + 
      "&chco=" + cornerColor.replace("#", "") + "," + primaryColor.replace("#", "") + "," + strokeColor.replace("#", "") + "&ext=.png";
*/  var icon = new GIcon(G_DEFAULT_ICON);
  icon.image = iconUrl;
  icon.iconSize = new GSize(width, height);
  icon.shadowSize = new GSize(Math.floor(width*1.6), height);
  icon.iconAnchor = new GPoint(width/2, height);
  icon.infoWindowAnchor = new GPoint(width/2, Math.floor(height/12));
  icon.printImage = iconUrl + "&chof=gif";
  icon.mozPrintImage = iconUrl + "&chf=bg,s,ECECD8" + "&chof=gif";
 /* var iconUrl = baseUrl + "&chs=" + width + "x" + height + 
      "&chco=" + cornerColor.replace("#", "") + "," + primaryColor.replace("#", "") + "," + strokeColor.replace("#", "");*/
  /*icon.transparent = iconUrl + "&chf=a,s,ffffff11&ext=.png";*/
  icon.transparent = iconUrl;

  icon.imageMap = [
      width/2, height,
      (7/16)*width, (5/8)*height,
      (5/16)*width, (7/16)*height,
      (7/32)*width, (5/16)*height,
      (5/16)*width, (1/8)*height,
      (1/2)*width, 0,
      (11/16)*width, (1/8)*height,
      (25/32)*width, (5/16)*height,
      (11/16)*width, (7/16)*height,
      (9/16)*width, (5/8)*height
  ];
  for (var i = 0; i < icon.imageMap.length; i++) {
    icon.imageMap[i] = parseInt(icon.imageMap[i]);
  }

  return icon;
}
var popup_body 	= new Array();

$(document).ready(function(){
$('.garage_locator').click(function (){
		var garage_sl 	= $.trim($(this).attr("lang"));
		if(garage_sl){
			var html_content_id	=	Number(garage_sl) - 1;
			gmarkers[garage_sl].openInfoWindowHtml(popup_body[html_content_id]);
		}
	});
});
function create_nodes(data,image_url){
	var point	    = new Array();
	var marker  	= new Array();
	var limit	=	data.length;
	for(var i=0;i<limit;i++){
		//var garageid		=	data[i].garageid;
                var garageid		=	data[i].co_id;
		//var garageid_b_64	=	data[i].garageid_b_64;
		//var garagename		=	data[i].garagename;
		//var address			=	data[i].address;
                var garageid_b_64	=	'';
		var garagename		=	'';
		var address			='';
		var latitude		=	data[i].co_lattitude;
		var longitude		=	data[i].co_longitude;
		//var map_pin_angle	=	data[i].map_pin_angle;
		//var map_pin_length	=	data[i].map_pin_length;
		//var feedback_count	=	data[i].feedback_count;
		//var cgi_star_rating	=	data[i].cgi_star_rating;
		//var percent_score	=	data[i].percent_score;

                var map_pin_angle	=	'';
		var map_pin_length	=	'';
		var feedback_count	=	'';
		var cgi_star_rating	=	'';
		var percent_score	=	'';
		var postcode		=	data[i].co_postcode;
		//var distance		=	data[i].distance;
		//var bookingservice	=	data[i].bookingservice;
		//var garage_thumb	=	data[i].garage_thumb;

                var distance		=	'';
		var bookingservice	=	'';
		var garage_thumb	=	'';
               // alert(garageid);
                if(garageid ==1){
                    var arrowfirst		=	1;
                }else{
                    var arrowfirst		=	0;
                }
		var increaseimage	=	0;
		//alert('id '+garageid+'  name '+garagename+'  lat '+latitude+'  lon '+longitude+'  angle '+map_pin_angle+'  len '+map_pin_length+'  feed '+feedback_count+'  star '+cgi_star_rating+'  perc '+percent_score+'  dist '+distance+'  dist '+distance );
		
		point[i]		=	new GLatLng(latitude,longitude);
		var TableOpen		=	'<table width=\'300\' cellpadding=\'0\' cellspacing=\'2\' border=\'0\' border=1>';
		var TableClose		=	'<\/table>';
		var TrOpen			=	'<tr>';
		var TrClose			=	'<\/tr>';
		var TdClose			=	'<\/td>';
		var TdOneOpen		=	'<td width=\'3\'">';
		var GarageImage		=	'<a href=\''+base_url+'garage/details/'+garageid_b_64+'\'><img src=\''+garage_thumb+'\' width=\'100\' height=\'70\' border=\'0\'><\/a>';	
		var TdTwoOpen		=	'<td valign=\'top\' align=\'left\'>';
		var TdTwoLineOne	=	'<div class=\'garage_list_garage_rating\'><a class=\'garage_list_garage_rating\' href=\''+base_url+'garage/details/'+garageid_b_64+'\'>'+garagename+'<\/a><\/div>';
		var TdTwoLineTwo	=	'<div>'+address+'<\/div>';
		if(feedback_count){
			var TdTwoLineThree	=	'<div>Feedback : <a href=\''+base_url+'garage/feedback/'+garageid_b_64+'\'>'+feedback_count+'<\/a><\/div>';
		}else TdTwoLineThree	=	'';
		if('Y' == bookingservice){
			var TdTwoLineFour	=	'<div>Booking Service : <a href=\''+base_url+'bookonline/step1/'+garageid_b_64+'\'>Book online<\/a>'+'<\/div>';
		}else TdTwoLineFour	=	'';
		var TdTwoLineFive	=	'<div>Distance : '+parseFloat(distance).toFixed(2)+' mi<\/div>';
		var TdTwoLineSix	=	'<div align=\'right\'><a href=\''+base_url+'garage/details/'+garageid_b_64+'\'>more..</a><\/div>';
		
		//popup_body[i]	=	TableOpen+TrOpen+TdOneOpen+GarageImage+TdClose+TdTwoOpen+TdTwoLineOne+TdTwoLineTwo+TdTwoLineThree+TdTwoLineFour+TdTwoLineFive+TdTwoLineSix+TdClose+TrClose+TableClose;
		popup_body[i]	='';
		//var image_id	=	i+1;
                var image_id	=	2;
		marker = createCustomMarker(point[i], "SSS",  popup_body[i],i,postcode,garageid,image_id, arrowfirst, increaseimage,map_pin_length,map_pin_angle,image_url,i+1);
		//var marker	=	createMarker(point[i]);		// Default Google marker
		map.addOverlay(marker);
	}
}
function garage_locator(i) {
	gmarkers[i].openInfoWindowHtml(popup_body[i]);
	//setBottom(data1[i].garageid);
}
function createCustomMarker(point,name,html,kval,pcode,gid,imagesid, firstarrow, increaseimage, leng, ang, image_url,i) {
 		var widh=45;var hgh=41;
 		/*if(leng=='Long'){
 			if(ang=='Top'){
 				widh=38;hgh=106;
 			}
 			if(ang=='Left'){
 				//widh=176;hgh=38;
 				widh=106;hgh=38;
 			}
 			if(ang=='Right'){
 				//widh=220;hgh=38;
 				widh=106;hgh=38;
 			}
 			if(ang=='Bottom'){
 				widh=38;hgh=106;
 			}
 		}
 		if(leng=='Standard'){ 
 			if(ang=='Top'){
 				widh=38;hgh=71;
 			}
 			if(ang=='Left'){
 				//widh=111;hgh=38;
 				widh=71;hgh=38;
 			}
 			if(ang=='Right'){
 				//widh=150;hgh=38;
 				widh=71;hgh=38;
 			}
 			if(ang=='Bottom'){
 				widh=38;hgh=71;
 			}
 		}
 		if(leng=='Short'){ 
 			if(ang=='Top'){
 				widh=38;hgh=50;
 			}
 			if(ang=='Left'){
 				widh=50;hgh=38;
 			}
 			if(ang=='Right'){
 				widh=50;hgh=38;
 			}
 			if(ang=='Bottom'){
 				widh=38;hgh=50;
 			}
 		}*/
		
		var iUrl =""
		previousPcode	=	pcode;
		//iUrl =image_url+"gmap/pin/"+leng+"/"+leng+"_"+ang+"/"+imagesid+".png";
                //if(gid==1){
                 iUrl =image_url+"pin_04.png";
                // }else{
                  // if(gid%2 ==0) iUrl =image_url+"pin_02.png";
                  // else  iUrl =image_url+"pin_03.png";
                //}
		var newIcon = MapIconMaker.createMarkerIcon({width: widh, height: hgh, primaryColor: "#00ff00", iconurl:iUrl });
				
		
		newIcon['shadow']	 = '';
		/*if(leng=='Long'){
			if(ang=='Left'){
 				newIcon['iconAnchor'] = new GPoint(100,24);
 			}
			if(ang=='Right'){
				newIcon['iconAnchor'] = new GPoint(-12,24);
			}
			if(ang=='Bottom'){
				newIcon['iconAnchor'] = new GPoint(6,14);
			}
		}
		if(leng=='Standard'){ 
			if(ang=='Left'){
 				newIcon['iconAnchor'] = new GPoint(70,24);
 			}
			if(ang=='Right'){
				newIcon['iconAnchor'] = new GPoint(-12,24);
			}
			if(ang=='Bottom'){
				newIcon['iconAnchor'] = new GPoint(6,14);
			}
		}
		if(leng=='Short'){ 
			if(ang=='Left'){
 				newIcon['iconAnchor'] = new GPoint(50,24);
 			}
			if(ang=='Right'){
				newIcon['iconAnchor'] = new GPoint(-12,24);
			}
			if(ang=='Bottom'){
				newIcon['iconAnchor'] = new GPoint(6,14);
			}
		}*/
		var marker = new GMarker(point,{icon: newIcon});
		//GEvent.addListener(marker, "click", function() { alert('ff');
                    
			//marker.openInfoWindowHtml(html);
		  //__fncGarageDetails(gid);
			//});
		GEvent.addListener(marker, "mouseover", function() {
		  //marker.openInfoWindowHtml(html);
		  //setBottom(gid);
			});
		GEvent.addListener(marker, "mouseout", function() {
		 	//showBottomDiv();
			});	
		gmarkers[imagesid] = marker;
		return marker;
	}

	
	//To get MapCenter Longitude and Latitude
//javascript:void(prompt('',gApplication.getMap().getCenter()));