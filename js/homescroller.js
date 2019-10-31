	/*
	You can choose from any of the following named effects:

    * blindX
    * blindY
    * blindZ
    * cover
    * curtainX
    * curtainY
    * fade
    * fadeZoom
    * growX
    * growY
    * scrollUp
    * scrollDown
    * scrollLeft
    * scrollRight
    * scrollHorz
    * scrollVert
    * shuffle
    * slideX
    * slideY
    * toss
    * turnUp
    * turnDown
    * turnLeft
    * turnRight
    * uncover
    * wipe
    * zoom
	
	// override these globally if you like (they are all optional) 
$.fn.cycle.defaults = { 
    fx:           'fade', // name of transition effect (or comma separated names, ex: fade,scrollUp,shuffle) 
    timeout:       4000,  // milliseconds between slide transitions (0 to disable auto advance) 
    timeoutFn:     null,  // callback for determining per-slide timeout value:  function(currSlideElement, nextSlideElement, options, forwardFlag) 
    continuous:    0,     // true to start next transition immediately after current one completes 
    speed:         1000,  // speed of the transition (any valid fx speed value) 
    speedIn:       null,  // speed of the 'in' transition 
    speedOut:      null,  // speed of the 'out' transition 
    next:          null,  // selector for element to use as click trigger for next slide 
    prev:          null,  // selector for element to use as click trigger for previous slide 
    prevNextClick: null,  // callback fn for prev/next clicks:  function(isNext, zeroBasedSlideIndex, slideElement) 
    pager:         null,  // selector for element to use as pager container 
    pagerClick:    null,  // callback fn for pager clicks:  function(zeroBasedSlideIndex, slideElement) 
    pagerEvent:   'click', // name of event which drives the pager navigation 
    pagerAnchorBuilder: null, // callback fn for building anchor links:  function(index, DOMelement) 
    before:        null,  // transition callback (scope set to element to be shown):     function(currSlideElement, nextSlideElement, options, forwardFlag) 
    after:         null,  // transition callback (scope set to element that was shown):  function(currSlideElement, nextSlideElement, options, forwardFlag) 
    end:           null,  // callback invoked when the slideshow terminates (use with autostop or nowrap options): function(options) 
    easing:        null,  // easing method for both in and out transitions 
    easeIn:        null,  // easing for "in" transition 
    easeOut:       null,  // easing for "out" transition 
    shuffle:       null,  // coords for shuffle animation, ex: { top:15, left: 200 } 
    animIn:        null,  // properties that define how the slide animates in 
    animOut:       null,  // properties that define how the slide animates out 
    cssBefore:     null,  // properties that define the initial state of the slide before transitioning in 
    cssAfter:      null,  // properties that defined the state of the slide after transitioning out 
    fxFn:          null,  // function used to control the transition: function(currSlideElement, nextSlideElement, options, afterCalback, forwardFlag) 
    height:       'auto', // container height 
    startingSlide: 0,     // zero-based index of the first slide to be displayed 
    sync:          1,     // true if in/out transitions should occur simultaneously 
    random:        0,     // true for random, false for sequence (not applicable to shuffle fx) 
    fit:           0,     // force slides to fit container 
    containerResize: 1,   // resize container to fit largest slide 
    pause:         0,     // true to enable "pause on hover" 
    pauseOnPagerHover: 0, // true to pause when hovering over pager link 
    autostop:      0,     // true to end slideshow after X transitions (where X == slide count) 
    autostopCount: 0,     // number of transitions (optionally used with autostop to define X) 
    delay:         0,     // additional delay (in ms) for first transition (hint: can be negative) 
    slideExpr:     null,  // expression for selecting slides (if something other than all children is required) 
    cleartype:     !$.support.opacity,  // true if clearType corrections should be applied (for IE) 
    cleartypeNoBg: false, // set to true to disable extra cleartype fixing (leave false to force background color setting on slides) 
    nowrap:        0,     // true to prevent slideshow from wrapping 
    fastOnEvent:   0,     // force fast transitions when triggered manually (via pager or prev/next); value == time in ms 
    randomizeEffects: 1,  // valid when multiple effects are used; true to make the effect sequence random 
    rev:           0,     // causes animations to transition in reverse 
    manualTrump:   true,  // causes manual transition to stop an active transition instead of being ignored 
    requeueOnImageNotLoaded: true, // requeue the slideshow if any image slides are not yet loaded 
    requeueTimeout: 250   // ms delay for requeue 
};

<font color=red size=+1>WARNING TESTING ONLY</font>
Database date is June 25, 2009 11:08pm

*/jQuery(document).ready(function(a){function e(){document.getElementById("slideshow").style.visibility="visible";a("#indexText").html('<a href="'+this.href+'">'+this.title+"</a>")}a.fn.cycle.updateActivePagerLink=function(d,c){var b=c-1;0>b?a(d).find("li").removeClass("activeSlide6").filter("li:eq(6)").addClass("normal6"):a(d).find("li").removeClass("activeSlide"+b).filter("li:eq("+b+")").addClass("normal"+b);a(d).find("li").removeClass("normal"+c).filter("li:eq("+ c+")").addClass("activeSlide"+c);for(b=0;6>=b;b++)b!=c&&a(d).find("li").removeClass("activeSlide"+b).filter("li:eq("+b+")").addClass("normal"+b)};a(function(){a("#indexText").after('<div class="pager"><ul id="fancy'+browser+'menu"></ul></div>');a("#slideshow").cycle({fx:"scrollHorz",speed:1E3,timeout:7E3,rev:0,easing:"easeInOutBack",pager:"#fancy"+browser+"menu",before:e,pagerAnchorBuilder:function(){return"<li><a href=#></a></li>"}})});a("#slideshowSync"+browser).cycle({fx:"fade",timeout:0,speed:1E3, startingSlide:0})});function onPausePlay(){!0==Play?(Play=!1,jQuery("#slideshow").cycle("pause"),document.getElementById("playpauseimg"+browser).src=base_url+"images/play-btn.png",document.getElementById("playpauseimg"+browser).title="Play"):(Play=!0,jQuery("#slideshow").cycle("resume"),document.getElementById("playpauseimg"+browser).src=base_url+"images/pause-btn.png",document.getElementById("playpauseimg"+browser).title="Pause")} function onMouseOverPP(){!0==Play?document.getElementById("playpauseimg"+browser).src=base_url+"images/pause-wht.png":document.getElementById("playpauseimg"+browser).src=base_url+"images/play-wht.png"}function onMouseOutPP(){!0==Play?document.getElementById("playpauseimg"+browser).src=base_url+"images/pause-btn.png":document.getElementById("playpauseimg"+browser).src=base_url+"images/play-btn.png"};