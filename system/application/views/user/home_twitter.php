   <?php   
    $i=0; 
    if(!empty($tweets)){
    foreach ($tweets as $tweet) { ?>
    <?php ?>
        <div class="post_cntnr">
             <div class="post_head">
                 <a href="https://twitter.com/adhischools" target="_blank" rel="nofollow"><span class="logo_adhi_img_txt"></span></a>                
                 <a title ="retweet" href="https://twitter.com/intent/retweet?tweet_id=<?php echo $tweet->id_str; ?>" target="_blank" rel="nofollow"><span class="post_icon1"></span></a>
             </div>
             <div class="post_txt">
                 <?php echo $tweet->text."<br />"; ?>                            
             </div>
             <div class="post_txt_bottom">
                 <div class="post_txt_bottom_lft"><?php  echo(isset( $tweet->entities->urls[0]))? '<span class="tweet_colr">'.$tweet->entities->urls[0]->url.' via @youtube'.'</span>':''; ?></div>
                 <div class="post_txt_bottom_rght"><?php $time1=strtotime(date('Y-m-d H:i:s',strtotime($tweet->created_at)));
                    echo ago($time1); //date('Y-M-d',strtotime($tweet->created_at)); ?></div>
             </div>
         </div>

	<?php if($i <2 ){ ?>
       <div class="post_hr"></div>
      <?php }
       $i++;}
	} ?>