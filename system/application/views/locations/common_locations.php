
<div class="wrapper">
<img src="<?php echo base_url(); ?>image_uploads/<?php echo $location->image_name; ?>" width="100%" class="img-responsive"/>

<section class="career_content">
    <div class="container">
        <div class="panel-group panel-group-ext" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#panel1">
                    <h4 class="panel-title">
                        <b class="text-uppercase"><?php echo $fname; ?></b>
                    </h4>
                </div>

                <br></br>
                <?php if ($name == 'Rancho Cucamonga real estate school') { ?>
                    <div class="rancho_parag text-justify col-md-12">
                        <p> Taking real estate classes at our Rancho Cucamonga real estate school allows our students to learn about the Rancho Cucamonga real estate market first hand.</p>
                        <p> 
                            The median house price in Rancho Cucamonga is over $450,000 and is a great place to sell real estate.  With average commissions over $10,000 per transaction, real estate agents in Rancho Cucamonga only need to do a few deals per year to hit their income goals. </p>    

                        <p> Our real estate school in Rancho Cucamonga is inside of First Team Real Estate, one of the most powerful real estate companies in southern California and one of the largest independent real estate firms anywhere in the United States.</p>

                        <p> Enroll in real estate classes in Rancho Cucamonga today!  ADHI Schools is the best real estate school in Rancho Cucamonga!  Let us prove it - We would love to have you as our newest student!</p>
                    </div>
                <?php } else if ($name == 'Irvine real estate school') {
                    ?>
                    <div class="rancho_parag text-justify col-md-12">
                        <p> Taking real estate classes at our Irvine real estate school allows our students to learn about the Irvine real estate market first hand.</p>
                        <p>
                            The median house price in Irvine is over $800,000 and is a great place to sell real estate.  With average commissions over $15,000 per transaction, real estate agents in Irvine only need to do a few deals per year to hit their income goals.  
                        <p> Our real estate school in Irvine is inside of First Team Real Estate, one of the most powerful real estate companies in Orange County and one of the largest independent real estate firms anywhere in the United States.</p>

                        <p> Enroll in real estate classes in Irvine today!  ADHI Schools is the best real estate school in Irvine!  Let us prove it - We would love to have you as our newest student!</p>
                    </div>                    <?php
                } else if ($name == 'Los Angeles real estate school') {
                    ?>
                    <div class="rancho_parag text-justify col-md-12">
                        <p> Taking real estate classes at our Los Angeles area real estate school allows our students to learn about the Los Angeles real estate market first hand.</p>
                        <p>
                            The median house price in Los Angeles and Brentwood is well over $1,000,000 and is a great place to sell real estate.  With average commissions over $30,000 per transaction, real estate agents in Brentwood Los Angeles only need to do a few deals per year to hit their income goals.  </p>                          
                        <p> Our real estate school in Los Angeles is inside of Rodeo Realty, one of the most powerful real estate companies in southern California and one of the largest independent real estate firms anywhere in the United States.</p>

                        <p> Enroll in real estate classes in the Los Angeles area today!  ADHI Schools is the best real estate school in Los Angeles - Let us prove it!  We would love to have you as our newest student!</p>
                    </div>                    <?php } else if ($name == 'Temecula Real Estate School') {
                    ?>
                    <div class="rancho_parag text-justify col-md-12">
                        <p> Taking real estate classes at our Temecula area real estate school allows our students to learn about the Temecula real estate market first hand.</p>
                        <p> 
                            The median house price in Temecula is over $450,000 and is a great place to sell real estate.  With average commissions over $12,000 per transaction, real estate agents in Temecula only need to do a few deals per year to hit their income goals.   </p>                          
                        <p> Our real estate school in Temecula is inside of First Team Real Estate, one of the most powerful real estate companies in southern California and one of the largest independent real estate firms anywhere in the United States.</p>

                        <p> Enroll in real estate classes in the Temecula area today!  ADHI Schools is the best real estate school in Temecula!  Let us prove it - We would love to have you as our newest student!</p>
                    </div><?php } else if ($name == 'San Diego real estate school') {
                    ?>
                    <div class="rancho_parag text-justify col-md-12">
                        <p> Taking real estate classes at our San Diego area real estate school allows our students to learn about the San Diego real estate market first hand.</p>
                        <p> 
                            The median house price in Encinitas is over $1,000,000 and is a great place to sell real estate.  With average commissions over $20,000 per transaction, real estate agents in Encinitas only need to do a few deals per year to hit their income goals.   </p>                          
                        <p>Our real estate school in Encinitas is inside of First Team Real Estate, one of the most powerful real estate companies in southern California and one of the largest independent real estate firms anywhere in the United States.</p>

                        <p> Enroll in real estate classes in the San Diego area today!  ADHI Schools is the best real estate school in the San Diego area - Let us prove it!  We would love to have you as our newest student!</p>
                    </div>                    <?php }
                ?>


                <br/><br/>
                <h5><i class="fa fa-location-arrow"> </i>&nbsp;&nbsp;<b><?php echo $location->subregion_address; ?></b></h5>
                
                <div class="panel panel-default">

                    <div id="panel2" class="panel-collapse collapse in">
                        <div class="panel-body" style="padding:0px! important;">
                            <script src="https://maps.google.com/maps/api/js?key=AIzaSyAgBgPIfK2tgIYnnEJBBc-5TJTzKhINEPg&sensor=false"></script>
                            <script type="text/javascript">
                                function initialize() {
                                    /* loading the map starts here */

                                        <?php if (empty($postcode_lat_long)) { ?>
                                            var mapOptions = {
                                                center: new google.maps.LatLng(<?php echo $this->config->item('default_latitude'); ?>, <?php echo $this->config->item('default_longitude'); ?>),
                                                zoom: 10,
                                                mapTypeId: google.maps.MapTypeId.ROADMAP,
                                                fullscreenControl:false
                                            };

                                            var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
                                        <?php } else { ?>

                                            var mapOptions = {
                                                center: new google.maps.LatLng(<?php echo $postcode_lat_long['co_lattitude']; ?>, <?php echo $postcode_lat_long['co_longitude']; ?>),
                                                zoom: 10,
                                                mapTypeId: google.maps.MapTypeId.ROADMAP,
                                                fullscreenControl:false
                                            };

                                            var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

                                            var iconBase = '<?php echo base_url() ?>images/reskin/';
                                            var icons = {
                                                location: {
                                                    name: 'Broker Placement',
                                                    icon: iconBase + 'pin.svg',
                                                    shadow: iconBase + 'pin.svg'
                                                }
                                            };

                                            function addMarker(feature) {
                                                var marker = new google.maps.Marker({
                                                    position: feature.position,
                                                    icon: icons[feature.type].icon,
                                                    id: feature.id,
                                                    map: map
                                                });

                                                var contentString = "<b><?php echo $name.",<br/> ".$location->subregion_address; ?></b>";


                                                var infowindow = new google.maps.InfoWindow({
                                                  content: contentString
                                                });

                                                marker.addListener('click', function() {
                                                    infowindow.open(map, marker);
                                                });
                                            }

                                            var features = {
                                                position: new google.maps.LatLng(<?php echo $postcode_lat_long['co_lattitude']; ?>, <?php echo $postcode_lat_long['co_longitude']; ?>),
                                                type: 'location',
                                                id: '<?php echo $postcode_lat_long['sub_postcode']; ?>'
                                            };

                                            addMarker(features);
                                <?php } ?>
                                }
                                /* loading marker on the map ends here */

                                google.maps.event.addDomListener(window, 'load', initialize);
                                google.maps.event.addDomListener(window, "resize", initialize);

                            </script>


                            <div class="clearboth"></div>
                            <!-- <Map Container> -->

                            <div id="map-canvas" class="fl map_container"></div>	

                            <!-- </Map Container> -->
                            <?php /* popup starts */ ?>

                            <div class="margin30"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
</div>