<script src="<?php echo $this->config->item('site_baseurl');?>js/jquery-1.4.2.min.js" type="text/javascript"></script>
<div class="floatleft">
    <div class="left_cntnr pos_rel">
        <?php  $this ->load->view('left_content_sec.php');?>
    </div>
    <div class="right_cntnr">
        <div class="right_cntnr_bg_hd">
           <div class="sitepagehead"><h1>FAQ</h1><h2>FAQ</h2></div>
        </div>
        <div class="right_cntnr_bg">
            <div id="sitepage_main" >
                <div class="clearboth"></div>
                <!-- Search form for FAQ starts-->
                <div class="search_faq">
                   <?php echo  form_open ('faq', array('name'=>'frm_faq','id' => 'frm_faq', 'class' => '') ); ?>
                        <div class="fl fq_out">
                        	<div class="faq_l"></div>
                        	<div class="faq_rpt"><input type="text" name="search_faq" id="search_faq" value="<?php echo $search_faq;?>" class="faqtextbox"/></div>
                        	<div class="faq_r" onclick="faq_search();"></div>
                        </div>
                    </form>
                </div>
                <!-- Search form for FAQ ends-->
                <?php if(count($faq_details)>0){
                        foreach($faq_details as $faq){?>
                            <div class="faq_question_title" id="qt<?php echo $faq->fq_id;?>">
                                <div class="q_text"><?php print($faq->fq_question); ?>&nbsp; </div>
                                <div class="q_img"> <img src="<?php echo $this->config->item('site_baseurl')?>images/right_arrow1.png" title="Show Answer" alt="Show Answer" width="40" height="40" id="arr<?php echo $faq->fq_id;?>"/></div>
                            </div>
                            <div class="fq_list1"></div>
                            <div class="faqanswer" id="ans<?php echo $faq->fq_id;?>"><?php print($faq->fq_answer); ?></div>
                            <div class="cb"></div>
                            <div class="faq_hide_answer_txt" id="hd<?php echo $faq->fq_id;?>"><img src="<?php  echo $this->config->item('images');?>hide.png" alt="Hide Answer" title="Hide Answer" /></div>
                       <?php }
                } else { ?>
                <div class="no-data cb page_error">No data matching your search. Please try again.</div>
                <?php
                }    ?>        
            </div>
            <div class="cb"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
   <?php  foreach($faq_details as $faq){?>           
        $("#qt<?php echo $faq->fq_id;?>,#hd<?php echo $faq->fq_id;?>").click(function () {
            if ($("#ans<?php echo $faq->fq_id;?>").is(":hidden")) {
                $("#ans<?php echo $faq->fq_id;?>").slideDown("slow");
                $("#hd<?php echo $faq->fq_id;?>").slideDown("slow");
                $("#arr<?php echo $faq->fq_id;?>").attr("src","<?php echo $this->config->item('site_baseurl')?>images/down_arrow1.png");
                $("#arr<?php echo $faq->fq_id;?>").attr("title","Hide Answer");
        }else {
                $("#ans<?php echo $faq->fq_id;?>").slideUp("slow");
                $("#hd<?php echo $faq->fq_id;?>").slideUp("slow");
                $("#arr<?php echo $faq->fq_id;?>").attr("src","<?php echo $this->config->item('site_baseurl')?>images/right_arrow1.png");
                $("#arr<?php echo $faq->fq_id;?>").attr("title","Show Answer");
            }
        });
    <?php } ?>
    });
    function faq_search(){document.getElementById('frm_faq').submit();}
</script>