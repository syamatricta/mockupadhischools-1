/*

CUSTOM FORM ELEMENTS

Created by Ryan Fait
www.ryanfait.com

The only things you may need to change in this file are the following
variables: checkboxHeight, radioHeight and selectWidth (lines 24, 25, 26)

The numbers you set for checkboxHeight and radioHeight should be one quarter
of the total height of the image want to use for checkboxes and radio
buttons. Both images should contain the four stages of both inputs stacked
on top of each other in this order: unchecked, unchecked-clicked, checked,
checked-clicked.

You may need to adjust your images a bit if there is a slight vertical
movement during the different stages of the button activation.

The value of selectWidth should be the width of your select list image.

Visit http://ryanfait.com/ for more information.

*/
; var checkboxHeight="25",radioHeight="25",selectWidth="290",adjust_height=3;document.write('<style type="text/css">input.styled { display: none; } select.styled { position: relative;font-weight:bold; color:#000000; width: '+selectWidth+"px; opacity: 0; filter: alpha(opacity=0); z-index: 5; } .disabled { opacity: 0.5; filter: alpha(opacity=50); }</style>"); var Custom={init:function(){var c=document.getElementsByTagName("input"),e=[],f,g;for(a=0;a<c.length;a++)if(("checkbox"==c[a].type||"radio"==c[a].type)&&"styled"==c[a].className)e[a]=document.createElement("span"),e[a].className=c[a].type,!0==c[a].checked&&(position="checkbox"==c[a].type?"0 -"+parseInt(2*parseInt(checkboxHeight,10)+adjust_height,10)+"px":"0 -"+parseInt(2*radioHeight+adjust_height,10)+"px",e[a].style.backgroundPosition=position),c[a].parentNode.insertBefore(e[a],c[a]),c[a].onchange= Custom.clear,c[a].getAttribute("disabled")?e[a].className=e[a].className+=" disabled":(e[a].onmousedown=Custom.pushed,e[a].onmouseup=Custom.check);c=document.getElementsByTagName("select");for(a=0;a<c.length;a++)if("styled"==c[a].className){g=c[a].getElementsByTagName("option");f=g[0].childNodes[0].nodeValue;f=document.createTextNode(f);for(b=0;b<g.length;b++)!0==g[b].selected&&(f=document.createTextNode(g[b].childNodes[0].nodeValue));e[a]=document.createElement("span");"109px"==c[a].style.width? (e[a].style.backgroundImage="url("+base_url+"images/input_theme/select_109px.gif)",e[a].style.color="#00579E"):"154px"==c[a].style.width&&(e[a].style.backgroundImage="url("+base_url+"images/input_theme/select_154px.gif)",e[a].style.color="#00579E");e[a].className="select";e[a].id="select"+c[a].name;e[a].appendChild(f);c[a].parentNode.insertBefore(e[a],c[a]);c[a].getAttribute("disabled")?c[a].previousSibling.className=c[a].previousSibling.className+=" disabled":c[a].onchange=Custom.choose}document.onmouseup= Custom.clear},pushed:function(){element=this.nextSibling;this.style.backgroundPosition=!0==element.checked&&"checkbox"==element.type?"0 -"+parseInt(3*parseInt(checkboxHeight,10)+adjust_height,10)+"px":!0==element.checked&&"radio"==element.type?"0 -"+parseInt(3*radioHeight+parseInt(adjust_height,10),10)+"px":!0!=element.checked&&"checkbox"==element.type?"0 -"+parseInt(parseInt(checkboxHeight,10)+parseInt(adjust_height,10),10)+"px":"0 -"+parseInt(parseInt(radioHeight,10)+parseInt(adjust_height,10), 10)+"px"},check:function(){element=this.nextSibling;if(!0==element.checked&&"checkbox"==element.type)this.style.backgroundPosition="0 -3px",element.checked=!1,element.focus();else{if("checkbox"==element.type)this.style.backgroundPosition="0 -"+parseInt(2*parseInt(checkboxHeight,10)+adjust_height,10)+"px",element.focus();else{this.style.backgroundPosition="0 -"+parseInt(2*radioHeight+adjust_height,10)+"px";group=this.nextSibling.name;inputs=document.getElementsByTagName("input");for(a=0;a<inputs.length;a++)inputs[a].name== group&&inputs[a]!=this.nextSibling&&(inputs[a].previousSibling.style.backgroundPosition="0 -3px")}element.checked=!0}},clear:function(){inputs=document.getElementsByTagName("input");for(var c=0;c<inputs.length;c++)"checkbox"==inputs[c].type&&!0==inputs[c].checked&&"styled"==inputs[c].className?inputs[c].previousSibling.style.backgroundPosition="0 -"+parseInt(2*parseInt(checkboxHeight,10)+adjust_height,10)+"px":"checkbox"==inputs[c].type&&"styled"==inputs[c].className?inputs[c].previousSibling.style.backgroundPosition= "0 -3px":"radio"==inputs[c].type&&!0==inputs[c].checked&&"styled"==inputs[c].className?inputs[c].previousSibling.style.backgroundPosition="0 -"+parseInt(2*radioHeight+adjust_height,10)+"px":"radio"==inputs[c].type&&"styled"==inputs[c].className&&(inputs[c].previousSibling.style.backgroundPosition="0 -3px")},choose:function(){option=this.getElementsByTagName("option");for(d=0;d<option.length;d++)!0==option[d].selected&&(document.getElementById("select"+this.name).childNodes[0].nodeValue=option[d].childNodes[0].nodeValue, "sltSearchRegion"==this.name&&fncGetSubregion("sltSearchRegion","sltSearchSubregion"),"sltSearchSubregion"==this.name&&fncDisplayDefaultList(today_timeline,parameter2,parameter3,parameter4),"sltSearchCourse"==this.name&&fncDisplayDefaultList(today_timeline,parameter2,parameter3,parameter4),"sltSearchChp"==this.name&&fncDisplayDefaultList(today_timeline,parameter2,parameter3,parameter4),"course"==this.name&&ajax_load_chapters(),"chapter"==this.name&&goto_list())}};window.onload=Custom.init;