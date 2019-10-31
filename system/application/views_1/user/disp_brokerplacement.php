<script src="<?php echo $this->config->item('site_baseurl');?>js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $this->config->item('google_map_key')?>" type="text/javascript"></script>
<script src="http://www.google.com/uds/api?file=uds.js&amp;v=1.0&amp;key=<?php echo $this->config->item('google_map_key')?>" type="text/javascript"></script>
<script src="<?php echo $this->config->item('site_baseurl');?>js/gmap.js"></script>
<script type="text/javascript">
    <?php if(count($postcode_map_data)>0){ $t=1;?>
            $(document).ready(function() {
            <?php foreach($postcode_map_data as $datdet){ ?>
                     $('#mtgt_unnamed_<?php echo $t;?>').click(function() {
                        $.ajax({
                                url: base_url+"home/brokerplacementdetails/<?php echo $datdet->sub_postcode; ?>",
                                type: 'POST',
                                dataType: 'html',
                                data: { },
                                success: function(data){
                                                        $('#brokerclass').show();
                                                        $('#broker').html(data);
                                }
                            });
                    });
                    $('#popup_close').click(function(){
                        $('#brokerclass').hide();
                    });
                    <?php $t++;} ?>
                });
         <?php } ?>
          document.getElementById("map_container").getElementsByTagName("img").src = "http://dev.rainconcert.in/adhischools/images/gmap/pin_32_32.png";

</script>
<div class="floatleft" >
   <div class="left_cntnr" style="position: relative; padding-bottom:100px">
         <?php $this ->load->view('left_content_home.php');?>
    </div>
 
    <div class="right_cntnr">
        <div class="right_cntnr_bg_hd" >
            <div class="floatleft" style="width:100%;">
                 <div class="sitepagehead"><?php if(isset($pagedetails->title) && $pagedetails->title !=''){print($pagedetails->title); } ?></div>
                 <div class="username"><?php echo $this->session->userdata('USER_NAME')." ". $this->session->userdata('LAST_NAME'); ?></div>
            </div>
<!--          		<div class="sitepagehead"><?php if(isset($pagedetails->title) && $pagedetails->title !=''){print($pagedetails->title); } ?></div>-->
	</div>
        <div class="clearboth"></div>
        <div class="right_cntnr_bg" >
         <div id="sitepagemain">
                <?php if(count($pagedetails)>0){?>
                                <div class="sitepagecontent"><?php print($pagedetails->content); ?></div>
                <?php } ?>
        </div>
        <div style="clear:both;"></div>
			
	<!-- <Map Container> -->
	<div>
            <div class="gmap_top"></div>
            <div class="gmap_middle">
                <div id="map_container" class="fl map_container">
                    <div align="center" style="padding-top:300px;">
                        <img align="center" src="<?php echo $this->config->item('image_url')?>clock.gif">
		    </div>
		    <script type="text/javascript">
                        if (GBrowserIsCompatible()) {
                            var gmarkers    = [];
                            function createMarker(point,html) {
                                var marker = new GMarker(point);
				GEvent.addListener(marker, "click", function() {
                                marker.openInfoWindowHtml(html);
                                });
                                return marker;
                            }
                            function myclick(i) {
                                gmarkers[i].openInfoWindowHtml(htmls[i]);
				setBottom(data1[i].garageid);
                            }
                            <?php if($postcode_lat_long){?>
                                    // Display the map, with some controls and set the initial location
                                    var map = new GMap2(document.getElementById("map_container"));
                                    map.addControl(new GLargeMapControl());
                                    map.addControl(new GMapTypeControl());
                                    var map_center	=	new GLatLng(<?php echo $postcode_lat_long->co_lattitude;?>,<?php echo $postcode_lat_long->co_longitude;?>);
                                   <?php $zoom_level	=	8; ?>
                                    map.setCenter(map_center,<?php echo $zoom_level;?>,G_NORMAL_MAP);
                                    // Commented For hiding Red Spot mark of Current Postcode
				    var newIcon = MapIconMaker.createMarkerIcon({width: 41, height: 46, primaryColor: "#00ff00" });
                                    newIcon['shadow']	 = '';
				    var marker = new GMarker(map_center,{icon: newIcon});
				    map.addOverlay(marker);
				    create_nodes(<?php echo json_encode($postcode_map_data);?>,'<?php echo $this->config->item('gmap_image_url');?>');
				<?php }?>
			}else{
                            // display a warning if the browser was not compatible
			        alert("Sorry, the Google Maps API is not compatible with this browser");
			}
                    </script>
                </div>
            </div>
            <div class="gmap_bottom" ></div>
        </div>
				
        <!-- </Map Container> -->
        <?php /* popup starts */ ?>
        <div style="width:920px;left:450px; top:130px; display: none;" id="brokerclass">
            <?php  echo popup_box_top();?>
            <div class="popup_content_main" id="broker"></div>
            <?php echo popup_box_bottom();?>
            <style type="text/css">
            #brokerclass {
                              position:absolute;
                               width:600px;
                               z-index:1001;
                         }
            </style>
        </div>
        <?php /* popup ends */ ?>
        </div>
       </div>
    </div>
</div>

<style type="text/css">
        body {
        font-family: Arial, Helvetica, sans-serif;
        text-align: left;
        padding: 0px;
        margin-top:0px;
        background:url(<?php echo base_url().'images/bg_01.jpg'?>) #000000 no-repeat center top;
        height:auto;
        }
    </style>