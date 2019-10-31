<?php
// For the script that is running:
$script_directory = substr($_SERVER['SCRIPT_FILENAME'], 0, strrpos($_SERVER['SCRIPT_FILENAME'], '/'));
// If your script is included from another script:


//$config['site_baseurl'] = "http://".$_SERVER['SERVER_NAME'];
$config['site_baseurl'] =  "http" . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "s" : "") . "://";

$config['site_baseurl'] .= $_SERVER['SERVER_NAME'].'/'.str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
//$config['site_baseurl'] .= $_SERVER['SERVER_NAME'];

if(!defined('DOCUMENT_ROOT')) define('DOCUMENT_ROOT', str_replace('system/application/config','',substr(__FILE__, 0, strrpos(__FILE__, '/'))));
$config['site_baseurl'] = "http://".$_SERVER['SERVER_NAME'];
$config['site_baseurl'] .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);


//$config['site_ssl_baseurl'] = "https://".$_SERVER['SERVER_NAME'];
$config['site_ssl_baseurl'] = "https://".$_SERVER['SERVER_NAME'];
$config['site_ssl_baseurl'] .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

//$config['site_basepath']			= '/home/sreeraj/public_html/adhischools/';
$config['site_basepath']			=  constant("DOCUMENT_ROOT").'';


$config['captcha_image_path']       = $config['site_basepath'] .'captcha/';
$config['captcha_image_url']        = $config['site_ssl_baseurl'].'captcha/';
$config['captcha_font_path']        = $config['site_baseurl'].'fonts/texb.ttf';

$config['css_path']        			= $config['site_basepath'].'style/';
$config['css_path_parsed']        	= $config['site_basepath'].'style/parsed/';
$config['css_url_path']        		= $config['site_baseurl'].'style/parsed/';

$config['js_path']        			= $config['site_basepath'].'js/';
$config['js_path_parsed']        	= $config['site_basepath'].'js/parsed/';
$config['js_url_path']        		= $config['site_baseurl'].'js/parsed/';

$config['fonts_path']				=  $config['site_basepath'] .'fonts/';
$config['adhi_log_path']			=  $config['site_basepath'] .'logs/';

$config['partner_image_url']      	= $config['site_baseurl']."uploads";
$config['upload_file']	   			= $config['site_basepath']."uploads";
$config['dictionary_upload_file']	= $config['site_basepath']."uploads/dictionary";
$config['image_extensions']		   	= array('jpg','jpeg','png','JPG','JPEG');

// Videos extensions
$config['video_extensions']		   	= array('mp4','mov','f4v','flv','3gp', '3g2', 'webm');

$config['login_page']              = 'user/login/3';
$config['upload_exam']             = 'admin_exam/upload/';
$config['upload_quiz']				= 'admin_quiz/upload/';

// Question videos location
$config['quiz_video_location'] = 'https://streams.adhischools.com/videos/';

/* </ Email configuration >*/

$config['mailtype']				=	'html';
$config['smtp_timeout']			=	30;
$config['images']      				= $config['site_baseurl']."images/";
$config['tmp_label']      			= $config['site_baseurl']."tmp/";

$config['tiny_image_folder']		=	$config['site_basepath'] .'uploads/tinymceimages';
$config['tiny_image_url']			=	$config['site_baseurl'].'uploads/tinymceimages';

$config['login_unique_page']        = 'home/login/1';
$config['login_unique_page']        = 'user/log_in/1';
$config['login_exam_mode']          = 'home/login';
$config['login_exam_mode']          = 'user/log_in';
 $config['pagination_standard']		=	array ( 'num_tag_open' 	=> '<div class="pagination_div"> <div>',
							'num_tag_close' 	=> '</div></div>',
							'cur_tag_open'  	=> '<div class="pagination_selected_div"><div><b>',
							'cur_tag_close' 	=> '</b></div></div>',
							'prev_tag_open'  	=> '<div class="pagination_next_div"><div>',
							'prev_tag_close'  	=> '</div></div>',
							'next_tag_open'  	=> '<div class="pagination_next_div"><div>',
							'next_tag_close' 	=> '</div></div>',
							'last_tag_open'  	=> '<div class="pagination_next_div"><div>',
							'last_tag_close'  	=> '</div></div>',
							'first_tag_open'  	=> '<div class="pagination_next_div"><div>',
							'first_tag_close'  => '</div></div>'
							);
