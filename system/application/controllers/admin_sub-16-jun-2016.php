<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_sub extends Controller
{
    function Admin_sub () 
    {
        parent::Controller();
        $this->load->library('authentication');
        $this->load->helper(array('form', 'file'));
        if (!$this->authentication->logged_in ("admin"))
        {
                redirect("admin");
        }
        else if($this->authentication->logged_in ("admin") === "sub") 
        {
                redirect("admin/noaccess");
                exit;
        }
        $this->load->library(array('form_validation'));
        $this->load->model('Common_model');
        $this->load->model('admin_user_model');
        $this->load->model('admin_subadmin_model');
        $this->load->model('user_model');
        $this->gen_contents['css'] = array('admin_style.css','style.css','admin_register.css','admin_style_main.css');
        $this->gen_contents['js'] = array('subadmin_register.js');
        $this->gen_contents['title']	= 'Sub-Admin Management';
     }

    function index()
    {
        $this->list_subadmins();
    }

    function list_subadmins()
    {
        $this->gen_contents['page_title']	= 'Sub-Admin Management';
        
        $this->load->library('pagination');
        $config['base_url'] 			= base_url().'index.php/admin_sub/list_subadmins/';
        $config['per_page'] 			= '10';
        $config['num_links']                    = 1;
        $config['uri_segment']  		= 3;
        
        $this->gen_contents["search_firstname"] = '';
	$this->gen_contents["search_lastname"] = '';
	$this->gen_contents["search_email"] = '';
        if(isset($_POST["search"]))
        {
            $this->gen_contents["post_data"] = 1;
        }
        else
        {
            $this->gen_contents["post_data"] = 0;
        }
        if(!empty($_POST))
        {
            $this->gen_contents["search_firstname"] = $this->Common_model->safe_html($this->input->post('txtSrchFirstname'));
	    $this->gen_contents["search_lastname"] = $this->Common_model->safe_html($this->input->post('txtSrchLastname'));
	    $this->gen_contents["search_email"] = $this->Common_model->safe_html($this->input->post('txtSrchEmail'));
            
        }
        else
        {
            $this->gen_contents["search_firstname"] = $this->session->flashdata('search_firstname');
	    $this->gen_contents["search_lastname"] = $this->session->flashdata('search_lastname');
	    $this->gen_contents["search_email"] = $this->session->flashdata('search_email');
            
        }
        
        $this->session->set_flashdata('search_firstname',$this->gen_contents["search_firstname"]);
	$this->session->set_flashdata('search_lastname',$this->gen_contents["search_lastname"]);
	$this->session->set_flashdata('search_email',$this->gen_contents["search_email"]);
        
        
        $this->gen_contents["subadmin_details"]	= $this->admin_subadmin_model->select_subadmindetails($config['per_page'],$this->uri->segment(3),$this->gen_contents["search_firstname"],$this->gen_contents["search_lastname"],$this->gen_contents["search_email"]);
	
        $config['total_rows']   		= $this->admin_subadmin_model->qry_count_subadmindetails($this->gen_contents["search_firstname"],$this->gen_contents["search_lastname"],$this->gen_contents["search_email"]);
	$this->pagination->initialize($config);
        $this->gen_contents['paginate']     =   $this->pagination->create_links(true);
        
        $this->_template('list_subadmin_details',$this->gen_contents);
    }
    
    function add()
    {
        $this->gen_contents['page_title']	=	'Sub-Admin Registration';
        $this->load->helper("form");
        $this->gen_contents['state'] = $this->user_model->get_state();

        $this->_init_registration_rules();
        if($this->input->post('register_sub') == 1 && $this->form_validation->run() == TRUE) 
        {
            $this-> _int_subadmin_register();
        }
        else 
        {
            $this->_template('add_subadmin',$this->gen_contents);
        }

    }
    
    function update()
    {
        $this->gen_contents['page_title']	=	'Edit Sub-Admin Details';
        $this->load->helper("form");
        $this->gen_contents["userid"]		=	$this->uri->segment(3);
        $this->gen_contents['state'] = $this->user_model->get_state();
        
        $this->gen_contents["subadmindetails"]	=	$this->admin_subadmin_model->select_subadmin($this->gen_contents["userid"]);
        
        $this->_init_update_rules();
        if($this->input->post('register_sub') == 1 && $this->form_validation->run() == TRUE) 
        {
            $this-> _int_subadmin_update();
        }
        else
        {
            $this->_template('edit_subadmin',$this->gen_contents);
        }
    }
    
    function _template ($page,$contents)
    {
        $this->load->helper('form');
        $this->load->view("admin_header",$contents);
        $this->load->view('admin/subadmin/'.$page, $contents);
        $this->load->view("admin_footer");
    }
    
    function _int_subadmin_register()
    {
        $data = $this->_init_subadmin_regdetails();
        $insert = $this->Common_model->save("adhi_admin", $data);
        $redirect_action = "admin_sub/";
        if($insert)
        {
            $this->session->set_flashdata('success', "Sub-Admin Registration Completed Successfully");
            redirect($redirect_action);
            
        }   
        else
        {
            $this->session->set_flashdata('error', "Sub-Admin not registered... Please try again");
            redirect($redirect_action);
        }

    }
    
    function _int_subadmin_update()
    {
        $data = $this->_init_subadmin_updatedetails();
        $update = $this->Common_model->update("adhi_admin", $data,array("id"=> $this->input->post('subadmin_id')));
        
        $redirect_action = "admin_sub/";
        if($update)
        {
            $this->session->set_flashdata('success', "Sub-Admin updation Completed Successfully");
            redirect($redirect_action);
            
        }   
        else
        {
            $this->session->set_flashdata('error', "Sub-Admin not updated... Please try again");
            redirect($redirect_action);
        }

    }
    
    function _init_registration_rules()
    {
        $this->form_validation->set_rules('firstname', 'FIRST NAME', 'trim|required|max_length[128]');
        $this->form_validation->set_rules('lastname', 'LAST NAME', 'trim|required|max_length[128]');
        $this->form_validation->set_rules('username', 'USER NAME', 'trim|required|callback_check_username');
        $this->form_validation->set_rules('email', 'EMAIL', 'trim|required|valid_email|max_length[128]|callback_email_check['.$this->input->post('email').']');
        $this->form_validation->set_rules('confirmemail', 'CONFIRM EMAIL', 'trim|required|valid_email|max_length[128]|callback_email_confirm_check');
        $this->form_validation->set_rules('psword', 'PASSWORD', 'trim|required|min_length[6]|alpha_numeric');
        $this->form_validation->set_rules('psword1', 'CONFIRM PASSWORD', 'trim|required|min_length[6]|alpha_numeric|callback_password_confirm_check');
        $this->form_validation->set_rules('address', 'ADDRESS', 'trim|required|max_length[128]|alpha_numeric');
        $this->form_validation->set_rules('state', 'STATE', 'required');
        $this->form_validation->set_rules('city', 'CITY', 'trim|required');
        $this->form_validation->set_rules('zipcode', 'ZIPCODE', 'trim|required|max_length[5]');
        $this->form_validation->set_rules('phone', 'PHONE NO', 'trim|required|min_length[10]');
    }

    function _init_subadmin_regdetails()
    {
        return $this->gen_contents['data'] = array(
                    "firstname"         => $this->Common_model->safe_html($this->input->post('firstname')),
                    "lastname" 		=> $this->Common_model->safe_html($this->input->post('lastname')),
                    "username" 		=> $this->Common_model->safe_html($this->input->post('username')),
                    "emailid" 		=> $this->Common_model->safe_html($this->input->post('email')),
                    "password" 		=> md5($this->Common_model->safe_html($this->input->post('psword'))),
                    "company_address"	=> $this->Common_model->safe_html($this->input->post('address')),
                    "state" 		=> $this->input->post('state'),
                    "city" 		=> $this->Common_model->safe_html($this->input->post('city')),
                    "zpcode" 		=> $this->Common_model->safe_html($this->input->post('zipcode')),
                    "phone" 		=> $this->Common_model->safe_html($this->input->post('phone')),
                    "user_type"         => '2'
                     );  
    }
    
    function _init_update_rules()
    {
        $this->form_validation->set_rules('firstname', 'first name', 'trim|required|max_length[128]');
        $this->form_validation->set_rules('lastname', 'last name', 'trim|required|max_length[128]');
        $this->form_validation->set_rules('username', 'user name', 'trim|required|callback_check_username');
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|max_length[128]|callback_email_check['.$this->input->post('email').']');
        $this->form_validation->set_rules('confirmemail', 'confirm email', 'trim|required|valid_email|max_length[128]|callback_email_confirm_check');
        $this->form_validation->set_rules('address', 'address', 'trim|required|max_length[128]|alpha_numeric');
        $this->form_validation->set_rules('state', 'state', 'required');
        $this->form_validation->set_rules('city', 'city', 'trim|required');
        $this->form_validation->set_rules('zipcode', 'zipcode', 'trim|required|max_length[5]');
        $this->form_validation->set_rules('phone', 'phone no', 'trim|required|min_length[10]');
    }
    
    function _init_subadmin_updatedetails()
    {
        return $this->gen_contents['data'] = array(
                    "firstname"         => $this->Common_model->safe_html($this->input->post('firstname')),
                    "lastname" 		=> $this->Common_model->safe_html($this->input->post('lastname')),
                    "username" 		=> $this->Common_model->safe_html($this->input->post('username')),
                    "emailid" 		=> $this->Common_model->safe_html($this->input->post('email')),
                    "company_address"	=> $this->Common_model->safe_html($this->input->post('address')),
                    "state" 		=> $this->input->post('state'),
                    "city" 		=> $this->Common_model->safe_html($this->input->post('city')),
                    "zpcode" 		=> $this->Common_model->safe_html($this->input->post('zipcode')),
                    "phone" 		=> $this->Common_model->safe_html($this->input->post('phone'))
                     );  
    }
    
    function email_check($email) 
    {
        $subadmin_id = "";
        $subadmin_id = $this->input->post('subadmin_id');
        
        $email_check = $this->admin_subadmin_model->checkemail($email, $subadmin_id);
        if($email_check == 1) 
        {
            $this->form_validation->set_message('email_check', 'The email already exists');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    } 

    function email_confirm_check() 
    {
        $email = $this->input->post('email');
        $cemail = $this->input->post('confirmemail');
        if($email != $cemail) 
        {
            $this->form_validation->set_message('email_confirm_check', 'Email Id and Confirm Email Id do not match');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    function password_confirm_check() 
    {
        $psword = $this->input->post('psword');
        $psword1 = $this->input->post('psword1');
        $alphanumeric = intval(preg_match('/^[a-z\d]+$/i', $psword) // has only chars & digits
                        && preg_match('/[a-z]/i', $psword)        // has at least one char
                        && preg_match('/\d/', $psword)) ;
        if($psword != $psword1) 
        {
            $this->form_validation->set_message('password_confirm_check', 'Password and Confirm Password do not match');
            return FALSE;
        }
        if($alphanumeric != 1) 
        {
            $this->form_validation->set_message('password_confirm_check', 'Password and Confirm Password should be the combination of Alphanumeric');
            return FALSE;
        }     
        else
        {
            return TRUE;
        }
    }

    function check_username($username) 
    {
        $subadmin_id = "";
        $subadmin_id = $this->input->post('subadmin_id');
        
        $username_check = $this->admin_subadmin_model->checkusername($username, $subadmin_id);
        
        if($username_check == 1) 
        {
            $this->form_validation->set_message('check_username', 'The username already exists');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    function delete($subadmin_id) 
    {
        $deleted = $this->admin_subadmin_model->delete_subadmin($subadmin_id); 
        $redirect_action = "admin_sub/";
        if($deleted)
        {
            $this->session->set_flashdata('success', "Sub-Admin Deleted Successfully");
            redirect($redirect_action);
        } 
        else
        {
            $this->session->set_flashdata('error', "Sub-Admin not deleted... Please try again");
            redirect($redirect_action);
        }
    }
    
    function view ()
    {
        $this->gen_contents["course"]		=	array();
        $this->gen_contents['page_title']	=	'Sub-Admin Details';

        $this->session->set_flashdata('search_firstname',$this->session->flashdata('search_firstname'));
        $this->session->set_flashdata('search_lastname',$this->session->flashdata('search_lastname'));
        $this->session->set_flashdata('search_email',$this->session->flashdata('search_email'));
        
        $this->_user_details($this->uri->segment(3));

        $this->_template('view_user_details',$this->gen_contents);
    }
                
    function _user_details ($userid)
    {
        $this->userid 			= 	$userid;
        $this->gen_contents["userdetails"]	=	$this->admin_subadmin_model->select_subadmin($this->userid);
        $this->gen_contents["state"]		=	$this->admin_user_model->select_state_name($this->gen_contents["userdetails"]->state);
          
    }
    
    function reset_password()
    {
        $this->gen_contents['page_title']   = 'Sub-Admin Reset Password';
        $this->gen_contents['subadmin_id']  = $this->uri->segment(3);
        $this->gen_contents['page_no']  = $this->uri->segment(4);
        
        $this->_init_reset_rules();
        if($this->input->post('resetted') == 1 && $this->form_validation->run() == TRUE) 
        {
            $psword = $this->input->post('r_password');
            $subadmin_id = $this->input->post('subadmin_id');
            $page_no = $this->input->post('page_no');
            
            $subadmin_details = $this->admin_subadmin_model->select_subadmin($subadmin_id);
                        
            //Admin acknowledge mail
            $toemail = $this->config->item('main_cc_to');
            $from = "";
            $subject = 'Subadmin '.$subadmin_details->username. ' password has been reset';
            $message_template = '<p>Hey,</p>
            <p></p>
            <p>Sub Admin <b>"'.$subadmin_details->username. '"</b> password has been reset to "'.$psword.'"</p>
            <p></p>
            <p></p>
            <p>Team AdhiSchools!</p>';
            $admin_mail = $this->Common_model->send_mail($toemail,$from,$subject,$message_template);
            
            if($admin_mail)
            {
                $psword_md5 = md5($psword);
                $this->Common_model->update("adhi_admin", array("password"=>$psword_md5), array("id"=> $subadmin_id));
                $this->session->set_flashdata('success', "Password has been reset Successfully");
            }
            else
            {
                $this->session->set_flashdata('error', "Password rest failed... Please try again!");
            }
            redirect("admin_sub/list_subadmins/".$page_no);
        }   
        else
        {
            $this->_template('reset_password',$this->gen_contents);
        }
    }
    
    function _init_reset_rules()
    {
        $this->form_validation->set_rules('r_password', 'PASSWORD', 'trim|required|min_length[6]|alpha_numeric|callback_password_reset_check');
    }
    
    function password_reset_check() 
    {
        $psword = $this->input->post('r_password');
        
        $alphanumeric = intval(preg_match('/^[a-z\d]+$/i', $psword) // has only chars & digits
                        && preg_match('/[a-z]/i', $psword)        // has at least one char
                        && preg_match('/\d/', $psword)) ;
        
        if($alphanumeric != 1) 
        {
            $this->form_validation->set_message('password_reset_check', 'Password should be the combination of Alphanumeric');
            return FALSE;
        }     
        else
        {
            return TRUE;
        }
    }
}