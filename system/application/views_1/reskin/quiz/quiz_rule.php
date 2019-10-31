<?php page_heading('Quiz' , 'banner-inner'); ?>
<div class="divide40"></div>
<div class="container margin40">
	<div class="col-sm-11 col-sm-offset-1">
		
		<?php $subject_title = ($topic !== '') ? $subject.' > ' .$quizno . ' > ' . $topic : $subject.' > ' .$quizno ;?>
		<div class="row margin20">
	        <div class="col-sm-12 margin10">
	            <div class="heading_band">Subject : <?php  echo $subject_title?></div>
	        </div>
	        <div class="col-md-12 text-right">
	        	<button class="btn-adhi"  data-toggle="modal" data-target="#myModalrule">View Rules</button>
	        </div>
	    </div>
	     <?php echo  form_open ('quiz/courselist', array('name'=>'confirm_password_form_adhi','id' => 'confirm_password_form_adhi', 'class' => '') ); ?>
	    <div class="row">
	    	<div class="col-sm-12 ">
		    	<div class="jumbotron margin10">
		    		<div class="btnctr">
		    			<div class="col-sm-6 text-right margin10" >
		    				<?php if(@$poptry==0){?>
		    				<span id="hide_strt_btn">
		    					<a id="strtexm" class="btn-adhi"  data-segfore="<?php echo $this->uri->segment(4);?>" data-quizid="<?php echo $quiz_id;?>"><i class="fa fa-check"></i> Start Quiz</a>
		    				</span>
		    				
		    				<?php }?>
		    			</div>
		    			<div class="col-sm-6 text-left margin10"><a href="<?php echo site_url()."/quiz/quizlist" . "/" . $course_id?>" class="btn-adhi"><i class="fa fa-remove"></i> Cancel</a></div>
		    			<div class="clearfix"></div>
		    		</div>	    		
		    	</div>
		    	<input type="hidden" value="1" name="popup_blocked_status" id="popup_blocked_status">
    			<input type="hidden" value="<?php echo (isset($poptry) && $poptry=='1')? 1 : 0;?>" name="poptry" id="poptry">
    			<input type="hidden" name="hdnQuizNo" id="hdnQuizNo" value="<?php echo $quizno;?>"/>
	    	</div>
	    </div>
	    <?php echo form_close();?>
	</div>
</div>

<div class="modal fade" id="quizerror" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
    	<div class="modal-header">
			<button class="close" aria-label="Close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>			 
		</div>
		<div class="modal-body"> We have detected that you are using popup blocker.<br> Please disable the pop up blocker to access quiz.</div>	     
    </div>
  </div>
</div>
<div class="modal fade" id="myModalrule" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $page_title?></h4>
      </div>
      <div class="modal-body quizrule margin10">
        <?php echo $pagedetails->content;?>
      </div>
       
    </div>
  </div>
</div>

<?php if(isset($poptry) && $poptry=='1'){?>
 <script type="text/javascript" src="<?php echo base_url().'js/reskin/quiz_new.js';?>">    </script>
<?php }?>
