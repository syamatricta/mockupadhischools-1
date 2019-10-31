<?php page_heading('Quiz' , 'banner-inner'); ?>
<div class="divide40"></div>
<?php echo form_open('quiz/courselist', array('name'=>'confirm_password_form_adhi','id' => 'confirm_password_form_adhi', 'class' => '') ); ?>

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
		        <?php /* foreach($quizlist as $data): ?>
		        <div class="row margin10">
		        	 
		        	 	<?php if($data->quiz_status =='E'): ?>		        	 		 
		        	 		<div class="col-xs-2 text-center"><?php echo $i?></div>
		        	 		<div class="col-xs-5">
		        	 			<a href="#">
		        	 				Chapter <?php echo @$viewChapter?>
								    <?php echo $data->quiz_name . (($data->topic) ? ' - ' . $data->topic : '');?>
		        	 			</a>
		        	 		</div>
		        	 		<div class="col-xs-5">
		        	 			Last attempted on: <?php echo ($data->last_date!=0) ? $data->last_date : 'Not attempted'; ?>
		        	 		</div>
		        	 	<?php elseif($data->quiz_status =='D'):?>
		        	 		<div class="col-xs-2 text-center"><?php echo $i?></div>
		        	 		<div class="col-xs-5">
		        	 			<?php echo $data->quiz_name;?>- This quiz has been disabled by Administrator
		        	 		</div>
		        	 		<div class="col-xs-5">
		        	 			 
		        	 		</div>
		        	 	<?php else:?>
		        	 		<div class="col-xs-2 text-center"><?php echo $i?></div>
		        	 		<div class="col-xs-5">
		        	 			<?php echo $data->quiz_name;?>-This quiz has been removed by Administrator
		        	 		</div>
		        	 		<div class="col-xs-5">
		        	 			  <?php echo ($data->last_date!=0) ? 'Last attempted on: '.$data->last_date : ''; ?>
		        	 		</div>
		        	 	<?php endif; ?>
		        	
		        </div>
		         <?php $i++;  endforeach; */?>
		         <?php $viewChapter = 0; ?>
		         <div class="middlebutton" id="divShowActive" >
		         	<?php foreach($arr_quiz as $data): ?>
						<?php if($data->quiz_status =='E'): ?>
						<div class="row margin10 qlist">							 
							<div class="col-sm-8 mb10xs">
								<span class="padr10"><?php echo $active_no;?>.</span>
								<span class="hidden-xs hidden-sm ">Chapter <?php echo ++$viewChapter; ?>&nbsp;</span>
								(<a style="text-decoration: underline" href="<?php echo site_url()."quiz/quizrule/".$data->id."/".$course_id.'/'.$active_no;?>"> <?php echo $data->quiz_name . (($data->topic) ? ' - ' . $data->topic : '');?> </a>)
							</div>
							<div class="col-sm-4 mb10xs">Last attempted on: <?php echo ($data->last_date!=0) ? $data->last_date : 'Not attempted'; ?></div>
						</div>	
						<?php $active_no++; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<?php if($active_no==1):?>
						<div class="roe"><span class="col-sm-12"> No Active Quiz(s) available</span></div>
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