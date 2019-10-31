<?php page_heading('Take Final Exam' , 'banner-inner'); ?>
<div class="text-right" style="margin-right:8%;">		
    <span><a href="<?php echo base_url(); ?>">Home</a></span>		
    <span class="content">|Take final exam</span> 		
</div>
<div class="divide40"></div>
<div class="container margin40">
	<div class="col-sm-11 col-sm-offset-1">	 
		<div class="row margin20">
	        <div class="col-sm-12 margin10">
	            <div class="heading_band">Subject : <?php echo $subject?></div>
	        </div>
	         
	    </div>
	    <?php echo  form_open ('course/exam_start', array('name'=>'rule_form_adhi','id' => 'rule_form_adhi', 'class' => '') ); ?>
	    <div class="row">
	    	<div class="col-sm-12 ">
		    	<div class="jumbotron margin10">		    		 
	    			<div class="col-sm-12 ">
	    				<!--h4 class="margin10"><?php echo $page_title?></h4-->
	    				<p><?php echo $pagedetails->content;?></p>
	    			</div>		    		 
		    		<div class="col-sm-12 text-right" style="font-weight: 700"><span style="color:#945fad; font-size:16px;">Time </span> / 2.30 hrs</div>
		    		<div class="btnctr">
		    			<div class="col-sm-6 text-right margin10" >
		    				
		    				<span id="hide_strt_btn">
		    					<a id="strtfinalexam" class="btn-adhi"  ><i class="fa fa-check"></i> Start Exam</a>
		    				</span>
	 
		    			</div>
		    			<div class="col-sm-6 text-left margin10"><a href="<?php echo site_url()."course/courselist"?>" class="btn-adhi"><i class="fa fa-remove"></i> Cancel</a></div>
		    			<div class="clearfix"></div>
		    		</div>	    		
		    	</div>
		    	
		    	<input type="hidden" name="start" id="start" value="1">
				<input type="hidden" value="0" name="popup_blocked_status" id="popup_blocked_status">
                <input type="hidden" value="0" name="start_exam_status" id="start_exam_status">
                <input type="hidden" value="0" name="poptry" id="poptry">
	    	</div>
	    </div>
	    <?php echo form_close();?>
	</div>
</div>
<div class="modal fade" id="examerror" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
    	<div class="modal-header">
			<button class="close" aria-label="Close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>			 
		</div>
		<div class="modal-body"> We have detected that you are using popup blocker.<br> Please disable the pop up blocker to Start Examination.</div>	     
    </div>
  </div>
</div> 
 
<script type="text/javascript" src="<?php echo base_url().'js/reskin/exam_new.js';?>"></script>
<?php if(isset($poptry) && $poptry=='1'){?>
    <script language="javascript" type="text/javascript">
       
         exam_rule_start();
        //alert("It is fine you can start the exam now.");    	                
    </script>
 

<?php }?>