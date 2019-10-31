<!--<section id="video" class="video">
    <div class="container">
        <div class="col-sm-8 col-sm-offset-2  wow fadeInRight">
            <div id="video_view" class="owl-carousel">  
                <div class="item ">
                    <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item"   src="//www.youtube.com/embed/uqGcHnn_Dgk" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="item ">
                    <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="//www.youtube.com/embed/A8QQeh1uPUQ"  frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>-->

<section id="video" class="video hidden-xs">
    <div class="container" style="width:100%;">
            <?php if(!empty($video_list)) {?>
                <div class="col-sm-12 center wow fadeInRight">
                    <?php foreach($video_list->items as $key => $item) {
                        if($item->id->kind != 'youtube#video'){continue;}
                        if(in_array($key,$selected)) { ?>
                            <!--<iframe class="embed-responsive-item" width="20%" src="https://www.youtube.com/embed/<?php /*echo $item->id->videoId; */?>" frameborder="0" allowfullscreen></iframe>-->
                            <object style="width:20%;"
                                    data="https://www.youtube.com/embed/<?php echo $item->id->videoId; ?>">
                            </object>
                    <?php }
                    } ?>
                </div>
            <?php } else { ?>
                <div class="col-md-12">
                    <iframe width="400" height="315"  src="//www.youtube.com/embed/uqGcHnn_Dgk" frameborder="0" allowfullscreen style="margin-right:5%"></iframe>
                    <iframe width="400" height="315"  src="//www.youtube.com/embed/A8QQeh1uPUQ"  frameborder="0" allowfullscreen style="margin-left:5%" ></iframe>
                </div>
            <?php } ?>
    </div>
</section>

<section id="video" class="video visible-xs">
    <?php if(!empty($video_list)) { ?>
     <div class="container">
        <div class="col-sm-10 center wow fadeInRight">
            <?php foreach($video_list->items as $key => $item) {
                if($item->id->kind != 'youtube#video'){continue;}
                    if(in_array($key,$selected)) { ?>
                    <!--<iframe class="embed-responsive-item" width="90%" src="https://www.youtube.com/embed/<?php /*echo $item->id->videoId; */?>" frameborder="0" allowfullscreen></iframe>-->
                    <object style="width:90%;height:90%;"
                            data="https://www.youtube.com/embed/<?php echo $item->id->videoId; ?>">
                    </object>
            <?php }
             }  ?>
        </div>
     </div>
    <?php } else { ?>
        <div class="col-sm-4 text-center">
            <div class="row text-center-xs">
                <iframe src="//www.youtube.com/embed/uqGcHnn_Dgk" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="row">
                <iframe src="//www.youtube.com/embed/A8QQeh1uPUQ" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    <?php } ?>
</section>
