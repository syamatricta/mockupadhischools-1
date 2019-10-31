<?php page_heading('Quiz' , 'banner-inner'); ?>
<div class="divide40"></div>
<?php echo form_open('trial_quiz/courselist', array('name'=>'confirm_password_form_adhi','id' => 'confirm_password_form_adhi', 'class' => '') ); ?>

    <div class="container margin40">
        <div class="col-sm-11 col-sm-offset-1">
        	<div class="row margin20">
	            <div class="col-sm-12">
	                <div class="heading_band">Subject : <?php  echo @$quizlist[0]->course_name?></div>
	            </div>
	        </div>
	        <?php if(!empty($quizlist)) :
	        	if(isset($quizlist) && $quizlist!=''): 
				$arr_quiz = $quizlist;
				$i = 1;
					$active_no 	= 1;
		        ?>
		        
		         <?php $viewChapter = 0; ?>
		         <div class="middlebutton" id="divShowActive" >
		         	<?php foreach($arr_quiz as $data): ?>
						<?php if($data->quiz_status =='E'): ?>
						<div class="row margin10 qlist">							 
							<div class="col-sm-8 mb10xs">
								<?php /*<span class="padr10"><?php echo $active_no;?>.</span>
								<span class="hidden-xs hidden-sm ">Chapter <?php echo ++$viewChapter; ?>&nbsp;</span> */?>
                                                            <span class="fa fa-lg fa-paper-plane-o">&nbsp;<a style="text-decoration: underline" 
                                                                   href="<?php echo site_url()."trial_quiz/quizrule/".$data->id."/".$course_id.'/'.$active_no;?>"></span> <?php echo $data->quiz_name . (($data->topic) ? ' - ' . $data->topic : '');?> </a>
							</div>							
						</div>	
						<?php $active_no++; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<?php if($active_no==1):?>
						<div class="roe"><span class="col-sm-12"> <?php /*No Active Quiz(s) available*/ ?>
                                                We are updating the content, quizzes will be available shortly</span></div> 
					<?php endif; ?>
		         </div>
		        <?php else: ?>
					<div class="row"><span class="col-sm-12"> No Quiz Available</span></div>
				<?php endif; ?>
	       <?php else: ?>
				<div class="row"><span class="col-sm-12"> No Quiz Available</span></div>
		   <?php endif; ?>
		</div>
	</div>

<?php echo form_close();?>