<style>
    .btn-adhis {
        background-color: #945fad;
        border: solid 1px #945fad;
        color: #fff !important;
        font-size: 1.429em;
        font-weight: 600;
        border-radius: 0px;
        padding: 10px 20px;
        line-height: 1;
        cursor: pointer;
    }
</style>
<div class="vertical-alignment-helper">
<div class="modal-dialog coursebox modal-lg vertical-align-center" role="document">
    <div class="modal-content"
	    <div class="modal-body">
	    	<div class="row"><div class="col-md-12">
	    		<span class="datcnt pull-left"><?php echo date('m/d/Y',strtotime($date))?></span>
	    		<span class="pull-right"><button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>	</span>
	    	</div></div>
	    	
			<div class="panel-group panel-group-ext" id="accordion">
				<?php foreach ($arr_class as $key => $val) { 
					$image_path = $this->config->item('image_upload_url');
				?>
					
				
			    <div class="panel panel-default">
			        <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#panel<?php echo $key?>">
			            <h4 class="panel-title">
			                <a class="accordion-toggle" >
			                	<div class="row">
			                		<div class="col-md-4 col-xs-10  nopad"><?php echo $val->course?></div>
			                		<div class="col-md-4 f13 subt nopad hidden-sm hidden-xs">
			                			<i class="fa fa-map-marker"></i>
		                  				 <?php echo $val->region.' , '.$val->subregion ?>
			                		</div>
			                		<div class="col-md-3 f13 subt nopad hidden-sm hidden-xs">
			                			 <i class="fa fa-clock-o"></i>
		                  				  <?php echo $val->start_time.'-'.$val->end_time ?> 
			                		</div>
			                	</div>
			                </a>
			            </h4>
			        </div>
			        <div id="panel<?php echo $key?>" class="panel-collapse collapse">
			            <div class="panel-body">
			            	<div class="row">
			            		<div class="col-md-4">
			            			 <?php 
			            			 	$full_image = $this->config->item('image_upload_path').$val->image;
										if($val->image && file_exists($full_image)){
											$full_image = $image_path.$val->image;						 
										}else{
											$full_image = $this->config->item('images').'noimage.jpg';							 
										}
			            			 ?>
			            			 <div class="mb15">
			            			 	<img class="img-responsive" src="<?php echo base_url()?>timthumb.php?src=<?php echo $full_image ; ?>&w=320&q=100&h=246"  alt="<?php echo $val->course; ?>"/>
			            			 </div>
			            			 
		            			 	<div class="row mtop10 ">		              					
              					 		<div class="col-xs-1 text-center pad0r"><i class="fa fa-map-marker f20"></i></div>
              					 		<div class="col-xs-11  pad0r">
              					 			<p class="mb0"><span><?php echo $val->region.','.$val->subregion ?></span></p><p class="f13"><?php echo $val->subaddress;?></p>
              					 		</div>		                   				
	              					</div>
			            			<div class="row mtop10 hidden-md hidden-lg margin10">
	                  				 <div class="col-xs-1 text-center pad0r"><i class="fa fa-clock-o"></i></div>
	                  				 <div class="col-xs-11 f13"><?php echo $val->start_time.'-'.$val->end_time ?></div>
	                  				</div>  
			            		</div>
			            		<div class="col-md-8">
			            		 	<p class="loctitle">Location Details</p>
			            		 	<p class="lccontent"><?php echo $val->subregion_description?></p>
			            		 	<p class="loctitle">Chapter Details</p>
			            		 	<div class="lccontent"><?php echo $val->descp?></div>
                                                        <br/><br/>
                                                        <p><a href="<?php echo base_url(); ?>user/register" class="btn-adhis">Register Now</a>
			            		</div>
			            		<div class="col-md-12">
			            			<sapn class=" ">Students must spend 18 days and 45 hours with the course material per course. Attendance is not required to obtain a certificate of completion.</span>
			            		</div>
			            	</div>
			            	 		                
			            </div>
			        </div>
			    </div>
			    <?php } ?>
		    </div>
		</div>
	</div>
</div>
</div>