/* image upload configuration */

$config['image_upload_path'] 	= $config['site_basepath'].'image_uploads/';
$config['image_upload_url'] 	= $config['site_baseurl'].'image_uploads/';

$config['image_uploadbp_path'] 	= $config['site_basepath'].'bp_image/';
$config['image_uploadbp_url'] 	= $config['site_ssl_baseurl'].'bp_image/';

$config['image_max_size'] 		= '6144';
$config['image_max_width'] 		= '4000';
$config['image_max_height'] 	= '3024';

$config['banner_image_url']		= $config['site_baseurl']."image_uploads/banners/";
$config['banner_image_path']	= $config['site_basepath']."image_uploads/banners/";

$config['conversations_upload_file']	= $config['site_basepath']."uploads/conversations/";
$config['conversations_upload_file_url']	= $config['site_baseurl']."uploads/conversations/";

$config['conversation_extensions']		= 'txt|doc|eml|xls|pdf|jpg|jpeg|png|gif|JPG|JPEG';
$config['conversation_extensions_display']		= 'txt|doc|eml|xls|pdf|jpg|jpeg|png|gif';
$config['chapter_list']		=	array ('1' => 'Chapters 1 and 2',
                                               '2' => 'Chapters 3 and 4',
                                               '3' => 'Chapter 5',
                                               '4' => 'Chapter 6 and 7',
                                               '5' => 'Chapters 8 and 9',
                                               '6' => 'Chapters 10 and 11',
                                               '7' => 'Chapter 12',
                                               '8' => 'Chapters 13 and 14',
                                               '9' => 'Chapter 15 and Course Review');

$config['course_color']		=	array ('5' => 'EBC1BF',
                                               '6' => 'DBDEA4',
                                               '7' => 'A8D8E8',
                                               '8' => 'B5F49A',
                                               '9' => 'E2D289',
                                               '10' => 'F0FE57',
                                               '11' => 'E8E2DF',
                                               '12' => 'F8AB93',
                                               '13'=>'B68FFF',
                                               '14' =>'FDB6FF',
					       '15' =>'FDB6FF',
					       '16' => 'C1CDCD'
);

$config['course_color_div_width']		=	array (
                                                         array('0' => '100%'),
                                                         array('0' =>'50%','1' =>'50%'),
                                                         array('0' =>'33%','1' =>'34%','2' =>'33%'),
                                                         array('0' =>'25%','1' =>'25%','2' =>'25%','3' =>'25%'),
                                                         array('0' =>'20%','1' =>'20%','2' =>'20%','3' =>'20%','4' =>'20%'),
                                                         array('0' =>'17%','1' =>'17%','2' =>'16%','3' =>'17%','4' =>'16%','5' =>'17%'),
                                                         array('0' =>'15%','1' =>'14%','2' =>'14%','3' =>'14%','4' =>'14%','5' =>'14%','6' =>'15%'),
                                                         array('0' =>'13%','1' =>'12%','2' =>'13%','3' =>'12%','4' =>'13%','5' =>'12%','6' =>'13%','7' =>'12%')
                                                       );

$config['sq_image_folder']		=	$config['site_basepath'] .'images/sq/';
$config['sq_image_url']			=	$config['site_ssl_baseurl'].'images/sq/';


//$config['google_map_key']   	= 'ABQIAAAAjf08UtlvvRPG3jPMIVOWThTATFDIL8T7Uw94DM1qQGXBa_t6XRS6bdmhJPCnNASu4-bLMVzzRYJZKg';
//$config['google_map_key']   	= 'ABQIAAAAjf08UtlvvRPG3jPMIVOWThSQqS5LnS01cOD-WBUmf5EDV4M88hRCY2W5JoozfbqyNRGPyVD0hdjPRg'; //192.168.0.162

