<script src="<?php echo $this->config->item('site_baseurl');?>js/jquery-1.4.2.min.js" type="text/javascript"></script>
<div id="sitepagemain">
	<div class="sitepagetitle">FAQ</div>
	<div class="clearboth"></div>
	<?php if(count($faq_details)>0){
            foreach($faq_details as $faq){?>
			<div class="faqquestiontitle" id="qt<?php echo $faq->fq_id;?>"><?php print($faq->fq_question); ?>&nbsp; <img src="<?php echo $this->config->item('site_baseurl')?>images/right_arrow.jpeg" width="9" height="9" id="arr<?php echo $faq->fq_id;?>"/></div>
                        <div style="clear:both;"></div>
                        <div class="faqanswer" id="ans<?php echo $faq->fq_id;?>"><?php print($faq->fq_answer); ?></div>
                        <div style="clear:both;"></div>
                        <div class="faqhideanswertxt" id="hd<?php echo $faq->fq_id;?>">Hide Answer</div>
                        <div style="clear:both;height:5px;border-bottom:solid 1px #888888;"></div>
	<?php }
        
        } ?>
</div>
<div style="clear:both;"></div>
<script>
    $(document).ready(function() {
   <?php  foreach($faq_details as $faq){?>
           //$("#qt<?php echo $faq->fq_id;?>,#hd<?php echo $faq->fq_id;?>").click(function () {
               $("#qt<?php echo $faq->fq_id;?>").mouseover(function(){
    	         $(this).removeClass().addClass("faqquestiontitlehvour");
                }).mouseout(function(){
                $(this).removeClass().addClass("faqquestiontitle");
                 });
                  $("#hd<?php echo $faq->fq_id;?>").mouseover(function(){
    	         $(this).removeClass().addClass("faqhideanswertxthvour");
                }).mouseout(function(){
                $(this).removeClass().addClass("faqhideanswertxt");
                 });
               $("#qt<?php echo $faq->fq_id;?>,#hd<?php echo $faq->fq_id;?>").click(function () {
                    if ($("#ans<?php echo $faq->fq_id;?>").is(":hidden")) {
                        $("#qt<?php echo $faq->fq_id;?>").removeClass("faqquestiontitle");
                        $("#qt<?php echo $faq->fq_id;?>").addClass("faqquestiontitlehvour");
                        $("#ans<?php echo $faq->fq_id;?>").slideDown("slow");
                        $("#hd<?php echo $faq->fq_id;?>").slideDown("slow");
                        $("#arr<?php echo $faq->fq_id;?>").attr("src","<?php echo $this->config->item('site_baseurl')?>images/down_arrow.jpeg");

                    }else {
                        $("#qt<?php echo $faq->fq_id;?>").removeClass("faqquestiontitlehvour");
                        $("#qt<?php echo $faq->fq_id;?>").addClass("faqquestiontitle");
                         $("#ans<?php echo $faq->fq_id;?>").slideUp("slow");
                         $("#hd<?php echo $faq->fq_id;?>").slideUp("slow");
                         $("#arr<?php echo $faq->fq_id;?>").attr("src","<?php echo $this->config->item('site_baseurl')?>images/right_arrow.jpeg");

                    }
               });
    <?php } ?>

    });
</script>