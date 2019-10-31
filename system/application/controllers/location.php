<?php

defined('BASEPATH') OR exit('No direct script access allowed');

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

class Location extends Controller {

//    var $gen_contents = array();
//    var $siteurl = '';   /* Id of the selected user */
    public function __construct() {
        parent::__construct();
        $this->load->model('admin_subregion_model');
        $this->load->helper(array('form', 'url', 'file'));
        $this->load->library("session");

        $this->gen_contents['css'] = array('client_style.css', 'style.css');
        $this->gen_contents['js'] = array('client_login.js');
      }
   
    function california_real_estate_pre_licensing_course() {
        $this->gen_contents['title'] = 'California Real Estate Pre-Licensing Course | ADHI Schools';
        $this->gen_contents['meta_data_desc'] = "ADHI Schools real estate pre-licensing course offers both online and live classes to fit your lifestyle and prepare you to ace your California real estate license exam.";
        $this->gen_contents['mt_keyword']  = 'california real estate broker license,becoming a real estate broker,how to become a real estate broker in california,
              california real estate broker license requirements,real estate law,online real estate,real estate industry,national association of realtors,continuing education,state s real estate,
              agents and brokers,real estate license exam,full time,licensing requirements,real estate transaction,estate schools,state specific';
        $this->gen_contents['name'] = 'Let Your Real Estate Career Begin';
        $this->template->set_template('user');
        $this->template->write_view('content', 'locations/california-real-estate-pre-licensing-course', $this->gen_contents);
        $this->template->render();
    }


    function how_to_become_a_real_estate_broker_california() {
        $this->gen_contents['title'] = 'How to Become a Real Estate Broker in California | ADHI Schools';
        $this->gen_contents['meta_data_desc'] = "You're a real estate agent in California and now you want to become a broker. Discover the requirements, exams and preparation that's needed.";
        $this->gen_contents['mt_keyword'] = 'california real estate broker license,becoming a real estate broker,how to become a real estate broker in california,
              california real estate broker license requirements,real estate law,online real estate,real estate industry,national association of realtors,continuing education,state s real estate,
              agents and brokers,real estate license exam,full time,licensing requirements,real estate transaction,estate schools,state specific';
        $this->gen_contents['name'] = 'How to Become a Real Estate Broker in California';
       
        $this->template->set_template('user');
        $this->template->write_view('content', 'locations/how-to-become-a-real-estate-broker-california', $this->gen_contents);
        $this->template->render();
    }
    
    function redirect_to_california_real_estate_pre_licensing_course(){
        redirect('california-real-estate-pre-licensing-course');
    }

}

/* End of file home.php */
/* Location: ./system/application/controllers/home.php */