//$config['google_map_key']   	= 'AIzaSyAO4wRwquC83Uq3lQzt6U0fPy7sgPsQeR4';
$config['google_map_key']   	='AIzaSyDk0lm5G_y6Ms0mTZ5jQ3p9-F21-TPMMDw';
$config['gmap_image_url']		=	$config['site_baseurl'].'images/gmap/';




$config['upload_file_path']	   			= $config['site_basepath']."uploads/";
$config['upload_file_url']	   			= $config['site_ssl_baseurl']."uploads/";

$config['staff_image_thumb_dimension'] 	=  array('small' => array('width' => 75, 'height' => 107),
												'medium' => array('width' => 100, 'height' => 143),
												'large' => array('width' => 175, 'height' => 250));
$config['images_allowed_file_type']		= 'gif|jpg|png|jpeg';
$config['images_upload_limit'] 			= 4096;// 4MB

$config['staff_image_upload_path']	   	=  $config['upload_file_path']."staff/";
$config['staff_image_upload_url']	   	=  $config['upload_file_url']."staff/";

/* old smtp
$config['protocol']             =   'smtp';
$config['smtp_host']            =     'ssl://smtp.gmail.com';
$config['smtp_from_name']       =   'Adhi Schools';
$config['smtp_from']            =   'registration@adhischools.com';
$config['smtp_user']            =   'registration@adhischools.com';
$config['smtp_password']        =   'falconer88';
$config['smtp_port'] 		=   '465';
$config['main_cc_to']       	=   'kartik@adhischools.com';
$config['mailtype']			 = 'html';
$config['site_name']		 = 'Adhischools';
$config['smtp_timeout']			=	30;
 * 
 */

$config['smtp_auth']          = TRUE;
$config['protocol']           = 'smtp'; 
$config['smtp_host']          = 'tls://email-smtp.us-east-1.amazonaws.com';
$config['smtp_from_name']     = 'Adhi Schools';
$config['smtp_from']          = 'registration@adhischools.com';
$config['smtp_user']	      = 'AKIAI26KPGSVQM47X3JA';
$config['smtp_password']      = 'Au1k5Ezot2Idy1L6eLZGprcfX+mhSSujKz1RT+86WaMO';
$config['mailtype']           = 'html';
$config['smtp_timeout']       = 30;
$config['smtp_port']          = '465'; // 3535
$config['site_name']          = 'Adhischools';
$config['mailtype']           = 'html';

/* inexpensive page */
$config['inexpensive_image_path']       = $config['site_basepath'] .'images/inexpensive/';
$config['inexpensive_video_path']       = $config['site_basepath'] .'videos/inexpensive/';

/* twitter data */
$config['twitteruser']       	= "adhischools";
$config['notweets'] 			= 3;
$config['consumerkey'] 			= "pKns5MOTGQnZjSznGDSB2Q";
$config['consumersecret'] 		= "YET2ln5iRwv9eYnlwU21M64LVBNPijumCOSY31yjVs";
$config['accesstoken'] 			= "19295156-mrEFv8J4d1sZjuo6LfWS1fwIyqb5rX1OOuoy048aa";
$config['accesstokensecret'] 	= "ZoQRJxmf3wmbDr25PJhQLbiCJF9ODAuqe7rLxlME8";

$config['default_latitude'] = '34.11723599999999834154';
$config['default_longitude'] = '-118.02446400000000892305';

// Keller settings
$config["go_to_keller_registration"] 	= "http://www.adhischools.com/register.php";
$config["keller_domain"] 				= "www.kwadhi.com"; // keller domain only no http


//Delete duration of exam tracking data
$config['exam_tracking_delete_duration']	= '-2 months';
$config['write_cron_log_for_exam_tracking_delete']	= true;

//Offline message showing time interval
$config['offline_interval_time']			= 10;//15*60;//in seconds - currently 15min

$config['yuicompressor_path']	= $config['site_basepath'].'java/yuicompressor-2.4.8.jar';


$config['supplement_file_path']	= $config['upload_file_path'].'supplements/';
$config['supplement_file_url']	= $config['upload_file_url'].'supplements/';

