<?php
    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    /**
     * Project				-	Adhischools
     * Language				-	PHP 5 & above
     * Database				-	Mysql
     * Author				-	Shinu Mary Simon
     * Created On 			-	October 29, 2009
     * Modified On 			-	October 29, 2009
     * Development Center	-	Rain Concert Technologies Pvt Ltd, Trivandrum, Kerala, India.(http://aarthikaindia.com)
     * */
// ------------------------------------------------------------------------

    class Home extends Controller
    {
        var $gen_contents = array();
        var $siteurl = '';   /* Id of the selected user */

        function Home ()
        {
            parent::Controller();
            $this->load->helper(array('form', 'url', 'file'));
            $this->load->library("session");
            $this->load->model('admin_sitepage_model');
            //$this->load->library('authentication');
            $this->gen_contents['css'] = array('client_style.css', 'style.css');
            $this->gen_contents['js'] = array('client_login.js');
        }
        
        function index(){
            //var_dump($this->session->flashdata('TRIAL_PERIOD_EXPIRED'));exit;
            $this->gen_contents['current_page'] = 'home';
            if('login' == $this->uri->rsegment(3)){
                $this->session->set_flashdata('SHOW_LOGIN_POPUP', TRUE);
                redirect('/');
            }
            if('home' == $this->uri->segment(1)){
                redirect('/');
            }
            $this->load->model('admin_schedule_model');
            
            $this->gen_contents["msg"] = $this->session->userdata('MSG_LOGIN');
            $this->session->set_userdata('MSG_LOGIN', '');
            
            $this->gen_contents['is_users_first_visit'] = (is_users_first_visit() == true ) ? true : false;
            
            $this->gen_contents['dated'] 			=	convert_UTC_to_PST_date_slash(date('m/d/Y H:i:s'));
            
            /*
            $contents  = file_get_contents('http://www.adhischools.com/blog?wpapi=get_posts&count=12&content=1&type=post&orderby=date&order=asc');
            
            //$contents   = $this->_get_blog_posts();
            //echo '<pre>';print_r($contents);exit;
            //$contents  = file_get_contents(base_url().'blog/?wpapi=get_posts');
            //$this->gen_contents["blog"] =json_decode($contents,true);
            
            $contents = json_decode($contents,true);
            $posts   = $contents['posts'];
            usort($posts, 'blog_post_date_compare');
            //echo '<pre>';print_r($post);exit;
            $this->gen_contents["blog"] = $posts;
             
            */
            
            $this->gen_contents["arr_class"] = false;
            if(!$this->authentication->logged_in("normal") || ( $this->authentication->logged_in("normal") && 'Online' != $this->session->userdata('COURSE_TYPE'))){
                $this->gen_contents["arr_class"] = $this->admin_schedule_model->dbGetTonitesClasslist($this->gen_contents['dated'], '','','all');
            }
			
            $this->real_estate_license_info();
		
            
            $this->load->model('admin_trial_account_model');
            $settings                   = $this->admin_trial_account_model->getSettings();
            $this->gen_contents['trial_account_validity'] = $settings->validity_days;
            
            $this->load->model('user_model');
            
            if($this->gen_contents['is_users_first_visit']){
                $popup_captcha                                   = $this->user_model->generate_captcha (array(),"",0);
                $this->session->set_userdata ("popup_captcha_word", $popup_captcha['word']);
                $this->gen_contents['math_captcha_question_popup']     = $popup_captcha;
            }
            
            /*$channelId   = $this->config->item('channel_id');
            $maxResults  = $this->config->item('max_results');
            $API_key     = $this->config->item('api_key');
            $showResults = $this->config->item('show_results');
            
            $this->gen_contents['video_list'] = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId='.$channelId.'&maxResults='.$maxResults.'&key='.$API_key.''));
            $len            = count($this->gen_contents['video_list']->items);
            $selected       = array();
            while(count($selected) < $showResults){
                $rand = rand(0, $len-1);
                if(!in_array($rand, $selected)){
                    array_push($selected, $rand);
                }
            }
            
            while($len != 0){
                $len--;
                unset($this->gen_contents['video_list']->items[$len]->snippet->thumbnails->default);
                unset($this->gen_contents['video_list']->items[$len]->snippet->thumbnails->high);
            }*/
            /*print_r($this->gen_contents['video_list']);
            die('coming soon....');
            $this->gen_contents['selected']  = $selected;*/
            
            $captcha                                   = $this->user_model->generate_captcha (array(),"",0);
            $this->session->set_userdata ("captcha_word", $captcha['word']);
            $this->gen_contents['math_captcha_question']     = $captcha;
            
            $this->template->write_view('content', 'reskin/home', $this->gen_contents);
            $this->template->render();
        }
		
        function _get_blog_posts(){
            $params = array('type' => 'post', 'per_page' => 12, 'orderby' => 'date', 'order' => 'desc');
            $ch=curl_init();
            //curl_setopt($ch,CURLOPT_URL,'http://www.adhischools.com/blog/wp-json/wp/v2/posts');
            curl_setopt($ch,CURLOPT_URL,'http://192.168.0.165/adhischools/blog/index.php/wp-json/wp/v2/posts?'.http_build_query($params));
            curl_setopt($ch, CURLOPT_POST, 0);
            //curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            $return = curl_exec($ch);
            curl_close($ch);
            if (empty($return)){
                return false;
            }else{
                return $return;
            }
        }
        function new_about(){
            /*$this->gen_contents['css'] = array('client_style.css', 'style.css');
            $this->gen_contents['js'] = array('client_login.js');  
            
            
            $this->template->write_view('content', 'reskin/about', $this->gen_contents);
            $this->template->render();*/
            
            $this->siteurl = $this->uri->segment('1');
            $this->gen_contents['siteurl'] = $this->admin_sitepage_model->select_sitepages_url();
            $this->gen_contents['pagedetails'] = $this->admin_sitepage_model->select_single_sitepage_details($this->siteurl);
            
            
            $this->template->write_view('content', 'reskin/about', $this->gen_contents);
            
            $this->template->render();
//        echo $this->siteurl; exit;



            
        }
            function california_real_estate_classes(){
                $this->real_estate_license_info();

                 $this->load->model ('admin_trial_account_model');
                $settings                                       = $this->admin_trial_account_model->getSettings();
                $this->gen_contents['trial_account_validity']   = $settings->validity_days;
                $this->siteurl = $this->uri->segment('1');

                $this->gen_contents['siteurl'] = $this->admin_sitepage_model->select_sitepages_url();
                $this->gen_contents['pagedetails'] = $this->admin_sitepage_model->select_single_sitepage_details($this->siteurl);

                $this->template->write_view('content', 'reskin/pages', $this->gen_contents);
                $this->template->render();
            }
            function real_estate_education_app(){
                $this->siteurl = 'real-estate-exam-app';
			 
                $this->gen_contents['siteurl'] = $this->admin_sitepage_model->select_sitepages_url();
                $this->gen_contents['pagedetails'] = $this->admin_sitepage_model->select_single_sitepage_details($this->siteurl);
            
            
                $this->template->write_view('content', 'reskin/pages', $this->gen_contents);
                $this->template->render();
            }
	    
            function history_of_excellence(){
                $this->siteurl = 'best-real-estate-school';
			
                $this->gen_contents['siteurl'] = $this->admin_sitepage_model->select_sitepages_url();
                $this->gen_contents['pagedetails'] = $this->admin_sitepage_model->select_single_sitepage_details($this->siteurl);
            
            
                $this->template->write_view('content', 'reskin/pages', $this->gen_contents);
                $this->template->render();
		}
	
        /*
        function our_numbers(){
            $this->siteurl                  = 'why-we-are-the-best-real-estate-school';
			
            $this->gen_contents['siteurl']  = $this->admin_sitepage_model->select_sitepages_url();
            $this->gen_contents['pagedetails'] = $this->admin_sitepage_model->select_single_sitepage_details($this->siteurl);
            
            
            $this->template->write_view('content', 'reskin/our_numbers', $this->gen_contents);
            $this->template->render();
        }
        */
                
        /**
         * function to load the home template (header, body and footer)
         *
         * @param string $page
         * @param array $contents
         */
        function _home_template ($page, $contents)
        {
            $this->load->view("client_home_header", $contents);
            $this->load->view('user/' . $page, $contents);
            $this->load->view("client_home_footer", $contents);
        }

        function _homemain_template ($page, $contents)
        {
            $this->load->view("client_home_header_new", $contents);
            $this->load->view('user/' . $page, $contents);
            $this->load->view("client_homemain_footer_new", $contents);
        }

        /**
         * function to load the template (header, body and footer)
         *
         * @param string $page
         * @param array $contents
         */
        function _template ($page, $contents)
        {
            $this->load->view("client_common_header_new", $contents);
            $this->load->view('user/' . $page, $contents);
            $this->load->view("client_common_footer_new", $contents);
        }

        /**
         * function to load the template jquery (header, body and footer)
         *
         * @param string $page
         * @param array $contents
         */
        function _template_sec ($page, $contents)
        {
            $this->load->view("client_common_headersec_new", $contents);
            $this->load->view('user/' . $page, $contents);
            $this->load->view("client_common_footer_new", $contents);
        }

        /**
         * function to load the home template (header, body and footer)
         *
         * @param string $page
         * @param array $contents
         */
        function _template_wt_parsedjs ($page, $contents)
        {
            $this->load->view("client_common_header_wtjs", $contents);
            $this->load->view('user/' . $page, $contents);
            $this->load->view("client_common_footer_wtjs", $contents);
        }

        function _home_template_new ($page, $contents)
        {
            $this->load->view("client_home_header_new", $contents);
            $this->load->view('user/' . $page, $contents);
            $this->load->view("client_home_footer_new", $contents);
        }

        function getConnectionWithAccessToken ($cons_key, $cons_secret, $oauth_token, $oauth_token_secret)
        {
            $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
            return $connection;
        }

        /**
         * Index
         *
         * @access	public
         */
        function index_old (){        	
            if ($this->authentication->logged_in("normal")){
                redirect("profile");
            }
            $this->gen_contents["msg"] = $this->session->userdata('MSG_LOGIN');
            $this->session->set_userdata('MSG_LOGIN', '');
            $this->gen_contents['is_users_first_visit'] = (is_users_first_visit() == true ) ? true : false;
            $this->siteurl 							= $this->uri->segment('1');
            $this->gen_contents['siteurl']			= $this->admin_sitepage_model->select_sitepages_url();
            $this->gen_contents['thinkingabout']	= $this->admin_sitepage_model->select_single_sitepage_det(3);
            $this->gen_contents['gotquestion'] 		= $this->admin_sitepage_model->select_single_sitepage_det(4);
            $this->gen_contents['js'] 				= array_merge($this->gen_contents['js'], array("effects.js", "modalbox.js", "jquery-1.4.2.min.js", "jquery.easing.js", "jquery.cycle.all.js", "homescroller.js", "inlinehome.js","disp_rel_cls.js", 'overlay_custom.js'));
            $this->gen_contents['css'] 				= array_merge($this->gen_contents['css'], array("modalbox.css", "homescroller.css","inlinehome.css","disp_rel_cls.css", 'overlaypopup.css'));
            
            if($this->gen_contents['is_users_first_visit'] == true){
                $this->gen_contents['js'] 				= array_merge($this->gen_contents['js'], array('overlay_custom.js'));
                $this->gen_contents['css'] 				= array_merge($this->gen_contents['css'], array('overlaypopup.css'));
            }
            
            $this->gen_contents['banners'] 			= $this->admin_sitepage_model->get_banners();

            $this->load->model('admin_schedule_model');
            $this->gen_contents['dated'] 			=	convert_UTC_to_PST_date_slash(date('m/d/Y H:i:s'));

            $this->gen_contents["offset_hidden"]	= 0;
            $this->gen_contents["num_hidden"] 		= 5;
            $this->gen_contents['image_path'] 		= $this->config->item('image_upload_url') . 'thumbs/';
            $this->gen_contents['modal_path'] 		= 'home/class_details';
            $this->gen_contents['modal_form'] 		= 'tonightclassform';
            $this->commonListRelatedRegion();
            $this->real_estate_license_info();
            
            $this->_homemain_template('client_home_page_new', $this->gen_contents);
        }
        
        function test123(){
            $this->admin_sitepage_model->test_enroll_check();
        }

        /**
         * showing login with msg
         *
         * @access	public
         */
        function login ()
        {
            if ($this->authentication->logged_in("normal"))
                redirect("profile");
            $msg = $this->uri->segment(3);
            $this->gen_contents['siteurl'] = $this->admin_sitepage_model->select_sitepages_url();
            $this->gen_contents['thinkingabout'] = $this->admin_sitepage_model->select_single_sitepage_det(3);
            $this->gen_contents['gotquestion'] = $this->admin_sitepage_model->select_single_sitepage_det(4);
            $this->gen_contents['msg'] = $msg;
            $this->gen_contents['banners'] = $this->admin_sitepage_model->get_banners();
//			if($msg==1)$this->admin_sitepage_model->select_single_sitepage_details($this->siteurl);
//				$this->session->set_flashdata('msg', 'You are already logged in');
//			else if($msg==2)
//				$this->session->set_flashdata('msg', 'You are already in Exam mode');
            /* $this->load->view('client_common_header',$this->gen_contents);
              $this->load->view('user/client_home_page');
              $this->load->view('client_common_footer'); */
            $this->gen_contents['js'] = array_merge($this->gen_contents['js'], array("effects.js", "modalbox.js", "jquery-1.4.2.min.js", "jquery.easing.js", "jquery.cycle.all.js", "homescroller.js"));
            $this->gen_contents['css'] = array_merge($this->gen_contents['css'], array("modalbox.css", "homescroller.css"));

            $this->load->model('admin_schedule_model');
            $this->gen_contents['dated'] = convert_UTC_to_PST_date_slash(date('m/d/Y H:i:s'));
            $this->gen_contents["offset_hidden"] = 0;
            $this->gen_contents["num_hidden"] = 5;
            $this->gen_contents['image_path'] = $this->config->item('image_upload_url') . 'thumbs/';
            $this->gen_contents['modal_path'] = 'home/class_details';
            $this->gen_contents['modal_form'] = 'tonightclassform';

            //Load the shiny new rssparse
            $this->load->library('RSSParser', array('url' => 'http://www.adhischools.com/blog/feed/', 'life' => 0));
            //Get one item from the feed
            $data = $this->rssparser->getFeed(1);
            $this->gen_contents['blog_posts_rss'] = $data;


            $this->commonListRelatedRegion();
            $this->_home_template('client_home_page', $this->gen_contents);
        }

        /**
         * showing login with msg
         *
         * @access	public
         */
        function forgot_password ()
        {
            if ($this->authentication->logged_in("normal"))
                redirect("profile");
            $msg = $this->uri->segment(3);
            $this->gen_contents['siteurl'] = $this->admin_sitepage_model->select_sitepages_url();
            $this->gen_contents['page_title'] = 'Forgot Password ';
            $this->gen_contents['siteurl'] = $this->admin_sitepage_model->select_sitepages_url();
            $this->gen_contents['thinkingabout'] = $this->admin_sitepage_model->select_single_sitepage_det(3);
            $this->gen_contents['gotquestion'] = $this->admin_sitepage_model->select_single_sitepage_det(4);
            /* $this->load->view('client_common_header',$this->gen_contents);
              $this->load->view('user/forgot_password');
              $this->load->view('client_common_footer'); */
            $this->_template('forgot_password', $this->gen_contents);
        }

        /**
         * About Us
         */
        function aboutus ()
        {
            $this->gen_contents['css'] = array_merge($this->gen_contents['css'], array("about.css"));
            $this->siteurl = $this->uri->segment('1');
            $this->gen_contents['siteurl'] = $this->admin_sitepage_model->select_sitepages_url();
            $this->gen_contents['pagedetails'] = $this->admin_sitepage_model->select_single_sitepage_details($this->siteurl);
            $this->_home_template_new('disp_sitepage_new_aboutus', $this->gen_contents);
        }

        /**
         * About Us
         */
        function articles ()
        {
            redirect();
            
            $this->gen_contents['css'] = array('client_style.css', 'style.css', 'articles.css');
            $this->gen_contents['siteurl'] = $this->admin_sitepage_model->select_sitepages_url();
            $this->load->view("user/articles_content_new", $this->gen_contents); 
        }

        /**
         * Contact Us
         */
        function contactus ()
        {
            /*$this->gen_contents['css'] = array_merge($this->gen_contents['css'], array("sitepg.css"));
            $this->siteurl = $this->uri->segment('1');
            $this->gen_contents['siteurl'] 	= $this->admin_sitepage_model->select_sitepages_url();
            $this->gen_contents['pagedetails']	= $this->admin_sitepage_model->select_single_sitepage_details($this->siteurl);
            $this->_home_template_new('disp_sitepage_new', $this->gen_contents);*/
            
            $this->siteurl = $this->uri->segment('1');
            $this->gen_contents['siteurl'] = $this->admin_sitepage_model->select_sitepages_url();
            $this->gen_contents['pagedetails'] = $this->admin_sitepage_model->select_single_sitepage_details($this->siteurl);
            
            $this->template->write_view('content', 'reskin/pages', $this->gen_contents);
            $this->template->render();
        }
        
        function sitemap(){
            
            $this->template->write_view('content', 'reskin/sitemap', $this->gen_contents);
            $this->template->render();
        }
   
        function text_image($text){
        	$im = imagecreatetruecolor(120, 20);
			$text_color = imagecolorallocate($im, 233, 14, 91);
			imagestring($im, 1, 5, 5,  $text, $text_color);
			
			// Set the content type header - in this case image/jpeg
			header('Content-Type: image/jpeg');
			
			// Output the image
			imagejpeg($im);
			
			// Free up memory
			imagedestroy($im);
        }
        /**
         * Thinking about real estate
         */
        function thinkingaboutrealestate ()
        {
            $this->siteurl = $this->uri->segment('1');
            $this->gen_contents['siteurl'] = $this->admin_sitepage_model->select_sitepages_url();
            $this->gen_contents['pagedetails'] = $this->admin_sitepage_model->select_single_sitepage_details($this->siteurl);
            $this->_template('disp_sitepage', $this->gen_contents);
        }

        /**
         * Got Questions
         */
        function gotquestions ()
        {
            redirect('faq');
            /* $this->siteurl	=	$this->uri->segment('1');
              $this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();
              $this->gen_contents['pagedetails']	=	$this->admin_sitepage_model->select_single_sitepage_details($this->siteurl);
              $this->_template('disp_sitepage',$this->gen_contents); */
        }

        /**
         * privacy policy
         */
        function privacypolicy ()
        {
            $this->gen_contents['css'] = array_merge($this->gen_contents['css'], array("sitepg.css"));
            $this->siteurl = $this->uri->segment('1');
            $this->gen_contents['siteurl'] = $this->admin_sitepage_model->select_sitepages_url();
            $this->gen_contents['pagedetails'] = $this->admin_sitepage_model->select_single_sitepage_details($this->siteurl);

            //$this->_home_template_new('disp_sitepage_new', $this->gen_contents);
			
            $this->template->write_view('content', 'reskin/pages', $this->gen_contents);
            $this->template->render();

        }

        /**
         * terms of use
         */
        function termsofuse ()
        {
            $this->gen_contents['css'] = array_merge($this->gen_contents['css'], array("sitepg.css"));
            $this->siteurl = $this->uri->segment('1');
            $this->gen_contents['siteurl'] = $this->admin_sitepage_model->select_sitepages_url();
            $this->gen_contents['pagedetails'] = $this->admin_sitepage_model->select_single_sitepage_details($this->siteurl);
            $this->template->write_view('content', 'reskin/pages', $this->gen_contents);
            $this->template->render();
        }

        /**
         * testimonial
         */
        function testimonial ()
        {
            $this->load->model('admin_testimonial_model');
            $this->gen_contents['testimonials'] = $this->admin_testimonial_model->select_testimonial('','','',false);
            $this->template->write_view('content', 'reskin/testimonial', $this->gen_contents);
            $this->template->render();
        }

        /**
         * brokerplacement
         */
        function brokerplacement (){        	 
            
			$this->siteurl = 'brokerplacement';//$this->uri->segment('1');
            $this->gen_contents['siteurl'] = $this->admin_sitepage_model->select_sitepages_url();
            $this->gen_contents['pagedetails'] = $this->admin_sitepage_model->select_single_sitepage_details($this->siteurl);			 
			$this->gen_contents['postcode_lat_long'] = $this->admin_sitepage_model->getPostcodeLatitudeLongitude();

            if (count($this->gen_contents['postcode_lat_long']))
            {
                // $this->session->set_userdata('current_postcode',$search_str);
                $this->gen_contents['search_page'] = ($this->uri->segment(4)) ? abs(intval($this->uri->segment(4))) : 0;
                $this->gen_contents['postcode_offset'] = intval($this->gen_contents['search_page'] * 10);
                $this->gen_contents['postcode_limit'] = 10;
                $this->gen_contents['postcode_map_data'] = $this->admin_sitepage_model->getPostcodeSearchData(
                    $this->gen_contents['postcode_lat_long']->co_lattitude, $this->gen_contents['postcode_lat_long']->co_longitude);
            }
            else
            {
                $this->gen_contents['postcode_data'] = array();
                $this->gen_contents['search_type'] = 'g';
            }		
            $this->template->write_view('content', 'reskin/careers', $this->gen_contents);
            $this->template->render();
        } 

        function brokerplacementdetails ()
        {
            $this->gen_contents['pagedetails'] = $this->admin_sitepage_model->select_single_sitepage_details('brokerplacement');
            $search_str = $this->uri->segment('3');

            $this->gen_contents['contentdetails'] = $this->admin_sitepage_model->getcntdetails($search_str);
            // print_r($this->gen_contents['contentdetails']);
            $this->load->view('user/disp_brokerplacement_details', $this->gen_contents);
        }

		function brokerplacementdetailsreskin ()
        {
            $this->gen_contents['pagedetails'] = $this->admin_sitepage_model->select_single_sitepage_details('brokerplacement');
            $search_str = $this->uri->segment('3');

            $this->gen_contents['contentdetails'] = $this->admin_sitepage_model->getcntdetails($search_str);
            // print_r($this->gen_contents['contentdetails']);
            $this->load->view('reskin/careers_popup', $this->gen_contents);
        }
        /**
         * faq
         */
        function faq ()
        {
            $this->siteurl = $this->uri->segment('1');
            //$this->gen_contents['css'] = array_merge($this->gen_contents['css'], array("faq.css"));
            //if($this->input->post('search_faq')) {
            //    $search_faq = $this->input->post('search_faq');
            //} else {
            //    $search_faq = "";
            //}
            $this->load->model('admin_trial_account_model');
            $settings           = $this->admin_trial_account_model->getSettings();
            $check_variables    = array('{{EXPIRY_VALIDITY_DAY}}');
            $relpace_values     = array($settings->validity_days);
            $faq_details        = $this->admin_sitepage_model->select_faq_det('');
            foreach($faq_details as  $faq_detail){
                $faq_detail->fq_question  = str_replace($check_variables, $relpace_values, $faq_detail->fq_question);
                $faq_detail->fq_answer    = str_replace($check_variables, $relpace_values, $faq_detail->fq_answer);
            }
            
            $this->gen_contents['faq_details'] = $faq_details;
            //$this->gen_contents['siteurl'] = $this->admin_sitepage_model->select_sitepages_url();
            //print_r($this->gen_contents['siteurl']) ;exit;
            //$this->gen_contents['search_faq'] = $search_faq;
            //$this->_template_sec('disp_faq_new', $this->gen_contents);
            
            
            
            $this->template->write_view('content', 'reskin/faq', $this->gen_contents);
            $this->template->render();
        }

        /**
         *  Blog
         */
        function blog ()
        {
            $this->siteurl = $this->uri->segment('1');
            $this->gen_contents['siteurl'] = $this->admin_sitepage_model->select_sitepages_url();
            $this->gen_contents['pagedetails'] = $this->admin_sitepage_model->select_single_sitepage_details($this->siteurl);
            $this->_template('disp_sitepage', $this->gen_contents);
        }

        /**
         * SCHEDULE
         */
        function schedule ()
        {
            redirect('schedule');
             $this->siteurl	=	$this->uri->segment('1');
              $this->gen_contents['siteurl']	=	$this->admin_sitepage_model->select_sitepages_url();
              $this->gen_contents['pagedetails']	=	$this->admin_sitepage_model->select_single_sitepage_details($this->siteurl);
              $this->_template('disp_sitepage',$this->gen_contents); 
        }

        /**
         * Exam Rules
         */
        function examrules ()
        {
            $this->gen_contents['page_title'] = "Exam Rules";
            $this->gen_contents['pageid'] = '7';
            $this->gen_contents['pagedetails'] = $this->admin_sitepage_model->select_single_sitepage_det($this->gen_contents['pageid']);
            $this->load->view('user/disp_sitepage', $this->gen_contents);
        }

        /**
         * Exam Score
         */
        function examscore ()
        {//die('ddddd');
            $this->gen_contents['page_title'] = "Exam Score";


            $this->gen_contents['pagedetails'] = "Your Score is " . $this->uri->segment(3);
            $this->load->view('exam/view_score', $this->gen_contents);
        }

          function page_1()
        {//die('ddddd');
            $this->gen_contents['page_1'] = "Exam Score";


            $this->gen_contents['pagedetails'] = "Your Score is " . $this->uri->segment(3);
            $this->load->view('exam/view_score', $this->gen_contents);
        }
        
        
        
        /**
         * Exam Score
         */
        
        //notneed
        /*
        function examscore_scr ()
        {//die('ddddd');
            $this->gen_contents['page_title'] = "Exam Score";
            $this->load->model('course_model');
            $userid = $this->session->userdata('USERID');
            $this->_init_course_end();
            $data = $this->course_model->get_score($this->uri->segment(3), $userid);

            $this->gen_contents['pagedetails'] = "Your Score is " . $data->final_score;
            $this->load->view('exam/view_score', $this->gen_contents);
        }
        */
        
		//notneed
        /*
		function _init_course_end ()
        {
            $this->load->model('course_model');
            $this->load->model('user_exam_model');
            $this->load->model('quiz_model');
            $this->load->model('Common_model');
            $this->load->model('admin_sitepage_model');

            $this->gen_contents['siteurl'] = $this->admin_sitepage_model->select_sitepages_url();
            if ($this->authentication->logged_in("normal"))
            {
                $this->session->userdata('EXAMMODEID');
                $exam_mode = $this->course_model->check_ajaxupdate($this->session->userdata('EXAMMODEID'));


                if (isset($exam_mode) && $exam_mode)
                {
                    $examtime = convert_UTC_to_PST_timeonly();
                    $exam_time = $examtime - $exam_mode->exam_time;
                    if ($exam_time > 10)
                    {

                        $data = $this->course_model->get_exam_detail($this->session->userdata('USERID'));

                        if ($data)
                        {
                            for ($i = 0; $i < count($data); $i++)
                            {

                                $grade = $this->user_exam_model->get_grade($data[$i]->exam_score);
                                if ($grade)
                                    $status = 'P';
                                else
                                    $status = 'F';
								
                                //notneed
                                //$data = $this->course_model->update_score($this->session->userdata('USERID'), $status, $data[$i]->user_course_id, $data[$i]->exam_score, $data[$i]->id);
                            }
                        }else
                        {

                            $this->course_model->update_score_fail($exam_mode->user_id, 'F', $exam_mode->course_id, 0);
                        }
                        //$this->user_exam_model->delete_exam_date($this->session->userdata('EXAMMODEID'));

                        $this->user_exam_model->update_endexam_status('', '', $this->session->userdata('EXAMMODEID'));

                        $session_items = array('EXAMMODEID' => '');
                        $this->session->unset_userdata($session_items);
                    }
                }
                $quiz_mode = $this->quiz_model->check_ajaxupdate_quiz($this->session->userdata('QUIZMODEID'));


                if (isset($quiz_mode) && $quiz_mode)
                {
                    $examtime = convert_UTC_to_PST_timeonly();
                    $exam_time = $examtime - $quiz_mode->quiz_time;
                    if ($exam_time > 10)
                    {

                        $this->quiz_model->update_endquiz_status('', '', $this->session->userdata('QUIZMODEID'));

                        $session_items = array('QUIZMODEID' => '');
                        $this->session->unset_userdata($session_items);
                    }
                }
            }
        }
        */
        

        /**
         * Exam Rules
         */
        function quizrules ()
        {
            $this->gen_contents['page_title'] = "Quiz Rules";
            $this->gen_contents['pageid'] = '11';
            $this->gen_contents['pagedetails'] = $this->admin_sitepage_model->select_single_sitepage_det($this->gen_contents['pageid']);
            $this->load->view('user/disp_sitepage', $this->gen_contents);
        }

        function commonListRelatedRegion ()
        {

            $this->load->model('admin_schedule_model');

            $this->gen_contents["tot_num_related_region"] = $this->admin_schedule_model->dbGetCountTonitesClasslist($this->gen_contents['dated']);

            $this->gen_contents["next_active"] = 0; //1 for enable and 0 for disable
            $this->gen_contents["prev_active"] = 0; //1 for enable and 0 for disable
            $num_pages = ceil($this->gen_contents["tot_num_related_region"] / $this->gen_contents["num_hidden"]) - 1;
            $cur_page = ceil(($this->gen_contents["offset_hidden"] / $this->gen_contents["num_hidden"]));
            if ($cur_page < $num_pages)
            {
                $this->gen_contents["next_active"] = 1;
            }
            if ($cur_page > 0)
            {
                $this->gen_contents["prev_active"] = 1;
            }
            $this->gen_contents['image_path'] = $this->config->item('image_upload_url') . 'thumbs/';
            $this->gen_contents["arr_result"] = $this->admin_schedule_model->dbGetTonitesClasslist($this->gen_contents['dated'], $this->gen_contents["num_hidden"], $this->gen_contents["offset_hidden"]);
        }

        function related_region ()
        {
            $this->gen_contents['modal_path'] = 'home/class_details';
            $this->gen_contents['modal_form'] = 'tonightclassform';
            if (!empty($_POST))
            {
                $this->gen_contents['dated'] = $_POST['dated'];
                $this->gen_contents['subregion'] = $_POST['subregion'];
                $this->gen_contents["offset_hidden"] = $_POST['offset'];
                $this->gen_contents["num_hidden"] = 5;

                $this->commonListRelatedRegion();
            }
            else
            {
                $this->gen_contents["arr_result"] = array();
            }
            $related_regions = $this->load->view('user/display_related_class', $this->gen_contents);
            echo $related_regions;
        }

        function class_details ()
        {

            $this->load->model('admin_schedule_model');
            $this->gen_contents['image_path'] = $this->config->item('image_upload_url') . 'thumbs/';
            $image_path = $this->config->item('image_upload_path') . 'thumbs/';
            if ($this->uri->segment('4') > 0 && $this->uri->segment('5') > 0 && $this->uri->segment('6') > 0)
            {
                $this->gen_contents['dated'] = $this->uri->segment('4') . '/' . $this->uri->segment('5') . '/' . $this->uri->segment('6');
            }
            else if (isset($_REQUEST['hdnDated']))
                $this->gen_contents['dated'] = $_REQUEST['hdnDated'];
            else
                $this->gen_contents['dated'] = date('m/d/Y');
            if ($this->uri->segment('3') > 0)
            {
                $this->gen_contents['hdnSubregion'] = $this->uri->segment('3');
            }
            else if (isset($_REQUEST['hdnSubregion']) && $_REQUEST['hdnSubregion'] != '')
                $this->gen_contents['hdnSubregion'] = $_REQUEST['hdnSubregion'];
            else
                $this->gen_contents['hdnSubregion'] = '';

            $this->gen_contents['arr_class'] = $this->admin_schedule_model->dbGetClassDetailsForSubregion($this->gen_contents['hdnSubregion'], $this->gen_contents['dated']);
            $this->gen_contents['arr_subregion'] = $this->admin_schedule_model->dbSelectSingleSubRegion($this->gen_contents['hdnSubregion']);

            $image = $image_path . $this->gen_contents['arr_subregion']->image_name;

            if ($this->gen_contents['arr_subregion']->image_name && file_exists($image))
            {
                $this->gen_contents['image_url'] = $this->gen_contents['image_path'] . $this->gen_contents['arr_subregion']->image_name;
            }
            else
            {
                $this->gen_contents['image_url'] = $this->config->item('images') . 'default_image.jpg';
            }
            $this->gen_contents['adhi_course'] = $this->admin_schedule_model->dbSelectSelcCrashCourse();
            $this->load->view('user/display_class_details', $this->gen_contents);
        }

        /**
         * Banners
         */
        function banners ()
        {
            $banner_id = (int) $this->uri->segment('2');
            $this->gen_contents['banner_details'] = $this->admin_sitepage_model->select_banners(1, 0, $banner_id);
            if (is_array($this->gen_contents['banner_details']) && count($this->gen_contents['banner_details']) > 0)
            {
                /* $this->siteurl	=	'banner'.$banner_id;

                  $this->gen_contents['pagedetails']		=	$this->admin_sitepage_model->select_single_sitepage_details_from_id($this->gen_contents['banner_details'][0]->sitepage_id);
                 */
                $this->gen_contents['siteurl'] = $this->admin_sitepage_model->select_sitepages_url();
                $this->_template('disp_sitepage_banners', $this->gen_contents);
            }
            else
            {
                redirect('home');
            }
        }

        /**
         * meet our staff
         */
        function meet_our_staff ()
        {
        	$this->gen_contents['css'] = array_merge($this->gen_contents['css'], array("meet.css"));
        	$this->gen_contents['js'] = array_merge($this->gen_contents['js'], array("meet.js"));
            $this->load->model('admin_meet_staff_model');
            $this->siteurl = $this->uri->segment('1');
            $this->gen_contents['siteurl'] = $this->admin_sitepage_model->select_sitepages_url();
            $this->gen_contents['pagedetails'] = $this->admin_sitepage_model->select_single_sitepage_details($this->siteurl);
            $this->gen_contents['staffs'] = $this->admin_meet_staff_model->select_staffs();
 
           // $this->_home_template_new('meetstaff/meet_staff', $this->gen_contents);
			 
			$this->template->write_view('content', 'reskin/meet_staff', $this->gen_contents);
            $this->template->render();
        }

        function inexpensive_old ()
        {
            //redirect('/');
            $this->siteurl = $this->uri->segment('1');
            $this->gen_contents['js'] = array_merge($this->gen_contents['js'], array("effects.js", "modalbox.js", "inexpensive.js"));
            $this->gen_contents['css'] = array_merge($this->gen_contents['css'], array("modalbox.css", "homescroller.css", "inexpensive.css"));
            $this->gen_contents['siteurl'] = $this->admin_sitepage_model->select_sitepages_url();
            $this->gen_contents['pagedetails'] = $this->admin_sitepage_model->select_single_sitepage_details($this->siteurl);
            $this->_home_template_new('disp_sitepage_new_inexpensive', $this->gen_contents);
        }
        function inexpensive(){
            $this->gen_contents['pagedetails'] = $this->admin_sitepage_model->select_single_sitepage_details('inexpensive');
            
            $this->template->write_view('content', 'reskin/inexpensive', $this->gen_contents);
            $this->template->render();
        }
        function real_estate_license_info ()
        {
            $this->question_format = 'word';
            
            if(!isset($_POST['submit']) && !isset($_POST['submit_popup'])){
                $this->load->model('user_model');
                $captcha                                   = $this->user_model->generate_captcha (array(),"",0);
                $this->session->set_userdata ("captcha_word", $captcha['word']);
                $this->gen_contents['math_captcha_question']     =  $captcha;
                
                $captcha                                   = $this->user_model->generate_captcha (array(),"",0);
                $this->session->set_userdata ("popup_captcha_word", $captcha['word']);
                $this->gen_contents['math_captcha_question_popup']=  $captcha;
                return;
            }
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->load->model('common_model');
            //Validate fields
            if(isset($_POST['submit_popup'])){
                $this->form_validation->set_rules('licencee_name_popup', 'name', 'required|trim|strip_tags|max_length[50]|xss_clean');
                $this->form_validation->set_rules('licencee_email_popup', 'email', 'required|trim|strip_tags|valid_email|xss_clean');
                $this->form_validation->set_rules('math_captcha_popup', 'CAPTCHA', 'required|trim|callback_checkmathcaptchapopups');
                $name = $this->input->post('licencee_name_popup');
                $email = $this->input->post('licencee_email_popup');
                $phone_number = $this->input->post('licencee_phone_popup') ? $this->input->post('licencee_phone_popup') : '';
                $new_user = 1;
            }else{
                $this->form_validation->set_rules('licencee_name', 'name', 'required|trim|strip_tags|max_length[50]|xss_clean');
                $this->form_validation->set_rules('licencee_email', 'email', 'required|trim|strip_tags|valid_email|xss_clean');
                $this->form_validation->set_rules('math_captcha', 'CAPTCHA', 'required|trim|callback_checkmathcaptchas');
                $name = $this->input->post('licencee_name');
                $email = $this->input->post('licencee_email');
                $phone_number = $this->input->post('licencee_phone') ? $this->input->post('licencee_phone') : '';
                $new_user = 0;
            } 
            $data = array();
            if ($this->form_validation->run() != FALSE)
            {
                
                /* Logic changed from classes in next week to classes from today for next 14 days and course only real estate principles
                $query = $this->db->query("SELECT `adhi_subregion`.`id` , `subregion_name` , `region_id` , `subregion_address` , DAYNAME(`date`) AS day, CONCAT( TIME_FORMAT( `time_start` , '%h %i %p' ) , ' - ', TIME_FORMAT( `time_end` , '%h %i %p' ) ) AS time
                    FROM `adhi_subregion`
                    JOIN `adhi_events_master` ON `adhi_events_master`.`subregion_id` = `adhi_subregion`.`id`
                    WHERE week( date ) = ( week( now( ) ) +1 )
                    AND year( date ) = year( now( ) )
                    GROUP BY `adhi_events_master`.`subregion_id`
                    ORDER BY date ASC, time_start ASC");
                */
                
                $cours_nam = "Real Estate Principles";
                
                $query = $this->db->query("SELECT `adhi_subregion`.`id` , `subregion_name` , `region_id` , `subregion_address` , DAYNAME(`date`) AS day, `date` AS the_date, CONCAT( TIME_FORMAT( `time_start` , '%h %i %p' ) , ' - ', TIME_FORMAT( `time_end` , '%h %i %p' ) ) AS time, `repeat_status`,  `repeat_till`
                    ,`adhi_courses`.`id` as course_id FROM `adhi_subregion`
                    JOIN `adhi_events_master` ON `adhi_events_master`.`subregion_id` = `adhi_subregion`.`id`
                    JOIN `adhi_courses` ON `adhi_courses`.`id` = `adhi_events_master`.`course_id`
                    WHERE (date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 13 day)
                    OR CURDATE() BETWEEN `date` AND `repeat_till`)
                    AND `adhi_courses`.`course_name` = '".$cours_nam."'
                    GROUP BY `adhi_events_master`.`subregion_id`
                    ORDER BY date ASC, time_start ASC");
                
                $data = $query->result();
                
                $this->load->model ('admin_trial_account_model');
                $settings                                       = $this->admin_trial_account_model->getSettings();
                $this->gen_contents['trial_account_validity']   = $settings->validity_days;
                
                if(!empty($data)){
                    $date_array = array();
                    $today = date("Y-m-d");
                    $limit = date('Y-m-d', strtotime(date("Y-m-d") . ' +14 day'));
                    
                    foreach($data as $key => $d){
                        $min_date = $d->the_date;
                        
                        if(strtotime($min_date) < strtotime($today)){
                            if($d ->repeat_status == 1){
                                $date_array = $this->date_range($d->the_date, $d->repeat_till, $limit, '+1 day', 'Y-m-d' );
                            }

                            if($d->repeat_status == 2){
                                $date_array = $this->date_range($d->the_date, $d->repeat_till, $limit, '+7 day', 'Y-m-d' );
                            }
                            
                            if(!empty($date_array)){
                                foreach($date_array as $dt){
                                    if(strtotime($dt) >= strtotime($today)){
                                        $data[$key]->the_date = $dt;
                                        $data[$key]->day = date('l', strtotime($dt));
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    
                    usort($data,function ($a, $b) {
                        return strtotime($a->the_date) - strtotime($b->the_date);
                    });
                    
                    if($this->config->item('REPEAT_INCLUDE')){
                        $k = 0;
                        $repeat_datas = array();
                        $limit = date('Y-m-d', strtotime(date("Y-m-d") . ' +14 day'));

                        foreach($data as $key => $d){
                           $data[$key] = ( (array) $d );

                            if($d ->repeat_status == 1){
                                $date_array = $this->date_range($d->the_date, $d->repeat_till, $limit, '+1 day', 'Y-m-d' );
                            }

                            if($d->repeat_status == 2){
                                $date_array = $this->date_range($d->the_date, $d->repeat_till, $limit, '+7 day', 'Y-m-d' );
                            }

                            if(($d->repeat_status == 1 || $d->repeat_status == 2) && ! empty($date_array)){
                                unset($date_array[0]);

                                foreach($date_array as $val){
                                    $temp = $d;
                                    $temp->the_date = $val;
                                    $temp->day = date('l', strtotime($val));
                                    $repeat_datas[$k] =( (array) $temp );
                                    $k++;
                                }
                            }
                        }

                        $data = array_merge($data, $repeat_datas);
                        usort($data,function ($a, $b) {
                            return strtotime($a['the_date']) - strtotime($b['the_date']);
                        });

                        foreach(array_keys($data) as $key)
                        {
                          $data[$key] = (object)$data[$key];
                        }
                    }
                    
                    $this->gen_contents['course_region'] = $data;
                    $mesg = $this->load->view('email_template', $this->gen_contents, true);
                }else {
                    $mesg = $this->load->view('email_template', $this->gen_contents, true); //
                }
                
                $insert_or_not = ($this->common_model->valueExists('adhi_new_user','mail_status', array('new_user_email_id' => $email, 'cron_status' => 1),array())) ? 0 : 1 ;   // If already under cron job  
             
                if($insert_or_not){
                    if($this->endsWith(strtolower($email),".xyz") || $this->endsWith(strtolower($email),".xyz.")){
                        $from      = $this->config->item('guest_pass_mail_from');
                        $from_name = $this->config->item('guest_pass_mail_from_name');
                        
                        $phone_template = ($phone_number != '') ? '. We have blocked this. <br/> Phone number is '. $phone_number : '. We have blocked this. <br/> '; 
                        $message_template = '<p>Hey,</p>
                        <p></p>
                        <p><b>' . ucfirst($name) . '</b>  is looking for a FREE GUEST PASS. His/her email id is '.$email.$phone_template.'</p>
                        <p>IP Address: '.$this->input->ip_address().'</p>
                        <p></p>
                        <p></p>
                        <p>Team AdhiSchools!</p>';
                        $this->common_model->guest_pass_mail($this->config->item('guest_pass_enquiry'), $from, $from_name,
                               'Guest Pass Enquiry',
                                $message_template
                                );
                        
                        $data = array('status'=>300, 'msg'=> "<span style='color:#fff;'> Seems like you have already requested for Guest Pass! </span>");
                    }else{
                        $mail_status = ($this->common_model->valueExists('adhi_user','id', array('emailid' => $email),array())) ? 2 : 1  ;    // 2 - registered user                    // Check if user already registered
                        $cron_status = ($mail_status == 1) ? 1 : 2;

                        $date = convert_UTC_to_PST_datetime(gmdate('m/d/Y H:i:s'));
                        $data_save = array('new_user_ip' => $this->input->ip_address(),'new_user_name' => $name, 'new_user_email_id' => $email,'new_user_phone_number' => $phone_number,'mail_count' => 0,'created_date' => $date,'new_user' => $new_user,'mail_status' => $mail_status,'cron_status' => $cron_status,'new_user_status' => 1);
                        $result_user_id = $this->common_model->save('adhi_new_user',$data_save);

                        if($result_user_id){
                                $from      = $this->config->item('guest_pass_mail_from');
                                $from_name = $this->config->item('guest_pass_mail_from_name');
                                // Due to the an issue of multiple dot in email on email content,
                                // include name in <b> tag 
                                //Admin main 
                                $phone_template = ($phone_number != '') ? '. He/she has requested for a callback. <br/> Phone number is '. $phone_number : ''; 
                                $message_template = '<p>Hey,</p>
                                <p></p>
                                <p><b>' . ucfirst($name) . '</b>  is looking for a FREE GUEST PASS. His/her email id is '.$email.$phone_template.'</p>
                                <p>IP Address: '.$this->input->ip_address().'</p>
                                <p></p>
                                <p></p>
                                <p>Team AdhiSchools!</p>';
                                $mails = $this->common_model->guest_pass_mail($this->config->item('guest_pass_enquiry'), $from, $from_name,
                                       'Guest Pass Enquiry',
                                        $message_template
                                        );


                                $mail = $this->common_model->guest_pass_mail($this->config->item('guest_pass_mail_from'), $from, $from_name,ucfirst($name).', Are You Ready For A New Career In Real Estate?', 
                                        $mesg,'',array(),$email,''
                                        );

                                $email_data = array('enquiry_id' => $result_user_id,'email_id' => $email, 'email_status' => $mail, 'created_date' => $date, 'status' => 1 );        // Save email history    
                                $email_history = $this->common_model->save('adhi_guest_enquiry_mail_history', $email_data);

                                                                                                                                                    // Increment mail count
                                $data_save = array('mail_count' => 1);
                                $data_where = array('new_user_id' => $result_user_id, 'new_user_status' => 1);
                                $email_count = $this->common_model->update('adhi_new_user',$data_save,$data_where);

                                $data = array('status'=>200, 'msg'=> "Your free guest pass is sent to your email along with the details of class.  Make sure you check your spam filter as this automated email may show up there.");

                            }    
                    }
                } else{      
                        $data = array('status'=>300, 'msg'=> "<span style='color:#fff;'> You have already requested for guest pass enquiry. Please check your mail. Make sure you check your spam filter as this automated email may show up there.</span>");
                }
            }
            else{
                $data = array('status'=>100, 'msg'=> validation_errors());
            }
            
            if(isset($_POST['submit'])){
                $this->load->model('user_model');
                $captcha                                   = $this->user_model->generate_captcha (array(),"",0);
                $this->session->set_userdata ("captcha_word", $captcha['word']);
                $this->gen_contents['math_captcha_question']     = $data['math_captcha_question'] =  $captcha;
                
            }else if(isset($_POST['submit_popup'])){
                $this->load->model('user_model');
                $captcha                                   = $this->user_model->generate_captcha (array(),"",0);
                $this->session->set_userdata ("popup_captcha_word", $captcha['word']);
                $this->gen_contents['math_captcha_question_popup']     = $data['math_captcha_question_popup'] =  $captcha;
            }
            
            $this->output->set_header("Content-Type:application/json");
            echo $this->output->set_output(json_encode($data));
        }
        
        function endsWith($currentString, $target){
            $length = strlen($target);
            if ($length == 0) {
                return true;
            }

            return (substr($currentString, -$length) === $target);
        }
        
        function checkmathcaptchas($val){
            $captcha = $this->session->userdata('captcha_word');
            
            if(strtolower($val) == strtolower($captcha)){
                return TRUE;
            }else{
                 $this->load->library('form_validation');
                 $this->form_validation->set_error_delimiters('','');
                 $this->form_validation->set_message('checkmathcaptchas', 'Wrong Captcha');
                 return FALSE;
            }
        }
        function checkmathcaptchapopups($val){
            $captcha = $this->session->userdata('popup_captcha_word');
            if(strtolower($val) == strtolower($captcha)){
                return TRUE;
            }else{
                 $this->load->library('form_validation');
                 $this->form_validation->set_error_delimiters('','');
                 $this->form_validation->set_message('checkmathcaptchapopups', 'Wrong Captcha');
                 return FALSE;
            }
        }
        
        function checkmathcaptcha($val){
            if( num_captcha_validate($val, 1) == true){
                return TRUE;
            }else{
                 $this->load->library('form_validation');
                 $this->form_validation->set_error_delimiters('','');
                 $this->form_validation->set_message('checkmathcaptcha', 'Wrong Answer');
                 return FALSE;
            }
        }
        function checkmathcaptchapopup($val){
             if( num_captcha_validate($val, 2) == true){
                return TRUE;
            }else{
                 $this->load->library('form_validation');
                 $this->form_validation->set_error_delimiters('','');
                 $this->form_validation->set_message('checkmathcaptchapopup', 'Wrong Answer');
                 return FALSE;
            }
        }
        /**
         * Unsubscribe guest pass cron mail
         *
         */
        function unsubscribe_guest_pass($id = FALSE){
            $this->load->model('common_model');
            $data_save = array('cron_status' => 3,'updated_date' => convert_UTC_to_PST_datetime(gmdate('m/d/Y H:i:s')));
            $data_where = array('new_user_id' => $id);
            $this->gen_contents['status'] = $this->common_model->update('adhi_new_user',$data_save,$data_where);
            $this->siteurl = $this->uri->segment('1');
            $this->gen_contents['siteurl'] = $this->admin_sitepage_model->select_sitepages_url();
            $this->gen_contents['pagedetails'] = $this->admin_sitepage_model->select_single_sitepage_details($this->siteurl);
            $this->_template('unsubscribe_view', $this->gen_contents);
        }
        
        /**
         * Load twitter tweets in homepage - ajax
         *
         */
		function load_tweets(){
         	$this->output->cache(5);
	    	require_once($this->config->item('site_basepath') . 'system/plugins/twitteroauth.php');
	        $twitteruser		= $this->config->item('twitteruser');
	        $notweets 			= $this->config->item('notweets');
	        $consumerkey 		= $this->config->item('consumerkey');
	        $consumersecret 	= $this->config->item('consumersecret');
	        $accesstoken 		= $this->config->item('accesstoken');
	        $accesstokensecret 	= $this->config->item('accesstokensecret');
	        $connection 		= $this->getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
	        $tweets 			= $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=" . $twitteruser . "&count=" . $notweets);
	
	        $this->load->model('common_model');
	        $this->gen_contents['tweets']	= json_encode($tweets);
	        $tweets_dat 					= $this->gen_contents['tweets'];
	        if (count($tweets_dat) > 0){
	            $tweets_data	= serialize($this->gen_contents['tweets']);
	            $details		= array('twitter_data' => $tweets_data);
	            $twitter_exist	= $this->admin_sitepage_model->get_twitter_data();
	            if ($twitter_exist){
	                $this->gen_contents['insert_twitter_data'] = $this->admin_sitepage_model->update_twitter_data($details);
	            }else{
	                $this->gen_contents['insert_twitter_data'] = $this->common_model->save('adhi_twitter_data', $details);
	            }
	        }
	        $twitterdata = $this->admin_sitepage_model->get_twitter_data();
	        if ($twitterdata){
	            $tweets	= unserialize($twitterdata);
	            $this->gen_contents['tweets'] = json_decode($tweets);
	        }
	        $this->gen_contents['tweets'] = json_decode($tweets);
	        
	        $html	= $this->load->view('user/home_twitter', $this->gen_contents, TRUE);
	        $this->load->view('dsp_show_ajax', array('return_value' => $html));
	    }
	    
	    /**
         * Load first blog post in homepage from adhi blog feed - ajax
         *
         */
	    function load_blog_post(){
	    	$this->output->cache(5);
	        //Load the shiny new rssparse
	        try
			{
				$this->load->library('RSSParser', array('url' => 'http://www.adhischools.com/blog/feed/', 'life' => 0));				
			}
			catch (Exception $e)
			{
	        	$this->load->view('dsp_show_ajax', array('return_value' => 'Error in retrieving post'));
	        	exit;	
			}
	        //Get one item from the feed
	        $data	= array();
	        $data['blog_posts_rss'] = $this->rssparser->getFeed(1);
	        $html	= $this->load->view('user/_home_blog_posts', $data, TRUE);
	        $this->load->view('dsp_show_ajax', array('return_value' => $html));
	        
	    }
            
            function reskin(){
                $this->load->view('reskin');
            }
            
            function date_range($first, $lasts, $limit, $step = '+1 day', $output_format = 'd/m/Y' ) {

                $dates   = array();
                $current = strtotime($first);
                $last    = strtotime($lasts);
                $limit   = strtotime($limit);
                
                if($last > $limit){
                    $last = $limit;
                }

                while( $current <= $last ) {
                    $dates[] = date($output_format, $current);
                    $current = strtotime($step, $current);
                }

                return $dates;
            }
            

        function our_principles(){
            $this->template->write_view('content', 'reskin/our_principles', $this->gen_contents);
            $this->template->render();   
        }
        
        function licensing_process (){
            $this->template->write_view('content', 'reskin/licensing_process', $this->gen_contents);
            $this->template->render();
        }
        
        
        function blog_posts(){
            $contents   = file_get_contents('http://www.adhischools.com/blog?wpapi=get_posts&count=12&content=1&type=post&orderby=date&order=asc');
            $contents   = json_decode($contents,true);
            $posts      = $contents['posts'];
            usort($posts, 'blog_post_date_compare');
            $this->gen_contents["blog"] = $posts;
            $output['return_value'] = $this->load->view('reskin/home/_blog', $this->gen_contents, TRUE);
            $this->load->view('dsp_show_ajax', $output);
        }
        
        function general_information(){
            /*$this->load->helper('download');
            $data   = file_get_contents(c('site_basepath').'/pdf/general-information.pdf');
            $name   = 'General-Information.pdf';
            force_download($name, $data);*/
            // We'll be outputting a PDF
            header('Content-type: application/pdf');

            // It will be called downloaded.pdf
            header('Content-Disposition: inline; filename="general-information.pdf"');

            // The PDF source is in original.pdf
            readfile(c('site_basepath').'/pdf/general-information.pdf');
            //header("Content-disposition: inline; filename=".c('base_url').'pdf/general-information.pdf');exit;

        }
        
        function _set_default_values(){
                $this->gen_contents['siteurl']			= $this->admin_sitepage_model->select_sitepages_url();
                $this->gen_contents['thinkingabout']	= $this->admin_sitepage_model->select_single_sitepage_det(3);
                $this->gen_contents['gotquestion']		= $this->admin_sitepage_model->select_single_sitepage_det(4);
                $this->gen_contents['dated'] 			= convert_UTC_to_PST_date_slash(date('m/d/Y H:i:s'));
                //$this->gen_contents['dated'] 			= date('m/d/Y');
                $this->gen_contents['image_path'] 		= $this->config->item('image_upload_url').'thumbs/';
                $this->gen_contents['modal_path'] 		= 'home/class_details';
                $this->gen_contents['modal_form'] 		= 'tonightclassform';
                $this->gen_contents["offset_hidden"] 	= 0;
                $this->gen_contents["num_hidden"] 		= 5;
        }
        
       /**
        * function used to get the regions and all subregions
        */
       function _get_regions_subregions(){

               $this->gen_contents['regions'] 		= $this->admin_schedule_model->dbSelectAllRegions();
               $arr_data 							= $this->admin_schedule_model->dbSelectAllSubRegions();
               $this->gen_contents['raw_subregion']= $arr_data;
               $id 								= 0;
               $arr_subregion						= array();

               foreach ($arr_data as $value){
                       if($id != $value->regionid){
                               $id 						= $value->regionid;
                               $arr_subregion['R'][$id] 	= array();
                       }
                       $arr_subregion['R'][$id][] 		= array('id' =>$value->id,'name'=>$value->sub_name);
               }
               //gets all the region and subregion for the purpose of displaying filter
               //used to diaply subregion using jason array 				
               $this->gen_contents['json_array'] 	= json_encode($arr_subregion);

       }
       
       function open_location($id){
            $this->load->model('admin_schedule_model');
            $date               = convert_UTC_to_PST_date_slash(date('m/d/Y H:i:s'));
            
            $class              = $this->admin_schedule_model->dbGetCurrentClassDetailsForSubregion($id,$date,0);
            
            if(!empty($class)){
                $place_name         = strtolower(str_replace(' ','-',$class[0]->subregion)).'-real-estate-school';
            }else{
                $class = $this->admin_schedule_model->dbSelectSingleSubRegion($id);
                $place_name = strtolower(str_replace(' ','-',$class->sub_name)).'-real-estate-school';
            }
            
            if($place_name == 'carmel-valley-/-del-mar-real-estate-school'){
                $place_name = 'san-diego-real-estate-school';
            }
            $this->session->set_userdata("loc_id",$id);
            header('Location: '.  base_url().'locations/'.$place_name);
        }
        
        
        
        function locations($place_name){
            
            $this->load->model('admin_subregion_model');
            $this->load->model('admin_schedule_model');
            $this->gen_contents['mt_keyword'] = '';
            $this->gen_contents['meta_data_desc']  = '';
            $this->gen_contents["upcoming"] = 0;
            
            if($place_name == 'san-diego-real-estate-school'){
                $place_name = 'carmel-valley-/-del-mar-real-estate-school';
            }
            
            if($place_name == 'carmel-valley-/-del-mar-real-estate-school'){
                $this->gen_contents['title'] = 'San Diego Real Estate School | ADHI Schools';
                $this->gen_contents['sname'] = 'San Diego real estate school';
                $this->gen_contents['location'] = $this->admin_subregion_model->location_region("Encinitas");
                $id = $this->gen_contents['location']->id;
            }else if($place_name == 'rancho-cucamonga-real-estate-school'){
                $this->gen_contents['title'] = 'Rancho Cucamonga Real Estate School | ADHI Schools';
                $this->gen_contents['sname'] = 'Rancho Cucamonga real estate school';
                $this->gen_contents['location'] = $this->admin_subregion_model->location_region("Rancho Cucamonga");
                $id = $this->gen_contents['location']->id;
            }else if($place_name == 'temecula-real-estate-school'){
                $this->gen_contents['title'] = 'Temecula Real Estate School | ADHI Schools';
                $this->gen_contents['sname'] = 'Temecula Real Estate School';
                $this->gen_contents['location'] = $this->admin_subregion_model->location_region("Temecula");
                $id = $this->gen_contents['location']->id;
            }else if($place_name == 'irvine-real-estate-school'){
                $this->gen_contents['title'] = 'Irvine Real Estate School | ADHI Schools';
                $this->gen_contents['sname'] = 'Irvine real estate school';
                $this->gen_contents['location'] = $this->admin_subregion_model->location_region("Irvine");
                $id = $this->gen_contents['location']->id;
            }else if($place_name == 'los-angeles-real-estate-school'){
                $this->gen_contents['title'] = 'Los Angeles Real Estate School | ADHI Schools';
                $this->gen_contents['sname'] = 'Los Angeles real estate school';
                $this->gen_contents['location'] = $this->admin_subregion_model->location_region("Brentwood");
                $id = $this->gen_contents['location']->id;
            }else{
                $id = $this->session->userdata("loc_id");
                //$this->session->unset_userdata("loc_id");
                $this->gen_contents['location'] = $this->admin_schedule_model->dbSelectSingleSubRegion($id);
                $this->gen_contents['location']->subregion_title = 'Real Estate School in '.$this->gen_contents['location']->sub_name;
                $this->gen_contents['title'] = $this->gen_contents['location']->sub_name;
                $this->gen_contents['sname'] = $this->gen_contents['location']->sub_name." Real Estate School";
            }
            
            if(!empty($this->gen_contents['location'])){
                $this->gen_contents['mt_keyword'] = $this->gen_contents['location']->subregion_meta_keyword;
                $this->gen_contents['meta_data_desc']  = $this->gen_contents['location']->subregion_meta;
            }
            
            $this->gen_contents['current_page']         = 'home';
            $this->gen_contents['date'] 		= convert_UTC_to_PST_date_slash(date('m/d/Y H:i:s'));
            
            $initial_place_arr = explode('-',$place_name);
            array_pop($initial_place_arr);
            array_pop($initial_place_arr);
            array_pop($initial_place_arr);
            
            
            $subregion_name = ucwords(implode(' ',$initial_place_arr));
            
            $this->load->model('admin_schedule_model');
            $this->gen_contents["msg"] = $this->session->userdata('MSG_LOGIN');
            $this->session->set_userdata('MSG_LOGIN', '');
            
            $this->gen_contents["arr_class"] = false;
            if(!$this->authentication->logged_in("normal") || ( $this->authentication->logged_in("normal") && 'Online' != $this->session->userdata('COURSE_TYPE'))){
                $this->gen_contents["arr_class"] = $this->admin_schedule_model->dbGetCurrentClassDetailsForSubregion($id,$this->gen_contents['date'],1,$subregion_name);
                
                if(empty($this->gen_contents["arr_class"])){
                    $this->gen_contents["upcoming"] = 1;
                   $this->gen_contents["arr_class"] = $this->admin_schedule_model->dbGetUpcomingClassDetailsForSubregion($id,$this->gen_contents['date'],1,$subregion_name);
                }
            }
            
            $this->load->model('admin_sitepage_model');
            $this->_set_default_values();
            $this->commonListRelatedRegion();
            $this->gen_contents["selected_nav"] = 'schedule';
            
            //$this->gen_contents['meta_data_desc'] = $this->gen_contents["arr_class"][0]->subregion_meta;
            $this->template->set_template('user');
            $this->template->write_view('content', 'sample_location', $this->gen_contents);
            $this->template->render();
        }


        function youtube_videos(){
            $channelId   = $this->config->item('channel_id');
            $maxResults  = $this->config->item('max_results');
            $API_key     = $this->config->item('api_key');
            $showResults = $this->config->item('show_results');

            $this->gen_contents['video_list'] = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId='.$channelId.'&maxResults='.$maxResults.'&key='.$API_key.''));
            $len            = count($this->gen_contents['video_list']->items);
            $selected       = array();
            while(count($selected) < $showResults){
                $rand = rand(0, $len-1);
                if(!in_array($rand, $selected)){
                    array_push($selected, $rand);
                }
            }

            while($len != 0){
                $len--;
                unset($this->gen_contents['video_list']->items[$len]->snippet->thumbnails->default);
                unset($this->gen_contents['video_list']->items[$len]->snippet->thumbnails->high);
            }
            $this->gen_contents['selected']  = $selected;
            $output['return_value'] = $this->load->view('reskin/home/_videos', $this->gen_contents, TRUE);
            $this->load->view('dsp_show_ajax', $output);
        }

        function why_we_are_the_best_real_estate_school(){
            redirect('best-real-estate-school');
        }
        
        function california_real_estate_classes_in(){
            redirect('find-real-estate-classes');
        }
        
        function getting_my_real_estate_license(){
            redirect('how-to-get-a-real-estate-license-california');
        }
        
        function scheduling(){
            redirect('find-real-estate-classes');
        }
    }
    /* End of file home.php */
/* Location: ./system/application/controllers/home.php */
