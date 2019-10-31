               <div id="videoContainer" style="display:none">
                   
                    <?php
                    	$video_details = array('intro.mp4','Chapter1.mp4', 'Chapter2.mp4', 'Chapter6.mp4' );   
                    
                        $player_path = base_url() . 'js/jwplayer/player.swf'; 

                        $video_path1 = 'http://streams.adhischools.com/inexpensive/'.urlencode($video_details[0]);
                        $video_path2 = 'http://streams.adhischools.com/inexpensive/'.urlencode($video_details[1]);
                        $video_path3 = 'http://streams.adhischools.com/inexpensive/'.urlencode($video_details[2]);
                        $video_path4 = 'http://streams.adhischools.com/inexpensive/'.urlencode($video_details[3]);


                    	$video_info_array = array(
			   'video_id' => '0',
			   'video_path' => $video_path1
			);
                    ?>
                    <div class="video_player_div"><?php $this->load->view('user/disp_inexpensive_video_player', $video_info_array);?></div>
                    <div class="video_thumb_div">
                        <div class="video_thumb" id="video_thumb" onclick="viewVideo('<?php print $video_path1;?>','<?php print $player_path;?>');"><img src="<?php print base_url();?>images/inexpensive/meet-ourstaff01_slice_10.jpg"></div>
                        <div class="video_thumb" onclick="viewVideo('<?php print $video_path2;?>','<?php print $player_path;?>');"><img src="<?php print base_url();?>images/inexpensive/meet-ourstaff01_slice_07.jpg"></div>
                        <div class="video_thumb" onclick="viewVideo('<?php print $video_path3;?>','<?php print $player_path;?>');"><img src="<?php print base_url();?>images/inexpensive/meet-ourstaff01_slice_12.jpg"></div>
                        <div class="video_thumb_last" onclick="viewVideo('<?php print $video_path4;?>','<?php print $player_path;?>');"><img src="<?php print base_url();?>images/inexpensive/meet-ourstaff01_slice_10.jpg"></div>
                    </div>
                </div>