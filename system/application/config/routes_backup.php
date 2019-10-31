<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  | 	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['scaffolding_trigger'] = 'scaffolding';
  |
  | This route lets you set a "secret" word that will trigger the
  | scaffolding feature for added security. Note: Scaffolding must be
  | enabled in the controller in which you intend to use it.   The reserved
  | routes must come before any wildcard or regular expression routes.
  |
 */
$route['default_controller'] = "home";
$route['scaffolding_trigger'] = "";

$route['articles'] = 'home/articles';
$route['about-us'] = 'home/new_about';
$route['contact-us'] = 'home/contactus';
$route['our-terms-of-use'] = 'home/termsofuse';
$route['our-privacy-policy'] = 'home/privacypolicy';

$route['thinking-about'] = 'home/thinkingaboutrealestate';
$route['got_question'] = 'home/gotquestions';
$route['got-question'] = 'home/gotquestions';
$route['forgot-password'] = 'user/forgot_password';
$route['testimonials'] = 'home/testimonial';
$route['testimonial'] = 'home/testimonial';
$route['brokerplacement'] = 'home/brokerplacement';
$route['faq'] = 'home/faq';
//$route['blog']                =   'home/blog';
$route['schedules_and_locations'] = 'home/schedule';


$route['banners/(:num)'] = "home/banners/$1";
$route['forum'] = "home/forums";
$route['meet-our-staff'] = 'home/meet_our_staff';
$route['inexpensive-online-only-classes'] = "home/inexpensive";
$route['inexpensive'] = "home/inexpensive";
$route['login'] = "user/user_login";
$route['mike-ferry-superstar-retreat'] = "download";

//$route['california-real-estate-classes'] = 'home/california_real_estate_classes';
//$route['online-real-estate-classes'] = 'home/california_real_estate_classes';

//$route['real-estate-education-app']         =   'home/real_estate_education_app';	
//$route['history-of-excellence']             =   'home/history_of_excellence';									
$route['new'] = 'home/index';
$route['careers'] = 'home/brokerplacement';
$route['sitemap'] = 'home/sitemap';
$route['our-principles'] = 'home/our_principles';
$route['find-real-estate-classes'] = 'schedule';
//$route['our-numbers']                       =   'home/our_numbers';
//$route['licensing-process']                 =   'home/licensing_process';

$route['best-real-estate-school'] = 'home/history_of_excellence';
$route['real-estate-exam-app'] = 'home/real_estate_education_app';
//$route['getting-my-real-estate-license']            =   'home/licensing_process';
$route['how-to-get-a-real-estate-license-california'] = 'home/licensing_process';
$route['why-we-are-the-best-real-estate-school'] = 'home/our_numbers';

//$route['guestregister'] = 'trial_account/register';
$route['free-online-real-estate-classes-trial'] = 'trial_account/register';

/* Please change siteconfig also */
$route['airforce1'] = 'admin/login';
$route['airforce1/(:any)'] = 'admin/login/$1';

$route['career-events'] = 'career_event';
$route['general-information'] = 'home/general_information';
$route['location/(:any)'] = 'home/location/$1';

//content  locations
$route['california-real-estate-pre-licensing-course'] = 'locations/california_real_estate_pre_licensing_course';
$route['online-real-estate-classes'] = 'home/california_real_estate_classes';
$route['how-to-become-a-real-estate-broker-california'] = 'locations/how_to_become_a_real_estate_broker_california';
//$route['locations/irvine-real-estate-school'] = 'locations/irvine_real_estate_school';
$route['locations/irvine-real-estate-school'] = 'locations/irvine_real_estate_school';

$route['locations/los-angeles-real-estate-school'] = 'locations/los_angeles_real_estate_school';
$route['locations/rancho-cucamonga-real-estate-school'] = 'locations/rancho_cucamonga_real_estate_school';
$route['locations/san-diego-real-estate-school'] = 'locations/san_diego_real_estate_school';
$route['locations/temecula-real-estate-school'] = 'locations/temecula_real_estate_school';

//disabling user registration temporarily
//$route['user/register']                         =   'user/course_contact';
/* End of file routes.php */
