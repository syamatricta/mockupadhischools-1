<?php page_heading((isset($pagedetails->title) && $pagedetails->title !='') ? $pagedetails->title : '' , 'banner-about');?>
<section class="page-content">
	 <?php if(count($pagedetails)>0){?>
    <div class="container">
        <?php print(filter_content($pagedetails->content)); ?>
    </div>
    <?php }?>
    <div class="container">
    	<div class="grid">
    		 
    		<?php 
    		$image_path = $this->config->item('staff_image_upload_url');
    		foreach($staffs as $key=>$staff){
    		$full_image = $this->config->item('staff_image_upload_path').$staff->photo;
						if($staff->photo && file_exists($full_image)){
							$full_image = $image_path.$staff->photo;						 
						}else{
							$full_image = $this->config->item('images').'noimg_round.png';							 
						}	
    			?>
    		 
    			<div class="staff_box  grid-sizer animate" id="<?php echo $key?>">
    				<div class="inner">
    					<div class="text-center">
    						<img class="" src="<?php echo $full_image ; ?>"  alt="<?php echo $staff->name; ?>"/>
    					</div>
		    			<div class="sname text-center"><?php echo $staff->name; ?></div>
		    			<div class="staff_desc" ><?php echo strip_tags($staff->description) ?></div>
		    			<div class="staff_cnt"></div>
		    			<?php $weekly =$staff->totalhour?$staff->totalhour:0; 
		    			$total=  $staff->basehour + $weekly;
		    			$total = $total==0?'N/A':$total.' HRS'?>
		    			<div class="hrstaken">NUMBER of HOURS TAUGHT :&nbsp;<span class="fig"> <?php echo $total?></span></div>
						<div class="service text-center">YEARS OF SERVICE :&nbsp;<span class="fig"><?php echo $staff->fromyear?></span></div>
    				</div>
    			</div>
    		 
    		<?php }?>
    	
    		
    	</div>
    	
    </div>
</section>
