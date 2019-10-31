<?php page_heading('Become a Real Estate Instructor', 'banner-career'); ?>
<br/><br/>
<div class="text-right" style="margin-right:8%; margin-top: -35px;">		
    <span><a href="<?php echo base_url(); ?>">Home</a></span>		
    <span class="content">|Careers</span> 		
</div>
<section class="career_content">
    <div class="container">
        <div class="panel-group panel-group-ext" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#panel1">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" >Careers at ADHI Schools</a>
                    </h4>
                </div>
                <div id="panel1" class="panel-collapse collapse">
                    <div class="panel-body ptb40">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="sub-title">Position:</p>
                                <p class="margin10">Real estate instructor</p>
                                <p class="sub-title">Compensation:</p>
                                <p>Depending on experience</p>
                            </div>
                            <div class="col-md-8">
                                <p class="sub-title">Requirements:</p>
                                <ul>
                                    <li>Bachelors degree or masters preferred. </li>
                                    <li>A minimum of three years of fulltime realestate experience. </li>
                                    <li>Actively engaged in realestates sales, loan origination or property management.</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 sf">Please submit resume to our corporate headquarters. <b class="bfsize" >Call 888 768 5285 </b> for more information.</div>
                        </div>		                
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#panel2">
                    <h4 class="panel-title">
                        <a class="accordion-toggle">Broker Placement</a>
                    </h4>
                </div>
                <div id="panel2" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <script src="https://maps.google.com/maps/api/js?key=AIzaSyAgBgPIfK2tgIYnnEJBBc-5TJTzKhINEPg&sensor=false"></script>
                        <script type="text/javascript">
                            function initialize() {
                                /* loading the map starts here */

<?php if (empty($postcode_lat_long)) { ?>
                                    var mapOptions = {
                                        center: new google.maps.LatLng(<?php echo $this->config->item('default_latitude'); ?>, <?php echo $this->config->item('default_longitude'); ?>),
                                        zoom: 8,
                                        mapTypeId: google.maps.MapTypeId.ROADMAP
                                    };

                                    var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
<?php } else { ?>

                                    var mapOptions = {
                                        center: new google.maps.LatLng(<?php echo $postcode_lat_long->co_lattitude; ?>, <?php echo $postcode_lat_long->co_longitude; ?>),
                                        zoom: 8,
                                        mapTypeId: google.maps.MapTypeId.ROADMAP
                                    };

                                    var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
                                    /* loading the map ends here */


                                    /* loading marker on the map starts here */
                                    var iconBase = '<?php echo base_url() ?>images/reskin/';
                                    var icons = {
                                        brokerplacement: {
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
                                        google.maps.event.addListener(marker, "click", function (e) {
                                            var url = base_url + "home/brokerplacementdetailsreskin/" + feature.id;
                                            $('#ajaxModal').remove();
                                            //e.preventDefault();
                                            var $this = $(this),
                                                    $remote = url,
                                                    $modal = $('<div class="modal" id="ajaxModal"><div class="modal-body"></div></div>');
                                            $('body').append($modal);
                                            $modal.modal({backdrop: 'static', keyboard: false});
                                            $modal.load($remote);
                                        });
                                    }

                                    var features = [
    <?php
    $map_data_count = count($postcode_map_data);
    $count = 1;
    foreach ($postcode_map_data as $mapdata) {
        ?>
                                            {
                                                position: new google.maps.LatLng(<?php echo $mapdata->co_lattitude; ?>, <?php echo $mapdata->co_longitude; ?>),
                                                        type: 'brokerplacement',
                                                id: '<?php echo $mapdata->sub_postcode; ?>'
                                            }
        <?php
        if ($count != $map_data_count) {
            echo ',';
        }
        $count++;
    }
    ?>
                                    ];

                                    for (var i = 0, feature; feature = features[i]; i++) {
                                        addMarker(feature);
                                    }
<?php } ?>
                            }
                            /* loading marker on the map ends here */

                            google.maps.event.addDomListener(window, 'load', initialize);
                            google.maps.event.addDomListener(window, "resize", initialize);

                        </script>

                        <div id="sitepagemain" class="ptb40">
                            <?php if (count($pagedetails) > 0) { ?>
                                <div class="sitepagecontent"><?php print($pagedetails->content); ?></div>
                            <?php } ?>
                        </div>
                        <div class="clearboth"></div>
                        <!-- <Map Container> -->

                        <div id="map-canvas" class="fl map_container"></div>	

                        <!-- </Map Container> -->
                        <?php /* popup starts */ ?>
                        <div style="width:920px; top:130px; display: none;" id="brokerclass">
                            <?php echo popup_box_top(); ?>
                            <div class="popup_content_main" id="broker"></div>
                            <?php echo popup_box_bottom(); ?>
                            <style type="text/css">
                                #brokerclass {
                                    position:absolute;
                                    width:600px;
                                    z-index:1001;
                                }
                            </style>
                        </div>
                        <div class="margin30"></div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#panel3">
                    <h4 class="panel-title">
                        <a class="accordion-toggle">ADHI Job Creation</a>
                    </h4>
                </div>
                <div id="panel3" class="panel-collapse collapse">
                    <div class="panel-body ptb40 prl10">
                        <p class="col-sm-10 col-sm-offset-1">
                            Over the last ten years, ADHI Schools has helped place hundreds of our students with local brokers throughout California. Many of our alumni have gone on to become top producers, mentors and managers at their respective companies. We have deep
                            relationships with over 150 real estate offices and can help you get placed with the right broker. All of our broker placement services are free of charge and an added benefit of being part of the ADHI family.
                        </p>
                        <h2 class="text-center col-sm-12">
                            Hear from our alumini about how they got started
                        </h2>
                        <div class="text-center col-sm-8 col-sm-offset-2">
                            <div class="video-container">
                                <iframe   src="https://www.youtube.com/embed/9cU5sP47NSY?html5=1" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                        <div class="col-sm-12 margin30"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
