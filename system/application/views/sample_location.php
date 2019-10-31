<link rel="stylesheet" href="<?php echo $this->config->item('style_url');?>fullcalendar.min.css" />
<?php 
 $name = '';
 $mobile_username_part = '';
 if($this->session->userdata('USER_NAME')){
      $name = '<i class="fa fa-user"> </i> '.$this->session->userdata('USER_NAME').' '.$this->session->userdata('LAST_NAME');
      $mobile_username_part   = '<div class="mob_username hidden-sm visible-xs part2">'. $name.'</div>';
 }
?>
<?php 
$bp = "";
if ($sname == 'Temecula Real Estate School' || $sname == 'Rancho Cucamonga real estate school') { 
    $bp = "background-position:right;";
} 
if ($sname == 'Rancho Cucamonga real estate school') { ?>
<style>
    #course_location_title{
        font-size:14px;
    }
</style>
<?php }
?>
<section class="page_head banner-career-event" style="background-image: url(./../../image_uploads/<?php echo $location->image_name; ?>) !important; padding: 0px;<?php echo $bp; ?>"></section>
        <div class="text-right" style="margin-right:8%;">		
            <span><a href="<?php echo base_url(); ?>">Home</a></span>		
            <span class="content">|Locations</span> 		
        </div>
        <section id="section-class" class="section-class">
            <div class="container">
                <div class="star-heading">
                        <h2 class="wow fadeInUp" style="text-transform: uppercase">
                            <?php echo $location->subregion_title; ?>
                        </h2>
                        <hr class="wow fadeInUp" />
                </div>
                <br/><br/>
                
                <?php if (isset($arr_class) && !empty($arr_class) && !$upcoming): ?>
                    <div class="panel-group panel-group-ext">
                        <div class="panel panel-default">
                        <?php if(!empty($arr_class)) {
                            foreach($arr_class as $val){
                        ?>
                                <div href="#panel" data-parent="#accordion" data-toggle="collapse" class="panel-heading" style="height:50px;text-align: center;">
                                    <h4 class="panel-title">
                                        <div class="">
                                                <div class="col-md-4 subt hidden-sm hidden-xs">
                                                    <i class="fa fa-book f20"></i>
                                                    <label id="course_name_title" style="margin-top: 2px;"><?php echo $val->course; ?></label>
                                                </div>
                                                <div class="col-md-4 subt hidden-sm hidden-xs">
                                                        <i class="fa fa-map-marker f20"></i>
                                                        <label id="course_location_title" style="margin-top: 2px;"><?php echo $val->region.', '.$val->subregion; ?></label>
                                                </div>
                                                <div class="col-md-4 subt hidden-sm hidden-xs">
                                                         <i class="fa fa-clock-o f20"></i>
                                                         <label id="course_time_title" style="margin-top: 2px;"><?php echo $val->start_time.'-'.$val->end_time; ?></label>  
                                                </div>
                                        </div>
                                    </h4>
                                </div>
                                <div class="panel-collapse collapse in">
                                    <div class="panel-body" id="no_pad_panel">
                                        <div class="row floatleft">
                                                <div class="col-md-4">
                                                        <div class="row mtop10 ">		              					
                                                            <div class="col-xs-1 text-center pad0r"><i class="fa fa-map-marker f20"></i></div>
                                                            <div class="col-xs-11  pad0r">
                                                                    <p class="mb0"><span id="course_location"><?php echo $val->region.','.$val->subregion; ?></span></p>
                                                                    <p id="course_subaddress" class="f13"><?php echo $val->subaddress; ?></p>
                                                            </div>		                   				
                                                        </div>
                                                </div>
                                                <div class="col-md-4">
                                                        <p class="loctitle">Location Details</p>
                                                        <p id="course_subregion_description" class="lccontent"><?php echo $val->subregion_description; ?></p>
                                                </div>
                                                <div class="col-md-4"><p class="loctitle">Chapter Details</p>
                                                        <?php if($val->descp != "") { ?>
                                                            <div id="course_descp" class="lccontent"><?php echo $val->descp; ?></div>
                                                        <?php } ?>
                                                </div>
                                          </div>  
                                          <div class="col-md-12" style="text-align:center;margin:20px 0px;">
                                                <span class="center">Students must spend 18 days and 45 hours with the course material per course. Attendance is not required to obtain a certificate of completion.
                                                </span>
                                          </div>

                                          <div class="clearfix"> </div>
                                    </div>
                                </div>
                        <?php  }
                        }
                        ?>
                        <?php /*<div class="col-md-12">
                            <div id="map-canvas" class="fl map_container"></div>
                        </div> */ ?>
                    </div>
                    </div>
                <?php endif; ?>
                
                <?php if ($sname == 'Rancho Cucamonga real estate school') { ?>
                    <div class="rancho_parag text-justify col-md-12">
                        <p> Taking real estate classes at our Rancho Cucamonga real estate school allows our students to learn about the Rancho Cucamonga real estate market first hand.</p>
                        <p> 
                            The median house price in Rancho Cucamonga is over $450,000 and is a great place to sell real estate.  With average commissions over $10,000 per transaction, real estate agents in Rancho Cucamonga only need to do a few deals per year to hit their income goals. </p>    

                        <p> Our real estate school in Rancho Cucamonga is inside of First Team Real Estate, one of the most powerful real estate companies in southern California and one of the largest independent real estate firms anywhere in the United States.</p>

                        <p> Enroll in real estate classes in Rancho Cucamonga today!  ADHI Schools is the best real estate school in Rancho Cucamonga!  Let us prove it - We would love to have you as our newest student!</p>
                    </div><br/><br/>
                <?php } else if ($sname == 'Irvine real estate school') { ?>
                    <div class="rancho_parag text-justify col-md-12">
                        <p> Taking real estate classes at our Irvine real estate school allows our students to learn about the Irvine real estate market first hand.</p>
                        <p>
                            The median house price in Irvine is over $800,000 and is a great place to sell real estate.  With average commissions over $15,000 per transaction, real estate agents in Irvine only need to do a few deals per year to hit their income goals.  
                        <p> Our real estate school in Irvine is inside of First Team Real Estate, one of the most powerful real estate companies in Orange County and one of the largest independent real estate firms anywhere in the United States.</p>

                        <p> Enroll in real estate classes in Irvine today!  ADHI Schools is the best real estate school in Irvine!  Let us prove it - We would love to have you as our newest student!</p>
                    </div>  <br/><br/>                  
                <?php } else if ($sname == 'Los Angeles real estate school') {?>
                    <div class="rancho_parag text-justify col-md-12">
                        <p> Taking real estate classes at our Los Angeles area real estate school allows our students to learn about the Los Angeles real estate market first hand.</p>
                        <p>
                            The median house price in Los Angeles and Brentwood is well over $1,000,000 and is a great place to sell real estate.  With average commissions over $30,000 per transaction, real estate agents in Brentwood Los Angeles only need to do a few deals per year to hit their income goals.  </p>                          
                        <p> Our real estate school in Los Angeles is inside of Rodeo Realty, one of the most powerful real estate companies in southern California and one of the largest independent real estate firms anywhere in the United States.</p>

                        <p> Enroll in real estate classes in the Los Angeles area today!  ADHI Schools is the best real estate school in Los Angeles - Let us prove it!  We would love to have you as our newest student!</p>
                    </div>     <br/><br/>               
                <?php } else if ($sname == 'Temecula Real Estate School') { ?>
                    <div class="rancho_parag text-justify col-md-12">
                        <p> Taking real estate classes at our Temecula area real estate school allows our students to learn about the Temecula real estate market first hand.</p>
                        <p> 
                            The median house price in Temecula is over $450,000 and is a great place to sell real estate.  With average commissions over $12,000 per transaction, real estate agents in Temecula only need to do a few deals per year to hit their income goals.   </p>                          
                        <p> Our real estate school in Temecula is inside of First Team Real Estate, one of the most powerful real estate companies in southern California and one of the largest independent real estate firms anywhere in the United States.</p>

                        <p> Enroll in real estate classes in the Temecula area today!  ADHI Schools is the best real estate school in Temecula!  Let us prove it - We would love to have you as our newest student!</p>
                    </div><br/><br/>
                <?php } else if ($sname == 'San Diego real estate school') { ?>
                    <div class="rancho_parag text-justify col-md-12">
                        <p> Taking real estate classes at our San Diego area real estate school allows our students to learn about the San Diego real estate market first hand.</p>
                        <p> 
                            The median house price in Encinitas is over $1,000,000 and is a great place to sell real estate.  With average commissions over $20,000 per transaction, real estate agents in Encinitas only need to do a few deals per year to hit their income goals.   </p>                          
                        <p>Our real estate school in Encinitas is inside of First Team Real Estate, one of the most powerful real estate companies in southern California and one of the largest independent real estate firms anywhere in the United States.</p>

                        <p> Enroll in real estate classes in the San Diego area today!  ADHI Schools is the best real estate school in the San Diego area - Let us prove it!  We would love to have you as our newest student!</p>
                    </div> <br/><br/>                   
                <?php } ?>
            </div>
        </section>

