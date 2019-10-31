<?php $image_url = $this->config->item('inexpensive_image_path');?>
<script src="<?php print base_url()?>js/jwplayer/jwplayer.js"></script>
<div class="floatleft">
      <div class="left_cntnr pos_rel">
            <?php $this ->load->view('left_content_home.php');?>
    </div>
    <div class="right_cntnr">
        <div class="right_cntnr_bg_hd">
        	 <div class="floatleft w100perc">
				 <div class="sitepagehead"><?php if(isset($pagedetails->title) && $pagedetails->title !=''){print($pagedetails->title); } ?></div>
				 <div class="username"><?php disp_loggedin_username(); ?></div>
			 </div>

        </div>
        <div class="right_cntnr_bg">
                <div id="sitepagemain">                    
                    <div class="clearboth"></div>
                           <div class="sitepagecontent_new">
                                <div class="inexpensive_contant_top">
                                    <div class="inexpensive_topcontant">
                                        <span class="inexpensive_contant_top_title">Taking classes online</span><br>
                                        <span class="inexpensive_contant_top_text">can be challenging for anyone. So how do you make sure that you have the greatest chances of success? We have a few things up our sleeve to make sure
                                        that you actually finish.
                                    </span>
                                    </div>
                                </div>

                                <div class="inexpensive_video_div" onclick="javascript:Modalbox.show($('videoContainer'), { width: 782,  title:'&nbsp;'}); return false;">&nbsp;</div>


                                <div class="inexpensive_forum_helpdesk_main">
                                    <div class="forum_section">
                                        <div class="forum_title">&nbsp;</div>
                                        <div class="forum_text">
                                            <div class="forum_help_text_top">&nbsp;</div>
                                            <div class="forum_help_text_content">We have an Internet forum that is constantly monitored for new posts and we respond quickly.<br>Try us.</div>
                                            <div class="forum_help_text_bottom">&nbsp;</div>

                                        </div>
                                    </div>
                                    <div class="helpdesk_section">
                                        <div class="helpdesk_title">&nbsp;</div>
                                        <div class="helpdesk_text">
                                            <div class="forum_help_text_top">&nbsp;</div>
                                            <div class="forum_help_text_content">Need more help with the course material? Post to our Facebook wall, send us a tweet , or just call us at 888 768 5285.</div>
                                            <div class="forum_help_text_bottom">&nbsp;</div>
                                        </div>
                                    </div>

                                </div>
                                <div class="clearboth"></div>
                                <div class="course_main">

                                    <div class="course_material_title">Course Material</div>
                                    <div class="inexpensive_course_material">
                                        <div class="course_material_top"></div>
                                        <div class="course_material_content">
                                            <div class="course_material_content_text">
                                              Don’t forget that the price of our course includes all of your course materials. Each book contains over 450 pages of real estate goodness.
                                              The Real Estate Principles book covers some basic real estate law and a general overview of real estate.
                                              The Real Estate Practice book is going to help you jumpstart your career and pick a great office in which to work.
                                              You have your choice of an elective course <br><br>
                                              You also get access to practice quizzes on our website and within each of the provided textbooks.
                                                                                          </div>
                                            <div class="course_material_content_img">&nbsp;</div>
                                        </div>
                                        <div class="course_material_bottom">&nbsp;</div>

                                     </div>
                                </div>

                                <div class="inexpensive_register_main"><a href="<?php print c('site_ssl_baseurl');?>user/register"><div class="inexpensive_register_link"></div></a></div>
         
                </div>
                <div class="clearboth"></div>
                
                <?php $this->load->view('user/disp_inexpensive_video', '');?>         

        </div>
    </div>
</div>
</div>