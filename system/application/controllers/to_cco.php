<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Project				-	Adhischools
 * Language				-	PHP 5 & above
 * Database				-	Mysql
 * Author				-	Syama S
 * Created On                           -	May 25, 2016
 * Development Center                   -	Rain Concert Technologies Pvt Ltd, Trivandrum, Kerala, India.(http://aarthikaindia.com)
 */
// ------------------------------------------------------------------------
class To_Cco extends Controller {

    /**
     * General contents
     *
     * @var Array
     */
    var $gen_contents = array();
    var $userid = '';                                                           /* Id of the selected user */
    

    /**
     * Admin constructor
     *
     */
    function To_Cco() {
        parent::Controller();
        $this->load->library('authentication');
        $this->load->helper(array('form', 'file'));
        if (!$this->authentication->logged_in("admin") || $this->authentication->logged_in("admin") === "sub") {
            redirect("admin");
        }
        $this->gen_contents['css']      =       array('admin_style.css','dhtmlgoodies_calendar.css');
        $this->gen_contents['js']       =       array('admin_user_js.js','popcalendar.js');
        $this->gen_contents['title']	=	'CCO User Management';
    }
    
    function user_register($id = ""){
        
        $this->load->helper('form');
        $this->gen_contents['user_id'] = $id;
        
        $this->load->view("admin_header",$this->gen_contents);
        $this->load->view('iframe_cco/register', $this->gen_contents);
        $this->load->view("admin_footer");
    }
}

/* End of file admin.php */
/* Location: ./system/application/controllers/admin_user.php */