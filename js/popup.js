/* 
  popup.js

  A lightweight general purpose JavaScript DOM element popup class.

  Webpage:
    http;//www.methods.co.nz/popup/popup.html

  Inspired by:
    Lightbox2: http://www.huddletogether.com/projects/lightbox2/
    Lightbox Gone Wild: http://particletree.com/features/lightbox-gone-wild/
    Tooltip: http://blog.innerewut.de/pages/tooltip
    Prototype library: http://www.prototypejs.org/
    Scriptaculous library: http://script.aculo.us/

  Attributions:
    - Uses the getPageSize() function from Lightbox v2.02 by Lokesh Dhakar
      (http://www.huddletogether.com/projects/lightbox2/).
    - Adapted the the modal overlay technique used in Lightbox v2.02 by Lokesh
      Dhakar (http://www.huddletogether.com/projects/lightbox2/).

  Version: 1.0.1

  Author:    Stuart Rackham <srackham@methods.co.nz>
  License:   This source code is released under the MIT license.

  Copyright (c) Stuart Rackham 2007

*/
; var Popup=Class.create();Popup.zIndex=995; Popup.prototype={initialize:function(a,c,b){b=Object.extend({modal:!1,effect:"fade",hidden:!0,closebox:"popup_closebox",draghandle:"popup_draghandle"},b||{});b.position=b.position||(b.modal?"center":"auto");b.trigger=b.trigger||(b.modal?"click":"mouseover");b.duration=this.first_value(b.duration,Popup.duration,0.5);b.show_duration=this.first_value(b.show_duration,b.duration);b.hide_duration=this.first_value(b.hide_duration,b.duration);b.opacity=this.first_value(b.opacity,Popup.opacity,0.5);b.show_delay= this.first_value(b.show_delay,Popup.show_delay,500);b.hide_delay=this.first_value(b.hide_delay,Popup.hide_delay,200);b.cursor_margin=this.first_value(b.cursor_margin,Popup.cursor_margin,5);this.options=b;c&&(this.link=$(c));this.popup=$(a);this.popup.popup=this;b.hidden&&this.popup.hide();b.closebox?(this.closeboxes=document.getElementsByClassName(b.closebox,this.popup),this.popup.hasClassName(b.closebox)&&(this.closeboxes[this.closeboxes.length]=this.popup)):this.closeboxes=[];if(b.draghandle){a= document.getElementsByClassName(b.draghandle,this.popup);for(i=0;i<a.length;i++)new Draggable(this.popup,{handle:a[i]});this.popup.hasClassName(b.draghandle)&&new Draggable(this.popup,{handle:this.popup})}this.register_events()},register_events:function(){var a;this.is_auto_open()?(a=this.start_show_timer,this.link&&Event.observe(this.link,"mouseout",this.stop_show_timer.bindAsEventListener(this))):a=this.show;this.link&&Event.observe(this.link,this.options.trigger,a.bindAsEventListener(this));this.options.modal|| Event.observe(this.popup,"click",this.bring_to_front.bindAsEventListener(this));if(0<this.closeboxes.length)for(a=0;a<this.closeboxes.length;a++)Event.observe(this.closeboxes[a],"click",this.hide.bindAsEventListener(this));else this.link&&Event.observe(this.link,"mouseout",this.start_hide_timer.bindAsEventListener(this)),Event.observe(this.popup,"mouseover",this.stop_hide_timer.bindAsEventListener(this)),Event.observe(this.popup,"mouseout",this.start_hide_timer.bindAsEventListener(this))},bring_to_front:function(){Number(this.popup.style.zIndex)< Popup.zIndex-1&&(this.popup.style.zIndex=Popup.zIndex++)},start_show_timer:function(a){this.stop_show_timer(a);this.mouse_x=Event.pointerX(a);this.mouse_y=Event.pointerY(a);this.show_timer=setTimeout(this.show.bind(this,a),this.options.show_delay)},stop_show_timer:function(){this.show_timer&&(clearTimeout(this.show_timer),this.show_timer=null)},start_hide_timer:function(a){this.stop_hide_timer(a);this.hide_timer=setTimeout(this.hide.bind(this,a),this.options.hide_delay)},stop_hide_timer:function(){this.hide_timer&& (clearTimeout(this.hide_timer),this.hide_timer=null)},show:function(a){this.stop_show_timer(a);this.stop_hide_timer(a);if(!this.is_open)switch(this.options.modal&&this.show_overlay(),a=a?this.is_auto_open()?this.get_popup_position(this.mouse_x,this.mouse_y):this.get_popup_position(Event.pointerX(a),Event.pointerY(a)):this.get_popup_position(),Element.setStyle(this.popup,{top:a.y,left:a.x,zIndex:Popup.zIndex++}),this.is_open=!0,this.options.effect){case "slide":Effect.SlideDown(this.popup,{duration:this.options.show_duration}); break;case "grow":Effect.Grow(this.popup,{duration:this.options.show_duration});break;case "blind":Effect.BlindDown(this.popup,{duration:this.options.show_duration});break;default:Effect.Appear(this.popup,{duration:this.options.show_duration})}},hide:function(){this.is_open=!1;switch(this.options.effect){case "slide":Effect.SlideUp(this.popup,{duration:this.options.hide_duration});break;case "grow":Effect.Shrink(this.popup,{duration:this.options.hide_duration});break;case "blind":Effect.BlindUp(this.popup, {duration:this.options.hide_duration});break;default:Effect.Fade(this.popup,{duration:this.options.hide_duration})}this.options.modal&&this.hide_overlay()},first_value:function(){for(var a=0;a<arguments.length;a++)if(void 0!==arguments[a])return arguments[a]},is_auto_open:function(){return"mouseover"==this.options.trigger},show_overlay:function(){if(!Popup.overlay){var a=document.createElement("div");a.setAttribute("id","popup_overlay");a.style.display="none";document.body.appendChild(a);Popup.overlay= a;Popup.overlay_levels=[]}Popup.overlay.style.height=this.get_page_dimensions().height+"px";a=Popup.zIndex++;Popup.overlay.style.zIndex=a;Popup.overlay_levels.push(a);1==Popup.overlay_levels.length?new Effect.Appear(Popup.overlay,{duration:this.options.show_duration,to:this.options.opacity,queue:{position:"end",scope:"popup_overlay"}}):Popup.overlay.style.zIndex=a},hide_overlay:function(){Popup.overlay_levels.pop();var a=Popup.overlay_levels.pop();a?(Popup.overlay_levels.push(a),Popup.overlay.style.zIndex= a):new Effect.Fade(Popup.overlay,{duration:this.options.hide_duration,queue:{position:"end",scope:"popup_overlay"}})},get_popup_position:function(a,c){var b;switch(this.options.position){case "auto":b=this.get_auto_position(a,c);break;case "center":b=this.get_center_position();break;case "below":b=this.get_below_position();break;default:(mo=this.options.position.match(/^\s*([^\s,]+)\s*,\s*([^\s,]+)\s*$/))?(b={x:mo[1],y:mo[2]},b.x=Number(b.x)||b.x,b.y=Number(b.y)||b.y):b={x:0,y:0}}"number"==typeof b.x&& (b.x+="px");"number"==typeof b.y&&(b.y+="px");return b},get_below_position:function(){var a=Position.cumulativeOffset(this.link);return{x:a[0],y:a[1]+Element.getHeight(this.link)}},get_center_position:function(){dim=Element.getDimensions(this.popup);var a=dim.width,c=dim.height;dim=this.get_viewport_dimensions();var b=dim.width,d=dim.height;return{x:a>=b?0:(b-a)/2,y:c>=d?0:(d-c)/2}},get_auto_position:function(a,c){dim=Element.getDimensions(this.popup);var b=dim.width,d=dim.height;dim=this.get_viewport_dimensions(); var f=dim.width,g=dim.height,h=f-(a+this.options.cursor_margin),j=a-this.options.cursor_margin,k=c-this.options.cursor_margin,l=g-(a+this.options.cursor_margin),e=this.options.cursor_margin,m=a,n=c;return{x:b>=f?0:b<=h?m+e:b<=j?m-(b+e):h>=j?f-b:0,y:d>=g?0:d<=l?n+e:d<=k?n-(d+e):l>=k?g-d:0}},get_viewport_dimensions:function(){var a=this.getPageSize();return{width:a[2],height:a[3]}},get_page_dimensions:function(){var a=this.getPageSize();return{width:a[0],height:a[1]}},getPageSize:function(){var a,c; window.innerHeight&&window.scrollMaxY?(a=document.body.scrollWidth,c=window.innerHeight+window.scrollMaxY):document.body.scrollHeight>document.body.offsetHeight?(a=document.body.scrollWidth,c=document.body.scrollHeight):(a=document.body.offsetWidth,c=document.body.offsetHeight);var b,d;self.innerHeight?(b=self.innerWidth,d=self.innerHeight):document.documentElement&&document.documentElement.clientHeight?(b=document.documentElement.clientWidth,d=document.documentElement.clientHeight):document.body&& (b=document.body.clientWidth,d=document.body.clientHeight);pageHeight=c<d?d:c;pageWidth=a<b?b:a;return arrayPageSize=[pageWidth,pageHeight,b,d]}};