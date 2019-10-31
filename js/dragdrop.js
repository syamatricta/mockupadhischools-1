// Copyright (c) 2005-2009 Thomas Fuchs (http://script.aculo.us, http://mir.aculo.us)
//
// script.aculo.us is freely distributable under the terms of an MIT-style license.
// For details, see the script.aculo.us web site: http://script.aculo.us/

; if(Object.isUndefined(Effect))throw"dragdrop.js requires including script.aculo.us' effects.js library"; var Droppables={drops:[],remove:function(a){this.drops=this.drops.reject(function(c){return c.element==$(a)})},add:function(a,c){a=$(a);var b=Object.extend({greedy:!0,hoverclass:null,tree:!1},c||{});if(b.containment){b._containers=[];var d=b.containment;Object.isArray(d)?d.each(function(a){b._containers.push($(a))}):b._containers.push($(d))}b.accept&&(b.accept=[b.accept].flatten());Element.makePositioned(a);b.element=a;this.drops.push(b)},findDeepestChild:function(a){deepest=a[0];for(i=1;i<a.length;++i)Element.isParent(a[i].element, deepest.element)&&(deepest=a[i]);return deepest},isContained:function(a,c){var b;b=c.tree?a.treeNode:a.parentNode;return c._containers.detect(function(a){return b==a})},isAffected:function(a,c,b){return b.element!=c&&(!b._containers||this.isContained(c,b))&&(!b.accept||Element.classNames(c).detect(function(a){return b.accept.include(a)}))&&Position.within(b.element,a[0],a[1])},deactivate:function(a){a.hoverclass&&Element.removeClassName(a.element,a.hoverclass);this.last_active=null},activate:function(a){a.hoverclass&& Element.addClassName(a.element,a.hoverclass);this.last_active=a},show:function(a,c){if(this.drops.length){var b,d=[];this.drops.each(function(b){Droppables.isAffected(a,c,b)&&d.push(b)});0<d.length&&(b=Droppables.findDeepestChild(d));this.last_active&&this.last_active!=b&&this.deactivate(this.last_active);if(b){Position.within(b.element,a[0],a[1]);if(b.onHover)b.onHover(c,b.element,Position.overlap(b.overlap,b.element));b!=this.last_active&&Droppables.activate(b)}}},fire:function(a,c){if(this.last_active&& (Position.prepare(),this.isAffected([Event.pointerX(a),Event.pointerY(a)],c,this.last_active)&&this.last_active.onDrop))return this.last_active.onDrop(c,this.last_active.element,a),!0},reset:function(){this.last_active&&this.deactivate(this.last_active)}},Draggables={drags:[],observers:[],register:function(a){0==this.drags.length&&(this.eventMouseUp=this.endDrag.bindAsEventListener(this),this.eventMouseMove=this.updateDrag.bindAsEventListener(this),this.eventKeypress=this.keyPress.bindAsEventListener(this), Event.observe(document,"mouseup",this.eventMouseUp),Event.observe(document,"mousemove",this.eventMouseMove),Event.observe(document,"keypress",this.eventKeypress));this.drags.push(a)},unregister:function(a){this.drags=this.drags.reject(function(c){return c==a});0==this.drags.length&&(Event.stopObserving(document,"mouseup",this.eventMouseUp),Event.stopObserving(document,"mousemove",this.eventMouseMove),Event.stopObserving(document,"keypress",this.eventKeypress))},activate:function(a){a.options.delay? this._timeout=setTimeout(function(){Draggables._timeout=null;window.focus();Draggables.activeDraggable=a}.bind(this),a.options.delay):(window.focus(),this.activeDraggable=a)},deactivate:function(){this.activeDraggable=null},updateDrag:function(a){if(this.activeDraggable){var c=[Event.pointerX(a),Event.pointerY(a)];this._lastPointer&&this._lastPointer.inspect()==c.inspect()||(this._lastPointer=c,this.activeDraggable.updateDrag(a,c))}},endDrag:function(a){this._timeout&&(clearTimeout(this._timeout), this._timeout=null);this.activeDraggable&&(this._lastPointer=null,this.activeDraggable.endDrag(a),this.activeDraggable=null)},keyPress:function(a){this.activeDraggable&&this.activeDraggable.keyPress(a)},addObserver:function(a){this.observers.push(a);this._cacheObserverCallbacks()},removeObserver:function(a){this.observers=this.observers.reject(function(c){return c.element==a});this._cacheObserverCallbacks()},notify:function(a,c,b){0<this[a+"Count"]&&this.observers.each(function(d){if(d[a])d[a](a, c,b)});if(c.options[a])c.options[a](c,b)},_cacheObserverCallbacks:function(){["onStart","onEnd","onDrag"].each(function(a){Draggables[a+"Count"]=Draggables.observers.select(function(c){return c[a]}).length})}},Draggable=Class.create({initialize:function(a,c){var b={handle:!1,reverteffect:function(a,b,c){var g=0.02*Math.sqrt(Math.abs(b^2)+Math.abs(c^2));new Effect.Move(a,{x:-c,y:-b,duration:g,queue:{scope:"_draggable",position:"end"}})},endeffect:function(a){var b=Object.isNumber(a._opacity)?a._opacity: 1;new Effect.Opacity(a,{duration:0.2,from:0.7,to:b,queue:{scope:"_draggable",position:"end"},afterFinish:function(){Draggable._dragging[a]=!1}})},zindex:1E3,revert:!1,quiet:!1,scroll:!1,scrollSensitivity:20,scrollSpeed:15,snap:!1,delay:0};(!c||Object.isUndefined(c.endeffect))&&Object.extend(b,{starteffect:function(a){a._opacity=Element.getOpacity(a);Draggable._dragging[a]=!0;new Effect.Opacity(a,{duration:0.2,from:a._opacity,to:0.7})}});b=Object.extend(b,c||{});this.element=$(a);b.handle&&Object.isString(b.handle)&& (this.handle=this.element.down("."+b.handle,0));this.handle||(this.handle=$(b.handle));this.handle||(this.handle=this.element);b.scroll&&(!b.scroll.scrollTo&&!b.scroll.outerHTML)&&(b.scroll=$(b.scroll),this._isScrollChild=Element.childOf(this.element,b.scroll));Element.makePositioned(this.element);this.options=b;this.dragging=!1;this.eventMouseDown=this.initDrag.bindAsEventListener(this);Event.observe(this.handle,"mousedown",this.eventMouseDown);Draggables.register(this)},destroy:function(){Event.stopObserving(this.handle, "mousedown",this.eventMouseDown);Draggables.unregister(this)},currentDelta:function(){return[parseInt(Element.getStyle(this.element,"left")||"0"),parseInt(Element.getStyle(this.element,"top")||"0")]},initDrag:function(a){if(Object.isUndefined(Draggable._dragging[this.element])||!Draggable._dragging[this.element])if(Event.isLeftClick(a)&&(!(tag_name=Event.element(a).tagName.toUpperCase())||!("INPUT"==tag_name||"SELECT"==tag_name||"OPTION"==tag_name||"BUTTON"==tag_name||"TEXTAREA"==tag_name))){var c= [Event.pointerX(a),Event.pointerY(a)],b=this.element.cumulativeOffset();this.offset=[0,1].map(function(a){return c[a]-b[a]});Draggables.activate(this);Event.stop(a)}},startDrag:function(a){this.dragging=!0;this.delta||(this.delta=this.currentDelta());this.options.zindex&&(this.originalZ=parseInt(Element.getStyle(this.element,"z-index")||0),this.element.style.zIndex=this.options.zindex);this.options.ghosting&&(this._clone=this.element.cloneNode(!0),(this._originallyAbsolute="absolute"==this.element.getStyle("position"))|| Position.absolutize(this.element),this.element.parentNode.insertBefore(this._clone,this.element));if(this.options.scroll)if(this.options.scroll==window){var c=this._getWindowScroll(this.options.scroll);this.originalScrollLeft=c.left;this.originalScrollTop=c.top}else this.originalScrollLeft=this.options.scroll.scrollLeft,this.originalScrollTop=this.options.scroll.scrollTop;Draggables.notify("onStart",this,a);this.options.starteffect&&this.options.starteffect(this.element)},updateDrag:function(a,c){this.dragging|| this.startDrag(a);this.options.quiet||(Position.prepare(),Droppables.show(c,this.element));Draggables.notify("onDrag",this,a);this.draw(c);this.options.change&&this.options.change(this);if(this.options.scroll){this.stopScrolling();var b;if(this.options.scroll==window)with(this._getWindowScroll(this.options.scroll))b=[left,top,left+width,top+height];else b=Position.page(this.options.scroll),b[0]+=this.options.scroll.scrollLeft+Position.deltaX,b[1]+=this.options.scroll.scrollTop+Position.deltaY,b.push(b[0]+ this.options.scroll.offsetWidth),b.push(b[1]+this.options.scroll.offsetHeight);var d=[0,0];c[0]<b[0]+this.options.scrollSensitivity&&(d[0]=c[0]-(b[0]+this.options.scrollSensitivity));c[1]<b[1]+this.options.scrollSensitivity&&(d[1]=c[1]-(b[1]+this.options.scrollSensitivity));c[0]>b[2]-this.options.scrollSensitivity&&(d[0]=c[0]-(b[2]-this.options.scrollSensitivity));c[1]>b[3]-this.options.scrollSensitivity&&(d[1]=c[1]-(b[3]-this.options.scrollSensitivity));this.startScrolling(d)}Prototype.Browser.WebKit&& window.scrollBy(0,0);Event.stop(a)},finishDrag:function(a,c){this.dragging=!1;if(this.options.quiet){Position.prepare();var b=[Event.pointerX(a),Event.pointerY(a)];Droppables.show(b,this.element)}this.options.ghosting&&(this._originallyAbsolute||Position.relativize(this.element),delete this._originallyAbsolute,Element.remove(this._clone),this._clone=null);b=!1;c&&((b=Droppables.fire(a,this.element))||(b=!1));if(b&&this.options.onDropped)this.options.onDropped(this.element);Draggables.notify("onEnd", this,a);var d=this.options.revert;d&&Object.isFunction(d)&&(d=d(this.element));var e=this.currentDelta();d&&this.options.reverteffect?(0==b||"failure"!=d)&&this.options.reverteffect(this.element,e[1]-this.delta[1],e[0]-this.delta[0]):this.delta=e;this.options.zindex&&(this.element.style.zIndex=this.originalZ);this.options.endeffect&&this.options.endeffect(this.element);Draggables.deactivate(this);Droppables.reset()},keyPress:function(a){a.keyCode==Event.KEY_ESC&&(this.finishDrag(a,!1),Event.stop(a))}, endDrag:function(a){this.dragging&&(this.stopScrolling(),this.finishDrag(a,!0),Event.stop(a))},draw:function(a){var c=this.element.cumulativeOffset();if(this.options.ghosting){var b=Position.realOffset(this.element);c[0]+=b[0]-Position.deltaX;c[1]+=b[1]-Position.deltaY}b=this.currentDelta();c[0]-=b[0];c[1]-=b[1];this.options.scroll&&(this.options.scroll!=window&&this._isScrollChild)&&(c[0]-=this.options.scroll.scrollLeft-this.originalScrollLeft,c[1]-=this.options.scroll.scrollTop-this.originalScrollTop); b=[0,1].map(function(b){return a[b]-c[b]-this.offset[b]}.bind(this));this.options.snap&&(b=Object.isFunction(this.options.snap)?this.options.snap(b[0],b[1],this):Object.isArray(this.options.snap)?b.map(function(a,b){return(a/this.options.snap[b]).round()*this.options.snap[b]}.bind(this)):b.map(function(a){return(a/this.options.snap).round()*this.options.snap}.bind(this)));var d=this.element.style;if(!this.options.constraint||"horizontal"==this.options.constraint)d.left=b[0]+"px";if(!this.options.constraint|| "vertical"==this.options.constraint)d.top=b[1]+"px";"hidden"==d.visibility&&(d.visibility="")},stopScrolling:function(){this.scrollInterval&&(clearInterval(this.scrollInterval),this.scrollInterval=null,Draggables._lastScrollPointer=null)},startScrolling:function(a){if(a[0]||a[1])this.scrollSpeed=[a[0]*this.options.scrollSpeed,a[1]*this.options.scrollSpeed],this.lastScrolled=new Date,this.scrollInterval=setInterval(this.scroll.bind(this),10)},scroll:function(){var a=new Date,c=a-this.lastScrolled; this.lastScrolled=a;if(this.options.scroll==window)with(this._getWindowScroll(this.options.scroll)){if(this.scrollSpeed[0]||this.scrollSpeed[1])a=c/1E3,this.options.scroll.scrollTo(left+a*this.scrollSpeed[0],top+a*this.scrollSpeed[1])}else this.options.scroll.scrollLeft+=this.scrollSpeed[0]*c/1E3,this.options.scroll.scrollTop+=this.scrollSpeed[1]*c/1E3;Position.prepare();Droppables.show(Draggables._lastPointer,this.element);Draggables.notify("onDrag",this);this._isScrollChild&&(Draggables._lastScrollPointer= Draggables._lastScrollPointer||$A(Draggables._lastPointer),Draggables._lastScrollPointer[0]+=this.scrollSpeed[0]*c/1E3,Draggables._lastScrollPointer[1]+=this.scrollSpeed[1]*c/1E3,0>Draggables._lastScrollPointer[0]&&(Draggables._lastScrollPointer[0]=0),0>Draggables._lastScrollPointer[1]&&(Draggables._lastScrollPointer[1]=0),this.draw(Draggables._lastScrollPointer));this.options.change&&this.options.change(this)},_getWindowScroll:function(a){var c,b,d;with(a.document)a.document.documentElement&&documentElement.scrollTop? (c=documentElement.scrollTop,b=documentElement.scrollLeft):a.document.body&&(c=body.scrollTop,b=body.scrollLeft),a.innerWidth?(d=a.innerWidth,a=a.innerHeight):a.document.documentElement&&documentElement.clientWidth?(d=documentElement.clientWidth,a=documentElement.clientHeight):(d=body.offsetWidth,a=body.offsetHeight);return{top:c,left:b,width:d,height:a}}});Draggable._dragging={}; var SortableObserver=Class.create({initialize:function(a,c){this.element=$(a);this.observer=c;this.lastValue=Sortable.serialize(this.element)},onStart:function(){this.lastValue=Sortable.serialize(this.element)},onEnd:function(){Sortable.unmark();this.lastValue!=Sortable.serialize(this.element)&&this.observer(this.element)}}),Sortable={SERIALIZE_RULE:/^[^_\-](?:[A-Za-z0-9\-\_]*)[_](.*)$/,sortables:{},_findRootElement:function(a){for(;"BODY"!=a.tagName.toUpperCase();){if(a.id&&Sortable.sortables[a.id])return a; a=a.parentNode}},options:function(a){if(a=Sortable._findRootElement($(a)))return Sortable.sortables[a.id]},destroy:function(a){a=$(a);if(a=Sortable.sortables[a.id])Draggables.removeObserver(a.element),a.droppables.each(function(a){Droppables.remove(a)}),a.draggables.invoke("destroy"),delete Sortable.sortables[a.element.id]},create:function(a,c){a=$(a);var b=Object.extend({element:a,tag:"li",dropOnEmpty:!1,tree:!1,treeTag:"ul",overlap:"vertical",constraint:"vertical",containment:a,handle:!1,only:!1, delay:0,hoverclass:null,ghosting:!1,quiet:!1,scroll:!1,scrollSensitivity:20,scrollSpeed:15,format:this.SERIALIZE_RULE,elements:!1,handles:!1,onChange:Prototype.emptyFunction,onUpdate:Prototype.emptyFunction},c||{});this.destroy(a);var d={revert:!0,quiet:b.quiet,scroll:b.scroll,scrollSpeed:b.scrollSpeed,scrollSensitivity:b.scrollSensitivity,delay:b.delay,ghosting:b.ghosting,constraint:b.constraint,handle:b.handle};b.starteffect&&(d.starteffect=b.starteffect);b.reverteffect?d.reverteffect=b.reverteffect: b.ghosting&&(d.reverteffect=function(a){a.style.top=0;a.style.left=0});b.endeffect&&(d.endeffect=b.endeffect);b.zindex&&(d.zindex=b.zindex);var e={overlap:b.overlap,containment:b.containment,tree:b.tree,hoverclass:b.hoverclass,onHover:Sortable.onHover},f={onHover:Sortable.onEmptyHover,overlap:b.overlap,containment:b.containment,hoverclass:b.hoverclass};Element.cleanWhitespace(a);b.draggables=[];b.droppables=[];if(b.dropOnEmpty||b.tree)Droppables.add(a,f),b.droppables.push(a);(b.elements||this.findElements(a, b)||[]).each(function(c,f){var j=b.handles?$(b.handles[f]):b.handle?$(c).select("."+b.handle)[0]:c;b.draggables.push(new Draggable(c,Object.extend(d,{handle:j})));Droppables.add(c,e);b.tree&&(c.treeNode=a);b.droppables.push(c)});b.tree&&(Sortable.findTreeElements(a,b)||[]).each(function(c){Droppables.add(c,f);c.treeNode=a;b.droppables.push(c)});this.sortables[a.identify()]=b;Draggables.addObserver(new SortableObserver(a,b.onUpdate))},findElements:function(a,c){return Element.findChildren(a,c.only, c.tree?!0:!1,c.tag)},findTreeElements:function(a,c){return Element.findChildren(a,c.only,c.tree?!0:!1,c.treeTag)},onHover:function(a,c,b){if(!Element.isParent(c,a)&&!(0.33<b&&0.66>b&&Sortable.options(c).tree))if(0.5<b){if(Sortable.mark(c,"before"),c.previousSibling!=a){b=a.parentNode;a.style.visibility="hidden";c.parentNode.insertBefore(a,c);if(c.parentNode!=b)Sortable.options(b).onChange(a);Sortable.options(c.parentNode).onChange(a)}}else{Sortable.mark(c,"after");var d=c.nextSibling||null;if(d!= a){b=a.parentNode;a.style.visibility="hidden";c.parentNode.insertBefore(a,d);if(c.parentNode!=b)Sortable.options(b).onChange(a);Sortable.options(c.parentNode).onChange(a)}}},onEmptyHover:function(a,c,b){var d=a.parentNode,e=Sortable.options(c);if(!Element.isParent(c,a)){var f=Sortable.findElements(c,{tag:e.tag,only:e.only}),g=null;if(f){var h=Element.offsetSize(c,e.overlap)*(1-b);for(b=0;b<f.length;b+=1)if(0<=h-Element.offsetSize(f[b],e.overlap))h-=Element.offsetSize(f[b],e.overlap);else{g=0<=h-Element.offsetSize(f[b], e.overlap)/2?b+1<f.length?f[b+1]:null:f[b];break}}c.insertBefore(a,g);Sortable.options(d).onChange(a);e.onChange(a)}},unmark:function(){Sortable._marker&&Sortable._marker.hide()},mark:function(a,c){var b=Sortable.options(a.parentNode);if(!b||b.ghosting){Sortable._marker||(Sortable._marker=($("dropmarker")||Element.extend(document.createElement("DIV"))).hide().addClassName("dropmarker").setStyle({position:"absolute"}),document.getElementsByTagName("body").item(0).appendChild(Sortable._marker));var d= a.cumulativeOffset();Sortable._marker.setStyle({left:d[0]+"px",top:d[1]+"px"});"after"==c&&("horizontal"==b.overlap?Sortable._marker.setStyle({left:d[0]+a.clientWidth+"px"}):Sortable._marker.setStyle({top:d[1]+a.clientHeight+"px"}));Sortable._marker.show()}},_tree:function(a,c,b){for(var d=Sortable.findElements(a,c)||[],e=0;e<d.length;++e){var f=d[e].id.match(c.format);f&&(f={id:encodeURIComponent(f?f[1]:null),element:a,parent:b,children:[],position:b.children.length,container:$(d[e]).down(c.treeTag)}, f.container&&this._tree(f.container,c,f),b.children.push(f))}return b},tree:function(a,c){a=$(a);var b=this.options(a),b=Object.extend({tag:b.tag,treeTag:b.treeTag,only:b.only,name:a.id,format:b.format},c||{});return Sortable._tree(a,b,{id:null,parent:null,children:[],container:a,position:0})},_constructIndex:function(a){var c="";do a.id&&(c="["+a.position+"]"+c);while(null!=(a=a.parent));return c},sequence:function(a,c){a=$(a);var b=Object.extend(this.options(a),c||{});return $(this.findElements(a, b)||[]).map(function(a){return a.id.match(b.format)?a.id.match(b.format)[1]:""})},setSequence:function(a,c,b){a=$(a);var d=Object.extend(this.options(a),b||{}),e={};this.findElements(a,d).each(function(a){a.id.match(d.format)&&(e[a.id.match(d.format)[1]]=[a,a.parentNode]);a.parentNode.removeChild(a)});c.each(function(a){var b=e[a];b&&(b[1].appendChild(b[0]),delete e[a])})},serialize:function(a,c){a=$(a);var b=Object.extend(Sortable.options(a),c||{}),d=encodeURIComponent(c&&c.name?c.name:a.id);return b.tree? Sortable.tree(a,c).children.map(function(a){return[d+Sortable._constructIndex(a)+"[id]="+encodeURIComponent(a.id)].concat(a.children.map(arguments.callee))}).flatten().join("&"):Sortable.sequence(a,c).map(function(a){return d+"[]="+encodeURIComponent(a)}).join("&")}};Element.isParent=function(a,c){return!a.parentNode||a==c?!1:a.parentNode==c?!0:Element.isParent(a.parentNode,c)}; Element.findChildren=function(a,c,b,d){if(!a.hasChildNodes())return null;d=d.toUpperCase();c&&(c=[c].flatten());var e=[];$A(a.childNodes).each(function(a){a.tagName&&(a.tagName.toUpperCase()==d&&(!c||Element.classNames(a).detect(function(a){return c.include(a)})))&&e.push(a);b&&(a=Element.findChildren(a,c,b,d))&&e.push(a)});return 0<e.length?e.flatten():[]};Element.offsetSize=function(a,c){return a["offset"+("vertical"==c||"height"==c?"Height":"Width")]};