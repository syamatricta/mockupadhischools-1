

var MapIconMaker = {};

MapIconMaker.createMarkerIcon = function(opts) {
  var width = opts.width || '110';
  var height = opts.height || '60';
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
	var point	    = 	new Array();
	var marker  	= 	new Array();
	var limit		=	data.length;
	for(var i=0;i<limit;i++){
		var garageid		=	data[i].garageid;
		var garageid_b_64	=	data[i].garageid_b_64;
		var garagename		=	data[i].garagename;
		var address			=	data[i].address;
		var latitude		=	data[i].latitude;
		var longitude		=	data[i].longitude;
		var map_pin_angle	=	data[i].map_pin_angle;
		var map_pin_length	=	data[i].map_pin_length;
		var feedback_count	=	data[i].feedback_count;
		var cgi_star_rating	=	data[i].cgi_star_rating;
		var percent_score	=	data[i].percent_score;
		var postcode		=	data[i].postcode;
		var distance		=	data[i].distance;
		var bookingservice	=	data[i].bookingservice;
		var garage_thumb	=	data[i].garage_thumb;
		var arrowfirst		=	0;
		var increaseimage	=	0;
		
		point[i]		=	new GLatLng(latitude,longitude);
		var TableOpen		=	'<table width=\'300\' cellpadding=\'0\' cellspacing=\'2\' border=\'0\' border=1>';
		var TableClose		=	'<\/table>';
		var TrOpen			=	'<tr>';
		var TrClose			=	'<\/tr>';
		var TdClose			=	'<\/td>';
		var TdOneOpen		=	'<td width=\'3\'">';
		var ImageTitle		=	'dhashdajks';	
		
		
		popup_body[i]	=	TableOpen+TrOpen+TdOneOpen+ImageTitle+TdClose+TrClose+TableClose;
		
		var image_id	=	i+1;
		marker = createCustomMarker(point[i], "SSS",  popup_body[i]);
		//var marker	=	createMarker(point[i]);		// Default Google marker
		map.addOverlay(marker);
	}
}
function garage_locator(i) {
	gmarkers[i].openInfoWindowHtml(popup_body[i]);
	//setBottom(data1[i].garageid);
}
function createCustomMarker(point,name,html,kval,pcode,gid,imagesid, firstarrow, increaseimage, leng, ang, image_url) {
 		var widh=0;var hgh=0;
 		if(leng=='Long'){ 
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
 		}
		
		var iUrl =""
		previousPcode	=	pcode;
		iUrl =image_url+"gmap/pin/"+leng+"/"+leng+"_"+ang+"/"+imagesid+".png";
		var newIcon = MapIconMaker.createMarkerIcon({width: widh, height: hgh, primaryColor: "#00ff00", iconurl:iUrl });
				
		
		newIcon['shadow']	 = '';
		if(leng=='Long'){ 
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
		}
		var marker = new GMarker(point,{icon: newIcon});
		GEvent.addListener(marker, "click", function() {
			marker.openInfoWindowHtml(html);
		  //__fncGarageDetails(gid);
			});
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