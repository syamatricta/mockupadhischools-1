<link rel="stylesheet" href="<?php echo $this->config->item('style_url');?>fullcalendar.min.css" />
<?php page_heading_location('Location ', '');?>
        <?php if (isset($arr_class) && !empty($arr_class)): ?>

        <section id="section-class" class="section-class">
            <div class="container">
                <div class="star-heading">
                        <h2 class="wow fadeInUp" style="text-transform: uppercase">
                            <?php echo $arr_class[0]->region ; ?> - <?php echo $arr_class[0]->subregion ; ?>
                        </h2>
                        <hr class="wow fadeInUp" />
                </div>

                <div class="row"> 
                        <div class="col-sm-12">
                                    <p class="text-right loc-cnt wow fadeInUp">
                                    <?php $i = 0;
                                           $val = $arr_class[0];

                                           $i++;
                                           $full_image = 'image_uploads/'.$val->image;
                                           if($val->image && file_exists($full_image)){
                                                   $full_image = 'image_uploads/'.$val->image;						 
                                           }else{
                                                   $full_image = $this->config->item('images').'noimage.jpg';							 
                                           }
                                    ?>
                                    <img class="img-responsive center" width="1120" height="446" src="<?php echo base_url(); ?>/<?php echo $full_image; ?>"  alt="<?php echo $arr_class[0]->subregion ; ?>"/>

                        </div>
                </div>

                <div class="clear"></div>
                <br/><br/><br/><br/>

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
                                                        <label id="course_location_title" style="margin-top: 2px;"><?php echo $val->region.','.$val->subregion; ?></label>
                                                </div>
                                                <div class="col-md-3 subt hidden-sm hidden-xs">
                                                         <i class="fa fa-clock-o f20"></i>
                                                         <label id="course_time_title" style="margin-top: 2px;"><?php echo $val->start_time.','.$val->end_time; ?></label>  
                                                </div>
                                        </div>
                                    </h4>
                                </div>
                                <div class="panel-collapse collapse in">
                                    <div class="panel-body">
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
                        <div class="col-md-12">
                            <div id="map-canvas" class="fl map_container"></div>
                        </div>
                    </div>
                </div>

            </div>

        </section>
        <?php endif;?>


        <h2 class="hidden"><?php echo date('F Y');?></h2>
        <section class="page-content">
            <div class="container scheduledetails">
                        <div class="row">
                                <div class="col-md-12 mb50">
                                        <input name="sltSearchRegion" id="sltSearchRegion" type="hidden" value="<?php echo $arr_class[0]->region_id; ?>"/>
                                        <input name="sltSearchSubregion" id="sltSearchSubregion" type="hidden" value="<?php echo $arr_class[0]->subregion_id; ?>"/>
                                        <input name="sltSearchCourse" id="sltSearchCourse" type="hidden" value=""/>
                                        <input name="sltSearchChp" id="sltSearchChp" type="hidden" value=""/>

                                        <script>
                                                <?php echo $content  		 	= "var content = ".$json_array.";"; ?>
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
        
    <script type="text/javascript" src="<?php echo $this->config->item('script_url');?>moment.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->config->item('script_url');?>fullcalendar.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWUDV4r_Y_jzawmdXwfga5VQ6I4aPfZUE&libraries=drawing,geometry,places&callback=initialize"
                    async defer></script>
    <script type="text/javascript">
        $(document).ready(function(){
            initialize();
        });

        function initialize() {

          geocoder = new google.maps.Geocoder();
          var address = "<?php echo $arr_class[0]->subaddress; ?>";

          geocoder.geocode( { 'address' : address }, function( results, status ) {
            if( status == google.maps.GeocoderStatus.OK ) {

                var mapOptions = {
                    zoom: 12,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                var map = new google.maps.Map(document.getElementById("map-canvas"),mapOptions);     
                map.setCenter( results[0].geometry.location );

                var marker = new google.maps.Marker( {
                    map     : map,
                    position: results[0].geometry.location
                } );
            }
          });
        }
    </script>