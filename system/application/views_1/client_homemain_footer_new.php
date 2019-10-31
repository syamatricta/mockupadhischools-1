		</div>


<!--                <script src="<?php echo $this->config->item('site_baseurl');?>js/jquery-1.4.2.min.js" type="text/javascript"></script>-->

	</div>
    <div class="footer_img">
 
    </div>
 <script>
     function __blockbtmdiv(){
         if($('moredivcnt').style.display=='block'){
                $('moredivcnt').style.display='none';
         }else{
                $('moredivcnt').style.display='block';
         }
 }
    //$(document).ready(function() {
         //$("#morediv").click(function () {
            //if ($("#moredivcnt").is(":hidden")) {
              //  $("#moredivcnt").slideDown("slow");
            //}else {
            //    $("#moredivcnt").slideUp("slow");
           // }
        // });
   // });


/* Start WebsiteAlive AliveTracker Code */
function wsa_include_js(){
var wsa_host = (("https:" == document.location.protocol) ? "https://" : "http://");
var js = document.createElement("script");
js.setAttribute("language", "javascript");
js.setAttribute("type", "text/javascript");
js.setAttribute("src",wsa_host + "tracking-v3.websitealive.com/3.0/?objectref=c1&groupid=687&websiteid=0");
document.getElementsByTagName("head").item(0).appendChild(js);
}
if (window.attachEvent) {window.attachEvent("onload", wsa_include_js);}
else if (window.addEventListener) {window.addEventListener("load", wsa_include_js, false);}
else {document.addEventListener("load", wsa_include_js, false);}
/* End WebsiteAlive AliveTracker v3.0 Code */

/*Start AliveChat Tracking Code
function wsa_include_js(){
	var wsa_host = (('https:' == document.location.protocol) ? 'https://' : 'http://');
	var js = document.createElement('script');
	js.setAttribute('language', 'javascript');
	js.setAttribute('type', 'text/javascript');
	js.setAttribute('src',wsa_host + 'tracking.websitealive.com/vTracker_v2.asp?objectref=c1&groupid=687&websiteid=0');
	document.getElementsByTagName('head').item(0).appendChild(js);}
if (window.attachEvent) {window.attachEvent('onload', wsa_include_js);}
else if (window.addEventListener) {window.addEventListener('load', wsa_include_js, false);}
else {document.addEventListener('load', wsa_include_js, false);};
/*End AliveChat Tracking Code*/

</script>
</body>
</html>
