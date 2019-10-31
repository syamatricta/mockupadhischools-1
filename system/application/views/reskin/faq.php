<?php page_heading('FAQ', '');?>
  
<div class="text-right" style="margin-right:8%;">
    <span><a href="<?php echo base_url(); ?>">Home</a></span>
    <span class="content">|FAQ</span> 
</div>


<section class="faq">
    <div class="container">
        <div class="row">
            <div class="col-sm-12"><input type="text" name="search_faq" id="search_faq" class="form-control" placeholder="Search FAQ" /><i class="fa fa-search fa-search-faq"></i></div>
            <div class="col-sm-12">
                <div class="panel-group panel-group-ext" id="accordion">
                    <?php
                        if(count($faq_details)>0){
                            foreach($faq_details as $faq){
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" data-target="#collapse<?php echo $faq->fq_id;?>">
                            <h2 class="panel-title"><a class="accordion-toggle"><?php print($faq->fq_question); ?></a></h2>
                        </div>
                        <div id="collapse<?php echo $faq->fq_id;?>" class="panel-collapse collapse">
                            <div class="panel-body">
                                <?php print($faq->fq_answer); ?>
                            </div>
                        </div>
                    </div>
                    <?php
                            }
                        } else {
                    ?>
                    <div class="col-sm-12">No data matching your search. Please try again.</div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</section>
