		<?php if(!isset($quiz_design)){?>	
				</div>
			<div class="innerbakground_right"><img  src="<?php  echo $this->config->item('images');?>innerpages/inner_background_right.jpg" /></div>
		<?php } ?>
		</div>
	</div>
        <script type="text/javascript">
            current_user_type = 'trial';
            $$("span.help").each( function(link) {
			new Tooltip_new(link, {mouseFollow: true,delay : 60});
            });
        </script>
        <style>
            .quizinnerbackground_middle{width: 100% !important;}
            .exam_success_middle{width: 758px !important;}
            .quiz_result{width: 764px !important;}
            .quiz_border_result{width: 760px !important;}
        </style>
</body>
</html>