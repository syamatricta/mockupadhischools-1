<?php if (isset($arr_class) && !empty($arr_class)): ?>
<section id="section-class" class="section-class">
    <div class="container">
        <div class="star-heading">
        	<i class="fa fa-star fa1 wow fadeInUp"></i>
        	<i class="fa fa-star fa2 wow fadeInUp"></i>
        	<i class="fa fa-star fa1 wow fadeInUp"></i>
                <h2 class="wow fadeInUp">Today's Classes</h2>     

                <hr class="wow fadeInUp" />
        </div>
       
        <div class="row"> 
	      	<div class="col-sm-12">
		      	<div class="wrapper-with-margin"> 
		      		 <p class="text-right loc-cnt wow fadeInUp"><a class="loc" href="<?php echo base_url()?>schedule">View all locations &nbsp;<i class="fa fa-arrow-right"></i> </a></p>
		      	<div id="classess_view" class="owl-carousel">  
		      		<?php $i = 0;
					$image_path = $this->config->item('image_upload_url');
					foreach($arr_class as $val):
						$i++;
						$full_image = $this->config->item('image_upload_path').$val->image;
						if($val->image && file_exists($full_image)){
							$full_image = $image_path.$val->image;						 
						}else{
							$full_image = $this->config->item('images').'noimage.jpg';							 
						}
						
						if($i%2){
							$alt = 'Real Estate Classes Los Angeles';
						}else{
							$alt = 'Real Estate School Orange County';
						}
						?>        
	  					<div class="item wow fadeInUp" data-wow-delay="<?php echo $i*.5;?>s">
	  						<div class="course_section">
	  							<div class="class-img">
		  							<div class="classes-hover">
				                        <div class="classes-hover-content">
				                            <i class="fa fa-eye"></i>
				                        </div>
			                    	</div>
			                    	<img class="img-responsive" src="<?php echo base_url()?>timthumb.php?src=<?php echo $full_image ; ?>&w=320&q=100&h=246"  alt="<?php echo $alt; ?>"/>
	  							</div>
		  						
	                  			<h4 class="class-name"><?php echo $val->course?></h4>                  			 
	              				<div class="class-details" data-location="<?php echo $val->region.' , '.$val->subregion?>" >
	              					<div class="row">
                                                            <div class="col-xs-5 pad0r">
		                  				 <i class="fa fa-calendar"></i>
		                  				 <span class="class-time cls_c_date"><?php echo $dated?></span>
                                                            </div>
                                                            <div class="col-xs-7 pad0r" style="padding-left: 0;">
		                  				 <i class="fa fa-clock-o"></i>
		                  				 <span class="class-time cls_c_time"><?php echo $val->start_time.'-'.$val->end_time ?></span>
                                                            </div>
		              				</div>
		              				<div class="row mtop10 ">		              					
                  					 	<span class="col-xs-1 text-center pad0r"><i class="fa fa-map-marker f20"></i></span>
                  					 	<span class="col-xs-11 class-loc pad0r cls_c_address" ><?php echo $val->subaddress?></span>		                   				
		              				</div>
		              				<div class="wline"></div> 
		              				<div class="row">
		              					<div class="col-xs-12">
		                  					<div class="class-title cls_c_chapter" data-description="<?php echo $val->subregion_description?>"><?php echo strlen(strip_tags($val->descp)) > 45 ? substr(strip_tags($val->descp), 0, 45)."..." : substr(strip_tags($val->descp), 0, 45)?></div>
		                  				</div>	                  				 
		              				</div>
	              				</div>
                  			</div>
						</div>
					<?php endforeach;?>
				</div>
				</div>
	      	</div>
      	</div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="course_details">
	  <div class="modal-dialog coursebox modal-lg" role="document">
		    <div class="modal-content"
			    <div class="modal-body">
			    	<div class="row"><div class="col-md-12">
			    		<span class="datcnt pull-left" id="course_date_top"></span>
			    		<span class="pull-right"><button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>	</span>
			    	</div></div>
			    	
					<div class="panel-group panel-group-ext" >
						
					    <div class="panel panel-default">
					        <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#panel">
					            <h4 class="panel-title">
					                <a class="accordion-toggle" >
					                	<div class="">
					                		<div class="col-md-4 col-xs-10  nopad" id="course_name_title"></div>
					                		<div class="col-md-4 f13 subt nopad hidden-sm hidden-xs">
					                			<i class="fa fa-map-marker"></i>
				                  				<label id="course_location_title"></label>
					                		</div>
					                		<div class="col-md-3 f13 subt nopad hidden-sm hidden-xs">
					                			 <i class="fa fa-clock-o"></i>
				                  				 <label id="course_time_title"></label>  
					                		</div>
					                	</div>
					                </a>
					            </h4>
					        </div>
					        <div   class="panel-collapse collapse in">
					            <div class="panel-body">
					            	<div class="row">
					            		<div class="col-md-4">
					            			  
					            			 <div class="mb15">
					            			 	<img class="img-responsive" id="course_image" src=""  alt=""/>
					            			 </div>
					            			 
				            			 	<div class="row mtop10 ">		              					
		              					 		<div class="col-xs-1 text-center pad0r"><i class="fa fa-map-marker f20"></i></div>
		              					 		<div class="col-xs-11  pad0r">
		              					 			<p class="mb0"><span id="course_location"></span></p>
		              					 			<p class="f13" id="course_subaddress"></p>
		              					 		</div>		                   				
			              					</div>
					            			<div class="row mtop10 hidden-md hidden-lg margin10">
			                  				 <div class="col-xs-1 text-center pad0r"><i class="fa fa-clock-o"></i></div>
			                  				 <div class="col-xs-11 class-time f13" id="course_time"></div>
			                  				</div>  
					            		</div>
					            		<div class="col-md-8">
					            		 	<p class="loctitle">Location Details</p>
					            		 	<p class="lccontent" id="course_subregion_description"></p>
					            		 	<p class="loctitle">Chapter Details</p>
					            		 	<div class="lccontent" id="course_descp"></div>
					            		</div>
					            		<div class="col-md-12">
					            			<sapn class=" ">Students must spend 18 days and 45 hours with the course material per course. Attendance is not required to obtain a certificate of completion.</span>
					            		</div>
					            	</div>
					            	 		                
					            </div>
					        </div>
					    </div>
					    
				    </div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif;?>