//Active user time span
$config['active_time_span'] = '-5 minutes';

//Google analytics - api details
$config['ga_profile_id']    = '11533762';
$config['ga_tracking_id']   = 'UA-5713717-1';
$config['ga_hostname_filter']   = 'www.adhischools.com';

$config['ga_client_id']        = '608247043255-f3dpkvb5b7s3d7cvubgej7s3924k2g4e.apps.googleusercontent.com';
$config['ga_client_secret']    = '32kyScU3SJnIP4JBeAIx5hfy';
$config['ga_redirect_uri']     = 'http://www.adhischools.com/admin/dashboard';

//Default admin dashboard tab (visitors_analysis, exam_report, browser_platform, user_report, course)
$config['default_dashboard_tab']    = 'visitors_analysis';

//Cron - if the exam status not modifiying ongoing  to pass/fail the cron will change the exam status that exam written before a 4 hour
$config['exam_ongoing_duration']	= '4 HOUR';

//per page count of average time spent by user page wise listing
$config['average_time_spent_perpage']	= 10;

//guest pass email send from
$config['guest_pass_mail_from']	= 'info@adhischools.com';
$config['guest_pass_mail_from_name']	= 'Adhi Schools';

//MAIL TEMPLATE ID
$config['RECRUITER_MAIL_TEMPLATE']	= 1;
$config['LOGIN_ALERT_MAIL_TEMPLATE']	= 2;
$config['OTP_MAIL_TEMPLATE']            = 3;

//Day Light Saving Time
$config['DST']           =      TRUE;
$config['DST_HOUR']      =      1;
$config['REPEAT_INCLUDE']=      FALSE;    //Set this to ture when changing guest pass logic to include repeated dates

$config['image_url']        = $config['site_baseurl']."images/reskin/";
$config['style_url']        = $config['site_baseurl']."style/reskin/";
$config['script_url']       = $config['site_baseurl']."js/reskin/";
$config['script_path']      = $config['site_basepath']."js/reskin/";

$config['trial_account_activation_email_expiry']       = '24 hours';

/* Please change config/route also */
$config['admin_login_url']  = 'airforce1';

$config['channel_id']       = 'UCKnNFzHOoFcrh0vNBRWcEBQ';
$config['api_key']          = 'AIzaSyCxWZMFw06UzSJyzgC9UFi48f-ckGAfZ98';
$config['max_results']      = 50;
$config['show_results']     = 12;

//Same constant is defined in crone/config.php
//
define('IS_FEDEX_ONE_RATE_ENABLED', TRUE);

//FEDEX ONE RATE Service Type
$config['fedex_one_rate_service_type']		= 'FEDEX_EXPRESS_SAVER';

//For weight based shipping rate
$config['fedex_packaging_type']	= 'YOUR_PACKAGING';        #FEDEX_10KG_BOX, FEDEX_25KG_BOX, FEDEX_BOX, FEDEX_ENVELOPE, FEDEX_PAK, FEDEX_TUBE, YOUR_PACKAGING
$config['fedex_service_type']	= 'INTERNATIONAL_PRIORITY';

$config['fedex_packaging_dimensions'] = array(
	'FEDEX_PAK' => array(
		'length' => 12,
		'width' => 15.5,
		'height' => 1
	),
    'FEDEX_MEDIUM_BOX' => array(
        'length' => 13.25,
        'width' => 11.5,
        'height' => 2.38
	),
    'FEDEX_LARGE_BOX' => array(
        'length' => 17.88,
        'width' => 12.38,
        'height' => 3
	),
    'FEDEX_EXTRA_LARGE_BOX' => array(
        'length' => 15.75,
        'width' => 14.18,
        'height' => 6
	),
    'YOUR_PACKAGING' => array(
        'length' => 20,
        'width' => 20,
        'height' => 10
	),
);

$config['distinct_question_enabled_courses']	= array(5,6,7,8,9,10,11,12);// 6 - realestate practice
$config['cut_off_date']     = "2018-09-16";   //Y-m-d
$config['optionALimitDate'] = "2018-09-16";  //Y-m-d
?>
