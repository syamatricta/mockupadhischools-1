<div class="vertical-alignment-helper">
    <div class="modal-dialog coursebox modal-lg vertical-align-center" role="document" id="event-booking-list">
    <div class="modal-content">
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
			                		<div class="col-md-4 col-xs-10  nopad"><?php echo $val->title?></div>
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
                                                    <img class="img-responsive" src="<?php echo base_url()?>timthumb.php?src=<?php echo $full_image ; ?>&w=320&q=100&h=246"  alt="<?php echo $val->title; ?>"/>
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
                                            <div class="col-md-<?php echo (strtotime($date) >= time()) ? '4' : '8';?>">
                                                <p class="loctitle">Location Details</p>
                                                <p class="lccontent"><?php echo $val->subregion_description?></p>
                                                <p class="loctitle">Details</p>
                                                <div class="lccontent"><?php echo $val->descp?></div>
                                                <p class="loctitle">Parking Info</p>
                                                <div class="lccontent"><?php echo $val->parking_info?></div>                                                
                                            </div>
                                            <?php if(strtotime($date) >= time()) {?>
                                            <div class="col-md-4">
                                                <div class="alert hidden event_booking_msg text-center" id="message_div_<?php echo $val->id;?>"></div>
                                                <div class="row event_booking_div">
                                                    <form class="event_booking_form" name="event_booking_form" data-id="<?php echo $val->id;?>" id="event_booking_form_<?php echo $val->id;?>" >
                                                        <input type="hidden" name="event_id" value="<?php echo $val->id;?>" />
                                                        <input type="hidden" name="event_date" value="<?php echo $date;?>" />
                                                        <div class="col-md-12 form-group">
                                                            <input type="text" name="first_name" id="first_name" placeholder="FIRST NAME*" class="form-control" maxlength="40" required value="<?php echo set_value('firstname', s('USER_NAME')); ?>" />
                                                        </div>
                                                        <div class="col-md-12 form-group"> 
                                                            <input type="text" name="last_name" id="last_name" placeholder="LAST NAME*" class="form-control" maxlength="40" required value="<?php echo set_value('lastname', s('LAST_NAME')); ?>" />
                                                        </div>
                                                        <div class="col-md-12 form-group"> 
                                                            <input type="email" name="email" id="email" maxlength="70" required placeholder="EMAIL*" class="form-control" value="<?php echo set_value('email', (s('EMAIL')) ? s('EMAIL') : s('EXP_EMAIL')); ?>"/>
                                                        </div>
                                                        <div class="col-md-12 form-group"> 
                                                            <input type="text"  placeholder="PHONE*" required name="phone" id="phone" maxlength="10"  class="form-control numbers_only"  value="<?php echo set_value('phone', (s('PHONE')) ? s('PHONE') : s('EXP_PHONE')); ?>" />
                                                        </div>
                                                        <div class="col-md-12 form-group"> 
                                                            <button type="submit" class="btn-adhi career_event_booking_btn">BOOK NOW</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <?php }?>
			            	</div>	                
			            </div>
			        </div>
			    </div>
			    <?php } ?>
		    </div>
	</div>
    </div>
</div>
<div class="modal" id="modal_book_event" data-backdrop="static">
	<div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title"><?php echo $arr_class[0]->title;?></h4>
        </div><div class="container"></div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 form-group">
                    <input type="text" name="firstname" id="firstname" placeholder="FIRST NAME*" class="form-control" maxlength="40" required value="<?php echo set_value('firstname'); ?>" />
                </div>
                <div class="col-md-12 form-group"> 
                    <input type="text" name="lastname" id="lastname" placeholder="LAST NAME*" class="form-control" maxlength="40" required value="<?php echo set_value('lastname'); ?>" />
                </div>
                <div class="col-md-12 form-group"> 
                    <input type="email" name="email" id="email" maxlength="70" required placeholder="EMAIL*" class="form-control" value="<?php echo set_value('email', (s('EMAIL')) ? s('EMAIL') : s('EXP_EMAIL')); ?>"/>
                </div>
                <div class="col-md-12 form-group"> 
                    <input type="text"  placeholder="PHONE*" required name="phone" id="phone" maxlength="10"  class="form-control numbers_only"  value="<?php echo set_value('phone', (s('PHONE')) ? s('PHONE') : s('EXP_PHONE')); ?>" />
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <a href="#" data-dismiss="modal" class="btn-adhi">Close</a>
          <a href="#" class="btn-adhi">Save changes</a>
        </div>
      </div>
    </div>
</div>