<h2 class="hidden"><?php echo date('F Y');?></h2>
<?php if(!empty($arr_class)) { ?>
<section class="page-content">
    <div class="container scheduledetails">
        <div class="row">
            <div class="col-md-12">
                    <input name="sltSearchRegion" id="sltSearchRegion" type="hidden" value="<?php echo $arr_class[0]->region_id; ?>"/>
                    <input name="sltSearchSubregion" id="sltSearchSubregion" type="hidden" value="<?php echo $arr_class[0]->subregion_id; ?>"/>
                    <input name="sltSearchCourse" id="sltSearchCourse" type="hidden" value=""/>
                    <input name="sltSearchChp" id="sltSearchChp" type="hidden" value=""/>

                    <script>
                            <?php //echo $content  		 	= "var content = ".$json_array.";"; ?>
                    </script>
                    <div class="col-md-12">
                            <div id="calendar"></div>
                    </div>
                    <div class="col-md-12 mb50"></div>
                    <div class="col-md-12 mb50"></div>
            </div>
        </div>
    </div>
</section>
<?php } ?>
<div class="container">
    <h5><i class="fa fa-location-arrow"> </i>&nbsp;&nbsp;<b><?php echo $location->subregion_address; ?></b></h5>

    <div class="panel panel-default">
        <div id="panel2" class="panel-collapse collapse in">
            <div class="panel-body" style="padding:0px! important;">
                <script src="https://maps.google.com/maps/api/js?key=AIzaSyAgBgPIfK2tgIYnnEJBBc-5TJTzKhINEPg&sensor=false"></script>
                <script type="text/javascript">
                    function initialize() {
                        /* loading the map starts here */

                            <?php if (empty($location)) { ?>
                                var mapOptions = {
                                    center: new google.maps.LatLng(<?php echo $this->config->item('default_latitude'); ?>, <?php echo $this->config->item('default_longitude'); ?>),
                                    zoom: 12,
                                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                                    fullscreenControl:false
                                };

                                var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
                            <?php } else { ?>

                                var mapOptions = {
                                    center: new google.maps.LatLng(<?php echo $location->latitude; ?>, <?php echo $location->longitude; ?>),
                                    zoom: 12,
                                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                                    fullscreenControl:false
                                };

                                var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

                                var iconBase = '<?php echo base_url() ?>images/reskin/';
                                var icons = {
                                    location: {
                                        name: 'Classes',
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

                                    var contentString = "<b><?php echo $sname.",<br/> ".$location->subregion_address; ?></b>";


                                    var infowindow = new google.maps.InfoWindow({
                                      content: contentString
                                    });

                                    marker.addListener('click', function() {
                                        infowindow.open(map, marker);
                                    });
                                }

                                var features = {
                                    position: new google.maps.LatLng(<?php echo $location->latitude; ?>, <?php echo $location->longitude; ?>),
                                    type: 'location',
                                    id: '<?php echo $location->postcode; ?>'
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

<script type="text/javascript" src="<?php echo $this->config->item('script_url');?>moment.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('script_url');?>fullcalendar.min.js"></script>
   