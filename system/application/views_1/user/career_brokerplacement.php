<script src="<?php echo $this->config->item('site_baseurl');?>js/jquery-1.4.2.min.js" type="text/javascript"></script>
  <script type="text/javascript">	
	jQuery.noConflict();
</script>
<script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=<?php echo $this->config->item('google_map_key')?>&sensor=true">
    </script>
    <script type="text/javascript">
      function initialize() {
      	/* loading the map starts here */
      	
      	<?php if(empty($postcode_lat_long)){?>
	        var mapOptions = {
	          center: new google.maps.LatLng(<?php echo $this->config->item('default_latitude');?>, <?php echo $this->config->item('default_longitude');?>),
	          zoom: 8,
	          mapTypeId: google.maps.MapTypeId.ROADMAP
	        };	       
	       	
	        var map = new google.maps.Map(document.getElementById("map-canvas"),
	            	mapOptions);     	
         <?php } else { ?>  
         
         var mapOptions = {
	          center: new google.maps.LatLng(<?php echo $postcode_lat_long->co_lattitude;?>, <?php echo $postcode_lat_long->co_longitude;?>),
	          zoom: 8,
	          mapTypeId: google.maps.MapTypeId.ROADMAP
	        };
	       
	       	var map = new google.maps.Map(document.getElementById("map-canvas"),
	            	mapOptions); 
      	/* loading the map ends here */
      
      	
      	/* loading marker on the map starts here */
      	var iconBase = '<?php echo base_url()?>images/gmap/';
        var icons = {
          brokerplacement: {
            name: 'Broker Placement',
            icon: iconBase + 'pin_04.png',
            shadow: iconBase + 'pin_04.png'
          }
        };
      	function addMarker(feature) {
          var marker = new google.maps.Marker({
            position: feature.position,
            icon: icons[feature.type].icon,  
            id: feature.id,         
            map: map
          });
          google.maps.event.addListener(marker, "click", function (e) {               
               var url= base_url+"home/brokerplacementdetails/"+feature.id;      
                    
               jQuery.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'html',
                    data: { },
                    success: function(data){
                        jQuery('#brokerclass').show();
                        jQuery('#broker').html(data);
                    }
                });
                jQuery('#popup_close').click(function(){
                        jQuery('#brokerclass').hide();
                    });
            });
        }
        
        var features = [
	        <?php 
	        $map_data_count = count($postcode_map_data);
	        $count = 1;
	        foreach($postcode_map_data as $mapdata){?>
	          {
	            position: new google.maps.LatLng(<?php echo $mapdata->co_lattitude; ?>, <?php echo $mapdata->co_longitude; ?>),
	            type: 'brokerplacement',
	            id: '<?php echo $mapdata->sub_postcode; ?>'
	          }
	         <?php 
	         if($count != $map_data_count){
	         	echo ',';
	         }
	         $count++; 
	        } ?>
        ];

        for (var i = 0, feature; feature = features[i]; i++) {
          addMarker(feature);
        }
         <?php } ?>
      }   
      /* loading marker on the map ends here */
     
      google.maps.event.addDomListener(window, 'load', initialize);
      
    </script>
    
	 <div id="sitepagemain">
	        <?php if(count($pagedetails)>0){?>
	                <div class="sitepagecontent"><?php print($pagedetails->content); ?></div>
	        <?php } ?>
	</div>
	 <div class="clearboth"></div>
	<!-- <Map Container> -->
	           
	 <div id="map-canvas" class="fl map_container"></div>	
				
    <!-- </Map Container> -->
    <?php /* popup starts */ ?>
    <div style="width:920px; top:130px; display: none;" id="brokerclass">
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