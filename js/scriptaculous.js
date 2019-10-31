// script.aculo.us scriptaculous.js v1.8.1, Thu Jan 03 22:07:12 -0500 2008

// Copyright (c) 2005-2007 Thomas Fuchs (http://script.aculo.us, http://mir.aculo.us)
// 
// Permission is hereby granted, free of charge, to any person obtaining
// a copy of this software and associated documentation files (the
// "Software"), to deal in the Software without restriction, including
// without limitation the rights to use, copy, modify, merge, publish,
// distribute, sublicense, and/or sell copies of the Software, and to
// permit persons to whom the Software is furnished to do so, subject to
// the following conditions:
// 
// The above copyright notice and this permission notice shall be
// included in all copies or substantial portions of the Software.
//
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
// EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
// MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
// NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
// LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
// OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
// WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
//
// For details, see the script.aculo.us web site: http://script.aculo.us/
; var Scriptaculous={Version:"1.8.1",require:function(b){document.write('<script type="text/javascript" src="'+b+'">\x3c/script>')},REQUIRED_PROTOTYPE:"1.6.0",load:function(){function b(a){a=a.split(".");return 1E5*parseInt(a[0])+1E3*parseInt(a[1])+parseInt(a[2])}if("undefined"==typeof Prototype||"undefined"==typeof Element||"undefined"==typeof Element.Methods||b(Prototype.Version)<b(Scriptaculous.REQUIRED_PROTOTYPE))throw"script.aculo.us requires the Prototype JavaScript framework >= "+Scriptaculous.REQUIRED_PROTOTYPE; $A(document.getElementsByTagName("script")).findAll(function(a){return a.src&&a.src.match(/scriptaculous\.js(\?.*)?$/)}).each(function(a){var b=a.src.replace(/scriptaculous\.js(\?.*)?$/,"");a=a.src.match(/\?.*load=([a-z,]*)/);(a?a[1]:"builder,effects,dragdrop,controls,slider,sound").split(",").each(function(a){Scriptaculous.require(b+a+".js")})})}};Scriptaculous.load();