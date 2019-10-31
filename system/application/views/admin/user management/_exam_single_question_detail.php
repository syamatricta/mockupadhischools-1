<?php
	$single_block_class = (0 == $key%2) ? ' clear_right': '';
?>
<div class="erc_single">
	<div class="ercs_question"><?php $qustion_inc	= $key; echo $qustion_inc.'. '.$question_details[$question_id]['question'];?></div>
	<div class="ercs_info">
		<div class="ercs_options">
			<?php
				$correct_answer_alphabet	= '';
				$given_answer_alphabet		= '';
				$answered_image				= 'not_attended.png';
				$i	= 1;
				foreach($option_details[$question_id] as $option_id => $option_label){
					switch($i){
						case 1: 
							$alphabet = 'A';break;
						case 2:
							$alphabet = 'B';break;
						case 3:
							$alphabet = 'C';break;
						case 4:
							$alphabet = 'D';break;
						default:
							break;
					}											
					if('' == $correct_answer_alphabet && $option_id == $question_details[$question_id]['answer_id']){
						$correct_answer_alphabet = $alphabet;
					}
					if('' == $given_answer_alphabet && isset($attended_details[$question_id]['option_id']) && $option_id == $attended_details[$question_id]['option_id']){
						$given_answer_alphabet = $alphabet;
						if($question_details[$question_id]['answer_id'] == $attended_details[$question_id]['option_id']){
							$answered_image	= 'right_answer.png';
						}else{
							$answered_image	= 'wrong_answer.png';
						}
					}
			?>
				<span class="ercq_option">(<?php echo $alphabet;?>) <?php echo $option_label;?></span>
			<?php
					$i++;
				}
			?>
		</div>
		
		<div class="ercq_bottom_box">
			<div class="ercq_verify">
				<div class="ercq_verify_row"><span class="verify_label">Selected Answer : </span><?php echo ('' != $given_answer_alphabet) ? '<span class="given_anw">'.$given_answer_alphabet.'</span>': 'Not answered';?></div>
				<div class="ercq_verify_row"><span class="verify_label">Correct Answer &nbsp;&nbsp;: </span><span class="correct_anw"><?php echo $correct_answer_alphabet;?></span></div>
			</div>
			<div class="ercq_image"><img class="center" src="<?php echo $this->config->item('images').$answered_image;?>" /></div>
			<div class="ercq_attended_info">
				<?php if ( isset($attended_details[$question_id]['created_at'])){?>
				<div class="eto_info_row">
					<span class="etoi_l">Viewed at</span>
					<span class="etoi_m">:</span>
					<span class="etoi_r"><?php echo date('G:i:s', strtotime($attended_details[$question_id]['created_at']));?></span>
				</div>
				<?php }?>
				<?php if ( isset($attended_details[$question_id]['updated_at'])){?>
				<div class="eto_info_row">
					<span class="etoi_l">Answered at</span>
					<span class="etoi_m">:</span>
					<span class="etoi_r"><?php echo date('G:i:s', strtotime($attended_details[$question_id]['updated_at']));?></span>
				</div>
				<?php }?>
				<?php if ( isset($attended_details[$question_id]['online'])){?>
				<div class="eto_info_row">
					<span class="etoi_l">Mode</span>
					<span class="etoi_m">:</span>
					<span class="etoi_r"><?php echo (1 == $attended_details[$question_id]['online']) ? ' Online' : ' Offline';?></span>
				</div>
				<?php }?>
			</div>
		</div>
		
	</div>
</div>